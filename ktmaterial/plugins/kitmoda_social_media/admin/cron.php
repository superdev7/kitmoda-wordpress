<?php

    
class KSM_CRON {
    
    
    static function clear_users_month_sales() {
        ignore_user_abort(true);
        set_time_limit(0);
        KSM_Stats::clear_users_month_sales();
        exit();
    }
    
    
    static function count_user_views() {
        ignore_user_abort(true);
        set_time_limit(0);
        $users = get_users();
        foreach($users as $u) {
            update_user_meta($u->ID, 'projects_views', get_number(KSM_Stats::count_user_product_views($u->ID)));
        }
        exit();
    }
    
    static function count_total_views() {
        ignore_user_abort(true);
        set_time_limit(0);
        
        $views = get_number(KSM_Stats::count_total_product_views());
        update_option('ksm_total_views', $views);
        exit();
    }


    
    static function count_users_rank() {
        ignore_user_abort(true);
        set_time_limit(0);
        
        $users = get_users();
        $total_users = count($users);
        
        foreach($users as $u) {
            $rank = KSM_Stats::rank($u, $total_users);
            update_user_meta($u->ID, 'rank', $rank);
        }
        exit();
    }
    
    
    
    
    
    static function trending() {
        
        
        $time_segments = array();
        $_hours = array(
            1 => array(1),
            2 => array(2, 3),
            3 => range(4, 12),
            4 => range(13, 48)
        );
        
        foreach($_hours as $k => $v) 
            foreach($v as $a) 
                $time_segments[$k][] = get_hour_key($a);
        
        
        
        
        
        $posts_data = array();
        foreach($time_segments as $k => $ts) {
            $_tmp_data = KSM_postView::get_hours_views($ts);
            foreach($_tmp_data as $vvv) {
                $vvv->time_segments = $ts;
                $posts_data[$vvv->ID][$k] = $vvv;
            }
        }
        
        
        //pr($posts_data);
        //exit;
        
        
        
        //update_post_meta($_img, 'user_upload_type', 'community_gallery_image');
        
        foreach($posts_data as $post_id => $pd) {
            
            
            $ts1_views = get_number($pd[1]->total_views);
            $ts2_views = get_number($pd[2]->total_views);
            $ts3_views = get_number($pd[3]->total_views);
            $ts4_views = get_number($pd[4]->total_views);
            
            
            $accelerations = array();
            
            if($ts2_views > 0) {
                $accelerations[1] = @($ts1_views / $ts2_views);
            } else {
                $accelerations[1] = $ts1_views;
            }
            
            if($ts3_views > 0) {
                $accelerations[2] = $ts2_views / $ts3_views;
            } else {
                $accelerations[2] = $ts2_views;
            }
            
            
            
            if($ts4_views > 0) {
                $accelerations[3] = $ts3_views / $ts4_views;
            } else {
                $accelerations[3] = $ts3_views;
            }
            
            
            $velocity = array_sum($accelerations) / 3;
            
            echo "{$post_id}, [$ts1_views, $ts2_views, $ts3_views, $ts4_views] ,{$velocity} <br />";
            
            update_post_meta($post_id, 'trending', $velocity);
            
        }
        
        
    }
    

    
    static function top_rated() {
        
        
        $posts = get_posts(array(
            'posts_per_page' => -1,
            'post_type' => array('download','ksm_post'),
            'post_status' => 'any'
        ));
        
        
        
        foreach($posts as $p) {
            
            $rating = KSM_Stats::calculate_post_rating($p->ID);
            update_post_meta($p->ID, 'rating_coefficient', $rating);
            
            
            if($p->post_type == 'ksm_post') {
                
                $attachments = post_attacments($p->ID);
                foreach((Array) $attachments as $att) {
                    $rating = KSM_Stats::calculate_post_rating($att->ID);
                    update_post_meta($att->ID, 'rating_coefficient', $rating);
                }
                
            }
            
            
        }
        
        
    }
    
    
    
    static function collaboration_progress_delay() {
        global $wpdb;
        
        $activity_steps = array(
            'model_mid_wip',
            'fb_wait_model_mid_wip',
            'model_final_wip',
            'fb_wait_model_final_wip',
            'texture_mid_wip',
            'fb_wait_texture_mid_wip',
            'texture_final_wip',
            'fb_wait_texture_final_wip');
        
        
        
        $q = "SELECT p.ID, pm.* FROM {$wpdb->posts} p INNER JOIN {$wpdb->postmeta} pm on p.ID = pm.post_id and pm.meta_key = 'current_step_state'
AND meta_value IN ('".implode("', '", $activity_steps)."')
WHERE post_type = 'collab_active';";


        
        
        
        
        //foreach($posts as $p) {
        //    $notification = KSM_Notification::get('collaboration_delay', array('id' => $p->ID));
        //    $notification->send();
        //}
        
        
    }
    
    
    
    
}







?>