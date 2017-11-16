<?php

class ConfigurationsController extends BackendController {

    private $arr_date_format_php;
    private $arr_date_format_mysql;
    private $arr_date_format_jquery;
	
    function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);

        $this->arr_date_format_php = array(
            'Y-m-d',
            'd/m/Y',
            'm-d-Y',
            'M d, Y'
        );

        $this->arr_date_format_mysql = array(
            '%Y-%m-%d',
            '%d/%m/%Y',
            '%m-%d-%Y',
            '%b %d, %Y'
        );

        $this->arr_date_format_jquery = array(
            '%Y-%m-%d',
            '%d/%m/%Y',
            '%m-%d-%Y',
            '%b %d, %Y'
        );
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Configurations Management", Utilities::generateUrl("configurations"));
    }

    function default_action() {
        $this->set('frmConf', $this->getForm());
        $this->set('frmHome', $this->getHomePageform());
        $this->set('frmPdf', $this->getPdfform());
		$this->set('frmThirdparty', $this->getThirdPartyform());
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->_template->render();
    }

    function update() {
        global $db;
        global $post;
        if ($post['action'] == "website") {
			
			
            $frm = $this->getForm();
            $post['conf_date_format_jquery'] = $this->arr_date_format_jquery[$post['date_format']];
            $post['conf_date_format_mysql'] = $this->arr_date_format_mysql[$post['date_format']];
            $post['conf_date_format_php'] = $this->arr_date_format_php[$post['date_format']];
			
			if($_FILES['CONF_ADMIN_LOGO']['tmp_name'] != '')
			{
				if (isUploadedFileValidImage($_FILES['CONF_ADMIN_LOGO'])){
						if(!saveImage($_FILES['CONF_ADMIN_LOGO']['tmp_name'],$_FILES['CONF_ADMIN_LOGO']['name'], $saved_image_name, 'logo/',true)){
							Message::addErrorMessage($saved_image_name);
						}
						$post["CONF_ADMIN_LOGO"]=$saved_image_name;
					}
			}
			else
			{
				unset($post["CONF_ADMIN_LOGO"]);
			}
			
			if($_FILES['CONF_FRONT_LOGO']['tmp_name'] != '')
			{	
		
				if (isUploadedFileValidImage($_FILES['CONF_FRONT_LOGO'])){
					if(!saveImage($_FILES['CONF_FRONT_LOGO']['tmp_name'],$_FILES['CONF_FRONT_LOGO']['name'], $saved_image_name, 'logo/',true)){
						Message::addErrorMessage($saved_image_name);
					}
					$post["CONF_FRONT_LOGO"]=$saved_image_name;
				}
			}
			else
			{
				unset($post["CONF_FRONT_LOGO"]);
			}
			if($_FILES['CONF_FOOTER_LOGO']['tmp_name'] != '')
			{	
		
				if (isUploadedFileValidImage($_FILES['CONF_FOOTER_LOGO'])){
					if(!saveImage($_FILES['CONF_FOOTER_LOGO']['tmp_name'],$_FILES['CONF_FOOTER_LOGO']['name'], $saved_image_name, 'logo/',true)){
						Message::addErrorMessage($saved_image_name);
					}
					$post["CONF_FOOTER_LOGO"]=$saved_image_name;
				}
			}
			else
			{
				unset($post["CONF_FOOTER_LOGO"]);
			}
			
        } else if ($post['action'] == "home") {
            $frm = $this->getHomePageform();
        } else if ($post['action'] == "pdf") {
            $frm = $this->getPdfform();
        }
		else if ($post['action'] == "thirdparty") {
            $frm = $this->getThirdPartyform();
        }
        if (!$frm->validate($post)) {
            Message::addErrorMessage('Something Went Wrong!');
            dieJsonError(Message::getHtml());
        }



        if (isAjaxRequest()) {
            if (!$frm->validate($post)) {
                Message::addErrorMessage("Something Went Wrong!");
                dieJsonSuccess(Message::getHtml());
            } else {
                if ($this->Configurations->updateConfig($post)) {
                    Message::addMessage('Settings updated!');
                } else {
                    Message::addErrorMessage("Something Went Wrong!");
                    dieJsonError(Message::getHtml());
                }
            }
        }

        dieJsonError(Message::getHtml());
    }

    protected function getForm() {


        $frm = new Form('frmConfigurations');

        $frm->setExtra("class='web_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setValidatorJsObjectName('settingValidator');
        $frm->setOnSubmit('submitSettings(settingValidator); return false;');
        $frm->addRequiredField('<strong>Website Name</strong>:', 'conf_website_name', CONF_WEBSITE_NAME);
        $frm->addRequiredField('<strong>Website Phone</strong>:', 'conf_contact_phone', CONF_CONTACT_PHONE);
        $frm->addRequiredField('<strong>Website Email</strong>:', 'conf_website_email', CONF_WEBSITE_EMAIL);
        $frm->addRequiredField('<strong>Doctor Name</strong>:', 'conf_doctor_name', CONF_DOCTOR_NAME);
        $frm->addRequiredField('<strong>Back-end Default Paging Size</strong>:', 'conf_default_admin_paging_size', CONF_DEFAULT_ADMIN_PAGING_SIZE);
        $frm->addRequiredField('<strong>Front-end Default Paging Size</strong>:', 'conf_default_front_paging_size', CONF_DEFAULT_FRONT_PAGING_SIZE);
        $frm->addSelectBox('<strong>Require Reply Approval</strong>:', 'conf_required_reply_approval', Applicationconstants::$arr_status, CONF_REQUIRED_REPLY_APPROVAL)->requirements()->setRequired();
        $frm->addSelectBox('<strong>Date Format:', 'date_format', $this->arr_date_format_php, array_keys($this->arr_date_format_php, CONF_DATE_FORMAT_PHP), '', '');

        $arr = DateTimeZone::listIdentifiers();
        $arr = array_combine($arr, $arr);
        $fld = $frm->addSelectBox('<strong>Timezone</strong>:', 'conf_timezone', $arr, CONF_TIMEZONE, 'class="input"', '');
        $fld->html_after_field = ' Now according to ' . CONF_TIMEZONE . ' = ' . displayDate(date('Y-m-d H:i:s'), true, true, CONF_TIMEZONE);
		 $frm->addSelectBox('<strong>Terms & Condition Page</strong>:', 'conf_terms_Page', Cms::getAssociativeArray(), CONF_TERMS_PAGE)->requirements()->setRequired();
        $frm->addEmailField('<strong>Send Emails From</strong>:', 'conf_emails_from', CONF_EMAILS_FROM);

        $frm->addEmailField('<strong>Administrator Email ID</strong>:', 'conf_admin_email_id', CONF_ADMIN_EMAIL_ID);
		
		$fld=$frm->addFileUpload('Admin Logo:', 'CONF_ADMIN_LOGO', 'CONF_ADMIN_LOGO', '');
			$admin_logo=CONF_ADMIN_LOGO;
			$fld->html_before_field='<div class="filefield"><span class="filename"></span>';
			if (!empty($admin_logo)){
            $fld->html_after_field='<label class="filelabel">Browse File</label></div><br/><br/>
			<div style="background-color:#ccc; padding:5px;"><img src="'.generateUrl('image', 'site_admin_logo',array(CONF_ADMIN_LOGO), CONF_WEBROOT_URL).'" /> </div><br/><br/>Preferred dimensions 172 X 55';
			}else{
				 $fld->html_after_field='<label class="filelabel">Browse File</label></div><br/>Preferred dimensions 172 X 55';
			}
			
			$fld=$frm->addFileUpload('Desktop Logo:', 'CONF_FRONT_LOGO', 'CONF_FRONT_LOGO', '');
			$front_logo=CONF_FRONT_LOGO;
			$fld->html_before_field='<div class="filefield"><span class="filename"></span>';
			if (!empty($front_logo)){
            $fld->html_after_field='<label class="filelabel">Browse File</label></div><br/><br/><img src="'.generateUrl('image', 'site_logo',array(CONF_FRONT_LOGO, 'THUMB'), CONF_WEBROOT_URL).'" /> <br/><br/>Preferred dimensions 172 X 55';

			}else{
				 $fld->html_after_field='<label class="filelabel">Browse File</label></div><br/>Preferred dimensions 172 X 55';
			}
			$fld=$frm->addFileUpload('Desktop Footer Logo:', 'CONF_FOOTER_LOGO', 'CONF_FOOTER_LOGO', '');
			$footer_logo=CONF_FOOTER_LOGO;
			$fld->html_before_field='<div class="filefield"><span class="filename"></span>';
			if (!empty($footer_logo)){
            $fld->html_after_field='<label class="filelabel">Browse File</label></div><br/><br/><img src="'.generateUrl('image', 'site_footer_logo',array($footer_logo, 'THUMB'), CONF_WEBROOT_URL).'" /> <br/><br/>Preferred dimensions 172 X 55';

			}else{
				 $fld->html_after_field='<label class="filelabel">Browse File</label></div><br/>Preferred dimensions 172 X 55';
			}

        $frm->addSubmitButton('', 'btn_submit', 'Submit');
        $frm->addHiddenField("", "action", "website");
        $frm->setAction(generateUrl('configurations', 'update'));

        return $frm;
    }

    function getHomePageform() {
        $frm = new Form('frmHomeSettings');
        $frm->setExtra(' class="web_form"');
        $frm->setJsErrorDisplay('afterfield');
        $frm->setValidatorJsObjectName('homeSettingsValidator');
        $frm->setOnSubmit('submitHomeSettings(homeSettingsValidator); return false;');
        $frm->addRequiredField('You Tube Link', 'CONF_HOMEPAGE_YOUTUBE_LINK', CONF_HOMEPAGE_YOUTUBE_LINK, 'CONF_HOMEPAGE_YOUTUBE_LINK', 'autocomplete="off"')->requirements()->setRequired();

        $frm->addSubmitButton('', 'btn_submit', 'Submit', '', 'class="login_btn"');
        $frm->addHiddenField("", "action", "home");
        $frm->setAction(generateUrl('configurations', 'update'));

        return $frm;
    }

	function getThirdPartyform() {
        $frm = new Form('frmThirdPartySettings');
        $frm->setExtra(' class="web_form"');
        $frm->setJsErrorDisplay('afterfield');
        $frm->setValidatorJsObjectName('ThirdPartySettingsValidator');
        $frm->setOnSubmit('submitThirdPartySettings(ThirdPartySettingsValidator); return false;');
        $frm->addTextBox('Google ReCaptcha Site Key ', 'CONF_RECAPTACHA_SITEKEY', CONF_RECAPTACHA_SITEKEY, 'CONF_RECAPTACHA_SITEKEY' );
		$frm->addTextBox('Google ReCaptcha Secret Key ', 'CONF_RECAPTACHA_SECRETKEY', CONF_RECAPTACHA_SECRETKEY, 'CONF_RECAPTACHA_SECRETKEY' );

        $frm->addSubmitButton('', 'btn_submit', 'Submit', '', 'class="login_btn"');
        $frm->addHiddenField("", "action", "thirdparty");
        $frm->setAction(generateUrl('configurations', 'update'));

        return $frm;
    }
    function getPdfform() {
        $frm = new Form('frmPdfSettings');
        $frm->setExtra(' class="web_form"');
        $frm->setJsErrorDisplay('afterfield');
        $frm->setValidatorJsObjectName('pdfValidator');
        $frm->setOnSubmit('submitPdfSettings(pdfValidator); return false;');
        $frm->addTextBox('PDF Footer Line 1 Content', 'conf_pdf_footer_text_line_1', CONF_PDF_FOOTER_TEXT_LINE_1, 'conf_pdf_footer_text_line_1', 'autocomplete="off"')->requirements()->setRequired();
        $frm->addTextBox('PDF Footer Line 2 Content', 'conf_pdf_footer_text_line_2', CONF_PDF_FOOTER_TEXT_LINE_2, 'conf_pdf_footer_text_line_2', 'autocomplete="off"')->requirements()->setRequired();
        $frm->addTextBox('PDF Footer Line 3 Content', 'conf_pdf_footer_text_line_3', CONF_PDF_FOOTER_TEXT_LINE_3, 'conf_pdf_footer_text_line_3', 'autocomplete="off"')->requirements()->setRequired();
        $frm->addHTMLEditor('PDF Footer Call Text', 'conf_pdf_call_text', CONF_PDF_CALL_TEXT, 'conf_pdf_call_text', 'autocomplete="off"')->requirements()->setRequired();

        $frm->addHTMLEditor('PDF Page 1 Content', 'CONF_PAGE_1_CONTENT', CONF_PAGE_1_CONTENT, 'CONF_PAGE_1_CONTENT', 'autocomplete="off"')->requirements()->setRequired();

        $frm->addSubmitButton('', 'btn_submit', 'Submit', '', 'class="login_btn"');
        $frm->addHiddenField("", "action", "pdf");
        $frm->setAction(generateUrl('configurations', 'update'));

        return $frm;
    }

}
