<?php
class Cms extends Model {

      
    const NOT_DELETED_CMSPAGE= 0;
    const DELETED_CMSPAGE = 1;
    Const CMS_MENU_LEFT=1;
    Const CMS_MENU_RIGHT=2;
	protected $db;
	
	function __construct(){
		$this->db = Syspage::getdb();
    }
    public static function searchCms() {
        $srch = new SearchBaseNew('tbl_cms_contents', "cms");
        return $srch;
    }

    public static function getactiveCms() {
        $srch = self::searchCms();
        $srch->addCondition('cmsc_content_delete', '=', Self::NOT_DELETED_CMSPAGE);
        $srch->addCondition('cmsc_content_active', '=',1);
        return $srch;
    }
    public static function getactiveCmsByName($name) {
        $srch = self::searchCms();
 
        $srch->addCondition('cmsc_page_identifier', '=', $name);
        return $srch;
    }	
    public static function getactiveCmsById($id) {
        $srch = self::searchCms();
        $srch->addCondition('cmsc_id', '=', $id);
        return $srch;
    }
	
	public static function getAssociativeArray(){
		global $db;
		$srch = new SearchBase('tbl_cms_contents', 'tcp');
		$srch->addMultipleFields(array('cmsc_id', 'cmsc_title'));
		$srch->addCondition('cmsc_content_delete', '=', Self::NOT_DELETED_CMSPAGE);
        $srch->addCondition('cmsc_content_active', '=',1);
		$srch->addOrder('cmsc_title', 'ASC');
		
		$rs = $srch->getResultSet();
		return $db->fetch_all_assoc($rs);
	}
	public static function getactiveCmsBySlug($slug) {
        $srch = self::searchCms();
 
        $srch->addCondition('cmsc_slug', '=', $slug);
		
        return $srch;
    }
	public static function getPageSlugById($id) {
		global $db;
        $srch = self::searchCms();
 
		$srch->addCondition('cmsc_id', '=', $id);
		$srch->addFld('cmsc_slug');
		$rs = $srch->getResultSet();
		$result = $db->fetch($rs);
		
        return $result['cmsc_slug'];
    }
	
}