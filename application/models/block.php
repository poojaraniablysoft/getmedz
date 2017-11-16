<?php

class Block extends Model {
	

    const NOT_ACTIVE_BLOCK = 0;
    const ACTIVE_BLOCK = 1;
	 function __construct(){
		$this->db = Syspage::getdb();
    }

    public static function searchBlock() {
        $srch = new SearchBaseNew('tbl_content_blocks', "bl");
        return $srch;
    }

    public static function getactiveBlock() {
        $srch = self::searchBlock();
        $srch->addCondition('block_active', '=', Self::ACTIVE_BLOCK);
        return $srch;
    }

    public static function getactiveBlockByName($name) {
        $srch = self::getactiveBlock();
        $srch->addCondition('block_identifier', '=', $name);
        return $srch;
    }

    public static function getBlockById($id) {
        $srch = self::searchBlock();
        $srch->addCondition('block_id', '=', $id);
        return $srch;
    }
	 public static function getactiveBlocksByName($name) {
		global $db;
        $srch = self::getactiveBlock();
        $srch->addCondition('block_identifier', '=', $name);		
		$srch->doNotLimitRecords(true);
        $srch->doNotCalculateRecords(true);
        $rs = $srch->getResultSet();
		$row = $db->fetch($rs);	   
		if($row==false) return array();
        else return $row;
    }

}
