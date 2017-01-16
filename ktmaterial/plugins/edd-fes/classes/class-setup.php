<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class FES_Setup {
	public function __construct() {
		add_action( 'admin_init', array( $this, 'is_wp_and_edd_activated' ), 1 );
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'switch_theme', 'flush_rewrite_rules', 15 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array(
				$this,
				'enqueue_styles'
			) );
		add_action( 'admin_enqueue_scripts', array(
				$this,
				'admin_enqueue_scripts'
			) );
		add_action( 'admin_enqueue_scripts', array(
				$this,
				'admin_enqueue_styles'
			) );
		add_action( 'wp_head', array(
				$this,
				'fes_version'
			) );
		add_action( 'admin_head', array(
				$this,
				'admin_head'
			) );
		add_filter( 'media_upload_tabs', array(
				$this,
				'remove_media_library_tab'
			) );
		add_action( 'wp_footer', array(
				$this,
				'edd_lockup_uploaded'
			) );
		add_post_type_support( 'download', 'author' );
		add_post_type_support( 'download', 'comments' );
		add_action( 'edd_system_info_after', array(
				$this,
				'fes_add_below_system_info'
			) );

		add_filter( 'parse_query', array( $this, 'restrict_media' ) );
	}

	public function is_wp_and_edd_activated() {
		global $wp_version;
		if ( version_compare( $wp_version, '3.8', '< ' ) ) {
			if ( is_plugin_active( EDD_FES()->basename ) ) {
				deactivate_plugins( EDD_FES()->basename );
				unset( $_GET[ 'activate' ] );
				add_action( 'admin_notices', array(
						$this,
						'wp_notice'
					) );
			}
		} else if ( !class_exists( 'Easy_Digital_Downloads' ) || ( version_compare( EDD_VERSION, '1.9' ) < 0 ) ) {
				if ( is_plugin_active( EDD_FES()->basename ) ) {
					deactivate_plugins( EDD_FES()->basename );
					unset( $_GET[ 'activate' ] );
					add_action( 'admin_notices', array(
							$this,
							'edd_notice'
						) );
				}
			}
	}

	public function edd_notice() {
?>
	<div class="updated">
		<p><?php
		printf( __( '<strong>Notice:</strong> Easy Digital Downloads Frontend Submissions requires Easy Digital Downloads 1.9 or higher in order to function properly.', 'edd_fes' ) );
?>
		</p>
	</div>
	<?php
	}
	public function wp_notice() {
?>
	<div class="updated">
		<p><?php
		printf( __( '<strong>Notice:</strong> Easy Digital Downloads Frontend Submissions requires WordPress 3.8 or higher in order to function properly.', 'edd_fes' ) );
?>
		</p>
	</div>
	<?php
	}

	public function enqueue_form_assets(){
		if ( !is_page( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ) ) ) {
			EDD_FES()->setup->enqueue_styles( true );
			EDD_FES()->setup->enqueue_scripts( true );
		}
	}

	public function enqueue_scripts( $override = false ) {
		if ( is_admin() ) {
			return;
		}
		global $post;
		if ( is_page( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ) ) || $override ) {
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'underscore' );
			// FES outputs minified scripts by default on the frontend. To load full versions, hook into this and return empty string.
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
			$minify = apply_filters('fes_output_minified_versions', $suffix );
			wp_enqueue_script( 'fes_form', fes_plugin_url . 'assets/js/frontend-form' . $minify . '.js', array(
					'jquery'
				), fes_plugin_version );
			wp_localize_script( 'fes_form', 'fes_form', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'error_message' => __( 'Please fix the errors to proceed', 'edd_fes' ),
				'nonce' => wp_create_nonce( 'fes_nonce' ),
				'avatar_title' =>  __( 'Choose an avatar', 'edd_fes' ),
				'avatar_button' =>  __( 'Select as avatar', 'edd_fes' ),
				'file_title' =>  __( 'Choose a file', 'edd_fes' ),
				'file_button' =>  __( 'Insert file URL', 'edd_fes' ),
				'feat_title' =>  __( 'Choose a featured image', 'edd_fes' ),
				'feat_button' =>  __( 'Select as featured image', 'edd_fes' ),
				'one_option' => __( 'You must have at least one option', 'edd_fes' ),
				'too_many_files_pt_1' => __( 'You may not add more than ', 'edd_fes' ),
				'too_many_files_pt_2' => __( ' files!', 'edd_fes' )
			) );

			wp_enqueue_media();
			wp_enqueue_script( 'comment-reply' );
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'jquery-ui-autocomplete' );
			wp_enqueue_script( 'suggest' );
			wp_enqueue_script( 'jquery-ui-slider' );
			wp_enqueue_script( 'jquery-ui-timepicker', fes_plugin_url . 'assets/js/jquery-ui-timepicker-addon.js', array(
					'jquery-ui-datepicker'
				) );
			
		}
	}

	public function enqueue_styles( $override = false ) {
		if ( is_admin() ) {
			return;
		}
		global $post;
		if ( is_page( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ) ) || $override ) {
			// FES outputs minified scripts by default on the frontend. To load full versions, hook into this and return empty string.
			$minify = apply_filters('fes_output_minified_versions', '.min' );
			if ( EDD_FES()->helper->get_option( 'fes-use-css', true ) ){
				wp_enqueue_style( 'fes-css', fes_plugin_url . 'assets/css/frontend' . $minify . '.css' );
			}
			wp_enqueue_style( 'jquery-ui', fes_plugin_url . 'assets/css/jquery-ui-1.9.1.custom.css' );
		}
	}

	public function admin_enqueue_scripts() {
		if ( !is_admin() ) {
			return;
		}
		global $pagenow, $post;
		$current_screen = get_current_screen();
		if ( $current_screen->post_type === 'fes-forms' || $current_screen->base === 'edd-fes_page_fes-vendors'){
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-autocomplete' );
			wp_enqueue_script( 'jquery-smallipop', fes_plugin_url . 'assets/js/jquery.smallipop-0.4.0.min.js', array(
					'jquery'
				) );

			wp_enqueue_script( 'fes-formbuilder', fes_plugin_url . 'assets/js/formbuilder.js', array(
					'jquery',
					'jquery-ui-sortable'
				) );

			wp_register_script( 'jquery-tiptip', fes_plugin_url . 'assets/js/jquery-tiptip/jquery.tipTip.min.js', array(
					'jquery'
				), '2.0', true );
		}
		if ( $current_screen->post_type === 'download' || $pagenow == 'profile.php' || $current_screen->base === 'edd-fes_page_fes-vendors' ) {
			wp_enqueue_script( 'jquery' );
			wp_register_script( 'jquery-tiptip', fes_plugin_url . 'assets/js/jquery-tiptip/jquery.tipTip.min.js', array(
					'jquery'
				), '2.0', true );
			wp_enqueue_script( 'edd-fes-admin-js', fes_plugin_url . 'assets/js/admin.js', array(
					'jquery',
					'jquery-tiptip'
				), '2.0', true );
			wp_enqueue_script( 'jquery-ui-autocomplete' );
			wp_enqueue_script( 'underscore' );
			wp_enqueue_script( 'fes-form', fes_plugin_url . 'assets/js/frontend-form.js', array(
					'jquery'
				) );
			wp_localize_script( 'fes-form', 'fes_form', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'error_message' => __( 'Please fix the errors to proceed', 'edd_fes' ),
				'nonce' => wp_create_nonce( 'fes_nonce' ),
				'avatar_title' =>  __( 'Choose an avatar', 'edd_fes' ),
				'avatar_button' =>  __( 'Select as avatar', 'edd_fes' ),
				'file_title' =>  __( 'Choose a file', 'edd_fes' ),
				'file_button' =>  __( 'Insert file URL', 'edd_fes' ),
				'feat_title' =>  __( 'Choose a featured image', 'edd_fes' ),
				'feat_button' =>  __( 'Select as featured image', 'edd_fes' ),
				'one_option' => __( 'You must have at least one option', 'edd_fes' ),
				'too_many_files_pt_1' => __( 'You may not add more than ', 'edd_fes' ),
				'too_many_files_pt_2' => __( ' files!', 'edd_fes' )
			) );
			wp_enqueue_script( 'comment-reply' );
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'jquery-ui-autocomplete' );
			wp_enqueue_script( 'suggest' );
			wp_enqueue_script( 'jquery-ui-slider' );
			wp_enqueue_script( 'jquery-ui-timepicker', fes_plugin_url . 'assets/js/jquery-ui-timepicker-addon.js', array(
					'jquery-ui-datepicker'
				) );
		}
	}

	public function admin_enqueue_styles() {
		if ( !is_admin() ) {
			return;
		}
		$current_screen = get_current_screen();
		if ( $current_screen->post_type === 'fes-forms' || $current_screen->post_type === 'download' || $current_screen->base === 'edd-fes_page_fes-vendors' ) {
			if ( $current_screen->post_type === 'fes-forms' ) {
				wp_enqueue_style( 'fes-formbuilder', fes_plugin_url . 'assets/css/formbuilder.css' );
			}
			
			if ( $current_screen->post_type === 'download' ) {
				$minify = apply_filters('fes_output_minified_versions','.min' );
				wp_enqueue_style( 'fes-css', fes_plugin_url . 'assets/css/frontend' . $minify . '.css' );
			}
			if ( $current_screen->base === 'edd-fes_page_fes-vendors' ) {
				wp_enqueue_style( 'fes-css', fes_plugin_url . 'assets/css/frontend.css' );
			}
			wp_enqueue_style( 'fes-admin-css', fes_plugin_url . 'assets/css/admin.css' );
			wp_enqueue_style( 'jquery-smallipop', fes_plugin_url . 'assets/css/jquery.smallipop.css' );
			wp_enqueue_style( 'jquery-ui-core', fes_plugin_url . 'assets/css/jquery-ui-1.9.1.custom.css' );
		}
	}

	public function fes_add_below_system_info() {
		echo "\n\n".__('Notice: FES is installed. Consider including FES\'s debug information from FES -> System Info if this is an FES bug ticket.','edd_fes')."\n\n";
	}

	public function fes_version() {
		// Newline on both sides to avoid being in a blob
		echo '<meta name="generator" content="EDD FES v' . fes_plugin_version . '" />' . "\n";
	}

	public function admin_head() {
	?>
	<style>
	@charset "UTF-8";

	@font-face {
		font-family: "fes";
		src:url("<?php echo fes_assets_url; ?>/font/fes-dashicon.eot");
		src:url("<?php echo fes_assets_url; ?>/font/fes-dashicon.eot?#iefix") format("embedded-opentype"),
			url("<?php echo fes_assets_url; ?>/font/fes-dashicon.woff") format("woff"),
			url("<?php echo fes_assets_url; ?>/font/fes-dashicon.ttf") format("truetype"),
			url("<?php echo fes_assets_url; ?>/font/fes-dashicon.svg#fes") format("svg");
		font-weight: normal;
		font-style: normal;

	}

	[data-icon]:before {
		font-family: "fes" !important;
		content: attr(data-icon);
		font-style: normal !important;
		font-weight: normal !important;
		font-variant: normal !important;
		text-transform: none !important;
		speak: none;
		line-height: 1;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
	}

	[class^="icon-"]:before,
	[class*=" icon-"]:before {
		font-family: "fes" !important;
		font-style: normal !important;
		font-weight: normal !important;
		font-variant: normal !important;
		text-transform: none !important;
		speak: none;
		line-height: 1;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
	}
	#adminmenu #toplevel_page_fes-about .menu-icon-generic div.wp-menu-image:before {
		font-family: "fes" !important;
		content: "a";
	}
	</style>
	<?php
	}

	public function edd_lockup_uploaded() {
		if ( is_admin() ) {
			return;
		}
		?>
	    <script type="text/javascript">
	    jQuery(document).on("DOMNodeInserted", function(){
	        // Lock uploads to "Uploaded to this post"
	        jQuery('select.attachment-filters [value="uploaded"]').attr( 'selected', true ).parent().trigger('change');
	    });
		</script>
		<?php
	}

	// removes URL tab in image upload for post
	public function remove_media_library_tab( $tabs ) {
		if ( is_admin() ) {
			return $tabs;
		}
		if ( !current_user_can( 'fes_is_admin' ) ) {
				unset( $tabs[ 'library' ] );
				unset( $tabs[ 'gallery' ] );
				unset( $tabs[ 'type' ] );
				unset( $tabs[ 'type_url' ] );
				return $tabs;
		} else {
			return $tabs;
		}
	}

	// Prevents vendors from seeing media files that aren't theirs
        
        
	public function restrict_media( $wp_query ) {
            /* Comment by Tahir 9/23/2015
		if ( is_admin() ) {
			if ( ! current_user_can( 'fes_is_admin' ) && $wp_query->get( 'post_type' ) == 'attachment' ) {
				$wp_query->set( 'author', get_current_user_id() );
			}
		}
             * End
             */
	}
         

	public function register_post_type() {
		$capability = 'manage_shop_settings';
		register_post_type( 'fes-forms', array(
				'label' => __( 'EDD FES Forms', 'edd_fes' ),
				'public' => false,
				'rewrites' => false,
				'capability_type' => 'post',
				'capabilities' => array(
					'publish_posts' => 'cap_that_doesnt_exist',
					'edit_posts' => $capability,
					'edit_others_posts' => $capability,
					'delete_posts' => 'cap_that_doesnt_exist',
					'delete_others_posts' => 'cap_that_doesnt_exist',
					'read_private_posts' => 'cap_that_doesnt_exist',
					'edit_post' => $capability,
					'delete_post' => 'cap_that_doesnt_exist',
					'read_post' => $capability,
					'create_posts' => 'cap_that_doesnt_exist'
				),
				'hierarchical' => false,
				'query_var' => false,
				'supports' => array(
					'title'
				),
				'can_export'		=> true,
				'show_ui'           => false,
				'labels' => array(
					'name' => __( 'EDD FES Forms', 'edd_fes' ),
					'singular_name' => __( 'FES Form', 'edd_fes' ),
					'menu_name' => __( 'FES Forms', 'edd_fes' ),
					'add_new' => __( 'Add FES Form', 'edd_fes' ),
					'add_new_item' => __( 'Add New Form', 'edd_fes' ),
					'edit' => __( 'Edit', 'edd_fes' ),
					'edit_item' => '',
					'new_item' => __( 'New FES Form', 'edd_fes' ),
					'view' => __( 'View FES Form', 'edd_fes' ),
					'view_item' => __( 'View FES Form', 'edd_fes' ),
					'search_items' => __( 'Search FES Forms', 'edd_fes' ),
					'not_found' => __( 'No FES Forms Found', 'edd_fes' ),
					'not_found_in_trash' => __( 'No FES Forms Found in Trash', 'edd_fes' ),
					'parent' => __( 'Parent FES Form', 'edd_fes' )
				)
			) );
	}
}
