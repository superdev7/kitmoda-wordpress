<?php



class KSM_Email_ConfirmRegistration extends KSM_Email {
    
    
    public $User,
           $name;
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
        
        if($args['user_id']) {
            $this->User = new KSM_User($args['user_id']);
        }
    }
            
    
    public function subject() {
        return 'Confirm Email';
    }
    

    function prepare_data() {
        
        $key_data = $this->User->getConfirmKey(true, 'signup');
        
        
        $key = $key_data->user_key;
        
        $args_data = array(
            'action'=>'confirm', 
            'eckey'=> $key,
            'id' => base64_encode($this->User->ID)
            );
        
        $activation_url = esc_url(add_query_arg($args_data, ksm_get_permalink('login')));
        $activation_link = '<a href="'.$activation_url.'" target="_blank">'.$activation_url.'</a>';
        
        
        
        
        
        $data = array();
        
        $data['display_name'] = $this->User->display_name();
        $data['activation_link'] = $activation_link;
        
        
        
        
        
        return $data;
        
    }

}