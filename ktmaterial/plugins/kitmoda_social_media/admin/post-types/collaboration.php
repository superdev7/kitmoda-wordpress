<?php


function register_post_type_collaboration() {
    
    $labels = array(
                'menu_name'           => _x('Collaborations', 'text_domain'),
                'name'                => _x( 'Collaboration', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Collaboration', 'Post Type Singular Name', 'text_domain' ),
                'add_new_item'        => __( 'Add New Collaborations', 'text_domain' ),
		'add_new'             => __( 'New Collaborations', 'text_domain' ),
                'not_found'           => __( 'No Collaborations found', 'text_domain' ),
		'not_found_in_trash'  => __( 'No Collaborations found in Trash', 'text_domain' ),
                'parent_item_colon'   => __( 'Parent Collaboration:', 'text_domain' ),
		'all_items'           => __( 'Collaborations', 'text_domain' ),
		'view_item'           => __( 'View Collaboration', 'text_domain' ),
                'edit_item'           => __( 'Edit Collaboration', 'text_domain' ),
		'update_item'         => __( 'Update Collaboration', 'text_domain' ),
		'search_items'        => __( 'Search Collaboration', 'text_domain' )
    );

    $args = array(
               'labels' => $labels,
               'hierarchical' => true,
               'description' => 'Collaboration',
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
    
    
            
    register_post_type('ksm_collaboration', $args);
   
}


?>