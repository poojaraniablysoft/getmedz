<?php

class CustomerController extends FrontController {

    public function before_filter() {

        parent::before_filter();

        if (!Members::isCustomerLogged()) {
            redirectUser(generateUrl('members', 'login'));
        }

        Syspage::addCss(
                array(
            'css/ionicons.css',
            'css/customer-style.css'
                ), true);

        $customer_id = Members::getLoggedUserID();
        $member = new Members();
        $customerData = $member->getCustomerData($customer_id);
        $this->set('customerName', $customerData['user_first_name'] . " " . $customerData['user_last_name']);
    }

    public function default_action() {
        $this->set('searchForm', $this->searchForm());
        $this->render();
    }

    public function listing() {

        $page = Syspage::getPostedVar('page');
        $post = Syspage::getPostedVar();

        $user_id = Members::getLoggedUserID();
        $question = new Question();
        $question = $question->searchQuestions();
        $question->joinTable('tbl_question_replies', 'LEFT JOIN', 'r.reply_orquestion_id=oq.orquestion_id  AND reply_by=' . Question::QUESTION_REPLIED_BY_DOCTOR, 'r');
        // $question->joinTable('tbl_doctors', 'LEFT JOIN', 'd.doctor_id=oq.orquestion_doctor_id  AND reply_by=' . Question::QUESTION_REPLIED_BY_DOCTOR, 'dw');

        $question->addMultipleFields(array(
            'CONCAT_WS(" ",user_first_name,user_last_name) as customer_name',
            'order_date',
            'orquestion_question',
            'orquestion_id',
            'reply_text',
            'count(reply_id) as count_replies',
            'user_id',
            'reply_approved',
            'order_id',
            'reply_id',
            'orquestion_status',
            'doctor_id',
            'CONCAT_WS(" ",doctor_first_name,doctor_last_name) as doctor_name',
            '(CASE WHEN doctor_is_online=1 AND DATE_SUB(NOW(),INTERVAL 10 MINUTE)< doctor_last_activity THEN 1 ELSE 0 END) as doctor_online'
        ));
        //  $question->addCondition('reply_approved','=','1');
        $question->addGroupBy('orquestion_id');
        $question->addOrder('orquestion_id', 'DESC');
        //Searching Critreia
        $question->addCondition('order_user_id', '=', $user_id);

        if (isset($post['orquestion_status'])) {
            $cnd = $question->addCondition('orquestion_status', '=', $post['orquestion_status']);
        }




        $this->paginate($question, $page, generateUrl('customer', 'listing'));


        $this->render();
    }

    private function searchForm() {
        $frm = new Form('searchForm', 'searchForm');
        $frm->setAction(generateUrl('customer', 'listing'));
        $frm->setExtra("class='table_form' onChange='submitsearch()'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");

        $frm->addSelectBox('Status', 'orquestion_status', array(Question::QUESTION_ACCEPTED => 'My Accepted Questions', Question::QUESTION_PENDING => 'My Pending Questions', Question::QUESTION_REPLIED_BY_DOCTOR => 'Followup Questions', Question::QUESTION_CLOSED => 'My Closed Questions'));

        $frm->addSelectBox('Sort By', 'sort_by', array(1 => 'Order By OrderId(ASC)'), '', '', 'Recent Questions');
        $frm->addSelectBox('Filter By', 'filter_by', array("WEEK" => '1 Week', "MONTH" => '1 Month', "SEMESTER" => '6 months'), '', '', 'All');
        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Search', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'reset', 'Show All', '', 'class="cancel_search" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('searchValidator');
        $frm->setOnSubmit('return submitsearch(this, searchValidator);');
        return $frm;
    }

    public function question($orquestion_id) {

        global $db;
        if (!Members::isUserLogged()) {
            redirectUser(generateUrl('members', 'login'));
        }
        Syspage::addCss(array(
            "css$selected_css_folder/jquery.rating.css"
        ));
        Syspage::addJs(array(
            /*   'js/jquery.jqEasyCharCounter.min.js', /* JS for character counting */
            'js/jquery.rating.pack.js',
            'js/jquery.rating.js'
        ));
        $post = Syspage::getPostedVar();
        $question = new Question();

        $orquestion_id = intval($orquestion_id);
        if (intval($orquestion_id) <= 0)
            die('Invalid Input');
        $srch = $question->searchQuestions();
        $srch->addCondition('orquestion_id', '=', $orquestion_id);

        $logged_user_type = Members::getLoggedUserAttribute('user_type');
        $user_id = Members::getLoggedUserID();
        if ($logged_user_type == Members::CUSTOMER_USER_TYPE) {
            $srch->addCondition('order_user_id', '=', $user_id);
        } else {
            die('Invalid Access');
        }



        $srch->addMultipleFields(array('orquestion_status', 'orquestion_id', 'order_user_id', 'order_id', 'orquestion_question', 'orquestion_doctor_id', 'orquestion_med_history', 'orquestion_seen_doctor', 'order_date', 'CONCAT(user_first_name," " , user_last_name) as user_name', 'orquestion_age', 'orquestion_gender', 'user_added_on', 'user_added_on', 'user_email', 'user_id', 'COUNT(file_id) as have_file'));
        $srch->addGroupBy('orquestion_id');
        $rs = $srch->getResultSet();
        $arr_question = $db->fetch($rs);
        $this->set('arr_question', $arr_question);
        $doctor_id = Members::getLoggedUserID();
        if ($arr_question['orquestion_doctor_id'] > 0) {
            $srch = $question->getReplies();
            $srch->joinTable('tbl_files', 'LEFT JOIN', 'file_record_id=reply_id  AND file_record_type=' . Files::QUESTION_ATTACHMENT);
            $srch->addCondition('reply_orquestion_id', '=', $orquestion_id);
            //$srch->addCondition('file_record_type','=',QUESTION::REPLY_TYPE);
            $srch->addFld(array('r.*', 'order_user_id', '(CASE WHEN '
                . 'reply_by=' . Question::QUESTION_REPLIED_BY_DOCTOR . '
                      THEN CONCAT_WS(" ",doctor_first_name,doctor_last_name) ELSE CONCAT_WS(" ",user_first_name,user_last_name) END) as replier_name', 'count(file_record_id) as attachments')
            );
            $srch->addGroupBy('reply_id');
            $rs = $srch->getResultSet();

            $replies = $db->fetch_all($rs);

            $this->set('replies', $replies);
            $replyFrm = $this->getReplyFrm($orquestion_id);
            $this->set('replyFrm', $replyFrm);
            $data['reply_orquestion_id'] = $orquestion_id;
            $replyFrm->fill($data);
            $upFrm = $this->getFileUploadForm();
            $upFrm->addHiddenField("action", "action", "upload_file");
            $this->set('upFrm', $upFrm);
        }
        $review_data['review_doctor_id'] = $arr_question['orquestion_doctor_id'];
        $review_data['review_order_id'] = $arr_question['order_id'];
        $review_frm = $this->getReviewForm();
        $review_frm->fill($review_data);
        $this->set('review_frm', $review_frm);
        $this->_template->render();
    }

    function getReplyFrm($orquestion_id) {
        if ($orquestion_id < 1)
            redirectUser(generateUrl('customer', ''));
        $frm = new Form('frmReplyForm', 'frmReplyForm');
        $frm->setExtra(' class="table_form" method=post');
        $frm->addHiddenField('', 'reply_orquestion_id')->requirements()->setRequired();
        $frm->addHiddenField('', 'uploaded_files_id', '', 'uploaded_files_id');
        $fld = $frm->addTextArea('Reply', 'reply_text', '', 'reply_text');
        $fld->requirements()->setRequired();
        $frm->setAction(generateUrl('customer', 'setup_reply'));
        $frm->addButton("", "add_attachment", "Add Attachment", "add_attachment", 'class="up-btn filelabel"');
        $frm->addButton("", "close_question", "Close Your Question", "close_question", 'class="up-btn filelabel" onclick="updateQuestionStatus(' . $orquestion_id . ',' . Question::QUESTION_CLOSED . ')"');
        $frm->addSubmitButton('', 'btn_reply', 'Reply', 'btn_reply', '');
        $frm->setValidatorJsObjectName('cmsValidator');
        $frm->setOnSubmit('submitForm(this, cmsValidator); return false;');
        return $frm;
    }

    function getFileUploadForm() {
        $frm = new Form('uploadFileForm', 'uploadFileForm');
        $frm->setAction(generateUrl('doctor', 'setup_file'));
        $frm->setExtra('class="siteForm" style="display:none"');
        $frm->addFileUpload("", "fileupload", "fileupload")->requirements()->setRequired();
        return $frm;
    }

    function setup_reply() {
        $post = Syspage::getPostedVar();
        global $db;
        $frm = $this->getReplyFrm();
        $orquestion_id = intval($post['reply_orquestion_id']);
        $this->Question = new Question();
        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('doctor', 'question', array($post['reply_orquestion_id'])));
        }

        $post = Syspage::getPostedVar();
        $post['reply_by'] = Members::getLoggedUserAttribute('user_type');
        if ($post['reply_by'] == Members::DOCTOR_USER_TYPE) {

            $srch = $this->Question->searchQuestions();
            $srch->addDirectCondition('( orquestion_doctor_id="' . Members::getLoggedUserID() . '" OR  orquestion_doctor_id=0)');

            $srch->addCondition('orquestion_id', '=', $orquestion_id);
            $srch->addMultipleFields(array('orquestion_question', 'orquestion_id', 'CONCAT(user_first_name," " , user_last_name) as user_name', 'order_date'));

            $rs = $srch->getResultSet();
            $total_record = $srch->recordCount();
            if ($total_record < 1) {
                Message::addErrorMessage("Invalid Access");
                die(convertToJson(array('status' => 0, 'msg' => Message::getHtml(), 'response' => $response)));
            }
            $post2['orquestion_status'] = Question::QUESTION_REPLIED_BY_DOCTOR;

            $post['reply_by'] = Question::QUESTION_REPLIED_BY_DOCTOR;
        } else {
            $srch = $this->Question->searchQuestions();
            $srch->addCondition('orquestion_id', '=', $orquestion_id);
            $srch->addCondition('order_user_id', '=', Members::getLoggedUserAttribute('user_id'));
            $srch->addMultipleFields(array('orquestion_question', 'orquestion_id', 'CONCAT(user_first_name," " , user_last_name) as user_name', 'order_date'));
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

        if ($reply_id = $this->Question->setUpReply($data)) {
            $post2['orquestion_id'] = $orquestion_id;
            //Update Order Status
            $this->Question->updateOrderStatus($post2);

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
            $this->userReplyEmail($reply_id);
            $srch = $this->Question->getReplies();
            $srch->joinTable('tbl_files', 'LEFT JOIN', 'file_record_id=reply_id  AND file_record_type=' . Files::QUESTION_ATTACHMENT);
            $srch->addCondition('reply_orquestion_id', '=', $orquestion_id);
            $srch->addOrder('reply_id', 'DESC');
            $srch->addFld(array('r.*', '(CASE WHEN '
                . 'reply_by=' . Question::QUESTION_REPLIED_BY_DOCTOR . '
                      THEN CONCAT_WS(" ",doctor_first_name,doctor_last_name) ELSE CONCAT_WS(" ",user_first_name,user_last_name) END) as replier_name',
                'order_date', 'count(file_record_id) as attachments')
            );
            $srch->addGroupBy('reply_id');
            $rs = $srch->getResultSet();
            $arr_question = $db->fetch($rs);

            $this->set('reply', $arr_question);
            $response = $this->_template->render(false, false, 'doctor/getReply.php', true);
            Message::addMessage("Your reply is successfully saved.");
            die(convertToJson(array('status' => 1, 'msg' => Message::getHtml(), 'response' => $response)));
        } else {

            Message::addErrorMessage("We are unable to process the data, Please try after some time");
            dieJsonError(Message::getHtml());
        }
    }

    public function userReplyEmail($reply_id) {
        //Send email
        $Email = new Emails();
        $Email->replies = array($reply_id);
        $Email->patientReplyEmail();
    }

    function giveRating() {
        $review_frm = $this->getReviewForm($review_doctor_id);
        $this->set('review_frm', $review_frm);
        $this->_template->render(false, false);
    }

    function getReviewForm() {
        $frm = new Form('frmReviews', 'frmReviews');

        //$frm->captionInSameCell(true);
        $frm->setTableProperties(' width="100%" cellspacing="0" cellpadding="0" border="0" class="cellborder"');
        $frm->setExtra(' class="web_form"');

        $frm->addHTML('Rate Your Doctor', 'review_rating', createStarRating('review_rating'));
        $fld = $frm->addTextArea('Your Review', 'review_text', '', 'review_text');
        //$fld->requirements()->setLength(100,1000);
        $fld->requirements()->setRequired();


        $frm->addHiddenField('', 'review_doctor_id');
        $frm->addHiddenField('', 'review_order_id');
        //$frm->setAction(generateUrl('carlisting', 'review_setup'));
        $frm->setValidatorJsObjectName('reviewValidator');
        $frm->setOnSubmit('submitReviewSetup(this, reviewValidator); return(false);');
        $frm->addSubmitButton('', 'btn_submit', 'Submit', 'btn_submit', '');

        return $frm;
    }

    /** Edit Profile *** */
    function profile() {

        $user_id = Members::getLoggedUserID();

        //Check if doctor exist
        $srch = Customer::searchCustomer();
        $srch->addMultipleFields(array('*'));
        $srch->addCondition('user_id', '=', $user_id);
        $user_data = $srch->fetch();

        if (intval($user_data['user_id']) < 1) {
            die("Invalid Request");
        }

        $this->set('frm', $this->form());
        $this->set('user_data', $srch->fetch());

        $this->_template->render();
    }

    function edit_profile() {

        $post = Syspage::getPostedVar();

        $removeFields = array('user_deleted' => 1, 'user_active' => 2, 'btn_submit' => 3, 'user_email' => 4);
        $filteredFields = array_diff_key($post, $removeFields);
        $frm = $this->form();
        $user_id = Members::getLoggedUserID();

        //Check if doctor exist
        $srch = Customer::searchCustomer();
        $srch->addMultipleFields(array('*'));
        $srch->addCondition('user_id', '=', $user_id);
        $user_data = $srch->fetch();

        if (intval($user_data['user_id']) < 1) {
            die("Invalid Request");
        }

        //validate The form
        if (!$frm->validate($filteredFields)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('customer', 'profile'));
        }
        $filteredFields = array_merge($filteredFields, array('user_id' => $user_id));
        $user = new Users();

        if (!$user->setupUser($filteredFields)) {

            Message::addErrorMessage("Error While saving the profile.Please try after some time");
        }
        Message::getHtml();
        Message::addMessage("Profile is updated successfully.");

        redirectUser(generateUrl('customer', 'profile'));
    }

    private function getform() {
        $frm = new Form('FrmStates');
        $frm->setAction(generateUrl('customer', 'edit_profile'));
        $frm->setExtra("class='web_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setFieldsPerRow(2);
        $frm->setTableProperties("class='table_form_vertical'");


        $frm->addHiddenField('', 'user_id', '', 'user_id');
        $frm->addRequiredField('First Name', 'user_first_name')->requirements()->setRequired();
        $frm->addRequiredField('Last Name', 'user_last_name')->requirements()->setRequired();
        $fld = $frm->addEmailField('Email', 'user_email', '', 'doctor_email', 'readonly');
        $fld->requirements()->setRequired(false);
        $frm->addRadioButtons('User Gender', 'user_gender', Applicationconstants::$arr_gender)->requirements()->setRequired();
        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Update', 'btn_submit', 'style="cursor:pointer;"');
        //   $fld2 = $frm->addButton('', 'cancel', 'Cancel', '', 'class="cancel_form reset_button" style="margin-left:10px; cursor:pointer;"');
        //  $fld1->attachField($fld2);
        //$fld1->merge_cells=2;

        return $frm;
    }

    public function form() {

        Syspage::addJs(
                array(
            'css/ionicons.css',
            'css/style.css'
                ), true);
        $user_id = Members::getLoggedUserID();
        $frm = $this->getform();
        if (intval($user_id) > 0) {


            $srch = Customer::searchCustomer();
            $srch->addCondition('user_id', "=", $user_id);
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
        $frm->setExtra(' class="web_form"');
        $frm->setTableProperties("class='edit_form' width='100%'");
        $frm->addPasswordField('Current Password:', 'current_password')->requirements()->setRequired();
        $fld = $frm->addPasswordField('New Password:', 'new_password');
        $fld->requirements()->setLength(6, 20);
        $fld->requirements()->setRequired();
        $fld1 = $frm->addPasswordField('Confirm New Password:', 'new_password1');
        $fld1->requirements()->setLength(6, 20);
        $fld1->requirements()->setCompareWith('new_password', 'eq', 'New Password');

        $frm->addSubmitButton('', 'btn_submit', 'Submit', 'btn_submit'/* , 'class="inputbuttons"' */);
        $frm->setAction(generateUrl('customer', 'changepasswordsetup'));
        return $frm;
    }

    function changepassword() {
        $user_id = Members::getLoggedUserID();

        $srch = Customer::searchCustomer();
        $srch->addCondition('user_id', "=", $user_id);
        $data = $srch->fetch();


        if (intval($data['user_id']) < 1) {
            die("Invalid Request");
        }

        $this->set('user_data', $data);
        $this->set('frm', $this->changepasswordform());
        $this->_template->render();
    }

    public function changepasswordsetup() {
        $user_id = Members::getLoggedUserID();

        $srch = Customer::searchCustomer();
        $srch->addMultipleFields(array('*'));
        $srch->addCondition('user_id', '=', $user_id);
        $user_data = $srch->fetch();

        if (intval($user_data['user_id']) < 1) {
            die("Invalid Request");
        }
        $frm = $this->getform();
        $post = Syspage::getPostedVar();
        //validate The form

        if ($user_data['doctor_password'] !== encryptPassword($post['current_password'])) {
            Message::addErrorMessage("Current password is not correct.");
            redirectUser(generateUrl('customer', 'changepassword'));
        }

        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('customer', 'changepassword'));
        }



        $newPass = encryptPassword($post['new_password']);
        $data = array('user_password' => $newPass, 'user_id' => $user_id);
        $user = new Users();

        if (!$user->setupUser($data)) {

            Message::addErrorMessage("Error While changing the password.Please try after some time");
        }

        Message::addMessage("Password is updated successfully.");

        redirectUser(generateUrl('customer', 'changepassword'));
    }

    /*     * ***********Upload profile image******** */

    function profile_pic() {
        $post = Syspage::getPostedVar();
        $user_id = Members::getLoggedUserID();


        $srch = Customer::searchCustomer();
        $srch->addCondition('user_id', '=', $user_id);
        $user_data = $srch->fetch();

        if (intval($user_data['user_id']) < 1) {
            die("Invalid Request");
        }


        $response = "";

        if ($_FILES['fileupload']['name'] != "" && $_FILES['fileupload']['error'] == 0) {
            $isUpload = uploadContributionFile($_FILES['fileupload']['tmp_name'], $_FILES['fileupload']['name'], $response, "customer_profile/");

            if ($isUpload) {
                $fls = new Files();

                //Check if previous file

                $record = $fls->getFile($user_id, Files::USER_PROFILE);
                if (intval($record['file_id']) > 0) {
                    $dat['file_id'] = $record['file_id'];
                    $filepath = $record['file_path'];
                }

                $dat['file_record_type'] = Files::USER_PROFILE;
                $dat['file_record_id'] = $user_id;
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

        redirectUser(generateUrl('customer', 'profile'));
    }

    function review_setup() {
        $db = Syspage::getdb();
        $post = Syspage::getPostedVar();
        if (!Members::isUserLogged()) {
            dieJsonError('You need to be logged in to perform this action.');
        }
        if (!Permission::canCustomerAddReview()) {
            dieJsonError('Invalid Access');
        }
        $user_id = Members::getLoggedUserAttribute('user_id');


        $review_doctor_id = intval($post['review_doctor_id']);
        $review_order_id = $post['review_order_id'];
        /* Invalid request */
        if ($review_doctor_id < 1 || $review_order_id == '') {
            dieJsonError('Invalid request');
        }

        /* Check if user already posted review on this car variant, only 1 review allowed per variant as discussed */
        $this->customer = new customer();
        $srch = $this->customer->search_reviews();
        $srch->addCondition('review_user_id', '=', intval($user_id));
        $srch->addCondition('review_doctor_id', '=', intval($review_doctor_id));
        $srch->addCondition('review_order_id', '=', $review_order_id);
        $rs = $srch->getResultSet();
        if ($review_row = $db->fetch($rs)) {
            $review_id = $review_row['review_id'];
        }


        /* Validate Form */
        $frm = $this->getReviewForm($review_doctor_id);
        if (!$frm->validate($post)) {
            dieJsonError($frm->getValidationErrors());
        }

        $data = $post;

        /* Validate Star Rating Values - All Mandatory */

        if (intval($post['review_rating']) < 1) {
            dieJsonError('Please add rating for doctor');
        }


        unset($data['btn_submit']);
        if (!$review_id = $this->customer->addReviews($data)) {
            dieJsonError($this->customer->getError());
        } else {
            $this->userReviewEmail($review_id);
            die(convertToJson(array('status' => 1, 'msg' => 'Your Review has been Submitted.')));
        }
    }

    public function userReviewEmail($reply_id) {
        //Send email
        $Email = new Emails();
        $Email->replies = array($reply_id);
        $Email->doctorReplyEmail();
    }

    public function doc_profile($orquestion_id) {
        global $db;


        Syspage::addCss(array(
            "css$selected_css_folder/jquery.rating.css"
        ));
        Syspage::addJs(array(
            /*   'js/jquery.jqEasyCharCounter.min.js', /* JS for character counting */
            'js/jquery.rating.pack.js',
            'js/jquery.rating.js'
        ));

        $post = Syspage::getPostedVar();

        $question = new Question();

        $orquestion_id = intval($orquestion_id);
        if (intval($orquestion_id) <= 0)
            die('Invalid Input');

        $srch = $question->searchQuestions();
        $srch->joinTable('tbl_question_replies', 'LEFT JOIN', 'r.reply_orquestion_id=oq.orquestion_id  AND reply_by=' . Question::QUESTION_REPLIED_BY_DOCTOR, 'r');
        $srch->joinTable('tbl_doctor_reviews', 'LEFT JOIN', 'review_doctor_id=doctor_id', 'rev');
        $srch->addCondition('orquestion_id', '=', $orquestion_id);

        $logged_user_type = Members::getLoggedUserAttribute('user_type');
        $user_id = Members::getLoggedUserID();
        if ($logged_user_type == Members::CUSTOMER_USER_TYPE) {
            $srch->addCondition('order_user_id', '=', $user_id);
        } else {
            die('Invalid Access');
        }



        $srch->addMultipleFields(array(
            'CONCAT_WS(" ",user_first_name,user_last_name) as customer_name',
            'order_date',
            'orquestion_question',
            'orquestion_id',
            'reply_text',
            'count(reply_id) as count_replies',
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
        $srch->addGroupBy('orquestion_id');
        $srch->addOrder('orquestion_id', 'DESC');
        //Searching Critreia


        $this->set('question', $srch->fetch());



        $srch = $question->getReplies();
        $srch->joinTable('tbl_files', 'LEFT JOIN', 'file_record_id=reply_id  AND file_record_type=' . Files::QUESTION_ATTACHMENT);
        $srch->addCondition('reply_orquestion_id', '=', $orquestion_id);
        //$srch->addCondition('file_record_type','=',QUESTION::REPLY_TYPE);
        $srch->addFld(array('r.*', 'order_user_id', 'count(file_record_id) as attachments', 'CONCAT_WS(" ",doctor_first_name,doctor_last_name) as doctor_name', 'CONCAT_WS(" ",user_first_name,user_last_name) as customer_name', 'user_id', 'doctor_id', '(CASE WHEN doctor_is_online=1 AND DATE_SUB(NOW(),INTERVAL 10 MINUTE)< doctor_last_activity THEN 1 ELSE 0 END) as doctor_online')
        );
        $srch->addGroupBy('reply_id');
        $rs = $srch->getResultSet();

        $replies = $db->fetch_all($rs);

        $this->set('replies', $replies);

        $replyFrm = $this->getReplyFrm($orquestion_id);
        $this->set('replyFrm', $replyFrm);
        $data['reply_orquestion_id'] = $orquestion_id;
        $replyFrm->fill($data);
        // printR($replies);
        // exit();

        $this->_template->render();
    }

}
