<?php

class Emails extends Model {

    public $questionList = array();
    public $review_list = array();
    public $replies = array();
    private $template_code = 0;
    private $subject = "";
    private $message = "";
    private $replacementKeys = array();
    private $replacementData = array();

    public function getTemplateData() {

        $email = new Emailtemplates();
        $templateData = $email->getTemplateById($this->template_code)->fetch();

        if (intval($templateData['tpl_id']) < 1) {
            return false;
        }


        $this->subject = $templateData['tpl_subject'];
        $this->message = $templateData['tpl_body'];
        return true;
    }

    /*
     * 
     */

    public function accountCreatedEmail($data) {

        $this->template_code = 'new_registration';
     
       $this->replacementData[] = $data;

        if (!$this->getTemplateData()) {
            return false;
        }

        $this->replacementKeys = array(
            'USER' => array('user_name' => '{user_name}', 'email' => 'user_email','user_password'=>'{user_password}','user_email'=>'{user_email}'),
        );
        
        $this->dispatch_email();
    }
	
	 public function passwordUpdatedEmail($data) {

        $this->template_code = 'doctor_password_updates';
     
       $this->replacementData[] = $data;

        if (!$this->getTemplateData()) {
            return false;
        }

        $this->replacementKeys = array(
            'USER' => array('user_name' => '{user_name}', 'email' => 'user_email','user_password'=>'{user_password}','user_email'=>'{user_email}'),
        );
        
        $this->dispatch_email();
    }

    /*
     * Event -:When a question is posted
     * Recipients-:Admin
     * Condition->IF question verification is ON
     */

    public function questionPostEmail() {

        if (!CONF_QUESTION_APPROVAL) {
            return true;
        }

        $this->template_code = 'question_posted';
        $this->replacementData = $this->getQuestionsData(array('orquestion_question'))->fetch_all();

        if (!$this->getTemplateData()) {
            return false;
        }

        $this->sendToAdmin();

        $this->replacementKeys = array(
            'ADMIN' => array('admin_name' => '{user_name}', 'email' => 'admin_email', 'orquestion_question' => '{question_txt}'),
        );


        $this->dispatch_email();
    }

    /*
     * Event-:When Doc Accept to question 
     * Recipients->User
     */

	public function questionAcceptByDocEmail() {
		$this->template_code = 'question_accepted';
		$this->replacementData = $this->getQuestionsData(array('user_email', 'CONCAT_WS(" ",user_first_name,user_last_name) as user_name', 'orquestion_question', 'CONCAT_WS(" ",doctor_first_name,doctor_last_name) as doc_name'))->fetch_all();

		if (!$this->getTemplateData()) {
			return false;
		}

		$this->replacementKeys = array(
			'USER' => array('user_name' => '{user_name}', 'email' => 'user_email', 'orquestion_question' => '{question_txt}', 'doc_name' => '{doc_name}'),
		);
		$this->dispatch_email();
	}
	public function questionEsclatedToAdmin() {
        $this->template_code = 'question_esclated';
        $this->replacementData = $this->getQuestionsData(array('doctor_email', 'user_email', 'CONCAT_WS(" ",doctor_first_name,doctor_last_name) as doc_name', 'CONCAT_WS(" ",user_first_name,user_last_name) as user_name', 'orquestion_question'))->fetch_all();

        if (!$this->getTemplateData()) {
            die("Template not found");
        }
        $this->sendToAdmin();

        $this->replacementKeys = array(           
            'ADMIN' => array('admin_name' => '{user_name}', 'email' => 'admin_email', 'orquestion_question' => '{question_txt}','doc_name'=>'{doctor_name}'),
        );
		$this->dispatch_email();
    }

    /*
     * Event-:When a Doctor replied to a question.
     * Recipients-:User
     */

    public function doctorReplyEmail() {

        $this->template_code = 'question_reply';
        $this->replacementData = $this->getQuestionsReplyData(array('user_email', 'CONCAT_WS(" ",user_first_name,user_last_name) as user_name', 'orquestion_question', 'reply_text'))->fetch_all();

        if (!$this->getTemplateData()) {
            return false;
        }

        $this->replacementKeys = array(
            'USER' => array('user_name' => '{user_name}', 'email' => 'user_email', 'orquestion_question' => '{question_txt}', 'reply_text' => '{reply_text}', 'replied_by' => '{replied_by}'),
        );
        foreach ($this->replacementData as $key => $value) {
            $this->replacementData[$key]['replied_by'] = "Doctor";
        }

        $this->dispatch_email();
    }

    /*
     * Event-:When a patient replied to a question.
     * Recipients-:Doctor
     */

    public function patientReplyEmail() {
        $this->template_code = 'question_reply';
        $this->replacementData = $this->getQuestionsReplyData(array('doctor_email', 'CONCAT_WS(" ",doctor_first_name,doctor_last_name) as doc_name', 'orquestion_question', 'reply_text'))->fetch_all();

        if (!$this->getTemplateData()) {
            return false;
        }


        $this->replacementKeys = array(
            'DOCTOR' => array('doc_name' => '{user_name}', 'email' => 'doctor_email', 'orquestion_question' => '{question_txt}', 'reply_text' => '{reply_text}', 'replied_by' => '{replied_by}'),
        );

        foreach ($this->replacementData as $key => $value) {
            $this->replacementData[$key]['replied_by'] = "Patient";
        }


        $this->dispatch_email();
    }

    /*
     * Event-:When a question is closes
     * Recipients-:doctor,admin
     */

    public function questionCloseEmail() {
        $this->template_code = 'question_close';
        $this->replacementData = $this->getQuestionsData(array('doctor_email', 'user_email', 'CONCAT_WS(" ",doctor_first_name,doctor_last_name) as doc_name', 'CONCAT_WS(" ",user_first_name,user_last_name) as user_name', 'orquestion_question'))->fetch_all();

        if (!$this->getTemplateData()) {
            return false;
        }
        $this->sendToAdmin();

        $this->replacementKeys = array(
            'DOCTOR' => array('doc_name' => '{user_name}', 'email' => 'doctor_email', 'orquestion_question' => '{question_txt}'),
            'ADMIN' => array('admin_name' => '{user_name}', 'email' => 'admin_email', 'orquestion_question' => '{question_txt}'),
        );
        $this->dispatch_email();
    }

    /*
     * Event-:When a question auto closed
     * Recipients-:doctor,admin,user
     */

    public function questionAutoCloseEmail() {

        $this->template_code = 'question_close';
        $this->replacementData = $this->getQuestionsData(array('doctor_email', 'user_email', 'CONCAT_WS(" ",doctor_first_name,doctor_last_name) as doc_name', 'CONCAT_WS(" ",user_first_name,user_last_name) as user_name', 'orquestion_question'))->fetch_all();

        if (!$this->getTemplateData()) {
            return false;
        }

        $this->sendToAdmin();
        $this->replacementKeys = array(
            'USER' => array('user_name' => '{user_name}', 'email' => 'user_email', 'orquestion_question' => '{question_txt}'),
            'DOCTOR' => array('doc_name' => '{user_name}', 'email' => 'doctor_email', 'orquestion_question' => '{question_txt}'),
            'ADMIN' => array('admin_name' => '{user_name}', 'email' => 'admin_email', 'orquestion_question' => '{question_txt}'),
        );




        $this->dispatch_email();
    }

    /*
     * Event-:When a Doctor is rated
     * Recipients-:doctor,admin,user
     */

    public function doctorRatedEmail() {
        $this->template_code = 'doctor_review';
        $srch = Review::searchReviews();
        $srch->addCondition('review_id', 'IN', (array) $this->review_list);
        $srch->addFld(
                array('doctor_email', 'user_email', 'CONCAT_WS(" ",doctor_first_name,doctor_last_name) as doc_name', 'CONCAT_WS(" ",user_first_name,user_last_name) as user_name')
        );


        $this->replacementData = $srch->fetch_all();
        if (!$this->getTemplateData()) {
            return false;
        }

        $this->sendToAdmin();

        $this->replacementKeys = array(
            'DOCTOR' => array('doc_name' => '{user_name}', 'email' => 'doctor_email', 'user_name' => '{review_by}'),
            'ADMIN' => array('admin_name' => '{user_name}', 'email' => 'admin_email', 'user_name' => '{review_by}'),
        );

        $this->dispatch_email();
    }

    public function sendToAdmin() {
        foreach ($this->replacementData as $key => $value) {

            $this->replacementData[$key]['admin_name'] = "Admin";
            $this->replacementData[$key]['admin_email'] = CONF_ADMIN_EMAIL_ID;
        }
    }

    public function getQuestionsData($fields = array()) {

        $quest = new Question();
        $questions = $quest->searchQuestions();
        $questions->addCondition('orquestion_id', 'IN', (array) $this->questionList);
	
        if (count($fields) > 0) {

            $questions->addFld($fields);
        }

        return $questions;
    }

    public function getQuestionsReplyData($fields = array()) {

        $quest = new Question();
        $questions = $quest->getReplies();
        $questions->addCondition('reply_id', 'IN', (array) $this->replies);

        if (count($fields) > 0) {

            $questions->addFld($fields);
        }

        return $questions;
    }

    public function dispatch_email() {
        $emailData = array();
        foreach ($this->replacementData as $replacedData) {
            foreach ($this->replacementKeys as $user_type) {
              $email = $replacedData[$user_type['email']];
                unset($user_type['email']);

                foreach ($user_type as $key => $value) {
                    $emailData[$value] = $replacedData[$key];
                }

              $subject = str_replace(array_keys($emailData), array_values($emailData), $this->subject);
               $message = str_replace(array_keys($emailData), array_values($emailData), $this->message);



                sendMail($email, $subject, $message);
            }
        }
    }

}
