<?php

class KSM_Like {
	
	

    
    static function like_comment_toggle() {
        
        if($_POST['id']) {
            $action = KSM_Action::get($_POST['id']);
        }
        
        if(($action['action'] == 'comment_like' || $action['action'] == 'comment_unlike') && $action['_id']) {
            if($action['action'] == 'comment_like') {
                self::comment_like($action['_id']);
            } 
            elseif($action['action'] == 'comment_unlike') {
                self::comment_unlike($action['_id']);
            }
        }
        
    }
    
    static function comment_like($comment_id) {
        global $user_ID;
        
        
        $comment = get_comment($comment_id);
        
        $count = 0;
        if($comment && $user_ID) {
            $likes = get_comment_meta($comment_id, 'likes', true);
            
            $likes = $likes ?  (Array) $likes : array();
            
            $count = count($likes);
            
            if(!in_array($user_ID, $likes)) {
                $likes[] = $user_ID;
                $count++;
                update_comment_meta($comment_id, 'likes', $likes);
                update_comment_meta($comment_id, 'likes_count', $count);
            }
        }
        
        
        $results = KSM_Action::comment_unlike($comment);
        $results['count'] = $count;
            
        echo json_encode($results);
        die();
    }
    
    static function comment_unlike($comment_id) {
        global $user_ID;
        
        
        $comment = get_comment($comment_id);
        
        $count = 0;
        if($comment && $user_ID) {
            $likes = get_comment_meta($comment_id, 'likes', true);
            $likes = $likes ?  (Array) $likes : array();
            $count = count($likes);
            if(in_array($user_ID, $likes)) {
                $user_key = array_search($user_ID, $likes);
                unset($likes[$user_key]);
                $count--;
                update_comment_meta($comment_id, 'likes', $likes);
                update_comment_meta($comment_id, 'likes_count', $count);
            }
        }
        
        $results = KSM_Action::comment_like($comment);
        $results['count'] = $count;
            
        echo json_encode($results);
        die();
    }
    
    
    
    static function like_post_toggle() {
        if($_POST['id']) {
            $action = KSM_Action::get($_POST['id']);
        }
        
        
        if(($action['action'] == 'post_like' || $action['action'] == 'post_unlike') && $action['_id']) {
            
            if($action['action'] == 'post_like') {
                self::post_like($action['_id']);
            } 
            elseif($action['action'] == 'post_unlike') {
                self::post_unlike($action['_id']);
            }
            
        }
    }
    
    
    static function post_like($post_id) {
        global $user_ID;
        
        $post = get_post($post_id);
        
        $count = 0;
        
        
        
        if($post && $user_ID) {
            $post->likes = $post->likes ? (Array) $post->likes : array();
            $count = count($post->likes);
            if(!in_array($user_ID, $post->likes)) {
                $post->likes[] = $user_ID;
                $count++;
                update_post_meta($post_id, 'likes', $post->likes);
                update_post_meta($post_id, 'likes_count', $count);
                if($post->post_type == 'download') {
                    update_user_meta($post->post_author, 'projects_likes_count', self::count_user_product_likes($post->post_author));
                }
            }
            
                
            if(has_term('ksm_tax_topic', 'wip', $post->ID)) {
                update_user_meta($post->post_author, 'wip_post_likes', $count);
            } elseif(has_term('ksm_tax_topic', 'finished', $post->ID)) {
                update_user_meta($post->post_author, 'finished_post_likes', $count);
            }
            
        }
        
        
        
        $results = KSM_Action::post_unlike($post);
        $results['count'] = $count;
            
        echo json_encode($results);
        die();
        
        
        
    }
    
    
    
    
    static function post_unlike($post_id) {
        global $user_ID;
        
        $post = get_post($post_id);
        
        $count = 0;
        if($post && $user_ID) {
            $post->likes = $post->likes ? (Array) $post->likes : array();
            
            $count = count($post->likes);
            if(in_array($user_ID, $post->likes)) {
                $user_key = array_search($user_ID, $post->likes);
                unset($post->likes[$user_key]);
                $count--;
                
                update_post_meta($post_id, 'likes', $post->likes);
                update_post_meta($post_id, 'likes_count', $count);
                if($post->post_type == 'download') {
                    update_user_meta($post->post_author, 'projects_likes_count', self::count_user_product_likes($post->post_author));
                }
                
                if(has_term('ksm_tax_topic', 'wip', $post->ID)) {
                    update_user_meta($post->post_author, 'wip_post_likes', $count);
                } elseif(has_term('ksm_tax_topic', 'finished', $post->ID)) {
                    update_user_meta($post->post_author, 'finished_post_likes', $count);
                }
            }
            
        }
        
        $results = KSM_Action::post_like($post);
        $results['count'] = $count;
            
        echo json_encode($results);
        die();
    }
    
    
    
    
    static function count_user_product_likes($user_id) {
        
        global $wpdb;
        
        $q = "SELECT sum(pm.meta_value) FROM $wpdb->posts p, $wpdb->postmeta pm WHERE 
                p.post_author = '{$user_id}' AND p.post_status = 'publish' 
                AND p.post_type = 'download' AND pm.meta_key = 'likes_count' AND meta_value > 0 
                AND pm.post_id=p.ID";
        
        return $wpdb->get_var($q);
        
    }
    
    
    static function user_liked($post, $user_id='') {
        global $user_ID;
            
        $user_id = $user_id ? $user_id : $user_ID;
        $likes = $post->likes ? (Array) $post->likes : array();
        $liked = false;

        if($user_id) {
            $liked = in_array($user_id, $likes) ? true : false;
        }
        
        return $liked;
        
    }
    
    
    static function user_liked_comment($comment, $user_id='') {
        global $user_ID;
            
        $user_id = $user_id ? $user_id : $user_ID;
        
        $liked = false;

        if($user_id && $comment) {
            
            $comment_meta = get_comment_meta($comment->comment_ID);
            $likes = ($comment_meta['likes'][0]) ? (Array) maybe_unserialize($comment_meta['likes'][0]) : array();
            $liked = in_array($user_id, $likes) ? true : false;
        }
        
        return $liked;
        
    }
    
}

?>