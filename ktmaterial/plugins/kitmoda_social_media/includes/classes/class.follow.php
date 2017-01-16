<?php

class KSM_Follow {
	
	
	
    
    /**
     * 
     * @global type $wpdb
     * @param int $to
     * @param int $from
     * @return type
     */
	
	static function getStatus($to, $from) {
            
            global $wpdb;
            
            $sql = "SELECT * FROM ".$wpdb->prefix."ksm_follows
                    WHERE user_to = %d
                    AND user_by = %d";
            
            
            $result = $wpdb->get_results($wpdb->prepare($sql, $to, $from));
            
            return $result;
	}
        
        
	static function count_followings($user_id) {
            
            global $wpdb;
            
            $sql = "SELECT count(id) as count FROM ".$wpdb->prefix."ksm_follows
                    WHERE user_by = %d";
            
            
            $result = $wpdb->get_results($wpdb->prepare($sql, $user_id));
            
            return $result[0]->count;
        }
        
        
        
        static function count_followers($user_id) {
            
            global $wpdb;
            
            $sql = "SELECT count(id) as count FROM ".$wpdb->prefix."ksm_follows
                    WHERE user_to = %d";
            
            
            $result = $wpdb->get_results($wpdb->prepare($sql, $user_id));
            
            return $result[0]->count;
        }
        
        
	
        
        
        
        
        static function add_follow($user_to, $user_by) {
            global $wpdb;
            $date = time();
            return
            $wpdb->insert(
                    $wpdb->prefix."ksm_follows", 
                    array('user_to' =>  $user_to, 'user_by' => $user_by, 'date' => $date), 
                    array( '%s', '%d' , '%d') 
                    );
        }
        
        static function remove_follow($user_to, $user_by) {
            global $wpdb;

            return
            $wpdb->delete(
                    $wpdb->prefix."ksm_follows", 
                    array('user_to' =>  $user_to, 'user_by' => $user_by), 
                    array( '%s', '%d') 
                    );
        }
        
        static function follow($user_to) {
            global $user_ID;
            
            
            $user_by = $user_ID;
            
            $status = self::getStatus($user_to, $user_by);
            
            if(empty($status)) {
                self::add_follow($user_to, $user_by);
                update_user_meta($user_by, 'followings_count', self::count_followings($user_by));
                update_user_meta($user_to, 'followers_count', self::count_followers($user_to));
                KSM_Notification::add($user_to, 'following' , $user_by);
            }
            
            echo json_encode(KSM_Action::unfollow($user_to));
            die();
	}
	
        
        static function unfollow($user_to) {
            global $user_ID;
            
            
            $user_by = $user_ID;
            
            $status = self::getStatus($user_to, $user_by);
            
            
            if(!empty($status)) {
                self::remove_follow($user_to, $user_by);
                
                $followings_count = self::count_followings($user_by);
                update_user_meta($user_by, 'followings_count', $followings_count);
                update_user_meta($user_to, 'followers_count', self::count_followers($user_by));
            }
            
            $result_action = KSM_Action::follow($user_to);
            $result_action['followings'] = $followings_count;
            
            return $result_action;
	}
        
        
        
        
        
        
        
        static function follow_toggle() {
            
            if($_POST['id']) {
                $action = KSM_Action::get($_POST['id']);
            }
            
            if(($action['action'] == 'follow' || $action['action'] == 'unfollow') && $action['_id']) {
                
                if($action['action'] == 'follow') {
                    self::follow($action['_id']);
                } elseif($action['action'] == 'unfollow') {
                    self::unfollow($action['_id']);
                }
                
            } 
        }
        
        
        
        
        
        
        static function get_user_followings($user_id) {
            global $wpdb;
            
            $sql = "SELECT * FROM ".$wpdb->prefix."ksm_follows
                    WHERE user_by = %d ORDER BY id DESC";
            
            
            $result = $wpdb->get_results($wpdb->prepare($sql, $user_id));
            
            return $result;
        }
        
        
        
        static function get_user_following_ids($user_id, $page=0, $rpp=10) {
            global $wpdb;
            
            
            $offset = $page ? ($page * $rpp) : $rpp;
            $offset = $offset - $rpp;
            
            $sql = "SELECT user_to FROM ".$wpdb->prefix."ksm_follows
                    WHERE user_by = %d ORDER BY id DESC LIMIT $offset, $rpp";
            
            
            $result = $wpdb->get_results($wpdb->prepare($sql, $user_id));
            
            return $result;
        }
        
        
        static function get_all_user_following_ids($user_id) {
            global $wpdb;
            
            $sql = "SELECT user_to FROM ".$wpdb->prefix."ksm_follows
                    WHERE user_by = %d";
            
            $result = $wpdb->get_results($wpdb->prepare($sql, $user_id));
            
            $user_ids = array();
            foreach($result as $r) {
                $user_ids[] = $r->user_to;
            }
            
            return $user_ids;
        }
	
}

?>