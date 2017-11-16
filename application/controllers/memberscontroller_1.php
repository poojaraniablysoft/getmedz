<?php

class MembersController extends Controller {

    public function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);

//        $activeActions = array('login','email_password_instructions','validatecustomerlogin','validatedoctorlogin','reset_password','logout','customerforgot_password','getdashboard');
//        
//        
//        if(!in_array($action,$activeActions)){
//            page_404();
//        }
        
    }

    public function doctor_signup() {
        $post = Syspage::getPostedVar();
        $basic = $this->getDoctorSignupForm();
        $basic->fill($post);
        $address = $this->getDocAddressForm();
        $address->fill($post);
        $this->set("basic_details", $basic);
        $this->set("address_details", $address);
        $this->_template->render();
    }

    private function getDoctorSignupForm() {

        $frm = new Form('FrmDoc');

        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setFieldsPerRow(2);
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addHiddenField('', 'doctor_id');
        $frm->addRequiredField('First Name', 'doctor_first_name')->requirements()->setRequired();
        $frm->addRequiredField('Last Name', 'doctor_last_name')->requirements()->setRequired();


        $fld = $frm->addEmailField('Email', 'doctor_email');
        $fld->setUnique('tbl_doctors', 'doctor_email', 'doctor_id', 'doctor_email', 'doctor_email');
        $frm->addRequiredField('Medical or Graduate School', 'doctor_med_school')->requirements()->setRequired();
        $frm->addSelectBox('Medical Category', 'doctor_med_category', Medicalcategory::getActiveCategories()->fetch_all_assoc())->requirements()->setRequired();

        $frm->addSelectBox('Medical Degree', 'doctor_med_degree', Degree::getactiveDegree()->fetch_all_assoc())->requirements()->setRequired();

        $frm->addSelectBox('Medical Year', 'doctor_med_year', getYearList())->requirements()->setRequired();

        $frm->addRequiredField('License No#', 'doctor_licence_no')->requirements()->setRequired();
        $fld = $frm->addSelectBox('Medical State', 'doctor_med_state_id', State::getStateCountryOpt())->requirements()->setRequired();

        $frm->setValidatorJsObjectName('DoctorValidator');

        $fld1 = $frm->addButton('', 'btn_submit', 'Next', 'btn_submit', 'style="cursor:pointer;" onClick="doc_next_form(DoctorValidator);"');
//        $fld2 = $frm->addButton('', 'cancel', 'Cancel', '', 'class="cancel_form reset_button" style="margin-left:10px; cursor:pointer;"');
//        $fld1->attachField($fld2);
        //$fld1->merge_cells=2;


        return $frm;
    }

    private function getDocAddressForm() {

        $frm = new Form('FrmDoc2');
        $frm->setAction(generateUrl('members', 'doc_setup'));
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setFieldsPerRow(2);
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->setValidatorJsObjectName('DoctorValidator2');
        $frm->addHiddenField('', 'doctor_id');


        $frm->addRequiredField('Address', 'doctor_address')->requirements()->setRequired();
        $frm->addRequiredField('City', 'doctor_city')->requirements()->setRequired();

        $fld = $frm->addSelectBox('State', 'doctor_state_id', State::getStateCountryOpt())->requirements()->setRequired();
        $frm->addIntegerField('House No#', 'doctor_house_no')->requirements()->setRequired();
        $frm->addIntegerField('Pincode', 'doctor_pincode')->requirements()->setRequired();
        $frm->addIntegerField('Phone No#', 'doctor_phone_no')->requirements()->setRequired();

        $fld1 = $frm->addButton('', 'btn_submit', 'Submit', 'btn_submit', 'style="cursor:pointer;" onclick="submitSetup(DoctorValidator2);"');
        $fld2 = $frm->addButton('', 'back', 'back', '', 'class="cancel_form " style="margin-left:10px; cursor:pointer;" onclick="do_prev_form()"');
        $fld1->attachField($fld2);
        //$fld1->merge_cells=2;


        return $frm;
    }

    public function doc_setup() {
        $post = Syspage::getPostedVar();


        $doc = new Doctor();
        $perForm = $this->getDoctorSignupForm();
        $addForm = $this->getDocAddressForm();


        if (!$perForm->validate($post) || !$addForm->validate($post)) {
            Message::addErrorMessage($perForm->getValidationErrors());
            Message::addErrorMessage($addForm->getValidationErrors());
            redirectUser(generateUrl('members', 'doctor_signup'));
        }

        if (!$doc->setupDoctor($post)) {
            redirectUser(generateUrl('members', 'doctor_signup'));
        }

        redirectUser(generateUrl('site', 'success'));
    }

    public function login() {
        if (Members::isUserLogged()) {
            $this->getDashboard();
        }
        Syspage::addCss(
                array(
            'css/customer-style.css'
                ), true);
        /* Check if any valid details saved in cookies */
        if (isset($_COOKIE['askdoctor_remember'])) {

            $cookie_arr = explode('|', $_COOKIE['askdoctor_remember']);

            if ($this->Members->validateCookie($cookie_arr, $user_data)) {

                if ($cookie_arr[1] == Members::CUSTOMER_USER_TYPE) {
                    if ($this->Members->validateCustomerLogin($user_data['user_email'], $user_data['user_password'], true)) {
                        if (Members::isUserLogged())
                            redirectUser(generateUrl('members', 'getDashboard'));
                    }else {
                        $this->Member->updateCookie($user_data['user_id'], true, Members::CUSTOMER_USER_TYPE); /* Delete cookie something fishy, cookie data not validated */
                    }
                } elseif ($cookie_arr[1] == Members::DOCTOR_USER_TYPE) {
                    if ($this->Members->validateDoctorLogin($user_data['doctor_email'], $user_data['doctor_password'], true)) {
                        if (Members::isUserLogged()) {
                            redirectUser(generateUrl('members', 'getDashboard'));
                        }
                    } else {
                        $this->Members->updateCookie($user_data['doctor_id'], true, Members::DOCTOR_USER_TYPE); /* Delete cookie something fishy, cookie data not validated */
                    }
                }
            }
        }

        $customerfrm = $this->getCustomerLoginForm();
        $doctorfrm = $this->getDoctorLoginForm();
        $this->set('customerfrm', $customerfrm);
        $this->set('doctorfrm', $doctorfrm);
        $this->_template->render();
    }

    function getDashboard() {
        $user_type = $this->Members->getLoggedUserAttribute('user_type');
        if ($user_type == Members::CUSTOMER_USER_TYPE) {
            redirectUser(generateUrl('customer', ''));
        } elseif ($user_type == Members::DOCTOR_USER_TYPE) {
            redirectUser(generateUrl('doctor', ''));
        }
    }

    function getCustomerLoginForm() {
        $frm = new Form('frmCustomerLogin', 'frmCustomerLogin');
        $frm->setExtra(' class="form_tbl"');
        $frm->addEmailField('Email Address', 'user_email', '', '', 'placeholder="Email Address"')->requirements()->setRequired();

        $frm->addPasswordField('Password', 'user_password', '', '', 'placeholder="Password"')->requirements()->setRequired();
        $frm->addCheckBox('Remember Me ', 'chk_remember', '1');
        $frm->setAction(generateUrl('members', 'validateCustomerLogin'));

        $frm->addHiddenField('Refer Page', 'page_reffer', $_SERVER['HTTP_REFERER']);
        $frm->addSubmitButton('', 'btn_login', 'Login', 'btn_login', 'class="btn_submit"');
        return $frm;
    }

    function getDoctorLoginForm() {
        $frm = new Form('frmDoctorLogin', 'frmDoctorLogin');
        $frm->setExtra(' class="form_tbl"');
        $frm->addEmailField('Email Address', 'doctor_email', '', '', 'placeholder="Email Address"')->requirements()->setRequired();

        $frm->addPasswordField('Password', 'doctor_password', '', '', 'placeholder="Password"')->requirements()->setRequired();
        $frm->addCheckBox('Remember Me ', 'chk_remember', '1');
        $frm->setAction(generateUrl('members', 'validateDoctorLogin'));

        $frm->addHiddenField('Refer Page', 'page_reffer', $_SERVER['HTTP_REFERER']);
        $frm->addSubmitButton('', 'btn_login', 'Login', 'btn_login', 'class="btn_submit"');
        return $frm;
    }

    function validateCustomerLogin() {
        $post = Syspage::getPostedVar();
        global $msg;

        $frm = $this->getCustomerLoginForm();
        //$frm->setValidationLangFile('includes/form-validation-lang.php');
        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('members', 'login'));
        }

        if (!$this->Members->validateCustomerLogin($post['user_email'], $post['user_password'])) {
            //  Message::addErrorMessage($this->Members->getError());
            redirectUser(generateUrl('members', 'login'));
        }
        $user_id = $this->Members->getLoggedUserAttribute('user_id');
        /* Remember me check-box */
        if (isset($post['chk_remember'])) {

            $this->Members->updateCookie($user_id, '', Members::CUSTOMER_USER_TYPE); /* Set Cookies */
        } else {
            $this->Members->updateCookie($user_id, true, Members::CUSTOMER_USER_TYPE); /* destroy any previously set cookie */
        }
        redirectUser(generateUrl('customer', ''));
    }

    function validateDoctorLogin() {
        $post = Syspage::getPostedVar();
        global $msg;

        $frm = $this->getDoctorLoginForm();

        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('members', 'login'));
        }

        if (!$this->Members->validateDoctorLogin($post['doctor_email'], $post['doctor_password'])) {

            //Message::addErrorMessage($this->Members->getError());
            redirectUser(generateUrl('members', 'login'));
        }

        $doctor_id = $this->Members->getLoggedUserAttribute('doctor_id');
        /* Remember me check-box */
        if (isset($post['chk_remember'])) {

            $this->Members->updateCookie($doctor_id, '', Members::DOCTOR_USER_TYPE); /* Set Cookies */
        } else {

            $this->Members->updateCookie($doctor_id, true, Members::DOCTOR_USER_TYPE); /* destroy any previously set cookie */
        }


        redirectUser(generateUrl('doctor', ''));
    }

    function logout() {

        /* Expire Cookies if any */
        $user_id = Members::getLoggedUserAttribute('user_id');
        $doctor_id = Members::getLoggedUserAttribute('doctor_id');
        $this->Members->updateCookie($user_id, true, Members::CUSTOMER_USER_TYPE);
        $this->Members->updateCookie($doctor_id, true, Members::DOCTOR_USER_TYPE);


        if (intval($doctor_id) > 0) {
            $Doctor = new Doctor();
            $Doctor->updateDoc(array('doctor_id' => $doctor_id, 'doctor_is_online' => 0));
        }

        session_destroy();
        redirectUser(generateUrl());
    }

    /* ---- Forgot Password-----  */

    function customerforgot_password() {
        Syspage::addCss(
                array(
            'css/customer-style.css'
                ), true);
        $post = Syspage::getPostedVar();
        if (Members::isUserLogged()) {
            redirectUser(generateUrl('members', 'getDashboard'));
        }
        $frm = new Form('frmForgotPassword', 'frmForgotPassword');
        $frm->setExtra(' class="form_tbl"');
        $frm->addEmailField('Email ID', 'user_email', '', '', ' placeholder="Email Address"');
        $frm->addRequiredField('Security Code', 'security_code', '', '', ' placeholder="Security Code"');
        $frm->addHiddenField('', 'user_type', intval(Members::CUSTOMER_USER_TYPE), '', '', '');
        $frm->addHTML('', 'securimage', '<img src="' . captchaImgUrl() . '" class="captcha-img" id="image"><a   class="refreshbtn" href="javascript:void(0);" onclick="document.getElementById(\'image\').src = \'' . captchaImgUrl() . '?sid=\' + Math.random(); return false"><i class="icon ion-android-sync"></i></a>');
        $frm->addSubmitButton('', 'btn_submit', 'Submit', '', 'class="btn_submit"');
        $frm->setAction(generateUrl('members', 'email_password_instructions'));
        $this->set('frm', $frm);
        $this->_template->render();
    }

    function reset_password($token) {
        $post = Syspage::getPostedVar();
        global $db;
        Syspage::addCss(
                array(
            'css/customer-style.css'
                ), true);
        if (Members::isUserLogged()) {
            redirectUser(generateUrl('members', 'getDashboard'));
        }
        if (!Members::validatePasswordResetToken($token)) {
            redirectUser(generateUrl('site', 'notfound'));
        }



        /* Validate new password */
        if ($post['mode'] == 'setup_reset_password' AND isset($post['mode'])) {

            $token_arr = explode('.', $post['token']);
            $user_id = intval($token_arr[0]);
            $type = intval($token_arr[2]);
            // $attempts = $this->checkLoginAttempts(intval($user_id), 5);
            // if ($attempts) {

            if (!$db->update_from_array('tbl_users', array('user_password' => encryptPassword($post['user_password'])), array('smt' => 'user_id = ?', 'vals' => array($user_id)))) {
                die($db->getError());
            }
            $db->query("delete from tbl_user_password_reset_requests where uprr_user_id = '" . intval($user_id) . "'  and uprr_user_type='" . $type . "' ");
            /*    $db->insert_from_array('tbl_user_password_reset_count', array('uprc_user_id' => intval($user_id), 'uprc_updated' => date('Y-m-d H:i:s'))); */
            Message::addMessage('Password successfully updated! Please login now with your new password.');
            redirectUser(generateUrl('members', 'login'));
            exit();
            /*  } else {
              Message::addErrorMessage(t_lang('You have already tried a lots, please try again after 24 hours.'));
              redirectUser(generateUrl('members', 'customerforgot_password'));
              /* } */
        }

        $frm = new Form('frmResetPassword', 'frmResetPassword');
        $frm->addHiddenField('', 'mode', 'setup_reset_password');
        $frm->addHiddenField('', 'token', $token);
        $frm->addHiddenField('', 'user_type', $type);
        $frm->setExtra(' class="form_tbl"');
        $fld = $frm->addPasswordField('New Password', 'user_password', '', '', ' placeholder="Enter new password"');
        $fld->requirements()->setRequired();
        $fld->requirements()->setLength(6, 20);
        $fld1 = $frm->addPasswordField('Confirm New Password', 'user_password1', '', '', ' placeholder="Confirm Password"');
        $fld1->requirements()->setRequired();
        $fld1->requirements()->setCompareWith('user_password');

        $frm->setJsErrorDisplay('afterfield');
        $frm->addSubmitButton('', 'btn_submit', 'Submit', '', 'class="btn_submit"');
        //$frm->setAction(generateUrl('member', 'reset_password'));
        $this->set('frm', $frm);

        $this->_template->render();
    }

    /* Email Password instructions on forgot password request.
     */

    function email_password_instructions() {
        global $db;
        $post = Syspage::getPostedVar();
        $user_type = $post['user_type'];
        if (Members::isUserLogged()) {
            redirectUser(generateUrl('members', 'getDashboard'));
        }
        if (!verifyCaptcha()) {
            Message::addErrorMessage('You entered incorrect Security Code. Please Try Again.');
            if ($user_type == Members::CUSTOMER_USER_TYPE) {
                redirectUser(generateUrl('members', 'customerforgot_password'));
            } elseif ($user_type == Members::DOCTOR_USER_TYPE) {
                redirectUser(generateUrl('member', 'doctorforgot_password'));
            } else {
                redirectUser(generateUrl('members', 'customerforgot_password'));
            }
        }

        if ($user_type == Members::CUSTOMER_USER_TYPE) {
            $srch = new SearchBase('tbl_users');
            $srch->addCondition('user_email', '=', $post['user_email']);
            $srch->addMultipleFields(array('user_id', 'user_email', 'user_first_name'));
            $rs = $srch->getResultSet();
            if (!$row_user = $db->fetch($rs)) {
                Message::addErrorMessage('Invalid Email ID!');
                redirectUser(generateUrl('members', 'customerforgot_password'));
            }
        } elseif ($user_type == Members::DOCTOR_USER_TYPE) {
            $srch = new SearchBase('tbl_users');
            $srch->addCondition('user_email', '=', $post['user_email']);
            $srch->addMultipleFields(array('user_id', 'user_email'));
            $rs = $srch->getResultSet();
            if (!$row_user = $db->fetch($rs)) {
                Message::addErrorMessage('Invalid Email ID!');
                redirectUser(generateUrl('member', 'doctorforgot_password'));
            }
        } else {
            Message::addErrorMessage('Invalid Access');
            redirectUser(generateUrl('member', 'customerforgot_password'));
        }


        /*   $attempts = $this->checkLoginAttempts(intval($row_user['user_id']), 4);
          if ($attempts) { */
        $user_id = intval($row_user['user_id']);
        $db->query("delete from tbl_user_password_reset_requests where uprr_expiry < '" . date('Y-m-d H:i:s') . "'  and uprr_user_type='" . $user_type . "' ");

        $rs = $db->query("select * from tbl_user_password_reset_requests where uprr_user_id = '" . intval($row_user['user_id']) . "' and uprr_user_type='" . $user_type . "' ");
        if ($row_request = $db->fetch($rs)) {
            Message::addErrorMessage('Your request to reset password has already been placed within last 24 hours. Please check your emails or retry after 24 hours of your previous request');
            if ($user_type == Members::CUSTOMER_USER_TYPE) {
                redirectUser(generateUrl('members', 'customerforgot_password'));
            } else {
                redirectUser(generateUrl('members', 'doctorforgot_password'));
            }
        }

        $token = encryptPassword(getRandomPassword(20));
        $db->insert_from_array('tbl_user_password_reset_requests', array(
            'uprr_user_id' => $row_user['user_id'],
            'uprr_token' => $token,
            'uprr_expiry' => date('Y-m-d H:i:s', strtotime("+1 DAY")),
            'uprr_user_type' => $user_type,
        ));

        $reset_url = 'http://' . $_SERVER['SERVER_NAME'] . generateUrl('members', 'reset_password', array($row_user['user_id'] . '.' . $token . '.' . $post['user_type']));

        $row_tpl = SITE::getEmailTemplate('forgot_password');

        $subject = $row_tpl['tpl_subject'];
        $body = $row_tpl['tpl_body'];



        $arr_replacements = array(
            '{website_name}' => CONF_WEBSITE_NAME,
            '{website_url}' => $_SERVER['SERVER_NAME'],
            '{site_date}' => displayDate(date('Y-m-d H:i:s')),
            '{reset_url}' => $reset_url,
            '{user_name}' => $row_user['user_first_name'],
        );

        foreach ($arr_replacements as $key => $val) {
            $subject = str_replace($key, $val, $subject);
            $body = str_replace($key, $val, $body);
        }

        sendMail($post['user_email'], $subject, $body);

        Message::addMessage('Your password reset instructions are sent to your email. Please check your spam folder if you do not find it in your in-box. Please mind that this request is valid only for next 24 hours.');

        redirectUser(generateUrl('members', 'customerforgot_password'));
        /*  } else {
          Message::addErrorMessage('You have already tried a lots, please try again after 24 hours.');
          redirectUser(generateUrl('member', 'forgot_password'));
          } */
    }

}
