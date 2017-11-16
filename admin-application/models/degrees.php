<?php

class Degrees extends Model {

    
    public $degree_id;
    
    
    public function setupdegree($data) {
        
        $degree_id=intval($data['degree_id']);
        unset($data['degree_id']);
        $record = new TableRecord('tbl_degrees');
        $record->assignValues($data);
        if ($degree_id > 0)
            $success = $record->update(array('smt' => 'degree_id = ?', 'vals' => array($degree_id)));
        else {
            $record->assignValues($data);
            $success = $record->addNew();
        }

        if ($success) {
            $this->degree_id = ($degree_id > 0) ? $degree_id : $record->getId();
            if ($degree_id > 0) {
                Message::addMessage('Degree updated successfully.');
            } else {
                Message::addMessage('Degree added successfully.');
            }
        } else {
            $this->error = $record->getError();
        }
        return $success;
    }

}
