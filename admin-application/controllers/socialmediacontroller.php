<?php
class SocialMediaController extends BackendController {
    
	 public function before_filter() {
        parent::before_filter();
        
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Social Media Platforms", Utilities::generateUrl("socialmedia"));
    }
	
	function default_action($page) {
		$admin_id = Admin::getLoggedinUserId();
		$this->canview = Permission::canViewSocial($admin_id);
		if ($this->canview != true) {
            $this->notAuthorized();
        }
		$sObj=new Socialmedia();
		$this->set('breadcrumb', $this->b_crumb->output());
		$this->set('arr_listing', $sObj->getSocialmedias($criteria));
		$this->_template->render();
    }
	
	function form($splatform_id) {
		$admin_id = Admin::getLoggedinUserId();
		if (!Admin::getAdminAccess($admin_id,SOCIALPLATFORMS)) {
             $this->notAuthorized();
        }
		$sObj=new Socialmedia();
		if ($splatform_id>0)
        	$socialplatform = $sObj->getSocialMediaById($splatform_id);
        $frm = $this->getForm($splatform_id,$socialplatform);
		
		$post = Syspage::getPostedVar();
		if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($post['btn_submit'])){
			if(!$frm->validate($post)){
				Message::addErrorMessage($frm->getValidationErrors());
			}else{
				if($post['splatform_id'] != $splatform_id){
					Message::addErrorMessage('Error: Invalid Request!!');
					redirectUser(generateUrl('socialmedia'));
				}else{
					if (isUploadedFileValidImage($_FILES['splatform_file'])){
						if(!saveImage($_FILES['splatform_file']['tmp_name'],$_FILES['splatform_file']['name'], $saved_icon_file_name, 'socialplatforms/')){
		               		Message::addError($saved_icon_file_name);
    		   			}
						$post["splatform_icon_file"]=$saved_icon_file_name;
    		    	}
					if (empty($splatform_id) && (!file_exists($_FILES['splatform_file']['tmp_name']) || !is_uploaded_file($_FILES['splatform_file']['tmp_name']))){
						Message::addError('Error: Please select icon file.');
						redirectUser(generateUrl('socialmedia'));
					}
					if($sObj->addUpdate($post)){
						Message::addMessage('Success: Social platform details added/updated successfully.');
						redirectUser(generateUrl('socialmedia'));
					}else{
						Message::addErrorMessage($sObj->getError());
					}
				}
			}
			$frm->fill($post);
		}
		 if ($splatform_id > 0) {
            $this->b_crumb->add("Edit Social Media Platform", Utilities::generateUrl("socialmedia", "form"));
        } else {
            $this->b_crumb->add("Add Social Media Platform", Utilities::generateUrl("socialmedia", "form"));
        }
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->set('frm', $frm);
        $this->_template->render(true,true);
    }
	
	
    protected function getForm($splatform_id,$data=array()) {
        $frm = new Form('frmTheme','frmTheme');
		$frm->captionInSameCell(false);
        $frm->addHiddenField('', 'splatform_id', $splatform_id, 'splatform_id');
        $frm->addRequiredField('Title', 'splatform_title');
		$fld = $frm->addRequiredField('URL', 'splatform_url');
		$fld->requirements()->setRegularExpressionToValidate('^(http(?:s)?\:\/\/[a-zA-Z0-9]+(?:(?:\.|\-)[a-zA-Z0-9]+)+(?:\:\d+)?(?:\/[\w\-]+)*(?:\/?|\/\w+\.[a-zA-Z]{2,4}(?:\?[\w]+\=[\w\-]+)?)?(?:\&[\w]+\=[\w\-]+)*)$');
		$fld = $frm->addFileUpload('Icon Image', 'splatform_file');
        $fld->html_before_field = '<div id="banner_image" ><div class="filefield"><span class="filename"></span>';
        if (!empty($data['splatform_icon_file'])) {
			$fld->html_after_field = '<label class="filelabel">Browse File</label></div><p><b>Current Image:</b><br /><img src="'.generateUrl('image', 'social_platform_icon', array($data["splatform_icon_file"],'SMALL'),CONF_WEBROOT_URL).'" /></p></div> ';
        } else {
			$fld->html_after_field = '<label class="filelabel">Browse File</label></div></div>';
        }
		$frm->addSelectBox('Status', 'splatform_status', Applicationconstants::$arr_status, '1', '');
        $frm->addSubmitButton('&nbsp;','btn_submit','Save changes');
        $frm->setExtra(' validator="socialplatformfrmValidator" class="web_form" rel="upload"');
        $frm->setValidatorJsObjectName('socialplatformfrmValidator');
		$frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties('width="100%" border="0" cellspacing="0" cellpadding="0" class="table_form_horizontal"');
		$frm->setLeftColumnProperties('width="20%"');
	    $frm->fill($data);
        return $frm;
    }
    
	function status($splatform_id, $mod='block') {
		$admin_id = Admin::getLoggedinUserId();
		if (!Admin::getAdminAccess($admin_id,SOCIALPLATFORMS)) {
             die(Admin::getUnauthorizedMsg());
        }	
        $splatform_id = intval($splatform_id);
		$sObj=new Socialmedia();
        $socialplatform = $sObj->getSocialMediaById($splatform_id);
        if($socialplatform==false) {
            Message::addErrorMessage('Error: Please perform this action on valid record.');
            redirectUserReferer();
        }
        switch($mod) {
            case 'block':
            	$data_to_update = array(
					'splatform_status'=>0,
	            );
            break;
            case 'unblock':
    	        $data_to_update = array(
					'splatform_status'=>1,
            	);
            break;
           
        }
		if($sObj->updateSocialPlatformStatus($splatform_id,$data_to_update)){
			Message::addMessage('Success: Status is modified successfully.');
		}else{
			Message::addErrorMessage($sObj->getError());
		}
        redirectUserReferer();
    }
	
	function delete($splatform_id) {
		$sObj=new Socialmedia();
		$admin_id = Admin::getLoggedinUserId();
		if (!Admin::getAdminAccess($admin_id,SOCIALPLATFORMS)) {
             die(Admin::getUnauthorizedMsg());
        }
        if($sObj->delete($splatform_id)){
			Message::addMessage('Success: Record has been deleted.');
		}else{
			Message::addErrorMessage($sObj->getError());
		}
		
		redirectUserReferer();
    }
	
	
}