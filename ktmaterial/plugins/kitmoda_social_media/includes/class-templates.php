<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}




class KSM_Template {

    
    
	static function templates_dir() {
            return KSM_VIEWS_PATH;
	}
        
        static function include_element($name) {
            
            $file = KSM_VIEWS_PATH . '__elements/' . str_replace('.', '/', $name) . '.php';
            if(is_file($file)) {
                return $file;
            }
            
            
        }
	
        
        
	
	static function templates_url() {
            return KSM_BASE_URL . 'templates';
	}
	
	
	static function template_include( $template ) {
            global $post_type;
            
            if($GLOBALS['k_controller']) {
                $GLOBALS['k_controller']->render();
                exit;
            }
            //pr($GLOBALS['k_controller']);
            //pr($GLOBALS['ksm_controller']);
            
            /*
            if(is_single() && $post_type == 'download' && !is_admin()) {
                $template = self::templates_dir() . 'Store_Product.php';
            }
            
            
            if($post_type == 'ksm_wall_post' && is_archive()) {
                $template = self::templates_dir() . 'studio.php';
            }
            elseif(is_page(ksm_get_page_id('tab-community'))) {
                $template = self::templates_dir() . 'community.php';
            }
            
            elseif(is_page(ksm_get_page_id('tab-collaboration'))) {
                $template = self::templates_dir() . 'collaboration.php';
            }
            
            
            elseif(is_page(ksm_get_page_id('page-edit_profile'))) {
                $template = self::templates_dir() . 'edit_profile.php';
            } elseif(is_page(ksm_get_page_id('tab-studio'))) {
                
            } elseif(is_page(ksm_get_page_id('page-following'))) {
                if($_POST['action']=='jspaging') {
                    echo do_shortcode('[ksm_profile_following]');
                    exit;
                }
                $template = self::templates_dir() . 'dynamic_popup.php';
            } elseif(is_page(ksm_get_page_id('page-compose'))) {
                $template = self::templates_dir() . 'dynamic_popup.php';
            } elseif(
                    is_page(ksm_get_page_id('page-settings')) || 
                    is_page(ksm_get_page_id('page-add_wip')) ||
                    is_page(ksm_get_page_id('page-share')) || 
                    is_page(ksm_get_page_id('page-publisher'))
                    ) {
                
                $template = self::templates_dir() . 'dynamic_popup.php';
            }
            
            elseif(is_page(ksm_get_page_id('page-favorites'))) {
                
                if($_POST['action']=='jspaging') {
                    echo do_shortcode('[ksm_profile_favorites]');
                    exit;
                }
                $template = self::templates_dir() . 'dynamic_popup_dark.php';
                
            } elseif(is_page(ksm_get_page_id('page-top_selling'))) {
                
                if($_POST['action']=='jspaging') {
                    echo do_shortcode('[ksm_profile_top_selling]');
                    exit;
                }
                $template = self::templates_dir() . 'dynamic_popup_dark.php';
                
            }
            
            */
            
            return $template;
        }
}


