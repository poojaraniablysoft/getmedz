<?php

class Medicalcategory extends Model {

    private $category_id;

    function __construct() {
        parent::__construct();
        $this->category_id = 0;
    }

    function setup($data) {
        $category_id = intval($data['category_id']);
        if (!($category_id > 0))
            $category_id = 0;
        if (isset($data['category_id']))
            unset($data['category_id']);

        $record = new TableRecord('tbl_medical_categories');
        $record->assignValues($data);

        if ($category_id > 0)
            $success = $record->update(array('smt' => 'category_id = ?', 'vals' => array($category_id)));
        else {

            $record->assignValues($data);

            $success = $record->addNew();
        }

        if ($success) {
            $this->category_id = ($category_id > 0) ? $category_id : $record->getId();
            if ($category_id > 0) {
                Message::addMessage('Medical Category updated successfully.');
            } else {
                Message::addMessage('Medical Category added successfully.');
            }
        } else {
            $this->error = $record->getError();
        }
		 //return $success;
        return $this->category_id;
    }

    function getData($category_id) {
        $category_id = intval($category_id);
        $record = new TableRecord('tbl_medical_categories');
        if (!$record->loadFromDb(array('smt' => 'category_id = ?', 'vals' => array($category_id)))) {
            $this->error = $record->getError();
            return false;
        }
        return $record->getFlds();
    }

    function deleteMedicalCategory($category_id) {

        $db = &Syspage::getdb();


        if (!$this->canMedicalcategoriesDelete()) {
            $this->error = "You need to delete all Medical before deleting this Medical category";
            return false;
        }
        $data = array();
        $data['category_id'] = $category_id;
        $data['category_deleted'] = 1;
        $record = new TableRecord('tbl_medical_categories');
        $record->assignValues($data);

        if ($category_id > 0)
            $success = $record->update(array('smt' => 'category_id = ?', 'vals' => array($category_id)));
        if ($success) {
            return true;
        } else
            return false;
    }

    function canMedicalcategoriesDelete() {

        return true;
    }

    static function search($criteria, $flds = array()) {

        $srch = new SearchBaseNew('tbl_medical_categories', 'faqcat');
        if (count($flds) > 0)
            $srch->addMultipleFields($flds);

        foreach ($criteria as $key => $val) {

            if (strval($val) == '')
                continue;

            switch ($key) {
                case 'category_id':
                    $srch->addCondition('category_id', '=', intval($val));
                    break;
                case 'category_name':
                    $srch->addCondition('category_name', 'LIKE', '%' . $val . '%');
                    break;
            }
        }

        return $srch;
    }
     static function getActiveCategories() {

        $srch = new SearchBaseNew('tbl_medical_categories', 'faqcat');
        $srch->addCondition('category_deleted', '=', '0	');
        $srch->addCondition('category_active', '=', '1');
        
        return $srch;
    }
	static function getCategoriesForQuestion() {

        $srch = new SearchBaseNew('tbl_medical_categories', 'faqcat');
		$srch->joinTable('tbl_doctors','INNER JOIN','doctor_med_category=category_id');
        $srch->addCondition('category_deleted', '=', '0	');
        $srch->addCondition('category_active', '=', '1');
        $srch->addGroupBy('category_id');
        
        return $srch;
    }
	function delete_category($category_id){
		
		if(is_numeric($category_id) && intval($category_id)>0){
			if($this->medicalCategory_model->deleteMedicalCategory($category_id)){
				Message::addMsg('Medical Category deleted successfully.');
			} else {
				Message::addErrorMessage($this->medicalCategory_model->getError());
			}
		} else {
			Message::addErrorMessage('Invalid Request');
		}
		redirectUser(generateUrl('medicalcategory'));
	}
}
