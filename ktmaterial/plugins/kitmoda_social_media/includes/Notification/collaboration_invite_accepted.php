<?php


class KSM_Notification_CollaborationInviteAccepted extends KSM_Notification {
    
public $id,
       $post;
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
        
        $this->post = KSM_CollaborationRequest::get($this->id);
    }
    
    
    
    public function add_data() {
        $data = array();
        
        if($this->post) {
            
            $data['user_id'] = $this->post->post_author;
            $data['value'] = array(
                'collaboration_id' => $this->post->post_parent,
                'request_id' => $this->id
            );
        }
        
        return $data;
    }
    
    
    public function view_data() { 
        
        $data = array();
        
        
        if($this->notification) {
            $value = maybe_unserialize($this->notification->value);
            $collaboration = KSM_Collaboration::get($value['collaboration_id']);
            
            
            $data['active_collaboration_link'] = '<a href="'.ksm_get_permalink('collaboration/active').'">here</a>';
            $data['collaboration_name_link'] = '<a href="'.$collaboration->full_view_link().'">'.$collaboration->post_title.'</a>';
            $data['thumb'] = $collaboration->the_thumb('avatar_small');
            $data['accepted_by_link'] = $collaboration->Author->display_name_link();
            
        }
        
        return $data;
        
    }

}
?>