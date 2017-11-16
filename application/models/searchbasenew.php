<?php

    class SearchBaseNew extends SearchBase{
        
        protected $db;
        
       
        public function __construct($table_name,$alias) {
            parent::__construct($table_name,$alias);     
            $this->db=  Syspage::getDb();
        }
        
        public function fetch_all_assoc(){
            return $this->db->fetch_all_assoc($this->getResultSet());
        }
        public function fetch_all(){
            return $this->db->fetch_all($this->getResultSet());
        }      

           public function fetch(){
            return $this->db->fetch($this->getResultSet());
        }   
        
        
    }
