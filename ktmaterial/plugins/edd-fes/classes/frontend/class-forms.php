<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class FES_Forms {
	function __construct() {
		// old removed shortcodes from pre-2.2
		add_shortcode( 'fes_profile', array( $this, '__return_empty_string' ) );
		add_shortcode( 'fes-form', array( $this, '__return_empty_string' ) );
		add_shortcode( 'edd_fes_login_form', array( $this, '__return_empty_string' ) );
		add_shortcode( 'edd_fes_register_form', array( $this, '__return_empty_string' ) );
		add_shortcode( 'edd_fes_combo_form', array( $this, '__return_empty_string' ) );

		// new shortcodes added in 2.2
		add_shortcode( 'fes_submission_form', array( $this, 'render_submission_form' ) );
		add_shortcode( 'fes_profile_form', array( $this, 'render_profile_form' ) );
		add_shortcode( 'fes_login_form', array( $this, 'render_login_form' ) );
		add_shortcode( 'fes_registration_form', array( $this, 'render_registration_form' ) );
		add_shortcode( 'fes_login_registration_form', array( $this, 'render_login_registration_form' ) );
		add_shortcode( 'fes_vendor_contact_form', array( $this, 'contact_form_shortcode' ) );

		// save actions
		add_action( 'admin_init', array( $this, 'submit_profile_form' ) );
		add_action( 'wp_ajax_fes_update_profile', array( $this, 'submit_profile_form' ) );
		add_action( 'wp_ajax_nopriv_fes_update_profile', array( $this, 'submit_profile_form' ) );

		add_action( 'wp_ajax_fes_submit_post', array( $this, 'submit_submission_form' ) );
		add_action( 'wp_ajax_nopriv_fes_submit_post', array( $this, 'submit_submission_form' ) );

		add_action( 'admin_init', array( $this, 'submit_registration_form' ) );
		add_action( 'wp_ajax_fes_submit_registration', array( $this, 'submit_registration_form' ) );
		add_action( 'wp_ajax_nopriv_fes_submit_registration', array( $this, 'submit_registration_form' ) );

		add_action( 'wp_ajax_fes_submit_login', array( $this, 'submit_login_form' ) );
		add_action( 'wp_ajax_nopriv_fes_submit_login', array( $this, 'submit_login_form' ) );

		add_action( 'wp_ajax_fes_submit_vendor_contact_form', array( $this, 'submit_vendor_contact_form' ) );
		add_action( 'wp_ajax_nopriv_fes_submit_vendor_contact_form', array( $this, 'submit_vendor_contact_form' ) );
	}

	// render form
	// var1: type of form
	// var2: id of user/post
	// var3: read/write = false, read_only = true
	// var4: args (array) (used in submission form for now)
	function render_form( $type = 'submission', $id = false, $read_only = false, $args = array() ) {
		EDD_FES()->setup->enqueue_form_assets();
		switch ( $type ) {
		case 'submission':
			do_action( 'fes_render_form_above_submission_form', $id, $read_only, $args );
			echo $this->render_submission_form( $id, $read_only, $args );
			do_action( 'fes_render_form_below_submission_form', $id, $read_only, $args );
			break;
		case 'profile':
			do_action( 'fes_render_form_above_profile_form', $id, $read_only, $args );
			echo $this->render_profile_form( $id, $read_only, $args );
			do_action( 'fes_render_form_below_profile_form', $id, $read_only, $args );
			break;
		case 'login':
			do_action( 'fes_render_form_above_login_form', $id, $read_only, $args );
			echo $this->render_login_form( $args );
			do_action( 'fes_render_form_below_login_form', $id, $read_only, $args );
			break;
		case 'registration':
			do_action( 'fes_render_form_above_registration_form', $id, $read_only, $args );
			echo $this->render_registration_form( $id, $read_only, $args );
			do_action( 'fes_render_form_below_registration_form', $id, $read_only, $args );
			break;
		case 'login-registration':
			do_action( 'fes_render_form_above_login_registration_form', $id, $read_only, $args );
			echo $this->render_login_registration_form ( $args );
			do_action( 'fes_render_form_below_login_registration_form', $id, $read_only, $args );
			break;
		case 'vendor-contact-form':
			do_action( 'fes_render_form_above_vendor_contact_form', $id, $read_only, $args );
			echo $this->render_vendor_contact_form( $id, $read_only, $args );
			do_action( 'fes_render_form_below_vendor_contact_form', $id, $read_only, $args );
			break;
		default:
			do_action( 'fes_render_form_above_submission_form', $id, $read_only, $args );
			echo $this->render_submission_form( $id, $read_only, $args );
			do_action( 'fes_render_form_below_submission_form', $id, $read_only, $args );
			break;
		}
	}

	function contact_form_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'id' => 0,
		),
		$atts, 'vendor_contact_form' );
		return $this->render_vendor_contact_form( $atts['id'], false, $atts );
	}

	function render_vendor_contact_form( $id = false, $read_only = false, $args = array() ) {

		EDD_FES()->setup->enqueue_form_assets();

		if ( ! $id ){
			// still no id? One last try. Let's return
			return sprintf( __('No %s ID set!', 'edd_fes'), EDD_FES()->vendors->get_vendor_constant_name( $plural = true, $uppercase = false ) );
		}

		// load the scripts so others don't have to
		if ( ! isset( $args['already_loaded_scripts'] ) ) {
			EDD_FES()->setup->enqueue_form_assets();
		}

		$form_id = EDD_FES()->helper->get_option( 'fes-vendor-contact-form', false );

		if ( ! $form_id ){
			return __( 'Vendor Contact Form not set in the FES settings', 'edd_fes' );
		}

		$args['vendor'] = $id;

		ob_start();

		$form_vars = get_post_meta( $form_id, 'fes-form', true );
		do_action( 'fes_vendor_contact_form_before_form', $form_id, $read_only, $args ); ?>
		<form class="fes-form-vendor-contact-form" action="" method="post">
			<div class="fes-form">
				<?php
				do_action( 'fes_vendor_contact_above_render_items', $form_id, $read_only, $args );

				echo apply_filters( 'fes_vendor_contact_form_header', '<h1 class="fes-headers" id="fes-contact-form-title">' . __( 'Contact Form', 'edd_fes' ) . '</h1>' );

				$this->render_items( $form_vars, $id, $type = 'vendor-contact', $form_id, $read_only, $args );

				do_action( 'fes_vendor_contact_below_render_items', $form_id, $args );

				$this->submit_button( $form_id, $type = 'vendor-contact', $id, $args );

				do_action( 'fes_vendor_contact_below_submit_buttons', $form_id, $read_only, $args );
				?>
			</div>
		</form>
		<?php
		do_action( 'fes_vendor_contact_after_form', $form_id, $read_only, $args );

		$form = ob_get_contents();
		ob_end_clean();
		return $form;

	}

	function render_login_form( $id = false, $read_only = false, $args = array() ) {

		EDD_FES()->setup->enqueue_form_assets();

		ob_start();

		if ( !is_user_logged_in() ) {

			$form_id = EDD_FES()->helper->get_option( 'fes-login-form', false );

			if ( !$form_id ){
				_e( 'Login Form not set in the FES settings', 'edd_fes' );
				return;
			}

			$form_vars = get_post_meta( $form_id, 'fes-form', true );

			if ( ! $form_vars ) {
				_e( 'Login form has no fields!', 'edd_fes' );
				return;
			}

			do_action( 'fes_login_form_before_form', $form_id, $read_only, $args );
			?>
			<form class="fes-form-login-form" action="" method="post">
			<div class="fes-form">
			<?php
			echo apply_filters( 'fes_login_form_header', '<h1 class="fes-headers" id="fes-login-form-title">' . __( 'Login', 'edd_fes' ) . '</h1>' );
			?>
			<p class="fes-form-error fes-error" style="display: none;"></p>
			<?php
			do_action( 'fes_login_form_above_render_items', $form_id, $read_only, $args );
			$this->render_items( $form_vars, $id, $type = 'login', $form_id, $read_only, $args );
			do_action( 'fes_login_form_below_render_items', $form_id, $args );
			$this->submit_button( $form_id, $type = 'login', $args );
			do_action( 'fes_login_form_below_submit_buttons', $form_id, $read_only, $args );
			?>
			</div>
			</form>
			<?php
			do_action( 'fes_login_form_after_form', $form_id, $read_only, $args );
		}

		$form = ob_get_contents();
		ob_end_clean();
		return $form;
	}

	function render_registration_form( $id = false, $read_only = false, $args = array()  ) {

		EDD_FES()->setup->enqueue_form_assets();

		$allow_registrations = (bool) EDD_FES()->helper->get_option( 'fes-allow-registrations', true ); // allow new users to become vendors
		$allow_applications  = (bool) EDD_FES()->helper->get_option( 'fes-allow-applications', true ); // allow existing users to become vendors
		$is_pending = (bool) EDD_FES()->vendors->is_pending( $id ); // user is pending vendor
		$is_vendor = (bool) EDD_FES()->vendors->vendor_is_vendor( $id ); // user is vendor
		$is_backend = isset( $args['backend'] ) && is_user_logged_in() ? true : false; // we're in the backend
		$logged_in = is_user_logged_in();

		ob_start();

		if ( $is_vendor && !$is_backend ) {
			// if we are a vendor, but not in the backend, don't show this form
			return '';
		} else if ( $is_pending && !$is_backend ) {
			// if we are pending vendor but not in the backend
			?>
			<div class="fes-vendor-pending fes-info">
			<?php echo apply_filters( 'fes_application_pending_message', __( 'Your application is pending', 'edd_fes' ) ); ?>
			</div>
			<?php
		} else if ( $logged_in && !$allow_applications && !$is_backend ){
			// if existing user wants to become a vendor, and applications are off, and not in backend
			?>
			<div class="fes-info">
			<?php _e( 'Vendor applications are currently closed', 'edd_fes' ); ?>
			</div>
			<?php
		} else if ( !$logged_in && !$allow_registrations && $allow_applications && !$is_backend ){
			// if user is logged out and we allow applications, tell them they can login and apply
			?>
			<div class="fes-info">
			<?php _e( 'Vendor registration is currently closed. If you have an existing account, you may login and apply to become a vendor.', 'edd_fes' ); ?>
			</div>
			<?php
		} else if ( !$logged_in && !$allow_registrations && !$allow_applications && !$is_backend ){
			// if user is logged out and we allow applications, tell them they can login and apply
			?>
			<div class="fes-info">
			<?php _e( 'Vendor registration is currently closed.', 'edd_fes' ); ?>
			</div>
			<?php
		} else {
			// One of these cases:
			// logged out, registration on, application on
			// logged in, registration on, application on
			// logged in, registration off, application on
			// logged in, registration on/off, application on/off and in backend (is an admin editing a vendor likely )
			$form_id = EDD_FES()->helper->get_option( 'fes-registration-form', false );
			if ( !$form_id ){
				_e( 'Registration Form not set in the FES settings', 'edd_fes' );
			}
			$form_vars = get_post_meta( $form_id, 'fes-form', true );

			if ( !$form_vars ) {
				_e( 'Registration form has no fields!', 'edd_fes' );
			}

			do_action( 'fes_registration_form_before_form', $form_id, $read_only, $args );
			?>
			<form class="fes-form-registration-form" action="" method="post">
				<div class="fes-form">
					<?php

					do_action( 'fes_registration_form_above_title', $form_id, $read_only, $args );

					if ( !is_admin() ){
						echo apply_filters( 'fes_registration_form_header', '<h1 class="fes-headers" id="fes-registration-form-title">' . __( 'Register', 'edd_fes' ) . '</h1>' );
					}

					do_action( 'fes_registration_form_above_render_items', $form_id, $read_only, $args );

					$this->render_items( $form_vars, $id, 'registration', $form_id, $read_only, $args );

					do_action( 'fes_registration_form_below_render_items', $form_id, $args );

					$this->submit_button( $form_id, 'registration', $id, $args );

					do_action( 'fes_registration_form_below_submit_buttons', $form_id, $read_only, $args );
					?>
				</div>
			</form>
			<?php
			do_action( 'fes_registration_form_after_form', $form_id, $read_only, $args );

		}

		$form = ob_get_contents();
		ob_end_clean();
		return $form;
	}

	// TODO: this entire function needs to be made 1000x times more dev friendly. Let's do that in 2.3
	function render_login_registration_form( $id = false, $read_only = false, $args = array() ) {
		$count = EDD_FES()->vendors->combo_form_count();
		$width = $count == 2 ? '44%' : '100%';
		ob_start();

		if ( $count == 2 ){
			echo '<table><tr><td id="fes_login_registration_form_row_left" class="fes_login_registration_form_row fes_login_registration_form_row_half_width" style="width: 44%; clear: none; float: left;">';
			echo $this->render_login_form( $args );
			echo '</td><td id="fes_login_registration_form_row_right" class="fes_login_registration_form_row fes_login_registration_form_row_half_width" style="width: 44%; float: left;">';
			echo $this->render_registration_form( $args );
			echo '</td></tr></div></table>';
		} else if ( $count === 1 ){
			if ( EDD_FES()->vendors->can_see_login() ){
				echo '<table><tr><td id="_login_registration_form_row_full_width_login" class="fes_login_registration_form_row" style="width: 88%; clear: none; float: left;">';
				echo $this->render_login_form( $args );
				echo '</td></tr></div></table>';
			}
			else if ( EDD_FES()->vendors->can_see_registration() ){
				echo '<table><tr><td id="_login_registration_form_row_full_width_registration" class="fes_login_registration_form_row" style="width: 88%; clear: none; float: left;">';
				if ( EDD_FES()->helper->get_option( 'fes-allow-registrations', true ) || EDD_FES()->helper->get_option( 'fes-allow-applications', true ) ) {
					echo $this->render_registration_form( $args );
				}
				else{
					_e( 'Registration and applications are currently closed', 'edd_fes' );
				}
				echo '</td></tr></div></table>';
			}
			else if ( EDD_FES()->vendors->is_pending() ){
				echo '<table><tr><td id="_login_registration_form_row_full_width_pending" class="fes_login_registration_form_row" style="width: 88%; clear: none; float: left;">';
					echo apply_filters( 'fes_application_pending_message', __( 'Your application is pending', 'edd_fes' ) );
				echo '</td></tr></div></table>';
			}
			else{
				_e( 'An error occured. FES error: CFCF 1', 'edd_fes' );
			}
		}
		else{
			if( EDD_FES()->vendors->is_pending() ) {
				echo apply_filters( 'fes_application_pending_message', __( 'Your application is pending', 'edd_fes' ) );
			} else {
				_e( 'You are already a vendor, go to the Vendor Dashboard', 'edd_fes' );
			}
		}

		$form = ob_get_contents();
		ob_end_clean();

		return $form;
	}

	function render_submission_form( $id = false, $read_only = false, $args = array() ) {

		global $post;

		// Session set for upload watermarking
		$fes_post_id = isset( $post->ID ) ? $post->ID : '';
		EDD()->session->set( 'edd_fes_post_id', $fes_post_id );

		EDD_FES()->setup->enqueue_form_assets();

		ob_start();

		$form_id = EDD_FES()->helper->get_option( 'fes-submission-form', false );
		if ( ! $form_id ){
			_e( 'Submission Form not set in the FES settings', 'edd_fes' );
		}

		$form_vars = get_post_meta( $form_id, 'fes-form', true );

		if ( !$form_vars ) {
			_e( 'Submission form has no fields!', 'edd_fes' );
		}

		if ( isset( $_REQUEST['post_id']) && absint( $_REQUEST['post_id'] ) ) {
			$id = absint( $_REQUEST['post_id'] );
		} else if( empty( $id ) ) {
			$id = 0;
		}

		$user_id = get_current_user_id();
		$is_vendor = EDD_FES()->vendors->vendor_is_vendor( $user_id );
		$is_admin = EDD_FES()->vendors->vendor_is_admin( $user_id );
		$download = get_post( $id );

		// if they are not a vendor, admin, or in the backend
		if ( ! $download ) {
			_e( 'Access Denied', 'edd_fes' );
			return;
		}

		// if they are not a vendor, admin, or in the backend
		if ( !$is_admin && !is_admin() && !$is_vendor ) {
			_e( 'Access Denied', 'edd_fes' );
			return;
		}

		$post_author = $download->post_author;

		// if they are not admin, in the admin, or the author of the post
		if ( !$is_admin && !is_admin() && $id !== 0 && ( $post_author != $user_id ) ) {
			_e( 'Access Denied', 'edd_fes' );
			return;
		}

		if ( $id !== 0 ) {
			if ( !EDD_FES()->vendors->vendor_can_edit_product( $id ) ) {
				_e( 'Access Denied', 'edd_fes' );
				return;
			} else {
				echo '<h1 class="fes-headers" id="fes-edit-product-page-title" >'. sprintf( __( 'Edit %s', 'edd_fes'), EDD_FES()->vendors->get_product_constant_name( $plural = false, $uppercase = true ) ) . ' ' . __( ': #', 'edd_fes' ).$id.'</h1>';
			}
		}
		else {
			if ( !EDD_FES()->vendors->vendor_can_create_product() ) {
				_e( 'Access Denied', 'edd_fes' );
				return;
			} else {
				echo '<h1 class="fes-headers" id="fes-new-product-page-title" >'.sprintf( __( 'Create New %s', 'edd_fes'), EDD_FES()->vendors->get_product_constant_name( $plural = false, $uppercase = true ) ) .'</h1>';
			}
		}
		// is it read only? If so don't make it a form
		if ( !$read_only ) { ?>
			 <form class="fes-submission-form" action="" method="post">
		<?php }
		?>
			<div class="fes-form">
		<?php

		if ( !$id ) {
			do_action( 'fes_submission_form_new_top', $form_id, $user_id, $args );
		} else {
			do_action( 'fes_submission_form_existing_top', $form_id, $id, $user_id, $args );
		}

		$this->render_items( $form_vars, $id, $type = 'submission', $form_id, $read_only, $args );

		if ( !$id ) {
			do_action( 'fes_submission_form_new_bottom', $form_id, $user_id, $args );
		} else {
			do_action( 'fes_submission_form_existing_bottom', $form_id, $id, $user_id, $args );
		}

		if ( !$read_only ) {
			$this->submit_button( $form_id, $type = 'submission', $id, $args );
		}

		?>
		</div>
		<?php

		// is it read only? If so don't make it a form
		if ( !$read_only ) { ?>
			</form>
		<?php }

		$form = ob_get_contents();
		ob_end_clean();

		return $form;
	}

	function render_profile_form( $id = -2, $read_only = false, $args = array() ) {

		EDD_FES()->setup->enqueue_form_assets();
		ob_start();

		if ( $id === -2 || empty( $id ) ) {
			$id = get_current_user_id();
		}

		$form_id = EDD_FES()->helper->get_option( 'fes-profile-form', false );

		if ( !$form_id ){
			_e( 'Profile Form not set in the FES settings', 'edd_fes' );
			return;
		}

		$form_vars = get_post_meta( $form_id, 'fes-form', true );
		echo '<h1 class="fes-headers" id="fes-profile-page-title">'. __( 'Profile', 'edd_fes') . '</h1>';

		if ( ! $form_vars ) {
			_e( 'Profile form has no fields!', 'edd_fes' );
			return;
		}

		if ( isset( $_GET[ 'msg' ] ) && $_GET[ 'msg' ] == 'profile_update' ) {
			echo '<div class="fes-success">';
			echo __( 'Updated Successfully', 'edd_fes' );
			echo '</div>';
		}

		$user_id = get_current_user_id();

		$is_vendor = EDD_FES()->vendors->vendor_is_vendor( $user_id );
		$is_admin = EDD_FES()->vendors->vendor_is_admin( $user_id );

		// if they are not a vendor, admin, or in the backend or vendor != the vendor being looked at
		if ( !$is_admin && !is_admin() && !$is_vendor || ( $user_id !== $id && !is_admin() && !$is_admin ) ) {
			_e( 'Access Denied', 'edd_fes' );
			return;
		}

		// is it read only? If so don't make it a form
		if ( !$read_only ) { ?>
			 <form class="fes-profile-form" action="" method="post">
		<?php }
		?>
			<div class="fes-form">
		<?php

		do_action( 'fes_profile_form_top', $form_id, $id, $args );

		$this->render_items( $form_vars, $id, $type = 'profile' , $form_id, $read_only, $args );

		do_action( 'fes_profile_form_bottom', $form_id, $id, $args );

		if ( !$read_only ) {
			$this->submit_button( $form_id, $type = 'profile', $id, $args );
		}
		?>
			</div>
		<?php
		// is it read only? If so don't make it a form
		if ( !$read_only ) { ?>
			</form>
		<?php }

		$form = ob_get_contents();
		ob_end_clean();

		return $form;
	}

	// submit form
	function submit_form( $type = 'submission', $id = false, $values = array(), $args = array() ) {
		switch ( $type ) {
		case 'submission':
			$this->submit_submission_form( $id, $values, $args );
			break;
		case 'profile':
			$this->submit_profile_form( $id, $values, $args );
			break;
		case 'login':
			$this->submit_login_form( $id, $values, $args );
			break;
		case 'registration':
			$this->submit_registration_form( $id, $values, $args );
			break;
		case 'vendor_contact':
			$this->submit_vendor_contact_form( $id, $values, $args );
			break;
		default:
			$this->submit_submission_form( $id, $read_only, $args );
			break;
		}

	}

	function submit_vendor_contact_form( $args = array() ) {
		check_ajax_referer( 'fes-form-vendor-contact-form' );
		@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );

		$form_id       = isset( $_POST[ 'form_id' ] ) ? intval( $_POST[ 'form_id' ] ) : -1;
		if ( $form_id != EDD_FES()->helper->get_option( 'fes-vendor-contact-form', false ) ) {
			$this->signal_error( __( 'Form ID mismatch', 'edd_fes' ) );
		}

		$form_vars     = $this->get_input_fields( $form_id );
		$form_settings = get_post_meta( $form_id, 'fes-form_settings', true );
		list( $user_vars, $taxonomy_vars, $meta_vars ) = $form_vars;

		do_action( 'fes_pre_process_contact_form', $this, $form_id, $form_vars );

		if ( EDD_FES()->helper->get_option( 'fes-vendor-contact-captcha', false ) ) {
			if ( $this->search_array( $form_vars, 'input_type', 'recaptcha' ) ) {
				$this->validate_re_captcha();
			}
		}
		// user_vars contains the radio toggle
		// meta_vars contains the user_login and password fields
		if ( $this->search_array( $user_vars, 'name', 'first_name' ) ) {
			if ( !isset($_POST[ 'first_name' ]) || $_POST[ 'first_name' ] === '' ){
				$this->signal_error( __( 'Please fill out the contact form!', 'edd_fes' ) );
			}
			else{
				$userdata[ 'first_name' ] = sanitize_text_field( $_POST[ 'first_name' ] );
			}
		}
		else if ( $this->search_array( $meta_vars, 'name', 'first_name' ) ) {
			if ( !isset($_POST[ 'first_name' ]) || $_POST[ 'first_name' ] === '' ){
				$this->signal_error( __( 'Please fill out the contact form!', 'edd_fes' ) );
			}
			else{
				$userdata[ 'first_name' ] = sanitize_text_field( $_POST[ 'first_name' ] );
			}
		}

		if ( $this->search_array( $user_vars, 'name', 'last_name' ) ) {
			if ( !isset($_POST[ 'last_name' ]) || $_POST[ 'last_name' ] === '' ){
				$this->signal_error( __( 'Please fill out the contact form!', 'edd_fes' ) );
			}
			else{
				$userdata[ 'last_name' ] = sanitize_text_field( $_POST[ 'last_name' ] );
			}
		}
		else if ( $this->search_array( $meta_vars, 'name', 'last_name' ) ) {
			if ( !isset($_POST[ 'last_name' ]) || $_POST[ 'last_name' ] === '' ){
				$this->signal_error( __( 'Please fill out the contact form!', 'edd_fes' ) );
			}
			else{
				$userdata[ 'last_name' ] = sanitize_text_field( $_POST[ 'last_name' ] );
			}
		}

		if ( $this->search_array( $user_vars, 'name', 'user_email' ) ) {
			if ( !isset($_POST[ 'user_email' ]) || $_POST[ 'user_email' ] === '' ){
				$this->signal_error( __( 'Please fill out the contact form!', 'edd_fes' ) );
			}
			if ( !is_email( $_POST[ 'user_email' ] ) ){
				$this->signal_error( __( 'Please enter a valid email!', 'edd_fes' ) );
			}
			else{
				$userdata[ 'user_email' ] = sanitize_email( $_POST[ 'user_email' ] );
			}
		}
		else if ( $this->search_array( $meta_vars, 'name', 'user_email' ) ) {
			if ( !isset($_POST[ 'user_email' ]) || $_POST[ 'user_email' ] === '' ){
				$this->signal_error( __( 'Please fill out the contact form!', 'edd_fes' ) );
			}
			if ( !is_email( $_POST[ 'user_email' ] ) ){
				$this->signal_error( __( 'Please enter a valid email!', 'edd_fes' ) );
			}
			else{
				$userdata[ 'user_email' ] = sanitize_email( $_POST[ 'user_email' ] );
			}
		}


		if ( $this->search_array( $user_vars, 'name', 'subject' ) ) {
			if ( !isset($_POST[ 'subject' ]) || $_POST[ 'subject' ] === '' ){
				$this->signal_error( __( 'Please fill out the contact form!', 'edd_fes' ) );
			}
			else{
				$userdata[ 'subject' ] = sanitize_text_field( $_POST[ 'subject' ] );
			}
		}
		else if ( $this->search_array( $meta_vars, 'name', 'subject' ) ) {
			if ( !isset($_POST[ 'subject' ]) || $_POST[ 'subject' ] === '' ){
				$this->signal_error( __( 'Please fill out the contact form!', 'edd_fes' ) );
			}
			else{
				$userdata[ 'subject' ] = sanitize_text_field( $_POST[ 'subject' ] );
			}
		}

		if ( $this->search_array( $user_vars, 'name', 'message' ) ) {
			if ( !isset($_POST[ 'message' ]) || $_POST[ 'message' ] === '' ){
				$this->signal_error( __( 'Please fill out the contact form!', 'edd_fes' ) );
			}
			else{
				$userdata[ 'message' ] = esc_textarea( $_POST[ 'message' ] );
			}
		}
		else if ( $this->search_array( $user_vars, 'name', 'message' ) ) {
			if ( !isset($_POST[ 'message' ]) || $_POST[ 'message' ] === '' ){
				$this->signal_error( __( 'Please fill out the contact form!', 'edd_fes' ) );
			}
			else{
				$userdata[ 'message' ] = esc_textarea( $_POST[ 'message' ] );
			}
		}

		if ( !isset($_POST[ 'vendor_id' ]) || $_POST[ 'vendor_id' ] === '' ){
			$this->signal_error( __( 'Invalid vendor id!', 'edd_fes' ) );
		}
		else{
			$userdata[ 'vendor_id' ] = absint( $_POST[ 'vendor_id' ] );
		}

		$vendor_user = new WP_User( $userdata[ 'vendor_id' ] );
		if ( ! is_object( $vendor_user ) ) {
			$this->signal_error( __( 'Invalid vendor id!', 'edd_fes' ) );
		}

		$to = apply_filters( 'fes_vendor_contact_form_to', $vendor_user->user_email, $userdata );
		$from_name  = $userdata['first_name'] . ' ' . $userdata['last_name'];
		$from_email = $userdata['user_email'];
		$subject    = apply_filters('fes_vendor_contact_form_subject', sprintf( __('Message from user: %s', 'edd_fes' ), $userdata[ 'subject' ] ) );
		$message    = $userdata[ 'message' ];

		EDD_FES()->emails->send_email( $to, $from_name, $from_email, $subject, $message, 'user', $userdata['vendor_id'], array() );

		// maybe in 2.3 offer the ability to save emails sent or view in admin
		// however there are already plugins for this

		do_action( 'fes_vendor_contact_form_success', $userdata );

		$response = array(
			'redirect_to' => $_POST['_wp_http_referer'],
			'success' => true,
			'message' => __( 'Email sent!', 'edd_fes' ),
			'is_post' => false
		);

		$response = apply_filters( 'fes_vendor_contact_form_success_redirect', $response, $userdata );

		echo json_encode( $response );
		exit;
	}



	function submit_login_form( $args = array() ) {
		check_ajax_referer( 'fes-form-login' );
		@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );

		$form_id       = isset( $_POST[ 'form_id' ] ) ? intval( $_POST[ 'form_id' ] ) : 12;
		if ( $form_id != EDD_FES()->helper->get_option( 'fes-login-form', false ) ) {
			$this->signal_error( __( 'Form ID mismatch', 'edd_fes' ) );
		}

		$form_vars     = $this->get_input_fields( $form_id );
		$form_settings = get_post_meta( $form_id, 'fes-form_settings', true );
		list( $user_vars, $taxonomy_vars, $meta_vars ) = $form_vars;
		$user_id  = get_current_user_id();
		$userdata = array(
			'ID' => $user_id
		);
		if ( EDD_FES()->helper->get_option( 'fes-login-captcha', false ) ){
			if ( $this->search_array( $form_vars, 'input_type', 'recaptcha' ) ) {
				$this->validate_re_captcha();
			}
		}
		// user_vars contains the radio toggle
		// meta_vars contains the user_login and password fields
		if ( $this->search_array( $meta_vars, 'name', 'user_login' ) ) {
			$userdata[ 'username' ] = sanitize_user( $_REQUEST[ 'user_login' ] );
		}
		if ( $this->search_array( $meta_vars, 'name', 'password' ) ) {
			$userdata[ 'password' ] = sanitize_text_field( $_REQUEST[ 'pass1' ] );
		}
		if ( !isset( $userdata['username'] ) || !isset( $userdata[ 'password' ] ) ) {
			$this->signal_error( __( 'Please fill out the login form!', 'edd_fes' ) );
		}

		$user = get_user_by( 'login', $userdata[ 'username' ] );
		if ( $user ) {
			$password = wp_check_password( $userdata[ 'password' ] , $user->data->user_pass, $user->ID );
			if ( $password ) {
				wp_set_auth_cookie( $user->ID, true );
				wp_set_current_user( $user->ID, $userdata[ 'username' ] );
				do_action( 'wp_login', $userdata[ 'username' ] );
				do_action( 'fes_login_form' );
				$url = get_permalink( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ) );
				if ( isset( $_REQUEST['fes_login_radio_button'] ) && $_REQUEST['fes_login_radio_button'] == 'Customer'  ) {
					$url = get_permalink( edd_get_option( 'purchase_history_page' ) );
				}
				do_action( 'fes_vendor_contact_form_success', $userdata );
				$response = array(
					'success' => true,
					'redirect_to' => $url,
					'message' => __( 'Logged in!', 'edd_fes' ),
					'is_post' => true
				);
				$response = apply_filters( 'fes_login_form_success_redirect', $response, $userdata );
				echo json_encode( $response );
				exit;
			}
			else {
				$this->signal_error( __( 'Password is wrong!', 'edd_fes' ) );
			}
		}
		else {
			$this->signal_error( __( 'Username is wrong!', 'edd_fes' ) );
		}
	}

	function submit_registration_form( $args = array() ) {
		global $edd_options;
		if ( is_admin() && ( !isset( $_REQUEST[ '_wpnonce' ] ) || !wp_verify_nonce( $_REQUEST[ '_wpnonce' ], 'fes-form-registration' ) ) ) {
			return;
		}
		check_ajax_referer( 'fes-form-registration' );
		@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
		$form_id       = isset( $_POST[ 'form_id' ] ) ? intval( $_POST[ 'form_id' ] ) : 0;
		$db_form_id    = EDD_FES()->helper->get_option( 'fes-registration-form', false );
		$form_vars     = $this->get_input_fields( $form_id );
		list( $user_vars, $taxonomy_vars, $meta_vars ) = $form_vars;
		$merged_user_meta = array_merge( $user_vars, $meta_vars );

		do_action( 'fes_pre_process_registration_form', $this, $form_id, $form_vars );

		if ( $form_id != $db_form_id && !is_admin() ) {
			$response    = array(
				'success' => false,
				'redirect_to' => get_permalink( $_POST[ 'page_id' ] ),
				'message' => __( 'Access Denied: '.$form_id.' != '.$db_form_id , 'edd_fes' ),
				'is_post' => true
			);
			echo json_encode( $response );
			exit;
		}

		// if admin side lets get them out of the way
		if ( is_admin() && ! empty( $_REQUEST['is_admin'] ) && '1' == $_REQUEST['is_admin'] ) {

			$user = get_userdata( absint( $_REQUEST[ 'user_id' ] ) );

			if ( ! current_user_can( 'edit_users' ) ) {
				$response    = array(
					'success' => false,
					'redirect_to' => admin_url( 'admin.php?page=fes-vendors&vendor='.$user->ID.'&result=denied&action=edit' ),
					'message' => __( 'Access denied!' , 'edd_fes' ),
					'is_post' => true
				);
				$response    = apply_filters( 'fes_registration_form_denied_admin_redirect', $response, $user->ID, $form_id );
				do_action('fes_registration_form_denied_admin', $user->ID );
				echo json_encode( $response );
				exit;
			}

			$userdata = array();

			if ( $this->search_array( $merged_user_meta, 'name', 'first_name' ) ) {
				$userdata[ 'first_name' ] = sanitize_text_field( $_POST[ 'first_name' ] );
			}
			if ( $this->search_array( $merged_user_meta, 'name', 'last_name' ) ) {
				$userdata[ 'last_name' ] = sanitize_text_field( $_POST[ 'last_name' ] );
			}
			if ( $this->search_array( $merged_user_meta, 'name', 'user_email' ) ) {
				if ( ! empty( $_POST[ 'user_email' ] ) && ! is_email( $_POST[ 'user_email' ] ) ){
					$this->signal_error( __( 'Please enter a valid email!', 'edd_fes' ) );
				}
				elseif( ! empty( $_POST[ 'user_email' ] ) ) {
					$userdata[ 'user_email' ] = sanitize_email( $_POST[ 'user_email' ] );
				}
			}

			if ( $this->search_array( $merged_user_meta, 'name', 'display_name' ) ) {
				$userdata[ 'display_name' ] = sanitize_text_field( $_POST[ 'display_name' ] );
			}

			if ( $this->search_array( $merged_user_meta, 'name', 'user_url' ) ) {
				if ( isset( $_POST[ 'user_url' ] ) ){
					$userdata[ 'user_url' ] = sanitize_text_field( $_POST[ 'user_url' ] );
				}
			}


			$userdata['ID'] = $user->ID;
			wp_update_user( $userdata );
			// save app data to vendor
			$counter = 0;
			foreach ( $meta_vars as $meta ) {
				if ( $meta['name'] == 'password' ) {
					unset( $meta_vars[$counter] );
				}
				$counter++;
			}
			$this->update_user_meta( $meta_vars, $user->ID );

			// redirect to dashboard
			$response    = array(
				'success' => true,
				'redirect_to' => admin_url( 'admin.php?page=fes-vendors&vendor='.$user->ID.'&result=success&action=edit' ),
				'message' => __( 'Successfully Updated' , 'edd_fes' ),
				'is_post' => true
			);
			$response    = apply_filters( 'fes_registration_form_admin_redirect', $response, $user->ID, $form_id );
			do_action('fes_registration_form_admin_success', $user->ID );
			echo json_encode( $response );
			exit;
		} // End is_admin()


		// check recaptcha
		if ( $this->search_array( $form_vars, 'input_type', 'recaptcha' ) ) {
			$this->validate_re_captcha();
		}

		// if user logged in skip verification & creation of new user
		if ( is_user_logged_in() ) {

			$user = new WP_User( get_current_user_id() );
			$userdata = array();
			$userdata[ 'user_email' ] = $user->user_email;

			if ( $this->search_array( $merged_user_meta, 'name', 'first_name' ) ) {
				if ( !isset($_POST[ 'first_name' ]) || $_POST[ 'first_name' ] === '' ){
					$this->signal_error( __( 'Please fill out the registration form!', 'edd_fes' ) );
				}
				else{
					$userdata[ 'first_name' ] = sanitize_text_field( $_POST[ 'first_name' ] );
				}
			}
			if ( $this->search_array( $merged_user_meta, 'name', 'last_name' ) ) {
				if ( !isset($_POST[ 'last_name' ]) || $_POST[ 'last_name' ] === '' ){
					$this->signal_error( __( 'Please fill out the registration form!', 'edd_fes' ) );
				}
				else{
					$userdata[ 'last_name' ] = sanitize_text_field( $_POST[ 'last_name' ] );
				}
			}

			if ( $this->search_array( $merged_user_meta, 'name', 'display_name' ) ) {
				if ( !isset($_POST[ 'display_name' ]) || $_POST[ 'display_name' ] === '' ){
					$this->signal_error( __( 'Please fill out the registration form!', 'edd_fes' ) );
				}
				else{
					$userdata[ 'display_name' ] = sanitize_text_field( $_POST[ 'display_name' ] );
				}
			}

			if ( $this->search_array( $merged_user_meta, 'name', 'user_url' ) ) {
				if ( isset( $_POST[ 'user_url' ] ) ){
					$userdata[ 'user_url' ] = sanitize_text_field( $_POST[ 'user_url' ] );
				}
			}

			$userdata['ID'] = $user->ID;
			wp_update_user( $userdata );

		}
		// else if username + password field is valid user, login and continue
		else if ( $this->is_valid_user( $merged_user_meta ) ) {

			$userdata = array();
			if ( $this->search_array( $merged_user_meta, 'name', 'first_name' ) ) {
				if ( !isset($_POST[ 'first_name' ]) || $_POST[ 'first_name' ] === '' ){
					$this->signal_error( __( 'Please fill out the registration form!', 'edd_fes' ) );
				}
				else{
					$userdata[ 'first_name' ] = sanitize_text_field( $_POST[ 'first_name' ] );
				}
			}
			if ( $this->search_array( $merged_user_meta, 'name', 'last_name' ) ) {
				if ( !isset($_POST[ 'last_name' ]) || $_POST[ 'last_name' ] === '' ){
					$this->signal_error( __( 'Please fill out the registration form!', 'edd_fes' ) );
				}
				else{
					$userdata[ 'last_name' ] = sanitize_text_field( $_POST[ 'last_name' ] );
				}
			}
			if ( $this->search_array( $merged_user_meta, 'name', 'user_email' ) ) {
				if ( !isset($_POST[ 'user_email' ]) || $_POST[ 'user_email' ] === '' ){
					$this->signal_error( __( 'Please fill out the registration form!', 'edd_fes' ) );
				}
				if ( !is_email( $_POST[ 'user_email' ] ) ){
					$this->signal_error( __( 'Please enter a valid email!', 'edd_fes' ) );
				}
				else{
					$userdata[ 'user_email' ] = sanitize_email( $_POST[ 'user_email' ] );
				}
			}

			if ( $this->search_array( $merged_user_meta, 'name', 'display_name' ) ) {
				if ( !isset($_POST[ 'display_name' ]) || $_POST[ 'display_name' ] === '' ){
					$this->signal_error( __( 'Please fill out the registration form!', 'edd_fes' ) );
				}
				else{
					$userdata[ 'display_name' ] = sanitize_text_field( $_POST[ 'display_name' ] );
				}
			}

			if ( $this->search_array( $merged_user_meta, 'name', 'user_url' ) ) {
				if ( isset( $_POST[ 'user_url' ] ) ){
					$userdata[ 'user_url' ] = sanitize_text_field( $_POST[ 'user_url' ] );
				}
			}

			if ( $this->search_array( $merged_user_meta, 'name', 'description' ) ) {
				if ( isset( $_POST[ 'description' ] ) ){
					$userdata[ 'description' ] = wp_kses( $_POST[ 'description' ], fes_allowed_html_tags() );
				}
			}

			$user = get_user_by( 'login', $_REQUEST[ 'user_login' ] );

			if( $user ) {

				$userdata['ID'] = $user->ID;
				wp_update_user( $userdata );

				wp_set_auth_cookie( $user->ID, true );
				wp_set_current_user( $user->ID, $_REQUEST[ 'user_login' ] );
				do_action( 'wp_login', $_REQUEST[ 'user_login' ] );

			} else {

				$this->signal_error( __( 'Sorry! Registration is currently disabled at this time!', 'edd_fes' ) );

			}
		}
		// registration is disabled
		else if ( !(bool)EDD_FES()->helper->get_option( 'fes-allow-applications', true ) ) {

			$this->signal_error( __( 'Sorry! Registration is currently disabled at this time!', 'edd_fes' ) );

		} else {
			$userdata = array();
			if ( $this->search_array( $merged_user_meta, 'name', 'first_name' ) ) {
				if ( !isset($_POST[ 'first_name' ]) || $_POST[ 'first_name' ] === '' ){
					$this->signal_error( __( 'Please fill out the registration form!', 'edd_fes' ) );
				}
				else{
					$userdata[ 'first_name' ] = sanitize_text_field( $_POST[ 'first_name' ] );
				}
			}
			if ( $this->search_array( $merged_user_meta, 'name', 'last_name' ) ) {
				if ( !isset($_POST[ 'last_name' ]) || $_POST[ 'last_name' ] === '' ){
					$this->signal_error( __( 'Please fill out the registration form!', 'edd_fes' ) );
				}
				else{
					$userdata[ 'last_name' ] = sanitize_text_field( $_POST[ 'last_name' ] );
				}
			}
			if ( $this->search_array( $merged_user_meta, 'name', 'user_email' ) ) {
				if ( !isset($_POST[ 'user_email' ]) || $_POST[ 'user_email' ] === '' ){
					$this->signal_error( __( 'Please fill out the registration form!', 'edd_fes' ) );
				}
				if ( !is_email( $_POST[ 'user_email' ] ) ){
					$this->signal_error( __( 'Please enter a valid email!', 'edd_fes' ) );
				}
				else{
					$userdata[ 'user_email' ] = sanitize_email( $_POST[ 'user_email' ] );
				}
			}
			if ( $this->search_array( $merged_user_meta, 'name', 'user_login' ) ) {
				if ( !isset($_POST[ 'user_login' ]) || $_POST[ 'user_login' ] === '' ){
					$this->signal_error( __( 'Please fill out the registration form!', 'edd_fes' ) );
				}
				else{
					$userdata[ 'user_login' ] = sanitize_user( $_POST[ 'user_login' ] );
				}
			}
			if ( $this->search_array( $merged_user_meta, 'name', 'display_name' ) ) {
				if ( !isset($_POST[ 'display_name' ]) || $_POST[ 'display_name' ] === '' ){
					$this->signal_error( __( 'Please fill out the registration form!', 'edd_fes' ) );
				}
				else{
					$userdata[ 'display_name' ] = sanitize_text_field( $_POST[ 'display_name' ] );
				}
			}

			if ( $this->search_array( $merged_user_meta, 'name', 'user_url' ) ) {
				if ( isset( $_POST[ 'user_url' ] ) ){
					$userdata[ 'user_url' ] = sanitize_text_field( $_POST[ 'user_url' ] );
				}
			}

			if ( $this->search_array( $merged_user_meta, 'name', 'description' ) ) {
				if ( isset( $_POST[ 'description' ] ) ){
					$userdata[ 'description' ] = wp_kses( $_POST[ 'description' ], fes_allowed_html_tags() );
				}
			}

			// verify password
			if ( $pass_element = $this->search_array( $merged_user_meta, 'name', 'password' ) ) {
				$pass_element    = current( $pass_element );
				$password        = ( isset( $_POST[ 'pass1' ] ) ? sanitize_text_field( $_POST[ 'pass1' ] ) : '' );
				$password_repeat = ( isset( $_POST[ 'pass2' ] ) ? sanitize_text_field( $_POST[ 'pass2' ] ) : '' );
				// check only if it's filled
				if ( $pass_length = strlen( $password ) ) {
					// min length check
					if ( $pass_length < intval( $pass_element[ 'min_length' ] ) ) {
						$this->signal_error( sprintf( __( 'Password must be %s character long', 'edd_fes' ), $pass_element[ 'min_length' ] ) );
					}
					// repeat password check
					if ( isset( $_POST[ 'pass2' ] ) && ( $password != $password_repeat ) ) {
						$this->signal_error( __( 'Password didn\'t match', 'edd_fes' ) );
					}
					// password is good
					$userdata[ 'user_pass' ] = $password;
				}
			}

			// see if an account? If so log in
			$user = get_user_by( 'login', $userdata[ 'user_login' ] );
			if ( $user ) {
				$password = wp_check_password( $userdata[ 'user_pass' ] , $user->data->user_pass, $user->ID );
				// if username + password is account log them in
				if ( $password ) {
					wp_set_auth_cookie( $user->ID, true );
					wp_set_current_user( $user->ID, $userdata[ 'user_login' ] );
					do_action( 'wp_login', $userdata[ 'user_login' ] );
				}
				// else show username is in user & password incorrect
				else {
					$this->signal_error( __( 'Username already in use and password incorrect!', 'edd_fes' ) );
				}
			}
			// good to go, create an subscriber account and log them in
			else {
				$userdata[ 'role' ] = 'subscriber';
				$userdata[ 'user_registered' ] = date( 'Y-m-d H:i:s' );
				$user_id = wp_insert_user( $userdata );
				if ( is_wp_error( $user_id ) ) {
					$this->signal_error( $user_id->get_error_message() );
				}
				wp_new_user_notification( $user_id );
				$user = new WP_User( $user_id );
				$user_login = $userdata[ 'user_login'];
				// log the new user in
				wp_set_auth_cookie( $user_id, true );
				wp_set_current_user( $user_id, $user_login );
				do_action( 'wp_login', $user_login );
			}
		}


		// at this point should have user_id
		$user_id = get_current_user_id();

		// if auto approved
		if ( (bool)EDD_FES()->helper->get_option( 'fes-auto-approve-vendors', true ) ) {
			$role = 'frontend_vendor';
			// save app data to vendor
			$counter = 0;
			foreach ( $meta_vars as $meta ) {
				if ( $meta['name'] == 'password' ) {
					unset( $meta_vars[$counter] );
				}
				$counter++;
			}
			$this->update_user_meta( $meta_vars, $user_id );

			// email user
			$to = apply_filters('fes_registration_form_frontend_vendor_to', $userdata[ 'user_email' ], $userdata );
			$from_name = isset( $edd_options[ 'from_name' ] ) ? $edd_options[ 'from_name' ] : get_bloginfo( 'name' );
			$from_email = isset( $edd_options[ 'from_email' ] ) ? $edd_options[ 'from_email' ] : get_option( 'admin_email' );
			$subject = apply_filters('fes_registration_form_to_vendor_accepted_subject', __('Application Accepted', 'edd_fes' ) );
			$message = EDD_FES()->helper->get_option( 'fes-vendor-new-auto-vendor-email', '' );
			$type = "user";
			$id = $user_id;
			$args = array( 'permissions' => 'fes-vendor-new-auto-vendor-email-toggle');

			EDD_FES()->emails->send_email( $to, $from_name, $from_email, $subject, $message, $type, $id, $args );

			// add frontend_vendor role
			$user->add_role( 'frontend_vendor' );
			// remove pending_vendor role
			$user->remove_role( 'pending_vendor' );
			// redirect to dashboard
			$response = array(
				'success' => true,
				'redirect_to' => get_permalink( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ) ),
				'message' => __( 'Your Application has been Approved!', 'edd_fes' ),
				'is_post' => true
			);
			do_action('fes_registration_form_frontend_vendor', $user_id, $userdata);
			$response = apply_filters( 'fes_register_form_frontend_vendor', $response, $user_id, $form_id, $_REQUEST );
			echo json_encode( $response );
			exit;
			// else pending vendor
		} else {

			// save app data to vendor
			$counter = 0;
			foreach ( $meta_vars as $meta ) {
				if ( $meta['name'] == 'password' ) {
					unset( $meta_vars[$counter] );
				}
				$counter++;
			}
			$this->update_user_meta( $meta_vars, $user_id );

			// email admin
			$to = apply_filters('fes_registration_form_pending_vendor_to_admin', edd_get_admin_notice_emails(), $userdata );
			$from_name = isset( $edd_options[ 'from_name' ] ) ? $edd_options[ 'from_name' ] : get_bloginfo( 'name' );
			$from_email = isset( $edd_options[ 'from_email' ] ) ? $edd_options[ 'from_email' ] : get_option( 'admin_email' );
			$subject = apply_filters('fes_registration_form_to_admin_subject', __('New Vendor Application Received', 'edd_fes' ) );
			$message = EDD_FES()->helper->get_option( 'fes-admin-new-app-email', '' );
			$type = "user";
			$id = $user_id;
			$args = array( 'permissions' => 'fes-admin-new-app-email-toggle');
			EDD_FES()->emails->send_email( $to , $from_name, $from_email, $subject, $message, $type, $id, $args );

			// email user
			$to = apply_filters('fes_registration_form_pending_vendor_to', $userdata[ 'user_email' ], $userdata );
			$from_name = isset( $edd_options[ 'from_name' ] ) ? $edd_options[ 'from_name' ] : get_bloginfo( 'name' );
			$from_email = isset( $edd_options[ 'from_email' ] ) ? $edd_options[ 'from_email' ] : get_option( 'admin_email' );
			$subject = apply_filters('fes_registration_form_to_vendor_received_subject', __('Application Received', 'edd_fes' ) );
			$message = EDD_FES()->helper->get_option( 'fes-vendor-new-app-email', '' );
			$type = "user";
			$id = $user_id;
			$args = array( 'permissions' => 'fes-vendor-new-app-email-toggle');
			EDD_FES()->emails->send_email( $to , $from_name, $from_email, $subject, $message, $type, $id, $args );

			// add pending vendor cap
			$user->add_role( 'pending_vendor' );
			// redirect to app under view
			$response = array(
				'success' => true,
				'redirect_to' => get_permalink( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ) ),
				'message' => __( 'Application Submitted', 'edd_fes' ),
				'is_post' => true
			);
			do_action('fes_registration_form_pending_vendor', $user_id, $userdata);
			$response = apply_filters( 'fes_register_form_pending_vendor', $response, $user_id, $form_id, $_REQUEST );
			echo json_encode( $response );
			exit;
		}
	}

	function submit_submission_form( $id = 0, $values = array(), $args = array() ) {
		if ( is_admin() && ( !isset( $_REQUEST[ '_wpnonce' ] ) || !wp_verify_nonce( $_REQUEST[ '_wpnonce' ], 'fes-form-submission-form' ) ) ) {
			return;
		}
		global $edd_options;
		check_ajax_referer( 'fes-form-submission-form' );
		@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );

		$form_id       = isset( $_POST[ 'form_id' ] ) ? intval( $_POST[ 'form_id' ] ) : 0;
		$db_form_id = EDD_FES()->helper->get_option( 'fes-submission-form', false );
		if ( $form_id != $db_form_id ) {
			$response    = array(
				'success' => false,
				'redirect_to' => get_permalink( $_POST[ 'page_id' ] ),
				'message' => __( 'Access Denied: '.$form_id.' != '.$db_form_id , 'edd_fes' ),
				'is_post' => true
			);
			echo json_encode( $response );
			exit;
		}

		if ( !$id && isset( $_REQUEST['post_id'] ) && absint( $_REQUEST['post_id'] ) ) {
			$id = absint( $_REQUEST['post_id'] );
		}

		$user_id = get_current_user_id();
		$is_vendor = EDD_FES()->vendors->vendor_is_vendor( $user_id );
		$is_admin = EDD_FES()->vendors->vendor_is_admin( $user_id );

		// if they are not a vendor, admin, or in the backend
		if ( !$is_admin && !is_admin() && !$is_vendor ) {
			$response    = array(
				'success' => false,
				'redirect_to' => get_permalink( $_POST[ 'page_id' ] ),
				'message' => __( 'Access Denied' , 'edd_fes' ),
				'is_post' => true
			);
			echo json_encode( $response );
			exit;
		}

		if ( $id ) {
			$post = get_post( $id );
			$post_author = $post->post_author;
			// if they are not admin, in the admin, or the author of the post
			if ( !$is_admin && !is_admin() && $id !== 0 && ( $post_author !== $user_id ) ) {
				$response    = array(
					'success' => false,
					'redirect_to' => get_permalink( $_POST[ 'page_id' ] ),
					'message' => __( 'Access Denied' , 'edd_fes' ),
					'is_post' => true
				);
				echo json_encode( $response );
				exit;
			}
		}

		$form_vars     = $this->get_input_fields( $form_id );
		$form_settings = get_post_meta( $form_id, 'fes-form_settings', true );
		list( $post_vars, $taxonomy_vars, $meta_vars ) = $form_vars;

		// don't check captcha on post edit
		if ( !$id ) {
			// check recaptcha
			if ( $this->search_array( $post_vars, 'input_type', 'recaptcha' ) ) {
				$this->validate_re_captcha();
			}
		}

		$error = apply_filters( 'fes_submit_post_validate', '', $form_id );
		if ( !empty( $error ) ) {
			$this->signal_error( $error );
		}

		$pending = false;
		$new = true;
		$post_id = $id;

		if( ! empty( $post->post_status ) && 'publish' != $post->post_status ) {
			$status = $post->post_status;
		} else {
			$status = 'publish';
		}

		// already existing product
		if ( $id && is_object( get_post ( $id ) ) ) {
			$new = false;
			$post_id = $id;
			if ( ! EDD_FES()->helper->get_option( 'fes-auto-approve-edits', false ) ) {
				$pending = true;
				$status  = 'pending';
			}
		} else {
			if ( ! EDD_FES()->helper->get_option( 'fes-auto-approve-submissions', false ) ) {
				$pending = true;
				$status  = 'pending';
			}
		}

		$post_author = get_current_user_id();

		$postarr = array(
			'post_type' => 'download',
			'post_status' => $status,
			'post_author' => $post_author,
			'post_title' => isset( $_POST[ 'post_title' ] ) ? sanitize_text_field( trim( $_POST[ 'post_title' ] ) ) : '',
			'post_content' => isset( $_POST[ 'post_content' ] ) ? wp_kses( $_POST[ 'post_content' ], fes_allowed_html_tags() ) : '',
			'post_excerpt' => isset( $_POST[ 'post_excerpt' ] ) ? wp_kses( $_POST[ 'post_excerpt' ], fes_allowed_html_tags() ) : ''
		);
		if ( isset( $_POST[ 'category' ] ) ) {
			$category                   = $_POST[ 'category' ];
			$postarr[ 'post_category' ] = is_array( $category ) ? $category : array(
				$category
			);
		}
		if ( isset( $_POST[ 'tags' ] ) ) {
			$postarr[ 'tags_input' ] = explode( ',', $_POST[ 'tags' ] );
		}
		$postarr = apply_filters( 'fes_add_post_args', $postarr, $form_id, $form_settings, $form_vars );

		if ( $new ) {
			$post_id = wp_insert_post( $postarr );
		}
		else {
			$postarr['ID'] = $post_id;
			wp_update_post( $postarr );

		}

		if ( $post_id ) {
			self::update_post_meta( $meta_vars, $post_id );
			// set the post form_id for later usage
			update_post_meta( $post_id, '_fes-form_id', $form_id );
			// find our if any images in post content and associate them
			if ( !empty( $postarr[ 'post_content' ] ) ) {
				$dom = new DOMDocument();
				$dom->loadHTML( $postarr[ 'post_content' ] );
				$images = $dom->getElementsByTagName( 'img' );
				if ( $images->length ) {
					foreach ( $images as $img ) {
						$url           = $img->getAttribute( 'src' );
						$url           = str_replace( array(
								'"',
								"'",
								"\\"
							), '', $url );
						$attachment_id = fes_get_attachment_id_from_url( $url, $post_author );
						if ( $attachment_id ) {
							fes_associate_attachment( $attachment_id, $post_id );
						}
					}
				}
			}
			foreach ( $taxonomy_vars as $taxonomy ) {
				if ( isset( $_POST[ $taxonomy[ 'name' ] ] ) ) {
					if ( is_object_in_taxonomy( 'download', $taxonomy[ 'name' ] ) ) {
						$tax = $_POST[ $taxonomy[ 'name' ] ];
						// if it's not an array, make it one
						if ( !is_array( $tax ) ) {
							$tax = array(
								$tax
							);
						}
						if ( $taxonomy[ 'type' ] == 'text' ) {
							$hierarchical = array_map( 'trim', array_map( 'strip_tags', explode( ',', $_POST[ $taxonomy[ 'name' ] ] ) ) );
							wp_set_object_terms( $post_id, $hierarchical, $taxonomy[ 'name' ] );
						} else {
							if ( is_taxonomy_hierarchical( $taxonomy[ 'name' ] ) ) {
								wp_set_post_terms( $post_id, $_POST[ $taxonomy[ 'name' ] ], $taxonomy[ 'name' ] );
							} else {
								if ( $tax ) {
									$non_hierarchical = array();
									foreach ( $tax as $value ) {
										$term = get_term_by( 'id', $value, $taxonomy[ 'name' ] );
										if ( $term && !is_wp_error( $term ) ) {
											$non_hierarchical[] = $term->name;
										}
									}
									wp_set_post_terms( $post_id, $non_hierarchical, $taxonomy[ 'name' ] );
								}
							} // hierarchical
						} // is text
					} // is object tax
				} // isset tax
			}
			$options   = isset( $_POST[ 'option' ] ) ? $_POST[ 'option' ] : '';

			$files     = isset( $_POST[ 'files' ] ) ? $_POST[ 'files' ] : '';
			$prices    = array();
			$edd_files = array();
			if ( isset( $options ) && $options != '' ) {
				foreach ( $options as $key => $option ) {
					$prices[] = array(
						'name' => isset( $option[ 'description' ] ) ? sanitize_text_field( $option[ 'description' ] ) : '',
						'amount' => isset( $option[ 'price' ] ) ? $option[ 'price' ] : '',
					);
				}
				if ( !empty( $files ) ) {
					foreach ( $files as $key => $url ) {
						$edd_files[ $key ] = array(
							'name' => basename( $url ),
							'file' => $url,
							'condition' => $key
						);
					}
				}
			} elseif( !empty( $files ) ) {

				// For when there are no prices or option names allowed, https://github.com/chriscct7/edd-fes/issues/417

				foreach ( $files as $key => $url ) {
					$edd_files[ $key ] = array(
						'name' => basename( $url ),
						'file' => $url,
						'condition' => $key
					);
				}

			}

			do_action( 'fes_submission_form_save_custom_fields', $post_id );
			if ( count( $prices ) === 1 || count( $prices ) === 0 ) {
				if (!isset( $prices[ 0 ][ 'amount' ] ) ){
					 $prices[ 0 ][ 'amount' ] = "";
				}
				update_post_meta( $post_id, '_variable_pricing', 0 );
				update_post_meta( $post_id, 'edd_price', $prices[ 0 ][ 'amount' ] );
				update_post_meta( $post_id, 'edd_variable_prices', $prices ); // Save variable prices anyway so that price options are saved
			} else {
				update_post_meta( $post_id, '_variable_pricing', 1 );
				update_post_meta( $post_id, 'edd_variable_prices', $prices );

				if ( EDD_FES()->helper->get_option( 'fes-allow-multiple-purchase-mode', false ) ){
					update_post_meta( $post_id, '_edd_price_options_mode', '1' );
				}
			}
			if ( !empty( $files ) ) {
				$edd_files = apply_filters( 'fes_pre_files_save', $edd_files, $post_id );
				update_post_meta( $post_id, 'edd_download_files', $edd_files );
			}
			if ( EDD_FES()->integrations->is_commissions_active() && $new === true ) {
				$commission = array(
					'amount' => eddc_get_recipient_rate( 0, $post_author ),
					'user_id' => $post_author,
					'type' => 'percentage'
				);
				update_post_meta( $post_id, '_edd_commission_settings', $commission );
				update_post_meta( $post_id, '_edd_commisions_enabled', '1' );
			}
			do_action( 'fes_submit_submission_form_bottom', $post_id );

			$redirect_to = get_permalink( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ) );
			if ( EDD_FES()->vendors->vendor_can_edit_product( $post_id ) ){
				$redirect_to = add_query_arg( array(
					'task' => 'edit-product'
				), $redirect_to );

				$redirect_to = add_query_arg( array(
					'post_id' => $post_id
				), $redirect_to );
			}
			else{
				$redirect_to = add_query_arg( array(
					'task' => 'dashboard'
				), $redirect_to );
			}

			// Unset edd session
			EDD()->session->set( 'edd_fes_post_id', '' );

			if( $new ) {
				if ( $pending ) {
					// email admin
					$to = apply_filters('fes_submission_form_pending_to_admin', edd_get_admin_notice_emails(), $post_id );
					$from_name = isset( $edd_options[ 'from_name' ] ) ? $edd_options[ 'from_name' ] : get_bloginfo( 'name' );
					$from_email = isset( $edd_options[ 'from_email' ] ) ? $edd_options[ 'from_email' ] : get_option( 'admin_email' );
					$subject = apply_filters('fes_submission_form_to_admin_subject', __('New Submission Received', 'edd_fes' ) );
					$message = EDD_FES()->helper->get_option( 'fes-admin-new-submission-email', '' );
					$type = "post";
					$id = $post_id;
					$args = array( 'permissions' => 'fes-admin-new-submission-email-toggle');
					EDD_FES()->emails->send_email( $to , $from_name, $from_email, $subject, $message, $type, $id, $args );

					// email user
					$user = new WP_User( $user_id );
					$to = $user->user_email;
					$from_name = isset( $edd_options[ 'from_name' ] ) ? $edd_options[ 'from_name' ] : get_bloginfo( 'name' );
					$from_email = isset( $edd_options[ 'from_email' ] ) ? $edd_options[ 'from_email' ] : get_option( 'admin_email' );
					$subject = apply_filters('fes_submission_new_form_to_vendor_subject', __('Submission Received', 'edd_fes' ) );
					$message = EDD_FES()->helper->get_option( 'fes-vendor-new-submission-email', '' );
					$type = "post";
					$id = $post_id;
					$args = array( 'permissions' => 'fes-vendor-new-submission-email-toggle');
					EDD_FES()->emails->send_email( $to , $from_name, $from_email, $subject, $message, $type, $id, $args );
					do_action('fes_submission_form_new_pending', $post_id );
				}
				else{
					do_action('fes_submission_form_new_published', $post_id );
				}
			} else {
				// submission heading to pending
				if ( $pending ){
					// email admin
					$to = apply_filters('fes_submission_form_published_to_admin', edd_get_admin_notice_emails(), $post_id );
					$from_name = isset( $edd_options[ 'from_name' ] ) ? $edd_options[ 'from_name' ] : get_bloginfo( 'name' );
					$from_email = isset( $edd_options[ 'from_email' ] ) ? $edd_options[ 'from_email' ] : get_option( 'admin_email' );
					$subject = apply_filters('fes_submission_form_edit_to_admin_subject', __('New Submission Edit Received', 'edd_fes' ) );
					$message = EDD_FES()->helper->get_option( 'fes-admin-new-submission-edit-email', '' );
					$type = "post";
					$id = $post_id;
					$args = array( 'permissions' => 'fes-admin-new-submission-edit-email-toggle');
					EDD_FES()->emails->send_email( $to , $from_name, $from_email, $subject, $message, $type, $id, $args );
					do_action('fes_submission_form_edit_pending', $post_id );
				}
				else{
					do_action('fes_submission_form_edit_published', $post_id );
				}
			}

			$response = array(
				'success' => true,
				'redirect_to' => $redirect_to,
				'message' => __( 'Success!', 'edd_fes' ),
				'is_post' => true
			);
			$response = apply_filters( 'fes_add_post_redirect', $response, $post_id, $form_id );
			echo json_encode( $response );
			exit;
		}
		else {
			$this->signal_error( __( 'Something went wrong! Error 1049: Post ID not set. Possibly Database lock in place.', 'edd_fes' ) );
		}

	}

	function submit_profile_form( $id = false, $values = array(), $args = array() ) {
		if ( is_admin() && ( ( !isset( $_REQUEST[ '_wpnonce' ] ) || !wp_verify_nonce( $_REQUEST[ '_wpnonce' ], 'fes-form-update-profile' ) ) ) ) {
			return;
		}
		check_ajax_referer( 'fes-form-update-profile' );
		@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );

		$form_id   = isset( $_POST[ 'form_id' ] ) ? intval( $_POST[ 'form_id' ] ) : 0;
		$form_vars = $this->get_input_fields( $form_id );

		list( $user_vars, $taxonomy_vars, $meta_vars ) = $form_vars;

		$merged_user_meta = array_merge( $user_vars, $meta_vars );

		// if admin side lets get them out of the way
		if ( is_admin() && ! empty( $_REQUEST['is_admin'] ) && '1' == $_REQUEST['is_admin'] ) {

			$user = get_userdata( absint( $_REQUEST[ 'user_id' ] ) );

			if ( ! current_user_can( 'edit_users' ) ) {
				$response    = array(
					'success' => false,
					'redirect_to' => admin_url( 'admin.php?page=fes-vendors&vendor='.$user->ID.'&result=denied&action=edit' ),
					'message' => __( 'Access denied!' , 'edd_fes' ),
					'is_post' => true
				);
				$response    = apply_filters( 'fes_profile_form_denied_admin_redirect', $response, $user->ID, $form_id );
				do_action('fes_profile_form_denied_admin', $user->ID );
				echo json_encode( $response );
				exit;
			}

			$userdata = array();
			if ( $this->search_array( $merged_user_meta, 'name', 'first_name' ) ) {
				$userdata[ 'first_name' ] = $_POST[ 'first_name' ];
			}
			if ( $this->search_array( $merged_user_meta, 'name', 'last_name' ) ) {
				$userdata[ 'last_name' ] = $_POST[ 'last_name' ];
			}
			if ( $this->search_array( $merged_user_meta, 'name', 'user_email' ) ) {
				$userdata[ 'user_email' ] = $_POST[ 'user_email' ];
			}
			if ( $this->search_array( $merged_user_meta, 'name', 'display_name' ) ) {
				$userdata[ 'display_name' ] = $_REQUEST[ 'display_name' ];
			}
			if ( $this->search_array( $merged_user_meta, 'name', 'user_url' ) ) {
				if ( isset( $_POST[ 'user_url' ] ) ){
					$userdata[ 'user_url' ] = sanitize_text_field( $_POST[ 'user_url' ] );
				}
			}

			// check if password filled out
			// verify password
			if ( $pass_element = $this->search_array( $merged_user_meta, 'name', 'password' ) ) {
				$pass_element    = current( $pass_element );
				$password        = sanitize_text_field( $_POST[ 'pass1' ] );
				$password_repeat = sanitize_text_field( $_POST[ 'pass2' ] );
				// check only if it's filled
				if ( $pass_length = strlen( $password ) ) {
					// min length check
					if ( $pass_length < intval( $pass_element[ 'min_length' ] ) ) {
						$this->signal_error( sprintf( __( 'Password must be %s character long', 'edd_fes' ), $pass_element[ 'min_length' ] ) );
					}
					// repeat password check
					if ( $password != $password_repeat ) {
						$this->signal_error( __( 'Password didn\'t match', 'edd_fes' ) );
					}
					// seems like he want to change the password
					$userdata[ 'user_pass' ] = $password;
				}
			}

			$userdata['ID'] = $user->ID;
			wp_update_user( $userdata );

			// save app data to vendor
			$counter = 0;
			foreach ( $merged_user_meta as $meta ) {
				if ( $meta['name'] == 'password' ) {
					unset( $merged_user_meta[$counter] );
				}
				$counter++;
			}

			$this->update_user_meta( $merged_user_meta, $user->ID );

			// redirect to dashboard
			$response    = array(
				'success' => true,
				'redirect_to' => admin_url( 'admin.php?page=fes-vendors&vendor='.$user->ID.'&result=success&action=edit' ),
				'message' => __( 'Successfully Updated' , 'edd_fes' ),
				'is_post' => true
			);
			$response    = apply_filters( 'fes_profile_form_admin_redirect', $response, $user->ID, $form_id );

			do_action('fes_profile_form_admin_success', $user->ID );

			echo json_encode( $response );

			exit;

		}

		if ( $id && absint( $_REQUEST['user_id'] ) ) {
			$id = absint( $_REQUEST['user_id'] );
		} else {
			$id = 0;
		}

		$user_id = get_current_user_id();
		$is_vendor = EDD_FES()->vendors->vendor_is_vendor( $user_id );
		$is_admin = EDD_FES()->vendors->vendor_is_admin( $user_id );

		// if they are not a vendor, admin, or in the backend or vendor != the vendor being looked at
		if ( !$is_admin && !is_admin() && !$is_vendor || ( $user_id !== $id && !is_admin() && !$is_admin ) ) {
			$response    = array(
				'success' => false,
				'redirect_to' => get_permalink( $_POST[ 'page_id' ] ),
				'message' => __( 'Access Denied' , 'edd_fes' ),
				'is_post' => false
			);
			echo json_encode( $response );
			exit;
		}

		$db_form_id = EDD_FES()->helper->get_option( 'fes-profile-form', false );

		if ( $form_id != $db_form_id ) {
			$response    = array(
				'success' => false,
				'redirect_to' => get_permalink( $_POST[ 'page_id' ] ),
				'message' => __( 'Access Denied: '.$form_id.' != '.$db_form_id , 'edd_fes' ),
				'is_post' => true
			);
			echo json_encode( $response );
			exit;
		}

		$userdata = array(
			'ID' => $user_id
		);

		if ( $this->search_array( $merged_user_meta, 'name', 'first_name' ) ) {
			$userdata[ 'first_name' ] = sanitize_text_field( $_POST[ 'first_name' ] );
		}
		if ( $this->search_array( $merged_user_meta, 'name', 'last_name' ) ) {
			$userdata[ 'last_name' ] = sanitize_text_field( $_POST[ 'last_name' ] );
		}
		if ( $this->search_array( $merged_user_meta, 'name', 'user_email' ) ) {
			if ( !is_email( $_POST[ 'user_email' ] ) ){
				$this->signal_error( __( 'Please enter a valid email!', 'edd_fes' ) );
			} else{
				$userdata[ 'user_email' ] = sanitize_email( $_POST[ 'user_email' ] );
			}
		}
		if ( $this->search_array( $merged_user_meta, 'name', 'user_login' ) && isset( $_POST[ 'user_login' ] ) ) {
			$userdata[ 'user_login' ] = sanitize_user( $_POST[ 'user_login' ] );
		}
		if ( $this->search_array( $merged_user_meta, 'name', 'display_name' ) ) {
			$userdata[ 'display_name' ] = sanitize_text_field( $_POST[ 'display_name' ] );
		}
		if ( $this->search_array( $merged_user_meta, 'name', 'nickname' ) ) {
			$userdata[ 'nickname' ] = sanitize_text_field( $_POST[ 'nickname' ] );
		}
		if ( $this->search_array( $merged_user_meta, 'name', 'user_url' ) ) {
			$userdata[ 'user_url' ] = esc_url_raw( $_POST[ 'user_url' ] );
		}
		if ( $this->search_array( $merged_user_meta, 'name', 'description' ) ) {
			$userdata[ 'description' ] = $_POST[ 'description' ];
		}

		// check if password filled out
		// verify password
		if ( $pass_element = $this->search_array( $merged_user_meta, 'name', 'password' ) ) {
			$pass_element    = current( $pass_element );
			$password        = sanitize_text_field( $_POST[ 'pass1' ] );
			$password_repeat = sanitize_text_field( $_POST[ 'pass2' ] );
			// check only if it's filled
			if ( $pass_length = strlen( $password ) ) {
				// min length check
				if ( $pass_length < intval( $pass_element[ 'min_length' ] ) ) {
					$this->signal_error( sprintf( __( 'Password must be %s character long', 'edd_fes' ), $pass_element[ 'min_length' ] ) );
				}
				// repeat password check
				if ( $password != $password_repeat ) {
					$this->signal_error( __( 'Password didn\'t match', 'edd_fes' ) );
				}
				// seems like he want to change the password
				$userdata[ 'user_pass' ] = $password;
			}
		}
		$userdata = apply_filters( 'fes_update_profile_vars', $userdata, $form_id );
		$user_id  = wp_update_user( $userdata );
		if ( $user_id ) {
			// update meta fields
			$counter = 0;
			foreach ( $merged_user_meta as $meta ) {
				if ( $meta['name'] == 'password' ) {
					unset( $merged_user_meta[$counter] );
				}
				$counter++;
			}
			//echo json_encode( $merged_user_meta ); exit;
			$this->update_user_meta( $merged_user_meta, $user_id );
			do_action( 'fes_update_profile', $user_id, $form_id );
		}
		//redirect URL
		$redirect_to = get_permalink( $_POST[ 'page_id' ] );
		$redirect_to = add_query_arg( array(
				'task' => 'profile'
			), $redirect_to );
		// send the response
		$response    = array(
			'success' => true,
			'redirect_to' => $redirect_to,
			'message' => __( 'Profile Successfully Updated' , 'edd_fes' ),
			'is_post' => false
		);
		$response    = apply_filters( 'fes_profile_form_redirect', $response, $user_id, $form_id );
		do_action('fes_profile_form_success', $user_id );
		echo json_encode( $response );
		exit;
	}

	// types of forms:
	// login: 1
	// register: 1
	// application: 1
	// profile: 1
	// submission form: 6 (new,pending,denied,need feedback, edit,del, preview)

	// retrieve fields
	public static function get_input_fields( $form_id ) {
		$form_vars = get_post_meta( $form_id, 'fes-form', true );

		$ignore_lists = array( 'section_break', 'html' );
		$post_vars = $meta_vars = $taxonomy_vars = array();
		if ( $form_vars == null ) {
			return array( array(), array(), array() );
		}
		foreach ( $form_vars as $key => $value ) {

			// ignore section break and HTML input type
			if ( in_array( $value['input_type'], $ignore_lists ) ) {
				continue;
			}

			//separate the post and custom fields
			if ( isset( $value['is_meta'] ) && $value['is_meta'] == 'yes' ) {
				$meta_vars[] = $value;
				continue;
			}

			if ( $value['input_type'] == 'taxonomy' ) {

				// don't add "category"
				if ( $value['name'] == 'category' ) {
					continue;
				}

				$taxonomy_vars[] = $value;
			} else {
				$post_vars[] = $value;
			}
		}

		return array( $post_vars, $taxonomy_vars, $meta_vars );
	}

	public function is_valid_user( $user_vars ) {
		$userdata = array();
		// verify password
		if ( $pass_element = $this->search_array( $user_vars, 'name', 'password' ) ) {
			$pass_element    = current( $pass_element );
			$password        = ( isset( $_POST[ 'pass1' ] ) ? sanitize_text_field( $_POST[ 'pass1' ] ) : '' );
			$password_repeat = ( isset( $_POST[ 'pass2' ] ) ? sanitize_text_field( $_POST[ 'pass2' ] ) : false );
			// check only if it's filled
			if ( $pass_length = strlen( $password ) ) {
				// min length check
				if ( $pass_length < intval( $pass_element[ 'min_length' ] ) ) {
					return false;
				}
				// repeat password check
				if ( $password_repeat && ( $password !== $password_repeat ) ) {
					return false;
				}
				// password is good
				$userdata[ 'password' ] = $password;
			}
		}
		if ( $this->search_array( $user_vars, 'name', 'user_login' ) ) {
			$userdata[ 'username' ] = $_REQUEST[ 'user_login' ];
		}
		else {
			return false;
		}
		// see if an account? If so log in
		$user = get_user_by( 'login', $userdata[ 'username' ] );
		if ( $user ) {
			$password = wp_check_password( $userdata[ 'password' ] , $user->data->user_pass, $user->ID );
			if ( $password ) {
				return true;
			}
			else {
				return false;
			}
		}
		return false;
	}

	public static function prepare_meta_fields( $meta_vars ) {
		// loop through custom fields
		// skip files, put in a key => value paired array for later executation
		// process repeatable fields separately
		// if the input is array type, implode with separator in a field

		$files = array();
		$meta_key_value = array();

		foreach ( $meta_vars as $key => $value ) {

			// put files in a separate array, we'll process it later
			if ( ( $value['input_type'] == 'file_upload' ) || ( $value['input_type'] == 'image_upload' ) ) {

				$files[] = array(
					'name' => $value['name'],
					'value' => isset( $_POST['fes_files'][$value['name']] ) ? $_POST['fes_files'][$value['name']] : array()
				);

				// process repeatable fiels
			} elseif ( $value['input_type'] == 'repeat' ) {

				// if it is a multi column repeat field
				if ( isset( $value['multiple'] ) ) {

					// if there's any items in the array, process it
					if ( isset( $_POST[$value['name']] ) ) {

						$meta_key_value[$value['name']] = $_POST[$value['name']];

					}

				} else {
					$meta_key_value[$value['name']] = implode( '| ', $_POST[$value['name']] );
				}

				// process other fields
			} else {

				// if it's an array, implode with this->separator
				if ( ! empty( $_POST[$value['name']] ) && is_array( $_POST[$value['name']] ) ) {
					$meta_key_value[$value['name']] = implode( '| ', $_POST[$value['name']] );
				} else {
					if( ! empty( $_POST[ $value['name'] ] ) ) {

						$meta_key_value[$value['name']] = trim( $_POST[$value['name']] );

					} else {

						$meta_key_value[$value['name']] = '';

					}
				}
			}
		} //end foreach

		return array( $meta_key_value, $files );
	}

	// make fields
	/**
	 * Render form items
	 *
	 * @param array   $form_vars
	 * @param int|null post or user id
	 * @param string  $type      type of the form. submission, profile, application, login, register, vendor_contact
	 */
	function render_items( $form_vars = array(), $id = 0, $type = 'submission', $form_id = 0, $read_only = false, $args = array() ) {
		$hidden_fields = array();
		$edit_ignore = array();

		if ( $type == 'submission' ) {
			$edit_ignore = array( 'recaptcha' );
		}

		if ( $type == 'registration' && is_user_logged_in() ) {
			$edit_ignore = array( 'user_login', 'password', 'user_email' );
		}

		if ( !$form_vars ) {
			return _e( 'Form has no fields!', 'edd_fes' );
		}

		$edit_ignore = apply_filters( 'fes_forms_edit_ignore', $edit_ignore, $form_vars, $id, $type, $form_id, $read_only, $args );
		$hidden_fields = apply_filters( 'fes_forms_hidden_fields_before', $hidden_fields, $form_vars, $id, $type, $form_id, $read_only, $args );

		foreach ( $form_vars as $key => $form_field ) {

			// don't show captcha in edit page
			if ( $type == 'submission' && isset( $form_field['input_type'] ) && in_array( $form_field['input_type'], $edit_ignore ) && ! empty( $id ) ) {
				continue;
			}

			// Don't show the email, username or password fields to already logged in users.
			if ( $type == 'registration' && isset( $form_field['name'] ) && in_array( $form_field['name'], $edit_ignore ) ) {
				continue;
			}

			if ( $type == 'login' && !EDD_FES()->helper->get_option( 'fes-allow-customer-login', true ) && isset( $form_field['input_type'] ) && $form_field['input_type'] == 'radio' ) {
				continue;
			}

			if ( $type == 'login' && !EDD_FES()->helper->get_option( 'fes-login-captcha', false ) && isset( $form_field['input_type'] ) && $form_field['input_type'] == 'recaptcha'  ) {
				continue;
			}

			if ( $type == 'vendor-contact' && !EDD_FES()->helper->get_option( 'fes-vendor-contact-captcha', false ) && isset( $form_field['input_type'] ) && $form_field['input_type'] == 'recaptcha'  ) {
				continue;
			}

			if ( $form_field['input_type'] == 'toc'  ){
				$value = $id ? $this->get_meta( $id, 'fes_accept_toc', $type, true ) : 0;
				if ( $value ){
					$hidden_fields[] = $form_field;
					continue; // don't reshow toc once they've agreed to it
				}
			}

			// ignore the hidden fields
			if ( $form_field['input_type'] == 'hidden' ) {
				$hidden_fields[] = $form_field;
				continue;
			}

			if ( $read_only ) {
				if ( $form_field['input_type'] == 'hidden' || $form_field['input_type'] == 'recaptcha' || $form_field['input_type'] == 'toc' ) {
					$hidden_fields[] = $form_field;
					continue;
				}
			}

			$label_exclude = array( 'section_break', 'html', 'action_hook', 'toc' );
			$el_name       = ! empty( $form_field['name'] ) ? $form_field['name'] : '';
			$class_name    = ! empty( $form_field['css'] ) ? ' ' . $form_field['css'] : '';

			do_action('fes_before_fieldset_output', $form_vars, $id, $type, $form_id, $read_only, $args );

			printf( '<fieldset class="fes-el %s%s">', $el_name, $class_name );

			do_action('fes_after_fieldset_output', $form_vars, $id, $type, $form_id, $read_only, $args );

			if ( isset( $form_field['input_type'] ) && !in_array( $form_field['input_type'], $label_exclude ) ) {

				do_action('fes_before_label_output', $form_vars, $id, $type, $form_id, $read_only, $args );

				$label = $this->label( $form_field, $id );

				echo apply_filters('fes_forms_label_wrap', $label, $form_vars, $id, $type, $form_id, $read_only, $args );

				do_action('fes_after_label_output', $form_vars, $id, $type, $form_id, $read_only, $args );

			}

			if( is_admin() && EDD_FES()->vendors->vendor_is_admin( get_current_user_id() ) && ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) ) {
				$form_field['required'] = 'no';
			}

			do_action('fes_after_label_output', $form_vars, $id, $type, $form_id, $read_only, $args );

			switch ( $form_field['input_type'] ) {
				case 'text':
					do_action('fes_before_text_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					$field = $this->text( $form_field, $id, $type );
					echo apply_filters('fes_forms_text_wrap', $field, $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action('fes_after_text_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;

				case 'textarea':
					do_action('fes_before_textarea_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					$field = $this->textarea( $form_field, $id, $type );
					echo apply_filters('fes_forms_textarea_wrap', $field, $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action('fes_after_textarea_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;

				case 'image_upload':
					do_action('fes_before_image_upload_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					if ( function_exists( 'wp_enqueue_media' ) ) {
						wp_enqueue_media();
					} else {
						wp_enqueue_script( 'media-upload' );
					}
					$field = $this->image_upload( $form_field, $id, $type );
					echo apply_filters('fes_forms_image_upload_wrap', $field, $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action('fes_after_image_upload_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;

				case 'select':
					do_action('fes_before_select_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					$field = $this->select( $form_field, false, $id, $type );
					echo apply_filters('fes_forms_select_wrap', $field, $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action('fes_after_select_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;

				case 'multiselect':
					do_action('fes_before_multiselect_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					$field = $this->select( $form_field, true, $id, $type );
					echo apply_filters('fes_forms_multiselect_wrap', $field, $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action('fes_after_multiselect_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;

				case 'radio':
					do_action('fes_before_radio_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					$field = $this->radio( $form_field, $id, $type );
					echo apply_filters('fes_forms_radio_wrap', $field, $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action('fes_after_radio_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;

				case 'checkbox':
					do_action('fes_before_checkbox_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					$field = $this->checkbox( $form_field, $id, $type );
					echo apply_filters('fes_forms_checkbox_wrap', $field, $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action('fes_after_checkbox_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;

				case 'file_upload':
					do_action('fes_before_file_upload_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					$field = $this->file_upload( $form_field, $id, $type );
					echo apply_filters('fes_forms_file_upload_wrap', $field, $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action('fes_after_file_upload_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;

				case 'url':
					do_action('fes_before_url_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					$field = $this->url( $form_field, $id, $type );
					echo apply_filters('fes_forms_url_wrap', $field, $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action('fes_after_url_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;

				case 'email':
					do_action('fes_before_email_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					$field = $this->email( $form_field, $id, $type );
					echo apply_filters('fes_forms_email_wrap', $field, $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action('fes_after_email_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;

				case 'password':
					do_action('fes_before_password_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					$field = $this->password( $form_field, $id, $type );
					echo apply_filters('fes_forms_password_wrap', $field, $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action('fes_after_password_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;

				case 'repeat':
					do_action('fes_before_repeat_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					$field = $this->repeat( $form_field, $id, $type );
					echo apply_filters('fes_forms_repeat_wrap', $field, $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action('fes_after_repeat_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;

				case 'taxonomy':
					do_action('fes_before_taxonomy_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					$field = $this->taxonomy( $form_field, $id, $type );
					echo apply_filters('fes_forms_taxonomy_wrap', $field, $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action('fes_after_taxonomy_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;

				case 'section_break':
					do_action('fes_before_section_break_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					$field = $this->section_break( $form_field, $id );
					echo apply_filters('fes_forms_section_break_wrap', $field, $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action('fes_after_section_break_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;

				case 'html':
					do_action('fes_before_html_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					$field = $this->html( $form_field );
					echo apply_filters('fes_forms_html_wrap', $field, $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action('fes_after_html_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;

				case 'recaptcha':
					do_action('fes_before_recaptcha_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					$field = $this->recaptcha( $form_field, $id, $type );
					echo apply_filters('fes_forms_recaptcha_wrap', $field, $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action('fes_after_recaptcha_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;

				case 'action_hook':
					do_action('fes_before_action_hook_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					$field = $this->action_hook( $form_field, $form_id, $id, $type );
					echo apply_filters('fes_forms_action_hook_wrap', $field, $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action('fes_after_action_hook_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;

				case 'date':
					do_action('fes_before_date_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					$field = $this->date( $form_field, $id, $type );
					echo apply_filters('fes_forms_date_wrap', $field, $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action('fes_after_date_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;

				case 'toc':
					do_action('fes_before_toc_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					$field = $this->toc( $form_field, $id, $type );
					echo apply_filters('fes_forms_toc_wrap', $field, $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action('fes_after_toc_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;

				case 'multiple_pricing':
					do_action('fes_before_multiple_pricing_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					$field = $this->multiple_pricing( $form_field, $id );
					echo apply_filters('fes_forms_multiple_pricing_wrap', $field, $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action('fes_after_multiple_pricing_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;

				default:
					do_action('fes_before_'.$form_field['name'].'_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					do_action( 'fes_render_field_'.$form_field['name'], $form_field, $id, $type );
					do_action('fes_after_'.$form_field['name'].'_output', $form_vars, $id, $type, $form_id, $read_only, $args );
					break;
			}
			do_action('fes_before_fieldset_output_ends', $form_vars, $id, $type, $form_id, $read_only, $args );
			echo '</fieldset>';
			do_action('fes_after_fieldset_output_ends', $form_vars, $id, $type, $form_id, $read_only, $args );
		}
		$hidden_fields = apply_filters( 'fes_forms_hidden_fields_after', $hidden_fields, $form_vars, $id, $type, $form_id, $read_only, $args );
		if ( $hidden_fields ) {
			foreach ( $hidden_fields as $field ) {
				do_action('fes_before_hidden_field_output', $form_vars, $id, $type, $form_id, $read_only, $args );
				$name = isset( $field['name']  ) ? $field['name'] : "";
				$meta_value = isset( $field['meta_value']  ) ? $field['meta_value'] : "";
				printf( '<input type="hidden" name="%s" value="%s">', esc_attr( $name ), esc_attr( $meta_value ) );
				echo "\r\n";
				do_action('fes_after_hidden_field_output', $form_vars, $id, $type, $form_id, $read_only, $args );
			}
		}
	}

	// load fields
	/**
	 * Prints a text field
	 *
	 * @param array   $attr
	 * @param int|null $id Post or User ID
	 */
	function text( $attr, $id, $type = 'submission' ) {
		// checking for user profile username
		$username = false;
		$taxonomy = false;
		$value = '';

		if ( $id ) {
			if ( $this->is_meta( $attr ) ) {
				$value = $this->get_meta( $id, $attr['name'], $type );

				if ( $type !== 'registration' && $type !== 'login' && isset( $attr['template'] ) && $attr['template'] == 'user_login' ) {
					$username = true;
				}
			} else {
				// applicable for post tags
				if ( $type == 'submission' && $attr['name'] == 'tags' ) {
					$post_tags = wp_get_post_tags( $id );
					$tagsarray = array();
					foreach ( $post_tags as $tag ) {
						$tagsarray[] = $tag->name;
					}

					$value = implode( ', ', $tagsarray );
					$taxonomy = true;
				} elseif ( $type == 'submission' ) {
					$value = get_post_field( $attr['name'], $id );
				} elseif ( $type == 'user' || $type == 'registration'  || $type == 'profile' ) {
					$value = get_user_by( 'id', $id )->$attr['name'];

					if ( $type !== 'registration' && $type !== 'login' && isset( $attr['template'] ) && $attr['template'] == 'user_login' ) {
						$username = true;
					}
				}
			}
		} else {

			$value = ! empty( $attr['default'] ) ? $attr['default'] : '';

			if ( $type == 'submission' && $attr['name'] == 'tags' ) {
				$taxonomy = true;
			}
		}

		if( is_user_logged_in() && $type == 'registration' ) {

			if( is_admin() && ! empty( $id ) ) {

				$user_data = get_userdata( $id );

			} else {

				$user_data = get_userdata( get_current_user_id() );

			}

			if ( $attr['name'] == 'first_name' ) {
				$value = $user_data->first_name;
			}

			if ( $attr['name'] == 'last_name' ) {
				$value = $user_data->last_name;
			}

			if ( $attr['name'] == 'email_address' ) {
				$value = $user_data->user_email;
			}

			if ( $attr['name'] == 'display_name' ) {
				$value = $user_data->display_name;
			}

		}

		if( empty( $attr['placeholder'] ) ) {
			$attr['placeholder'] = '';
		}

		ob_start(); ?>

        <div class="fes-fields">
            <input class="textfield<?php echo $this->required_class( $attr ); ?>" id="<?php echo $attr['name']; ?>" type="text" data-required="<?php echo $attr['required'] ?>" data-type="text"<?php $this->required_html5( $attr ); ?> name="<?php echo esc_attr( $attr['name'] ); ?>" placeholder="<?php echo esc_attr( $attr['placeholder'] ); ?>" value="<?php echo esc_attr( $value ) ?>" size="<?php echo esc_attr( $attr['size'] ) ?>" <?php echo $username ? 'disabled' : ''; ?> />
            <?php if ( $taxonomy ) { ?>
            <script type="text/javascript">
                jQuery(function($) {
                    $('fieldset.tags input[name=tags]').suggest( fes_form.ajaxurl + '?action=ajax-tag-search_array&tax=post_tag', { delay: 500, minchars: 2, multiple: true, multipleSep: ', ' } );
                });
            </script>
            <?php } ?>
        </div>

        <?php
        return ob_get_clean();
	}

	/**
	 * Prints a textarea field
	 *
	 * @param array   $attr
	 * @param int|null $id Post or User ID
	 */
	function textarea( $attr, $id, $type = 'submission' ) {
		$req_class = ( isset( $attr['required'] ) && $attr['required'] == 'yes' ) ? 'required' : 'rich-editor';

		if ( $id  && $type != 'vendor-contact' ) {
			if ( $this->is_meta( $attr ) ) {
				$value = $this->get_meta( $id, $attr['name'], $type, true );
			} else {
				if ( $type == 'submission' ) {
					$value = get_post_field( $attr['name'], $id );
				} else {
					$value = $this->get_user_data( $id, $attr['name'] );
				}
			}
		} else {
			$value = $attr['default'];
		}
		if ( !isset( $attr['cols'] ) ){
			$attr['cols'] = 50;
		}
		if ( !isset( $attr['rows'] ) ){
			$attr['rows'] = 8;
		}
		ob_start();
?>

        <div class="fes-fields">
        <?php

		$rich = isset( $attr['rich'] ) ? $attr['rich'] : '';

		if ( $rich == 'yes' ) {
			$options = array( 'editor_height' => $attr['rows'], 'quicktags' => false, 'editor_class' => $req_class );
			if (isset($attr['insert_image']) && $attr['insert_image']){
				$options['media_buttons'] = true;
			}
			printf( '<span class="fes-rich-validation" data-required="%s" data-type="rich" data-id="%s"></span>', $attr['required'], $attr['name'] );
			wp_editor( $value, $attr['name'], $options );

		} elseif ( $rich == 'teeny' ) {
			$options = array( 'editor_height' => $attr['rows'], 'quicktags' => false, 'teeny' => true, 'editor_class' => $req_class);
			if ($attr['insert_image']){
				$options['media_buttons'] = true;
			}
			printf( '<span class="fes-rich-validation" data-required="%s" data-type="rich" data-id="%s"></span>', $attr['required'], $attr['name'] );
			wp_editor( $value, $attr['name'], $options );
		} else {
?>
                <textarea class="textareafield<?php echo $this->required_class( $attr ); ?>" id="<?php echo $attr['name']; ?>" name="<?php echo $attr['name']; ?>" data-required="<?php echo $attr['required'] ?>" data-type="textarea"<?php $this->required_html5( $attr ); ?> placeholder="<?php echo esc_attr( $attr['placeholder'] ); ?>" rows="<?php echo esc_attr( $attr['rows'] ); ?>" cols="<?php echo esc_attr( $attr['cols'] ); ?>"><?php echo esc_textarea( $value ) ?></textarea>
            <?php } ?>
        </div>

        <?php
        return ob_get_clean();
	}

	/**
	 * Prints a multiple pricing field
	 *
	 * @param array   $attr
	 * @param int|null $post_id
	 */
	function multiple_pricing( $attr, $post_id = 0 ) {
		// this system of letters should just be replaced with booleans. It would make this whole thing way simpler.
		$attr['names'] = $attr && isset($attr['names']) ? strtolower( $attr['names'] ) : '';
		$names_disabled = $attr && isset($attr['names']) && $attr['names'] !== 'no' ? false : true;
		$attr['prices'] = $attr && isset($attr['prices']) ? strtolower( $attr['prices'] ) : '';
    	$prices_disabled = $attr && isset($attr['prices']) && $attr['prices'] !== 'no' ? false : true;
    	$attr['files'] = $attr && isset($attr['files']) ? strtolower( $attr['files'] ) : '';
    	$files_disabled = $attr && isset($attr['files']) && $attr['files'] !== 'no' ? false : true;

    	$predefined_on = $attr && isset($attr['multiple']) && $attr['multiple'] !== 'false' ? true : false;

		$predefined_options = $attr && isset($attr['files']) ? esc_attr( $attr['files'] ) : false;

		if ( $post_id ) {
			$files = get_post_meta( $post_id, 'edd_download_files', true );
			$prices = get_post_meta( $post_id, 'edd_variable_prices', true );
			$is_variable = (bool) get_post_meta( $post_id, '_variable_pricing', true );
			$combos = array();
			if ( $is_variable ) {
				$counter = 0;
				foreach ( $prices as $key => $option ) {
					$file  = ( isset( $files[$counter] ) && isset( $files[$counter]['file'] )? $files[$counter]['file'] : '' );
					$price = ( isset( $option['amount'] )? $option['amount'] : '' );
					$desc  = ( isset( $option['name'] )? $option['name'] : '' );
					$combos[$key] = array( 'description' => $desc, 'price' => $price, 'files' => $file );
					$counter++;
				}
			} else {
				$file = ( isset( $files[0]['file'] )? $files[0]['file'] : '' );
				$desc = ( isset( $prices[0]['name'] )? $prices[0]['name'] : '' );
				$price = get_post_meta( $post_id, 'edd_price', true );
				$combos = array ( 0 => array( 'description' => $desc, 'price' => $price, 'files' => $file ) );
			}
		} else {
			if ( $predefined_on && isset( $attr['columns'] ) && $attr['columns'] > 0 ){
				$keys = count( $attr['columns'] );
	            $new_values = array();
	            $key = 0;
	            foreach ( $attr['columns'] as $old_key => $value ){
	                if ( $old_key === 0 || $old_key % 2 == 0 ){
	                    $new_values[$key]['description'] = $value['name'];
	                    $new_values[$key]['files'] = '';
	                }
	                else{
	                     $new_values[$key]['price'] = $value['price'];
	                     $key++;
	                }
	                unset( $attr[$old_key] );
	            }
	            $combos = $new_values;
	        }
            else{
				$combos = array( 0 => array( 'description' => '', 'price' => '', 'files' => '' ) );
            }
		}

		$files = $combos;
		ob_start();
		?>
		<div class="fes-fields">
			<table class="<?php echo sanitize_key($attr['name']); ?>">
				<thead>
					<tr>
						<?php if ( $attr[ 'single' ] !== 'yes' && (!$names_disabled || $predefined_on)  ) { ?>
							<td class="fes-name-column"><?php _e( 'Name of Price Option', 'edd_fes' ); ?></td>
						<?php } ?>
						<?php if ( !$prices_disabled || $predefined_on ) { ?>
							<td class="fes-price-column"><?php printf( __( 'Amount (%s)', 'edd_fes' ), edd_currency_filter( '' ) ); ?></td>
						<?php } ?>
						<?php if ( !$files_disabled ) { ?>
							<td class="fes-file-column" colspan="2"><?php _e( 'File URL', 'edd_fes' ); ?></td>
						<?php } ?>
						<?php do_action("fes-add-multiple-pricing-column"); ?>
						<?php if ( $attr[ 'single' ] === 'yes' || $predefined_on ) { ?>
							<td class="fes-remove-column">&nbsp;</td>
						<?php } ?>
					</tr>
				</thead>
				<tbody  class="fes-variations-list-<?php echo sanitize_key($attr['name']); ?>">
				<?php
				foreach ( $files as $index => $file ){
					if ( ! is_array( $file ) ) {
						$file = array(
							'file' => '',
							'description' => '',
							'price' => ''
						);
						$file = apply_filters('fes_default_new_multiple_price_row_values', $file );
					}
					$price = isset( $file['price'] ) && $file['price'] != '' ? $file['price'] : '';
					$description = isset( $file['description'] ) && $file['description'] != '' ? $file['description'] : '';
					$download = isset( $file['files'] ) && $file['files'] != '' ? $file['files'] : '';

					$price = apply_filters('fes_multiple_price_row_price_value', $price, $file );
					$description = apply_filters('fes_multiple_price_row_description_value', $description, $file );
					$download = apply_filters('fes_multiple_price_row_download_value', $download, $file );

					$required = ! empty( $attr['required'] ) && 'yes' == $attr['required'] ? 'data-required="yes" data-type="multiple"' : '';

					?>
					<tr class="fes-single-variation" id="fes-multiple-validation-pointer">
						<?php if ( $attr[ 'single' ] !== 'yes' && (!$names_disabled || $predefined_on) ) { ?>
						<td class="fes-name-row">
							<?php if( $names_disabled ) : ?>
								<span class="fes-name-value"><?php echo esc_attr( $description ); ?></span>
								<input type="hidden" class="fes-name-value" name="option[<?php echo esc_attr( $index ); ?>][description]" id="options[<?php echo esc_attr( $index ); ?>][description]" rows="3" placeholder="<?php esc_attr_e( 'Option Name', 'edd_fes' ); ?>" value="<?php echo esc_attr( $description ); ?>" <?php echo $required; ?>/>
							<?php else : ?>
								<input type="text" class="fes-name-value" name="option[<?php echo esc_attr( $index ); ?>][description]" id="options[<?php echo esc_attr( $index ); ?>][description]" rows="3" placeholder="<?php esc_attr_e( 'Option Name', 'edd_fes' ); ?>" value="<?php echo esc_attr( $description ); ?>" <?php echo $required; ?>/>
							<?php endif; ?>
							<input type="hidden" id="fes-name-row-js" name="fes-name-row-js" value="1" />
						</td>
						<?php }
						if ( !$prices_disabled || $predefined_on ) { ?>
						<td class="fes-price-row">
							<?php if( $prices_disabled ) : ?>
								<span class="fes-price-value"><?php echo esc_attr( $price ); ?></span>
								<input type="hidden" class="fes-price-value" placeholder="<?php echo edd_currency_filter( '0.00' ); ?>" name="option[<?php echo esc_attr( $index ); ?>][price]" id="options[<?php echo esc_attr( $index ); ?>][price]" placeholder="20" value="<?php echo esc_attr( $price ); ?>" <?php echo $required; ?>/>
							<?php else : ?>
								<input type="text" class="fes-price-value" placeholder="<?php echo edd_currency_filter( '0.00' ); ?>" name="option[<?php echo esc_attr( $index ); ?>][price]" id="options[<?php echo esc_attr( $index ); ?>][price]" placeholder="20" value="<?php echo esc_attr( $price ); ?>" <?php echo $required; ?>/>
							<?php endif; ?>
							<input type="hidden" id="fes-price-row-js" name="fes-price-row-js" value="1"/>
						</td>
						<?php }
						if ( !$files_disabled ) { ?>
						<td class="fes-url-row">
							<input type="text" class="fes-file-value" placeholder="<?php _e( "http://", 'edd_fes' ); ?>" name="files[<?php echo esc_attr( $index ); ?>]" value="<?php echo esc_attr( $download ); ?>" <?php echo $required; ?>/>
							<input type="hidden" id="fes-file-row-js" name="fes-file-row-js" value="1" />
						</td>
						<td class="fes-url-choose-row">
							<a href="#" class="btn btn-sm btn-default upload_file_button" data-choose="<?php _e( 'Choose file', 'edd_fes' ); ?>" data-update="<?php _e( 'Insert file URL', 'edd_fes' ); ?>">
							<?php echo str_replace( ' ', '&nbsp;', __( 'Upload', 'edd_fes' ) ); ?></a>
						</td>
						<?php }
						do_action("fes-add-multiple-pricing-row-value", $file); ?>
						<?php if ( $attr[ 'single' ] !== 'yes' && !$predefined_on ) { ?>
						<td class="fes-delete-row">
							<a href="#" class="btn btn-sm btn-danger delete">
							<?php _e( 'x', 'edd_fes' ); ?></a>
						</td>
						<?php } ?>
					</tr>
					<?php } ?>
					<tr class="add_new" style="display:none !important;" id="<?php echo sanitize_key($attr['name']); ?>"></tr>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="5">
							<?php if ( $attr[ 'single' ] !== 'yes' && !$predefined_on ) { ?>
							<a href="#" class="insert-file-row" id="<?php echo sanitize_key($attr['name']); ?>"><?php _e( 'Add File', 'edd_fes' ); ?></a>
							<?php } ?>
						</th>
					</tr>
				</tfoot>
			</table>
	</div>
	<?php
	return ob_get_clean();
	}

	function file_upload( $attr, $post_id, $type ) {
		$single = false;
		if ( $type == 'submission' ) {
			$single = true;
		}

		$uploaded_items = $post_id ? $this->get_meta( $post_id, $attr['name'], $type, $single ) : '';

		if ( ! is_array( $uploaded_items ) || empty( $uploaded_items ) ) {
			$uploaded_items = array( 0 => '' );
		}

		if ( !isset($attr['single'])){
			$attr['single'] = false;
		}

		$max_files = 0;
		if ( isset( $attr['count'] ) && $attr['count'] > 0 ){
			$max_files = $attr['count'];
		}
		ob_start();
?>
        <div class="fes-fields">
			<table class="<?php echo sanitize_key($attr['name']); ?>">
				<thead>
					<tr>
						<td class="fes-file-column" colspan="2"><?php _e( 'File URL', 'edd_fes' ); ?></td>
						<?php if ( is_admin() ) { ?>
						<td class="fes-download-file">
							<?php _e( 'Download File', 'edd_fes' ); ?>
						</td>
						<?php } ?>
						<?php if ( $attr[ 'single' ] !== 'yes' ) { ?>
							<td class="fes-remove-column">&nbsp;</td>
						<?php } ?>
					</tr>
				</thead>
				<tbody class="fes-variations-list-<?php echo sanitize_key($attr['name']); ?>">
					<input type="hidden" id="fes-upload-max-files-<?php echo sanitize_key($attr['name']); ?>" value="<?php echo $max_files; ?>" />
            <?php
			foreach ( $uploaded_items as $index => $attach_id ) {
				$download = wp_get_attachment_url($attach_id);
				?>
				<tr class="fes-single-variation">
					<td class="fes-url-row">
						<?php printf( '<span class="fes-file-validation" data-required="%s" data-type="file"></span>', $attr['required'] ); ?>
						<input type="text" class="fes-file-value" placeholder="<?php _e( "http://", 'edd_fes' ); ?>" name="<?php echo $attr['name']; ?>[<?php echo esc_attr( $index ); ?>]" value="<?php echo esc_attr( $download ); ?>" />
					</td>
					<td class="fes-url-choose-row" width="1%">
						<a href="#" class="btn btn-sm btn-default upload_file_button" data-choose="<?php _e( 'Choose file', 'edd_fes' ); ?>" data-update="<?php _e( 'Insert file URL', 'edd_fes' ); ?>">
						<?php echo str_replace( ' ', '&nbsp;', __( 'Choose file', 'edd_fes' ) ); ?></a>
					</td>
					<?php if ( is_admin() ) { ?>
					<td class="fes-download-file">
						<?php printf( '<a href="%s">%s</a>', wp_get_attachment_url( $attach_id ), __( 'Download File', 'edd_fes' ) ); ?>
					</td>
					<?php } ?>
					<?php if ( $attr[ 'single' ] !== 'yes' ) { ?>
					<td width="1%" class="fes-delete-row">
						<a href="#" class="btn btn-sm btn-danger delete">
						<?php _e( 'x', 'edd_fes' ); ?></a>
					</td>
					<?php } ?>
				</tr>
				<?php
			}
			?>
					<tr class="add_new" style="display:none !important;" id="<?php echo sanitize_key($attr['name']); ?>"></tr>
				</tbody>
				<?php if( ! empty( $attr['count'] ) && $attr['count'] > 1 ) : ?>
				<tfoot>
					<tr>
						<th colspan="5">
							<a href="#" class="insert-file-row" id="<?php echo sanitize_key($attr['name']); ?>"><?php _e( 'Add File', 'edd_fes' ); ?></a>
						</th>
					</tr>
				</tfoot>
				<?php endif; ?>
		</table>
       </div> <!-- .fes-fields -->
        <?php
        return ob_get_clean();
	}

	/**
	 * Prints a image upload field
	 *
	 * @param array   $attr
	 * @param int|null $post_id
	 */
	function image_upload( $attr, $post_id, $type ) {
		$featured_image = false;
		$gallery = false;
		$avatar = false;
		$url = '';
		$id = 0;
		if ($post_id) {
			if ($type == 'submission') {
				if ($attr['name'] == 'featured_image') {
					$featured_image = true;
					$id = get_post_thumbnail_id( $post_id );
					$url = wp_get_attachment_url( $id );
				}
				// Coming in 2.3 ;)
				if ($attr['name'] == 'gallery') {
					$gallery = true;
				}
			} else{
				$avatar = true;
				$id = $post_id;
				$url = get_user_meta( $id, 'user_avatar', true );
				$avatar_id = fes_get_attachment_id_from_url( $url );
			}
		}

		// Not saved before
		if ( $attr['name'] == 'featured_image') {
			$featured_image = true;
		} else {
			$avatar = true;
		}
		ob_start();
		?>
		<style> .fes-hide { display: none } </style>
		<?php
		if ($featured_image) {  ?>
		<div class="fes-fields">
			<?php $required = isset( $attr['required'] ) ? $attr['required'] : ''; ?>
            <div class="fes-feat-image-upload">
                <div class="instruction-inside <?php if($id != 0 ){ echo 'fes-hide';} ?>">
                	<?php printf( '<span class="fes-image-validation" data-required="%s" data-type="image"></span>', $required ); ?>
                    <input type="hidden" name="feat-image-id" class="fes-feat-image-id" value="<?php echo $id; ?>">
                    <a href="#" class="fes-feat-image-btn btn btn-sm"><?php _e( 'Upload Featured Image', 'edd_fes' ); ?></a>
                </div>

             	<div class="image-wrap <?php if ($id == 0 ){ echo 'fes-hide';} ?>">
                    <a class="close fes-remove-feat-image">&times;</a>
                    <img src="<?php echo $url; ?>" alt="">
                </div>
            </div>
        </div> <!-- .fes-fields -->

		<?php }
		else if ($gallery){ ?>
		<div class="fes-fields">
			<?php $required = isset( $attr['required'] ) ? $attr['required'] : ''; ?>
            <div class="fes-gallery-image-upload">
                <div class="instruction-inside <?php if($id !== 0 ){ echo 'fes-hide';} ?>">
                	<?php printf( '<span class="fes-image-validation" data-required="%s" data-type="image"></span>', $required ); ?>
                    <input type="hidden" name="gallery_image_id" class="fes-gallery-image-id" value="<?php echo $id; ?>">
                    <a href="#" class="fes-gallery-image-btn btn btn-sm"><?php _e( 'Upload Gallery', 'edd_fes' ); ?></a>
                </div>

             	<div class="image-wrap <?php if ($id === 0 ){ echo 'fes-hide';} ?>">
                    <a class="close fes-remove-gallery-image">&times;</a>
                    <img src="<?php echo $url; ?>" alt="">
                </div>
            </div>
        </div> <!-- .fes-fields -->
		<?php
		}
		// avatar
		else{
		?>
		<div class="fes-fields">
			<?php $required = isset( $attr['required'] ) ? $attr['required'] : ''; ?>
            <div class="fes-avatar-image-upload">
                <div class="instruction-inside <?php if( ! empty( $avatar_id ) ) { echo 'fes-hide'; } ?>">
                	<?php printf( '<span class="fes-image-validation" data-required="%s" data-type="image"></span>', $required ); ?>
                    <input type="hidden" name="avatar_id" class="fes-avatar-image-id" value="<?php echo esc_attr( $avatar_id ); ?>">
                    <a href="#" class="fes-avatar-image-btn btn btn-sm"><?php _e( 'Upload Avatar', 'edd_fes' ); ?></a>
                </div>

             	<div class="image-wrap <?php if( empty( $avatar_id ) ) { echo 'fes-hide'; } ?>">
                    <a class="close fes-remove-avatar-image">&times;</a>
                    <img src="<?php echo esc_attr( $url ); ?>" alt="" class="fes-avatar-image">
                </div>
            </div>
        </div> <!-- .fes-fields -->
        <?php
    }
    return ob_get_clean();
	}

	/**
	 * Prints a select or multiselect field
	 *
	 * @param array   $attr
	 * @param bool    $multiselect
	 * @param int|null $post_id
	 */
	function select( $attr, $multiselect = false, $post_id, $type ) {
		if ( $post_id ) {
			$selected = $this->get_meta( $post_id, $attr['name'], $type );
			$selected = $multiselect ? explode( '| ', $selected ) : $selected;
		} else {
			$selected = isset( $attr['selected'] ) ? $attr['selected'] : '';
			$selected = $multiselect ? ( is_array( $selected ) ? $selected : array() ) : $selected;
		}

		$multi = $multiselect ? ' multiple="multiple"' : '';
		$data_type = $multiselect ? 'multiselect' : 'select';
		$css = $multiselect ? ' class="multiselect"' : '';
		ob_start();
?>

        <div class="fes-fields">

            <select<?php echo $css; ?> name="<?php echo $attr['name'] ?>[]"<?php echo $multi; ?> data-required="<?php echo $attr['required'] ?>" data-type="<?php echo $data_type; ?>"<?php $this->required_html5( $attr ); ?>>

                <?php if ( !empty( $attr['first'] ) ) { ?>
                    <option value=""><?php echo $attr['first']; ?></option>
                <?php } ?>

                <?php
		if ( $attr['options'] && count( $attr['options'] ) > 0 ) {
			foreach ( $attr['options'] as $option ) {
				$current_select = $multiselect ? selected( in_array( $option, $selected ), true, false ) : selected( $selected, $option, false );
?>
                        <option value="<?php echo esc_attr( $option ); ?>"<?php echo $current_select; ?>><?php echo $option; ?></option>
                        <?php
			}
		}
?>
            </select>
        </div>
        <?php
        return ob_get_clean();
	}

	/**
	 * Prints a radio field
	 *
	 * @param array   $attr
	 * @param int|null $post_id
	 */
	function radio( $attr, $post_id, $type ) {
		$selected = isset( $attr['selected'] ) ? $attr['selected'] : '';

		if ( $post_id ) {
			$selected = $this->get_meta( $post_id, $attr['name'], $type, true );
		}
		ob_start();
?>

        <div class="fes-fields">

            <span data-required="<?php echo $attr['required'] ?>" data-type="radio"></span>

            <?php
		if ( $attr['options'] && count( $attr['options'] ) > 0 ) {
			foreach ( $attr['options'] as $option ) {
			if ( isset( $attr['name'] ) && $attr['name'] == 'fes_login_radio_button' && $option == 'Vendor' && EDD_FES()->vendors->get_vendor_constant_name( $plural = false, $uppercase = true ) !== 'Vendor' ){
				$option = EDD_FES()->vendors->get_vendor_constant_name( $plural = false, $uppercase = true );
			}
?>

                    <label>
                        <input name="<?php echo $attr['name']; ?>" type="radio" value="<?php echo esc_attr( $option ); ?>"<?php checked( $selected, $option ); ?> />
                        <?php echo __( $option, 'edd_fes' ); ?>
                    </label>
                    <?php
			}
		}
?>
        </div>
        <?php
        return ob_get_clean();
	}

	/**
	 * Prints a checkbox field
	 *
	 * @param array   $attr
	 * @param int|null $post_id
	 */
	function checkbox( $attr, $post_id, $type ) {
		$selected = isset( $attr['selected'] ) ? $attr['selected'] : array();

		if ( $post_id ) {
			$selected = explode( '| ', $this->get_meta( $post_id, $attr['name'], $type, true ) );
		}
		ob_start();
?>

        <div class="fes-fields">
            <span data-required="<?php echo $attr['required'] ?>" data-type="radio"></span>

            <?php
		if ( $attr['options'] && count( $attr['options'] ) > 0 ) {
			foreach ( $attr['options'] as $option ) {
?>

                    <label>
                        <input type="checkbox" name="<?php echo $attr['name']; ?>[]" value="<?php echo esc_attr( $option ); ?>"<?php echo in_array( $option, $selected ) ? ' checked="checked"' : ''; ?> />
                        <?php echo __( $option, 'edd_fes' ); ?>
                    </label>
                    <?php
			}
		}
?>
        </div>
        <?php
        return ob_get_clean();
	}

	/**
	 * Prints a url field
	 *
	 * @param array   $attr
	 * @param int|null $post_id
	 */
	function url( $attr, $post_id, $type ) {

		if ( $post_id ) {
			if ( $this->is_meta( $attr ) ) {
				$value = $this->get_meta( $post_id, $attr['name'], $type, true );
			} else {
				//must be user profile url
				$value = $this->get_user_data( $post_id, $attr['name'] );
			}
		} else {
			$value = $attr['default'];
		}
		ob_start();
?>

        <div class="fes-fields">
            <input id="fes-<?php echo $attr['name']; ?>" type="url" class="url" data-required="<?php echo $attr['required'] ?>" data-type="text"<?php $this->required_html5( $attr ); ?> name="<?php echo esc_attr( $attr['name'] ); ?>" placeholder="<?php echo esc_attr( $attr['placeholder'] ); ?>" value="<?php echo esc_attr( $value ) ?>" size="<?php echo esc_attr( $attr['size'] ) ?>" />
        </div>

        <?php
        return ob_get_clean();
	}

	/**
	 * Prints a email field
	 *
	 * @param array   $attr
	 * @param int|null $post_id
	 */
	function email( $attr, $post_id, $type = 'submission' ) {
		if ( $post_id && $type != 'vendor-contact' ) {
			if ( $this->is_meta( $attr ) ) {
				$value = $this->get_meta( $post_id, $attr['name'], $type, true );
			} else {
				$value = $this->get_user_data( $post_id, $attr['name'] );
			}
		} else {
			$value = ! empty( $attr['default'] ) ? $attr['default'] : '';
		}

		$attr['placeholder'] = ! empty( $attr['placeholder'] ) ? $attr['placeholder'] : '';

		ob_start();
?>

        <div class="fes-fields">
            <input id="fes-<?php echo $attr['name']; ?>" type="email" class="email" data-required="<?php echo $attr['required'] ?>" data-type="text"<?php $this->required_html5( $attr ); ?> name="<?php echo esc_attr( $attr['name'] ); ?>" placeholder="<?php echo esc_attr( $attr['placeholder'] ); ?>" value="<?php echo esc_attr( $value ) ?>" size="<?php echo esc_attr( $attr['size'] ) ?>" />
        </div>

        <?php
        return ob_get_clean();
	}

	/**
	 * Prints a password field
	 *
	 * @param array   $attr
	 */
	function password( $attr, $post_id, $type ) {
		if ( $post_id && $type != 'registration' ) {
			$attr['required'] = 'no';
		}
		if ( !isset( $attr['placeholder'] ) ){
			$attr['placeholder'] = '';
		}
		ob_start();
?>

        <div class="fes-fields">
            <input id="pass1" type="password" class="password" data-required="<?php echo $attr['required'] ?>" data-type="text"<?php $this->required_html5( $attr ); ?> name="pass1" placeholder="<?php echo esc_attr( $attr['placeholder'] ); ?>" value="" size="<?php echo esc_attr( $attr['min_length'] ) ?>" />
        </div>

        <?php
		if ( $attr['repeat_pass'] == 'yes' ) {
			echo $this->label( array( 'name' => 'pass2', 'label' => $attr['re_pass_label'], 'required' => $post_id ? 'no' : 'yes' ) );
?>

            <div class="fes-fields">
                <input id="pass2" type="password" class="password" data-required="<?php echo $attr['required'] ?>" data-type="text"<?php $this->required_html5( $attr ); ?> name="pass2" value="" size="<?php echo esc_attr( $attr['min_length'] ) ?>" />
            </div>

            <?php
		}
		return ob_get_clean();
	}

	/**
	 * Prints a repeatable field
	 *
	 * @param array   $attr
	 * @param int|null $post_id
	 */
	function repeat( $attr, $post_id, $type ) {
		$add = fes_assets_url .'img/add.png';
		$remove = fes_assets_url. 'img/remove.png';

		ob_start();
?>

        <div class="fes-fields">

            <?php if ( isset( $attr['multiple'] ) ) { ?>
                <table>
                    <thead>
                        <tr>
<?php
						$num_columns = count( $attr['columns'] );
						foreach ( $attr['columns'] as $column ) {
?>
                             <th><?php echo $column; ?></th>
<?php 
						}
?>
                            <th style="visibility: hidden;">
                                <?php _e( 'Actions', 'edd_fes' ); ?>
                            </th>
                        </tr>

                    </thead>
                    <tbody>
<?php
					$items = $post_id ? $this->get_meta( $post_id, $attr['name'], $type ) : array();
					$row_count = count( $items ) > 0 ? count( $items ) - 1 : 0;
					if ( $items ) {
						foreach ( $items as $key => $item_val ) {
?>
                                <tr data-key="<?php echo $row_count; ?>">
                                    <?php for ( $count = 0; $count < $num_columns; $count++ ) { 
                                    	$value = isset( $item_val[$count] ) ? $item_val[$count] : '';
?>
                                        <td class="fes-repeat-field">
                                            <input type="text" name="<?php echo $attr['name'] . '[' . $row_count . '][' . $count . ']'; ?>" value="<?php echo esc_attr( $value ); ?>" size="<?php echo esc_attr( $attr['size'] ) ?>" data-required="<?php echo $attr['required'] ?>" data-type="text"<?php $this->required_html5( $attr ); ?> />
                                        </td>
                                    <?php } ?>
                                    <td class="fes-repeat-field">
                                        <img class="fes-clone-field" alt="<?php esc_attr_e( 'Add another', 'edd_fes' ); ?>" title="<?php esc_attr_e( 'Add another', 'edd_fes' ); ?>" src="<?php echo $add; ?>">
                                        <img class="fes-remove-field" alt="<?php esc_attr_e( 'Remove this choice', 'edd_fes' ); ?>" title="<?php esc_attr_e( 'Remove this choice', 'edd_fes' ); ?>" src="<?php echo $remove; ?>">
                                    </td>
                                </tr>
<?php
							$row_count++;
						} //endforeach

                    } else {
?>
                            <tr data-key="<?php echo $row_count; ?>">
                                <?php for ( $count = 0; $count < $num_columns; $count++ ) { ?>
                                    <td class="fes-repeat-field">
                                        <input type="text" name="<?php echo $attr['name'] . '[' . $row_count . '][' . $count . ']'; ?>" size="<?php echo esc_attr( $attr['size'] ) ?>" data-required="<?php echo $attr['required'] ?>" data-type="text"<?php $this->required_html5( $attr ); ?> />
                                    </td>
                                <?php } ?>
                                <td class="fes-repeat-field">
                                    <img class="fes-clone-field" alt="<?php esc_attr_e( 'Add another', 'edd_fes' ); ?>" title="<?php esc_attr_e( 'Add another', 'edd_fes' ); ?>" src="<?php echo $add; ?>">
                                    <img class="fes-remove-field" alt="<?php esc_attr_e( 'Remove this choice', 'edd_fes' ); ?>" title="<?php esc_attr_e( 'Remove this choice', 'edd_fes' ); ?>" src="<?php echo $remove; ?>">
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>
<?php
        	} else {
?>
                <table>
<?php
				$items = $post_id ? explode( '| ', $this->get_meta( $post_id, $attr['name'], $type, true ) ) : array();

				if ( $items ) {
					foreach ( $items as $item ) {
?>
	                    <tr>
	                        <td class="fes-repeat-field">
	                            <input id="fes-<?php echo $attr['name']; ?>" type="text" data-required="<?php echo $attr['required'] ?>" data-type="text"<?php $this->required_html5( $attr ); ?> name="<?php echo esc_attr( $attr['name'] ); ?>[]" placeholder="<?php echo esc_attr( $attr['placeholder'] ); ?>" value="<?php echo esc_attr( $item ) ?>" size="<?php echo esc_attr( $attr['size'] ) ?>" />
	                        </td>
	                        <td class="fes-repeat-field">
	                            <img style="cursor:pointer; margin:0 3px;" alt="add another choice" title="add another choice" class="fes-clone-field" src="<?php echo $add; ?>">
	                            <img style="cursor:pointer;" class="fes-remove-field" alt="remove this choice" title="remove this choice" src="<?php echo $remove; ?>">
	                        </td>
	                    </tr>
<?php
					} //endforeach
				
				} else {
?>
	                <tr>
	                    <td class="fes-repeat-field">
	                        <input id="fes-<?php echo $attr['name']; ?>" type="text" data-required="<?php echo $attr['required'] ?>" data-type="text"<?php $this->required_html5( $attr ); ?> name="<?php echo esc_attr( $attr['name'] ); ?>[]" placeholder="<?php echo esc_attr( $attr['placeholder'] ); ?>" value="<?php echo esc_attr( $attr['default'] ) ?>" size="<?php echo esc_attr( $attr['size'] ) ?>" />
	                    </td>
	                    <td class="fes-repeat-field">
	                        <img style="cursor:pointer; margin:0 3px;" alt="add another choice" title="<?php _e( 'add another choice', 'edd_fes' ); ?>" class="fes-clone-field" src="<?php echo $add; ?>">
	                        <img style="cursor:pointer;" class="fes-remove-field" alt="remove this choice" title="<?php _e( 'remove this choice', 'edd_fes' ); ?>" src="<?php echo $remove; ?>">
	                    </td>
	                </tr>
<?php
				}
?>
                </table>
<?php
        }
?>
        </div>

        <?php
        return ob_get_clean();
	}

	/**
	 * Prints a taxonomy field
	 *
	 * @param array   $attr
	 * @param int|null $post_id
	 */
	function taxonomy( $attr, $post_id ) {
		$exclude_type = isset( $attr['exclude_type'] ) ? $attr['exclude_type'] : 'exclude';
		$exclude = $attr['exclude'];
		$taxonomy = $attr['name'];

		$terms = array();
		if ( $post_id && $attr['type'] == 'text' ) {
			$terms = wp_get_post_terms( $post_id, $taxonomy, array( 'fields' => 'names' ) );
		} elseif ( $post_id ) {
			$terms = wp_get_post_terms( $post_id, $taxonomy, array( 'fields' => 'ids' ) );
		}
		ob_start();

?>

        <div class="fes-fields">
            <?php
		switch ( $attr['type'] ) {
		case 'select':

			$selected = $terms ? $terms[0] : '';
			$required = isset( $attr['required'] ) ? $attr['required'] : '';
			$required = sprintf( 'data-required="%s" data-type="select"', $required );

			$select = wp_dropdown_categories( array(
					'show_option_none' => __( '-- Select --', 'edd_fes' ),
					'hierarchical' => 1,
					'hide_empty' => 0,
					'orderby' => isset( $attr['orderby'] ) ? $attr['orderby'] : 'name',
					'order' => isset( $attr['order'] ) ? $attr['order'] : 'ASC',
					'name' => $taxonomy . '[]',
					'id' => $taxonomy,
					'taxonomy' => $taxonomy,
					'echo' => 0,
					'title_li' => '',
					'class' => $taxonomy,
					$exclude_type => $exclude,
					'selected' => $selected,
				) );
			echo str_replace( '<select', '<select ' . $required, $select );
			break;

		case 'multiselect':
			$selected_multiple = $terms ? $terms : array();
			$selected = is_array( $selected_multiple ) && !empty( $selected_multiple ) ? $selected_multiple[0] : '';
			$required = sprintf( 'data-required="%s" data-type="multiselect"', $attr['required'] );
			$walker = new FES_Walker_Category_Multi();

			$select = wp_dropdown_categories( array(
					'show_option_none' => __( '-- Select --', 'edd_fes' ),
					'hierarchical' => 1,
					'hide_empty' => 0,
					'orderby' => isset( $attr['orderby'] ) ? $attr['orderby'] : 'name',
					'order' => isset( $attr['order'] ) ? $attr['order'] : 'ASC',
					'name' => $taxonomy . '[]',
					'id' => $taxonomy,
					'taxonomy' => $taxonomy,
					'echo' => 0,
					'title_li' => '',
					'class' => $taxonomy . ' multiselect',
					$exclude_type => $exclude,
					'selected' => $selected,
					'selected_multiple' => $selected_multiple,
					'walker' => $walker
				) );

			echo str_replace( '<select', '<select multiple="multiple" ' . $required, $select );
			break;

		case 'checkbox':
			printf( '<span data-required="%s" data-type="tax-checkbox" />', $attr['required'] );
			fes_category_checklist( $post_id, false, $attr );
			break;

		case 'text':
?>

                    <input class="textfield<?php echo $this->required_class( $attr ); ?>" id="<?php echo $attr['name']; ?>" type="text" data-required="<?php echo $attr['required'] ?>" data-type="text"<?php $this->required_html5( $attr ); ?> name="<?php echo esc_attr( $attr['name'] ); ?>" value="<?php echo esc_attr( implode( ', ', $terms ) ); ?>" size="40" />

                    <script type="text/javascript">
                        jQuery(function($) {
                            $('#<?php echo $attr['name']; ?>').suggest( fes_form.ajaxurl + '?action=ajax-tag-search_array&tax=<?php echo $attr['name']; ?>', { delay: 500, minchars: 2, multiple: true, multipleSep: ', ' } );
                        });
                    </script>

                    <?php
			break;

		default:
			// code...
			break;
		}
?>
        </div>

        <?php
        return ob_get_clean();
	}

	/**
	 * Prints a HTML field
	 *
	 * @param array   $attr
	 */
	function html( $attr ) {
		ob_start();
?>
        <div class="fes-fields">
            <?php echo do_shortcode( $attr['html'] ); ?>
        </div>
        <?php
        return ob_get_clean();
	}

	/**
	 * Prints a toc field
	 *
	 * @param array   $attr
	 */
	function toc( $attr, $post_id ) {
		ob_start();
?>
        <div class="fes-label">
            &nbsp;
        </div>

        <div class="fes-fields">
            <span data-required="yes" data-type="radio"></span>

            <textarea rows="10" cols="40" disabled="disabled" name="toc"><?php echo $attr['description']; ?></textarea>
            <label>
                <input type="checkbox" name="fes_accept_toc" required="required" /> <?php echo $attr['label']; ?>
            </label>
        </div>
        <?php
        return ob_get_clean();
	}

	/**
	 * Prints recaptcha field
	 *
	 * @param array   $attr
	 */
	function recaptcha( $attr, $post_id, $type ) {
		if( $type != 'vendor-contact' && $type != 'registration' && !empty($post_id)) {
			return;
		}

		ob_start();
		?>
        <div class="fes-fields">
        	<script type="text/javascript"> var RecaptchaOptions = { theme : 'clean' };</script>
            <?php echo recaptcha_get_html( EDD_FES()->helper->get_option( 'fes-recaptcha-public-key', '', is_ssl() ) ); ?>
        </div>
        <?php
        return ob_get_clean();
	}

	/**
	 * Prints a section break
	 *
	 * @param array   $attr
	 * @param int|null $post_id
	 */
	function section_break( $attr ) {
		ob_start();
?>
        <div class="fes-section-wrap">
            <h2 class="fes-section-title"><?php echo $attr['label']; ?></h2>
            <div class="fes-section-details"><?php echo $attr['description']; ?></div>
        </div>
        <?php
        return ob_get_clean();
	}

	/**
	 * Prints a action hook
	 *
	 * @param array   $attr
	 * @param int     $form_id
	 * @param int|null $post_id
	 * @param array   $form_settings
	 */
	function action_hook( $attr, $form_id, $post_id, $form_settings ) {

		if ( !empty( $attr['label'] ) ) {
			do_action( $attr['label'], $form_id, $post_id, $form_settings );
		}
	}

	/**
	 * Prints a date field
	 *
	 * @param array   $attr
	 * @param int|null $post_id
	 */
	function date( $attr, $post_id, $type ) {

		$value = $post_id ? $this->get_meta( $post_id, $attr['name'], $type, true ) : '';
		ob_start();
?>

        <div class="fes-fields">
            <input id="fes-date-<?php echo $attr['name']; ?>" type="text" class="datepicker" data-required="<?php echo $attr['required'] ?>" data-type="text"<?php $this->required_html5( $attr ); ?> name="<?php echo esc_attr( $attr['name'] ); ?>" value="<?php echo esc_attr( $value ) ?>" size="30" />
        </div>
        <script type="text/javascript">
            jQuery(function($) {
        <?php if ( $attr['time'] == 'yes' ) { ?>
                                $("#fes-date-<?php echo $attr['name']; ?>").datetimepicker({ dateFormat: '<?php echo $attr["format"]; ?>' });
        <?php } else { ?>
                                $("#fes-date-<?php echo $attr['name']; ?>").datepicker({ dateFormat: '<?php echo $attr["format"]; ?>' });
        <?php } ?>
            });
        </script>

        <?php
        return ob_get_clean();
	}

	// submit button
	function submit_button( $form_id = false, $type = 'submission', $id = false, $args = array() ) {
		if ( !$form_id ) {
			return __( 'Invalid FES Form ID', 'edd_fes' );
		}
		global $edd_options;
		$color = isset( $edd_options[ 'checkout_color' ] ) ? $edd_options[ 'checkout_color' ] : 'blue';
		$color = ( $color == 'inherit' ) ? '' : $color;
		$style = isset( $edd_options[ 'button_style' ] ) ? $edd_options[ 'button_style' ] : 'button';
		switch ( $type ) {
			case 'vendor-contact':
	?>
					<fieldset class="fes-submit">
						<div class="fes-label">
							&nbsp;
						</div>
						<?php wp_nonce_field( 'fes-form-vendor-contact-form' ); ?>
						<input type="hidden" name="form_id" value="<?php echo $form_id; ?>">
						<input type="hidden" name="action" value="fes_submit_vendor_contact_form">
						<input type="hidden" name="user_id" value="<?php echo get_current_user_id(); ?>">
						<input type="hidden" name="vendor_id" value="<?php echo isset($args['vendor']) ? absint($args['vendor']) : '0'; ?>">
						<input type="submit" class="edd-submit <?php echo $color; ?> <?php echo $style; ?>" name="submit" value="<?php echo __( 'Send Message', 'edd_fes' ); ?>" />
					</fieldset>
					<?php
				break;
			case 'submission':
	?>
					<fieldset class="fes-submit">
						<div class="fes-label">
							&nbsp;
						</div>

						<?php wp_nonce_field( 'fes-form-submission-form' ); ?>
						<input type="hidden" name="form_id" value="<?php echo $form_id; ?>">
						<input type="hidden" name="user_id" value="<?php echo get_current_user_id(); ?>">
						<input type="hidden" name="page_id" value="<?php echo get_post() ? get_the_ID() : '0'; ?>">
						<input type="hidden" name="action" value="fes_submit_post">

						<?php
						if ( $id ) {
							$cur_post = get_post( $id );
	?>
							<input type="hidden" name="post_id" value="<?php echo $id; ?>">
							<input type="hidden" name="post_author" value="<?php echo esc_attr( $cur_post->post_author ); ?>">
							<input type="hidden" name="submission_status" value="edit">
							<input type="submit" class="edd-submit <?php echo $color; ?> <?php echo $style; ?>" name="submit" value="<?php echo __( 'Update', 'edd_fes' ); ?>" />
						<?php } else { ?>
							<input type="hidden" name="submission_status" value="new">
							<input type="submit" class="edd-submit <?php echo $color; ?> <?php echo $style; ?>" name="submit" value="<?php echo __( 'Submit', 'edd_fes' ); ?>" />
						<?php }
				break;
			case 'profile':
	?>
					<fieldset class="fes-submit">
						<div class="fes-label">
							&nbsp;
						</div>
						<?php wp_nonce_field( 'fes-form-update-profile' ); ?>
						<input type="hidden" name="form_id" value="<?php echo $form_id; ?>">
						<input type="hidden" name="action" value="fes_update_profile">
						<input type="hidden" name="user_id" value="<?php echo $id; ?>">
						<input type="hidden" name="page_id" value="<?php echo get_post() ? get_the_ID() : '0'; ?>">
						<?php if( is_admin() ) : ?>
							<input type="hidden" name="is_admin" value="1">
						<?php endif; ?>
						<input type="submit" class="edd-submit <?php echo $color; ?> <?php echo $style; ?>" name="submit" value="<?php echo __( 'Update Profile', 'edd_fes' ); ?>" />
					</fieldset>
					<?php
				break;
			case 'login':
	?>
					<fieldset class="fes-submit">
						<div class="fes-label">
							&nbsp;
						</div>
						<?php wp_nonce_field( 'fes-form-login' ); ?>
						<input type="hidden" name="action" value="fes_submit_login">
						<input type="hidden" name="form_id" value="<?php echo $form_id; ?>">
						<input type="submit" class="edd-submit <?php echo $color; ?> <?php echo $style; ?>" name="submit" value="<?php echo __( 'Login', 'edd_fes' ); ?>" />
						<a href="<?php echo wp_lostpassword_url(); ?>" id="fes_lost_password_link" title="<?php _e( 'Lost Password?', 'edd_fes' ); ?>"><?php _e( 'Lost Password?', 'edd_fes' ); ?></a>
					</fieldset>
					<?php
				break;
			case 'registration':
				$wording = sprintf( __( 'Become A %s', 'edd_fes' ),  EDD_FES()->vendors->get_vendor_constant_name( $plural = false, $uppercase = true ) );
				if ( $id ) {
					$wording =  __( 'Submit Changes', 'edd_fes' );
				}

	?>
				<fieldset class="fes-submit">
					<div class="fes-label">
						&nbsp;
					</div>
					<?php wp_nonce_field( 'fes-form-registration' ); ?>
					<input type="hidden" name="action" value="fes_submit_registration">
					<input type="hidden" name="form_id" value="<?php echo $form_id; ?>">
					<?php if( $id ) : ?>
						<input type="hidden" name="user_id" value="<?php echo $id; ?>">
					<?php endif; ?>
					<?php if( is_admin() ) : ?>
						<input type="hidden" name="is_admin" value="1">
					<?php endif; ?>
					<input type="submit" class="edd-submit <?php echo $color; ?> <?php echo $style; ?>" name="submit" value="<?php echo $wording; ?>" />
				</fieldset>
				<?php
				break;
			default:
				break;
		} // endswitch
	}

	// validate fields
	function validate_re_captcha() {
		$recap_challenge = isset( $_POST['recaptcha_challenge_field'] ) ? $_POST['recaptcha_challenge_field'] : '';
		$recap_response = isset( $_POST['recaptcha_response_field'] ) ? $_POST['recaptcha_response_field'] : '';
		$private_key = EDD_FES()->helper->get_option( 'fes-recaptcha-private-key', '' );

		$resp = recaptcha_check_answer( $private_key, $_SERVER["REMOTE_ADDR"], $recap_challenge, $recap_response );

		if ( !$resp->is_valid ) {
			$this->signal_error( __( 'reCAPTCHA validation failed', 'edd_fes' ) );
		}
	}

	// signal error when using AJAX
	function signal_error( $error ) {
		echo json_encode( array( 'success' => false, 'error' => $error ) );
		die();
	}

	// search_array nD matrix
	function search_array( $array, $key, $value ) {
		$results = array();

		if ( is_array( $array ) ) {
			if ( isset( $array[$key] ) && $array[$key] == $value )
				$results[] = $array;

			foreach ( $array as $subarray )
				$results = array_merge( $results, $this->search_array( $subarray, $key, $value ) );
		}

		return $results;
	}

	public static function update_user_meta( $meta_vars, $user_id ) {

		// prepare meta fields
		list( $meta_key_value, $files ) = self::prepare_meta_fields( $meta_vars );

		// set featured image if there's any
		if ( ! empty( $_POST[ 'avatar_id' ] ) ) {
			$attachment_id = absint( $_POST[ 'avatar_id' ] );
			fes_update_avatar( $user_id, $attachment_id );
		} else {
			delete_user_meta( $user_id, 'user_avatar' );
		}

		// save all custom fields
		foreach ( $meta_key_value as $meta_key => $meta_value ) {
			update_user_meta( $user_id, $meta_key, $meta_value );
		}

		// save any files attached
		foreach ( $files as $file_input ) {
			if ( !isset( $_POST[ $file_input[ 'name' ] ] ) ){
				continue;
			}

			delete_user_meta( $user_id, $file_input[ 'name' ] );

			foreach ( $_POST[ $file_input[ 'name' ] ] as $file => $url ){
				$attachment_id = fes_get_attachment_id_from_url( $url );
				update_user_meta( $user_id, $file_input[ 'name' ], $attachment_id );
			}
		}
	}

	public static function update_post_meta( $meta_vars, $post_id ) {
		// prepare the meta vars
		list( $meta_key_value, $files ) = self::prepare_meta_fields( $meta_vars );
		// set featured image if there's any
		// if not in admin or if in admin (but doing an ajax call)
		if ( ( is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX ) || !is_admin() ){
			if ( isset( $_POST[ 'feat-image-id' ] ) && $_POST[ 'feat-image-id' ] != 0 ) {
				$attachment_id = $_POST[ 'feat-image-id' ];
	 			fes_associate_attachment( $attachment_id, $post_id );
	 			set_post_thumbnail( $post_id, $attachment_id );
			}

			if ( !isset( $_POST[ 'feat-image-id' ] ) || $_POST[ 'feat-image-id' ] == 0 ) {
				delete_post_thumbnail( $post_id );
			}
		}

		// save all custom fields
		foreach ( $meta_key_value as $meta_key => $meta_value ) {
			update_post_meta( $post_id, $meta_key, $meta_value );
		}

		// save any files attached
		foreach ( $files as $file_input ) {
			if ( !isset( $_POST[ $file_input[ 'name' ] ] ) ){
				continue;
			}
			$ids = array();

			// We need to detach all previously attached files for this field. See #559
			$old_files = get_post_meta( $post_id, $file_input[ 'name' ], true );
			if( ! empty( $old_files ) && is_array( $old_files ) ) {
				foreach( $old_files as $file_id ) {
					global $wpdb;

					$wpdb->update(
						$wpdb->posts,
						array(
							'post_parent' => 0,
						),
						array(
							'ID' => $file_id,
						),
						array(
							'%d'
						),
						array(
							'%d'
						)
					);
				}
			}

			foreach ( $_POST[ $file_input[ 'name' ] ] as $file => $url ){
				if ( empty ($url) ){
					continue;
				}

				$author_id = 0;
				if( ! current_user_can( 'manage_shop_settings' ) ) {
					$author_id = get_post_field( 'post_author', $post_id );
				}
				$attachment_id = fes_get_attachment_id_from_url( $url, $author_id );

				fes_associate_attachment( $attachment_id, $post_id );
				$ids[] = $attachment_id;
			}

			update_post_meta( $post_id, $file_input[ 'name' ], $ids );
		}
	}

	function required_mark( $attr ) {
		if ( isset( $attr['required'] ) && $attr['required'] == 'yes' ) {
			return apply_filters( 'fes_required_mark', ' <span class="edd-required-indicator">*</span>', $attr );
		}
	}
	function required_html5( $attr ) {
		if ( isset( $attr['required'] ) && $attr['required'] == 'yes' ) {
			echo apply_filters( 'fes_required_html5', ' required="required"', $attr );
		}
	}
	function required_class( $attr ) {
		if ( isset( $attr['required'] ) && $attr['required'] == 'yes' ) {
			echo apply_filters( 'fes_required_class', ' edd-required-indicator', $attr );
		}
	}
	function label( $attr, $post_id = 0 ) {
		if ( $post_id && $attr['input_type'] == 'password' ) {
			$attr['required'] = 'no';
		}
		ob_start();
?>
        <div class="fes-label">
            <label for="fes-<?php echo isset( $attr['name'] ) ? $attr['name'] : 'cls'; ?>"><?php echo __( $attr['label'], 'edd_fes' ) . $this->required_mark( $attr ); ?></label>
			<br />
            <?php if ( ! empty( $attr['help'] ) ) : ?>
		  	<span class="fes-help"><?php echo __( $attr['help'], 'edd_fes' ); ?></span>
		  <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
	}
	function is_meta( $attr ) {
		if ( isset( $attr['is_meta'] ) && $attr['is_meta'] == 'yes' ) {
			return true;
		}

		return false;
	}
	function get_meta( $object_id, $meta_key, $type = 'submission', $single = true ) {
		if ( !$object_id ) {
			return '';
		}

		if ( $type == 'submission' ) {
			return get_post_meta( $object_id, $meta_key, $single );
		}

		if ( $type == 'vendor-contact' ) {
			return get_user_meta( get_current_user_id(), $meta_key, $single );
		}

		return get_user_meta( $object_id, $meta_key, $single );
	}
	function get_user_data( $user_id, $field ) {
		return get_user_by( 'id', $user_id )->$field;
	}

	function guess_username( $email ) {
		// username from email address
		$username = sanitize_user( substr( $email, 0, strpos( $email, '@' ) ) );

		if ( !username_exists( $username ) ) {
			return $username;
		}

		// try to add some random number in username
		// and may be we got our username
		$username .= rand( 1, 199 );
		if ( !username_exists( $username ) ) {
			return $username;
		}
	}
}
