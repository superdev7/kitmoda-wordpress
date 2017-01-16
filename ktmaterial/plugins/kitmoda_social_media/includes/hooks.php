<?php

add_action( 'template_redirect', 'ksm_template_redirect' );
//add_filter( 'query_vars', 'ksm_query_vars' );

add_action('ksm_user_attach_attachment', 'ksm_user_attach_attachment');
add_action('ksm_user_upload_attachment', 'ksm_user_upload_attachment', 10, 2);



add_action('wp_insert_post', 'ksm_insert_post', 10, 3);



foreach(KSM_DataStore::Option('AjaxAction', 'private') as $action) 
    add_action("wp_ajax_{$action}", array('KSM_Ajax', $action));


foreach(KSM_DataStore::Option('AjaxAction', 'public') as $action) 
    add_action("wp_ajax_nopriv_{$action}", array('KSM_Ajax', "public_{$action}"));

    

add_filter('page_link', 'ksm_page_link', 1, 3);


//add_shortcode('ksm_profile_following', array(KSM_Shortcode, 'following'));
//add_shortcode('ksm_profile_top_selling', array(KSM_Shortcode, 'top_selling'));
//add_shortcode('ksm_profile_favorites', array(KSM_Shortcode, 'favorites'));
//add_shortcode('ksm_compose_message', array(KSM_Shortcode, 'compose'));
//add_shortcode('ksm_profile_settings', array(KSM_Shortcode, 'profile_settings'));
//add_shortcode('ksm_profile_add_wip', array(KSM_Shortcode, 'add_wip'));
//add_shortcode('ksm_share_page', array(KSM_Shortcode, 'share'));

//add_shortcode('ksm_profile_publisher', array(KSM_Shortcode, 'publisher'));
//add_shortcode('ksm_post_options', array(KSM_Shortcode, 'post_options'));



add_action('user_register', array('KSM_Award', 'blackCurtainBeta'));
add_action('user_register', array('KSM_Award', 'earlyAdopter'));

