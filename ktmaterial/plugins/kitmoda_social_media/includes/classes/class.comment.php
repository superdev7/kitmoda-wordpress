<?php



class KSM_Comment {
    
    public $Comment,
           $match_type;
    
    
    function __construct($id = 0, $match_type = true) {
        //echo "__construct : {$id} : end__construct";
        $this->match_type = $match_type;
        
        $this->Comment = $this->init($id);
        
    }
    
    
    static function get($id, $match_type=true) {
        
        $cls = get_called_class();
        
        $_obj = new $cls($id, $match_type);
        
        if($_obj->comment_ID) {
            return $_obj;
        }
        
        return null;
    }
    
    public function get_meta($key) {
        return get_comment_meta($this->comment_ID, $key, true);
    }
    
    
    public function like_toggle_params() {
    
        
        $like_action = KSM_Action::comment_like_toggle($this->Comment);
        
        
        return 
        array(
            'count' => get_number($this->get_meta('likes_count')),
            'class' => $like_action['class'],
            'params' => array(
                'id' => $like_action['action'],
                'action' => 'clike'
                )
            );
                
                

             
    
    }
    
    public function init($id) {
        
        $comment = null;
        if($id) {
            $comment = get_comment($id);
            
            
            if(!$comment || ($this->match_type && $comment->comment_type != $this->_comment_type)) {
                $comment = null;
            }
        }
        return $comment;
    }
    
    
    
    public function like() {
        
        $user_id = get_current_user_id();
        $likes = (Array) $this->get_meta('likes');
        $count = count($likes);
        
        if($user_id && !in_array($user_id, $likes)) {
            $likes[] = $user_id;
            $count++;
            $this->update_meta('likes', $likes);
            $this->update_meta('likes_count', $count);
        }
        
        
        return $this->like_toggle_params();
    }
    
    
    
     public function unlike() {
        
        $user_id = get_current_user_id();
        
        $likes = (Array) $this->get_meta('likes');
        $count = count($likes);
        
        if($user_id && in_array($user_id, $likes)) {
            
            $user_key = array_search($user_id, $likes);
            unset($likes[$user_key]);
            $count--;
            $this->update_meta('likes', $likes);
            $this->update_meta('likes_count', $count);
        }
        
        return $this->like_toggle_params();
    }
    
    
    public function __get($name) {
        
        
        if($name == 'Author' && !isset($this->Author)) {
            $this->Author = new KSM_User($this->user_id);
        }
        
        
        if(property_exists($this, $name)) {
            return $this->{$name};
        } elseif(is_object($this->Comment) && (property_exists($this->Comment, $name) || isset($this->Comment->{$name}))) {
            return $this->Comment->{$name};
        }
    }
    
    
    public function isOwner($user_id = 0) {
        
        $user_id = $user_id ? $user_id : get_current_user_id();
        
        
        if($this->Comment && $user_id && $this->user_id == $user_id) {
            return true;
        }
        return false;
    }
    
    
    public function update_meta($key, $value) {
        
        update_comment_meta($this->comment_ID, $key, $value);
    }
    
    function update($args) {
        $args['comment_ID'] = $this->comment_ID;
        wp_update_comment($args);
        $this->update_meta('last_edit_date', current_time( 'mysql' ));
        return $this->Success("Comment updated");
    }
    
    public function Error($error) {
        return array('error' => true, 'msg' => $error);
    }
    
    
    public function Success($msg='', $data = array()) {
        return array_merge($data , array('success' => true, 'msg' => $msg));
    }
    
    
    public function delete($force = true) {
        
        
        if(!$this->isOwner()) {
            return $this->Error("You can't delete this comment.");
        }
        
        if(wp_delete_comment( $this->comment_ID, $force )) {
            return $this->Success("Comment Deleted.");
        } else {
            return $this->Error("Error while deleting comment.");
        }
        
    }
    
    
    static function get_comment($id) {
        
        $comment = new KSM_Comment($id, false);
        return $comment;
    }
    
    
    
    
    
}


?>