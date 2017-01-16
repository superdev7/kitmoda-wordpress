<?php


function register_post_type_collaboration_join_request() {
  
    $labels = array(
                'menu_name'           => _x('Collaboration Join Request', 'text_domain'),
                'name'                => _x( 'Collaboration Join Request', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Collaboration Join Request', 'Post Type Singular Name', 'text_domain' ),
                'add_new_item'        => __( 'Add New Collaboration Join Request', 'text_domain' ),
		'add_new'             => __( 'New Collaboration Join Request', 'text_domain' ),
                'not_found'           => __( 'No Collaboration Join Request found', 'text_domain' ),
		'not_found_in_trash'  => __( 'No Collaboration Join Request found in Trash', 'text_domain' ),
                'parent_item_colon'   => __( 'Parent Collaboration Join Request:', 'text_domain' ),
		'all_items'           => __( 'Collaboration Join Requests', 'text_domain' ),
		'view_item'           => __( 'View Collaboration Join Request', 'text_domain' ),
                'edit_item'           => __( 'Edit Collaboration Join Request', 'text_domain' ),
		'update_item'         => __( 'Update Collaboration Join Request', 'text_domain' ),
		'search_items'        => __( 'Search Collaboration Join Request', 'text_domain' )
    );

    $args = array(
               'labels' => $labels,
               'hierarchical' => true,
               'description' => 'Collaboration Join Request',
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
    
    
            
    register_post_type('collab_join_request', $args);
   
}


?>