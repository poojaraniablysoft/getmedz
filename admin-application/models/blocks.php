<?php

class Blocks extends Model {

    public $block_id;

    public function setupBlocks($data) {

        $block_id = intval($data['block_id']);
        unset($data['block_id']);
        $record = new TableRecord('tbl_content_blocks');
        $record->assignValues($data);
        if ($block_id > 0)
            $success = $record->update(array('smt' => ' block_id = ?', 'vals' => array($block_id)));
        else {
         //   $record->assignValues($data);
        //    $success = $record->addNew();
        }

        if ($success) {
            $this->block_id = ($block_id > 0) ? $block_id : $record->getId();
            if ($block_id > 0) {
                Message::addMessage('Block updated successfully.');
            } else {
                Message::addMessage('Block added successfully.');
            }
        } else {
            $this->error = $record->getError();
        }
        return $success;
    }

}
