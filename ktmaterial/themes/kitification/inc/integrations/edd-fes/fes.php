<?php
/**
 * Easy Digital Downloads - Frontend Form Submission
 *
 * @package Kitification
 */

/**
 * Change the reCAPTCHA color scheme.
 *
 * @since Kitification 1.2.0
 */
function kitification_edd_fes_recaptcha() {
?>
	<script type="text/javascript">
		var RecaptchaOptions = {
			theme : 'clean',
		};
	</script>
<?php
}
add_action( 'wp_head', 'kitification_edd_fes_recaptcha' );

/**
 * Remove FES Styles
 *
 * @since Kitification 1.0
 *
 * @return void
 */
function kitification_edd_fes_enqueue_scripts() {
	wp_dequeue_style( 'fes-css' );
}
add_action( 'wp_enqueue_scripts', 'kitification_edd_fes_enqueue_scripts' );

/**
 * FES Vendor Dashboard Menu
 *
 * @since Kitification 1.0
 *
 * @param array $menu
 * @return array $menu
 */
function kitification_edd_fes_vendor_dashboard_menu( $menu ) {
	if ( EDD_FES()->integrations->is_commissions_active() ) {
		$menu[ 'earnings' ][ 'icon' ] = 'graph';
	}

	$menu[ 'home' ][ 'icon' ] = 'house';
	$menu[ 'orders' ][ 'icon' ] = 'ticket';
	$menu[ 'logout' ][ 'icon' ] = 'logout';

	return $menu;
}
add_filter( 'fes_vendor_dashboard_menu', 'kitification_edd_fes_vendor_dashboard_menu' );

function kitification_header_outer_image_fes( $background ) {
	global $wp_query;

	if ( ! is_page_template( 'page-templates/vendor.php' ) ) {
		return $background;
	}

	$vendor = isset( $wp_query->query_vars[ 'vendor' ] ) ? $wp_query->query_vars[ 'vendor' ] : null;

	if ( ! $vendor ) {
		return $background;
	}

	$vendor = new WP_User( $vendor );

	$image = get_user_meta( $vendor->ID, 'cover_image', true );
	$image = wp_get_attachment_image_src( $image, 'fullsize' );

	if ( is_array( $image ) ) {
		return $image;
	}

	return $background;
}
add_filter( 'kitification_header_outer_image', 'kitification_header_outer_image_fes', 1 );