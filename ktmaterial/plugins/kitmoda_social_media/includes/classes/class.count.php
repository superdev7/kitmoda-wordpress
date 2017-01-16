<?php


class KSM_Count {
    
    
    
    
    
    static function user_collaboration_active_requests($user_id = 0) {
        
        global $wpdb;
        
        if(!$user_id) {
            return;
        }
        
        $q = "
            SELECT COUNT(res.ID) FROM (
                SELECT p.ID FROM ".$wpdb->posts." p 
                    INNER JOIN ".$wpdb->postmeta." AD mt0 ON (p.ID = mt0.post_id)
                    INNER JOIN ".$wpdb->postmeta." AS mt1 ON (p.ID = mt1.post_id) 
                WHERE p.post_type = 'collab_join_request' AND 
                    p.post_status = 'publish' AND 
                        ( (mt0.meta_key = 'request_status' AND 
                           mt0.meta_value  = 'active') AND 
                          (mt1.meta_key = 'collaboration_author' AND 
                           mt1.meta_value = '".$user_id."') ) 
                GROUP BY p.ID) as res";
        
        
        
        return $wpdb->get_var($q);
        
    }
    
    
    
    
    

    static function update_user_sale_stats($user_id) {
        $time = time();
        
        $year = date('Y', $time);
        $month = date('m', $time);
        
                
        $year_key = ksm_date_key($year);
        $month_key = ksm_date_key($year, $month);
        
        
        
        $sale_stats = self::user_sales($user_id);
        $year_sale_stats = self::user_year_sales($user_id, $year);
        $month_sale_stats = self::user_month_sales($user_id, $year, $month);
        
        //echo $user_id;
        //pr($sale_stats);
        
        
        update_user_meta($user_id, 'count_sales', $sale_stats['sales']);
        update_user_meta($user_id, 'count_revenue', $sale_stats['revenue']);
        update_user_meta($user_id, 'count_income', $sale_stats['income']);
        
        
        $current_dated_sales = (Array) get_user_meta($user_id, 'dated_sales', true);
        $current_dated_sales[$year_key] = $year_sale_stats;
        $current_dated_sales[$month_key] = $month_sale_stats;
        
        update_user_meta($user_id, 'dated_sales', $current_dated_sales);
    }
    
    
    
    static function user_sales($user_id) {
        
        $data = array('sales' => 0,'revenue' => 0, 'income' => 0);
        
        if(!$user_id) {
            return $data;
        }
        
        global $wpdb;
        
        
        $q = "SELECT COUNT(*) sales, SUM(pm.meta_value) revenue, SUM(pm3.meta_value) income FROM {$wpdb->posts} p
              INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
                INNER JOIN {$wpdb->postmeta} pm3 ON p.ID = pm3.post_id
                WHERE pm.meta_key = 'pd_download_author_%d_share'
                AND pm3.meta_key = 'pd_download_author_%d_income'
                AND p.post_status = 'publish' 
                AND p.post_type = 'ksm_p_download'";
        
        
              
        $result = $wpdb->get_row($wpdb->prepare($q, $user_id, $user_id));
        
        //echo $wpdb->last_query;
        //pr($result);
        if($result) {
            $data = array(
                'sales' => $result->sales ? $result->sales : 0,
                'revenue' => $result->revenue ? $result->revenue : 0,
                'income' => $result->income ? $result->income : 0
                );
        }
        
        return $data;
        
    }
    
    
    static function user_year_sales($user_id, $year) {
        
        $data = array('sales' => 0,'revenue' => 0, 'income' => 0);
        
        if(!$user_id) {
            return $data;
        }
        
        global $wpdb;
        
        
        $q = "SELECT COUNT(*) sales, SUM(pm.meta_value) revenue, SUM(pm3.meta_value) income FROM {$wpdb->posts} p
              INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
                INNER JOIN {$wpdb->postmeta} pm3 ON p.ID = pm3.post_id
                WHERE pm.meta_key = 'pd_download_author_%d_share'
                AND pm3.meta_key = 'pd_download_author_%d_income'
                AND p.post_status = 'publish' 
                AND YEAR(p.post_date) = '%d'
                AND p.post_type = 'ksm_p_download'";
        
        
              
        $result = $wpdb->get_row($wpdb->prepare($q, $user_id, $user_id, $year));
        if($result) {
            $data = array(
                'sales' => $result->sales ? $result->sales : 0,
                'revenue' => $result->revenue ? $result->revenue : 0,
                'income' => $result->income ? $result->income : 0
                );
        }
        
        return $data;
        
    }
    
    
    
    static function user_month_sales($user_id, $year, $month) {
        
        $data = array('sales' => 0,'revenue' => 0, 'income' => 0);
        
        if(!$user_id) {
            return $data;
        }
        
        global $wpdb;
        
        
        $q = "SELECT COUNT(*) sales, SUM(pm.meta_value) revenue, SUM(pm3.meta_value) income FROM {$wpdb->posts} p
              INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
                INNER JOIN {$wpdb->postmeta} pm3 ON p.ID = pm3.post_id
                WHERE pm.meta_key = 'pd_download_author_%d_share'
                AND pm3.meta_key = 'pd_download_author_%d_income'
                AND p.post_status = 'publish' 
                AND YEAR(p.post_date) = '%d' 
                AND MONTH(p.post_date) = '%d' 
                AND p.post_type = 'ksm_p_download'";
        
        
              
        $result = $wpdb->get_row($wpdb->prepare($q, $user_id, $user_id, $year, $month));
        if($result) {
            $data = array(
                'sales' => $result->sales ? $result->sales : 0,
                'revenue' => $result->revenue ? $result->revenue : 0,
                'income' => $result->income ? $result->income : 0
                );
        }
        
        return $data;
        
    }
    
    static function user_day_sales($user_id, $year, $month, $day) {
        
        $data = array('sales' => 0,'revenue' => 0, 'income' => 0);
        
        if(!$user_id) {
            return $data;
        }
        
        global $wpdb;
        
        
        $q = "SELECT COUNT(*) sales, SUM(pm.meta_value) revenue, SUM(pm3.meta_value) income FROM {$wpdb->posts} p
              INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
                INNER JOIN {$wpdb->postmeta} pm3 ON p.ID = pm3.post_id
                WHERE pm.meta_key = 'pd_download_author_%d_share'
                AND pm3.meta_key = 'pd_download_author_%d_income'
                AND p.post_status = 'publish' 
                AND YEAR(p.post_date) = '%d' 
                AND MONTH(p.post_date) = '%d' 
                AND DAY(p.post_date) = '%d' 
                AND p.post_type = 'ksm_p_download'";
        
        
              
        $result = $wpdb->get_row($wpdb->prepare($q, $user_id, $user_id, $year, $month, $day));
        if($result) {
            $data = array(
                'sales' => $result->sales ? $result->sales : 0,
                'revenue' => $result->revenue ? $result->revenue : 0,
                'income' => $result->income ? $result->income : 0
                );
        }
        
        return $data;
        
    }
    /////////////////////////////////////////////////////////////////////////////
    
    static function user_models($user_id) {
        if(!$user_id) {
            return '0';
        }
        
        global $wpdb;
        $q = "SELECT COUNT(*) FROM {$wpdb->prefix}ksm_d_authors da
              INNER JOIN {$wpdb->posts} p on p.ID = da.download_id
              WHERE p.post_status = 'publish' AND da.user_id = '%d'";
              
        $result = $wpdb->get_var($wpdb->prepare($q, $user_id));
        return ($result ? $result : '0');
        
    }
    
    static function user_textured_models($user_id) {
        if(!$user_id) {
            return '0';
        }
        
        global $wpdb;
        $q = "SELECT COUNT(*) FROM {$wpdb->prefix}ksm_d_authors da
              INNER JOIN {$wpdb->posts} p on p.ID = da.download_id
              INNER JOIN {$wpdb->postmeta} pm on p.ID = pm.post_id and meta_key = 'is_textured'
              WHERE p.post_status = 'publish' AND da.user_id = '%d' AND meta_value = 'yes'";
        
        $result = $wpdb->get_var($wpdb->prepare($q, $user_id));
        return ($result ? $result : '0');
    }
    
    static function user_untextured_models($user_id){
        if(!$user_id) {
            return '0';
        }
        global $wpdb;
        $q = "SELECT COUNT(*) FROM {$wpdb->prefix}ksm_d_authors da
              INNER JOIN {$wpdb->posts} p on p.ID = da.download_id
              INNER JOIN {$wpdb->postmeta} pm on p.ID = pm.post_id and meta_key = 'is_untextured'
              WHERE p.post_status = 'publish' AND da.user_id = '%d' AND meta_value = 'yes'";
        $result = $wpdb->get_var($wpdb->prepare($q, $user_id));
        return ($result ? $result : '0');
    }
    static function user_solo_models($user_id){
        if(!$user_id) {
            return '0';
        }
        global $wpdb;
        $q = "SELECT COUNT(*) FROM {$wpdb->prefix}ksm_d_authors da
              INNER JOIN {$wpdb->posts} p on p.ID = da.download_id
              INNER JOIN {$wpdb->postmeta} pm on p.ID = pm.post_id and meta_key = 'is_solo'
              WHERE p.post_status = 'publish' AND da.user_id = '%d' AND meta_value = 'yes'";
        $result = $wpdb->get_var($wpdb->prepare($q, $user_id));
        return ($result ? $result : '0');
    }
    static function user_solo_textured_models($user_id){
        if(!$user_id) {
            return '0';
        }
        global $wpdb;
        $q = "SELECT COUNT(*) FROM {$wpdb->prefix}ksm_d_authors da
              INNER JOIN {$wpdb->posts} p on p.ID = da.download_id
              INNER JOIN {$wpdb->postmeta} pm on p.ID = pm.post_id and meta_key = 'is_solo_textured'
              WHERE p.post_status = 'publish' AND da.user_id = '%d' AND meta_value = 'yes'";
        $result = $wpdb->get_var($wpdb->prepare($q, $user_id));
        return ($result ? $result : '0');
    }
    static function user_solo_untextured_models($user_id){
        if(!$user_id) {
            return '0';
        }
        global $wpdb;
        $q = "SELECT COUNT(*) FROM {$wpdb->prefix}ksm_d_authors da
              INNER JOIN {$wpdb->posts} p on p.ID = da.download_id
              INNER JOIN {$wpdb->postmeta} pm on p.ID = pm.post_id and meta_key = 'is_solo_untextured'
              WHERE p.post_status = 'publish' AND da.user_id = '%d' AND meta_value = 'yes'";
        $result = $wpdb->get_var($wpdb->prepare($q, $user_id));
        return ($result ? $result : '0');
    }
    static function user_collaboration_models($user_id){
        if(!$user_id) {
            return '0';
        }
        global $wpdb;
        $q = "SELECT COUNT(*) FROM {$wpdb->prefix}ksm_d_authors da
              INNER JOIN {$wpdb->posts} p on p.ID = da.download_id
              INNER JOIN {$wpdb->postmeta} pm on p.ID = pm.post_id and meta_key = 'is_collaboration'
              WHERE p.post_status = 'publish' AND da.user_id = '%d' AND meta_value = 'yes'";
        $result = $wpdb->get_var($wpdb->prepare($q, $user_id));
        return ($result ? $result : '0');
    }
    static function user_collaboration_textured_models($user_id){
        if(!$user_id) {
            return '0';
        }
        global $wpdb;
        $q = "SELECT COUNT(*) FROM {$wpdb->prefix}ksm_d_authors da
              INNER JOIN {$wpdb->posts} p on p.ID = da.download_id
              INNER JOIN {$wpdb->postmeta} pm on p.ID = pm.post_id and meta_key = 'is_collaboration_textured'
              WHERE p.post_status = 'publish' AND da.user_id = '%d' AND meta_value = 'yes'";
        $result = $wpdb->get_var($wpdb->prepare($q, $user_id));
        return ($result ? $result : '0');
    }
    static function user_collaboration_untextured_models($user_id){
        if(!$user_id) {
            return '0';
        }
        global $wpdb;
        $q = "SELECT COUNT(*) FROM {$wpdb->prefix}ksm_d_authors da
              INNER JOIN {$wpdb->posts} p on p.ID = da.download_id
              INNER JOIN {$wpdb->postmeta} pm on p.ID = pm.post_id and meta_key = 'is_collaboration_untextured'
              WHERE p.post_status = 'publish' AND da.user_id = '%d' AND meta_value = 'yes'";
        $result = $wpdb->get_var($wpdb->prepare($q, $user_id));
        return ($result ? $result : '0');
    }
    
    
    /////////////////////////////////////////////////////////////////////////
    
    
    
    
    static function user_models_rating($user_id) {
        if(!$user_id) {
            return '0';
        }
        
        global $wpdb;
        $q = "SELECT AVG(pm2.meta_value) FROM {$wpdb->prefix}ksm_d_authors da
              INNER JOIN {$wpdb->posts} p on p.ID = da.download_id 
              INNER JOIN {$wpdb->postmeta} pm2 on p.ID = pm2.post_id and pm2.meta_key = 'product_rating' 
              WHERE p.post_status = 'publish' AND da.user_id = '%d'";
              
        $result = $wpdb->get_var($wpdb->prepare($q, $user_id));
        return ($result ? $result : '0');
    }
    
    static function user_textured_models_rating($user_id) {
        if(!$user_id) {
            return '0';
        }
        
        global $wpdb;
        $q = "SELECT AVG(pm2.meta_value) FROM {$wpdb->prefix}ksm_d_authors da
              INNER JOIN {$wpdb->posts} p on p.ID = da.download_id
              INNER JOIN {$wpdb->postmeta} pm on p.ID = pm.post_id and pm.meta_key = 'is_textured' 
              INNER JOIN {$wpdb->postmeta} pm2 on p.ID = pm2.post_id and pm2.meta_key = 'product_rating' 
              WHERE p.post_status = 'publish' AND da.user_id = '%d' AND pm.meta_value = 'yes'";
        
        $result = $wpdb->get_var($wpdb->prepare($q, $user_id));
        return ($result ? $result : '0');
    }
    
    static function user_untextured_models_rating($user_id){
        if(!$user_id) {
            return '0';
        }
        global $wpdb;
        $q = "SELECT AVG(pm2.meta_value) FROM {$wpdb->prefix}ksm_d_authors da
              INNER JOIN {$wpdb->posts} p on p.ID = da.download_id
              INNER JOIN {$wpdb->postmeta} pm on p.ID = pm.post_id and pm.meta_key = 'is_untextured' 
              INNER JOIN {$wpdb->postmeta} pm2 on p.ID = pm2.post_id and pm2.meta_key = 'product_rating' 
              WHERE p.post_status = 'publish' AND da.user_id = '%d' AND pm.meta_value = 'yes'";
        $result = $wpdb->get_var($wpdb->prepare($q, $user_id));
        return ($result ? $result : '0');
    }
    static function user_solo_models_rating($user_id){
        if(!$user_id) {
            return '0';
        }
        global $wpdb;
        $q = "SELECT AVG(pm2.meta_value) FROM {$wpdb->prefix}ksm_d_authors da
              INNER JOIN {$wpdb->posts} p on p.ID = da.download_id
              INNER JOIN {$wpdb->postmeta} pm on p.ID = pm.post_id and pm.meta_key = 'is_solo' 
              INNER JOIN {$wpdb->postmeta} pm2 on p.ID = pm2.post_id and pm2.meta_key = 'product_rating' 
              WHERE p.post_status = 'publish' AND da.user_id = '%d' AND pm.meta_value = 'yes'";
        $result = $wpdb->get_var($wpdb->prepare($q, $user_id));
        return ($result ? $result : '0');
    }
    static function user_solo_textured_models_rating($user_id){
        if(!$user_id) {
            return '0';
        }
        global $wpdb;
        $q = "SELECT AVG(pm2.meta_value) FROM {$wpdb->prefix}ksm_d_authors da
              INNER JOIN {$wpdb->posts} p on p.ID = da.download_id
              INNER JOIN {$wpdb->postmeta} pm on p.ID = pm.post_id and pm.meta_key = 'is_solo_textured'
              INNER JOIN {$wpdb->postmeta} pm2 on p.ID = pm2.post_id and pm2.meta_key = 'product_rating' 
              WHERE p.post_status = 'publish' AND da.user_id = '%d' AND pm.meta_value = 'yes'";
        $result = $wpdb->get_var($wpdb->prepare($q, $user_id));
        return ($result ? $result : '0');
    }
    static function user_solo_untextured_models_rating($user_id){
        if(!$user_id) {
            return '0';
        }
        global $wpdb;
        $q = "SELECT AVG(pm2.meta_value) FROM {$wpdb->prefix}ksm_d_authors da
              INNER JOIN {$wpdb->posts} p on p.ID = da.download_id
              INNER JOIN {$wpdb->postmeta} pm on p.ID = pm.post_id and pm.meta_key = 'is_solo_untextured'
              INNER JOIN {$wpdb->postmeta} pm2 on p.ID = pm2.post_id and pm2.meta_key = 'product_rating' 
              WHERE p.post_status = 'publish' AND da.user_id = '%d' AND pm.meta_value = 'yes'";
        $result = $wpdb->get_var($wpdb->prepare($q, $user_id));
        return ($result ? $result : '0');
    }
    static function user_collaboration_models_rating($user_id){
        if(!$user_id) {
            return '0';
        }
        global $wpdb;
        $q = "SELECT AVG(pm2.meta_value) FROM {$wpdb->prefix}ksm_d_authors da
              INNER JOIN {$wpdb->posts} p on p.ID = da.download_id
              INNER JOIN {$wpdb->postmeta} pm on p.ID = pm.post_id and pm.meta_key = 'is_collaboration'
              INNER JOIN {$wpdb->postmeta} pm2 on p.ID = pm2.post_id and pm2.meta_key = 'product_rating' 
              WHERE p.post_status = 'publish' AND da.user_id = '%d' AND pm.meta_value = 'yes'";
        $result = $wpdb->get_var($wpdb->prepare($q, $user_id));
        return ($result ? $result : '0');
    }
    static function user_collaboration_textured_models_rating($user_id){
        if(!$user_id) {
            return '0';
        }
        global $wpdb;
        $q = "SELECT AVG(pm2.meta_value) FROM {$wpdb->prefix}ksm_d_authors da
              INNER JOIN {$wpdb->posts} p on p.ID = da.download_id
              INNER JOIN {$wpdb->postmeta} pm on p.ID = pm.post_id and pm.meta_key = 'is_collaboration_textured'
              INNER JOIN {$wpdb->postmeta} pm2 on p.ID = pm2.post_id and pm2.meta_key = 'product_rating' 
              WHERE p.post_status = 'publish' AND da.user_id = '%d' AND pm.meta_value = 'yes'";
        $result = $wpdb->get_var($wpdb->prepare($q, $user_id));
        return ($result ? $result : '0');
    }
    static function user_collaboration_untextured_models_rating($user_id){
        if(!$user_id) {
            return '0';
        }
        global $wpdb;
        $q = "SELECT AVG(pm2.meta_value) FROM {$wpdb->prefix}ksm_d_authors da
              INNER JOIN {$wpdb->posts} p on p.ID = da.download_id
              INNER JOIN {$wpdb->postmeta} pm on p.ID = pm.post_id and pm.meta_key = 'is_collaboration_untextured'
              INNER JOIN {$wpdb->postmeta} pm2 on p.ID = pm2.post_id and pm2.meta_key = 'product_rating' 
              WHERE p.post_status = 'publish' AND da.user_id = '%d' AND pm.meta_value = 'yes'";
        $result = $wpdb->get_var($wpdb->prepare($q, $user_id));
        return ($result ? $result : '0');
    }
    
    
    
    
    /////////////////////////////////////////////////////////////////////////
    
    
    static function user_c_artwork_rating($user_id) {
        if(!$user_id) {
            return '0';
        }
        
        global $wpdb;
        $q = "SELECT FORMAT(AVG(r.artwork_rating) ,2) from {$wpdb->prefix}ksm_c_ratings r where r.rate_to = '{$user_id}'";
        $result = $wpdb->get_var($q);
        return ($result ? $result : '0');
    }
    
    
    static function user_c_communication_rating($user_id) {
        if(!$user_id) {
            return '0';
        }
        
        global $wpdb;
        $q = "SELECT FORMAT(AVG(r.communication_rating) ,2) from {$wpdb->prefix}ksm_c_ratings r where r.rate_to = '{$user_id}'";
        $result = $wpdb->get_var($q);
        return ($result ? $result : '0');
    }
    
    
    
    
    static function user_c_artwork_rating_collaborations($user_id) {
        if(!$user_id) {
            return '0';
        }
        
        global $wpdb;
        $q = "SELECT COUNT(id) from {$wpdb->prefix}ksm_c_ratings r where r.rate_to = '{$user_id}' GROUP BY rate_to";
        $result = $wpdb->get_var($q);
        return ($result ? $result : '0');
    }
    
    
    static function user_c_communication_rating_collaborations($user_id) {
        if(!$user_id) {
            return '0';
        }
        
        global $wpdb;
        $q = "SELECT COUNT(id) from {$wpdb->prefix}ksm_c_ratings r where r.rate_to = '{$user_id}' GROUP BY rate_to";
        $result = $wpdb->get_var($q);
        return ($result ? $result : '0');
    }
    
    
    
    static function user_collaboration_ratings($user_id) {
        if(!$user_id) {
            return '0';
        }
        
        global $wpdb;
        $q = "SELECT COUNT(id) from {$wpdb->prefix}ksm_c_ratings r where r.rate_to = '{$user_id}' GROUP BY rate_to";
        $result = $wpdb->get_var($q);
        return ($result ? $result : '0');
    }
    
    
    static function set_post_views($postID) {
        
        $user_ip = get_the_user_ip();
        $key = $user_ip . '_views';// . $postID;
        $value = array($user_ip, $postID);
        $visited = get_transient($key);

    
        if ( false === ( $visited ) ) {
            set_transient( $key, $value, 60*60*24 );
            $count_key = 'views';
            $count = get_post_meta($postID, $count_key, true);
            if($count==''){
                $count = 0;
                delete_post_meta($postID, $count_key);
                add_post_meta($postID, $count_key, '0');
            }else{
                $count++;
                update_post_meta($postID, $count_key, $count);
            }


        }
        
    }
    
    
    static function update_product_sale_stats($download_id, $payment_id) {
        
        
        $download = new KSM_Download($download_id);
        
        
        $payment = get_post($payment_id);
        
        
        
        $year = date('Y', strtotime($payment->post_date));
        $month = date('m', strtotime($payment->post_date));
        
        $year_key = ksm_date_key($year);
        $month_key = ksm_date_key($year, $month);
        
    
        
        $total_stats = self::product_sales($download_id);
        $download->update_meta('sales', $total_stats['sales']);
        $download->update_meta('revenue', $total_stats['revenue']);
        
        
        //$year_stats = self::product_sales_of_year($download_id, $year);
        //$month_stats = self::product_sales_of_month($download_id, $year, $month);
        
        
        
        $authors = $download->authors();
        
        $author_stats = array();
        
        foreach($authors as $a) {
            //$share_per_sale = $download->author_price_share($a);
            //$income_per_sale = $download->author_income_per_sale($a);
            
            $author_stats = self::product_author_sales($download_id, $a);
            
            $download->update_meta("download_author_{$a}_sales", $author_stats['sales']);
            $download->update_meta("download_author_{$a}_revenue", $author_stats['revenue']);
            $download->update_meta("download_author_{$a}_income", $author_stats['income']);
            
            $author_dated_stats_key = "download_author_{$a}_dated_stats";
            
            $author_dated_stats = (Array) $download->{$author_dated_stats_key};
            
            
            $author_month_stats = self::product_author_sales_of_month($download_id, $a, $year, $month);
            
            $author_dated_stats[$month_key] = $author_month_stats;
            
            $download->update_meta($author_dated_stats_key, $author_dated_stats);
            
            
            
            
            /*
            $author_stats[$a] = array(
                'revenue' => $total_stats['sales'] * $share_per_sale,
                'income' => $total_stats['sales'] * $income_per_sale,
                'dated_stats' => array(
                    $year_key => array(
                        'revenue'=> $year_stats['sales'] * $share_per_sale,
                        'income'=> $year_stats['sales'] * $income_per_sale
                    ),
                    $month_key => array(
                        'revenue'=> $month_stats['sales'] * $share_per_sale,
                        'income'=> $month_stats['sales'] * $income_per_sale
                    ),
                )
            );
            */
            
        }
        
        //pr($author_stats);
        //$revenue = $sales * $download->price();
        //$year_revenue = $year_sales * $download->price();
        //$month_revenue = $month_sales * $download->price();
        
        
        //update_post_meta($download_id, 'revenue', $total_stats['revenue']);
        //update_post_meta($download_id, 'sales', $total_stats['sales']);
    }
    
    
    
    
    
    static function product_sales($download_id) {
        
        $data = array('sales' => 0,'revenue' => 0);
        
        if(!$download_id) {
            return $data ;
        }
        

        global $wpdb;
        
        
              
        
        $q = "SELECT COUNT(p.ID) sales, sum(pm2.meta_value) revenue FROM {$wpdb->posts} p 
              INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID 
              INNER JOIN {$wpdb->postmeta} pm2 ON pm2.post_id = p.ID 
              WHERE pm2.meta_key = 'subtotal' AND pm.meta_key = 'download_id' 
              AND pm.meta_value = '%d' AND p.post_type = 'ksm_p_download' 
              AND p.post_status = 'publish' GROUP BY pm.meta_value";
        
        
        $result = $wpdb->get_row($wpdb->prepare($q, $download_id));
        
        
        if($result) {
            $data = array(
                'sales' => $result->sales ? $result->sales : 0,
                'revenue' => $result->revenue ? $result->revenue : 0
                );
        }
        
        return $data;
        
    }
    
    
    
    static function product_author_sales($download_id, $author) {
        
        $data = array('sales' => 0,'revenue' => 0, 'income' => 0);
        
        if(!$download_id) {
            return $data ;
        }
        

        global $wpdb;
        
        $q = "SELECT COUNT(*) sales, SUM(pm.meta_value) revenue, SUM(pm3.meta_value) income FROM {$wpdb->posts} p
              INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
              INNER JOIN {$wpdb->postmeta} pm2 ON p.ID = pm2.post_id
              INNER JOIN {$wpdb->postmeta} pm3 ON p.ID = pm3.post_id
              WHERE pm.meta_key = 'pd_download_author_%d_share'
              AND pm3.meta_key = 'pd_download_author_%d_income'
              AND p.post_status = 'publish' AND p.post_type = 'ksm_p_download'
              AND pm2.meta_key = 'download_id' AND pm2.meta_value = '%d'";
        
        
              
        
        $result = $wpdb->get_row($wpdb->prepare($q, $author, $author , $download_id));
        
        
        if($result) {
            $data = array(
                'sales' => $result->sales ? $result->sales : 0,
                'revenue' => $result->revenue ? $result->revenue : 0,
                'income' => $result->income ? $result->income : 0
                );
        }
        
        return $data;
        
    }
    
    
    static function author_sales($author) {
        
        $data = array('sales' => 0,'revenue' => 0, 'income' => 0);
        
        if(!$download_id) {
            return $data ;
        }
        

        global $wpdb;
        
        $q = "SELECT COUNT(*) sales, SUM(pm.meta_value) revenue, SUM(pm3.meta_value) income FROM {$wpdb->posts} p
              INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
              INNER JOIN {$wpdb->postmeta} pm3 ON p.ID = pm3.post_id
              WHERE pm.meta_key = 'pd_download_author_%d_share'
              AND pm3.meta_key = 'pd_download_author_%d_income'
              AND p.post_status = 'publish' AND p.post_type = 'ksm_p_download'";
        
        
              
        
        $result = $wpdb->get_row($wpdb->prepare($q, $author, $author));
        
        
        if($result) {
            $data = array(
                'sales' => $result->sales ? $result->sales : 0,
                'revenue' => $result->revenue ? $result->revenue : 0,
                'income' => $result->income ? $result->income : 0
                );
        }
        
        return $data;
        
    }
    
    
    static function product_sales_of_year($download_id, $year) {
        
        if(!$download_id) {
            return '0';
        }
        
        global $wpdb;
        
        $q = "SELECT COUNT(p.ID) sales, sum(pm2.meta_value) revenue FROM {$wpdb->posts} p 
              INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID 
              INNER JOIN {$wpdb->postmeta} pm2 ON pm2.post_id = p.ID 
              WHERE pm2.meta_key = 'subtotal' AND pm.meta_key = 'download_id' AND pm.meta_value = '%d' 
              AND p.post_type = 'ksm_p_download' AND YEAR(p.post_date) = '%d' 
              AND p.post_status = 'publish' GROUP BY pm.meta_value";
        
        $result = $wpdb->get_row($wpdb->prepare($q, $download_id, $year));
        
        if($result) {
            $data = array(
                'sales' => $result->sales ? $result->sales : 0,
                'revenue' => $result->revenue ? $result->revenue : 0
                );
        }
        
        return $data;
    }
    
    
    static function product_author_sales_of_month($download_id, $author , $year, $month) {
        
        $data = array('sales' => 0,'revenue' => 0, 'income' => 0);
        
        if(!$download_id) {
            return $data;
        }
        
        global $wpdb;
        
        
        $q = "SELECT COUNT(*) sales, SUM(pm.meta_value) revenue, SUM(pm3.meta_value) income FROM {$wpdb->posts} p
              INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
              INNER JOIN {$wpdb->postmeta} pm2 ON p.ID = pm2.post_id
              INNER JOIN {$wpdb->postmeta} pm3 ON p.ID = pm3.post_id
              WHERE pm.meta_key = 'pd_download_author_%d_share'
              AND pm3.meta_key = 'pd_download_author_%d_income'
              AND p.post_status = 'publish' AND p.post_type = 'ksm_p_download'
              AND YEAR(p.post_date) = '%d' AND MONTH(p.post_date) = '%d'
              AND pm2.meta_key = 'download_id' AND pm2.meta_value = '%d'";
        
        
        $result = $wpdb->get_row($wpdb->prepare($q, $author, $author, $year, $month, $download_id));
        
        
        if($result) {
            $data = array(
                'sales' => $result->sales ? $result->sales : 0,
                'revenue' => $result->revenue ? $result->revenue : 0,
                'income' => $result->income ? $result->income : 0
                );
        }
        
        return $data;
    }

    
    
    
    
    
    static function user_total_purchases($user_id) {
        
        if(!$user_id) {
            return '0';
        }
        
        global $wpdb;
        $q = "SELECT count(*) FROM {$wpdb->posts} WHERE post_type = 'ksm_p_download' AND post_author = '{$user_id}' AND post_status = 'publish'";
        $result = $wpdb->get_var($q);
        return ($result ? $result : '0');
    }
    
    
    
    static function user_textured_purchases($user_id) {
        
        if(!$user_id) {
            return '0';
        }
        
        global $wpdb;
        
        $q = "SELECT count(*) FROM {$wpdb->posts} p 
                INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID WHERE 
                    pm.meta_key = 'model_type' AND 
                    pm.meta_value = 'textured' AND 
                    p.post_type = 'ksm_p_download' AND 
                    p.post_author = '{$user_id}' AND 
                    p.post_status = 'publish'";
        
        
        
        $result = $wpdb->get_var($q);
        return ($result ? $result : '0');
    }
    
    
    static function user_untextured_purchases($user_id) {
        
        if(!$user_id) {
            return '0';
        }
        
        global $wpdb;
        
        $q = "SELECT count(*) FROM {$wpdb->posts} p 
                INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID WHERE 
                    pm.meta_key = 'model_type' AND 
                    pm.meta_value = 'untextured' AND 
                    p.post_type = 'ksm_p_download' AND 
                    p.post_author = '{$user_id}' AND 
                    p.post_status = 'publish'";
        
        
        
        $result = $wpdb->get_var($q);
        return ($result ? $result : '0');
    }
    
    
    
    static function user_total_purchased_amount($user_id) {
        
        
        if(!$user_id) {
            return '0';
        }
        
        global $wpdb;
        
        $q = "SELECT SUM(pm.meta_value) FROM {$wpdb->postmeta} pm 
            INNER JOIN {$wpdb->posts} p ON pm.post_id = p.ID WHERE 
            pm.meta_key = 'subtotal' AND 
            p.post_type = 'ksm_p_download' AND 
            p.post_author = '{$user_id}' AND 
            p.post_status = 'publish';";
        
        $result = $wpdb->get_var($q);
        return ($result ? $result : '0');
    }
    
    
    
    
    static function user_year_purchased_amount($user_id, $year) {
        
        if(!$user_id) {
            return '0';
        }
        
        global $wpdb;
        
        $q = "SELECT SUM(pm.meta_value) FROM {$wpdb->postmeta} pm 
            INNER JOIN {$wpdb->posts} p ON pm.post_id = p.ID WHERE 
            pm.meta_key = 'subtotal' AND 
            p.post_type = 'ksm_p_download' AND 
            p.post_author = '{$user_id}' AND 
            YEAR(p.post_date) = '{$year}' AND
            p.post_status = 'publish'";
        
        $result = $wpdb->get_var($q);
        return ($result ? $result : '0');
        
        
    }
    
    static function user_month_purchased_amount($user_id, $year, $month){
        if(!$user_id) {
            return '0';
        }
        
        global $wpdb;
        
        $q = "SELECT SUM(pm.meta_value) FROM {$wpdb->postmeta} pm 
            INNER JOIN {$wpdb->posts} p ON pm.post_id = p.ID WHERE 
            pm.meta_key = 'subtotal' AND 
            p.post_type = 'ksm_p_download' AND 
            p.post_author = '{$user_id}' AND 
            YEAR(p.post_date) = '{$year}' AND 
            MONTH(p.post_date) = '{$month}' AND
            p.post_status = 'publish';";
        
        $result = $wpdb->get_var($q);
        return ($result ? $result : '0');
    }
    
    
    
    static function update_user_year_purchased_amount($user_id, $year){
        $amount = self::user_year_purchased_amount($user_id, $year);
        $meta_data = (Array) get_user_meta($user_id, 'dated_purchases', true);
        $meta_data['year'][$year] = $amount;
        update_user_meta($user_id, 'dated_purchases', $meta_data);
    }
    
    static function update_user_month_purchased_amount($user_id, $year, $month){
        $amount = self::user_month_purchased_amount($user_id, $year, $month);
        $meta_data = (Array) get_user_meta($user_id, 'dated_purchases', true);
        $_name = "{$year}_{$month}";
        $meta_data['month'][$_name] = $amount;
        update_user_meta($user_id, 'dated_purchases', $meta_data);
    }
    
    
    
    static function user_concept_rating($user_id) {
        
        if(!$user_id) {
            return;
        }
        
        global $wpdb;
        
        $q = "SELECT AVG(score) FROM {$wpdb->prefix}ksm_d_ratings 
            WHERE user_rate_key = 'concept_{$user_id}' GROUP BY user_rate_key";
        
        return $wpdb->get_var($q);
    }
    
    static function user_model_rating($user_id) {
        
        if(!$user_id) {
            return;
        }
        
        global $wpdb;
        
        $q = "SELECT AVG(score) FROM {$wpdb->prefix}ksm_d_ratings 
            WHERE user_rate_key = 'model_{$user_id}' GROUP BY user_rate_key";
        
        return $wpdb->get_var($q);
    }
    
    static function user_texture_rating($user_id) {
        
        if(!$user_id) {
            return;
        }
        
        global $wpdb;
        
        $q = "SELECT AVG(score) FROM {$wpdb->prefix}ksm_d_ratings 
            WHERE user_rate_key = 'texture_{$user_id}' GROUP BY user_rate_key";
        
        return $wpdb->get_var($q);
    }
    
    
    static function user_solo_rating($user_id) {
        
        if(!$user_id) {
            return;
        }
        
        global $wpdb;
        
        $q = "SELECT AVG(score) FROM {$wpdb->prefix}ksm_d_ratings 
            WHERE user_rate_key = 'solo_{$user_id}' GROUP BY user_rate_key";
        
        return $wpdb->get_var($q);
    }
    
    static function user_contribution_rating($user_id) {
        
        if(!$user_id) {
            return;
        }
        
        global $wpdb;
        
        $q = "SELECT AVG(score) FROM {$wpdb->prefix}ksm_d_ratings 
            WHERE user_rate_key = 'role_{$user_id}' GROUP BY user_rate_key";
        
        return $wpdb->get_var($q);
    }
    
    
    static function user_team_rating($user_id) {
        if(!$user_id) {
            return;
        }
        
        global $wpdb;
        
        $q = "SELECT AVG(score) FROM {$wpdb->prefix}ksm_d_ratings 
            WHERE user_rate_key = 'team_{$user_id}' GROUP BY user_rate_key";
        
        return $wpdb->get_var($q);
    }
    
    static function user_maintained_asset_rating($user_id) {
        if(!$user_id) {
            return;
        }
        
        global $wpdb;
        
        $q = "SELECT AVG(score) FROM {$wpdb->prefix}ksm_d_ratings 
            WHERE user_rate_key = 'maintenance_{$user_id}' GROUP BY user_rate_key";
        
        return $wpdb->get_var($q);
    }
    
    
    
    function user_solo_rating_products($user_id) {
        if(!$user_id) {
            return;
        }
        
        global $wpdb;
    
        
        $q = "SELECT COUNT(*) FROM (
            SELECT COUNT(id) FROM {$wpdb->prefix}ksm_d_ratings 
            WHERE user_rate_key = 'solo_{$user_id}' GROUP BY download_id
            ) as rows";
        
        return $wpdb->get_var($q);
    }
    
    
    function user_team_rating_products($user_id) {
        if(!$user_id) {
            return;
        }
        
        global $wpdb;
        
        $q = "SELECT COUNT(*) FROM (
            SELECT COUNT(id) FROM {$wpdb->prefix}ksm_d_ratings 
            WHERE user_rate_key = 'team_{$user_id}' GROUP BY download_id
            ) as rows";
        
        return $wpdb->get_var($q);
    }
    
    
    function user_contribution_rating_products($user_id) {
        if(!$user_id) {
            return;
        }
        
        global $wpdb;
        
        $q = "SELECT COUNT(*) FROM (
            SELECT COUNT(id) FROM {$wpdb->prefix}ksm_d_ratings 
            WHERE user_rate_key = 'role_{$user_id}' GROUP BY download_id
            ) as rows";
        
        return $wpdb->get_var($q);
    }
    
    
    function user_concept_rating_products($user_id) {
        if(!$user_id) {
            return;
        }
        
        global $wpdb;
        
        $q = "SELECT COUNT(*) FROM (
            SELECT COUNT(id) FROM {$wpdb->prefix}ksm_d_ratings 
            WHERE user_rate_key = 'concept_{$user_id}' GROUP BY download_id
            ) as rows";
        
        return $wpdb->get_var($q);
    }
    
    function user_model_rating_products($user_id) {
        if(!$user_id) {
            return;
        }
        
        global $wpdb;
        
        $q = "SELECT COUNT(*) FROM (
            SELECT COUNT(id) FROM {$wpdb->prefix}ksm_d_ratings 
            WHERE user_rate_key = 'model_{$user_id}' GROUP BY download_id
            ) as rows";
        
        return $wpdb->get_var($q);
    }
    
    function user_texture_rating_products($user_id) {
        if(!$user_id) {
            return;
        }
        
        global $wpdb;
        
        $q = "SELECT COUNT(*) FROM (
            SELECT COUNT(id) FROM {$wpdb->prefix}ksm_d_ratings 
            WHERE user_rate_key = 'texture_{$user_id}' GROUP BY download_id
            ) as rows";
        
        return $wpdb->get_var($q);
    }
    
    
    
    
    
    function user_maintained_asset_rating_products($user_id) {
        if(!$user_id) {
            return;
        }
        
        global $wpdb;
        
        $q = "SELECT COUNT(*) FROM (
            SELECT COUNT(id) FROM {$wpdb->prefix}ksm_d_ratings 
            WHERE user_rate_key = 'maintenance_{$user_id}' GROUP BY download_id
            ) as rows";
        
        return $wpdb->get_var($q);
    }
    
    
    
    
    static function __callStatic($name, $arguments) {
        
        
        
        
        //echo $name . '<br >';
        
        if(substr($name, 0, 7) == 'update_' || substr($name, 0, 8) == '_update_') {
            
            $meta_prefix = '';
            if(substr($name, 0, 7) == 'update_') {
                $meta_prefix = 'count_';
                $method = substr($name, 7);
            } else {
                $method = substr($name, 8);
            }
            
            
            $result = call_user_func_array(array(self, $method), $arguments);
            
            if(substr($method, 0, 5) == 'user_') {
                $meta_key = $meta_prefix . substr($method, 5);
                //echo $arguments[0], $meta_key, $result. "<br>";
                update_user_meta($arguments[0], $meta_key, $result);
            } else {
                $meta_key = $meta_prefix . $method;
                update_post_meta($arguments[0], $meta_key, $result);
            }
            
        }
        
    }
    
}


?>
