<?php

class KSM_Favorite {
	
	
	
    
    /**
     * 
     * @global type $wpdb
     * @param int $to
     * @param int $from
     * @return type
     */
	
	static function getStatus($item_id, $user_id) {
            
            global $wpdb;
            
            $sql = "SELECT * FROM ".$wpdb->prefix."ksm_favorites
                    WHERE user_id = %d
                    AND item_id = %d";
            
            
            $result = $wpdb->get_results($wpdb->prepare($sql, $user_id, $item_id));
            
            return $result;
	}
        
        
        static function count_user_favorites($user_id) {
            
            global $wpdb;
            
            $sql = "SELECT count(id) as count FROM ".$wpdb->prefix."ksm_favorites
                    WHERE user_id = %d";
            
            
            $result = $wpdb->get_results($wpdb->prepare($sql, $user_id));
            
            return $result[0]->count;
        }
        
        
        
        
	static function can_favorite($post, $user_ID='') {
            if(!$user_ID) {
                global $user_ID;
            }
        
            $can_favorite = false;
            if($user_ID) {
                $favorites = $post->favorites ? (Array) $post->favorites : array();
                $can_favorite = !in_array($user_ID, $favorites) ? true : false;
            }
            
            return $can_favorite;
    }
	
	
        
        
        
        static function add($item_id, $user_id) {
            global $wpdb;
            $date = time();
            return
            $wpdb->insert(
                    $wpdb->prefix."ksm_favorites", 
                    array('user_id' =>  $user_id, 'item_id' => $item_id, 'date' => $date), 
                    array( '%s', '%d' , '%d') 
                    );
        }
        
        static function remove($item_id, $user_id) {
            global $wpdb;

            return
            $wpdb->delete(
                    $wpdb->prefix."ksm_favorites", 
                    array('user_id' =>  $user_id, 'item_id' => $item_id), 
                    array( '%s', '%d') 
                    );
        }
        
        static function favorite($item_id, $user_id=0) {
            global $user_ID;
            
            $user_id = $user_id ? $user_id : $user_ID;
            $post = get_post($item_id);
            
            
            $count = 0;
            if($user_id && $post && !self::getStatus($item_id, $user_id)) {
                
                
                self::add($item_id, $user_id);
                
                $post->favorites = $post->favorites ? (Array) $post->favorites : array();
                
                if(!in_array($user_id, $post->favorites)) {
                    $post->favorites[] = $user_id;
                }
                
                $count = count($post->favorites);
                
                
                
                update_post_meta($item_id, 'favorites', $post->favorites);
                update_post_meta($item_id, 'favorites_count', $count);
                update_user_meta($user_id, 'favorites_count', self::count_user_favorites($user_id));
                
            }
            
            $results = KSM_Action::unfavorite($post);
            $results['count'] = $count;
            
            echo json_encode($results);
            die();
	}
	
        
        static function unfavorite($item_id, $user_id=0) {
            
            global $user_ID;
            
            $user_id = $user_id ? $user_id : $user_ID;
            $post = get_post($item_id);
            
            
            $count = 0;
            if($user_id && $post && self::getStatus($item_id, $user_id)) {
                
                //pr($post);
                self::remove($item_id, $user_id);
                
                $post->favorites = $post->favorites ? (Array) $post->favorites : array();
                
                
                
                $user_key = array_search($user_id, $post->favorites);
                
                unset($post->favorites[$user_key]);
                
                $count = count($post->favorites);
                
                update_post_meta($item_id, 'favorites', $post->favorites);
                update_post_meta($item_id, 'favorites_count', $count);
                update_user_meta($user_id, 'favorites_count', self::count_user_favorites($user_id));
                
            }
            
            $results = KSM_Action::favorite($post);
            $results['count'] = $count;
            
            echo json_encode($results);
            die();
            
            
            
	}
        
        
        static function favorite_toggle() {
            
            if($_POST['id']) {
                $action = KSM_Action::get($_POST['id']);
            }
            
            
            
            if(($action['action'] == 'favorite' || $action['action'] == 'unfavorite') && $action['_id']) {
                
                if($action['action'] == 'favorite') {
                    self::favorite($action['_id']);
                } 
                elseif($action['action'] == 'unfavorite') {
                    
                    self::unfavorite($action['_id']);
                }
                
            }
        }
        
        
        
        
        
        
        static function get_user_favorites($user_id, $p=0, $rpp=0) {
            global $wpdb;
            
            
            $limit = "";
            if($p  && $rpp) {
                $start = ($p * $rpp) - $rpp;
                $limit = " LIMIT {$start}, {$rpp}";
            }
            
            
            $sql = "SELECT * FROM ".$wpdb->prefix."ksm_favorites
                    WHERE user_id = %d ORDER BY id DESC{$limit}";
            
            
            $result = $wpdb->get_results($wpdb->prepare($sql, $user_id));
            
            return $result;
        }
	
}







?>