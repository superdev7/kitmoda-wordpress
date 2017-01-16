<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class FES_Install {

	public $toSet = array();
	public $fes_settings = array();

	public function init() {

		$this->fes_settings = get_option( 'fes_settings' );

		$default = get_option( 'edd_fes_options', false );
		if ( $default ){
			$default = isset( $default['db_version'] ) ? $default['db_version'] : '2.0';
		}
		$version = get_option( 'fes_current_version', $default );

		if ( version_compare( $version, '2.2', '>=' )  ) {
			return;
		}

		$this->toSet = $this->fes_settings;

		EDD_FES()->setup->register_post_type();
		$this->install_or_update_fes();
		update_option( 'fes_settings', $this->toSet );

	}

	public function create_page( $slug, $page_title = '', $page_content = '', $post_parent = 0 ) {
		global $wpdb, $wp_version;
		$page_id = $this->toSet[ 'fes-' . $slug . '-page'];
		if ( $page_id > 0 && get_post( $page_id ) ) {
			return;
		}
		$page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM " . $wpdb->posts . " WHERE post_name = %s LIMIT 1;", $slug ) );
		if ( $page_found ) {
			if ( !$page_id ) {
				$this->toSet[ 'fes-' . $slug . '-page'] = $page_found;
				return;
			}
			return;
		}
		$page_data = array(
			'post_status' => 'publish',
			'post_type' => 'page',
			'post_author' => get_current_user_id(),
			'post_name' => $slug,
			'post_title' => $page_title,
			'post_content' => $page_content,
			'post_parent' => $post_parent,
			'comment_status' => 'closed'
		);
		$page_id   = wp_insert_post( $page_data );
		$this->toSet[ 'fes-' . $slug . '-page'] = $page_id;
		return;
	}

	public function create_post( $slug, $page_title = '' ) {
		global $wpdb, $wp_version, $fes_settings;
		$page_id = $this->toSet[$slug];
		if ( $page_id > 0 && get_post( $page_id ) ) {
			return;
		}
		$page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM " . $wpdb->posts . " WHERE post_name = %s LIMIT 1;", $slug ) );
		if ( $page_found ) {
			if ( !$page_id ) {
				$this->toSet[$slug] = $page_found;
				return;
			}
			return;
		}

		$page_data = array(
			'post_status' => 'publish',
			'post_type' => 'fes-forms',
			'post_author' => get_current_user_id(),
			'post_title' => $page_title
		);
		$page_id   = wp_insert_post( $page_data );
		$this->save_default_values( $slug, $page_id );
		$this->toSet[$slug] = $page_id;
		return;
	}

	private function save_default_values( $slug, $page_id ) {
		switch ( $slug ) {
		case 'fes-login-form':
			$login = array(
				1 => array(
					'input_type' => 'text',
					'template' => 'user_login',
					'required' => 'yes',
					'label' => __( 'Username', 'edd_fes' ),
					'name' => 'user_login',
					'is_meta' => 'yes',
					'size' => 40,
					'help' => '',
					'css' => '',
					'placeholder' => '',
					'default' => '',
				),
				2 => array(
					'input_type' => 'password',
					'template' => 'password',
					'required' => 'yes',
					'label' => __( 'Password', 'edd_fes' ),
					'name' => 'password',
					'is_meta' => 'yes',
					'size' => '40',
					'min_length' => '6',
					'repeat_pass' => 'no',
					'help' => '',
					'css' => '',
					'placeholder' => '',
					'default' => ''
				),
				3 => array(
					'input_type' => 'radio',
					'template' => 'radio_field',
					'required' => 'yes',
					'label' => __( 'Login as a', 'edd_fes' ),
					'is_meta' => 'no',
					'name' => 'fes_login_radio_button',
					'css' => 'fes_login_radio_button',
					'selected' => 'Vendor',
					'options' => array( EDD_FES()->vendors->get_vendor_constant_name( $plural = false, $uppercase = true ), __( 'Customer', 'edd_fes' ) ),
					'help' => '',
					'placeholder' => '',
					'default' => ''
				),
				4 => array(
					'input_type' => 'recaptcha',
					'template' => 'recaptcha',
					'label' => '',
				),
			);
			update_post_meta( $page_id , 'fes-form', $login );
			break;
		case 'fes-profile-form':
			$login = array(
				0 => array(
					'input_type' => 'text',
					'template' => 'text_field',
					'required' => 'yes',
					'label' => __( 'Name of Store', 'edd_fes' ),
					'name' => 'name_of_store',
					'is_meta' => 'yes',
					'help' => __( 'What would you like your store to be called?', 'edd_fes' ),
					'css' => '',
					'placeholder' => '',
					'default' => '',
					'size' => '40'
				),
				1 => array(
					'input_type' => 'email',
					'template' => 'email_address',
					'required' => 'yes',
					'label' => __( 'Email to use for Contact Form', 'edd_fes' ),
					'name' => 'email_to_use_for_contact_form',
					'is_meta' => 'yes',
					'help' => __( 'This email, if filled in, will be used for the vendor contact forms. If it is not filled in, the one from your user profile will be used.', 'edd_fes' ),
					'css' => '',
					'placeholder' => '',
					'default' => '',
					'size' => '40'
				)
			);

			update_post_meta( $page_id , 'fes-form', $login );
			break;
		case 'fes-registration-form':
			$register = array(
				1 =>
				array (
					'input_type' => 'text',
					'template' => 'first_name',
					'required' => 'yes',
					'label' => __( 'First Name', 'edd_fes' ),
					'name' => 'first_name',
					'is_meta' => 'yes',
					'help' => '',
					'css' => '',
					'placeholder' => '',
					'default' => '',
					'size' => '40',
				),
				2 =>
				array (
					'input_type' => 'text',
					'template' => 'last_name',
					'required' => 'yes',
					'label' => __( 'Last Name', 'edd_fes' ),
					'name' => 'last_name',
					'is_meta' => 'yes',
					'help' => '',
					'css' => '',
					'placeholder' => '',
					'default' => '',
					'size' => '40',
				),
				3 =>
				array (
					'input_type' => 'email',
					'template' => 'user_email',
					'required' => 'yes',
					'label' => __( 'Email', 'edd_fes' ),
					'name' => 'user_email',
					'is_meta' => 'yes',
					'help' => '',
					'css' => '',
					'placeholder' => '',
					'default' => '',
					'size' => '40',
				),
				4 =>
				array (
					'input_type' => 'text',
					'template' => 'user_login',
					'required' => 'yes',
					'label' => __( 'Username', 'edd_fes' ),
					'name' => 'user_login',
					'is_meta' => 'yes',
					'help' => '',
					'css' => '',
					'placeholder' => '',
					'default' => '',
					'size' => '40',
				),
				5 =>
				array (
					'input_type' => 'password',
					'template' => 'password',
					'required' => 'yes',
					'label' => __( 'Password', 'edd_fes' ),
 					'name' => 'password',
					'is_meta' => 'yes',
					'help' => '',
					'css' => '',
					'placeholder' => '',
					'default' => '',
					'size' => '40',
					'min_length' => '6',
					'repeat_pass' => 'no'
				),
				6 =>
				array (
					'input_type' => 'text',
					'template' => 'display_name',
					'required' => 'yes',
					'label' => __( 'Display Name', 'edd_fes' ),
					'name' => 'display_name',
					'is_meta' => 'yes',
					'help' => '',
					'css' => '',
					'placeholder' => '',
					'default' => '',
					'size' => '40',
				),
			);
			update_post_meta( $page_id , 'fes-form', $register );
			break;
		case 'fes-vendor-contact-form':
			$contact = array(
				1 =>
				array (
					'input_type' => 'text',
					'template' => 'first_name',
					'required' => 'yes',
					'label' => __( 'First Name', 'edd_fes' ),
					'name' => 'first_name',
					'is_meta' => 'yes',
					'help' => '',
					'css' => '',
					'placeholder' => '',
					'default' => '',
					'size' => '40',
				),
				2 =>
				array (
					'input_type' => 'text',
					'template' => 'last_name',
					'required' => 'yes',
					'label' => __( 'Last Name', 'edd_fes' ),
					'name' => 'last_name',
					'is_meta' => 'yes',
					'help' => '',
					'css' => '',
					'placeholder' => '',
					'default' => '',
					'size' => '40',
				),
				3 =>
				array (
					'input_type' => 'email',
					'template' => 'user_email',
					'required' => 'yes',
					'label' => __( 'Email', 'edd_fes' ),
					'name' => 'user_email',
					'is_meta' => 'no',
					'help' => '',
					'css' => '',
					'placeholder' => '',
					'default' => '',
					'size' => '40',
				),
				4 =>
				array (
					'input_type' => 'text',
					'template' => 'text',
					'required' => 'yes',
					'label' => __( 'Subject', 'edd_fes' ),
					'name' => 'subject',
					'is_meta' => 'no',
					'help' => '',
					'css' => '',
					'placeholder' => '',
					'default' => '',
					'size' => '40',
				),
				5 =>
				array (
					'input_type' => 'textarea',
					'template' => 'textarea',
					'required' => 'yes',
					'label' => __( 'Message', 'edd_fes' ),
					'name' => 'message',
					'is_meta' => 'no',
					'help' => '',
					'css' => '',
					'placeholder' => '',
					'default' => '',
					'size' => '40',
				),
				6 => array(
					'input_type' => 'recaptcha',
					'template' => 'recaptcha',
					'label' => '',
				),
			);
			update_post_meta( $page_id , 'fes-form', $contact );
			break;
		default:
			break;
		}
	}

	public function install_or_update_fes() {
		global $wpdb, $wp_version, $wp_rewrite;
		$default = get_option( 'edd_fes_options', false );
		if ( $default ){
			$default = isset( $default['db_version'] ) ? $default['db_version'] : '2.0';
		}
		$version = get_option( 'fes_current_version', $default );

		// if new install
		if ( !$version ){
			$this->fes_new_install();
			update_option( 'fes_db_version', '2.2' );
			update_option( 'fes_current_version', '2.2' );
			set_transient( '_fes_activation_redirect', true, 30 );
		}
		// if 2.2 or newever
		else if ( version_compare( $version, '2.2', '>=' )  ){
			update_option( 'fes_db_version', fes_plugin_version );
			update_option( 'fes_current_version', fes_plugin_version );
			set_transient( '_fes_activation_redirect', true, 30 );
		}
		// if < 2.2
		else{
			update_option( 'fes_db_version', '2.1' );
			while ( version_compare( $version, '2.2', '<' ) ) {
				// version is 2.0 - 2.1
				if ( version_compare( $version, '2.1', '<' ) ){
					$this->fes_v21_upgrades();
					$version = '2.1';
				}
				// version is 2.1 to 2.2
				else{
					$this->fes_v22_upgrades();
					$version = '2.2';
				}
			}
			update_option( 'fes_current_version', '2.2' );
			set_transient( '_fes_activation_redirect', true, 30 );
		}
	}

	public function fes_new_install() {
		$this->add_new_roles();
		$this->create_page( 'vendor-dashboard', __( 'Vendor Dashboard', 'edd_fes' ), '[fes_vendor_dashboard]' );
		$this->create_page( 'vendor', __( 'Vendor', 'edd_fes' ), '[downloads]' );
		$this->create_post( 'fes-submission-form', __( 'Submission Form', 'edd_fes' ) );
		$this->create_post( 'fes-profile-form', __( 'Profile Form', 'edd_fes' ) );
		$this->create_post( 'fes-registration-form', __( 'Registration Form', 'edd_fes' ) );
		$this->create_post( 'fes-login-form', __( 'Login Form', 'edd_fes' ) );
		$this->create_post( 'fes-vendor-contact-form', __( 'Vendor Contact Form', 'edd_fes' ) );
	}

	public function fes_v21_upgrades() {
		//$this->create_post( 'fes-application-form', __( 'Application Form Editor', 'edd_fes' ) );
	}

	public function fes_v22_upgrades() {
		// convert settings panel
		$this->fes_v22_settings_update();
		$this->create_post( 'fes-registration-form', __( 'Registration Form', 'edd_fes' ) );
		$this->create_post( 'fes-login-form', __( 'Login Form', 'edd_fes' ) );
		$this->create_post( 'fes-vendor-contact-form', __( 'Vendor Contact Form', 'edd_fes' ) );
		
		// if application form
		if ( isset( $this->toSet['fes-application-form'] ) && $this->toSet['fes-application-form'] != '' ){
			// move fields to registration form
			$old_fields = get_post_meta( $this->toSet['fes-application-form'], 'fes-form', true);
			$new_fields = get_post_meta( $this->toSet['fes-registration-form'], 'fes-form', true);

			if ( is_array( $old_fields ) && is_array( $new_fields ) ){
				$counter = 0;
				foreach( $old_fields as $field ){
					$key = 7 + $counter;
					if ( isset( $field['input_type'] ) && $field['input_type'] == 'image_upload' && isset( $field['is_meta'] ) && $field['is_meta'] == 'no' ){
						$field['input_type'] = 'file_upload';
					}
					if ( isset( $field['template'] ) && $field['template'] == 'image_upload' && isset( $field['is_meta'] ) && $field['is_meta'] == 'no' ){
						$field['template'] = 'file_upload';
					}
					// skip these fields as they are already in the new form
					$to_skip = array( 'last_name', 'first_name', 'user_email', 'username', 'password', 'display_name' );
					if ( isset( $field['template'] ) && !in_array( $field['template'] , $to_skip ) ) {
						$new_fields[$key] = $field;
						$counter++;
					}
				}
				update_post_meta( $this->toSet['fes-registration-form'], 'fes-form', $new_fields );
			}


		}

		// if submission form
		if ( isset( $this->toSet['fes-submission-form'] ) && $this->toSet['fes-submission-form'] != '' ){
			$old_fields = get_post_meta( $this->toSet['fes-submission-form'], 'fes-form', true);
			if ( !is_array( $old_fields ) ){
				return;
			}
			else{
				// replace image uploaders with file ones
				foreach( $old_fields as $field ){
					if ( isset( $field['input_type'] ) && $field['input_type'] == 'image_upload' ){
						$field['input_type'] = 'file_upload';
					}
					if ( isset( $field['template'] ) && $field['template'] == 'image_upload' ){
						$field['template'] = 'file_upload';
					}
				}
				update_post_meta( $this->toSet['fes-submission-form'], 'fes-form', $old_fields );
			}
		}


		// if profile form
		if ( isset( $this->toSet['fes-profile-form'] ) && $this->toSet['fes-profile-form'] != '' ){
			// add fields to profile form
			$old_fields = get_post_meta( $this->toSet['fes-profile-form'], 'fes-form', true);
			$nextindex = 1;
			if ( !is_array( $old_fields ) ){
				$old_fields = array();
			}
			else{
				// replace image uploaders with file ones
				foreach( $old_fields as $field ){
					if ( isset( $field['input_type'] ) && $field['input_type'] == 'image_upload' ){
						$field['input_type'] = 'file_upload';
					}
					if ( isset( $field['template'] ) && $field['template'] == 'image_upload' ){
						$field['template'] = 'file_upload';
					}
				}

				end($old_fields); 
				$last = key($old_fields);
				$nextindex = $last + 1;
			}

			$old_fields[$nextindex] = array(
					'input_type' => 'text',
					'template' => 'text_field',
					'required' => 'yes',
					'label' => 'Name of Store',
					'name' => 'name_of_store',
					'is_meta' => 'yes',
					'help' => 'What would you like your store to be called?',
					'css' => '',
					'placeholder' => '',
					'default' => '',
					'size' => '40'
			);
			$nextindex++;
			$old_fields[$nextindex] = array(
					'input_type' => 'email',
					'template' => 'email_address',
					'required' => 'yes',
					'label' => 'Email to use for Contact Form',
					'name' => 'email_to_use_for_contact_form',
					'is_meta' => 'yes',
					'help' => 'This email, if filled in will be used for the vendor contact forms. if it is not filled in, the one from your user profile will be used.',
					'css' => '',
					'placeholder' => '',
					'default' => '',
					'size' => '40'
			);
			update_post_meta( $this->toSet['fes-profile-form'], 'fes-form', $old_fields );
		}


		// foreach fes_form if has editor in the name, remove it ( only affects FES Forms from pre 2.2 )
		// Submission form
		if ( isset( $this->toSet['fes-submission-form'] ) && $this->toSet['fes-submission-form'] != '' ){
			$id = $this->toSet['fes-submission-form'];
  			$update = array(
      			'ID'           => $id,
      			'post_title'   => __( 'Submission Form', 'edd_fes' ),
      			'post_name'    =>'fes-submission-form'
  			);
  			wp_update_post( $update );
		}
		
		// Profile form
		if ( isset( $this->toSet['fes-profile-form'] ) && $this->toSet['fes-profile-form'] != '' ){
			$id = $this->toSet['fes-profile-form'];
  			$update = array(
      			'ID'           => $id,
      			'post_title'   => __( 'Profile Form', 'edd_fes' ),
      			'post_name'    =>'fes-profile-form'
  			);
  			wp_update_post( $update );
		}

	}

	// for future
	public function fes_v23_upgrades(){
		// delete old settings option from 2.1
		// delete all old applications
		// delete application form
	}

	public function fes_v22_settings_update(){
		$old_settings = get_option( 'edd_fes_options', false );
		if ( !$old_settings ){
			return;
		}

		// Submission form
		if ( isset( $old_settings['fes-submission-form'] ) && $old_settings['fes-submission-form'] != '' ){
			$this->toSet['fes-submission-form'] = $old_settings['fes-submission-form'];
		}
		
		// Profile form
		if ( isset( $old_settings['fes-profile-form'] ) && $old_settings['fes-profile-form'] != '' ){
			$this->toSet['fes-profile-form'] = $old_settings['fes-profile-form'];
		}

		// Application form
		if ( isset( $old_settings['fes-application-form'] ) && $old_settings['fes-application-form'] != '' ){
			$this->toSet['fes-application-form'] = $old_settings['fes-application-form'];
		}		

		// Vendor form
		if ( isset( $old_settings['vendor-page'] ) && $old_settings['vendor-page'] != '' ){
			$this->toSet['fes-vendor-page'] = $old_settings['vendor-page'];
		}

		// Vendor Dashboard form
		if ( isset( $old_settings['vendor-dashboard-page'] ) && $old_settings['vendor-dashboard-page'] != '' ){
			$this->toSet['fes-vendor-dashboard-page'] = $old_settings['vendor-dashboard-page'];
		}

		// Vendor Dashboard notification
		if ( isset( $old_settings['dashboard-page-template'] ) && $old_settings['dashboard-page-template'] !== '' ){
			$this->toSet['fes-dashboard-notification'] = $old_settings['dashboard-page-template'];
		}

		// Allow Vendors Backend Access
		if ( isset( $old_settings['vendors_bea'] ) && $old_settings['vendors_bea'] !== '' ){
			$this->toSet['fes-allow-backend-access'] = $old_settings['vendors_bea'];
		}		

		// Show Vendor Registration
		if ( isset( $old_settings['show_vendor_registration'] ) && $old_settings['show_vendor_registration'] !== '' ){
			$this->toSet['show_vendor_registration'] = $old_settings['show_vendor_registration'];
		}

		// Auto Approve Vendors
		if ( isset( $old_settings['edd_fes_auto_approve_vendors'] ) && $old_settings['edd_fes_auto_approve_vendors'] !== '' ){
			$this->toSet['fes-auto-approve-vendors'] = $old_settings['edd_fes_auto_approve_vendors'];
		}

		// Allow Vendors to Edit Products
		if ( isset( $old_settings['edd_fes_vendor_permissions_edit_product'] ) && $old_settings['edd_fes_vendor_permissions_edit_product'] !== '' ){
			$this->toSet['fes-allow-vendors-to-edit-products'] = $old_settings['edd_fes_vendor_permissions_edit_product'];
		}

		// Allow Vendors to Delete Products
		if ( isset( $old_settings['edd_fes_vendor_permissions_delete_product'] ) && $old_settings['edd_fes_vendor_permissions_delete_product'] !== '' ){
			$this->toSet['fes-allow-vendors-to-delete-products'] = $old_settings['edd_fes_vendor_permissions_delete_product'];
		}

		// Use EDD's CSS
		if ( isset( $old_settings['edd_fes_use_css'] ) && $old_settings['edd_fes_use_css'] !== '' ){
			$this->toSet['fes-use-css'] = $old_settings['edd_fes_use_css'];
		}

		// Admin notification on new vendor application
		if ( isset( $old_settings['edd_fes_notify_admin_new_app_toggle'] ) && $old_settings['edd_fes_notify_admin_new_app_toggle'] !== '' ){
			$this->toSet['fes-admin-new-app-email-toggle'] = $old_settings['edd_fes_notify_admin_new_app_toggle'];
		}

		// Admin message on new vendor application
		if ( isset( $old_settings['edd_fes_notify_admin_new_app_message'] ) && $old_settings['edd_fes_notify_admin_new_app_message'] != '' ){
			$this->toSet['fes-admin-new-app-email'] = $old_settings['edd_fes_notify_admin_new_app_message'];
		}

		// User message on new vendor application
		if ( isset( $old_settings['edd_fes_notify_user_new_app_message'] ) && $old_settings['edd_fes_notify_user_new_app_message'] != '' ){
			$this->toSet['fes-vendor-new-app-email'] = $old_settings['edd_fes_notify_user_new_app_message'];
		}

		// Admin message on new vendor submission
		if ( isset( $old_settings['new_edd_fes_submission_admin_message'] ) && $old_settings['new_edd_fes_submission_admin_message'] != '' ){
			$this->toSet['fes-admin-new-submission-email'] = $old_settings['new_edd_fes_submission_admin_message'];
		}

		// User message on vendor application accepted
		if ( isset( $old_settings['edd_fes_notify_user_app_accepted_message'] ) && $old_settings['edd_fes_notify_user_app_accepted_message'] != '' ){
			$this->toSet['fes-vendor-app-approved-email'] = $old_settings['edd_fes_notify_user_app_accepted_message'];
		}

		// User message on vendor application denied
		if ( isset( $old_settings['edd_fes_notify_user_app_denied_message'] ) && $old_settings['edd_fes_notify_user_app_denied_message'] != '' ){
			$this->toSet['fes-vendor-app-declined-email'] = $old_settings['edd_fes_notify_user_app_denied_message'];
		}

		// User message on new vendor submission
		if ( isset( $old_settings['new_edd_fes_submission_user_message'] ) && $old_settings['new_edd_fes_submission_user_message'] != '' ){
			$this->toSet['fes-vendor-new-submission-email'] = $old_settings['new_edd_fes_submission_user_message'];
		}

		// User message on new vendor submission accepted
		if ( isset( $old_settings['edd_fes_submission_accepted_message'] ) && $old_settings['edd_fes_submission_accepted_message'] != '' ){
			$this->toSet['fes-vendor-submission-approved-email'] = $old_settings['edd_fes_submission_accepted_message'];
		}

		// User message on new vendor submission declined
		if ( isset( $old_settings['edd_fes_submission_declined_message'] ) && $old_settings['edd_fes_submission_declined_message'] != '' ){
			$this->toSet['fes-vendor-submission-declined-email'] = $old_settings['edd_fes_submission_declined_message'];
		}

		// reCAPTCHA Public Key
		if ( isset( $old_settings['recaptcha_public'] ) && $old_settings['recaptcha_public'] != '' ){
			$this->toSet['fes-recaptcha-public-key'] = $old_settings['recaptcha_public'];
		}

		// reCAPTCHA Private Key
		if ( isset( $old_settings['recaptcha_private'] ) && $old_settings['recaptcha_private'] != '' ){
			$this->toSet['fes-recaptcha-private-key'] = $old_settings['recaptcha_private'];
		}
	}

	private function add_new_roles() {
		global $wp_roles;
		remove_role( 'pending_vendor' );
		add_role( 'pending_vendor', __( 'Pending Vendor', 'edd_fes' ), array(
				'read' => true,
				'edit_posts' => false,
				'delete_posts' => false
			) );
		remove_role( 'suspended_vendor' );
		add_role( 'suspended_vendor', __( 'Suspended Vendor', 'edd_fes' ), array(
				'read' => true,
				'edit_posts' => false,
				'delete_posts' => false
			) );
		remove_role( 'frontend_vendor' );
		add_role( 'frontend_vendor', 'Frontend Vendor', array(
				'read' => true,
				'edit_posts' => true,
				'upload_files' => true,
				'delete_posts' => false,
				'manage_categories' => false,
				'unfiltered_html' => false
			) );
		if ( class_exists( 'WP_Roles' ) && !isset( $wp_roles ) )
			$wp_roles = new WP_Roles();
		if ( is_object( $wp_roles ) ) {
			$capabilities     = array();
			$capability_types = array(
				'product'
			);
			foreach ( $capability_types as $capability_type ) {
				$capabilities[ $capability_type ] = array(
					// Post type
					"edit_{$capability_type}",
					"read_{$capability_type}",
					"delete_{$capability_type}",
					"edit_{$capability_type}s",
					"read_private_{$capability_type}s",
					"edit_private_{$capability_type}s",
					// Terms
					"manage_{$capability_type}_terms",
					"edit_{$capability_type}_terms",
					"assign_{$capability_type}_terms"
				);
			}
			foreach ( $capabilities as $cap_group ) {
				foreach ( $cap_group as $cap ) {
					$wp_roles->add_cap( 'frontend_vendor', $cap );
				}
			}
			$wp_roles->add_cap( 'frontend_vendor', 'edit_product' );
			$wp_roles->add_cap( 'frontend_vendor', 'edit_products' );
			$wp_roles->add_cap( 'frontend_vendor', 'upload_files' );
			$wp_roles->add_cap( 'frontend_vendor', 'assign_product_terms' );
			$wp_roles->add_cap( 'frontend_vendor', 'delete_product' );
			$wp_roles->add_cap( 'frontend_vendor', 'delete_products' );

			$wp_roles->add_cap( 'administrator', 'fes_is_admin' );
			$wp_roles->add_cap( 'editor', 'fes_is_admin' );
		}
	}
}