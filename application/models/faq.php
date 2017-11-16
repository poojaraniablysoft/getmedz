<?php

class Faq extends Model {

    const ACTIVE_FAQ = 1;
    const NOT_ACTIVE_FAQ = 0;
    const NOT_DELETED_FAQ = 0;
    const DELETED_FAQ = 1;

    public static function searchFaqs() {
        $srch = new SearchBaseNew('tbl_faq', "f");
        $srch->joinTable('tbl_faq_category', 'INNER JOIN', 'faqcat_id=faq_category_id');
        return $srch;
    }

    public static function getactiveFaqs() {
        $srch = self::searchFaqs();
        $srch->addCondition('faq_active', '=', Self::ACTIVE_FAQ);
		$srch->addCondition('faq_deleted', '=', Self::NOT_DELETED_FAQ);
		
        return $srch;
    }
	public static function getFaqs($category_id = 0) {
		$srch = new SearchBaseNew('tbl_faq', "f");		
		$srch->addCondition('faq_active', '=', Self::ACTIVE_FAQ);
		$srch->addCondition('faq_deleted', '=', Self::NOT_DELETED_FAQ);
		if($category_id > 0)
		{
			$srch->addCondition('faq_category_id', '=', $category_id );
		}
		
        return $srch;
    }

    /*
     * Ftech only the not DELATED FaqS
     */

    public static function getAllFaqs() {
        $srch = self::searchFaqs();
        $srch->addCondition('faq_deleted', '=', Self::NOT_DELETED_FAQ);
        return $srch;
    }

    public static function getFaqcategoryOpt() {

        $srch = self::getactiveFaqs();
        $srch->addMultipleFields(array(
            'faqcat_id',
            'faqcat_name',
            'faq_id',
            'faq_name',
        ));
        $allFaqs = $srch->fetch_all();
   
        $options = array();
        foreach ($allFaqs as $value) {

            $faqcat_id = $value['faqcat_id'];
            $faqcat_name = $value['faqcat_name'];
            $faq_id = $value['faq_id'];
            $faq_name = $value['faq_name'];

            if (!isset($options[$faqcat_id])) {
                //$options[$country_id] = array('group_caption'=> $country_name);
            }
            $options[$faq_id] = $faq_name;
        }
      
       
        return $options;
    }

}
