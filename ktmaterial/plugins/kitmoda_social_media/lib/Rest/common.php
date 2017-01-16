<?php


class KSM_Rest_Controller_Common extends KSM_BaseRest {
    
    
    
    public function like_permission($request) {
        
        $this->request = $request;
        
        if(!get_current_user_id()) {
            return;
        }
        
        if($this->param('id')) {
            $action = KSM_Action::get($this->param('id'));
            if(($action['action'] == 'comment_like' || $action['action'] == 'comment_unlike') && $action['_id']) {
                $comment = KSM_Post_Comment::get($action['_id']);
                if($comment) {
                    unset($comment);
                    return true;
                }
            }
            
        }
    }
    
    
    
    
    
    
    public function like() {
        
        $action = KSM_Action::get($this->param('id'));
        
        $result = array();
        
        if($action['action'] == 'comment_like') {
            $comment = KSM_Post_Comment::get($action['_id']);
            if($comment) {
                
                
                $result = $comment->like();
            }
        }
        
        elseif($action['action'] == 'comment_unlike') {
            $comment = KSM_Post_Comment::get($action['_id']);
            if($comment) {
                $result = $comment->unlike();
            }
        }
            
        
        
        return $result;
        
        
    }
    
}

?>