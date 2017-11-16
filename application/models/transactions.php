<?php

class Transactions extends Model {

    CONST TRANS_COMPLETED=1;
    CONST TRANS_NOTCOMPLETED=1;
    public function setupTrans($data) {


       $trans_id = intval($data['tran_id']);
        unset($data['tran_id']);
        $record = new TableRecord('tbl_order_transactions');
        $record->assignValues($data);
        if ($trans_id > 0){
			
            $success = $record->update(array('smt' => 'tran_id = ?', 'vals' => array($trans_id)));
		}
        else {
			
            $record->assignValues($data);
            $success = $record->addNew();
        }

        if ($success) {
            return $this->trans_id = ($trans_id > 0) ? $trans_id : $record->getId();
        } else {
            $this->error = $record->getError();
        }
        return $success;
    }

    public function addupdateTransaction($data) {

        $db = Syspage::getdb();
        $trans_id = intval($data['tran_id']);
        $status = intval($data['tran_completed']);

      
          
		if (!$this->setupTrans($data)) {
			return false;
		}

		

        

        return true;
    }

    static public function searchTrans() {
        $srch = new SearchBaseNew('tbl_order_transactions', 'trans');
        $srch->joinTable('tbl_orders', 'LEFT JOIN', 'tran_order_id=order_id');
        $srch->joinTable('tbl_users', 'LEFT JOIN', 'order_user_id=user_id','u');
        return $srch;
    }

    public function getTransById($order_id) {

        $srch = $this->searchTrans();
        $srch->addCondition('tran_order_id', '=', $order_id);
        return $srch;
    }
	
	 static function getTotalAmountReceiveByOrderId($orderId){
		global $db;
		$srch = new SearchBaseNew('tbl_order_transactions', 'trans');
        $srch->addCondition('tran_order_id', '=', $orderId);
		$srch->addFld('sum(tran_amount)as amountReceived');
		$res = $srch->getResultSet();
		$result = $db->fetch($res);
		
        return $result['amountReceived'];
	}
	
	
}
