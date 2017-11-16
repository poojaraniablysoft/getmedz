<?php

Class OrderFactory {

    public $payment_type;
    public $data;

    public function __construct($payment_type, $data) {
        $this->payment_type = $payment_type;
        $this->data = $data;
    }

    public function getInstance($data) {

        $data = $this->data;
		
          /*   case 0:
                  $data['order_type'] = Orderabstract::ORDER_QUESTION;
                return new Singlepayment($data);


            case 1:*/
                $data['order_type'] = Orderabstract::ORDER_SUBSCRIPTION; 
                return new Subscriptionpayment($data);
      
        /* throw new InvalidArgumentException('Invalid arguments'); */
    }

}
