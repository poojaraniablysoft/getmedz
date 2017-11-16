<?php

class Questionlog extends Model {

 
    protected $log_id;
    public function acceptLog($data) {

        if (!isset($data['log_doctor_id']) || !isset($data['log_question_id'])) {
            $this->error = "Invalid request";
            return false;
        }


        $record = new TableRecord('tbl_question_acceptance_log');
        $record->assignValues($data);
        if (!$record->addNew()) {
            $this->error= $record->getError();
            return false;
        }
       
        $this->log_id = $record->getId();
        return true;
    }
    
    public function getLogId(){
        
        return $this->log_id;
    }

}
