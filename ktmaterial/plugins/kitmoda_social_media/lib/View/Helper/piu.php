<?php



class KSM_uploaderHelper {
    public $minFiles = 0,
           $maxFiles = 0,
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
           $success_action_params = array();
    
    
    
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
            'nonce' => wp_create_nonce($nonce_key)
            
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
            <?=$this->obj_name?> = new kimgupl({
                m_p : {
                <?php foreach($this->multipart_params as $k=>$v) :
                    echo "'{$k}' : '{$v}',";
                endforeach;?>
                    
		},
                url : '<?=admin_url( 'admin-ajax.php' )?>',
                max_size : '<?=$this->max_size?>',
                file_types : '<?=$this->types?>',
                browse_button : '<?=$this->browse_button?>',
                container : '<?=$this->container?>', 
                drop_element : '<?=$this->drop_element?>',
                sortable : '<?=$this->sortable?>'
        });
        
        
        
        
        
        
        
        
        })
    
    </script>
        <?php
        
        
    }
    
    
    
    /**
     * 
     * @param string $action Ajax action name
     * @param string $nonce_action Key used to generate nonce
     * @param string $upload_type Unique upload identifier
     */
    
    static function upload_image($action, $nonce_action, $upload_type) {
        
        $file = $_FILES['async-upload'];
        $uploads = wp_upload_dir();
        $wp_filetype = wp_check_filetype(basename($file['name']), null );
        
        $result = array();
        
        check_ajax_referer($nonce_action);
        $upload = wp_handle_upload($_FILES['async-upload'], array('action' => $action));

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

            $preview = wp_get_attachment_image_src($attachment_id, 'medium');
            $result = array(
                'success'=>'1',
                'id' => $attachment_id,
                //'url' => wp_get_attachment_thumb_url($attachment_id),
                'url' => $preview[0]
            );
            
            do_action('ksm_user_upload_attachment', $attachment_id, $upload_type);
        } else {
            $result = array('success'=>'0');
        }
        
        echo json_encode($result);
        die();
        
        
    }
    
    
    
}





class KSM_piuHelper {
    
    public $scripts = array(
        
        array('piu', array('jquery', 'plupload-all'))
    );
    
    function __construct($args = array()) {
        
    }
    
    
    
    function render() {
        
        
        
        
        
        
        
        
        
        
    ?>
    <script type="text/javascript">
        var <?=$this->obj_name?>;
        $(function() {
            <?=$this->obj_name?> = new kimgupl({
                m_p : {
                <?php foreach($this->multipart_params as $k=>$v) :
                    echo "'{$k}' : '{$v}',";
                endforeach;?>
                    
		},
                url : '<?=admin_url( 'admin-ajax.php' )?>',
                max_size : '<?=$this->max_size?>',
                file_types : '<?=$this->types?>',
                browse_button : '<?=$this->browse_button?>',
                container : '<?=$this->container?>', 
                drop_element : '<?=$this->drop_element?>',
                sortable : '<?=$this->sortable?>'
        });
        
        
        
        
        
        
        
        
        })
    
    </script>
        
        <?php
    }
    
}







class KSM_Uploader {
    
    public $minFiles = 0,
           $maxFiles = 0,
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
           $success_action_params = array();
    
    
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
            'nonce' => wp_create_nonce($nonce_key)
            
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
            <?=$this->obj_name?> = new kimgupl({
                m_p : {
                <?php foreach($this->multipart_params as $k=>$v) :
                    echo "'{$k}' : '{$v}',";
                endforeach;?>
                    
		},
                url : '<?=admin_url( 'admin-ajax.php' )?>',
                max_size : '<?=$this->max_size?>',
                file_types : '<?=$this->types?>',
                browse_button : '<?=$this->browse_button?>',
                container : '<?=$this->container?>', 
                drop_element : '<?=$this->drop_element?>',
                sortable : '<?=$this->sortable?>'
        });
        
        
        
        
        
        
        
        
        })
    
    </script>
        <?php
        
        
    }
    
    
    
    /**
     * 
     * @param string $action Ajax action name
     * @param string $nonce_action Key used to generate nonce
     * @param string $upload_type Unique upload identifier
     */
    
    static function upload_image($action, $nonce_action, $upload_type) {
        
        $file = $_FILES['async-upload'];
        $uploads = wp_upload_dir();
        $wp_filetype = wp_check_filetype(basename($file['name']), null );
        
        $result = array();
        
        check_ajax_referer($nonce_action);
        $upload = wp_handle_upload($_FILES['async-upload'], array('action' => $action));

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

            $preview = wp_get_attachment_image_src($attachment_id, 'medium');
            $result = array(
                'success'=>'1',
                'id' => $attachment_id,
                //'url' => wp_get_attachment_thumb_url($attachment_id),
                'url' => $preview[0]
            );
            
            do_action('ksm_user_upload_attachment', $attachment_id, $upload_type);
        } else {
            $result = array('success'=>'0');
        }
        
        echo json_encode($result);
        die();
        
        
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
            $contentTypeStartWith
            ;
    
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
        $this->acl = $s3_acl;
        
        if($contentTypeStartWith) {
            $this->contentTypeStartWith = $contentTypeStartWith;
        }
        
        $this->key_starts_with = str_replace('{un}', $user_login, $key_starts_with);
        
        $this->setPolicy();
        $this->setSignature();
        $this->setMultipartParams();
        
        
    }
    
    
    
    
    
    public function setPolicy() {
        global $user_ID;
        
        
        $conditions = array(
                array('bucket' => $this->bucket),
                array('starts-with', '$key', $this->key_starts_with),
                array('success_action_status' => '201'),
            
            
                //array('starts-with', '$success_action_redirect', ''), 	
                array('starts-with', '$name', ''), 	
                array('starts-with', '$Filename', ''),
                array('starts-with', '$x-amz-meta-user_id', $user_ID),
                array('content-length-range', 0, $this->max_length ),
                //array('starts-with', '$chunk', ''), 
                //array('starts-with', '$chunks', ''),
            );
        
        
            $conditions[] = array('acl' => $this->acl);
            
            if($this->contentTypeStartWith)  {
                $conditions[] = array('starts-with', '$Content-Type', $this->contentTypeStartWith);
            }
        
            $this->policy = base64_encode(json_encode(array(
                'expiration' => date('Y-m-d\TH:i:s.000\Z', strtotime('+1 day')), 
                'conditions' => $conditions
            )));
        
    }
    
    
    public function setMultipartParams() {
        global $user_ID;
        
        $this->multipart_params = array(
            'key' => $this->key_starts_with . '/{id}/',
            'success_action_status' => '201',
            //'success_action_redirect' => admin_url( 'admin-ajax.php'),
            'Filename' => '${filename}',
            'x-amz-meta-user_id' => $user_ID,
            'AWSAccessKeyId' => $this->accessKeyId,
            'policy' => $this->policy,
            'signature' => $this->signature
        );
        
        
        $this->multipart_params['acl'] = $this->acl;
        
        
        
    }
    
    
    public function setSignature() {
        $this->signature = base64_encode(hash_hmac('sha1', $this->policy, $this->secret, true));
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
            <?=$this->obj_name?> = new ks3imgupl({
            m_p : {
                <?php foreach($this->multipart_params as $k=>$v) :
                    echo "'{$k}' : '{$v}',";
                endforeach;?>
                    
		},
                iss3: true,
                url : '<?=S3_URL?>',
                max_size : '<?=$this->max_size?>',
                file_types : '<?=$this->types?>',
                browse_button : '<?=$this->browse_button?>',
                container : '<?=$this->container?>', 
                drop_element : '<?=$this->drop_element?>',
                sa : <?=json_encode($this->success_action_params)?>,
                setCT : <?=($this->contentTypeStartWith ? 'true' : false)?>,
                sortable : '<?=$this->sortable?>'
        });
        
        
        
        
        
        
        
        
        })
    
    </script>
        <?php
        
        
    }
    
}



class KSM_Image_Uploader extends KSM_Uploader {
    
    public function __construct($args) {
        
        
        parent::__construct($args);
    }
    
}















?>