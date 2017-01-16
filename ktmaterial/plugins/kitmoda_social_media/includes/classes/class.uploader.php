<?php

class KSM_Uploader {
    
    public $min_files = 0,
           $max_files = 0,
           $max_size,
           $types,
           $obj_name,
           $browse_button,
           $container,
           $drop_element,
           $sortable,
           $action, 
           $action_type,
           $name,
           $uploader_name,
           $js_class,
           $preview_size,
           $queue_item,
           $queue_element,
           $success_action_params = array(),
           $js_params,
           $empty_div,
           $setCT
            
           ;
    
    
    public function __construct($args) {
        
        foreach($args as $key => $val) {
            if(property_exists($this, $key)) {
                $this->{$key} = $val;
            }
        }
        
        
        
        if($this->max_size) {
            $this->max_length = (int) $this->max_size * (1024 * 1024);
        }
        
        $this->setMultipartParams();
        
        
        $this->url = admin_url( 'admin-ajax.php' );
        
        
    }
    
    public function nonce_key() {
        $nonce_key = $this->action;
        if($this->action_type) {
            $nonce_key .= "_{$this->action_type}";
        }
        return $nonce_key;
    }
    
    
    
    public function setMultipartParams() {
        global $user_ID;
        
        
        $nonce_key = $this->nonce_key();
        
        $this->multipart_params = array(
            'action' => $this->action,
            '_ajax_nonce' => wp_create_nonce($nonce_key)
            
        );
        
        if($this->action_type) {
            
            $this->multipart_params['at'] = $this->action_type;
            
        }
    }
    
    
    
    
    
    
    
    
    
    public function build() {
        global $user_ID, $user_login;
        
        if(!$user_ID || !$user_login) {
            return;
        }
        
        wp_enqueue_script('plupload-all');
        
        
        
        
        
        
    ?>
    <script type="text/javascript">
        var <?=$this->obj_name?>;
        $(function() {
            <?=$this->obj_name?> = new <?=$this->js_class?>({
                m_p : {
                <?php foreach($this->multipart_params as $k=>$v) :
                    echo "'{$k}' : '{$v}',";
                endforeach;?>
                    
		},
                url : '<?=$this->url?>',
                max_size : '<?=$this->max_size?>',
                file_types : '<?=$this->types?>',
                browse_button : '<?=$this->browse_button?>',
                container : '<?=$this->container?>', 
                drop_element : '<?=$this->drop_element?>',
                sortable : '<?=$this->sortable?>',
                queue_item : '<?=$this->queue_item?>',
                queue_element : '<?=$this->queue_element?>',
                empty_div : '<?=$this->empty_div?>',
                iss3: '<?=$this->isS3?>',
                sa : <?=json_encode($this->success_action_params)?>,
                setCT : '<?=$this->setCT?>',
                max_files : <?=$this->max_files?>
        });
        
        
        
                
                
        
        
        
        
        
        })
    
    </script>
        <?php
        
        
    }
    
    
    static function get_uploader($name = '') {
        
        if($name) {
            $config = self::get_config($name);
        
        
            if(!empty($config)) {
                $cls_name = $config['uploader_class'];
                $config['uploader_name'] = $name;
                return new $cls_name($config);
            }
        }
        
        
        
        return null;
        
    }
    
    
    static function get_config($name) {
        return KSM_DataStore::Option('uploader', $name);
    }
    
    
    static function build_uploader($name) {
        $uploader = self::get_uploader($name);
        if($uploader) {
            $uploader->build();
        }
    }
    
    
    static function build_aunular_uploader() {
        $uploader = self::get_uploader($name);
        if($uploader) {
            
            $uploader->build();
        }
    }
    
    
    
    static function handle_upload() {
        
        $uploader = self::get_uploader($_POST['at']);
        
        if($uploader) {
            $uploader->do_upload();
        }
    }
    
    
    function getAttachables($attachments = array()) {
        
        $attachables = array();
        
        foreach($attachments as $att) {
            if($this->isAttachable($att)) {
                $attachables[] = $att;
            }
        }
        
        return $attachables;
        
    }
    
    function isAttachable($attachment_id = 0) {
        
        if($attachment_id) {
            $attachment = get_post($attachment_id);
            if($attachment && ksm_can_user_attach_attachment($attachment, $this->name)) {
                return true;
            }
        }
        
        return false;
    }
    
    function attach_attachments($attachments = array(), $post_id) {
        
        foreach((Array) $attachments as $att) {
            ksm_attach_attachment($att, $post_id);
        }
        
    }
    
}




class KSM_S3_Uploader extends KSM_Uploader {
    
    public $multipart_params,
            $policy,
            $bucket,
            $accessKeyId,
            $secret,
            $acl,
            $key_starts_with,
            $contentTypeStartWith,
            $s3_params,
            $js_class = 'ks3uplr';
    
    public function __construct($args) {
        
        global $user_ID, $user_login;
        
        if(!$user_ID || !$user_login) {
            return;
        }
        
        parent::__construct($args);
        
        extract($args);
        
        $this->bucket = S3_BUCKET;
        $this->accessKeyId = S3_ACCESS_KEY_ID;
        $this->secret = S3_SECRET;
        //$this->acl = $s3_acl;
        $this->isS3 = true;
        $this->url = S3_URL;
        
        
        $s3_params = (Array) $s3;
        
        $this->s3_params = (Array) $s3_params;
        
        //if($contentTypeStartWith) {
        //    $this->contentTypeStartWith = $contentTypeStartWith;
        //}
        
        
        $this->success_action_params = (Array) $this->s3_params['success_action_params'];
        $this->success_action_params['up_name'] = $this->uploader_name;
        
        $this->s3_params['key'] = str_replace('{un}', $user_login, $this->s3_params['key']);
        
        $this->setPolicy();
        $this->setSignature();
        $this->setMultipartParams();
        
        
    }
    
    
    
    
    
    public function setPolicy() {
        global $user_ID;
        
        
        
        
        
        $this->s3_conditions[] = array('bucket' => $this->bucket);
        $this->s3_conditions[] = array('success_action_status' => '201');
        $this->s3_conditions[] = array('acl' => $this->s3_params['acl']);
        $this->s3_conditions[] = array('starts-with', '$key', $this->s3_params['key']);
        $this->s3_conditions[] = array('starts-with', '$name', '');
        $this->s3_conditions[] = array('starts-with', '$Filename', '');
        $this->s3_conditions[] = array('starts-with', '$x-amz-meta-user_id', $user_ID);
        $this->s3_conditions[] = array('content-length-range', 0, $this->max_length );
        
        
        if($this->s3_params['Content-Type'])  {
            $this->s3_conditions[] = array('starts-with', '$Content-Type', $this->s3_params['Content-Type']);
            $this->setCT = true;
        }
        
        //$conditions = array(
            //array('starts-with', '$chunk', ''), 
            //array('starts-with', '$chunks', ''),
        //);
        
        $this->policy = base64_encode(json_encode(array(
            'expiration' => date('Y-m-d\TH:i:s.000\Z', strtotime('+1 day')), 
            'conditions' => $this->s3_conditions
        )));
        
    }
    
    
    public function setMultipartParams() {
        global $user_ID;
        
        $this->multipart_params = array(
            'key' => $this->s3_params['key'] . '/{id}/',
            'success_action_status' => '201',
            'Filename' => '${filename}',
            'x-amz-meta-user_id' => $user_ID,
            'AWSAccessKeyId' => $this->accessKeyId,
            'policy' => $this->policy,
            'signature' => $this->signature,
            'acl' => $this->s3_params['acl']
        );
        
        
    }
    
    
    public function setSignature() {
        $this->signature = base64_encode(hash_hmac('sha1', $this->policy, $this->secret, true));
    }
    
    
}



class KSM_Image_Uploader extends KSM_Uploader {
    
    public function __construct($args) {
        parent::__construct($args);
    }
    
    
    
    public function do_upload() {
        
        $file = $_FILES['async-upload'];
        $uploads = wp_upload_dir();
        $wp_filetype = wp_check_filetype(basename($file['name']), null );
        
        $result = array();
        
        check_ajax_referer($this->nonce_key());
        $upload = wp_handle_upload($_FILES['async-upload'], array('action' => $this->action));

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
            
            
            $sizes = explode(',', $this->preview_size);
            $previews = array();
            foreach ($sizes as $s) {
                $s = trim($s);
                $pa = wp_get_attachment_image_src($attachment_id, $s);
                $previews[$s] = $pa[0];
            }
            
            
            
            $preview = reset($previews);
            $result = array(
                'success'=>'1',
                'id' => $attachment_id,
                'url' => $preview,
                'sizes' => $previews
            );
            
            do_action('ksm_user_upload_attachment', $attachment_id, $this->name);
        } else {
            $result = array('success'=>'0');
        }
        
        echo json_encode($result);
        die();
        
        
    
        
    }
    
    
}


class KSM_Publisher_Image_Uploader extends KSM_Image_Uploader {
    
    public function __construct($args) {
        parent::__construct($args);
    }
    
}















?>