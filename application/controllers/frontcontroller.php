<?php

class FrontController extends Controller {

    protected $layout;
    protected $layoutExtension = "php";

    function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);

        $this->before_filter();
        $this->set('controller', $controller);
    }

    protected function before_filter() {

//        if (!Members::isUserLogged()){//      
//           
//            redirectUser(generateUrl('members', 'login'));
//        }
//        
//        $user_id = Members::getLoggedUserID(); 

		//$login_navigation_elements         = $cache->get("login_navigation_elements");
		//$without_login_navigation_elements = $cache->get("without_login_navigation_elements");
		$question = new Question();
		$question = $question->searchQuestions();
		$rs = $question->getResultSet();
		$question_count = $question->recordCount();
		
		$Question = new Question();
		$reply_count = $Question->getRepliesCount();
		$sObj=new Socialmedia();
		$social_platforms=$sObj->getSocialmedias(array("status"=>1));
		
		$this->set('social_platforms',$social_platforms);
		$this->set('reply_count',$reply_count);
		$this->set('question_count',$question_count);
		if($login_navigation_elements == null ) {
			$nav = new Navigation();
			$top_header_mobile_navigation=$nav->getNavigation(1);
			
			$footer_mobile_navigation=$nav->getNavigation(2); 
			$footer_nav_quick_links=$nav->getNavigation(5);
			$footer_nav_our_services=$nav->getNavigation(4);
				$foot_nav = array();
				$footer_navigation = array();
		        $previous_gid = $j = $k =0;
    		    foreach ($footer_nav as $i=>$nav){           
					if($i==0 || $previous_gid!=$nav['nav_id']){
						$previous_gid = $nav['nav_id'];
						$j++;
					}
					$footer_navigation[$previous_gid][] = array(
						'navgroup_id'=>$nav['nav_id'],
						'parent'=> $nav['nav_name'],
						'navlink_caption' => strip_javascript($nav['nl_html']),
						'navlink_cmspage_id' => $nav['nl_cms_page_id'],
						'navlink_caption' => strip_javascript($nav['nl_caption']),
						'navlink_html' => strip_javascript($nav['nl_html']),
						'navlink_type' => $nav['nl_type'],
						'navlink_bullet_icon' => $nav['nl_bullet_image'],
						'navlink_href_target' => $nav['nl_target']
					);
				}
			$login_navigation_elements=array("top_header_mobile_navigation"=>$top_header_mobile_navigation,"footer_mobile_navigation"=>$footer_mobile_navigation,"footer_nav_quick_links"=>$footer_nav_quick_links,'footer_nav_our_services'=>$footer_nav_our_services); 
			foreach($login_navigation_elements as $elemkey=>$elemval){
				$this->set($elemkey,$elemval);
			}
			//$cache->set("login_navigation_elements",$login_navigation_elements , 4*60*60); // 4 Hours Cacheing
			
		}
    }

    public function paginate($srch, $page, $url = "",$checkrecords=0,$redirectUrl='') {

        if (!is_object($srch)) {
            trigger_error("Not Valid Object requered Search class obj");
        }		
        $pagesize = CONF_DEFAULT_FRONT_PAGING_SIZE;
		//$pagesize = 2;
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
		if (!isAjaxRequest()) {
			if($checkrecords==1){				
							
				if($total_records==0){
					$url_actions = explode('/',$url);	
					if((isset($url_actions[1]) && $url_actions[1]=='doctor' && isset($url_actions[2]) && $url_actions[2]=='unansweredquestions' ))
					{
						
						redirectUser($redirectUrl.'/'.$url_actions[2]);
					}
					else{
							redirectUser($redirectUrl);
						}
					}
			}
		}
        $this->set('arr_listing', $arr_listing);
        $this->set('pages', $srch->pages());
        $this->set('page', $page);
        $this->set('pagesize', $pagesize);
        $this->set('start_record', $start_record);
        $this->set('end_record', $end_record);
        $this->set('total_records', $total_records);
        $frm = createHiddenFormFromPost("paginateForm", $url, array('page'), array('page' => $page));
        $this->set("paginateForm", $frm);

        return true;
    }

    public function render($include_header = true, $include_footer = true, $tplpath = NULL, $return_content = false, $convertVariablesToHtmlentities = true) {


        if (isAjaxRequest()) {
            $include_header = false;
            $include_footer = false;
        }

        $this->_template->render($include_header, $include_footer, $tplpath, $return_content, $convertVariablesToHtmlentities);
    }

    public function getAttachment($entity_id, $type = Files::QUESTION_ATTACHMENT) {

        $files = new Files();

        $questionAttachments = $files->getFiles($entity_id, $type);

        if (intval($entity_id) < 0 || count($questionAttachments) < 1) {
            die("Not found");
        }
        $filesPath = array_column($questionAttachments, 'file_path');


        $files->create_zip("Question", $questionAttachments);
    }

    function setup_file() {
        $post = Syspage::getPostedVar();
        if ($post['action'] == "upload_file") {
            $response = "";

            if ($_FILES['fileupload']['name'] != "" && $_FILES['fileupload']['error'] == 0) {
                $isUpload = uploadContributionFile($_FILES['fileupload']['tmp_name'], $_FILES['fileupload']['name'], $response);
                if ($isUpload) {
                    $fls = new Files();
                    $dat['file_record_type'] = Question::REPLY_TYPE;
                    $dat['file_record_id'] = '';
                    $dat['file_path'] = $response;
                    $dat['file_display_name'] = $_FILES['fileupload']['name'];
                    $dat['file_display_order'] = 0;
                    $file_id = $fls->addFile($dat);


                    dieJsonSuccess(array($dat['file_display_name'], $file_id));
                } else {
                    dieJsonError($response);
                }
            } else {
                dieJsonError("NO_FILES_UPLOADED.");
            }
            dieJsonError("NO_FILES_UPLOADED.");
        }
    }
	
	function getPaypalOrderForm(){
		
		$frm = new Form('frmPay');
		$frm->addHiddenField('','cmd','_xclick');
		$frm->addHiddenField('','business',CONF_PAYPAL_BUSINESS_ACCOUNT_EMAIL);
		$frm->addHiddenField('','charset','utf-8');
		$frm->addHiddenField('','currency_code',"");
		$frm->addHiddenField('','item_name','');
		$frm->addHiddenField('','amount','');
		$frm->addHiddenField('','quantity','');
		$frm->addHiddenField('','image_url', generateAbsoluteUrl('image','site_logo',array(),CONF_WEBROOT_URL));
		$frm->addHiddenField('','custom','');
	//	$frm->addHiddenField('','rm',"2");
		$frm->addHiddenField('','return', generateAbsoluteUrl("account","success"));
		$frm->addHiddenField('','cancel_return',generateAbsoluteUrl("account","cancel"));
#		$frm->addHiddenField('','notify_url', getAbsoluteUrl(generateUrl("order","notify")));
		$frm->addHiddenField('','notify_url',getUrlScheme()."/public/index_noauth.php?url=ping/subscription");
		//$frm->setExtra(' id="frmPay" action= "https://www.sandbox.paypal.com/cgi-bin/webscr " ');
		$frm->setId("frmPay");
		$action = "https://www.sandbox.paypal.com/cgi-bin/webscr"; 
		if(CONF_PAYPAL_MODE == 1){
			$action = "https://www.paypal.com/cgi-bin/webscr";
		}
		$frm->setAction($action);
		//$frm->setExtra('action= "https://www.sandbox.paypal.com/cgi-bin/webscr " ');
		return $frm;
	}

	
	/* function getPaypalOrderForm(){
		$frm = new Form('frmPay');
		$frm->addTextBox('','cmd','_xclick');
		$frm->addTextBox('','business',CONF_PAYPAL_BUSINESS_ACCOUNT_EMAIL);
		$frm->addTextBox('','charset','utf-8');
		$frm->addTextBox('','currency_code',"");
		$frm->addTextBox('','item_name','');
		$frm->addTextBox('','amount','');
		$frm->addTextBox('','quantity','');
		$frm->addTextBox('','image_url', generateAbsoluteUrl('image','site_logo',array(),CONF_WEBROOT_URL));
		$frm->addTextBox('','custom','');
	//	$frm->addHiddenField('','rm',"2");
		//$frm->addTextBox('','return', generateAbsoluteUrl("order","success"));
		//$frm->addTextBox('','cancel_return',generateAbsoluteUrl("order","cancel"));
#		$frm->addHiddenField('','notify_url', getAbsoluteUrl(generateUrl("order","notify")));
		$frm->addTextBox('','notify_url',getUrlScheme()."/public/index_noauth.php?url=ping/subscription");
		//$frm->setExtra(' id="frmPay" action= "https://www.sandbox.paypal.com/cgi-bin/webscr " ');
		$frm->setId("frmPay");
		$action = "https://www.sandbox.paypal.com/cgi-bin/webscr"; 
		if(CONF_PAYPAL_MODE == 1){
			$action = "https://www.paypal.com/cgi-bin/webscr";
		}
		$frm->setAction($action);
		//$frm->setExtra('action= "https://www.sandbox.paypal.com/cgi-bin/webscr " ');
		return $frm;
	} */
}
