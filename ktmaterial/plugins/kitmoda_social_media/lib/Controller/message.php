<?php

class KSM_MessageController extends KSM_BaseController {
    
    public $scripts = array(
        array('message', array('jquery', 'ksm_scripts', 'jquery-ui-sortable'))
    );
    
    
    
    
    public function ksm_index() {
        
        
        $this->set('sub_tab', 'messages');
        
        $user_id = get_current_user_id();
        if(!$user_id) {
            $login_page = ksm_get_permalink('login/account_messages');
            wp_redirect($login_page);
            exit;
        }
        
    }
    
    
    
    public function ksm_dl_images() {
        
        if($this->params['id']) {
            $message = new KSM_Message($this->params['id']);
            if($message && $message->hasAccess()) {
                $message->download_images();
            }
        }
        exit;
    }
    
    
    public function ksm_compose() {
        
        
        $this->layout = 'colorbox';
        
        
        $to_username = get_query_var('to_user');
        $to_user = "";
        
        if($to_username) {
            $to_user = get_user_by('login', $to_username);
            //if(!$to_user) {
            //    $to_username = "";
            //}
        }
        
        
        
        
        $images_uploader = KSM_Uploader::get_uploader('mciau'); // Image Attachment Uploader
        
        $attachment_uploader = KSM_Uploader::get_uploader('mcfau');
        
        $this->set('images_uploader', $images_uploader);
        $this->set('attachment_uploader', $attachment_uploader);
        $this->set('to_user', $to_user);
        
        
    }
    
    
    
    public function ksm_ajax_send() {
        
        $this->Model->send();
        
        
    }
    
    
    public function ksm_ajax_dd() {
        $this->Model->messages();
    }
    
    
    public function ksm_ajax_delete() {
        $this->Model->delete_messages();
    }
    
    public function ksm_ajax_read() {
        
        $this->Model->read_messages();
        
    }
}

