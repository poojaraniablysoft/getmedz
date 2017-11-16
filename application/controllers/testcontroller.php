<?php

class TestController extends Controller{
    
    
    
    public function test(){
        
       $Email= new Emails();
       $Email->questionList=array(2,1);
        $Email->questionAcceptByDocEmail();
        exit();
    }
    
    
    
    
}

