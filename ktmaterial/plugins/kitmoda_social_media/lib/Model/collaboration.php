<?php

//'collaboration_join_request'

class KSM_CollaborationModel extends KSM_BaseModel {
    
    
    public $collaboration_types = array('concept', 'untextured'),

        $post_type = 'ksm_collaboration';
    
    
    function filter_join($join, $inc) {
        global $wpdb;
        
        $ratings = (Array) $inc->query['ratings'];
        
        
        $artwork_rating = is_numeric($ratings['artwork']) && $ratings['artwork'] > 0 ? $ratings['artwork'] : '' ; 
        $communication_rating = is_numeric($ratings['communication']) && $ratings['communication'] > 0 ? $ratings['communication'] : '' ; 
        
        $artwork_rating = sanitize_text_field($artwork_rating);
        $communication_rating = sanitize_text_field($communication_rating);
        
        
        if($communication_rating) {
            $join .= " INNER JOIN {$wpdb->usermeta} as _usr ON _usr.user_id = {$wpdb->posts}.post_author 
                  AND _usr.meta_key='c_communication_rating' AND _usr.meta_value >= '{$communication_rating}'";
        }
        
        if($artwork_rating) {
            $join .= " INNER JOIN {$wpdb->usermeta} as _usr2 ON _usr2.user_id = {$wpdb->posts}.post_author 
                  AND _usr2.meta_key='c_artwork_rating' AND _usr2.meta_value >= '{$artwork_rating}'";
        }
            
        
        
        
        return $join;
    }
    
}