<?php

//'collaboration_join_request'

class KSM_CollaborationRequestModel extends KSM_BaseModel {
    
    
    public $collaboration_types = array('concept', 'untextured'),

        $post_type = 'collab_join_request';
    
    
    
    
    function can_user_send_join_request($post_id) {
        
        $can_send_join_request = false;
        $error = "You can't send a request to join this collaboration.";
        
        $user_id = get_current_user_id();
        
        
        
        
        if($post_id) {
            
            $collaboration = new KSM_Collaboration($post_id);

            

            if($collaboration->isRequestSubmissionOpen() && $user_id != $collaboration->post_author) {
                if($collaboration->user_already_submit_join_request()) {
                    $error = "You already sent a request to join this collaboration.";
                } else {
                    $can_send_join_request = true;
                }
            }

            if($can_send_join_request) {
                return $this->Success('');
            }
        }
        
        
        return $this->Error($error);
        
        
        
        
    }
    
    
    
    
    /*
    function join_request_exists($post_id, $user_id = 0) {
        if(!$user_id) {
            $user_id = get_current_user_id();
        }
        if(!$user_id || !$post_id) {
            return true;
        }
        
        
        global $wpdb;
        
        $q = "SELECT p.ID FROM $wpdb->posts p WHERE p.post_author = '{$user_id}' 
             AND p.post_type = 'collab_join_request' AND p.post_parent = '{$post_id}'";
        
        return $wpdb->get_var($q);
        
    }
    */
    
    
    
    
    function send_join_request() {
        
        
        $user_id = get_current_user_id();
        
        
        $request_type =sanitize_text_field( $_POST['request_type']); // 1 = model, 2 = texture, 3 = model + texture
        $model_price = sanitize_text_field($_POST['model_price']);
        $texture_price = sanitize_text_field($_POST['texture_price']);
        $post_id = sanitize_text_field($_POST['_id']);
        
        
        
        $collaboration = new KSM_Collaboration($post_id);
        
        
        if(!$collaboration->isRequestSubmissionOpen()) {
            $error = "You can't send a request to join this collaboration.";
        } 
        
        elseif($collaboration->user_already_submit_join_request()) {
            $error = "Your request to join this collaboration was already sent.";
        }
        
        elseif(!in_array($request_type, $collaboration->acceptableRequestTypes())) {
            $error = "You can't apply for that role";
        }
        
        
        if($error) {
            return $this->Error($error);
        }
        
        
        
        
        $price_fields = array();
        
        
        if($request_type == 'model') {
            $price_fields = array('model_price');
        } elseif($request_type == 'texture') {
            $price_fields = array('texture_price');
        } elseif($request_type == 'texture') {
            $price_fields = array('model_price', 'texture_price');
        }
        
        
        
        
        $required_fields = array_merge(array('message'), $price_fields);
        
        
        
        $data['message'] = sanitize_text_field($_POST[ 'message' ])  ? wp_kses( $_POST[ 'message' ], array() ) : '';
        $data['model_price'] = sanitize_text_field($_POST['model_price']);
        $data['texture_price'] = sanitize_text_field($_POST['texture_price']);
        
        
        
        $v = new KSM_Validator($data);
        
        
        $v->rule('required', $required_fields);
        $v->rule('price', $price_fields);
        
        
        if($v->validate()) {
            
            if(!$_POST['terms_agreed'] == 'yes') {
                $error = "You must agree to the terms";
            }
        } else {
            $ak = array_keys($v->errors());
            $error = array_shift(array_shift($v->errors()));
        }
        
        
        if($error) {
            return $this->Error($error);
        }
        
        
        $data['request_type'] = $request_type;
        
        
        if(!$collaboration->add_request($data)) {
            return $this->Error('Error while sending your request');
        } 
        
        
        return $this->Success('');
    }
    
    
    
    
    
    public function accept_request($id) {
        
        
        $request = new KSM_CollaborationRequest($id);
        
        $result = $request->Accept();
        
        
        
        
        return $result;
        
        
        //if(!$id) {
        //    return $this->Error("Select a request");
        //}
        
        //$collaborationRequest = new KSM_CollaborationRequest($id);
        
        //get_post($post);
        
        //echo $id;
        //pr(get_post((int)$id));
        
        //exit;
        
        //return $collaborationRequest->Accept();
    }
    
    
    
    
    public function reject_request($id) {
        
        
        $request = new KSM_CollaborationRequest($id);
        
        $result = $request->Reject();
        
        
        
        
        return $result;
        
        
    }
    
    
}