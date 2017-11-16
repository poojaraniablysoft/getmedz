<?php

abstract class Orderabstract extends Model {

    public $data = array();
    public $question_id, $user_id, $order_id, $trans_id, $sub_id,$file_id;

    CONST PAYMENT_BY_CARD = 0;
    CONST PAYMENT_BY_SUBSCRIPTION = 1;
    CONST PAYMENT_BY_PAID_PLAN = 2;
    CONST PAYMENT_BY_FREE_PLAN = 3;
    CONST ORDER_QUESTION = 0;
    CONST ORDER_SUBSCRIPTION = 1;
    CONST ORDER_COMPLETED = 1;

    public function __construct(array $data) {
        parent::__construct();
        $this->data = $data;
		
    }

    public function createUser(array $arrayToSave) {

		$user_id=Members::getLoggedUserID();
		
        if($user_id<1){ 
			$user = new Users();	
			if(!$arrayToSave['user_email']){
				return false;
			}
			if (!$this->user_id = $user->setupUser($arrayToSave)) {
				$this->error = $user->getError();
				return false;
			}
		}else{
			$this->user_id =Members::getLoggedUserID();
		}
        return $this->user_id;
    }

    public function createPassword() {

        $password = getRandomPassword(10);
        return encryptPassword($password);
    }

    public function createOrder(array $arrayToSave) {

        if (intval($this->user_id < 0)) {
            $this->error = "User is not found";
            return false;
        }

        $order = new Order();

        if (!$orderId = $order->setupOrder($arrayToSave)) {
            $this->error = $order->getError();
            return false;
        }
        $this->order_id = $orderId;
        return   $this->order_id;
    }

    public function generateOrderId() {

        return "AD" . time() . intval(microtime() * 1000);
    }

    public function addTransaction(array $arrayToSave) {

        if (intval($this->order_id < 0)) {
            $this->error = "Invalid Request";
            return false;
        }



        $trans = new Transactions();
        if (!$this->trans_id = $trans->setupTrans($arrayToSave)) {
            $this->error = $trans->getError();
            return false;
        }
        return true;
    }

    public function saveQuestion(array $arrayToSave) {


        if (intval($this->order_id) < 0) {
            $this->error = "Invalid Request";
            return false;
        }

        $question = new Question();

        if (!$this->question_id = $question->setupQuestion($arrayToSave)) {
            $this->error = $question->getError();
            return false;
        }
        return true;
    }
	public function saveQuestionAssignmentData(array $arrayToSave) {


        if (intval($this->question_id) < 0) {
            $this->error = "Invalid Request";
            return false;
        }

        $question = new Question();

        if (!$this->question_assign_id = $question->setupQuestionAssignmentData($arrayToSave)) {
            $this->error = $question->getError();
            return false;
        }
        return true;
    }

    public function uploadFile() {

        if (!empty($this->data['attachment'])) {

            $fileEntity=explode("-",$this->data['attachment']);
            $fls = new Files();
            $dat['file_record_type'] = Files::QUESTION_POST_ATTACHMENT;
            $dat['file_record_id'] = $this->question_id;
            $dat['file_path'] = $fileEntity[0];
            $dat['file_display_name'] = $fileEntity[1];
            $dat['file_display_order'] = 0;			
            $this->file_id = $fls->addFile($dat);
        }
    }

    public function activateUser($data) {
	
		
		$srch= users::searchUser();
		$srch->addCondition('user_email','=',$data['user_email']);
		$srch->addCondition('user_active','=','1');
		$srch->getResultSet();
		$rows=$srch->recordCount();

		if($rows>=1)
        return false;
		else
		return true;
    }

    public function createSubscription(array $arrayToSave) {
        $user = new Usersubscription();

        if (!$this->sub_id = $user->setupUserSubscription($arrayToSave)) {
            $this->error = $user->getError();
            return false;
        }
        return true;
    }

    public function execute() {
        
    }

    public function getUserData($data) {
		
        $userFields = array('orquestion_name'=>'user_first_name', 'orquestion_email'=>'user_email','orquestion_gender'=>'user_gender','orquestion_state'=>'user_state','orquestion_phone'=>'user_phone','orquestion_age'=>'user_age','orquestion_weight'=>'user_weight');

        foreach ($userFields as $key => $value) {
            if (isset($this->data[$key])) {
                $arrayToSave[$value] = $this->data[$key];
            }
        }
		
        return $arrayToSave;
    }

    public function sendUserMail($userData,$password) {
        $email = new Emails();
        $emailData = array('user_email' => $userData['user_email'], 'user_name' => $userData['user_first_name'], 'user_password' => $password);

        $email->accountCreatedEmail($emailData);
    }

    public function getQuestionData() {
        $questionFields = array(
            'orquestion_question',
            'orquestion_med_category',
            'orquestion_age',
            'orquestion_med_history',
            'orquestion_gender',
            'orquestion_seen_doctor',
            'orquestion_state',
			'orquestion_weight',
			'orquestion_phone',
			'orquestion_doctor_id',
        );
        foreach ($questionFields as $key => $value) {
            if (isset($this->data[$value])) {
                $arrayToSave[$value] = $this->data[$value];
            }
        }
      //  $arrayToSave['orquestion_order_id'] = $this->order_id;

        return $arrayToSave;
    }

	public function getQuestionAssignedData($userId) {
        
		$arrayToSave = array();

        $arrayToSave['qassign_doctor_id'] = $this->data['orquestion_doctor_id'];
        $arrayToSave['qassign_question_id'] =$this->question_id;     
        $arrayToSave['qassign_assigned_on'] = date("Y-m-d H:i:s");     
        $arrayToSave['qassign_assigned_by'] =   $this->user_id;
        return $arrayToSave;
    }

    public function getOrderData() {

        $arrayToSave = array();

        $arrayToSave['order_id'] = $this->generateOrderId();
        $arrayToSave['order_user_id'] = $this->user_id;
        $arrayToSave['order_type'] = $this->data['order_type'];
        $arrayToSave['order_net_amount'] = $this->data['order_amount'];
        $arrayToSave['order_plan_id'] = $this->data['tran_plan_id'];

        return $arrayToSave;
    }

    public function getTransactionData() {

        $arrayToSave = array();
        $arrayToSave['tran_order_id'] = $this->order_id;
        $arrayToSave['tran_amount'] = $this->data['order_amount'];
        $arrayToSave['tran_payment_mode'] = $this->data['payment_by'];
        $arrayToSave['tran_real_amount'] = $this->data['order_amount'];
        $arrayToSave['tran_plan_id'] = $this->data['tran_plan_id'];

        return $arrayToSave;
    }

    public function getSubsriptionData() {
        $arrayToSave = array();

        $PlanData = $this->getSubscriptionData(intval($this->data['subs_id']));

        $arrayToSave['orsubs_order_id'] = $this->order_id;
        $arrayToSave['orsubs_price'] = $this->data['order_amount'];
        $arrayToSave['orsubs_duration'] = $PlanData['subs_duration'];
        $arrayToSave['orsubs_question_allowed'] = $PlanData['subs_question'];
        $arrayToSave['orsubs_question'] = $PlanData['subs_question'];
        $validityDays = $PlanData['subs_duration'];
        $arrayToSave['orsubs_valid_from'] = date(CONF_DATE_FORMAT_PHP);
        $arrayToSave['orsubs_valid_upto'] = date(CONF_DATE_FORMAT_PHP, strtotime("+$validityDays day"));
        $arrayToSave['orsubs_subscription_id'] = $this->data['subs_id'];

        return $arrayToSave;
    }

    public function getSubscriptionData($id) {
        $srch = Subscription::getactiveSubscription();
        $srch->addCondition('subs_id', '=', $id);
        return $srch->fetch();
    }

}
