<?php

class KSM_StudioModel extends KSM_BaseModel {
    
    
    
    public function __construct() {
        parent::__construct();
    }
    
    
    
    
    
    function favorites_join($join, $inc) {
        global $wpdb;
        
        
        
        $user_id = $inc->query['favorites_of_user'];
        
        $join .= "INNER JOIN  {$wpdb->prefix}ksm_favorites f ON {$wpdb->posts}.ID = f.item_id AND f.user_id = '{$user_id}'";
        
        return $join;
    }
    
    
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
        
        
        $max_length = POST_CONTENT_MAX_LENGTH;
        
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
                'post_title'    => "",
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
            
            
            $total_images = count($finial_images);
            
            $image_sort = 1;
            foreach($finial_images as $img) {
                update_post_meta($img, 'image_sort', $image_sort);
                $image_sort++;
            }
            
            update_post_meta($_post_id, 'images_count', $total_images);
            
            return $this->Success('', array('post_id' => $_post_id));
        }
        

        return $this->Error("Error while posting");
        
    }
    
    
    /*
    
    function save_post_options($is_edit = false) {
        
        
        $post_id = $_POST['_id'];
        
        
        $post = new KSM_Social_Post($post_id);
        
        
        $post->save_post_options($is_edit);
        
        $post_to = $_POST['post_to'];
        
        
        $images_data = ksm_prepare_list_input_data($_POST['kimg'], array('id', 'name', 'topic', 'progress', 'add_in_gallery'), 'id');
        
        
        
        if(!$this->post_options_available($post_id, get_current_user_id() , $is_edit)) 
            return $this->Error('Post options are not available.');
        
        elseif(trim($_POST['post_title']) == '')
            return $this->Error('Post title is required.');
        
        
        
        
        $topic_all_terms = array_keys(KSM_DataStore::Terms('topic', '', 'topic'));
        $progress_all_terms = array_keys(KSM_DataStore::Terms('topic', '', 'progress'));
        
        
        $post_topic = in_array($_POST['topic'], $topic_all_terms) ? $_POST['topic'] : '';
        $post_progress = in_array($_POST['progress'], $progress_all_terms) ? $_POST['progress'] : '';
        
        
        if(!$post_topic) 
            return $this->Error('Select post topic.');
        
        
        $post_at_tax = new KSM_Taxonomy('post_at');
        $topic_tax = new KSM_Taxonomy('topic');
        
        $post_at_terms[] = (int) $post_at_tax->get_term_id('studio');
        if($post_to == '2') {
            $post_at_terms[] = (int) $post_at_tax->get_term_id('community');
        }
        
        $topic_terms = array();
        $topic_terms[] = (int) $topic_tax->get_term_id($post_topic);
        if($post_progress) {
            $topic_terms[] = (int) $topic_tax->get_term_id($post_progress);
        }
        
        
        
        $post = get_post($post_id);
        $existing_images = post_attacment_ids($post->ID);
        $new_images_ids = array_keys($images_data);
        
        
        $existing = array_intersect($new_images_ids, $existing_images);
        $removable = array_diff($existing_images, $new_images_ids);
        
        
        $uploader = KSM_Uploader::get_uploader('postiu');
        $new = $uploader->getAttachables(array_diff($new_images_ids, $existing_images));
        $finial_images = array_merge($new, $existing);
        
        $update_galleries = false;
        
        $sort_num = 1;
        
        foreach($images_data as $img_id => $img_data) {
            if(!in_array($img_id, $finial_images)) {
                continue;
            }
            
            $img_data['add_in_gallery'] = $img_data['add_in_gallery'] == 'yes' ? 'yes' : 'no';
            
            wp_update_post(array('ID' => $img_id, 'post_title' => $img_data['name']));
            update_post_meta($img_id, 'add_in_gallery', $img_data['add_in_gallery']);
            update_post_meta($img_id, 'image_sort', $sort_num);
            wp_delete_object_term_relationships($img_id, array('ksm_tax_topic', 'ksm_tax_post_at'));
            
            $update_galleries = true;
            
            $img_topic_terms = array();
            
            if($img_data['topic'] && in_array($img_data['topic'], $topic_all_terms) ) 
                $img_topic_terms[] = (int) $topic_tax->get_term_id($img_data['topic']);
            
            if($img_data['progress'] && in_array($img_data['progress'], $progress_all_terms)) 
                $img_topic_terms[] = (int) $topic_tax->get_term_id($img_data['progress']);
            
            
            if($img_topic_terms) {
                $topic_tax->set_term($img_id, $img_topic_terms);
            }
            if($post_at_terms) {
                $post_at_tax->set_term($img_id, $post_at_terms);
            }
            
            $sort_num++;
        }
        
        foreach((Array) $removable as $r_att) {
            $update_galleries = true;
            wp_delete_attachment($r_att);
        }
        
        if($new) {
            $update_galleries = true;
            $uploader->attach_attachments($new, $post->ID);
        }
        
        
        
        
        wp_delete_object_term_relationships($post->ID, array('ksm_tax_topic', 'ksm_tax_post_at'));
        
        if($post_at_terms) 
            $post_at_tax->set_term($post->ID, $post_at_terms);
        if($topic_terms) 
            $topic_tax->set_term($post->ID, $topic_terms);
        
        wp_update_post(array(
            'ID' => $post->ID, 
            'post_title'  => $_POST['post_title'],
            'post_status' => 'publish'
            ));
        
        return $this->Success('', array('update_galleries' => $update_galleries));
    }
    
    */
    
    /*
    function post_options_available($post_id , $user_id = 0, $is_edit = false) {
        
        if(!$user_id) {
            $user_id = get_current_user_id();
        }
        
        $available = false;
        
        $post_status = $is_edit ? 'publish' : 'pending';
        
        if($post_id && $user_id) {
            $post = get_post($post_id);
            if($post && $post->post_status == $post_status && $post->post_type == 'ksm_post' && $post->post_author == $user_id) {
                $available = true;
            }
        }
        return $available;
    }
    
    */
    
    
    
    
    
    
    
    function submit_gallery_image() {
        
        
        $post_id = sanitize_text_field($_POST['_id']);
        $post_to = sanitize_text_field($_POST['post_to']);
        $community_topic = sanitize_text_field($_POST['topic']);
        $gallery = sanitize_text_field($_POST['gallery']);
        $gallery_images = (Array) $_POST['kgimg'];
        $finial_gallery_images = array();
        
        
        
        
        
        
        if(!$this->post_options_available($post_id)) 
            return $this->Error("Post options are not available");
        
        
        
        
        
        $post = get_post($post_id);
        $attachments = post_attacments($post->ID);
        
        
        
        if($post_to == '2') {
            if(!$community_topic || !in_array($community_topic, KSM_Community::$topic_terms)) 
                return $this->Error("Please select a topic.");
        }
        
        
        $post_at_tax = new KSM_Taxonomy('post_at');
        $topic_tax = new KSM_Taxonomy('topic');
        $post_at_terms = $topic_terms = array();
        
        
        $post_at_terms[] = (int) $post_at_tax->get_term_id('studio');
        if($post_to == 2) {
            
            $post_at_terms[] = (int) $post_at_tax->get_term_id('community');
            $topic_terms[] = (int) $topic_tax->get_term_id($community_topic);
        }
        
        
        
        $images_terms = array();
        
        
        foreach ($attachments as $k => $i) {
            
            
            $images_terms[$i->ID]['topic'] = array();
            
            if($post_to == 2)
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
            $topic_terms[] = (int) $topic_tax->get_term_id($gallery);
        }
        
        
        
        //pr($images_terms);
        //pr($post_at_terms);
        //exit;
        
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
        
        return $this->Success('');
    }
    
    
    
    function submit_gallery_image_old() {
        
        
        
        $post_to = sanitize_text_field($_POST['post_to']);
        $community_topic = sanitize_text_field($_POST['topic']);
        $image = sanitize_text_field($_POST['gi']);
        
        $user_id = get_current_user_id();
        
        
        $post_content = sanitize_text_field($_POST['description']);
        $title = sanitize_title($_POST['title']);
        
        
        if(!$image) {
            return $this->Error('Attach a photo');
        }
        
        $img_attachment = get_post($image);
        
        if(!ksm_can_user_attach_attachment($img_attachment, 'wip_photo_attachment')) {
            return $this->Error('Attach a photo');
        }
        
        if($post_to == '2' && (!$community_topic || !in_array($community_topic, KSM_Community::$topic_terms))) {
            return $this->Error("Please select a topic.");
        }
        
        
        $topic_term_id = $gallery_term_id = '';
        
        
        
        
        
        
        
        
        $_post_id  = wp_insert_post(array(
            'post_title'    => $title,
            'post_content'  => $post_content,
            'post_type'     => 'ksm_wall_post',
            'post_status'   => 'pending',
            'post_author' => $user_ID
            ));
        
        
        
        
        
        if($wall_post_id) {
            
            foreach($finial_images as $img) {
                ksm_attach_attachment($img->ID, $wall_post_id);
            }
            
            return $this->Success('', array('post_id' => $wall_post_id));
            
            
        }
        
        
        
        
        
        
        foreach ($attachments as $i) {
            
            if($_POST['kimg_title'][$i->ID] && $_POST['kimg_title'][$i->ID] != $i->post_title) {
                wp_update_post(array('ID' => $i->ID, 'post_title' => $_POST['kimg_title'][$i->ID]));
            }
            
        }
        
        if($post_to == '2') {
            
            $tax = new KSM_Taxonomy('topic');
            
            $topic_term_id = $tax->get_term_id($community_topic);
            
            
            
            if($gallery && in_array($gallery, KSM_Community::$gallery_terms)) {
                $gallery_term_id = $tax->get_term_id($gallery);
            }
            
            
            $community_post_id  = wp_insert_post(array(
                'post_title'    => "Community Post",
                'post_content'  => $post->post_content,
                'post_type'     => 'ksm_community_post',
                'post_status'   => 'publish',
                'post_author' => $user_id
            ));
            
            
            
            
            if($community_post_id) {
                
                
                $tax->set_term($community_post_id, array((int) $topic_term_id));
                
                foreach ($attachments as $i) {
                    
                    $_img = ksm_copy_image_attachment($i->ID);
                    if($_img) {
                        
                        update_post_meta($_img, 'user_upload_type', 'community_gallery_image');
                        
                        $finial_gallery_images[] = array(
                            'img' => $_img,
                            'terms' => in_array($i->ID, $gallery_images) ? array((int) $topic_term_id, (int) $gallery_term_id) : array((int) $topic_term_id)
                        );
                    }
                }
                
                $total_gallery_images = count($finial_gallery_images);
                
                if($finial_gallery_images[0]) {
                    set_post_thumbnail($community_post_id, $finial_gallery_images[0]['img']);
                    $tax->set_term($finial_gallery_images[0]['img'], $finial_gallery_images[0]['terms']);
                    unset($finial_gallery_images[0]);
                }
                
                foreach($finial_gallery_images as $img) {
                    wp_update_post(array('ID' => $img['img'], 'post_parent' => $community_post_id));
                    $tax->set_term($img['img'], $img['terms']);
                }
                
                
                update_post_meta($community_post_id, 'images_count', $total_gallery_images);
                
            }
            
            
            
        }
        
        wp_update_post(array(
            'ID' => $post->ID,
            'post_status'   => 'publish'
        ));
        
        return $this->Success('');
        
    }
    
    
    
    /*
    function submit_gallery_image() {
        
        
        $user_id = get_current_user_id();
        
        
        $post_content = $_POST['description'];
        $title = $_POST['title'];
        
        $image = $_POST['gi'];
        
        if(!$image) {
            return $this->Error('Attach a photo');
        }
        
        
        
        
        
        $img_attachment = get_post($image);
        if(!ksm_can_user_attach_attachment($img_attachment, 'wip_photo_attachment')) {
            return $this->Error('Attach a photo');
        }
        
        
        
        $post = new stdClass();
        $post->post_title = $title;
        $post->post_content = $post_content;
        
        
        global $user_ID;
        $wip_id  = wp_insert_post(array(
            'post_title'    => $title,
            'post_content'  => $post_content,
            'post_type'     => 'ksm_wip',
            'post_status'   => 'publish',
            'post_author' => $user_ID
            ));
        
        if($wip_id) {
            
            wp_update_post(array('ID' => $img->ID, 'post_parent' => $wip_id));
            do_action('ksm_user_attach_attachment', $img->ID);
            
            update_post_meta($wip_id, 'image', $img->ID);
            
            update_user_meta($user_ID, 'wip_count', KSM_Stats::count_user_wips($user_ID));
            
        }
        
            
        
        if($wip_id) {
            
            $post = get_post($wip_id);
            
            //ob_start();
            
            //include KSM_BASE_PATH.'templates/studio/wall_post_item.php';
            //$wall_item_html = ob_get_clean();
            //$wall_item_html = preg_replace( "/\r|\n/", "", $wall_item_html );
            KSM_Js::AddWipImage($post, $img_attachment);
            
            
        }
        
        die();
        
    }
    
    
    
    */
    
    
}