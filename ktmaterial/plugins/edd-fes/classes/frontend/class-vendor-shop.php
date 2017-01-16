<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class FES_Vendor_Shop {

	public function __construct() {

		add_action( 'pre_get_posts', array( $this, 'vendor_download_query' ) );
		add_action( 'the_content', array( $this, 'content' ), 10 );
		add_filter( 'init', array( $this, 'add_rewrite_rules' ),0 );
		add_action( 'query_vars', array( $this, 'query_vars' ), 0 );
		add_filter( 'the_title',  array( $this, 'change_the_title' ) );
		add_filter( 'save_post', array( $this, 'vendor_page_updated' ), 10, 1 );
		add_action( 'admin_init', array( $this, 'after_vendor_page_update' ), 10 );

	}

	public function content($content) {

		$has_shortcode = false;

		if( function_exists( 'has_shortcode' ) ) {
			$has_shortcode = has_shortcode( $content, 'downloads' );
		}

		if ( $this->get_queried_vendor() && ! $has_shortcode ) {
			return do_shortcode( '[downloads]' );
		} else {
			return $content;
		}

	}

	public function query_vars( $query_vars ) {
		$query_vars[] = 'vendor';
		return $query_vars;
	}

	public function add_rewrite_rules() {

		if ( ! EDD_FES()->helper->get_option( 'fes-vendor-page', false ) ) {
			return;
		}

		$page_id   = EDD_FES()->helper->get_option( 'fes-vendor-page', false );
		$page      = get_page( $page_id );
		$page_name = ! empty( $page->post_name ) ? $page->post_name : EDD_FES()->vendors->get_vendor_constant_name( false, false );
		$permalink = apply_filters( 'fes_adjust_vendor_url', untrailingslashit( $page_name ) );

		// Remove beginning slash
		if ( substr( $permalink, 0, 1 ) == '/' ) {
			$permalink = substr( $permalink, 1, strlen( $permalink ) );
		}

		//add_rewrite_rule( $permalink . '/([^/]+)', 'index.php?page_id=' . $page_id . '&vendor=$matches[1]', 'top' );

		add_rewrite_rule("{$page_name}/([^/]+)/page/?([2-9][0-9]*)", "index.php?page_id={$page_id}&vendor=\$matches[1]&paged=\$matches[2]", 'top');
		add_rewrite_rule("{$page_name}/([^/]+)", "index.php?page_id={$page_id}&vendor=\$matches[1]", 'top');
	}

	/**
	 * Retrieves the currently displayed vendor
	 *
	 * This is used when display a vendor's store page
	 *
	 * @since 2.2.10
	 * @return object|false WP User Object or false
	 */
	public function get_queried_vendor() {

		$user   = false;
		$vendor = get_query_var( 'vendor' );

		if( ! empty( $vendor ) ) {

			if( is_numeric( $vendor ) ) {

				$user = get_userdata( absint( $vendor ) );

			} else {

				$user = get_user_by( 'slug', $vendor );

			}

		}

		return $user;
	}

	public function vendor_download_query( $query ) {

		global $post;

		if ( is_admin() ) {
			return;
		}

		if ( $this->get_queried_vendor() ) {
			add_filter( 'edd_downloads_query', array(
				$this,
				'set_shortcode'
			) );
		}
	}

	public function set_shortcode( $query ) {

		$vendor = $this->get_queried_vendor();

		if( $vendor ) {

			$query[ 'author' ] = $vendor->ID;

		}

		return $query;
	}

	public function change_the_title( $title ) {

		if( ! in_the_loop() || is_admin() ) {
			return $title;
		}

		$vendor = $this->get_queried_vendor();

		if( ! $vendor ) {
			return $title;
		}

		$vendor_page = EDD_FES()->helper->get_option( 'fes-vendor-page', false );

		if ( ! is_page( $vendor_page ) ) {
			return $title;
		}

		remove_filter( 'the_title', array( $this, 'change_the_title' ) );

		$store_name = EDD_FES()->helper->get_user_meta( 'name_of_store', $vendor->ID );

		if ( empty( $store_name ) ) {

			$vendor_name = EDD_FES()->vendors->get_vendor_constant_name( $plural = false, $uppercase = true ) . ' ' . $vendor->display_name;

			$title = sprintf( __('The Shop of %s','edd_fes'), $vendor_name );

		} else {

			$title = $store_name;
		}

		$title = apply_filters('fes_change_the_title', $title , $vendor->ID );

		return $title;
	}

	public function vendor_page_updated( $post_id ) {

		if ( ! EDD_FES()->helper->get_option( 'fes-vendor-page', false ) ) {
			return;
		}

		$page_id = EDD_FES()->helper->get_option( 'fes-vendor-page', false );

		if ( (int) $page_id !== (int) $post_id ) {
			return;
		}

		$this->add_rewrite_rules();

		// Set an option so we know to flush the rewrites at the next admin_init
		add_option( 'fes_permalinks_updated', 1, 'no' );

		return $post_id;
	}

	public function after_vendor_page_update() {

		$fes_permalinks_updated = get_option( 'fes_permalinks_updated' );

		if ( empty( $edd_fes_permalinks_updated ) ) {
			return;
		}

		flush_rewrite_rules();

		delete_option( 'fes_permalinks_updated' );

	}
}
