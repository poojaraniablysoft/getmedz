<?php

class Tmporders extends Model {

    public function tmpOrderSetup($data) {

        if ( !isset($data['tmp_session_id'])) {
            $this->error = "Invalid request";
            return false;
        }

        $data['tmp_order_date']='mysql_func_NOW()';
        $record = new TableRecord('tbl_tmp_orders');
        $record->assignValues($data,true,'','',true);
        if (!$record->addNew(array('IGNORE'),$data)) {
			die;
            $this->error = $record->getError();
            return false;
        }

        return true;
    }

}
