<?php

class Cmspages extends Model {

    public $cms_id;

    public function setupCmspage($data) {

        $cms_id = intval($data['cmsc_id']);
        unset($data['cmsc_id']);
        $record = new TableRecord('tbl_cms_contents');
        $record->assignValues($data);
        if ($cms_id > 0)
            $success = $record->update(array('smt' => '	cmsc_id = ?', 'vals' => array($cms_id)));
        else {
            $record->assignValues($data);
            $success = $record->addNew();
        }

        if ($success) {
            $this->cms_id = ($cms_id > 0) ? $cms_id : $record->getId();
            if ($cms_id > 0) {
                Message::addMessage('Cms Page updated successfully.');
            } else {
                Message::addMessage('Cms Page added successfully.');
            }
        } else {
            $this->error = $record->getError();
        }
        return $success;
    }

}
