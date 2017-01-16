<?php

class KSM_postView {
    
    
    
    static function get_hours_views($hours) {
        
        global $wpdb;
        
        $sql = 
        'SELECT p.ID , p.post_type, kv.total_views 
            FROM '.$wpdb->posts.' p 
            LEFT JOIN (
                       SELECT sum(views) total_views, post_id FROM '.$wpdb->prefix.'ksm_views 
                       WHERE hour IN ('.implode(',', $hours).') 
                       GROUP BY post_id) kv ON kv.post_id = p.ID
            WHERE post_type = "download"';
        
            
        $result1 = $wpdb->get_results($sql);
        
        $sql = 
        'SELECT p.ID , p.post_type, kv.total_views 
            FROM '.$wpdb->postmeta.' pm, '.$wpdb->posts.' p
            LEFT JOIN (
                       SELECT sum(views) total_views, post_id FROM '.$wpdb->prefix.'ksm_views 
                       WHERE hour IN ('.implode(',', $hours).') 
                       GROUP BY post_id) kv ON kv.post_id = p.ID
            WHERE pm.meta_key = "user_upload_type" AND pm.meta_value = "post_image" AND pm.post_id = p.ID';
        
        
        
        //echo $sql . "<br /><br /><br /><br />";
        
        
        $result2 = $wpdb->get_results($sql);
        
        
        
        
        $result1 = $result1 ? $result1 : array();
        $result2 = $result2 ? $result2 : array();
        
        
        $result = array_merge($result1, $result2);
        
        return $result;
        
        
    }
    
    
    static function hour_exists($post_id, $hour = '') {
        global $wpdb;
        
        if(!$hour) {
            $hour = get_hour_key();
        }
        
        $q = "SELECT id FROM ".$wpdb->prefix."ksm_views WHERE post_id = %d AND hour = %d";
        
        $_id = $wpdb->get_var($wpdb->prepare($q , $post_id, $hour ));
        
        return $_id;
    }
    
    
    
    
    
    static function add($post, $increment = 1) {
        
        $name = get_the_user_ip();
        
        
        
        if(!is_dir(KSM_VIEWS_CACHE_PATH)) {
            if(!@mkdir(KSM_VIEWS_CACHE_PATH))
				wp_die( __("Unable to create...") );
        }
        
        
        
        if(!KSM_DataStore::View_Exist($name, $post->ID)) {
            
            global $wpdb;
            $new_count = $post->views_count + 1;
            update_post_meta($post->ID, 'views_count', $new_count);
            KSM_DataStore::Save_Views($name, ','.$post->ID);
        
            
                
            if(has_term('ksm_tax_topic', 'wip', $post->ID)) {
                update_user_meta($post->post_author, 'wip_post_count', $new_count);
            } elseif(has_term('ksm_tax_topic', 'finished', $post->ID)) {
                update_user_meta($post->post_author, 'finished_post_count', $new_count);
            }
            
            
            
            if(!($post->post_type == 'download' || ($post->post_type == 'attachment' && $post->user_upload_type == 'post_image'))) {
                return;
            }
            
            
            
            
            $_id = self::hour_exists($post->ID);

            if($_id) {

                $q = "UPDATE ".$wpdb->prefix."ksm_views SET views=views+{$increment} WHERE id={$_id}";
                $wpdb->query($q);
            } else {
                $_hour = get_hour_key();
                $wpdb->insert( 
                        $wpdb->prefix."ksm_views", 
                        array('post_id' => $post->ID, 'hour' => $_hour, 'views' => $increment), 
                        array('%d', '%d', '%d') );
            }
        }
    }
    
    
    
    
    /*
    static function add($post, $increment = 1) {
        
    }
    
    */
    
    
    
}