<?php


$data = array(
    'title' => array(
        'type' => 'text',
        'rules' => array('required'),
        'sanitize' => array('trim', 'sanitize_text_field')
        ),
    'description' => array(
        'type' => 'text',
        'rules' => array('required'),
        'sanitize' => array('wp_kses_no_tag')
        ),
    'keywords' => array(
        'type' => 'list',
        'rules' => array('max_10_items' => "Maximum 10 keywords allowed"),
        'sanitize' => array('wp_kses_no_tag'),
        'save_as' => array('post_terms'),
        'tax' => 'keyword'
        ),
    'category' => array(
        'type' => 'no_child_term_id',
        'rules' => array('required'),
        'sanitize' => array('last_array_element'),
        'save_as' => array('post_term')
        ),
    
    'concept_created' => array(
        'type' => 'string',
        'rules' => array('in_array' => "Did you create custom concept art"),
        'rules_data' => array('in_array' => array('yes', 'no')),
        'save_as' => array('post_meta')
        ),
    'style' => array(
        'type' => 'term_id',
        'rules' => array('required'), 
        'save_as' => array('post_term')
        ),
    'era' => array(
        'type' => 'term_id',
        'rules' => array('required'), 
        'save_as' => array('post_term')
        ),
    'culture' => array(
        'type' => 'term_id',
        'rules' => array('required'), 
        'save_as' => array('post_term')
        ),
    
    'allow_invites' => array(
        'type' => 'string',
        'rules' => array('in_array' => 'Do you want to allow collaboration invites'),
        'rules_data' => array('in_array' => array('yes', 'no')),
        ),
    
    'price_share' => array(
        'type' => 'price',
        'rules' => array('required', 'price')
        ),
    'untextured_price' => array(
        'type' => 'price',
        'rules' => array('required', 'price')
        ),
    'terms_agreed' => array(
        'type' => 'string',
        'rules' => array('required' => "You must agree to the terms")
        )
    );

?>