<?php

class Files extends Model {

    const DOCTOR_PROFILE=3;
    const USER_PROFILE=4;
    const QUESTION_ATTACHMENT=1;
    CONST QUESTION_POST_ATTACHMENT=0;
	CONST BANNER_TYPE=5;
	CONST MEDICAL_CATEGORY_TYPE=6;
	//CONST DOCTOR_IMAGE_TYPE=7;
    function __construct() {
        parent::__construct();
    }

    function attachFile($data) {
        global $db;
        $success = $db->insert_from_array('tbl_attached_files', $data);
        return false;
    }

    function getFiles($record_id, $file_type) {
        global $db;
        $record_id = intval($record_id);
        $srch = new SearchBase('tbl_files');
        $srch->addCondition('file_record_type', '=', $file_type);
        $srch->addCondition('file_record_id', '=', $record_id);
        $srch->addOrder('file_display_order', "asc");
        $rs = $srch->getResultSet();
        $record = $db->fetch_all($rs);
        return $record;
    }

    function getFile($record_id, $file_type) {
        global $db;
        $record_id = intval($record_id);
        $srch = new SearchBase('tbl_files');
        $srch->addCondition('file_record_type', '=', $file_type);
        $srch->addCondition('file_record_id', '=', $record_id);
        $rs = $srch->getResultSet();
        $record = $db->fetch($rs);
        return $record;
    }

    function getFirstImage($record_id, $file_type) {
        global $db;
        $record_id = intval($record_id);
        $srch = new SearchBase('tbl_files');
        $srch->addCondition('file_record_type', '=', $file_type);
        $srch->addCondition('file_record_id', '=', $record_id);
        $srch->addOrder('file_display_order', 'desc');
		
        $rs = $srch->getResultSet();
        $record = $db->fetch($rs);
        return $record;
    }

    function getLastImage($record_id, $file_type) {
        global $db;
        $record_id = intval($record_id);
        $srch = new SearchBase('tbl_files');
        $srch->addCondition('file_record_type', '=', $file_type);
        $srch->addCondition('file_record_id', '=', $record_id);
        $srch->addOrder('file_id', 'desc');
        $rs = $srch->getResultSet();
        $record = $db->fetch($rs);
        return $record;
    }

    function getLastImageId($record_id, $file_type) {
        global $db;
        $record_id = intval($record_id);
        $srch = new SearchBase('tbl_files');
        $srch->addCondition('file_record_type', '=', $file_type);
        $srch->addCondition('file_record_id', '=', $record_id);
        $srch->addOrder('file_id', 'desc');
        $rs = $srch->getResultSet();
        $record = $db->fetch($rs);
        return $record['file_id'];
    }

    function getFirstImageIdByOrder($record_id, $file_type) {
        global $db;
        $record_id = intval($record_id);
        $srch = new SearchBase('tbl_files');
        $srch->addCondition('file_record_type', '=', $file_type);
        $srch->addCondition('file_record_id', '=', $record_id);
        $srch->addOrder('file_display_order', 'asc');
        $rs = $srch->getResultSet();
        $record = $db->fetch($rs);
        return $record['file_id'];
    }

    function getLastImageIdByOrder($record_id, $file_type) {
        global $db;
        $record_id = intval($record_id);
        $srch = new SearchBase('tbl_files');
        $srch->addCondition('file_record_type', '=', $file_type);
        $srch->addCondition('file_record_id', '=', $record_id);
        $srch->addOrder('file_display_order', 'desc');
        $rs = $srch->getResultSet();
        $record = $db->fetch($rs);
        return $record['file_id'];
    }

    function getImage($file_id = 0) {
        global $db;
        $file_id = intval($file_id);
        $srch = new SearchBase('tbl_files');
        $srch->addCondition('file_id', '=', $file_id);
        $rs = $srch->getResultSet();
        $record = $db->fetch($rs);
        return $record;
    }

    function addFile($data) {
        global $db;

        $file_id = intval($data['file_id']);
        if (!($file_id > 0))
            $file_id = 0;


        if ($file_id > 0) {
		
            $success = $db->update_from_array('tbl_files', $data, array('smt' => 'file_id = ?', 'vals' => array($file_id)));
        } else {
			
            $success = $db->insert_from_array('tbl_files', $data);
            $file_id = $db->insert_id();
			
        }
        if ($success) {
            return $file_id;
        }
        return false;
    }

    function removeFile($file_id) {
        $file_id = intval($file_id);
        global $db;

        $filesArr = Files::getImage($file_id);
        $pth = CONF_INSTALLATION_PATH . 'user-uploads/' . $filesArr["file_path"];
        if (file_exists($pth)) {
            unlink($pth);
        }
        $success = $db->deleteRecords("tbl_files", array("smt" => "file_id=?", "vals" => array($file_id)));
        if ($success) {
            return true;
        }
        return false;
    }

    function removeFileByType($file_type_id, $file_type) {
        $file_type_id = intval($file_type_id);
        $file_type = intval($file_type);
        global $db;
        $filesArr = Files::getFiles($file_type_id, $file_type);
        if (count($filesArr) > 0) {
            foreach ($filesArr as $f) {
                $pth = CONF_INSTALLATION_PATH . 'user-uploads/' . $f['file_path'];
                if (file_exists($pth)) {
                    unlink($pth);
                }
            }
        }
        $success = $db->deleteRecords("tbl_files", array("smt" => "file_record_type=? and file_record_id=?", "vals" => array($file_type, $file_type_id)));
        if ($success) {
            return true;
        }
        return false;
    }

    static function create_zip($type, $files = array()) {
        if ($type && count($files) > 0) {
            $zip = new ZipArchive();
            $assignZip = $type . time() . ".zip";
            $path = CONF_INSTALLATION_PATH . 'user-uploads/';
            if (file_exists($path . $assignZip)) {
                unlink($path . $assignZip);
            }
            if ($zip->open($path . $assignZip, ZIPARCHIVE::CREATE) != TRUE) {
                die("Could not open archive");
            }
            $i = 0;
            
           
            foreach ($files as $file) {
                $ext = array_pop(explode(".", $file['file_display_name']));
                $base = str_replace("." . $ext, "", $file['file_display_name']);
                $finalName = $base . "_" . time() . "_" . $i++ . "." . $ext;
                $download_file = file_get_contents($path . $file['file_path']);
                $zip->addFromString(basename($finalName), $download_file);
            }
            $zip->close();
            $now = gmdate("D, d M Y H:i:s");
            header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
            header("Last-Modified: {$now} GMT");
            // force download  
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");
            // disposition / encoding on response body
            header("Content-Disposition: attachment;filename=$assignZip");
            header("Content-Transfer-Encoding: binary");
            echo file_get_contents(CONF_INSTALLATION_PATH . 'user-uploads/' . $assignZip);
            unlink($path . $assignZip);
            die;
        }

       

    }

    
    static function questionHaveAttachment($question_id,$file_type=Files::QUESTION_POST_ATTACHMENT){
         global $db;
        $record_id = intval($record_id);
        $srch = new SearchBase('tbl_files');
        $srch->addCondition('file_record_type', '=', $file_type);
        $srch->addCondition('file_record_id', '=', $question_id);
        $srch->addOrder('file_display_order', "asc");
        $rs = $srch->getResultSet();
      
        return $srch->recordCount();
        
        
    }
}

?>