<?php

class PaymentController extends Controller {
    /*
     * Required param order id
     */

    public function validate_transaction() {

        $post = Syspage::getPostedVar();

        $order_id = $post['order_id'];

        $order = new Transactions();
        $order->getTransById($order_id);

        if ($order->recordCount() < 1) {
            return false;
        }

        $transData = $order->fetch();
        //Set Data You need to set
        $data = array();
        $data['tran_id'] = $transData['tran_id'];


        if (!$order->setupTrans($data)) {
            return false;
        }


        return true;
    }

}

?>