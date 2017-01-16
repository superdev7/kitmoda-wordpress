<?php



class KSM_MessageModel extends KSM_BaseModel {
    
    
    public $post_type = 'ksm_message';
    
    
    
    
    function count_user_messages($user_id) {
        global $wpdb;
        return $wpdb->get_var("SELECT COUNT(p.ID) FROM $wpdb->posts p, $wpdb->postmeta pm WHERE p.post_status = 'publish' AND p.post_type = 'ksm_message' AND pm.meta_key = 'sent_to' AND meta_value='{$user_id}' AND pm.post_id=p.ID");
    }
    
    function count_news($user_ID) {
        global $wpdb;
        $q = "SELECT count(wp_posts.ID) FROM wp_posts 
            INNER JOIN wp_postmeta ON (wp_posts.ID = wp_postmeta.post_id)
            INNER JOIN wp_postmeta AS mt1 ON (wp_posts.ID = mt1.post_id) WHERE 1=1  AND 
            wp_posts.post_type = 'ksm_message' AND ((wp_posts.post_status = 'publish')) AND 
            ( (wp_postmeta.meta_key = 'sent_to' AND CAST(wp_postmeta.meta_value AS CHAR) = '{$user_ID}') 
            AND (mt1.meta_key = 'viewed' AND CAST(mt1.meta_value AS CHAR) != '1') ) GROUP BY wp_posts.ID";
        return $wpdb->get_var($q);
            
    }
    
    
    
    
    
    
    
    
    
    
    
    function get($where) {
		
	$db = DB_MySQL::getInstance();
	
	$q = "SELECT * FROM messages WHERE {$where}";
	
	$messages = $db->select($q);
	$data = array();
	
	return $messages;
    }
	
        
        
        
        
    function send() {
            
        global  $user_ID;
        
        
        $post_content = sanitize_text_field($_POST['message']);
        
        
        if($_POST['id']) {
            
            $key = json_decode(Ksm_Hash::decrypt($_POST['id']));
            $action = $key->action;
            $to_id = $key->_id;
            if($to_id && is_numeric($to_id)) {
                $to_user = get_user_by('id', $to_id);
            }
        } else {
                
            if(!$_POST['username']) {
                $error = "Please type a username";
            } else {
                $to_user = get_user_by('login', sanitize_text_field($_POST['username']));
                if(!$to_user instanceof WP_User) {
                    $error = "user does not exists";
                } else {
                    $action = 'compose';
                    $to_id = $to_user->ID;
                }
            }
            
            
            
        }
        
        if($error) {
            KSM_Js::setMessageSendError($error);
            die();
        }
            
        
        if($action != 'compose' || !$to_user instanceof WP_User || !$user_ID) {
            $error = "Error while sending message.";
        }
        
        
        $images = (Array) $_POST['multi_images'];
        $attachments = (Array) $_POST['attach'];
        
        $finial_images = array();
        $finial_attachments = array();
            
            
        foreach($attachments as $att) {
            if($att) {
                if(KSM_S3::can_user_attach($att)) {
                    $finial_attachments[] = $att;
                }
            }
        }
        
        
        foreach($images as $img) {
            if($img) {
                $img_attachment = get_post($img);
                if(ksm_can_user_attach_attachment($img_attachment, 'compose_photo_attachment')) {
                    $finial_images[] = $img_attachment;
                }
            }
        }



        if(!$error && (empty($finial_images) && empty($finial_attachments) && !$post_content)) {
            $error = "Please write something or attach a file or photo";
        }
        
        
        if($error) {
            KSM_Js::setMessageSendError($error);
            die();
        }
            
        $auth_user = wp_get_current_user();

        $title = $auth_user->user_login . " sent a message to ".$to_user->user_login;
        $message_id  = wp_insert_post(array(
            'post_title'    => $title,
            'post_content'  => $post_content,
            'post_type'     => 'ksm_message',
            'post_status'   => 'publish'
            ));
        
        $have_photos = $have_attachments = false;
        
        if($message_id) {
            
            
            
            update_post_meta($message_id, 'sent_from', $user_ID);
            update_post_meta($message_id, 'sent_to', $to_user->ID);
            update_post_meta($message_id, 'viewed', '0');
            update_post_meta($message_id, 'read', '0');
            
            $notification_count = get_number($to_user->inbox_news_count) + 1;
            update_user_meta($to_user->ID, 'inbox_news_count', $notification_count);
            
            
            
            update_user_meta($to_user->ID, 'inbox_messages_count', $this->count_user_messages($to_user->ID));
            
            foreach($finial_images as $img) {
                wp_update_post(array('ID' => $img->ID, 'post_parent' => $message_id));
                do_action('ksm_user_attach_attachment', $img->ID);
                $have_photos = true;
            }
            
            foreach($attachments as $att) {
                if(KSM_S3::add_attachment($att, $message_id, 'message_attachment')) {
                    $have_attachments = true;
                }
            }
            
            update_post_meta($message_id, 'have_photos', $have_photos);
            update_post_meta($message_id, 'have_attachments', $have_attachments);

            
            KSM_Js::MessageSent();

        }
        
        die();
    }
        
        
        
        
        
        
        
    function read_messages() {
        global $user_ID;
        
        
        
        $items = $_POST['items'] ? $_POST['items'] : array();
        $ids = array();
        foreach($items as $i) {
            if($i['value'] && is_numeric($i['value']) && $i['value'] > 0) {
                $ids[] = $i['value'];
            }
        }
        
        
        foreach($ids as $id) {
            echo get_post_meta($id, 'sent_to', true) . '|' . $user_ID;
            if(get_post_meta($id, 'sent_to', true) == $user_ID) {
                update_post_meta($id, 'read', '1');
            }
        }
        
    }
        
    function delete_messages() {
        global $user_ID;
        
        
        $items = $_POST['items'] ? $_POST['items'] : array();
        $ids = array();
        foreach($items as $i) {
            if($i['value'] && is_numeric($i['value']) && $i['value'] > 0) {
                $ids[] = $i['value'];
            }
        }
        
        $deleted = array();
        
        foreach($ids as $id) {
            if(get_post_meta($id, 'sent_to', true) == $user_ID) {
                wp_delete_post($id, true);
                $deleted[] = $id;
            }
        }
        
        update_user_meta($user_ID, 'inbox_messages_count', $this->count_user_messages($user_ID));
        
        $total_deleted = count($deleted);
        if($total_deleted > 0) {
            
            $user = wp_get_current_user();
            
            $rpp = KSM_MESSAGES_DROPDOWN_RESULTS_PER_PAGE;
            $total_pages = ceil(get_number($user->inbox_messages_count)/$rpp);

            $p = $_POST['p'] ? $_POST['p'] : 1;
            $p = (!is_numeric($p) || $p < 1) ? 1 : $p;
            
            if($p > $total_pages) {
                $p = $total_pages;
                $total_deleted = 0;
            }
            
            
            $this->dd_list_messages($total_deleted, $p);
        }
        
        
    }
        
        
    function dd_list_messages($max, $page) {
            
            global $user_ID;
            
            $user = wp_get_current_user();
            
            
            $html = '';
            
            $rpp = KSM_MESSAGES_DROPDOWN_RESULTS_PER_PAGE;
            $p = $page;
            $p = (!is_numeric($p) || $p < 1) ? 1 : $p;
            
            $total_pages = ceil(get_number($user->inbox_messages_count)/$rpp);
            
            $p = $p > $total_pages ? $total_pages : $p;
            
            if(get_number($user->inbox_messages_count) == 0) {
                ob_start();
                include KSM_VIEWS_PATH.'__Element/empty_dd_message_item.php';
                $html = ob_get_clean();
                $paging = false;
            } else {
                
                
                $messages = get_posts(array(
                    'post_type' => 'ksm_message',
                    'posts_per_page' => $rpp,
                    'paged' => $p,
                    'meta_query' => array(
                        array('key' => 'sent_to', 'value' => $user_ID)
                    )
                ));
                
                $inbox_news_count = get_number($user->inbox_news_count);
                
                if($inbox_news_count > 0) {
                    $inbox_news_count = $max ? $inbox_news_count - $max : $inbox_news_count - $rpp;
                    $inbox_news_count = $inbox_news_count < 1 ? 0 : $inbox_news_count;
                    update_user_meta($user_ID, 'inbox_news_count', $inbox_news_count);
                }
                
                
                $skip = $max ? $rpp - $max : 0;
                $c = 0;
                
                ob_start();
                foreach ($messages as $msg) {
                    if($skip > $c) {
                        continue;
                    }
                    include KSM_VIEWS_PATH .'__Element/dd_message_item.php';
                    $this->mark_viewed($msg->ID);
                    $c++;
                }
                $html = ob_get_clean();
                
                update_user_meta($user_ID, 'inbox_news_count', $this->count_news($user_ID));
                
                ob_start();
                include KSM_VIEWS_PATH.'__Element/dd_paging.php';
                $paging = ob_get_clean();
                
                
                
                
            }
            
            echo json_encode(
                    array(
                        'messages' => $html, 
                        'paging' => $paging,
                        'p' => $p
                    ));
            
            die();
            
        }
        
        
        
    function mark_viewed($mid) {
        $m = get_post($mid);
        if(!$m->viewed) {
            update_post_meta($mid, 'viewed', '1');
        }
    }
        
        
    function messages() {
        
        global $user_ID;
        
        $user = wp_get_current_user();
        
        
        $html = '';
        
        $rpp = KSM_MESSAGES_DROPDOWN_RESULTS_PER_PAGE;
        $total_pages = ceil(get_number($user->inbox_messages_count)/$rpp);
        
        $p = $_POST['p'] ? $_POST['p'] : 1;
        $p = (!is_numeric($p) || $p < 1) ? 1 : $p;
        $p = $p > $total_pages ? $total_pages : $p;
        
        $this->dd_list_messages(0, $p);
    }
    
    
    
    
}