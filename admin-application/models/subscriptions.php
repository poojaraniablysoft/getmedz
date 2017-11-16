<?php

class Subscriptions extends Model {

    
    public $subs_id;
    
    
    public function setupSubscription($data) {
        
        $subs_id=intval($data['subs_id']);
        unset($data['subs_id']);
        $record = new TableRecord('tbl_subscriptions');
        $record->assignValues($data);

        if ($subs_id > 0)
            $success = $record->update(array('smt' => 'subs_id = ?', 'vals' => array($subs_id)));
        else {
            $record->assignValues($data);
            $success = $record->addNew();
        }

        if ($success) {
            $this->subs_id = ($subs_id > 0) ? $subs_id : $record->getId();
            if ($subs_id > 0) {
                Message::addMessage('Subscripion updated successfully.');
            } else {
                Message::addMessage('Subscripion added successfully.');
            }
        } else {
            $this->error = $record->getError();
        }
        return $success;
    }

}
