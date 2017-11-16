<?php

class Country extends Model {

  
    const NOT_DELETED_COUNTRY= 0;
    const DELETED_COUNTRY = 1;

    public static function searchCountries() {
        $srch = new SearchBaseNew('tbl_countries', "cn");
        return $srch;
    }

    public static function getactiveCountries() {
        $srch = new SearchBaseNew('tbl_countries', "cn");
        $srch->addCondition('country_deleted', '=', Self::NOT_DELETED_COUNTRY);
        return $srch;
    }

  

}
