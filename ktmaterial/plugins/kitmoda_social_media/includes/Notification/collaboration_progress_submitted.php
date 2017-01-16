<?php



class KSM_Notification_CollaborationProgressSubmitted extends KSM_Notification {
    
    public $id,
       $post;
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
        
        $this->post = KSM_Collaboration_Wip::get($this->id);
    }
    
    
    
    public function add_data() {
        $data = array();
        
        if($this->post) {
            
            $data['user_id'] = $this->post->collaboration_author;
            $data['value'] = array(
                'active_id' => $this->post->post_parent,
                'partner' => $this->post->post_author
            );
        }
        
        return $data;
    }
    
    
    public function view_data() { 
        
        $data = array();
        
        if($this->notification) {
            
            $value = maybe_unserialize($this->notification->value);
            $active_id = $value['active_id'];
            $partner_id = $value['partner'];
            
            
            $partner = KSM_User::get($partner_id);
            
            
            
            $active = KSM_CollaborationActive::get($active_id);
            
            $data['thumb'] = $active->the_thumb('avatar_small');
            $data['project_link'] = '<a href="'.ksm_get_permalink("collaboration/partner_projects/{$active_id}").'">here</a>';
            $data['partner_link'] = $partner->display_name_link();
            
        }
        
        return $data;
        
    }
}

?>
