<?php

abstract class KSM_BaseRest {
    
    
    public $request,
           $errors,
           $success_data = array(),
           $success_msg = "",
           $is_success = false,
           $is_error = false
           ;
    
    
    
    function __construct() {
        
    }
    
    
    protected function params() {
        
        $params = (Array) $this->request->get_params();
        
        return $params;
    }
    
    protected function param($name) {
        $param = "";
        $params = $this->params();
        if($params[$name]) {
            $param = $params[$name];
        }
        
        return $param;
    }
    
    
    
    
    protected function access_header_params() {
        
        $params = array();
        
        $access_header = $this->request->get_header('ksm_access_id');
        if($access_header) {
            $access_params = KSM_Action::get($access_header);
        
            $params = $access_params;
        }
        
        return $params;
    }
    
    
    protected function access_header_user() {
        
        $user = null;
        
        $params = $this->access_header_params();
        if(!empty($params) && $params['user']) {
            $user = get_user_by('login', $params['user']);
        }
        return $user;
    }
    
    
    protected function is_access_valid($require_login = true) {
        $user_id = get_current_user_id();
        
        $valid = false;

        
        
        if($user_id) {
            
            $request_user =  $this->access_header_user();
            if($request_user && $request_user->ID == $user_id) {
                $valid = true;
            }
        }
        return $valid;
    }
    
    
    
    protected function Error($name, $error) {
        $this->is_error = true;
        $this->errors[$name] = $error;
    }
    
    
    protected function Errors() {
        $data = array();
        if(!empty($this->errors)) {
            $data['success'] = false;
            $data['errors']  = $this->errors;
        }
        return $data;
    }
    
    
    function setSuccess($message = '', $data = array()) {
        
        $this->success_msg = $message;
        $this->success_data = $data;
        
        $this->is_success = true;
    }
    
    protected function Success($message = '', $data = array()) {
        
        
        $result = array();
        
        $result['success'] = true;
        if($message) {
            $result['message'] = $message;
        }
        
        
        if($data) {
            $result = array_merge($result, $data);
        }
        
        
        return $result;
    }
    
    
    
    
    
    function send_result() {
        if(!empty($this->errors)) {
            
            $response = array('error' => true, 'errors' => $this->errors );
        } elseif($this->is_success) {
            
            $this->success_data['msg'] = $this->success_msg;
            $this->success_data['success'] = true;
            $response = $this->success_data;
        }
        
        wp_send_json($response);
        
        
    }
    
}

?>