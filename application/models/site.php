<?php
class site extends Model{
	
	/* TO get Email Template */
	static function getEmailTemplate($tpl_code)
	{
		global $db;
		$srch = new SearchBase('tbl_email_templates', 'et');
		$srch->addCondition('tpl_code', '=', $tpl_code );
		$rs=$srch->getResultSet();
		if($row = $db->fetch($rs)) return $row;
	}
}
?>