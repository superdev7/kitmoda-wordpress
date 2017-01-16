<?php

$data = array(
    
    'ksm_collaboration' => array(
        'labels' => array(
            'menu_name'           => 'Collaborations',
            'name'                => 'Collaborations',
            'singular_name'       => 'Collaboration',
            'add_new_item'        => 'Add New Collaborations',
            'add_new'             => 'New Collaboration',
            'not_found'           => 'No Collaborations found',
            'not_found_in_trash'  => 'No Collaborations found in Trash',
            'parent_item_colon'   => 'Parent Collaboration:',
            'all_items'           => 'Collaborations',
            'view_item'           => 'View Collaboration',
            'edit_item'           => 'Edit Collaboration',
            'update_item'         => 'Update Collaboration',
            'search_items'        => 'Search Collaboration'
            ),
        'hierarchical' => true,
        'description' => 'Collaborations',
        'supports' => array('title','editor'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => 'ksm',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
        ),
    
    
    
    'ksm_p_download' => array(
        'labels' => array(
            'menu_name'           => 'Purchased Download',
            'name'                => 'Purchased Downloads',
            'singular_name'       => 'Purchased Download',
            'add_new_item'        => 'Add New Purchased Download',
            'add_new'             => 'New Purchased Download',
            'not_found'           => 'No Purchased Download found',
            'not_found_in_trash'  => 'No Purchased Download found in Trash',
            'parent_item_colon'   => 'Payment:',
            'all_items'           => 'Purchased Downloads',
            'view_item'           => 'View Purchased Download',
            'edit_item'           => 'Edit Purchased Download',
            'update_item'         => 'Update Purchased Download',
            'search_items'        => 'Search Purchased Download'
            ),
        'hierarchical' => true,
        'description' => 'Purchased Downloads',
        'supports' => array('title','editor'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => 'ksm',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
        ),
    
    
    /*
    'ksm_download_rate' => array(
        'labels' => array(
            'menu_name'           => 'Download Rate',
            'name'                => 'Download Rates',
            'singular_name'       => 'Download Rate',
            'add_new_item'        => 'Add New Download Rate',
            'add_new'             => 'New Download Rate',
            'not_found'           => 'No Download Rate found',
            'not_found_in_trash'  => 'No Download Rate found in Trash',
            'parent_item_colon'   => 'Download:',
            'all_items'           => 'Download Rates',
            'view_item'           => 'View Download Rate',
            'edit_item'           => 'Edit Download Rate',
            'update_item'         => 'Update Download Rate',
            'search_items'        => 'Search Download Rate'
            ),
        'hierarchical' => true,
        'description' => 'Download Rates',
        'supports' => array('title','editor'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => 'ksm',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
        ),
    */
    
    
    'ksm_p_download_rate' => array(
        'labels' => array(
            'menu_name'           => 'Purchased Download Rate',
            'name'                => 'Purchased Download Rates',
            'singular_name'       => 'Purchased Download Rate',
            'add_new_item'        => 'Add New Purchased Download Rate',
            'add_new'             => 'New Purchased Download Rate',
            'not_found'           => 'No Purchased Download Rate found',
            'not_found_in_trash'  => 'No Purchased Download Rate found in Trash',
            'parent_item_colon'   => 'Purchased Download:',
            'all_items'           => 'Purchased Download Rates',
            'view_item'           => 'View Purchased Download Rate',
            'edit_item'           => 'Edit Purchased Download Rate',
            'update_item'         => 'Update Purchased Download Rate',
            'search_items'        => 'Search Purchased Download Rate'
            ),
        'hierarchical' => true,
        'description' => 'Download Rates',
        'supports' => array('title','editor'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => 'ksm',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
        ),
    
    
    'collab_join_request' => array(
        'labels' => array(
            'menu_name'            => 'Collaboration Join Request',
            'name'                => 'Collaboration Join Requests',
            'singular_name'       => 'Collaboration Join Request',
            'add_new_item'        => 'Add New Collaboration Join Request',
            'add_new'             => 'New Collaboration Join Request',
            'not_found'           => 'No Collaboration Join Request found',
            'not_found_in_trash'  => 'No Collaboration Join Request found in Trash',
            'parent_item_colon'   => '',
            'all_items'           => 'Collaboration Join Requests',
            'view_item'           => 'View Collaboration Join Request',
            'edit_item'           => 'Edit Collaboration Join Request',
            'update_item'         => 'Update Collaboration Join Request',
            'search_items'        => 'Search Collaboration Join Request'
        ),
        'hierarchical' => true,
        'description' => 'Collaboration Join Request',
        'supports' => array('title','editor'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => 'ksm',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    ) ,
    
    
    
    
    'collab_active' => array(
        'labels' => array(
            'menu_name'           => 'Active Collaboration',
            'name'                => 'Active Collaboration',
            'singular_name'       => 'Active Collaboration',
            'add_new_item'        => 'Add New Active Collaboration',
            'add_new'             => 'New Active Collaboration',
            'not_found'           => 'No Active Collaboration found',
            'not_found_in_trash'  => 'No Active Collaboration found in Trash',
            'parent_item_colon'   => '',
            'all_items'           => 'Active Collaboration',
            'view_item'           => 'View Active Collaboration',
            'edit_item'           => 'Edit Active Collaboration',
            'update_item'         => 'Update Active Collaboration',
            'search_items'        => 'Search Active Collaboration'
        ),
        'hierarchical' => true,
        'description' => 'Collaboration Active',
        'supports' => array('title','editor'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => 'ksm',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    ) ,
    
    
    
    
    'collab_active_step' => array(
        'labels' => array(
            'menu_name'           => 'Active Collaboration Step',
            'name'                => 'Active Collaboration Step',
            'singular_name'       => 'Active Collaboration Step',
            'add_new_item'        => 'Add New Active Collaboration Step',
            'add_new'             => 'New Active Collaboration Step',
            'not_found'           => 'No Active Collaboration Step found',
            'not_found_in_trash'  => 'No Active Collaboration Step found in Trash',
            'parent_item_colon'   => '',
            'all_items'           => 'Active Collaboration Step',
            'view_item'           => 'View Active Collaboration Step',
            'edit_item'           => 'Edit Active Collaboration Step',
            'update_item'         => 'Update Active Collaboration Step',
            'search_items'        => 'Search Active Collaboration Step'
        ),
        'hierarchical' => true,
        'description' => 'Collaboration Active Step',
        'supports' => array('title','editor'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => 'ksm',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    ) ,
    
    
    
    
    'ksm_post' => array(
        'labels' => array(
            'menu_name'           => 'Posts',
            'name'                => 'Post',
            'singular_name'       => 'Post',
            'add_new_item'        => 'Add New Post',
            'add_new'             => 'New Post',
            'not_found'           => 'No Post found',
            'not_found_in_trash'  => 'No Post found in Trash',
            'parent_item_colon'   => 'Parent Post:',
            'all_items'           => 'Posts',
            'view_item'           => 'View Post',
            'edit_item'           => 'Edit Post',
            'update_item'         => 'Update Post',
            'search_items'        => 'Search Post'
            ),
        'hierarchical' => true,
        'description' => 'Post',
        'supports' => array('title','editor'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => 'ksm',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    ) , 
    
    
    
    /*
    
    'ksm_wall_post' => array(
        'labels' => array(
            'menu_name'           => 'Wall Posts',
            'name'                => 'Wall Post',
            'singular_name'       => 'Wall Post',
            'add_new_item'        => 'Add New Wall Post',
            'add_new'             => 'New Wall Post',
            'not_found'           => 'No Wall Post found',
            'not_found_in_trash'  => 'No Wall Post found in Trash',
            'parent_item_colon'   => 'Parent Wall Post:',
            'all_items'           => 'Wall Posts',
            'view_item'           => 'View Wall Post',
            'edit_item'           => 'Edit Wall Post',
            'update_item'         => 'Update Wall Post',
            'search_items'        => 'Search Wall Post'
            ),
        'hierarchical' => true,
        'description' => 'Wall Post',
        'supports' => array('title','editor'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => 'ksm',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    ),
    
    
    

    'ksm_community_post' => array(
        'labels' => array(
            'menu_name'           => 'Community Posts',
            'name'                => 'Community Post',
            'singular_name'       => 'Community Post',
            'add_new_item'        => 'Add New Community Post',
            'add_new'             => 'New Community Post',
            'not_found'           => 'No Community Post found',
            'not_found_in_trash'  => 'No Community Post found in Trash',
            'parent_item_colon'   => 'Parent Community Post:',
            'all_items'           => 'Community Posts',
            'view_item'           => 'View Community Post',
            'edit_item'           => 'Edit Community Post',
            'update_item'         => 'Update Community Post',
            'search_items'        => 'Search Community Post'
            ),
        'hierarchical' => true,
        'description' => 'Community Post',
        'supports' => array('title','editor'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => 'ksm',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    ) , 
    
    */
    
    'ksm_message' => array(
        'labels' => array(
            'menu_name'           => 'Messages',
            'name'                => 'Message',
            'singular_name'       => 'Message',
            'add_new_item'        => 'Add New Message',
            'add_new'             => 'New Message',
            'not_found'           => 'No Message found',
            'not_found_in_trash'  => 'No Message found in Trash',
            'parent_item_colon'   => 'Parent Message:',
            'all_items'           => 'Messages',
            'view_item'           => 'View Message',
            'edit_item'           => 'Edit Message',
            'update_item'         => 'Update Message',
            'search_items'        => 'Search Message'
            ),
        'hierarchical' => true,
        'description' => 'Message',
        'supports' => array('title','editor'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => 'ksm',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
        
    ) ,
    

    
    'ksm_kitmoda_update' => array(
        'labels' => array(
            'menu_name'           => _x('Updates', 'text_domain'),
            'name'                => _x( 'Kitmoda Updates', 'Post Type General Name', 'text_domain' ),
            'singular_name'       => _x( 'Update', 'Post Type Singular Name', 'text_domain' ),
            'add_new_item'        => __( 'Add New Update', 'text_domain' ),
            'add_new'             => __( 'New Update', 'text_domain' ),
            'not_found'           => __( 'No Update Post found', 'text_domain' ),
            'not_found_in_trash'  => __( 'No Update Post found in Trash', 'text_domain' ),
            'parent_item_colon'   => __( 'Parent Update Post:', 'text_domain' ),
            'all_items'           => __( 'Kitmoda Updates', 'text_domain' ),
            'view_item'           => __( 'View Update Post', 'text_domain' ),
            'edit_item'           => __( 'Edit Update Post', 'text_domain' ),
            'update_item'         => __( 'Update Update Post', 'text_domain' ),
            'search_items'        => __( 'Search Update Post', 'text_domain' )
            ),
        'hierarchical' => true,
        'description' => 'Kitmoda Updates',
        'supports' => array('title','editor'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => 'ksm',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
        
    )

    
    
);