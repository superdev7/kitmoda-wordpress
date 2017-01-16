<?php

//'collaboration_join_request'

class KSM_CollaborationActiveModel extends KSM_BaseModel {
    
    
    public $post_type = 'collab_active';
    
    
    
    
    
    public function submit_wip_feedback() {
        
        
        $active_id = sanitize_text_field($_POST['_id']);
        $post_content = sanitize_text_field($_POST['post_content']);
        $images = (Array) $_POST['multi_images'];
        
        $user_id = get_current_user_id();
        
        $hasAccess = false;
        
        if($user_id && $active_id) {
            
            $active = new KSM_CollaborationActive($active_id);
            
            if($active->ID && $active->collaboration_author == $user_id && $active->isWaitingForFeedback()) {
                $hasAccess = true;
            }
        }
        
        
        if(!$hasAccess) {
            return $this->Error("You don't have access to feedback this wip");
        }
        
        
        
        
        //////////////////////////////////////////////////////////////////////////
        
        
        
        
        
        $uploader = KSM_Uploader::get_uploader('cwfiu');
        $finial_images = array();
        foreach($images as $img) {
            if($uploader->isAttachable($img)) {
                 $finial_images[] = $img;
            }
        }
        
        
        
        if(empty($finial_images) && !$post_content) {
            return $this->Error("Please write something or attach a photo");
        }
        
        
	
        $post_args = array(
                'post_type' => 'collab_active_step',
		'post_status' => 'publish',
		'post_author' => $user_id,
                'post_title' => $active->post_title,
		'post_content' => $post_content,
                'post_parent' => $active->ID
        );
            
        $_post_id  = wp_insert_post($post_args);
        
        if($_post_id) {
            
            $uploader->attach_attachments($finial_images, $_post_id);
            
            update_post_meta($_post_id, 'step', $active->current_step);
            update_post_meta($_post_id, 'step_state', $active->current_step_state);
            update_post_meta($_post_id, 'collaboration_author', $active->collaboration_author);
            update_post_meta($_post_id, 'collaboration_id', $active->post_parent);
            $active->moveToNextStop();
        }
        
        return $this->Success("Feedback has been sent to your collaboration partner.");
        
        
    }
    
    
    
    public function send_message() {
        
        
        $active_id = sanitize_text_field($_POST['_id']);
        $post_content = sanitize_text_field($_POST['post_content']);
        $images = (Array) $_POST['multi_images'];
        
        $user_id = get_current_user_id();
        
        $hasAccess = false;
        
        if($user_id && $active_id) {
            
            $active = new KSM_CollaborationActive($active_id);
            
            if($active->ID && $active->collaboration_author == $user_id) {
                $hasAccess = true;
            }
        }
        
        
        if(!$hasAccess) {
            return $this->Error("You don't have access to message");
        }
        
        
        
        $uploader = KSM_Uploader::get_uploader('cmiu');
        $finial_images = array();
        foreach($images as $img) {
            if($uploader->isAttachable($img)) {
                 $finial_images[] = $img;
            }
        }
        
        
        
        if(empty($finial_images) && !$post_content) {
            return $this->Error("Please write something or attach a photo");
        }
        
        
        /////////////////////////////////////////////////////////////////////
        
        $to = get_user_by('id', $active->post_author);
        $from = get_user_by('id', $user_id);
        
        
        $title = $from->user_login . " sent a message to ".$to->user_login;
        $message_id  = wp_insert_post(array(
            'post_title'    => $title,
            'post_content'  => $post_content,
            'post_type'     => 'ksm_message',
            'post_status'   => 'publish',
            'post_parent' => $active->ID
            ));
        
        $have_photos = $finial_images ? true : false;
        
        if($message_id) {
            
            
            
            update_post_meta($message_id, 'sent_from', $user_id);
            update_post_meta($message_id, 'sent_to', $to->ID);
            update_post_meta($message_id, 'viewed', '0');
            update_post_meta($message_id, 'read', '0');
            update_post_meta($message_id, 'step', $active->current_step);
            update_post_meta($message_id, 'step_state', $active->current_step_state);
            update_post_meta($message_id, 'have_photos', $have_photos);
            
            
            $notification_count = get_number($to->inbox_news_count) + 1;
            $MessageModel = new KSM_MessageModel();
            $new_count = $MessageModel->count_user_messages($to->ID);
            
            
            update_user_meta($to->ID, 'inbox_news_count', $notification_count);
            update_user_meta($to->ID, 'inbox_messages_count', $new_count);
            
            
            $uploader->attach_attachments($finial_images, $message_id);
        }
        
        
        return $this->Success("Message Sent.");
        
    }
    
    
    
    
    
    
    
    
}