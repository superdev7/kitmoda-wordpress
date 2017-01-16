<?php

class KSM_CartController extends KSM_BaseController {
    
    
    
    public $scripts = array(
        array('cart', array('jquery', 'ksm_scripts')),
        
        array('selectbox/jquery.selectbox-0.2.min', array('jquery', 'ksm_scripts'))
    );
    
    public $styles = array('selectbox/jquery.selectbox');
    
    
    

    
    
    public function ksm_index() {
        $this->layout = "cart";
        $cart_items    = edd_get_cart_contents();
        $this->set('cart_items', $cart_items);
    }
    
    
    public function ksm_checkout() {
        $this->layout = "cart";
        
        /*
        if(!get_current_user_id()) {
            wp_redirect(ksm_get_permalink('login'));
            exit;
        }
        */
        
    }
    
    public function ksm_ajax_purchase_form() {
        $this->render_element('checkout-form');
    }
    
    
    public function ksm_purchase_confirmation() {
        
        $this->layout = 'cart';
        
        global $edd_receipt_args;
        
        

	

	$session = edd_get_purchase_session();
	if ( isset( $_GET[ 'payment_key' ] ) ) {
            $payment_key = urldecode( $_GET[ 'payment_key' ] );
	} elseif ( $edd_receipt_args['payment_key'] ) {
            $payment_key = $edd_receipt_args['payment_key'];
	} else if ( $session ) {
            $payment_key = $session[ 'purchase_key' ];
	}

        
        
        if($payment_key) {
            
            $payment_id = edd_get_purchase_id_by_key( $payment_key );
            
            
            
            
            
            
            
            
            //$this->render_element('purchase_library_product_item', array('pd' => $pd));
            
            
            
            
            $items = KSM_Purchased_Download::get_from_payment($payment_id);
            
            
            
            $customer_id              = edd_get_payment_user_id( $payment_id );
            
            $user_can_view = ( is_user_logged_in() && $customer_id == get_current_user_id() ) || ( ( $customer_id == 0 || $customer_id == '-1' ) && ! is_user_logged_in() && edd_get_purchase_session() ) || current_user_can( 'view_shop_sensitive_data' );

            if ($user_can_view ) {
                $payment   = get_post( $payment_id);
                $meta      = edd_get_payment_meta( $payment->ID );
                $cart      = edd_get_payment_meta_cart_details( $payment->ID, true );
                $user      = edd_get_payment_meta_user_info( $payment->ID );
                $email     = edd_get_payment_user_email( $payment->ID );
                $status    = edd_get_payment_status( $payment, true );
                
                
                
                
                $user_id = edd_get_payment_user_id($payment_id);
                
                if($user_id) {
                    $ksm_user = KSM_User::get($user_id);
                    
                    if($ksm_user) {
                        $this->set('user_login', $ksm_user->user_login);
                    }
                }
                
            }
        }
	
	
        $ksm_payment = KSM_Payment::get($payment_id);
        
        
        if(!$payment || !$cart) {
            $this->set('error', 'Sorry, trouble retrieving payment receipt.');
        } else {
            $this->set('payment', $payment);
            $this->set('meta', $meta);
            $this->set('cart', $cart);
            $this->set('user', $user);
            $this->set('email', $email);
            $this->set('status', $status);
            $this->set('items', $items);
            
            $this->set('ksm_payment', $ksm_payment);
        }
    }
    
    
}
?>