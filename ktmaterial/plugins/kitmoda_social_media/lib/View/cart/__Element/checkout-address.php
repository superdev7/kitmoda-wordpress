<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$logged_in = is_user_logged_in();

if( $logged_in ) {
	$user_address = get_user_meta( get_current_user_id(), '_edd_user_address', true );
}
$line1 = $logged_in && ! empty( $user_address['line1'] ) ? $user_address['line1'] : '';
$line2 = $logged_in && ! empty( $user_address['line2'] ) ? $user_address['line2'] : '';
$city  = $logged_in && ! empty( $user_address['city']  ) ? $user_address['city']  : '';
$zip   = $logged_in && ! empty( $user_address['zip']   ) ? $user_address['zip']   : '';
?>
<fieldset id="edd_cc_address" class="cc-address">
	<legend>Card Billing Address</legend>
        <div class="fields">
            
            <?php do_action( 'edd_cc_billing_top' ); ?>
	<p id="edd-card-address-wrap">
		<label for="card_address" class="edd-label">
                    Address
                    <span class="edd-description">Credit Card Billing Address.</span>
                </label>
		
		<input type="text" id="card_address" name="card_address" class="card-address edd-input<?php if( edd_field_is_required( 'card_address' ) ) { echo ' required'; } ?>" placeholder="<?php _e( 'Address line 1', 'edd' ); ?>" value="<?php echo $line1; ?>"/>
	</p>
	<p id="edd-card-address-2-wrap">
		<label for="card_address_2" class="edd-label">
			Address Line 2
			<span class="edd-description">(OPTIONAL - The Apartment, Suite, Floor, Building, Ect.)</span>
		</label>
		
		<input type="text" id="card_address_2" name="card_address_2" class="card-address-2 edd-input<?php if( edd_field_is_required( 'card_address_2' ) ) { echo ' required'; } ?>" placeholder="<?php _e( 'Address line 2', 'edd' ); ?>" value="<?php echo $line2; ?>"/>
	</p>
	<p id="edd-card-city-wrap">
		<label for="card_city" class="edd-label">
			City
			<span class="edd-description">(Credit Card Billing City)</span>
		</label>
		
		<input type="text" id="card_city" name="card_city" class="card-city edd-input<?php if( edd_field_is_required( 'card_city' ) ) { echo ' required'; } ?>" placeholder="<?php _e( 'City', 'edd' ); ?>" value="<?php echo $city; ?>"/>
	</p>
	<p id="edd-card-zip-wrap">
		<label for="card_zip" class="edd-label">
			Zip / Postal Code
			<span class="edd-description">(Credit Card Billing zip or postal code)</span>
		</label>
		
		<input type="text" size="4" name="card_zip" class="card-zip edd-input<?php if( edd_field_is_required( 'card_zip' ) ) { echo ' required'; } ?>" placeholder="<?php _e( 'Zip / Postal code', 'edd' ); ?>" value="<?php echo $zip; ?>"/>
	</p>
	<p id="edd-card-country-wrap">
		<label for="billing_country" class="edd-label">
                    Country
                    <span class="edd-description">(Credit Card Billing Country)</span>
		</label>
		
		<select name="billing_country" id="billing_country" class="billing_country edd-select<?php if( edd_field_is_required( 'billing_country' ) ) { echo ' required'; } ?>">
			<?php

			$selected_country = edd_get_shop_country();

			if( $logged_in && ! empty( $user_address['country'] ) && '*' !== $user_address['country'] ) {
				$selected_country = $user_address['country'];
			}

			$countries = edd_get_country_list();
			foreach( $countries as $country_code => $country ) {
			  echo '<option value="' . esc_attr( $country_code ) . '"' . selected( $country_code, $selected_country, false ) . '>' . $country . '</option>';
			}
			?>
		</select>
	</p>
	<p id="edd-card-state-wrap">
		<label for="card_state" class="edd-label">
                    State / Province
                    <span class="edd-description">(Credit Card Billing State or Province)</span>
		</label>
		
    <?php
    $selected_state = edd_get_shop_state();
    $states         = edd_get_shop_states( $selected_country );

    if( $logged_in && ! empty( $user_address['state'] ) ) {
			$selected_state = $user_address['state'];
		}

    if( ! empty( $states ) ) : ?>
    <select name="card_state" id="card_state" class="card_state edd-select<?php if( edd_field_is_required( 'card_state' ) ) { echo ' required'; } ?>">
        <?php
            foreach( $states as $state_code => $state ) {
                echo '<option value="' . $state_code . '"' . selected( $state_code, $selected_state, false ) . '>' . $state . '</option>';
            }
        ?>
    </select>
	<?php else : ?>
		<input type="text" size="6" name="card_state" id="card_state" class="card_state edd-input" placeholder="<?php _e( 'State / Province', 'edd' ); ?>"/>
		<?php endif; ?>
	</p>
	<?php do_action( 'edd_cc_billing_bottom' ); ?>
            
        </div>
</fieldset>
	
