<?php


remove_filter( 'epap_adaptive_receivers', 'eddc_paypal_adaptive_autopay', 8);
remove_action( 'edd_update_payment_status', 'eddc_record_commission', 10);




add_filter( 'epap_adaptive_receivers', 'ksm_eddc_paypal_adaptive_autopay', 8, 2 );
add_action( 'edd_update_payment_status', 'ksm_eddc_record_commission', 10, 3 );


function ksm_eddc_get_recipient_rate($rate, $download_id, $user_id) {
    
    $download = KSM_Download::get($download);
    
    if($download)  {
        if($download->isCollaboration() && $download->is_partner($user_id)) {
            $rate = $download->partner_commission($user_id);
        }
    }
    return $rate;
}

add_filter( 'eddc_get_recipient_rate', 'ksm_eddc_get_recipient_rate', 30, 3);


function ksm_eddc_get_recipients( $download_id = 0, $payment_id ) {
    
    
    
    $download = new KSM_Download($download_id);
    
    $settings = get_post_meta( $download_id, '_edd_commission_settings', true );
    $recipients = array_map( 'trim', explode( ',', $settings['user_id'] ) );
    
    if($download) {
        
        $payment_user_id = edd_get_payment_user_id($payment_id);
        if($download->isCollaboration() && $download->is_partner($payment_user_id)) {
            $_recipients = array();
            foreach($recipients as $r) {
                if($r != $payment_user_id) {
                    $_recipients[] = $r;
                }
            }
            $recipients = $_recipients;
        }
    }
    
    
    return (array) apply_filters( 'eddc_get_recipients', $recipients, $download_id );
    
    
}


function ksm_eddc_paypal_adaptive_autopay( $receivers, $payment_id ) {

	if( ! edd_get_option( 'edd_commissions_autopay_pa' ) ) {
		return $receivers;
	}

	$cart  = edd_get_payment_meta_cart_details( $payment_id );
	if ( 'subtotal' == edd_get_option( 'edd_commissions_calc_base', 'subtotal' ) ) {
		$total = edd_get_payment_subtotal( $payment_id );
	} else {
		$total = edd_get_payment_amount( $payment_id );
	}

	$final = array();

	foreach ( $cart as $item ) {

		$recipients = ksm_eddc_get_recipients( $item['id'], $payment_id );
		
		if ( 'subtotal' == edd_get_option( 'edd_commissions_calc_base', 'subtotal' ) ) {

			$price = $item['subtotal'];

		} else {
		
			$price = $item['price'];

		}

		foreach ( $recipients as $recipient ) {

			$type          = eddc_get_commission_type( $item['id'] );
			$rate          = eddc_get_recipient_rate( $item['id'], $recipient );
			$args          = array(
				'price'       => $price,
				'rate'        => $rate,
				'type'        => $type,
				'download_id' => $item['id'],
				'recipient'   => $recipient,
				'payment_id'  => $payment_id
			);

			$amount        = eddc_calc_commission_amount( $args );
			$percentage    = round( ( 100 / $total ) * $amount, 2 );
			$user          = get_userdata( $recipient );
			$custom_paypal = get_user_meta( $recipient, 'eddc_user_paypal', true );
			$email         = is_email( $custom_paypal ) ? $custom_paypal : $user->user_email;

			if ( $percentage !== 0 ) {
				if ( isset( $final[ $email ] ) ) {
					$final[ $email ] = $percentage + $final[ $email ];
				} else {
					$final[ $email ] = $percentage;
				}
			}
		}
	}

	$return  = '';
	$counter = 0;
	$taken   = 0;

	// Add up the total commissions
	foreach ( $final as $person => $val ) {
		$taken = $taken + $val;
	}

	// Calculate the final percentage the store owners should receive

	$remaining = 100 - $taken;
	$owners    = $receivers;
	$owners    = explode( "\n", $owners );

	foreach ( $owners as $key => $val ) {

		$val        = explode( '|', $val );
		$email      = $val[0];
		$percentage = $val[1];
		$remainder  = ( $percentage / 100 ) * $remaining;

		if ( isset( $final[ $email ] ) ) {
			$final[ $email ] = $final[ $email ] + $remainder;
		} else {
			$final[ $email ] = $remainder;
		}

	}

	// Rebuild the final PayPal receivers string
	foreach ( $final as $person => $val ) {

		if ( $counter === 0) {
			$return = $person . "|" . $val;
		} else {
			$return = $return . "\n" . $person . "|" . $val;
		}
		$counter++;

	}

	//echo '<pre>'; print_r( $return ); echo '</pre>'; exit;

	return $return;
}



function ksm_eddc_record_commission( $payment_id, $new_status, $old_status ) {

	// Check if the payment was already set to complete
	if( $old_status == 'publish' || $old_status == 'complete' )
		return; // Make sure that payments are only completed once

	// Make sure the commission is only recorded when new status is complete
	if( $new_status != 'publish' && $new_status != 'complete' )
		return;

	if( edd_get_payment_gateway( $payment_id ) == 'manual_purchases' && ! isset( $_POST['commission'] ) )
		return; // do not record commission on manual payments unless specified

	$payment_data  	= edd_get_payment_meta( $payment_id );
	$user_info   	= maybe_unserialize( $payment_data['user_info'] );
	$cart_details  	= edd_get_payment_meta_cart_details( $payment_id );

	// loop through each purchased download and award commissions, if needed
	foreach ( $cart_details as $download ) {

		$download_id    		= absint( $download['id'] );
		$commissions_enabled  	= get_post_meta( $download_id, '_edd_commisions_enabled', true );

		if ( 'subtotal' == edd_get_option( 'edd_commissions_calc_base', 'subtotal' ) ) {

			$price = $download['subtotal'];

		} else {

			if ( 'total_pre_tax' == edd_get_option( 'edd_commissions_calc_base', 'subtotal' ) ) {
	
				$price = $download['price'] - $download['tax'];

			} else {

				$price = $download['price'];
	
			}


		}

		if( ! empty( $download['fees'] ) ) {
			foreach( $download['fees'] as $fee ) {
				$price += $fee['amount'];
			}
		}

		// if we need to award a commission, and the price is greater than zero
		if ( $commissions_enabled && floatval( $price ) > '0' ) {

			// set a flag so downloads with commissions awarded are easy to query
			update_post_meta( $download_id, '_edd_has_commission', true );

			$commission_settings = get_post_meta( $download_id, '_edd_commission_settings', true );

			if ( $commission_settings ) {

				$type = eddc_get_commission_type( $download_id );

				// but if we have price variations, then we need to get the name of the variation
				if ( edd_has_variable_prices( $download_id ) ) {
					$price_id = edd_get_cart_item_price_id ( $download );
					$variation = edd_get_price_option_name( $download_id, $price_id );
				}


				$recipients = ksm_eddc_get_recipients( $download_id, $payment_id );

				// Record a commission for each user
				foreach( $recipients as $recipient ) {

					$rate           	= eddc_get_recipient_rate( $download_id, $recipient );    // percentage amount of download price
					$args               = array(
						'price'         => $price,
						'rate'          => $rate,
						'type'          => $type,
						'download_id'   => $download_id,
						'recipient'     => $recipient,
						'payment_id'    => $payment_id
					);

					$commission_amount 	= eddc_calc_commission_amount( $args ); // calculate the commission amount to award
					$currency    		= $payment_data['currency'];

					$commission = array(
						'post_type'  	=> 'edd_commission',
						'post_title'  	=> $user_info['email'] . ' - ' . get_the_title( $download_id ),
						'post_status'  	=> 'publish'
					);

					$commission_id = wp_insert_post( apply_filters( 'edd_commission_post_data', $commission ) );

					$commission_info = apply_filters( 'edd_commission_info', array(
						'user_id'  	=> $recipient,
						'rate'   	=> $rate,
						'amount'  	=> $commission_amount,
						'currency'  => $currency
					), $commission_id, $payment_id, $download_id );

					eddc_set_commission_status( $commission_id, 'unpaid' );

					update_post_meta( $commission_id, '_edd_commission_info', $commission_info );
					update_post_meta( $commission_id, '_download_id', $download_id );
					update_post_meta( $commission_id, '_user_id', $recipient );
					update_post_meta( $commission_id, '_edd_commission_payment_id', $payment_id );
					//if we are dealing with a variation, then save variation info
					if ( isset( $variation ) ) {
						update_post_meta( $commission_id, '_edd_commission_download_variation', $variation );
					}

					do_action( 'eddc_insert_commission', $recipient, $commission_amount, $rate, $download_id, $commission_id, $payment_id );
				}
			}
		}
	}
}