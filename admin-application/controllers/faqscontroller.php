<?php

class FaqsController extends BackendController {

    public function before_filter() {
        parent::before_filter();
		$this->faqs = new Faqs();
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Faq Category Management", Utilities::generateUrl("faqcategory"));
        $this->b_crumb->add("Faqs Management", Utilities::generateUrl("faqs"));
    }

    public function default_action() {
        $this->set('searchForm', $this->searchForm());
        $this->set('addform', $this->getform());
			$this->set('breadcrumb', $this->b_crumb->output());
        $this->render();
    }

    public function listing() {

        $page = Syspage::getPostedVar('page');
        $faqs = Faq::getAllfaqs();
        $post=Syspage::getPostedVar();
        if(!empty($post['keyword'])){  
            $cnd=$faqs->addCondition('faq_question','like',$post['keyword']."%");
         
        } 
        if(intval($post['faq_category_id'])>0){  
            $faqs->addCondition('faq_category_id','=',$post['faq_category_id']);
        }      
        $this->paginate($faqs, $page, generateUrl('faqs', 'listing'));
        $user_id = Admin::getLoggedinUserId();
        $this->set('canAddFaqs', Permission::canAddFaqs($user_id));
        $this->set('canEditFaqs', Permission::canEditFaqs($user_id));
        $this->set('canDeleteFaqs', Permission::canDeleteFaqs($user_id));
        $this->render();
    }
    private function searchForm() {
        $frm = new Form('searchForm','searchForm');
        $frm->setAction(generateUrl('doctors', 'listing'));
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addTextBox('Keywords', 'keyword');
		Faqcat::getActiveFaqCategory()->fetch_all_assoc();
        $frm->addSelectBox('Catgeory', 'faq_category_id', Faqcat::getActiveFaqCategory()->fetch_all_assoc());
        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Search', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'reset', 'Show All', '', 'class="cancel_search" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('searchValidator');
        $frm->setOnSubmit('return submitsearch(this, searchValidator);');
        return $frm;
    }
    private function getform() {
        $frm = new Form('Frmfaqs');
        $frm->setAction(generateUrl('faqs', 'setup'));
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addHiddenField('', 'faq_id');
        $frm->addRequiredField('Faq Name', 'faq_question')->requirements()->setRequired();
        $frm->addHtmlEditor('Faq Answer', 'faq_answer');
        $frm->addSelectBox('Catgeory', 'faq_category_id', Faqcat::getAllFaqCategory()->fetch_all_assoc())->requirements()->setRequired();
        
		$frm->addIntegerField('FAQ Display order ', 'faq_display_order')->requirements()->setRequired();
        $frm->addSelectBox('Status', 'faq_active', Applicationconstants::$arr_status)->requirements()->setRequired();

        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Submit', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'cancel', 'Cancel', '', 'class="cancel_form reset_button" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('faqsValidator');
		$frm->setTableProperties('width="100%" border="0" cellspacing="0" cellpadding="0" class="table_formsingle"');
		$frm->setLeftColumnProperties('class="td_form_horizontal"');
        $frm->setOnSubmit('submitfaqsSetup(this, faqsValidator);');
        return $frm;
    }

    public function form($id) {
        $user_id = Admin::getLoggedinUserId();
      
        $frm = $this->getform();
        if (intval($id) > 0) {

            if (!Permission::canEditFaqs($user_id, $id)) {
                $this->notAuthorized();
            }

            $srch = Faq::getAllFaqs();
            $srch->addCondition('faq_id', "=", $id);
            $data = $srch->fetch();
			
            $frm->fill($data);

            if (!$data)
                dieWithError('Invalid Request');
        }else {
            if (!Permission::canAddFaqs($user_id)) {
                $this->notAuthorized();
            }
        }
		 if ($id > 0) {
            $this->b_crumb->add("Edit Faq", Utilities::generateUrl("faqs", "form"));
        } else {
            $this->b_crumb->add("Add Faq", Utilities::generateUrl("faqs", "form"));
        }
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->set('frm', $frm);
        $this->render();
    }

    public function setup() {
        $user_id = Admin::getLoggedinUserId();
        $post = Syspage::getPostedVar();

        if (intval($post['faq_id']) > 0) {
            if (!Permission::canEditFaqs($user_id, $post['faq_id'])) {
                $this->notAuthorized();
            }
        } else {
            if (!Permission::canAddFaqs($user_id)) {
                $this->notAuthorized();
            }
        }
       
        $frm = $this->getForm();
        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('faqs'));
        }
        if (!$this->faqs->setupfaqs($post)) {
            Message::addErrorMessage($this->faqs->getError());
        }
        redirectUser(generateUrl('faqs'));
    }

    function delete_Faq($faq_id) {
        $user_id = Admin::getLoggedinUserId();
        if (!Permission::canDeletefaqs($user_id, $faq_id)) {
            $this->notAuthorized();
        }
        if (is_numeric($faq_id) && intval($faq_id) > 0) {
            $data = array('faq_id' => $faq_id, 'faq_deleted' => Faq::DELETED_FAQ);
            if ($this->faqs->setupfaqs($data)) {
                Message::getHtml();
                Message::addMsg('Faq deleted successfully.');
            } else {
                Message::addErrorMessage($this->faqs->getError());
            }
        } else {
            Message::addErrorMessage('Invalid Request');
        }
        redirectUser(generateUrl('faqs'));
    }

    function change_listing_status() {



        $db = Syspage::getdb();
        $post = Syspage::getPostedVar();
        $faq_id = intval($post['faq_id']);
        $status = intval($post['mode']);

        $user_id = Admin::getLoggedinUserId();
        if (!Permission::canChangeStatusoffaqs($user_id, $faq_id)) {
            $this->notAuthorized();
        }
        if ($faq_id < 1) {
            Message::addErrorMessage('Invalid ID');
            dieJsonError(Message::getHtml());
        }

        /* Update Winner */
        if (!$db->update_from_array('tbl_faq', array('Faq_active' => $status), array('smt' => 'faq_id = ?', 'vals' => array($faq_id)), '', '', '', 1)) {
            Message::addErrorMessage($db->getError());
            dieJsonError(Message::getHtml());
        }


        Message::addMessage('Faq status changed successfully.');
        dieJsonSuccess(Message::getHtml());
    }

}
