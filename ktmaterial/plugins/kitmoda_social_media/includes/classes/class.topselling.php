<?php

class KSM_TopSelling {
    
    
    
    
    
    static function get_results($user_id, $p = 0, $rpp = 0) {
        
        $args = array(
            'posts_per_page' => -1, 
            'post_type' => 'download', 
            
            'post_status'	  => 'publish',
            'author'	  => $user_id,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => '_edd_download_sales',
                    'value' => '0',
                    'compare' => '>'
                    )
                ),
            'orderby'      => 'meta_value',
            'order'        => 'DESC',
        );
        
        if($p && $rpp) {
            $args['paged'] = $p;
            $args['posts_per_page'] = $rpp;
        }
        
        $results = get_posts($args);
        
        return $results;
        
    }
    
    
    
}














?>