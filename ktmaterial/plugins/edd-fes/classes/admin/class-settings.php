<?php
if ( !class_exists( "FES_Settings" ) ) {

    class FES_Settings {

        public $args = array();
        public $sections = array();
        public $ReduxFramework;

        public function __construct() {

            if ( !class_exists( "ReduxFramework" ) ) {
                require_once( dirname( __FILE__ ) . '/redux/ReduxCore/framework.php' );
            }

            // This is needed. Bah WordPress bugs.  ;)
            //if ( defined( 'TEMPLATEPATH' ) && strpos( Redux_Helpers::cleanFilePath( __FILE__ ), Redux_Helpers::cleanFilePath( TEMPLATEPATH ) ) !== false ) {
                $this->initSettings();
            //} else {
                //add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
            //}
        }

        public function initSettings() {
            // Set the default arguments
            $this->setArguments();

            // Create the sections and fields
            $this->setSections();

            if ( !isset( $this->args['opt_name'] ) ) { // No errors please
                return;
            }

            $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
        }


        public function setSections() {
            $this->sections[] = array(
                'title' => __( 'Main Settings', 'edd_fes' ),
                'desc' => __( 'Easy Digital Downloads Frontend Submissions is a constantly improving piece of complex software. For the latest information, update information, and submitting feature requests, visit: <a href="https://easydigitaldownloads.com/support/forum/add-on-plugins/frontend-submissions//">https://easydigitaldownloads.com/support/forum/add-on-plugins/frontend-submissions//</a>', 'edd_fes' ),
                'icon' => 'el-icon-home',
                'fields' => array(
                    array(
                        'id'=> 'fes-use-css',
                        'type' => 'switch',
                        'title' => __( 'Use FES\'s CSS', 'edd_fes' ),
                        'default'   => true,
                    ),
                    // for reintroduction in 2.3
                    //array(
                    //    'id'=> 'fes-show-custom-meta',
                    //    'type' => 'switch',
                    //    'title' => __( 'Show custom fields on the post? (disabled in 2.1)', 'edd_fes' ),
                    //    'default'   => 0,
                   // ),
                    array(
                        'id'=>'fes-dashboard-notification',
                        'type' => 'textarea',
                        'title' => __( 'Vendor Announcement', 'edd_fes' ),
                        'subtitle' => __( 'Use this to announce things to your vendors. Appears on the Vendor Dashboard Page once logged in.', 'edd_fes' ),
                        'validate' => 'html',
                        'default' => __( 'This is the vendor dashboard. Add welcome text or any other information that is applicable to your vendors.', 'edd_fes' )
                    ),
                    array(
                        'id' => 'fes-plugin-constants',
                        'type' => 'text',
                        'title' => __( 'Rename FES Constants', 'edd_fes' ),
                        'subtitle' => __( 'We ask for all posible combinations of singular/plural and upper/lower case forms since in some languages, different words are used depending on these combinations.', 'edd_fes' ),
                        'desc' => __( 'Note this is CASE SENSITIVE', 'edd_fes' ),
                        'options' => array( 1=>'Vendors', 2=>'Vendor', 3 => 'vendors', 4=> 'vendor', 5=>'Products', 6=>'Product', 7=>'products', 8=>'product' ),
                        'default' => array( 1=>'Vendors', 2=>'Vendor', 3 => 'vendors', 4=> 'vendor', 5=>'Products', 6=>'Product', 7=>'products', 8=>'product' ),
                    ),
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-cogs',
                'title' => __( 'Pages', 'edd_fes' ),
                'desc' => __( '<p class="description">Settings for Pages</p>', 'edd_fes' ),
                'fields' => array(
                    array(
                        'id' => 'fes-vendor-dashboard-page',
                        'type' => 'select',
                        'data' => 'pages',
                        'title' => __( 'Vendor Dashboard Page', 'edd_fes' ),
                    ),
                    array(
                        'id' => 'fes-vendor-page',
                        'type' => 'select',
                        'data' => 'pages',
                        'title' => __( 'Vendor Page', 'edd_fes' ),
                    )
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-check',
                'title' => __( 'Permissions', 'edd_fes' ),
                'desc' => __( '<p class="description">Settings for FES Permissions</p>', 'edd_fes' ),
                'fields' => array(
                    array(
                        'id'=> 'fes-allow-registrations',
                        'type' => 'switch',
                        'title' => __( 'Registration', 'edd_fes' ),
                        'subtitle'=> __( 'Allow guests to apply to become a vendor', 'edd_fes' ),
                        'default'       => true,
                    ),
                    array(
                        'id'=> 'fes-allow-applications',
                        'type' => 'switch',
                        'title' => __( 'Applications', 'edd_fes' ),
                        'subtitle'=> __( 'Allow existing WordPress users to apply to become a vendor', 'edd_fes' ),
                        'default'       => true,
                    ),
                    array(
                        'id'=> 'fes-allow-backend-access',
                        'type' => 'switch',
                        'title' => __( 'Allow WP Backend Access to Vendors?', 'edd_fes' ),
                        'subtitle'=> __( 'Does not remove the admin bar. Simply prevents vendors from accessing the backend.', 'edd_fes' ),
                        'default'       => false,
                    ),
                    array(
                        'id'=> 'fes-remove-admin-bar',
                        'type' => 'switch',
                        'title' => __( 'Allow Vendors to See the Admin Bar?', 'edd_fes' ),
                        'subtitle'=> __( 'This only removes the bar for users with the frontend_vendor cap but not the fes_is_admin cap', 'edd_fes' ),
                        'default'       => false,
                    ),
                    array(
                        'id'=> 'fes-auto-approve-vendors',
                        'type' => 'switch',
                        'title' => __( 'Automatically Approve Vendors?', 'edd_fes' ),
                        'subtitle'=> __( 'If off, vendors will not be able to submit products until you manually approve them', 'edd_fes' ),
                        'default'       => true,
                    ),
                    array(
                        'id'=> 'fes-auto-approve-submissions',
                        'type' => 'switch',
                        'title' => __( 'Automatically Approve Submissions?', 'edd_fes' ),
                        'subtitle'=> __( 'If off, vendor products will be saved as a pending download until you manually approve them', 'edd_fes' ),
                        'default'       => false,
                    ),
                    array(
                        'id'=> 'fes-auto-approve-edits',
                        'type' => 'switch',
                        'title' => __( 'Automatically Approve Vendor Edits?', 'edd_fes' ),
                        'subtitle'=> __( 'If off, vendor products will be changed to pending status (removed from store) until manually approved', 'edd_fes' ),
                        'default'       => true,
                    ),
                    /*array(
                        'id'=> 'fes_allow_vendors_to_create_coupons',
                        'type' => 'switch',
                        'title' => __( 'Allow Vendors to Create Coupons?', 'edd_fes' ),
                        'subtitle'=> __( 'If on, vendors will be able to create simple flat rate or % coupons for their items (discount on their products, not the whole cart)', 'edd_fes' ),
                        'default'       => 0,
                    ),*/
                    array(
                        'id'=> 'fes-allow-vendors-to-edit-products',
                        'type' => 'switch',
                        'title' => __( 'Allow Vendors to Edit Products?', 'edd_fes' ),
                        'subtitle'=> __( 'If on, vendors will be able to edit their products', 'edd_fes' ),
                        'default'       => true,
                    ),
                    array(
                        'id'=> 'fes-allow-vendors-to-delete-products',
                        'type' => 'switch',
                        'title' => __( 'Allow Vendors to Delete Products?', 'edd_fes' ),
                        'subtitle'=> __( 'If on, vendors will be able to delete their products', 'edd_fes' ),
                        'default'       => true,
                    ),
                    array(
                        'id'=> 'fes-allow-vendors-to-create-products',
                        'type' => 'switch',
                        'title' => __( 'Allow Vendors to Create Products?', 'edd_fes' ),
                        'subtitle'=> __( 'If on, vendors will be able to create products', 'edd_fes' ),
                        'default'       => true,
                    ),
                    /*array(
                        'id'=> 'fes-allow-vendors-to-draft-products',
                        'type' => 'switch',
                        'title' => __( 'Allow Vendors to draft Products?', 'edd_fes' ),
                        'subtitle'=> __( 'If on, vendors will be able to create simple flat rate or % coupons for their items (discount on their products, not the whole cart)', 'edd_fes' ),
                        'default'       => 1,
                    )*/
                    array(
                        'id'=> 'fes-allow-vendors-to-view-orders',
                        'type' => 'switch',
                        'title' => __( 'Allow Vendors to View Orders?', 'edd_fes' ),
                        'subtitle'=> __( 'If on, vendors will be able to view orders', 'edd_fes' ),
                        'default'       => true,
                    ),
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-website',
                'title' => __( 'Emails', 'edd_fes' ),
                'desc' => __( '<p class="description">Settings for FES Emails</p>', 'edd_fes' ),
                'fields' => array(
                    array(
                        'id'   =>'fes-admin-email-divider',
                        'desc' => '<h2>'.__( 'Admin Email Settings', 'edd_fes' ).'</h2>',
                        'type' => 'divide',
                        'class' => 'wp-menu-arrow' // man Redux makes it hard to hide that styled <hr>
                    ),
                    array(
                        'id'=> 'fes-admin-new-app-email-toggle',
                        'type' => 'switch',
                        'title' => __( 'Send Admin Email on New Application', 'edd_fes' ),
                        'default'       => 1,
                        //'required' =>  array( 'fes-auto-approve-applications', 'equals', array( '0' ) ),
                    ),
                    array(
                        'id' => 'fes-admin-new-app-email',
                        'type' => 'textarea',
                        'title' => __( 'Admin New Vendor Application Email', 'edd_fes' ),
                        'subtitle' => __( 'For a list of shortcodes you can use, see ', 'edd_fes' ).'<a href="https://easydigitaldownloads.com/docs/frontend-submissions-email-configuration/">'.__('the KB','edd_fes').'</a>',
                        'validate' => 'html',
                        'required' =>  array( 'fes-admin-new-app-email-toggle', 'equals', array( '1' ) ),
                        'default' => '',
                    ),
                    array(
                        'id'=> 'fes-admin-new-submission-email-toggle',
                        'type' => 'switch',
                        'title' => __( 'Send Admin Email on New Submission?', 'edd_fes' ),
                        'default'       => 1,
                    ),
                    array(
                        'id' => 'fes-admin-new-submission-email',
                        'type' => 'textarea',
                        'title' => __( 'Admin New Submission Email', 'edd_fes' ),
                        'subtitle' => __( 'For a list of shortcodes you can use, see ', 'edd_fes' ).'<a href="https://easydigitaldownloads.com/docs/frontend-submissions-email-configuration/">'.__('the KB','edd_fes').'</a>',
                        'validate' => 'html',
                        'required' =>  array( 'fes-admin-new-submission-email-toggle', 'equals', array( '1' ) ),
                        'default' => '',
                    ),
                    array(
                        'id'=> 'fes-admin-new-submission-edit-email-toggle',
                        'type' => 'switch',
                        'title' => __( 'Send Admin Email on New Edit?', 'edd_fes' ),
                        'default'       => 1,
                    ),
                    array(
                        'id' => 'fes-admin-new-submission-edit-email',
                        'type' => 'textarea',
                        'title' => __( 'Admin Submission Edit Email', 'edd_fes' ),
                        'subtitle' => __( 'For a list of shortcodes you can use, see ', 'edd_fes' ).'<a href="https://easydigitaldownloads.com/docs/frontend-submissions-email-configuration/">'.__('the KB','edd_fes').'</a>',
                        'validate' => 'html',
                        'required' =>  array( 'fes-admin-new-submission-edit-email-toggle', 'equals', array( '1' ) ),
                        'default' => '',
                    ),
                    array(
                        'id'   =>'fes-vendor-email-divider',
                        'desc' => '<h2>'.__( 'Vendor Email Settings', 'edd_fes' ).'</h2>',
                        'type' => 'divide',
                        'class' => 'wp-menu-arrow' // man Redux makes it hard to hide that styled <hr>
                    ),
                    array(
                        'id'=> 'fes-vendor-new-app-email-toggle',
                        'type' => 'switch',
                        'title' => __( 'Send Vendors Confirmation Email On Applying', 'edd_fes' ),
                        'default'       => 1,
                        //     'required' =>  array( 'fes-auto-approve-submissions', 'equals', array( '0' ) ),
                    ),
                    array(
                        'id' => 'fes-vendor-new-app-email',
                        'type' => 'textarea',
                        'title' => __( 'Vendor Application Confirmation Email', 'edd_fes' ),
                        'subtitle' => __( 'For a list of shortcodes you can use, see ', 'edd_fes' ).'<a href="https://easydigitaldownloads.com/docs/frontend-submissions-email-configuration/">'.__('the KB','edd_fes').'</a>',
                        'validate' => 'html',
                        'required' =>  array( 'fes-vendor-new-app-email-toggle', 'equals', array( '1' ) ),
                        'default' => '',
                    ),
                    array(
                        'id'=> 'fes-vendor-app-approved-email-toggle',
                        'type' => 'switch',
                        'title' => __( 'Send Vendor Email on Approved Application', 'edd_fes' ),
                        'default'       => 1,
                        //    'required' =>  array( 'fes-auto-approve-submissions', 'equals', array( '0' ) ),
                    ),
                    array(
                        'id' => 'fes-vendor-app-approved-email',
                        'type' => 'textarea',
                        'title' => __( 'Vendor Application Approved Email', 'edd_fes' ),
                        'subtitle' => __( 'For a list of shortcodes you can use, see ', 'edd_fes' ).'<a href="https://easydigitaldownloads.com/docs/frontend-submissions-email-configuration/">'.__('the KB','edd_fes').'</a>',
                        'validate' => 'html',
                        'required' =>  array( 'fes-vendor-app-approved-email-toggle', 'equals', array( '1' ) ),
                        'default' => '',
                    ),
                    array(
                        'id'=> 'fes-vendor-app-declined-email-toggle',
                        'type' => 'switch',
                        'title' => __( 'Send Vendor Email on Declined Application', 'edd_fes' ),
                        'default'       => 1,
                        //     'required' =>  array( 'fes-auto-approve-submissions', 'equals', array( '0' ) ),
                    ),
                    array(
                        'id' => 'fes-vendor-app-declined-email',
                        'type' => 'textarea',
                        'title' => __( 'Vendor Application Declined Email', 'edd_fes' ),
                        'subtitle' => __( 'For a list of shortcodes you can use, see ', 'edd_fes' ).'<a href="https://easydigitaldownloads.com/docs/frontend-submissions-email-configuration/">'.__('the KB','edd_fes').'</a>',
                        'validate' => 'html',
                        'required' =>  array( 'fes-vendor-app-declined-email-toggle', 'equals', array( '1' ) ),
                        'default' => '',
                    ),
                    array(
                        'id'=> 'fes-vendor-new-auto-vendor-email-toggle',
                        'type' => 'switch',
                        'title' => __( 'Send Vendor Email Upon Being Auto-Approved?', 'edd_fes' ),
                        'default'       => 1,
                        //    'required' =>  array( 'fes-auto-approve-submissions', 'equals', array( '1' ) ),
                    ),
                    array(
                        'id' => 'fes-vendor-new-auto-vendor-email',
                        'type' => 'textarea',
                        'title' => __( 'Email to Auto-Approved Vendor', 'edd_fes' ),
                        'subtitle' => __( 'For a list of shortcodes you can use, see ', 'edd_fes' ).'<a href="https://easydigitaldownloads.com/docs/frontend-submissions-email-configuration/">'.__('the KB','edd_fes').'</a>',
                        'validate' => 'html',
                        'required' =>  array( 'fes-vendor-new-auto-vendor-email-toggle', 'equals', array( '1' ) ),
                        'default' => '',
                    ),
                    array(
                        'id'=> 'fes-vendor-app-revoked-email-toggle',
                        'type' => 'switch',
                        'title' => __( 'Send Vendor Email on Revoked Application', 'edd_fes' ),
                        'default'       => 1,
                    ),
                    array(
                        'id' => 'fes-vendor-app-revoked-email',
                        'type' => 'textarea',
                        'title' => __( 'Vendor Application Revoked Email', 'edd_fes' ),
                        'subtitle' => __( 'For a list of shortcodes you can use, see ', 'edd_fes' ).'<a href="https://easydigitaldownloads.com/docs/frontend-submissions-email-configuration/">'.__('the KB','edd_fes').'</a>',
                        'validate' => 'html',
                        'required' =>  array( 'fes-vendor-app-revoked-email-toggle', 'equals', array( '1' ) ),
                        'default' => '',
                    ),
                    array(
                        'id'=> 'fes-vendor-suspended-email-toggle',
                        'type' => 'switch',
                        'title' => __( 'Send Vendor Email on Suspension', 'edd_fes' ),
                        'default'       => 1,
                    ),
                    array(
                        'id' => 'fes-vendor-suspended-email',
                        'type' => 'textarea',
                        'title' => __( 'Vendor Suspended Email', 'edd_fes' ),
                        'subtitle' => __( 'For a list of shortcodes you can use, see ', 'edd_fes' ).'<a href="https://easydigitaldownloads.com/docs/frontend-submissions-email-configuration/">'.__('the KB','edd_fes').'</a>',
                        'validate' => 'html',
                        'required' =>  array( 'fes-vendor-suspended-email-toggle', 'equals', array( '1' ) ),
                        'default' => '',
                    ),
                    array(
                        'id'=> 'fes-vendor-unsuspended-email-toggle',
                        'type' => 'switch',
                        'title' => __( 'Send Vendor Email on Unsuspension', 'edd_fes' ),
                        'default'       => 1,
                    ),
                    array(
                        'id' => 'fes-vendor-unsuspended-email',
                        'type' => 'textarea',
                        'title' => __( 'Vendor Unsuspended Email', 'edd_fes' ),
                        'subtitle' => __( 'For a list of shortcodes you can use, see ', 'edd_fes' ).'<a href="https://easydigitaldownloads.com/docs/frontend-submissions-email-configuration/">'.__('the KB','edd_fes').'</a>',
                        'validate' => 'html',
                        'required' =>  array( 'fes-vendor-unsuspended-email-toggle', 'equals', array( '1' ) ),
                        'default' => '',
                    ),
                    array(
                        'id'=> 'fes-vendor-new-submission-email-toggle',
                        'type' => 'switch',
                        'title' => __( 'Vendor Email Upon Creating Submission?', 'edd_fes' ),
                        'default'       => 1,
                    ),
                    array(
                        'id' => 'fes-vendor-new-submission-email',
                        'type' => 'textarea',
                        'title' => __( 'Vendor Email Upon Creating Submission Email', 'edd_fes' ),
                        'subtitle' => __( 'For a list of shortcodes you can use, see ', 'edd_fes' ).'<a href="https://easydigitaldownloads.com/docs/frontend-submissions-email-configuration/">'.__('the KB','edd_fes').'</a>',
                        'validate' => 'html',
                        'required' =>  array( 'fes-vendor-new-submission-email-toggle', 'equals', array( '1' ) ),
                        'default' => '',
                    ),
                    array(
                        'id'=> 'fes-vendor-submission-approved-email-toggle',
                        'type' => 'switch',
                        'title' => __( 'Vendor Email Upon Submission Being Approved?', 'edd_fes' ),
                        'default'       => 1,
                    ),
                    array(
                        'id' => 'fes-vendor-submission-approved-email',
                        'type' => 'textarea',
                        'title' => __( 'Vendor Submission Approved Email', 'edd_fes' ),
                        'subtitle' => __( 'For a list of shortcodes you can use, see ', 'edd_fes' ).'<a href="https://easydigitaldownloads.com/docs/frontend-submissions-email-configuration/">'.__('the KB','edd_fes').'</a>',
                        'validate' => 'html',
                        'required' =>  array( 'fes-vendor-submission-approved-email-toggle', 'equals', array( '1' ) ),
                        'default' => '',
                    ),
                    array(
                        'id'=> 'fes-vendor-submission-declined-email-toggle',
                        'type' => 'switch',
                        'title' => __( 'Vendor Email Upon Submission Being Declined?', 'edd_fes' ),
                        'default'       => 1,
                    ),
                    array(
                        'id' => 'fes-vendor-submission-declined-email',
                        'type' => 'textarea',
                        'title' => __( 'Vendor Submission Declined Email', 'edd_fes' ),
                        'subtitle' => __( 'For a list of shortcodes you can use, see ', 'edd_fes' ).'<a href="https://easydigitaldownloads.com/docs/frontend-submissions-email-configuration/">'.__('the KB','edd_fes').'</a>',
                        'validate' => 'html',
                        'required' =>  array( 'fes-vendor-submission-declined-email-toggle', 'equals', array( '1' ) ),
                        'default' => '',
                    ),
                    array(
                        'id'=> 'fes-vendor-submission-revoked-email-toggle',
                        'type' => 'switch',
                        'title' => __( 'Vendor Email Upon Submission Being Revoked?', 'edd_fes' ),
                        'default'       => 1,
                    ),
                    array(
                        'id' => 'fes-vendor-submission-revoked-email',
                        'type' => 'textarea',
                        'title' => __( 'Vendor Submission Revoked Email', 'edd_fes' ),
                        'subtitle' => __( 'For a list of shortcodes you can use, see ', 'edd_fes' ).'<a href="https://easydigitaldownloads.com/docs/frontend-submissions-email-configuration/">'.__('the KB','edd_fes').'</a>',
                        'validate' => 'html',
                        'required' =>  array( 'fes-vendor-submission-revoked-email-toggle', 'equals', array( '1' ) ),
                        'default' => '',
                    ),
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-list-alt',
                'title' => __( 'Forms', 'edd_fes' ),
                'desc' => __( '<p class="description">Settings for FES Forms</p>', 'edd_fes' ),
                'fields' => array(
                    array(
                        'id' => 'fes-submission-form',
                        'type'     => 'select',
                        'data' => 'posts',
                        'args'=> array( 'post_type'=> 'fes-forms', 'posts_per_page'=> -1),
                        'title' => __( 'Submission Form', 'edd_fes' ),
                    ),
                    array(
                        'id' => 'fes-profile-form',
                        'type'     => 'select',
                        'data' => 'posts',
                        'args'=> array( 'post_type'=> 'fes-forms', 'posts_per_page'=>-1),
                        'title' => __( 'Profile Form', 'edd_fes' ),
                    ),
                    array(
                        'id' => 'fes-login-form',
                        'type'     => 'select',
                        'data' => 'posts',
                        'args'=> array( 'post_type'=> 'fes-forms', 'posts_per_page'=>-1),
                        'title' => __( 'Login Form', 'edd_fes' ),
                    ),
                    array(
                        'id' => 'fes-registration-form',
                        'type'     => 'select',
                        'data' => 'posts',
                        'args'=> array( 'post_type'=> 'fes-forms', 'posts_per_page'=>-1),
                        'title' => __( 'Registration Form', 'edd_fes' ),
                    ),
                    array(
                        'id' => 'fes-vendor-contact-form',
                        'type'     => 'select',
                        'data' => 'posts',
                        'args'=> array( 'post_type'=> 'fes-forms', 'posts_per_page'=>-1),
                        'title' => __( 'Vendor Contact Form', 'edd_fes' ),
                    ),
                    array(
                        'id'=> 'fes-allow-customer-login',
                        'type' => 'switch',
                        'title' => __( 'Allow Customers To Login On the Vendor Dashboard?', 'edd_fes' ),
                        'desc' => __( 'If on, creates a radio toggle on the login form on the vendor dashboard. If a customer logs in, he is redirected to the page set as the Purchase History Page on the EDD settings panel', 'edd_fes' ),
                        'default'       => true,
                    ),
                    array(
                        'id'=> 'fes-login-captcha',
                        'type' => 'switch',
                        'title' => __( 'CAPTCHA on the login form', 'edd_fes' ),
                        'desc' => __( 'If on, creates a captcha field on the login form on the vendor dashboard', 'edd_fes' ),
                        'default'       => false,
                    ),
                    array(
                        'id'=> 'fes-vendor-contact-captcha',
                        'type' => 'switch',
                        'title' => __( 'CAPTCHA on the vendor contact form', 'edd_fes' ),
                        'desc' => __( 'If on, creates a captcha field on the vendor contact form', 'edd_fes' ),
                        'default'       => false,
                    ),
                    array(
                        'id'=> 'fes-allow-multiple-purchase-mode',
                        'type' => 'switch',
                        'title' => __( 'Enable Multiple Purchase Mode for all vendor products', 'edd_fes' ),
                        'desc' => __( 'If on, allows customers to purchase multiple variations of a vendor product at a time', 'edd_fes' ),
                        'default'       => false,
                    ),
                    // Toggle on/off fields of store settings (and their functionality)
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-bullhorn',
                'title' => __( 'Integrations', 'edd_fes' ),
                'desc' => __( '<p class="description">Settings for FES Integrations</p>', 'edd_fes' ),
                'fields' => array(
                    array(
                        'id' => 'fes-recaptcha-public-key',
                        'type' => 'text',
                        'title' => __( 'reCAPTCHA Public Key', 'edd_fes' ),
                    ),
                    array(
                        'id' => 'fes-recaptcha-private-key',
                        'type' => 'text',
                        'title' => __( 'reCAPTCHA Private Key', 'edd_fes' ),
                    ),
                    // Checkout Field Manager integration in 2.3
                    // Commissions override email notification integration in 2.3
                    // QR codes integration in 2.3
                    // Product Support integration in 2.3 (pending Trello vote)
                )
            );
            do_action( 'fes_settings_panel_sections', $this->sections );
        }

        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {
            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'fes_settings', // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => __( 'Easy Digital Downloads', 'edd' ).' '.fes_plugin_name, // Name that appears at the top of your panel
                'display_version' => fes_plugin_version, // Version that appears at the top of your panel
                'menu_type' => 'submenu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => false, // Show the sections below the admin menu item or not
                'menu_title' => __( 'Settings', 'edd_fes' ),
                'page_title' => __( 'FES Settings', 'edd_fes' ),
                'admin_bar' => false, // Show the panel pages on the admin bar
                'global_variable' => '', // Set a different name for your global variable other than the opt_name
                'dev_mode' => false, // Show the time the page took to load, etc
                'page_priority' => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'fes-about', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions' => 'manage_shop_settings', // Permissions needed to access the options panel.
                'menu_icon' => '', // Specify a custom URL to an icon
                'last_tab' => '', // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
                'page_slug' => 'fes-settings', // Page slug used to denote the panel
                'save_defaults' => true, // On load save the defaults to DB before user clicks save or not
                'default_show' => false, // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '', // What to print by the field's title if the value shown is default. Suggested: *
                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                //'domain'              => 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
                'footer_credit'       => __( 'Thanks for using EDD FES', 'edd_fes' ), // Disable the footer credit of Redux. Please leave if you can help it.
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database' => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'show_import_export' => true, // REMOVE
                'system_info' => false, // REMOVE
                'help_tabs' => array(),
                'help_sidebar' => '', // __( '', $this->args['domain'] );
                'hints' => array(
                    'icon'              => 'icon-question-sign',
                    'icon_position'     => 'right',
                    'icon_color'        => 'lightgray',
                    'icon_size'         => 'normal',

                    'tip_style'         => array(
                        'color'     => 'light',
                        'shadow'    => true,
                        'rounded'   => false,
                        'style'     => '',
                    ),
                    'tip_position'      => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect' => array(
                        'show' => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'mouseover',
                        ),
                        'hide' => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );

            // Panel Intro text -> before the form
            if ( !isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
                if ( !empty( $this->args['global_variable'] ) ) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace( "-", "_", $this->args['opt_name'] );
                }
                $this->args['intro_text'] = __( 'Thanks for using EDD FES', 'edd_fes' );
            }
        }

    }
    global $fes_save_settings;
   $fes_save_settings = new FES_Settings();
}
