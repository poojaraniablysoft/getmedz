<?php

class ReviewsController extends BackendController {

    public function before_filter() {
        parent::before_filter();
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Reviews Management", Utilities::generateUrl("reviews"));
    }

    public function default_action() {
    //    $this->set('searchForm', $this->searchForm());
	 Syspage::addCss(array(
            "../css$selected_css_folder/jquery.rating.css"
        ));
       
		$this->set('breadcrumb', $this->b_crumb->output());
        
        $this->render();
    }

    public function listing() {

        $page = Syspage::getPostedVar('page');
        $post=Syspage::getPostedVar();
        $reviews = Review::searchReviews();
		
		$reviews->addMultipleFields(array('review_id','order_user_id','order_date','CONCAT(user_first_name," ",user_last_name) as user_name','user_email','review_text','CONCAT(doctor_first_name," ",doctor_last_name) as doctor_name','review_rating',"(CASE WHEN order_type=".Orderabstract::ORDER_SUBSCRIPTION." THEN 1 ELSE 2 END) as upsell"));
        //Searching Critreia 
        
        $this->paginate($reviews, $page, generateUrl('reviews', 'listing'));
        $user_id = Admin::getLoggedinUserId();
        
        $this->set('canEditreviews', Permission::canEditreviews($user_id));
        
        $this->render();
    }

  

    private function getform($star_rating=0) {
        $frm = new Form('Frmreviews');
        $frm->setAction(generateUrl('reviews', 'setup'));
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addHiddenField('', 'review_id');
        $frm->addHiddenField('', 'review_doctor_id');
        $frm->addHiddenField('', 'review_user_id');
        $frm->addHiddenField('', 'review_id');
        $frm->addRequiredField('Review Text', 'review_text')->requirements()->setRequired();
        $frm->addHtml( 'Rating','',createStarRating('review_rating',$star_rating));
        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Submit', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'cancel', 'Cancel', '', 'class="cancel_form reset_button" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('reviewsValidator');
        $frm->setOnSubmit('submitreviewsSetup(this, reviewsValidator);');
        return $frm;
    }

    public function form() {
        $user_id = Admin::getLoggedinUserId();
        $id = Syspage::getPostedVar('id');
       
        if (intval($id) > 0) {

            if (!Permission::canEditreviews($user_id, $id)) {
                $this->notAuthorized();
            }

            $srch = Review::searchReviews();
            $srch->addCondition('review_id', "=", $id);
            $data = $srch->fetch();

           

            if (!$data)
                dieWithError('Invalid Request');
        }else{
		 dieWithError('Invalid Request');
		}
		$frm = $this->getform($data['review_rating']);
		 $frm->fill($data);
        $this->set('frm', $frm);
        $this->render();
    }

    public function setup() {
        $user_id = Admin::getLoggedinUserId();
        $post = Syspage::getPostedVar();

        if (intval($post['review_id']) > 0) {
            if (!Permission::canEditreviews($user_id, $post['review_id'])) {
                $this->notAuthorized();
            }
        } else {
          
                $this->notAuthorized();
            
        }

        $frm = $this->getForm();
        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('reviews'));
        }

        if (!$this->Reviews->setupreview($post)) {
            Message::addErrorMessage($this->Reviews->getError());
        }
        redirectUser(generateUrl('reviews'));
    }
	
	function detail($review_id){
	
		 $review_id = intval($review_id);
       if($review_id<=0) die('Invaid Input');      

		if (!Permission::canviewreviews($user_id, $review_id)) {
			$this->notAuthorized();
		}

		 Syspage::addCss(array(
            "../css$selected_css_folder/jquery.rating.css"
        ));
		 Syspage::addJs(array(
            "../js/jquery.rating.js"
        ));
		$srch = Review::searchReviews();
		$srch->addCondition('review_id', "=", $review_id);
		$srch->addMultipleFields(array('order_id','review_id','order_user_id','order_date','CONCAT(user_first_name," ",user_last_name) as user_name','user_email','review_text','CONCAT(doctor_first_name," ",doctor_last_name) as doctor_name','review_rating'));
        //Searching Critreia 
        
		$data = $srch->fetch();  
		$this->set('review',$data);
		if (!$data)
			dieWithError('Invalid Request');
		$this->b_crumb->add("Review", Utilities::generateUrl("reviews", "detail"));
		$this->set('breadcrumb', $this->b_crumb->output());
		 $this->render();
        
	}
	

}
