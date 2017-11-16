<?php

class HomeController extends FrontController {

    function default_action() {		
        $questionFrm = Question::getQuestionForm();
		/* $questionFrm->addSubmitButton('', 'btn_login', 'Get your answer', 'btn_login', 'class="ask button button--fill button--secondary"'); */
        $this->set('categories', Medicalcategory::getCategoriesForQuestion()->fetch_all());
		$postedData = Syspage::getPostedVar();
		$postedData['step']=1;
		$questionFrm->fill($postedData);
        $this->set('questionFrm', $questionFrm);


        $docs = Doctor::getActiveDoctores();  
		
        $this->set('activedocs', $docs->fetch_all());
		

        //Get Unanswered Questions
        $unansweredQuest = $this->getRecentlyAskedQuestion(); 
        $this->set('unansweredQuest', $unansweredQuest->fetch_all());

        //Get Closed Questions
        $answeredQuest = $this->getRecentAnsweredQuestion();
	
        $this->set('answeredQuest', $answeredQuest->fetch_all());
		
		/*new page*/
		$bannerObj=new Banners();
		$home_banners=$bannerObj->getHomePageBanners();		
		
		$home_page_elements=array("banners"=>$home_banners);
		$this->set('home_page_elements',$home_page_elements);
		$testimonial = new Testimonials();
		$testimonials=$testimonial->getTestimonials(array());
	    $this->set('testimonials',$testimonials);
		$blog = new Blog();
		$page = 1;  
		$pagesize = 2;
		$post['page'] = $page;
		$post['pagesize'] = $pagesize;
		$post_data = $blog->getBlogPosts($post);
		
            $posts = array();
            if ($post_data) {
                foreach ($post_data as $pd) {
                    /* get post categories[ */
                    $pd['post_categories'] = array();
                    $pd['post_categories'] = $blog->getPostCategories(array('post_id' => $pd['post_id']));
                    /* ] */
                    $posts[] = $pd;
                }
            }
			
		$this->set('blog_posts', $posts);
		$this->set('page_type', 'home');
        $this->_template->render();
    }

    public function viewquestion($question_id) {
        $quest = new Question();
        $srch = $quest->getReplies();
        $srch->addCondition('reply_orquestion_id', '=', intval($question_id));
        $srch->addGroupBy('reply_id');
        $this->set('reply', $srch->fetch());
        $this->_template->render(false, false);
    }

    function message_common() {
        $this->_template->render();
    }
	function youtube_video()
	{
		$this->_template->render(false,false);
	}
	function Questionform() {		
		$data = '';
		$step = Syspage::getPostedVar('step');		
		$frm = $this->getQuestionForm($step);
		$session_step = 'step_'.$step;		
		if(isset($_SESSION[$session_step]))
			{				
				$data = $_SESSION[$session_step];
			}
		$_SESSION['step'] = $step;
		
		if($data!='')
		{
			$frm->fill($data);
		}
		//$frm->addButton('', 'btn_login', 'Next Step', 'btn_login', 'onclick="return submitForm(this,Questionvalidator);" class="ask button button--fill button--secondary"');
		$this->set('step', $step);
        $this->set('questionFrm', $frm);
			
		 if ($step == Question::STEP_2){			 
			 $this->set('right_block','QUESTION_POST_STEP2_RIGHT_BLOCK');
			 $this->_template->render(false,false,"common/question/step2.php");
			} 
		else if($step == Question::STEP_3){	
			$this->set('right_block','QUESTION_POST_STEP3_RIGHT_BLOCK');		
			$this->_template->render(false,false,"common/question/step3.php");
			}
		else if($step == Question::STEP_4){
			$this->set('right_block','QUESTION_POST_STEP4_RIGHT_BLOCK');
			$this->_template->render(false,false,"common/question/step4.php");
			}
		else if($step == Question::STEP_5){	
			$this->set('right_block','QUESTION_POST_STEP5_RIGHT_BLOCK');
			$this->_template->render(false,false,"common/question/step5.php");
			}
				
		
    }

 /*    function getQuestionForm($step = Question::STEP_1) {
		
        $frm = new Form('frmQuestionForm', 'frmQuestionForm');
        $frm->setExtra(' class="form form__horizontal"');
        $frm->setJsErrorDisplay('beforefield');
			
		if($step == Question::STEP_1)
			{
				$frm->setAction(generateUrl('askquestion'));
				$categories = Medicalcategory::getActiveCategories()->fetch_all_assoc();				
				$frm->addRadioButtons(Utilities::getLabel('LBL_Medical_Category'), 'orquestion_med_category', $categories, key($categories), '', 'style="display:none"')->requirements()->setRequired();
				$frm->addTextArea(Utilities::getLabel('LBL_Medical_Question'), 'orquestion_question', '', 'orquestion_question', 'placeholder="Hi,can I answer your health question? Please type your question here..."')->requirements()->setRequired();
				$fld = $frm->addFileUpload('', 'fileupload', 'file-1','class="inputfile inputfile-1"');
				$frm->addHiddenField('', 'step', Question::STEP_1);
				$frm->addHiddenField('', 'file_name');
				$frm->setValidatorJsObjectName('Questionvalidator');
				$frm->addSubmitButton('', 'btn_login', Utilities::getLabel('LBL_Get_your_answer'), 'btn_login', 'class="ask button button--fill button--secondary"');
		
			}
		if($step == Question::STEP_2)
			{
				$frm->addTextArea(Utilities::getLabel('LBL_Medical_History'), 'orquestion_med_history', '', '', 'placeholder="Medical History"')->requirements()->setRequired();
				$frm->addTextBox(Utilities::getLabel('LBL_Name'),'orquestion_name','','orquestion_name','placeholder="Enter Your Name"')->requirements()->setRequired(false);
				$frm->addSelectBox(Utilities::getLabel('LBL_Age'), 'orquestion_age', Applicationconstants::$arr_age_year, '', '')->requirements()->setRequired();
				$frm->addSelectBox(Utilities::getLabel('LBL_Weight_(in_Kgs)'), 'orquestion_weight', Applicationconstants::$arr_weight_kgs, '', '')->requirements()->setRequired();
				$frm->addSelectBox(Utilities::getLabel('LBL_Gender'), 'orquestion_gender', Applicationconstants::$arr_gender, '', '')->requirements()->setRequired();				
				$frm->addSelectBox(Utilities::getLabel('LBL_Select_State'), 'orquestion_state', State::getactiveStates()->fetch_all_assoc(), '', '')->requirements()->setRequired();
				$frm->addTextBox(Utilities::getLabel('LBL_Phone_Number'),'orquestion_phone','','orquestion_phone','placeholder="Enter Phone Number"')->requirements()->setRequired();
				$frm->addEmailField(Utilities::getLabel('LBL_Email'),'orquestion_email','','orquestion_email','placeholder="Enter Your Email"')->requirements()->setRequired(false);
				$frm->addCheckBox( '', 'orquestion_term', '1' ,'term');	
				$frm->addHiddenField('', 'step', Question::STEP_2);

				$frm->addButton('', 'btn_login', Utilities::getLabel('LBL_Next_Step'), 'btn_login', 'onclick="return submitForm(this,Questionvalidator);" class="ask button button--fill button--secondary"');			
				
				
			}
		if($step == Question::STEP_3)
			{
				$frm->addHiddenField(Utilities::getLabel('Doctor_Selection'), 'orquestion_doctor_id', '','doctor_id')->requirements()->setRequired();;
				$frm->addHiddenField('', 'step', Question::STEP_3);							
				$srch_relate = Doctor::getDoctores();		
				$med_category = $_SESSION['step_1']['orquestion_med_category'];		
				$srch_relate->addCondition('doctor_med_category', '=',$med_category);		
				$related_doctor_data = $srch_relate->fetch_all();
				
				if(!empty($related_doctor_data))
				{
					foreach($related_doctor_data as $key=>$value)
					{
						$all_doctor_data[$key] = $value;
						$all_doctor_data[$key]['rating']=$this->getAverageDoctorRating($value['doctor_id']);
						$all_doctor_data[$key]['answers']=$this->getAnswersCount($value['doctor_id']);
					}
				}
				$this->set('related_doctor_data',$all_doctor_data);
				
				$frm->addButton('', 'btn_login',Utilities::getLabel('LBL_Next_Step'), 'btn_login', 'onclick="return submitForm(this,Questionvalidator);" class="ask button button--fill button--secondary"');
			}
		if($step == Question::STEP_4)
			{
				$frm->addHiddenField(Utilities::getLabel('LBL_Subscription'), 'subscription_id', '','subscription_id')->requirements()->setRequired();
				$frm->addHiddenField('', 'step', Question::STEP_4);
				if (Members::isUserLogged()) {
					$user_id = Members::getLoggedUserID();
					if($this->CheckIfUserHasSubs($user_id))
					{						
						echo true;
						die;
					}
				}
				$frm->addButton('', 'btn_login',Utilities::getLabel('LBL_Next_Step'), 'btn_login', 'onclick="return submitForm(this,Questionvalidator);" class="ask button button--fill button--secondary"');				
               
			}
		if($step == Question::STEP_5)
			{
				$this->createTmpOrder();				
				//$post['post_question'] = $post_question;
				$checkOutFrm = $this->getCheckoutForm();
				if (Members::isUserLogged()) {
					$post['user_email'] = Members::getLoggedUserAttribute('user_email');
				}
				$checkOutFrm->fill($post);
				$this->set('checkOutFrm', $checkOutFrm);
				$frm->setAction(generateUrl('askQuestion', 'questionCheckout'));			    
				$frm->addHiddenField('', 'step', Question::STEP_5);
               
			}
        $frm->setValidatorJsObjectName('Questionvalidator');
        $frm->setJsErrorDisplay('afterfield');
        return $frm;
    }	
	
 */
     function questionsetup($header_include = true) {	
		$category = new Medicalcategory();
		//$step = $_SESSION['step'] = Question::STEP_2;
		 if(isset($_SESSION['step']))
		{
			$step = $_SESSION['step'];
		}
		else{
			$step = $_SESSION['step'] = Question::STEP_2;
		} 			
        $post = Syspage::getPostedVar();		
		if(!empty($post['orquestion_med_category']))
		{			
			$cat_data = $category->getData($post['orquestion_med_category']);
			$category_name = $cat_data['category_name'];			
			$this->set('cat_data', $cat_data);
			$this->set('question', $post['orquestion_question']);
			$_SESSION['step_1'] = $post;
		}    
        //Handles The attachement
        if ($_FILES['fileupload']['name'] != "") {			
            if (!$file_name = $this->uploadFile()) {
                return false;
            }
            $post['file_name'] = $file_name; 			
			$this->set('attchment', $post['file_name']);
			$_SESSION['step_1']['attachment'] = $post['file_name'];
        }	
		
		
		if (!isset($_SESSION['step_1'])) {
			$frm1 = $this->getQuestionForm(Question::STEP_1);
			if (!$frm1->validate($post)) {
            Message::addErrorMessage($frm1->getValidationErrors());
			redirectUser(generateUrl());
			}
            
        }else{
			
			$attach = isset($_SESSION['step_1']['attachment'])?$_SESSION['step_1']['attachment']:'';
			$cat_data = $category->getData($_SESSION['step_1']['orquestion_med_category']);
			$this->set('cat_data', $cat_data);
			$this->set('question', $_SESSION['step_1']['orquestion_question']);
			$this->set('attchment',$attach );
		}		       
        $this->set('step', $step);       	
		if(!$header_include )
		{			
			$this->_template->render(false,false);
		}
		
		else{
			$this->_template->render();
		}
    }
	function step3() {			
				
        $post = Syspage::getPostedVar();		
		if(!empty($post['orquestion_name']))
		{
			$_SESSION['step_2'] = $post;
		} 		
		if (!isset($_SESSION['step_2'])) {
			
			$frm1 = $this->getQuestionForm(Question::STEP_2);
			if (!$frm1->validate($post)) {				
            Message::addErrorMessage($frm1->getValidationErrors());
			echo false;	
			die;
			}
        }
		$step = $_SESSION['step'] = Question::STEP_3;
		$data = '';
		$frm = $this->getQuestionForm($step);		
		$session_step = 'step_'.$step;
		if(isset($_SESSION[$session_step]))
			{
				$data = $_SESSION[$session_step];
			}
		
		$frm->fill($data);
		$frm->getField('btn_login')->value = 'Next Step';
		
		$this->set('step', $step);
        $this->set('questionFrm', $frm);
			
		 if ($step == Question::STEP_2){			 
			 $this->set('right_block','QUESTION_POST_STEP2_RIGHT_BLOCK');
			 $this->_template->render(false,false,"common/question/step2.php");
			} 
		else if($step == Question::STEP_3){	
			$this->set('right_block','QUESTION_POST_STEP3_RIGHT_BLOCK');		
			$this->_template->render(false,false,"common/question/step3.php");
			}
		else if($step == Question::STEP_4){
			$this->set('right_block','QUESTION_POST_STEP4_RIGHT_BLOCK');
			$this->_template->render(false,false,"common/question/step4.php");
			}
		else if($step == Question::STEP_5){	
			$this->set('right_block','QUESTION_POST_STEP5_RIGHT_BLOCK');
			$this->_template->render(false,false,"common/question/step5.php");
			}
    }
	
	function step4() {	
		
		$step = $_SESSION['step'] = Question::STEP_4;		
        $post = Syspage::getPostedVar();		
		if(!empty($post['orquestion_doctor_id']))
		{
			$_SESSION['step_3'] = $post;
		} 		
		if (!isset($_SESSION['step_3'])) {
			$frm1 = $this->getQuestionForm(Question::STEP_3);
			if (!$frm1->validate($post)) {				
             Message::addErrorMessage($frm1->getValidationErrors());
            echo false;	
			die;
			}
           
        }
		$data = '';
		$frm = $this->getQuestionForm($step);
		$session_step = 'step_'.$step;
		if(isset($_SESSION[$session_step]))
			{
				$data = $_SESSION[$session_step];
			}
		
		$frm->fill($data);
		$frm->getField('btn_login')->value = 'Next Step';
		$this->set('step', $step);
        $this->set('questionFrm', $frm);
			
		 if ($step == Question::STEP_2){			 
			 $this->set('right_block','QUESTION_POST_STEP2_RIGHT_BLOCK');
			 $this->_template->render(false,false,"common/question/step2.php");
			} 
		else if($step == Question::STEP_3){	
			$this->set('right_block','QUESTION_POST_STEP3_RIGHT_BLOCK');		
			$this->_template->render(false,false,"common/question/step3.php");
			}
		else if($step == Question::STEP_4){
			$this->set('right_block','QUESTION_POST_STEP4_RIGHT_BLOCK');
			$this->_template->render(false,false,"common/question/step4.php");
			}
		else if($step == Question::STEP_5){	
			$this->set('right_block','QUESTION_POST_STEP5_RIGHT_BLOCK');
			$this->_template->render(false,false,"common/question/step5.php");
			}
    }
	function step5() {	
		
		$step = $_SESSION['step'] = Question::STEP_5;		
        $post = Syspage::getPostedVar();		
		if(!empty($post['subscription_id']))
		{
			$_SESSION['step_4'] = $post;
		} 		
		if (!isset($_SESSION['step_4'])) {
			$frm1 = $this->getQuestionForm(Question::STEP_4);
            Message::addErrorMessage($frm1->getValidationErrors());
            redirectUser(generateUrl());
        }
		$data = '';
		$frm = $this->getQuestionForm($step);
		$session_step = 'step_'.$step;
		if(isset($_SESSION[$session_step]))
			{
				$data = $_SESSION[$session_step];
			}
		$frm->fill($data);
		$frm->getField('btn_login')->value = 'Next Step';
		$this->set('step', $step);
        $this->set('questionFrm', $frm);
			
		 if ($step == Question::STEP_2){			 
			 $this->set('right_block','QUESTION_POST_STEP2_RIGHT_BLOCK');
			 $this->_template->render(false,false,"common/question/step2.php");
			} 
		else if($step == Question::STEP_3){	
			$this->set('right_block','QUESTION_POST_STEP3_RIGHT_BLOCK');		
			$this->_template->render(false,false,"common/question/step3.php");
			}
		else if($step == Question::STEP_4){
			$this->set('right_block','QUESTION_POST_STEP4_RIGHT_BLOCK');
			$this->_template->render(false,false,"common/question/step4.php");
			}
		else if($step == Question::STEP_5){	
			$this->set('right_block','QUESTION_POST_STEP5_RIGHT_BLOCK');
			$this->_template->render(false,false,"common/question/step5.php");
			}
    }
	
	function ajaxQuestionsetup($step) {
		
        $post = Syspage::getPostedVar();
		
		if(!empty($post['orquestion_med_category']))
		{
			$category = new Medicalcategory();
			$cat_data = $category->getData($post['orquestion_med_category']);
			$category_name = $cat_data['category_name'];			
			$this->set('cat_data', $cat_data);
			$this->set('question', $post['orquestion_question']);
		}
        $step = Syspage::getPostedVar('step');
		
        $frm = $this->getQuestionForm();
		$frm->addButton('', 'btn_login', 'Get your answer', 'btn_login', 'onclick="return submitForm(this,Questionvalidator);" class="ask button button--fill button--secondary"');
		$step2frm = $this->getStep2HiddenForm();

        $post['btn_login'] = 'Next Step';

        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl());
        }
        
        //Handles The attachement
        if ($_FILES['fileupload']['name'] != "") {
			
            if (!$file_name = $this->uploadFile()) {
                return false;
            }
			
            $post['file_name'] = $file_name;
 			
			 // piece1
			$this->set('attchment', $post['file_name']);
        }		
      // $frm->setAction(generateUrl('home', 'questionsetup'));

        switch ($step) {
            case 'step-3':
				$frm->getField('orquestion_doctor_id')->requirements()->setRequired();				
				$srch_relate = Doctor::getDoctores();		
				$med_category = $post['orquestion_med_category'];		
				$srch_relate->addCondition('doctor_med_category', '=',$med_category);		
				$related_doctor_data = $srch_relate->fetch_all();
				
				if(!empty($related_doctor_data))
				{
					foreach($related_doctor_data as $key=>$value)
					{
						$all_doctor_data[$key] = $value;
						$all_doctor_data[$key]['rating']=$this->getAverageDoctorRating($value['doctor_id']);
						$all_doctor_data[$key]['answers']=$this->getAnswersCount($value['doctor_id']);
					}
				}
				$this->set('related_doctor_data',$all_doctor_data);
                $post['step'] = 'step-4';
                break;
            case 'step-4':
				if (Members::isUserLogged()) {
					$user_id = Members::getLoggedUserID();
					if($this->CheckIfUserHasSubs($user_id))
					{						
						echo true;
						die;
					}
				}
				$frm->getField('subscription_id')->requirements()->setRequired();
				$post['step'] = 'step-5';								
                break;                

            case 'step-5':
				$post = Syspage::getPostedVar();
				$frm = $this->getQuestionForm();
				if (!$frm->validate($post)) {					
				Message::addErrorMessage($frm->getValidationErrors());
				redirectUser(generateUrl(''));
				}

			//To main the customer count for the report
				$this->createTmpOrder();

				$post_question = serialize($post);
				//unset($post);
				$post['post_question'] = $post_question;

/* 
				$total_doctors = $this->getDoctors();
				$this->set('total_doctors', $total_doctors);
				$latest_review = $this->getLatestReview();
				$this->set('latest_review', $latest_review); */
				$checkOutFrm = $this->getCheckoutForm();
				if (Members::isUserLogged()) {
					$post['user_email'] = Members::getLoggedUserAttribute('user_email');
				}
				$checkOutFrm->fill($post);
				$this->set('checkOutFrm', $checkOutFrm);
				$frm->setAction(generateUrl('askQuestion', 'questionCheckout'));
			    $post['step'] = 'step-6';
				

                break;
            case 'step-6':
                //$frm->setAction(generateUrl('askQuestion', 'account'));
                break;
            default:				
                Message::getHtml();
                $post['step'] = 'step-3';
                $frm->getField('orquestion_med_history')->requirements()->setRequired();
				
				$frm->getField('orquestion_gender')->requirements()->setRequired();
				$fld=$frm->getField('orquestion_age');
				$fld->requirements()->setRequired();
				$fld=$frm->getField('orquestion_weight');
				$fld->requirements()->setRequired();
				$frm->getField('orquestion_state')->requirements()->setRequired();
				$frm->getField('orquestion_phone');
				$user_id=Members::getLoggedUserID();		
				if(!$user_id ){					
				$frm->getField('orquestion_name')->requirements()->setRequired();
				$frm->getField('orquestion_email')->requirements()->setRequired();	
				}				
				$frm->getField('orquestion_term')->requirements()->setRequired();				
                break;
        }
        $frm->setValidatorJsObjectName('Questionvalidator');
		$user_id=Members::getLoggedUserID();		
         if($user_id != '' && $user_id != 0){
		 //$user = new Users();
		$users = Users::searchUser();
		
		$users->addCondition('user_id','=',$user_id);
		$userdata = $users->fetch();
		/* echo "<pre>";
		print_r($userdata);  
		die;  */
		} 		
       // $frm->setOnSubmit('return submitForm(this,Questionvalidator); return false;');
        $frm->fill($post);
        $this->set('step', $step);
        $this->set('questionFrm', $frm);
		if(isset($post['is_ajax_request']) && ($post['is_ajax_request'] == 1) )
		{
		
		 if ($step == 'step-2'){
			 $this->set('right_block','QUESTION_POST_STEP2_RIGHT_BLOCK');
			 $this->_template->render(false,false,"common/question/ask-step_main.php");
			} 
		else if($step == 'step-3'){	
			$this->set('right_block','QUESTION_POST_STEP3_RIGHT_BLOCK');		
			$this->_template->render(false,false,"common/question/step3.php");
			}
		else if($step == 'step-4'){
			$this->set('right_block','QUESTION_POST_STEP4_RIGHT_BLOCK');
			$this->_template->render(false,false,"common/question/step4.php");
			}
		else if($step == 'step-5'){	
			$this->set('right_block','QUESTION_POST_STEP5_RIGHT_BLOCK');
			$this->_template->render(false,false,"common/question/step5.php");
			}
				
		}
		
		else{
			$this->_template->render();
		}
    }

    function getLoginForm() {
        
    }

    public function uploadFile() {
        if ($_FILES['fileupload']['error'] == 0 && uploadContributionFile($_FILES['fileupload']['tmp_name'], $_FILES['fileupload']['name'], $response)) {

            return $response."-".$_FILES['fileupload']['name'];
        } else {
            return false;
        }
    }

    public function udpate_activity() {
        die();
    }

    public function get_udpates() {
        $docs = Doctor::onlineDoctors();
        $docs->addFld('count(*) as docs');
        $docsCount = $docs->fetch();
        die(convertToJson($docsCount));
    }

    function getRecentlyAskedQuestion() {


        $srch = Question::searchActiveQuestions();
        $srch->addMultipleFields(array('orquestion_id', 'order_date', 'order_id', 'orquestion_question', 'CONCAT(user_first_name," ",user_last_name) as username'));
        //  $srch->addCondition('orquestion_status', '=', Question::QUESTION_PENDING, 'AND');
        // $srch->addCondition('orquestion_status', '=', Question::QUESTION_ACCEPTED, 'OR');
		$srch->addOrder('orquestion_id','desc');
        $srch->setPageSize(5);
        $srch->setPageNumber(1);

        return $srch;
    }

    function getRecentAnsweredQuestion() {


        $srch = Question::searchActiveQuestions();
        $srch->addMultipleFields(array('orquestion_id', 'order_date', 'order_id', 'orquestion_question', 'CONCAT(user_first_name," ",user_last_name) as username','CONCAT(doctor_first_name," ",doctor_last_name) as doctor_username','category_name','getTextWithoutTags(reply_text) as reply_text'));

        $srch->addCondition('orquestion_reply_status', '=', Question::REPLY_APPROVED);
        $srch->setPageSize(5);
        $srch->setPageNumber(1);
        $srch->addOrder('orquestion_replied_at', 'desc');
        $srch->addGroupBy('orquestion_id');
       

        return $srch;
    }
	
	function get_self_attachment($file_name)
	{
		
		$filename = explode("-",$file_name);	
	
		$filename1 = $filename[0];
		
		$filename2 = $filename[1]; 
            $zip = new ZipArchive();
            $assignZip = $type . time() . ".zip";
            $path = CONF_INSTALLATION_PATH . 'user-uploads/';
            if (file_exists($path . $assignZip)) {
                unlink($path . $assignZip);
            }
            if ($zip->open($path . $assignZip, ZIPARCHIVE::CREATE) != TRUE) {
                die("Could not open archive");
            }
            $i = 0;          
           
           
                $ext = array_pop(explode(".", $filename2));
                $base = str_replace("." . $ext, "", $filename2);
                $finalName = $base . "_" . time() . "_" . $i++ . "." . $ext;

                $download_file = file_get_contents($path . $filename1);
				
                $zip->addFromString(basename($finalName), $download_file);
           
            $zip->close();
            $now = gmdate("D, d M Y H:i:s");
            header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
            header("Last-Modified: {$now} GMT");
            // force download  
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");
            // disposition / encoding on response body
            header("Content-Disposition: attachment;filename=$assignZip");
            header("Content-Transfer-Encoding: binary");
            echo file_get_contents(CONF_INSTALLATION_PATH . 'user-uploads/' . $assignZip);
            unlink($path . $assignZip);
            die;
        }
	

	
	private function CheckIfUserHasSubs($user_id) {

        $srchSubs = Usersubscription::getUserActiveSubsByUserId($user_id);
		
        $subs = $srchSubs->fetch();
		
        if (!$srchSubs->recordCount()) {
            return false;
        }
		
        $post = isset($_SESSION['step_2'])?$_SESSION['step_2']:'';	
				
		$post = array_merge($post,$_SESSION['step_3'],$_SESSION['step_1']);	
			
        $subs_id = $subs['orsubs_id'];
        $data = array_merge($post, array('payment_mode' => Orderabstract::ORDER_SUBSCRIPTION, 'order_type' => Orderabstract::ORDER_QUESTION, 'order_amount' => 0, 'payment_by' => Orderabstract::PAYMENT_BY_SUBSCRIPTION,'tran_completed'=>1));
		
        $questionPost = new Subscriptionquestionpayment($data);
		
        $questionPost->sub_id = $subs_id;
        $questionPost->user_id = $user_id;

        if (!$questionPost->execute()) {
            Message::addErrorMessage('Problem while posting a question.Try Again later');
        } else {
            Message::addMessage('Question Posted Successfully');
        }
		
		return true;
		//redirectUserWithData(generateUrl(''));
        //redirectUser(generateUrl(''));
    }
	
	

		
	

}
