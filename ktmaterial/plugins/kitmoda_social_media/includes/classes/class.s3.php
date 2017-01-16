<?php

require_once KSM_BASE_PATH . 'includes/aws/aws-autoloader.php';
use Aws\S3\S3Client;
use Aws\Common\Aws;

class KSM_S3 {
    
    
    
    
    static function add_attachment($key, $post_id=0, $type='') {
        
        $post_author = get_current_user_id();
        
        $wp_filetype = wp_check_filetype(basename($key), null );
        $attachment_id = 0;
        $guid = S3_URL . $key;
        $attachment = array(
            'guid' => $guid,
            'post_mime_type' => $wp_filetype['type'],
            'post_title'     => preg_replace( '/\.[^.]+$/', '', basename($key) ),
            'post_content' => '',
            'post_status' => 'inherit',
            'post_author' => $post_author
            );
        $attachment_id = wp_insert_attachment( $attachment, $guid, $post_id );

        if($attachment_id) {
            $attach_data = wp_generate_attachment_metadata( $attachment_id, $guid );
            wp_update_attachment_metadata( $attachment_id, $attach_data );
            update_post_meta($attachment_id, 's3_file_key', $key);
            update_post_meta($attachment_id, 'user_upload_type', $type);
            self::clearTemp($key);
        }
        
        return $attachment_id;
    }
    
    
    static function clearTemp($key){
        global $wpdb;
        
        if($key) {
            $wpdb->delete( $wpdb->prefix. EDD_FES_S3_UPLOADS_TABLE, array('s3_key' => $key), array( '%s') );
        }
    }
    
    static function can_user_attach($key) {
        global $user_ID;
        $tmp = self::getTempObject($key);
        //if($tmp && $tmp->user_id == $user_ID && self::objectExistsOnAmazon($key)) {
        //    return true;
        //}
        
        if($tmp && $user_ID && $tmp->user_id == $user_ID) {
            return true;
        }
        return false;
    }
    
    
    
    static function compose_upload_success() {
        global $user_ID, $user_login, $wpdb;
        $key = sanitize_key($_POST['k']);
        $starts_width = "ksm/attachments/{$user_login}/";
        
        if($key && $user_login && (preg_match("#^{$starts_width}#", $key) === 1)) {
            if(self::objectExistsOnAmazon($key)) {
                self::addTempObject($key);
            }
        }
        die();
    }
    
    
    
    
    static function download_attach($keys = array(), $post_id, $type='') {
        
        $attachments = self::attach_files($keys, $post_id, $type);
        
        
        $condition = 0;
        foreach((Array) $attachments['ids'] as $att) {
            
            $att_post = get_post($att);
            $new_list[$condition] = array(
                'name' => basename($att_post->guid),
                'file' => $att_post->guid,
                'condition' => $condition,
                'attachment_id' => $att
            );
            $condition++;
        }
        
        update_post_meta( $post_id, 'edd_download_files', $new_list );
        
    }


    
    
    
    
    static function attach_files( $keys = array(), $post_id, $type='') {
        
        
        $current_s3_files = (Array) get_post_meta( $post_id, 'files', true );
        $deleteable_files = $new_list = $new = $existing_keys = array();
        
        $final_list = array('keys'=>array(), 'ids' => array());
        
        
        foreach($current_s3_files as $f) {
            $key = get_post_meta($f, 's3_file_key', true);
            if(in_array($key, $keys)) {
                $final_list['keys'][] = $key;
                $final_list['ids'][] = $f;
            } else {
                $deleteable_files[] = $f;
            }
        }
        
        
        foreach($keys as $k) {
            if(!in_array($k, $final_list['keys'])) {
                $attachment_id = self::add_attachment($k, $post_id, $type);
                if($attachment_id) {
                    $final_list['keys'][] = $k;
                    $final_list['ids'][] = $attachment_id;
                }
            }
        }
        
        
        foreach($deleteable_files as $d) {
            wp_delete_attachment($d, true);
        }
        
        update_post_meta( $post_id, 'files', $final_list['ids'] );
        
        return $final_list;
    }
    
    
    
    
    static function upload_success_action() {
        
        
        global $user_ID, $user_login, $wpdb;
        
        $uploader_name = sanitize_text_field($_POST['up_name']);
        $key = sanitize_key($_POST['k']);
        
        $result = array('success' => false);
        
        if($uploader_name && $key && $user_login) {
            
            $upload = KSM_Uploader::get_uploader($uploader_name);
            if($upload instanceof KSM_Uploader) {
                if(preg_match("#^{$upload->s3_params['key']}#", $key) === 1) {
                    if(self::objectExistsOnAmazon($key)) {
                        self::addTempObject($key);
                        $result = array('success' => true, 'k' => $key);
                    }
                }
            }
        }
        
        
        echo json_encode($result);
        die();
        
    }
    
    
    
    static function objectExistsOnAmazon($key) {
        $s3 = S3Client::factory(array('key' => S3_ACCESS_KEY_ID,'secret' => S3_SECRET));
        return $s3->doesObjectExist(S3_BUCKET, $key);
    }
    
    
    
    static function deleteObject($key) {
        if(!$key || $key == '') {
            return;
        }
        
        $s3 = S3Client::factory(array('key' => S3_ACCESS_KEY_ID,'secret' => S3_SECRET));   
        if(self::objectExistsOnAmazon($key)) {
            $s3->deleteObject(array('Bucket' => S3_BUCKET, 'Key' => $key));
        }
    }


    
    static function isTempObject($key) {
        if(self::getTempObject($key)) {
            return true;
        }
        return false;
    }
    
    static function getTempObject($key) {
        global $wpdb;
        
        
        $tbl = $wpdb->prefix . EDD_FES_S3_UPLOADS_TABLE;
        
        $q = "SELECT * FROM {$tbl} WHERE s3_key = %s";
        $res = $wpdb->get_results($wpdb->prepare($q, $key));
        return $res[0];
    }
    
    static function addTempObject($key) {
        global $user_ID, $wpdb;
        $wpdb->insert(
                $wpdb->prefix. EDD_FES_S3_UPLOADS_TABLE, 
                array('user_id' =>  $user_ID, 's3_key' => $key, 'date' => time()), 
                array( '%d', '%s' , '%d')
                );
        
    }
    
    
    
    static function signKey($file_key) {
        $s3 = S3Client::factory(array('key' => S3_ACCESS_KEY_ID,'secret' => S3_SECRET));
        
        $requested_file = '';
        
        if($file_key) {
            if(@$s3->doesObjectExist(S3_BUCKET, $file_key)) {
                $requested_file = @$s3->getObjectUrl(S3_BUCKET, $file_key, S3_DOWNLOAD_EXPIRE_TIME);
            } 
        }
        
        return $requested_file;
    }
    
    
}