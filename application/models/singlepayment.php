<?php

class Singlepayment extends Orderabstract {

    public function __construct(array $data) {
        parent::__construct($data);
    }

    public function execute() {
die;
        //User Creation 
        $userData = $this->getUserData();
		 
        $password = getRandomPassword(10);
        $userData['user_password'] = encryptPassword($password);
		
        if (!$user_id = $this->createUser($userData)) {
            return false;
        }



        //Order Creation
        $orderData = $this->getOrderData();
        if (!$this->createOrder($orderData)) {
            return false;
        }


        /* $transData = $this->getTransactionData();
        if (!$this->addTransaction($transData)) {
            return false;
        } */

        $arrayToSave = $this->getQuestionData();
        if (!$this->saveQuestion($arrayToSave)) {
            return false;
        }

        $this->uploadFile();
        /* if ($this->activateUser($userData)) { */
            $this->sendUserMail($password);
        /* } */
        return true;
    }

}
