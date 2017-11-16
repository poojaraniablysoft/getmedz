<?php

class Cron extends Model {

    const CLOSE_QUESTION_TIME_PERIOD = 7;
    const ACCEPT_QUESTION_TIME_PERIOD = 30;
    
    public function __construct() {
        parent::__construct();
        $this->close_questions();
        $this->unanwered_questions();
        
        $this->update_doc_activity();
    }
    
    public function close_questions() {

        global $db;
        $question = new Question();
        $replies = $question->getReplies();
        $replies->addDirectCondition("reply_id = (SELECT reply_id FROM tbl_question_replies WHERE reply_orquestion_id=oq.orquestion_id ORDER BY reply_id DESC LIMIT 1)");
        $replies->addCondition('orquestion_status', 'NOT IN ', array(Question::QUESTION_PENDING, Question::QUESTION_CLOSED, Question::QUESTION_ACCEPTED));
        $replies->addDirectCondition('reply_date < DATE_SUB(NOW(),INTERVAL '.self::CLOSE_QUESTION_TIME_PERIOD.' DAY )');
        $replies->addCondition('reply_by', '=', Question::QUESTION_REPLIED_BY_DOCTOR);
        $replies->addFld('orquestion_id');
   
        $expiredQuestions = $replies->fetch_all();
  
        if (count($expiredQuestions) > 0) {
            $questions = array_column($expiredQuestions, 'orquestion_id');


            $questions = implode(",", $questions);
             $status=Question::QUESTION_CLOSED;
            $query="UPDATE tbl_order_questions SET `orquestion_status` = $status WHERE orquestion_id IN ($questions)";
            $db->query($query);
            
            //Send Notification
           $close= new Email();
           $close->questionList=$expiredQuestions;
           $close->questionAutoCloseEmail();
        }
        
        
    }
    public function unanwered_questions() {

        global $db;
        $question = new Question();
        $replies = $question->searchQuestions();
        $replies->addCondition('orquestion_status', 'IN ', array( Question::QUESTION_ACCEPTED));
        $replies->addDirectCondition('orquestion_doctor_accepted_at < DATE_SUB(NOW(),INTERVAL '.self::ACCEPT_QUESTION_TIME_PERIOD.' MINUTE )');
        $replies->addFld('orquestion_id');
   
        $expiredQuestions = $replies->fetch_all();
     
        if (count($expiredQuestions) > 0) {
            $questions = array_column($expiredQuestions, 'orquestion_id');


            $questions = implode(",", $questions);
            $status=Question::QUESTION_PENDING;
            $query="UPDATE tbl_order_questions SET `orquestion_status` = $status  WHERE orquestion_id IN ($questions)";
            $db->query($query);
        }
    }
    
    
    public function update_doc_activity(){
        
        if(!Members::isDoctorLogged()){
            return false;
        }
        $doc_id=  Members::getLoggedUserID();

        $data=array('doctor_id'=>$doc_id,'doctor_last_activity'=>'mysql_func_NOW()');
        $record = new TableRecord('tbl_doctors');
        $record->assignValues($data,true,'','',true);
         $success = $record->update(array('smt' => 'doctor_id = ?', 'vals' => array($doc_id)));
        return true;        
                
    }
    
    
    
    
}
