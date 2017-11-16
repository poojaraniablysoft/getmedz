<?php

class SubscriptionsController extends BackendController {

    public function before_filter() {
        parent::before_filter();
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Subscription Management", Utilities::generateUrl("subscriptions"));
    }

    public function default_action() {
        $this->set('searchForm', $this->searchForm());
        $this->set('addform', $this->getform());
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->render();
    }

    public function listing() {

        $page = Syspage::getPostedVar('page');
        $post=Syspage::getPostedVar();
        $subscriptions = Subscription::getAllSubscription();
        //Searching Critreia
        
        if(!empty($post['subs_name'])){  
            $subscriptions->addCondition('subs_name','like',$post['subs_name']."%");
        }
        
        
        $this->paginate($subscriptions, $page, generateUrl('subscriptions', 'listing'));
        $user_id = Admin::getLoggedinUserId();
        $this->set('canAddSubscription', Permission::canAddSubscription($user_id));
        $this->set('canEditSubscription', Permission::canEditSubscription($user_id));
        $this->set('canDeleteSubscription', Permission::canDeleteSubscription($user_id));
        $this->render();
    }

    private function searchForm() {
        $frm = new Form('searchForm','searchForm');
        $frm->setAction(generateUrl('subscriptions', 'listing'));
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addRequiredField('Subscription Name', 'subs_name')->requirements()->setRequired();
       
        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Search', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'reset', 'Show All', '', 'class="cancel_search" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('searchValidator');
        $frm->setOnSubmit('return submitSubscriptionsearch(this, searchValidator);');
        return $frm;
    }

    private function getform() {
        $frm = new Form('FrmSubscriptions');
        $frm->setAction(generateUrl('subscriptions', 'setup'));
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addHiddenField('', 'subs_id');
        $frm->addRequiredField('Subscription Name', 'subs_name');
		$frm->addTextBox('Subscription Subheading', 'subs_subheading');		
		$frm->addTextBox('Subscription Questions Allowed', 'subs_question','');		
		 $frm->addRequiredField('Subscription Price', 'subs_price');
		 $frm->addRequiredField('Subscription Presentable Price', 'subs_price_text');
		 $frm->addTextBox('Subscription Presentable Price Subheading', 'subs_price_subheading');
		 $frm->addRequiredField('Subscription Duration(In Days)', 'subs_duration');
        $frm->addSelectBox('Mark As Popular', 'subs_popular', Applicationconstants::$arr_yes_no)->requirements()->setRequired();
        $frm->addSelectBox('Status', 'subs_active', Applicationconstants::$arr_status)->requirements()->setRequired();

        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Submit', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'cancel', 'Cancel', '', 'class="cancel_form reset_button" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('SubscriptionValidator');
        $frm->setOnSubmit('submitSubscriptionsetup(this, SubscriptionValidator);');
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

            $srch = Subscription::getAllSubscription();
            $srch->addCondition('subs_id', "=", $id);
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

        if (intval($post['subs_id']) > 0) {
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
            redirectUser(generateUrl('Subscriptions'));
        }

        if (!$this->Subscriptions->setupSubscription($post)) {
            Message::addErrorMessage($this->Subscriptions->getError());
        }
        redirectUser(generateUrl('subscriptions'));
    }

    function delete_Subscription($subs_id) {
        $user_id = Admin::getLoggedinUserId();
        if (!Permission::canDeleteSubscription($user_id, $subs_id)) {
            $this->notAuthorized();
        }
        if (is_numeric($subs_id) && intval($subs_id) > 0) {
            $data = array('subs_id' => $subs_id, 'subs_deleted' => Subscription::DELETED_SUBSCRIPTION);
            if ($this->Subscriptions->setupSubscription($data)) {
                Message::getHtml();
                Message::addMsg('Subscription  deleted successfully.');
            } else {
                Message::addErrorMessage($this->Subscriptions->getError());
            }
        } else {
            Message::addErrorMessage('Invalid Request');
        }
        redirectUser(generateUrl('subscriptions'));
    }

    function change_listing_status() {

        $user_id = Admin::getLoggedinUserId();
        if (!Permission::canChangeStatusofSubscription($user_id, $subs_id)) {
            $this->notAuthorized();
        }

        $db = Syspage::getdb();
        $post = Syspage::getPostedVar();
        $subs_id = intval($post['subs_id']);
        $status = intval($post['mode']);
        if ($subs_id < 1) {
            Message::addErrorMessage('Invalid ID');
            dieJsonError(Message::getHtml());
        }

        /* Update Winner */
        if (!$db->update_from_array('tbl_subscriptions', array('subs_active' => $status), array('smt' => 'subs_id = ?', 'vals' => array($subs_id)), '', '', '', 1)) {
            Message::addErrorMessage($db->getError());
            dieJsonError(Message::getHtml());
        }


        Message::addMessage('Subscription status changed successfully.');
        dieJsonSuccess(Message::getHtml());
    }

}
