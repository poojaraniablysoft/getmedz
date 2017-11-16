<?php
class faqcat extends Model {

    const ACTIVE_FAQCATEGORY = 1;
    const NOT_ACTIVE_FAQCATEGORY = 0;
    const NOT_DELETED_FAQCATEGORY = 0;
    const DELETED_FAQCATEGORY = 1;

    public static function searchFaqCategory() {
        $srch = new SearchBaseNew('tbl_faq_category', "d");
        return $srch;
    }

    public static function getActiveFaqCategory() {
        $srch = new SearchBaseNew('tbl_faq_category', "d");
        $srch->addCondition('faqcat_active', '=', Self::ACTIVE_FAQCATEGORY);
		$srch->addCondition('faqcat_deleted', '=', Self::NOT_DELETED_FAQCATEGORY);
		
        return $srch;
    }

    /*
     * Fetch only the not DELETED FAQCATEGORY
     */

    public static function getAllFaqCategory() {
        $srch = new SearchBaseNew('tbl_faq_category', "st");
        $srch->addCondition('faqcat_deleted', '=', Self::NOT_DELETED_FAQCATEGORY);
        return $srch;
    }

}
