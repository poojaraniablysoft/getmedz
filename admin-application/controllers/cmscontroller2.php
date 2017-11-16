<?php

class CmsController extends Controller {

    function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);
		if (!is_object($this->cms_model)) $this->cms_model = new cms();
    }

    function default_action() {
		if(!Adminpermissions::canAccessModule('cms', false, Admin::getLoggedinUserId())) die(Adminpermissions::defaultUnauthorizedMsg());	
        $this->_template->render();
    }

   function form(){		
		global $post;	
		
		$page_name = $post['cmsc_page_identifier'];			
        $frm = $this->getForm($page_name);
		if ($page_name){
			$data = $this->cms_model->getData($page_name);		
			$frm->fill($data);
			if (!$data) dieWithError('Invalid Request');
		}		
		
        $this->set('frm', $frm);
        $this->_template->render(false,false);
    }

    function listing() {
        $post = Syspage::getPostedVar();   
        $srch = Cms::search();
        $rs = $srch->getResultSet();
        $db = &Syspage::getDb();
        $this->set('arr_listing', $db->fetch_all($rs));
        
        $this->_template->render(false, false);
    }

    protected function getForm($cmsc_page_identifier) {
		if(!Adminpermissions::canAccessModule('cms', false, Admin::getLoggedinUserId())) die(Adminpermissions::defaultUnauthorizedMsg());	
		
        $frm = new Form('frmCms');
		$frm->setTableProperties("class='edit_form' width='100%'");
		$frm->setJsErrorDisplay('afterfield');
		$frm->setAction(generateUrl('cms','setup'));
        $frm->addHiddenField('', 'cmsc_page_identifier',$cmsc_page_identifier);
        $frm->addRequiredField('Title', 'cmsc_title');
		$frm->addRequiredField('Title Arabic', 'cmsc_title_lang_2');
        $fck = $frm->addHtmlEditor('Description', 'cmsc_content');		
        $fck = $frm->addHtmlEditor('Description Arabic', 'cmsc_content_lang_2');	
        $fld1=$frm->addSubmitButton('', 'btn_submit', 'Submit','btn_submit','style="cursor:pointer;"');
		$fld2=$frm->addButton('', 'cancel', 'Cancel', '', 'class="cancel_form reset_button" style="margin-left:10px; cursor:pointer;"');
		$fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('cmsValidator');
		$frm->setOnSubmit('submitCmsSetup(this, cmsValidator);');

        return $frm;
    }

    function setup() {	
		global $msg;
		global $db;
        $post = Syspage::getPostedVar();
		if(!Adminpermissions::canAccessModule('cms', false, Admin::getLoggedinUserId())) die(Adminpermissions::defaultUnauthorizedMsg());	
		
		$frm = $this->getForm();
    	if (!$frm->validate($post)){
    		Message::addErrorMessage($frm->getValidationErrors());
    		redirectUser(generateUrl('cms'));
    	}
		
		$data = $post;	
		$cmsc_page_identifier=$this->cms_model->setup($data);
        if (!$cmsc_page_identifier){
            Message::addErrorMessage($this->cms_model>getError());
        }		
		redirectUser(generateUrl('cms'));
    }
    

}