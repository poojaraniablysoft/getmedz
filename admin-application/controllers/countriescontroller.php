<?php

class CountriesController extends BackendController {

    public function before_filter() {
        parent::before_filter();
		$this->b_crumb = new Breadcrumb();		
        $this->b_crumb->add("Country Management", Utilities::generateUrl("countries"));
    }

    public function default_action() {
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->render();
    }

    public function listing() {

        $page = Syspage::getPostedVar('page');
        $countries = Country::getactiveCountries();
        $this->paginate($countries, $page,  generateUrl('countries','listing'));
		
        $this->render();
    }

    function getform() {
        $frm = new Form('FrmCountries');
        $frm->setAction(generateUrl('countries', 'setup'));
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addHiddenField('', 'country_id');
        $frm->addRequiredField('Country Name', 'country_name')->requirements()->setRequired();
        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Submit', 'btn_submit', 'style="cursor:pointer;"');
        $fld2 = $frm->addButton('', 'cancel', 'Cancel', '', 'class="cancel_form reset_button" style="margin-left:10px; cursor:pointer;"');
        $fld1->attachField($fld2);
        $frm->setValidatorJsObjectName('countriesValidator');
        $frm->setOnSubmit('submitSetup(this, countriesValidator);');
        return $frm;
    }

    public function form() {
        $id = Syspage::getPostedVar('id');
        $frm = $this->getform();

        if (intval($id) > 0) {
            $srch = Country::getactiveCountries();
            $srch->addCondition('country_id', "=", $id);
            $data = $srch->fetch();

            $frm->fill($data);

            if (!$data)
                dieWithError('Invalid Request');
        }

        $this->set('frm', $frm);
        $this->render();
    }

    public function setup() {

        $post = Syspage::getPostedVar();

        $frm = $this->getForm();
        if (!$frm->validate($post)) {
            Message::addErrorMessage($frm->getValidationErrors());
            redirectUser(generateUrl('countries'));
        }
        if (!$this->Countries->setupCountry($post)) {
            Message::addErrorMessage($this->Countries->getError());
        }
        redirectUser(generateUrl('countries'));
    }




}
