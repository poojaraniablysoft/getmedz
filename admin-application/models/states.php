<?php

class States extends Model {

    
    public $state_id;
    
    
    public function setupStates($data) {
        
        $state_id=intval($data['state_id']);
        unset($data['state_id']);
        $record = new TableRecord('tbl_states');
        $record->assignValues($data);
        if ($state_id > 0)
            $success = $record->update(array('smt' => 'state_id = ?', 'vals' => array($state_id)));
        else {
            $record->assignValues($data);
            $success = $record->addNew();
        }

        if ($success) {
            $this->state_id = ($state_id > 0) ? $state_id : $record->getId();
            if ($state_id > 0) {
                Message::addMessage('State updated successfully.');
            } else {
                Message::addMessage('State added successfully.');
            }
        } else {
            $this->error = $record->getError();
        }
        return $success;
    }

}
