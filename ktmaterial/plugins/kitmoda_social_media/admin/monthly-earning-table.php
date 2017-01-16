<?php


if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'magento-help/includes/class-wp-list-table.php' );
}

class Artists_List extends WP_List_Table {

	
	public function __construct() {
		parent::__construct( [
			'singular' => __( 'Customer', 'sp' ), //singular name of the listed records
			'plural'   => __( 'Customers', 'sp' ), //plural name of the listed records
			'ajax'     => true //does this table support ajax?
		] );

	}


	public static function get_customers( $per_page = 5, $page_number = 1 ) {

		global $wpdb;

		$sql = "SELECT * FROM {$wpdb->prefix}users";

		if ( ! empty( $_REQUEST['orderby'] ) ) {
			$sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
			$sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
		}

		$sql .= " LIMIT $per_page";
		$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;


		$result = $wpdb->get_results( $sql, 'ARRAY_A' );
                $results = array();
                
                foreach($result as $res) {
                    
                    $user = new KSM_User($res['ID']);
                    $res['name'] = $user->real_full_name();
                    $res['tax_info_recieved'] = $user->tax_info_recieved() ? 'YES' : 'NO';
                    $results[] = $res;
                }
                
		return $results;
	}


	/*
	public static function delete_customer( $id ) {
		global $wpdb;

		$wpdb->delete(
			"{$wpdb->prefix}customers",
			[ 'ID' => $id ],
			[ '%d' ]
		);
	}
        */


	public static function record_count() {
		global $wpdb;

		$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}users";

		return $wpdb->get_var( $sql );
	}


	
	public function no_items() {
            _e( 'No customers avaliable.', 'sp' );
	}


	public function column_default( $item, $column_name ) {
                    return $item[$column_name];

		switch ( $column_name ) {
			case 'address':
			case 'city':
				return $item[ $column_name ];
			default:
				return print_r( $item, true ); //Show the whole array for troubleshooting purposes
		}
	}

	
	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['ID']
		);
	}


	
	function column_name( $item ) {

		$delete_nonce = wp_create_nonce( 'sp_delete_customer' );

		$title = '<strong>' . $item['name'] . '</strong>';

		$actions = array(
                    'view' => sprintf( '<a href="?page=%s&action=%s&customer=%s&_wpnonce=%s">View</a>', esc_attr( $_REQUEST['page'] ), 'view', absint( $item['ID'] ), $delete_nonce ),
                    'delete' => sprintf( '<a href="?page=%s&action=delete&artist_id=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), absint( $item['ID'] ), $delete_nonce )
                );

		return $title . $this->row_actions( $actions );
	}
        
        
        function column_user_login($item) {
            return '<em>' . $item['user_login'] . '</em>';
        }

	
	function get_columns() {
            
            $columns = array(
                'cb'                    => '<input type="checkbox" />',
                'name'                  => 'Full Name' ,
                //''                    => 'Month / Year' ,
                'user_login'            => 'Username' ,
                'user_email'            => 'Email' ,
                
                'tax_info_recieved'     => 'Tax Info Recieved' ,
                'address'               => 'Address',
                //''                    => 'Monthly Earning Total' ,
                //''                    => 'Yearly Earning' ,
                'total_earning'         => 'Total Earning' ,
                //''                    => 'Check Payment Amount' ,
                //''                    => 'Check ID' ,
                //''                    => 'Money Owed Remaining'
                );
            
		return $columns;
	}


	public function get_sortable_columns() {
		$sortable_columns = array(
			'user_login' => array( 'name', true ),
			'user_email' => array( 'city', false )
		);

		return $sortable_columns;
	}
        
        
        
	public function prepare_items() {
            
            $columns = $this->get_columns();
            $hidden = array();
            $sortable = $this->get_sortable_columns();
            $this->_column_headers = array($columns, $hidden, $sortable);

            $this->process_bulk_action();

            $per_page     = $this->get_items_per_page( 'customers_per_page', 5 );
            $current_page = $this->get_pagenum();
            $total_items  = self::record_count();

            $this->set_pagination_args( array('total_items' => $total_items, 'per_page'    => $per_page ) );

            $this->items = self::get_customers( $per_page, $current_page );
	}

        /*
        public function get_bulk_actions() {
		$actions = array('bulk-delete' => 'Delete');
		return $actions;
	}
        
	public function process_bulk_action() {

		//Detect when a bulk action is being triggered...
		if ( 'delete' === $this->current_action() ) {

			// In our file that handles the request, verify the nonce.
			$nonce = esc_attr( $_REQUEST['_wpnonce'] );

			if ( ! wp_verify_nonce( $nonce, 'sp_delete_customer' ) ) {
				die( 'Go get a life script kiddies' );
			}
			else {
				self::delete_customer( absint( $_GET['customer'] ) );

				wp_redirect( esc_url( add_query_arg() ) );
				exit;
			}

		}

		// If the delete bulk action is triggered
		if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
		     || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
		) {

			$delete_ids = esc_sql( $_POST['bulk-delete'] );

			// loop over the array of record IDs and delete them
			foreach ( $delete_ids as $id ) {
				self::delete_customer( $id );

			}

			wp_redirect( esc_url( add_query_arg() ) );
			exit;
		}
	}
        
        */

}