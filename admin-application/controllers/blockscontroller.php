<?php

class BlocksController extends BackendController {

    protected $Cmspage;

    public function before_filter() {
        parent::before_filter();
        $this->Blocks = new Blocks();
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Blocks Management", Utilities::generateUrl("blocks"));
    }

    public function default_action() {
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->render();
    }

    function form($block_id) {
        global $post;
        $user_id = Admin::getLoggedinUserId();
        if (!Permission::canEditCmsPage($user_id)) {
            $this->notAuthorized();
        }
		if(!$block_id)
		{
			$block_id = $post['block_id'];
		}
        $frm = $this->getForm();
        if (intval($block_id) > 0) {
            $data = Block::getBlockById($block_id)->fetch();
            $frm->fill($data);
            if (!$data) {
                dieWithError('Invalid Request');
            }
        }

        $this->set('frm', $frm);
		 if ($banner_id > 0) {
            $this->b_crumb->add("Edit Block", Utilities::generateUrl("blocks", "form"));
        } else {
            $this->b_crumb->add("Add Block", Utilities::generateUrl("blocks", "form"));
        }
		$this->set('breadcrumb', $this->b_crumb->output());
		$this->_template->render(true, true);
        //$this->_template->render(false, false);
    }

    function listing() {
		global $db;
        $page = Syspage::getPostedVar('page');
        $pages = Block::searchBlock();
		$rs = $pages->getResultSet();
      //  $this->paginate($pages, $page, generateUrl('blocks', 'listing'));
        $user_id = Admin::getLoggedinUserId();
		//var_dump($rs->fetchAllAssoc());
		$this->set('arr_listing',$db->fetch_all($rs));
        $this->set('canEdit', Permission::canEditBlocks($user_id));
 
  
        $this->render();
    }

    private function getForm() {

        $frm = new Form('frmCms');
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setAction(generateUrl('blocks', 'setup'));
        $frm->addHiddenField('', 'block_id');
       
        $fck = $frm->addHtmlEditor('Content', 'block_content');
        //  $frm->addSelectBox('Page Type', 'cmsc_type', Applicationconstants::$cms_page_type)->requirements()->setRequired();
        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Submit', 'btn_submit', 'style="cursor:pointer;"');

        $fld2 = $frm->addButton('', 'cancel', 'Cancel', '', 'class="cancel_form reset_button" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
		$frm->setTableProperties('width="100%" border="0" cellspacing="0" cellpadding="0" ');
        $frm->setValidatorJsObjectName('cmsValidator');
        $frm->setOnSubmit('submitSetup(this, cmsValidator);');
		$frm->setTableProperties('width="100%" border="0" cellspacing="0" cellpadding="0" class="table_formsingle"');
		//$frm->setLeftColumnProperties('class="td_form_horizontal"');
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
       
        $frm = $this->getForm();
        if (!$frm->validate($data)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('blocks'));
        }

        if (!$this->Blocks->setupBlocks($data)) {
            Message::addErrorMessage($this->Blocks->getError());
        }
        redirectUser(generateUrl('blocks'));
    }
    function change_listing_status() {

        $user_id = Admin::getLoggedinUserId();
        if (!Permission::canChangeStatusofBlocks($user_id, $degree_id)) {
            $this->notAuthorized();
        }

        $db = Syspage::getdb();
        $post = Syspage::getPostedVar();
        $block_id = intval($post['block_id']);
        $status = intval($post['mode']);
        if ($block_id < 1) {
            Message::addErrorMessage('Invalid ID');
            dieJsonError(Message::getHtml());
        }

        /* Update Winner */
        if (!$db->update_from_array('tbl_content_blocks', array('block_active' => $status), array('smt' => 'block_id = ?', 'vals' => array($block_id)), '', '', '', 1)) {
            Message::addErrorMessage($db->getError());
            dieJsonError(Message::getHtml());
        }


        Message::addMessage('Block status changed successfully.');
        dieJsonSuccess(Message::getHtml());
    }
}
