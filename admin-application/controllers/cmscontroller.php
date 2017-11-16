<?php

class CmsController extends BackendController {

    protected $Cmspage;

    public function before_filter() {
        parent::before_filter();
        $this->Cmspage = new Cmspages();
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Cms Management", Utilities::generateUrl("cms"));
    }

    public function default_action() {
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->render();
    }

    function form($page_id = 0) {       
        $user_id = Admin::getLoggedinUserId();
        if (!Permission::canEditCmsPage($user_id)) {
            $this->notAuthorized();
        }        
        $frm = $this->getForm();
        if (intval($page_id) > 0) {
            $data = Cms::getactiveCmsById($page_id)->fetch();
            $frm->fill($data);
            if (!$data) {
				Message::addErrorMessage('Invalid Request');
				redirectUser(generateUrl('cms'));                
            }
        }
		 if ($page_id > 0) {
            $this->b_crumb->add("Edit CMS Page", Utilities::generateUrl("cms", "form"));
        } else {
            $this->b_crumb->add("Add CMS Page", Utilities::generateUrl("cms", "form"));
        }
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->set('frm', $frm);
        $this->_template->render();
    }

    function listing() {
        $page = Syspage::getPostedVar('page');
        $pages = Cms::searchCms();
        $pages->addCondition('cmsc_content_delete', '=', Cms::NOT_DELETED_CMSPAGE);
        $this->paginate($pages, $page, generateUrl('cms', 'listing'));
        $user_id = Admin::getLoggedinUserId();

        $this->set('canEdit', Permission::canEditCmsPage($user_id));
        $this->set('canAdd', Permission::canAddCmsPage($user_id));
        $this->set('canDelete', Permission::canDeleteCmsPage($user_id));
        $this->render();
    }

    private function getForm() {

        $frm = new Form('frmCms');
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setAction(generateUrl('cms', 'setup'));
        $frm->addHiddenField('', 'cmsc_id');
        $frm->addRequiredField('Title', 'cmsc_title');
		$frm->addRequiredField('Sub Title', 'cmsc_sub_title');
        //$fld = $frm->addRequiredField('Slug', 'cmsc_slug')->setUnique('tbl_cms_contents', 'cmsc_slug', 'cmsc_id', 'cmsc_slug', 'cmsc_slug');
		$fld=$frm->addRequiredField('Slug', 'cmsc_slug');
		$fld->html_after_field='<small>Do not use spaces, instead replace spaces with - and make sure the keyword is globally unique.</small>';
        $fck = $frm->addHtmlEditor('Description', 'cmsc_content');
		
		$frm->addHtml('<h6 class="meta-text">Section 2: SEO/Meta Data (Optional)</h6>', 'htmlNote','','&nbsp;');
		$frm->addTextBox('Page Title', 'cmsc_meta_title','','cmsc_meta_title','class="medium"');
		$frm->addTextArea('Meta Keywords', 'cmsc_meta_keywords','','cmsc_meta_keywords','class="medium" cols="112"');
		$frm->addTextArea('Meta Description', 'cmsc_meta_description','','cmsc_meta_desc','class="medium" cols="112"');
        //$frm->addSelectBox('Page Type', 'cmsc_type', Applicationconstants::$cms_page_type)->requirements()->setRequired();
        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Submit', 'btn_submit', 'style="cursor:pointer;"');

        $fld2 = $frm->addButton('', 'cancel', 'Cancel', '', 'class="cancel_form reset_button" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
		$frm->setTableProperties('width="100%" border="0" cellspacing="0" cellpadding="0" class="table_formsingle"');
		$frm->setLeftColumnProperties('class="td_form_horizontal"');
        $frm->setValidatorJsObjectName('cmsValidator');
        $frm->setOnSubmit('submitCmsSetup(this, cmsValidator);');
        return $frm;
    }

    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-\_]/', '', $string); // Removes special chars.
        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }

    function setup() {
        $user_id = Admin::getLoggedinUserId();
        $post = Syspage::getPostedVar();
        $data = $post;
			 	
        //$data['cmsc_slug'] = $this->clean($post['cmsc_slug']);
        $frm = $this->getForm();
        if (!$frm->validate($data)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('cms'));
        }
		else{
		$cms_data = Cms::getactiveCmsById($data['cmsc_id'])->fetch();
		
		$oldSlug=$cms_data['cmsc_slug'];
		if($post['cmsc_slug'] == $oldSlug)
		{
			$slug = $data['cmsc_slug'];
		}
		else{
			
		$slug=slugify($data['cmsc_slug']);
		$slug_match  = Cms::getactiveCmsBySlug($slug)->fetch_all();
		
		if(count($slug_match) > 0)
			{
				
				Message::addErrorMessage('Slug should be unigue.');
				redirectUser(generateUrl('cms'));
			}
		}
		
		$data['cmsc_slug']=$slug;
        if (!$this->Cmspage->setupCmspage($data)) {
            Message::addErrorMessage($this->Cmspage->getError());
        }
		}
        redirectUser(generateUrl('cms'));
    }

    function delete_cms($cms_id) {
        $user_id = Admin::getLoggedinUserId();
        if (!Permission::canDeleteCmsPage($user_id, $cms_id)) {
            $this->notAuthorized();
        }
        if (is_numeric($cms_id) && intval($cms_id) > 0) {
            $data = array('cmsc_id' => $cms_id, 'cmsc_content_delete' => Cms::DELETED_CMSPAGE);
            if ($this->Cmspage->setupCmspage($data)) {
                Message::getHtml();
                Message::addMsg('cms page deleted successfully.');
            } else {
                Message::addErrorMessage($this->Cmspage->getError());
            }
        } else {
            Message::addErrorMessage('Invalid Request');
        }
        redirectUser(generateUrl('cms'));
    }

    function change_listing_status() {



        $db = Syspage::getdb();
        $post = Syspage::getPostedVar();
        $cmsc_id = intval($post['cmsc_id']);
        $status = intval($post['mode']);

        $user_id = Admin::getLoggedinUserId();
        if (!Permission::canChangeStatusofCmsPage($user_id, $cmsc_id)) {
            $this->notAuthorized();
        }
        if ($cmsc_id < 1) {
            Message::addErrorMessage('Invalid ID');
            dieJsonError(Message::getHtml());
        }

        /* Update Winner */
        if (!$db->update_from_array('tbl_cms_contents', array('cmsc_content_active' => $status), array('smt' => 'cmsc_id = ?', 'vals' => array($cmsc_id)), '', '', '', 1)) {
            Message::addErrorMessage($db->getError());
            dieJsonError(Message::getHtml());
        }


        Message::addMessage('Cms Page status changed successfully.');
        dieJsonSuccess(Message::getHtml());
    }

}
