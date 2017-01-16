<?php




class KSM_Image {
    
    
    
    static $_41X41 = 'avatar_tiny';
    static $_62X62 = 'avatar_small';
    static $_72X72 = 'avatar_small_2';
    static $_135X135 = 'avatar_large';
    static $_344X246 = 'favorite_large';
    static $_9999999X196 = 'gallery_grid';
    static $_675X9999999 = 'wall_full';
    static $_240X140 = 'community_post';
    
    
    
    
    

    
    static function post_thumb($post, $size) {
        $src = "";
        if($post && $post->_thumbnail_id) {
            $image = wp_get_attachment_image_src($post->_thumbnail_id, $size);
            $src = $image[0];
        }
        
        return $src;
    }
}