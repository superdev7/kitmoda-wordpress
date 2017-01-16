<?php 
if (!isset($_GET['order_id'])){
	_e('Access Denied','edd_fes');
	return;
}

$key = edd_get_payment_key( $_GET['order_id']);

if (EDD_FES()->vendors->vendor_can_view_receipt(false, $key)){
	do_action('fes_above_vendor_receipt');
	echo '<h1 class="fes-headers" id="fes-edit-order-page-title">'.__('Order: #','edd_fes').$_GET['order_id'].'</h1>';
	echo do_shortcode('[edd_receipt payment_key='. $key .']');
	do_action('fes_below_vendor_receipt');
}
else{
	_e('Access Denied','edd_fes');
}