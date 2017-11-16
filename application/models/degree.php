<?php

class Degree extends Model {

    const ACTIVE_DEGREE = 1;
    const NOT_ACTIVE_DEGREE = 0;
    const NOT_DELETED_DEGREE = 0;
    const DELETED_DEGREE = 1;

    public static function searchDegrees() {
        $srch = new SearchBaseNew('tbl_degrees', "d");
        return $srch;
    }

    public static function getactiveDegree() {
        $srch = new SearchBaseNew('tbl_degrees', "d");
        $srch->addCondition('degree_active', '=', Self::ACTIVE_DEGREE);
        $srch->addCondition('degree_deleted', '=', Self::NOT_DELETED_DEGREE);
        return $srch;
    }

    /*
     * Fetch only the not DELETED Degrees
     */

    public static function getAllDegree() {
        $srch = new SearchBaseNew('tbl_degrees', "st");
        $srch->addCondition('degree_deleted', '=', Self::NOT_DELETED_DEGREE);
        return $srch;
    }

}
