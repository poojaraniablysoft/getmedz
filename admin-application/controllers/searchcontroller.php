<?php

 class SearchController extends BackendController{
	 
	  public function before_filter() {
        parent::before_filter();
       
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Search", Utilities::generateUrl("search"));
    }
     
     
     public static $searchFields=array('user_first_name'=>'First Name',
                                        'user_last_name'=>'Last Name',
                                        'user_email'=>'Email',
                                        'user_pincode'=>'Zip code'
                                       );
     
     
     public function default_action(){
          $this->set('searchForm', $this->searchForm());
		  $this->set('breadcrumb', $this->b_crumb->output());
         $this->_template->render();
     }
     
    public function listing() {

        $page = Syspage::getPostedVar('page');

        $doctores = Customer::searchCustomer();
        //Searching Critreia
        $doctores->addMultipleFields(array('*', 'CONCAT_WS(" ",user_first_name,user_last_name) as name'));
        $post = Syspage::getPostedVar();
        if (!empty($post['search_by'])) {
            $cnd = $doctores->addCondition($post['search_by'], 'like', $post['keyword'] . "%");
            
        }

        $this->paginate($doctores, $page, generateUrl('Search', 'listing'));
       
        $this->render();
    }

    private function searchForm() {
        $frm = new Form('searchForm', 'searchForm');
        $frm->setAction(generateUrl('Search', 'listing'));
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");
         $frm->addSelectBox('Search By', 'search_by',self::$searchFields)->requirements()->setRequired();
        $frm->addTextBox('Keywords', 'keyword')->requirements()->setRequired();

        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Search', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'reset', 'Show All', '', 'class="cancel_search" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('searchValidator');
        $frm->setOnSubmit('return submitsearch(this, searchValidator);');
        return $frm;
    }
     
     
     
     
     
     
     
     
     
 }