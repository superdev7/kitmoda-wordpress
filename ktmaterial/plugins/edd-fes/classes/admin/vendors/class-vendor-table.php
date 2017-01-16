<?php
class FES_Vendor_Table extends WP_List_Table {

    /**
     * Number of results to show per page
     *
     * @since       1.7
     * @var         int
     */
    public $per_page = 10;

    /**
     * Total number of vendors for current view
     *
     * @since       2.2.6
     * @var         int
     */
    public $total = 0;


    function __construct() {
        global $status, $page;
        //Set parent defaults
        parent::__construct( array(
            'singular'  => EDD_FES()->vendors->get_vendor_constant_name( $plural = false, $uppercase = false ),     //singular name of the listed records
            'plural'    => EDD_FES()->vendors->get_vendor_constant_name( $plural = true, $uppercase = false ),    //plural name of the listed records
            'ajax'      => false             //does this table support ajax?
        ) );
    }


    function column_default( $item, $column_name ) {
        switch ( $column_name ) {
        case 'name':
            return '<a href="'.admin_url( 'admin.php?page=fes-vendors&vendor='.$item->ID.'&action=edit' ).'">'.$item->first_name.' '.$item->last_name.' ('.$item->user_login.')</a>';
            break;
        case 'view':
            return $item->display_name;
            break;
        case 'actions':
            $admin_actions = array();
            if ( user_can( $item->ID, 'fes_is_admin' ) || user_can( $item->ID, 'frontend_vendor' ) ) {
                $admin_actions[ 'view' ]   = array(
                    'action' => 'view',
                    'name' => __( 'View', 'edd_fes' ),
                    'url' => admin_url( 'admin.php?page=fes-vendors&vendor='.$item->ID.'&action=edit' )
                );
                $admin_actions[ 'revoke' ] = array(
                    'action' => 'delete',
                    'name' => __( 'Revoke', 'edd_fes' ),
                    'url' => admin_url( 'admin.php?page=fes-vendors&vendor='.$item->ID.'&action=revoke_vendor' )
                );
                $admin_actions[ 'suspend' ] = array(
                    'action' => 'suspend',
                    'name' => __( 'Suspend', 'edd_fes' ),
                    'url' => admin_url( 'admin.php?page=fes-vendors&vendor='.$item->ID.'&action=suspend_vendor' )
                );
            }
            if ( user_can( $item->ID, 'pending_vendor' ) ) {
                $admin_actions[ 'view' ]   = array(
                    'action' => 'view',
                    'name' => __( 'View', 'edd_fes' ),
                    'url' => admin_url( 'admin.php?page=fes-vendors&vendor='.$item->ID.'&action=edit' )
                );
                $admin_actions[ 'approve' ] = array(
                    'action' => 'approve',
                    'name' => __( 'Approve', 'edd_fes' ),
                    'url' => admin_url( 'admin.php?page=fes-vendors&vendor='.$item->ID.'&action=approve_vendor' )
                );
                $admin_actions[ 'decline' ] = array(
                    'action' => 'delete',
                    'name' => __( 'Decline', 'edd_fes' ),
                    'url' => admin_url( 'admin.php?page=fes-vendors&vendor='.$item->ID.'&action=decline_vendor' )
                );
            }
            if ( user_can( $item->ID, 'suspended_vendor' ) ) {
                $admin_actions[ 'view' ]   = array(
                    'action' => 'view',
                    'name' => __( 'View', 'edd_fes' ),
                    'url' => admin_url( 'admin.php?page=fes-vendors&vendor='.$item->ID.'&action=edit' )
                );
                $admin_actions[ 'revoke' ] = array(
                    'action' => 'delete',
                    'name' => __( 'Revoke', 'edd_fes' ),
                    'url' => admin_url( 'admin.php?page=fes-vendors&vendor='.$item->ID.'&action=revoke_vendor' )
                );
                $admin_actions[ 'unsuspend' ] = array(
                    'action' => 'unsuspend',
                    'name' => __( 'Unsuspend', 'edd_fes' ),
                    'url' => admin_url( 'admin.php?page=fes-vendors&vendor='.$item->ID.'&action=unsuspend_vendor' )
                );
            }
            $admin_actions = apply_filters( 'fes_admin_actions', $admin_actions, $item );
            foreach ( $admin_actions as $action ) {
                $image = isset( $action[ 'image_url' ] ) ? $action[ 'image_url' ] : fes_plugin_url . 'assets/img/icons/' . $action[ 'action' ] . '.png';
                printf( '<a class="button tips" href="%s" data-tip="%s"><img src="%s" alt="%s" width="14" /></a>', esc_url( $action[ 'url' ] ), esc_attr( $action[ 'name' ] ), esc_attr( $image ), esc_attr( $action[ 'name' ] ) );
            }
            break;
            break;
        case 'products':
            $count = EDD_FES()->vendors->get_all_products($item->ID);
            return !empty($count) ? count($count) : '0';
            break;
        case 'status':
            if ( user_can( $item, 'fes_is_admin' ) ) {
                echo '<span class="download-status all">' . __( 'All', 'edd_fes' ) . '</span>';
            }
            else if ( user_can( $item, 'pending_vendor' ) ) {
                echo '<span class="download-status pending-review">' . __( 'Pending', 'edd_fes' ) . '</span>';
            }
            else if ( user_can( $item, 'fes_is_admin' ) || user_can( $item, 'frontend_vendor' ) ) {
                echo '<span class="download-status published">' . __( 'Approved', 'edd_fes' ) . '</span>';
            }
            else if ( user_can( $item, 'suspended_vendor' ) ) {
                echo '<span class="download-status future">' . __( 'Suspended', 'edd_fes' ) . '</span>';
            }
            else {
                return 'ERROR: WP_Query is misbehaving!';
            }
            break;
        case 'date':
            return date_i18n( get_option( 'date_format' ), strtotime( $item->user_registered ) );
            break;
        case 'sales':
            global $wpdb;
            global $current_user;
            $vendor_products = array();

            $vendor_products = get_posts( array(
                    'nopaging' => true,
                    'orderby' => 'title',
                    'post_type' => 'download',
                    'post_status'  => 'publish',
                    'author' => $item->ID,
                    'order' => 'ASC'
                ) );

            if ( empty( $vendor_products ) ){
                return edd_currency_filter( edd_format_amount( 0 ) );
            }

            $sales = 0;
            foreach ( $vendor_products as $product ) {
                $sales = $sales + edd_get_download_earnings_stats( $product->ID );
            }
            return edd_currency_filter( edd_format_amount( $sales ) );
            break;
        default:
            return print_r( $item, true ); //Show the whole array for troubleshooting purposes
            break;
        }
    }

    function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],
            /*$2%s*/ $item->ID
        );
    }


    function get_columns() {
        $columns = array(
            'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
            'name'     => __( 'Name', 'edd_fes' ),
            'actions'     => __( 'Actions', 'edd_fes' ),
            'status'   => __( 'Status', 'edd_fes' ),
            'products'   => sprintf( __( 'Number of %s', 'edd_fes' ), EDD_FES()->vendors->get_product_constant_name( $plural = true, $uppercase = true ) ),
            'sales'   => __( 'Sales', 'edd_fes' ),
            'date'      => sprintf( __( '%s Since', 'edd_fes' ), EDD_FES()->vendors->get_vendor_constant_name( $plural = false, $uppercase = true ) ),
        );
        return $columns;
    }

    function get_views() {
        $base = admin_url( 'admin.php?page=fes-vendors' );
        $current = isset( $_GET['view'] ) ? sanitize_text_field( $_GET['view'] ) : 'all';
        $views = array(
            'all'       => sprintf( '<a href="%s"%s>%s <span class="count">(%s)</span></a>', add_query_arg( 'view', 'all', $base ), $current === 'all' ? ' class="current"' : '', __( 'All', 'edd_fes' ), $this->get_count(array('frontend_vendor', 'suspended_vendor', 'pending_vendor')) ),
            'pending'   => sprintf( '<a href="%s"%s>%s <span class="count">(%s)</span></a>', add_query_arg( 'view', 'pending', $base ), $current === 'pending' ? ' class="current"' : '', __( 'Pending', 'edd_fes' ), $this->get_count(array('pending_vendor')) ),
            'approved'  => sprintf( '<a href="%s"%s>%s <span class="count">(%s)</span></a>', add_query_arg( 'view', 'approved', $base ), $current === 'approved' ? ' class="current"' : '', __( 'Approved', 'edd_fes'), $this->get_count(array('frontend_vendor')) ),
            'suspended' => sprintf( '<a href="%s"%s>%s <span class="count">(%s)</span></a>', add_query_arg( 'view', 'suspended', $base ), $current === 'suspended' ? ' class="current"' : '', __( 'Suspended', 'edd_fes'), $this->get_count(array('suspended_vendor')) )
        );
        return $views;
    }


    function get_bulk_actions() {
        $actions = array(
            'approve_vendor'      => sprintf( __( 'Approve %s' , 'edd_fes' ), EDD_FES()->vendors->get_vendor_constant_name( $plural = true, $uppercase = true ) ),
            'decline_vendor'    => sprintf( __( 'Decline %s' , 'edd_fes' ), EDD_FES()->vendors->get_vendor_constant_name( $plural = true, $uppercase = true ) ),
            'revoke_vendor'=>  sprintf( __( 'Revoke %s' , 'edd_fes' ), EDD_FES()->vendors->get_vendor_constant_name( $plural = true, $uppercase = true ) ),
            'suspend_vendor'=>  sprintf( __( 'Suspend %s' , 'edd_fes' ), EDD_FES()->vendors->get_vendor_constant_name( $plural = true, $uppercase = true ) ),
            'unsuspend_vendor'=>  sprintf( __( 'Unsuspend %s' , 'edd_fes' ), EDD_FES()->vendors->get_vendor_constant_name( $plural = true, $uppercase = true ) ),
        );
        return $actions;
    }


    /**
     * Retrieve the current page number
     *
     * @access      private
     * @since       1.7
     * @return      int
     */
    function get_paged() {
        return isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1;
    }

    /**
     * Retrieve the offset based on the current page number
     *
     * @access      private
     * @since       2.2.6
     * @return      int
     */
    function get_offset() {
        $page = $this->get_paged();
        return $this->per_page * ( $page - 1 );
    }

    function applications_data() {
        global $wpdb;
        $blog_id = get_current_blog_id();

        $view = isset( $_GET['view'] ) ? $_GET['view'] : 'all';

        switch( $view ) {

            case 'approved' :
                $roles = array('frontend_vendor');
                break;

            case 'suspended' :
                $roles = array('suspended_vendor');
                break;

            case 'pending' :
                $roles = array('pending_vendor');
                break;

            case 'all':
            default:
                $roles = array('frontend_vendor', 'suspended_vendor', 'pending_vendor');
                break;
        }

        $users_args = array(
            'meta_query' => array(
                'relation' => 'OR',
            ),
            'number' => $this->per_page,
            'offset' => $this->get_offset()
        );

        foreach ($roles as $role) {
            $users_args['meta_query'][] = array(
                'key' => $wpdb->get_blog_prefix( $blog_id ) . 'capabilities',
                'value' => $role,
                'compare' => 'like'
            );
        }

        $this->total = $this->get_count( $roles );

        $users = new WP_User_Query( $users_args );
        return $users->results;
    }

    function get_count( $roles ) {
        global $wpdb;
        $blog_id = get_current_blog_id();

        $count_args = array(
            'meta_query' => array(
                'relation' => 'OR',
            ),
            'number' => 999999999
        );

        foreach ($roles as $role) {
            $count_args['meta_query'][] = array(
                'key' => $wpdb->get_blog_prefix( $blog_id ) . 'capabilities',
                'value' => $role,
                'compare' => 'like'
            );
        }

        $count = new WP_User_Query( $count_args );
        return $count->get_total();
    }

    // In 2.3 we'll make all the columns sortable and add search capabilities
    function get_sortable_columns() {
        $sortable_columns = array(
            //'name'     => array( 'name', false ),     // true means it's already sorted
            //'status'    => array( 'status', false ),
            //        'products'  => array('products',false),
            //        'sales'  => array('sales',false),
            //'date'  => array( 'date', false ),
        );
        return $sortable_columns;
    }

    /**
     *
     *
     * @uses $this->_column_headers
     * @uses $this->items
     * @uses $this->get_columns()
     * @uses $this->get_sortable_columns()
     * @uses $this->get_pagenum()
     * @uses $this->set_pagination_args()
     * */
    function prepare_items() {

        $columns = $this->get_columns();
        $hidden = array(); // no hidden columns

        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array( $columns, $hidden, $sortable );

        $current_page = $this->get_pagenum();

        $this->items = $this->applications_data();
        $this->set_pagination_args( array(
            'total_items' => $this->total,
            'per_page'    => $this->per_page,
            'total_pages' => ceil( $this->total / $this->per_page )
        ) );
    }
}