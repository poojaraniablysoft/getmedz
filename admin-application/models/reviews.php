<?php

class Reviews extends Model {

    
    public $review_id;
    
    
    public function setupreview($data) {
        
        $review_id=intval($data['review_id']);
        unset($data['review_id']);
        $record = new TableRecord('tbl_doctor_reviews');
        $record->assignValues($data);
        if ($review_id > 0)
            $success = $record->update(array('smt' => 'review_id = ?', 'vals' => array($review_id)));
        else {
            $record->assignValues($data);
            $success = $record->addNew();
        }

        if ($success) {
            $this->review_id = ($review_id > 0) ? $review_id : $record->getId();
            if ($review_id > 0) {
                Message::addMessage('Review updated successfully.');
            } else {
                Message::addMessage('Review added successfully.');
            }
        } else {
            $this->error = $record->getError();
        }
        return $success;
    }

}
