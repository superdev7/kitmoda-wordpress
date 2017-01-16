<?php



class KSM_Email_TaxMessage extends KSM_Email {
    
    
    public $User,
           $name,
           $key;
    
           
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
        
        if($args['id']) {
            $this->Post = KSM_Purchased_Download::get($args['id']);
            
            if($this->Post) {
                $this->User = $this->Post->Author;
            }
            
        }
    }
    
    
    
    public function subject() {
        $subject = 'Tax Information Required';
        return $subject;
    }
    
    function prepare_data() {
        
        
        
        
        
        
        
        $data = array();
        
        
        
        
        return $data;
        
    }

}