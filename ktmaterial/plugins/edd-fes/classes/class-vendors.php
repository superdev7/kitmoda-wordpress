<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class FES_Vendors {
	function __construct() {
		add_action( 'admin_init', array(
				$this,
				'fes_prevent_admin_access'
			), 1000 );
		add_filter( 'show_admin_bar' , array(
				$this,
				'hide_admin_bar'
		), 99999 );
		add_filter( 'edd_user_can_view_receipt', array( $this, 'vendor_can_view_receipt' ), 10, 2 );
		add_filter( 'edd_user_can_view_receipt_item', array( $this, 'vendor_can_view_receipt_item' ), 10, 2 );
	}
	public function hide_admin_bar( $bool ){

		if ( is_admin() ){
			return $bool;
		}

		// This setting is reversed. ! removed means it is removed. Stupid.
		if( ! EDD_FES()->helper->get_option( 'fes-remove-admin-bar', false ) ) {
			if( EDD_FES()->vendors->vendor_is_vendor( get_current_user_id(), true, true ) && ! EDD_FES()->vendors->vendor_is_admin() ) {
				$bool = false;
			}
		}

		return $bool;
	}
	public static function get_vendor_store_url_dashboard( $user = false ) {
		if ( is_numeric( $user ) ) {
			$user = new WP_User( $user );
		}
		if ( ! $user || ! is_object( $user ) ) {
			$user = new WP_User( get_current_user_id() );
		}
		$vendor_url = EDD_FES()->vendors->get_vendor_store_url( $user );
		return sprintf( __( ' Your store url is: %s', 'edd_fes' ), '<a href="' . esc_url( $vendor_url ) . '">' . $vendor_url . '</a>' );
	}
	public static function get_vendor_store_url( $user = false ) {

		if ( !is_object( $user ) ){
			if ( $user === false ){
				$user = get_current_user_id();
			}
			$user = new WP_User( $user );
		}

		if ( !$user || !is_object( $user ) ) {
			$user = new WP_User( get_current_user_id() );
		}

		$archive_page = EDD_FES()->vendors->use_author_archives();
		$name = get_userdata( $user->ID );
		$user_nicename = apply_filters( 'fes_user_nicename_to_lower' , strtolower( $name->user_nicename ), $user );

		if ( empty( $archive_page ) ) {

			$vendor_url = get_permalink( EDD_FES()->helper->get_option( 'fes-vendor-page', '' ) );
			$permalink = apply_filters( 'fes_adjust_vendor_url', untrailingslashit( 'vendor/' ) );
			$vendor_url = str_replace( 'fes-vendor/', $permalink, $vendor_url );
			$vendor_url = str_replace( 'vendor/', $permalink, $vendor_url );

			if( get_option( 'permalink_structure' ) ) {

				$vendor_url = trailingslashit( $vendor_url ) . $user_nicename;

			} else {

				$vendor_url = add_query_arg( 'vendor', $user_nicename, $vendor_url );

			}

		} else {

			$vendor_url = get_author_posts_url( $user->ID, $user_nicename );

		}

		return $vendor_url;
	}

	public function fes_prevent_admin_access() {
		if ( EDD_FES()->helper->get_option( 'fes-allow-backend-access', false ) ) {
			return;
		}

		if (
			// Look for the presence of /magento-help/ in the url
			stripos( $_SERVER[ 'REQUEST_URI' ], '/magento-help/' ) !== false &&
			// Allow calls to async-upload.php
			stripos( $_SERVER[ 'REQUEST_URI' ], 'async-upload.php' ) == false &&
			// Allow calls to media-upload.php
			stripos( $_SERVER[ 'REQUEST_URI' ], 'media-upload.php' ) == false &&
			// Allow calls to admin-ajax.php
			stripos( $_SERVER[ 'REQUEST_URI' ], 'admin-ajax.php' ) == false ) {
				if ( EDD_FES()->vendors->vendor_is_vendor() && !EDD_FES()->vendors->vendor_is_admin() ) {
					wp_redirect( get_permalink( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ) ) );
					exit();
				}
		}
	}

	/**
	 * Checks whether the ID provided is vendor capable or not
	 * This method is deprecated. Use the one in the vendor permissions class instead.
	 * Will be removed in 2.3.
	 *
	 * @param int     $user_id
	 * @return bool
	 */
	public static function is_vendor( $user_id ) {
		$bool      = user_can( 'frontend_vendor', $user_id ) ? true : false;
		return apply_filters( 'fes_is_vendor', $bool, $user_id );
	}

	/**
	 * Checks whether the ID provided is admin capable or not
	 * This method is deprecated. Use the one in the vendor permissions class instead.
	 * Will be removed in 2.3.
	 *
	 * @param int     $user_id
	 * @return bool
	 */
	public static function is_admin( $user_id ) {
		$bool      = user_can( 'fes_is_admin', $user_id ) ? true : false;
		return apply_filters( 'fes_is_admin', $bool, $user_id );
	}

	/**
	 * Grabs the vendor ID whether a username or an int is provided
	 * and returns the vendor_id if it's actually a vendor
	 * This method is deprecated. Use the one in the vendor permissions class instead.
	 * Will be removed in 2.1.
	 *
	 * @param unknown $input
	 * @return unknown
	 */
	public static function get_vendor_id( $input ) {
		$int_vendor = (int) $input;
		$vendor     = !empty( $int_vendor ) ? get_userdata( $input ) : get_user_by( 'login', $input );
		if ( !$vendor )
			return false;
		$vendor_id = $vendor->ID;
		if ( self::is_vendor( $vendor_id ) ) {
			return $vendor_id;
		} else {
			return false;
		}
	}

	public static function is_pending( $user_id = -2 ) {
		if ( $user_id == -2 ){
			$user_id = get_current_user_id();
		}
		$user       = get_userdata( $user_id );
		$roles      = ! empty( $user->roles ) ? (array) $user->roles : array();
		$is_pending = in_array( 'pending_vendor', $roles );
		return $is_pending;
	}

	public function vendor_can_view_receipt( $user_can_view, $edd_receipt_id ) {
		if ( ! $edd_receipt_id ){
			return false;
		}

		$payment_id = ! empty( $_GET['order_id'] ) ? absint( $_GET['order_id'] ) : false;

		if( $payment_id ) {

			$cart = edd_get_payment_meta_cart_details( $payment_id );

			foreach ( $cart as $item ) {
				$item = get_post( $item[ 'id' ] );

				if ( $item->post_author == get_current_user_id() ) {
					$user_can_view = true;

					break;
				}
			}

		}

		return $user_can_view;
	}

	public function vendor_can_view_receipt_item( $user_can_view, $item ) {

		if( is_user_logged_in() && ! ( current_user_can( 'manage_shop_reports' ) || $this->vendor_is_admin() ) && $this->is_vendor( get_current_user_id() ) ) {

			$download = get_post( $item[ 'id' ] );
			if ( (int) $download->post_author !== (int) get_current_user_id() ) {
				$user_can_view = false;
			}

		}

		return $user_can_view;
	}

	public function vendor_is_author( $post_id = false, $user_id = false ){
		if ( $post_id == false || $user_id == false ){
			return false;
		}
		else{
			$download = get_post( $post_id ) ;
			if ( (int) $download->post_author !== (int) $user_id ) {
				return false;
			}
			else{
				return true;
			}
		}
	}

	public function get_product_constant_name( $plural = false, $uppercase = true ){
		$constant = EDD_FES()->helper->get_option( 'fes-plugin-constants', array() );
		// Products
		if ( $plural && $uppercase ){
			$constant = ( isset( $constant[5] ) && $constant[5] != '' ) ? $constant[5] : __('Products', 'edd_fes');
			$constant = apply_filters( 'fes_product_constant_plural_uppercase', $constant );
			return $constant;
		}
		// products
		else if ( $plural){
			$constant = ( isset( $constant[7] ) && $constant[7] != '' ) ? $constant[7] : __('products', 'edd_fes');
			$constant = apply_filters( 'fes_product_constant_plural_lowercase', $constant );
			return $constant;
		}
		// Product
		else if( !$plural && $uppercase ){
			$constant = ( isset( $constant[6] ) && $constant[6] != '' ) ? $constant[6] : __('Product', 'edd_fes');
			$constant = apply_filters( 'fes_product_constant_singular_uppercase', $constant );
			return $constant;
		}
		// product
		else{
			$constant = ( isset( $constant[8] ) && $constant[8] != '' ) ? $constant[8] : __('product', 'edd_fes');
			$constant = apply_filters( 'fes_product_constant_singular_lowercase', $constant );
			return $constant;
		}
	}

	public function get_vendor_constant_name( $plural = false, $uppercase = true ){
		$constant = EDD_FES()->helper->get_option( 'fes-plugin-constants', array() );
		// Vendors
		if ( $plural && $uppercase ){
			$constant = ( isset( $constant[1] ) && $constant[1] != '' ) ? $constant[1] : __('Vendors', 'edd_fes');
			$constant = apply_filters( 'fes_vendor_constant_plural_uppercase', $constant );
			return $constant;
		}
		// vendors
		else if ( $plural){
			$constant = ( isset( $constant[3] ) && $constant[3] != '' ) ? $constant[3] : __('vendors', 'edd_fes');
			$constant = apply_filters( 'fes_vendor_constant_plural_lowercase', $constant );
			return $constant;
		}
		// Vendor
		else if( !$plural && $uppercase ){
			$constant = ( isset( $constant[2] ) && $constant[2] != '' ) ? $constant[2] : __('Vendor', 'edd_fes');
			$constant = apply_filters( 'fes_vendor_constant_singular_uppercase', $constant );
			return $constant;
		}
		// vendor
		else{
			$constant = ( isset( $constant[4] ) && $constant[4] != '' ) ? $constant[4] : __('vendor', 'edd_fes');
			$constant = apply_filters( 'fes_vendor_constant_singular_lowercase', $constant );
			return $constant;
		}
	}

	function vendor_can_create_product( $user_id = -2 ) {
		if ( $user_id == -2 ) {
			$user_id = get_current_user_id();
		}

		if ( !EDD_FES()->helper->get_option( 'fes-allow-vendors-to-create-products', true ) ){
			return false;
		}

		if ( EDD_FES()->vendors->vendor_is_vendor( $user_id ) ) {
			return true;
		} else {
			return false;
		}
	}

	public function vendor_can_edit_product( $post_id ) {
		if ( !EDD_FES()->helper->get_option( 'fes-allow-vendors-to-edit-products', true ) ){
			return false;
		}
		$user_id = get_current_user_id();
		$post = get_post( $post_id, ARRAY_A);
		if ( EDD_FES()->vendors->vendor_is_vendor( $user_id )  && (EDD_FES()->vendors->vendor_is_admin( $user_id ) || $post['post_author'] == $user_id) ){
			return true;
		}
		else {
			return false;
		}
	}

	public function vendor_can_delete_product( $post_id ) {
		if ( !EDD_FES()->helper->get_option( 'fes-allow-vendors-to-delete-products', true ) ){
			return false;
		}
		$user_id = get_current_user_id();
		$post = get_post( $post_id, ARRAY_A);
		if ( EDD_FES()->vendors->vendor_is_vendor( $user_id )  && (EDD_FES()->vendors->vendor_is_admin( $user_id ) || $post['post_author'] == $user_id) ){
			return true;
		}
		else {
			return false;
		}
	}

	public function vendor_can_view_order( $post_id ) {
		if ( !EDD_FES()->helper->get_option( 'fes-allow-vendors-to-view-orders', false ) ){
			return false;
		}
		$user_id = get_current_user_id();
		if ( EDD_FES()->vendors->vendor_is_vendor( $user_id ) || EDD_FES()->vendors->vendor_is_admin( $user_id ) ){
			return edd_FES()->vendors->vendor_can_view_receipt(false, $post_id );
		}
		else {
			return false;
		}
	}

	public function vendor_can_view_orders() {
		if ( !EDD_FES()->helper->get_option( 'fes-allow-vendors-to-view-orders', false ) ){
			return false;
		}
		$user_id = get_current_user_id();
		if ( EDD_FES()->vendors->vendor_is_vendor( $user_id ) || EDD_FES()->vendors->vendor_is_admin( $user_id ) ){
			return true;
		}
		else {
			return false;
		}
	}

	// Let's make some magic
	public function vendor_is_vendor( $user_id = -2, $pending = false, $suspended = false ) {
		if ( $user_id == -2 ) {
			$user_id = get_current_user_id();
		}
		if ( $user_id == 0 ) {
			// This is a logged out user, since get_current_user_id returns 0 for non logged in
			// since we can't do anything with them, lets get them out of here. They aren't vendors.
			return false;
		}
		$user = new WP_User( $user_id );
		// This allows devs to take what would normally be a vendor and say they aren't a vendor.
		$bool = false;
		$bool = apply_filters( 'fes_skip_is_vendor', $bool, $user );
		// Note to developers: I passed in the entire user object above.
		// So expect either an object (logged in user) or false (not logged in user).
		if ( $bool ) {
			return false;
		}
		// Authentication Attempt #1: okay let's try caps
		// $vendor_caps = array ( 'fes_is_vendor', 'fes_is_admin');
		// $vendor_caps = apply_filters('fes_vendor_caps', $vendor_caps);
		if ( user_can( $user_id, 'frontend_vendor' ) || user_can( $user_id, 'fes_is_admin' ) ) {
			return true;
		}

		if ( $pending && user_can( $user_id, 'pending_vendor' ) ){
			return true;
		}

		if ( $suspended && user_can( $user_id, 'suspended_vendor' ) ){
			return true;
		}

		// Authentication Attempt #2:  maybe a developer has a reason for wanting to hook a user in?
		$bool = false;
		$bool = apply_filters( 'fes_is_vendor_check_override', $bool, $user );
		// Note to developers: I passed in the entire user object above.
		// So expect either an object (logged in user) or false (not logged in user).
		if ( $bool ) {
			return true;
		}
		// end of the line
		return false;
	}

	public function vendor_is_admin( $user_id = -2 ) {
		if ( $user_id == -2 ) {
			$user_id = get_current_user_id();
		}
		if ( $user_id == 0 ) {
			// This is a logged out user, since get_current_user_id returns 0 for non logged in
			// since we can't do anything with them, lets get them out of here. They aren't vendors.
			return false;
		}
		$user = new WP_User( $user_id );
		// This allows devs to take what would normally be a vendor and say they aren't a vendor.
		$bool = false;
		$bool = apply_filters( 'fes_skip_is_admin', $bool, $user );
		// Note to developers: I passed in the entire user object above.
		// So expect either an object (logged in user) or false (not logged in user).
		if ( $bool ) {
			return false;
		}
		// Authentication Attempt #1: okay let's try caps
		// $vendor_caps = array ( 'fes_is_vendor', 'fes_is_admin');
		// $vendor_caps = apply_filters('fes_vendor_caps', $vendor_caps);
		if ( user_can( $user->ID, 'fes_is_admin' ) ||  user_can( $user->ID, 'manage_shop_settings' ) ) {
			return true;
		}

		// Authentication Attempt #2:  maybe a developer has a reason for wanting to hook a user in?
		$bool = false;
		$bool = apply_filters( 'fes_is_admin_check_override', $bool, $user );
		// Note to developers: I passed in the entire user object above.
		// So expect either an object (logged in user) or false (not logged in user).
		if ( $bool ) {
			return true;
		}
		// end of the line
		return false;
	}

	// User id if present/logged in
	// $ref is the url we want to bring the user back to if applicable
	public function vendor_not_a_vendor_redirect( $user_id = -2 ) {
		// lets try the grab user_id trick
		if ( $user_id == -2 ) {
			$user_id = get_current_user_id();
		}
		if ( $user_id == 0 ) {
			// This is a logged out user, since get_current_user_id returns 0 for non logged in
			// So let's log them in, and then attempt redirect to ref
			$base_url = get_permalink( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ) );
			$base_url = add_query_arg( 'view', 'login-register', $base_url );
			wp_redirect( $base_url );
			exit;
		} else {
			$user = new WP_User( $user_id );
			if ( current_user_can( 'pending_vendor' ) ) {
				// are they a pending vendor: display not approved display
				$base_url = get_permalink( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ) );
				$base_url = add_query_arg( 'user_id', $user_id, $base_url );
				$base_url = add_query_arg( 'view', 'pending', $base_url );
				wp_redirect( $base_url );
				exit;
			} else {
				// are they not a vendor yet: show registration page
				$base_url = get_permalink( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ) );
				$base_url = add_query_arg( 'user_id', $user_id, $base_url );
				$base_url = add_query_arg( 'view', 'application', $base_url );
				wp_redirect( $base_url );
				exit;
			}
		}
	}

	// WARNING: FUNCTION NOT IN USE. It's for 2.3. Don't use it yet.
	public function vendor_not_enough_permissions( $user_id = -2, $ref = -2 ) {
		// lets try the grab user_id trick
		if ( $user_id == -2 ) {
			$user_id = get_current_user_id();
		}
		if ( $ref == -2 ) {
			$ref = wp_get_referer();
			if ( $ref == false ) {
				$ref = 'unknown page';
			}
		}
		// lets also log this
		//fes_simple_log( $logname = 'Vendor Access Denied Log', $text = "User $user_id, attempted to access $ref and was denied", $severity = 3 );
		$base_url = get_permalink( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ) );
		add_query_arg( 'ref', $ref, $base_url );
		add_query_arg( 'user_id', $user_id, $base_url );
		add_query_arg( 'view', 'pending', $base_url );
		wp_redirect( $base_url );
		exit;
	}

		public function get_pending_products( $user_id = false ) {
		global $wpdb;
		global $current_user;
		if ( !$user_id ){
			$user_id = $user_id;
		}
		$vendor_products = array();
		$vendor_products = get_posts( array(
				'nopaging' => true,
				'author' => $user_id,
				'orderby' => 'title',
				'post_type' => 'download',
				'post_status' => 'pending',
				'order' => 'ASC'
			) );
		if ( empty( $vendor_products ) ) {
			return false;
		}
		foreach ( $vendor_products as $product ) {
			$data[] = array(
				'ID' => $product->ID,
				'date' => $product->post_date,
				'title' => $product->post_title,
				'url' => esc_url( get_permalink( $product->ID ) ),
				'sales' => edd_get_download_sales_stats( $product->ID )
			);
		}
		$data = apply_filters('fes_get_pending_products', $data, $user_id );
		return $data;
	}

	public function get_published_products( $user_id = false ) {
		global $wpdb;
		global $current_user;
		if ( !$user_id ){
			$user_id = $current_user->ID;
		}
		$vendor_products = array();
		$vendor_products = get_posts( array(
				'nopaging' => true,
				'author' => $user_id,
				'orderby' => 'title',
				'post_type' => 'download',
				'post_status' => 'publish',
				'order' => 'ASC'
			) );
		if ( empty( $vendor_products ) ) {
			return false;
		}
		foreach ( $vendor_products as $product ) {
			$data[] = array(
				'ID' => $product->ID,
				'date' => $product->post_date,
				'title' => $product->post_title,
				'url' => esc_url( get_permalink( $product->ID ) ),
				'sales' => edd_get_download_sales_stats( $product->ID )
			);
		}
		$data = apply_filters('fes_get_published_products', $data, $user_id );
		return $data;
	}
	public function get_all_products( $user_id = false, $status = array( 'draft', 'pending', 'publish', 'trash', 'future', 'private' ) ) {
		global $wpdb;
		global $current_user;
		if ( !$user_id ){
			$user_id = $current_user->ID;
		}
		$vendor_products = array();
		$vendor_products = get_posts( array(
				'nopaging' => true,
				'author' => $user_id,
				'orderby' => 'title',
				'post_type' => 'download',
				'post_status' => $status,
				'order' => 'ASC'
			) );
		if ( empty( $vendor_products ) ) {
			return false;
		}
		foreach ( $vendor_products as $product ) {
			$data[] = array(
				'ID' => $product->ID,
				'title' => $product->post_title,
				'status' => $product->post_status,
				'url' => esc_url( admin_url( 'post.php?post='.$product->ID.'&action=edit' ) ),
				'sales' => edd_get_download_sales_stats( $product->ID )
			);
		}
		$data = $this->array_msort( $data, array( 'status'=>SORT_ASC, 'title'=> SORT_ASC, 'sales' => SORT_DESC, 'ID' => SORT_ASC, 'url'=> SORT_ASC ) );
		$data = apply_filters('fes_get_all_products', $data, $user_id );
		return $data;
	}

	function array_msort( $array, $cols ) {
		$colarr = array();
		foreach ( $cols as $col => $order ) {
			$colarr[$col] = array();
			foreach ( $array as $k => $row ) { $colarr[$col]['_'.$k] = strtolower( $row[$col] ); }
		}
		$eval = 'array_multisort(';
		foreach ( $cols as $col => $order ) {
			$eval .= '$colarr[\''.$col.'\'],'.$order.',';
		}
		$eval = substr( $eval, 0, -1 ).');';
		eval( $eval );
		$ret = array();
		foreach ( $colarr as $col => $arr ) {
			foreach ( $arr as $k => $v ) {
				$k = substr( $k, 1 );
				if ( !isset( $ret[$k] ) ) $ret[$k] = $array[$k];
				$ret[$k][$col] = $array[$k][$col];
			}
		}
		return $ret;

	}

	public function get_products( $user_id, $post_status = false ) {
		global $wpdb;

		$products = array();

		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		$allowed_statuses = array( 'publish', 'draft', 'pending', 'future' );

		if( empty( $post_status ) || ! in_array( $post_status, $allowed_statuses ) ) {
			$post_status = array( 'publish', 'draft', 'pending', 'future' );
		}


		$args = array(
			'author' => $user_id,
			'post_type' => 'download',
			'post_status' => $post_status,
			'posts_per_page' => 10,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'paged' => $paged
		);

		$args = apply_filters( 'fes_get_products_args', $args );

		$products = get_posts( $args );

		if ( empty( $products ) ) {
			return array();
		}

		$data = apply_filters( 'fes_get_products_data', $products );
		return $data;
	}

	public function get_all_products_count( $user_id, $status ) {
		$products = $this->get_all_products( $user_id, $status );

		return !empty($products) ? count($products) : 0;
	}

	public function get_all_orders( $user_id = 0, $status = array() ) {
		$published_products = EDD_FES()->vendors->get_published_products( $user_id );
		if (!$published_products){
			return array();
		}
		$published_products = wp_list_pluck( $published_products, 'ID' );

		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		$args = array(
			'download' => $published_products,
			'output'   => 'edd_payment',
			'mode'     => 'all',
			'posts_per_page' => 10,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'paged' => $paged
		);
		$args = apply_filters( 'fes_get_all_orders_args', $args );

		$payments = edd_get_payments( $args );

		if ( ! $payments ) {
			return array();
		}

		// nothing fancy with this for now
		return $payments;
	}

	public function get_all_orders_count( $user_id, $status ) {
		return count( $this->get_all_orders( $user_id, $status ) );
	}

	public function use_author_archives(){
		
		/*
		 * This option was deprecated in FES 2.2.10 per https://github.com/chriscct7/edd-fes/issues/504
		 */

		return false;
	}

	public function can_see_login(){
		if ( !is_user_logged_in() ){
			return true;
		}
		else{
			return false;
		}
	}

	public function can_see_registration(){
		if ( !EDD_FES()->vendors->is_pending( ) && !EDD_FES()->vendors->vendor_is_vendor() && ( EDD_FES()->helper->get_option( 'fes-allow-registrations', true ) || EDD_FES()->helper->get_option( 'fes-allow-applications', true ) )  ){
			return true;
		}
		else{
			return false;
		}

	}

	public function combo_form_count(){
		if ( EDD_FES()->vendors->can_see_registration() && EDD_FES()->vendors->can_see_login() ){
			return 2;
		}
		if ( EDD_FES()->vendors->can_see_registration() || EDD_FES()->vendors->can_see_login() ){
			return 1;
		}
		else{
			return 0;
		}
	}

	public function get_avatar( $hook_name = '', $id_or_email = 0 , $size = 96 , $default = '' , $alt = false ){
		if ( $id_or_email == 0 ){
			$id_or_email = get_current_user_id();
		}

		$id_or_email = apply_filters( 'fes_get_avatar_id_or_email_' . $hook_name , $id_or_email );
		$size        = apply_filters( 'fes_get_avatar_size_' . $hook_name , $size );
		$default     = apply_filters( 'fes_get_avatar_id_or_email_' . $hook_name , $default );
		$alt         = apply_filters( 'fes_get_avatar_alt_' . $hook_name , $alt );
		$avatar      = apply_filters( 'fes_get_avatar', get_avatar( $id_or_email, $size, $default, $alt ) );

		return apply_filters( 'fes_get_avatar_' . $hook_name, $avatar, $id_or_email, $size, $default, $alt );

	}
}
