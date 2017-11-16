<?php
class LabelsController extends BackendController {
    
	 public function before_filter() {
        parent::before_filter();
        
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Labels Management", Utilities::generateUrl("labels"));
    }

	function default_action($page) {
		
		Syspage::addJs(array('../js/admin/jquery.jeditable.mini.js'), false);
		$user_id = Admin::getLoggedinUserId();
		if (!Admin::getAdminAccess($user_id,LANGUAGELABELS)) {
             die(Admin::getUnauthorizedMsg());
        }
		$frm=$this->getSearchForm();
		$this->set('search_form',$frm);
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->_template->render();
    }
	
	protected function getSearchForm() {
        $frm=new Form('frmSearchLabels','frmSearchLabels');
		$frm->setFieldsPerRow(2);
		$frm->setExtra('class="web_form last_td_nowrap"');
		$frm->setMethod('GET');
		$frm->captionInSameCell(true);
		$frm->setRequiredStarWith('not-required');
		$frm->addHiddenField('', 'mode', "search");
		$frm->addTextBox('Keyword', 'keyword','','',' class="small"');
		$fld1 =$frm->addSubmitButton('','btn_submit','Search');
		 $fld2 = $frm->addButton('', 'reset', 'Show All', '', 'class="cancel_search" style="margin-left:10px; cursor:pointer;"');
		  $fld1->attachField($fld2);
		$frm->setJsErrorDisplay('afterfield');
        $frm->setAction(generateUrl('labels'));
		$frm->setOnSubmit('searchLabels(this); return false;');
		$frm->setTableProperties('width="100%" border="0" cellspacing="0" cellpadding="0" class="table_form_vertical"');
        return $frm;
    }
	
	function listing($page = 1) {
		$user_id = Admin::getLoggedinUserId();
        if (!Admin::getAdminAccess($user_id,LANGUAGELABELS)) {
             die(Admin::getUnauthorizedMsg());
        }
		$page = Syspage::getPostedVar('page');
		$tObj=Labels:: search();	
	//	$tObj->addMultipleFields(array('testimonial_name','testimonial_id','testimonial_status'));		
		$post = Syspage::getPostedVar();
        if (!empty($post['keyword'])) {
            $cnd = $tObj->addCondition('label_key', 'like', $post['keyword'] . "%");
            $cnd->attachCondition('label_caption_en', 'like', $post['keyword'] . "%");
        }
		$this->paginate($tObj, $page, generateUrl('labels', 'listing'))	;
		$this->render(false,false);
        
    }

    function form($label_id) {
		if (!Admin::getAdminAccess(Admin::getLoggedinUserId(),LANGUAGELABELS)) {
             die(Admin::getUnauthorizedMsg());
        }
        $label_id = intval($page = Syspage::getPostedVar('id'));
        $frm = $this->getForm($label_id);
        if ($label_id > 0) {
            $data = $this->Labels->getData($label_id);

            $frm->fill($data);
        }
	
        $this->set('frm', $frm);
        $this->_template->render(false,false);
    }

    protected function getForm($id) {
        $frm = new Form('frmLabels');
		$frm->setExtra(' validator="LabelsfrmValidator" class="web_form"');
        $frm->setValidatorJsObjectName('LabelsfrmValidator');
        $frm->addHiddenField('', 'label_id');
		if ($id>0)
			$frm->addTextBox('Key', 'label_key','', '', 'readonly class="input-xlarge"');
		else	
			$frm->addRequiredField('Key', 'label_key','', '', ' class="input-xlarge"');
		
		$fld=$frm->addTextArea('Caption English', 'label_caption_en', '', 'label_caption_en', ' class="cleditor" rows="3"');
	//	$fld=$frm->addTextArea('Caption Alternate Language', 'label_caption_es', '', 'label_caption_es', ' class="cleditor" rows="3"');
		$frm->addSubmitButton('&nbsp;','btn_submit','Save changes');
		$frm->setJsErrorDisplay('afterfield');
		$frm->setTableProperties('width="100%" border="0" cellspacing="0" cellpadding="0" class="table_form_horizontal"');
		$frm->setLeftColumnProperties('width="20%"');
		//$frm->setAction(generateUrl('labels', 'setup'));
        $frm->setOnSubmit('return submitSetup(this, LabelsfrmValidator);');
        return $frm;
    }
	
	public function setup() {
        $user_id = Admin::getLoggedinUserId();
        $post = Syspage::getPostedVar();
        $frm = $this->getForm();
		

        if (!$frm->validate($post)) {
           
            Message::addErrorMessage($frm->getValidationErrors());
			dieJsonError(Message::getHtml());
        }
        unset($post['label_key']);
        
		$label = new Labels();
        if (!$label->addUpdateLabel($post)) {
            dieJsonError($user->getError());
        }
   
        dieJsonSuccess("Label updated successfully");
    }
	
	function delete($label_id) {
		if (!Admin::getAdminAccess($this->getLoggedAdminId(),LANGUAGELABELS)) {
             die(Admin::getUnauthorizedMsg());
        }
        if($this->Labels->deleteLabel($label_id)){
			Message::addMessage('Success: Record has been deleted.');
		}else{
			Message::addErrorMessage($this->Labels->getError());
		}
		
		redirectUserReferer();
    }
	
	function getLabelContent($id, $lang)
	{
		$post = Syspage::getPostedVar();
		// printArray($post);exit;
		if(!$val= $this->Labels->getData($id))
		{
			echo '';
		}
		echo $val['label_caption_' . $lang];
	}
	function updateLabelField(){
		$post = Syspage::getPostedVar();
		$post["value"] = $post["value"];
		$this->Labels->updateLabelText($post);
		// echo html_entity_decode($post["value"]);
		echo $post["value"];
		//exit();
	}
	
	
	
	
}