<?php



class KSM_ShareModel extends KSM_BaseModel {
    
    
    public $topic_terms = array(
            'general',
            'challenge',
            'model',
            'concept',
            'texture',
            'question'
        ),

        $gallery_terms = array(
            'wip',
            'finished'
        ),

        $post_type = 'ksm_community_post';
    
    
    
    
    
    
    
    
    function get_communiy_link($post) {
        global $wpdb;
        $user = get_user_by('id', $post->post_author);
    
        if(!$user instanceof WP_User) {
            return '';
        }
        
        //COMMUNITY_POSTS_PER_PAGE = 1;

        $q = "SELECT count(*) total FROM {$wpdb->posts} WHERE post_type = 'ksm_community_post' AND ID >= '{$post->ID}' AND post_status='publish'";

        $offset = $wpdb->get_var($q);
        
        if($offset) {
            $page = ceil($offset / COMMUNITY_POSTS_PER_PAGE );
        }
        
        
        

        $link = ksm_get_permalink('community');
        $link .= "#page={$page}&wp_id={$post->ID}";

        return $link;
    }


    function get_download_link($post) {
        global $wpdb;
        $user = get_user_by('id', $post->post_author);

        if(!$user instanceof WP_User) {
            return '';
        }

        $q = "SELECT count(*) total FROM {$wpdb->posts} WHERE post_author = '{$post->post_author}' AND post_type = 'download' AND ID >= '{$post->ID}'";

        $offset = $wpdb->get_var($q);
        if($offset) {
            $page = ceil($offset / 20);
        }

        $link = ksm_get_permalink('studio', $user->user_login);
        $link .= "#dl_{$page}_{$post->ID}";

        return $link;
    }



    function get_wall_post_link($post) {
        global $wpdb;
        $user = get_user_by('id', $post->post_author);

        if(!$user instanceof WP_User) {
            return '';
        }

        $q = "SELECT count(*) total FROM {$wpdb->posts} WHERE post_author = '{$post->post_author}' AND post_type = 'ksm_wall_post' AND ID >= '{$post->ID}'";

        $offset = $wpdb->get_var($q);
        if($offset) {
            $page = ceil($offset / 5);
        }

        $link = ksm_get_permalink('studio', $user->user_login, $page);
        $link .= "#wp_$post->ID";

        return $link;
    }
    
    
}