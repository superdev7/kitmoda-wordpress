<?php

class KSM_UntexturedPublisherController extends KSM_BaseController {
    
    
    
    public $scripts = array(
        array('publisher', array('jquery', 'ksm_scripts', 'jquery-ui-sortable'))
    );
    
    public $required_login = array('*');
    
    
    
    public function ksm_index() {
        
        $this->layout = 'colorbox';
        
        
        $options = KSM_DataStore::Options('UntexturedPublisher');
        
        
        
        //$images_uploader = KSM_Uploader::get_uploader($this->Model->image_uploader_name);
        //$textured_file_uploader = KSM_Uploader::get_uploader('tpf');
        //$untextured_file_uploader = KSM_Uploader::get_uploader('utpf');
        
        
        
        
        
        $this->set('images_uploader', $images_uploader);
        $this->set('textured_file_uploader', $textured_file_uploader);
        $this->set('untextured_file_uploader', $untextured_file_uploader);
        
        
        $this->set('pub_options', $options);
        
        
        
        
        
        
        
    }
    
    
    public function ksm_ajax_validate_images() {
        
        $result = $this->Model->validate_images();
        
        echo json_encode($result);
    }
    
    
    
    
    public function ksm_ajax_validate_description() {
        $result = $this->Model->validate_description();
        echo json_encode($result);
    }
    
    
    public function ksm_ajax_validate_tech() {
        $result = $this->Model->validate_tech();
        echo json_encode($result);
    }
    
    
    public function ksm_ajax_validate_upload() {
        $result = $this->Model->validate_upload();
        echo json_encode($result);
    }
    
    
    public function ksm_ajax_submit() {
        
        $result = $this->Model->submit();
        
        if($result['success']) {
            KSM_Js::cbCloseWithMessage($result['msg']);
        }
    }
    
    
}
?>