<?php

class Users extends Model {

    protected $db;

    public function __construct() {
        parent::__construct();
        $this->db = Syspage::getPostedVar();
    }

    public function setupUser($data) {

  /*if ($rows >= 1) {

            $this->error = "Unable to Process data";
            return false;
        }
*/
        $user_id = intval($data['user_id']);
        unset($data['user_id']);
        $record = new TableRecord('tbl_users');
        $record->assignValues($data);
        if ($user_id > 0)
            $success = $record->update(array('smt' => 'user_id = ?', 'vals' => array($user_id)));
        else {
			
			$srch = $this->searchUser();
			$srch->addCondition('user_email', '=', $data['user_email']);
			
			$srch->getResultSet();
			$rows = $srch->recordCount();			
			if ($rows >= 1) {

				$this->error = "Unable to Process user data";
				return false;
			}
            $record->assignValues($data);
            $record->setFldValue('user_added_on', 'mysql_func_NOW()', true);

            $success = $record->addNew();
        }

        if ($success) {
            return $this->user_id = ($user_id > 0) ? $user_id : $record->getId();
        } else {

            $this->error = $record->getError();
        }
        return $success;
    }

    static function sendUserCreationEmail($email, $params) {

        $to = $email;
        $subject = "Congrats! Your Account is succesfully Created. ";
        $message = "<table>";
        $message.="<tr><td>Username<td><td>{$email}<td></tr>";
        $message.="<tr><td>Password<td><td>{PASSWORD}<td></tr>";
        $message.="</table>";

        $message = str_replace(array_keys($params), $params, $message);
        return sendMail($to, $subject, $message);
    }

    static function searchUser() {
        $srch = new SearchBaseNew('tbl_users');
        return $srch;
    }

}
