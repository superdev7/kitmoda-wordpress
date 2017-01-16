<fieldset id="edd_purchase_submit">
    
    
    
    

    <?php edd_checkout_hidden_fields(); ?>

    <div class="edd_purchase_submit_inner">
        <?php echo edd_checkout_button_purchase(); ?>

        <p id="edd_final_total_wrap">
            <strong>Purchase Total</strong>
            <span class="edd_cart_amount" data-subtotal="<?=edd_get_cart_subtotal()?>" data-total="<?=edd_get_cart_subtotal()?>"><?=edd_cart_total()?></span>
        </p>
    </div>
    <div class="clr"></div>

    <?php do_action( 'edd_purchase_form_after_submit' ); ?>

    <?php if ( edd_is_ajax_disabled() ) { ?>
	<p class="edd-cancel"><a href="javascript:history.go(-1)"><?php _e( 'Go back', 'edd' ); ?></a></p>
    <?php } ?>
</fieldset>