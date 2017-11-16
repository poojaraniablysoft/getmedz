
<?php

class Order extends Model {

    protected $db;

    public function __construct() {
        parent::__construct();
        $this->db = Syspage::getPostedVar();
    }

    public function setupOrder($data) {


        $order_id = $data['order_id'];
        
        $record = new TableRecord('tbl_orders');
        $record->assignValues($data);
        $success = $record->addNew();
        if (!$success) {
           
            $this->error = $record->getError();
        }
        return $order_id;
    }
	static function getOrderOnly($order_id){
		global $db;
		$search = new SearchBase('tbl_orders');
		$search->addCondition('order_id','=',$order_id);
		$rs = $search->getResultSet($search);
		$row = $db->fetch($rs);
		return $row;
	}
	
	public function updateOrderStatus($orderId){
		
		$order = $this->getOrderOnly($orderId);
		$amountRecieved = Transactions::getTotalAmountReceiveByOrderId($orderId);
		if($order['order_net_amount']==$amountRecieved){
			
				$OrderData['order_paid']=1;
				$record = new TableRecord('tbl_orders');
				$record->assignValues($OrderData);
				if ($orderId ){			
					$success = $record->update(array('smt' => 'order_id = ?', 'vals' => array($orderId)));
					
					if($success){
						
						$question = new Question();
						$question->addQuestionAssignment($orderId);

					}
				}
		}
	}
    

}
