<?php

class MedicalcategoryController extends BackendController {

    public $medicalCategory_model;

    function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);
        if (!is_object($this->medicalCategory_model))
            $this->medicalCategory_model = new MedicalCategory();
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Medical Categories Management", Utilities::generateUrl("medicalcategory"));
    }

    function default_action() {
        $this->set('searchForm', $this->searchForm());
        $this->set('addform', $this->getform());
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->_template->render();
    }

    function listing($page = 0) {
        $page = Syspage::getPostedVar('page');
        $post=Syspage::getPostedVar();
        $categories = MedicalCategory::search();
         if(!empty($post['keyword'])){  
          $categories->addCondition('category_name','like',$post['keyword']."%");
         
        } 
        $categories->addCondition('category_deleted', '=', '0	');
        $categories->addOrder('category_id','DESC');
        $this->paginate($categories, $page, generateUrl('medicalcategory', 'listing'));

        $user_id = Admin::getLoggedinUserId();
        $this->set('canAdd', Permission::canAddMedicalCategory($user_id));
        $this->set('canEdit', Permission::canEditMedicalCategory($user_id));
        $this->set('canDelete', Permission::canDeleteMedicalCategory($user_id));

        $this->render();
    }
    private function searchForm() {
        $frm = new Form('searchForm','searchForm');
        $frm->setAction(generateUrl('doctors', 'listing'));
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addTextBox('Keywords', 'keyword');
        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Search', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'reset', 'Show All', '', 'class="cancel_search" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('searchValidator');
        $frm->setOnSubmit('return submitsearch(this, searchValidator);');
        return $frm;
    }
    function form() {
        global $post;

        if (!is_numeric($post['id']))
            $post['id'] = 0;
        if ($post['id'] < 0)
            $post['id'] = 0;
        $category_id = $post['id'];

        $category_id = intval($category_id);

        $frm = $this->getForm($category_id);
        if ($category_id > 0) {
            $data = $this->medicalCategory_model->getData($category_id);

            $frm->fill($data);
            if (!$data)
                dieWithError('Invalid Request');
        }

        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    function setup() {
        global $msg;
        $user_id = Admin::getLoggedinUserId();
        $post = Syspage::getPostedVar();
		$category_id = $post['category_id'];
        if (intval($post['category_id']) > 0) {
            if (!Permission::canEditMedicalCategory($user_id, $post['category_id'])) {
                $this->notAuthorized();
            }
        } else {
            if (!Permission::canAddMedicalCategory($user_id, $post['category_id'])) {
                $this->notAuthorized();
            }
        }
        $frm = $this->getForm();
        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('medicalcategory'));
        }

        $data = $post;
		$image_uploading = false;
		$saved_image_name = '';
		if (isUploadedFileValidImage($_FILES['med_cat_file'])){
			
			$image_uploading = true;
			
				if(!saveImage($_FILES['med_cat_file']['tmp_name'],$_FILES['med_cat_file']['name'], $saved_image_name, 'medical_category/')){
					Message::addError($saved_image_name);
				}
				$data["category_image_path"]=$saved_image_name;
			
		}

        if (!$category_id = $this->medicalCategory_model->setup($data)) {
            Message::addErrorMessage($this->medicalCategory_model > getError());
        } else {
			if($image_uploading)
								{
									$fls = new Files();
									//Check if previous file

									$record = $fls->getFile($category_id, Files::MEDICAL_CATEGORY_TYPE);
									
									if (intval($record['file_id']) > 0) {
										$dat['file_id'] = $record['file_id'];
										$filepath = $record['file_path'];
									}

									$dat['file_record_type'] = Files::MEDICAL_CATEGORY_TYPE;
									$dat['file_record_id'] = $category_id ;
									$dat['file_path'] = 'medical_category/'.$saved_image_name;
									$dat['file_display_name'] = $_FILES['med_cat_file']['name'];
									$dat['file_display_order'] = 0;
									$file_id = $fls->addFile($dat);
								}
            
        }

        redirectUser(generateUrl('medicalcategory'));
    }

    function getForm($category_id=0) {
        $frm = new Form('FrmMedicalCategory');
        $frm->setAction(generateUrl('medicalcategory', 'setup'));
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addHiddenField('', 'category_id', $category_id);
        $frm->addRequiredField('Medical Category Name', 'category_name')->requirements()->setRequired();
        $frm->addTextArea('Medical Category Description', 'category_description','','category_description')->requirements()->setRequired();;
        $frm->addSelectBox('Status', 'category_active', Applicationconstants::$arr_status, '', '', '', 'category_active');
        $frm->addHiddenField('', 'page', 1);
		$fld = $frm->addFileUpload('Medical Category Image', 'med_cat_file');
        $fld->html_before_field = '<div id="med_cat_image" ><div class="filefield"><span class="filename"></span>';
        $fld->html_after_field = '<label class="filelabel">Browse File</label></div><p><b>Current Image:</b><br /><img src="'.generateUrl('image', 'medical_category', array($category_id, 139, 113),CONF_WEBROOT_URL).'" /></p></div> ';
        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Submit', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'cancel', 'Cancel', '', 'class="cancel_form reset_button" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('MedicalCategoryValidator');
        $frm->setOnSubmit('submitMedicalCategorySetup(this, MedicalCategoryValidator);');

        return $frm;
    }

    function delete_MedicalCategory($category_id) {
        $user_id = Admin::getLoggedinUserId();
        if (!Permission::canDeleteMedicalCategory($user_id, $category_id)) {
            $this->notAuthorized();
        }
        if (is_numeric($category_id) && intval($category_id) > 0) {
            if ($this->medicalCategory_model->deleteMedicalCategory($category_id)) {
                Message::addMsg('Medical Category deleted successfully.');
            } else {
                Message::addErrorMessage($this->medicalCategory_model->getError());
            }
        } else {
            Message::addErrorMessage('Invalid Request');
        }
        redirectUser(generateUrl('medicalcategory'));
    }

    function change_listing_status($category_id, $status = 0) {

        global $db;
        global $post;
        global $msg;



        $category_id = intval($post['category_id']);
        $status = intval($post['mode']);
        $user_id = Admin::getLoggedinUserId();
        if (!Permission::canChangeStatusofMedicalCategory($user_id, $category_id)) {
            $this->notAuthorized();
        }


        if ($category_id < 1) {
            Message::addErrorMessage('Invalid ID');
            dieJsonError(Message::getHtml());
        }

        /* Update Winner */
        if (!$db->update_from_array('tbl_medical_categories', array('category_active' => $status), array('smt' => 'category_id = ?', 'vals' => array($category_id)), '', '', '', 1)) {
            Message::addErrorMessage($db->getError());
            dieJsonError(Message::getHtml());
        }


        Message::addMessage('Medical Categories status changed successfully.');
        dieJsonSuccess(Message::getHtml());
    }

}
