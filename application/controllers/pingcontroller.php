<?php 
class PingController extends FrontController {
	
	function __construct($action) {
        parent::__construct($action);
		
	
		
    }
	
	public function default_action($orderId ='AD1510222236866'){
		 $ord = new Order();
		$ord->updateOrderStatus($orderId);
	}
	 public function subscription(){
		 
		 
		//mail('priyanka@ablysoft.com','test','test');
		$response ='';
		$post = Syspage::getPostedVar();
		
		$paymentGateway = new Paymentgateway();//$data['item_name']
		
		//
		if($paymentGateway->isPaymentSuccess(PaymentGateway::PAYMENT_GATEWAY_TYPE_PAYPAL, $post['item_name'], $post, $response) === true){
		
			$this->updatePaypalResponseForSubscription($post, $response);
		}
	
		exit(0); 
	} 
	
	public function updatePaypalResponseForSubscription($data,$response) {
		 //$user_id = Admin::getLoggedinUserId();
		$order_id = $data['item_name'];	  
		 $ord = new Order();
		 
		$order = $ord->getOrderOnly($order_id);
		
		if($order['order_paid'] == 1){
			//mail('priyanka@ablysoft.com','test2','order_paid');
			return false;
		}
		if(empty($order) || empty($data)) return;
		$transaction = New Transactions();
		
		
		$user_id = $order['order_user_id'];
		$trans['tran_order_id'] = $order_id;
        $trans['tran_amount'] = $data['mc_gross'];
        $trans['tran_payment_mode'] = 1;
        $trans['tran_real_amount'] = $order['order_amount'];       
		$trans['tran_id'] = $transaction_data['tran_id'];
		$trans['tran_completed'] =  $data['payment_status'] == 'Completed'?1:0;		
		$trans['tran_gateway_transaction_id'] = $data['txn_id'] ;
		$trans['tran_gateway_response_data'] =  $response;
	
        if ($transaction->addupdateTransaction($trans)) {
		
				$ord->updateOrderStatus($order_id);
			
            //Message::addErrorMessage($transaction->getError());
        }
		 
		
	}
}
	

?>