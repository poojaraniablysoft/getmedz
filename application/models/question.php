<?php

class Question extends Model {

    protected $db;

    CONST REPLY_TYPE = 1;
    CONST QUESTION_PENDING = 0;
    CONST QUESTION_ASSIGNED = 1;
    CONST QUESTION_ACCEPTED = 2;
    CONST QUESTION_REJECTED= 3;
    CONST QUESTION_REPLIED_BY_DOCTOR = 4;
    CONST QUESTION_REPLIED_BY_PATIENT = 5;
    CONST QUESTION_ESCLATED_TO_ADMIN = 6;
    CONST QUESTION_CLOSED = 7;
    CONST REPLY_PENDING = 0;
    CONST REPLY_APPROVED = 1;
    CONST REPLY_DISAPPROVED = 2;
	
	CONST STEP_1 = 1;
    CONST STEP_2 = 2;
    CONST STEP_3 = 3;
    CONST STEP_4 = 4;
    CONST STEP_5 = 5;

    
    public static $QuestionStatus=array(Question::QUESTION_ACCEPTED => 'Accepted',Question::QUESTION_ASSIGNED => 'Assigned', Question::QUESTION_PENDING => 'Pending',Question::QUESTION_REPLIED_BY_DOCTOR =>'Doctor Replied', Question::QUESTION_REPLIED_BY_PATIENT => 'Followup', Question::QUESTION_CLOSED => 'Closed');
    
    public function __construct() {
        parent::__construct();
        $this->db = Syspage::getPostedVar();
    }

    public function setupQuestion($data) {


        $orquestion_id = intval($data['orquestion_id']);
        unset($data['orquestion_id']);
        $record = new TableRecord('tbl_order_questions');
        $record->assignValues($data);
        if ($orquestion_id > 0)
            $success = $record->update(array('smt' => 'orquestion_id = ?', 'vals' => array($orquestion_id)));
        else {
            $record->assignValues($data);
            $success = $record->addNew();
        }

        if ($success) {
            return $this->orquestion_id = ($orquestion_id > 0) ? $orquestion_id : $record->getId();
        } else {
            $this->error = $record->getError();
        }
        return $success;
    }
	public function setupQuestionAssignmentData($data) {


        
        $record = new TableRecord('tbl_question_assign');
        $record->assignValues($data);
		$success = $record->addNew();
   

        if (!$success) {
           
            $this->error = $record->getError();
        }
        return $success;
    }
	public function updateQuestionStatus($data) {


        
        $record = new TableRecord('tbl_question_status');
        $record->assignValues($data);
		$success = $record->addNew();  
		mail("pooja.rani@ablysoft.com","UPdate question Status",serialize($data));
		
        if (!$success) {           
            $this->error = $record->getError();
			
        }
		$updateArr= array();
		$record = new TableRecord('tbl_order_questions');
		$updateArr['orquestion_status'] = $data['qstatus_status'];
		
		if($data['qstatus_status']==0){
			mail("pooja.rani@ablysoft.com","Question Status is 0 for ".$data['qstatus_question_id'],serialize($data));
		}
        $record->assignValues($updateArr);
		
		$success = $record->update(array('smt' => 'orquestion_id = ?', 'vals' => array($data['qstatus_question_id'])));
        if (!$success) {           
            $this->error = $record->getError();
        }
        return $success;
    }

    public function searchQuestions() {
        $srch = new SearchBaseNew('tbl_order_questions', 'oq');
        $srch->joinTable('tbl_order_transactions', 'INNER JOIN', 'oq.orquestion_order_id=ot.tran_order_id', 'ot');
        $srch->joinTable('tbl_orders', 'INNER JOIN', 'o.order_id=ot.tran_order_id', 'o');
        $srch->joinTable('tbl_users', 'INNER JOIN', 'u.user_id=o.order_user_id', 'u');
        $srch->joinTable('tbl_doctors', 'LEFT JOIN', 'd.doctor_id=oq.orquestion_doctor_id', 'd');
        $srch->joinTable('tbl_files', 'LEFT JOIN', 'orquestion_id=file_record_id AND file_record_type=' . Files::QUESTION_POST_ATTACHMENT);
        return $srch;
    }

    static public function searchActiveQuestions() {
        $srch = new SearchBaseNew('tbl_order_questions', 'oq');
        $srch->joinTable('tbl_order_transactions', 'INNER JOIN', 'oq.orquestion_order_id=ot.tran_order_id', 'ot');
        $srch->joinTable('tbl_orders', 'INNER JOIN', 'o.order_id=ot.tran_order_id', 'o');
        $srch->joinTable('tbl_users', 'INNER JOIN', 'u.user_id=o.order_user_id', 'u');
        $srch->joinTable('tbl_doctors', 'LEFT JOIN', 'd.doctor_id=oq.orquestion_doctor_id', 'd');
		$srch->joinTable('tbl_question_replies', 'LEFT JOIN', 'r.reply_orquestion_id=oq.orquestion_id', 'r');
		$srch->joinTable('tbl_medical_categories', 'LEFT JOIN', 'ca.category_id=oq.orquestion_med_category', 'ca');		
        $srch->joinTable('tbl_files', 'LEFT JOIN', 'orquestion_id=file_record_id AND file_record_type=' . Files::QUESTION_POST_ATTACHMENT);
        $srch->addCondition('tran_completed', '=', Orderabstract::ORDER_COMPLETED);
		/* $srch->addGroupBy('reply_id'); */
		
        return $srch;
    }

    public function getReplies() {
        //AND reply_by=' . Question::QUESTION_REPLIED_BY_PATIENT
		
		$degreeSrch = new SearchBase('tbl_doctor_degrees','dd');
		$degreeSrch->joinTable('tbl_degrees', 'LEFT JOIN', 'd.degree_id=dd.docdegree_id','d');
		$degreeSrch->joinTable('tbl_doctors', 'LEFT JOIN', 'doc.doctor_id=dd.docdegree_doctor_id','doc');
		$degreeSrch->addMultipleFields(array('GROUP_CONCAT(degree_name) as degrees','doctor_id'));
		$degreeSrch->doNotCalculateRecords();
		$degreeSrch->doNotLimitRecords();
		$degreeSrch->addGroupBy('doctor_id');
        $srch = new SearchBaseNew('tbl_question_replies', 'r');
        $srch->joinTable('tbl_order_questions', 'INNER JOIN', 'r.reply_orquestion_id=oq.orquestion_id  ', 'oq');
        $srch->joinTable('tbl_orders', 'INNER JOIN', 'o.order_id=oq.orquestion_order_id  ', 'o');
        $srch->joinTable('tbl_users', 'LEFT JOIN', 'u.user_id=o.order_user_id ', 'u');
        $srch->joinTable('tbl_doctors', 'LEFT JOIN', 'd.doctor_id=oq.orquestion_doctor_id  AND reply_by=' . Question::QUESTION_REPLIED_BY_DOCTOR, 'd');
		$srch->joinTable('tbl_medical_categories', 'LEFT JOIN', 'd.doctor_med_category=mc.category_id  ', 'mc');
		$srch->joinTable('tbl_states', 'LEFT JOIN', 'd.doctor_state_id=s.state_id  ', 's');
		$srch->joinTable('('.$degreeSrch->getQuery().')', 'LEFT JOIN', 'deg.doctor_id=d.doctor_id  ', 'deg');
        return $srch;
    }
	
	public function getRepliesCount() {
        //AND reply_by=' . Question::QUESTION_REPLIED_BY_PATIENT
        $srch = new SearchBaseNew('tbl_question_replies', 'r');
        $srch->joinTable('tbl_order_questions', 'INNER JOIN', 'r.reply_orquestion_id=oq.orquestion_id  ', 'oq');
        $srch->joinTable('tbl_orders', 'INNER JOIN', 'o.order_id=oq.orquestion_order_id  ', 'o');
        $srch->joinTable('tbl_users', 'LEFT JOIN', 'u.user_id=o.order_user_id ', 'u');
        $srch->joinTable('tbl_doctors', 'LEFT JOIN', 'd.doctor_id=oq.orquestion_doctor_id  AND reply_by=' . Question::QUESTION_REPLIED_BY_DOCTOR, 'd');
		
		$rs = $srch->getResultSet();
		$all_reply_count = $srch->recordCount();
		//$all_reply_count = count($reply->fetch_all());
		
        return $all_reply_count;
    }

    public function setUpReply($data) {

        global $db;
        $reply_id = intval($data['reply_id']);
        if (!($reply_id > 0))
            $reply_id = 0;


        if ($reply_id > 0) {
            unset($data['uploaded_files_id']);
            unset($data['outmode']);
            $success = $db->update_from_array('tbl_question_replies', $data, array('smt' => 'reply_id = ?', 'vals' => array($reply_id)));
        } else {
            $record = new TableRecord('tbl_question_replies');
            $record->assignValues($data);
            $record->setFldValue('reply_date', 'mysql_func_NOW()', true);
            $success = $record->addNew();
        }
        if ($success) {

            return $this->reply_id = ($reply_id > 0) ? $reply_id : $record->getId();
        } else {
            $this->error = $record->getError();
        }
        return $success;
    }

    public function updateOrderStatus($data) {

        $orquestion_id = intval($data['orquestion_id']);
        unset($data['orquestion_id']);
        $record = new TableRecord('tbl_order_questions');
        $record->assignValues($data);
        if ($orquestion_id > 0)
            $success = $record->update(array('smt' => 'orquestion_id = ?', 'vals' => array($orquestion_id)));

        if ($success) {
            return $this->orquestion_id = ($orquestion_id > 0) ? $orquestion_id : $record->getId();
        } else {
            $this->error = $record->getError();
        }
        return $success;
    }
	
	public function getQuestionByCategory($cat_id,$result_type="array")
	{
		$user_id = Members::getLoggedUserID();        
        $question = $this->searchQuestions();
        $question->joinTable('tbl_question_replies', 'LEFT JOIN', 'r.reply_orquestion_id=oq.orquestion_id AND reply_approved=1 AND reply_by=' . Question::QUESTION_REPLIED_BY_DOCTOR, 'r');
        $question->joinTable('tbl_doctor_reviews', 'LEFT JOIN', 'review_doctor_id=doctor_id', 'rev');

        $question->addMultipleFields(array(
            'CONCAT_WS(" ",user_first_name,user_last_name) as customer_name',
            'order_date',
            'orquestion_question',
            'orquestion_id',
            'reply_text',
            'count(DISTINCT reply_id) as count_replies',
            'user_id',
            'reply_approved',
            'order_id',
            'reply_id',
            'orquestion_status',
            'doctor_id',
            'CONCAT_WS(" ",doctor_first_name,doctor_last_name) as doctor_name',
            '(CASE WHEN doctor_is_online=1 AND DATE_SUB(NOW(),INTERVAL 10 MINUTE)< doctor_last_activity THEN 1 ELSE 0 END) as doctor_online',
            'AVG(review_rating) as doc_rating'
        ));
        //  $question->addCondition('reply_approved','=','1');
        $question->addGroupBy('orquestion_id');
        $question->addOrder('orquestion_id', 'DESC');
		//$question->limit(5);
        //Searching Critreia
        $question->addCondition('order_user_id', '=', $user_id);
		$cnd = $question->addCondition('orquestion_status', '=', $cat_id);
		return $question;
		
	}
	
	public static function getQuestionIdByOrderId($orderId){
		global $db;
		
		$question = new SearchBaseNew('tbl_order_questions', 'oq');
       
		$question->addCondition('orquestion_order_id','=',$orderId);
		$question->addFld('orquestion_id');
	
		$res = $question->getResultSet();
		$result= $db->fetch($res);
	
		return $result['orquestion_id'];
	}
	
	public static function getQuestionForm() {
		
        $frm = new Form('frmQuestionForm', 'frmQuestionForm');
        $frm->setExtra(' class="form form__horizontal"');
        $frm->setJsErrorDisplay('beforefield');
        $categories = Medicalcategory::getActiveCategories()->fetch_all_assoc();
        $frm->setAction(generateUrl('askquestion'));
        $frm->addHiddenField('Medical Category', 'orquestion_med_category','', '', 'style="display:none"')->requirements()->setRequired();
		$frm->addTextBox('Name','orquestion_name','','orquestion_name','placeholder="Enter Your Name"');
        $frm->addTextArea('Medical Question', 'orquestion_question', '', 'orquestion_question', 'placeholder="Hi,can I answer your health question? Please type your question here..."')->requirements()->setRequired();
        $frm->addTextArea('Medical History', 'orquestion_med_history', '', '', 'placeholder="Medical History"');
        $frm->addSelectBox('Age', 'orquestion_age', Applicationconstants::$arr_age_year, '', '');
		$frm->addSelectBox('Weight (in Kgs)', 'orquestion_weight', Applicationconstants::$arr_weight_kgs, '', '');
		$frm->addSelectBox('Gender', 'orquestion_gender', Applicationconstants::$arr_gender, '', '');
        //$fld = $frm->addRadioButtons('Gender', 'orquestion_gender', Applicationconstants::$arr_gender, '', 2, 'class="lib_custom_radio"', 'class="custom_radio"');

        $fld = $frm->addFileUpload('', 'fileupload', 'file-1','class="inputfile inputfile-1"');

      //  $fld->extra = 'onChange="getElementById(\'textfield\').value = getElementById(\'browse\').value;" ';    

        $frm->addSelectBox('Select State', 'orquestion_state', State::getactiveStates()->fetch_all_assoc(), '', '');
		$frm->addTextBox('Phone Number','orquestion_phone','','orquestion_phone','placeholder="Enter Phone Number"');
		$emailFld = $frm->addEmailField('Email','orquestion_email','','orquestion_email','placeholder="Enter Your Email"');
		$emailFld->setUnique('tbl_users', 'user_email', 'user_id', 'user_email', 'user_email');
        $frm->addHiddenField('', 'step', '1');
        $frm->addHiddenField('Subscription', 'subscription_id', '','subscription_id');
		$frm->addHiddenField('Doctor Selection', 'orquestion_doctor_id', '','doctor_id');
        $frm->addHiddenField('', 'file_name');
        $frm->addHiddenField('', 'user_id',Members::getLoggedUserID(),'user_id');
		$frm->addCheckBox( '', 'orquestion_term', '1' ,'term');
		
        $frm->addSubmitButton('', 'btn_login', Utilities::getLabel('LBL_Next'), 'btn_login', ' class="button button--fill button--secondary fl--right"');
        return $frm;
    }
	
	static function getQuestionStatus($questionId){
		global $db;
		$qstatusQuery = new SearchBase('tbl_question_status');
		$qstatusQuery->addOrder('qstatus_id','desc');		
		$qstatusQuery->doNotCalculateRecords();
		$qstatusQuery->addCondition('qstatus_question_id','=',$questionId);
		$qstatusQuery->setPageSize(1);
        $qstatusQuery->setPageNumber(1); 
		
		$rs = $qstatusQuery->getResultSet();
		$questionData = $db->fetch($rs);
		
		return $questionData['qstatus_status'];
	}
	function addQuestionAssignment($orderId,$questionId){
		$ord = new Order();
		 
		$order = $ord->getOrderOnly($orderId);
		if($questionId<0){
			$questionId  = Question::getQuestionIdByOrderId($orderId);
		}
		$questionStatusArr = array();
		$questionStatusArr['qstatus_question_id'] = $questionId;
		$questionStatusArr['qstatus_status'] = Question::QUESTION_ASSIGNED;//Assigned
		$questionStatusArr['qstatus_updated_by'] = $order['order_user_id'];
		$questionStatusArr['qstatus_updated_on'] = date("Y-m-d H:i:s");
		$question = new Question();
		if( !($question->updateQuestionStatus($questionStatusArr))) {
			
		}
		
		
		$user = new Users();
		$arrayToSave = array('user_id' => $order['order_user_id'], 'user_active' => 1);
		if($order['order_user_id']){
			
			if( !($user->setupUser($arrayToSave))) {
				mail('pooja.rani@ablysoft.com','Unable to setupUser',serialize($arrayToSave));
			}
		}

		 $Email = new Emails();
		
		 $Email->questionList = array($questionId);
		 $Email->questionPostEmail();
		 return true;
	}
	
	public function updateReplyView($data){
		
		$updateArr = array();
		$updateArr['reply_view'] = $data['reply_view'];
		$record = new TableRecord(tbl_question_replies);
        $record->assignValues($updateArr);
		
		$success = $record->update(array('smt' => 'reply_orquestion_id = ? and reply_by =?', 'vals' => array($data['reply_orquestion_id'],$data['reply_by'])));
        if (!$success) {           
            $this->error = $record->getError();
        }
        return $success;
	}
	
	public function getQuestionsCount($status = 0)
	{
		global $db;
		$user_id = Members::getLoggedUserID();        
        $question = $this->searchQuestions();
       

       
        //  $question->addCondition('reply_approved','=','1');
        $question->addGroupBy('orquestion_id');
        $question->addCondition('order_user_id', '=', $user_id);
		switch($status){
			case Question::QUESTION_ACCEPTED:
				$cnd = $question->addCondition('orquestion_status', '=',Question::QUESTION_ACCEPTED);
				$cnd->attachCondition('orquestion_status', '=',Question::QUESTION_REPLIED_BY_DOCTOR);
				$cnd->attachCondition('orquestion_status', '=',Question::QUESTION_REPLIED_BY_PATIENT);
				$cnd->attachCondition('orquestion_status', '=',Question::QUESTION_ESCLATED_TO_ADMIN);
				$cnd->attachCondition('orquestion_status', '=',Question::QUESTION_CLOSED);
					
				break;
			case Question::QUESTION_ASSIGNED:
				$cnd = $question->addCondition('orquestion_status', '=',Question::QUESTION_ASSIGNED);
				break;
			case Question::QUESTION_REPLIED_BY_DOCTOR:
				$cnd = $question->addCondition('orquestion_status', '=',Question::QUESTION_REPLIED_BY_DOCTOR);
				$cnd->attachCondition('orquestion_status', '=',Question::QUESTION_REPLIED_BY_PATIENT);
					break;
			case Question::QUESTION_CLOSED:
				$cnd = $question->addCondition('orquestion_status', '=',Question::QUESTION_CLOSED);
					break;
		}
	
		$rs = $question->getResultSet();
	
		return $question->recordCount();
		
	}
	public static  function getDoctorQuestionCount($type='')
	{
		
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
		}elseif($type=='answered'){			
			//$fld=$srch->addCondition('orquestion_status', '=', Question::QUESTION_REPLIED_BY_PATIENT);
			$fld=$srch->addCondition('orquestion_status', '=', Question::QUESTION_REPLIED_BY_DOCTOR);
			$fld->attachCondition('orquestion_status', '=', Question::QUESTION_CLOSED,'OR');
			$fld->attachCondition('orquestion_status', '=', Question::QUESTION_ESCLATED_TO_ADMIN,'OR');
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
		}
		
        $srch->addGroupBy('orquestion_id');
        $srch->addMultipleFields(array('orquestion_question', 'user_id', 'orquestion_id', 'CONCAT(user_first_name," " , user_last_name) as user_name', 'order_date','qassign_doctor_id','orquestion_doctor_id','orquestion_status','orquestion_last_updated','qr.reply_date'));	
		

        $srch->addFld(
           
            'orquestion_id'
           
        );
        //  $question->addCondition('reply_approved','=','1');
        $srch->addGroupBy('orquestion_id');
        $rs = $srch->getResultSet();
		$result = $srch->recordCount();
		return $result;
		
	}
	
	public function getAssignmentHistory($quetionId = 0){
		global $db;
		$srch = new SearchBase('tbl_question_status');
		$srch->joinTable('tbl_question_assign','LEFT JOIN','qstatus_question_id=qassign_question_id');
		$srch->joinTable('tbl_doctors','LEFT JOIN','qassign_doctor_id=doctor_id');
		$srch->addMultipleFields(array('CONCAT(doctor_first_name," ",doctor_last_name) as doctor_name','qassign_assigned_on'));
		$srch->addCondition('qstatus_status','=',Question::QUESTION_ASSIGNED);
		$srch->addCondition('qstatus_question_id','=',$quetionId);
		$srch->addOrder('qassign_assigned_on','desc');
		$srch->addGroupBy('qstatus_id');
		$rs = $srch->getResultSet();
		$result =  $db->fetch_all($rs);
		return $result;
	}

}
