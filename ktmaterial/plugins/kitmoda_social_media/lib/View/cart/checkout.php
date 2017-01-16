
<div class="checkout_main">
    <div class="checkout_main_inner">
        <div class="header">
            <div class="inner">
                <div class="heading">PAYMENT</div>
                
                <div class="clr"></div>
            </div>
            
        </div>
        <div class="community_sidebar_linebreak_dark"></div>
        <div class="community_sidebar_linebreak"></div>
        
        
        <?php if(!get_current_user_id()) : ?>
            <div class="auth_section">
                <a ng-click="auth('login', 'checkout')">Login</a>
            </div>
        <?php endif; ?>

<?php



	global $edd_options, $user_ID, $post;

	$payment_mode = edd_get_chosen_gateway();
	$form_action  = esc_url( edd_get_checkout_uri( 'payment-mode=' . $payment_mode ) );

	
		echo '<div id="edd_checkout_wrap">';
		if ( edd_get_cart_contents() || edd_cart_has_fees() ) :

			//edd_checkout_cart();
?>
			<div id="edd_checkout_form_wrap" class="edd_clearfix">
				<?php do_action( 'edd_before_purchase_form' ); ?>
				<form id="edd_purchase_form" class="edd_form" action="<?php echo $form_action; ?>" method="POST">
					<?php
					do_action( 'edd_checkout_form_top' );

					if ( edd_show_gateways() ) {
						do_action( 'edd_payment_mode_select'  );
					} else {
						//do_action( 'edd_purchase_form' );
                                                $this->render_element('checkout-form');
					}

					do_action( 'edd_checkout_form_bottom' )
					?>
				</form>
				<?php do_action( 'edd_after_purchase_form' ); ?>
			</div><!--end #edd_checkout_form_wrap-->
		<?php
		else:
			do_action( 'edd_cart_empty' );
		endif;
		echo '</div><!--end #edd_checkout_wrap-->';
?>	
                        
                        
                        <div class="tc_note">By placing this order you are agreeing to Kitmoda’s Terms of Use and Copyright Policy.</div>
    </div>
</div>