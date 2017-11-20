<?php

class DoctorController extends FrontController {

    public function before_filter() {

        parent::before_filter();
       
        if (!Members::isDoctorLogged()) {

            redirectUser(generateUrl('members', 'login'));
        }



        $this->Doctor = new Doctor();
        $this->getEntityCount();
    }

    private function getEntityCount() {
        $user_id = Members::getLoggedUserID();
        $qest = new Question();
        $srch = $qest->searchActiveQuestions();
        $srch->joinTable('tbl_question_replies', 'LEFT JOIN', 'r.reply_orquestion_id=oq.orquestion_id', 'r');


        $srch->addMultipleFields(array(
            "COUNT(DISTINCT CASE WHEN orquestion_doctor_id=$user_id AND orquestion_status=" . Members::CUSTOMER_USER_TYPE . " AND reply_by=" . Members::DOCTOR_USER_TYPE . " THEN orquestion_id ELSE NULL END) as followup_question",
            "COUNT(DISTINCT CASE WHEN orquestion_doctor_id=$user_id AND orquestion_status=" . Members::DOCTOR_USER_TYPE . " AND reply_by=" . Members::DOCTOR_USER_TYPE . " THEN orquestion_id ELSE NULL END) as answered_question",
            "COUNT(DISTINCT CASE WHEN orquestion_doctor_id=$user_id AND  orquestion_status=" . Question::QUESTION_ACCEPTED . " THEN orquestion_id ELSE NULL END) as unanswered_question",
            "COUNT(DISTINCT CASE WHEN orquestion_status=" . Question::QUESTION_PENDING . " THEN orquestion_id ELSE NULL END) as all_question",
        ));


        $this->set('menu_count', $srch->fetch());
        $this->set('doctor_name', Members::getLoggedUserAttribute('doctor_first_name') . " " . Members::getLoggedUserAttribute('doctor_last_name'));
        return true;
    }

    function default_action() {


        global $db;
        
		$doctorId  =  Members::getLoggedUserID();	
		$replySrch = new SearchBase('tbl_question_replies');
		$replySrch->setPageSize(1);
		$replySrch->doNotCalculateRecords();
		$replySrch->setPageNumber(1);
		$replySrch->addOrder('reply_id','desc');
		$srch =  Question::searchActiveQuestions();
        $srch->joinTable('tbl_question_assign', 'INNER JOIN', 'qa.qassign_question_id=oq.orquestion_id', 'qa');
        $srch->joinTable("(".$replySrch->getQuery().")", 'LEFT JOIN', 'r.reply_orquestion_id=oq.orquestion_id', 'qr');
       // $srch->joinTable("(".$qstatusQuery->getQuery().")", 'LEFT JOIN', 'qs.qstatus_question_id=oq.orquestion_id', 'qs');
		$srch->addCondition('qassign_doctor_id', '=', $doctorId);
      
        $interval = "";
        if (!empty($filterBy)) {
            switch ($filterBy) {
                case "MONTH":
                    $interval = " 1 DAY";
					break;
                case "WEEK":
                    $interval = " 1 WEEK";
						break;
                case "SEMESTER":
                    $interval = " 6 MONTH";
                 
                    break;
            }
			
        }
		$srch->addCondition('orquestion_status', '=', Question::QUESTION_REPLIED_BY_PATIENT);
        $srch->addGroupBy('orquestion_id');
        $srch->addMultipleFields(array('orquestion_question', 'user_id', 'orquestion_id', 'CONCAT(user_first_name," " , user_last_name) as user_name', 'order_date','qassign_doctor_id','orquestion_doctor_id','orquestion_status','orquestion_last_updated','qr.reply_date'));
        $rs = $srch->getResultSet();
		$arr_listing = $srch->fetch_all();
		$this->set('arr_listing', $arr_listing); 

		$allQuestions = Question::getDoctorQuestionCount();
		$answeredQuestions = Question::getDoctorQuestionCount('answered');
		$unansweredQuestions = Question::getDoctorQuestionCount('unanswered');
		
		$this->set('allQuestions',$allQuestions);
		$this->set('answeredQuestions',$answeredQuestions);
		$this->set('unansweredQuestions',$unansweredQuestions);
		$this->render();
       
    }

    function myansweredquestions() {

        global $db;
        $page = Syspage::getPostedVar('page');
        $post = Syspage::getPostedVar();
        $orquestion_doctor_id = Members::getLoggedUserID();
        $question = new Question();
        $srch = $question->searchActiveQuestions();
        $srch->joinTable('tbl_question_replies', 'LEFT JOIN', 'r.reply_orquestion_id=oq.orquestion_id', 'r');
        $srch->addCondition('orquestion_doctor_id', '=', $orquestion_doctor_id);
        $srch->addCondition('orquestion_status', '=', Question::QUESTION_REPLIED_BY_DOCTOR);

        $srch->addGroupBy('orquestion_id');
        $srch->addMultipleFields(array('orquestion_question', 'user_id', 'orquestion_id', 'CONCAT(user_first_name," " , user_last_name) as user_name', 'order_date'));

        if (!empty($post['sort_by'])) {
            $cnd = $srch->addOrder('order_date', 'ASC');
        } else {
            $srch->addOrder('order_date', 'DESC');
        }
        $interval = "";
        if (!empty($post['filter_by'])) {
            switch ($post['filter_by']) {
                case "MONTH":
                    $interval = " 1 DAY";
                case "WEEK":
                    $interval = " 1 WEEK";
                case "SEMESTER":
                    $interval = " 6 MONTH";
                    $cnd = $srch->addDirectCondition("order_date BETWEEN DATE( DATE_SUB( NOW() , INTERVAL $interval )) AND  CURDATE()  ");
                    break;
            }
        }
        $this->paginate($srch, $page, generateUrl('doctor', 'myansweredquestions'));
        $this->set('searchForm', $this->searchForm());
		$this->set('selected_menu','myansweredquestions');
		$this->set('question_title',getLabel('L_My_Answered_Questions'));
        if (isAjaxRequest()) {

            $this->render('', '', 'common/doctor/myansweredquestions.php');
        } else {
            $this->render();
        }
    }
	 function myclosedquestions() {

        global $db;
        $page = Syspage::getPostedVar('page');
        $post = Syspage::getPostedVar();
        $orquestion_doctor_id = Members::getLoggedUserID();
        $question = new Question();
        $srch = $question->searchActiveQuestions();
        $srch->joinTable('tbl_question_replies', 'LEFT JOIN', 'r.reply_orquestion_id=oq.orquestion_id', 'r');
        $srch->addCondition('orquestion_doctor_id', '=', $orquestion_doctor_id);
        $srch->addCondition('orquestion_status', '=', Question::QUESTION_CLOSED);
        $srch->addGroupBy('orquestion_id');
        $srch->addMultipleFields(array('orquestion_status','orquestion_question', 'user_id', 'orquestion_id', 'CONCAT(user_first_name," " , user_last_name) as user_name', 'order_date'));

        if (!empty($post['sort_by'])) {
            $cnd = $srch->addOrder('order_date', 'ASC');
        } else {
            $srch->addOrder('order_date', 'DESC');
        }
        $interval = "";
        if (!empty($post['filter_by'])) {
            switch ($post['filter_by']) {
                case "MONTH":
                    $interval = " 1 DAY";
                case "WEEK":
                    $interval = " 1 WEEK";
                case "SEMESTER":
                    $interval = " 6 MONTH";
                    $cnd = $srch->addDirectCondition("order_date BETWEEN DATE( DATE_SUB( NOW() , INTERVAL $interval )) AND  CURDATE()  ");
                    break;
            }
        }
        $this->paginate($srch, $page, generateUrl('doctor', 'myclosedquestions'));
        $this->set('searchForm', $this->searchForm());
		$this->set('selected_menu','myclosedquestions');
		$this->set('question_title',getLabel('L_My_Closed_Questions'));
        if (isAjaxRequest()) {

            $this->render('', '', 'common/doctor/myansweredquestions.php');
        } else {
            $this->render();
        }
    }
    private function searchForm() {
        $frm = new Form('searchForm', 'searchForm');
        $frm->setAction(generateUrl('customer', 'questions'));
        $frm->setExtra("class='form' onChange='submitsearch()'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");

        $frm->addSelectBox('Status', 'orquestion_status', array(Question::QUESTION_ACCEPTED => 'My Accepted Questions', Question::QUESTION_PENDING => 'My Pending Questions', Question::QUESTION_REPLIED_BY_DOCTOR => 'Followup Questions', Question::QUESTION_CLOSED => 'My Closed Questions'));

        $frm->addSelectBox('Sort By', 'sort_by', array(1 => 'Oldest to Newest'), '', '', 'Recent Questions');
        $frm->addSelectBox('Filter By', 'filter_by', array("WEEK" => '1 Week', "MONTH" => '1 Month', "SEMESTER" => '6 months'), '', '', 'All');
        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Search', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'reset', 'Show All', '', 'class="cancel_search" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('searchValidator');
        $frm->setOnSubmit('return submitsearch(this, searchValidator);');
        return $frm;
    }

    function questions($selected='') {
	
        global $db;
        $page = Syspage::getPostedVar('page');
        $post = Syspage::getPostedVar();
        $orquestion_doctor_id = Members::getLoggedUserID();
        $question = new Question();
        $srch = $question->searchActiveQuestions();
        $srch->joinTable('tbl_question_replies', 'LEFT JOIN', 'r.reply_orquestion_id=oq.orquestion_id', 'r');
		$srch->addCondition('orquestion_doctor_id', '=', $orquestion_doctor_id);
        $srch->addCondition('orquestion_status', '=', '0');
        $srch->addOrder('orquestion_id', 'desc');
        $srch->addGroupBy('orquestion_id');
        $srch->addMultipleFields(array('orquestion_question', 'user_id', 'orquestion_id', 'CONCAT(user_first_name," " , user_last_name) as user_name', 'order_date'));

        $this->paginate($srch, $page, generateUrl('doctor', 'questions'));
		if($selected !='')
		{
			$this->set('selected_menu',$selected);
			$this->set('question_title',getLabel('L_My_Unanswered_Questions'));
		}
		else
		{
			$this->set('selected_menu','questions');
			$this->set('question_title',getLabel('L_My_Questions'));
		}
      
            $this->render();
        
    }
	
	
	function unansweredquestions() {

      global $db;
        $page = Syspage::getPostedVar('page');
        $post = Syspage::getPostedVar();
        $orquestion_doctor_id = Members::getLoggedUserID();
        $question = new Question();
       
		if($selected !='')
		{
			$this->set('selected_menu',$selected);
			$this->set('question_title',getLabel('L_My_Unanswered_Questions'));
		}
		else
		{
			$this->set('selected_menu','unansweredquestions');
			$this->set('question_title',getLabel('L_My_Questions'));
		}
      
         $this->render();
       
    }

	
   
    
    function setup_reply() {
        global $db;
        $post = Syspage::getPostedVar();
        $frm = $this->getReplyFrm();
        $orquestion_id = intval($post['reply_orquestion_id']);
        $this->Question = new Question();
        if (!$frm->validate($post)) {
			dieJsonError($frm->getValidationErrors());
        }
        $post['reply_by'] = Members::getLoggedUserAttribute('user_type');

        $srch = $this->Question->getReplies();
        $srch->joinTable('tbl_files', 'LEFT JOIN', 'file_record_id=reply_id  AND file_record_type=' . Files::QUESTION_ATTACHMENT);
        $srch->addCondition('reply_orquestion_id', '=', $orquestion_id);
        $srch->addOrder('reply_id', 'DESC');
        $srch->addFld(array('r.*', 'user_id', '(CASE WHEN '
            . 'reply_by=' . Question::QUESTION_REPLIED_BY_DOCTOR . '
				  THEN CONCAT_WS(" ",doctor_first_name,doctor_last_name) ELSE CONCAT_WS(" ",user_first_name,user_last_name) END) as replier_name',
            'order_date', 'count(file_record_id) as attachments','category_name','doctor_city','state_name','doctor_summary as degrees')
        );
        $srch->addGroupBy('reply_id');
        $rs = $srch->getResultSet();
        $total_records = $srch->recordCount();
        $arr_replies = $db->fetch($rs);
        $this->set('reply', $arr_replies);
		
        if ($post['reply_by'] == Members::DOCTOR_USER_TYPE) {

            $srch = $this->Question->searchActiveQuestions();
            $srch->addDirectCondition('( orquestion_doctor_id="' . Members::getLoggedUserID() . '" OR  orquestion_doctor_id=0)');

            $srch->addCondition('orquestion_id', '=', $orquestion_id);
            $srch->addMultipleFields(array('orquestion_question', 'orquestion_status', 'user_id', 'orquestion_reply_status', 'orquestion_id', 'CONCAT(user_first_name," " , user_last_name) as user_name', 'order_date'));

            $rs = $srch->getResultSet();
            $result = $db->fetch_all($rs);
            $total_record = $srch->recordCount();
            if ($total_record < 1) {
                Message::addErrorMessage("Invalid Access");
                die(convertToJson(array('status' => 0, 'msg' => Message::getHtml(), 'response' => $response)));
            }
            $post2['orquestion_status'] = Question::QUESTION_REPLIED_BY_DOCTOR;
            if (CONF_REQUIRED_REPLY_APPROVAL && $result['orquestion_status'] == Question::QUESTION_REPLIED_BY_DOCTOR && $result['orquestion_reply_status'] == Question::REPLY_PENDING && $post['reply_id'] < 1) {
                Message::addErrorMessage("You can not send reply untill your first reply approved");
                dieJsonError(Message::getHtml());
            }
            if ($result['orquestion_reply_status'] == 1) {
                $post2['orquestion_reply_status'] = 1;
            } elseif (CONF_REQUIRED_REPLY_APPROVAL && $total_records <= 1) {
                $post2['orquestion_reply_status'] = 0;
            } else {
                $post2['orquestion_reply_status'] = 1;
                $post2['orquestion_replied_at'] = date("Y-m-d h:i:s");
            }
            $post['reply_by'] = Question::QUESTION_REPLIED_BY_DOCTOR;
        } else {
            $srch = $this->Question->searchActiveQuestions();
            $srch->addCondition('orquestion_id', '=', $orquestion_id);
            $srch->addCondition('order_user_id', '=', Members::getLoggedUserAttribute('user_id'));
            $srch->addMultipleFields(array('orquestion_question', 'user_id', 'orquestion_id', 'CONCAT(user_first_name," " , user_last_name) as user_name', 'order_date'));
            $rs = $srch->getResultSet();
            $total_record = $srch->recordCount();

            if ($total_record < 1) {
                Message::addErrorMessage("Invalid Access");
                die(convertToJson(array('status' => 0, 'msg' => Message::getHtml(), 'response' => $response)));
            }

            $post2['orquestion_status'] = Question::QUESTION_REPLIED_BY_PATIENT;
            $post['reply_by'] = Question::QUESTION_REPLIED_BY_PATIENT;
        }


        $uploaded_files = $post['uploaded_files'];
        $data = $post;
        unset($data['uploaded_files']);
        $data['reply_approved'] = 1;
        /*  if (CONF_REQUIRED_REPLY_APPROVAL) {
          $data['reply_approved'] = 0;
          } */
        if ($reply_id = $this->Question->setUpReply($data)) {

            $post2['orquestion_id'] = $orquestion_id;
            //Update Order Status 
            $this->Question->updateOrderStatus($post2);
            $files = new Files();
            $questionAttachments = $files->getFiles($data['reply_id'], Files::QUESTION_ATTACHMENT);

            foreach ($questionAttachments as $attached_files) {
                $attached_data['file_record_type'] = Question::REPLY_TYPE;
                $attached_data['file_record_id'] = '';
                $attached_data['file_id'] = $attached_files['file_id'];
                $files->addFile($attached_data);
            }
            // Updates File status
            if ($post['uploaded_files']) {
                $files = new Files();
                foreach ($post['uploaded_files'] as $uploaded_file_id) {
                    $reply['file_record_type'] = Question::REPLY_TYPE;
                    $reply['file_record_id'] = $reply_id;
                    $reply['file_id'] = $uploaded_file_id;
                    $files->addFile($reply);
                }
            }

            //Email TO user
            $this->docReplyEmail($reply_id);


            $srch = $this->Question->getReplies();
            $srch->joinTable('tbl_files', 'LEFT JOIN', 'file_record_id=reply_id  AND file_record_type=' . Files::QUESTION_ATTACHMENT);
            $srch->addCondition('reply_orquestion_id', '=', $orquestion_id);
            $srch->addOrder('reply_id', 'DESC');
            $srch->addFld(array('r.*', 'user_id', '(CASE WHEN '
                . 'reply_by=' . Question::QUESTION_REPLIED_BY_DOCTOR . '
				  THEN CONCAT_WS(" ",doctor_first_name,doctor_last_name) ELSE CONCAT_WS(" ",user_first_name,user_last_name) END) as replier_name',
                'order_date', 'count(file_record_id) as attachments','category_name','doctor_city','state_name','doctor_summary as degrees')
            );
            $srch->addGroupBy('reply_id');
            $rs = $srch->getResultSet();
            $total_records = $srch->recordCount();
            $arr_replies = $db->fetch($rs);

            $this->set('reply', $arr_replies);


            $response = $this->_template->render(false, false, 'doctor/getReply.php', true);
            Message::addMessage("Your reply is successfully saved.");
            die(convertToJson(array('status' => 1, 'msg' => Message::getHtml(), 'response' => $response, 'total_replies' => $total_records, 'reply_id' => $reply_id)));
        } else {

            Message::addErrorMessage("We are unable to process the data, Please try after some time");
            dieJsonError(Message::getHtml());
        }
    }

    public function docReplyEmail($reply_id) {
        //Send email
        $Email = new Emails();
        $Email->replies = array($reply_id);
        $Email->doctorReplyEmail();
    }

    public function question($orquestion_id) {

        global $db;
        if (!Members::isUserLogged()) {
            redirectUser(generateUrl('members', 'login'));
        }
        $post = Syspage::getPostedVar();
        $question = new Question();
        $orquestion_id = intval($orquestion_id);
        $srch = $question->searchActiveQuestions();
        $srch->addCondition('orquestion_id', '=', $orquestion_id);
        $logged_user_type = Members::getLoggedUserAttribute('user_type');
        $user_id = Members::getLoggedUserID();
        if ($logged_user_type == Members::CUSTOMER_USER_TYPE) {
            $srch->addCondition('orquestion_user_id', '=', $user_id);
        } elseif ($logged_user_type == Members::DOCTOR_USER_TYPE) {
            $srch->addDirectCondition("(orquestion_doctor_id=$user_id OR  orquestion_doctor_id=0)");
        } else {
            redirectUser(generateUrl('members', 'login'));
        }
        $srch->addMultipleFields(array('orquestion_id', 'order_user_id', 'orquestion_status', 'orquestion_reply_status', 'orquestion_question', 'orquestion_doctor_id', 'orquestion_med_history', 'orquestion_seen_doctor', 'order_date', 'CONCAT(user_first_name," " , user_last_name) as user_name', 'orquestion_age', 'orquestion_gender', 'user_added_on', 'user_email', 'user_id', 'COUNT(file_id) as have_file','orquestion_weight'));
        $srch->addGroupBy('orquestion_id');
        $rs = $srch->getResultSet();
        $arr_question = $db->fetch($rs);
        $this->set('arr_question', $arr_question);
        $doctor_id = Members::getLoggedUserID();
        if ($arr_question['orquestion_doctor_id'] > 0 && $arr_question['orquestion_doctor_id'] != Members::isDoctorLogged()) {
            die('Invalid Access');
        }
        if ($arr_question['orquestion_doctor_id'] > 0) {
            $srch = $question->getReplies();
            $srch->joinTable('tbl_files', 'LEFT JOIN', 'file_record_id=reply_id  AND file_record_type=' . Files::QUESTION_ATTACHMENT);
            $srch->addCondition('reply_orquestion_id', '=', $orquestion_id);
            //$srch->addCondition('file_record_type','=',QUESTION::REPLY_TYPE);
            $srch->addFld(array('r.*', '(CASE WHEN '
                . 'reply_by=' . Question::QUESTION_REPLIED_BY_DOCTOR . '
                      THEN CONCAT_WS(" ",doctor_first_name,doctor_last_name) ELSE CONCAT_WS(" ",user_first_name,user_last_name) END) as replier_name', 'count(file_record_id) as attachments','category_name','doctor_city','state_name','doctor_summary as degrees')
            );
			
            $srch->addGroupBy('reply_id');
            $rs = $srch->getResultSet();
		
            $replies = $db->fetch_all($rs);

            $this->set('replies', $replies);
            $data['reply_orquestion_id'] = $orquestion_id;
            $replyFrm = $this->getReplyFrm();
            $this->set('replyFrm', $replyFrm);

            $replyFrm->fill($data);
            $upFrm = $this->getFileUploadForm();
            $upFrm->addHiddenField("action", "action", "upload_file");
            $this->set('upFrm', $upFrm);
        }

        $this->_template->render();
    }
	
	public function updateReplyView($questionId){
		$data['reply_orquestion_id'] = $questionId;
		$data['reply_view'] = 1;
		$data['reply_by'] = Question::QUESTION_REPLIED_BY_PATIENT;	
		$question = new Question();		
		$question->updateReplyView($data);
	}


    function getReplyFrm() {

        $frm = new Form('frmReplyForm', 'frmReplyForm');
        $frm->setExtra(' class="table_formsingle full-width-form" method=post');
		$frm->setLeftColumnProperties('class="td_form_horizontal"');
        $frm->addHiddenField('', 'reply_orquestion_id')->requirements()->setRequired();
        $frm->addHiddenField('', 'uploaded_files_id', '', 'uploaded_files_id');
        $frm->addHiddenField('', 'reply_id', '', 'reply_id');
        $fld = $frm->addHtmlEditor('Reply', 'reply_text');
        $fld->requirements()->setRequired();
        $frm->setAction(generateUrl('doctor', 'setup_reply'));
        $frm->addButton("", "add_attachment", "Add Attachment", "add_attachment", 'class="attachment-js  up-btn-js button button--non-fill button--primary fl--left"');
        $frm->addSubmitButton('', 'btn_reply', 'Reply', 'btn_reply', 'class="button button--fill button--secondary fl--right"');
        $frm->setValidatorJsObjectName('replyValidator');
        $frm->setOnSubmit('return submitForm(this, replyValidator);');
        return $frm;
    }

    function getFileUploadForm() {
        $frm = new Form('uploadFileForm', 'uploadFileForm');
        $frm->setAction(generateUrl('doctor', 'setup_file'));
        $frm->setExtra('class="siteForm" style="display:none"');
        $frm->addFileUpload("", "fileupload", "fileupload")->requirements()->setRequired();
        return $frm;
    }

    /** Edit Profile *** */
    function profile() {

        $doctor_id = Members::getLoggedUserID();

        //Check if doctor exist
        $srch = Doctor::getDoctores();
        $srch->addMultipleFields(array('*'));
        $srch->addCondition('doctor_id', '=', $doctor_id);
        $doctor_data = $srch->fetch();

        if (intval($doctor_data['doctor_id']) < 1) {
            die("Invalid Request");
        }


        $this->set('frm', $this->form());
        $this->set('doctor_data', $srch->fetch());
		$this->set('selected_menu','profile');
        $this->_template->render();
    }

    function edit_profile() {

        $post = Syspage::getPostedVar();		
        $removeFields = array('doctor_deleted' => 1, 'doctor_active' => 2, 'btn_submit' => 3);
        $filteredFields = array_diff_key($post, $removeFields);
        $frm = $this->form();
        $doctor_id = Members::getLoggedUserID();

        //Check if doctor exist
        $srch = Doctor::getDoctores();
        $srch->addMultipleFields(array('*'));
        $srch->addCondition('doctor_id', '=', $doctor_id);
        $doctor_data = $srch->fetch();

        if (intval($doctor_data['doctor_id']) < 1) {
            die("Invalid Request");
        }
		
        //validate The form 
        if (!$frm->validate($filteredFields)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('doctor', 'profile'));
        }
        $filteredFields = array_merge($filteredFields, array('doctor_id' => $doctor_id));

        if (!$this->Doctor->setupDoctor($filteredFields)) {

            Message::addErrorMessage("Error While saving the profile.Please try after some time");
        }
        Message::getHtml();
        Message::addMessage("Profile is updated successfully.");


        redirectUser(generateUrl('doctor', 'profile'));
    }

    private function getform() {
        $frm = new Form('FrmStates');
        $frm->setAction(generateUrl('doctor', 'edit_profile'));
        $frm->setExtra("class='form form__horizontal'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setFieldsPerRow(2);
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addRequiredField('First Name', 'doctor_first_name')->requirements()->setRequired();
        $frm->addRequiredField('Last Name', 'doctor_last_name')->requirements()->setRequired();
        $frm->addHiddenField('', 'doctor_id', '', 'doctor_id');
        /* $fld = $frm->addEmailField('Email', 'doctor_email', '', 'doctor_email');
        $fld->setUnique('tbl_doctors', 'doctor_email', 'doctor_id', 'doctor_id', 'doctor_id'); */

        $frm->addSelectBox('Medical Category', 'doctor_med_category', Medicalcategory::getActiveCategories()->fetch_all_assoc())->requirements()->setRequired();

        $frm->addTextArea('Doctor Summary Of Qualifictaion', 'doctor_summary')->requirements()->setRequired();

        $frm->addRequiredField('Address', 'doctor_address')->requirements()->setRequired();
        $frm->addRequiredField('City', 'doctor_city')->requirements()->setRequired();

        $fld = $frm->addSelectBox('State', 'doctor_state_id', State::getStateCountryOpt())->requirements()->setRequired();
        $frm->addIntegerField('House No#', 'doctor_house_no')->requirements()->setRequired();
        $frm->addIntegerField('Pincode', 'doctor_pincode')->requirements()->setRequired();
        $frm->addIntegerField('Phone No#', 'doctor_phone_no')->requirements()->setRequired();

		/*New Added Fields*/
		$frm->addFloatField('Experience In Year', 'doctor_experience')->requirements()->setRequired();
		$frm->addTextArea('Experience Summary ','doctor_experience_summary')->requirements()->setRequired();
		$frm->addRequiredField('Medical or Graduate School', 'doctor_med_school')->requirements()->setRequired();
		$frm->addTextArea('Doctor Summary Of Qualification','doctor_summary')->requirements()->setRequired();
        $frm->addSelectBox('Medical degree', 'doctor_med_degree', degree::getactivedegree()->fetch_all_assoc())->requirements()->setRequired();

        $frm->addSelectBox('Medical Year', 'doctor_med_year', getYearList())->requirements()->setRequired();

        $frm->addRequiredField('License No', 'doctor_licence_no')->requirements()->setRequired();
        $fld = $frm->addSelectBox('Medical State', 'doctor_med_state_id', State::getStateCountryOpt())->requirements()->setRequired();
		
        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Update', 'btn_submit', 'class="button button--fill button--orange" style="cursor:pointer;"');
        //   $fld2 = $frm->addButton('', 'cancel', 'Cancel', '', 'class="cancel_form reset_button" style="margin-left:10px; cursor:pointer;"');
        //  $fld1->attachField($fld2);
        //$fld1->merge_cells=2;

        return $frm;
    }

    public function form() {
       
        $doctor_id = Members::getLoggedUserID();
        $frm = $this->getform();
        if (intval($doctor_id) > 0) {

            $srch = Doctor::getDoctores();
            $srch->addCondition('doctor_id', "=", $doctor_id);
            $data = $srch->fetch();

            $frm->fill($data);

            if (!$data)
                dieWithError('Invalid Request');
        }
        else {
            dieWithError("Invalid Reqest");
        }
        $this->set('frm', $frm);
        return $frm;
    }

    /*     * ***Change Password******* */

    function changepasswordform() {
        $frm = new Form('frmPassword');
        $frm->setJsErrorDisplay('afterfield');
        $frm->setExtra(' class="form form__horizontal"');
        $frm->setTableProperties("class='edit_form' width='100%'");
        $frm->addPasswordField('Current Password:', 'current_password')->requirements()->setRequired();
        $fld = $frm->addPasswordField('New Password:', 'new_password');
        $fld->requirements()->setLength(6, 20);
        $fld->requirements()->setRequired();
        $fld1 = $frm->addPasswordField('Confirm New Password:', 'new_password1');
        $fld1->requirements()->setLength(6, 20);
        $fld1->requirements()->setCompareWith('new_password', 'eq', 'New Password');

        $frm->addSubmitButton('', 'btn_submit', 'Update', 'btn_submit' , 'class="button button--fill button--orange"' );
        $frm->setAction(generateUrl('doctor', 'changepasswordsetup'));
        return $frm;
    }

    function changepassword() {
        $doctor_id = Members::getLoggedUserID();
        $srch = Doctor::getDoctores();
        $srch->addCondition('doctor_id', "=", $doctor_id);
        $doctor_data = $srch->fetch();

        if (intval($doctor_data['doctor_id']) < 1) {
            die("Invalid Request");
        }

        $this->set('doctor_data', $doctor_data);
        $this->set('frm', $this->changepasswordform());
		$this->set('selected_menu','profile');
        $this->_template->render();
    }

    public function changepasswordsetup() {
        $doctor_id = Members::getLoggedUserID();

        $srch = Doctor::getDoctores();
        $srch->addCondition('doctor_id', "=", $doctor_id);
        $doctor_data = $srch->fetch();

        if (intval($doctor_data['doctor_id']) < 1) {
            die("Invalid Request");
        }
        $frm = $this->changepasswordform();
        $post = Syspage::getPostedVar();
        //validate The form 

        if ($doctor_data['doctor_password'] !== encryptPassword($post['current_password'])) {
            Message::addErrorMessage("Current password is not correct.");
            redirectUser(generateUrl('doctor', 'changepassword'));
        }

        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('doctor', 'changepassword'));
        }



        $newPass = $post['new_password'];
        $data = array('doctor_password' => $newPass, 'doctor_id' => $doctor_id);
        if (!$this->Doctor->setupDoctor($data)) {

            Message::addErrorMessage("Error While changing the password.Please try after some time");
        }

        Message::addMessage("Password is updated successfully.");


        redirectUser(generateUrl('doctor', 'changepassword'));
    }

    /*     * ***********Upload profile image******** */

    function profile_pic() {
        $post = Syspage::getPostedVar();
        $doctor_id = Members::getLoggedUserID();


        $srch = Doctor::getDoctores();
        $srch->addCondition('doctor_id', "=", $doctor_id);
        $doctor_data = $srch->fetch();

        if (intval($doctor_data['doctor_id']) < 1) {
            die("Invalid Request");
        }


        $response = "";

        if ($_FILES['fileupload']['name'] != "" && $_FILES['fileupload']['error'] == 0) {
            $isUpload = uploadContributionFile($_FILES['fileupload']['tmp_name'], $_FILES['fileupload']['name'], $response, "doc_profile/");

            if ($isUpload) {
                $fls = new Files();

                //Check if previous file

                $record = $fls->getFile($doctor_id, Files::DOCTOR_PROFILE);
                if (intval($record['file_id']) > 0) {
                    $dat['file_id'] = $record['file_id'];
                    $filepath = $record['file_path'];
                }

                $dat['file_record_type'] = Files::DOCTOR_PROFILE;
                $dat['file_record_id'] = $doctor_id;
                $dat['file_path'] = $response;
                $dat['file_display_name'] = $_FILES['fileupload']['name'];
                $dat['file_display_order'] = 0;
                $file_id = $fls->addFile($dat);

                Message::addMessage("Profile picture is successfully changed");
                $removeFilePath = CONF_INSTALLATION_PATH . 'user-uploads/' . $filepath;
                unlink($removeFilePath);
            } else {
                Message::addErrorMessage($response);
            }
        } else {
            Message::addErrorMessage("Error While changing the profile picture.");
        }

        redirectUser(generateUrl('doctor', 'profile'));
    }

    public function getDoctorProfilePic($doc_id, $w, $h) {

        $fls = new Files();

        if (intval($doc_id) < 1) {
            $doc_id = Members::getLoggedUserID();
        }
        $data = $fls->getFirstImage($doc_id, Files::DOCTOR_PROFILE);

        Image::displayImage(($data['file_path'] == '' ? 'images/default_icon-user.jpg' : $data['file_path']), $w, $h);
    }

    /*     * ****Update question status ******* */

    public function updateQuestionStatus() {

        $post = Syspage::getPostedVar();
        $doctor_id = Members::getLoggedUserID();
		
        //Check for ajax request
        if (isAjaxRequest()) {

            $srch = Doctor::getDoctores();
            $srch->addCondition('doctor_id', "=", $doctor_id);
            $doctor_data = $srch->fetch();

            if (intval($doctor_data['doctor_id']) < 1) {
                Message::addErrorMessage("Invalid Request");
                dieWithError(Message::getHtml());
            }

            $data = array('orquestion_status' => intval($post['qStatus']), 'orquestion_doctor_id' => '0');
            $record = new TableRecord('tbl_order_questions');

            //Remove previous doctor
            if ($post['qStatus'] === 0) {
                $data['orquestion_doctor_id'] = 0;
                $data['orquestion_doctor_accepted_at'] = '0000-00-00 00:00:00';
            }

            $record->assignValues($data);

            $success = $record->update(array('smt' => 'orquestion_id = ? AND orquestion_doctor_id= ?', 'vals' => array($post['_id'], $doctor_id)));

            if (!$success) {
                Message::addErrorMessage("Problem while updating the status");
                dieWithError(Message::getHtml());
            }
            Message::addMessage("Question status changed successfully");
            dieWithSuccess(Message::getHtml());
        } else {
            Message::addErrorMessage("Invalid Request");
            die(Message::getHtml());
        }
    }

    public function customer() {
        $this->set('searchForm', $this->customerSearchForm());

        $this->render();
    }

    function customerlisting() {
        global $db;
        $page = Syspage::getPostedVar('page');
        $post = Syspage::getPostedVar();

        $orquestion_doctor_id = Members::getLoggedUserID();
        $customer = new Customer();
        $srch = $customer->searchDoctorAssociatedCustomer();
        $srch->addOrder('user_id','desc');
        $srch->addCondition('orquestion_doctor_id', '=', $orquestion_doctor_id);

        $srch->addGroupBy('order_user_id');
        $srch->addMultipleFields(array('user_id', 'user_email', 'orquestion_id', 'CONCAT(user_first_name," " , user_last_name) as user_name', 'user_added_on'));



        $interval = "";
        if (!empty($post['search_keyword'])) {
            $cnd = $srch->addCondition('user_id', '=', $post['search_keyword']);
            $cnd = $cnd->attachCondition('user_email', 'like', $post['search_keyword'] . "%", 'OR');
        }



        //$rs = $srch->getResultSet();
        $this->paginate($srch, $page, generateUrl('doctor', 'customerlisting'));

        $this->render();
    }

    private function customerSearchForm() {
        $frm = new Form('searchForm', 'searchForm');
        $frm->setAction(generateUrl('doctor', 'customer'));
        $frm->setExtra("class='searchForm' ");
        $frm->setJsErrorDisplay('afterfield');
      
        $frm->addTextBox('Sort By', 'search_keyword', '', '', 'placeholder="Email Address or User Id"');

        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Search', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'reset', 'Show All', '', 'class="cancel_search" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);

        $frm->setOnSubmit('return submitsearch();');
        return $frm;
    }

    function loadform($id) {
        global $db;
        $post = Syspage::getPostedVar();
        $this->Question = new Question();
        $srch = $this->Question->getReplies();
        $srch->joinTable('tbl_files', 'LEFT JOIN', 'file_record_id=reply_id  AND file_record_type=' . Files::QUESTION_ATTACHMENT);

        $srch->addOrder('reply_id', 'DESC');
        $srch->addFld(array('r.*', 'user_id', 'orquestion_id', '(CASE WHEN '
            . 'reply_by=' . Question::QUESTION_REPLIED_BY_DOCTOR . '
                      THEN CONCAT_WS(" ",doctor_first_name,doctor_last_name) ELSE CONCAT_WS(" ",user_first_name,user_last_name) END) as replier_name',
            'order_date', 'count(file_record_id) as attachments')
        );
        $srch->addGroupBy('reply_id');
        $srch->addCondition('reply_id', '=', $post['id']);
        $rs = $srch->getResultSet();

        $data = $db->fetch($rs);
        $files = new Files();
        $questionAttachments = $files->getFiles($data['reply_id'], Files::QUESTION_ATTACHMENT);

        $this->set('files', $questionAttachments);
        $replyFrm = $this->getReplyFrm();
        $this->set('replyFrm', $replyFrm);
        $replyFrm->fill($data);
        $upFrm = $this->getFileUploadForm();
        $upFrm->addHiddenField("action", "action", "upload_file");
        $this->set('upFrm', $upFrm);
        $this->render('', '', 'common/doctor/form.php');
    }

    public function getFileList($question_id) {

        $files = new Files();
        $questionAttachments = $files->getFiles($question_id, Files::QUESTION_ATTACHMENT);

        if (count($questionAttachments) < 1) {
            die("Not found");
        }
        $filesPath = array_column($questionAttachments, 'file_path');


        $files->create_zip("Question", $questionAttachments);
    }

    /*
     * Customer View Page
     */

    public function viewcustomer($customer_id) {

        if (intval($customer_id < 1)) {
            redirectUser(generateUrl('customers'));
        }

        $doctor_id = Members::getLoggedUserID();
        $customer = new Customer();
        $srch = $customer->searchDoctorAssociatedCustomer();
        $srch->addCondition('orquestion_doctor_id', '=', $doctor_id);
        $srch->addCondition('order_user_id', '=', $customer_id);
        $srch->addGroupBy('order_user_id');
        $srch->addMultipleFields(array('*', 'CONCAT_WS(" ",user_first_name,user_last_name) as name'));
        $userdata = $srch->fetch();
        if (count($userdata) < 1) {
            die("Invalid Access");
        }



        //Get ALl Questions
        $customer = new Customer($customer_id);
        $questions = $customer->getCustomerQuestions();
        $questions->addCondition('orquestion_doctor_id', '=', $doctor_id);


        $this->set('user_data', $userdata);
        $this->set('questions', $questions->fetch_all());
        $this->_template->render();
    }

    /*
     * Function to create pdf of all the chat
     */

    public function generateChat($customer_id, $question_id) {

        $customer = new Customer($customer_id);

        $srch = Question::searchActiveQuestions();
        $srch->addMultipleFields(array('CONCAT_WS(" ",doctor_first_name,doctor_last_name) as doctor_name', 'CONCAT_WS(" ",user_first_name,user_last_name) as user_name', 'order_date', 'order_id'));
        $srch->addCondition('orquestion_id', '=', $question_id);
        $rs = $srch->getResultSet();


        $this->set('question_data', $srch->fetch());
        $rplies = $customer->getCustomerQuestionReply($question_id);
        $rplies->addFld(array('orquestion_question', 'r.*', 'order_date', '(CASE WHEN '
            . 'reply_by=' . Question::QUESTION_REPLIED_BY_DOCTOR . '
                      THEN CONCAT_WS(" ",doctor_first_name,doctor_last_name) ELSE CONCAT_WS(" ",user_first_name,user_last_name) END) as replier_name')
        );
        $replies = $rplies->fetch_all();


        if ($rplies->recordCount() == 0) {
            die("Not Found");
        }


        $this->set('replies', $replies);
        $Content = $this->_template->render(false, false, 'doctor/customer_chat.php', true);


        create_pdf('communication.pdf', $Content);
    }
	
	function listquestions(){
		$page = Syspage::getPostedVar('page');
		$type = Syspage::getPostedVar('type');
		$sortBy = Syspage::getPostedVar('sort_by');
		$filterBy = Syspage::getPostedVar('filter_by');
		$doctorId  =  Members::getLoggedUserID();	
		$replySrch = new SearchBase('tbl_question_replies');
		$replySrch->setPageSize(1);
		$replySrch->doNotCalculateRecords();
		$replySrch->setPageNumber(1);
		$replySrch->addOrder('reply_id','desc');
		$srch =  Question::searchActiveQuestions();
        $srch->joinTable('tbl_question_assign', 'INNER JOIN', 'qa.qassign_question_id=oq.orquestion_id', 'qa');
        $srch->joinTable("(".$replySrch->getQuery().")", 'LEFT JOIN', 'r.reply_orquestion_id=oq.orquestion_id', 'qr');
       // $srch->joinTable("(".$qstatusQuery->getQuery().")", 'LEFT JOIN', 'qs.qstatus_question_id=oq.orquestion_id', 'qs');
		$srch->addCondition('qassign_doctor_id', '=', $doctorId);
      
        $interval = "";
        if (!empty($filterBy)) {
            switch ($filterBy) {
                case "MONTH":
                    $interval = " 1 DAY";
					break;
                case "WEEK":
                    $interval = " 1 WEEK";
						break;
                case "SEMESTER":
                    $interval = " 6 MONTH";
                 
                    break;
            }
			
        }
		if($type=='unanswered'){
			$fld= $srch->addCondition('orquestion_status', '=', Question::QUESTION_ASSIGNED);
			$fld->attachCondition('orquestion_status', '=', Question::QUESTION_ACCEPTED,'OR');
			$fld->attachCondition('orquestion_status', '=', Question::QUESTION_REPLIED_BY_PATIENT,'OR');
			$srch->addOrder('orquestion_last_updated', 'DESC');
		}elseif($type=='answered'){			
			$fld=$srch->addCondition('orquestion_status', '=', Question::QUESTION_REPLIED_BY_PATIENT);
			$fld->attachCondition('orquestion_status', '=', Question::QUESTION_REPLIED_BY_DOCTOR,'OR');
			if($interval)
			$cnd = $srch->addDirectCondition("r.reply_date > DATE_SUB( NOW() , INTERVAL $interval )");
			if (!empty($sortBy)) {
				$cnd = $srch->addOrder('order_date', 'ASC');
			} else {
				$srch->addOrder('order_date', 'DESC');
			}
		}elseif($type=='closed'){			
			//$cnd = $srch->addDirectCondition("orquestion_last_updated > DATE_SUB( NOW() , INTERVAL $interval )");
			$srch->addCondition('orquestion_status', '=', Question::QUESTION_CLOSED);
			if($interval)
			$cnd = $srch->addDirectCondition("orquestion_last_updated > DATE_SUB( NOW() , INTERVAL $interval )");
			if (!empty($sortBy)) {
            $cnd = $srch->addOrder('orquestion_last_updated', 'ASC');
			} else {
				$srch->addOrder('orquestion_last_updated', 'DESC');
			}
		}else{
			$srch->addOrder('orquestion_asked_on', 'DESC');
		}
		
        $srch->addGroupBy('orquestion_id');
        $srch->addMultipleFields(array('orquestion_question', 'user_id', 'orquestion_id', 'CONCAT(user_first_name," " , user_last_name) as user_name', 'order_date','qassign_doctor_id','orquestion_doctor_id','orquestion_status','orquestion_last_updated','qr.reply_date','orquestion_asked_on'));	
		
		$this->paginate($srch, $page, generateUrl('doctor', 'listquestions'));
        $this->render(false,false);
	}
	
	 function acceptquestion() {
		 global $db;
		$orquestionId =  Syspage::getPostedVar('questionId');
		if (intval($orquestionId < 1)) {
           dieJsonError(Utilities::getLabel('LBL_Invalid_Access'));
        }
		$doctorId  =  Members::getLoggedUserID();
        $question = new Question();
        $qstatusQuery = new SearchBase('tbl_question_status');
		$qstatusQuery->addOrder('qstatus_id','desc');
		$qstatusQuery->doNotCalculateRecords();
		//$qstatusQuery->addGroupBy('qstatus_question_id');
		$qstatusQuery->setPageSize(1);
        $qstatusQuery->setPageNumber(1);
		$srch =  Question::searchActiveQuestions();
        $srch->joinTable('tbl_question_assign', 'INNER JOIN', 'qa.qassign_question_id=oq.orquestion_id', 'qa');
        $srch->joinTable('tbl_question_replies', 'LEFT JOIN', 'r.reply_orquestion_id=oq.orquestion_id', 'r');
       // $srch->joinTable("(".$qstatusQuery->getQuery().")", 'LEFT JOIN', 'qs.qstatus_question_id=oq.orquestion_id', 'qs');
		$srch->addCondition('qassign_doctor_id', '=', $doctorId);
        $srch->addOrder('orquestion_id', 'desc');
        $srch->addGroupBy('orquestion_id');
        $srch->addCondition('orquestion_id', '=', $orquestionId);
        $srch->addMultipleFields(array('orquestion_question', 'user_id', 'orquestion_id', 'order_date','qassign_doctor_id','orquestion_doctor_id','orquestion_status'));	
        $rs = $srch->getResultSet();
		$questionData = $db->fetch($rs);
		if($questionData['qassign_doctor_id']!=$questionData['orquestion_doctor_id']){
			dieJsonError(Utilities::getLabel('LBL_Question_has_been_reassigned_to_other_doctor'));
		}elseif($questionData['orquestion_status']!=Question::QUESTION_ASSIGNED && $questionData['orquestion_doctor_id']!=$doctorId){
			dieJsonError(Utilities::getLabel('LBL_Question_is_already_assigned_to_other_doctor'));
		}elseif($questionData['orquestion_status']!=Question::QUESTION_ASSIGNED && $questionData['orquestion_doctor_id']==$doctorId){
			dieJsonError(Utilities::getLabel('LBL_You_have_alrady_accepted_this_question'));
		}
		$data['orquestion_id'] = $orquestionId;
		//$data['orquestion_status'] = Question::Question:ACCEPTED;
		$data['orquestion_doctor_id'] = $doctorId;
		$data['orquestion_doctor_accepted_at'] = 'mysql_func_NOW()';
		$data['orquestion_last_updated'] = 'mysql_func_NOW()';

		if ($this->Doctor->acceptQuestion($data)) {

			$logObj = new Questionlog();
			$logObj->acceptLog(array('log_doctor_id' => $doctorId, 'log_question_id' => $orquestionId));
			
			$questionStatusArr = array();
			$questionStatusArr['qstatus_question_id'] = $orquestionId;
			$questionStatusArr['qstatus_status'] = Question::QUESTION_ACCEPTED;//Assigned
			$questionStatusArr['qstatus_updated_by'] = $doctorId;
			$questionStatusArr['qstatus_updated_on'] = date("Y-m-d H:i:s");
			$question = new Question();
			if( $question->updateQuestionStatus($questionStatusArr)) {
				$Email = new Emails();
				$Email->questionList = array($orquestionId);
				$Email->questionAcceptByDocEmail();
			}
			
			
		}
		dieJsonSuccess(Utilities::getLabel('LBL_Question_has_been_Accepted_successfully'));
          //  redirectUser(generateUrl('doctor', 'unansweredquestions'));
       
    }
	
	function esclatequestion() {
		 global $db;
		$orquestionId =  Syspage::getPostedVar('questionId');
		if (intval($orquestionId < 1)) {
           dieJsonError(Utilities::getLabel('LBL_Invalid_Access'));
        }
		$doctorId  =  Members::getLoggedUserID();
        $question = new Question();
        $qstatusQuery = new SearchBase('tbl_question_status');
		$qstatusQuery->addOrder('qstatus_id','desc');
		$qstatusQuery->doNotCalculateRecords();
		//$qstatusQuery->addGroupBy('qstatus_question_id');
		$qstatusQuery->setPageSize(1);
        $qstatusQuery->setPageNumber(1);
		$srch =  Question::searchActiveQuestions();
       // $srch->joinTable('tbl_question_assign', 'INNER JOIN', 'qa.qassign_question_id=oq.orquestion_id', 'qa');
        $srch->joinTable('tbl_question_replies', 'LEFT JOIN', 'r.reply_orquestion_id=oq.orquestion_id', 'r');
       // $srch->joinTable("(".$qstatusQuery->getQuery().")", 'LEFT JOIN', 'qs.qstatus_question_id=oq.orquestion_id', 'qs');
		
        $srch->addOrder('orquestion_id', 'desc');
        $srch->addGroupBy('orquestion_id');
        $srch->addCondition('orquestion_id', '=', $orquestionId);
        $srch->addCondition('orquestion_doctor_id', '=', $doctorId);
        $srch->addMultipleFields(array('orquestion_question', 'user_id', 'orquestion_id', 'order_date','orquestion_doctor_id','orquestion_status'));	
        $rs = $srch->getResultSet();
		$questionData = $db->fetch($rs);
		if(!$questionData){
			dieJsonError(Utilities::getLabel('LBL_Invalid_Access'));
		}
		$data['orquestion_id'] = $orquestionId;
		//$data['orquestion_status'] = Question::Question:ACCEPTED;
		$data['orquestion_status'] = Question::QUESTION_ESCLATED_TO_ADMIN;
		$data['orquestion_last_updated'] = 'mysql_func_NOW()';
		if ($this->Doctor->esclateQuestion($data)) {

			$logObj = new Questionlog();
			$logObj->acceptLog(array('log_doctor_id' => $doctorId, 'log_question_id' => $orquestionId));
			
			$questionStatusArr = array();
			$questionStatusArr['qstatus_question_id'] = $orquestionId;
			$questionStatusArr['qstatus_status'] = Question::QUESTION_ESCLATED_TO_ADMIN;//esclated
			$questionStatusArr['qstatus_updated_by'] = $doctorId;
			$questionStatusArr['qstatus_updated_on'] = date("Y-m-d H:i:s");
			$question = new Question();
			if( $question->updateQuestionStatus($questionStatusArr)) {
				$Email = new Emails();
				$Email->questionList = array($orquestionId);
				$Email->questionEsclatedToAdmin();
			}
			
			
		}
		dieJsonSuccess(Utilities::getLabel('LBL_Question_has_been_esclated_to_admin_successfully'));
          //  redirectUser(generateUrl('doctor', 'unansweredquestions'));
       
    }

	
}
