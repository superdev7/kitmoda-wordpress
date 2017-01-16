<?php



class KSM_Notification_CollaborationInviteSent extends KSM_Notification {
    
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
            
            $value = maybe_unserialize($this->notification->value);
            $user = KSM_User::get($value['sent_by']);
            
            $collaboration = KSM_Collaboration::get($value['collaboration_id']);
            $data['studio_link'] = $user->display_name_link();
            $data['requests_link'] = '<a href="'.ksm_get_permalink('collaboration/requests').'">here</a>';
            $data['collaboration_name_link'] = '<a href="'.$collaboration->full_view_link().'">'.$collaboration->post_title.'</a>';
            $data['thumb'] = $collaboration->the_thumb('avatar_small');
        }
        
        return $data;
        
    }
    
    
}

?>


