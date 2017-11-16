<?php

class AccountController extends FrontController {

    public function setpassword() {



        if (intval($_SESSION['Ask_Guest']['user_id']) < 1 && $_SESSION['Ask_Guest']['token'] < time()) {
            $this->invalidRequest();
        }


        global $db;
        $frm = $this->change_password_form();
        $post = Syspage::getPostedVar();
        if ($post['mode'] == 'SET_PASS') {

            if (!$frm->validate($post)) {
                Message::addErrorMessage($frm->getValidationErrors());
                redirectUser(generateUrl('account', 'setpassword'));
            }


            $user_id = intval($_SESSION['Ask_Guest']['user_id']);

            // $attempts = $this->checkLoginAttempts(intval($user_id), 5);
            // if ($attempts) {

            if (!$db->update_from_array('tbl_users', array('user_password' => encryptPassword($post['user_password'])), array('smt' => 'user_id = ?', 'vals' => array($user_id)))) {
                die($db->getError());
            }
            unset($_SESSION['Ask_Guest']);
            Message::addMessage('Password successfully updated! Please login now with your new password.');
            redirectUser(generateUrl('members', 'login'));
            exit();
        }
        $this->set('frm', $frm);
        $this->set('postData', $_SESSION['Ask_Guest']['data']);

        $this->_template->render();
    }

    private function change_password_form() {

        $frm = new Form('frmResetPassword', 'frmResetPassword');
        $frm->addHiddenField('', 'mode', 'SET_PASS');

        $frm->setExtra(' class="forgot_paswrd"');
        $fld = $frm->addPasswordField('New Password', 'user_password', '', '', ' placeholder="Enter new password"');
        $fld->requirements()->setRequired();
        $fld->requirements()->setLength(6, 20);
        $fld1 = $frm->addPasswordField('Confirm New Password', 'user_password1', '', '', ' placeholder="Confirm Password"');
        $fld1->requirements()->setRequired();
        $fld1->requirements()->setCompareWith('user_password');

        $frm->addSubmitButton('', 'btn_submit', 'Submit', '', 'class="btn"');
        $frm->setAction(generateUrl('account', 'setpassword'));
        return $frm;
    }

    public function checkoutpage() {
		$checkOutArray=Syspage::getPostedVar();	
		
		$paypal['currency_code']= 'USD';
		$paypal['item_name']=$checkOutArray['order_id'];
		$paypal['amount']=$checkOutArray['order_amount'];
		$paypal['quantity']=1;
		$paypal['custom']=$checkOutArray['trans_id'];
		$paypal_frm = $this->getPaypalOrderForm();
		$paypal_frm->fill($paypal);
		$this->set('paypal_frm', $paypal_frm);		
        $this->set('checkOutArray',$checkOutArray);
        $this->_template->render(true,true,'account/checkout.php');
    }
	
	function success(){
		 $this->_template->render(true,true,'account/success.php');
		 unset($_SESSION['step']);
		 unset($_SESSION['step_1']);
		 unset($_SESSION['step_2']);
		 unset($_SESSION['step_3']);
		 unset($_SESSION['step_4']);
		 unset($_SESSION['step_5']);
	}
	
	function cancel(){
		 
			Message::addErrorMessage(getLabel('M_Order_cancel'));
			redirectUser(generateUrl('home'));
		
	}

}
