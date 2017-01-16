<?php

class KSM_UntexturedPublisherModel extends KSM_BaseModel {
    
    public $image_uploader_name = 'tpi',
           $_data = array();
    
    
    
    public function __construct() {
        parent::__construct();
    }
    
    public function validate_images($return_data = false) {
        
        $images = (Array) $_POST['kcci'];
        
        $data = array();
        
        
        $featured_image = (Array) array_slice($images, 0, 1);
        $featured_image = $featured_image[0];
        $textured = (Array) array_slice($images, 1, 5);
        $untextured = (Array) array_slice($images, 6, 5);
        $wireframe = (Array) array_slice($images, 11, 5);
        
        $error = '';
        
        
        
        $data['featured'] =   '';
        $data['textured'] =   array();
        $data['untextured'] = array();
        $data['wireframe'] =  array();
        
        
        $uploader = KSM_Uploader::get_uploader('tpi');
        
        
        if($uploader->isAttachable($featured_image)) {
            $data['featured'] = $featured_image;
        }
        
        
        foreach($textured as $ta) {
            if($uploader->isAttachable($ta)) {
                $data['textured'][] = $ta;
            }
        }
        
        foreach($untextured as $uta) {
            if($uploader->isAttachable($uta)) {
                $data['untextured'][] = $uta;
            }
        }
        
        foreach($wireframe as $wa) {
            if($uploader->isAttachable($wa)) {
                $data['wireframe'][] = $wa;
            }
        }
        
        
        
        if(!$data['featured']) {
            $error = 'Featured Image is required';
        } elseif(count($data['textured']) < 3) {
            $error = 'Please provide at least 3 textured images';
        }elseif(count($data['untextured']) < 3) {
            $error = 'Please provide at least 3 untextured images';
        }elseif(count($data['wireframe']) < 3) {
            $error = 'Please provide at least 3 wireframe images';
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
    
    
    
    public function validate_description($return_data = false) {
        
        $data = array();
        
        $data['title'] = sanitize_text_field( trim( $_POST[ 'title' ] ));
        $data['description'] = isset( $_POST[ 'description' ] ) ? wp_kses( $_POST[ 'description' ], fes_allowed_html_tags() ) : '';
        $data['keywords'] = isset( $_POST[ 'keywords' ] ) ? wp_kses( $_POST[ 'keywords' ], array() ) : '';
        
        
        $data['category'] = is_array($_POST['category']) ? end($_POST['category']) : '';
        
        $data['category'] = $data['category'] ? $data['category'] : '';
        
        
        //pr($data['category']);
        //echo $cat_tax->term_exist($data['category']);
        
        $cat_tax = new KSM_Taxonomy('category');
        $style_tax = new KSM_Taxonomy('style');
        $era_tax = new KSM_Taxonomy('era');
        $culture_tax = new KSM_Taxonomy('culture');
        
        
        
        
        
        if($data['category']) {
            if($cat_tax->term_exists($data['category'],'id') && !$cat_tax->get_children($data['category'])) {
                
            } else {
                $data['category'] = "";
            }
        }
        
        
        $data['style'] = $_POST['style'] ? $_POST['style'] : '';
        $data['era'] = $_POST['era'] ? $_POST['era'] : '';
        $data['culture'] = $_POST['culture'] ? $_POST['culture'] : ''; 
        
        
        
        if($data['style'])
            if(!$style_tax->term_exists($data['style'], 'id'))
                $data['style'] = "";
            
        if($data['era']) 
            if(!$era_tax->term_exists($data['era'], 'id'))
                $data['era'] = "";
            
            
        if($data['culture']) 
            if(!$culture_tax->term_exists($data['culture'], 'id')) 
                $data['culture'] = "";
            
        
        
        
        $data['textured_price'] = sanitize_text_field($_POST['textured_price']);
        $data['untextured_price'] = sanitize_text_field($_POST['untextured_price']);
        
        $data['sell_type'] = sanitize_text_field($_POST['sell_type']);
        
        $validate_fields = array('title', 'description', 'category', 'style', 'era', 'culture', 'textured_price');
        
        if($data['sell_type'] == '2') {
            $validate_fields[] = 'untextured_price';
        }
        
        
        
        
        
        
        $v = new KSM_Validator($data);
        
        $v->rule('required', $validate_fields);
        
        
        if($v->validate()) {
            
            
            
            if($data['sell_type'] != '1' && $data['sell_type'] != '2') {
                $error = "Invalid Sell Type.";
            }
            
            elseif(!(filter_var($data['textured_price'], FILTER_VALIDATE_INT) || 
                    filter_var($_POST['textured_price'], FILTER_VALIDATE_FLOAT))) {
                $error = "Invalid Textured Price.";
            } elseif((!(filter_var($data['untextured_price'], FILTER_VALIDATE_INT) || 
                    filter_var($_POST['untextured_price'], FILTER_VALIDATE_FLOAT))) && $data['sell_type'] == '2') {
                $error = "Invalid Untextured Price.";
            } elseif(!$_POST['terms_agreed'] == 'yes') {
                $error = "You must agree to the terms";
            }
            
        } else {
            $ak = array_keys($v->errors());
            $error = array_shift(array_shift($v->errors()));
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
    
    
    
    public function validate_tech($return_data = false) {
        
        
        $data = array();
        
        $modeling_methods = (Array) $_POST['modeling_method'];
        $mappings = (Array) $_POST['mapping'];
        $other_file_formats = (Array) $_POST['other_file_formats'];
        
        
        $data['environment'] = sanitize_text_field($_POST['environment']);
        $data['primary_file_format'] = sanitize_text_field($_POST['primary_file_format']);
        $data['poly_count'] = sanitize_text_field($_POST['poly_count']);
        $data['organization'] = sanitize_text_field($_POST['organization']);
        $data['world_scale'] = sanitize_text_field($_POST['world_scale']);
        $data['print_ready'] = sanitize_text_field($_POST['print_ready']);
        $data['game_ready'] = sanitize_text_field($_POST['game_ready']);
        $data['model_quads'] = sanitize_text_field($_POST['model_quads']);
        $data['renderer'] =sanitize_text_field($_POST['renderer']);
        $data['lighting'] = sanitize_text_field($_POST['lighting']);
        $data['bake_lighting'] = sanitize_text_field($_POST['bake_lighting']);
        $data['texturing_method'] = sanitize_text_field($_POST['texturing_method']);
        $data['unwrap'] = sanitize_text_field($_POST['unwrap']);
        
        
        $data['other_file_formats'] = array();
        $data['modeling_method'] = array();
        $data['mapping'] = array();
        
        
        
        foreach($modeling_methods as $mm) 
            if($mm && KSM_DataStore::Term_Exist('modeling_method', $mm))
                $data['modeling_method'][] = $mm;
            
        
        foreach($mappings as $m)
            if($m && KSM_DataStore::Term_Exist('mapping', $m))
                $data['mapping'][] = $m;
            
        foreach($other_file_formats as $of)
            if($of && KSM_DataStore::Term_Exist('file_format', $of))
                $data['other_file_formats'][] = $of;
        
        
        
        
        
        
        if(empty($data['modeling_method'])) {
            $error = "Please Select : Modeling Method";
        }
        
        elseif(!($data['environment'] && KSM_DataStore::Term_Exist('environment',$data['environment']))) {
            $error = "Please Select : Entire Environment or Single Object";
        }
        
        elseif(!($data['primary_file_format'] && KSM_DataStore::Term_Exist('file_format', $data['primary_file_format']))) {
            $error = "Please Select : Primary File Format";
        } 
        
        elseif(!($data['poly_count'] && is_numeric($data['poly_count']) && $data['poly_count'] > 0)) {
            $error = "Polygon count should be a number";
        } 
        
        elseif(!($data['organization'] && KSM_DataStore::Term_Exist('organization', $data['organization']))) {
            $error = "Please Select : Are the Objects Named and Organized";
        }
        
        
        elseif(!($data['world_scale'] && KSM_DataStore::Term_Exist('world_scale', $data['world_scale']))) {
            $error = "Plesae Select : Does the model match real world scale";
        }
        
        
        elseif(!($data['print_ready'] && KSM_DataStore::Term_Exist('print_ready',$data['print_ready']))) {
            $error = "Please Select : Is the Model 3D print ready";
        }
        
        
        elseif(!($data['game_ready'] && KSM_DataStore::Term_Exist('game_ready',$data['game_ready']))) {
            $error = "Please Select : Is the model Game and Realtime Rendering Ready";
        }
        
        
        elseif(!($data['model_quads'] && KSM_DataStore::Term_Exist('model_quads',$data['model_quads']))) {
            $error = "Please Select : Is the model quads";
        }
        
        
        elseif(!($data['renderer'] && KSM_DataStore::Term_Exist('renderer',$data['renderer']))) {
            $error = "Please Select : What renderer was used for the featured image";
        }
        
        elseif(!($data['lighting'] && KSM_DataStore::Term_Exist('lighting',$data['lighting']))) {
            $error = "Please Select : Is the lighting setup included within the main file";
        }
        
        elseif(!($data['bake_lighting'] && KSM_DataStore::Term_Exist('bake_lighting',$data['bake_lighting']))) {
            $error = "Please Select : Did you bake the lighting into the textures";
        }
        
        elseif(empty($data['mapping'])) {
            $error = "Please Select : Which map types were used to render details";
        }
        
        elseif(!($data['texturing_method'] && KSM_DataStore::Term_Exist('texturing_method',$data['texturing_method']))) {
            $error = 'Please Select : How were the textures created';
        }
        
        elseif(!($data['unwrap'] && KSM_DataStore::Term_Exist('unwrap',$data['unwrap']))) {
            $error = 'Please Select : How was the model unwrapped';
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
    
    
    
    public function validate_upload($return_data = false) {
        
        $data = array();
        $data['textured_file'] = sanitize_file_name($_POST['tpf']);
        $data['untextured_file'] = sanitize_file_name($_POST['utpf']);
        
        $sell_type = sanitize_text_field($_POST['upload_sell_type']);
        
        if(!($data['textured_file'] && KSM_S3::can_user_attach($data['textured_file']))) {
            $error = "Textured Model is required.";
        }
        
        if($sell_type == 2 && !$error) {
            if(!($data['untextured_file'] && KSM_S3::can_user_attach($data['untextured_file']))) {
                $error = "Untextured Model is required.";
            }
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
    
    
    public function prepare_untextured_images($data) {
        
        $images = array();
        $images['featured'] = ksm_copy_image_attachment($data['featured']);
                
        foreach((Array) $data['textured'] as $img) {
            $images['textured'] = ksm_copy_image_attachment($img);
        }
        foreach((Array) $data['untextured'] as $img) {
            $images['untextured'] = ksm_copy_image_attachment($img);
        }
        foreach((Array) $data['wireframe'] as $img) {
            $images['wireframe'] = ksm_copy_image_attachment($img);
        }
        
        
        $this->prepare_images($images, 'untextured');
        
                
    }
    
    public function prepare_images($data = array(), $type = 'textured') {
        
        
        $this->_data[$type]['ksm_set_post_thumbnail'][] = array('post_id', $data['featured']);
        
        
        foreach((Array) $data['textured'] as $img) {
            $this->_data[$type]['update_post_meta'][] = array($img, 'img_cat', 'textured');
            $this->_data[$type]['ksm_attach_attachment'][] = array($img, 'post_id');
        }
        
        foreach((Array) $data['untextured'] as $img) {
            $this->_data[$type]['update_post_meta'][] = array($img, 'img_cat', 'untextured');
            $this->_data[$type]['ksm_attach_attachment'][] = array($img, 'post_id');
        }
        
        
        foreach((Array) $data['wireframe'] as $img) {
            $this->_data[$type]['update_post_meta'][] = array($img, 'img_cat', 'wireframe');
            $this->_data[$type]['ksm_attach_attachment'][] = array($img, 'post_id');
        }
        
    }
    
    
    public function prepare_description($data = array(), $type = 'textured') {
        
        $KUser = KUser::get_instance();
        
        //$cat_tax = new KSM_Taxonomy('category');
        //$style_tax = new KSM_Taxonomy('style');
        //$era_tax = new KSM_Taxonomy('era');
        //$culture_tax = new KSM_Taxonomy('culture');
        
        //$cat_tax->set_terms($post_id, array((int) $data['category']));
        //$style_tax->set_terms($post_id, array((int) $data['style']));
        //$era_tax->set_terms($post_id, array((int) $data['era']));
        //$culture_tax->set_terms($post_id, array((int) $data['culture']));
        
        
        
        $this->_data[$type]['wp_set_post_terms'][] = array('post_id', array((int) $data['category']), 'category');
        $this->_data[$type]['wp_set_post_terms'][] = array('post_id', array((int) $data['style']), 'ksm_tax_style');
        $this->_data[$type]['wp_set_post_terms'][] = array('post_id', array((int) $data['era']), 'ksm_tax_era');
        $this->_data[$type]['wp_set_post_terms'][] = array('post_id', array((int) $data['culture']), 'ksm_tax_culture');
        
        
        
        
        // setup keywords;
        
        
        
        $price_key = "{$type}_price";
        
        $price = $data[$price_key];
        
        $prices = array();
        $prices[] = array(
            'name' => ucfirst($type) . ' Model Price',
            'amount' => $price,
        );
        
        
        if (!isset( $prices[ 0 ][ 'amount' ] ) ){
            $prices[ 0 ][ 'amount' ] = "";
        }
        
        
        
        $price_tax = new KSM_Taxonomy('price');
        
        $price_term = $price_tax->value_to_term($price);
        
        if($price_term) {
            $this->_data[$type]['wp_set_post_terms'][] = array('post_id', array((int) $price_term->term_id), 'ksm_tax_price');
        }
        
        $this->_data[$type]['update_post_meta'][] = array('post_id', '_variable_pricing', 0);
        $this->_data[$type]['update_post_meta'][] = array('post_id', 'edd_price', $price);
        $this->_data[$type]['update_post_meta'][] = array('post_id', 'edd_variable_prices', $prices);
        $this->_data[$type]['update_post_meta'][] = array('post_id', 'product_type', $type);
        
        
        
        
        
        $TexturedModelCommission = KSM_DataStore::Option('Commission', 'TexturedModel');
        
        if ( EDD_FES()->integrations->is_commissions_active()) {
            $commission = array(
                'amount' => $TexturedModelCommission['artist']['amount'],
                'user_id' => $KUser->Auth->ID,
                'type' => $TexturedModelCommission['artist']['type']
                );
            
            $this->_data[$type]['update_post_meta'][] = array('post_id', '_edd_commission_settings', $commission);
            $this->_data[$type]['update_post_meta'][] = array('post_id', '_edd_commisions_enabled', '1');
            
            //update_post_meta( $post_id, '_edd_commission_settings', $commission );
            //update_post_meta( $post_id, '_edd_commisions_enabled', '1' );
        }
            
        
    }
    
    
    public function prepare_tech($data = array(), $type = 'textured') {
        
        $term_ids = array();
        
        foreach($this->tech_taxonomy_fields as $k => $v) {
            
            $multi = false;
            
            if(is_array($v)) {
                $f_name = $k;
                $tax_name = $v['tax'] ? $v['tax'] : $k;
                $multi = $v['multi'] ? true : false;
            } else {
                $f_name = $tax_name = $v;
            }
            
            $tax = new KSM_Taxonomy($tax_name);
            
            
            
            if($multi) {
                foreach((Array) $data[$f_name] as $m) {
                    $term = $tax->value_to_term($m);
                    if($term) {
                        $term_ids[$tax_name][] = (int) $term->term_id;
                    }
                }
            } else {
                $term = $tax->value_to_term($data[$f_name]);
                if($term) {
                    $term_ids[$tax_name][] = (int) $term->term_id;
                }
            }
            
            
        }
        
        
        foreach($term_ids as $tax_name => $_ids) {
            $tax = new KSM_Taxonomy($tax_name);
            $this->_data[$type]['wp_set_post_terms'][] = array('post_id', $_ids, $tax->key);
        }
        
        $this->_data[$type]['update_post_meta'][] = array('post_id', 'primary_file_format', $data['primary_file_format']);
        $this->_data[$type]['update_post_meta'][] = array('post_id', 'poly_count', $data['poly_count']);
    }
    
    
    
    public function prepare_upload($data = array(), $type = 'textured') {
        
        $edd_files = array();
        
        $file_data_key = "{$type}_file";
        
        $edd_files[0] = array(
            'name' => basename( $data[$file_data_key] ),
            'file' => $data[$file_data_key],
            'condition' => '0'
	);
        
        
        $this->_data[$type]['KSM_S3::download_attach'][] = array(array($data[$file_data_key]), 'post_id', $file_data_key);
        $this->_data[$type]['update_post_meta'][] = array('post_id', 'edd_download_files', $edd_files);
        
    }
    
    public function submit() {
        
        $KUser = KUser::get_instance();
        
        $step1_v_result = $this->validate_images(true);
        
        if($step1_v_result['error']) {
            KSM_Js::setPublisherError($step1_v_result['msg'], 1);
            exit;
        } 
        
        
        $step2_v_result = $this->validate_description(true);
        if($step2_v_result['error']) {
            KSM_Js::setPublisherError($step2_v_result['msg'], 2);
            exit;
        }
        
        $step3_v_result = $this->validate_tech(true);
        if($step3_v_result['error']) {
            KSM_Js::setPublisherError($step3_v_result['msg'], 3);
            exit;
        }
        
        $step4_v_result = $this->validate_upload(true);
        if($step4_v_result['error']) {
            KSM_Js::setPublisherError($step4_v_result['msg'], 4);
            exit;
        }
        
        
        $images = $step1_v_result['data'];
        $description = $step2_v_result['data'];
        $tech = $step3_v_result['data'];
        $upload = $step4_v_result['data'];
        
        $this->prepare_images($images, 'textured');
        $this->prepare_description($description, 'textured');
        $this->prepare_tech($tech, 'textured');
        $this->prepare_upload($upload, 'textured');
        
        if($description['sell_type'] == 2) {
            $this->prepare_untextured_images($images);
            $this->prepare_description($description, 'untextured');
            $this->prepare_tech($tech, 'untextured');
            $this->prepare_upload($upload, 'untextured');
        }
        
        
        
        
        
	$status = 'publish';
        
        $success_msg = "Your model successfully posted";
        
	if ( ! EDD_FES()->helper->get_option( 'fes-auto-approve-submissions', false ) ) {
            $status  = 'pending';
            $success_msg = "Your model submitted for approval";
	}
		
        
        
        
            
            
        foreach($this->_data as $type => $tdata) {
            
            
            
            
            
            $post_args = array(
                'post_type' => 'download',
		'post_status' => $status,
		'post_author' => $KUser->Auth->ID,
		'post_title' => isset( $description['title'] ) ? sanitize_text_field( trim( $description['title'] ) ) : '',
		'post_content' => isset( $description['description'] ) ? wp_kses( $description['description'], fes_allowed_html_tags() ) : ''
            );
            
            
            
            
            $_post_id  = wp_insert_post($post_args);
            
            if($_post_id) {
                wp_set_post_terms($_post_id, $description['keywords'], 'ksm_tax_keyword');
                foreach($tdata as $fun_name => $fun_args) {
                    foreach($fun_args as $_fun_args) {
                        if(in_array('post_id', $_fun_args)) {
                            $post_id_key = array_search('post_id', $_fun_args);
                            $_fun_args[$post_id_key] = $_post_id;
                        }
                        call_user_func_array($fun_name, $_fun_args);
                    }
                }
            }
        }
            
            
        
        return array('success' => true , 'msg' => $success_msg);
        
        
    }
    
    
    public function post() {
        
        global  $user_ID;
        
        $data['title'] = sanitize_text_field( trim( $_POST[ 'title' ] ));
        $data['description'] = isset( $_POST[ 'description' ] ) ? wp_kses( $_POST[ 'description' ], fes_allowed_html_tags() ) : '';
        $data['keywords'] = isset( $_POST[ 'keywords' ] ) ? wp_kses( $_POST[ 'keywords' ], array() ) : '';
        $data['category'] = is_array($_POST['category']) ? end($_POST['category']) : '';
        $data['style'] = $_POST['style'] ? $_POST['style'] : '';
        $data['era'] = $_POST['era'] ? $_POST['era'] : '';
        $data['culture'] = $_POST['culture'] ? $_POST['culture'] : ''; 
        $data['price_share'] = $_POST['price_share'];
        
        
        
        
        
        
        $images = (Array) $_POST['cci'];
        $uploader = self::get_uploader('cci');
        
        $finial_images = array();
        
        foreach($images as $img) {
            if($img) {
                $img_attachment = get_post($img);
                
                if($img_attachment && ksm_can_user_attach_attachment($img_attachment, $uploader->name)) {
                    $finial_images[] = $img_attachment;
                }
                
            }
        }
        
        
        
            
        
        
        die();
        
        
    }
    
    
    
}