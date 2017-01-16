<?php

class KSM_ModelStepPublisherController extends KSM_BaseController {
    
    
    
    public $scripts = array(
        array('publisher', array('jquery', 'ksm_scripts', 'jquery-ui-sortable'))
    );
    
    public $required_login = array('*');
    
    
    
    public function ksm_index() {
        
        $this->layout = 'publisher';
        
        
        $active_id = $this->params['id'];
        $step = $this->params['step'];
        $step_state = $this->params['step_state'];
        
        
        
        $hasAccess = false;
        
        
        if($active_id) {
            $active = new KSM_CollaborationActive($active_id);
            
            
            
            if($active->ID) {
                
                if($active->can_publish_wip($step, $step_state)) {
                    $hasAccess = true;
                    $publisher = KSM_Publisher::get('model_mid_wip');
                    $publisher->Active = $active;
                }
                
            }
        }
        
        
        if(!$hasAccess) {
            echo "Error";
            exit;
        }
        
        
        
        
        $this->styles[] = 'concept_publisher';
        $this->set('publisher', $publisher);
    }
    
    
    public function ksm_ajax_validate_images() {
        
        $result = $this->Model->validate_images();
        
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