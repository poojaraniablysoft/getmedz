<?php

class Faqs extends Model {

    
    public $faq_id;
    
    
    public function setupFaqs($data) {
        
        $faq_id=intval($data['faq_id']);
        unset($data['faq_id']);
        $record = new TableRecord('tbl_faq');
        $record->assignValues($data);
        if ($faq_id > 0)
            $success = $record->update(array('smt' => 'faq_id = ?', 'vals' => array($faq_id)));
        else {
            $record->assignValues($data);
            $success = $record->addNew();
        }

        if ($success) {
            $this->faq_id = ($faq_id > 0) ? $faq_id : $record->getId();
            if ($faq_id > 0) {
                Message::addMessage('Faq updated successfully.');
            } else {
                Message::addMessage('Faq added successfully.');
            }
        } else {
            $this->error = $record->getError();
        }
        return $success;
    }

}
