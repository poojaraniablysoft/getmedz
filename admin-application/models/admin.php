<?php

class Admin extends Model {
	CONST ADMIN_USER_TYPE=1;
    function __construct() {
        parent::__construct();
    }

    function login($username, $password) {
        /* @var $db Database */
        global $db;
		
		$srch = new SearchBase('tbl_admin');
		$srch->addCondition('admin_username', '=', $username);
		$password = encryptPassword($password);
		$srch->addCondition('admin_password', '=', $password);
		$srch->addCondition('admin_active', '=', 1);
		$rs = $srch->getResultSet();
		
		if (!$row = $db->fetch($rs)) {
			$this->error = 'Invalid username or password';
            return false;
		}
		
		if ($row['admin_username'] !== $username || $row['admin_password'] !== $password) {
			$this->error = 'Invalid username or password';
            return false;
		}
		
        $_SESSION['admin_logged'] = 1;
        $_SESSION['admin_username'] = $row['admin_username'];
        $_SESSION['admin_email'] = $row['admin_email'];
		$_SESSION['administrator_id'] = $row['admin_id'];
        return true;
    }

    function logout() {
		$username=$this->getLoggedUsername();
		  $this->updateCookie($username, true);
        session_destroy();
		session_start();
    }

    static function isLogged() {
        return ($_SESSION['admin_logged'] == 1);
    }

 

    function changePassword($current_password, $new_password, $admin_email = '') {        
        global $db;
		
		$srch = new SearchBase('tbl_admin');
		$srch->addCondition('admin_username', '=', $_SESSION['admin_username']);		
		$srch->addCondition('admin_password', '=', encryptPassword($current_password) );		
		$rs = $srch->getResultSet();
		
		if (!$row = $db->fetch($rs)) {
			$this->error = 'Incorrect current password';
            return false;
		}
		
		$data['admin_password'] = encryptPassword($new_password);
		if( !empty($admin_email) AND $admin_email != '' ) $data['admin_email'] = $admin_email;
		
		if (!$db->update_from_array('tbl_admin', $data , array('smt'=>'admin_username = ?', 'vals'=>array( $_SESSION['admin_username'] )))){
            $this->error = $db->getError();
            return false;
        }else{
			if( !empty($admin_email) AND $admin_email != '' ) $_SESSION['admin_email'] = $admin_email; /* Update Email Id in session */
		}
		
        return true; 
    }
	
    static function isSubuserLogged() {
        return (self::isLogged() && self::getLoggedinUserId()!==0);
    }
	
	static function isSuperAdminLogged() {
        return (self::isLogged() && self::getLoggedinUserId()==1);
    }
    
    static function getLoggedUsername() {
        return $_SESSION['admin_username'];
    }
    
    static function getLoggedUserEmail() {
        return $_SESSION['admin_email'];
    }

    static function getLoggedinUserId() {
        if (self::isLogged()) return $_SESSION['administrator_id'];
        else return false;
    }
	
	static function getLoggedId() {
        if (self::isLogged()) return $_SESSION['administrator_id'];
        else return false;
    }

    function addUpdate($data) {
        global $db;

        $admin_id = intval($data['admin_id']);
        if (!($admin_id > 0))
            $admin_id = 0;
        unset($data['admin_id']);

        $arr_fields = array();

        $arr_fields['admin_username'] = $data['admin_username'];
        $arr_fields['admin_email'] = $data['admin_email'];

        if ($data['admin_password'] != '')
            $arr_fields['admin_password'] = encryptPassword($data['admin_password']);

        if ($admin_id > 0) {
            $success = $db->update_from_array('tbl_admin', $arr_fields, array('smt' => 'admin_id = ?', 'vals' => array($admin_id)));
        } else {
            $success = $db->insert_from_array('tbl_admin', $arr_fields);
            $admin_id = $db->insert_id();
        }

        if ($success) {
            $db->deleteRecords('tbl_admin_permissions', array('smt' => 'ap_admin_id = ?', 'vals' => array($admin_id)));

            foreach ($data['permissions'] as $key => $val) {
                $db->insert_from_array('tbl_admin_permissions', array('ap_admin_id' => $admin_id, 'ap_module' => $key, 'ap_permission' => $val));
            }
        } else {
            $this->error = $db->getError();
            return false;
        }

        return true;
    }

    function getData($id) {

        if (!is_numeric($id)) {
            $this->error = 'Invalid Request';
            return false;
        }

        $id = intval($id);

        $record = new TableRecord('tbl_admin');

        if (!$record->loadFromDb(array('smt' => 'admin_id = ?', 'vals' => array($id)))) {
            $this->error = $record->getError();
            return false;
        }

        $data = $record->getFlds();
        $data['permissions'] = $this->getAdminPermissions($id);

        unset($data['admin_password']);

        return $data;
    }

    function getAdminPermissions($id) {
        global $db;

        if (!is_numeric($id)) {
            $this->error = 'Invalid Request';
            return false;
        }

        $id = intval($id);

        $sql = $db->query("SELECT ap_module, ap_permission FROM tbl_admin_permissions WHERE ap_admin_id = $id");
        $result_data = $db->fetch_all($sql);

        $permissions = array();

        foreach ($result_data as $arr) {
            $permissions[$arr['ap_module']] = $arr['ap_permission'];
        }

        return $permissions;
    }
	function validateCookie($data_arr, &$user_data) {
        global $db;
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (!is_array($data_arr)) {
            return false;
        }

        $srch = new SearchBase('tbl_remember_me');
        $srch->addCondition('remember_token', '=', $data_arr[0]);
        $srch->addCondition('remember_user_type', '=', ADMIN::ADMIN_USER_TYPE);
        $srch->addCondition('remember_user_id', '=', $data_arr[2]);
        $srch->addCondition('remember_agent', '=', $user_agent);
        $srch->addDirectCondition('remember_expiry >= NOW()'); /* Not expired  */
        $rs = $srch->getResultSet();
	
        if (!$row = $db->fetch($rs)) {
			
            self::updateCookie($data_arr[2], true); /* Delete cookie something fishy */
            return false;
        }

        $srch = new SearchBase('tbl_admin');
        $srch->addCondition('admin_id', '=', $data_arr[2]);
       
        $srch->addCondition('admin_active', '=', 1);
        $rs2 = $srch->getResultSet();

        if (!$user_row = $db->fetch($rs2)) {
            self::updateCookie($data_arr[2], true); /* Delete cookie something fishy, email not exists */
            return false;
        } else {
            $user_data = $user_row;
            self::updateCookie($data_arr[2], false); /* reset cookie */
            return true;
        }

        return false;
    }
    
	function updateCookie($admin_id, $destroy = false) {
        global $db;
        $expiry = time() + 60 * 60 * 24 * 15; /* 15 Days */
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        /* Delete previous db cookies for email Id */
        $db->deleteRecords('tbl_remember_me', array('smt' => 'remember_user_id = ?', 'vals' => array($admin_id)), '', '', 1);

        /* Destroy cookie */
        if ($destroy) {
            setcookie('askdoctor_remember', '', time() - $expiry);
            return;
        }

        $token = md5(uniqid(rand(), true));
        $cookie_data = $token . '|' .ADMIN::ADMIN_USER_TYPE. '|' . $admin_id;

        setcookie('askdoctor_remember', $cookie_data, $expiry, '/', '', '', true);
        $db->insert_from_array('tbl_remember_me', array('remember_token' => $token, 'remember_user_id' => $admin_id, 'remember_agent' => $user_agent, 'remember_expiry' => 'mysql_func_DATE_ADD(NOW(), INTERVAL 15 DAY)', 'remember_user_type' => ADMIN::ADMIN_USER_TYPE), true);
		
    }
	   function validateLogin($emailid, $password, $passwordAlreadyEncripted = false) {
        global $db;

        if (!$passwordAlreadyEncripted)
            $password = encryptPassword($password);

        $srch = new SearchBase('tbl_admin');
        $srch->addCondition('admin_username', '=', $emailid);
        $rs = $srch->getResultSet();

        if (!$row = $db->fetch($rs)) {
            Message::addErrorMessage('Invalid Email-Id or Password1');
            return false;
        }

        if (strtolower($row['admin_username']) != strtolower($emailid) || $row['admin_password'] != $password) {
            Message::addErrorMessage('Invalid Email-Id or Password2');
            return false;
        }
		$_SESSION['admin_logged'] = 1;
        $_SESSION['admin_username'] = $row['admin_username'];
        $_SESSION['admin_email'] = $row['admin_email'];
		$_SESSION['administrator_id'] = $row['admin_id'];
		return true;
    }
	static  function getAdminAccess($admin_id, $module_id) {
		if(intval($admin_id) < 1) return false;
		if (self::isSuperAdminLogged())
			return true;
		$db = Syspage::getdb();	
		$srch = new SearchBase('tbl_admin_permissions');
		$srch->addCondition('ap_admin_id', '=', (int)($admin_id));
		$srch->addCondition('ap_module', '=', (int)$module_id);
		$srch->doNotLimitRecords();
		$rs = $srch->getResultSet();
		if($srch->recordCount() < 1){
			return false;
		}
		$row = $db->fetch($rs);
		return $row['ap_permission']==1?true:false;
	}
}