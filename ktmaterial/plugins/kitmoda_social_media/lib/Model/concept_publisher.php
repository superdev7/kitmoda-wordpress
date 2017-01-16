<?php

class KSM_ConceptPublisherModel extends KSM_BaseModel {
    
    public $_data = array();
    
    
    
    public function __construct() {
        parent::__construct();
    }
    
    public function validate_images($return_data = false) {
        
        $images = (Array) $_POST['kpi'];
        
        $data = array();
        
        
        $featured_image = (Array) array_slice($images, 0, 1);
        $featured_image = $featured_image[0];
        $model = (Array) array_slice($images, 1, 10);
        
        $error = '';
        
        
        
        $data['featured'] =   '';
        $data['model'] =   array();
        
        
        
        
        $uploader = KSM_Uploader::get_uploader('utpi');
        
        
        if($uploader->isAttachable($featured_image)) {
            $data['featured'] = $featured_image;
        }
        
        
        foreach($model as $m) {
            if($uploader->isAttachable($m)) {
                $data['model'][] = $m;
            }
        }
        
        
        
        
        
        
        
        if(!$data['featured']) {
            $error = 'Featured Image is required';
        } elseif(count($data['model']) < 3) {
            $error = 'Please provide at least 3 model renders';
        }
        
        
        if($error) {
            $result =  array('error' => true, 'msg' => $error);
        } else {
            $result = array('success' => true);
            if($return_data) {
                $result['data'] = $data;
            }
        }
            
        return $result;
        
    }
    
    
    
    public function validate_notes($return_data = false) {
        
        $data = array();
        
        
        $data['notes'] = isset( $_POST[ 'notes' ] ) ? wp_kses( $_POST[ 'notes' ], fes_allowed_html_tags() ) : '';
        
        
        if($error) {
            $result =  array('error' => true, 'msg' => $error);
        } else {
            $result = array('success' => true);
            if($return_data) {
                $result['data'] = $data;
            }
        }
            
        return $result;
        
        
    }
    
    
    
    
    
    
    
    public function prepare_images($data = array(), $post_id) {
        
        ksm_set_post_thumbnail($post_id, $data['featured']);
        foreach((Array) $data['model'] as $attachment_id) {
            update_post_meta($attachment_id, 'img_cat', 'model');
            ksm_attach_attachment($attachment_id, $post_id);
        }
    }
    
    
    
    
    
    public function submit() {
        
        $KUser = KUser::get_instance();
        
        $step1_v_result = $this->validate_images(true);
        
        if($step1_v_result['error']) {
            KSM_Js::setPublisherError($step1_v_result['msg'], 1);
            exit;
        } 
        
        
        $step2_v_result = $this->validate_notes(true);
        if($step2_v_result['error']) {
            KSM_Js::setPublisherError($step2_v_result['msg'], 2);
            exit;
        }
        
        
        
        $images = $step1_v_result['data'];
        $notes = $step2_v_result['data'];
        
        
        
        
        
        
        
        
        
        
        
        
	
        
        $success_msg = "Concept collaboration is successfully posted";
        
	
		
        
        $post_args = array(
                'post_type' => 'ksm_collaboration',
		'post_status' => 'publish',
		'post_author' => $KUser->Auth->ID,
		//'post_title' => isset( $description['title'] ) ? sanitize_text_field( trim( $description['title'] ) ) : '',
                'post_title' => 'Concept art collaboration',
		'post_content' => $notes['notes']
        );
            
        $_post_id  = wp_insert_post($post_args);
        if($_post_id) {
            $this->add_images($images, $_post_id);
        }
        
            
            
        
        return array('success' => true , 'msg' => $success_msg);
        
        
    }
        
    
    
}