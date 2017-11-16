<?php

class SiteController extends FrontController {



    function contact() {
        $frm = $this->getContactUsForm();
        $this->set('frm', $frm);
      
        $this->_template->render();
    }

    function contact_setup() {
        global $db;
        global $msg;
        $post = Syspage::getPostedVar();
		
        $frm = $this->getContactUsForm();
        if (!$frm->validate($post)) {
			
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('site', 'contact'));
        }		
		else if(!verifyGoogleCaptcha()) {
			Message::addErrorMessage(getLabel('M_ERROR_PLEASE_VERIFY_YOURSELF'));
			redirectUser(generateUrl('site', 'contact'));
		} 
		
        /* Send contact us email to admin */
        if ($post['mode'] == 'setup') {

            $row_tpl = SITE::getEmailTemplate('contact_email');

            $subject = $row_tpl['tpl_subject'];
      $body = $row_tpl['tpl_body'];



            $arr_replacements = array(
                '{website_name}' => CONF_WEBSITE_NAME,
                '{website_url}' => $_SERVER['SERVER_NAME'],
               
                '{user_full_name}' => $post['c_name'],
                '{user_email}' => $post['c_user_email'],
                '{user_phone}' => $post['c_phone'],
                '{site_date}' => displayDate(date('Y-m-d H:i:s')),
                '{user_message}' => $post['c_message']
            );

            foreach ($arr_replacements as $key => $val) {
                $subject = str_replace($key, $val, $subject);
                $body = str_replace($key, $val, $body);
            }
            if (sendMail(CONF_ADMIN_EMAIL_ID, $subject, $body,"",true)) {
                Message::addMessage('Mail has been sent successfully.');
            } else {
                Message::addErrorMessage('Internal Server error, please Try again later');
            }
            redirectUser(generateUrl('site', 'contact'));
        }
    }

  
    function getContactUsForm() {
       
      

        $frm = new Form('frmContact', 'frmContact');
        $frm->setExtra(' class="form form__horizontal"');
        $frm->setAction(generateUrl('site', 'contact_setup'));
        $frm->addRequiredField('Name', 'c_name');
        $frm->addTextBox('Phone', 'c_phone');
        $fld = $frm->addEmailField('Email ID', 'c_user_email');
        $fld->requirements()->setRequired(true);
        $fld = $frm->addTextArea('Message', 'c_message');
        $fld->requirements()->setLength(10, 500);
        $fld->requirements()->setRequired(true);
        $frm->addHiddenField('', 'mode', 'setup');
        //$frm->addRequiredField('Security Code', 'security_code');
		//$frm->addHTML('', 'securimage', '<div class="captcha"><img src="/images/fixed/captcha.jpg" id="image"></div>');
		$frm->addHTML('', 'securimage', '<div class="g-recaptcha" data-sitekey="'.CONF_RECAPTACHA_SITEKEY.'"></div>');
		
		
        
        $frm->addSubmitButton('', 'btn_submit', 'Submit', '', 'class="button button--fill button--orange"');
        $frm->setRequiredStarWith('caption');

        return $frm;
    }

    
    public function notfound(){
     
              Syspage::addCss(
                array(
            'css/customer-style.css'
                ), true);
        $this->_template->render();
    }
    
  
}
