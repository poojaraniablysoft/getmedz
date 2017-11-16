<?php

class Customer extends Model {

    Const DELETED_CUSTOMER = 1;
    Const NOTDELETED_CUSTOMER = 0;

    private $customer_id;

    public function __construct($custmor_id) {
        parent::__construct();
        $this->customer_id = $custmor_id;
    }

    public static function searchCustomer() {
        $srch = new SearchBaseNew('tbl_users', "u");
        $srch->addCondition('user_deleted', '=', self::NOTDELETED_CUSTOMER);
        return $srch;
    }

    public static function searchDoctorAssociatedCustomer() {
        $srch = self::searchCustomer();
        $srch->joinTable('tbl_orders', 'INNER JOIN', 'order_user_id=u.user_id', 'o');
        $srch->joinTable('tbl_order_questions', 'INNER JOIN', 'o.order_id=oq.orquestion_order_id', 'oq');

        return $srch;
    }

    public function getCustomerQuestions() {
        $Question = new Question();
        $srch = $Question->searchQuestions();
        $srch->addCondition('user_id', '=', $this->customer_id);
        return $srch;
    }
	
	public function getCustomerPayments($user_id){
		$srch= Transactions::searchTrans();
		 $srch->joinTable('tbl_subscriptions', 'INNER JOIN', 'tran_plan_id=subs_id');
		$srch->addCondition('order_user_id','=',$user_id);
		//$srch->addCondition('tran_completed','=',1);
		$srch->addCondition('tran_plan_id','>=',1);
		
		$srch->addCondition('order_net_amount','>',0);
		$srch->addMultipleFields(array('subs_name','order_user_id','order_id','tran_plan_id'));
		//$srch->addGroupBy('tran_id');
		return $srch;
	
	}

    public function getCustomerQuestionReply($question_id) {

        $Question = new Question();
        $srch = $Question->getReplies();
        $srch->addCondition('orquestion_id', '=', $question_id);
        $srch->addCondition('user_id', '=', $this->customer_id);
        return $srch;
    }

    function addReviews($data) {
        if ($data['review_doctor_id'] < 1) {
            $this->error = 'Invalid Input.';
            return false;
        }
        $review_id = $data['review_id'];
        $user_id = Members::getLoggedUserAttribute('user_id');

        $data['review_user_id'] = $user_id;
        $data['review_active'] = 1; /* Need approval before publishing */

        $record = new TableRecord('tbl_doctor_reviews');
        $record->assignValues($data, false);
        $record->setFldValue('review_posted_on', 'mysql_func_NOW()', true);
        if ($review_id < 1) {


            $success = $record->addNew(array(), $data);
        } else {
            $success = $record->update(array('smt' => 'review_id = ?', 'vals' => array($review_id)));
        }
        if (!$success) {
            $this->error = $record->getError();
        }

        return   ($review_id > 0) ? $review_id : $record->getId();;
    }

    static public function search_reviews() {
        $srch = new SearchBase('tbl_doctor_reviews', 'r');
        $srch->joinTable('tbl_users', 'INNER JOIN', 'u.user_id=r.review_user_id', 'u');
        return $srch;
    }

}

?>