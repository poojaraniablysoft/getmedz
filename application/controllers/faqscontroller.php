<?php
class FaqsController extends FrontController{
	
    function default_action(){
		$faq=new faq();
        $faq_categories=faqcat :: getActiveFaqCategory()->fetch_all();
		
		
		foreach($faq_categories as $key=>$val){
			$arr_faqs=array("faqs"=>$faq->getFaqs($val["faqcat_id"])->fetch_all());
            $faq_cats[]=array_merge($val,$arr_faqs);
		}
		//$faqs=faq :: getactiveFaqsWithCat()->fetch_all;
		
		
		$this->set('faq_categories', $faq_cats);
		
		$this->_template->render();	
    }
	
	function category($id){
		$cat_obj=new Categories();
		$faq_obj=new Faqs();
        $faq_categories=$cat_obj->getCategoriesHavingRecords(2);
		$this->set('faq_categories', $faq_categories);
        $faq_category=$cat_obj->getData($id);
		if (!$faq_category)
			show404();

		$faq_obj=new Faqs();
		$arr_faqs=array("faqs"=>$faq_obj->getcategoryFaqs($id));
        $faq_cats=array_merge($faq_category,$arr_faqs);
		$this->set('faq_category', $faq_cats);
		$this->_template->render();	
    }

}