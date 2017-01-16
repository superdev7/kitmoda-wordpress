<?php


class KSM_Social_Post extends KSM_Post {
    
    
    
    public $_post_type = 'ksm_post',
            $view_type = '';
    
    
    
    

    function rest_item($type = 'get', $args = array()) {
        $data = array();
        
        if($this->ID) {
            if($type == 'get') {
                return $this->rest_get_item($args);
            } elseif($type == 'update') {
                return $this->rest_update_item($args);
            }
        }
        return $data;
    }
    
    
    public function rest_get_item($args = array()) {
        
        
        
        $images = $comments = array();
            
        $ksm_post_attachments = $this->image_attachments(array(
            'order'     => 'ASC',
            'meta_key' => 'image_sort',
            'orderby'   => 'meta_value_num'
        ));
        
        
        
        $thumb_size = 'community_thumb_smaller';
        
        
        if(!(isset($args['images']) && $args['images'] === null)) {
            $images_size = $args['images_size'] ? $args['images_size'] : 'wall_full';
            foreach($ksm_post_attachments as $_image) {
                $images[] = array(
                    'title' => $_image->post_title,
                    'favorites_count' => get_number($_image->favorites_count),
                    'src' => get_image_src($_image->ID, $images_size),
                    'fav_action' => KSM_Action::favorite_toggle($_image)
                );
            }
        }
        
        if(!empty($ksm_post_attachments)) {
            $thumb = get_image_src($ksm_post_attachments[0]->ID, $thumb_size);
        }
        
        
        
        $ksm_post_comments = $this->comments(array('orderby' => 'comment_date', 'order' => 'ASC'));
            
        foreach ($ksm_post_comments as $_comment) {
            $com = new KSM_Post_Comment($_comment->comment_ID);
            $comments[] = $com->rest_item();
        }
        
        
        
        $data = array(
            'post_id' => $this->ID,
            'avatar' => $this->Author->avatar('avatar_tiny'),
            'title'  => $this->post_title,
            'author_link'  => $this->Author->studio_link(),
            'author_name'  => $this->Author->display_name(),
            'edit_post_link' => ksm_get_permalink("studio/edit_post/$this->ID"),
            'delete_post_link' => ksm_get_permalink("studio/delete_post/$this->ID"),
            'time_ago'  => time_ago($this->post_date),
            'content' => $this->post_content,
            'views_count' => $this->views_count,
            'comments_count' => $this->comment_count,
            'likes_count' => $this->likes_count,
            'like_action' => KSM_Action::post_like_toggle($this->Post),
            'has_access' => ($this->isOwner() ? true : false),
            'images_count' => $this->images_count,
            
            
            'thumb' => $thumb,
            
            
            'images' => $images,
            'comments' => $comments
        );
        
        
        
        
        if($args['is_community']) {
            $data['edit_post_link'] = ksm_get_permalink("community/edit_post/$this->ID");
            $data['delete_post_link'] = ksm_get_permalink("community/delete_post/$this->ID");
        }
        
        
        if($args['gallery']) {
            $data['gallery'] = $this->gallery(array(
                    'full_size'=> 'wall_full', 
                    'thumb_size'=>'community_thumb_smaller' , 
                    'name'=>"comm_sgallery_{$this->ID}",
                    'count_view' => true,
                    'with_featured' => true
                    ));
        }
        
        
        KSM_postView::add($this->Post);

           
        return $data;
    }
    
    
    public function have_gallery_images() {
        $attachments = $this->image_attachments();
        
        $have_gallery_images = false;
        
        foreach($attachments as $att) {
            if($att->add_in_gallery == 'yes') {
                $have_gallery_images = true;
                break;
            }
        }
        return $have_gallery_images;
    }
    
    public function Topic() {
        $topic = ksm_get_ds_post_term_names($this->ID, 'topic', 'topic', true);
        return $topic ? $topic : 'general';
        
    }
    
    
    public function Progress() {
        $progress = ksm_get_ds_post_term_names($this->ID, 'topic', 'progress', true);
        
        return $progress;
    }
    
    
    function posted_at_type() {
        $post_at_terms = wp_get_post_terms($this->ID, "ksm_tax_post_at", array('fields' => 'names'));
        if(!in_array('studio', $post_at_terms) || !in_array('community', $post_at_terms)) {
            $post_at = 1;
        } elseif(in_array('studio', $post_at_terms) && in_array('community', $post_at_terms)) {
            $post_at = 2;
        } else {
            $post_at = '';
        }
        return $post_at;
    }
    
    
    
    function post_options_available($is_edit = false) {
        
        
        $available = false;
        $post_status = $is_edit ? 'publish' : 'pending';
        
        if($this->ID && $this->post_status == $post_status && $this->isOwner()) {
            $available = true;
        }
        
        return $available;
    }
    
    
    
    
    
    
    
    function add_comment($args) {
        
        
        
        $result = array();
        $user = $args['user'];
        $comment = $args['comment'];
        
        
        $errors = array();
        
        
        if($comment == "") {
            $errors['comment'] = "Please write something";
        }
        
        
        
        if(empty($errors)) {
            
            $commentdata = array(
                'comment_post_ID' => $this->ID,
                'comment_author' => $user->user_login, 
                'user_id'=> $user->ID,
                'comment_content' => $comment,
                'comment_type' => $this->_post_type,
                'comment_author_IP' => get_the_user_ip()
            );

            $comment_id = wp_new_comment($commentdata);
            
            
            if($comment_id) {
                
                
                $comment = new KSM_Post_Comment($comment_id);
                
                
                $comment->update_meta('views_count', '0');
                $comment->update_meta('likes', array());
                $comment->update_meta('likes_count', '0');
                
                foreach((Array) $args['extra_meta'] as $em) {
                    $comment->update_meta($em[0], $em[1]);
                }
                
                
                $result = $this->Success("Comment Posted", $comment->rest_item());
                
                
            } else {
                $errors['fail'] = 'Error while posting comment.';
            }
            
        }
        
        
        
        if($errors) {
            return $this->Errors($errors);
        }
        
        return $result;
    }
    
    
    
    
    
    function save_post_options($is_edit) {
        
        
        if(!$this->post_options_available($is_edit)) 
            return $this->Error('Post options are not available.');
        
        
        $post_title = wp_kses($_POST['post_title'], array());
        if($is_edit) {
            $post_content = wp_kses($_POST['post_content'], array());
        } else {
            $post_content = $this->post_content;
        }
        
        
        
        
        $topic_all_terms = array_keys(KSM_DataStore::Terms('topic', '', 'topic'));
        $post_topic = in_array($_POST['topic'], $topic_all_terms) ? $_POST['topic'] : '';
        
        $post_to = sanitize_text_field($_POST['post_to']);
        
        
        $progress_all_terms = array_keys(KSM_DataStore::Terms('topic', '', 'progress'));
        $post_progress = in_array($_POST['progress'], $progress_all_terms) ? $_POST['progress'] : '';
        
        
        
        
        
        $images = $this->input_list_images();
        
        
        
        if($post_title == '')
            return $this->Error('Post title is required.');
        
        if(!$post_topic) 
            return $this->Error('Select post topic.');
        
        if(empty($images['final_list']) && ($post_content == '' || !$post_content)) 
            return $this->Error("Please write something or attach a photo");
        
        
        $title_max_length = POST_TITLE_MAX_LENGTH;
        
        
        
                
        if(strlen($post_title) > $title_max_length) 
            return $this->Error("{$title_max_length} characters allowed for title");
        
        $max_length = POST_CONTENT_MAX_LENGTH;
        
        if(strlen($post_content) > $max_length) 
            return $this->Error("{$max_length} characters allowed");
        
        
        
        
        $post_at_tax = new KSM_Taxonomy('post_at');
        $topic_tax = new KSM_Taxonomy('topic');
        
        
        if($this->view_type == 'studio') {
            $post_at_terms[] = (int) $post_at_tax->get_term_id('studio');
        } elseif($this->view_type == 'community') {
            $post_at_terms[] = (int) $post_at_tax->get_term_id('community');
        }
        
        if($post_to == '2') {
            if($this->view_type == 'studio') {
                $post_at_terms[] = (int) $post_at_tax->get_term_id('community');
            } elseif($this->view_type == 'community') {
                $post_at_terms[] = (int) $post_at_tax->get_term_id('studio');
            }
        }
        
        
        
        $topic_terms = array();
        $topic_terms[] = (int) $topic_tax->get_term_id($post_topic);
        if($post_progress) {
            $topic_terms[] = (int) $topic_tax->get_term_id($post_progress);
        }
        
        
        
        $update_galleries = false;
        
        $sort_num = 1;
        
        
        $total_images = count((Array)$images['final_list']);
        
        $this->update_meta('images_count', $total_images);
        
        foreach((Array)$images['final_list'] as $img_id => $img_data) {
            
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
        
        foreach((Array) $images['removable'] as $r_att) {
            $update_galleries = true;
            wp_delete_attachment($r_att);
        }
        
        if($images['new']) {
            $update_galleries = true;
            $uploader = KSM_Uploader::get_uploader('postiu');
            $uploader->attach_attachments($images['new'], $this->ID);
        }
        
        
        
        
        wp_delete_object_term_relationships($this->ID, array('ksm_tax_topic', 'ksm_tax_post_at'));
        
        if($post_at_terms) 
            $post_at_tax->set_term($this->ID, $post_at_terms);
        if($topic_terms) 
            $topic_tax->set_term($this->ID, $topic_terms);
        
        $post_update_args = array(
            'ID' => $this->ID, 
            'post_title'  => $post_title,
            'post_status' => 'publish'
            );
        
        if($is_edit) {
            $post_update_args['post_content'] = $post_content;
        }
        
        wp_update_post($post_update_args);
        
        return $this->Success('', array('update_galleries' => $update_galleries));
    }
    
    
    
    function can_delete_post() {
        
        if(!$this->ID) {
            $this->Error('post doesn\'t exist');
        }
        
        if(!$this->isOwner()) {
            return $this->Error("You cannot delete this post");
        }
        
        return $this->Success();
    }
    
    
    public function delete($delete_gallery_images) {
        
        $result = $this->can_delete_post();
        if($result['error']) return $result;
        
        
        
        $update_galleries = false;
        
        if($this->have_gallery_images()) {
            $update_galleries = true;
            $attachments = $this->image_attachments();
        
            $deleteable_images = array();
            
            if($delete_gallery_images) {
                $deleteable_images = $attachments;
            } else {
                foreach($attachments as $att) {
                    if($att->add_in_gallery == 'no') {
                        $deleteable_images[] = $att;
                    }
                }
            }

            foreach($deleteable_images as $img) {
                wp_delete_attachment($img->ID);
            }
        }
        
        wp_delete_post($this->ID);
        
        return $this->Success('Post successfully deleted.', array('update_galleries' => $update_galleries));
    }
    
    
    
    
    function input_list_images() {
        
        $images_data = ksm_prepare_list_input_data($_POST['kimg'], array('id', 'name', 'topic', 'progress', 'add_in_gallery'), 'id');
        $existing_images = $this->image_attachment_ids();
            
            
        $new_images_ids = array_keys($images_data);
        

        $existing = array_intersect($new_images_ids, $existing_images);
        $removable = array_diff($existing_images, $new_images_ids);


        $uploader = KSM_Uploader::get_uploader('postiu');
        $new = $uploader->getAttachables(array_diff($new_images_ids, $existing_images));
        $finial_images = array_merge($new, $existing);
        
        
        $finial_images_data = array();
        
        //$changed_galleries = array();
        
        foreach($images_data as $img_id => $img_data) {
            
            
            if(in_array($img_id, $finial_images)) {
                $finial_images_data[$img_id] = $img_data;
            }
            
        }
        
        
        return array(
            'removable' => $removable,
            'new' => $new,
            'final_list' => $finial_images_data
        );
            
    }
    
    
    
    
    public function admin_save() {
        
        $topic_all_terms = array_keys(KSM_DataStore::Terms('topic', '', 'topic'));
        $progress_all_terms = array_keys(KSM_DataStore::Terms('topic', '', 'progress'));
        
        
        $post_at_tax = new KSM_Taxonomy('post_at');
        $topic_tax = new KSM_Taxonomy('topic');
        
        
        $images = $this->input_list_images();
        
        
        
        
        
        $total_images = count((Array)$images['final_list']);
        $this->update_meta('images_count', $total_images);
        
        $sort_num = 1;
        foreach((Array)$images['final_list'] as $img_id => $img_data) {
            
            $img_data['add_in_gallery'] = $img_data['add_in_gallery'] == 'yes' ? 'yes' : 'no';
            
            wp_update_post(array('ID' => $img_id, 'post_title' => $img_data['name']));
            update_post_meta($img_id, 'add_in_gallery', $img_data['add_in_gallery']);
            update_post_meta($img_id, 'image_sort', $sort_num);
            wp_delete_object_term_relationships($img_id, array('ksm_tax_topic', 'ksm_tax_post_at'));
            
            
            
            $img_topic_terms = array();
            
            if($img_data['topic'] && in_array($img_data['topic'], $topic_all_terms) ) {
                $img_topic_terms[] = (int) $topic_tax->get_term_id($img_data['topic']);
            }
            
            if($img_data['progress'] && in_array($img_data['progress'], $progress_all_terms)) {
                $img_topic_terms[] = (int) $topic_tax->get_term_id($img_data['progress']);
            }
            
            
            if($img_topic_terms) {
                $topic_tax->set_term($img_id, $img_topic_terms);
            }
            if($post_at_terms) {
                $post_at_tax->set_term($img_id, $post_at_terms);
            }
            
            $sort_num++;
        }
        
        foreach((Array) $images['removable'] as $r_att) {
            wp_delete_attachment($r_att);
        }
        
        if($images['new']) {
            $uploader = KSM_Uploader::get_uploader('postiu');
            $uploader->attach_attachments($images['new'], $this->ID);
        }
        
    }
   
}