<?php

class QuestionController extends controller {

	 function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);

        
    }
    function setup_reply() {
        $post = Syspage::getPostedVar();
        $frm = $this->getReplyFrm();

        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('question', 'detail', array($post['reply_orquestion_id'])));
        }

        $post = Syspage::getPostedVar();
        $post['reply_by'] = Members::getLoggedUserAttribute('user_type');
        $uploaded_files = $post['uploaded_files'];
        $data = $post;
        unset($data['uploaded_files']);
        if ($reply_id = $this->Question->setUpReply($data)) {

            if ($post['uploaded_files']) {
                $files = new Files();
                foreach ($post['uploaded_files'] as $uploaded_file_id) {
                    $reply['file_record_type'] = Question::REPLY_TYPE;
                    $reply['file_record_id'] = $reply_id;
                    $reply['file_id'] = $uploaded_file_id;
                    $files->addFile($reply);
                }
            }
            Message::addMessage("Your reply has been posted successfully");
        } else {
            Message::addErrorMessage("We are unable to process the data, Please try after some time");
        }
        redirectUser(generateUrl('question', 'detail', array($post['reply_orquestion_id'])));
    }

    function setup_file() {
        if ($post['action'] == "upload_file") {
            $response = "";

            if ($_FILES['fileupload']['name'] != "" && $_FILES['fileupload']['error'] == 0) {
                $isUpload = uploadContributionFile($_FILES['fileupload']['tmp_name'], $_FILES['fileupload']['name'], $response);
                if ($isUpload) {
                    $fls = new Files();
                    $dat['file_record_type'] = Question::REPLY_TYPE;
                    $dat['file_record_id'] = '';
                    $dat['file_path'] = $response;
                    $dat['file_display_name'] = $_FILES['fileupload']['name'];
                    $dat['file_display_order'] = 0;
                    $file_id = $fls->addFile($dat);


                    dieJsonSuccess(array($dat['file_display_name'], $file_id));
                } else {
                    dieJsonError($response);
                }
            } else {
                dieJsonError("NO_FILES_UPLOADED.");
            }
            dieJsonError("NO_FILES_UPLOADED.");
        }
    }
	
	function updateQuestionStatus(){
		 $post = Syspage::getPostedVar();
		 $data= $post;
		 $data['orquestion_last_updated'] = 'mysql_func_NOW()';
		 $orquestion_id=$post['orquestion_id'];
		 if($orquestion_id<1){ dieJsonError('Invalid Input');}
		 $success=$this->Question->updateOrderStatus($data);
		
		 if($success){
			 dieJsonSuccess('Question has been successfully closed, Kindly add the rating');
		 }else{
			 dieJsonError('We are unabe to process the data, Kindly try again later');
		 }
	}
	/*All Active questions with reply*/
	function lists(){
		 $post = Syspage::getPostedVar();
		 $orquestion_med_category=$post['orquestion_med_category'];
		 if($orquestion_med_category<1){ dieJsonError('Invalid Input');}
		 $question = new Question();
			$srch = $question->searchActiveQuestions();
			$srch->joinTable('tbl_question_replies', 'LEFT JOIN', 'r.reply_orquestion_id=oq.orquestion_id', 'r');
			$srch->addCondition('orquestion_doctor_id', '=', $orquestion_doctor_id);
			$srch->addCondition('orquestion_status', '=', Question::QUESTION_REPLIED_BY_PATIENT);
			$srch->addOrder('reply_date', 'desc');
			$srch->addGroupBy('orquestion_id');
			$srch->addMultipleFields(array('orquestion_question', 'user_id', 'orquestion_id', 'CONCAT(user_first_name," " , user_last_name) as user_name', 'order_date', '(select reply_date from tbl_question_replies where reply_orquestion_id=oq.orquestion_id order by reply_id desc limit 1) as reply_date'));

			//$rs = $srch->getResultSet();
			$this->paginate($srch, $page, generateUrl('doctor', ''),1,generateUrl('doctor', 'questions'));
	}

}
