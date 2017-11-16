<?php

class Members extends Model {

    CONST CUSTOMER_USER_TYPE = 2;
    CONST DOCTOR_USER_TYPE = 3;

    private $attributes;

    function __construct() {
        parent::__construct();
    }

    function getCustomerData($id) {
        global $db;

        if (!is_numeric($id)) {
            Message::addError('Invalid Id');
            return false;
        }

        $record = new TableRecord('tbl_users');
        if (!$record->loadFromDb(array('smt' => 'user_id = ?', 'vals' => array($id)), true)) {
            $this->error = $record->getError();
            return false;
        }
        $arr = $record->getFlds();
        $this->attributes = $arr;
        return $arr;
    }

    function getDoctorData($id) {
        global $db;

        if (!is_numeric($id)) {
            Message::addError('Invalid Id');
            return false;
        }

        $record = new TableRecord('tbl_doctors');
        if (!$record->loadFromDb(array('smt' => 'user_id = ?', 'vals' => array($id)), true)) {
            Message::addError($record->getError());
            return false;
        }
        $arr = $record->getFlds();
        $this->attributes = $arr;
        return $arr;
    }

    function validateCustomerLogin($emailid, $password, $passwordAlreadyEncripted = false) {
        global $db;

        if (!$passwordAlreadyEncripted)
            $password = encryptPassword($password);

        $srch = new SearchBase('tbl_users');
        $srch->addCondition('user_email', '=', $emailid);
        $rs = $srch->getResultSet();

        if (!$row = $db->fetch($rs)) {
            Message::addErrorMessage('Invalid Email-Id or Password');
            return false;
        }

        if (strtolower($row['user_email']) != strtolower($emailid) || $row['user_password'] != $password) {
            Message::addErrorMessage('Invalid Email-Id or Password');
            return false;
        }


        if ($row['user_active'] != 1) {
            Message::addErrorMessage('Your account is not active. Please contact administrator.');
            return false;
        }

        if ($row['user_deleted'] != 0) {
            Message::addErrorMessage('Your account has been deleted. Please contact administrator.');
            return false;
        }

        $this->user_id = $row['user_id'];
        $this->attributes = $row;
        $attrs_session = array(
            'user_id',
            'user_email',
            'user_first_name',
            'user_last_name'
        );

        $_SESSION['logged_user'] = array();
        $_SESSION['logged_user']['user_type'] = Members::CUSTOMER_USER_TYPE;
        foreach ($attrs_session as $key) {
            $_SESSION['logged_user'][$key] = $this->getCustomerAttribute($key);
        }


        return true;
    }

    function getCustomerAttribute($attr) {
        if (!($this->user_id > 0)) {
            throw new InvalidArgumentException('Invalid Request');
            return;
        }
        return $this->attributes[$attr];
    }

    function getDoctorAttribute($attr) {
        if (!($this->doctor_id > 0)) {
            throw new InvalidArgumentException('Invalid Request');
            return;
        }
        return $this->attributes[$attr];
    }

    function validateDoctorLogin($emailid, $password, $passwordAlreadyEncripted = false) {
        global $db;

        if (!$passwordAlreadyEncripted)
            $password = encryptPassword($password);

        $srch = new SearchBase('tbl_doctors');
        $srch->addCondition('doctor_email', '=', $emailid);
        $rs = $srch->getResultSet();

        if (!$row = $db->fetch($rs)) {

            Message::addErrorMessage('Invalid Email-Id or Password');
            return false;
        }

        if (strtolower($row['doctor_email']) != strtolower($emailid) || $row['doctor_password'] != $password) {
            Message::addErrorMessage('Invalid Email-Id or Password');

            return false;
        }


        if ($row['doctor_active'] != 1) {

            Message::addErrorMessage('Your account is not active. Please contact administrator.');

            return false;
        }

        if ($row['doctor_deleted'] != 0) {
            Message::addErrorMessage('Your account is deleted. Please contact administrator.');
            return false;
        }

        $this->doctor_id = $row['doctor_id'];
        $this->attributes = $row;
        $attrs_session = array(
            'doctor_id',
            'doctor_email',
            'doctor_first_name',
            'doctor_last_name'
        );

        $_SESSION['logged_user'] = array();
        $_SESSION['logged_user']['user_type'] = Members::DOCTOR_USER_TYPE;
        foreach ($attrs_session as $key) {
            $_SESSION['logged_user'][$key] = $this->getDoctorAttribute($key);
        }
      
       $Doctor=new Doctor();
       $Doctor->updateDoc(array('doctor_id'=>$this->doctor_id,'doctor_is_online'=>1));
       
        return true;
    }

    static function getLoggedUserAttribute($attr) {
        return $_SESSION['logged_user'][$attr];
    }

    static function getLoggedUserID() {
        if ($_SESSION['logged_user']['user_type'] == Members::CUSTOMER_USER_TYPE) {
            return $_SESSION['logged_user']['user_id'];
        } elseif ($_SESSION['logged_user']['user_type'] == Members::DOCTOR_USER_TYPE) {
            return $_SESSION['logged_user']['doctor_id'];
        }
    }

    static function isUserLogged() {

        $members = new Members();

        if ($_SESSION['logged_user']['user_type'] == Members::CUSTOMER_USER_TYPE) {
            if (!$_SESSION['logged_user']['user_id']) {
                if (!isset($_COOKIE['askdoctor_remember']))
                    return false;

                $cookie_arr = explode('|', $_COOKIE['askdoctor_remember']);

                if ($members->validateCookie($cookie_arr, $user_data)) {
                    if (!$members->validateCustomerLogin($user_data['user_email'], $user_data['user_password'], true))
                        $members->updateCookie($_SESSION['logged_user']['user_id'], true, Members::CUSTOMER_USER_TYPE);
                }
            }

            if ($_SESSION['logged_user']['user_id']) {
                if (!$members->checkLastCustomerInactiveCheck($_SESSION['logged_user']['user_id']))
                    return false;
                return ($_SESSION['logged_user']['user_id'] > 0);
            } else
                return false;
        }
        elseif ($_SESSION['logged_user']['user_type'] == Members::DOCTOR_USER_TYPE) {

            if (!$_SESSION['logged_user']['doctor_id']) {
                if (!isset($_COOKIE['askdoctor_remember']))
                    return false;

                $cookie_arr = explode('|', $_COOKIE['askdoctor_remember']);

                if ($members->validateCookie($cookie_arr, $user_data)) {
                    if (!$members->validateDoctorLogin($user_data['doctor_email'], $user_data['doctor_password'], true))
                        $members->updateCookie($_SESSION['logged_user']['doctor_id'], true, Members::DOCTOR_USER_TYPE);
                }
            }

            if ($_SESSION['logged_user']['doctor_id']) {
                if (!$members->checkLastDoctorInactiveCheck($_SESSION['logged_user']['doctor_id']))
                    return false;
                return ($_SESSION['logged_user']['doctor_id'] > 0);
            }
            elseif ($_SESSION['logged_user']['user_id']) {
                if (!$members->checkLastCustomerInactiveCheck($_SESSION['logged_user']['user_id']))
                    return false;
                return ($_SESSION['logged_user']['user_id'] > 0);
            } else
                return false;
        }
    }

    static function isDoctorLogged() {
        $members = new Members();
        if ($_SESSION['logged_user']['doctor_id']) {
            if (!$members->checkLastDoctorInactiveCheck($_SESSION['logged_user']['doctor_id']))
                return false;
            return ($_SESSION['logged_user']['doctor_id'] > 0);
        } return false;
    }

    static function isCustomerLogged() {
        $members = new Members();
        if ($_SESSION['logged_user']['user_id']) {
            if (!$members->checkLastCustomerInactiveCheck($_SESSION['logged_user']['user_id']))
                return false;
            return ($_SESSION['logged_user']['user_id'] > 0);
        } return false;
    }

    function checkLastCustomerInactiveCheck($user_id) {

        global $db;
        $srch = new SearchBase('tbl_users');
        $srch->addCondition('user_id', '=', $user_id);
        $rs = $srch->getResultSet();

        if (!$row = $db->fetch($rs)) {
            return false;
        }

        if ($row['user_active'] != 1) {
            return false;
        }

        $attrs_session = array(
            'user_active',
        );
        $_SESSION['logged_user']['user_type'] = Members::CUSTOMER_USER_TYPE;
        foreach ($attrs_session as $key) {
            $_SESSION['logged_user'][$key] = $row[$key];
        }
        return true;
    }

    function checkLastDoctorInactiveCheck($doctor_id) {

        global $db;
        $srch = new SearchBase('tbl_doctors');
        $srch->addCondition('doctor_id', '=', $doctor_id);
        $rs = $srch->getResultSet();

        if (!$row = $db->fetch($rs)) {
            return false;
        }

        if ($row['doctor_active'] != 1) {
            return false;
        }

        $attrs_session = array(
            'doctor_active',
        );
        $_SESSION['logged_user']['user_type'] = Members::DOCTOR_USER_TYPE;
        foreach ($attrs_session as $key) {
            $_SESSION['logged_user'][$key] = $row[$key];
        }
        return true;
    }

    function validateCookie($data_arr, &$user_data) {
        global $db;
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (!is_array($data_arr)) {
            return false;
        }
        $srch = new SearchBase('tbl_remember_me');
        $srch->addCondition('remember_token', '=', $data_arr[0]);
        $srch->addCondition('remember_user_type', '=', $data_arr[1]);
        $srch->addCondition('remember_user_id', '=', $data_arr[2]);
        $srch->addCondition('remember_agent', '=', $user_agent);
        $srch->addDirectCondition('remember_expiry >= NOW()'); /* Not expired  */
        $rs = $srch->getResultSet();

        if (!$row = $db->fetch($rs)) {
            if ($data_arr[1] == Members::CUSTOMER_USER_TYPE) {
                self::updateCookie($data_arr[2], true, Members::CUSTOMER_USER_TYPE); /* Delete cookie something fishy */
            }if ($data_arr[1] == Members::DOCTOR_USER_TYPE) {
                self::updateCookie($data_arr[2], true, Members::DOCTOR_USER_TYPE); /* Delete cookie something fishy */
            }return false;
        }


        if ($data_arr[1] == Members::CUSTOMER_USER_TYPE) {
            $srch = new SearchBase('tbl_users');
            $srch->addCondition('user_id', '=', $data_arr[2]);
            $srch->addCondition('user_deleted', '=', 0);
            $srch->addCondition('user_active', '=', 1);
            $rs2 = $srch->getResultSet();
        } elseif ($data_arr[1] == Members::DOCTOR_USER_TYPE) {
            $srch = new SearchBase('tbl_doctors');
            $srch->addCondition('doctor_id', '=', $data_arr[2]);
            $srch->addCondition('doctor_deleted', '=', 0);
            $srch->addCondition('doctor_active', '=', 1);
            $rs2 = $srch->getResultSet();
        }

        if ($data_arr[1] == Members::CUSTOMER_USER_TYPE || $data_arr[1] == Members::DOCTOR_USER_TYPE) {
            if (!$user_row = $db->fetch($rs2)) {
                self::updateCookie($data_arr[2], true, $data_arr[1]); /* Delete cookie something fishy, email not exists */
                return false;
            } else {
                $user_data = $user_row;
                self::updateCookie($data_arr[2], false, $data_arr[1]); /* reset cookie */
                return true;
            }
        } else {

            $user_data = $user_row;
            self::updateCookie($data_arr[2], false, $data_arr[1]); /* reset cookie */
            return true;
        }

        return false;
    }

    function updateCookie($user_id, $destroy = false, $type = 3) {


        global $db;
        $expiry = time() + 60 * 60 * 24 * 15; /* 15 Days */
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        /* Delete previous db cookies for email Id */
        $db->deleteRecords('tbl_remember_me', array('smt' => 'remember_user_id = ? and remember_user_type = ?', 'vals' => array($user_id, $type)), '', '', 1);

        /* Destroy cookie */
        if ($destroy) {
            setcookie('askdoctor_remember', '', time() - $expiry);
            return;
        }

        $token = md5(uniqid(rand(), true));
        $cookie_data = $token . '|' . $type . '|' . $user_id;

        setcookie('askdoctor_remember', $cookie_data, $expiry, '/', '', '', true);
        $db->insert_from_array('tbl_remember_me', array('remember_token' => $token, 'remember_user_id' => $user_id, 'remember_agent' => $user_agent, 'remember_expiry' => 'mysql_func_DATE_ADD(NOW(), INTERVAL 15 DAY)', 'remember_user_type' => $type), true);
    }

    static function validatePasswordResetToken($token) {
        $db = &Syspage::getdb();
        $token_arr = explode('.', $token);
        $user_id = intval($token_arr[0]);
        $token = $token_arr[1];
        $type = $token_arr[2];
        if ($user_id < 1)
            return false;

        $db->query("delete from tbl_user_password_reset_requests where uprr_expiry < '" . date('Y-m-d H:i:s') . "' and uprr_user_type='" . $type . "'");
        $rs = $db->query("select * from tbl_user_password_reset_requests where uprr_token = " . $db->quoteVariable($token) . " and uprr_user_id='" . intval($user_id) . "' and uprr_user_type='" . $type . "' ");
        $row = $db->fetch($rs);

        if (!$row) {
            return false;
        }
        return true;
    }

}

?>