<?php


if(!defined('EDD_FES_S3_VERSION')) {
    define('EDD_FES_S3_VERSION', '1.1.1');
}


if(!defined('EDD_FES_S3_UPLOADS_TABLE')) {
    define('EDD_FES_S3_UPLOADS_TABLE', 'ksm_s3_temp_uploads');
}

if(!defined('EDD_FES_S3_CLEAR_UPLOADS_INTERVAL')) {
    define('EDD_FES_S3_CLEAR_UPLOADS_INTERVAL', 60*60*24);
}

if(!defined('EDD_FES_S3_CLEAR_UPLOADS_INTERVAL_NAME')) {
    define('EDD_FES_S3_CLEAR_UPLOADS_INTERVAL_NAME', 'daily');
}





define('POST_BLOCK_REPORTS_THRESHOLD', '30 minutes'); // 30 minutes
define('POST_BLOCK_REPORTS_COUNT', 2);


define('POST_CONTENT_MAX_LENGTH', '800');
define('POST_TITLE_MAX_LENGTH', '20');
define('POST_COMMUNITY_MAX_LENGTH', '800');








define('KSM_WALL_POST_UPLOAD_SIZE', '10mb');
define('KSM_WALL_POST_UPLOAD_TYPES', 'jpg,jpeg,png');
define('KSM_WALL_POST_RESULTS_PER_PAGE', '5');


define('COMMUNITY_POSTS_PER_PAGE', '20');


define('POST_MAX_LENGTH', '20');
define('POST_TITLE_MAX_LENGTH', '20');



define('MAX_MODEL_RETURN_LIMIT', 9);
define('MONTHLY_MODEL_RETURN_LIMIT', 3);


define('ALLOWED_FAVORITE_POST_TYPES', 'attachment,download,ksm_post');


define('KSM_ARTIST_COMMISSION_RATE', 80);



define('KSM_COMPOSE_IMAGE_UPLOAD_SIZE', '10mb');
define('KSM_COMPOSE_IMAGE_UPLOAD_TYPES', 'jpg,jpeg,png');


define('KSM_COMPOSE_FILE_UPLOAD_SIZE', 10);
define('KSM_COMPOSE_FILE_UPLOAD_TYPES', '*');


define('KSM_MESSAGES_DROPDOWN_RESULTS_PER_PAGE', '5');


define('KSM_AVATAR_UPLOAD_SIZE', '10mb');
define('KSM_AVATAR_UPLOAD_TYPES', 'jpg,jpeg,png,gif');



define('KSM_FACEBOOK_APP_ID', '379176981319');
define('KSM_FACEBOOK_APP_SECRET', 'e27ae63cedba67353df7ba7d46f3110f');





define('OPTIONS_DATASTORE_PATH', KSM_LIB_PATH . 'Datastore' . DIRECTORY_SEPARATOR);
define('TERMS_DATASTORE_PATH', OPTIONS_DATASTORE_PATH . 'Terms' . DIRECTORY_SEPARATOR);

define('KSM_CACHE_PATH', KSM_BASE_PATH . 'cache' . DIRECTORY_SEPARATOR);
define('KSM_VIEWS_CACHE_PATH', KSM_CACHE_PATH . 'Views' . DIRECTORY_SEPARATOR . date('mdY') .  DIRECTORY_SEPARATOR);


define('RECAPTCHA_SITE_KEY', '6LemNh4TAAAAAMwyn_QO-8FmS4z5Pubbzn4HMAJi');

define('RECAPTCHA_SECRET_KEY', '6LemNh4TAAAAALha3iuKKRcYjFzkcjSnhYult1zT');






$GLOBALS['ksm_win_settings'] = array(
    'settings' => array(
        'height' => '800',
        'width' => '706'
    ),
    'compose' => array(
        'height' => '500',
        'width' => '706'
    ),
    'following' => array(
        'height' => '780',
        'width' => '706'
    ),
    'favorites' => array(
        'height' => '750',
        'width' => '994'
    ),
    'top_selling' => array(
        'height' => '750',
        'width' => '994'
    ),
    'add_wip' => array(
        'height' => '1050',
        'width' => '740'
    ),
    'edit_profile' => array(
        'height' => '800',
        'width' => '706'
    )
    
);




$GLOBALS['ksm_list_skills'] = array(
    1 =>    'Anatomical Sculpture', 
            'Architecture', 
            'Archoo',
            'Sci Fi Vehicles', 
            'Envirtonment Concepts'
);


$GLOBALS['ksm_list_softwares'] = array(
    1 =>    'Maya', 
            'Studio Max', 
            'Lightwave', 
            'Photoshop', 
            'ZBrush'
);


require_once 'classes/class.hash.php';

?>
