<?php

class FrontController extends Controller {

    
    
    public function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);
        $this->before_filter();
    }

    public function before_filter() {

       
    }

    public function invalidRequest() {

        if (isAjaxRequest()) {
            dieJsonError("Your Session seems to have expired. Please try refreshing the page to login again");
        }
        $this->redirectToLogin();
    }
    public function notAuthorized() {

        if (isAjaxRequest()) {
			  Message::addErrorMessage('You are not authorized to perform this action');
            dieJsonError(Message::getHTML());
        }
        die("Invalid Request");
    }
    
    public function page_404(){
        
                die("Page Not Found");
    }
    
    public function redirectToLogin() {
        redirectUser(generateUrl('admin', 'loginform'));
    }

    public function render($include_header = true, $include_footer = true, $tplpath = NULL, $return_content = false, $convertVariablesToHtmlentities = true) {


        if (isAjaxRequest()) {
            $include_header = false;
            $include_footer = false;
        }

        $this->_template->render($include_header, $include_footer, $tplpath, $return_content, $convertVariablesToHtmlentities);
    }

    public function paginate($srch, $page, $url = "") {

        if (!is_object($srch)) {
            trigger_error("Not Valid Object requered Search class obj");
        }

        $pagesize = CONF_DEFAULT_ADMIN_PAGING_SIZE;

        if (intval($page) < 1) {
            $page = 1;
        }
        $srch->setPageSize($pagesize);
        $srch->setPageNumber($page);
        $arr_listing = $srch->fetch_all();


        $start_record = (($page - 1) * $pagesize + 1);
        $end_record = $page * $pagesize;
        $total_records = $srch->recordCount();
        if ($total_records < $end_record)
            $end_record = $total_records;

        $this->set('arr_listing', $arr_listing);
        $this->set('pages', $srch->pages());
        $this->set('page', $page);
        $this->set('pagesize', $pagesize);
        $this->set('start_record', $start_record);
        $this->set('end_record', $end_record);
        $this->set('total_records', $total_records);
        $frm=createHiddenFormFromPost("paginateForm",$url,array(),array('page'=>$page));
        $this->set("paginateForm",$frm);
        
        return true;
    }

}
