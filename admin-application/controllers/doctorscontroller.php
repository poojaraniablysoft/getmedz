<?php

class DoctorsController extends BackendController {

    public function before_filter() {
        parent::before_filter();
        $this->Doctor = new Doctor();
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Doctors Management", Utilities::generateUrl("doctors"));
    }

    public function default_action() {
        $this->set('searchForm', $this->searchForm());
        $this->set('addform', $this->getform());
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->render();
    }

    public function listing() {

        $page = Syspage::getPostedVar('page');
      
        $doctores = Doctor::getDoctores();
           //Searching Critreia
        $doctores->addMultipleFields(array('*','CONCAT_WS(" ",doctor_first_name,doctor_last_name) as name'));
        $post=Syspage::getPostedVar();
        if(!empty($post['keyword'])){  
            $cnd=$doctores->addCondition('doctor_first_name','like',$post['keyword']."%");
            $cnd->attachCondition('doctor_email','like',$post['keyword']."%");
        } 
       if(intval($post['doctor_med_category'])>0){  
            $doctores->addCondition('doctor_med_category','=',$post['doctor_med_category']);
        }   
        $doctores->addOrder('doctor_id','desc');
        $this->paginate($doctores, $page, generateUrl('doctors', 'listing'));
        $user_id = Admin::getLoggedinUserId();
        $this->set('canAdd', Permission::canAddDoctor($user_id));
        $this->set('canEdit', Permission::canEditDoctor($user_id));
        $this->set('canDelete', Permission::canDeleteDoctor($user_id));
		
        $this->render();
    }
    private function searchForm() {
        $frm = new Form('searchForm','searchForm');
        $frm->setAction(generateUrl('doctors', 'listing'));
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addTextBox('Keywords', 'keyword');
        $frm->addSelectBox('Medical Category', 'doctor_med_category', Medicalcategory::getActiveCategories()->fetch_all_assoc());
        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Search', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'reset', 'Show All', '', 'class="cancel_search" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('searchValidator');
        $frm->setOnSubmit('return submitsearch(this, searchValidator);');
        return $frm;
    }
    private function getform() {
        $frm = new Form('FrmStates');
        $frm->setAction(generateUrl('doctors', 'setup'));
        $frm->setExtra("class='table_form' autocomplete='off'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setFieldsPerRow(2);
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addHiddenField('', 'doctor_id','','doctor_id');
        $frm->addRequiredField('First Name', 'doctor_first_name')->requirements()->setRequired();
        $frm->addRequiredField('Last Name', 'doctor_last_name')->requirements()->setRequired();

        $fld = $frm->addEmailField('Email', 'doctor_email','','doctor_email');
        $fld->setUnique('tbl_doctors','doctor_email','doctor_id','doctor_id','doctor_id');
		$fld1 = $frm->addRadioButtons('Gender', 'doctor_gender', Applicationconstants::$arr_gender, '', 2, 'class="lib_custom_radio"', 'class="custom_radio"');
		//$fld1->requirements()->setRequired();
		$frm->addFloatField('Experience In Year', 'doctor_experience')->requirements()->setRequired();
		$frm->addTextArea('Experience Summary ','doctor_experience_summary')->requirements()->setRequired();
        $frm->addRequiredField('Medical or Graduate School', 'doctor_med_school')->requirements()->setRequired();
        $frm->addSelectBox('Medical Category', 'doctor_med_category', Medicalcategory::getActiveCategories()->fetch_all_assoc())->requirements()->setRequired();

        $frm->addTextArea('Doctor Summary Of Qualification','doctor_summary')->requirements()->setRequired();
        $frm->addSelectBox('Medical degree', 'doctor_med_degree', degree::getactivedegree()->fetch_all_assoc())->requirements()->setRequired();

        $frm->addSelectBox('Medical Year', 'doctor_med_year', getYearList())->requirements()->setRequired();

        $frm->addRequiredField('License No', 'doctor_licence_no')->requirements()->setRequired();
        $fld = $frm->addSelectBox('Medical State', 'doctor_med_state_id', State::getStateCountryOpt())->requirements()->setRequired();
        $frm->addSelectBox('Status', 'doctor_active', Applicationconstants::$arr_status)->requirements()->setRequired();

        
        $frm->addRequiredField('Address', 'doctor_address')->requirements()->setRequired();
        $frm->addRequiredField('City', 'doctor_city')->requirements()->setRequired();
         
        $fld = $frm->addSelectBox('State', 'doctor_state_id', State::getStateCountryOpt())->requirements()->setRequired();
        $frm->addIntegerField('House No#', 'doctor_house_no')->requirements()->setRequired();
        $frm->addIntegerField('Pincode', 'doctor_pincode')->requirements()->setRequired();
       
        $fld = $frm->addPasswordField('Password', 'doctor_password','');
        $fld->requirements()->setRequired();
        $fld->requirements()->setLength(8, 50);
		$frm->addIntegerField('Phone No', 'doctor_phone_no')->requirements()->setRequired();
        $fld1 = $frm->addPasswordField('Confirm New Password', 'doctor_password1','');

        $fld1->requirements()->setCompareWith('doctor_password');
        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Submit', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'cancel', 'Cancel', '', 'class="cancel_form reset_button" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        //$fld1->merge_cells=2;
        $frm->setValidatorJsObjectName('DoctorValidator');
        $frm->setOnSubmit('submitSetup(this, DoctorValidator);');
        return $frm;
    }

    public function form() {
        $user_id = Admin::getLoggedinUserId();
        $id = Syspage::getPostedVar('id');
		
        $frm = $this->getform();
        if (intval($id) > 0) {

            if (!Permission::canEditDoctor($user_id, $id)) {
                $this->notAuthorized();
            }
			$frm->getField('doctor_password')->requirements()->setRequired(false);
            $srch = Doctor::getDoctores();
            $srch->addCondition('doctor_id', "=", $id);
            $data = $srch->fetch();
            $data['doctor_password'] = "";
            $frm->fill($data);

            if (!$data)
                dieWithError('Invalid Request');
        }else {
            if (!Permission::canAddDoctor($user_id)) {
                $this->notAuthorized();
            }
        }
        $this->set('frm', $frm);
		$this->set('id', $id);
        $this->render();
    }

    public function setup() {
        $user_id = Admin::getLoggedinUserId();
        $post = Syspage::getPostedVar();



		   $frm = $this->getForm();
        if (intval($post['doctor_id']) > 0) {
			if(empty($post['doctor_password'])){
			$frm->getField('doctor_password')->requirements()->setRequired(false);
			}
            if (!Permission::canEditDoctor($user_id, $post['doctor_id'])) {
                $this->notAuthorized();
            }
        } else {
			$frm->getField('doctor_password')->requirements()->setRequired(false);
            if (!Permission::canAddDoctor($user_id)) {
                $this->notAuthorized();
            }
			
			
			
        }


		
     
        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('doctors'));
        }

        /* if ($post['doctor_password'] == "DUMMY") {
            unset($post['doctor_password']);
        } */



        if (!$this->Doctor->setupDoctor($post)) {
            Message::addErrorMessage($this->Doctor->getError());
        }  if (intval($post['doctor_id']) > 0) { Message::addMessage("Doctor is updated successfully.");
		}
        redirectUser(generateUrl('doctors'));
    }

    function delete_doctor($doctor_id) {
        $user_id = Admin::getLoggedinUserId();
        if (!Permission::canDeleteDoctor($user_id, $doctor_id)) {
            $this->notAuthorized();
        }
        if (is_numeric($doctor_id) && intval($doctor_id) > 0) {
            $data = array('doctor_id' => $doctor_id, 'doctor_deleted' => Doctor::DELETED_DOCTOR);


            if ($this->Doctor->setupDoctor($data)) {
                Message::getHtml();
                Message::addMsg('Doctor deleted successfully.');
            } else {
                Message::addErrorMessage($this->States->getError());
            }
        } else {
            Message::addErrorMessage('Invalid Request');
        }
        redirectUser(generateUrl('doctors'));
    }

    function change_listing_status() {

        $user_id = Admin::getLoggedinUserId();


        $db = Syspage::getdb();
        $post = Syspage::getPostedVar();
        $doctor_id = intval($post['doctor_id']);
        $status = intval($post['mode']);

        if (!Permission::canChangeStatusofDoctor($user_id, $doctor_id)) {
            $this->notAuthorized();
        }

        if ($doctor_id < 1) {
            Message::addErrorMessage('Invalid ID');
            dieJsonError(Message::getHtml());
        }

        /* Update Winner */
        if (!$db->update_from_array('tbl_doctors', array('doctor_active' => $status), array('smt' => 'doctor_id = ?', 'vals' => array($doctor_id)), '', '', '', 1)) {
            Message::addErrorMessage($db->getError());
            dieJsonError(Message::getHtml());
        }

        dieJsonSuccess('Doctors status updated successfully.');
    }
	
	/*     * ***********Upload profile image******** */

    function profile_pic($doctor_id) {
        
        $srch = Doctor::getDoctores();
        $srch->addCondition('doctor_id', "=", $doctor_id);
        $doctor_data = $srch->fetch();

        if (intval($doctor_data['doctor_id']) < 1) {
            die("Invalid Request");
        }


        $response = "";

        if ($_FILES['fileupload']['name'] != "" && $_FILES['fileupload']['error'] == 0) {
            $isUpload = uploadContributionFile($_FILES['fileupload']['tmp_name'], $_FILES['fileupload']['name'], $response, "doc_profile/");

            if ($isUpload) {
                $fls = new Files();

                //Check if previous file

                $record = $fls->getFile($doctor_id, Files::DOCTOR_PROFILE);
                if (intval($record['file_id']) > 0) {
                    $dat['file_id'] = $record['file_id'];
                    $filepath = $record['file_path'];
                }

                $dat['file_record_type'] = Files::DOCTOR_PROFILE;
                $dat['file_record_id'] = $doctor_id;
                $dat['file_path'] = $response;
                $dat['file_display_name'] = $_FILES['fileupload']['name'];
                $dat['file_display_order'] = 0;
				
                $file_id = $fls->addFile($dat);

                Message::addMessage("Profile picture is successfully changed");
                $removeFilePath = CONF_INSTALLATION_PATH . 'user-uploads/' . $filepath;
                unlink($removeFilePath);
				dieJsonSuccess(Message::getHtml());
            } else {
				 Message::addErrorMessage($response);
				dieJsonError(Message::getHtml());
               
            }
        } else {
            Message::addErrorMessage("Error While changing the profile picture.");
			//Message::addErrorMessage($this->Banners->getError());
			dieJsonError(Message::getHtml());
        }

        //redirectUser(generateUrl('doctors'));
    }
	
	

}
