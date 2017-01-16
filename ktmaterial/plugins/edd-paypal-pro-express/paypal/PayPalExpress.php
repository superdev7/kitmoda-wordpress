<?php
class PayPalExpressGateway extends PayPalFunctions {

  protected $_purchase_data;

  public function purchase_data($data) {
    $this->_purchase_data = $data;
  }

  public function retrieve_token() {

    $ppfunctions = new PayPalFunctions();

    $ppfunctions->api_end_point($this->_purchase_data['api_end_point']);

    $cart_details = $this->_purchase_data['cart_details'];
    $items        = array();

    foreach( $cart_details as $c ) {

      $item_data   = array(
        'name'     => html_entity_decode( $c['name'], ENT_COMPAT, 'UTF-8' ),
        'amount'   => $c['price'],
        'number'   => $c['item_number'],
        'quantity' => 1
      );

      $items[]     = $c['price'];

      $ppfunctions->new_item( $item_data );

    }

    if( ! empty( $this->_purchase_data['fees'] ) ) {
      foreach( $this->_purchase_data['fees'] as $fee ) {

        $item_data   = array(
          'name'     => html_entity_decode( $fee['label'], ENT_COMPAT, 'UTF-8' ),
          'amount'   => $fee['amount'],
          'quantity' => 1
        );

        $items[]     = $fee['amount'];

        $ppfunctions->new_item( $item_data );

      }
    }

    $total_amount = $this->_purchase_data['price'];
    $item_total   = array_sum( $items );
    $tax          = $this->_purchase_data['tax'];
    $discount     = $this->_purchase_data['discount_amount'];

    if( $item_total > $total_amount) {

      $item_data = array(
        'name' => __('Discount', 'eppe'),
        'amount' => 0 - $discount,
        'number' => $this->_purchase_data['discount'],
        'quantity' => 1
      );
      $items[] = 0 - $discount;

      $ppfunctions->new_item($item_data);

      $item_total = array_sum( $items );
    }

    $lang = substr( $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2 );

    if(  defined( 'ICL_LANGUAGE_CODE' ) ) {

      switch ( ICL_LANGUAGE_CODE ) {
        // WPML is active so use its language code
        case "fr":
          $locale = 'FR';
          break;
        case "it":
          $locale = 'IT';
          break;
        case "de":
          $locale = 'DE';
          break;
        default:
          $locale = 'US';
          break;
      }

    } else {

      switch ( $lang ) {
        // use browser language code
        case "fr":
          $locale = 'FR';
          break;
        case "it":
          $locale = 'IT';
          break;
        case "de":
          $locale = 'DE';
          break;
        default:
          $locale = 'US';
          break;
      }

    }

    $paypal_data = array(
      'USER' => $this->_purchase_data['credentials']['api_username'],
      'PWD' => $this->_purchase_data['credentials']['api_password'],
      'SIGNATURE' => $this->_purchase_data['credentials']['api_signature'],
      'VERSION' => 86,
      'METHOD' => 'SetExpressCheckout',
      'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
      'LANDINGPAGE' => 'Billing',
      'SOLUTIONTYPE' => 'Sole',
      'NOSHIPPING' => 1,
      'RETURNURL' => $this->_purchase_data['urls']['return_url'],
      'CANCELURL' => $this->_purchase_data['urls']['cancel_url'],
      'LOCALECODE' => $locale,
      'PAYMENTREQUEST_0_CURRENCYCODE' => $this->_purchase_data['currency_code'],
      'PAYMENTREQUEST_0_AMT' => $total_amount,
     // 'PAYMENTREQUEST_0_TAXAMT' => $tax,
      'PAYMENTREQUEST_0_ITEMAMT' => $item_total,
      'PAYMENTREQUEST_0_SHIPPINGAMT' => 0,
      'PAYMENTREQUEST_0_CUSTOM' => $this->_purchase_data['payment_id'],
      'PAYMENTREQUEST_0_SHIPTONAME' => $this->_purchase_data['first_name'] . ' ' . $this->_purchase_data['last_name'],
      'PAYMENTREQUEST_0_SHIPTOSTREET' => $this->_purchase_data['address1'],
      'PAYMENTREQUEST_0_SHIPTOSTREET2' => $this->_purchase_data['address2'],
      'PAYMENTREQUEST_0_SHIPTOCITY' => $this->_purchase_data['city'],
      'PAYMENTREQUEST_0_SHIPTOSTATE' => $this->_purchase_data['state'],
      'PAYMENTREQUEST_0_SHIPTOZIP' => $this->_purchase_data['zip'],
      'PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE' => $this->_purchase_data['country'],
      'EMAIL' => $this->_purchase_data['email'],
      'FIRSTNAME' => $this->_purchase_data['first_name'],
      'LASTNAME' => $this->_purchase_data['last_name']
    );

    $ppfunctions->request_fields( $paypal_data );

    $response = $ppfunctions->paypal_query();

    return $response;
  }

  public function express_checkout_details($token) {
    $token = urlencode($token);
    $ppfunctions = new PayPalFunctions();
    $ppfunctions->api_end_point($this->_purchase_data['api_end_point']);
    $ppfunctions->request_fields(array(
      'USER' => $this->_purchase_data['credentials']['api_username'],
      'PWD' => $this->_purchase_data['credentials']['api_password'],
      'SIGNATURE' => $this->_purchase_data['credentials']['api_signature'],
      'VERSION' => 86
    ));
    $response = $ppfunctions->get_express_token_details($token);
    return $response;
  }

  public function express_checkout( $token, $payer_id, $amount, $item_total, $tax, $currency ) {
    $token = urlencode($token);
    $ppfunctions = new PayPalFunctions();
    $ppfunctions->api_end_point($this->_purchase_data['api_end_point']);

    $data =  array(
      'USER' => $this->_purchase_data['credentials']['api_username'],
      'PWD' => $this->_purchase_data['credentials']['api_password'],
      'SIGNATURE' => $this->_purchase_data['credentials']['api_signature'],
      'VERSION' => 86,
      'METHOD' => 'DoExpressCheckoutPayment',
      'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
      'TOKEN' => $token,
      'PAYERID' => $payer_id,
      'BUTTONSOURCE' => 'ArmorlightComputers_SP',
      'PAYMENTREQUEST_0_AMT' => number_format($amount, 2, '.', ''),
      'PAYMENTREQUEST_0_ITEMAMT' => number_format($item_total, 2, '.', ''),
      'PAYMENTREQUEST_0_SHIPPINGAMT' => 0,
      'PAYMENTREQUEST_0_TAXAMT' => $tax,
      'PAYMENTREQUEST_0_CURRENCYCODE' => $currency
    );

    $ppfunctions->request_fields( $data );
    $response = $ppfunctions->paypal_query();
    return $response;
  }

  public function get_purchase_id_by_token( $token ) {

    global $wpdb;

    $purchase = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_edd_ppe_token' AND meta_value = %s LIMIT 1", $token ) );

    if ( $purchase != NULL )
      return $purchase;

    return 0;
  }

}