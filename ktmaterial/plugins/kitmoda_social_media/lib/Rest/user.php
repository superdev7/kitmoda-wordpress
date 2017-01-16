<?php


class KSM_Rest_Controller_User extends KSM_BaseRest {
    
    
    
    public function register_permission($request) {
        
        $this->request = $request;
        
        
        
        
        if(!get_current_user_id()) {
            return true;
        }
        
        return false;
    }
    
    
    
    
    
    
    public function register() {
        $form = KSM_Form::get_form('Registration', array('data' => $this->params()));
        return $form->submit();
    }
    
    
    
    
    
    public function login_permission($request) {
        
        $this->request = $request;
        
        return true;
    }
    
    
    
    
    
    
    public function login() {
        
        $email = sanitize_text_field($this->param('email'));
        $pass = sanitize_text_field($this->param('pass'));
        
        
        
        
        
        $error = "";
        
	
	if ( !$email) {
            $this->Error('login', "Please type your email address.");
	} elseif ( !$pass) {
            $this->Error('login', "Password is required");
	} else {
            
            
            
            
            $user = get_user_by( 'email', $email );
        
            if ( $user instanceof WP_User) {
                if ( wp_check_password( $pass , $user->data->user_pass, $user->ID ) ) {
                    $email_confirmed = get_user_meta($user->ID, 'email_confirmed', true);
                    if($email_confirmed == 'no') {
                        $this->Error( 'login', "Please confirm your email address to activate your account.");
                    } else {
                        wp_set_auth_cookie( $user->ID, true );
                        wp_set_current_user( $user->ID, $user->user_login );
                        do_action( 'wp_login', $user->user_login );


                        if($ara == 'community_add_post') {
                            $url = ksm_get_permalink('community');
                        } elseif($ara == 'collaboration_active') {
                            $url = ksm_get_permalink('collaboration/active/');
                        } elseif($ara == 'collaboration_launch') {
                            $url = ksm_get_permalink('collaboration/launch/');
                        } elseif($ara == 'collaboration_requests') {
                            $url = ksm_get_permalink('collaboration/requests/');
                        } elseif($ara == 'collaboration_partner_projects') {
                            $url = ksm_get_permalink('collaboration/partner_projects/');
                        } elseif($ara == 'account_messages') {
                            $url = ksm_get_permalink('account/messages/');
                        } elseif($ara == 'account_purchase_library') {
                            $url = ksm_get_permalink('account/purchase_library/');
                        } elseif($ara == 'account_sales') {
                            $url = ksm_get_permalink('account/sales/');
                        } elseif($ara == 'account_products') {
                            $url = ksm_get_permalink('account/products/');
                        } else {
                            $url = ksm_get_permalink('studio');
                        }

                        $this->setSuccess('Login', array('redirect' => $url));

                    }


                }
            }
            
            
            
            
        }
        
        
        if(!$this->is_success && !$this->is_error) {
            $this->Error('login', "Invalid login details.");
        }
        
        
        $this->send_result();
        
        
        
        
        
    }
    
    
    
    
    public function recover_permission($request) {
        
        $this->request = $request;
        
        return true;
    }
    
    
    
    
    
    
    public function recover() {
        
        $email = $this->param('email');
        
        
	if ( empty( $email ) || !$email ) {
            $this->Error('email',"Enter an e-mail address.");
	}
        
        if ( $user = KSM_User::get($email, 'email') ) {
            if(!is_wp_error($user->request_reset_password())) {
                $this->setSuccess('Check your email for a link to reset your password.');
            } else {
                $this->Error('email',"The e-mail could not be sent.");
            }
        } else {
        
            $this->Error('email',"Invalid e-mail address.");
        }
        
        $this->send_result();
        
    }
}

?>