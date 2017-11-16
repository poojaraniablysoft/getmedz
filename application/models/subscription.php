<?php

class Subscription extends Model {

    const ACTIVE_SUBSCRIPTION = 1;
    const NOT_ACTIVE_SUBSCRIPTION = 0;
    const NOT_DELETED_SUBSCRIPTION = 0;
    const DELETED_SUBSCRIPTION = 1;

    public static function searchSubscriptions() {
        $srch = new SearchBaseNew('tbl_subscriptions', "d");
        $srch->addCondition('subs_deleted', '=', Self::NOT_DELETED_SUBSCRIPTION);
        return $srch;
    }

    public static function getactiveSubscription() {
        $srch = new SearchBaseNew('tbl_subscriptions', "d");
        $srch->addCondition('subs_active', '=', Self::ACTIVE_SUBSCRIPTION);
        $srch->addCondition('subs_deleted', '=', Self::NOT_DELETED_SUBSCRIPTION);
        return $srch;
    }

    /*
     * Fetch only the not DELETED Subscriptions
     */

    public static function getAllSubscription() {
        $srch = new SearchBaseNew('tbl_subscriptions', "st");
        $srch->addCondition('subs_deleted', '=', Self::NOT_DELETED_SUBSCRIPTION);
        return $srch;
    }

}
