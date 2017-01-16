<?php


class KSM_Notification_CollaborationComplete extends KSM_Notification {
    
public $id,
       $post;
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
        
        $this->post = KSM_CollaborationActive::get($this->id);
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

}
?>