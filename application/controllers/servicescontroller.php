<?php
class ServicesController extends FrontController {
	public $medicalCategory_model;

    function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);
        if (!is_object($this->medicalCategory_model))
            $this->medicalCategory_model = new MedicalCategory();
    }
    function default_action() {
		$question = new Question();
		$categories = MedicalCategory::search();        
        $categories->addCondition('category_deleted', '=', '0	');
        $categories->addOrder('category_id','DESC');
		$count_categories = count($categories->fetch_all());
		
        $question = $question->searchQuestions();
		$rs = $question->getResultSet();
		$question_count = $question->recordCount();
		
		$Question = new Question();
		$reply_count = $Question->getRepliesCount();
		$this->set('reply_count',$reply_count);
		$this->set('question_count',$question_count);
		$this->set('medical_service_count',$count_categories);
		$this->_template->render(); 
	}
	
	function listing($page = 0) {
        $page = Syspage::getPostedVar('page');
        $post=Syspage::getPostedVar();
        $categories = MedicalCategory::search();        
        $categories->addCondition('category_deleted', '=', '0	');
        $categories->addOrder('category_id','DESC');
        $this->paginate($categories, $page, generateUrl('services', 'listing'));
		$this->_template->render(false,false); 
    }
}