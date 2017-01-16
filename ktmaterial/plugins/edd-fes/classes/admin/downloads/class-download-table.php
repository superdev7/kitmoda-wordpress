<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class FES_Download_Table {
	public function __construct() {
		add_filter( 'manage_edit-download_columns', array(
			 $this,
			'columns' 
		) );
		add_action( 'manage_download_posts_custom_column', array(
			 $this,
			'custom_columns' 
		), 2 );
		add_action( 'admin_footer-edit.php', array(
			 $this,
			'add_bulk_actions' 
		) );
		add_action( 'load-edit.php', array(
			 $this,
			'do_bulk_actions' 
		) );
		add_action( 'admin_init', array(
			 $this,
			'approve_download' 
		) );
		add_action( 'admin_notices', array(
			 $this,
			'approved_notice' 
		) );
		add_filter( 'post_row_actions', array(
			 $this,
			'remove_quick_edit' 
		), 10, 2 );
	}
	
	public function remove_quick_edit( $actions ) {
		global $post;
		if ( $post->post_type == 'fes-forms' ) {
			unset( $actions[ 'inline hide-if-no-js' ] );
		}
		return $actions;
	}
	public function add_bulk_actions() {
		global $post_type;
		if ( $post_type == 'download' ) {
?>
			<script type="text/javascript">
		      jQuery(document).ready(function() {
		        jQuery('<option>').val('approve_downloads').text('<?php
			_e( 'Approve Downloads', 'edd_fes' );
?>').appendTo("select[name='action']");
		        jQuery('<option>').val('approve_downloads').text('<?php
			_e( 'Approve Downloads', 'edd_fes' );
?>').appendTo("select[name='action2']");
		      });
		    </script>
		    <?php
		}
	}
	
	public function do_bulk_actions() {
		$wp_list_table = new FES_List_Table();
		$action        = $wp_list_table->current_action();
		switch ( $action ) {
			case 'approve_downloads':
				check_admin_referer( 'bulk-posts' );
				$post_ids           = array_map( 'absint', array_filter( (array) $_GET[ 'post' ] ) );
				$approved_downloads = array();
				if ( !empty( $post_ids ) )
					foreach ( $post_ids as $post_id ) {
						$download_data = array(
							 'ID' => $post_id,
							'post_status' => 'publish' 
						);
						if ( get_post_status( $post_id ) == 'pending' && wp_update_post( $download_data ) ){
							$approved_downloads[] = $post_id;
						}
						$post = get_post( $post_id );

						$user = new WP_User( $post->post_author );
						$to = $user->user_email;
						$from_name = isset( $edd_options[ 'from_name' ] ) ? $edd_options[ 'from_name' ] : get_bloginfo( 'name' );
						$from_email = isset( $edd_options[ 'from_email' ] ) ? $edd_options[ 'from_email' ] : get_option( 'admin_email' );
						$subject = apply_filters( 'fes_submission_accepted_message_subj', __( 'Submission Accepted', 'edd_fes' ), 0 );
						$message = EDD_FES()->helper->get_option( 'fes-vendor-submission-approved-email', '' );
						$type = "post";
						$id = $post->ID;
						$args['permissions'] = 'fes-vendor-submission-approved-email-toggle';
						EDD_FES()->emails->send_email( $to , $from_name, $from_email, $subject, $message, $type, $id, $args );
						do_action('fes_approve_download_admin', $post_id );
					}
				wp_redirect( remove_query_arg( 'approve_downloads', add_query_arg( 'approved_downloads', $approved_downloads, admin_url( 'edit.php?post_type=download' ) ) ) );
				exit;
				break;
		}
		return;
	}
	
	public function approve_download() {
		if ( !empty( $_GET[ 'approve_download' ] ) && wp_verify_nonce( $_REQUEST[ '_wpnonce' ], 'approve_download' ) && current_user_can( 'edit_post', $_GET[ 'approve_download' ] ) ) {
			$post_id       = absint( $_GET[ 'approve_download' ] );
			$download_data = array(
				 'ID' => $post_id,
				'post_status' => 'publish' 
			);
			wp_update_post( $download_data );
			$post = get_post( $post_id );

			$user = new WP_User( $post->post_author );
			$to = $user->user_email;
			$from_name = isset( $edd_options[ 'from_name' ] ) ? $edd_options[ 'from_name' ] : get_bloginfo( 'name' );
			$from_email = isset( $edd_options[ 'from_email' ] ) ? $edd_options[ 'from_email' ] : get_option( 'admin_email' );
			$subject = apply_filters( 'fes_submission_accepted_message_subj', __( 'Submission Accepted', 'edd_fes' ), 0 );
			$message = EDD_FES()->helper->get_option( 'fes-vendor-submission-approved-email', '' );
			$type = "post";
			$id = $post->ID;
			$args['permissions'] = 'fes-vendor-submission-approved-email-toggle';
			EDD_FES()->emails->send_email( $to , $from_name, $from_email, $subject, $message, $type, $id, $args );
			do_action('fes_approve_download_admin', $post_id );
			wp_redirect( remove_query_arg( 'approve_download', add_query_arg( 'approved_downloads', $post_id, admin_url( 'edit.php?post_type=download' ) ) ) );
			exit;
		}
	}
	
	public function approved_notice() {
		global $post_type, $pagenow;
		if ( $pagenow == 'edit.php' && $post_type == 'download' && !empty( $_REQUEST[ 'approved_downloads' ] ) ) {
			$approved_downloads = $_REQUEST[ 'approved_downloads' ];
			if ( is_array( $approved_downloads ) ) {
				$approved_downloads = array_map( 'absint', $approved_downloads );
				$titles             = array();
				foreach ( $approved_downloads as $download_id )
					$titles[] = get_the_title( $download_id );
				echo '<div class="updated"><p>' . sprintf( __( '%s approved', 'edd_fes' ), '&quot;' . implode( '&quot;, &quot;', $titles ) . '&quot;' ) . '</p></div>';
			} else {
				echo '<div class="updated"><p>' . sprintf( __( '%s approved', 'edd_fes' ), '&quot;' . get_the_title( $approved_downloads ) . '&quot;' ) . '</p></div>';
			}
		}
	}
	
	public function columns( $columns ) {
		$columns               = array();
		$columns[ "cb" ]       = "<input type=\"checkbox\" />";
		$columns[ "status" ]   = __( "Status", "edd_fes" );
		if ( current_user_can( 'shop_worker' )  || current_user_can( 'shop_manager' ) || current_user_can( 'manage_shop_settings' ) || current_user_can( 'manage_shop_settings' ) ) {
		$columns[ "actions" ]  = __( "Actions", "edd_fes" );
		}
		$columns[ "product" ]  = EDD_FES()->vendors->get_product_constant_name( $plural = false, $uppercase = true );
		$columns[ "author" ]   = EDD_FES()->vendors->get_vendor_constant_name( $plural = false, $uppercase = true );
		$columns[ "price" ]    = __( "Price", "edd_fes" );
		$columns[ "sales" ]    = __( "Sales", "edd_fes" );
		$columns[ "earnings" ] = __( "Earnings", "edd_fes" );
		$columns[ "date" ]     = __( "Date", "edd_fes" );
		if ( !current_user_can( 'view_shop_reports' ) ) {
			unset( $columns[ 'sales' ] );
			unset( $columns[ 'earnings' ] );
		}
		return apply_filters( 'fes_admin_columns', $columns );
	}
	
	public function custom_columns( $column ) {
		global $post;
		$post_id = $post->id;
		switch ( $column ) {
			case "status":
				echo '<span class="download-status ' . $this->get_the_download_status( $post, true ) . '">' . $this->get_the_download_status( $post, false ) . '</span>';
				break;
			case "product":
				edit_post_link( '#' . $post->ID . ' &ndash; ' . $post->post_title, '<strong>', '</strong>', $post->ID );
				break;
			case "actions":
				$admin_actions = array();
				if ( $post->post_status !== 'trash' ) {
					$admin_actions[ 'view' ]   = array(
						 'action' => 'view',
						'name' => __( 'View', 'edd_fes' ),
						'url' => get_permalink( $post->ID ) 
					);
					$admin_actions[ 'edit' ]   = array(
						 'action' => 'edit',
						'name' => __( 'Edit', 'edd_fes' ),
						'url' => get_edit_post_link( $post->ID ) 
					);
					if ( $post->post_status !== 'publish' ){
						$admin_actions[ 'delete' ] = array(
							'action' => 'delete',
							'name' => __( 'Delete', 'edd_fes' ),
							'url' => get_delete_post_link( $post->ID ) 
						);
					}
					else{
						$admin_actions[ 'revoke' ] = array(
							'action' => 'delete',
							'name' => __( 'Revoke', 'edd_fes' ),
							'url' => get_delete_post_link( $post->ID ) 
						);
					}
				}
				if ( $post->post_status == 'pending' && current_user_can( 'publish_posts' ) ) {
					$admin_actions[ 'approve' ] = array(
						'action' => 'approve',
						'name' => __( 'Approve', 'edd_fes' ),
						'url' => wp_nonce_url( add_query_arg( 'approve_download', $post->ID ), 'approve_download' ) 
					);
				}
				$admin_actions = apply_filters( 'fes_admin_actions', $admin_actions, $post );
				foreach ( $admin_actions as $action ) {
					$image = isset( $action[ 'image_url' ] ) ? $action[ 'image_url' ] : fes_plugin_url . 'assets/img/icons/' . $action[ 'action' ] . '.png';
					printf( '<a class="button tips" href="%s" data-tip="%s"><img src="%s" alt="%s" width="14" /></a>', esc_url( $action[ 'url' ] ), esc_attr( $action[ 'name' ] ), esc_attr( $image ), esc_attr( $action[ 'name' ] ) );
				}
				break;
			case 'custom':
				do_action( 'fes_admin_column_values', $post );
				break;
		}
	}
	
	public function get_the_download_status( $post = null, $css = false ) {
		$post   = get_post( $post );
		$status = $post->post_status;
		if ( $css ) {
			if ( $status == 'publish' ){
				$status = 'published';
			} elseif ( $status == 'expired' ){
				$status = 'expired';
			} elseif ( $status == 'pending' ){
				$status = 'pending-review';
			} elseif ( $status == 'draft' ){
				$status = 'draft';
			} elseif ( $status == 'future' ){
				$status = 'scheduled';
			} else{
				$status = 'trash';
			}
			return apply_filters( 'fes_the_download_status_css', $status, $post );
		}
		if ( $status == 'publish' ){
			$status = __( 'Live', 'edd_fes' );
		} elseif ( $status == 'draft' ){
			$status = __( 'Draft', 'edd_fes' );
		} elseif ( $status == 'pending' ){
			$status = __( 'Pending Review', 'edd_fes' );
		} elseif ( $status == 'future' ){
			$status = __( 'Scheduled', 'edd_fes' );
		} else{
			$status = __( 'Trash', 'edd_fes' );
		}
		return apply_filters( 'fes_the_download_status', $status, $post );
	}
}