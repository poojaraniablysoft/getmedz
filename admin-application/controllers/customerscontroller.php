<?php

class CustomersController extends BackendController {

    public function before_filter() {
        parent::before_filter();
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Customers Management", Utilities::generateUrl("customers"));
    }

    public function default_action() {
        $this->set('searchForm', $this->searchForm());
        $this->set('addform', $this->getform());
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->render();
    }

    public function listing() {

        $page = Syspage::getPostedVar('page');

        $customers = Customer::searchCustomer();
        //Searching Critreia
        $customers->addMultipleFields(array('*', 'CONCAT_WS(" ",user_first_name,user_last_name) as name'));
        $post = Syspage::getPostedVar();
        if (!empty($post['keyword'])) {
            $cnd = $customers->addCondition('user_first_name', 'like', $post['keyword'] . "%");
            $cnd->attachCondition('user_email', 'like', $post['keyword'] . "%");
        }
		$customers->addOrder('user_id','desc');
        $this->paginate($customers, $page, generateUrl('customers', 'listing'));
        $user_id = Admin::getLoggedinUserId();
        $this->set('canAdd', Permission::canAddUser($user_id));
        $this->set('canEdit', Permission::canEditUser($user_id));
        $this->set('canDelete', Permission::canDeleteUser($user_id));
        $this->render();
    }

    private function searchForm() {
        $frm = new Form('searchForm', 'searchForm');
        $frm->setAction(generateUrl('customers', 'listing'));
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addTextBox('Keywords', 'keyword');

        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Search', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'reset', 'Show All', '', 'class="cancel_search" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('searchValidator');
        $frm->setOnSubmit('return submitsearch(this, searchValidator);');
        return $frm;
    }

    private function getform() {
        $frm = new Form('FrmStates');
        $frm->setAction(generateUrl('customers', 'setup'));
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setFieldsPerRow(2);
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addHiddenField('', 'user_id', '', 'user_id');
        $frm->addRequiredField('First Name', 'user_first_name')->requirements()->setRequired();
        $frm->addRequiredField('Last Name', 'user_last_name')->requirements()->setRequired();

        $fld = $frm->addEmailField('Email', 'user_email', '', 'doctor_email', 'readonly');
        $fld->requirements()->setRequired(false);

        $frm->addRadioButtons('User Gender', 'user_gender', Applicationconstants::$arr_gender,1)->requirements()->setRequired();


        $fld = $frm->addPasswordField('Password', 'user_password');
        $fld->requirements()->setRequired();
        $fld->requirements()->setLength(8, 50);

        $fld1 = $frm->addPasswordField('Confirm New Password', 'user_password1');

        $fld1->requirements()->setCompareWith('user_password');


      //  $frm->addTextBox('Emoi Link', 'user_emoi_link');
        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Submit', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'cancel', 'Cancel', '', 'class="cancel_form reset_button" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        //$fld1->merge_cells=2;
        $frm->setValidatorJsObjectName('DoctorValidator');
        $frm->setOnSubmit('submitSetup(this, DoctorValidator);');
        return $frm;
    }

    public function form() {
        $user_id = Admin::getLoggedinUserId();
        $id = Syspage::getPostedVar('id');
        $frm = $this->getform();
        if (intval($id) > 0) {
			
            if (!Permission::canEditUser($user_id, $id)) {
                $this->notAuthorized();
            }
            $frm->getField('user_password')->requirements()->setRequired(false);
            $srch = Customer::searchCustomer();
            $srch->addCondition('user_id', "=", $id);
            $data = $srch->fetch();
            $data['user_password'] = "";
            $frm->fill($data);

            if (!$data)
                dieWithError('Invalid Request');
        }else {
            if (!Permission::canAddUser($user_id)) {
                $this->notAuthorized();
            }
        }
        $this->set('frm', $frm);
        $this->render();
    }

    public function setup() {
        $user_id = Admin::getLoggedinUserId();
        $post = Syspage::getPostedVar();
        $frm = $this->getForm();
		
        if (intval($post['user_id']) > 0) {
            $frm->getField('user_password')->requirements()->setRequired(false);
            if (!Permission::canEditUser($user_id, $post['user_id'])) {
                $this->notAuthorized();
            }
        } else {
            if (!Permission::canAddUser($user_id)) {
                $this->notAuthorized();
            }
        }


        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('customers'));
        }
        unset($post['user_email']);
        if (!empty($post['user_password'])) {
            $post['user_password'] = encryptPassword($post['user_password']);
        } else {
            unset($post['user_password']);
        }
        $user = new Users();
        if (!$user->setupUser($post)) {
            Message::addErrorMessage($user->getError());
        }
            Message::addMessage("Customer information is updated successfully");
        redirectUser(generateUrl('customers'));
    }

    function delete_user($customer_id) {
        $user_id = Admin::getLoggedinUserId();
        if (!Permission::canDeleteUser($user_id, $customer_id)) {
            $this->notAuthorized();
        }
        if (is_numeric($customer_id) && intval($customer_id) > 0) {
            $data = array('user_id' => $customer_id, 'user_deleted' => Customer::DELETED_CUSTOMER);


            $user = new Users();
            if ($user->setupUser($data)) {
                Message::getHtml();
                Message::addMsg('User deleted successfully.');
            } else {
                Message::addErrorMessage($user->getError());
            }
        } else {
            Message::addErrorMessage('Invalid Request');
        }
        redirectUser(generateUrl('customers'));
    }

    function change_listing_status() {

        $user_id = Admin::getLoggedinUserId();


        $db = Syspage::getdb();
        $post = Syspage::getPostedVar();
        $customer_id = intval($post['user_id']);
        $status = intval($post['mode']);

        if (!Permission::canChangeStatusofUser($user_id, $customer_id)) {
            $this->notAuthorized();
        }

        if ($customer_id < 1) {
            Message::addErrorMessage('Invalid ID');
            dieJsonError(Message::getHtml());
        }

        /* Update Winner */
        if (!$db->update_from_array('tbl_users', array('user_active' => $status), array('smt' => 'user_id = ?', 'vals' => array($customer_id)), '', '', '', 1)) {
            Message::addErrorMessage($db->getError());
            dieJsonError(Message::getHtml());
        }


        Message::addMessage('Customer status changed successfully.');
        dieJsonSuccess(Message::getHtml());
    }

    /*
     * Customer View Page
     */

    public function view($customer_id) {

        if (intval($customer_id < 1)) {
            redirectUser(generateUrl('customers'));
        }

        $srch = Customer::searchCustomer();
        $srch->addCondition('user_id', '=', $customer_id);
        $srch->addMultipleFields(array(
            '*',
            'CONCAT_WS(" ",user_first_name,user_last_name) as name'
        ));
		$user_data = $srch->fetch();
		 $this->set('user_data',$user_data );
        //Get ALl Questions
        $customer = new Customer($customer_id);
        $questions = $customer->getCustomerQuestions();
		 $this->set('questions', $questions->fetch_all());
		$payments = $customer->getCustomerPayments($customer_id);
        $this->set('payments', $payments->fetch_all());
		 $this->b_crumb->add("Customer[".$user_data['name']."]");
      
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->_template->render();
    }
	
	
	

    /*
     * Function to create pdf of all the chat
     */
	 
	 

    public function generateChat($customer_id, $question_id) {

        $customer = new Customer($customer_id);
        $question = new question();
		$srch = $question->searchQuestions();
		$srch->addMultipleFields(array('CONCAT_WS(" ",doctor_first_name,doctor_last_name) as doctor_name','CONCAT_WS(" ",user_first_name,user_last_name) as user_name','order_date','order_id'));
		$srch->addCondition('orquestion_id','=',$question_id);
		$rs=$srch->getResultSet();
		
		$this->set('question_data', $srch->fetch());
       $rplies= $customer->getCustomerQuestionReply($question_id);
        $rplies->addFld(array('orquestion_question','r.*','order_date', '(CASE WHEN '
            . 'reply_by=' . Question::QUESTION_REPLIED_BY_DOCTOR . '
                      THEN CONCAT_WS(" ",doctor_first_name,doctor_last_name) ELSE CONCAT_WS(" ",user_first_name,user_last_name) END) as replier_name')
        );
		
	 $replies= $rplies->fetch_all();	
         if ($rplies->recordCount()==0) {
            die("Not Found");
        } 
        
        
        $this->set('replies',$replies);
        
   
       $Content=$this->_template->render(false,false,'customers/customer_chat.php',true);
        

       create_pdf('communication.pdf',$Content);
        
        
    }

}
