<?php

class Countries extends Model {

    public $country_id;

    public function setupCountry($data) {

        $country_id = intval($data['country_id']);
        unset($data['country_id']);
        $record = new TableRecord('tbl_countries');
        $record->assignValues($data);
        if ($country_id > 0)
            $success = $record->update(array('smt' => 'country_id = ?', 'vals' => array($country_id)));
        else {
            $record->assignValues($data);
            $success = $record->addNew();
        }

        if ($success) {
            $this->country_id = ($country_id > 0) ? $country_id : $record->getId();
            if ($country_id > 0) {
                Message::addMessage('Country updated successfully.');
            } else {
                Message::addMessage('Country added successfully.');
            }
        } else {
            $this->error = $record->getError();
        }
        return $success;
    }

}
