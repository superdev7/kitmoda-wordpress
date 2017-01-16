<?php


$data = array(
    
    
    'fname' => array(
        'label' => 'First Name',
        'class' => 'inputi',
        'type' => 'text',
        'field_type' => 'Input_Text',
        'rules' => array(
            'required' => "First name is required.",
            'alpha_num_space' => "Please only use letters, numbers and spaces"
            ),
        'sanitize' => array('wp_kses_no_tag'),
        ),
    'lname' => array(
        'label' => 'Last Name',
        'class' => 'inputi',
        'type' => 'text',
        'field_type' => 'Input_Text',
        'rules' => array(
            'required' => "Last name is required.",
            'alpha_num_space' => "Please only use letters, numbers and spaces"
            ),
        'sanitize' => array('wp_kses_no_tag'),

        ),
    'display_name' => array(
        'label' => 'Display Name',
        'class' => 'inputi',
        'type' => 'text',
        'field_type' => 'Input_Text',
        'rules' => array(
            'required' => 'Display name is required.',
            'between_length_5-20' => 'Display name must be between {min}-{max} characters',
            'alpha_num_space' => "Please only use letters, numbers and spaces",
            'display_name_available' => "Display name is not available, Please pick another one."
            ),
        'sanitize' => array('trim', 'wp_kses_no_tag'),

        ),
    'email' => array(
        'label' => 'Email',
        'class' => 'inputi',
        'type' => 'text',
        'field_type' => 'Input_Email',
        'rules' => array(
            'required' => 'Email is required.',
            'email' => 'Email is not valid',
            'email_available' => "Email is already registered.",
            'email_domain_blacklist' => 'Please use a dedicated personal email address.'
            ),
        'sanitize' => array('wp_kses_no_tag'),

        ),
    'password' => array(
        'label' => 'Password',
        'class' => 'inputi',
        'type' => 'text',
        'field_type' => 'Input_Password',
        'rules' => array(
            'required' => 'Password is required.',
            'min_length_5' => 'Password must be at least {min} characters long.'
            ),
        'sanitize' => array('wp_kses_no_tag'),
        ),
    
    'recaptcha_response' => array(
        //'label' => 'Password',
        //'class' => 'inputi',
        //'type' => 'text',
        'field_type' => 'Input_Password',
        'rules' => array(
            'google_recaptcha' => 'Invalid captcha.'
            ),
        'sanitize' => array('wp_kses_no_tag'),
        )
    
    
    
    
        
    );

?>


