<?php

class KSM_Email extends KSM_Object {
    
    
    public  $layout = 'default',
            $from_name,
            $from_email,
            $subject,
            $headers,
            
            $html = true;
    
    public function __construct($args = array()) {
        parent::__construct($args);
    }
    
    
    
    static function get($name, $args = array()) {
        
        
        if($name) {
            
            
            $cls_name = "KSM_Email_" . ucfirst(ksm_camelcase($name));
            
            $args['name'] = $name;
            if(class_exists($cls_name)) {
                return new $cls_name($args);
            }
            
        }
        
        
        
        return null;

    }
    
    
    public function to_email() {
        return $this->User->user_email;
    }
    
    public function subject() {
        return '';
    }
    
    public function to_name() {
        return $this->User->display_name();
    }
    
    public function get_headers() {
        if ( ! $this->headers ) {
            $this->headers  = "From: {$this->get_from_name()} <{$this->get_from_address()}>\r\n";
            $this->headers .= "Reply-To: {$this->get_from_address()}\r\n";
            $this->headers .= "Content-Type: {$this->get_content_type()}; charset=utf-8\r\n";
	}

	return $this->headers;
    }
    
    
    
    public function get_from_name() {
	
        $from_name = 'Kitmoda';
	return wp_specialchars_decode( $from_name );
    }
    
    public function get_from_address() {
	if ( ! $this->from_email ) {
            $this->from_email = edd_get_option( 'from_email', get_option( 'admin_email' ) );
	}
	return $this->from_email;
    }
    
    public function get_content_type() {
        
	if ( ! $this->content_type && $this->html ) {
            $this->content_type = 'text/html';
	} else if ( ! $this->html ) {
            $this->content_type = 'text/plain';
	}
        
	return $this->content_type;
    }
    
    public function text_to_html( $message ) {

	if ( 'text/html' == $this->content_type || true === $this->html ) {
            $message = wpautop( $message );
	}

	return $message;
    }
    
    
    public function template() {
        return KSM_VIEWS_PATH . '__Email' . DIRECTORY_SEPARATOR . $this->name . '.php';
    }
    
    public function layout() {
        return KSM_VIEWS_PATH . '__Email' . DIRECTORY_SEPARATOR . '__Layout' . DIRECTORY_SEPARATOR . $this->layout . '.php';
    }
    
    
    public function message() {
        
        $data = $this->get_data();
        ob_start();
        include $this->template();
        $message = ob_get_clean();
        
        foreach($data as $k => $v) {
            $tag = '{{' . $k . '}}';
            $message = str_replace($tag, $v, $message);
        }
        
        
        if ( false === $this->html ) {
            return wp_strip_all_tags( $message );
	}

        $message = $this->text_to_html( $message );
        
        
        ob_start();
        include $this->layout();
        $layout    = ob_get_clean();
        $message = str_replace( '{{body}}', $message, $layout );

        return $message;
    }
    
    
    public function global_data() {
        
        $data = array();
        $siteUrl = site_url();
        $siteTitle = get_bloginfo('name');
        
        $siteLink = '<a href="' . esc_url($siteUrl) . '" target="_blank">' . $siteTitle . '</a>';
        
        $data['site_url'] = $siteUrl;
        $data['site_title'] = $siteTitle;
        $data['site_home_link'] = $siteLink;
        
        if($this->User) {
            $data['user_email'] = $this->User->user_email;
            $data['user_login'] = $this->User->user_login;
            $data['display_name'] = $this->User->display_name();
            $data['user_full_name'] = $this->User->real_full_name();
        }
        return $data;
    }
    
    public function get_data() {
        $gdata = $this->global_data();
        $pdata = $this->prepare_data();
        
        $data = array_merge($gdata, $pdata);
        return $data;
    }
    
    
    public function send() {
        
        $message = $this->message();
        if(wp_mail($this->to_email(), $this->subject(), $message, $this->get_headers())) {
            return true;
        } 
        
        return false;
    }
}