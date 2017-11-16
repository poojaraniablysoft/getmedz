<?php

class QuestionsController extends BackendController {

	public function before_filter() {
        parent::before_filter();
       
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Questions Management", Utilities::generateUrl("questions"));
    }

    public function default_action() {
        $this->set('searchForm', $this->searchForm());
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->render();
    }

    private function searchForm() {
        $frm = new Form('searchForm', 'searchForm');
        $frm->setAction(generateUrl('questions', 'listing'));
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");
        $fld=$frm->addTextBox('Keywords', 'keyword');
        $fld->extra="placeholder='User First name,Doctor First name,Question Text'";
        $frm->addSelectBox('Status', 'orquestion_status', array(Question::QUESTION_ACCEPTED => 'Accepted Questions', Question::QUESTION_PENDING => 'Pending Questions', Question::QUESTION_REPLIED_BY_DOCTOR => 'Followup Questions', Question::QUESTION_CLOSED => 'Closed Questions'), '', '', 'All Questions');
        $frm->addTextBox('Order ID#', 'order_id');
        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Search', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'reset', 'Show All', '', 'class="cancel_search" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('searchValidator');
        $frm->setOnSubmit('return submitsearch(this, searchValidator);');
        return $frm;
    }

    public function listing() {

        $page = Syspage::getPostedVar('page');
        $post = Syspage::getPostedVar();
        $question = new Question();
        $question = $question->searchActiveQuestions();
		$question->addCondition('reply_by', '=', Question::QUESTION_REPLIED_BY_DOCTOR);
        //$question->joinTable('tbl_question_replies', 'LEFT JOIN', 'r.reply_orquestion_id=oq.orquestion_id  AND reply_by=' . Question::QUESTION_REPLIED_BY_DOCTOR, 'r');
        // $question->joinTable('tbl_doctors', 'LEFT JOIN', 'd.doctor_id=oq.orquestion_doctor_id  AND reply_by=' . Question::QUESTION_REPLIED_BY_DOCTOR, 'dr');

        $question->addMultipleFields(array(
            'CONCAT_WS(" ",user_first_name,user_last_name) as customer_name',
            'order_date',
            'orquestion_question',
            'orquestion_id',
            'orquestion_reply_status',
            'reply_text',
            'count(reply_id) as count_replies',
            'user_id',
            'reply_approved',
            'order_id',
            'reply_id'
        ));

        $question->addGroupBy('orquestion_id');
        $question->addOrder('orquestion_id', 'DESC');
        //Searching Critreia

        if (!empty($post['keyword'])) {
            $cnd = $question->addCondition('doctor_first_name', 'like', $post['keyword'] . "%",'AND');
            $cnd->attachCondition('orquestion_question', 'like', $post['keyword'] . "%",'OR');
  
            $cnd->attachCondition('user_first_name', 'like', $post['keyword'] . "%",'OR');
        }
        if (!empty($post['order_id'])) {
            $cnd = $question->addCondition('order_id', '=', $post['order_id'],'AND');
        }
        if (isset($post['orquestion_status'])) {
            $cnd = $question->addCondition('orquestion_status', '=', intval($post['orquestion_status']),'AND');
        }
		
        $this->paginate($question, $page, generateUrl('questions', 'listing'));
        $user_id = Admin::getLoggedinUserId();

        $this->render();
    }

    function change_listing_status() {

        $user_id = Admin::getLoggedinUserId();


        $db = Syspage::getdb();
        $post = Syspage::getPostedVar();
        $orquestion_id = intval($post['orquestion_id']);
        $status = intval($post['mode']);


        if ($orquestion_id < 1) {
            Message::addErrorMessage('Invalid ID');
            dieJsonError(Message::getHtml());
        }
		if($status==1){
			$replied_at=date("Y-m-d h:i:s");
		}
        /* Update Winner */
        if (!$db->update_from_array('tbl_order_questions', array('orquestion_reply_status' => $status,'orquestion_replied_at'=>$replied_at), array('smt' => 'orquestion_id = ?', 'vals' => array($orquestion_id)), '', '', '', 1)) {
            Message::addErrorMessage($db->getError());
            dieJsonError(Message::getHtml());
        }


        Message::addMessage('Reply status changed successfully.');
        dieJsonSuccess(Message::getHtml());
    }

    /*
     * View Function 
     * @param Int Question id
     */

    function view($orquestion_id = 0) {
        $orquestion_id = intval($orquestion_id);

        if ($orquestion_id < 1) {
            redirectUser(generateUrl('questions'));
        }
        global $db;
        $post = Syspage::getPostedVar();
        $question = new Question();

        $srch = $question->searchQuestions();
        $srch->addCondition('orquestion_id', '=', $orquestion_id);
        $srch->addMultipleFields(array('orquestion_reply_status', 'orquestion_id', 'order_user_id', 'orquestion_question', 'orquestion_doctor_id', 'orquestion_med_history', 'orquestion_seen_doctor', 'order_date', 'CONCAT(user_first_name," " , user_last_name) as user_name', 'orquestion_age', 'orquestion_gender', 'user_added_on', 'user_email', 'user_id','COUNT(file_id) as have_file'));
        $srch->addGroupBy('orquestion_id');

        $rs = $srch->getResultSet();
        $arr_question = $db->fetch($rs);
        $this->set('arr_question', $arr_question);

        if ($arr_question['orquestion_doctor_id'] > 0) {
            $srch = $question->getReplies();
            $srch->joinTable('tbl_files', 'LEFT JOIN', 'file_record_id=reply_id  AND file_record_type=' . Files::QUESTION_ATTACHMENT);
            $srch->addCondition('reply_orquestion_id', '=', $orquestion_id);
            //$srch->addCondition('file_record_type','=',QUESTION::REPLY_TYPE);
            $srch->addFld(array('r.*', '(CASE WHEN '
                . 'reply_by=' . Question::QUESTION_REPLIED_BY_DOCTOR . '
                      THEN CONCAT_WS(" ",doctor_first_name,doctor_last_name) ELSE CONCAT_WS(" ",user_first_name,user_last_name) END) as replier_name', 'count(file_record_id) as attachments')
            );
            $srch->addGroupBy('reply_id');
            $rs = $srch->getResultSet();

            $replies = $db->fetch_all($rs);

            $this->set('replies', $replies);
        }
		$this->b_crumb->add("Question", Utilities::generateUrl("questions", "view"));
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->_template->render();
    }

}
