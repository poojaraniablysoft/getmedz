<?php

class Orderquestion extends Model {

    protected $db;
    public $question_id, $user_id, $order_id, $trans_id;
    public static $userFields = array('user_first_name', 'user_last_name', 'user_email', 'user_password');
    public static $questionFields = array(
        'orquestion_question',
        'orquestion_med_category',
        'orquestion_age',
        'orquestion_med_history',
        'orquestion_gender',
        'orquestion_seen_doctor',
        'orquestion_state',
    );

    const QUESTION_ORDER_TYPE = 1;

    public function __construct() {
        parent::__construct();
        $this->db = Syspage::getdb();
    }

    public function setupQuestion($data) {


        //Incase of logged in user

        if (intval($this->user_id) < 1) {
            $password = getRandomPassword(10);
            $data['user_password'] = encryptPassword($password);
            $data['user_active'] = 1;
            if (!$user_id = $this->saveUser($data)) {
                return false;
            }
            Users::sendUserCreationEmail($data['user_email'], array('{PASSWORD}' => $password));
        }
        if (!$this->createOrder($data, $this->user_id)) {
            return false;
        }

        if (!$this->addTransaction($data, $this->order_id)) {
            return false;
        }

        $questionData = unserialize($data['post_question']);
        if (!$this->saveQuestion($questionData, $this->order_id)) {
            return false;
        }

        return true;
    }

    public function saveUser($data) {
        $arrayToSave = array();

        foreach (self::$userFields as $key => $value) {
            if (isset($data[$value])) {
                $arrayToSave[$value] = $data[$value];
            }
        }

        $user = new Users();
        if (!$this->user_id = $user->setupUser($arrayToSave)) {
            $this->error = $user->getError();
            return false;
        }

        return true;
    }

    public function createOrder($data, $user_id) {

        if (intval($user_id < 0)) {
            $this->error = "Invalid Request";
            return false;
        }


        $arrayToSave = array();
        $this->order_id = "AD" . strtotime(date("Y-m-d h:i:s"));
        $arrayToSave['order_id'] = $this->order_id;
        $arrayToSave['order_user_id'] = $user_id;
        $arrayToSave['order_type'] = Self::QUESTION_ORDER_TYPE;
        $arrayToSave['order_net_amount'] = $data['order_amount'];

        $order = new Order();

        if (!$order->setupOrder($arrayToSave)) {
            $this->error = $order->getError();
            return false;
        }

        return true;
    }

    public function addTransaction($data, $order_id) {

        if (intval($order_id < 0)) {
            $this->error = "Invalid Request";
            return false;
        }

        $arrayToSave = array();

        $arrayToSave['tran_order_id'] = $order_id;
        $arrayToSave['tran_amount'] = $data['order_amount'];
        $arrayToSave['tran_payment_mode'] = $data['payment_mode'];
        $arrayToSave['tran_real_amount'] = $data['order_amount'];

        $trans = new Transactions();

        if (!$this->trans_id = $trans->setupTrans($arrayToSave)) {
            $this->error = $trans->getError();
            return false;
        }
        return true;
    }

    public function saveQuestion($data, $order_id) {
        $arrayToSave = array();

        if (intval($order_id < 0)) {
            $this->error = "Invalid Request";
            return false;
        }
        $arrayToSave['orquestion_order_id'] = $order_id;
        foreach (self::$questionFields as $key => $value) {
            if (isset($data[$value])) {
                $arrayToSave[$value] = $data[$value];
            }
        }
        $question = new Question();

        if (!$this->question_id = $question->setupQuestion($arrayToSave)) {
            $this->error = $question->getError();
            return false;
        }
        return true;
    }

}
