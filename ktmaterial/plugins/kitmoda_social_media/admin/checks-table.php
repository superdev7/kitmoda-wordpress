<?php


if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'magento-help/includes/class-wp-list-table.php' );
}

class Check_List_Table extends WP_List_Table {

	
    public function __construct() {
        parent::__construct( array(
            'singular' => 'Check',
            'plural'   => 'Checks',
            'ajax'     => true
        ));
    }


    public static function get_checks( $per_page = 5, $page_number = 1 ) {
        global $wpdb;
        $sql = "SELECT * FROM {$wpdb->prefix}ksm_payment_checks WHERE user_id = " . $_REQUEST['user_id'];

        if ( ! empty( $_REQUEST['orderby'] ) ) {
                $sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
                $sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
        }

        $sql .= " LIMIT $per_page";
        $sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;


        $result = $wpdb->get_results( $sql, 'ARRAY_A' );
        return $result;
    }


    public static function record_count() {
        global $wpdb;
        $sql = "SELECT * FROM {$wpdb->prefix}ksm_payment_checks WHERE user_id = " . $_REQUEST['user_id'];
        return $wpdb->get_var( $sql );
    }

    
    public static function delete_check( $id ) {
        global $wpdb;
        $wpdb->delete("{$wpdb->prefix}ksm_payment_checks", array('id' => $id),array('%d'));
    }


    public function no_items() {
        echo 'No Check found';
    }
    

    public function column_default( $item, $column_name ) {
        return $item[$column_name];
    }


    function column_cb( $item ) {
        return sprintf('<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['id']);
    }

    function column_year_month($item) {
        return $item['year'] . '-' . $item['month'];
    }

    function column_add_date($item) {
        if($item['add_date']) {
            return date('Y-m-d', $item['add_date']);
        }
    }

    function column_check_id( $item ) {
        $delete_nonce = wp_create_nonce( 'ksmdeletecheck' );
        $title = '<strong>' . $item['check_id'] . '</strong>';
        $actions = array(
            //'edit' => sprintf( '<a href="?page=%s&action=%s">Edit</a>', esc_attr( $_REQUEST['page'] ), 'edit', absint( $item['id'] ) ),
            'delete' => sprintf( '<a href="?page=%s&action=delete&view=artist&user_id=%s&check_id=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), absint( $item['user_id'] ) , absint( $item['id'] ), $delete_nonce )
        );
        return $title . $this->row_actions( $actions );
    }



    function get_columns() {

        $columns = array(
            'cb'                => '<input type="checkbox" />',
            'check_id'          => 'Check ID',
            'amount'            => 'Amount' ,
            'year_month'        => 'Year / Month' ,
            'check_date'        => 'Check Date' ,
            'add_date'          => 'Date' ,
            'remaining'         => 'Remaining'
            );

            return $columns;
    }


    public function get_sortable_columns() {
            $sortable_columns = array();
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

        $this->items = self::get_checks( $per_page, $current_page );
    }

    
    public function get_bulk_actions() {
        $actions = array('delete' => 'Delete');
        return $actions;
    }

    public function process_bulk_action() {

        if ( 'delete' === $this->current_action() ) {
            $nonce = esc_attr( $_REQUEST['_wpnonce'] );
            
            if ( ! wp_verify_nonce( $nonce, 'ksmdeletecheck' ) ) {
                die();
            }
            else {
                
                
                $url = '?page='.$_REQUEST['page'].'&view=artist&user_id='.$_REQUEST['user_id'];
                
                
                
                self::delete_check( absint( $_GET['check_id'] ) );
                
                
                wp_redirect( $url );
                
            }
        }

            
        if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' ) || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )) {
            $delete_ids = esc_sql( $_POST['bulk-delete'] );
            
            foreach ( $delete_ids as $id ) {
                self::delete_check( $id );
            }
            wp_redirect( esc_url( add_query_arg() ) );
            exit;
        }
    }
        
        

}