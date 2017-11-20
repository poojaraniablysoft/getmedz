<?php class questionhelper extends FrontController{
	
	static function getQuestionStatusDateText($questionStatus = 0){
		
		switch($questionStatus){
			case Question::QUESTION_ASSIGNED :
			case Question::QUESTION_ACCEPTED:
			case Question::QUESTION_REJECTED:
			case Question::QUESTION_ESCLATED_TO_ADMIN:
				return Utilities::getLabel('LBL_Asked_On');
			case Question::QUESTION_REPLIED_BY_DOCTOR:
				return Utilities::getLabel('LBL_Answered_on');
			case Question::QUESTION_REPLIED_BY_PATIENT:
				return Utilities::getLabel('LBL_Followedup_on');
			case Question::QUESTION_CLOSED:
				return Utilities::getLabel('LBL_Closed_on');
		}
		
	}
	static function getQuestionStatusDate($question){
		
		switch($question['orquestion_status']){
			case Question::QUESTION_ASSIGNED :
			case Question::QUESTION_ACCEPTED:
			case Question::QUESTION_REJECTED:			
				return date("D, dS M Y h:i T", strtotime($question['orquestion_asked_on']));
			case Question::QUESTION_REPLIED_BY_DOCTOR:
			case Question::QUESTION_REPLIED_BY_PATIENT:
				return date("D, dS M Y h:i T", strtotime($question['reply_date']));
			case Question::QUESTION_CLOSED:
			case Question::QUESTION_ESCLATED_TO_ADMIN:
				return date("D, dS M Y h:i T", strtotime($question['orquestion_last_updated']));
				
		}
		
	}
	static function getQuestionStatusDateTextForCustomer($questionStatus = 0){
		
		switch($questionStatus){
			case Question::QUESTION_ASSIGNED :
			case Question::QUESTION_ACCEPTED:
			case Question::QUESTION_REJECTED:
			case Question::QUESTION_ESCLATED_TO_ADMIN:
			case Question::QUESTION_REPLIED_BY_DOCTOR:
			case Question::QUESTION_REPLIED_BY_PATIENT:
				return Utilities::getLabel('LBL_Asked_On');
				
			case Question::QUESTION_CLOSED:
				return Utilities::getLabel('LBL_Closed_on');
		}
		
	}
	static function getQuestionStatusDateForCustomer($question){
	
		switch($question['orquestion_status']){
			case Question::QUESTION_ASSIGNED :
			case Question::QUESTION_ACCEPTED:
			case Question::QUESTION_REJECTED:			
			case Question::QUESTION_REPLIED_BY_DOCTOR:
			
				return date("D, dS M Y h:i T", strtotime($question['orquestion_asked_on']));
			case Question::QUESTION_REPLIED_BY_PATIENT:		
				return date("D, dS M Y h:i T", strtotime($question['orquestion_asked_on']));
			case Question::QUESTION_ESCLATED_TO_ADMIN:
			case Question::QUESTION_CLOSED:
				return date("D, dS M Y h:i T", ($question['orquestion_asked_on'])? strtotime($question['orquestion_asked_on']):strtotime($question['orquestion_last_updated']));
				
		}
		
	}
	
}