<?php
class Emailnotifications extends Model {
	
	function __construct(){
		$this->db = Syspage::getdb();
    }
	
	function getError() {
		return $this->error;
	}
	
	function sendContributionEmailToAdmin($data) {
		if (empty($data)) { return false; }
		if ($data){
			$replacements = array(
				'{user_full_name}' => ucfirst($data['contribution_author_first_name']) . ' ' . ucfirst($data['contribution_author_last_name']),
				'{posted_on}' => date('Y-m-d'),
				'{user_email}' => $data['contribution_author_email'],
				'{user_phone}' => $data['contribution_author_phone'],
			);
			Utilities::sendMailTpl(Settings::getSetting("CONF_ADMIN_EMAIL"), 'contribution_email_to_admin', $replacements);
	        return true;
		}else{
			$this->error = Utilities::getLabel('M_INVALID_REQUEST');
		}
    }
	
}
?>