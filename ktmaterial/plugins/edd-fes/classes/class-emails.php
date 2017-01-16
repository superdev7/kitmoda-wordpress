<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class FES_Emails {
	function __construct() {
		add_filter( 'transition_post_status', array(
			 $this,
			'post_status'
		), 10, 3 );
	}

	// New/beta in 2.2, this function replaces shortcodes for the meta names of custom text fields and subs in the values
	function custom_meta_values( $post_id, $user_id, $type = "user", $message ){
		$profile = array('textarea', 'text','url', 'date', 'email', 'eddc_user_paypal');
		$submission = array('text','textarea','date','url','email');
		$submission_meta = array();
		$user_meta = array();

		$form_id = EDD_FES()->helper->get_option( 'fes-submission-form', false );
		if ( $form_id ){
			list($post_fields, $taxonomy_fields, $custom_fields) = EDD_FES()->forms->get_input_fields( $form_id );
			foreach($custom_fields as $field){
				if ( in_array( $field['input_type'], $submission ) ){
					array_push($submission_meta, $field['name']);
				}
			}
		}

		$form_id = EDD_FES()->helper->get_option( 'fes-registration-form', false );
		if ( $form_id ){
			list($user_vars, $taxonomy_vars, $meta_vars) = EDD_FES()->forms->get_input_fields( $form_id );
			foreach($meta_vars as $field){
				if ( in_array( $field['input_type'], $profile ) ){
					array_push($user_meta, $field['name']);
				}
			}
		}

		$form_id = EDD_FES()->helper->get_option( 'fes-profile-form', false );
		if ( $form_id ){
			list($user_vars, $taxonomy_vars, $meta_vars) = EDD_FES()->forms->get_input_fields( $form_id );
			foreach($meta_vars as $field){
				if ( in_array( $field['input_type'], $profile ) ){
					array_push($user_meta, $field['name']);
				}
			}
		}


		if ( $type === 'post'){
			foreach($submission_meta as $meta ){
				$message = str_replace('{'.$meta.'}', EDD_FES()->helper->get_post_meta($meta, $post_id), $message );
			}
		}

		foreach($user_meta as $meta ){
			$message = str_replace('{'.$meta.'}', EDD_FES()->helper->get_user_meta($meta, $user_id), $message );
		}

		return $message;
	}


	// This function only exists because of #blamepippin and will probably be gone after EDD 2.0 is released.
	// id is int of post or user id. Guest user ids and unpublished post ids can be null or (int) -1
	// message is string message to translate
	function email_tags( $id = null, $message = " ", $type = "other" ){

		$has_tags = ( strpos( $message, '{' ) !== false );
		$bypass_tag_check = apply_filters('fes_bypass_tag_check', false, $id, $message, $type);
		if ( ! $has_tags && !$bypass_tag_check ){
			return $message;
		}

		// Some sort of email to do with users. Application received. Application approved. Etc.
		if ( $type === "user" ){
			$user = new WP_User( $id );
			$firstname = '';
			$lastname  = '';
			$fullname  = '';
			$username  = '';
			if ( isset( $user->ID ) && $user->ID > 0 && isset( $user->first_name ) ) {
				$user_data = get_userdata( $user->ID );
				$firstname = $user->first_name;
				$lastname  = $user->last_name;
				$fullname  = $user->first_name . ' ' . $user->last_name;
				$username  = $user_data->user_login;
			} elseif ( isset( $user->first_name ) ) {
				$firstname = $user->first_name;
				$lastname  = $user->last_name;
				$fullname  = $user->first_name . ' ' . $user->last_name;
				$username  = $user->first_name;
			} else {
				$name      = $user->user_email;
				$firstname = $name;
				$lastname  = $name;
				$fullname  = $name;
				$username  = $name;
			}
			$message = str_replace( '{firstname}', $firstname, $message );
			$message = str_replace( '{lastname}', $lastname, $message );
			$message = str_replace( '{fullname}', $fullname, $message );
			$message = str_replace( '{username}', $username, $message );
			$message = str_replace( '{sitename}', get_bloginfo( 'name' ), $message );
			$message = EDD_FES()->emails->custom_meta_values( $post_id = 0, $user->ID, $type = "user", $message );
			return apply_filters( "fes_email_tags_user", $message, $id );
		}

		// Some sort of email to do with posts. Post submitted. Post approved. Etc.
		else if ( $type === "post" ){
			$post = get_post( $id );
			$user = new WP_User( $post->post_author);
			$firstname = '';
			$lastname  = '';
			$fullname  = '';
			$username  = '';
			if ( isset( $user->ID ) && $user->ID > 0 && isset( $user->first_name ) ) {
				$user_data = get_userdata( $user->ID );
				$firstname = $user->first_name;
				$lastname  = $user->last_name;
				$fullname  = $user->first_name . ' ' . $user->last_name;
				$username  = $user_data->user_login;
			} elseif ( isset( $user->first_name ) ) {
				$firstname = $user->first_name;
				$lastname  = $user->last_name;
				$fullname  = $user->first_name . ' ' . $user->last_name;
				$username  = $user->first_name;
			} else {
				$name      = $user->user_email;
				$firstname = $name;
				$lastname  = $name;
				$fullname  = $name;
				$username  = $name;
			}
			$message = str_replace( '{firstname}', $firstname, $message );
			$message = str_replace( '{lastname}', $lastname, $message );
			$message = str_replace( '{fullname}', $fullname, $message );
			$message = str_replace( '{username}', $username, $message );
			$message = str_replace( '{sitename}', get_bloginfo( 'name' ), $message );
			$message = str_replace( '{post-title}', $post->post_title, $message );
			$message = str_replace( '{post-content}', wp_strip_all_tags( $post->post_content ), $message );
			$message = str_replace( '{post-date}', $post->post_date, $message );
			$message = str_replace( '{post-excerpt}', wp_strip_all_tags( $post->post_excerpt ), $message );
			$message = str_replace( '{post-status}', $post->post_status, $message );

			$taglist = "";
			$posttags = get_the_tags( $post->ID );
			if ($posttags) {
				foreach($posttags as $tag) {
					$taglist .=  $tag->name . ', ';
				}
				$taglist = rtrim($taglist, ", ");
			}

			$message = str_replace( '{post-tags}', $taglist, $message );

			$catlist = "";
			$postcats = get_the_category( $post->ID );
			if ($postcats) {
				foreach($postcats as $cat) {
					$catlist .=  $cat->cat_name . ', ';
				}
				$catlist = rtrim($catlist, ", ");
			}

			$message = str_replace( '{post-categories}', $catlist, $message );
			$message = str_replace( '{post-category}', $catlist, $message );
			$message = EDD_FES()->emails->custom_meta_values( $id, $user->ID, $type = "post", $message );
			return apply_filters( "fes_email_tags_post", $message, $id );
		}
		else {
			return apply_filters( "fes_email_tags_other", $message, $id );
		}
	}

	// Devs: Please note, you should validate & sanitize all parameters before sending them in here.
	public function send_email( $to, $from_name, $from_email, $subject, $message, $type, $id, $args ){

		if ( ! EDD_FES()->emails->should_send( $args ) ) {
			return false;
		}

		// start building the email
		$message_to_send = EDD_FES()->emails->email_tags( $id, $message, $type );
		$message_to_send = apply_filters('fes_send_mail_message', $message_to_send, $to, $from_name, $from_email, $subject, $message, $type, $id, $args );

		if( class_exists( 'EDD_Emails' ) ) {

			$emails = new EDD_Emails;

			$emails->from_name    = $from_name;
			$emails->from_address = $from_email;
			$emails->heading      = $subject;

			$emails->send( $to, $subject, $message_to_send );

		} else {
			$headers  = "From: " . stripslashes_deep( html_entity_decode( $from_name, ENT_COMPAT, 'UTF-8' ) ) . " <$from_email>\r\n";
			$headers .= "Reply-To: " . $from_email . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers = apply_filters('fes_send_mail_headers', $headers, $to, $from_name, $from_email, $subject, $message, $type, $id, $args );
			wp_mail( $to, $subject, $message_to_send, $headers );
		}

	}

	public function should_send( $args = array() ){

		$ret = true;

		global $fes_settings;

		if( isset( $args['permissions'] ) ) {

			// See if there's a toggle for this email in the settings panel
			// If the toggle is enabled, we send
			$ret = isset( $fes_settings[ $args['permissions'] ] ) && '1' == $fes_settings[ $args['permissions'] ];

		}

		return (bool) apply_filters( 'fes_no_email_filter', $ret, $args );
	}

	function post_status( $latest_status, $previous_status, $post ) {
		global $current_user, $post;
		// Not an object if its not a draft yet. So prior to autosave this might throw warnings
		// We can prevent this by returning till it's been autosaved. This is when it becomes an obj.
		if ( !is_object( $post ) ) {
			return;
		}
		if ( $post->post_type != 'download' ) {
			return;
		}
		if ( $previous_status == 'pending' && $latest_status == 'trash' ) {
			$user = new WP_User( $post->post_author );
			$to = apply_filters('fes_submission_declined_email_to',$user->user_email, $user);
			$from_name = isset( $edd_options[ 'from_name' ] ) ? $edd_options[ 'from_name' ] : get_bloginfo( 'name' );
			$from_email = isset( $edd_options[ 'from_email' ] ) ? $edd_options[ 'from_email' ] : get_option( 'admin_email' );
			$subject = apply_filters( 'fes_submission_declined_message_subj', __( 'Submission Declined', 'edd_fes' ), 0 );
			$message = EDD_FES()->helper->get_option( 'fes-vendor-submission-declined-email', '' );
			$type = "post";
			$id = $post->ID;
			$args['permissions'] = 'fes-vendor-submission-declined-email-toggle';
			EDD_FES()->emails->send_email( $to , $from_name, $from_email, $subject, $message, $type, $id, $args );
			return;
		}
		if ( $previous_status == 'publish' && $latest_status == 'trash' ) {
			$user = new WP_User( $post->post_author );
			$to = apply_filters('fes_submission_revoked_email_to',$user->user_email, $user);
			$from_name = isset( $edd_options[ 'from_name' ] ) ? $edd_options[ 'from_name' ] : get_bloginfo( 'name' );
			$from_email = isset( $edd_options[ 'from_email' ] ) ? $edd_options[ 'from_email' ] : get_option( 'admin_email' );
			$subject = apply_filters( 'fes_submission_revoked_message_subj', __( 'Submission Revoked', 'edd_fes' ), 0 );
			$message = EDD_FES()->helper->get_option( 'fes-vendor-submission-revoked-email', '' );
			$type = "post";
			$id = $post->ID;
			$args['permissions'] = 'fes-vendor-submission-revoked-email-toggle';
			EDD_FES()->emails->send_email( $to , $from_name, $from_email, $subject, $message, $type, $id, $args );
			return;
		}
	}
}
