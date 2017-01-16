<?php

class KSM_ShareController extends KSM_BaseController {
    
    
    
    public function ksm_share() {
        $this->layout = 'colorbox';
        
        $post_id = $this->params['id'];
        
        
        
        
        if(!$post_id) {
            exit;
        }
        
        
        $post = get_post($post_id);
        
        
        if(!KSM_Share::is_shareable($post)) {
            exit;
        }
        
        $params = KSM_Share::params($post_id);
        $params['id'] = $post_id;
        
        
        $this->set('share_params', $params);
    }
    
    
    public function short_link() {
        $key = $this->params['id'];
        global $wpdb;
        if(!$key) {
            return;
        }
    
    
        $posts = get_posts(array(
            'post_type' => 'any',
            'post_status' => 'publish',
            'meta_query' => array(
                array('key' => 'short_link', 'value' => $key)
            )
        ));
    
        if(!$posts[0]) {
            return;
        }
    
        $post = $posts[0];
        
        switch ($post->post_type) {
            case "ksm_post" :
                $link = $this->Model->get_wall_post_link($post);
            case "download":
                $link = $this->Model->get_download_link($post);
                break;
        }
        
        if($link) {
            wp_redirect($link);
        }
        
        exit;
    }
}