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
    'price_share' => array(
        'type' => 'price',
        'rules' => array('required', 'price')
        ),
    
    'terms_agreed' => array(
        'type' => 'string',
        'rules' => array('required' => "You must agree to the terms")
        )
    );

?>