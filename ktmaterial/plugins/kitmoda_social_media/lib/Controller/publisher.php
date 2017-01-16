<?php

class KSM_PublisherController extends KSM_BaseController {
    
    
    
    public $scripts = array(
        array('jquery.selectBoxIt', array('jquery', 'jquery-ui-widget')),
    );
    
    
    
    public function ksm_publisher() {
        
        
        $this->layout = 'publisher';
        
        
        $this->scripts[] = array('publisher', array('jquery', 'ksm_scripts', 'jquery-ui-sortable'));
        $this->scripts[] = array('jquery.caret.min');
        $this->scripts[] = array('jquery.tag-editor.min', array('jquery', 'jquery-ui-sortable', 'jquery-ui-autocomplete'));
        
        
        
        $this->scripts[] = array('jScrollPane', array('jquery'));
        $this->scripts[] = array('jquery.mousewheel', array('jquery'));
        $this->scripts[] = array('SelectBox', array('jquery'));
        
        
        $this->styles[] = 'jquery.jscrollpane';
        $this->styles[] = 'customSelectBox';
        
        $this->styles[] = 'jquery.tag-editor';
        $hasAccess = false;
                
                
        $pub_name = $this->params['pub_name'];
        
        
        if($pub_name) {
            $pub_args = array();
            if($this->params['id']) {
                $pub_args['id'] = $this->params['id'];
            }
            
            $publisher = KSM_Publisher::get($pub_name, $pub_args);
            if($publisher && $publisher->can_publish()) {
                $hasAccess = true;
            }
        }
        
        
        
        
        if(!$hasAccess) {
            KSM_Js::closeColorBoxWithError('You can\'t publish here.');
            exit;
        }
        
        $this->set('publisher', $publisher);
    }
    
    
    
    /*
    public function ksm_ajax_validate() {
        
        $step = $_POST['step'];
        $_id = $_POST['pub_id'];
        
        $_params = KSM_Action::get($_id);
        
        
        $result = array('error' => true, 'msg' => 'Error');
        
        if(is_array($_params)) {
            $pub_name = $_params['name'];
            
            if($pub_name) {
                
                $publisher = KSM_Publisher::get($pub_name);
                
                if($publisher) {
                    
                    $method = "validate_{$step}";
                
                    if(method_exists($publisher, $method)) {
                        $result = $publisher->{$method}();
                    }
                    
                }
                
                
            }
            
        }
        
        echo json_encode($result);
        die();
        
    }
    
    
    */
    
    
    
    public function ksm_ajax_validate() {
        
        
        $hasAccess = false;
        
        $_id = $_POST['pub_id'];
        $step = $_POST['step'];
        
        $_params = KSM_Action::get($_id);
        
        //pr($_params);
        if(is_array($_params)) {
            
            
            //pr($_params);
            
            $pub_name = $_params['name'];
            
            
            if($pub_name) {
                $pub_args = array();
                if($_params['_id']) {
                    $pub_args['id'] = $_params['_id'];
                }
                $publisher = KSM_Publisher::get($pub_name, $pub_args);
                if($publisher && $publisher->can_publish()) {
                    $method = "validate_{$step}";
                    if(method_exists($publisher, $method)) {
                        $hasAccess = true;
                    }
                }
            }
        }
        
        
        if($hasAccess) {
            $result = $publisher->{$method}();
        } else {
            $result = array('error' => true, 'msg' => 'You dont have access to publish here.');
        }
        
        
        echo json_encode($result);
        die();
    }
    
    
    
    
    public function ksm_ajax_submit() {
        
        
        $hasAccess = false;
        
        $_id = $_POST['pub_id'];
        $_params = KSM_Action::get($_id);
        
        
        if(is_array($_params)) {
            $pub_name = $_params['name'];
            
            
            if($pub_name) {
                $pub_args = array();
                if($_params['_id']) {
                    $pub_args['id'] = $_params['_id'];
                }
                $publisher = KSM_Publisher::get($pub_name, $pub_args);
                if($publisher && $publisher->can_publish()) {
                        $hasAccess = true;
                }
            }
        }
        
        
        if($hasAccess) {
            $method = "submit";
                
            if(method_exists($publisher, $method)) {
                $result = $publisher->{$method}();
            }
        } else {
            $result = array('error' => true, 'msg' => 'You dont have access to publish here.');
        }
        
        
        
        if($result['error']) {
            KSM_Js::setPublisherError($result['msg']);
            exit;
        }
        
        
        
        
        KSM_Js::reloadPageWithMessage('', $result['msg'] , 2);
        
        die();
    }
    
    
    
    
    
    
    
    
    
    
    public function ksm_index() {
        
        $this->layout = 'colorbox';
        
    }
    
    
    
    
    
    
    
    
}
?>