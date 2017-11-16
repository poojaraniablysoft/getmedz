<?php

class DegreesController extends BackendController {

    public function before_filter() {
        parent::before_filter();
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Degrees Management", Utilities::generateUrl("degrees"));
    }

    public function default_action() {
        $this->set('searchForm', $this->searchForm());
        $this->set('addform', $this->getform());
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->render();
    }

    public function listing() {

        $page = Syspage::getPostedVar('page');
        $post = Syspage::getPostedVar();
        $degrees = Degree::getAllDegree();
        //Searching Critreia

        if (!empty($post['degree_name'])) {
            $degrees->addCondition('degree_name', 'like', $post['degree_name'] . "%");
        }


        $this->paginate($degrees, $page, generateUrl('degrees', 'listing'));
        $user_id = Admin::getLoggedinUserId();
        $this->set('canAdddegree', Permission::canAdddegree($user_id));
        $this->set('canEditdegree', Permission::canEditdegree($user_id));
        $this->set('canDeletedegree', Permission::canDeletedegree($user_id));
        $this->render();
    }

    private function searchForm() {
        $frm = new Form('searchForm', 'searchForm');
        $frm->setAction(generateUrl('degrees', 'listing'));
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addRequiredField('Degree Name', 'degree_name')->requirements()->setRequired();
        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Search', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'reset', 'Show All', '', 'class="cancel_search" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('searchValidator');
        $frm->setOnSubmit('return submitdegreesearch(this, searchValidator);');
        return $frm;
    }

    private function getform() {
        $frm = new Form('Frmdegrees');
        $frm->setAction(generateUrl('degrees', 'setup'));
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addHiddenField('', 'degree_id','','degree_id');
        $fld = $frm->addRequiredField('Degree Name', 'degree_name');
        $fld->requirements()->setRequired();
        $fld->setUnique('tbl_degrees', 'degree_name', 'degree_id', 'degree_id', 'degree_id');
        $frm->addSelectBox('Status', 'degree_active', Applicationconstants::$arr_status)->requirements()->setRequired();

        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Submit', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'cancel', 'Cancel', '', 'class="cancel_form reset_button" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('degreeValidator');
        $frm->setOnSubmit('submitdegreeSetup(this, degreeValidator);');
        return $frm;
    }

    public function form() {
        $user_id = Admin::getLoggedinUserId();
        $id = Syspage::getPostedVar('id');
        $frm = $this->getform();
        if (intval($id) > 0) {

            if (!Permission::canEditdegree($user_id, $id)) {
                $this->notAuthorized();
            }

            $srch = Degree::getAlldegree();
            $srch->addCondition('degree_id', "=", $id);
            $data = $srch->fetch();

            $frm->fill($data);

            if (!$data)
                dieWithError('Invalid Request');
        }else {
            if (!Permission::canAdddegree($user_id)) {
                $this->notAuthorized();
            }
        }

        $this->set('frm', $frm);
        $this->render();
    }

    public function setup() {
        $user_id = Admin::getLoggedinUserId();
        $post = Syspage::getPostedVar();

        if (intval($post['degree_id']) > 0) {
            if (!Permission::canEditDegree($user_id, $post['degree_id'])) {
                $this->notAuthorized();
            }
        } else {
            if (!Permission::canAddDegree($user_id)) {
                $this->notAuthorized();
            }
        }

        $frm = $this->getForm();
        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('degrees'));
        }

        if (!$this->Degrees->setupdegree($post)) {
            Message::addErrorMessage($this->Degrees->getError());
        }
        redirectUser(generateUrl('degrees'));
    }

    function delete_degree($degree_id) {
        $user_id = Admin::getLoggedinUserId();
        if (!Permission::canDeletedegree($user_id, $degree_id)) {
            $this->notAuthorized();
        }
        if (is_numeric($degree_id) && intval($degree_id) > 0) {
            $data = array('degree_id' => $degree_id, 'degree_deleted' => degree::DELETED_DEGREE);
            if ($this->Degrees->setupdegree($data)) {
                Message::getHtml();
                Message::addMsg('Degree  deleted successfully.');
            } else {
                Message::addErrorMessage($this->Degrees->getError());
            }
        } else {
            Message::addErrorMessage('Invalid Request');
        }
        redirectUser(generateUrl('degrees'));
    }

    function change_listing_status() {

        $user_id = Admin::getLoggedinUserId();
        if (!Permission::canChangeStatusofdegree($user_id, $degree_id)) {
            $this->notAuthorized();
        }

        $db = Syspage::getdb();
        $post = Syspage::getPostedVar();
        $degree_id = intval($post['degree_id']);
        $status = intval($post['mode']);
        if ($degree_id < 1) {
            Message::addErrorMessage('Invalid ID');
            dieJsonError(Message::getHtml());
        }

        /* Update Winner */
        if (!$db->update_from_array('tbl_degrees', array('degree_active' => $status), array('smt' => 'degree_id = ?', 'vals' => array($degree_id)), '', '', '', 1)) {
            Message::addErrorMessage($db->getError());
            dieJsonError(Message::getHtml());
        }


        Message::addMessage('degree status changed successfully.');
        dieJsonSuccess(Message::getHtml());
    }

}
