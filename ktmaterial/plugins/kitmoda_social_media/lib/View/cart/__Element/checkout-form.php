<?php


global $edd_options;

	$payment_mode = edd_get_chosen_gateway();

	do_action( 'edd_purchase_form_top' );

	if ( edd_can_checkout() ) {

		do_action( 'edd_purchase_form_before_register_login' );

		$show_register_form = edd_get_option( 'show_register_form', 'none' ) ;
		if( ( $show_register_form === 'registration' || ( $show_register_form === 'both' && ! isset( $_GET['login'] ) ) ) && ! is_user_logged_in() ) : ?>
			<div id="edd_checkout_login_register">
				<?php do_action( 'edd_purchase_form_register_fields' ); ?>
			</div>
		<?php elseif( ( $show_register_form === 'login' || ( $show_register_form === 'both' && isset( $_GET['login'] ) ) ) && ! is_user_logged_in() ) : ?>
			<div id="edd_checkout_login_register">
				<?php do_action( 'edd_purchase_form_login_fields' ); ?>
			</div>
		<?php endif; ?>

		<?php if( ( !isset( $_GET['login'] ) && is_user_logged_in() ) || ! isset( $edd_options['show_register_form'] ) || 'none' === $show_register_form ) {
			//do_action( 'edd_purchase_form_after_user_info' );
                        $this->render_element('checkout-user_info');
		}

		do_action( 'edd_purchase_form_before_cc_form' );

		if( edd_get_cart_total() > 0 ) {

			// Load the credit card form and allow gateways to load their own if they wish
			if ( has_action( 'edd_' . $payment_mode . '_cc_form' ) ) {
				do_action( 'edd_' . $payment_mode . '_cc_form' );
			} else {
				//do_action( 'edd_cc_form' );
                            $this->render_element('checkout-cc-form');
			}

		}
                
                
                $this->render_element('checkout_submit');
		//do_action( 'edd_purchase_form_after_cc_form' );
                
	} else {
		// Can't checkout
		do_action( 'edd_purchase_form_no_access' );
	}

	do_action( 'edd_purchase_form_bottom' );
        
        
        
        
?>


