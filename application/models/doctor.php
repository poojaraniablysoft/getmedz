<?php

class Doctor extends Model {

    public $doctor_id = 0;

    const ACTIVE_DOCTOR = 1;
    const NOT_ACTIVE_DOCTOR = 1;
    const NOT_DELETED_DOCTOR = 0;
    const DELETED_DOCTOR = 1;

    public static function searchDoctor() {

        $srch = new SearchBaseNew('tbl_doctors');
        $srch->joinTable('tbl_medical_categories', 'INNER JOIN', 'category_id=doctor_med_category');
        $srch->joinTable('tbl_degrees', 'INNER JOIN', 'degree_id=doctor_med_degree');
        $srch->joinTable('tbl_states', 'INNER JOIN', 'state_id=doctor_state_id');
        return $srch;
    }

    public static function getActiveDoctores() {

        $srch = self::searchDoctor();
        $srch->addCondition('doctor_deleted', '=', self::NOT_DELETED_DOCTOR);
        $srch->addCondition('doctor_active', '=', self::ACTIVE_DOCTOR);
        return $srch;
    }

    public static function onlineDoctors() {
        $srch = self::getActiveDoctores();
        $srch->addDirectCondition('DATE_SUB(NOW(),INTERVAL 10 MINUTE) <= doctor_last_activity');
        $srch->addCondition('doctor_is_online', '=', 1);
        // $srch->addGroupBy('doctor_id');

        return $srch;
    }

    public static function getDoctores() {
        $srch = self::searchDoctor();
        $srch->addCondition('doctor_deleted', '=', self::NOT_DELETED_DOCTOR);
        return $srch;
    }

    public function updateDoc($data) {

        $doctor_id = intval($data['doctor_id']);
        unset($data['doctor_id']);

        $record = new TableRecord('tbl_doctors');
        $record->assignValues($data, true, '', '', true);
        $success = $record->update(array('smt' => 'doctor_id = ?', 'vals' => array($doctor_id)));
        return $success;
    }

    public function setupDoctor($data) {



        $doctor_id = intval($data['doctor_id']);
        unset($data['doctor_id']);
        if (!empty($data['doctor_password'])) {
            $password = $data['doctor_password'];
            $data['doctor_password'] = encryptPassword($data['doctor_password']);
        }
        $record = new TableRecord('tbl_doctors');
        $record->assignValues($data, true, '', '', true);
        if ($doctor_id > 0) {
            $success = $record->update(array('smt' => 'doctor_id = ?', 'vals' => array($doctor_id)));
            if ($data['doctor_password']) {
                $to = $data['doctor_email'];
                $email = new Emails();
                $emailData = array('user_email' => $to, 'user_name' => $data['doctor_first_name'], 'user_password' => $password);
                $email->passwordUpdatedEmail($emailData);
            }
        } else {
            if ($data['doctor_password'] == '') {
                $password = getRandomPassword(10);
                $data['doctor_password'] = encryptPassword($password);
            }
            $record->assignValues($data);
            $success = $record->addNew();
        }

        if ($success) {
            $this->doctor_id = ($doctor_id > 0) ? $doctor_id : $record->getId();
            if ($doctor_id > 0) {
                // Message::addMessage('Doctor updated successfully.');
            } else {

                $to = $data['doctor_email'];
                $email = new Emails();
                $emailData = array('user_email' => $to, 'user_name' => $data['doctor_first_name'], 'user_password' => $password);
                $email->accountCreatedEmail($emailData);

                Message::addMessage('Doctor added successfully.');
            }
        } else {
            $this->error = $record->getError();
        }
        return $success;
    }

    function acceptQuestion($data) {
        global $db;

        $record = new TableRecord('tbl_order_questions');
        $record->assignValues($data);
        $success = $record->update(array('smt' => 'orquestion_id = ?', 'vals' => array($data['orquestion_id'])));
        return $success;
    }
	function esclateQuestion($data) {
        global $db;

        $record = new TableRecord('tbl_order_questions');
        $record->assignValues($data);
        $success = $record->update(array('smt' => 'orquestion_id = ?', 'vals' => array($data['orquestion_id'])));
        return $success;
    }

    function ChangeOrder($data) {
        global $db;

        $record = new TableRecord('tbl_order_questions');
        $record->assignValues($data);
        if ($data['orquestion_id'])
            $success = $record->update(array('smt' => 'orquestion_id = ?', 'vals' => array($data['orquestion_id'])));

        if ($success) {
            Message::addMessage("Thankyou for accepting the Question");
        } else {
            Message::addMessage($record->getError());
        }
        return $success;
    }
	
	static function canAcceptQuestion($questionData= array()){
	
		if($questionData['qassign_doctor_id']!=$questionData['orquestion_doctor_id']){
			return false;
		}elseif($questionData['orquestion_status']==Question::QUESTION_ASSIGNED){
			return true;
		}else{
			return false;
		}
		
	}
	static function canReplyQuestion($questionData= array()){
	
		if($questionData['qassign_doctor_id']!=$questionData['orquestion_doctor_id']){
			return false;
		}elseif($questionData['orquestion_status']==Question::QUESTION_ACCEPTED || $questionData['orquestion_status']==Question::QUESTION_REPLIED_BY_PATIENT || $questionData['orquestion_status']==Question::QUESTION_REPLIED_BY_DOCTOR){
			return true;
		}else{
			return false;
		}
		
	}
	static function canViewQuestion($questionData= array()){
	
		if($questionData['qassign_doctor_id']!=$questionData['orquestion_doctor_id']){
			return false;
		}elseif($questionData['orquestion_status']==Question::QUESTION_REJECTED || $questionData['orquestion_status']==Question::QUESTION_CLOSED ){
			return true;
		}else{
			return false;
		}
		
	}

}
