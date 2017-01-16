<?php



class KSM_Email_MonthlySales extends KSM_Email {
    
    
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
        $subject = 'Model Return Confirmation';
        return $subject;
    }
    
    function prepare_data() {
        
        
        
        
        
        
        
        $data = array();
        
        
        
        
        
        $data['item_thumb'] = $this->Post->Download->the_thumb('purchase_lib_thumb');
        
        
        
        
        $data['item_category'] = $this->Post->Download->get_tax_label('category', false);
        $data['item_keywords'] = $this->Post->Download->get_tax_label('keyword', false);
        $data['item_era'] = $this->Post->Download->get_tax_label('era');
        $data['item_style'] = $this->Post->Download->get_tax_label('style');
        $data['item_culture'] = $this->Post->Download->get_tax_label('culture');
        
        $data['item_title'] = $this->Post->Download->post_title;
        
        
        return $data;
        
    }

}