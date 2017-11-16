<?php

class PageController extends FrontController {

    //  protected static $pages=array("about-us"=>'ABOUT_US',"legal"=>'LEGAL');

    public function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);


        $cmsPages = Cms::getactiveCms();
        $cmsPages->addCondition('mysql_func_LOWER(cmsc_slug)', '=', $action,'AND',TRUE);
        $page=$cmsPages->fetch();
   
        if (intval($page['cmsc_id'])<1) {
          page_404();
        }
        $this->display($page['cmsc_id']);
        exit();
    }

    public function display($page_id) {
		
		if($page_id == 24)
		{
			$this->set('page_type', 'howitworks');
		}
        $pageInfo = Cms::getactiveCmsById($page_id)->fetch();

        if (empty($pageInfo)) {
           page_404();
        }

        $this->set('pageinfo', $pageInfo);
        $this->_template->render(true, true, 'page/display.php');
    }

}
