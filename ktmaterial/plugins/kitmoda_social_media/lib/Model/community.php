<?php



class KSM_CommunityModel extends KSM_BaseModel {
    
    
    public $topic_terms = array(
            'general',
            'challenge',
            'model',
            'concept',
            'texture',
            'question'
        ),

        $gallery_terms = array(
            'wip',
            'finished'
        ),

        $post_type = 'ksm_community_post';
    
    
    
    
    
    
    function add_post() {
        
        $user_id = get_current_user_id();
        
        
        $_id = sanitize_text_field($_POST['_id']);
        $action = KSM_Action::get($_id);
        
        
        $editing = false;
        
        if($action && $action['id']) {
            $post = get_post($action['id']);
            
            if($post && $post->post_type == 'ksm_post' && $post->post_author == $user_id && $post->post_status == 'pending') {
                $editing = true;
            }
        }
        
        
        $post_content = sanitize_text_field($_POST['post_content']);
        $images = (Array) $_POST['multi_images'];
        
        
        if(!$user_id) 
            return $this->Error("You are not allowed to post here");
        
        
        
        if(!$post_content && empty($images)) 
            return $this->Error("Please write something or attach a photo");
        
        
        
        $max_length = POST_COMMUNITY_MAX_LENGTH;
        
        if(strlen($post_content) > $max_length) 
            return $this->Error("{$max_length} characters allowed");
        
        
        
        
        
        
        $uploader = KSM_Uploader::get_uploader('postiu');
        
        if($editing) {
            
            $post_images = post_attacment_ids($post->ID);
            
            
            $new = array_diff($images, $post_images);
            $removable = array_diff($post_images, $images);
            $existing = array_intersect($images, $post_images);
            
            $finial_images = array_merge($new, $existing);
        } else {
            $finial_images = $uploader->getAttachables($images);
        }
        
        
        
        
        
        
        if(empty($finial_images) && !$post_content) 
            return $this->Error("Please write something or attach a photo");
        
        
        
        
        if($editing) {
            wp_update_post(array('ID' => $post->ID, 'post_content' => $post_content));
            $_post_id = $post->ID;
        } else {
            
            $_post_id  = wp_insert_post(array(
                'post_title'    => "Wall Post",
                'post_content'  => $post_content,
                'post_type'     => 'ksm_post',
                'post_status'   => 'pending',
                'post_author' => $user_id
            ));
            
        }
        
        
        
        
        
        if($_post_id) {
            
            if($editing) {
                $uploader->attach_attachments($new, $_post_id);
                
                foreach((Array) $removable as $d) {
                    wp_delete_attachment($d, true);
                }
                
            } else {
                $uploader->attach_attachments($finial_images, $_post_id);
            }
            
            
            $image_sort = 1;
            foreach($finial_images as $img) {
                update_post_meta($img, 'image_sort', $image_sort);
                $image_sort++;
            }
            
            $total_images = count($finial_images);
            
            update_post_meta($_post_id, 'images_count', $total_images);
            
            return $this->Success('', array('post_id' => $_post_id));
        }
        

        return $this->Error("Error while posting");
        
    }
    
    
    /*
    
    function save_post_options() {
        
        
        $post_id = $_POST['_id'];
        $post_to = $_POST['post_to'];
        $community_topic = $_POST['topic'];
        $gallery = $_POST['gallery'];
        $gallery_images = (Array) $_POST['kgimg'];
        $finial_gallery_images = array();
        
        
        
        
        
        
        
        
        if(!$this->post_options_available($post_id)) 
            return $this->Error("Post options are not available");
        
        
        
        
        
        $post = get_post($post_id);
        $attachments = post_attacments($post->ID);
        
        
        
        
            if(!$community_topic || !in_array($community_topic, KSM_Community::$topic_terms)) 
                return $this->Error("Please select a topic.");
        
        
        $post_at_tax = new KSM_Taxonomy('post_at');
        $topic_tax = new KSM_Taxonomy('topic');
        $post_at_terms = $topic_terms = array();
        
        
        $post_at_terms[] = (int) $post_at_tax->get_term_id('community');
        $topic_terms[] = (int) $topic_tax->get_term_id($community_topic);
        
        
        if($post_to == 2) 
            $post_at_terms[] = (int) $post_at_tax->get_term_id('studio');
            
        
        
        
        $images_terms = array();
        
        $update_galleries = array();
        
        
        if($community_topic == 'challenge') {
            $update_galleries[] = 'challenge';
        }
        
        if(count($attachments) > 0) {
            $update_galleries[] = 'new';
        }
        
        foreach ($attachments as $k => $i) {
            
            
            $images_terms[$i->ID]['topic'] = array();
            $images_terms[$i->ID]['topic'][] = (int) $topic_tax->get_term_id($community_topic);
            
            
            if(in_array($i->ID, $gallery_images)) {
                $images_terms[$i->ID]['topic'][] = (int) $topic_tax->get_term_id($gallery);
                $finial_gallery_images[] = $i;
            }
            
            if($_POST['kimg_title'][$i->ID] && $_POST['kimg_title'][$i->ID] != $i->post_title) {
                wp_update_post(array('ID' => $i->ID, 'post_title' => $_POST['kimg_title'][$i->ID]));
            }
        }
        
        
        if($gallery && in_array($gallery, KSM_Community::$gallery_terms) && $finial_gallery_images) {
            if(!in_array($gallery, $update_galleries)) {
                $update_galleries[] = $gallery;
            }
            $topic_terms[] = (int) $topic_tax->get_term_id($gallery);
        }
        
        
        
        foreach($images_terms as $k => $v) {
            if($post_at_terms) 
                $post_at_tax->set_term($k, $post_at_terms);
            if($v['topic']) 
                $topic_tax->set_term($k, $v['topic']);
        }
                
        if($post_at_terms) 
            $post_at_tax->set_term($post->ID, $post_at_terms);
        if($topic_terms) 
            $topic_tax->set_term($post->ID, $topic_terms);
        
        
        
        
        
        wp_update_post(array('ID' => $post->ID, 'post_status'   => 'publish'));
        
        $update_galleries = array_map(function($g){
            return "{$g}_community";
        }, $update_galleries);
        
        return $this->Success('', array('update_galleries' => $update_galleries));
    }
    
    */
    
    
    function post_options_available($post_id , $user_id = 0) {
        
        if(!$user_id) {
            $user_id = get_current_user_id();
        }
        
        $available = false;
        
        if($post_id && $user_id) {
            $post = get_post($post_id);
            if($post && $post->post_status == 'pending' && $post->post_type == 'ksm_post' && $post->post_author == $user_id) {
                $available = true;
            }
        }
        return $available;
    }
    
    
    
    
    
}