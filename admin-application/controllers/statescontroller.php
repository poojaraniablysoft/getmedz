<?php

class StatesController extends BackendController {

    public function before_filter() {
        parent::before_filter();
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Country Management", Utilities::generateUrl("countries"));
        $this->b_crumb->add("States Management", Utilities::generateUrl("states"));
    }

    public function default_action() {
        $this->set('searchForm', $this->searchForm());
		$this->set('addform', $this->getform());
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->render();
    }

    public function listing() {

        $page = Syspage::getPostedVar('page');
        $states = State::getAllStates();
                $post=Syspage::getPostedVar();
        if(!empty($post['keyword'])){  
            $cnd=$states->addCondition('state_name','like',$post['keyword']."%");

        } 
        $this->paginate($states, $page, generateUrl('states', 'listing'));
        $user_id = Admin::getLoggedinUserId();
        $this->set('canAddStates', Permission::canAddStates($user_id));
        $this->set('canEditStates', Permission::canEditStates($user_id));
        $this->set('canDeleteStates', Permission::canDeleteStates($user_id));
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
    private function getform() {
        $frm = new Form('FrmStates');
        $frm->setAction(generateUrl('states', 'setup'));
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addHiddenField('', 'state_id');
        $frm->addRequiredField('State Name', 'state_name')->requirements()->setRequired();
        $frm->addSelectBox('Country', 'state_country_id', Country::getactiveCountries()->fetch_all_assoc(),'','','')->requirements()->setRequired();
        
        $frm->addSelectBox('Status', 'state_active', Applicationconstants::$arr_status,'','','')->requirements()->setRequired();

        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Submit', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'cancel', 'Cancel', '', 'class="cancel_form reset_button" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('StatesValidator');
        $frm->setOnSubmit('submitStatesSetup(this, StatesValidator);');
        return $frm;
    }

    public function form() {
        $user_id = Admin::getLoggedinUserId();
        $id = Syspage::getPostedVar('id');
        $frm = $this->getform();
        if (intval($id) > 0) {

            if (!Permission::canEditStates($user_id, $id)) {
                $this->notAuthorized();
            }

            $srch = State::getAllStates();
            $srch->addCondition('state_id', "=", $id);
            $data = $srch->fetch();

            $frm->fill($data);

            if (!$data)
                dieWithError('Invalid Request');
        }else {
            if (!Permission::canAddStates($user_id)) {
                $this->notAuthorized();
            }
        }

        $this->set('frm', $frm);
        $this->render();
    }

    public function setup() {
        $user_id = Admin::getLoggedinUserId();
        $post = Syspage::getPostedVar();

        if (intval($post['state_id']) > 0) {
            if (!Permission::canEditStates($user_id, $post['state_id'])) {
                $this->notAuthorized();
            }
        } else {
            if (!Permission::canAddStates($user_id)) {
                $this->notAuthorized();
            }
        }
        
        $frm = $this->getForm();
        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('states'));
        }
        if (!$this->States->setupStates($post)) {
            Message::addErrorMessage($this->States->getError());
        }
        redirectUser(generateUrl('states'));
    }

    function delete_state($state_id) {
        $user_id = Admin::getLoggedinUserId();
        if (!Permission::canDeleteStates($user_id, $state_id)) {
            $this->notAuthorized();
        }
        if (is_numeric($state_id) && intval($state_id) > 0) {
            $data = array('state_id' => $state_id, 'state_deleted' => State::DELETED_STATE);
            if ($this->States->setupStates($data)) {
                Message::getHtml();
                Message::addMsg('State deleted successfully.');
            } else {
                Message::addErrorMessage($this->States->getError());
            }
        } else {
            Message::addErrorMessage('Invalid Request');
        }
        redirectUser(generateUrl('states'));
    }

    function change_listing_status() {



        $db = Syspage::getdb();
        $post = Syspage::getPostedVar();
        $state_id = intval($post['state_id']);
        $status = intval($post['mode']);

        $user_id = Admin::getLoggedinUserId();
        if (!Permission::canChangeStatusofStates($user_id, $state_id)) {
            $this->notAuthorized();
        }
        if ($state_id < 1) {
            Message::addErrorMessage('Invalid ID');
            dieJsonError(Message::getHtml());
        }

        /* Update Winner */
        if (!$db->update_from_array('tbl_states', array('state_active' => $status), array('smt' => 'state_id = ?', 'vals' => array($state_id)), '', '', '', 1)) {
            Message::addErrorMessage($db->getError());
            dieJsonError(Message::getHtml());
        }


        Message::addMessage('State status changed successfully.');
        dieJsonSuccess(Message::getHtml());
    }

}
