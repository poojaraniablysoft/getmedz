<?php

class FaqcategoryController extends BackendController {

    public function before_filter() {
        parent::before_filter();
        $this->faqcat_model = new Faqcategory();
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Faq Category Management", Utilities::generateUrl("faqcategory"));
    }

    public function default_action() {
        $this->set('searchForm', $this->searchForm());
        $this->set('addform', $this->getform());
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->render();
    }

    public function listing() {

        $page = Syspage::getPostedVar('page');
        $faqcategories = faqcat::getAllfaqcategory();

        $post = Syspage::getPostedVar();
        if (!empty($post['keyword'])) {
            $cnd = $faqcategories->addCondition('faqcat_name', 'like', $post['keyword'] . "%");
        }
        $this->paginate($faqcategories, $page, generateUrl('faqcategory', 'listing'));
        $user_id = Admin::getLoggedinUserId();
        $this->set('canAddFaqCategory', Permission::canAddFaqCategory($user_id));
        $this->set('canEditFaqCategory', Permission::canEditFaqCategory($user_id));
        $this->set('canDeleteFaqCategory', Permission::canDeleteFaqCategory($user_id));
        $this->render();
    }
    private function searchForm() {
        $frm = new Form('searchForm','searchForm');
        $frm->setAction(generateUrl('doctors', 'listing'));
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
        $frm = new Form('Frmfaqcategory');
        $frm->setAction(generateUrl('faqcategory', 'setup'));
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addHiddenField('', 'faqcat_id');
        $frm->addRequiredField('FAQ Category Name', 'faqcat_name')->requirements()->setRequired();
        $frm->addIntegerField('FAQ Catgeory Display order ', 'faqcat_display_order')->requirements()->setRequired();

        $frm->addSelectBox('Status', 'faqcat_active', Applicationconstants::$arr_status)->requirements()->setRequired();

        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Submit', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'cancel', 'Cancel', '', 'class="cancel_form reset_button" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('faqcategoryValidator');
        $frm->setOnSubmit('submitfaqcategoryetup(this, faqcategoryValidator);');
        return $frm;
    }

    public function form() {
        $user_id = Admin::getLoggedinUserId();
        $id = Syspage::getPostedVar('id');
        $frm = $this->getform();
        if (intval($id) > 0) {

            if (!Permission::canEditfaqcategory($user_id, $id)) {
                $this->notAuthorized();
            }

            $srch = faqcat::getAllFaqCategory();
            $srch->addCondition('faqcat_id', "=", $id);
            $data = $srch->fetch();

            $frm->fill($data);

            if (!$data)
                dieWithError('Invalid Request');
        }else {
            if (!Permission::canAddfaqcategory($user_id)) {
                $this->notAuthorized();
            }
        }

        $this->set('frm', $frm);
        $this->render();
    }

    public function setup() {
        $user_id = Admin::getLoggedinUserId();
        $post = Syspage::getPostedVar();

        if (intval($post['faqcat_id']) > 0) {
            if (!Permission::canEditFaqCategory($user_id, $post['faqcat_id'])) {
                $this->notAuthorized();
            }
        } else {
            if (!Permission::canAddFaqCategory($user_id)) {
                $this->notAuthorized();
            }
        }

        $frm = $this->getForm();
        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('faqcategory'));
        }

        if (!$this->faqcat_model->setup($post)) {
            Message::addErrorMessage($this->faqcat_model->getError());
        }
        redirectUser(generateUrl('faqcategory'));
    }

    function delete_faqcategory($faqcat_id) {
        $user_id = Admin::getLoggedinUserId();
        if (!Permission::canDeletefaqcategory($user_id, $faqcat_id)) {
            $this->notAuthorized();
        }
        if (is_numeric($faqcat_id) && intval($faqcat_id) > 0) {
            $data = array('faqcat_id' => $faqcat_id, 'faqcat_deleted' => 1);
            if ($this->faqcat_model->setup($data)) {
                Message::getHtml();
                Message::addMsg('FAQ Category deleted successfully.');
            } else {
                Message::addErrorMessage($this->faqcat_model->getError());
            }
        } else {
            Message::addErrorMessage('Invalid Request');
        }
        redirectUser(generateUrl('faqcategory'));
    }

    function change_listing_status() {

        $user_id = Admin::getLoggedinUserId();
        if (!Permission::canChangeStatusoffaqcategory($user_id, $faqcat_id)) {
            $this->notAuthorized();
        }

        $db = Syspage::getdb();
        $post = Syspage::getPostedVar();
        $faqcat_id = intval($post['faqcat_id']);
        $status = intval($post['mode']);
        if ($faqcat_id < 1) {
            Message::addErrorMessage('Invalid ID');
            dieJsonError(Message::getHtml());
        }

        /* Update Winner */
        if (!$db->update_from_array('tbl_faq_category', array('faqcat_active' => $status), array('smt' => 'faqcat_id = ?', 'vals' => array($faqcat_id)), '', '', '', 1)) {
            Message::addErrorMessage($db->getError());
            dieJsonError(Message::getHtml());
        }


        Message::addMessage('FAQ Category status changed successfully.');
        dieJsonSuccess(Message::getHtml());
    }

}
