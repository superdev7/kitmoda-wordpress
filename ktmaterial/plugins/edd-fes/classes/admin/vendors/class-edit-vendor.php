<?php
if (!defined('ABSPATH')) {
    exit;
}

class FES_Edit_Vendor{
    function __construct() {

    }

    public function show_page() {
        $vendor = isset( $_GET['vendor'] ) ? absint( $_GET['vendor'] ) : false;
        if ( ! $vendor ) {
            echo __('Invalid ID', 'edd_fes');
            exit;
        }
        if ( ! user_can(get_current_user_id() , 'manage_shop_settings')) {
            echo __('Access Denied', 'edd_fes');
            exit;
        }
        $user = get_userdata( $vendor );
        echo '<div class="wrap about-wrap"><h2>' . __('Vendor: ', 'edd_fes') . $user->display_name . ' (' . __('ID', 'edd_fes') . ': ' . $user->ID . ')</h2>';
        $message = false;
        if (isset($_GET['approved']) && $_GET['approved'] == '2') { ?>
            <div class="updated">
                <p><?php printf( __('%s approved!', 'edd_fes'), EDD_FES()->vendors->get_vendor_constant_name($plural = false, $uppercase = true) ); ?></p>
            </div>
            <?php
        } ?>
        <style> #fes-vendor-edit-page{display:none;} div.fes-fields{clear:both;} </style>
        <script type="text/javascript">
            // This is super hackish but it works so well!
            (jQuery)(document).ready(function(){
                (jQuery)(".updated p").prepend("<?php printf( __('%s updated!', 'edd_fes'), EDD_FES()->vendors->get_vendor_constant_name($plural = false, $uppercase = true) ); ?>");
            });
        </script>
        <h2 class="nav-tab-wrapper">
            <a href="#fes-metabox" class="nav-tab" id="fes-editor-tab"><?php printf( __('%s Overview', 'edd_fes'), EDD_FES()->vendors->get_vendor_constant_name($plural = false, $uppercase = true) ); ?></a>
            <a href="#fes-metabox-registration-form" class="nav-tab" id="fes-registration-form"><?php _e('Application Form', 'edd_fes'); ?></a>
            <a href="#fes-metabox-profile-form" class="nav-tab" id="fes-post-settings-form-tab"><?php _e('Profile Form', 'edd_fes'); ?></a>
            <a href="#fes-metabox-products" class="nav-tab" id="fes-products-tab"><?php _e('Products', 'edd_fes'); ?></a>
            <?php if (EDD_FES()->integrations->is_commissions_active()) { ?>
            <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=download&page=edd-commissions&user=' . $vendor ) ); ?>" class="nav-tab" id="fes-commissions-tab"><?php _e('Commissions', 'edd_fes'); ?></a>
            <?php } ?>
            <?php do_action('fes_edit_vendor_form_tab'); ?>
        </h2>

        <div class="tab-content">
            <div id="fes-metabox" class="group">
                <div class="fes-form">
                    <fieldset>
                        <?php _e('Name: ', 'edd_fes'); ?></td><td><?php echo $user->display_name; ?>
                    </fieldset>
                    <fieldset>
                        <?php _e('Status: ', 'edd_fes');
                        if (user_can($user->ID, 'fes_is_admin') || user_can($user->ID, 'frontend_vendor')) {
                            _e('Frontend Vendor', 'edd_fes');
                        } else if (user_can($user->ID, 'pending_vendor')) {
                            _e('Pending Vendor', 'edd_fes');
                        } else if (user_can($user->ID, 'suspended_vendor')) {
                            _e('Suspended Vendor', 'edd_fes');
                        } else {
                            _e('Error!', 'edd_fes');
                        } ?>
                    </fieldset>
                    <fieldset>
                        <?php printf( __('Total %s: ', 'edd_fes'), EDD_FES()->vendors->get_product_constant_name($plural = true, $uppercase = true) ); ?></td><td><?php
                              echo EDD_FES()->vendors->get_all_products_count($user->ID, array('publish', 'pending', 'trash')); ?>
                              <br>
                        <?php printf( __('Live %s: ', 'edd_fes'), EDD_FES()->vendors->get_product_constant_name($plural = true, $uppercase = true) ); ?></td><td><?php
                              echo EDD_FES()->vendors->get_all_products_count($user->ID, 'publish'); ?>
                              <br>
                        <?php printf( __('Pending %s: ', 'edd_fes'), EDD_FES()->vendors->get_product_constant_name($plural = true, $uppercase = true) ); ?></td><td><?php
                              echo EDD_FES()->vendors->get_all_products_count($user->ID, 'pending'); ?>
                              <br>
                        <?php printf( __('Trashed %s: ', 'edd_fes'), EDD_FES()->vendors->get_product_constant_name($plural = true, $uppercase = true) ); ?></td><td><?php
                              echo EDD_FES()->vendors->get_all_products_count($user->ID, 'trash'); ?>
                              <br>
                    </fieldset>
                    <fieldset>
                        <?php _e('Actions: ', 'edd_fes');
                        if (user_can($user->ID, 'fes_is_admin') || user_can($user->ID, 'frontend_vendor')) { ?>
                            <a href="<?php echo admin_url('admin.php?page=fes-vendors&vendor=' . $user->ID . '&action=revoke_vendor&redirect=2'); ?>"><?php _e('Revoke', 'edd_fes') ?></a>&nbsp;
                            <a href="<?php echo admin_url('admin.php?page=fes-vendors&vendor=' . $user->ID . '&action=suspend_vendor&redirect=2'); ?>"><?php _e('Suspend', 'edd_fes') ?></a>
                        <?php
                        } else if (user_can($user->ID, 'pending_vendor')) { ?>
                            <a href="<?php echo admin_url('admin.php?page=fes-vendors&vendor=' . $user->ID . '&action=approve_vendor&redirect=2'); ?>"><?php _e('Approve', 'edd_fes') ?></a>&nbsp;
                            <a href="<?php echo admin_url('admin.php?page=fes-vendors&vendor=' . $user->ID . '&action=decline_vendor&redirect=2'); ?>"><?php _e('Decline', 'edd_fes') ?></a>
                        <?php
                        } else if (user_can($user->ID, 'suspended_vendor')) { ?>
                            <a href="<?php echo admin_url('admin.php?page=fes-vendors&vendor=' . $user->ID . '&action=unsuspend_vendor&redirect=2'); ?>"><?php _e('Unsuspend', 'edd_fes') ?></a>&nbsp;
                            <a href="<?php echo admin_url('admin.php?page=fes-vendors&vendor=' . $user->ID . '&action=revoke_vendor&redirect=2'); ?>"><?php _e('Revoke', 'edd_fes') ?></a>
                        <?php
                        } ?>
                    </fieldset>
                </div>
            </div>

            <div id="fes-metabox-registration-form" class="group">
                <?php EDD_FES()->forms->render_form('registration', $user->ID, true, $args = array( 'backend' => true )); ?>
            </div>

            <div id="fes-metabox-profile-form" class="group">
                <?php EDD_FES()->forms->render_form('profile', $user->ID, false, $args = array( 'backend' => true )); ?>
            </div>

            <div id="fes-metabox-products" class="group">
                <?php
                $concat = get_option("permalink_structure") ? "?" : "&";
                $products = EDD_FES()->vendors->get_all_products($user->ID);
                $sales = 0;
                $earnings = 0;

                if (!empty($products)) { ?>
                    <table class="widefat" id="fes-all-products">
                    <thead>
                         <tr>
                            <th><?php _e('ID', 'edd_fes'); ?></th>
                            <th><?php _e('Title', 'edd_fes'); ?></th>
                            <th><?php _e('Status', 'edd_fes'); ?></th>
                            <th><?php _e('Sales', 'edd_fes'); ?></th>
                        </tr>
                    </thead>
                     <tbody>

                     <?php foreach ($products as $product) : ?>
                         <tr>
                            <td><?php echo esc_html($product['ID']); ?></td>
                            <td><a href="<?php echo esc_html($product['url']); ?>"><?php echo esc_html($product['title']); ?></a></td>
                            <td><?php echo esc_html($product['status']); ?></td>
                            <td><?php echo esc_html($product['sales']); ?></td>
                        </tr>
                    <?php
                    $sales+= $product['sales']; ?>
                    <?php endforeach; ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <td><strong><?php _e('Total Sales', 'edd_fes'); ?></strong></td>
                            <td></td>
                            <td></td>
                            <td><?php echo $sales; ?></td>
                    </tfoot>
                    </table>
                <?php
            } else {
                printf( __('%s has no %s', 'edd_fes'), EDD_FES()->vendors->get_vendor_constant_name($plural = false, $uppercase = true), EDD_FES()->vendors->get_product_constant_name($plural = true, $uppercase = false) );
            } ?>
            </div>
            <?php
            if (EDD_FES()->integrations->is_commissions_active()) { ?>
            <div id="fes-metabox-commissions" class="group">
                <?php
                if (eddc_user_has_commissions( $user->ID )) {
                    echo eddc_user_commissions( $user->ID );
                } else {
                    printf( __('This %s has no sales yet!', 'edd_fes'), EDD_FES()->vendors->get_vendor_constant_name($plural = false, $uppercase = false) );
                } ?>
             </div>
            <?php
            }
            do_action('fes_edit_vendor_tab_content'); ?>
        </div>
        <?php
    }
}
