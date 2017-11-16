<?php

class AdminController extends Controller {

    function loginform() {

        Syspage::addCss(
                array(
            'css/login.css'
                ), true);
        /* Check if any valid details saved in cookies */
        if (isset($_COOKIE['askdoctor_remember'])) {

            $cookie_arr = explode('|', $_COOKIE['askdoctor_remember']);

            if ($this->Admin->validateCookie($cookie_arr, $user_data)) {

                if ($this->Admin->validateLogin($user_data['admin_username'], $user_data['admin_password'], true)) {
                    if (Admin::isLogged())
                        redirectUser(generateUrl(''));
                }else {
                    $this->Admin->updateCookie($user_data['admin_id'], true); /* Delete cookie something fishy, cookie data not validated */
                }
            }
        }
        $frm = $this->getForm();
        $frm_password = $this->get_forgot_password();
        $this->set('frm', $frm);
        $this->set('frm_password', $frm_password);
        $this->_template->render(false, false);
    }

    function login() {
        global $msg;
        $post = Syspage::getPostedVar();
        $frm = $this->getForm();
        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('admin', 'loginform'));
        }
        if (!$this->Admin->login($post['username'], $post['admin_password'])) {
            Message::addErrorMessage($this->Admin->getError());
            $this->_template = new Template('admin', 'loginform');
            $this->loginform();
            return;
        }
        /* Check if any valid details saved in cookies */
        /* Remember me check-box */

        $admin_id = $this->Admin->getLoggedinUserId();
        if (isset($post['chk_remember'])) {

            $this->Admin->updateCookie($admin_id); /* Set Cookies */
        } else {
            $this->Admin->updateCookie($admin_id, true); /* destroy any previously set cookie */
        }

        redirectUser(generateUrl(''));
    }

    function logout() {
        $this->Admin->logout();
        Message::addMessage('You are Logged out successfully.');
        redirectUser(generateUrl(''));
    }

    function getForm() {
        $frm = new Form('frmLogin');
        $frm->setExtra(' class="web_form" autocomplete="off"');
        $frm->setJsErrorDisplay('afterfield');
        $user_fld = $frm->addRequiredField('', 'username', '', 'username', 'autocomplete="off"')->requirements();
        $user_fld->setRequired();
        $user_fld->setCustomErrorMessage("Username is mandatory.");
        $user_pw = $frm->addPasswordField('', 'admin_password', '', 'admin_password', 'autocomplete="off"')->requirements();
        $user_pw->setRequired();
        $user_pw->setCustomErrorMessage("Password is mandatory.");
        $frm->addCheckBox('Remember Me ', 'chk_remember', '1');
        $frm->setOnSubmit('login(loginValidator);');
        $frm->setValidatorJsObjectName('loginValidator');
        $frm->addSubmitButton('', 'btn_submit', 'Login to your account', '', 'class="login_btn"');
        $frm->setAction(generateUrl('admin', 'login'));

        return $frm;
    }

    function changepassword() {
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Change Password", Utilities::generateUrl("admin","changepassword"));
        $frm = new Form('frmPassword');
        $frm->setJsErrorDisplay('afterfield');
        $frm->setExtra(' class="web_form"');
        $frm->setTableProperties("class='edit_form' width='100%'");
        $frm->addPasswordField('Current Password:', 'current_password')->requirements()->setRequired();
        $fld = $frm->addPasswordField('New Password:', 'new_password');
        $fld->requirements()->setLength(6, 20);
        $fld->requirements()->setRequired();
        $fld1 = $frm->addPasswordField('Confirm New Password:', 'new_password1');
        $fld1->requirements()->setLength(6, 20);
        $fld1->requirements()->setCompareWith('new_password', 'eq', 'New Password');
        $fld2 = $frm->addEmailField('Email ID:', 'admin_email');
        $fld2->requirements()->setRequired(false);
        $frm->addHTML('', '', '</br><span class="change-email">If you don\'t want to change email Id, leave the email Id field blank.<Br>Current Email Id:  <strong>' . Admin::getLoggedUserEmail() . '</strong></br></span>');
        $frm->addSubmitButton('', 'btn_submit', 'Submit', 'btn_submit'/* , 'class="inputbuttons"' */);
        $frm->setAction(generateUrl('admin', 'change_password'));
		
        $this->set('frmPassword', $frm);
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->_template->render();
    }

    function change_password() {
        global $post;
        global $msg;

        if ($this->Admin->changePassword($post['current_password'], $post['new_password'], $post['admin_email'])) {
            Message::addMessage('Password/Email Id changed successful!');
        } else {
            Message::addErrorMessage($this->Admin->getError());
            redirectUser(generateUrl('admin', 'changepassword'));
        }

        $this->Admin->logout();
        Message::addMessage('Password/Email Id changed successful!');
        redirectUser(generateUrl(''));
        //    
    }

    function get_forgot_password() {

        if ($this->Admin->isLogged())
            redirectUser(generateUrl(''));

        $frm = new Form('frmForgotPassword');
        $frm->setExtra('method="post"  class="web_form" onSubmit="return submitForgotPassword(this, commentValidator);"');
        $frm->setJsErrorDisplay('afterfield');
        $frm->addEmailField('Email', 'admin_email', '', '', '')->requirements()->setCustomErrorMessage('Email Id is mandatory');
        $fld = $frm->addRequiredField('Security Code:', 'security_code', '', 'security_code', '')->requirements()->setCustomErrorMessage('Security code is mandatory');

        $frm->addHTML("", 'secureimage', '<img src="' . CONF_WEBROOT_URL . 'securimage/securimage_show.php" id="image" class="captchapic"/>
    	<a href="javascript:void(0);" onclick="document.getElementById(\'image\').src = \'' . CONF_WEBROOT_URL . 'securimage/securimage_show.php?sid=\' + Math.random(); return false" class="reloadlink"></a>', 'captcha');

        $frm->setValidatorJsObjectName('PasswordValidator');
        $frm->setOnSubmit('submitForgotPassword(this, PasswordValidator); return(false);');
        $frm->setJsErrorDisplay('summary');
        $frm->setJsErrorDiv('div_error');
        $fld4 = $frm->addSubmitButton('', 'btn_submit', 'Send Reset Pasword Email');

        // $frm->setAction(generateUrl('admin', 'email_password_instructions'));



        return $frm;
    }

    function email_password_instructions() {
        /* @var $db Database */
        global $db;
        global $post;

        if ($this->Admin->isLogged()) {
            Message::addErrorMessage('You entered incorrect Security Code. Please Try Again.');
            dieJsonError(Message::getHtml());
        }
        require_once '../securimage/securimage.php';
        $img = new Securimage();
        if (!$img->check($_POST['security_code'])) {
            Message::addErrorMessage('You entered incorrect Security Code. Please Try Again.');
            dieJsonError(Message::getHtml());
            //  dieJsonError();
            //redirectUser(generateUrl('admin', 'forgot_password'));
        }
        $srch = new SearchBase('tbl_admin');
        $srch->addCondition('admin_email', '=', $post['admin_email']);
        $sql = $srch->getResultSet();

        //$sql = $db->query("SELECT * FROM tbl_admin WHERE admin_email = '" . $post['admin_email'] . "'");

        if (!$row = $db->fetch($sql)) {
            Message::addErrorMessage('Invalid Email ID!');
            dieJsonError(Message::getHtml());
        }

        $admin_id = $row['admin_id'];

        $db->query("delete from tbl_admin_password_resets_requests where aprr_expiry < '" . date('Y-m-d H:i:s') . "'");
        $rs = $db->query("select * from tbl_admin_password_resets_requests where appr_admin_id = " . intval($admin_id));
        if ($row_request = $db->fetch($rs)) {
            Message::addErrorMessage('Your request to reset password has already been placed within last 24 hours. Please check your emails or retry after 24 hours of your previous request');
            dieJsonError(Message::getHtml());
            // redirectUser(generateUrl('admin', 'loginfor'));
        }

        $tocken = encryptPassword(getRandomPassword(20));

        $db->insert_from_array('tbl_admin_password_resets_requests', array(
            'appr_admin_id' => $admin_id,
            'aprr_tocken' => $tocken,
            'aprr_expiry' => date('Y-m-d H:i:s', strtotime("+1 DAY"))
        ));

        $reset_url = 'http://' . $_SERVER['SERVER_NAME'] . generateUrl('admin', 'reset_password', array($tocken, $admin_id));
        $message = 'It seems that you have used forgot password option at ' . CONF_WEBSITE_NAME . ' (' . $_SERVER['SERVER_NAME'] . ')' . '
    	
    	Please visit the link given below to reset your password. <strong>Please note that the link is valid for next 24 hours only. </strong>
    	
    	Password reset url: <a href="' . $reset_url . '">' . $reset_url . '</a>
    	
    	<i>Please ignore this email if you did not use the forgot password option.</i>
    	';

        $message = nl2br($message);

        $subject = 'Password reset instructions at ' . CONF_WEBSITE_NAME;

        sendMail($post['admin_email'], $subject, $message);
        Message::addMessage('Your password reset instructions have been sent to your email. Please check your spam folder if you do not find it in your inbox. Please mind that this request is valid only for next 24 hours.');

        dieJsonError(Message::getHtml());


        // redirectUser(generateUrl('admin', 'forgot_password'));
    }

    function reset_password($tocken, $admin_id) {
        if ($this->Admin->isLogged()) {
            redirectUser(generateUrl('admin'));
        }
        if (!$this->validateTocken($tocken, $admin_id)) {
            die('Invalid Tocken');
        }
        /* Syspage::addJs(array(

          'js/login_functions.js'
          ), true); */

        Syspage::addCss(
                array(
            'css/login.css'
                ), true);

        $frm = new Form('frmResetPassword');
        $frm->setExtra(' class="web_form"');
        $frm->addHiddenField('', 'tocken', $tocken);
        $frm->setJsErrorDisplay('afterfield');
        $fld = $frm->addPasswordField('New Password:', 'admin_password', '', '', '');
        $fld->requirements()->setRequired();
        $fld->requirements()->setLength(4, 20);
        $fld1 = $frm->addPasswordField('Confirm New Password', 'admin_password1', '', '', '');
        $fld1->requirements()->setRequired();
        $fld1->requirements()->setCompareWith('admin_password');

        $frm->addSubmitButton('', 'btn_submit');

        $frm->setAction(generateUrl('admin', 'password_reset', array($admin_id)));

        $this->set('frm_password', $frm);

        $this->_template->render(false, false);
    }

    function password_reset($admin_id) {
        /* @var $db Database */
        global $db;
        global $post;

        if ($this->Admin->isLogged())
            redirectUser(generateUrl('admin'));

        if (!$this->validateTocken($post['tocken'], $admin_id)) {
            die('Invalid tocken!');
        }
        if (!$db->update_from_array('tbl_admin', array('admin_password' => encryptPassword($post['admin_password'])), array('smt' => 'admin_id = ?', 'vals' => array($admin_id)))) {
            dieWithError($db->getError());
        }
        $db->query("delete from tbl_admin_password_resets_requests where appr_admin_id = " . intval($admin_id));

        Message::addMessage('Password successfully updated! Please login now with your new password.');
        redirectUser(generateUrl('admin', 'login_form'));
    }

    protected function validateTocken($tocken, $admin_id) {
        /* @var $db Database */
        global $db;

        $db->query("delete from tbl_admin_password_resets_requests where aprr_expiry < '" . date('Y-m-d H:i:s') . "'");

        $srch = new SearchBase('tbl_admin_password_resets_requests');
        $srch->addCondition('aprr_tocken', '=', $tocken);
        $srch->addCondition('appr_admin_id', '=', $admin_id);
        $rs = $srch->getResultSet();
        //$rs = $db->query("select * from tbl_admin_password_resets_requests where aprr_tocken = '" . $tocken . "'");
        $row = $db->fetch($rs);

        if (!$row) {
            die('Invalid Token! You are using invalid link. <br>Please note that password reset requests are valid for 24 hours only.');
        }
        return true;
    }

    function profile() {
        $this->_template->render();
    }

}
