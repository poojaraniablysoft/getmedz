<?php

class EmailtemplatesController extends BackendController {

    function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);
        $this->Emailtemplates=new Emailtemplates();
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Email Templates", Utilities::generateUrl("emailtemplates"));
    }

    function default_action() {

        $this->_template->render();
    }

    function listing($page_no = 0) {

       $page = Syspage::getPostedVar('page');
      
        $doctores = $this->Emailtemplates->searchTemplates();
           //Searching Critreia
         
        
        $this->paginate($doctores, $page, generateUrl('emailtemplates', 'listing'));

        $this->_template->render(false, false);
    }

    function form($tpl_id) {

        global $post;
        if (!is_numeric($tpl_id)) {
            $tpl_id = 0;
        }
        if ($tpl_id < 0) {
            $tpl_id = 0;
        }
        $tpl_id = intval($tpl_id);
        $frm = $this->getForm($tpl_id);
        if ($tpl_id > 0) {
            $data = $this->Emailtemplates->getFormData($tpl_id);
            $frm->fill($data);
            if (!$data) {
                dieWithError('Invalid Request');
            }
        }
        $this->set('frm', $frm);
		
        $this->b_crumb->add("Edit Template", Utilities::generateUrl("emailtemplates", "form"));
       $this->set('breadcrumb', $this->b_crumb->output());
        $this->_template->render();
    }

    function getForm($tpl_id) {
        $frm = new Form('frmEmailTemplates');
         $frm->setTableProperties("class='table_form_vertical'");
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->addHiddenField('', 'tpl_id', $tpl_id);
        $frm->addRequiredField('Template Name', 'tpl_name', '', '', 'style="width:500px;"');
        $frm->addRequiredField('Subject', 'tpl_subject', '', '', 'style="width:500px;"');
        $frm->addHtmlEditor('Content', 'tpl_body', '');
        $frm->addHTML('Template Vars', 'tpl_replacements', '', '');

        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Submit', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'cancel', 'Cancel', '', 'onclick="javascript:history.back();" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);

      

        $frm->setValidatorJsObjectName('EmailTemplatesValidator');
        $frm->setAction(generateUrl('emailtemplates', 'setup'));

        return $frm;
    }

    function setup() {

        global $msg;
        $post = Syspage::getPostedVar();

        $frm = $this->getForm();
        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('emailtemplates', 'form'));
        }
        $data = $post;
        if (!$this->Emailtemplates->setup($data)) {
            Message::addErrorMessage($this->Emailtemplates->getError());
        }

        redirectUser(generateUrl('emailtemplates'));
    }

}

?>