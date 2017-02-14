<?php


function ksm_route_params() {
    $loader = KSM_MvcLoader::get_instance();
    $params = array();
    if($loader->dispatcher) {
        if($loader->dispatcher->controller) {
            $params = $loader->dispatcher->controller->params;
        }
    }

    return $params;
}


function ksm_developer_functions() {

    $ksm_delevopers = array(
        'nitesh'
    );

    foreach($ksm_delevopers as $__ksm_d) {
        $f = __DIR__ . DIRECTORY_SEPARATOR .$__ksm_d . DIRECTORY_SEPARATOR . 'functions.php';
        if(file_exists($f)) {
            require_once $f;
        }
    }
}

ksm_developer_functions();



function KSM_template_redirect() {

    //echo "asdasd";
    //echo is_front_page();
    //exit;
    //if(is_front_page()) {
    //    $url = ksm_get_permalink('community');
        //wp_redirect($url);

    //}
}

add_filter('template_redirect', 'KSM_template_redirect');



function ksm_get_page_id($page) {
    return get_option('ksm-'.$page.'-page');
}


function ksm_user_upload_attachment($attachment_id, $type) {
    update_post_meta($attachment_id, 'user_upload_type', $type);
    update_post_meta($attachment_id, 'not_attached', 'yes');
}

function ksm_user_attach_attachment($id) {
    delete_post_meta($id, 'not_attached');
}


function ksm_attach_attachment($attachment_id, $post_id) {
    wp_update_post(array('ID' => $attachment_id, 'post_parent' => $post_id));
    do_action('ksm_user_attach_attachment', $attachment_id);
}

function ksm_set_post_thumbnail($post_id, $attachment_id) {
    set_post_thumbnail($post_id, $attachment_id);
    do_action('ksm_user_attach_attachment', $attachment_id);
}

function ksm_include_element($name) {
    return KSM_Template::include_element($name);
}


function ksm_can_user_attach_attachment($att, $type , $user_ID=0) {
    if(!$user_ID) {
        global $user_ID;
    }
    if($att->post_type == 'attachment' &&
            $user_ID &&
            $att->post_author == $user_ID &&
            !$att->post_parent &&
            $att->user_upload_type == $type &&
            $att->not_attached == 'yes') {
        return true;
    }
    return false;
}

function add_tinymce_editor(){
    wp_admin_css('thickbox');
    wp_enqueue_script('wp-tinymce');
    wp_enqueue_script('tinymce');
    wp_enqueue_script('editor');
    add_thickbox();
}


function ksm_page_link($link, $post_id, $sample) {
    //echo $post_id;
    /*
    $page = get_post($post_id);
    add_query_arg();
    if($page->post_type == 'page') {
        if(strpos($page->post_name, 'ksm-page-') !== true) {
            $p = split('ksm-page-', $page->post_name);
            $link = home_url('profile/'.$p[1]);
        }
    }
    */
    return $link;
}

function ksm_edit_profile_page_url() {
    return home_url() . '?page_id='.  ksm_get_page_id('page-edit_profile');
}



function ksm_get_permalink($pagename, $username='', $page='') {

    $url = "";



    $url .= $pagename;

    if($username) {
        $url .= "/{$username}";
    }

    if($page) {
        $url .= "/page/{$page}";
    }

    return home_url("{$url}");

}

function ksm_ajax_loader() {

    $url = esc_url(trim($_POST['u'], '/'));
    $uri = array();

    foreach ( (array)$GLOBALS['ksm_ajax_rewrite_rules'] as $match => $query) {
        if ( preg_match("#^$match#", $url, $matches) ) {
            $query = addslashes(WP_MatchesMapRegex::apply($query, $matches));
            parse_str($query, $uri);
            break;
        }
    }


    switch ($uri['tab']) {

        case "collaboration" :

            break;


    }

    //pr($uri);




    die();
}

function ksm_account_settings_page_url() {

    return get_permalink(ksm_get_page_id('page-settings'));
    //return home_url() . '?page_id='.  ksm_get_page_id('page-settings');
}


function ksm_profile_following_page_url() {
    return home_url() . '?page_id='.  ksm_get_page_id('page-following');
}



 function ksm_copy_image_attachment($id) {

     if(!wp_attachment_is_image($id)) {
         return '0';
     }

     $att = get_post($id);
     $uploads = wp_upload_dir();

     $file_path = get_attached_file($att->ID);
     $pathinfo = pathinfo($file_path);

     do {
         $new_filename = "{$pathinfo['filename']}_".rand(111111,999999).'_'.time().".{$pathinfo['extension']}";
         $new_file_path = "{$uploads['path']}/{$new_filename}";
     } while (file_exists($new_file_path));

     $new_url = "{$uploads['url']}/{$new_filename}";

     if(!copy($file_path, $new_file_path)) {
         return '0';
     }

     $wp_filetype = wp_check_filetype($new_filename, null );


     $attachment = array(
         'guid' => $new_url,
         'post_mime_type' => $wp_filetype['type'],
         'post_title'     => $att->post_title,
         'post_content' => '',
         'post_status' => 'inherit',
         'post_author' => $att->post_author
     );

     $attachment_id = wp_insert_attachment( $attachment, $new_file_path );

     if($attachment_id) {
         require_once(ABSPATH . 'magento-help/includes/image.php');
         $attach_data = wp_generate_attachment_metadata( $attachment_id, $new_file_path );
         wp_update_attachment_metadata( $attachment_id, $attach_data );
         return $attachment_id;
     }

}


function get_the_user_ip() {
    if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


function KSM_load_vendor($vendor) {
    $ds = DIRECTORY_SEPARATOR;
    $vendor_path = KSM_BASE_PATH . "vendor{$ds}" . str_replace('.', $ds, $vendor) . "{$ds}src{$ds}autoload.php";
    if(file_exists($vendor_path)) {
        require_once $vendor_path;
    }
}

function ksm_query_vars($vars) {

    //echo ksm_query_vars . "<br>";

        $vars[] = "username";
        $vars[] = "tab";
        $vars[] = "ksm_controller";
        $vars[] = "ksm_action";
        $vars[] = "ksm_pname";
        $vars[] = "sl_key";
        return $vars;
}



function validateDate($date, $format = 'm/d/Y') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function ksm_update_user_sales($download_id, $d) {

    $download = get_post($download_id);

    if($download && $download->post_type == 'download') {
        $download_authors = array();


        if($download->collaboration_id) {
            $download_authors = $download->collaboration_partners;
        } else {
            $download_authors[] = array('id' => $download->post_author, 'price' => $d['price']);
        }


        foreach ((Array) $download_authors as $k => $v) {
            $sales_month = get_number(get_user_meta($v['id'], 'sales_month', true));
            update_user_meta($v['id'], 'sales_lifetime', KSM_User::count_sales($v['id']));
            update_user_meta($v['id'], 'sales_month', $sales_month + $v['price']);
        }


    }
}

function ksm_update_user_top_selling($download_id) {
    $download = get_post($download_id);
    $top_sellings = KSM_Stats::count_user_top_sellings($download->post_author);
    update_user_meta($download->post_author, 'top_selling_count', $top_sellings);
}


function get_current_controller() {
    return $GLOBALS['controller'];
}

function ksm_is_current_tab($tab) {

    $controller = get_query_var('mvc_controller');


    if($tab == 'collaboration' && ($controller == 'CollaborationRequest' || $controller == 'CollaborationActive' || $controller == 'Collaboration') ) {
        return true;
    }

    if($controller && $controller == $tab) {
        return true;
    }

    return false;
}


function get_image_src($attachment_id, $size='') {
    $image = wp_get_attachment_image_src($attachment_id, $size);
    return $image[0];
}


function get_image_ar($attachment_id, $size) {
    $avatar = wp_get_attachment_image_src($attachment_id, $size);
    return $avatar;
}



function time_ago($date, $append = " ago") {

    $date = is_numeric($date) ? $date : strtotime($date);



    //if(date('d', $date) == date('d')) {
        $date = ucwords(human_time_diff( $date) . $append);
    //} else {
    //    $date = date('M d, Y', $date);
    //}
    return $date;
}



function get_default_avatar($size='avatar_small') {
    switch($size) {
        case 'avatar_large':
            $dimensions = '135x135';
            break;
        case 'avatar_small' :
            $dimensions = '61x61';
            break;
        case 'avatar_small_2' :
            $dimensions = '72x72';
            break;
        case "avatar_tiny" :
            $dimensions = '41x41';
            break;
        case "avatar_tiny_2" :
            $dimensions = '24x24';
            break;


    }


    return KSM_BASE_URL.'images/avatar-'.$dimensions.'.jpg';
}

function get_number($num) {
    return $num ? $num : '0';
}



function ksm_posts_where($where) {
    global $wpdb, $wp_query;

//    echo $where;
//    pr($wp_query);
//    exit;


    return $where;
}



function ksm_format_to_number($number = 0) {


    return str_replace(array('k', 'm'), array('000', '000000'), $number);


}




function fvii() {
    $id = sanitize_text_field($_POST['id']);
    $p = get_post($id);
    ob_start();
    //pr($p);
    if($p->post_type == 'download') {
        include KSM_VIEWS_PATH. '__Element/gallery_full_view_item_info.php';
    }
    echo ob_get_clean();
    die();
}


function ksm_loading() {
    include KSM_BASE_PATH.'templates/__elements/loading.php';
}



function sl_to_link($key) {
    global $wpdb;

    if(!$key) {
        return;
    }


    $posts = get_posts(array(
        'post_type' => 'any',
        'post_status' => 'publish',
        'meta_query' => array(
            array('key' => 'short_link', 'value' => $key)
        )
    ));


    if($posts[0]) {
        $post = $posts[0];

        switch ($post->post_type) {

            case "ksm_wall_post" :
                $link = ksm_get_wall_post_to_link($post);
                if($link) {
                    wp_redirect($link);
                }
                break;

            case "download":
                $link = ksm_get_download_to_link($post);
                if($link) {
                    wp_redirect($link);
                }
                break;
            case "ksm_wip":
                $link = ksm_get_wip_to_link($post);
                if($link) {
                    wp_redirect($link);
                }
                break;

        }

    }



}


function ksm_get_wip_to_link($post) {
    global $wpdb;
    $user = get_user_by('id', $post->post_author);

    if(!$user instanceof WP_User) {
        return '';
    }

    $q = "SELECT count(*) total FROM {$wpdb->posts} WHERE post_author = '{$post->post_author}' AND post_type = 'ksm_wip' AND ID >= '{$post->ID}'";

    $offset = $wpdb->get_var($q);
    if($offset) {
        $page = ceil($offset / 20);
    }

    $link = ksm_get_permalink('studio', $user->user_login);
    $link .= "#wip_{$page}_{$post->ID}";

    return $link;
}


function ksm_get_download_to_link($post) {
    global $wpdb;
    $user = get_user_by('id', $post->post_author);

    if(!$user instanceof WP_User) {
        return '';
    }

    $q = "SELECT count(*) total FROM {$wpdb->posts} WHERE post_author = '{$post->post_author}' AND post_type = 'download' AND ID >= '{$post->ID}'";

    $offset = $wpdb->get_var($q);
    if($offset) {
        $page = ceil($offset / 20);
    }

    $link = ksm_get_permalink('studio', $user->user_login);
    $link .= "#dl_{$page}_{$post->ID}";

    return $link;
}



function ksm_get_wall_post_to_link($post) {
    global $wpdb;
    $user = get_user_by('id', $post->post_author);

    if(!$user instanceof WP_User) {
        return '';
    }

    $q = "SELECT count(*) total FROM {$wpdb->posts} WHERE post_author = '{$post->post_author}' AND post_type = 'ksm_wall_post' AND ID >= '{$post->ID}'";

    $offset = $wpdb->get_var($q);
    if($offset) {
        $page = ceil($offset / 5);
    }

    $link = ksm_get_permalink('studio', $user->user_login, $page);
    $link .= "#wp_$post->ID";

    return $link;
}




if(!function_exists('pr')) {
    function pr($ar){
        echo "<pre>";
        print_r($ar);
        echo "</pre>";
    }
}



//add_action( 'template_redirect', 'ppv_template_redirect' );
//function ppv_template_redirect() {
    global $wp_query, $post, $user_ID, $post_type, $user_login, $wpdb;

    //pr($wp_query);
    //exit;

//}


function ksm_insert_post($post_id, $post, $update) {
    if($update) {
        return;
    }


    update_post_meta($post_id, 'likes', array());

    update_post_meta($post_id, 'trending', '0');
    update_post_meta($post_id, 'rating_coefficient', '0');
    update_post_meta($post_id, 'views_count', '0');
    update_post_meta($post_id, 'likes_count', '0');

    if($post->post_type == 'ksm_post') {
        update_post_meta($post_id, 'reports_count', '0');
        update_post_meta($post_id, 'blocked', 'no');
    }

}



function ksm_pre_get_posts($query) {





    /*

    if(!$query->is_main_query() || is_admin()) {
        return;
    }

    ksm_init_controller();

    if($GLOBALS['k_controller']) {

        $name = $GLOBALS['k_controller']->name;
        $GLOBALS['k_controller']->{$name}->pre_get_posts($query);

    }

    */


    /*
    if(!$query->is_main_query() || is_admin() || !is_archive() || $query->query_vars['post_type'] != 'ksm_wall_post') {
        return $query;
    }


    $profile = KSM_profile::getInstance();



    $fes_settings = get_option( 'fes_settings' );
    $login_page = $fes_settings['fes-vendor-dashboard-page'];




    if($profile->is_private_pofile && $profile->error == '1') {
        wp_redirect(add_query_arg( 'view', 'login', get_permalink($login_page)));
        exit;
    }

    if(!$profile->profile_user->ID) {
        exit;
    }

    $query->set('posts_per_page' , KSM_WALL_POST_RESULTS_PER_PAGE );
    $query->set('post_status' , 'publish' );
    $query->set('meta_key' , 'wall_id');
    $query->set('meta_value' , $profile->profile_user->ID);
    $query->set('orderby' , 'date' );
    $query->set('order' , 'DESC' );
    */





    //pr($query);



}



function get_hour_key($num = 0) {

    $_time = time();


    $_this_hour = date('H', $_time);
    $_date_str =  date('d M Y', $_time);


    $_time_str = "{$_date_str} {$_this_hour} " . (($_this_hour == '1') ? 'hour' : 'hours');


    $this_hour = strtotime($_time_str);

    return ($this_hour - (3600 * $num));
}


function KSM_MVC_getControllerClassName($name) {

    $name = implode('_', array_map('ucfirst', explode('_', $name)));

    return "KSM_{$name}Controller";
}

function KSM_MVC_getName($class) {

    $name = "";

    if(strtolower(substr($class, 0,4)) == 'ksm_') {

        preg_match_all('/[A-Z][^A-Z]*/' ,  substr($class, 4), $split);
        $split = $split[0];



        $last = end($split);
        if(strtolower($last) == 'controller' || strtolower($last) == 'model' || strtolower($last) == 'helper') {
            unset($split[key($split)]);
        }




        $name = implode('', array_map('ucfirst', $split));

    }

    return $name;
}


function KSM_MVC_getFileName($class) {
    $name = KSM_MVC_getName($class);

    preg_match_all('/[A-Z][^A-Z]*/' ,  $name, $split);
    $split = $split[0];

    $name = implode('_', array_map('strtolower', $split));
    return $name;
}


function get_countryName($short_name) {

    if($short_name) {
        $countries = KSM_DataStore::Options('country');
        return $countries[$short_name];
    }
    return '';

}


function get_Language($short_name) {

    if($short_name) {
        $languages = KSM_DataStore::Options('languages');
        return $languages[$short_name];
    }
    return '';

}



function login_message($type = '') {

    $msg =
    '<div class="empty_msg">
        You don\'t have access to this page.
        Click here to <a atrqt="'.$type.'" href="">Login</a>
    </div>';
    return $msg;
}


function post_attacments($post_id, $args = array() , $including_thumb = true) {

    if(!$post_id) {
        return array();
    }


    $thumb_attachment = array();
    if($including_thumb) {
        $thumb_id = get_post_meta( $post_id, '_thumbnail_id', true );
        if($thumb_id) {
            $thumb_attachment[0] = get_post($thumb_id);
        }
    }



    $defaults = array(
        'post_type' => 'attachment',
        'posts_per_page' => -1,
        'post_parent' => $post_id,
        'post_mime_type' => 'image',
        'post_status' => array('inherit', 'publish')
    );


    $args = wp_parse_args( $args, $defaults );


    $attachments = get_posts($args);
    $attachments = $attachments ? $attachments : array();


    return array_merge($thumb_attachment, $attachments);
}


function post_attacment_ids($post_id, $args = array() , $including_thumb = true) {
    $attas = post_attacments($post_id, $args , $including_thumb);


    $list = array();
    foreach ($attas as $v) {
        $list[] = $v->ID;
    }

    return $list;

}



function ksm_slick_gallery($attachments, $settings = array()) {


    $thumb_size = $settings['thumb_size'];
    $full_size  = $settings['full_size'];

    $name = $settings['name'];
    $count_view = $settings['count_view'] ? $settings['count_view'] : false;



    if(!empty($attachments)) : ?>

    <div class="gallery_container slick_attachment_gallery">
        <div id="<?=$name?>" class="gallery">

            <?php if($settings['full'] !== false) : ?>
            <div class="full">
                <div class="slider">

                    <?php foreach($attachments as $att) :
                        $src = get_image_src($att->ID, $full_size);
                        if(!$src) continue;

                        if($count_view) KSM_postView::add($att);

                        ?>
                        <div data-item="<?=$att->ID?>">
                            <img src="<?=$src?>" />
                        </div>


                    <?php endforeach; ?>
                </div>

            </div>

            <?php endif; ?>

            <?php if($settings['button']) echo $settings['button'];?>

            <div class="nav">
                <div class="nav_controls">
                        <button type="button" data-role="none" class="slick-prev" aria-label="previous"></button>
                        <button type="button" data-role="none" class="slick-next" aria-label="next"></button>
                    </div>
                <div class="slider">

                    <?php foreach($attachments as $att) :
                        $src = get_image_src($att->ID, $thumb_size);
                        if(!$src) continue;
                        ?>
                        <div data-item="<?=$att->ID?>">
                            <div class="in"><img src="<?=$src?>" /></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <?php


    endif;
}


function slick_attachment_gallery($post_id, $settings) {
    $with_featured = $settings['with_featured'] ? true : false;
    $attachments = post_attacments($post_id, array() , $with_featured);
    ksm_slick_gallery($attachments, $settings);
}





function KSM_TopBarUserMenu() {

    $user_id = get_current_user_id();
    ob_start();

    if($user_id) :
        include KSM_VIEWS_PATH . '__Element' . DIRECTORY_SEPARATOR . 'top_bar_user_menu.php';
    else : ?>

        <div class="user_menu">
            <div class="upload_launch_container">
                <a ng-click="auth('login')" href="">
                    <div class="upload_launch"></div>
                    <div class="upload_launch_hover"></div>
                </a>
            </div>

            <ul class="noauth_nav">
                <li><a class="login_header_link" ng-click="auth('login')">Login</a></li>
                <li><a class="join_header_link" ng-click="auth('join')">Join</a></li>
            </ul>
        </div>
    <?php

    endif;

    return ob_get_clean();

}




function fes_dashboard() {
    $fes_settings = get_option( 'fes_settings' );

    return get_permalink($fes_settings['fes-vendor-dashboard-page']);
}


function star_rating_static($rating = 0, $calulate = false ,$max = 5) {

    if($calulate) {
        $m = 100 / $max;
        $rating = ($rating * $m) . '%';
    }

    return '<div class="rating"><div class="active" style="width:'.$rating.'"></div></div>';
}

function star_rating_static2($rating = 0, $calulate = false ,$max = 5) {

    if($calulate) {
        $m = 100 / $max;
        $rating = ($rating * $m) . '%';
    }
    return '<div class="rating2"><div class="active" style="width:'.$rating.'"></div></div>';
}

function ksm_avatar($user_id = 0, $size='avatar_small') {

        if($user_id) {
            $user = get_user_by('id', $user_id);
        }

        if($user instanceof WP_User) {
            if($user->$size) {
                $avatar = $user->$size;
            } elseif($user->avatar) {
                $avatar = get_image_src($user->avatar, $size);
            }
        }

        if($avatar) return $avatar;

        return get_default_avatar($size);

    }




function search_ajax_users($term) {

    $user_query = new WP_User_Query(
            array(
                'search' => $term,
                'search_columns' => array( 'user_login' )
                )
            );


        $data = array();
        foreach ( $user_query->results as $user ) {
            if(user_can($user, 'adminisrator')) {
                continue;
            }

            $d = array();
            $d['id'] = $user->ID;
            $d['label'] = $user->user_login;
            $d['value'] = $user->user_login;
            $data[] = $user->user_login;
	}

        return $data;

}

function ksm_users_suggest() {

    $term = trim($_GET['q']);
    if(strlen($term) > 2) {
        $term = "*{$term}*";
        echo json_encode(search_ajax_users($term));
    }

    die();

}


function ksm_softwares_suggest() {
    $term = trim($_GET['term']);
    if(strlen($term) > 2) {
        $all_softwares = $GLOBALS['ksm_list_softwares'];
        $matches = preg_grep("/{$term}/i", $all_softwares);
        echo json_encode($matches);
    }

    die();
}

function ksm_skills_suggest() {
    $term = trim($_GET['term']);
    if(strlen($term) > 2) {
        $all_skills = $GLOBALS['ksm_list_skills'];
        $matches = preg_grep("/{$term}/i", $all_skills);
        echo json_encode($matches);
    }

    die();
}


function term_parents($term_id) {

    $_term_id = $term_id;
    $result = array();

    $final = false;

    do {
        $term = get_term_by('id', $_term_id, 'category');
        $result[] = $term;
        $_term_id = $term->parent;

        if($_term_id == 0) {
            $final = true;
        }
    } while (!$final);

    $result = array_reverse($result);

    return $result;
}

function store_search_breadcrumb($cat) {


    if(!$cat) {
        return '<ul><li>Home</li><li class="clr"></li></ul>';
    }


    $terms = term_parents($cat);

    $breadcrumb = array();

    $breadcrumb[] = '<li>Home</li>';
    foreach($terms as $t) {
        $breadcrumb[] = "<li>{$t->name}</li>";
    }


    $childs = (Array) get_terms('category', array('parent'=> $cat, 'hide_empty'=> false));
    //pr($childs);

    if($childs) {
        $more_item = '<select class="light">';
        $more_item .= "<option value=\"\">MORE</option>";
        foreach($childs as $c) {
            $more_item .= "<option value=\"{$c->term_id}\">{$c->name}</option>";
        }
        $more_item .= '</select>';
        //$breadcrumb[] = "<li class=\"more_nav\">More{$more_item}</li>";
        $breadcrumb[] = "<li class=\"more_nav\">{$more_item}</li>";
    }

    $breadcrumb = implode('<li class="sep">&gt;</li>', $breadcrumb);
    $breadcrumb = "<ul>{$breadcrumb}<li class=\"clr\"></li></ul>";

    return $breadcrumb;
}




function last_array_element($ar = array()) {


    return is_array($ar) ? end($ar) : '';

}


function wp_kses_no_tag($content) {

    return wp_kses($content, array());
}


function ksm_enqueue_style($handle, $src = false, $deps = array(), $ver = false, $media = 'all') {
    wp_enqueue_style($handle, $src, $deps, $ver, $media);

    if(KSM_DEBUG_MODE) {

        // if (!is_front_page()) {
            $designers = array(
                'kunal',
                'sunny',
                'jaswinder',
                'kane'
            );
        // }


        if(strpos($src, trailingslashit(KSM_BASE_URL)) !== false) {
            $t = str_replace(trailingslashit(KSM_BASE_URL), "", $src);

            $i = pathinfo($t);


            foreach($designers as $d) {

                $usrc = trailingslashit(KSM_BASE_URL) . $i['dirname'] ."/" . $d . "/{$i['filename']}.css";
                $upath = KSM_BASE_PATH . untrailingslashit($i['dirname']) . DIRECTORY_SEPARATOR . $d . DIRECTORY_SEPARATOR . "{$i['filename']}.css";

                if(file_exists($upath)) {
                    wp_enqueue_style("{$d}-{$handle}", $usrc);
                }

            }


        }



    }


}




function KSM_Update_User_Cart_Meta() {
    $user_id = get_current_user_id();
    if($user_id) {
        $items = EDD()->session->get( 'edd_cart');
        update_user_meta($user_id, 'cart_items', $items);
    }
}


function KSM_edd_post_add_to_cart($download_id, $options) {
    KSM_Update_User_Cart_Meta();
}

function KSM_edd_post_remove_from_cart($cart_key, $item_id) {
    KSM_Update_User_Cart_Meta();
}

function KSM_edd_empty_cart() {
    KSM_Update_User_Cart_Meta();
}

function KSM_edd_cart_saving_disabled($disabled) {
    return false;
}

function KSM_wp_logout() {
    remove_action('edd_empty_cart', 'KSM_edd_empty_cart', 12);
    edd_empty_cart();
}


function KSM_wp_login($user_login) {

    $user = get_user_by('login', $user_login);


    $cart_items = $user->cart_items;

    if($cart_items) {

        foreach ((Array) $cart_items as $citem) {
            $pid = @$citem['id'];
            if($pid) {
                edd_add_to_cart($pid);
            }
        }

    }
}


add_action( 'wp_logout', 'KSM_wp_logout', 12 );

add_action( 'edd_post_add_to_cart', 'KSM_edd_post_add_to_cart', 12, 2 );
add_action( 'edd_post_remove_from_cart', 'KSM_edd_post_remove_from_cart', 12, 2 );
add_action('edd_empty_cart', 'KSM_edd_empty_cart', 12);


add_filter( 'edd_cart_saving_disabled',  'KSM_edd_cart_saving_disabled', 12, 1);


add_action( 'wp_login',  'KSM_wp_login' , 12, 1  );

//add_filter('posts_where', 'ksm_posts_where');
//add_filter('pre_get_posts','ksm_pre_get_posts');



add_action('wp_footer', 'ksm_wp_head');
function ksm_wp_head() {
    if(is_admin_bar_showing()) { ?>
        <style type="text/css">
            html {
                margin : 0 !important;
            }
            #page {
                padding-top: 32px;
            }
        </style>
    <?php
    }
}




function ksm_edd_insert_payment($payment_id, $payment_data) {


    if($payment_data['cart_details'] && !empty($payment_data['cart_details'])) {

        foreach($payment_data['cart_details'] as $d) {

            $download = new KSM_Download($d['id']);
            $p_download_id = wp_insert_post(array(
                    'post_title'    => $d['name'],
                    'post_status'   => isset( $payment_data['status'] ) ? $payment_data['status'] : 'pending',
                    'post_type'     => 'ksm_p_download',
                    'post_author'   => $payment_data['user_info']['id'],
                    'post_parent'   => $payment_id,
                    'post_date'     => isset( $payment_data['post_date'] ) ? $payment_data['post_date'] : null,
                    'post_date_gmt' => isset( $payment_data['post_date'] ) ? $payment_data['post_date'] : null
                ));

            if($p_download_id) {

                $file_meta = get_post_meta($d['id'], 'edd_download_files', true);
                $model_type = get_post_meta($d['id'], 'model_type', true);


                copy_post_terms($d['id'], $p_download_id, 'ksm_tax_keyword');


                $download_authors = (Array)$download->authors();
                $author_data = array();
                foreach ($download_authors as $a) {
                    $author_data["pd_download_author_{$a}_share"] = $download->author_price_share($a);
                    $author_data["pd_download_author_{$a}_income"] = $download->author_income_per_sale($a);
                }

                foreach ($author_data as $k => $v) {
                    update_post_meta($p_download_id, $k, $v);
                }

                update_post_meta($p_download_id, 'attachment_id', $file_meta[0]['attachment_id']);
                update_post_meta($p_download_id, 'model_type', $model_type);
                update_post_meta($p_download_id, 'download_id', $d['id']);
                update_post_meta($p_download_id, 'downloaded_count', '0');
                update_post_meta($p_download_id, 'download_limit', edd_get_file_download_limit($d['id']));
                update_post_meta($p_download_id, 'item_price', $d['item_price']);
                update_post_meta($p_download_id, 'discount', $d['discount']);
                update_post_meta($p_download_id, 'subtotal', $d['subtotal']);
                update_post_meta($p_download_id, 'tax', $d['tax']);
                update_post_meta($p_download_id, 'fee', $d['fee']);
                update_post_meta($p_download_id, 'price', $d['price']);

            }

        }
    }



    return $payment_id;

}


function ksm_edd_update_payment_status($payment_id, $new_status, $old_status) {


    $args = array(
        'posts_per_page'   => -1,
	'post_type'        => 'ksm_p_download',
	'post_parent'      => $payment_id,
        'post_status'      => 'any',
        );

    $posts = get_posts($args);


    foreach($posts as $p) {
	if ( $p->post_status === $new_status ) {
            return;
	}


	wp_update_post( array(
            'ID' => $p->ID,
            'post_status' => $new_status,
            'edit_date' => current_time( 'mysql' )
            ));
    }



    if($old_status != $new_status) {


        $downloads = edd_get_payment_meta_downloads($payment_id);

        foreach($downloads as $d) {


            KSM_Count::update_product_sale_stats($d['id'], $payment_id);
            KSM_Count::update_product_revenue($d['id']);
        }







        //'pd_download_author_{user_id}_share'



        update_user_purchases_stats($payment_id);
        //update_user_sales_stats($payment_id);
    }

}



//pr(KSM_Count::update_product_sale_stats(1804));
//exit;

function payment_to_authors($payment_id) {


    $downloads = edd_get_payment_meta_downloads($payment_id);

    $authors = array();

    foreach($downloads as $d) {
        $download = new KSM_Download($d['id']);

        if($download->ID) {
            $dauthors = $download->authors();
            foreach($dauthors as $a) {
                if(!in_array($a, $authors)) {
                    $authors[] = $a;
                }
            }
        }

    }

    return $authors;
}




function update_download_authors($download_id) {

}


function update_user_sales_stats($payment_id) {

    $payment_post = get_post($payment_id);

    if($payment_post && $payment_post->post_type == 'edd_payment') {


        $authors = payment_to_authors($payment_id);

        $downloads = edd_get_payment_meta_downloads($payment_id);

        foreach($downloads as $d) {

        }


        if($authors) {
            foreach($authors as $author) {
                KSM_Count::update_user_models_sale($author);
                KSM_Count::update_user_sales_revenue($author);
                KSM_Count::update_user_income($author);

                //KSM_Count::update_user_models_sold_this_year($author);
                //KSM_Count::update_user_sales_revenue_this_year($author);
                //KSM_Count::update_user_income_this_year($author);

                //KSM_Count::update_user_products_sold_this_month($author);
                //KSM_Count::update_user_sales_revenue_this_month($author);
                //KSM_Count::update_user_income_this_month($author);

                //KSM_Count::update_user_products_sold_today($author);
                //KSM_Count::update_user_sales_today($author);
                //KSM_Count::update_user_income_today($author);
            }
        }
    }
}


function ksm_date_key($y='0000', $m='00', $d='00') {
        $key = $y . $m . $d;
        return $key;
    }

function update_user_purchases_stats($payment_id) {

    $payment_post = get_post($payment_id);

    if($payment_post && $payment_post->post_type == 'edd_payment') {

        $user_id = $payment_post->post_author;

        $payment_year = date('Y', strtotime($payment_post->post_date));
        $payment_month = date('m', strtotime($payment_post->post_date));


        //$_month = $payment_year.'_'.$payment_year;


        KSM_Count::update_user_total_purchases($user_id);
        KSM_Count::update_user_textured_purchases($user_id);
        KSM_Count::update_user_untextured_purchases($user_id);
        KSM_Count::update_user_total_purchased_amount($user_id);

        KSM_Count::update_user_year_purchased_amount($user_id, $payment_year);
        KSM_Count::update_user_month_purchased_amount($user_id, $payment_year, $payment_month);



        /*
        product_stats {
            total_models
            solo_models
            collaboration_models
            textured_models
            untextured_models
            solo_textured_model
            solo_untextured_model
            collaboration_textured_model
            collaboration_untextured_model

        }
        */
    }


}




function ksm_update_author_model_stats($author) {

    KSM_Count::update_user_models($author);
    KSM_Count::update_user_textured_models($author);
    KSM_Count::update_user_untextured_models($author);

    KSM_Count::update_user_solo_models($author);
    KSM_Count::update_user_solo_textured_models($author);
    KSM_Count::update_user_solo_untextured_models($author);

    KSM_Count::update_user_collaboration_models($author);
    KSM_Count::update_user_collaboration_textured_models($author);
    KSM_Count::update_user_collaboration_untextured_models($author);

}


function ksm_update_author_model_ratings($author) {

    KSM_Count::update_user_models_rating($author);
    KSM_Count::update_user_textured_models_rating($author);
    KSM_Count::update_user_untextured_models_rating($author);

    KSM_Count::update_user_solo_models_rating($author);
    KSM_Count::update_user_solo_textured_models_rating($author);
    KSM_Count::update_user_solo_untextured_models_rating($author);

    KSM_Count::update_user_collaboration_models_rating($author);
    KSM_Count::update_user_collaboration_textured_models_rating($author);
    KSM_Count::update_user_collaboration_untextured_models_rating($author);
}


function copy_post_terms($from, $to, $tax) {


    $post_terms = wp_get_object_terms($from, $tax, array('fields' => 'slugs'));


    if(!($post_terms instanceof WP_Error)) {
         wp_set_object_terms($to, $post_terms, $tax, true);
    }
}




function ksm_get_ds_post_term_names($post_id, $tax, $section = '', $single = false) {

    $all_terms = array_keys(KSM_DataStore::Terms($tax, '', $section));
    $post_terms = wp_get_post_terms($post_id, "ksm_tax_{$tax}", array('fields' => 'names'));

    $terms = array();

    foreach((array) $post_terms as $t) {
        if(in_array($t, $all_terms)) {
            $terms[] = $t;
        }
    }


    if($single) {
        return ($terms[0] ? $terms[0] : '');
    }

    return $terms;
}



function array_average($ar) {

    $dv = count($ar);
    $average = 0;

    if($dv > 0) {
        $average = array_sum($ar) / count($ar);
    }
    return $average;
}

//function ksm_ajax_routes($routes = array()) {
//    $routes[] = array('controller' => 'Message', 'action' => 'submit_reset_password', 'no_private'=> true);
//    return $routes;
//}


function ksm_download_post_updated($post_ID, $post_after, $post_before) {
    if($post_before->post_type == 'download' && $post_after->post_status != $post_before->post_status) {

        $download = new KSM_Download($post_ID);

        foreach((Array) $download->authors() as $author) {
            ksm_update_author_model_stats($author);
        }
    }
}

function ksm_prepare_list_input_data($input_data, $vars = array(), $index='') {


    $input_data = (Array) ($input_data ? $input_data : array());

    $data = array();




    foreach($input_data as $field_name => $field_data) {
        if(in_array($field_name, $vars)) {
            foreach($field_data as $l => $m) {
                $_index = $index ? $input_data[$index][$l] : $l;
                foreach($vars as $_v) {
                    $data[$_index][$_v] = $input_data[$_v][$l];
                }
            }
        }
    }

    return $data;
}


add_action('edd_insert_payment', 'ksm_edd_insert_payment', 10, 2);
add_action( 'edd_update_payment_status', 'ksm_edd_update_payment_status' , 10, 3 );




add_action('post_updated', 'ksm_download_post_updated', 10, 3);
//add_filter('ksm_ajax_routes', 'ksm_ajax_routes', 10, 1);

remove_filter( 'parse_query', array( EDD_FES()->setup, 'restrict_media' ) );


function ksm_nav_cart_menu_item( $items, $args ) {


	if ( 'primary' != $args->theme_location )
		return $items;

	ob_start();

	$widget_args = array(
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => ''
	);

	$widget = the_widget( 'edd_cart_widget', array( 'title' => '' ), $widget_args );

	$widget = ob_get_clean();

	$link = sprintf( '<li class="current-cart"><a href="%s"><div class="kitmoda_cart_icon"></div> <div class="header_count_backdrop_box"><span class="edd-cart-quantity">%d</span></div></a><ul class="sub-menu nav-menu"><li class="widget">%s</li></ul></li>', get_permalink( edd_get_option( 'purchase_page' ) ), edd_get_cart_quantity(), $widget );

	return $link . $items;
}

remove_filter( 'wp_nav_menu_items', 'kitification_wp_nav_menu_items', 10);

add_filter( 'wp_nav_menu_items', 'ksm_nav_cart_menu_item', 100, 2);







function ksm_camelcase($str) {
    return preg_replace('/_(.?)/e',"strtoupper('$1')",$str);
}

function ksm_camelcase_to_underscored($str) {
    return strtolower(preg_replace('/([^A-Z])([A-Z])/', "$1_$2", $str));
}







add_action( 'edd_complete_purchase', 'KSM_edd_complete_purchase' , 999, 1 );
function KSM_edd_complete_purchase($payment_id) {


}


add_filter( 'edd_get_download_price', 'ksm_edd_get_download_price', 99, 2 );

function ksm_edd_get_download_price($price, $download_id) {
    $download = KSM_Download::get($download_id);
    if($download) {
        return $download->discounted_price();
    }

    return $price;
}

//add_action('init', 'ksm_debug_init');



function ksm_debug_init() {
    $user = KSM_User::get('25');
    $user->emit('user_register');
}


require_once "user_functions.php";
require_once 'commission_changes.php';
require_once 'checkout_changes.php';

?>