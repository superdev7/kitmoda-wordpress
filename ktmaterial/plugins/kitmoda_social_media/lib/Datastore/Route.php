<?php


$data = array(
    
    
    'rest' => array(
        
        'posts' => array(
            array('community/posts',
                array(
                    array('type' => 'community_query', 'methods' => WP_REST_Server::CREATABLE)
                )
            ),
            
            array('posts/report/(?P<id>[\d]+)',
                array(
                    array('type' => 'report', 'methods' => WP_REST_Server::CREATABLE)
                )
            )
            
            
        ),
        
        
        
        
        
        
        
        'comments' => array(
            array('comments/delete/(?P<id>[\d]+)',
                array(
                    array('type' => 'delete', 'methods' => WP_REST_Server::CREATABLE)
                )
            ),
            array('comments/update/(?P<id>[\d]+)',
                array(
                    array('type' => 'update', 'methods' => WP_REST_Server::CREATABLE)
                )
            ),
            array('comments/add',
                array(
                    array('type' => 'add', 'methods' => WP_REST_Server::CREATABLE)
                )
            )
        ),
        
        'common' => array(
            
            array('like',
                array(
                    array('type' => 'like', 'methods' => WP_REST_Server::CREATABLE)
                )
            )
        ),
        
        
        'user' => array(
            
            array('user/register',
                array(
                    array('type' => 'register', 'methods' => WP_REST_Server::CREATABLE)
                )
            ) ,
            
            array('user/login',
                array(
                    array('type' => 'login', 'methods' => WP_REST_Server::CREATABLE)
                )
            ),
            
            array('user/recover',
                array(
                    array('type' => 'recover', 'methods' => WP_REST_Server::CREATABLE)
                )
            )
        )
        
        
        
        
    ),
    
    
    
    
    'front' => array(
        array('profile/{:controller}'),
        array('profile/{:controller}/{:action}'),
        
        // Share
        array('share/{:id}', array('controller' => 'share', 'action' => 'share')),
        array('sl/{:id}', array('controller' => 'share', 'action'=>'short_link')),
        
        
        // Pages
        
        array('about', array('controller' => 'page', 'action' => 'about')),
        array('company', array('controller' => 'page', 'action' => 'company')),
        array('support', array('controller' => 'page', 'action' => 'support')),
        array('careers', array('controller' => 'page', 'action' => 'careers')),
        array('press', array('controller' => 'page', 'action' => 'press')),
        array('join', array('controller' => 'page', 'action' => 'join')),
        array('bestpractices', array('controller' => 'page', 'action' => 'bestpractices')),
        array('payments', array('controller' => 'page', 'action' => 'payments')),
        array('support', array('controller' => 'page', 'action' => 'support')),
        array('faqs', array('controller' => 'page', 'action' => 'faqs')),
        array('privacy', array('controller' => 'page', 'action' => 'privacy')),
        array('terms', array('controller' => 'page', 'action' => 'terms')),
        array('returns', array('controller' => 'page', 'action' => 'returns')),
        
        
        
        // Store
        array('store', array('controller' => 'store')),
        array('store/{:action}', array('controller' => 'store')),
        array('store/{:action}/{:id}', array('controller' => 'store')),
        
        //Studio
        array('studio', array('controller' => 'studio')),
        array('studio/{:username}', array('controller' => 'studio')),
        array('studio/{:username}/page/{:paged}', array('controller' => 'studio')),
        array('studio/page/{:paged}', array('controller' => 'studio')),
        array('studio/post_options/{:id}', array('controller' => 'studio', 'action' => 'post_options')),
        array('studio/edit_post/{:id}', array('controller' => 'studio', 'action' => 'post_options', 'action_type'=>'edit')),
        array('studio/delete_post/{:id}', array('controller' => 'studio', 'action' => 'delete_post')),
        
        
        array('studio/top_selling', array('controller' => 'studio', 'action' => 'top_selling')),
        array('studio/top_selling/{:username}', array('controller' => 'studio', 'action' => 'top_selling')),
        array('studio/top_selling/{:username}/{:paged}', array('controller' => 'studio', 'action' => 'top_selling')),
        
        
        array('studio/following', array('controller' => 'studio', 'action' => 'following')),
        array('studio/following/page/{:paged}', array('controller' => 'studio', 'action' => 'following')),
        array('studio/following/{:username}', array('controller' => 'studio', 'action' => 'following')),
        array('studio/following/{:username}/page/{:paged}', array('controller' => 'studio', 'action' => 'following')),
        
        
        
        array('studio/favorites', array('controller' => 'studio', 'action' => 'favorites')),
        array('studio/favorites/page/{:paged}', array('controller' => 'studio', 'action' => 'favorites')),
        array('studio/favorites/{:username}', array('controller' => 'studio', 'action' => 'favorites')),
        array('studio/favorites/{:username}/page/{:paged}', array('controller' => 'studio', 'action' => 'favorites')),
        
        
        
        array('studio/add_gallery_image', array('controller' => 'Studio', 'action' => 'add_gallery_image')),
        
        
        
        
        array('account', array('controller' => 'message', 'main_tab'=>'account')),
        array('account/messages', array('controller' => 'message', 'action' => 'index', 'main_tab'=>'account')),
        array('account/purchase_library', array('controller' => 'account', 'action' => 'purchase_library')),
        array('account/sales', array('controller' => 'account', 'action' => 'sales')),
        array('account/products', array('controller' => 'account', 'action' => 'products')),
        
        array('account/purchases/download/{:id}', array('controller' => 'account', 'action' => 'download')),
        
        array('account/pending_purchase/{:id}', array('controller' => 'account', 'action' => 'pending_purchase')),
        
        array('account/rate/{:id}', array('controller' => 'account', 'action' => 'rate_model')),
        
        array('account/return/{:id}', array('controller' => 'account', 'action' => 'return_model')),
        
        
        // Collaboration
        array('collaboration', array('controller' => 'collaboration')),
        array('collaboration/full_view/{:id}', array('controller' => 'collaboration', 'action' => 'full_view')),
        array('collaboration/requests', array('controller' => 'CollaborationRequest', 'action' => 'index', 'main_tab'=>'collaboration')),
        array('collaboration/request/join/{:id}', array('controller' => 'CollaborationRequest', 'action' => 'join')),
        array('collaboration/request/reject/{:id}', array('controller' => 'CollaborationRequest', 'action' => 'reject')),
        array('collaboration/request/accept/{:id}', array('controller' => 'CollaborationRequest', 'action' => 'accept')),
        array('collaboration/concept', array('controller' => 'collaboration', 'action' => 'index', 'collaboration_type' => 'concept')),
        array('collaboration/join', array('controller' => 'collaboration', 'action' => 'index', 'collaboration_type' => 'concept')),
        array('collaboration/untextured', array('controller' => 'collaboration', 'action' => 'index', 'collaboration_type' => 'untextured')),
        
        
        array('collaboration/partner_projects', array('controller' => 'CollaborationActive', 'action' => 'partner_projects', 'main_tab'=>'collaboration')),
        array('collaboration/partner_projects/{:id}', array('controller' => 'CollaborationActive', 'action' => 'partner_projects')),
        
        
        array('collaboration/active', array('controller' => 'CollaborationActive', 'action' => 'index', 'main_tab'=>'collaboration')),
        
        
        array('collaboration/launch', array('controller' => 'Collaboration', 'action' => 'concept_images')),
        array('collaboration/launch/concepts', array('controller' => 'Collaboration', 'action' => 'concept_images')),
        array('collaboration/launch/models', array('controller' => 'Collaboration', 'action' => 'model_images')),
        
        
        
        
        
        
        // Message
        array('message/compose', array('controller' => 'message', 'action' => 'compose')),
        array('message/compose/{:to_user}', array('controller' => 'message', 'action' => 'compose')),
        array('message/dl_images/{:id}', array('controller' => 'message', 'action' => 'dl_images')),
        
        
        // Community
        
        array('/', array('controller' => 'community')),
        
        array('community', array('controller' => 'community')),
        array('community/post_options/{:id}', array('controller' => 'community', 'action' => 'post_options')),
        
        array('community/edit_post/{:id}', array('controller' => 'community', 'action' => 'post_options', 'action_type'=>'edit')),
        array('community/delete_post/{:id}', array('controller' => 'community', 'action' => 'delete_post')),
       
        // User
        
        array('forgot_password', array('controller' => 'user', 'action' => 'forgot_password')),
        array('login', array('controller' => 'user', 'action' => 'login')),
        
        array('login/{:ar_action}', array('controller' => 'user', 'action' => 'login')),
        array('join', array('controller' => 'user', 'action' => 'join')),
        array('join/{:ar_action}', array('controller' => 'user', 'action' => 'join')),
        array('edit_profile', array('controller' => 'user', 'action' => 'edit_profile')),
        array('account_settings', array('controller' => 'user', 'action' => 'account_settings')),
        
        array('signout', array('controller' => 'user', 'action' => 'signout')),
        
        
        array('reset_password', array('controller' => 'user', 'action' => 'reset_password')),
        
        
        
        // Publisher
        array('publisher', array('controller' => 'publisher')),
        
        
        //
        
        
        
        
        
        //Collaboration Model WIP Publisher
        array('collaboration/active/mmw/{:id}', array('controller' => 'Publisher', 'action' => 'publisher', 'pub_name' => 'collaboration_model_mid_wip')),
        array('collaboration/active/mfw/{:id}', array('controller' => 'Publisher', 'action' => 'publisher', 'pub_name' => 'collaboration_model_final_wip')),
        
        //Collaboration Texture WIP Publisher
        array('collaboration/active/tmw/{:id}', array('controller' => 'Publisher', 'action' => 'publisher',  'pub_name' => 'collaboration_texture_mid_wip')),
        array('collaboration/active/tfw/{:id}', array('controller' => 'Publisher', 'action' => 'publisher', 'pub_name' => 'collaboration_texture_final_wip')),
        
        
        
        
        
        //Collaboration Model WIP Info
        
        array('collaboration/active/mi/{:id}', array('controller' => 'CollaborationActive', 'action' => 'step_info', 'info' => 'model')),
        array('collaboration/active/mmi/{:id}', array('controller' => 'CollaborationActive', 'action' => 'step_info', 'info' => 'model_mid_wip')),
        array('collaboration/active/mfi/{:id}', array('controller' => 'CollaborationActive', 'action' => 'step_info', 'info' => 'model_final_wip')),
        
        //Collaboration Texture WIP Info
        array('collaboration/active/ti/{:id}', array('controller' => 'CollaborationActive', 'action' => 'step_info', 'info' => 'texture')),
        array('collaboration/active/tmi/{:id}', array('controller' => 'CollaborationActive', 'action' => 'step_info', 'info' => 'texture_mid_wip')),
        array('collaboration/active/tfi/{:id}', array('controller' => 'CollaborationActive', 'action' => 'step_info', 'info' => 'texture_final_wip')),
        
        
        
        
        
        array('collaboration/active/cpum/{:id}',  array('controller'  => 'Publisher', 'action' => 'publisher', 'pub_name' => 'collaboration_publish_untextured')),
        array('collaboration/active/cptm/{:id}',  array('controller'  => 'Publisher', 'action' => 'publisher', 'pub_name' => 'collaboration_publish_textured')),
        //array('collaboration/active/cpmtm/{:id}', array('controller'  => 'Publisher', 'action' => 'publisher', 'pub_name' => 'collaboration_publish_model_textured')),
        
        
        
        
        
        array('collaboration/active/mfiles/{:id}',  array('controller'  => 'CollaborationActive', 'action' => 'concept_files' )),
        array('collaboration/active/tfiles/{:id}',  array('controller'  => 'CollaborationActive', 'action' => 'untextured_files' )),
        
        
        
        array('collaboration/active/rate/{:id}',  array('controller'  => 'CollaborationActive', 'action' => 'rate')),
        
        
        
        
        array('collaboration/active/mmn/{:id}',  array('controller'  => 'CollaborationActive', 'action' => 'step_notes', 'step' => 'model_mid_wip' )),
        array('collaboration/active/mfn/{:id}',  array('controller'  => 'CollaborationActive', 'action' => 'step_notes', 'step' => 'model_final_wip' )),
        array('collaboration/active/tmn/{:id}',  array('controller'  => 'CollaborationActive', 'action' => 'step_notes', 'step' => 'texture_mid_wip' )),
        array('collaboration/active/tfn/{:id}',  array('controller'  => 'CollaborationActive', 'action' => 'step_notes', 'step' => 'texture_final_wip' )),
        
        
        
        
        
        array('collaboration/active/dl_concept_files/{:id}',  array('controller'  => 'CollaborationActive', 'action' => 'download_concept_files' )),
        array('collaboration/active/dl_untextured_file/{:id}',  array('controller'  => 'CollaborationActive', 'action' => 'download_untextured_files' )),
        
        
        
        
        
        array('collaboration/launch/concept', array('controller' => 'Publisher', 'action' => 'publisher', 'pub_name' => 'collaboration_concept')),
        array('collaboration/launch/concept/{:id}', array('controller' => 'Publisher', 'action' => 'publisher', 'pub_name' => 'collaboration_concept_image')),
        
        
        
        array('collaboration/launch/untextured', array('controller' => 'Publisher', 'action' => 'publisher', 'pub_name' => 'collaboration_untextured')),
        
        array('collaboration/launch/untextured/{:id}', array('controller' => 'Publisher', 'action' => 'publisher', 'pub_name' => 'collaboration_untextured_image')),
        
        
        
        
        
        
        
        // TexturedPublisher
        //array('', array('controller' => 'TexturedPublisher')),
        
        array('publisher/textured', array('controller' => 'Publisher', 'action' => 'publisher', 'pub_name' => 'textured_model')),
        
        
        // UntexturedPublisher
        
        array('publisher/untextured', array('controller' => 'Publisher', 'action' => 'publisher', 'pub_name' => 'untextured_model')),
        
        
        
        // ConceptPublisher
        // 
        array('publisher/concept', array('controller' => 'Publisher', 'action' => 'publisher', 'pub_name' => 'collaboration_concept')),
        //array('publisher/concept', array('controller' => 'ConceptPublisher')),
        
        
        
        
        
        
        
        
        array('cart', array('controller' => 'cart')),
        array('checkout', array('controller' => 'cart', 'action' => 'checkout')),
        array('checkout/purchase-confirmation', array('controller' => 'cart', 'action' => 'purchase_confirmation'))
        
        
        
    ) ,
    
    
    'ajax' => array(
        array('controller' => 'User', 'action' => 'submit_join',  'no_private'=> true),
        array('controller' => 'User', 'action' => 'submit_login', 'no_private'=> true),
        array('controller' => 'User', 'action' => 'submit_forgot_password', 'no_private'=> true),
        array('controller' => 'User', 'action' => 'submit_reset_password', 'no_private'=> true),
        
        
        
        // Store
        array('controller' => 'Store', 'action' => 'getNewest', 'no_private'=> true),
        array('controller' => 'Store', 'action' => 'getTopRated', 'no_private'=> true),
        array('controller' => 'Store', 'action' => 'getTopSelling', 'no_private'=> true),
        array('controller' => 'Store', 'action' => 'getTrending', 'no_private'=> true),
        array('controller' => 'Store', 'action' => 'filter_posts', 'no_private'=> true),
        
        // Studio
        
        array('controller' => 'Studio', 'action' => 'filter_posts', 'no_private'=> true),
        array('controller' => 'Studio', 'action' => 'filter_favorites', 'no_private'=> true),
        
        array('controller' => 'Studio', 'action' => 'filter_top_sellings', 'no_private'=> true),
        
        array('controller' => 'Studio', 'action' => 'favorites_slider', 'no_private'=> true),
        array('controller' => 'Studio', 'action' => 'submit_post'),
        array('controller' => 'Studio', 'action' => 'submit_post_options'),
        array('controller' => 'Studio', 'action' => 'submit_edit_post'),
        
        array('controller' => 'Studio', 'action' => 'submit_delete_post'),
        
        
        
        
        array('controller' => 'Studio', 'action' => 'submit_comment'),
        array('controller' => 'Studio', 'action' => 'submit_add_gallery_image'),
        
        
        array('controller' => 'Studio', 'action' => 'kmvg', 'no_private'=> true),
        
        
        
        array('controller' => 'Account', 'action' => 'filter_purchases'),
        array('controller' => 'Account', 'action' => 'filter_sales'),
        array('controller' => 'Account', 'action' => 'filter_products'),
        
        
        
        array('controller' => 'Account', 'action' => 'submit_model_rate'),
        
        array('controller' => 'Account', 'action' => 'submit_return_model'),
        
        
        // Collaboration
        array('controller' => 'CollaborationRequest', 'action' => 'submit'),
        array('controller' => 'Collaboration', 'action' => 'filter', 'no_private'=> true),
        
        
        array('controller' => 'Collaboration', 'action' => 'launch_concepts_filter'),
        array('controller' => 'Collaboration', 'action' => 'launch_models_filter'),
        
        
        
        // Message
        array('controller' => 'Message', 'action' => 'send'),
        array('controller' => 'Message', 'action' => 'dd'),
        array('controller' => 'Message', 'action' => 'delete'),
        array('controller' => 'Message', 'action' => 'read'),
        
        
        
        
        
        // Community
        array('controller' => 'community', 'action' => 'filter_posts', 'no_private'=> true),
        array('controller' => 'Community', 'action' => 'submit_comment'),
        array('controller' => 'Community', 'action' => 'submit_post'),
        array('controller' => 'Community', 'action' => 'submit_post_options'),
        array('controller' => 'Community', 'action' => 'submit_edit_post'),
        array('controller' => 'Community', 'action' => 'submit_delete_post'),
        array('controller' => 'Community', 'action' => 'kmvg', 'no_private'=> true),
        
        // User
        array('controller' => 'User', 'action' => 'update_profile'),
        array('controller' => 'User', 'action' => 'update_settings'),
        array('controller' => 'User', 'action' => 'unfollow'),
        
        
        
        
        array('controller' => 'Publisher', 'action' => 'validate'),
        array('controller' => 'Publisher', 'action' => 'submit'),
        
        
        
        array('controller' => 'CollaborationActive', 'action' => 'submit_wip_feedback'),
        array('controller' => 'CollaborationActive', 'action' => 'send_message'),
        
        array('controller' => 'CollaborationActive', 'action' => 'submit_rate'),
        
        
        
        // ConceptPublisher
        //array('controller' => 'ConceptPublisher', 'action' => 'validate_notes'),
        //array('controller' => 'ConceptPublisher', 'action' => 'validate_images'),
        //array('controller' => 'ConceptPublisher', 'action' => 'submit'),
        
        // TexturedPublisher
        //array('controller' => 'TexturedPublisher', 'action' => 'validate_images'),
        //array('controller' => 'TexturedPublisher', 'action' => 'validate_description'),
        //array('controller' => 'TexturedPublisher', 'action' => 'validate_tech'),
        //array('controller' => 'TexturedPublisher', 'action' => 'validate_upload'),
        //array('controller' => 'TexturedPublisher', 'action' => 'submit'),
    )
    
    
    
    
    
);



?>