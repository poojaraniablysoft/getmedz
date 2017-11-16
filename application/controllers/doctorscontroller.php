<?php 
class DoctorsController extends FrontController {

    public function before_filter() {

        parent::before_filter();
       
        $this->Doctor = new Doctor();
        
    }
	function detail($doctor_id) {
		if (intval($doctor_id < 1)) {
			Message::addErrorMessage('L_Invalid_Request');
            redirectUser(generateUrl('doctors','lists'));
            //redirectUser(generateUrl('home'));
        }
		 $srch = Doctor::getDoctores();
		
        $srch->addMultipleFields(array('*'));
        $srch->addCondition('doctor_id', '=', $doctor_id);
        $doctor_data = $srch->fetch();
		
		if(!empty($doctor_data))
		{
		$srch_relate = Doctor::getDoctores();
		
		$med_category = $doctor_data['doctor_med_category'];
		
		$srch_relate->addCondition('doctor_med_category', '=',$med_category);
		$srch_relate->addCondition('doctor_id', '!=',$doctor_id);
		$related_doctor_data = $srch_relate->fetch_all();
		}
		$this->set('doctor_data', $doctor_data);
		$this->set('related_doctor_data', $related_doctor_data);
		$this->_template->render();
    }
	
	function default_action()
	{
		$post = getQueryStringData();
		$this->set('searchForm', $this->searchForm());
		if(isset($post['category']) && ($post['category'] != '')){				
			$this->set('category_selected',$post['category']);			
		}
		else if(isset($post['category']) && ($post['category'] == '')){			
			$this->set('category_selected','');
		}
		else
		{
			$this->set('category_selected','');
		}
		
		
		$this->set('categories', Medicalcategory::getActiveCategories()->fetch_all());
		$this->_template->render();
	}
	function listing()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$page = Syspage::getPostedVar('page');
			$post = Syspage::getPostedVar();
			
			$doctores = Doctor::getDoctores();
			if(intval($post['doctor_med_category'])>0){  
				$doctores->addCondition('doctor_med_category','=',$post['doctor_med_category']);			
			}			
			
			if(isset($post['sort_order']) && $post['sort_order']!=''){  
				$doctores->addOrder('doctor_experience',$post['sort_order']);
				$this->set('sort_by',$post['sort_order']);							
			}
			if(!empty($post['keyword'])){  
				$cnd=$doctores->addCondition('doctor_first_name','like',$post['keyword']."%");
				$cnd->attachCondition('doctor_email','like',$post['keyword']."%");
			} 
			if(!empty($post['doctor_state_id'])){  
				$doctores->addCondition('doctor_state_id','=',$post['doctor_state_id']);
			}
			if(isset($post['doctor_gender']) && !empty($post['doctor_gender'])){  
				$doctores->addCondition('doctor_gender','=',$post['doctor_gender']);					
			}
			$doctores->addOrder('doctor_id','desc');
			
			$rs = $doctores->getResultSet();
			$total_records = $doctores->recordCount();
			$this->set('total_records',$total_records);
			$this->paginate($doctores, $page, generateUrl('doctors', 'listing'));
			$this->render();
		}
	}
	private function searchForm() {
		$post = getQueryStringData();
		$category = isset($post['category'])?$post['category']:'';
        $frm = new Form('searchForm','searchForm');
        $frm->setAction(generateUrl('doctors', 'listing'));
        $frm->setExtra("class='form'");
        /* $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='ftable_orm_vertical'"); */
        $frm->addTextBox('', 'keyword','','','placeholder = "Type a Doctor Name or Email" ');
		$frm->addSelectBox('Medical Category', 'doctor_med_category', Medicalcategory::getActiveCategories()->fetch_all_assoc(),$category); 
		$fld = $frm->addSelectBox('State', 'doctor_state_id', State::getStateCountryOpt());	
		$fld = $frm->addRadioButtons('Gender', 'doctor_gender', Applicationconstants::$arr_gender, '1', 2, 'class="lib_custom_radio"', 'class="custom_radio"');
        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Find a doctor', 'btn_submit', 'class = "button button--fill button--secondary" style="cursor:pointer;"');        
        $frm->setValidatorJsObjectName('searchValidator');
        $frm->setOnSubmit('return submitsearch(this, searchValidator);');
        return $frm;
    }
}
