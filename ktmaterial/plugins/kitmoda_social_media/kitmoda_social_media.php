<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the ksm plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 *
 * Plugin Name:         kitmoda Social Media
 * Plugin URI:          https://kitmodadev.com
 * Description:         It will add social media features to kitmoda.com
 * Author URI:          http://www.kitmodadev.com
 *
 * Version:             1.1.1
 * Requires at least:   3.8
 * Tested up to:        4.0
 *
 *
 * @author              kitmoda
 */


// If this file is called directly, abort.
if (!defined('ABSPATH'))	exit;


//Constants
if(!defined('KSM_PLUGIN_VERSION')) define('KSM_PLUGIN_VERSION', '1.1.1');
if(!defined('KSM_DEBUG_MODE')) define('KSM_DEBUG_MODE', true);
if(!defined('KSM_REST_NAMESPACE')) define('KSM_REST_NAMESPACE', 'wp/v2');
if(!defined('KSM_API_URL')) define('KSM_API_URL', trailingslashit(rest_url(KSM_REST_NAMESPACE)));


add_action( 'rest_api_init', 'ksm_create_rest_routes', 0 );


//Registering Rest Routes
function ksm_create_rest_routes()
{
    KSM_MvcLoader::register_rest_routes();
}



//Main KSM plugin class - check to see if class doesn't already exist
if(!class_exists('kitmoda_Social_Media')) {
class kitmoda_Social_Media {

    public $loader;


    function __construct() {

        require_once 'includes/s3_config.php';

        //header("Cache-Control: nocache, no-store, max-age=0, must-revalidate");
        //header("Pragma: no-cache");
        //header("Expires: Fri, 01 Jan 1990 00:00:00 GMT");


        //Defining KSM Constants
        if(!defined('KSM_BASE_PATH')) define( 'KSM_BASE_PATH', WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . basename( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR );
        if(!defined('KSM_BASE_URL')) define( 'KSM_BASE_URL', plugin_dir_url( __FILE__ ) );
        if(!defined('KSM_PARTIALS_URL')) define("KSM_PARTIALS_URL", KSM_BASE_URL . "partials/");

        if(!defined('KSM_LIB_PATH')) define( 'KSM_LIB_PATH', KSM_BASE_PATH . 'lib' . DIRECTORY_SEPARATOR);
        if(!defined('KSM_CONTROLLERS_PATH')) define( 'KSM_CONTROLLERS_PATH', KSM_LIB_PATH . 'Controller' . DIRECTORY_SEPARATOR);
        if(!defined('KSM_MODELS_PATH')) define( 'KSM_MODELS_PATH', KSM_LIB_PATH . 'Model' . DIRECTORY_SEPARATOR);
        if(!defined('KSM_VIEWS_PATH')) define( 'KSM_VIEWS_PATH', KSM_LIB_PATH  . 'View' . DIRECTORY_SEPARATOR);
        if(!defined('KSM_HELPERS_PATH')) define( 'KSM_HELPERS_PATH', KSM_VIEWS_PATH . 'Helper' . DIRECTORY_SEPARATOR);






        require_once 'vendor/autoload.php';

		/**
        	Activation and deactivation hooks
			To perform actions when KSM plugin is activated or deactivated, calls
			the activate and deactivate funtions respectively

		**/
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));


        spl_autoload_register(array($this, 'auto_loader'));



        $this->includes(); //Include files by calling KSM includes function

        add_filter( 'set-screen-option', array($this, 'set_screen'), 10, 3 );

        add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue_scripts') );


        add_filter( 'fes_login_form_success_redirect',array($this, 'login_success_redirect'), 10, 2);


        add_action( 'wp_enqueue_style', array($this, 'enqueue_style') );

        add_action( 'wp_enqueue_scripts', array($this, 'enqueue_style') );

        add_filter('template_include', array( 'KSM_Template', 'template_include') );

        add_action('init', array($this, 'init'), 11);
        add_action('init', array($this, 'init_top'), 0);
        add_action('admin_menu', array($this, 'admin_menu'));

        add_action('fes_vendor_delete_product', array($this, 'count_product_stats') );
        add_action('fes_approve_download_admin', array($this, 'count_product_stats'));
        add_action('trashed_post', array($this, 'count_product_stats'));
        add_action('untrashed_post', array($this, 'count_product_stats'));
        add_action('deleted_post', array($this, 'count_product_stats'));
        add_action('fes_submission_form_new_published', array($this, 'count_product_stats'));


        add_action('edd_complete_download_purchase', array($this, 'ksm_update_user_sales'), 11, 4);





        $this->loader = KSM_MvcLoader::get_instance();



		add_filter('rewrite_rules_array', array($this->loader, 'add_rewrite_rules'));

        add_filter('query_vars', array($this->loader, 'add_query_vars'));

        add_filter('wp_loaded', array($this->loader, 'flush_rewrite_rules'));

		add_filter('template_redirect', array($this->loader, 'template_redirect'));
        add_action('plugins_loaded', array($this->loader, 'add_ajax_routes'));

        //add_action('init', array($this->loader, 'init'));
        //add_action('init', array($loader, 'init'));


        add_action( 'parse_query', array($this->loader, 'parse_query'));
        //add_action('pre_get_posts', array($this->loader, 'pre_get_posts'));




        //add_action( 'rest_api_init', array($this->loader, 'register_rest_routes'), 0);



        add_action('delete_attachment', array($this, 'delete_attachment_handler'));



        add_action( 'admin_init', array($this, 'admin_init') );

    }

    function set_screen($status, $option, $value) {
        return $value;
    }
    function admin_init() {

        require_once 'admin/post-types/post.php';
        require_once 'admin/users-table.php';
        require_once 'admin/checks-table.php';
    }

    //Loads admin css and js script files
    function admin_enqueue_scripts() {

        ksm_enqueue_style('ksm_admin-style', trailingslashit(KSM_BASE_URL).'admin/css/style.css');
        wp_enqueue_script('ksm_admin-js', trailingslashit(KSM_BASE_URL).'admin/js/functions.js');
    }


    //Registering custom post_types, taxonomies and images sizes
    public function init_top() {

        $this->register_post_types();
        $this->register_taxonomies();

        $this->add_image_sizes();

    }


    /**
	 *
	 *	Registers Custom Post Types for KSM Plugin
	 *  (post types are stored in kitmoda_social_media\lib\DataStore\PostType.php)
	 **/
    public function register_post_types() {

        $post_types = KSM_DataStore::Options('PostType');



        foreach($post_types as $pt => $pt_args) {
            register_post_type($pt, $pt_args);
        }

        require_once 'admin/post-types/kitmoda_updates.php';

    }

    /**
	 *
	 *	Registers Additional Image Sizes for KSM Plugin
	 *  (sizes stored in kitmoda_social_media\lib\DataStore\ImageSize.php)
	 **/
    public function add_image_sizes() {

        $sizes = KSM_DataStore::Options('ImageSize');
        foreach($sizes as $sname => $s_args) {
            add_image_size($sname, $s_args['width'], $s_args['height'], $s_args['crop']);
        }
    }


    /**
	 *
	 *	Registers Custom Taxonomies for KSM Plugin
	 *  (taxonomies are stored in kitmoda_social_media\lib\DataStore\Taxonomy.php)
	 **/
    public function register_taxonomies() {
        foreach((Array) KSM_DataStore::Options('taxonomy') as $t => $args) {

            $tax = new KSM_Taxonomy($t);

            //if(taxonomy_exists($tax->key)) {
            //    continue;
            //}

            register_taxonomy($tax->key, $tax->objects,
                    array(
                        'labels' => array(
                            'name'          => $tax->name,
                            'new_item_name' => "New {$tax->name}",
                            'add_new_item'  => "Add New {$tax->name}",
                            'menu_name'     =>  "{$args['menu_name']}",
                            'ksm_lable'     => 'Text'
                            ),
                            'public'        => true,
                            'show_ui'       => true,
                            'show_tagcloud' => true,
                            'hierarchical'  => $tax->hierarchical,
                            'show_in_menu' => (isset($args['show_in_menu']) ? $args['show_in_menu'] : true),
                            'query_var'     => true,
                            'rewrite'       => array( 'slug' => $tax->slug ),
                        )
            );
        }
    }




    public function init() {

		//check if cron function exists and then run it
        if($_GET['ksm_cron'] && method_exists('KSM_CRON', $_GET['ksm_cron'])) {
            $method = $_GET['ksm_cron'];
            KSM_CRON::$method();
            exit;
        }

		//check if patch function exists and then run it
        if($_GET['ksm_patch'] && method_exists('KSM_Patch', $_GET['ksm_patch'])) {
            $method = $_GET['ksm_patch'];
            KSM_Patch::$method();
            exit;
        }




    }

    //Automatically loads various class types(Controller, Model, Views, Rest)  from their various files.
    function auto_loader($class) {
	$file = $class;


        $parts = explode('_', $class);

        if(strtolower(substr($class, 0,4)) == 'ksm_') {
            $name = $parts[1];

            preg_match_all('/[A-Z][^A-Z]*/' ,  substr($class, 4), $split);
            $split = $split[0];


            //pr($split);

            if(strtolower(end($split)) == 'controller') {
                if(strtolower($split[0]) == 'base') {
                    $file = KSM_LIB_PATH . "base/controller.php";
                } else {
                    $file = KSM_CONTROLLERS_PATH . KSM_MVC_getFileName($class).".php";
                }
            }

            elseif(strtolower(end($split)) == 'rest') {
                if(strtolower($split[0]) == 'base') {
                    $file = KSM_LIB_PATH . "base/rest.php";
                }

                //else {
                //    $file = KSM_CONTROLLERS_PATH . KSM_MVC_getFileName($class).".php";
                //}
            }
            elseif(strtolower(end($split)) == 'model') {
                if(strtolower($split[0]) == 'base') {
                    $file = KSM_LIB_PATH . "base/model.php";
                } else {
                    $file = KSM_MODELS_PATH . KSM_MVC_getFileName($class).".php";
                }
            } elseif(strtolower($split[0]) == 'mvc' && $split[1]) {
                $file = KSM_LIB_PATH . strtolower($split[1]) . ".php";
            } elseif(strtolower($name) == 'view') {
                $file = KSM_LIB_PATH . "view.php";
            } elseif(strtolower(end($split)) == 'helper') {
                $file = KSM_HELPERS_PATH . KSM_MVC_getFileName($class).".php";
            } elseif(strtolower(end($split)) == 'publisher') {
                $file = KSM_BASE_PATH . "includes/classes/class.publisher.php";
            } elseif(strtolower(implode('', array_slice($split,-2,2,true))) == 'datastore') {
                $file = KSM_BASE_PATH . "includes/classes/class.datastore.php";
            }
            elseif(strtolower($split[0]) == 'collaboration') {
                $file = KSM_BASE_PATH . "includes/classes/class.collaboration.php";
            } elseif(strtolower(end($split)) == 'downloader') {
                $file = KSM_BASE_PATH . "includes/classes/class.downloader.php";
            }




            elseif(strtolower($split[0]) == 'email_') {
                unset($split[0]);
                $file = KSM_BASE_PATH . "includes/Email/".  ksm_camelcase_to_underscored(implode('', $split)).".php";
            }
            elseif(strtolower($split[0]) == 'notification_') {
                unset($split[0]);
                $file = KSM_BASE_PATH . "includes/Notification/".  ksm_camelcase_to_underscored(implode('', $split)).".php";
            }

            else {
                $file = KSM_BASE_PATH . "includes/classes/class.".  strtolower(implode('', $split)).".php";

            }


            if(strtolower(substr($class, 0, 19)) == 'ksm_rest_controller') {
                $file = KSM_LIB_PATH . "Rest/" . strtolower($split[2]) . ".php";
            }



            if(!is_file($file)) {
                $file = KSM_BASE_PATH . "includes/classes/class.".  strtolower($name).".php";
            }


            //echo $class . " | " . $file . "<br>";

            if(is_file($file)) {
                require_once $file;
            }

        }



    }



    public function login_success_redirect($response, $userdata) {
        $response['redirect_to'] = site_url().'/studio';
        return $response;
    }

    //public function my_enqueue_scripts() {
    //    if (function_exists('wp_tiny_mce')) wp_tiny_mce();
    //}

	//displays ksm admin menu in wordpress admin dashboard
    public function admin_menu() {

        $parent_slug = 'ksm';
        $menus[] = array('Settings', 'settings');
        $menus[] = array('Artists', 'artists');



        add_menu_page( "Kitmoda", "Kitmoda", 'administrator', $parent_slug, '', KSM_BASE_URL.'images/icons/kitmoda-tiny.png' );

        foreach ($menus as $m) {
            add_submenu_page( 'ksm', $m[0], $m[0], "administrator", $parent_slug.'_'.$m[1] ,array($this, $parent_slug.'_'.$m[1]));
        }
    }

	//Gets Artists Menu Page
    public function ksm_artists() {
        include 'admin/artists/index.php';
    }

	//Gets Settings Menu Page
    public function ksm_settings() {
        include 'admin/settings.php';
    }

    //Updates KSM user sales
    public function ksm_update_user_sales($download_id, $b, $c, $d) {
        ksm_update_user_sales($download_id, $d);
        ksm_update_user_top_selling($download_id);
    }

	//Count KSM product Statistics
    public function count_product_stats($post_id) {

        $p = get_post($post_id);
        if($p->post_type == 'download' && $p->post_author) {
            update_user_meta($p->post_author, 'products_count', KSM_Stats::count_user_products($p->post_author));
        }



    }


    //Activates KSM Plugin
    public function activate() {
        require_once 'admin/install.php';
        $install = new KSM_Install();
        $install->init();
    }

	//Deactivates KSM Plugin
    public function deactivate() {
        require_once 'admin/uninstall.php';
        $uninstall = new KSM_unInstall();
        $uninstall->init();
    }





    //Loads required CSS and JS
    public function enqueue_style() {

        add_thickbox();

        if (!is_front_page())
            ksm_enqueue_style('ksm_style', trailingslashit(KSM_BASE_URL).'css/style.css');


        wp_enqueue_script('tinymce', includes_url().'js/tinymce/tinymce.min.js');




        wp_enqueue_script('plupload-all');
        wp_enqueue_script( 'jquery-ui-sortable' );

        wp_enqueue_script('jquery-auto-complete', trailingslashit(KSM_BASE_URL).'js/jquery.auto-complete.min.js', array('jquery'));




        if (!is_front_page())
            wp_enqueue_style('google-roboto','http://fonts.googleapis.com/css?family=Roboto|Montserrat');


        if(is_page(ksm_get_page_id('page-edit_profile')) ||
           is_page(ksm_get_page_id('page-following')) ||
           is_page(ksm_get_page_id('page-compose')) ||
           is_page(ksm_get_page_id('page-settings')) ||
           is_page(ksm_get_page_id('page-favorites')) ||
           is_page(ksm_get_page_id('page-top_selling')) ||
           is_page(ksm_get_page_id('page-add_wip'))
           ) {
            $popup = true;
        }

        $mod_obj = '';
        //if(is_page(ksm_get_page_id('tab-collaboration'))) {
        //    wp_enqueue_style('collab_css', trailingslashit(KSM_BASE_URL).'css/collab.css');
        //    wp_enqueue_script('collab_js', trailingslashit(KSM_BASE_URL).'js/jquery.kcollab.js');
        //    $mod_obj = 'kcoll';
        //}


        if(is_page(ksm_get_page_id('page-add_wip'))) {
            wp_enqueue_script('ksm_wip-script', trailingslashit(KSM_BASE_URL).'js/wip.js', array('jquery'));
        }


        //if(is_page(ksm_get_page_id('page-publisher'))) {
        //    wp_enqueue_style('publisher-css', trailingslashit(KSM_BASE_URL).'css/publisher.css');
        //    wp_enqueue_script('kpub_js', trailingslashit(KSM_BASE_URL).'js/jquery.kpub.js', array('jquery-ui-sortable', 'ksm_scripts', 'ksm_s3_uploader_js'));
        //    $mod_obj = 'kp';
        //}






        wp_enqueue_script('ksm_colorbox-js', trailingslashit(KSM_BASE_URL).'js/jquery.colorbox.js', array('ksm_scripts'));
        ksm_enqueue_style('ksm_colorbox-style', trailingslashit(KSM_BASE_URL).'css/colorbox.css');

        //if(is_page(ksm_get_page_id('page-edit_profile'))) {
        //    wp_enqueue_script('ksm_avatar', trailingslashit(KSM_BASE_URL).'js/avatar.js', array('jquery'));
        //    wp_enqueue_script('ksm_jquery_caret-js', trailingslashit(KSM_BASE_URL).'js/jquery.caret.min.js');
            //wp_enqueue_script('ksm_tag-editor-js', trailingslashit(KSM_BASE_URL).'js/jquery.tag-editor.min.js', array('jquery', 'jquery-ui-sortable', 'jquery-ui-autocomplete'));
        //    wp_enqueue_style('ksm_tag-editor-style', trailingslashit(KSM_BASE_URL).'css/jquery.tag-editor.css');

        //}









        wp_enqueue_script('ksm_s3_uploader_js', trailingslashit(KSM_BASE_URL).'js/s3_uploader.js', array('jquery', 'ksm_scripts', 'jquery-ui-draggable','jquery-ui-droppable'));



        //wp_enqueue_script('plugins-js', trailingslashit(KSM_BASE_URL).'js/plugins.js', array('jquery'));
        //wp_enqueue_script('scripts-js', trailingslashit(KSM_BASE_URL).'js/scripts.js', array('jquery'));
        //wp_enqueue_style('s-gallery-style', trailingslashit(KSM_BASE_URL).'css/s-gallery.css');



        wp_enqueue_script('ksm_scripts', trailingslashit(KSM_BASE_URL).'js/functions.js', array('jquery', 'ksm_jquery_uri', 'slick-js'));

        wp_enqueue_script('slick-js', trailingslashit(KSM_BASE_URL).'js/slick/slick.js', array('jquery'));

        // wp_enqueue_script('kmvg-js', trailingslashit(KSM_BASE_URL).'js/jquery.kmvg.js', array('jquery'));
        ksm_enqueue_style('slick-style', trailingslashit(KSM_BASE_URL).'js/slick/slick.css');

        wp_enqueue_script('tooltipster-js', trailingslashit(KSM_BASE_URL).'js/jquery.tooltipster.js', array('jquery'));
        ksm_enqueue_style('tooltipster-style', trailingslashit(KSM_BASE_URL).'css/tooltipster.css');




        wp_enqueue_script('ksm_jquery_uri', trailingslashit(KSM_BASE_URL).'js/jquery.uri.js', array('jquery'));



        wp_enqueue_script("jquery-effects-core");


        //wp_enqueue_script('justifiedGallery-js', trailingslashit(KSM_BASE_URL).'js/justifiedGallery.js', array('jquery'));
        //wp_enqueue_style('justifiedGallery-style', trailingslashit(KSM_BASE_URL).'css/justifiedGallery.min.css');



        wp_enqueue_style('icheck-css', trailingslashit(KSM_BASE_URL).'js/icheck/skins/futurico/futurico.css');
        wp_enqueue_script('icheck-js', trailingslashit(KSM_BASE_URL).'js/icheck/icheck.js');

        if($popup) {
            wp_enqueue_script('ksm_pp-script', trailingslashit(KSM_BASE_URL).'js/pp.js', array('jquery'));
        }


        wp_enqueue_script('angular', trailingslashit(KSM_BASE_URL).'js/angular/angular.min.js');
        wp_enqueue_script('angular-resource.min', trailingslashit(KSM_BASE_URL).'js/angular/angular-resource.min.js');
        wp_enqueue_script('angular-animate.min', trailingslashit(KSM_BASE_URL).'js/angular/angular-animate.min.js');


        wp_enqueue_script('angular-messages.min', trailingslashit(KSM_BASE_URL).'js/angular/angular-messages.min.js');


        wp_enqueue_script('components-common', trailingslashit(KSM_BASE_URL).'js/components/common.js');


        wp_enqueue_script('ui-bootstrap-tpls-1.1.1.min', trailingslashit(KSM_BASE_URL).'js/ui-bootstrap-tpls-1.1.1.min.js');


        wp_enqueue_style('bootstrap.min', trailingslashit(KSM_BASE_URL).'css/bootstrap.min.css');






        wp_enqueue_style('animation-css', trailingslashit(KSM_BASE_URL).'css/animate.css');



        wp_enqueue_script( 'password-strength-meter' );

        //wp_enqueue_script( 'jquery-ui-draggable' );
        //wp_enqueue_script( 'jquery-ui-droppable' );

        $settings = array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'share_page' => home_url("share/"),
            'home_url' => home_url(),
            'ksm_url' => KSM_BASE_URL,
            'kmod' => $mod_obj,


            'auth_user' =>
                array(
                    'id' => KSM_Action::AuthID(),
                    'logged_in' => get_current_user_id() ? true : false,
                    'user' => array(
                        'id' => get_current_user_id(),
                    )
                ),


            'rest' => array(
                'nonce' => wp_create_nonce( 'wp_rest' ),
                'api_base' => KSM_API_URL,
                'access_key' => KSM_Action::StudioID(),
                'partials' => KSM_PARTIALS_URL,
            ),
            'recaptcha_site_key' => RECAPTCHA_SITE_KEY,
            'plu' => array(
                    'file_data_name'      => 'async-upload',
                    'url'                 => admin_url( 'async-upload.php', 'relative' ),
                    'flash_swf_url'       => includes_url( 'js/plupload/plupload.flash.swf' ),
                    'silverlight_xap_url' => includes_url( 'js/plupload/plupload.silverlight.xap' ),
                )

            );


        wp_localize_script('ksm_scripts', 'ksm_settings', $settings);




    }


    //Include required files
    public function includes() {
        require_once 'includes/config.php';


        require_once 'includes/functions.php';
        require_once 'admin/cron.php';
        require_once 'admin/patch.php';

        require_once 'includes/class-templates.php';

        //require_once 'admin/post-types/message.php';
        //require_once 'admin/post-types/wip.php';
        //require_once 'admin/post-types/wall_post.php';
        //require_once 'admin/post-types/collaboration.php';
        //require_once 'admin/post-types/collaboration_join_request.php';
        //require_once 'admin/post-types/community.php';

        //require_once 'admin/taxonomies.php';
        require_once 'admin/rewrite.php';
        require_once 'includes/hooks.php';
    }







    //Delete Post attachment from S3 Bucket

    public function delete_attachment_handler($attachment_id) {

        $attachment = get_post($post_id);


        KSM_S3::deleteObject($attachment->s3_file_key);

    }


}
}
//Initialize Plugin by creating instance of class
new kitmoda_Social_Media();
