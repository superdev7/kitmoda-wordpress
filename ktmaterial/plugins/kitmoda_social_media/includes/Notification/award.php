<?php



class KSM_Notification_Award extends KSM_Notification {
    
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
            
            $value = $this->notification->value;
            
            
            if(in_array($value, array_keys(KSM_Award::$permanent_awards))) {
                $award = KSM_Award::$permanent_awards[$value];
            } elseif(in_array($not->value, array_keys(KSM_Award::$temporary_awards))) {
                $award = KSM_Award::$temporary_awards[$value];
            }
            
            
            $data['award_title'] = $award['title'];
            
            $data['thumb'] = '<img src="'.KSM_BASE_URL."images/awards/{$value}.png".'" />';
        }
        
        return $data;
        
    }
    
    
}

?>


