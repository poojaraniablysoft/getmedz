<?php

class Usersubscription extends model {

    protected $db;

    public function __construct() {
        parent::__construct();
        $this->db = Syspage::getPostedVar();
    }

    public function setupUserSubscription($data) {


        $orsubs_id = intval($data['orsubs_id']);
        unset($data['orsubs_id']);
      
        $record = new TableRecord('tbl_order_subscriptions');
        $record->assignValues($data);
        if ($orsubs_id > 0)
            $success = $record->update(array('smt' => 'orsubs_id = ?', 'vals' => array($orsubs_id)));
        else {


            $record->assignValues($data);


            $success = $record->addNew();
        }
     
        if ($success) {
            return $this->orsubs_id = ($orsubs_id > 0) ? $orsubs_id : $record->getId();
        } else {
            $this->error = $record->getError();
        }
        return $success;
    }

    
    
    public static function searchUserSubscription(){
       $srch=new SearchBaseNew('tbl_orders');
       $srch->joinTable('tbl_order_subscriptions','INNER JOIN','orsubs_order_id=order_id');
       $srch->joinTable('tbl_order_questions','LEFT JOIN','order_id=orquestion_order_id');
      
       return $srch;

    }
    
    
    public static function getUserActiveSubsByUserId($user_id){
        $srch=self::searchUserSubscription();
      
        $srch->addCondition('order_user_id','=',$user_id);
        $srch->addCondition('order_paid','=',1);
        $srch->addMultipleFields(array('count(orquestion_id) as totalPostedQuestion','orsubs_question_allowed','order_id','orsubs_id'));
        $srch->addDirectCondition('DATE(NOW()) BETWEEN orsubs_valid_from AND orsubs_valid_upto');
        
        return $srch;
    }
    
    
}
