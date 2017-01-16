<?php


function register_post_type_community() {
          
    $labels = array(
                'menu_name'           => _x('Community Posts', 'text_domain'),
                'name'                => _x( 'Community Post', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Community Post', 'Post Type Singular Name', 'text_domain' ),
                'add_new_item'        => __( 'Add New Community Post', 'text_domain' ),
		'add_new'             => __( 'New Community Post', 'text_domain' ),
                'not_found'           => __( 'No Community Post found', 'text_domain' ),
		'not_found_in_trash'  => __( 'No Community Post found in Trash', 'text_domain' ),
                'parent_item_colon'   => __( 'Parent Community Post:', 'text_domain' ),
		'all_items'           => __( 'Community Posts', 'text_domain' ),
		'view_item'           => __( 'View Community Post', 'text_domain' ),
                'edit_item'           => __( 'Edit Community Post', 'text_domain' ),
		'update_item'         => __( 'Update Community Post', 'text_domain' ),
		'search_items'        => __( 'Search Community Post', 'text_domain' )
    );

    $args = array(
               'labels' => $labels,
               'hierarchical' => true,
               'description' => 'Community Post',
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
    
    
            
    register_post_type('ksm_community_post', $args);
    
    
   
}


?>