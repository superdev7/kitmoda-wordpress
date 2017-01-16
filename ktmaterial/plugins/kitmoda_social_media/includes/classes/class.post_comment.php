<?php


class KSM_Post_Comment extends KSM_Comment {
    
    
    
    public $_comment_type = 'ksm_post';
    
    
    
    
    public function __get($name) {
        
        if($name == 'Post' && !isset($this->Post)) {
            $this->Post = new KSM_Social_Post($this->comment_post_ID);
        } 
        
        return parent::__get($name);
    }
    
    
    
    
    function rest_item($type = 'get') {
        $data = array();
        
        if($this->comment_ID) {
            if($type == 'get') {
                return $this->rest_get_item();
            } elseif($type == 'update') {
                return $this->rest_update_item();
            }
        }
        return $data;
    }
    
    
    
    function rest_get_item() {
        
        
        $data = array(
            'comment_id' => $this->comment_ID,
            'avatar' => $this->Author->avatar(),
            'author_link'  => $this->Author->studio_link(),
            'author_name'  => $this->Author->display_name(),
            'date' => date('M j, Y', strtotime($this->comment_date)),
            'content' => $this->comment_content,
            'like' => $this->like_toggle_params(),
            'edited' => false,
            'has_access' => false
            );
        
        if($this->isOwner()) {
            $data['has_access'] = true;
        }
        
        
        $edit_date = get_comment_meta($this->comment_ID, 'last_edit_date', true);
        if($edit_date) {
            $data['edited'] = true;
            $data['date'] = date('M j, Y', strtotime($edit_date));
        }
        
        
        return $data;
    }
    
    
    function rest_update_item() {

        
        $data = array(
                'date' => date('M j, Y', strtotime($this->comment_date)),
                'content' => $this->Comment->comment_content,
                
                );
        
        
        
        $edit_date = get_comment_meta($this->comment_ID, 'last_edit_date', true);
        if($edit_date) {
            $data['edited'] = true;
            $data['date'] = date('M j, Y', strtotime($edit_date));
        }
        
        
        return $data;
    }
}