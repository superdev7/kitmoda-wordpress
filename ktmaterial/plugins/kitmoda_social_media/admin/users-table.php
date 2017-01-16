<?php


if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'magento-help/includes/class-wp-list-table.php' );
}

class Artists_List extends WP_List_Table {
    
    public function __construct() {
        parent::__construct( array(
            'singular' => 'Artist',
            'plural'   => 'Artists',
            'ajax'     => true
            ));
    }
        
    public static function get_artists( $per_page = 5, $page_number = 1 ) {

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
            $res['address'] = $user->address;
            $res['total_earning'] = $user->total_earning();
            $results[] = $res;
        }
        return $results;
    }

    public static function record_count() {
        global $wpdb;
        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}users";
        return $wpdb->get_var( $sql );
    }


    public function no_items() {
        echo 'No artist found.';
    }


    public function column_default( $item, $column_name ) {
        return $item[$column_name];
    }


    function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['ID']
        );
    }


    function column_user_login( $item ) {
        $title = '<strong>' . $item['user_login'] . '</strong>';
        $actions = array(
            'view' => sprintf( '<a href="?page=%s&view=artist&user_id=%s">View</a>', esc_attr( $_REQUEST['page'] ), absint( $item['ID'] ))
        );
        return $title . $this->row_actions( $actions );
    }


    function column_total_earning ($item) {
        return edd_currency_filter($item['total_earning']);
    }


    function get_columns() {

        $columns = array(
            'cb'                    => '<input type="checkbox" />',
            'user_login'            => 'Username' ,
            'name'                  => 'Full Name' ,
            'user_email'            => 'Email' ,
            'tax_info_recieved'     => 'Tax Info Recieved' ,
            'address'               => 'Address',
            'total_earning'         => 'Total Earning' ,
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

        $per_page     = $this->get_items_per_page( 'artists_per_page', 20 );
        $current_page = $this->get_pagenum();
        $total_items  = self::record_count();

        $this->set_pagination_args( array('total_items' => $total_items, 'per_page' => $per_page ) );

        $this->items = self::get_artists( $per_page, $current_page );
    }

        

}
?>