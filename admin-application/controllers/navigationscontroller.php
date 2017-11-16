<?php
class NavigationsController extends BackendController {
	private $admin;
    private $admin_id = 0;
    function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);
		 $admin_id = Admin::getLoggedinUserId();
        $this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Navigation Management", Utilities::generateUrl("navigations"));
        $this->canview = Admin::getAdminAccess($admin_id,NAVIGATION);
    }
	
    function default_action() {		
		$admin_id = Admin::getLoggedinUserId();
		if (!Admin::getAdminAccess($admin_id,NAVIGATION)) {
            die(Admin::getUnauthorizedMsg());
        }
	    $this->set('arr_listing', $this->Navigations->getnavigations());
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->_template->render();
    }
	
	 protected function getNavForm() {
        $frm = new Form('frmNav','frmNav');
		$frm->setExtra(' validator="navfrmValidator" class="web_form"');
        $frm->setValidatorJsObjectName('navfrmValidator');
        $frm->addHiddenField('', 'nav_id');
		$frm->addRequiredField('Title', 'nav_name','', '', ' class="input-xlarge"');
		$frm->addSubmitButton('&nbsp;','btn_submit','Save changes');
		$frm->setJsErrorDisplay('afterfield');
		$frm->setTableProperties('width="100%" border="0" cellspacing="0" cellpadding="0" class="table_form_horizontal"');
		$frm->setLeftColumnProperties('width="20%"');
        return $frm;
    }
	
	function form($id = 0) {
		$admin_id = Admin::getLoggedinUserId();
		if (!Admin::getAdminAccess($admin_id,NAVIGATION)) {
             die(Admin::getUnauthorizedMsg());
        }
        $id = intval($id);
        $frm = $this->getNavForm();
        if ($id > 0) {
            $data = $this->Navigations->getNavigationById($id);
            $frm->fill($data);
        }
		$post = Syspage::getPostedVar();
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			if(!$frm->validate($post)){
				Message::addErrorMessage($frm->getValidationErrors());
			}else{
					if($this->Navigations->addUpdateNavigation($post)){
						Message::addMessage('Success: Navigation added/updated successfully.');
						redirectUser(generateUrl('navigations'));
					}else{
						Message::addErrorMessage($this->Navigations->getError());
					}
				}
			$frm->fill($post);
		}
		if ($id > 0) {
            $this->b_crumb->add("Edit Navigation Title", Utilities::generateUrl("navigations", "form"));
        } else {
            $this->b_crumb->add("Add Navigation", Utilities::generateUrl("navigations", "form"));
        }
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->set('frm', $frm);
        $this->_template->render(true,true);
    }

    function pages($nav_id) {
		$admin_id = Admin::getLoggedinUserId();
		if (!Admin::getAdminAccess($admin_id,NAVIGATION)) {
             die(Admin::getUnauthorizedMsg());
        }
		$nav_id = intval($nav_id);
        $navigation = $this->Navigations->getNavigationById($nav_id);
        if($navigation==false) {
            Message::addErrorMessage('Error: Please perform this action on valid record.');
            redirectUser(generateUrl('navigations'));
        }
		$this->set('navigation', $nav_id);
		 $this->b_crumb->add("Pages", Utilities::generateUrl("navigations", "pages"));
		 $this->set('breadcrumb', $this->b_crumb->output());
        $this->set('arr_listing', $this->Navigations->getNavigationPagesById($nav_id));
		$this->_template->render();
    }
	
	function status($navigation_id, $mod='block') {
		$admin_id = Admin::getLoggedinUserId();
		if (!Admin::getAdminAccess($admin_id,NAVIGATION)) {
             die(Admin::getUnauthorizedMsg());
        }	
        $navigation_id = intval($navigation_id);
        $navigation = $this->Navigations->getNavigationById($navigation_id);
        if($navigation==false) {
            Message::addErrorMessage('Error: Please perform this action on valid record.');
            redirectUserReferer();
        }
        switch($mod) {
            case 'disable':
            	$data_to_update = array(
					'nav_status'=>0,
	            );
            break;
            case 'enable':
    	        $data_to_update = array(
					'nav_status'=>1,
            	);
            break;
           
        }
		if($this->Navigations->updateNavigationStatus($navigation_id,$data_to_update)){
			Message::addMessage('Success: Status is modified successfully.');
		}else{
			Message::addErrorMessage($this->Navigations->getError());
		}
        redirectUserReferer();
    }
	
	
	
	function addEditNavigationPage($navigation_id,$nav_page_id) {
		$admin_id = Admin::getLoggedinUserId();
		if (!Admin::getAdminAccess($admin_id,NAVIGATION)) {
             die(Admin::getUnauthorizedMsg());
        }
		$navigation = $this->Navigations->getNavigationById($navigation_id);
        if($navigation==false) {
            Message::addErrorMessage('Error: Please perform this action on valid record.');
            redirectUser(generateUrl('navigations'));
        }
        $nav_page_id = intval($nav_page_id);
		$navType = 0 ;
        $frm = $this->getForm($navigation_id,$nav_page_id);
        $navigationPage = $this->Navigations->getNavigationPageById($nav_page_id);
		$navigationPage["navigation_id"]=$navigation_id;
		$navigationPage["nav_page_id"]=$navigationPage["nl_id"];
		$navigationPage["external_page"]=$navigationPage["nl_type"]==2?$navigationPage["nl_html"]:"";
		$navigationPage["custom_html"]=$navigationPage["nl_type"]==1?$navigationPage["nl_html"]:"";
		if($navigationPage){
			$navType = 	$navigationPage["nl_type"];
		}
		$frm->fill($navigationPage);
		$post = Syspage::getPostedVar();
		if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($post['btn_submit'])){
			if(!$frm->validate($post)){
				Message::addErrorMessage($frm->getValidationErrors());
			}else{
				if($post['navigation_id'] != $navigation_id){
					Message::addErrorMessage('Error: Invalid Request!!');
					redirectUser(generateUrl('navigations','pages',array($navigation_id)));
				}else{
					
					if($this->Navigations->addUpdatePage($post)){
						Message::addMessage('Success: Navigation page details added/updated successfully.');
						redirectUser(generateUrl('navigations','pages',array($navigation_id)));
					}else{
						Message::addErrorMessage($this->Navigations->getError());
					}
				}
			}
			$frm->fill($post);
		}
        $this->b_crumb->add("Pages", Utilities::generateUrl("navigations", "pages",array($navigation_id))); 
		if($nav_page_id){
			$this->b_crumb->add($navigationPage['nl_caption'],Utilities::generateUrl("navigations", "addeditnavigationpage",array($navigation_id)));			
		}else{
			
			$this->b_crumb->add('Add Navigation Page',Utilities::generateUrl("navigations", "addeditnavigationpage",array($navigation_id)));	
		}
		$this->set('breadcrumb', $this->b_crumb->output());
		$this->set('navType', $navType);
		$this->set('nav_id', $navigation_id);
        $this->set('frm', $frm);
        $this->_template->render(true, true);
    }
	
	protected function getForm($nav_id,$nl_id){
			global $db;
			global $nav_page_type;
			$frm=new Form('frmNavigations');
			$frm->setExtra('class="web_form" validator="tplValidator"');
			$frm->setValidatorJsObjectName('tplValidator');
			$frm->addHiddenField('', 'nav_page_id', '0', '', '');
			$frm->addHiddenField('', 'navigation_id','', '', '');
			$frm->addTextBox('Caption Name', 'nl_caption','','nl_caption','class="input-xlarge"')->requirements()->setRequired();
			$fld=$frm->addSelectBox('Type:', 'nl_type', $nav_page_type,'','class="input-xlarge" onChange="CallPageTypePopulate(this.value);"','','nl_type')->requirements()->setRequired();
			$frm->addSelectBox('Link Target', 'nl_target',array('_self'=>'Current Window','_blank'=>'New Window'),$cat_parent_code,'class="input-xlarge"','');
			$fld=$frm->addRadioButtons('Login Protected', 'nl_login_protected',array('0'=>'Both','1'=>'Yes','2'=>'No'),0, $table_cols=3, $tableproperties='class="innerTable"', $extra='');
			
			$cmsObj=new Cms();
			$frm->addSelectBox('Link to CMS Page', 'nl_cms_page_id',$cmsObj->getAssociativeArray(),$cat_selected_link,'class="input-xlarge"','','cms_page');
			$frm->addTextBox('External Page', 'external_page', '', 'external_page', ' class="input-xlarge"');
			$frm->addTextArea('Custom HTML', 'custom_html', '', 'custom_html', ' class="input-xlarge"');
			$frm->addTextBox('Display Order', 'nl_display_order','','nl_display_order','class="input-xlarge"')->requirements()->setIntPositive();
			$frm->setJsErrorDisplay('afterfield');
			$frm->addSubmitButton('&nbsp;','btn_submit','Save changes');
			$frm->setTableProperties('width="100%" border="0" cellspacing="0" cellpadding="0" class="table_form_horizontal"');
			$frm->setLeftColumnProperties('width="20%"');
			return $frm;
		
    }
	
	function deletepage($nav_page_id) {
		$admin_id = Admin::getLoggedinUserId();
		if (!Admin::getAdminAccess($admin_id,NAVIGATION)) {
             die(Admin::getUnauthorizedMsg());
        }
        if($this->Navigations->deletePage($nav_page_id)){
			Message::addMessage('Success: Record has been deleted.');
		}else{
			Message::addErrorMessage($this->Navigations->getError());
		}
		redirectUserReferer();
    }
	
	
	function getNavCode($nav_id,$parent_id){
		global $db;
		$code=str_pad($nav_id, 5, '0', STR_PAD_LEFT);
		if($parent_id>0){
			$rs=$db->query("select nl_code from tbl_nav_links where nl_id=" . $parent_id);
			if($row=$db->fetch($rs)){
					$code=$row['nl_code'].$code;
				}
			}
		return $code;
	}

}