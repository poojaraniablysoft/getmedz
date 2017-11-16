<?php
class TestimonialsController extends BackendController {
	const PAGESIZE =20;
	
	private $admin;
    private $admin_id = 0;
    function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);
		$admin_id = Admin::getLoggedinUserId();        
        $this->canview = Admin::getAdminAccess($admin_id,TESTIMONIALS);        
             
        $this->set('canview', $this->canview);
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Testimonial Management", Utilities::generateUrl("testimonials"));
        
    }
	  public function before_filter() {
        parent::before_filter();
    }

	
	protected function getSearchForm() {
        $frm=new Form('frmSearchTestimonials','frmSearchTestimonials');
		$frm->setFieldsPerRow(2);
		$frm->setExtra('class="web_form last_td_nowrap"');
		$frm->setMethod('GET');
		$frm->captionInSameCell(true);
		$frm->setRequiredStarWith('not-required');
		$frm->addHiddenField('', 'mode', "search");
		$frm->addTextBox('Keyword', 'keyword','','',' class="small"');
		$fld1 = $frm->addButton('', 'btn_cancel', 'Clear Search', '', ' class="medium" style="margin-left:10px; cursor:pointer;" onclick="clearSearch()"');
        $fld = $frm->addSubmitButton('', 'btn_submit', 'Search', 'btn_submit')->attachField($fld1);
		$frm->setTableProperties('width="100%" border="0" cellspacing="0" cellpadding="0" class="table_form_vertical"');
		$frm->addHiddenField('', 'page', 1);
		$frm->setOnSubmit('searchTestimonials(this); return false;');
        return $frm;
    }
	
	function default_action() {
        if ($this->canview != true) {
            $this->notAuthorized();
        }
        $frm = $this->getSearchForm();
		$frm->fill(getQueryStringData());
        $this->set('frmPost', $frm);
		$user_id = Admin::getLoggedinUserId();

        $this->set('canEdit', Permission::canEditTestimonialPage($user_id));
        $this->set('canAdd', Permission::canAddTestimonialPage($user_id));
        $this->set('canDelete', Permission::canDeleteTestimonialPage($user_id));
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->_template->render();
    }
	
	function list_testimonials($page = 1) {
		
        if ($this->canview != true) {
            $this->notAuthorized();
        }
		$page = Syspage::getPostedVar('page');
		$tObj=Testimonials:: search();	
	//	$tObj->addMultipleFields(array('testimonial_name','testimonial_id','testimonial_status'));		
		$post = Syspage::getPostedVar();
        if (!empty($post['keyword'])) {
            $cnd = $tObj->addCondition('testimonial_name', 'like', $post['keyword'] . "%");
            $cnd->attachCondition('testimonial_test', 'like', $post['keyword'] . "%");
        }
		$this->paginate($tObj, $page, generateUrl('testimonials', 'list_testimonials'))	;
		$this->render(false,false);
        
    }
	
	function change_listing_status() {

        $user_id = Admin::getLoggedinUserId();


        $db = Syspage::getdb();
        $post = Syspage::getPostedVar();
        $testimonial_id = intval($post['testimonial_id']);
        $status = intval($post['mode']);


        if ($testimonial_id < 1) {
            Message::addErrorMessage('Invalid ID');
            dieJsonError(Message::getHtml());
        }

        /* Update Winner */
        if (!$db->update_from_array('tbl_testimonials', array('testimonial_status' => $status), array('smt' => 'testimonial_id = ?', 'vals' => array($testimonial_id)), '', '', '', 1)) {
            Message::addErrorMessage($db->getError());
            dieJsonError(Message::getHtml());
        }


        Message::addMessage('Testimonial status changed successfully.');
        dieJsonSuccess(Message::getHtml());
    }

	
	
	
    function form($testimonial_id=0) {
		if ($this->canview != true) {
            $this->notAuthorized();
        }
		
		$tObj=new Testimonials();
		if ($testimonial_id>0)
        	$testimonial = $tObj->getTestimonialById($testimonial_id);
        $frm = $this->getForm($testimonial_id,$testimonial);
		
		$post = Syspage::getPostedVar();
		if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($post['btn_submit'])){
			if(!$frm->validate($post)){
				Message::addErrorMessage($frm->getValidationErrors());
			}else{
				if($post['testimonial_id'] != $testimonial_id){
					Message::addErrorMessage('Error: Invalid Request!!');
					redirectUser(generateUrl('testimonials'));
				}else{
					
					if (isUploadedFileValidImage($_FILES['testimonial_file'])){
						if(!saveImage($_FILES['testimonial_file']['tmp_name'],$_FILES['testimonial_file']['name'], $saved_image_name, 'testimonials/')){
		               		Message::addError($saved_image_name);
    		   			}
						$post["testimonial_image"]=$saved_image_name;
    		    	}
					
					if($tObj->addUpdate($post)){
						Message::addMessage('Success: Testimonial details added/updated successfully.');
						redirectUser(generateUrl('testimonials'));
					}else{
						Message::addErrorMessage($tObj->getError());
					}
				}
			}
			$frm->fill($post);
		}
		 if ($testimonial_id > 0) {
            $this->b_crumb->add("Edit Testimonial", Utilities::generateUrl("testimonials", "form"));
        } else {
            $this->b_crumb->add("Add Testimonial", Utilities::generateUrl("testimonials", "form"));
        }
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->set('frm', $frm);
        $this->_template->render(true,true);
    }
	
	
    protected function getForm($testimonial_id,$data=array()) {
        $frm = new Form('frmTestimonial','frmTestimonial');
		$frm->captionInSameCell(false);
        $frm->addHiddenField('', 'testimonial_id', $testimonial_id, 'testimonial_id');
        $fld=$frm->addRequiredField('Testimonial By', 'testimonial_name', '', '', ' class="medium"');
		$fld->html_after_field = 'Enter name here.';
		$fld=$frm->addRequiredField('Testimonial Location', 'testimonial_address', '', '', ' class="medium"');
        $fld = $frm->addFileUpload('Testimonial Image', 'testimonial_file');
		$fld->html_before_field='<div class="filefield"><span class="filename"></span>';
		$fld->html_after_field='<label class="filelabel">Browse File</label></div>';
         if ($testimonial_id>0) {
			$frm->addHTML('','','<img src="'.generateUrl('image', 'testimonial_image', array($data["testimonial_image"],"THUMB"),CONF_WEBROOT_URL).'" />');
        }  
		/* if ($testimonial_id>0) {
			$frm->addHTML('','','<img src="'.generateUrl('image', 'testimonial_image', array($banner_id, 139, 113),CONF_WEBROOT_URL).'" />');
        }  */
		$fld = $frm->addTextArea('Testimonial Text', 'testimonial_text', '', '', 'rows=6 class="medium"')->requirements()->setRequired();
		$fld = $frm->addSelectBox('Testimonial Status', 'testimonial_status',Applicationconstants::$arr_status, $data["testimonial_status"], '')->requirements()->setRequired();
        
        $frm->addSubmitButton('&nbsp;','btn_submit','Save changes');
        $frm->setExtra(' validator="testimonialfrmValidator" class="web_form" rel="upload"');
        $frm->setValidatorJsObjectName('testimonialfrmValidator');
		$frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties('width="100%" border="0" cellspacing="0" cellpadding="0" class="table_form_horizontal"');
		$frm->setLeftColumnProperties('width="20%"');
	    $frm->fill($data);
        return $frm;
    }
    
	function delete() {
        if ($this->canview != true) {
            dieJsonError("Unauthorized Access");
        }
        $post = Syspage::getPostedVar();
		$tObj=new Testimonials();
        $testimonial_id = intval($post['id']);
        $testimonial = $tObj->getTestimonialById($testimonial_id);
		if($testimonial==false) {
           Message::addErrorMessage('Error: Please perform this action on valid record.');
           dieJsonError(Message::getHtml());
        }
		if($tObj->delete($testimonial_id)){
			Message::addMessage('Success: Record has been deleted.');
			dieJsonSuccess(Message::getHtml());
		}else{
			Message::addErrorMessage($tObj->getError());
			dieJsonError(Message::getHtml());
		}
    }
	
    
	
}
