<?php

class Review extends Model {

    public static function searchReviews() {
        $srch = new SearchBaseNew('tbl_doctor_reviews', "r");
        $srch->joinTable('tbl_orders', 'INNER JOIN', 'r.review_order_id=o.order_id', 'o');
        $srch->joinTable('tbl_users', 'INNER JOIN', 'r.review_user_id=u.user_id', 'u');
        $srch->joinTable('tbl_doctors', 'INNER JOIN', 'r.review_doctor_id=d.doctor_id', 'd');
        return $srch;
    }

}
