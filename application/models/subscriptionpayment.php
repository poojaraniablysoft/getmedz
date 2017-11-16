<?php

class Subscriptionpayment extends Orderabstract {

    public function __construct(array $data) {
        parent::__construct($data);
    }

    public function execute() {

        //User Creation 
        $userData = $this->getUserData();
		
        $password = getRandomPassword(10);
        $userData['user_password'] = encryptPassword($password);
        $user_id = Members::getLoggedUserID();

       
		if(!$user_id = $this->createUser($userData))
		return false;
       


        //Order Creation
        $orderData = $this->getOrderData();
        if (!$this->createOrder($orderData)) {
            return false;
        }

		$orderId = $orderData['order_id'];
        $arrayToSave = $this->getSubsriptionData();
		$arrayToSave['orsubs_order_id']=$orderId;
        if (!$this->createSubscription($arrayToSave)) {
            return false;
        }


       /*  $transData = $this->getTransactionData();
        if (!$this->addTransaction($transData)) {
            return false;
        } */




        //Post A question A question
        if (!$this->postQuestion($orderId)) {
            return false;
        }
        $this->uploadFile();
        $this->sendUserMail($userData,$password);
     /*    if ($this->activateUser()) { */
       /*  } */

        return true;
    }

    public function postQuestion($orderId) {

        $data = array_merge($this->data, array('payment_mode' => Orderabstract::ORDER_SUBSCRIPTION,'order_type'=>  Orderabstract::ORDER_QUESTION, 'order_amount' => 0, 'payment_by' => Orderabstract::PAYMENT_BY_SUBSCRIPTION,'order_id' =>$orderId));
        $questionPost = new Subscriptionquestionpayment($data);
        $questionPost->sub_id = $this->sub_id;
        $questionPost->user_id = $this->user_id;
        $questionPost->orquestion_order_id = $orderId;
        return $questionPost->execute();
    }

}
