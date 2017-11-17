<?php

class HomeController extends BackendController {

    function default_action() {

        // Get Total Active Users
        Syspage::addCss(array(
            "../css/jquery.rating.css"
        ));
        Syspage::addJs(array(
            "../js/jquery.rating.js"
        ));
        $total_users = $this->getUsers();
        $this->set('total_users', $total_users);

        // Get Total Doctors
        $total_doctors = $this->getDoctors();
        $this->set('total_doctors', $total_doctors);

        //Total Questions posted till date
        $total_questions = $this->getQuestions();
        $this->set('total_questions', $total_questions);

        //Total Questions posted till date
        $total_earnings = $this->getTotalEarnings();
        $this->set('total_earnings', $total_earnings);

        //Total Questions Answered
        $total_question_answered = $this->getQuestionAnswered();
        $this->set('total_question_answered', $total_question_answered);

        //Total Closed Answered
        $total_closed_question = $this->getClosedQuestions();
        $this->set('total_closed_question', $total_closed_question);

        //Total Unanswered Answered
        $total_unanswered_question = $this->getUnansweredQuestion();
        $this->set('total_unanswered_question', $total_unanswered_question);

        //Average Doctor Rating
        $average_doctor_rating = $this->getAverageDoctorRating();
        $this->set('average_doctor_rating', $average_doctor_rating);

        //List of Latest Posted Questions		
        $latest_questions = $this->getLatestQuestions();

        $this->set('latest_questions', $latest_questions);

        //List of Need Approval Questions	
        if (CONF_REQUIRED_REPLY_APPROVAL) {
            $approval_questions = $this->getNeedApprovalQuestions();
            $this->set('approval_questions', $approval_questions);
        }
        $this->_template->render();
    }

    function getNeedApprovalQuestions() {
        $srch = Question::searchActiveQuestions();
        $srch->addCondition('orquestion_reply_status', '=', '0');
        $srch->joinTable('tbl_doctors', 'LEFT JOIN', 'd.doctor_id=oq.orquestion_doctor_id', 'd');
        $srch->addMultipleFields(array('orquestion_id', 'order_date', 'order_id', 'orquestion_question', 'orquestion_replied_at', 'CONCAT(user_first_name," ",user_last_name) as username', 'CONCAT(doctor_first_name," ",doctor_last_name) as doctorname', 'orquestion_status', 'orquestion_reply_status'));
        $srch->addCondition('orquestion_reply_status','=','0');
        $srch->addCondition('orquestion_status','=',Question::QUESTION_REPLIED_BY_DOCTOR);
		$srch->setPageSize(5);
        $srch->setPageNumber(1);
        $srch->addOrder('order_date', 'desc');
        $srch->addOrder('orquestion_replied_at', 'desc');

        $arr_listing = $srch->fetch_all();

        return $arr_listing;
    }

    function getLatestQuestions() {

        $srch = Question::searchActiveQuestions();
        $srch->addMultipleFields(array('orquestion_id', 'order_date', 'order_id', 'orquestion_question', 'CONCAT(user_first_name," ",user_last_name) as username'));
        $srch->addOrder('order_date', 'desc');
        $srch->setPageSize(5);
        $srch->setPageNumber(1);
        $arr_listing = $srch->fetch_all();

        return $arr_listing;
    }

    function getAverageDoctorRating() {

        global $db;
        $reviews = Review::searchReviews();

        $reviews->addMultipleFields(array('AVG(review_rating) as totalrating'));

        $rs = $reviews->getResultSet();
        $records = $db->fetch($rs);
        $total_rating = $records['totalrating'];
        return $total_rating;
    }

    function getUnansweredQuestion() {

        global $db;
        $srch = Question::searchActiveQuestions();
        $srch->addCondition('orquestion_status', '=', Question::QUESTION_PENDING, 'AND');
        $srch->addCondition('orquestion_status', '=', Question::QUESTION_ACCEPTED, 'OR');

        $rs = $srch->getResultSet();
        $records = $db->fetch($rs);
        $total_records = $srch->recordCount();
        return $total_records;
    }

    function getQuestionAnswered() {

        global $db;
        $srch = Question::searchActiveQuestions();
        $srch->addCondition('orquestion_status', '=', Question::QUESTION_REPLIED_BY_DOCTOR, 'AND');
        $srch->addCondition('orquestion_status', '=', Question::QUESTION_REPLIED_BY_PATIENT, 'OR');
        $srch->addCondition('orquestion_status', '=', Question::QUESTION_CLOSED);
        $rs = $srch->getResultSet();
        $records = $db->fetch($rs);
        $total_records = $srch->recordCount();
        return $total_records;
    }

    function getClosedQuestions() {

        global $db;
        $srch = Question::searchActiveQuestions();

        $srch->addCondition('orquestion_status', '=', Question::QUESTION_CLOSED, 'AND');
        $rs = $srch->getResultSet();
        $records = $db->fetch($rs);
        $total_records = $srch->recordCount();
        return $total_records;
    }

    function getTotalEarnings() {

        global $db;
        $srch = Transactions::searchTrans();
        $srch->addCondition('tran_completed', '=', '1');
        $srch->addMultipleFields(array('SUM(tran_amount) as total_earnings'));
        $rs = $srch->getResultSet();
        $records = $db->fetch($rs);
        $total_earnings = $records['total_earnings'];
        return $total_earnings;
    }

    function getQuestions() {

        global $db;
        $srch = Question::searchActiveQuestions();

        $rs = $srch->getResultSet();
        $total_records = $srch->recordCount();
        return $total_records;
    }

    function getDoctors() {
        global $db;
        $srch = Doctor::searchDoctor();
        $srch->addCondition('doctor_active', '=', 1);
        $rs = $srch->getResultSet();
        $total_records = $srch->recordCount();
        return $total_records;
    }

    function getUsers() {
        global $db;
        $srch = Customer::searchCustomer();
        $srch->addCondition('user_active', '=', 1);
        $rs = $srch->getResultSet();
        $total_records = $srch->recordCount();
        return $total_records;
    }

    function settings() {
        $frm = $this->getform();
        $this->set('frm', $frm);
        $this->_template->render();
    }

    function update() {
        global $db;
        global $post;

        $post['conf_date_format_jquery'] = $this->arr_date_format_jquery[$post['date_format']];
        $post['conf_date_format_mysql'] = $this->arr_date_format_mysql[$post['date_format']];
        $post['conf_date_format_php'] = $this->arr_date_format_php[$post['date_format']];

        $valid_fields = array('conf_date_format_jquery', 'conf_date_format_mysql', 'conf_date_format_php', 'conf_emails_from', 'conf_admin_email_id', 'conf_timezone',
            'conf_website_name', 'conf_contact_email_to', 'conf_contact_phone',
            'conf_website_email',
            'conf_default_admin_paging_size', 'conf_default_front_paging_size', 'conf_required_reply_approval');


        foreach ($post as $key => $val) {
            if (!in_array($key, $valid_fields))
                continue;

            $db->update_from_array('tbl_configurations', array('conf_val' => trim($val)), array('smt' => 'conf_name = ?', 'vals' => array($key)));
        }

        Message::addMessage('Settings Updated');

        redirectUser(generateUrl('configurations'));
    }

    function getform() {
        $frm = new Form('frmHomeSettings');
        $frm->setExtra(' class="web_form"');
        $frm->setJsErrorDisplay('afterfield');
        $frm->addRequiredField('You Tube Link', 'homepage_youtube_link', '', 'homepage_youtube_link', 'autocomplete="off"')->requirements()->setRequired();
        $frm->setValidatorJsObjectName('homeSettingsValidator');
        $frm->addSubmitButton('', 'btn_submit', 'Submit', '', 'class="login_btn"');
        $frm->setAction(generateUrl('admin', 'settings'));

        return $frm;
    }
	
	function createProcedure(){
		global $db;
	
		$queries = array(
			"DROP FUNCTION IF EXISTS `getTextWithoutTags`",
			"DECLARE iStart, iEnd, iLength int;
    WHILE Locate( '<', Dirty ) > 0 And Locate( '>', Dirty, Locate( '<', Dirty )) > 0 DO
      BEGIN
        SET iStart = Locate( '<', Dirty ), iEnd = Locate( '>', Dirty, Locate('<', Dirty ));
        SET iLength = ( iEnd - iStart) + 1;
        IF iLength > 0 THEN
          BEGIN
            SET Dirty = Insert( Dirty, iStart, iLength, '');
          END;
        END IF;
      END;
    END WHILE;
    RETURN Dirty;
		END",
	
		);
		
		foreach ($queries as $qry) {
			if (!$db->query($qry)) {
				die($db->error);
			}
		}
		echo 'Created All the Procedures.';
	}

}
