<?php

class Faqcategory extends Model {

   
    public function setup($data) {
        
        $faqcat_id=intval($data['faqcat_id']);
        unset($data['faqcat_id']);
        $record = new TableRecord('tbl_faq_category');
        $record->assignValues($data);
        if ($faqcat_id > 0)
            $success = $record->update(array('smt' => 'faqcat_id = ?', 'vals' => array($faqcat_id)));
        else {
            $record->assignValues($data);
            $success = $record->addNew();
        }

        if ($success) {
            $this->faqcat_id = ($faqcat_id > 0) ? $faqcat_id : $record->getId();
            if ($faqcat_id > 0) {
                Message::addMessage('FAQ Catgeory updated successfully.');
            } else {
                Message::addMessage('FAQ Catgeory added successfully.');
            }
        } else {
            $this->error = $record->getError();
        }
        return $success;
    }

}
