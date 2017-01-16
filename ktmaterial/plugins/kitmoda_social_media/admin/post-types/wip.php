<?php


function register_post_type_wip() {
    
    
    $labels = array(
                'menu_name'           => _x('WIP Posts', 'ksm_wip_post'),
                'name'                => _x( 'WIP Post', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'WIP Post', 'Post Type Singular Name', 'text_domain' ),
                'add_new_item'        => __( 'Add New WIP Post', 'text_domain' ),
		'add_new'             => __( 'New WIP Post', 'text_domain' ),
                'not_found'           => __( 'No WIP Post found', 'text_domain' ),
		'not_found_in_trash'  => __( 'No WIP Post found in Trash', 'text_domain' ),
                'parent_item_colon'   => __( 'Parent WIP Post:', 'text_domain' ),
		'all_items'           => __( 'WIP Posts', 'text_domain' ),
		'view_item'           => __( 'View WIP Post', 'text_domain' ),
                'edit_item'           => __( 'Edit WIP Post', 'text_domain' ),
		'update_item'         => __( 'Update WIP Post', 'text_domain' ),
		'search_items'        => __( 'Search WIP Post', 'text_domain' )
    );

    $args = array(
               'labels' => $labels,
               'hierarchical' => true,
               'description' => 'WIP Post',
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
    
    
            
    register_post_type('ksm_wip', $args);
   
}


?>