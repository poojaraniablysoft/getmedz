<?php

class askQuestionController extends Controller {

    public function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);
    }

    private function CheckIfUserHasSubs($user_id) {
		
		if($user_id<1){
			return false;
		}

        $srchSubs = Usersubscription::getUserActiveSubsByUserId($user_id);
        $srchSubs->addOrder('orsubs_id','desc');
        $srchSubs->addGroupBy('order_id');
        $subs = $srchSubs->fetch();
	
        if (!$srchSubs->recordCount()) {
            return false;
        }
		if($subs['orsubs_question_allowed']>$subs['totalPostedQuestion']){
			return $subs;
		}else{
			return false;
		}
		
       
    }

    function getDoctors() {
        global $db;
        $srch = Doctor::searchDoctor();
        $srch->addCondition('doctor_active', '=', 1);
        $rs = $srch->getResultSet();
        $total_records = $srch->recordCount();
        return $total_records;
    }

    function default_action() {
		if (!Members::isCustomerLogged()) {
			Message::addErrorMessage(Utilities::getLabel('LBL_Please_login_with_cutomer_account'));
			redirectUser(Utilities::generateUrl());
		}
		$step = Syspage::getPostedVar('step');	
		$postedData = Syspage::getPostedVar();	
		if(!isset($_POST) && $step!=1){
			redirectUser(Utilities::generateUrl());
		}
        $questionFrm = Question::getQuestionForm();
		$category = new Medicalcategory();
		$cat_data = $category->getData($postedData['orquestion_med_category']);
		$category_name = $cat_data['category_name'];			
		$this->set('cat_data', $cat_data);
		$this->set('question', $postedData['orquestion_question']);
		
        if($step==0){
			redirectUser(generateUrl());
		}
		
		
         if ($step == Question::STEP_1){
				$questionFrm->getField('orquestion_email')->requirements()->setRequired(false);
				if (!$questionFrm->validate($postedData)) {
					Message::addErrorMessage($questionFrm->getValidationErrors());
					redirectUser(generateUrl());
				}			
			  //Handles The attachement
				if ($_FILES['fileupload']['name'] != "") {
					if (!$file_name = $this->uploadFile()) {
						return false;
					}

					$postedData['file_name'] = $file_name;
				}
				$postedData['step'] =2;
				$step++;
				$_SESSION['step_1']['attachment'] = $postedData['file_name'];
				
				
				// Dummy Data //
				if(Members::getLoggedUserID()&& $postedData['orquestion_name']=='' && $postedData['orquestion_gender']=='' && $postedData['orquestion_age']=='' && $postedData['orquestion_weight']=='' && $postedData['orquestion_state']=='' && $postedData['orquestion_phone']==''  && $postedData['orquestion_email']=='' ){
					$members = new Members();
					$userData = $members->getCustomerData(Members::getLoggedUserID());
					$postedData['orquestion_name']=$userData['user_first_name'];
					$postedData['orquestion_gender']=$userData['user_gender'];
					$postedData['orquestion_age']=$userData['user_age'];
					$postedData['orquestion_weight']=$userData['user_weight'];
					$postedData['orquestion_state']=$userData['user_state'];
					$postedData['orquestion_phone']=$userData['user_phone'];
					$postedData['orquestion_email']=$userData['user_email'];
					$postedData['orquestion_age']=$userData['user_age'];
					$postedData['orquestion_weight']=$userData['user_weight'];
				}
				/* $postedData['orquestion_med_history']=($postedData['orquestion_med_history']=='')?'Testing Medical History':$postedData['orquestion_med_history'];
				$postedData['orquestion_name']=($postedData['orquestion_name']=='')?'Pooja'.time():$postedData['orquestion_name'];;
				$postedData['orquestion_gender']=($postedData['orquestion_gender']=='')?rand(1,2):$postedData['orquestion_gender'];;
				$postedData['orquestion_age']=($postedData['orquestion_age']=='')?'10-17':$postedData['orquestion_age'];;
				$postedData['orquestion_weight']=($postedData['orquestion_weight']=='')?'30-40':$postedData['orquestion_weight'];;
				$postedData['orquestion_state']=($postedData['orquestion_state']=='')?'5':$postedData['orquestion_state'];;
				$postedData['orquestion_phone']=($postedData['orquestion_phone']=='')?rand(10000,500000):$postedData['orquestion_phone'];;
				$postedData['orquestion_email']=($postedData['orquestion_email']=='')?$postedData['orquestion_name'].'@dummyid.com':$postedData['orquestion_email'];; */
					
			} 
		else if($step == Question::STEP_2){	
				$questionFrm->getField('orquestion_med_category')->requirements()->setRequired();
				$questionFrm->getField('orquestion_question')->requirements()->setRequired();
				$questionFrm->getField('orquestion_term')->requirements()->setRequired();
				$questionFrm->getField('orquestion_med_history')->requirements()->setRequired();
				$questionFrm->getField('orquestion_name')->requirements()->setRequired();
				$questionFrm->getField('orquestion_gender')->requirements()->setRequired();
				$questionFrm->getField('orquestion_age')->requirements()->setRequired();
				$questionFrm->getField('orquestion_weight')->requirements()->setRequired();
				if(!Members::getLoggedUserID()){
					$required = true;
				}else{
					$required = false;
				}
				$questionFrm->getField('orquestion_email')->requirements()->setRequired($required);
				$questionFrm->getField('orquestion_state')->requirements()->setRequired();
				if (!$questionFrm->validate($postedData)) {
					Message::addErrorMessage($questionFrm->getValidationErrors());
					$postedData['step'] =2;
				}else{
				
					$postedData['step'] =3;
					$step++;
				}
		
				
				
				
			
			}
		else if($step == Question::STEP_3){
			
			$questionFrm->getField('orquestion_med_category')->requirements()->setRequired();
			$questionFrm->getField('orquestion_question')->requirements()->setRequired();
			$questionFrm->getField('orquestion_med_history')->requirements()->setRequired();
			$questionFrm->getField('orquestion_name')->requirements()->setRequired();
			$questionFrm->getField('orquestion_gender')->requirements()->setRequired();
			$questionFrm->getField('orquestion_age')->requirements()->setRequired();
			$questionFrm->getField('orquestion_weight')->requirements()->setRequired();
			if(!Members::getLoggedUserID()){
					$required = true;
				}else{
					$required = false;
				}
				$questionFrm->getField('orquestion_email')->requirements()->setRequired($required);
			$questionFrm->getField('orquestion_state')->requirements()->setRequired();
			$questionFrm->getField('orquestion_doctor_id')->requirements()->setRequired();
			if (!$questionFrm->validate($postedData)) {
				Message::addErrorMessage($questionFrm->getValidationErrors());
				$postedData['step'] =3;
			}else{
				
				$postedData['step'] =4;
				$step++;
			}
			
			
			if($subs = $this->CheckIfUserHasSubs(Members::getLoggedUserID())){
					
				$subs_id = $subs['orsubs_id'];
				$data = array_merge($postedData, array('payment_mode' => Orderabstract::ORDER_SUBSCRIPTION, 'order_type' => Orderabstract::ORDER_SUBSCRIPTION, 'order_amount' => 0, 'payment_by' => Orderabstract::PAYMENT_BY_SUBSCRIPTION,'tran_completed'=>1,'subs_id'=>$subs_id,'order_id'=>$subs['order_id']));
				
				$questionPost = new Subscriptionquestionpayment($data);
			
				$questionPost->sub_id = $subs_id;
				$questionPost->user_id = Members::getLoggedUserID();
				if (!$questionPost->execute()) {
					Message::addErrorMessage('Problem while posting a question.Try Again later');
				} else {
					
					Message::addMessage('Question Posted successfully');
					
				}
				
		
		redirectUser(generateUrl('', ''));
					
					
			}
		
			
		}
		else if($step == Question::STEP_4){	
		
		
			$questionFrm->getField('orquestion_med_category')->requirements()->setRequired();
			$questionFrm->getField('orquestion_question')->requirements()->setRequired();
			$questionFrm->getField('orquestion_med_history')->requirements()->setRequired();
			$questionFrm->getField('orquestion_name')->requirements()->setRequired();
			$questionFrm->getField('orquestion_gender')->requirements()->setRequired();
			$questionFrm->getField('orquestion_age')->requirements()->setRequired();
			$questionFrm->getField('orquestion_weight')->requirements()->setRequired();
			if(!Members::getLoggedUserID()){
					$required = true;
				}else{
					$required = false;
				}
			$questionFrm->getField('orquestion_email')->requirements()->setRequired($required);
			$questionFrm->getField('orquestion_state')->requirements()->setRequired();
			$questionFrm->getField('orquestion_doctor_id')->requirements()->setRequired();
			$questionFrm->getField('subscription_id')->requirements()->setRequired();
			if (!$questionFrm->validate($postedData)) {
				Message::addErrorMessage($questionFrm->getValidationErrors());
				$postedData['step'] =4;
			}else{
				
				$postedData['step'] =5;
							
				$post_question = '';
				//$orignalData = $post_question = Syspage::getPostedVar();
				
				//$post_question = unserialize($post['post_question']);
				$planType = intval($postedData['subscription_id']);		
				$srch = Subscription::getactiveSubscription();
				$srch->addCondition('subs_id', '=', $planType);
				
				$plan_data = $srch->fetch();
				if(!$plan_data){
					$postedData['step'] =4;
				}else{
					$postedData['step']=5;
					}
					
					$this->set('plan_data',$plan_data);
			}
			
			
			
			$step++;
				
					
				
				
				
				
				
				
				
			
		}elseif($step==Question::STEP_5){
			$questionFrm->getField('orquestion_med_category')->requirements()->setRequired();
			$questionFrm->getField('orquestion_question')->requirements()->setRequired();
			$questionFrm->getField('orquestion_med_history')->requirements()->setRequired();
			$questionFrm->getField('orquestion_name')->requirements()->setRequired();
			$questionFrm->getField('orquestion_gender')->requirements()->setRequired();
			$questionFrm->getField('orquestion_age')->requirements()->setRequired();
			$questionFrm->getField('orquestion_weight')->requirements()->setRequired();
			if(!Members::getLoggedUserID()){
					$required = true;
				}else{
					$required = false;
				}
				$questionFrm->getField('orquestion_email')->requirements()->setRequired($required);
			$questionFrm->getField('orquestion_state')->requirements()->setRequired();
			$questionFrm->getField('orquestion_doctor_id')->requirements()->setRequired();
			$questionFrm->getField('subscription_id')->requirements()->setRequired();
			if (!$questionFrm->validate($postedData)) {
				Message::addErrorMessage($questionFrm->getValidationErrors());
				$postedData['step'] =4;
			}else{
				$planType = intval($postedData['subscription_id']);		
				$srch = Subscription::getactiveSubscription();
				$srch->addCondition('subs_id', '=', $planType);
				
				$plan_data = $srch->fetch();
				if(!$plan_data){
					$postedData['step'] =4;
				}else{
						$this->createTmpOrder();	
						$post_question = $postedData;
						$post_question['payment_mode'] = $plan_data['subs_type'];
						$post_question['subs_id'] = $plan_data['subs_id'];
						$post_question['tran_plan_id'] = $planType;
						$post_question['payment_by'] = Orderabstract::PAYMENT_BY_CARD;
						$post_question['order_amount'] = $plan_data['subs_price'];

					   /*  $frm = $this->getCheckOutForm();

						if (!$frm->validate($post)) {
							Message::addErrorMessage($frm->getValidationErrors());
							redirectUser(generateUrl('askquestion', 'checkout'));
						} */
						/* $post_question['user_first_name']=$_SESSION['step_2']['orquestion_name'];
						$post_question['user_last_name']='';
						$post_question['user_email']=$_SESSION['step_2']['orquestion_email'];	 */
						
						$postedData = $post_question;
						
						$quesSetup = new OrderFactory(intval($postedData['payment_mode']), $postedData);
						$saveObj = $quesSetup->getInstance();	
						if (!$saveObj->execute()) {

							Message::addErrorMessage($saveObj->getError());
							redirectUser(generateUrl('', ''));
						}

						/* //Send Admin Question post email
						$Email = new Emails();
						$Email->questionList = array($saveObj->question_id);
						$Email->questionPostEmail();
 */
						
					//        $_SESSION['Ask_Guest']['user_id'] = $saveObj->user_id;
					//        //Token is valid for 15 min
					//        $_SESSION['Ask_Guest']['token'] = time() * 15 * 60;
					//        $_SESSION['Ask_Guest']['data'] =  array_merge($orignalData,array('order_id'=>$saveObj->order_id));
					//        
					//
					//
					//        redirectUser(generateUrl('account', 'setpassword'));
						//unset($post_question);
						if($plan_data['subs_price']>0){
							
								
								redirectUserWithData(generateAbsoluteUrl('account', 'checkoutpage'), array_merge($post_question, array('order_id' => $saveObj->order_id,'trans_id'=>$saveObj->trans_id)));
						
						}else{
							 $data = array_merge($postedData, array('payment_mode' => Orderabstract::ORDER_SUBSCRIPTION, 'order_type' => Orderabstract::ORDER_SUBSCRIPTION, 'order_amount' => 0, 'payment_by' => Orderabstract::PAYMENT_BY_FREE_PLAN,'tran_completed'=>1));
							
							$transaction = New Transactions();
		
		
							$user_id = $saveObj->user_id;
							$trans['tran_order_id'] = $saveObj->order_id;
							$trans['tran_amount'] = 0;
							$trans['tran_payment_mode'] = 1;
							$trans['tran_real_amount'] = $order['order_amount'];       
							$trans['tran_id'] = $transaction_data['tran_id'];
							$trans['tran_completed'] =  1;		
							$trans['tran_gateway_transaction_id'] = 'FREEPLAN-'.time() ;
							$trans['tran_gateway_response_data'] =  '';
							$ord = new Order();
							if ($transaction->addupdateTransaction($trans)) {
							
									$ord->updateOrderStatus($saveObj->order_id);
								
								Message::addMessage('Your Question has been posted successfully');
								redirectUser(generateUrl(''));
							}else{
								mail(CONF_ADMIN_EMAIL_ID,'Unable to update Transaction',serialize($trans));
								redirectUser(generateUrl(''));
							}
							 
						}
						
					}
			}
			
					
		}
			if($postedData['step']==3){
				$srch_relate = Doctor::getDoctores();		
				$med_category = $postedData['orquestion_med_category'];	
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
			}
			$this->set('step', $step);
			$this->set('postedData', $postedData);
			$this->set('attchment', $postedData['file_name']);
			$questionFrm->fill($postedData);
			$this->set('questionFrm', $questionFrm);
			$this->set('right_block',"QUESTION_POST_STEP".$step++."_RIGHT_BLOCK");
			$this->_template->render(true,true);
    }
	
	
	
		
		
		
	function getAverageDoctorRating($doctor_id) {

        global $db;
        $reviews = Review::searchReviews();

        $reviews->addMultipleFields(array('AVG(review_rating) as totalrating'));
		$reviews->addGroupBy('review_doctor_id');
		$reviews->addCondition('review_doctor_id','=',$doctor_id);
		
        $rs = $reviews->getResultSet();
        $records = $db->fetch($rs);
        $total_rating = $records['totalrating'];
        return $total_rating;
    }
	
	function getAnswersCount($doctor_id)
	{
		$Question = new Question();
		$srch = $Question->getReplies();
		$srch->addCondition('d.doctor_id', '=' ,$doctor_id  );
		
		$rs = $srch->getResultSet();
		$answer_count = $srch->recordCount();		
		return $answer_count;
	}
    function message_common() {
        $this->_template->render();
    }

   /*  function getQuestionForm() {
		
        $frm = new Form('frmQuestionForm', 'frmQuestionForm');
        $frm->setExtra(' class="form form__horizontal"');
        $frm->setJsErrorDisplay('beforefield');
        $categories = Medicalcategory::getActiveCategories()->fetch_all_assoc();
        $frm->setAction(generateUrl('askquestion'));
        $frm->addHiddenField('Medical Category', 'orquestion_med_category','', '', 'style="display:none"')->requirements()->setRequired();
		$frm->addTextBox('Name','orquestion_name','','orquestion_name','placeholder="Enter Your Name"');
        $frm->addTextArea('Medical Question', 'orquestion_question', '', 'orquestion_question', 'placeholder="Hi,can I answer your health question? Please type your question here..."')->requirements()->setRequired();
        $frm->addTextArea('Medical History', 'orquestion_med_history', '', '', 'placeholder="Medical History"');
        $frm->addSelectBox('Age', 'orquestion_age', Applicationconstants::$arr_age_year, '', '');
		$frm->addSelectBox('Weight (in Kgs)', 'orquestion_weight', Applicationconstants::$arr_weight_kgs, '', '');
		$frm->addSelectBox('Gender', 'orquestion_gender', Applicationconstants::$arr_gender, '', '');
        //$fld = $frm->addRadioButtons('Gender', 'orquestion_gender', Applicationconstants::$arr_gender, '', 2, 'class="lib_custom_radio"', 'class="custom_radio"');

        $fld = $frm->addFileUpload('', 'fileupload', 'browse');

        $fld->extra = 'onChange="getElementById(\'textfield\').value = getElementById(\'browse\').value;" class="HiddenField"';    

        $frm->addSelectBox('Select State', 'orquestion_state', State::getactiveStates()->fetch_all_assoc(), '', '');
		$frm->addTextBox('Phone Number','orquestion_phone','','orquestion_phone','placeholder="Enter Phone Number"');
		$emailFld = $frm->addEmailField('Email','orquestion_email','','orquestion_email','placeholder="Enter Your Email"');
		$emailFld->setUnique('tbl_users', 'user_email', 'user_id', 'user_email', 'user_email');
        $frm->addHiddenField('', 'step', 'step-1');
        $frm->addHiddenField('Subscription', 'subscription_id', '','subscription_id');
		$frm->addHiddenField('Doctor Selection', 'orquestion_doctor_id', '','doctor_id');
        $frm->addHiddenField('', 'file_name');
		$frm->addCheckBox( '', 'orquestion_term', '1' ,'term');
        $frm->addSubmitButton('', 'btn_login', Utilities::getLabel('LBL_Next'), 'btn_login', ' class="ask button button--fill button--secondary"');
        return $frm;
    } */
	public function uploadFile() {


        if ($_FILES['fileupload']['error'] == 0 && uploadContributionFile($_FILES['fileupload']['tmp_name'], $_FILES['fileupload']['name'], $response)) {

            return $response."-".$_FILES['fileupload']['name'];
        } else {
            return false;
        }
    }


    function account() {

        //In case Member is logged in
        $post = Syspage::getPostedVar();
        $frm = $this->getQuestionForm();

        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl(''));
        }

        //To main the customer count for the report
        $this->createTmpOrder();

        $post_question = serialize($post);
        unset($post);
        $post['post_question'] = $post_question;

        $total_doctors = $this->getDoctors();
        $this->set('total_doctors', $total_doctors);
        $latest_review = $this->getLatestReview();
        $this->set('latest_review', $latest_review);
        $checkOutFrm = $this->getCheckoutForm();
        if (Members::isUserLogged()) {
            $post['user_email'] = Members::getLoggedUserAttribute('user_email');
        }
        $checkOutFrm->fill($post);
        $this->set('checkOutFrm', $checkOutFrm);
		$this->set('payment_gateway','paypal');

        $this->_template->render();
    }

    function getLatestReview() {
        $pagesize = 1;
        $page = 1;
        $srch = Review::searchReviews();
        $srch->addMultipleFields(array('review_text', 'CONCAT(user_first_name," ",user_last_name)as user_name'));
        $srch->setPageSize($pagesize);
        $srch->setPageNumber($page);
        $srch->addOrder('review_id', 'desc');
        $review = $srch->fetch();
        return $review;
    }

    public function createTmpOrder() {
        $createTmpOrder = new Tmporders();
        $createTmpOrder->tmpOrderSetup(array('tmp_session_id' => session_id()));
        session_regenerate_id(true);
        return true;
    }

    public function steps() {
        
    }

    function getCheckoutBtnForm() {

        $frm = new Form('frmCheckoutBtnForm', 'frmCheckoutBtnForm');
        $frm->setExtra(' class="table_form"');
        $frm->addHiddenField('', 'post_question');
        //   $frm->addRadioButtons('Payment Plan','payment_plan', Applicationconstants::$paymentPlans,"",1);
        $frm->setAction(generateUrl('askquestion', 'checkout'));
        $frm->addSubmitButton('', 'btn_checkout', 'Proceed To Checkout', 'btn_checkout', '');


        return $frm;
    }

    function checkout() {
        $post = Syspage::getPostedVar();
        $post_question = unserialize($post['post_question']);
        $planType = intval($post['payment_plan']);
        $srch = Subscription::getactiveSubscription();
        $srch->addCondition('subs_id', '=', $planType);
        $plan_data = $srch->fetch();
        $post_question['payment_mode'] = $plan_data['subs_type'];
        $post_question['subs_id'] = $plan_data['subs_id'];
        $post_question['tran_plan_id'] = $planType;

        $post_question['payment_by'] = Orderabstract::PAYMENT_BY_CARD;
        $post_question['order_amount'] = $plan_data['subs_price'];


        unset($post);
        $post['post_question'] = serialize($post_question);
        $checkOutFrm = $this->getCheckoutForm();
        $checkOutFrm->fill($post);
        $this->set('checkOutFrm', $checkOutFrm);
        $this->_template->render();
    }

    function getCheckOutForm() {
        $str == '';
        $frm = new Form('frmCheckoutForm', 'frmCheckoutForm');
        $frm->setExtra(' class="table_form"');
        $frm->setJsErrorDisplay('afterfield');
        $frm->setAction(generateUrl('askquestion', 'questionCheckout'));
        $frm->addRequiredField('Cardholder First Name', 'user_first_name', '', '', 'placeholder="Cardholder First Name"');
        $frm->addRequiredField('Cardholder Last Name', 'user_last_name', '', '', 'placeholder="Cardholder Last Name"');
        $fld=$frm->addRequiredField('Card Number', 'cardNumber', '', 'cardNumber', 'placeholder="Card Number"');
        $fld->requirements()->setIntPositive();
        //    $frm->addSelectBox('Card Type', 'cardType', Applicationconstants::$arr_card_type, '', '', 'Select Card Type')->requirements()->setRequired();
        $frm->addSelectBox('Expiration Date', 'expMonth', Applicationconstants::$arr_exp_month, date('m'), '', 'M')->requirements()->setRequired();
        
        $frm->addSelectBox('', 'expYear', getCardYearList(), date('Y'), '')->requirements()->setRequired();
       $fld= $frm->addRequiredField('Cvv No.', 'card_cvv_no', '', '', 'placeholder="CVV No."');
         $fld->requirements()->setIntPositive();
         
          $str= "onBlur='checkEmail(this)'";
        if (Members::isUserLogged()) {
            $str = "readonly=readonly";
        }
        
    
        $frm->addEmailField('Email Address', 'user_email', '', '', "   placeholder='Email Address' $str");
        $frm->addIntegerField('Biling zip', 'biling_zip', '', '', 'placeholder="Biling zip"');
        
        $frm->addSubmitButton('', 'btn_checkout', 'Submit Order', 'btn_checkout', 'class="ask"');
        $frm->addHiddenField('', 'post_question');
	$frm->setJsErrorDisplay('afterfield');

        return $frm;
    }

    function getCustomerLoginForm() {
        $frm = new Form('frmCustomerLogin', 'frmCustomerLogin');
        $frm->setExtra(' class="table_form final-right-frm-area"');
        $frm->setTableProperties(' class="form_tbl"');
        $frm->addEmailField('Email Address', 'user_email', '', '', 'placeholder="Email Address"')->requirements()->setRequired();

        $frm->addPasswordField('Password', 'user_password', '', '', 'placeholder="Password"')->requirements()->setRequired();

        $frm->setAction(generateUrl('members', 'validateCustomerLogin'));

        $frm->addHiddenField('Refer Page', 'page_reffer', $_SERVER['HTTP_REFERER']);
        $frm->addSubmitButton('', 'btn_login', 'Login', 'btn_login', 'class="btn_submit"');
        $frm->setValidatorJsObjectName('searchValidator');
        $frm->setOnSubmit('return submitlog(this, searchValidator);');
        return $frm;
    }

    public function questioncheckout() {
		$post_question = '';
        //$orignalData = $post_question = Syspage::getPostedVar();
		
        //$post_question = unserialize($post['post_question']);
        $planType = intval($_SESSION['step_4']['subscription_id']);		
        $srch = Subscription::getactiveSubscription();
        $srch->addCondition('subs_id', '=', $planType);
		
        $plan_data = $srch->fetch();
		
        $post_question['payment_mode'] = $plan_data['subs_type'];
        $post_question['subs_id'] = $plan_data['subs_id'];
        $post_question['tran_plan_id'] = $planType;
        $post_question['payment_by'] = Orderabstract::PAYMENT_BY_CARD;
        $post_question['order_amount'] = $plan_data['subs_price'];

       /*  $frm = $this->getCheckOutForm();

        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('askquestion', 'checkout'));
        } */
		$post_question['user_first_name']=$_SESSION['step_2']['orquestion_name'];
		$post_question['user_last_name']='';
		$post_question['user_email']=$_SESSION['step_2']['orquestion_email'];	
		$post_question['order_amount'] = $plan_data['subs_price'];
		$post = $post_question;
		
        $quesSetup = new OrderFactory(intval($post['payment_mode']), $post);
        $saveObj = $quesSetup->getInstance();	
        if (!$saveObj->execute()) {
	
            Message::addErrorMessage($saveObj->getError());
            redirectUser(generateUrl(''));
        }

        //Send Admin Question post email
       
        Message::addMessage("Question is successfully Posted");
		
//        $_SESSION['Ask_Guest']['user_id'] = $saveObj->user_id;
//        //Token is valid for 15 min
//        $_SESSION['Ask_Guest']['token'] = time() * 15 * 60;
//        $_SESSION['Ask_Guest']['data'] =  array_merge($orignalData,array('order_id'=>$saveObj->order_id));
//        
//
//
//        redirectUser(generateUrl('account', 'setpassword'));
        //unset($post_question);
        
        redirectUserWithData(generateAbsoluteUrl('account', 'checkoutpage'), array_merge($post_question, array('order_id' => $saveObj->order_id,'trans_id'=>$saveObj->trans_id)));
    }

    public function checkUnique() {
        $email = Syspage::getPostedVar('email');
        $user = Users::searchUser();
        $user->addCondition('user_email', '=', $email);
        $data = $user->fetch();
        if (intval($data['user_id']) > 0) {
            Message::addErrorMessage("Email Already Exists");
            dieWithError("Email Already Exists");
        }

        dieWithSuccess("Email Available");
    }

    public function login() {

        $customerfrm = $this->getCustomerLoginForm();
        $customerfrm->setAction(generateUrl('askquestion', 'validate_login'));
        $this->set('customerfrm', $customerfrm);

        $this->_template->render(false, false);
    }

    public function validate_login() {

        $post = Syspage::getPostedVar();
        global $msg;
        $this->Members = new Members();
        $frm = $this->getCustomerLoginForm();
        //$frm->setValidationLangFile('includes/form-validation-lang.php');
        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            dieWithError($frm->getValidationErrors());
        }

        if (!$this->Members->validateCustomerLogin($post['user_email'], $post['user_password'])) {
            dieWithError("Login Failed! Username or password incorrect");
        }
        Message::getHtml();
        dieWithSuccess("Success");
    }
	static function getPaypalOrderForm(){
		$frm = new Form('frmPay');
		$frm->addHiddenField('','cmd','_xclick');
		$frm->addHiddenField('','business','nimchaniya@dummyid.com');
		$frm->addHiddenField('','charset','utf-8');
		$frm->addHiddenField('','currency_code',"");
		$frm->addHiddenField('','item_name','');
		$frm->addHiddenField('','amount','');
		$frm->addHiddenField('','quantity','');
		$frm->addHiddenField('','image_url', generateUrl('image','site_logo'));
		$frm->addHiddenField('','custom','');
	//	$frm->addHiddenField('','rm',"2");
		$frm->addHiddenField('','return', generateFullUrl("order","success"));
		$frm->addHiddenField('','cancel_return', generateFullUrl("order","cancel"));
#		$frm->addHiddenField('','notify_url', getAbsoluteUrl(generateUrl("order","notify")));
		$frm->addHiddenField('','notify_url',getFullWebrootUrl()."public/index_noauth.php?url=ping/order");
		$frm->setFormTagAttribute("id","frmPay");
		$frm->setFormTagAttribute("action","https://www.sandbox.paypal.com/cgi-bin/webscr");
		
		return $frm;
	}

}
