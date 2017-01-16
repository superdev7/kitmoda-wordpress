<?php

class KSM_Wall {
    
    
    static function post() {
        global  $user_ID;
        
        
        $post_content = sanitize_text_field($_POST['post_content']);
        //$wall_id = $_POST['wall_id'];
        
        $images = (Array) $_POST['multi_images'];
        
        if(!$user_ID) {
            $error = "You are not allowed to post here";
        } elseif(!$post_content && empty($images)) {
            $error = "Please write something or attach a photo";
        }
        
        
        $finial_images = array();
        
        foreach($images as $img) {
            if($img) {
                $img_attachment = get_post($img);
                
                if(ksm_can_user_attach_attachment($img_attachment, 'wall_photo_attachment')) {
                    $finial_images[] = $img_attachment;
                }
                
            }
        }
        
        
        
        if(!$error && (empty($finial_images) && !$post_content)) {
            $error = "Please write something or attach a photo";
        }
        
        
        
        if($error) {
            KSM_Js::setWallPostError($error);
            die();
        }
            
        $wall_post_id  = wp_insert_post(array(
            'post_title'    => "Wall Post",
            'post_content'  => $post_content,
            'post_type'     => 'ksm_wall_post',
            'post_status'   => 'pending',
            'post_author' => $user_ID
            ));
        
            
        
        if($wall_post_id) {
            
            $posted_from = $_POST['on'] == 'community' ? 'community' : 'studio';
            
            update_post_meta($wall_post_id, 'posted_from', $posted_from);
            
            
            foreach($finial_images as $img) {
                wp_update_post(array('ID' => $img->ID, 'post_parent' => $wall_post_id));
                do_action('ksm_user_attach_attachment', $img->ID);
            }
            
            $post = get_post($wall_post_id);
            
            
            KSM_Js::showPostOptions($post->ID);
        }
        
        die();
    }
    
    
    static function post_wip($wall_post, $img) {
        global $user_ID;
        $wip_id  = wp_insert_post(array(
            'post_title'    => "WIP Post",
            'post_content'  => $wall_post->post_content,
            'post_type'     => 'ksm_wip',
            'post_status'   => 'publish',
            'post_author' => $user_ID
            ));
        
        if($wip_id) {
            update_post_meta($wip_id, 'image', $img->ID);
            
            update_user_meta($user_ID, 'wip_count', KSM_Stats::count_user_wips($user_ID));
            
        }
        
        
    }
    
    public function comment() {
        
        
        global $user_ID, $user_login;
        
        $comment = sanitize_text_field($_POST['comment']);
        $wall_post_id = sanitize_text_field($_POST['wpid']);
        
        $wall_post = get_post($wall_post_id);
        
        
        if(!$wall_post_id || $wall_post->post_type != 'ksm_wall_post' || !$user_ID) {
            $error = "You are not allowed to comment";
        } elseif(!$comment) {
            $error = "Please write something";
        }
        
        if($error) {
            KSM_Js::setWallCommentError($wall_post_id, $error);
            die();
        }
        $commentdata = array(
            
            'comment_post_ID' => $wall_post_id,
            'comment_author' => $user_login, 
            'comment_content' => $comment,
            'user_id'=> $user_ID,
            'comment_author_IP' => get_the_user_ip()
            
        );
        $comment_id = wp_new_comment($commentdata);
        if($comment_id) {
            update_comment_meta($comment_id, 'views_count', '0');
            update_comment_meta($comment_id, 'likes', array());
            update_comment_meta($comment_id, 'likes_count', '0');
            
            $wpc = get_comment($comment_id);
            ob_start();
            include KSM_BASE_PATH.'templates/studio/wall_comment_item.php';
            $comment_item_html = ob_get_clean();
            $comment_item_html = preg_replace( "/\r|\n/", "", $comment_item_html );
            KSM_Js::addWallComment($wall_post_id, $comment_item_html, $wall_post->comment_count+1);
            
        }
        
        die();
        
    }
    
    
    
    
    public function upload_image() {
        
        
        $file = $_FILES['async-upload'];
        $uploads = wp_upload_dir();
        $wp_filetype = wp_check_filetype(basename($file['name']), null );
        
        
        check_ajax_referer('ksm_wiu');
        $upload = wp_handle_upload($_FILES['async-upload'], array('action' => 'wiu'));

        $parent_post_id = 0;
            
        $post_author = get_current_user_id();

        $attachment = array(
                'guid' => $upload['url'],
                'post_mime_type' => $wp_filetype['type'],
                'post_title'     => preg_replace( '/\.[^.]+$/', '', $file['name'] ),
                'post_content' => '',
                'post_status' => 'inherit',
                'post_author' => $post_author
        );
        $attachment_id = wp_insert_attachment( $attachment, $upload['file'], $parent_post_id );
        
        
        if($attachment_id) {

            require_once(ABSPATH . 'magento-help/includes/image.php');
            $attach_data = wp_generate_attachment_metadata( $attachment_id, $upload['file'] );
            wp_update_attachment_metadata( $attachment_id, $attach_data );

            $result = array(
                'success'=>'1',
                'id' => $attachment_id,
                'url' => wp_get_attachment_thumb_url($attachment_id)
            );
            
            do_action('ksm_user_upload_attachment', $attachment_id, 'wall_photo_attachment');
        }
        
        echo json_encode($result);
        die();
        
    }
    
    
    
    
    
    
    
    
    
    
    
}