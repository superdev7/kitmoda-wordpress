<?php



class KSM_UserModel extends KSM_BaseModel {
    
    
    
    
    public function login() {
        
        $email = sanitize_text_field($_POST['user']);
        $pass = sanitize_text_field($_POST[ 'pass' ]);
        
        
        $error = "";
        
	
	if ( !$email) {
            $error = "Please type your email address.";
	} elseif ( !$pass) {
            $error = "Password is required";
	}
        
        
        if($error) 
            return $this->Error($error);
        
        
        $user = get_user_by( 'email', $email );
        //if(!$user instanceof WP_User) {
        //    $user = get_user_by( 'login', $username_email );
        //}
        

	//wp_authenticate($error, $password);
        //wp_login($error, $password);
        
        
	if ( $user instanceof WP_User) {
            
            if ( wp_check_password( $pass , $user->data->user_pass, $user->ID ) ) {
                
                $email_confirmed = get_user_meta($user->ID, 'email_confirmed', true);
                if($email_confirmed == 'no') {
                    return $this->Error("Please confirm your email address to activate your account.");
                } else {
                    wp_set_auth_cookie( $user->ID, true );
                    wp_set_current_user( $user->ID, $user->user_login );
                    do_action( 'wp_login', $user->user_login );
                    return $this->Success();
                }
                
		
            } 
	}
        
        return $this->Error("Invalid login details.");
    }
    
    
    
    public function reset_password() {
        
        $error = "";
        
        $data = $_POST;
        
        $key = sanitize_key($_POST['key']);
        $login = sanitize_text_field($_POST['login']);
        
        $pass1 = sanitize_text_field($_POST['pass1']);
        $pass2 = sanitize_text_field($_POST['pass2']);
        
        
        $user = check_password_reset_key( $key, $login );
        
        
        if ( ! $user || is_wp_error( $user ) ) {
            if ( $user && $user->get_error_code() === 'expired_key' ) $error = true;
            else $error = true;
        }
        
        
        if($error) {
            return $this->Error("The password reset link is not valid anymore");
        }
        
        
        $password_min_length = 5;
        
        
        if ( is_user_logged_in() ) {
            $error = "You are already logged in";
        } elseif ( ! $pass1 || $pass1 == '' ) {
            $error = 'Password is required.';
        } elseif ( strlen($pass1) < $password_min_length ) {
            $error = "Password must be {$password_min_length} character long";
        } elseif ( $pass1 != $pass2 ) {
            $error = "Confirm password you entered don't match";
        }
        
        if($error) {
            return $this->Error($error);
        }
        
        
        reset_password( $user, $pass1 );
        return $this->Success('Your password has been changed.  Please log in to continue...');
    }
    
    public function forgot_password() {
        
        $email = sanitize_email($_POST['email']);
        
        
	if ( empty( $email ) || !$email ) {
            return $this->Error("Enter an e-mail address.");
	}
        
        if ( $user = KSM_User::get($email, 'email') ) {
            if(!is_wp_error($user->request_reset_password())) {
                return $this->Success();
            } else {
                return $this->Error("The e-mail could not be sent.");
            }
            
        }
	return $this->Error("Invalid e-mail address.");
    }
    
    public function registration() {
        
        
        
        $form = KSM_Form::get_form('Registration', array('data' => $_POST));
        
        pr($form->validate());
        
        exit;
        
        $password_min_length = 5;
        
        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']); //Sanitized Email
        $password = sanitize_text_field($_POST['pass']);
        
        
        if ( is_user_logged_in() ) {
            $error = "You are already logged in";
        } else if ( !(bool)EDD_FES()->helper->get_option( 'fes-allow-applications', true ) ) {
            $error = 'Sorry! Registration is currently disabled at this time!';
	} elseif (!$username || $username == '' ) {
            $error = 'Username is required.';
        } elseif(username_exists($username) ) {
            $error = 'Username is already in use.';
        } elseif(!$email || $email == '') {
            $error = "Email is required";
        } elseif ( ! is_email( $email) ){
            $error = 'Please enter a valid email!';
	} elseif(email_exists($email)) {
            $error = 'Email is already in use.';
        } elseif ( ! $password || $password == '' ) {
            $error = 'Password is required.';
        } elseif ( strlen($password) < $password_min_length ) {
            $error = "Password must be {$password_min_length} character long";
        }
        
        if($error) {
            return $this->Error($error);
        }
        
        
        $email = sanitize_email($email);
	
        $userdata['user_email'] = $email ;
        $userdata['user_pass']  = $password;
        $userdata['user_login'] = $username;
        $userdata[ 'role' ] = 'frontend_vendor';
        $userdata[ 'user_registered' ] = date( 'Y-m-d H:i:s' );
        
        
	$user_id = wp_insert_user( $userdata );
	if ( is_wp_error( $user_id ) )
            return $this->Error($user_id->get_error_message());
        
        
        
	wp_new_user_notification( $user_id );
        
        
        
        
        
        update_user_meta($user_id, 'c_artwork_rating', '0');
        update_user_meta($user_id, 'c_communication_rating', '0');
        
        
	wp_set_auth_cookie( $user_id, true );
	wp_set_current_user( $user_id, $userdata[ 'user_login'] );
	do_action( 'wp_login', $userdata[ 'user_login'] );
        
        return $this->Success('Welcome to Kitmoda.');
    }
    
    
    
    public function update_profile() {
        global $user_ID;
        
        $user = new stdClass;
        
	
	$user->ID = (int) $user_ID;
	$userdata = get_userdata( $user_ID );
        
	
	

	if ( isset( $_POST['email'] )) {
            $user->user_email = sanitize_email( $_POST['email'] );
        }
	if ( isset( $_POST['url'] ) ) {
            if ( empty ( $_POST['url'] ) || $_POST['url'] == 'http://' ) {
		$user->user_url = '';
            } else {
		$user->user_url = esc_url_raw( $_POST['url'] );
		$protocols = implode( '|', array_map( 'preg_quote', wp_allowed_protocols() ) );
		$user->user_url = preg_match('/^(' . $protocols . '):/is', $user->user_url) ? $user->user_url : 'http://'.$user->user_url;
            }
	}
	
	if ( isset( $_POST['display_name'] ) ) {
            $user->display_name = sanitize_text_field( $_POST['display_name'] );
        }
        
        

	
	$error = "";
        
	
        
	
	if ( empty( $user->user_email ) ) {
            $error = "Please enter an e-mail address.";
	} elseif ( !is_email( $user->user_email ) ) {
            $error = "The email address isn&#8217;t correct.";
	} elseif ( ( $owner_id = email_exists($user->user_email) ) && (  $owner_id != $user->ID  ) ) {
            $error = "This email is already registered, please choose another one.";
	}
        
        
        
        
        
        
        
        
	if(!$error) {
            wp_update_user( $user );
            
            update_user_meta($user->ID, 'country', $_POST['country']);
            update_user_meta($user->ID, 'skills', $_POST['skills']);
            update_user_meta($user->ID, 'softwares', $_POST['softwares']);
            update_user_meta($user->ID, 'primary_lang', $_POST['primary_lang']);
            update_user_meta($user->ID, 'secondary_lang', $_POST['secondary_lang']);
            update_user_meta($user->ID, 'tagline', $_POST['tagline']);
            
            update_user_meta($user->ID, 'completeness', $this->calculate_completeness($user->ID));
            
            
            
            
            
            if($_POST['avatar_id']) {
            
                $att_post = get_post($_POST['avatar_id']);
                
                $uploader = KSM_Uploader::get_uploader('epua');
                
                
                
                if($att_post && $uploader->isAttachable($att_post->ID)) {
                    update_user_meta($user->ID, 'avatar', $att_post->ID);
                    update_user_meta($user->ID, 'avatar_large', get_image_src($att_post->ID, 'avatar_large'));
                    update_user_meta($user->ID, 'avatar_small', get_image_src($att_post->ID, 'avatar_small'));
                    do_action('ksm_user_attach_attachment', $att_post->ID);
                }
            }
            
            
            
            
            
            
            
            $success = true;
        }
        
        
	if($success) {
            KSM_Js::setProfileEditSuccess();
        } else {
            KSM_Js::setProfileEditError($error);
        }
        
        die();
        
    }
    
    
    
    
    function calculate_completeness($user_id) {
        
        
        $completeness = 0;
        
        
        if($user_id && $user = get_user_by('id', $user_id)) {
            
            if($user->tagline) 
                $completeness += 5;
            
            if($user->avatar) 
                $completeness += 20;
            
            if($user->user_email) 
                $completeness += 10;
            
            if($user->user_url) 
                $completeness += 10;
            
            if($user->country) 
                $completeness += 10;

            if($user->skills) 
                $completeness += 15;

            if($user->softwares) 
                $completeness += 20;

            if($user->primary_lang || $user->secondary_lang) 
                $completeness += 10;
            
        }
        
        
        
        
        return $completeness;
        
    }
    
    
    
    
    
    
    
    
    
    
    function account_settings($user) {
        
        $settings = $user->ksm_settings ? $user->ksm_settings : array();
        
        
        
        if(!$settings['email_all']) {
            $settings['email_all'] = '';
        }
        
        
        if(!$settings['email_challenge']) {
            $settings['email_challenge'] = 1;
        }
        
        if(!$settings['email_updates']) {
            $settings['email_updates'] = 1;
        }
        
        if(!$settings['email_sales']) {
            $settings['email_sales'] = 1;
        }
        
        
        if($settings['email_all'] == 1) {
            $settings['email_challenge'] = 3;
            $settings['email_updates'] = 2;
            $settings['email_sales'] = 2;
        }
        
        
        if(!$settings['site_interested']) {
            $settings['site_interested'] = 1;
        }
        if(!$settings['site_default_page']) {
            $settings['site_default_page'] = 1;
        }
        
        return $settings;
        
    }
    
    
    function update_settings() {
        global $user_ID;
        
        $settings = array();
        
        $settings['email_sales'] = sanitize_text_field($_POST['email_sales']);
        $settings['email_updates'] = sanitize_text_field($_POST['email_updates']);
        $settings['email_challenge'] = sanitize_text_field($_POST['email_challenge']);
        $settings['email_all'] = sanitize_text_field($_POST['email_all']);
        
        $settings['email_all'] = $settings['email_all'] ? 1 : 0;
        
        $settings['site_interested'] = sanitize_text_field($_POST['site_interested']);
        $settings['site_default_page'] = sanitize_text_field($_POST['site_default_page']);
        
        
        
        if(!$settings['email_challenge'] || !in_array($settings['email_challenge'], range(1,3))) {
            $settings['email_challenge'] = 1;
        }
        
        if(!$settings['email_updates'] || !in_array($settings['email_updates'], range(1,2))) {
            $settings['email_updates'] = 1;
        }
        
        if(!$settings['email_sales'] || !in_array($settings['email_sales'], range(1,2))) {
            $settings['email_sales'] = 1;
        }
        
        
        if($settings['email_all'] == 1) {
            $settings['email_challenge'] = 3;
            $settings['email_updates'] = 2;
            $settings['email_sales'] = 2;
        }
        
        
        if($settings['email_challenge'] == 3 &&
            $settings['email_updates'] == 2 &&
            $settings['email_sales'] == 2) {
            $settings['email_all'] = 1;
        } else {
            $settings['email_all'] = '';
        }
        
        
        
        if(!$settings['site_interested'] || !in_array($settings['site_interested'], range(1,3))) {
            $settings['site_interested'] = 1;
        }
        
        if(!$settings['site_default_page'] || !in_array($settings['site_default_page'], range(1,5))) {
            $settings['site_default_page'] = 1;
        }
        
        
        update_user_meta($user_ID, 'ksm_settings', $settings);
        KSM_Js::SettingsSaved();
        die();
    }
    
}