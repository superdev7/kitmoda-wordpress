<?php



class KSM_Email_ForgotPassword extends KSM_Email {
    
    
    public $User,
           $name,
           $key;
    
           
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
        
        if($args['user_id']) {
            $this->User = new KSM_User($args['user_id']);
        }
    }
            
    
    public function subject() {
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        $subject = sprintf( __('[%s] Password Reset'), $blogname );
        return $subject;
    }
    
    

    function prepare_data() {
        
        $user_login = $this->User->user_login;
        $key = $this->key;
        
        
        $query_args = array('key'=> $key, 'login' => rawurlencode($user_login));
        $reset_url = esc_url(add_query_arg($query_args, ksm_get_permalink('reset_password')));
        $reset_link = '<a href="'.$reset_url.'" target="_blank">'.$reset_url.'</a>';
        
        
        
        
        
        
        
        
        $data = array();
        
        
        $data['reset_link'] = $reset_link;
        $data['reset_url'] = $reset_url;
        $data['user_login'] = $user_login;
        
        return $data;
        
    }

}