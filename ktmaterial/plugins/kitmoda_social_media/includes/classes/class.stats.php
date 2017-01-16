<?php

class KSM_Stats {
    
    
    
    static function count_user_products($user_id) {
        global $wpdb;
        
        $q = "SELECT count(p.ID) FROM $wpdb->posts p WHERE p.post_author = '{$user_id}' 
            AND p.post_status = 'publish' AND p.post_type = 'download'";
        
        return $wpdb->get_var($q);
        
    }
    
    
    static function count_user_wips($user_id) {
        global $wpdb;
        
        $q = "SELECT count(p.ID) FROM $wpdb->posts p WHERE p.post_author = '{$user_id}' 
            AND p.post_status = 'publish' AND p.post_type = 'ksm_wip'";
        
        return $wpdb->get_var($q);
        
    }
    
    
    
    static function count_user_product_views($user_id) {
        global $wpdb;
        $q = "SELECT sum(pm.meta_value) FROM $wpdb->posts p, $wpdb->postmeta pm WHERE 
                p.post_author = '{$user_id}' AND p.post_status = 'publish' AND p.post_type = 'download' 
                AND p.ID = pm.post_id AND pm.meta_key = 'views_count'";
        
        return $wpdb->get_var($q);
    }
    
    static function count_total_product_views() {
        global $wpdb;
        $q = "SELECT sum(um.meta_value) FROM $wpdb->usermeta um WHERE 
                um.meta_key = 'projects_views' AND um.meta_value > 0";
        
        return $wpdb->get_var($q);
    }
    
    
    static function count_user_top_sellings($user_id) {
        global $wpdb;
        
        
        
        $q = "SELECT count(p.ID) FROM $wpdb->posts p, $wpdb->postmeta pm WHERE 
                p.post_status = 'publish' AND p.post_author = '{$user_id}' AND 
                p.post_type = 'download' AND p.ID = pm.post_id AND pm.meta_key = '_edd_download_sales' AND 
                meta_value > 0";
                
        return $wpdb->get_var($q);
    }


    
    
    static function clear_users_month_sales() {
        global $wpdb;
        
        $q = "UPDATE $wpdb->usermeta SET meta_value='0' WHERE meta_key = 'sales_month'";
        
        $wpdb->query($q);
        
    }
    
    static function calculate_post_rating($post_id) {
        $p = get_post($post_id);
        if(!$p) {
            return;
        }
        
        $views = get_number($p->views_count);
        $likes = get_number($p->likes_count);
        
        if($views == 0) {
            $rating = '0';
        } else {
            $rating = $likes / $views;
        }
        
        return $rating;
        
        
    }
    
    
    
    
    
    static function calculate_top_ten_sellers() {
        global $wpdb;
        
        
        //$q = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'sales_lifetime' order by meta_value desc limit 0, 10";
        //return $wpdb->get_results($q);
        
        
        $users = get_users(array(
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'sales_lifetime',
                    'value' => 0,
		    'compare' => '>',
                    'type' => 'NUMERIC'
                    )
                ),
            'orderby'      => 'meta_value',
            'order'        => 'DESC',
            'number'       => '10'
            ));
        
            return $users;
        
        
    }
    
    
    
    
    
    
    
    
    
    
    static function top_ten_sellers() {
        $users = get_users(array(
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'top_ten_sellers',
                    'value' => 1,
		    'compare' => '=',
                    'type' => 'NUMERIC'
                    )
                )
            ));
        return $users;
    }
    
    
    static function trending() {
        
        
    }
    
    
    static function rank($user, $total_num_users) {
        
        
        $total_wall_posts = get_number(get_option('ksm_total_posts'));
        $total_views = get_number(get_option('ksm_total_views'));
        $total_likes = get_number(get_option('ksm_total_likes'));
        $toatl_favorites = get_number(get_option('ksm_total_favorites'));
        $total_sales = get_number(get_option('edd_earnings_total'));
        
        
        
        
        $aNumPost = $total_wall_posts / $total_num_users;
        $aNumView = $total_views / $total_num_users;
        $aNumLike = $total_likes / $total_num_users;
        $aNumFav = $toatl_favorites / $total_num_users;
        $aNumSale = $total_sales / $total_num_users;
        
        
        
        
        $products_count = get_number($user->products_count);
        $projects_views = get_number($user->projects_views);
        $projects_likes_count = get_number($user->projects_likes_count);
        $favorites_count = get_number($user->favorites_count);
        $sales_lifetime = get_number($user->sales_lifetime);
        
        
        if($products_count > 0) {
            $postsCoeffient = $aNumPost / get_number($user->products_count);
        } else {
            $postsCoeffient = $aNumPost;
        }
        
        if($projects_views > 0) {
            $viewsCoeffient = $aNumView / get_number($user->projects_views);
        } else {
            $viewsCoeffient = $aNumView;
        }
        
        if($projects_likes_count > 0) {
            $likesCoeffient = $aNumLike / get_number($user->projects_likes_count);
        } else {
            $likesCoeffient = $aNumLike;
        }
        
        if($favorites_count > 0) {
            $favCoeffient = $aNumFav / get_number($user->favorites_count);
        } else {
            $favCoeffient = $aNumFav;
        }
        
        if($sales_lifetime > 0) {
            $salesCoeffient = $aNumSale / get_number($user->sales_lifetime);
        } else {
            $salesCoeffient = $aNumSale;
        }
        
        
        
        

        $postWeighted = $postsCoeffient * 0.7;
        $viewsWeighted = $viewsCoeffient * 1.0;
        $likesWeighted = $likesCoeffient * 1.2;
        $favsWeighted =  $favCoeffient * 1.8;
        $salesWeighted = $salesCoeffient * 2.0;

        
        $rank = ($postWeighted + $viewsWeighted + $likesWeighted + $favsWeighted + $salesWeighted) / 5;
        
        return $rank;
        
    }
    
    
    
    
    
    
}