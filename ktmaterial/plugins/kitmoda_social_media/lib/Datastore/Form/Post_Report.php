<?php


$data = array(
    
    'reasons' => array(
        'type' => 'list',
        'rules' => array('max_10_items' => "Maximum 10 keywords allowed"),
        'sanitize' => array('wp_kses_no_tag'),
        'save_as' => array('post_terms'),
        'tax' => 'keyword'
        )
    );

?>