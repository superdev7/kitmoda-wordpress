<?php

//'collaboration_join_request'

class KSM_AccountModel extends KSM_BaseModel {
    
    
    
    
    

        
    public function filter_products_join($join, $inc) {
        global $wpdb;
        
        $user_id = get_current_user_id();
        $join .= " INNER JOIN {$wpdb->prefix}ksm_d_authors da on da.download_id = {$wpdb->posts}.ID AND da.user_id = '{$user_id}'";
        return $join;
    }
    
    
    
}