<?php

class Subscriptionquestionpayment extends Orderabstract {

    public function __construct(array $data) {
		
        parent::__construct($data);
    }

    public function execute() {
        //User Creation 
        //Order Creation
        if (intval($this->sub_id) < 0) {
            die('invalid access');
            return false;
        }

   
 /*      if (!$this->createOrder($orderData)) {
            return false;
        }
 */

       

        $arrayToSave = $this->getQuestionData();
		$arrayToSave['orquestion_order_id'] = $this->data['order_id'];
		
        if (!$this->saveQuestion($arrayToSave)) {
            return false;
        }
		
		 $arrayToSave = $this->getQuestionAssignedData($this->data['user_id']);
		  if (!$this->saveQuestionAssignmentData($arrayToSave)) {
            return false;
        }
		$question= new Question();
		if($question->addQuestionAssignment($subs['order_id'],$arrayToSave['qassign_question_id']))
					{
						return true;
					//	redirectUser(generateUrl());
					}else{
						return false;
					//	redirectUser(generateUrl());
					}
      //  $this->uploadFile();
        
    }

}
