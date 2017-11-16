<?php

class BlogcommentsController extends BackendController {

    private $admin;
    private $admin_id = 0;

    function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);
        $admin_id = Admin::getLoggedinUserId();
        $this->canview = Permission::canViewBlog($admin_id);
        $this->canadd = Permission::canAddBlog($admin_id);
        $this->canedit = Permission::canEditBlog($admin_id);
        $this->set('canview', $this->canview);
        $this->set('canadd', $this->canadd);
        $this->set('canedit', $this->canedit);
        
    }

    function default_action() {
        if ($this->canview != true) {
            dieError("Unauthorized Access");
        }
        $frm = $this->getSearchForm();
        $this->set('frmComment', $frm);
        
        $this->_template->render();
    }

    private function getSearchForm() {
        $frm = new Form('frmComment', 'frmComment');
        $frm->setExtra('class="web_form"');
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties('class="table" width="100%" cellspacing="0" cellpadding="0" border="0"');
        $frm->setFieldsPerRow(4);
        $frm->setLeftColumnProperties('width="20%"');
        $frm->captionInSameCell(true);
        $frm->addTextBox('Comment Author Name', 'comment_author_name', '', 'comment_author_name', '');
        $frm->addSelectBox('Comment Status', 'comment_status', array(0 => 'Pending', 1 => 'Approved', 2 => 'Cancelled'), '', '', 'Select', 'comment_status');
        $fld1 = $frm->addButton('', 'btn_cancel', 'Clear Search', '', ' class="medium" onclick=location.href="' . generateUrl("blogcomments") . '"');
        $fld = $frm->addSubmitButton('', 'btn_submit', 'Search', 'btn_submit')->attachField($fld1);
        $frm->addHiddenField('', 'page', 1);
        $frm->setOnSubmit('searchPost(this); return false;');
        return $frm;
    }

    function list_comments($data=array()) {
        if ($this->canview != true) {
            dieError("Unauthorized Access");
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_submit'])) {
            $post = Syspage::getPostedVar();
            $page = 1;
            if (isset($post['page']) && intval($post['page']) > 0)
                $page = intval($post['page']);
            else
                $post['page'] = $page;
		
            if (!empty($post['comment_author_name']) || (isset($post['comment_status'])) && $post['comment_status'] != '') {
                $this->set('srch', $post);
            }
            $pagesize = CONF_DEFAULT_ADMIN_PAGING_SIZE;
            $post['pagesize'] = $pagesize;
            $this->set('records', $this->Blogcomments->getBlogComments($post));
            $this->set('pages', $this->Blogcomments->getTotalPages());
            $this->set('page', $page);
            $this->set('start_record', ($page - 1) * $pagesize + 1);
            $end_record = $page * $pagesize;
            $total_records = $this->Blogcomments->getTotalRecords();
            if ($total_records < $end_record)
                $end_record = $total_records;
            $this->set('end_record', $end_record);
            $this->set('total_records', $total_records);
			$url = generateUrl('Blogcomments', 'list_comments');
			$frm=createHiddenFormFromPost("paginateForm",$url,array('page'),array('page'=>$page));
			$this->set("paginateForm",$frm);
            $this->_template->render(false, false);
        }
    }

    function view($comment_id) {
        if ($this->canview != true) {
            dieError("Unauthorized Access");
        }
        $comment_id = intval($comment_id);
        if ($comment_id < 1) {
            dieError("Unauthorized Access");
        }
        $comment_data = $this->Blogcomments->getComment($comment_id);
        $status_array = array('0' => 'Pending', '1' => 'Approved', '2' => 'Cancelled');
        //unset($status_array[$comment_data['comment_status']]);
        $frm = $this->getCommentStatusUpdateForm();
        $frm->getField('comment_status')->options = $status_array;
        $frm->getField('comment_status')->value = $comment_data['comment_status'];
        $frm->getField('comment_id')->value = $comment_data['comment_id'];
        $this->set('frmComment', $frm);
        $this->set('comment_data', $comment_data);
        /* $this->b_crumb->add("View Comment", generateUrl("blogcomments", "view"));
        $this->set('breadcrumb', $this->b_crumb->output()); */
        $this->_template->render();
    }

    private function getCommentStatusUpdateForm() {
        $frm = new Form('frmBlogComments', 'frmBlogComments');
        $frm->setJsErrorDisplay('afterfield');
        $frm->setExtra('class="web_form"');
        $frm->addHiddenField('', 'comment_id', '');
        $status_array = array('0' => 'Pending', '1' => 'Approved', '2' => 'Cancelled');
        $frm->addSelectBox('Status', 'comment_status', $status_array, '', '', 'Select', 'comment_status');
        $frm->addSubmitButton('', 'update', 'Update', 'update');
        //->html_after_field = '<input type="button"  class="" value="Cancel" onclick = "cancelComment();">';
        $frm->setOnSubmit('updateStatus(this); return false;');
        return $frm;
    }

    function updateStatus() {
        if ($this->canedit != true) {
            dieError("Unauthorized Access");
        }
        $post = Syspage::getPostedVar();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $post['comment_status'] != '') {
            if ($this->Blogcomments->updateStatus($post)) {
                if ($post['comment_status'] == 1) {
                    $comment_data = $this->Blogcomments->getComment(intval($post['comment_id']));
					 
                    if (!empty($comment_data)) {
                        
						$emailnotifications = new Emailnotifications();
						$emailnotifications->sendBlogCommentEmailToUser($comment_data);
                    }
                }
                Message::addMessage('Status updated successfully.');
                dieJsonSuccess(Message::getHtml());
            } else {
                Message::addErrorMessage($this->Blogcomments->getError());
                dieJsonError(Message::getHtml());
            }
        }
        Message::addErrorMessage('Invalid request!!');
        dieJsonError(Message::getHtml());
        exit(0);
    }

    function delete($comment_id, $token = '') {
		 
        if ($this->canedit != true) {
			Message::addErrorMessage("Unauthorized Access");
			redirectUser(generateUrl('blogcomments'));
        }
        $comment_id = intval($comment_id);
        if ($comment_id < 1) {
			Message::addErrorMessage("Invalid Request");
            redirectUser(generateUrl('blogcomments'));
        }
        
		if ($this->Blogcomments->deleteComment($comment_id)) {
			Message::addMessage('Comment deleted successfully.');			 
		} else {
			Message::addErrorMessage($this->Blogcomments->getError());
		}
		redirectUser(generateUrl('blogcomments'));
	}

}
