<?php



class KSM_Notification_Following extends KSM_Notification {
    
    public $id,
           $post 
            ;
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
        if($this->id) {
            $this->post = KSM_CollaborationRequest::get($this->id);
        }
    }
    
    
    
    public function add_data() {
        $data = array();
        
        if($this->post) {
            
            $data['user_id'] = $this->post->collaboration_author;
            $data['value'] = array(
                'collaboration_id' => $this->post->post_parent,
                'request_id' => $this->id,
                'sent_by' => $this->post->post_author
            );
        }
        
        return $data;
    }
    
    
    
    public function view_data() { 
        
        $data = array();
        
        if($this->notification) {
            $user_id = $this->notification->value;
            $user = KSM_User::get($user_id);
            $data['studio_link'] = $user->display_name_link();
            $data['thumb'] = $user->avatar_link('avatar_small');
        }
        
        return $data;
        
    }
    
    
}

?>


