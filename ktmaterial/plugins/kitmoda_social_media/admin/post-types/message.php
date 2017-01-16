<?php


function register_post_type_message() {
          
    $labels = array(
                'menu_name'           => _x('Messages', 'ksm_message'),
                'name'                => _x( 'Message', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Message', 'Post Type Singular Name', 'text_domain' ),
                'add_new_item'        => __( 'Add New Message', 'text_domain' ),
		'add_new'             => __( 'New Message', 'text_domain' ),
                'not_found'           => __( 'No Message found', 'text_domain' ),
		'not_found_in_trash'  => __( 'No Message found in Trash', 'text_domain' ),
                'parent_item_colon'   => __( 'Parent Message:', 'text_domain' ),
		'all_items'           => __( 'Messages', 'text_domain' ),
		'view_item'           => __( 'View Message', 'text_domain' ),
                'edit_item'           => __( 'Edit Message', 'text_domain' ),
		'update_item'         => __( 'Update Message', 'text_domain' ),
		'search_items'        => __( 'Search Message', 'text_domain' )
    );

    $args = array(
               'labels' => $labels,
               'hierarchical' => true,
               'description' => 'Message',
               'supports' => array('title','editor'),
               'public' => true,
               'show_ui' => true,
               'show_in_menu' => 'fes-about',
               'show_in_nav_menus' => true,
               'publicly_queryable' => true,
               'exclude_from_search' => false,
               'has_archive' => true,
               'query_var' => true,
               'can_export' => true,
               'rewrite' => true,
               'capability_type' => 'post'
        
    );
    
    
            
    register_post_type('ksm_message', $args);
    

   
   
}


?>