<?php

abstract class KSM_Publisher {
    
    public $steps,
           $name,
           $uploaders,
           $publisher_type,
           $as_data = array()
           ;
    
    
    
    public function __construct($args = array()) {
        foreach($args as $key => $val) {
            if(property_exists($this, $key)) {
                $this->{$key} = $val;
            }
        }
        
        foreach ($this->steps as $sname => $step) {
        
            if($sname == 'images') {
                if($step['uploader']) {
                    $this->uploaders[] = key($step['uploader']);
                } elseif($step['uploaders']) {
                    foreach((Array) $step['uploaders'] as $upl_name => $upl) {
                        $this->uploaders[] = $upl_name;
                    }
                }
            } else {
                $ds_name = str_replace('.', DIRECTORY_SEPARATOR, "Form.Publisher.{$this->name}.$sname");
                $this->steps[$sname]['fields'] = KSM_DataStore::Options($ds_name);
            }
        }
        
        $this->view_path = $this->view_path();
    }
    
    
    public function view_path() {
        return 
        KSM_VIEWS_PATH . 'publisher' . DIRECTORY_SEPARATOR . $this->name . DIRECTORY_SEPARATOR;
    }
    
    public function get_action_id() {
        return KSM_Action::publisher($this->name);
    }
    
    
    static function getClassName($name) {
        return 'KSM_' . implode('', array_map('ucfirst', explode('_', $name))) . 'Publisher';
    }
    
    
    public function getActionKey() {
        return $this->name;
    }
    
    
    public function can_publish() {
        $user_id = get_current_user_id();
        
        if($user_id) {
            return true;
        }
        
        return false;
    }
    
    
    
    public function after_submit($post_id) {
        
        $post = get_post($post_id);
        
        if($post->post_type == 'download') {
            $download = new KSM_Download($post_id);
            
            
            $download->update_split_artist_roles();
            
            $form = $download->getRatingForm();
            $download->update_meta('rate_assignment_roles', $form->getAssignmentRules());
            
            
            
            $isTextured = $download->isTextured() ? 'yes' : 'no';
            $isUntextured = $download->isUntextured() ? 'yes' : 'no';
            $isSolo = $download->isSolo() ? 'yes' : 'no';
            $isCollaboration = $download->isCollaboration() ? 'yes' : 'no';
            $isCollaborationTextured = $download->isCollaborationTextured() ? 'yes' : 'no';
            $isCollaborationUntextured = $download->isCollaborationUntextured() ? 'yes' : 'no';
            $isSoloTextured = $download->isSoloTextured() ? 'yes' : 'no';
            $isSoloUntextured = $download->isSoloUntextured() ? 'yes' : 'no';
            
            
            
            $download->update_meta('is_textured', $isTextured);
            $download->update_meta('is_untextured', $isUntextured);
            $download->update_meta('is_solo', $isSolo);
            $download->update_meta('is_collaboration', $isCollaboration);
            $download->update_meta('is_collaboration_textured', $isCollaborationTextured);
            $download->update_meta('is_collaboration_untextured', $isCollaborationUntextured);
            $download->update_meta('is_solo_textured', $isSoloTextured);
            $download->update_meta('is_solo_untextured', $isSoloUntextured);
            
            
            $authors = $download->authors();
            foreach ($authors as $a) {
                if(!$download->author_exists_in_d_authors($a)) {
                    $download->add_author_in_d_authors($a);
                }
                
                
                
                
                if($download->post_status == 'publish') {
                    ksm_update_author_model_stats($a);
                }
            }
        }
        
        
        update_post_meta($post_id, 'product_rating', '0');
        update_post_meta($post_id, 'pub_name', $this->name);
    }
    
    
    
    
    static function get($name = '', $args = array()) {
        
        if($name) {
            
            
            $config = self::get_config($name);
            
            if(!empty($config)) {
                $cls_name = self::getClassName($name);
                if(class_exists($cls_name)) {
                    $config['name'] = $name;
                    
                    $params = array_merge($config, $args);
                    return new $cls_name($params);
                }
            }
        }
        
        return null;
    }
    
    
    static function get_config($name) {
        return KSM_DataStore::Option('publisher', $name);
    }
    
    
    
    
    
    public function remove_field($step, $field) {
        
        if($step) {
            unset($this->steps[$step]['fields'][$field]);
        }
        
        
    }
    
    public function field_exists($field) {
        if($field && array_key_exists($field, $this->params['fields'])) {
            return true;
        }
                
        return false;
    }
    
    
    
    
    public function validate_final() {
        
        $step_index = 1;
        foreach ($this->steps as $sname => $sargs) {
            $validate_cb_method = "validate_{$sname}";
            $v_result = call_user_func(array($this, $validate_cb_method), true);
            if($v_result['error']) {
                KSM_Js::setPublisherError($v_result['msg'], $step_index);
                exit;
            } else {
                $this->steps[$sname]['data'] = $v_result['data'];
            }
            
            $step_index++;
        }
        
    }


    
    public function validate($step, $return_data = false) {
        $fields = (Array) $this->steps[$step]['fields'];
        
        
        
        $v = new KSM_Validate($_POST, $fields);
        
        
        
        
        if($v->validate_form()) {
            
        } else {
            $ak = array_keys($v->errors());
            $errors = $v->errors();
            if($errors) {
                $error = array_shift(array_shift($v->errors()));
            }
        }
        
        if($error) {
            $result =  array('error' => true, 'msg' => $error);
        } else {
            $result = array('success' => true);
            if($return_data) {
                $result['data'] = $v->data();
            }
        }
        return $result;
    }
    
    
    
    public function validate_images($return_data = false) {
        
        
        $step = $this->steps['images'];
        $result = array();
        if($step['uploader']) {
            $uploader_name = key($step['uploader']);
            $sections = $step['uploader'][$uploader_name]['sections'];
            $field_name = $step['uploader'][$uploader_name]['name'];
            $images = (Array) $_POST[$field_name];
            
            $uploader = KSM_Uploader::get_uploader($uploader_name);
            $pos = 0;
            $data = array();
            $images_sections = array();
            $error = '';
            
            
            foreach ($sections as $sec_name => $sec) {
                $images_sections = (Array) array_slice($images, $pos, $sec['items']);
                if($sec['items'] == 1) {
                    $images_sections = $images_sections[0];
                    if($uploader->isAttachable($images_sections)) {
                        $data[$sec_name] = $images_sections;
                    }
                } else {
                    foreach($images_sections as $m) {
                        if($uploader->isAttachable($m)) {
                            $data[$sec_name][] = $m;
                        }
                    }
                }
                $pos += (int) $sec['items'];
            }
            
            
            foreach ($sections as $sec_name => $sec) {
                if($sec['required'] > 0) {
                    
                    if($sec['required']  == 1) {
                        if(!$data[$sec_name]) {
                            $error = ucfirst($sec_name). ' Image is required';
                            break;
                        }
                    } 
                    elseif(count($data[$sec_name]) < $sec['required']) {
                        $error = 'Please provide at least '.$sec['required'].' '.ucfirst($sec_name)." images." ;
                        break;
                    }
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
            
            
        }
        
        return $result;
        
    }
    
    
    public function validate_tech($return_data = false) {
        
        $fields = $this->steps['tech']['fields'];
        
        if($fields['ap_required'] && $_POST['ap_required'] == 'no') {
            $this->remove_field('tech', 'additional_plugins');
        }
        
        
        if($fields['unwrapped'] && $_POST['unwrapped'] == 'no') {
            $this->remove_field('tech', 'unwrap_overlap');
            $this->remove_field('tech', 'unwrap_stretching');
        }
        
        
        
        $result = $this->validate('tech', $return_data);
        
        
        return $result;
    }
    
    public function validate_description($return_data = false) {
        $result = $this->validate('description', $return_data);
        return $result;
    }
    
    
    public function validate_notes($return_data = false) {
        $result = $this->validate('notes', $return_data);
        return $result;
    }
    
    
    
    public function validate_upload($return_data = false) {
        $result = $this->validate('upload', $return_data);
        return $result;
    }
    
    
    function add_new_post($type = 'download', $status = 'publish') {
        $user_id = get_current_user_id();
        $description = $this->steps['description']['data'];
        
        $post_args = array(
            'post_type' => $type,
            'post_status' => $status,
            'post_author' => $user_id,
            'post_title' => $description['title'],
            'post_content' => $description['description']
        );
        
        
        return wp_insert_post($post_args);
        
    }
    
    
    
    public function prepare_images() {
        $data = $this->steps['images']['data'];
        
        
        
        foreach($data as $type => $v) {
            $images = is_array($v) ? $v : array($v);
            
            foreach((Array) $images as $img) {
                if($type == 'featured') {
                    $this->as_data['ksm_set_post_thumbnail'][] = array('post_id', $img);
                } else {
                    $this->as_data['update_post_meta'][] = array($img, 'img_cat', $type);
                    $this->as_data['ksm_attach_attachment'][] = array($img, 'post_id');
                }
            }
                
            
        }
        
    }
    
    
    public function auto_save($post_id) {
        
        foreach($this->as_data as $fun_name => $fun_args) {
            foreach($fun_args as $_fun_args) {
                if(in_array('post_id', $_fun_args)) {
                    $post_id_key = array_search('post_id', $_fun_args);
                    $_fun_args[$post_id_key] = $post_id;
                }
                call_user_func_array($fun_name, $_fun_args);
            }
        }
    }
    
    
    public function prepare_auto_save() {
        
        
        $term_ids = array();
        
        $this->prepare_images();
        
        foreach($this->steps as $sname => $step) {
            
            $sdata = $step['data'];
            
            foreach ((Array) $step['fields'] as $fname => $f) {
                
                if(!$f['save_as']) {
                    continue;
                }
                
                
                
                foreach ($f['save_as'] as $sa) {
                    if($sa == 'post_term' || $sa == 'post_terms') {
                        
                        $multi = $sa == 'post_terms' ? true : false;
                        $tax_name = $f['tax'] ? $f['tax'] : $fname;
                        
                        
                        if($f['type'] == 'term_id' || $f['type'] == 'term_ids' || $f['type'] == 'no_child_term_id') {
                            
                            if($multi) {
                                foreach((Array) $sdata[$fname] as $m) {
                                    $term_ids[$tax_name][] = (int) $m;
                                }
                            } else {
                                $term_ids[$tax_name][] = (int) $sdata[$fname];
                            }
                            
                        } elseif($f['type'] == 'list') {
                            foreach((Array) explode(',', $sdata[$fname]) as $tn) {
                                $term_ids[$tax_name][] = $tn;
                            }
                        } else {
                            $tax = new KSM_Taxonomy($tax_name);
                            
                            if($multi) {
                                foreach((Array) $sdata[$fname] as $m) {
                                    $term = $tax->value_to_term($m);
                                    if($term) {
                                        $term_ids[$tax_name][] = (int) $term->term_id;
                                    }
                                }
                            } else {
                                $term = $tax->value_to_term($sdata[$fname]);
                                if($term) {
                                    $term_ids[$tax_name][] = (int) $term->term_id;
                                }
                            }
                            
                            
                        }
                    }
                    
                    
                    
                    elseif($sa == 'post_meta') {
                        $this->as_data['update_post_meta'][] = array('post_id', $fname, $sdata[$fname]);
                    }
                }
                
                
            }
        }
        
        
        
        
        foreach($term_ids as $tax_name => $_ids) {
            $tax = new KSM_Taxonomy($tax_name);
            $this->as_data['wp_set_post_terms'][] = array('post_id', $_ids, $tax->key);
        }
        
    }
    
}







class KSM_TexturedModelPublisher extends KSM_Publisher {
    
    public $publisher_type = 'textured';
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
    }
    
    public function validate_description($return_data = false) {
        if($_POST['sell_type'] == '1') {
            $this->remove_field('description', 'untextured_price');
        }
        
        $result = $this->validate('description', $return_data);
        return $result;
    }
    
    
    public function validate_upload($return_data = false) {
        if($_POST['upload_sell_type'] != '2') {
            $this->remove_field('upload', 'untextured_file');
        }
        $result = $this->validate('upload', $return_data);
        return $result;
    }
    
    public function prepare_description() {
        
        $user_id = get_current_user_id();
        
        $data = $this->steps['description']['data'];
        $price = $data['textured_price'];
        
        
        $prices = array();
        $prices[] = array(
            'name' => 'Textured Model Price',
            'amount' => $price,
        );
        
        
        if (!isset( $prices[ 0 ][ 'amount' ] ) ){
            $prices[ 0 ][ 'amount' ] = "";
        }
        
        
        
        $price_tax = new KSM_Taxonomy('price');
        
        $price_term = $price_tax->value_to_term($price);
        
        if($price_term) {
            $this->as_data['wp_set_post_terms'][] = array('post_id', array((int) $price_term->term_id), 'ksm_tax_price');
        }
        
        $this->as_data['update_post_meta'][] = array('post_id', '_variable_pricing', 0);
        $this->as_data['update_post_meta'][] = array('post_id', 'edd_price', $price);
        $this->as_data['update_post_meta'][] = array('post_id', 'edd_variable_prices', $prices);
        //$this->as_data['update_post_meta'][] = array('post_id', 'product_type', 'textured');
        
        
        
        
        
        $TexturedModelCommission = KSM_DataStore::Option('Commission', 'TexturedModel');
        
        if ( EDD_FES()->integrations->is_commissions_active()) {
            $commission = array(
                'amount' => $TexturedModelCommission['artist']['amount'],
                'user_id' => $user_id,
                'type' => $TexturedModelCommission['artist']['type']
                );
            
            $this->as_data['update_post_meta'][] = array('post_id', '_edd_commission_settings', $commission);
            $this->as_data['update_post_meta'][] = array('post_id', '_edd_commisions_enabled', '1');
        }
        
    }
    
    
    public function prepare_tech() {
        
    }
    
    
    
    public function prepare_upload() {
        
        $data = $this->steps['upload']['data'];
        
        
        //$edd_files = array();
        
        //$edd_files[0] = array(
        //    'name' => basename( $data['tpf'] ),
        //    'file' => $data['tpf'],
        //    'condition' => '0'
	//);
        
        
        $this->as_data['KSM_S3::download_attach'][] = array(array($data['tpf']), 'post_id', 'textured_file');
        //$this->as_data['update_post_meta'][] = array('post_id', 'edd_download_files', $edd_files);
        
    }
    
    
    
    
    public function submit() {
        
        $this->validate_final();
        
        
        
        $this->prepare_auto_save();
        $this->prepare_description();
        $this->prepare_tech();
        $this->prepare_upload();
        
        
        
        
        $description = $this->steps['description']['data'];
        
        
	$status = 'publish';
        $success_msg = "Your model successfully posted";
        
	if ( ! EDD_FES()->helper->get_option( 'fes-auto-approve-submissions', false ) ) {
            $status  = 'pending';
            $success_msg = "Your model submitted for approval";
	}
        
        
        $_post_id = $this->add_new_post('download', $status);
        if($_post_id) {
            
            $this->auto_save($_post_id);
            
            
            update_post_meta($_post_id, 'model_type', 'textured');
            $this->after_submit($_post_id);
            
            if($description['sell_type'] == 2) {
                $untextured = KSM_Publisher::get('untextured_model');
                if($untextured) {
                    $untextured->submit_from_textured_model($this);
                }
            }
            
            return array('success' => true , 'msg' => $success_msg);
            
        }
        
            
            
        
        return array('error' => true , 'msg' => 'unable to post.');
        
        
    }
    
    
    
}







class KSM_UntexturedModelPublisher extends KSM_Publisher {
    
    public $publisher_type = 'untextured';
    
    
    
    public function validate_description($return_data = false) {
        if($_POST['allow_invites'] == 'yes') {
            $this->remove_field('description', 'untextured_price');
        } else {
            $this->remove_field('description', 'price_share');
        }
        
        $result = $this->validate('description', $return_data);
        return $result;
    }
    
    
    
    
    public function prepare_images_from_textured_model($data) {
        
        $images = array();
        
        
        
                
        if($data['untextured'][0]) {
            $images['featured'] = ksm_copy_image_attachment($data['untextured'][0]);
            unset($data['untextured'][0]);
        }
        
        foreach((Array) $data['untextured'] as $img) {
            $images['untextured'][] = ksm_copy_image_attachment($img);
        }
        foreach((Array) $data['wireframe'] as $img) {
            $images['wireframe'][] = ksm_copy_image_attachment($img);
        }
        
        return $images;
        
    }
    
    
    
    public function prepare_description() {
        
        $user_id = get_current_user_id();
        
        
        $data = $this->steps['description']['data'];
        
        
        
        $price = $data['untextured_price'];
        
        
        
        $prices = array();
        $prices[] = array(
            'name' => 'Untextured Model Price',
            'amount' => $price,
        );
        
        
        if (!isset( $prices[ 0 ][ 'amount' ] ) ){
            $prices[ 0 ][ 'amount' ] = "";
        }
        
        
        
        $price_tax = new KSM_Taxonomy('price');
        
        $price_term = $price_tax->value_to_term($price);
        
        if($price_term) {
            $this->as_data['wp_set_post_terms'][] = array('post_id', array((int) $price_term->term_id), 'ksm_tax_price');
        }
        
        $this->as_data['update_post_meta'][] = array('post_id', '_variable_pricing', 0);
        $this->as_data['update_post_meta'][] = array('post_id', 'edd_price', $price);
        $this->as_data['update_post_meta'][] = array('post_id', 'edd_variable_prices', $prices);
        //$this->as_data['update_post_meta'][] = array('post_id', 'product_type', 'untextured');
        
        
        
        
        $TexturedModelCommission = KSM_DataStore::Option('Commission', 'UnTexturedModel');
        
        if ( EDD_FES()->integrations->is_commissions_active()) {
            $commission = array(
                'amount' => $TexturedModelCommission['artist']['amount'],
                'user_id' => $user_id,
                'type' => $TexturedModelCommission['artist']['type']
                );
            
            $this->as_data['update_post_meta'][] = array('post_id', '_edd_commission_settings', $commission);
            $this->as_data['update_post_meta'][] = array('post_id', '_edd_commisions_enabled', '1');
        }
        
    }
    
    
    public function prepare_tech() {
        
    }
    
    
    
    public function prepare_upload() {
        
        //$edd_files = array();
        
        $data = $this->steps['upload']['data'];
        
        
        
        //$edd_files[0] = array(
        //    'name' => basename( $data['utpf'] ),
        //    'file' => $data['utpf'],
        //    'condition' => '0'
	///);
        
        
        $this->as_data['KSM_S3::download_attach'][] = array(array($data['utpf']), 'post_id', 'untextured_file');
        //$this->as_data['update_post_meta'][] = array('post_id', 'edd_download_files', $edd_files);
        
    }
    
    public function submit_from_textured_model($textured) {
        
        
        
        $images = $this->prepare_images_from_textured_model($textured->steps['images']['data']);
        $description = $textured->steps['description']['data'];
        $tech = $textured->steps['tech']['data'];
        $upload = $textured->steps['upload']['data'];
        
        
        
        
        $description['allow_invites'] = 'no';
        
        
        $this->steps['images']['data'] = $images;
        $this->steps['description']['data'] = $description;
        $this->steps['tech']['data'] = $tech;
        $this->steps['upload']['data'] = $upload;
        
        
        
        $this->prepare_auto_save();
        
        
        
        //$this->prepare_images();
        $this->prepare_description();
        $this->prepare_tech();
        $this->prepare_upload();
        
        
        
        
        
        
        
        
	$status = 'publish';
        $success_msg = "Your model successfully posted";
        
	if ( ! EDD_FES()->helper->get_option( 'fes-auto-approve-submissions', false ) ) {
            $status  = 'pending';
            $success_msg = "Your model submitted for approval";
	}
		
        
        
        $_post_id = $this->add_new_post('download', $status);
        
        
        
        if($_post_id) {
            $this->auto_save($_post_id);
            update_post_meta($_post_id, 'model_type', 'untextured');
            $this->after_submit($_post_id);
            return array('success' => true , 'msg' => $success_msg);
        }
        
        return array('error' => true , 'msg' => 'unable to post.');
        
        
    }
    
    
    
    
    public function submit() {
        
        
        $this->validate_final();
        
        if($this->steps['description']['data']['allow_invites'] == 'yes') {
            $this->steps['description']['data']['untextured_price'] = $this->steps['description']['data']['price_share'];
        }

        $this->prepare_auto_save();
        $this->prepare_description();
        $this->prepare_tech();
        $this->prepare_upload();
        
        
        
        $description = $this->steps['description']['data'];
        
        
        
	$status = 'publish';
        $success_msg = "Your model successfully posted";
        
	if ( ! EDD_FES()->helper->get_option( 'fes-auto-approve-submissions', false ) ) {
            $status  = 'pending';
            $success_msg = "Your model submitted for approval";
	}
        
        
        $_post_id = $this->add_new_post('download', $status);
        if($_post_id) {
            $this->auto_save($_post_id);
            
            update_post_meta($_post_id, 'model_type', 'untextured');
            $this->after_submit($_post_id);
            if($description['allow_invites'] == 'yes') {
                $c_untextured = KSM_Publisher::get('collaboration_untextured');
                if($c_untextured) {
                    $c_untextured->submit_from_untextured_model($this);
                }
            }
            return array('success' => true , 'msg' => $success_msg);
        }
        
        return array('error' => true , 'msg' => 'unable to post.');
    }
    
    
    
    
    
}


class KSM_ConceptPublisher extends KSM_Publisher {
    
    public $publisher_type = 'concept';
}







class KSM_CollaborationUntexturedPublisher extends KSM_CollaborationPublisher {
    
    
    
    public function prepare_images_from_untextured_model($data) {
        
        
        $images = array();
        
        
        $images['featured'] = ksm_copy_image_attachment($data['featured']);
        foreach((Array) $data['untextured'] as $img) {
            $images['untextured'][] = ksm_copy_image_attachment($img);
        }
        foreach((Array) $data['wireframe'] as $img) {
            $images['wireframe'][] = ksm_copy_image_attachment($img);
        }
        
        return $images;
    }
    
    public function submit_from_untextured_model($untextured) {
        
        $images = $this->prepare_images_from_untextured_model($untextured->steps['images']['data']);
        $description = $untextured->steps['description']['data'];
        $tech = $untextured->steps['tech']['data'];
        $upload = $untextured->steps['upload']['data'];
        
        
        $this->steps['images']['data'] = $images;
        $this->steps['description']['data'] = $description;
        $this->steps['tech']['data'] = $tech;
        $this->steps['upload']['data'] = $upload;
        
        
        
        $this->prepare_auto_save();
        
        
        $success_msg = "Your Untextured Collaboration is successfully published";
        
        $user_id = get_current_user_id();
        
        $_post_id = $this->add_new_post('ksm_collaboration');
        if($_post_id) {
            
            
            $this->auto_save($_post_id);
            
            update_post_meta($_post_id, 'launch_type', 'untextured');
            update_post_meta($_post_id, 'current_stage', 'untextured');
            update_post_meta($_post_id, 'can_user_submit_request', 'yes');
            update_post_meta($_post_id, 'current_round', '1');
            update_post_meta($_post_id, 'price', $description['price_share']);
            
            
            update_post_meta($_post_id, 'model_price', $description['price_share']);
            update_post_meta($_post_id, 'model_partner', $user_id);
            
            update_post_meta($_post_id, 'untextured_file', $upload['utpf']);
            
            $this->after_submit($_post_id);
            
            return array('success' => true , 'msg' => $success_msg);
        }
        
        return array('error' => true , 'msg' => 'unable to post.');
        
        
    }
    
    
    public function submit() {
        
        $this->validate_final();
        $this->prepare_auto_save();
        $description = $this->steps['description']['data'];
        $upload = $this->steps['upload']['data'];
        
        
        $success_msg = "Your Untextured Collaboration is successfully published";
        $_post_id = $this->add_new_post('ksm_collaboration');
        
        $user_id = get_current_user_id();
        
        if($_post_id) {
            $this->auto_save($_post_id);
            
            update_post_meta($_post_id, 'launch_type', 'untextured');
            update_post_meta($_post_id, 'current_stage', 'untextured');
            update_post_meta($_post_id, 'can_user_submit_request', 'yes');
            update_post_meta($_post_id, 'current_round', '1');
            update_post_meta($_post_id, 'price', $description['price_share']);
            
            update_post_meta($_post_id, 'model_price', $description['price_share']);
            update_post_meta($_post_id, 'model_partner', $user_id);
            
            update_post_meta($_post_id, 'untextured_file', $upload['ucfp']);
            $this->after_submit($_post_id);
            KSM_S3::clearTemp($upload['ucfp']);
            
        }
        
            
            
        
        return array('success' => true , 'msg' => $success_msg);
        
        
    }
    
    
    
    
    public function images_data() {
        
        return array();
    }
    
    
    
    
    
}










class KSM_CollaborationSellPublisher extends KSM_Publisher {
    
}



class KSM_CollaborationModelSellPublisher extends KSM_CollaborationSellPublisher {
    
    
}

class KSM_CollaborationTextureSellPublisher extends KSM_CollaborationSellPublisher {
    
    
}

class KSM_CollaborationModelTextureSellPublisher extends KSM_CollaborationSellPublisher {
    
    
}


class KSM_CollaborationPublisher extends KSM_Publisher {
    
    
}


class KSM_CollaborationConceptPublisher extends KSM_CollaborationPublisher {
    
    
    public function images_data() {
        return array();
    }
    
    public function submit() {
        $this->validate_final();
        $this->prepare_auto_save();
        
        
        //pr($this->as_data);
        //exit;
        
        $description = $this->steps['description']['data'];
        $success_msg = "Your Concept Collaboration is successfully published";
        
	$user_id = get_current_user_id();
        
        $_post_id = $this->add_new_post('ksm_collaboration');
	if($_post_id) {
            
            $this->auto_save($_post_id);
            
            update_post_meta($_post_id, 'launch_type', 'concept');
            update_post_meta($_post_id, 'current_stage', 'concept');
            update_post_meta($_post_id, 'can_user_submit_request', 'yes');
            update_post_meta($_post_id, 'current_round', '1');
            
            
            update_post_meta($_post_id, 'concept_price', $description['price_share']);
            update_post_meta($_post_id, 'concept_partner', $user_id);
            
            update_post_meta($_post_id, 'concept_created', 'yes');
            
            
            update_post_meta($_post_id, 'price', $description['price_share']);
            $this->after_submit($_post_id);
        }
        
        return array('success' => true , 'msg' => $success_msg);
    }
}


class KSM_CollaborationUntexturedImagePublisher extends KSM_CollaborationUntexturedPublisher {
    
    public $image_id;
    
    public function __construct($args = array()) {
        parent::__construct($args);
        if($args['id']) {
            $this->image_id = $args['id'];
        }
    }
    
    
    public function view_path() {
        $dirname = 'collaboration_untextured';
        return 
        KSM_VIEWS_PATH . 'publisher' . DIRECTORY_SEPARATOR . $dirname . DIRECTORY_SEPARATOR;
        
    }
    
    
    public function get_action_id() {
        return KSM_Action::publisher($this->name, $this->image_id);
    }
    
    
    public function can_publish() {
        $user_id = get_current_user_id();
        
        
        if($user_id && $this->image_id) {
            $image = get_post($this->image_id);
            if($image && $image->post_author == $user_id && $image->user_upload_type == 'post_image') {
                return true;
            }
        }
        
        return false;
    }
    
    
    public function images_data() {
        
        $image = get_post($this->image_id);
        
        $image->poslock = true;
        return array(1=>$image);
        
        
    }
    
    
    public function validate_images($return_data = false) {
        
        
        
        //$this->steps['images']['uploader'][$uploader_name]['sections']['featured']['required'] = 0;
        
        
        
        
        
        $_result = parent::validate_images(true);
        if($_result['success']) {
            
            $uploader_name = key($this->steps['images']['uploader']);
            $field_name = $this->steps['images']['uploader'][$uploader_name]['name'];
            $images = (Array) $_POST[$field_name];
            $featured_image = (Array) array_slice($images, 0, 1);
            $featured_image = $featured_image[0];
            
            if($this->image_id != $featured_image) {
                $error = "Invalid featured image.";
            }
        } else {
            $error = $_result['msg'];
        }
        
        
        
        $result = array();
        
        if($error) {
            $result =  array('error' => true, 'msg' => $error);
        } else {
            $result = array('success' => true);
            if($return_data) {
                $_result['data']['featured'] = $this->image_id;
                $result['data'] = $_result['data'];
            }
        }
            
        return $result;
        
    }
    
    
    
    public function submit() {
        
        
        $this->validate_final();
        
        $this->steps['images']['data']['featured'] = ksm_copy_image_attachment($this->image_id);
        
        $this->prepare_auto_save();
        $description = $this->steps['description']['data'];
        $upload = $this->steps['upload']['data'];
        
        
        $success_msg = "Your Untextured Collaboration is successfully published";
        $_post_id = $this->add_new_post('ksm_collaboration');
        
        $user_id = get_current_user_id();
        
        if($_post_id) {
            $this->auto_save($_post_id);
            
            update_post_meta($_post_id, 'launch_type', 'untextured');
            update_post_meta($_post_id, 'current_stage', 'untextured');
            update_post_meta($_post_id, 'can_user_submit_request', 'yes');
            update_post_meta($_post_id, 'current_round', '1');
            update_post_meta($_post_id, 'price', $description['price_share']);
            
            update_post_meta($_post_id, 'model_price', $description['price_share']);
            update_post_meta($_post_id, 'model_partner', $user_id);
            
            update_post_meta($_post_id, 'untextured_file', $upload['ucfp']);
            
            $this->after_submit($_post_id);
            
            KSM_S3::clearTemp($upload['ucfp']);
            
        }
        
            
            
        
        return array('success' => true , 'msg' => $success_msg);
        
        
    }
    
}

class KSM_CollaborationConceptImagePublisher extends KSM_CollaborationConceptPublisher {
    
    public $image_id;
    
    public function __construct($args = array()) {
        parent::__construct($args);
        if($args['id']) {
            $this->image_id = $args['id'];
        }
    }
    
    public function view_path() {
        $dirname = 'collaboration_concept';
        return 
        KSM_VIEWS_PATH . 'publisher' . DIRECTORY_SEPARATOR . $dirname . DIRECTORY_SEPARATOR;
        
    }
    
    
    public function get_action_id() {
        return KSM_Action::publisher($this->name, $this->image_id);
    }
    
    public function can_publish() {
        $user_id = get_current_user_id();
        
        
        if($user_id && $this->image_id) {
            $image = get_post($this->image_id);
            if($image && $image->post_author == $user_id && $image->user_upload_type == 'post_image') {
                return true;
            }
        }
        
        return false;
    }
    
    
    
    
    
    public function images_data() {
        
        $image = get_post($this->image_id);
        
        $image->poslock = true;
        return array(1=>$image);
        
        
    }
    
    
    
    
    public function validate_images($return_data = false) {
        
        
        
        //$this->steps['images']['uploader'][$uploader_name]['sections']['featured']['required'] = 0;
        
        
        
        
        
        $_result = parent::validate_images(true);
        if($_result['success']) {
            
            $uploader_name = key($this->steps['images']['uploader']);
            $field_name = $this->steps['images']['uploader'][$uploader_name]['name'];
            $images = (Array) $_POST[$field_name];
            $featured_image = (Array) array_slice($images, 0, 1);
            $featured_image = $featured_image[0];
            
            if($this->image_id != $featured_image) {
                $error = "Invalid featured image.";
            }
        } else {
            $error = $_result['msg'];
        }
        
        
        
        $result = array();
        
        if($error) {
            $result =  array('error' => true, 'msg' => $error);
        } else {
            $result = array('success' => true);
            if($return_data) {
                $_result['data']['featured'] = $this->image_id;
                $result['data'] = $_result['data'];
            }
        }
            
        return $result;
        
    }
    
    
    
    public function submit() {
        $this->validate_final();
        
        $this->steps['images']['data']['featured'] = ksm_copy_image_attachment($this->image_id);
        
        
        $this->prepare_auto_save();
        
        $description = $this->steps['description']['data'];
        $success_msg = "Your Concept Collaboration is successfully published";
        
        $user_id = get_current_user_id();
	
        
        $_post_id = $this->add_new_post('ksm_collaboration');
	if($_post_id) {
            
            $this->auto_save($_post_id);
            
            update_post_meta($_post_id, 'launch_type', 'concept');
            update_post_meta($_post_id, 'current_stage', 'concept');
            update_post_meta($_post_id, 'can_user_submit_request', 'yes');
            update_post_meta($_post_id, 'current_round', '1');
            
            update_post_meta($_post_id, 'concept_price', $description['price_share']);
            update_post_meta($_post_id, 'concept_partner', $user_id);
            
            update_post_meta($_post_id, 'concept_created', 'yes');
            
            
            update_post_meta($_post_id, 'price', $description['price_share']);
            
            $this->after_submit($_post_id);
        }
        
        return array('success' => true , 'msg' => $success_msg);
    }
}




/////////////////////////////////////////////////////////////////////////////////////////



class KSM_CollaborationActiveStepPublisher extends KSM_Publisher {
    
    
    public $isCollaborationActiveStepPublisher = true;
    
    public $Active,
           $current_step,
           $current_step_state,
            
           $success_msg = "";
    
    
    
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
        if($args['id']) {
            $this->Active = new KSM_CollaborationActive($args['id']);
        }
        
        
    }
    
    
    public function can_publish() {
        
        if($this->Active) {
            
            if($this->Active->isOwner()) {
                if($this->Active->current_step == $this->current_step && $this->Active->current_step_state == $this->current_step_state) {
                    return true;
                }
            }
        }
        return false;
    }
    
    
    
    public function get_action_id() {
        return KSM_Action::publisher($this->name, $this->Active->ID);
    }
    
    
    function add_new_post($type = 'collab_active_step', $status = 'publish') {
        $user_id = get_current_user_id();
        $notes = $this->steps['notes']['data'];
        
        $post_args = array(
            'post_type' => $type,
            'post_status' => $status,
            'post_author' => $user_id,
            'post_title' => $this->Active->post_title,
            'post_content' => $notes['notes'],
            'post_parent' => $this->Active->ID
        );
        
        
        return wp_insert_post($post_args);
    }
    
    
    public function submit() {
        $this->validate_final();
        $this->prepare_auto_save();
        
        
        $wip = new KSM_Collaboration_Wip();
        
        
        
        $args = array(
            'post_title' => $this->Active->post_title,
            'post_content' => $this->steps['notes']['data'],
            'post_parent' => $this->Active->ID,
            'meta' => array(
                'step' => $this->Active->current_step,
                'step_state' => $this->Active->current_step_state,
                'collaboration_author' => $this->Active->collaboration_author,
                'feedback_required' => 'yes',
                'collaboration_id'=> $this->Active->post_parent)
            );
        
        
        
        
        $_post_id = $wip->Insert($args, $this->as_data);
        
        if($_post_id) {
            
            
            $wip->emit('collaboration_progress_submitted');
            
            $this->after_submit($_post_id);
            $this->Active->moveToNextStop();
        }
        return array('success' => true , 'msg' => $this->success_msg);
    }
    
    
}






class KSM_CollaborationTextureMidWipPublisher extends KSM_CollaborationActiveStepPublisher {
    
    public $success_msg = "Your texture wip images are submitted";


    public function view_path() {
        $dirname = 'collaboration_texture_wip_publisher';
        
        return 
        KSM_VIEWS_PATH . 'publisher' . DIRECTORY_SEPARATOR . $dirname . DIRECTORY_SEPARATOR;
        
    }
}

class KSM_CollaborationTextureFinalWipPublisher extends KSM_CollaborationTextureMidWipPublisher {
    
}



class KSM_CollaborationModelMidWipPublisher extends KSM_CollaborationActiveStepPublisher {
    
    public $success_msg = "Your model wip images are submitted";
    
    
    public function view_path() {
        $dirname = 'collaboration_model_wip_publisher';
        
        return 
        KSM_VIEWS_PATH . 'publisher' . DIRECTORY_SEPARATOR . $dirname . DIRECTORY_SEPARATOR;
        
    }
}


class KSM_CollaborationModelFinalWipPublisher extends KSM_CollaborationModelMidWipPublisher {
    
}




class KSM_CollaborationPublishUntexturedPublisher extends KSM_CollaborationActiveStepPublisher {
    
    
    public $publisher_type = 'untextured', 
           $collaboration_partners,
           $edd_price;
    
    
            
    
    
    
    
   public function can_publish() {
       if(parent::can_publish()) {
           if(!$this->Active->Collaboration->untextured_download_id) {
               return true;
           }
       }
       
       return false;
   }
           
    
    function add_new_post($type = 'download', $status = 'publish') {
        $user_id = get_current_user_id();
        
        $title = $this->Active->Collaboration->post_title;
        $description = $this->Active->Collaboration->post_content;
        
        $post_args = array(
            'post_type' => $type,
            'post_status' => $status,
            'post_author' => $user_id,
            'post_title' => $title,
            'post_content' => $description
        );
        
        
        return wp_insert_post($post_args);
        
    }
    
    
    
    public function prepare_price() {
       
        $artist_commission_rate = KSM_ARTIST_COMMISSION_RATE;
        
        
        
        
        $collaboration_partners = array();
        $commission_recipients = array();
        $product_price = 0;
        
        
        
        $collaboration_partners['concept_artist'] = array(
            'id' => $this->Active->Collaboration->post_author,
            'price' => $this->Active->Collaboration->price,
            'commission' => $this->Active->Collaboration->price * ( $artist_commission_rate / 100 )
        );
        
        
        
        $collaboration_partners['untextured_model_artist'] = array(
            'id' => $this->Active->Collaboration->model_partner,
            'price' => $this->Active->Collaboration->model_price,
            'commission' => $this->Active->Collaboration->model_price * ( $artist_commission_rate / 100 )
        );
        
        
        
        
        $this->collaboration_partners = $collaboration_partners;
        
        
        
        
        foreach($collaboration_partners as $k => $v) {
            
            $product_price += $v['price'];
            
            $rid = $v['id'];
            $rcommission = $v['commission'];
            
            if(!isset($commission_recipients[$rid])) {
                $commission_recipients[$rid] = 0;
            }
            $commission_recipients[$rid] += $rcommission;
        }
        
        
        
        
        $commission = array(
            'amount' => implode(',', $commission_recipients),
            'user_id' => implode(',', array_keys($commission_recipients)),
            'type' => 'flat'
            );
        
        $this->as_data['update_post_meta'][] = array('post_id', '_edd_commission_settings', $commission);
        $this->as_data['update_post_meta'][] = array('post_id', '_edd_commisions_enabled', '1');
        
        
        $this->edd_price = $product_price;
        
        
        $prices = array(array(
            'name' => 'Untextured Model Price',
            'amount' => $product_price,
        ));
        
        
        $price_tax = new KSM_Taxonomy('price');
        $price_term = $price_tax->value_to_term($product_price);
        if($price_term) {
            $this->as_data['wp_set_post_terms'][] = array('post_id', array((int) $price_term->term_id), 'ksm_tax_price');
        }
        
        $this->as_data['update_post_meta'][] = array('post_id', '_variable_pricing', 0);
        $this->as_data['update_post_meta'][] = array('post_id', 'edd_price', $product_price);
        $this->as_data['update_post_meta'][] = array('post_id', 'edd_variable_prices', $prices);
        //$this->as_data['update_post_meta'][] = array('post_id', 'product_type', 'untextured');
    }
    
    
    /*
    public function prepare_price() {
        
        $artist_commission_rate = KSM_ARTIST_COMMISSION_RATE;
        
        
        
        $this->concept_artist = $this->Active->Collaboration->post_author;
        $this->untextured_model_artist = $this->Active->post_author;
        $this->concept_artist_price = $this->Active->Collaboration->price;
        $this->untextured_model_artist_price = $this->Active->Collaboration->model_price;
        
        
        
        if ( EDD_FES()->integrations->is_commissions_active()) {
            $this->concept_artist_commission = $this->concept_artist_price * ( $artist_commission_rate / 100 );
            $this->untextured_model_artist_commission = $this->untextured_model_artist_price * ( $artist_commission_rate / 100 );
            
            $commission_recipients = array(
                $this->concept_artist => $this->concept_artist_commission ,
                $this->untextured_model_artist => $this->untextured_model_artist_commission
            );
            
            
            $commission = array(
                'amount' => implode(',', $commission_recipients),
                'user_id' => implode(',', array_keys($commission_recipients)),
                'type' => 'flat'
                );
            
            $this->as_data['update_post_meta'][] = array('post_id', '_edd_commission_settings', $commission);
            $this->as_data['update_post_meta'][] = array('post_id', '_edd_commisions_enabled', '1');
        }
        
        
        
        
        $product_price = $this->concept_artist_price + $this->untextured_model_artist_price;
        $prices = array(array(
            'name' => 'Untextured Model Price',
            'amount' => $product_price,
        ));
        
        
        
        $price_tax = new KSM_Taxonomy('price');
        $price_term = $price_tax->value_to_term($product_price);
        if($price_term) {
            $this->as_data['wp_set_post_terms'][] = array('post_id', array((int) $price_term->term_id), 'ksm_tax_price');
        }
        
        $this->as_data['update_post_meta'][] = array('post_id', '_variable_pricing', 0);
        $this->as_data['update_post_meta'][] = array('post_id', 'edd_price', $product_price);
        $this->as_data['update_post_meta'][] = array('post_id', 'edd_variable_prices', $prices);
        //$this->as_data['update_post_meta'][] = array('post_id', 'product_type', 'untextured');
    }
    */
    
    
    public function prepare_description() {
        
        
        //$keyword = wp_get_post_terms($this->Active->Collaboration->ID, 'ksm_tax_keyword', array("fields" => "ids"));
        //$category = wp_get_post_terms($this->Active->Collaboration->ID, 'category', array("fields" => "ids"));
        //$style = wp_get_post_terms($this->Active->Collaboration->ID, 'ksm_tax_style', array("fields" => "ids"));
        //$era = wp_get_post_terms($this->Active->Collaboration->ID, 'ksm_tax_era', array("fields" => "ids"));
        //$culture = wp_get_post_terms($this->Active->Collaboration->ID, 'ksm_tax_culture', array("fields" => "ids"));
        //$concept_created = $this->Active->Collaboration->concept_created;
        
        
        
        $cid = $this->Active->Collaboration->ID;
        $this->as_data['copy_post_terms'][] = array($cid, 'post_id', 'ksm_tax_keyword');
        $this->as_data['copy_post_terms'][] = array($cid, 'post_id', 'category');
        $this->as_data['copy_post_terms'][] = array($cid, 'post_id', 'ksm_tax_style');
        $this->as_data['copy_post_terms'][] = array($cid, 'post_id', 'ksm_tax_era');
        $this->as_data['copy_post_terms'][] = array($cid, 'post_id', 'ksm_tax_culture');
        
        
        
        
        //$this->as_data['wp_set_post_terms'][] = array('post_id', $keyword, 'ksm_tax_keyword');
        //$this->as_data['wp_set_post_terms'][] = array('post_id', $category, 'category');
        //$this->as_data['wp_set_post_terms'][] = array('post_id', $style, 'ksm_tax_style');
        //$this->as_data['wp_set_post_terms'][] = array('post_id', $era, 'ksm_tax_era');
        //$this->as_data['wp_set_post_terms'][] = array('post_id', $culture, 'ksm_tax_culture');
        //$this->as_data['update_post_meta'][] = array('post_id', 'concept_created', $concept_created);
        
        
        $this->prepare_price();
    }
    
    
    public function prepare_tech() {
        
    }
    
    
    
    public function prepare_upload() {
        
        //$edd_files = array();
        
        $data = $this->steps['upload']['data'];
        
        
        
        //$edd_files[0] = array(
        //    'name' => basename( $data['utpf'] ),
        //    'file' => $data['utpf'],
        //    'condition' => '0'
	//);
        
        
        $this->as_data['KSM_S3::download_attach'][] = array(array($data['utpf']), 'post_id', 'untextured_file');
        //$this->as_data['update_post_meta'][] = array('post_id', 'edd_download_files', $edd_files);
    }
    
    
    
    public function submit() {
        
        
        
        $this->validate_final();
        
        
        
        
        
        
        $this->prepare_auto_save();
        $this->prepare_description();
        $this->prepare_tech();
        $this->prepare_upload();
        
        
        
	$status = 'publish';
        $success_msg = "Your model successfully posted";
        
	if ( ! EDD_FES()->helper->get_option( 'fes-auto-approve-submissions', false ) ) {
            $status  = 'pending';
            $success_msg = "Your model submitted for approval";
	}
        
        
        $_post_id = $this->add_new_post('download', $status);
        if($_post_id) {
            $this->auto_save($_post_id);
            
            update_post_meta($_post_id, 'collaboration_partners', $this->collaboration_partners);
            update_post_meta($_post_id, 'collaboration_id', $this->Active->Collaboration->ID);
            update_post_meta($this->Active->Collaboration->ID, 'untextured_download_id', $_post_id);
            update_post_meta($this->Active->Collaboration->ID, 'price', $this->edd_price);
            
            
            update_post_meta($_post_id, 'model_type', 'untextured');
            
            update_post_meta($_post_id, 'concept_created', 'yes');
            
            
            $this->after_submit($_post_id);
            
            $this->Active->moveToNextStop();
            return array('success' => true , 'msg' => $success_msg);
        }
        
        return array('error' => true , 'msg' => 'unable to post.');
    }
    
    
}




//class KSM_CollaborationPublishTexturedPublisher {
    
    
//}



class KSM_CollaborationPublishTexturedPublisher extends KSM_CollaborationActiveStepPublisher {
    
    public $publisher_type = 'textured',
           $collaboration_partners,
           $UntexturedPost;

    public function __construct($args = array()) {
        
        parent::__construct($args);
        
        $this->UntexturedPost = $this->Active->getUntexturedStep();
        
    }
    
    
    
    
    
    
    
    public function can_publish() {
       if(parent::can_publish()) {
           if(!$this->Active->Collaboration->textured_download_id) {
               return true;
           }
       }
       return false;
   }
   
   
   


   public function prepare_price() {
       
        $artist_commission_rate = KSM_ARTIST_COMMISSION_RATE;
        
        
        
        
        $collaboration_partners = array();
        $commission_recipients = array();
        $product_price = 0;
        
        
        if($this->Active->Collaboration->launch_type == 'concept') {
            $collaboration_partners['concept_artist'] = array(
                    'id' => $this->Active->Collaboration->concept_partner,
                    'price' => $this->Active->Collaboration->concept_price,
                    'commission' => $this->Active->Collaboration->concept_price * ( $artist_commission_rate / 100 )
                );
        }
        
        
        $collaboration_partners['untextured_model_artist'] = array(
            'id' => $this->Active->Collaboration->model_partner,
            'price' => $this->Active->Collaboration->model_price,
            'commission' => $this->Active->Collaboration->model_price * ( $artist_commission_rate / 100 )
                );
        
        
        $collaboration_partners['textured_model_artist'] = array(
            'id' => $this->Active->Collaboration->texture_partner,
            'price' => $this->Active->Collaboration->texture_price,
            'commission' => $this->Active->Collaboration->texture_price * ( $artist_commission_rate / 100 )
                );
        
        $this->collaboration_partners = $collaboration_partners;
        
        
        
        
        foreach($collaboration_partners as $k => $v) {
            
            $product_price += $v['price'];
            
            $rid = $v['id'];
            $rcommission = $v['commission'];
            
            if(!isset($commission_recipients[$rid])) {
                $commission_recipients[$rid] = 0;
            }
            $commission_recipients[$rid] += $rcommission;
        }
        
        
        
        
        $commission = array(
            'amount' => implode(',', $commission_recipients),
            'user_id' => implode(',', array_keys($commission_recipients)),
            'type' => 'flat'
            );
        
        $this->as_data['update_post_meta'][] = array('post_id', '_edd_commission_settings', $commission);
        $this->as_data['update_post_meta'][] = array('post_id', '_edd_commisions_enabled', '1');
        
        
        $prices = array(array(
            'name' => 'Textured Model Price',
            'amount' => $product_price,
        ));
        
        
        $price_tax = new KSM_Taxonomy('price');
        $price_term = $price_tax->value_to_term($product_price);
        if($price_term) {
            $this->as_data['wp_set_post_terms'][] = array('post_id', array((int) $price_term->term_id), 'ksm_tax_price');
        }
        
        $this->as_data['update_post_meta'][] = array('post_id', '_variable_pricing', 0);
        $this->as_data['update_post_meta'][] = array('post_id', 'edd_price', $product_price);
        $this->as_data['update_post_meta'][] = array('post_id', 'edd_variable_prices', $prices);
        //$this->as_data['update_post_meta'][] = array('post_id', 'product_type', 'untextured');
    }
    
    
    
    public function prepare_description() {
        
        
        //$keyword = wp_get_post_terms($this->Active->Collaboration->ID, 'ksm_tax_keyword', array("fields" => "ids"));
        //$category = wp_get_post_terms($this->Active->Collaboration->ID, 'category', array("fields" => "ids"));
        //$style = wp_get_post_terms($this->Active->Collaboration->ID, 'ksm_tax_style', array("fields" => "ids"));
        //$era = wp_get_post_terms($this->Active->Collaboration->ID, 'ksm_tax_era', array("fields" => "ids"));
        //$culture = wp_get_post_terms($this->Active->Collaboration->ID, 'ksm_tax_culture', array("fields" => "ids"));
        //$concept_created = $this->Active->Collaboration->concept_created;
        
        
        //copy_post_terms($from, $to, $tax);
        
        //$this->as_data['wp_set_post_terms'][] = array('post_id', $keyword, 'ksm_tax_keyword');
        //$this->as_data['wp_set_post_terms'][] = array('post_id', $category, 'category');
        //$this->as_data['wp_set_post_terms'][] = array('post_id', $style, 'ksm_tax_style');
        //$this->as_data['wp_set_post_terms'][] = array('post_id', $era, 'ksm_tax_era');
        //$this->as_data['wp_set_post_terms'][] = array('post_id', $culture, 'ksm_tax_culture');
        
        $cid = $this->Active->Collaboration->ID;
        
        $this->as_data['copy_post_terms'][] = array($cid, 'post_id', 'ksm_tax_keyword');
        $this->as_data['copy_post_terms'][] = array($cid, 'post_id', 'category');
        $this->as_data['copy_post_terms'][] = array($cid, 'post_id', 'ksm_tax_style');
        $this->as_data['copy_post_terms'][] = array($cid, 'post_id', 'ksm_tax_era');
        $this->as_data['copy_post_terms'][] = array($cid, 'post_id', 'ksm_tax_culture');
        
        
        
        //$this->as_data['update_post_meta'][] = array('post_id', 'concept_created', $concept_created);
        
        
        $this->prepare_price();
    }
    
    
    
    public function prepare_upload() {
        
        $data = $this->steps['upload']['data'];
        $this->as_data['KSM_S3::download_attach'][] = array(array($data['tpf']), 'post_id', 'textured_file');
    }
    
    
    
    public function prepare_tech() {
        
        if($this->UntexturedPost ) {
            
            //wp_get_post_terms($this->UntexturedDownload->ID, 'ksm_tax_mapping', array("fields" => "ids"));
            //wp_get_post_terms($this->UntexturedDownload->ID, 'ksm_tax_renderer', array("fields" => "ids"));
            //wp_get_post_terms($this->UntexturedDownload->ID, 'ksm_tax_lighting', array("fields" => "ids"));
            //wp_get_post_terms($this->UntexturedDownload->ID, 'ksm_tax_texturing_method', array("fields" => "ids"));
            //wp_get_post_terms($this->UntexturedDownload->ID, 'ksm_tax_ambient_occlusion_baked', array("fields" => "ids"));
            //wp_get_post_terms($this->UntexturedDownload->ID, 'ksm_tax_unwrap_overlap', array("fields" => "ids"));
            
            
            
            $modeling_method = wp_get_post_terms($this->UntexturedPost->ID, 'ksm_tax_modeling_method', array("fields" => "ids"));
            $environment = wp_get_post_terms($this->UntexturedPost->ID, 'ksm_tax_environment', array("fields" => "ids"));
            $file_format = wp_get_post_terms($this->UntexturedPost->ID, 'ksm_tax_file_format', array("fields" => "ids"));
            $poly_count = wp_get_post_terms($this->UntexturedPost->ID, 'ksm_tax_poly_count', array("fields" => "ids"));
            $organization = wp_get_post_terms($this->UntexturedPost->ID, 'ksm_tax_organization', array("fields" => "ids"));
            $world_scale = wp_get_post_terms($this->UntexturedPost->ID, 'ksm_tax_world_scale', array("fields" => "ids"));
            $print_ready = wp_get_post_terms($this->UntexturedPost->ID, 'ksm_tax_print_ready', array("fields" => "ids"));
            $game_ready = wp_get_post_terms($this->UntexturedPost->ID, 'ksm_tax_game_ready', array("fields" => "ids"));
            $model_angular = wp_get_post_terms($this->UntexturedPost->ID, 'ksm_tax_model_angular', array("fields" => "ids"));
            $unwrapped = wp_get_post_terms($this->UntexturedPost->ID, 'ksm_tax_unwrapped', array("fields" => "ids"));
            $unwrap_stretching = wp_get_post_terms($this->UntexturedPost->ID, 'ksm_tax_unwrap_stretching', array("fields" => "ids"));
            
            
            
            
            
            $primary_file_format = $this->UntexturedPost->primary_file_format;
            $poly_count_meta = $this->UntexturedPost->poly_count;
            $ap_required = $this->UntexturedPost->ap_required;
            $additional_plugins = $this->UntexturedPost->additional_plugins;
            
            
            $this->as_data['update_post_meta'][] = array('post_id', 'primary_file_format', $primary_file_format);
            $this->as_data['update_post_meta'][] = array('post_id', 'poly_count', $poly_count_meta);
            $this->as_data['update_post_meta'][] = array('post_id', 'ap_required', $ap_required);
            $this->as_data['update_post_meta'][] = array('post_id', 'additional_plugins', $additional_plugins);
            
            
            
            $this->as_data['wp_set_post_terms'][] = array('post_id', $modeling_method, 'ksm_tax_modeling_method');
            $this->as_data['wp_set_post_terms'][] = array('post_id', $environment, 'ksm_tax_environment');
            $this->as_data['wp_set_post_terms'][] = array('post_id', $file_format, 'ksm_tax_file_format');
            $this->as_data['wp_set_post_terms'][] = array('post_id', $poly_count, 'ksm_tax_poly_count');
            $this->as_data['wp_set_post_terms'][] = array('post_id', $organization, 'ksm_tax_organization');
            $this->as_data['wp_set_post_terms'][] = array('post_id', $world_scale, 'ksm_tax_world_scale');
            $this->as_data['wp_set_post_terms'][] = array('post_id', $print_ready, 'ksm_tax_print_ready');
            $this->as_data['wp_set_post_terms'][] = array('post_id', $game_ready, 'ksm_tax_game_ready');
            $this->as_data['wp_set_post_terms'][] = array('post_id', $model_angular, 'ksm_tax_model_angular');
            $this->as_data['wp_set_post_terms'][] = array('post_id', $unwrapped, 'ksm_tax_unwrapped');
            $this->as_data['wp_set_post_terms'][] = array('post_id', $unwrap_stretching, 'ksm_tax_unwrap_stretching');
            
        }
        
    }
    
    
    
    
    
    function add_new_post($type = 'download', $status = 'publish') {
        $user_id = get_current_user_id();
        
        $title = $this->Active->Collaboration->post_title;
        $description = $this->Active->Collaboration->post_content;
        
        $post_args = array(
            'post_type' => $type,
            'post_status' => $status,
            'post_author' => $user_id,
            'post_title' => $title,
            'post_content' => $description
        );
        
        return wp_insert_post($post_args);
        
    }
    
    
    
    public function submit() {
        
        
        //build_type

        //$download->getBuildType();
        
        $this->validate_final();
        

        $this->prepare_auto_save();
        $this->prepare_description();
        $this->prepare_tech();
        $this->prepare_upload();
        
        
        
	$status = 'publish';
        $success_msg = "Your model successfully posted";
        
	if ( ! EDD_FES()->helper->get_option( 'fes-auto-approve-submissions', false ) ) {
            $status  = 'pending';
            $success_msg = "Your model submitted for approval";
	}
        
        
        $_post_id = $this->add_new_post('download', $status);
        if($_post_id) {
            $this->auto_save($_post_id);
            
            update_post_meta($_post_id, 'collaboration_partners', $this->collaboration_partners);
            update_post_meta($_post_id, 'collaboration_id', $this->Active->Collaboration->ID);
            update_post_meta($this->Active->Collaboration->ID, 'textured_download_id', $_post_id);
            
            update_post_meta($_post_id, 'model_type', 'textured');
            
            $concept_created = '';
            if($this->Active->Collaboration->launch_type == 'concept') {
                $concept_created = 'yes';
            } else {
                $concept_created = $this->Active->Collaboration->concept_created;
            }
            update_post_meta($_post_id, 'concept_created', $concept_created);
            
            
            $this->after_submit($_post_id);
            $this->Active->moveToNextStop();
            
            
            
            return array('success' => true , 'msg' => $success_msg);
        }
        
        return array('error' => true , 'msg' => 'unable to post.');
    }
}


class KSM_CollaborationPublishModelTexturedPublisher extends KSM_CollaborationPublishTexturedPublisher {
    
    
}
