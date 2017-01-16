<?php

class KSM_ConceptPublisherController extends KSM_BaseController {
    
    
    
    public $scripts = array(
        array('publisher', array('jquery', 'ksm_scripts', 'jquery-ui-sortable'))
    );
    
    public $required_login = array('*');
    
    
    
    public function ksm_index() {
        
        $this->layout = 'colorbox';
        
        
        
        
        
        
        $options = KSM_DataStore::Options('ConceptPublisher');
        
        
        
        
        
        $this->set('pub_options', $options);
        
        
        
        
        
        
        
    }
    
    
    public function ksm_ajax_validate_images() {
        
        $result = $this->Model->validate_images();
        
        echo json_encode($result);
    }
    
    
    
    
    public function ksm_ajax_validate_notes() {
        $result = $this->Model->validate_notes();
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