<?php

class Emailtemplates extends Model {

    private $tpl_id;

    function __construct() {
        parent::__construct();
        $this->tpl_id = 0;
    }

    function setup($data) {
        $tpl_id = intval($data['tpl_id']);
        if (!($tpl_id > 0))
            $tpl_id = 0;

        if (isset($data['tpl_id']))
            unset($data['tpl_id']);

        $record = new TableRecord('tbl_email_templates');
        $record->assignValues($data);


        if ($tpl_id > 0)
            $success = $record->update(array('smt' => 'tpl_id = ?', 'vals' => array($tpl_id)));
        else {
            /* $data['material_isactive']=1;
              $record->assignValues($data);
              $success = $record->addNew(); */
        }

        if ($success) {
            $this->tpl_id = ($tpl_id > 0) ? $tpl_id : $record->getId();

            if ($tpl_id > 0) {
                Message::addMessage('Template edited successfully.');
            } else {
                Message::addMessage('Template added successfully.');
            }
        } else {
            $this->error = $record->getError();
        }

        return $success;
    }

    public function searchTemplates() {
        $srch = new SearchBaseNew('tbl_email_templates', 'oq');

        return $srch;
    }

    public function getTemplateById($template_code = 0) {
        $srch = $this->searchTemplates();
        $srch->addCondition('tpl_code', '=', $template_code);
        return $srch;
    }

    public function getFormData($tpl_id) {
        $tpl_id = intval($tpl_id);
        $record = new TableRecord('tbl_email_templates');
        if (!$record->loadFromDb(array('smt' => 'tpl_id = ?', 'vals' => array($tpl_id)))) {
            $this->error = $record->getError();
            return false;
        }
        return $record->getFlds();
    }

    /* static function getMaterials($slug=false,$select_box=false){
      global $db;
      $material = new SearchBase('tbl_materials');
      $material->addCondition('material_isactive', '=', 1);
      $material->addOrder('material_name');

      if($select_box){
      $rs = $material->getResultSet();
      return $db->fetch_all_assoc($rs);

      }

      if($slug){
      $material->addCondition('material_id', '=', $slug);
      $rs = $material->getResultSet();
      return $db->fetch($rs);
      }

      $rs = $material->getResultSet();
      return $db->fetch_all($rs);
      } */
}
