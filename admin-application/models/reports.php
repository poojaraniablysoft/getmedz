<?php

class Reports extends Model {

    static $responseTypes = array('HTML', 'CSV');

    public function customerData($startDate = "", $endDate = "") {



        $srch2 = new SearchBaseNew('tbl_tmp_orders', 'ot');
        $srch2->doNotLimitRecords();
        $srch2->doNotCalculateRecords();
        $srch2->addGroupBy('tmp_order_date');
        if (!empty($startDate) && !empty($endDate))
            $srch2->addDirectCondition("tmp_order_date BETWEEN $startDate AND $endDate");

        $srch2->addMultipleFields(array('tmp_order_date', 'count(*) as total_prospects'));

        $prospects = $srch2->fetch_all_assoc();



        $srch = new SearchBaseNew('tbl_order_transactions', 'ot');
        $srch->joinTable('tbl_order_questions', 'INNER JOIN', 'oq.orquestion_order_id=ot.tran_order_id', 'oq');
        $srch->joinTable('tbl_orders', 'INNER JOIN', 'o.order_id=ot.tran_order_id', 'o');
        $srch->doNotLimitRecords();
        $srch->doNotCalculateRecords();



        if (!empty($startDate) && !empty($endDate))
            $srch->addDirectCondition("DATE(tran_time) BETWEEN $startDate AND $endDate");


        $srch->addMultipleFields(array(
            'DATE(tran_time) as tran_date',
            "CONCAT_WS('-',COUNT(DISTINCT CASE WHEN order_type=1 THEN order_id ELSE NULL END ),COUNT(DISTINCT CASE WHEN order_type=0 AND order_payment_mode!=1 THEN order_id ELSE NULL END )) as total_sales",
        ));
        $srch->addGroupBy('DATE(tran_time)');
        $total_sales = $srch->fetch_all_assoc();



        $data = array();


        foreach ($prospects as $key => $val) {

            $data[$key]['total_prospects'] = $val;
            $sales = $upsells = 0;

            if (isset($total_sales[$key])) {
                $sales_record = explode("-", $total_sales[$key]);

                $sales = $sales_record[0];
                $upsells = $sales_record[1];
            }
            $data[$key]['total_sales'] = $sales;
            $data[$key]['total_upsells'] = $upsells;
            $data[$key]['date'] = $key;
        }

        return $data;
    }

    public function doctor_stats($startDate = "", $endDate = "") {

      //  $questions = Question::searchActiveQuestions();

        $srch = new SearchBaseNew('tbl_doctors', 'd');
        $srch->joinTable('tbl_order_questions', 'LEFT JOIN', 'd.doctor_id=oq.orquestion_doctor_id', 'oq');
        $srch->joinTable('tbl_order_transactions', 'LEFT JOIN', 'oq.orquestion_order_id=ot.tran_order_id', 'ot');
        $srch->joinTable('tbl_orders', 'LEFT JOIN', 'o.order_id=ot.tran_order_id', 'o');
        $srch->joinTable('tbl_users', 'LEFT JOIN', 'u.user_id=o.order_user_id', 'u');
        // $srch->joinTable('tbl_doctors', 'LEFT JOIN', 'd.doctor_id=oq.orquestion_doctor_id', 'd');
        $srch->addCondition('tran_completed', '=', Orderabstract::ORDER_COMPLETED);
        $srch->addDirectCondition('doctor_id IS NOT NULL');
        $srch->joinTable('(SELECT * FROM `tbl_question_replies` WHERE `reply_by`=3 GROUP BY `reply_orquestion_id`)', 'LEFT JOIN', 'r.reply_orquestion_id=oq.orquestion_id  AND reply_by=' . Question::QUESTION_REPLIED_BY_DOCTOR . " AND  DATE(reply_date) BETWEEN '$startDate' AND '$endDate'", 'r');
        $srch->addGroupBy('doctor_id');
        $srch->addGroupBy('reply_date');


        $srch->addFld(array('*', 'DATE(reply_date) as doctor_reply', 'TIME_TO_SEC(TIMEDIFF (reply_date , orquestion_doctor_accepted_at)) as response_time'));
      
        return $srch->fetch_all();
    }

}
