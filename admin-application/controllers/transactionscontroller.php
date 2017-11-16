<?php

class TransactionsController extends BackendController {

    public function before_filter() {
        parent::before_filter();
        $this->Transactions = new Transactions();
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Transaction Management", Utilities::generateUrl("transactions"));
    }

    public function default_action() {
        $this->set('searchForm', $this->searchForm());
        $this->set('breadcrumb', $this->b_crumb->output());
        $this->render();
    }

    public function listing() {

        $page = Syspage::getPostedVar('page');
        $post = Syspage::getPostedVar();

        $srch = $this->Transactions->searchTrans();
        $srch->addCondition('tran_payment_mode','<>',1);
        //Searching T
		$srch->addOrder('tran_id','desc');
        if (!empty($post['order_id'])) {
            $srch->addCondition('order_id', '=', $post['order_id']);
        }

        if (!empty($post['user_email'])) {
            $srch->addCondition('user_email', 'like', $post['user_email'] . "%");
        }
        $this->paginate($srch, $page, generateUrl('transactions', 'listing'));
        $user_id = Admin::getLoggedinUserId();
        $this->set('canAddSubscription', Permission::canAddSubscription($user_id));
        $this->set('canEditSubscription', Permission::canEditSubscription($user_id));
        $this->set('canDeleteSubscription', Permission::canDeleteSubscription($user_id));
        $this->render();
    }

    private function searchForm() {
        $frm = new Form('searchForm', 'searchForm');
        $frm->setAction(generateUrl('transactions', 'listing'));
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addTextBox('Order ID#', 'order_id');
        $frm->addTextBox('User Email', 'user_email');
        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Search', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'reset', 'Show All', '', 'class="cancel_search" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('searchValidator');
        $frm->setOnSubmit('return submitsearch(this, searchValidator);');
        return $frm;
    }

    private function getform() {
        $frm = new Form('FrmSubscriptions');
        $frm->setAction(generateUrl('transactions', 'setup'));
        $frm->setExtra("class='web_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addHiddenField('', 'tran_id');
        $frm->addHiddenField('', 'user_id');
        $frm->addRequiredField('Amount', 'tran_amount');
        $frm->addTextBox('Admin Comments', 'tran_admin_comments');
        $frm->addTextArea('Response Data', 'tran_gateway_response_data');
        $frm->addSelectBox('Status', 'tran_completed', Applicationconstants::$arr_status)->requirements()->setRequired();

        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Submit', 'btn_submit', 'style="cursor:pointer;"');
       $fld2 = $frm->addButton('', 'cancel', 'Cancel', '', 'class="cancel_form2 reset_button" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('SubscriptionValidator');
        $frm->setOnSubmit('submitsetup(this, SubscriptionValidator);');
        return $frm;
    }

    public function form() {
        $user_id = Admin::getLoggedinUserId();
        $id = Syspage::getPostedVar('id');
        $frm = $this->getform();
        if (intval($id) > 0) {

            if (!Permission::canEditSubscription($user_id, $id)) {
                $this->notAuthorized();
            }

            $srch = $this->Transactions->searchTrans($id);
            $srch->addCondition('tran_id', '=', $id);
            $data = $srch->fetch();

            $frm->fill($data);

            if (!$data)
                dieWithError('Invalid Request');
        }else {
            if (!Permission::canAddSubscription($user_id)) {
                $this->notAuthorized();
            }
        }

        $this->set('frm', $frm);
        $this->render();
    }

    public function setup() {
        $user_id = Admin::getLoggedinUserId();
        $post = Syspage::getPostedVar();

        if (intval($post['tran_id']) > 0) {
            if (!Permission::canEditSubscription($user_id, $post['subs_id'])) {
                $this->notAuthorized();
            }
        } else {
            if (!Permission::canAddSubscription($user_id)) {
                $this->notAuthorized();
            }
        }

        $frm = $this->getForm();
        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('transactions'));
        }
        $post['tran_declined_by_admin'] = 0;
        if ($post['tran_completed'] == 0) {
            $post['tran_declined_by_admin'] = 1;
        }

        if (intval($post['user_id']) > 0 && intval($post['tran_completed'])==1) {
            $arrayToSave = array('user_id' => $post['user_id'], 'user_active' => 1);
            $user = new Users();
            if (!$user->setupUser($arrayToSave)) {
                Message::addErrorMessage($user->getError());
                redirectUser(generateUrl('transactions'));
            }
        }

        if (!$this->Transactions->updateTransactionsStatus($post)) {
            Message::addErrorMessage($this->Transactions->getError());
        }
		
		Message::addMessage('Transaction has been successfully updated');
        redirectUser(generateUrl('transactions'));
    }

}
