<?php

class KSM_Rest_Controller_Comments extends KSM_BaseRest {
    
    
    
    
    
    function has_comment_access() {
        $user_id = get_current_user_id();
        
        $has_access = false;

        if($user_id) {
            
            $request_user = $this->access_header_user();
            if($request_user && $request_user->ID == $user_id) {
                
                if($this->param('id')) {
                    $comment = new KSM_Post_Comment( (int) $this->param('id'));
                    if($comment->isOwner()) {
                        $has_access = true;
                    }
                }
            }
        }
        return $has_access;
    }
    
    
    
    
    
    function update_permission($request) {
        $this->request = $request;
        
        if($this->param('action') == 'update') {
        
            return $this->has_comment_access();
        }
        return false;
    }
    
    
    function update() {
        
        $params = $this->request->get_params();
        $result = array();
        if($this->param('id')) {
            
            
            $comment = new KSM_Post_Comment( (int) $this->param('id'));
            
            $result = $comment->update(array('comment_content' => $this->param('content')));
            
            unset($comment);
            
            $comment = new KSM_Post_Comment( (int) $params['id']);
            
            if($result['success']) {
                $result =  array_merge($comment->rest_item('update'), $result);
            }
        }
        
        return $result;
    }
    
    
    
    
    function delete_permission($request) {
        
        $this->request = $request;

        if($this->param('action') == 'delete') {
            return $this->has_comment_access();
        }
        return false;
    }
    
    function delete($request) {
        $params = $request->get_params();
        
        $result = array();
        if($params['id']) {
            $comment = new KSM_Post_Comment( (int) $params['id']);
            $result = $comment->delete();
            
        }
        
        return $result;
    }
    
         
    
    function add_permission($request = null) {
        
        if($request) {
            $this->request = $request;
        }
        
        if( $this->param('action') == 'add') {
            
            if($this->is_access_valid()) {
                $post = KSM_Social_Post::get($this->param('id'));
                if($post) {
                    unset($post);
                    return true;
                }
            }
        }
        return false;
    }
    
    
    
    function add() {
        
        $result = array();
        
        if($this->add_permission()) {
            $post = KSM_Social_Post::get($this->param('id'));
            if($post) {
                $comment = $this->param('content');
                $args = array(
                    'user'=> wp_get_current_user(),
                    'comment' => $comment,
                    'extra_meta' => array(
                        array('post_at', 'studio')
                    )
                );
                
                $result = $post->add_comment($args);
            }
        }
        
        return $result;
    }
    
    
    
    
    
    
    function Query($id) {
        
        $ksm_post = new KSM_Post($id);
        
        
        $ksm_post_comments = $ksm_post->comments(array(
            'orderby' => 'comment_date', 
            'order' => 'ASC'));
        
        $comments = array();
        foreach ($ksm_post_comments as $_comment) {
            $comments[] = self::get($_comment->comment_ID);
        }
        
        
        return $comments;
        
    }
    
    
    static function get($id) {
        
        
        $data = array();
        if($id) {
            $comment = KSM_Post_Comment::get($id);
            if($comment) {
                $data = $comment->rest_item();
            }
        }
        
        return $data;
    }
}