<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class FES_Dashboard {
	function __construct() {
		add_shortcode( 'fes_vendor_dashboard', array(
			 $this,
			'display_fes_dashboard'
		) );
		add_action( 'template_redirect', array(
			 $this,
			'check_access'
		) );

		add_action( 'init', array(
			$this,
			'delete_product'
		) );
		add_action('init',array($this,'comment_intercept'));
		add_action('init',array($this,'mark_comment_as_read'));

	}

	public function check_access() {
		global $post;
		if ( is_page( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ) ) && ( has_shortcode( $post->post_content, 'fes_vendor_dashboard' ) ) ) {
			$task = !empty( $_GET[ 'task' ] ) ? $_GET[ 'task' ] : '';
			if ( $task == 'logout' ) {
				$this->fes_secure_logout();
			}
			if ( is_user_logged_in() && !EDD_FES()->vendors->vendor_is_vendor() && !isset( $_GET[ 'view' ] ) ) {
				EDD_FES()->vendors->vendor_not_a_vendor_redirect();
			}
		}
	}

	public function display_fes_dashboard( $atts ) {
		global $post;

		$view = !empty( $_REQUEST[ 'view' ] ) ? $_REQUEST[ 'view' ] : 'login-register';

		if ( $view && !EDD_FES()->vendors->vendor_is_vendor() ) {
			ob_start();
			switch ( $view ) {
				case 'login':
					echo EDD_FES()->forms->render_login_form();
					break;
				case 'register':
					echo EDD_FES()->forms->render_registration_form();
					break;
				case 'login-register':
					echo EDD_FES()->forms->render_login_registration_form();
					break;
				default:
					echo EDD_FES()->forms->render_login_registration_form();
					break;
			}
			return ob_get_clean();
		} else {
			extract( shortcode_atts( array(
				 'user_id' => get_current_user_id()
			), $atts ) );

			//Session set for upload watermarking
			$fes_post_id = isset( $post->ID ) ? $post->ID : '';
			EDD()->session->set( 'edd_fes_post_id', $fes_post_id );

			$task = !empty( $_GET[ 'task' ] ) ? $_GET[ 'task' ] : '';
			ob_start();
			/* Load Menu */
			$custom = apply_filters('fes_signal_custom_task', false, $task );
			EDD_FES()->templates->fes_get_template_part( 'frontend', 'menu' );
			echo '<div id="fes-vendor-dashboard">';
			/* Get page options */
			switch ( $task ) {
				case 'dashboard':
					EDD_FES()->templates->fes_get_template_part( 'frontend', 'dashboard' );
					break;
				case 'products':
					global $products;
					$status = isset( $_GET['status'] ) ? $_GET['status'] : false;
					$products = EDD_FES()->vendors->get_products( get_current_user_id(), $status );
					EDD_FES()->templates->fes_get_template_part( 'frontend', 'products' );
					break;
				case 'new-product':
					echo EDD_FES()->forms->render_submission_form();
					break;
				case 'edit-product':
					echo EDD_FES()->forms->render_submission_form();
					break;
				case 'delete-product':
					EDD_FES()->templates->fes_get_template_part( 'frontend', 'delete-product' );
					break;
				case 'earnings':
					EDD_FES()->templates->fes_get_template_part( 'frontend', 'earnings' );
					break;
				case 'orders':
					global $orders;

					// if no permission to view, send to dashboard
					if ( !EDD_FES()->vendors->vendor_can_view_orders() ){
						EDD_FES()->templates->fes_get_template_part( 'frontend', 'dashboard' );
						break;
					}

					$orders = EDD_FES()->vendors->get_all_orders( get_current_user_id(), array() );
					EDD_FES()->templates->fes_get_template_part( 'frontend', 'orders' );
					break;
				case 'edit-order':

					// if no permission to view, send to dashboard
					if ( !EDD_FES()->vendors->vendor_can_view_orders() ){
						EDD_FES()->templates->fes_get_template_part( 'frontend', 'dashboard' );
						break;
					}

					EDD_FES()->templates->fes_get_template_part( 'frontend', 'edit-order' );
					break;
				case 'profile':
					EDD()->session->set( 'edd_fes_post_id', '' );
					echo EDD_FES()->forms->render_profile_form();
					break;
				case '':
					EDD_FES()->templates->fes_get_template_part( 'frontend', 'dashboard' );
					break;
				case $custom:
					do_action( 'fes_custom_task_' . $task );
					break;
				default:
					EDD_FES()->templates->fes_get_template_part( 'frontend', 'dashboard' );
					break;
			}
			echo '</div>';
			return ob_get_clean();
		}
	}

	public function fes_secure_logout() {
		if ( is_user_logged_in() ) {
			wp_logout();
			$base_url = get_permalink( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ) );
			$base_url = add_query_arg( array(
				'view' => 'login',
				'task' => false
			), $base_url );
			wp_redirect( $base_url );
			exit;
		}
	}

	public function delete_product() {
		if( ! isset( $_POST['fes_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce($_POST['fes_nonce'], 'fes_delete_nonce') ) {
			return;
		}

		if( ! isset( $_POST['pid'] ) ) {
			return;
		}

		$post_id = absint( $_POST['pid'] );
		if ( EDD_FES()->vendors->vendor_can_delete_product($post_id) ){
			wp_delete_post( $post_id );
		}

		$redirect_to = get_permalink( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ) );
		$redirect_to = add_query_arg( array(
			'task' => 'products'
		), $redirect_to );
		$redirect_to = apply_filters('fes_delete_product_redirection', $redirect_to, $_POST['pid'] );
		do_action('fes_vendor_delete_product', $_POST['pid'] );

		wp_redirect( get_permalink( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ) ) );
		exit;
	}

	public function get_vendor_dashboard_menu() {
		$menu_items = array();
		$menu_items['home'] = array(
			"icon" => "home",
			"task" => array( 'dashboard', '' ),
			"name" => __( 'Dashboard', 'edd_fes' ),
		);
		$menu_items['my_products'] = array(
			"icon" => "list",
			"task" => array( 'products' ),
			"name" => EDD_FES()->vendors->get_product_constant_name( $plural = true, $uppercase = true ),
		);
		if ( EDD_FES()->vendors->vendor_can_create_product() ) {
			$menu_items['new_product'] = array(
				"icon" => "pencil",
				"task" => array( 'new-product' ),
				"name" => sprintf( __( 'Add %s', 'edd_fes' ), EDD_FES()->vendors->get_product_constant_name( $plural = false, $uppercase = true ) ),
			);
		}
		if ( EDD_FES()->integrations->is_commissions_active() ) {
			$menu_items['earnings'] = array(
				"icon" => "earnings",
				"task" => array( 'earnings' ),
				"name" => __( 'Earnings', 'edd_fes' ),
			);
		}
		if ( EDD_FES()->vendors->vendor_can_view_orders() ){
			$menu_items['orders'] = array(
				"icon" => "gift",
				"task" => array( 'orders' ),
				"name" => __( 'Orders', 'edd_fes' ),
			);
		}
		$menu_items['profile'] = array(
			"icon" => "user",
			"task" => array( 'profile' ),
			"name" => __( 'Profile', 'edd_fes' ),
		);
		$menu_items['logout'] = array(
			"icon" => "off",
			"task" => array( 'logout' ),
			"name" => __( 'Logout', 'edd_fes' ),
		);
		$menu_items = apply_filters( "fes_vendor_dashboard_menu", $menu_items );
		return $menu_items;
	}

	public function product_list_title( $product_id ) {
		$title = esc_html( get_the_title( $product_id ) );
		$title = apply_filters( 'fes_product_list_title', $title, $product_id );
		return $title;
	}

	public function product_list_url( $product_id ) {
		$url = esc_url( get_permalink( $product_id ) );
		$url = apply_filters( 'fes_product_list_url', $url, $product_id );
		return $url;
	}

	public function product_list_edit_url( $product_id ) {
		$url = add_query_arg( array( 'task' => 'edit', 'post_id' => $product_id ), get_permalink() );
		$url = apply_filters( 'fes_product_list_edit_url', $url, $product_id );
		return $url;
	}

	public function product_list_delete_url( $product_id ) {
		$url = add_query_arg( array( 'task' => 'delete', 'post_id' => $product_id ), get_permalink() );
		$url = apply_filters( 'fes_product_list_delete_url', $url, $product_id );
		return $url;
	}

	public function product_list_status( $product_id ) {
		$status = '<span class="download-status ' . EDD_FES()->dashboard->product_list_generate_status( $product_id, true ) . '">' . EDD_FES()->dashboard->product_list_generate_status( $product_id, false ) . '</span>';
		$status = apply_filters( 'fes_product_list_status', $status, $product_id );
		return $status;
	}

	public function product_list_price( $product_id ) {
		if ( edd_has_variable_prices( $product_id ) ){
			$price = edd_price_range( $product_id );
		}
		else{
			$price = edd_price( $product_id );
		}
		$price = apply_filters( 'fes_product_list_price', $price, $product_id );
		return $price;
	}

	public function product_list_sales( $product_id ) {
		$sales = edd_get_download_sales_stats( $product_id );
		$sales = apply_filters( 'fes_product_list_title', $sales, $product_id );
		return $sales;
	}

	public function product_list_sales_esc( $product_id ) {
		$sales = esc_html( edd_get_download_sales_stats( $product_id ) );
		$sales = apply_filters( 'fes_product_list_title', $sales, $product_id );
		return $sales;
	}

	public function product_list_actions( $product_id ) {

		if( 'publish' == get_post_status( $product_id ) ) : ?>
			<a href="<?php echo esc_html( get_permalink( $product_id ) );?>" title="<?php _e( 'View', 'edd_fes' );?>" class="btn btn-mini view-product-fes"><?php _e( 'View', 'edd_fes' );?></a>
		<?php endif; ?>

		<?php if ( EDD_FES()->helper->get_option( 'fes-allow-vendors-to-edit-products', true ) && 'future' != get_post_status( $product_id ) ) : ?>
			<a href="<?php echo add_query_arg( array( 'task' => 'edit-product', 'post_id' => $product_id ), get_permalink() ); ?>" title="<?php _e( 'Edit', 'edd_fes' );?>" class="btn btn-mini edit-product-fes"><?php _e( 'Edit', 'edd_fes' );?></a>
		<?php endif; ?>

		<?php if ( EDD_FES()->helper->get_option( 'fes-allow-vendors-to-delete-products', true ) ) : ?>
			<a href="<?php echo add_query_arg( array( 'task' => 'delete-product', 'post_id' => $product_id ), get_permalink() );?>" title="<?php _e( 'Delete', 'edd_fes' );?>" class="btn btn-mini edit-product-fes"><?php _e( 'Delete', 'edd_fes' );?></a>
		<?php endif;
	}

	public function product_list_date( $product_id ) {
		$post = get_post( $product_id );
		$date = '';
		if ( '0000-00-00 00:00:00' == $post->post_date ) {
			$t_time = $h_time = __( 'Unpublished', 'edd_fes' );
			$time_diff = 0;
		} else {
			$t_time = get_the_time( __( 'Y/m/d g:i:s A', 'edd_fes' ) );
			$m_time = $post->post_date;
			$time = get_post_time( 'G', true, $post );

			$time_diff = time() - $time;

			if ( $time_diff > 0 && $time_diff < 24 * 60 * 60 ) {
				$h_time = sprintf( __( '%s ago', 'edd_fes' ), human_time_diff( $time ) );
			} else {
				$h_time = mysql2date( __( 'Y/m/d', 'edd_fes' ), $m_time );
			}
		}

		$date = '<abbr title="' . $t_time . '">' . apply_filters( 'fes_product_list_time', $h_time, $post, 'date', 'all' ) . '</abbr><br />';
		if ( 'publish' == $post->post_status ) {
			$date = $date . __( 'Published', 'edd_fes' );
		} elseif ( 'future' == $post->post_status ) {
			$date = $date . __( 'Scheduled', 'edd_fes' );
		} else {
			$date = $date . __( 'Last Modified', 'edd_fes' );
		}
		$date = apply_filters( 'fes_product_list_date', $date, $product_id );
		return $date;
	}

	public function product_list_status_bar() {
		$statuses = $this->get_product_list_statuses();
		if ( empty( $statuses ) || count( $statuses ) === 1 ) {return;}
		echo '<div class="fes-product-list-status-bar">';
		foreach ( $statuses as $status ) { ?>
        	<a href="<?php echo add_query_arg( array( 'status' => $status ) ); ?>" title="<?php echo $this->post_status_to_display( $status ); ?>" class="btn btn-mini edit-product-fes"><?php echo $this->post_status_to_display( $status ); ?></a>&nbsp|&nbsp;
       	<?php } ?>

       		<a href="<?php echo remove_query_arg( array( 'status' ) ); ?>" title="<?php _e( 'All', 'edd_fes' ); ?>" class="btn btn-mini edit-product-fes"><?php _e( 'All', 'edd_fes' ); ?></a>
       	<?php
		echo '</div>';
	}

	public function product_list_pagination() {
		$limit = 10;

		$statuses = array( 'pending', 'publish' );

		if ( isset( $_GET['status'] ) && in_array( $_GET['status'], $statuses ) ) {
			$status = $_GET['status'];
		}
		else {
			$status = 'all';
		}

		$order_count = EDD_FES()->vendors->get_all_products_count( get_current_user_id(), $status );
		$num_of_pages = ceil( $order_count / $limit );
		if ( $num_of_pages > 1 ) {
			echo '<div class="fes-product-list-pagination-container">';
			echo paginate_links( array(
					'current' => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1,
					'format' => '?paged=%#%',
					'total' => $num_of_pages,
					'base' => str_replace( 9999999 , '%#%', esc_url( get_pagenum_link( 9999999 ) ) ),
					'current' => max( 1, get_query_var( 'paged' ) ),
				) );
			echo '</div>';
		}
	}

	public function product_list_generate_status( $post = null, $css = false  ) {
		$post   = get_post( $post );
		$status = $post->post_status;
		if ( $css ) {
			if ( $status == 'publish' ) {
				$status = 'published';
			}
			elseif ( $status == 'expired' ) {
				$status = 'expired';
			}
			elseif ( $status == 'pending' ) {
				$status = 'pending-review';
			}
			elseif ( $status == 'draft' ) {
				$status = 'draft';
			}
			elseif ( $status == 'future' ) {
				$status = 'future';
			}
			else {
				$status = 'trash';
			}
			return apply_filters( 'fes_product_list_product_status_css', $status, $post );
		}
		if ( $status == 'publish' ) {
			$status = __( 'Live', 'edd_fes' );
		}
		elseif ( $status == 'draft' ) {
			$status = __( 'Draft', 'edd_fes' );
		}
		elseif ( $status == 'pending' ) {
			$status = __( 'Pending Review', 'edd_fes' );
		}
		elseif ( $status == 'future' ) {
			$status = __( 'Scheduled', 'edd_fes' );
		}
		else {
			$status = __( 'Trash', 'edd_fes' );
		}
		return apply_filters( 'fes_product_list_product_status', $status, $post );
	}

	public function get_product_list_statuses() {
		$user_id = get_current_user_id();
		$statuses = array();

		// Try draft
		$args = array(
			'author' => $user_id,
			'post_type' => 'download',
			'post_status' => 'draft',
			'fields'        => 'ids',
			'posts_per_page' => 1
		);
		$drafts = get_posts( $args );
		if ( count( $drafts ) > 0 ) {
			$statuses[] = 'draft';
		}

		// Try pending
		$args = array(
			'author' => $user_id,
			'post_type' => 'download',
			'post_status' => 'pending',
			'fields'        => 'ids',
			'posts_per_page' => 1
		);
		$pending = get_posts( $args );
		if ( count( $pending ) > 0 ) {
			$statuses[] = 'pending';
		}

		// Try published
		$args = array(
			'author' => $user_id,
			'post_type' => 'download',
			'post_status' => 'publish',
			'fields'        => 'ids',
			'posts_per_page' => 1
		);
		$published = get_posts( $args );
		if ( count( $published ) > 0 ) {
			$statuses[] = 'publish';
		}

		$statuses = apply_filters( 'fes_get_product_list_statuses', $statuses );
		return $statuses;
	}

	public function post_status_to_display( $status ) {

		if ( $status == 'publish' ) {
			$status = __( 'Live', 'edd_fes' );
		}
		elseif ( $status == 'draft' ) {
			$status = __( 'Draft', 'edd_fes' );
		}
		elseif ( $status == 'pending' ) {
			$status = __( 'Pending Review', 'edd_fes' );
		}
		elseif ( $status == 'future' ) {
			$status = __( 'Scheduled for Release', 'edd_fes' );
		}
		else {
			$status = __( 'Trash', 'edd_fes' );
		}
		return apply_filters( 'fes_product_list_product_status', $status );
	}

	public function order_status_to_display( $status ) {
		if ( $status == 'publish' || $status == '') {
			$status = __( 'Complete', 'edd_fes' );
		}
		elseif ( $status == 'draft' ) {
			$status = __( 'Draft', 'edd_fes' );
		}
		elseif ( $status == 'pending' ) {
			$status = __( 'Pending', 'edd_fes' );
		}
		else {
			$status = __( 'Trash', 'edd_fes' );
		}
		return apply_filters( 'fes_order_list_order_status', $status );
	}

	public function order_list_pagination() {
		$limit = 10;

		$order_count = EDD_FES()->vendors->get_all_orders_count( get_current_user_id(), array() );
		$num_of_pages = ceil( $order_count / $limit );
		if ( $num_of_pages > 1 ) {
			echo '<div class="fes-order-list-pagination-container">';
			echo paginate_links( array(
					'current' => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1,
					'format' => '?paged=%#%',
					'total' => $num_of_pages,
					'base' => str_replace( 9999999 , '%#%', esc_url( get_pagenum_link( 9999999 ) ) ),
					'current' => max( 1, get_query_var( 'paged' ) ),
				) );
			echo '</div>';
		}
	}

	public function order_list_actions( $order_id ) {
	?>
		<a href="<?php echo add_query_arg( array( 'task' => 'edit-order', 'order_id' => $order_id ), get_permalink() ); ?>" title="<?php _e( 'View', 'edd_fes' );?>" class="btn btn-mini view-order-fes"><?php _e( 'View', 'edd_fes' );?></a>
	<?php
	}

	public function order_list_status( $order_id ) {
		$order = get_post( $order_id );
		$status = '<span class="order-status">' . EDD_FES()->dashboard->order_status_to_display( $order->status ) . '</span>';
		$status = apply_filters( 'fes_order_list_status', $status, $order_id );
		return $status;
	}

	public function order_list_date( $order_id ) {
		$post = get_post( $order_id );
		$date = '';

		$t_time = get_the_time( __( 'Y/m/d g:i:s A', 'edd_fes' ) );
		$m_time = $post->post_date;
		$time = get_post_time( 'G', true, $post );

		$time_diff = time() - $time;

		if ( $time_diff > 0 && $time_diff < 24 * 60 * 60 ) {
			$h_time = sprintf( __( '%s ago', 'edd_fes' ), human_time_diff( $time ) );
		} else {
			$h_time = mysql2date( __( 'Y/m/d', 'edd_fes' ), $m_time );
		}
		return $h_time;
	}

	public function order_list_title( $product_id ) {
		$title = __( 'Order: #' ).$product_id;
		$title = apply_filters( 'fes_order_list_title', $title, $product_id );
		return $title;
	}

	public function order_list_total( $order_id ) {
		$total = edd_payment_amount( $order_id );
		$total = apply_filters( 'fes_order_list_total', $total, $order_id );
		return $total;

	}

	public function order_list_customer( $order_id ) {
		$customer = edd_get_payment_meta_user_info( $order_id );
		$customer_name = $customer['first_name']. ' '. $customer['last_name'];
		$customer_name = apply_filters( 'fes_order_list_customer', $customer_name, $customer );
		return $customer_name;
	}

	function comment_intercept(){

		if( ! isset( $_POST['fes_nonce'] ) || ! isset( $_POST['newcomment_body'] ) ) {
			return;
		}

		if ( !wp_verify_nonce($_POST['fes_nonce'], 'fes_comment_nonce') || $_POST['newcomment_body'] === '' ) {
			return;
		}

		$comment_id = absint( $_POST['cid'] );
		$author_id = absint( $_POST['aid'] );
		$post_id = absint( $_POST['pid'] );
		$content = wp_kses( $_POST['newcomment_body'], fes_allowed_html_tags() );

		$user = get_userdata( $author_id );

		update_comment_meta( $comment_id,'fes-already-processed', 'edd_fes' );

		$new_id = wp_insert_comment( array(
			'user_id' => $author_id,
			'comment_author_email' => $user->user_email,
			'comment_author' => $user->user_login,
			'comment_parent' => $comment_id,
			'comment_post_ID' => $post_id,
			'comment_content' => $content
		) );
		// This ensures author replies are not shown in the list
		update_comment_meta( $new_id, 'fes-already-processed', 'edd_fes' );
	}


	function mark_comment_as_read(){

		if ( ! isset( $_POST['fes_nonce'] ) || ! wp_verify_nonce( $_POST['fes_nonce'], 'fes_ignore_nonce' ) ) {
			return;
		}

		$comment_id = absint( $_POST['cid'] );
		update_comment_meta( $comment_id, 'fes-already-processed', 'edd_fes');
	}

	function render_comments_table( $limit ) {
		global $current_user, $wpdb;
		$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) :
		1;
		$offset = ( $pagenum - 1 ) * $limit;
		$args = array(
			'number' => $limit,
			'offset' => $offset,
			'post_author' => $current_user->ID,
			'post_type' => 'download',
			'status' => 'approve',
			'meta_query' => array(
				array(
					'key' => 'fes-already-processed',
					'compare' => 'NOT EXISTS'
				),
			)
		);
		$comments_query = new WP_Comment_Query;
		$comments = $comments_query->query( $args );

		if ( count( $comments ) == 0 ) {
			echo '<tr><td colspan="4">' . __( 'No Comments Found', 'edd_fes' ) . '</td></tr>';
		}
		foreach ($comments as $comment) {
			$this->render_comments_table_row( $comment );
		}

		$args = array('post_author'  => $current_user->ID,'post_type'    => 'download','status'       => 'approve','author__not_in' => array($current_user->ID),'meta_query'   => array(array('key' => 'fes-already-processed','compare' => 'NOT EXISTS',),));
		$comments_query = new WP_Comment_Query;
		$comments = $comments_query->query( $args );

		if ( count($comments) > 0){
			$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) :
			1;
			$num_of_pages = ceil( count($comments) / $limit );
			$page_links = paginate_links( array('base' => add_query_arg( 'pagenum', '%#%' ),'format' => '','prev_text' => __( '&laquo;', 'aag' ),'next_text' => __( '&raquo;', 'aag' ),'total' => $num_of_pages,'current' => $pagenum) );

			if ( $page_links ) {
				echo '<div class="fes-pagination">' . $page_links . '</div>';
			}
		}
	}

	function render_comments_table_row( $comment ) {
		$comment_date = get_comment_date( 'Y/m/d \a\t g:i a', $comment->comment_ID );
		$comment_author_img = EDD_FES()->vendors->get_avatar( 'comment_author_image', $comment->comment_author_email, 32 );
		$purchased = edd_has_user_purchased( $comment->user_id, $comment->comment_post_ID );
		?>
	<tr>
		<td class="col-author" style="width:25%;">
			<div class="fes-author-img"><?php echo $comment_author_img; ?></div>
			<span id="fes-comment-author"><?php echo $comment->comment_author; ?></span>
			<br /><br />
			<?php
			if ($purchased){
				echo '<div class="fes-light-green">'.__('Has Purchased','edd_fes').'</div>';
			} else {
				echo '<div class="fes-light-red">'.__('Has Not Purchased','edd_fes').'</div>';
			}

			?>
			<span id="fes-comment-date"><?php echo $comment_date; ?>&nbsp;&nbsp;&nbsp;</span><br />
			<span id="fes-product-name">
				<b><?php echo EDD_FES()->vendors->get_product_constant_name( $plural = false, $uppercase = true ) . ': '; ?></b>
				<a href="<?php echo esc_url( get_permalink( $comment->comment_post_ID ) ); ?>"><?php echo get_the_title( $comment->comment_post_ID ); ?></a>&nbsp;&nbsp;&nbsp;
			</span><br />
			<span id="fes-view-comment">
				<a href="<?php echo esc_url( get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment->comment_ID ); ?>"><?php _e( 'View Comment','edd_fes' ); ?></a>
			</span>
		</td>
		<td class="col-content" style="width:70%;">
			<div class="fes-comments-content"><?php echo $comment->comment_content; ?></div>
			<hr/>
			<div id="<?php echo $comment->comment_post_ID; ?>" class="fes-vendor-comment-respond-form">
				<span><?php _e( 'Respond:', 'edd_fes' ); ?></span><br/>
				<table>
					<tr>
						<form id="fes_comments-form" action="" method="post">
							<input type="hidden" name="cid" value="<?php echo $comment->comment_ID; ?>">
							<input type="hidden" name="pid" value="<?php echo $comment->comment_post_ID; ?>">
							<input type="hidden" name="aid" value="<?php echo get_current_user_id(); ?>">
							<?php wp_nonce_field('fes_comment_nonce', 'fes_nonce'); ?>
							<textarea class="fes-cmt-body" name="newcomment_body" cols="50" rows="8"></textarea>
							<button class="fes-cmt-submit-form button" type="submit"><?php  _e( 'Post Response', 'edd_fes' ); ?></button>
						</form>
						<form id="fes_ignore-form" action="" method="post">
							<input type="hidden" name="cid" value="<?php echo $comment->comment_ID; ?>">
							<?php wp_nonce_field('fes_ignore_nonce', 'fes_nonce'); ?>
							<button class="fes-ignore button" type="submit"><?php _e( 'Mark as Read', 'edd_fes' ); ?></button>
						</form>
					</tr>
				</table>
			</div>
		</td>
	</tr>
	<?php
	}

}