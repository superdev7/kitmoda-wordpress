<?php


KSM_MvcRouter::route('profile/{:controller}');
KSM_MvcRouter::route('profile/{:controller}/{:action}');




KSM_MvcRouter::route('share/{:id}', array('controller' => 'share', 'action' => 'share'));
KSM_MvcRouter::route('sl/{:id}', array('controller' => 'share', 'action'=>'short_link'));







KSM_MvcRouter::route('login', array('controller' => 'user', 'action' => 'login'));
KSM_MvcRouter::route('join', array('controller' => 'user', 'action' => 'join'));

KSM_MvcRouter::route('login/{:ar_action}', array('controller' => 'user', 'action' => 'login'));
KSM_MvcRouter::route('join/{:ar_action}', array('controller' => 'user', 'action' => 'join'));




KSM_MvcRouter::ajax_route(array('controller' => 'User', 'action' => 'submit_join',  'no_private'=> true));
KSM_MvcRouter::ajax_route(array('controller' => 'User', 'action' => 'submit_login', 'no_private'=> true));


//Store

KSM_MvcRouter::route('store', array('controller' => 'store'));
KSM_MvcRouter::route('store/{:action}', array('controller' => 'store'));
KSM_MvcRouter::route('store/{:action}/{:id}', array('controller' => 'store'));

KSM_MvcRouter::ajax_route(array('controller' => 'store', 'action' => 'getTopRated', 'no_private'=> true));
KSM_MvcRouter::ajax_route(array('controller' => 'store', 'action' => 'getTopSelling', 'no_private'=> true));
KSM_MvcRouter::ajax_route(array('controller' => 'store', 'action' => 'getTrending', 'no_private'=> true));
KSM_MvcRouter::ajax_route(array('controller' => 'store', 'action' => 'filter_posts', 'no_private'=> true));





//Studio
KSM_MvcRouter::route('studio', array('controller' => 'studio', 'post_type' => 'ksm_wall_post'));
//KSM_MvcRouter::route('studio/{:action}', array('controller' => 'studio'));

KSM_MvcRouter::route('studio/{:username}', array('controller' => 'studio', 'post_type' => 'ksm_wall_post'));
KSM_MvcRouter::route('studio/{:username}/page/{:paged}', array('controller' => 'studio', 'post_type' => 'ksm_wall_post'));
KSM_MvcRouter::route('studio/page/{:paged}', array('controller' => 'studio', 'post_type' => 'ksm_wall_post'));
KSM_MvcRouter::route('studio/post_options/{:id}', array('controller' => 'studio', 'action' => 'post_options'));


KSM_MvcRouter::ajax_route(array('controller' => 'Studio', 'action' => 'submit_post'));
KSM_MvcRouter::ajax_route(array('controller' => 'Studio', 'action' => 'submit_post_options'));
KSM_MvcRouter::ajax_route(array('controller' => 'Studio', 'action' => 'submit_comment'));







// Collaboration
KSM_MvcRouter::route('collaboration', array('controller' => 'collaboration'));



KSM_MvcRouter::route('collaboration/full_view/{:id}', array('controller' => 'collaboration', 'action' => 'full_view'));


KSM_MvcRouter::route('collaboration/requests', array('controller' => 'CollaborationRequest', 'action' => 'index'));
KSM_MvcRouter::route('collaboration/request/join/{:id}', array('controller' => 'CollaborationRequest', 'action' => 'join'));
KSM_MvcRouter::route('collaboration/request/reject/{:id}', array('controller' => 'CollaborationRequest', 'action' => 'reject'));
KSM_MvcRouter::route('collaboration/request/accept/{:id}', array('controller' => 'CollaborationRequest', 'action' => 'accept'));






KSM_MvcRouter::route('collaboration/concept', array('controller' => 'collaboration', 'action' => 'index', 'collaboration_type' => 'concept'));
KSM_MvcRouter::route('collaboration/untextured', array('controller' => 'collaboration', 'action' => 'index', 'collaboration_type' => 'untextured'));



KSM_MvcRouter::ajax_route(array('controller' => 'Collaboration', 'action' => 'submit_join_request'));





//Message

KSM_MvcRouter::route('message/compose', array('controller' => 'message', 'action' => 'compose'));
KSM_MvcRouter::route('message/compose/{:to_user}', array('controller' => 'message', 'action' => 'compose'));
KSM_MvcRouter::ajax_route(array('controller' => 'Message', 'action' => 'send'));
KSM_MvcRouter::ajax_route(array('controller' => 'Message', 'action' => 'dd'));
KSM_MvcRouter::ajax_route(array('controller' => 'Message', 'action' => 'delete'));
KSM_MvcRouter::ajax_route(array('controller' => 'Message', 'action' => 'read'));



// User

KSM_MvcRouter::route('edit_profile', array('controller' => 'user', 'action' => 'edit_profile'));
KSM_MvcRouter::route('account_settings', array('controller' => 'user', 'action' => 'account_settings'));
KSM_MvcRouter::ajax_route(array('controller' => 'User', 'action' => 'update_profile'));
KSM_MvcRouter::ajax_route(array('controller' => 'User', 'action' => 'update_settings'));





KSM_MvcRouter::route('publisher', array('controller' => 'publisher'));


KSM_MvcRouter::route('publisher/textured', array('controller' => 'TexturedPublisher'));
KSM_MvcRouter::route('publisher/untextured', array('controller' => 'UntexturedPublisher'));



KSM_MvcRouter::route('publisher/concept', array('controller' => 'ConceptPublisher'));
KSM_MvcRouter::ajax_route(array('controller' => 'ConceptPublisher', 'action' => 'validate_notes'));
KSM_MvcRouter::ajax_route(array('controller' => 'ConceptPublisher', 'action' => 'validate_images'));
KSM_MvcRouter::ajax_route(array('controller' => 'ConceptPublisher', 'action' => 'submit'));



// Community
KSM_MvcRouter::route('community', array('controller' => 'community'));
KSM_MvcRouter::route('community/post_options/{:id}', array('controller' => 'community', 'action' => 'post_options'));


KSM_MvcRouter::ajax_route(array('controller' => 'community', 'action' => 'filter_posts', 'no_private'=> true));
KSM_MvcRouter::ajax_route(array('controller' => 'Community', 'action' => 'post_comment'));
KSM_MvcRouter::ajax_route(array('controller' => 'Community', 'action' => 'submit_post'));
KSM_MvcRouter::ajax_route(array('controller' => 'Community', 'action' => 'submit_post_options'));



KSM_MvcRouter::ajax_route(array('controller' => 'TexturedPublisher', 'action' => 'validate_images'));
KSM_MvcRouter::ajax_route(array('controller' => 'TexturedPublisher', 'action' => 'validate_description'));
KSM_MvcRouter::ajax_route(array('controller' => 'TexturedPublisher', 'action' => 'validate_tech'));
KSM_MvcRouter::ajax_route(array('controller' => 'TexturedPublisher', 'action' => 'validate_upload'));
KSM_MvcRouter::ajax_route(array('controller' => 'TexturedPublisher', 'action' => 'submit'));


?>