<?php

class KSM_Shortcode {
    
    
    
    
    
    
    static function following() {
        $ksm_profile = KSM_profile::getInstance();
        $ksm_profile->following_popup();
        ob_start();
        include KSM_BASE_PATH.'templates/shortcodes/following_popup.php';
        return ob_get_clean();
    }
    
    
    static function favorites() {
        
        $ksm_profile = KSM_profile::getInstance();
        $ksm_profile->favorite_popup();
        
        ob_start();
        include KSM_BASE_PATH.'templates/shortcodes/favorites_popup.php';
        return ob_get_clean();
    }
    
    
    static function compose() {
        $ksm_profile = new KSM_profile();
        ob_start();
        include KSM_BASE_PATH.'templates/shortcodes/compose.php';
        return ob_get_clean();
    }
    
    
    static function top_selling() {
        $ksm_profile = KSM_profile::getInstance();
        $ksm_profile->top_selling_popup();
        ob_start();
        include KSM_BASE_PATH.'templates/shortcodes/top_selling_popup.php';
        return ob_get_clean();
    }
    
    static function profile_settings() {
        $ksm_profile = KSM_profile::getInstance();
        
        $settings = KSM_profile::profile_settings($ksm_profile->auth_user);
        
        
        ob_start();
        include KSM_BASE_PATH.'templates/shortcodes/profile_settings.php';
        return ob_get_clean();
    }
    
    
    static function add_wip() {
        $ksm_profile = new KSM_profile();
        ob_start();
        include KSM_BASE_PATH.'templates/shortcodes/add_wip.php';
        return ob_get_clean();
    }
    
    
    static function share() {
        
        $post_id = $_GET['id'];
        $post = get_post($post_id);
        
        if(KSM_Share::is_shareable($post)) {
            $params = KSM_Share::params($post_id);
            $params['id'] = $post_id;
            ob_start();
            include KSM_BASE_PATH.'templates/shortcodes/share.php';
            return ob_get_clean();
        }
    
    }
    
    
    
    static function publisher() {
        ob_start();
        include KSM_BASE_PATH.'templates/shortcodes/publisher.php';
        return ob_get_clean();
    }
    
    static function post_options() {
        global $user_ID;
        
        $id = $_GET['id'];
        
        if($id && $user_ID) {
            $post = get_post($id);
            //if(!($post && $post->post_author == $user_ID)) {
            if(!($post && $post->post_status == 'pending' && $post->post_author == $user_ID)) {
                $error = "Post options are not available";
            }
        } else {
            $error = "Post options are not available";
        }
        
        if($error) {
            return $error;
        }
        
        $attachments = post_attacments($post->ID);
        
        ob_start();
        
        
        include KSM_VIEWS_PATH.'shortcodes/post_options.php';
        return ob_get_clean();
    }
    
}