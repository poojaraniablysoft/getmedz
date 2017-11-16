<?php
/* 
*Created On 05/06/2015 By A K
*/

class Configurations extends Model {
	protected $db;
    function __construct() {
        parent::__construct();
		$this->db = Syspage::getdb();
    }
	
	function updateConfig($data){
		$valid_fields = array('conf_date_format_jquery', 'conf_date_format_mysql', 'conf_date_format_php', 'conf_emails_from', 'conf_admin_email_id', 'conf_timezone','CONF_ADMIN_LOGO','CONF_FRONT_LOGO','CONF_FOOTER_LOGO','CONF_RECAPTACHA_SITEKEY','CONF_RECAPTACHA_SECRETKEY', 
		'conf_website_name', 'conf_contact_email_to', 'conf_contact_phone',
		 'conf_website_email',
		 'conf_default_admin_paging_size','conf_default_front_paging_size','conf_required_reply_approval','CONF_HOMEPAGE_YOUTUBE_LINK','CONF_PAGE_1_CONTENT',
		 'conf_pdf_footer_text_line_1','conf_pdf_footer_text_line_2','conf_pdf_footer_text_line_3','conf_pdf_call_text','conf_doctor_name','conf_terms_Page');
		foreach($data as $key => $val){
			if(in_array($key, $valid_fields, true)){
				$this->db->update_from_array('tbl_configurations',array('conf_val'=>$val), array('smt'=>'conf_name = ?', 'vals'=>array($key)));
			}
		}
		return true;
	}
}	
?>	