<?php

class Settings extends Model {
	
   function __construct(){
		parent::__construct();
		$this->db = &Syspage::getdb();
   }	
   
   Static function getSetting($attr) {
		   $db = &Syspage::getdb();
		   $srch = new SearchBase('tbl_configurations', 'tc');
		   $srch->addCondition('tc.conf_name', '=',$attr);
		   $rs = $srch->getResultSet();
		   $row = $db->fetch($rs);
		   if ($row){
			   return $row['conf_val'];
		   }
		   return false;
    }
	

	
	
}