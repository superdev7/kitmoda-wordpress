<?php


add_filter( 'edd_is_checkout', 'ksm_edd_is_checkout' , 11, 1);
function ksm_edd_is_checkout($is_checkout) {
    
    
    $params = ksm_route_params();
    if($params['controller'] == 'cart' && $params['action'] == 'checkout')  {
        return true;
    }
    
    return false;
    
}





remove_action( 'edd_purchase_form', 'edd_show_purchase_form' );
add_action( 'edd_purchase_form', 'ksm_edd_show_purchase_form' );
function ksm_edd_show_purchase_form() {
    $dispatcher = KSM_MvcDispatcher::get_instance();
    $dispatcher->dispatch_ajax(array('is_ajax' => true, 'controller' => 'cart', 'action' => 'purchase_form'));
}


add_action( 'wp_enqueue_scripts', 'ksm_checkout_scripts_change');
function ksm_checkout_scripts_change() {
    
    wp_dequeue_script('edd-ajax');
    wp_deregister_script( 'edd-ajax' );
 
    
    wp_enqueue_script('edd-ajax', trailingslashit(KSM_BASE_URL).'js/edd-ajax.js', array('jquery'));
    wp_localize_script( 'edd-ajax', 'edd_scripts', array(
				'ajaxurl'                 => edd_get_ajax_url(),
				'position_in_cart'        => isset( $position ) ? $position : -1,
				'already_in_cart_message' => __('You have already added this item to your cart', 'edd'), // Item already in the cart message
				'empty_cart_message'      => __('Your cart is empty', 'edd'), // Item already in the cart message
				'loading'                 => __('Loading', 'edd') , // General loading message
				'select_option'           => __('Please select an option', 'edd') , // Variable pricing error with multi-purchase option enabled
				'ajax_loader'             => EDD_PLUGIN_URL . 'assets/images/loading.gif', // Ajax loading image
				'is_checkout'             => edd_is_checkout() ? '1' : '0',
				'default_gateway'         => edd_get_default_gateway(),
				'redirect_to_checkout'    => ( edd_straight_to_checkout() || edd_is_checkout() ) ? '1' : '0',
				'checkout_page'           => edd_get_checkout_uri(),
                                'cart_page'               => ksm_get_permalink('cart'),
				'permalinks'              => get_option( 'permalink_structure' ) ? '1' : '0',
			));
            
}

?>