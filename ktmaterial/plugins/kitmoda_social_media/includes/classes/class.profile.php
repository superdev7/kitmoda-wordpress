<?php

class KSM_profile {
    
    public
    $is_public_pofile,
    $is_private_pofile,
    $type,
    $profile_user,
    $auth_user,
    $error;
    
    
    
    
    
    public function __construct() {
        
        global $user_ID, $user_login;
        
        
        $profile_username = get_query_var('username');
        $tab = get_query_var('tab');
        $this->tab = $tab ? $tab : 'studio';
        
        
        
        if($this->tab == 'studio' && !$profile_username) {
            
        }
        
        if(!$profile_username) {
            $this->type = 'private';
            if($user_ID) {
                $this->profile_user = wp_get_current_user();
            } else {
                $this->error = 1;
            }
        } elseif($profile_username) {
            
            if($user_login && $profile_username == $user_login) {
                $this->type = 'private';
                $this->profile_user = get_user_by('login', $profile_username);
            } else {
                
                $this->type = 'public';
                
                $this->profile_user = get_user_by('login', $profile_username);
            
                if(!$this->profile_user instanceof WP_User) {
                    $this->error = 2;
                }
                
            }
            
            
            
            
        }
        
        
        /*
        if((!$profile_username && $user_ID) || ($profile_username && $profile_username == $user_login)) {
            $this->type = 'private';
            $this->profile_user = wp_get_current_user();
        } elseif($profile_username) {
            $this->profile_user = get_user_by('login', $profile_username);
            
            if($this->profile_user instanceof WP_User) {
                $this->type = 'public';
            }
        }
        */
        
        //if(!$this->type) {
        //    $this->error = true;
        //    return;
        //}
        
        
        $this->is_public_pofile = ($this->type == 'public') ? true : false;
        $this->is_private_pofile = ($this->type == 'private') ? true : false;
        
        if($user_ID) {
            $this->auth_user = wp_get_current_user();
        }
        
        
        
    }
    
    
    static function &getInstance() {
	static $instance = array();
	if (!$instance) {
            $instance[0] = new KSM_profile();
	}
	return $instance[0];
    }
    
    
    public function following_popup() {
        
        $rpp = 10;
        $total = get_number($this->profile_user->followings_count);
        $pages_count = ceil($total/$rpp);
        $current_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
        
        
        
        $follows = KSM_Follow::get_user_following_ids($this->profile_user->ID, $current_page, $rpp);
        
        $user_ids = array();
        
        foreach($follows as $f) {
            $user_ids[] = $f->user_to;
        }
        
        $results = array();
        if(!empty($user_ids)) {
            $results = get_users(array('include'=>$user_ids));
        }
        
        $this->following = array(
            'results' =>  $results,
            'followings_count' => $this->profile_user->followings_count,
            'pages_count' => $pages_count,
            'current_page' => $current_page
        );
        
        
    }
    
    
    public function top_selling_popup() {
        
        $rpp = 12;
        $total = get_number($this->profile_user->top_selling_count);
        $pages_count = ceil($total/$rpp);
        $current_page = get_query_var('paged') ? get_query_var('paged') : 1;
        
        $current_page = (!is_numeric($current_page) || $current_page < 1) ? 1 : $current_page;
        
        $top_sellings = KSM_TopSelling::get_results($this->profile_user->ID, $current_page , $rpp);
        
        //$favorites = KSM_Favorite::get_user_favorites($this->profile_user->ID, $current_page , $rpp);
        
        
        $this->top_sellings = array(
            'results' =>  $top_sellings,
            'top_selling_count' => $this->profile_user->top_selling_count,
            'pages_count' => $pages_count,
            'current_page' => $current_page
        );
    }


    public function favorite_popup() {
        
        $rpp = 12;
        $total = get_number($this->profile_user->favorites_count);
        $pages_count = ceil($total/$rpp);
        $current_page = get_query_var('paged') ? get_query_var('paged') : 1;
        
        $current_page = (!is_numeric($current_page) || $current_page < 1) ? 1 : $current_page;
        
        
        $favorites = KSM_Favorite::get_user_favorites($this->profile_user->ID, $current_page , $rpp);
        
        
        $this->favorites = array(
            'results' =>  $favorites,
            'favorites_count' => $this->profile_user->favorites_count,
            'pages_count' => $pages_count,
            'current_page' => $current_page
        );
        
        
    }
    
    
    
    
    public function studio() {
        
        
        
        
        
        
        $args = array();
        
        
        $this->wall_posts = get_posts(array(
            'showposts' => -1, 
            'post_type' => 'ksm_wall_post', 
            'meta_query' => array(
                array(
                    'key' => 'wall_id',
                    'value' => $this->profile_user->ID
                    )
                )
        ));
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}