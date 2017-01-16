<?php

require_once 'class.image_collage.php';

class KSM_Share {
    
    static function is_shareable($post) {
        
        if($post->post_type == 'ksm_post' || $post->post_type == 'download') {
            return true;
        }
        return false;
    }
    
    static function get_shareable_item($p) {
        
        $item = $p;
        
        if($p->post_type == 'attachment') {
            $i = get_post_ancestors($p->ID);
            $item = get_post($i[0]);
        }
        
        return $item;
        
    }
    
    
    
    
    
    static function get_params($post) {
        
        $params = array();
        
        if(!$post->short_link) {
            update_post_meta($post->ID, 'short_link', uniqid());
        }
            
            
        $params['email_subject'] = strlen($post->post_content) > 30 ? substr($post->post_content, 0, 30).'...' : $post->post_content;
        $params['email_message'] = "Check out what i found on Kitmoda.\n";
        $params['email_message'] .= home_url("sl/{$post->short_link}");
        $params['description'] = $post->post_content;
            
            
        $params['link'] = home_url("sl/{$post->short_link}");
        $params['caption'] = "I found this on Kitmoda";
            
            
        $params['tweet'] = strlen($post->post_content) > 80 ? substr($post->post_content, 0, 80).'...' : $post->post_content;
        $params['tweet'] .= " " . $params['link'];
                    
        $temp_attachments = post_attacments($post->ID);
        
        $attachments = array();
        foreach($temp_attachments as $at) {
            if($at->s3_file_key || !wp_attachment_is_image($at->ID)) {
                continue;
            }
            $attachments[] = $at;
        }
            
        if($attachments) {
            if(count($attachments) == 1) {
                $params['picture'] = get_image_src($attachments[0]->ID, 'wall_full');
            } elseif(count($attachments) > 1) {
                if(!$post->collage) {
                    $collage = new ksm_imageCollage(
                        array('width'=>'600', 'margins'=>'20' , 'entries'=>$attachments, 'name'=>$post->short_link)
                    );
                    update_post_meta($post->ID, 'collage', $collage->collage_image);
                }
                $params['picture'] = get_post_meta($post->ID, 'collage', true);
            }
        }
        
        return $params;
    }
    
    
    
    
    static function params($id) {
        
        $post = get_post($id);
        if(self::is_shareable($post)) {
            $params = self::get_params($post);
        }
        
        return $params;
    }
    
    
    
    
    
    
    
    
    
    static function facebook() {
        
        $post_id = sanitize_text_field($_POST['id']);
        $post = get_post($post_id);
        $params = self::params($post_id);
        
        if($post_id && $params) {
            $params['comment'] = sanitize_text_field($_POST['facebook_comment']);
            KSM_Js::fb_init_share($params);
        }
    }
    
    
    static function email() {
        $post_id = sanitize_text_field($_POST['id']);
        
        $post = get_post($post_id);
        
        if(!$post) {
            return;
        }
        
        
        $v_data['email_from'] = sanitize_email($_POST['email_from']);
        $v_data['email_to'] = 	sanitize_email($_POST['email_to']);
        $v_data['email_subject'] = sanitize_text_field($_POST['email_subject']);
        $v_data['email_message'] = sanitize_text_field($_POST['email_message']);
        
        
        
        $v = new KSM_Validator($v_data);
        
        $v->rule('required', array('email_from', 'email_to', 'email_subject', 'email_message'));
        $v->rule('email', array('email_from', 'email_to'));
        
        $v->labels(array(
            'email_from' => 'From email',
            'email_to' => 'To email'
        ));
        
        if($v->validate()) {
            $subject = "From ".sanitize_email($_POST['email_from'])." : ".sanitize_text_field($_POST['email_subject']);
            
            
            
            $sh_params = self::params($post->ID);
            $atta = array();
            if($sh_params['picture']) {
                $picture = $sh_params['picture'];
            }
            
            $parsed_url = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $picture);
            
            if ($parsed_url[1]) {
		$atta[] = WP_CONTENT_DIR . $parsed_url[1];
            }
            
            
            $_frm_email = get_option( 'admin_email');
            $headers = 'From: Kitmoda <'.$_frm_email.'>' . "\r\n";
            
            if(wp_mail(sanitize_email($_POST['email_to']), $subject, sanitize_text_field($_POST['email_message']), $headers, $atta)) {
                KSM_Js::setEmailShareSuccess();
            } else {
                KSM_Js::setEmailShareError("Error while sending your message.");
            }
        } else {
            
            $ak = array_keys($v->errors());
            $error = array_shift(array_shift($v->errors()));
            KSM_Js::setEmailShareError($error);
        }
    }
    
    
    
    
}