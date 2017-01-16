

<?php do_action( 'edd_before_cc_fields' ); ?>

<fieldset id="edd_cc_fields" class="edd-do-validate">
	<legend>PAYMENT INFO</legend>
        
        <div class="section_info">Please provide accurate details to recieve your purchase information</div>
        
        <div class="fields">
            
            <?php if( is_ssl() ) : ?>
                    <div id="edd_secure_site_wrapper">
                            <span class="padlock"></span>
                            <span><?php _e( 'This is a secure SSL encrypted payment.', 'edd' ); ?></span>
                    </div>
            <?php endif; ?>
            <p id="edd-card-number-wrap">
                    <label for="card_number" class="edd-label">
                            Card Number
                            <span class="edd-description">(16 digits)</span>
                            <span class="card-type"></span>
                    </label>
                    <input type="text" autocomplete="off" name="card_number" id="card_number" class="card-number edd-input required" placeholder="<?php _e( 'Card number', 'edd' ); ?>" />
            </p>
            <p id="edd-card-cvc-wrap">
                    <label for="card_cvc" class="edd-label">
                        CVC
                        <span class="edd-description">(3 digit code on back of card or 4 digit code on the front)</span>
                    </label>
                    
                    <input type="text" size="4" autocomplete="off" name="card_cvc" id="card_cvc" class="card-cvc edd-input required" placeholder="<?php _e( 'Security code', 'edd' ); ?>" />
            </p>
            <p id="edd-card-name-wrap">
                    <label for="card_name" class="edd-label">
                        Name on Card
                        <span class="edd-description">(As seen on the front of card)</span>
                    </label>
                    
                    <input type="text" autocomplete="off" name="card_name" id="card_name" class="card-name edd-input required" placeholder="<?php _e( 'Card name', 'edd' ); ?>" />
            </p>
            <?php do_action( 'edd_before_cc_expiration' ); ?>
            <p class="card-expiration">
                    <label for="card_exp_month" class="edd-label">
                        Expiration
                        <span class="edd-description">Month - Year</span>
                    </label>
                    
                    <select id="card_exp_month" name="card_exp_month" class="card-expiry-month edd-select edd-select-small required">
                        <?php 
                        for( $i = 1; $i <= 12; $i++ ) { 
                            echo '<option value="' . $i . '">' . sprintf ('%02d', $i ) . '</option>'; 
                        } 
                        ?>
                    </select>
                    
                    <select id="card_exp_year" name="card_exp_year" class="card-expiry-year edd-select edd-select-small required">
                        <?php 
                        for( $i = date('Y'); $i <= date('Y') + 10; $i++ ) { 
                            echo '<option value="' . $i . '">' . substr( $i, 2 ) . '</option>'; 
                        } 
                        ?>
                    </select>
            </p>
            <?php do_action( 'edd_after_cc_expiration' ); ?>
            
        </div>

</fieldset>
<?php

$this->render_element('checkout-address');
//do_action( 'edd_after_cc_fields' );

