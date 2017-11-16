<?php

class State extends Model {

    const ACTIVE_STATE = 1;
    const NOT_ACTIVE_STATE = 0;
    const NOT_DELETED_STATE = 0;
    const DELETED_STATE = 1;

    public static function searchStates() {
        $srch = new SearchBaseNew('tbl_states', "st");
        $srch->joinTable('tbl_countries', 'INNER JOIN', 'country_id=state_country_id');
        return $srch;
    }

    public static function getactiveStates() {
        $srch = self::searchStates();
        $srch->addCondition('state_active', '=', Self::ACTIVE_STATE);
		 $srch->addCondition('state_deleted', '=', Self::NOT_DELETED_STATE);
        return $srch;
    }

    /*
     * Ftech only the not DELATED STATES
     */

    public static function getAllStates() {
        $srch = self::searchStates();
        $srch->addCondition('state_deleted', '=', Self::NOT_DELETED_STATE);
        return $srch;
    }

    public static function getStateCountryOpt() {

        $srch = self::getactiveStates();
        $srch->addMultipleFields(array(
            'country_id',
            'country_name',
            'state_id',
            'state_name',
        ));
        $allStates = $srch->fetch_all();
   
        $options = array();
        foreach ($allStates as $value) {

            $country_id = $value['country_id'];
            $country_name = $value['country_name'];
            $state_id = $value['state_id'];
            $state_name = $value['state_name'];

            if (!isset($options[$country_id])) {
                //$options[$country_id] = array('group_caption'=> $country_name);
            }
            $options[$state_id] = $state_name;
        }
      
       
        return $options;
    }

}
