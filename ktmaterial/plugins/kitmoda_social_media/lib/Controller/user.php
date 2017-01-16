<?php

class KSM_UserController extends KSM_BaseController {
    
    
    public $styles = array('selectbox/jquery.selectbox', 'selectbox/jquery.selectbox');
    public $scripts = array(
        array('selectbox/jquery.selectbox-0.2.min', array('jquery', 'ksm_scripts')),
        array('jquery.mCustomScrollbar.concat.min', array('jquery', 'ksm_scripts')),
        array('selectbox/jquery.selectbox-0.2-profile.min', array('jquery'))
    );
    
    
    
    
    public function ksm_login() {
        $this->layout = 'colorbox';
        $user_id = get_current_user_id();
        
        if($user_id) {
            KSM_Js::setLoginSuccess($this->params['ar_action']);
            exit;
        }
        
        
        
        
        
        if($_GET['action'] == 'confirm' && isset($_GET['id']) && isset($_GET['eckey'])) {
            $id = base64_decode($_GET['id']);
            $key = $_GET['eckey'];
            
            $user = KSM_User::get($id);
            
            if($user) {
                if($user->varefy_key($key, 'signup')) {
                    $success = "Account successfully activated.";
                }
            }
            
            if(!$success) {
                $error = "Invalid verification link or link has been expired";
            }
            
        }
        
        
        
        
        
        
        if($error) {
            $this->set('error', $error);
        }
        
        
        if($success) {
            $this->set('success', $success);
        }
        
        $this->set('ar_action', $this->params['ar_action']);
    }
    
    
    public function ksm_forgot_password() {
        
        $this->layout = 'colorbox';
        
    }
    
    public function ksm_reset_password() {
        
        $this->layout = 'colorbox';
        $error = "";
        $user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
        
        
        
        if ( ! $user || is_wp_error( $user ) ) {
            if ( $user && $user->get_error_code() === 'expired_key' ) $error = true;
            else $error = true;
        }
        
        
        if($error) {
            EDD()->session->set('ksm_error_invalid_key', "The password reset link is not valid anymore");
            $url = ksm_get_permalink('login').'/?err=invalid_key';
            wp_redirect($url);
            exit;
        }
        
        
        $this->set('key', $_REQUEST['key']);
        $this->set('login', $_REQUEST['login']);
    }
    
    
    public function ksm_ajax_submit_reset_password() {
        $result = $this->Model->reset_password();
        
        if($result['error']) {
            KSM_Js::setLoginError($result['msg']);
        } elseif($result['success']) {
            EDD()->session->set('ksm_success_reset_password', $result['msg']);
            KSM_Js::setLoginSuccess($_POST['ara']);
        }
    }
    
    
    public function ksm_ajax_submit_forgot_password() {
        
        $result = $this->Model->forgot_password();
        
        if($result['error']) {
            KSM_Js::setLoginError($result['msg']);
        } elseif($result['success']) {
            
            KSM_Js::success_forgot_password();
        }
    }
    
    
    public function ksm_ajax_submit_login() {
        
        $result = $this->Model->login();
	        
        if($result['error']) {
            KSM_Js::setLoginError($result['msg']);
        } elseif($result['success']) {
            KSM_Js::setLoginSuccess($_POST['ara']);
        }
    }
    
    
    
    public function ksm_signout() {
        
        if ( is_user_logged_in() ) {
            wp_logout();
            $_url = ksm_get_permalink('store');
            wp_redirect( $_url );
            exit;
        }
    }
    
    
    public function ksm_join() {
        $this->layout = 'colorbox';
        
        $this->set('ar_action', $this->params['ar_action']);
    }
    
    
    public function ksm_ajax_submit_join() {
        
        $result = $this->Model->registration();
        
        if($result['error']) {
            KSM_Js::setLoginError($result['msg']);
        } elseif($result['success']) {
            
            KSM_Js::setLoginSuccess($_POST['ara']);

        }
        
        
    }
    
    public function ksm_edit_profile() {
        $this->layout = 'colorbox';
        
        $user = $this->KUser->Auth;
        
        
        
        $countries = KSM_DataStore::Options('country');
        $languages = KSM_DataStore::Options('languages');
        
        $this->set('countries', $countries);
        $this->set('languages', $languages);
        $this->set('user', $user);
        
        $uploader = KSM_Uploader::get_uploader('epua');
        
        $this->set('avatar_uploader', $uploader);
        
        $this->scripts[] = array('jquery.caret.min', array('jquery'));
        
        
        
        $this->scripts[] = array('jquery.tag-editor.min', array('jquery', 'jquery-ui-sortable', 'jquery-ui-autocomplete'));
        
        
        $this->scripts[] = array('jquery.selectBoxIt', array('jquery'));
        
        $this->styles[] = 'jquery.selectBoxIt';
        
        $this->styles[] = 'jquery.tag-editor';
    }
    
    
    public function ksm_ajax_update_profile() {
        $this->Model->update_profile();
    }
    
    public function ksm_ajax_update_settings() {
        $this->Model->update_settings();
    }
    
    
    
    public function ksm_account_settings() {
        $this->layout = 'colorbox';
        
        $settings = $this->Model->account_settings($this->KUser->Auth);
        $this->set('settings', $settings);
    }
    
    
    
    
    
    public function ksm_ajax_unfollow() {
        
        $result = array();
        
        if($_POST['id']) {
            $action = KSM_Action::get($_POST['id']);
            if($action['action'] == 'unfollow' && $action['_id']) {
                $result = KSM_Follow::unfollow($action['_id']);
            }
        }
        
        
        echo json_encode($result);
        die();
    }
    
}
?>