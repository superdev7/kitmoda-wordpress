<?php
if (!defined('ABSPATH')) {
    exit;
}

class FES_Edit_Download extends FES_Forms {

    function __construct() {
        add_action( 'wp_dropdown_users', array( $this, 'author_vendor_roles' ), 0, 1 );
        add_action('add_meta_boxes', array( $this, 'add_meta_boxes' ));
        add_action('save_post', array( $this, 'save_meta' ) , 1, 2);
        add_action( 'add_meta_boxes', array( &$this,'change_author_meta_box_title' ) );
    }


    /**
     * Override the authors selectbox with +vendor roles
     *
     * @param html $output
     *
     * @return html
     */
    public function author_vendor_roles( $output )
    {
        global $post;

        if ( empty( $post ) ) return $output;

        // Return if this isn't an EDD download post type
        if ( $post->post_type != 'download' ) return $output;

        // Return if this isn't the vendor author override dropdown
        if ( !strpos( $output, 'post_author_override' ) ) return $output;

        $args = array(
            'selected' => $post->post_author,
            'id'       => 'post_author_override',
        );

        $output = $this->vendor_selectbox( $args );

        return $output;
    }


    /**
     * Create a selectbox to display vendor & administrator roles
     *
     * @param array $args
     *
     * @return html
     */
    public function vendor_selectbox( $args )
    {
        $default_args = array(
            'placeholder',
            'id',
            'class',
        );

        foreach ( $default_args as $key ) {
            if ( !is_array( $key ) && empty( $args[ $key ] ) ) $args[ $key ] = '';
            else if ( is_array( $key ) ) foreach ( $key as $val ) $args[ $key ][ $val ] = esc_attr( $args[ $key ][ $val ] );
        }
        extract( $args );

        $roles     = array( 'editor', 'suspended_vendor', 'frontend_vendor', 'administrator', 'contributor', 'shop_manager', 'shop_vendor', 'author' );
        $user_args = array( 'fields' => array( 'ID', 'user_login' ) );

        $output = "<select style='width:200px;' name='$id' id='$id' class='$class' data-placeholder='$placeholder'>\n";
        $output .= "\t<option value=''></option>\n";

        foreach ( $roles as $role ) {

            $new_args           = $user_args;
            $new_args[ 'role' ] = $role;
            $users              = get_users( $new_args );

            if ( empty( $users ) ) continue;
            foreach ( (array) $users as $user ) {
                $select = selected( $user->ID, $selected, false );
                $output .= "\t<option value='$user->ID' $select>$user->user_login</option>\n";
            }

        }
        $output .= "</select>";

        // Convert this selectbox with jQuery Chosen
        // $output .= '<script type="text/javascript">jQuery(function() {jQuery("#' . $id . '").chosen();});</script>';

        return $output;
    }

    public function change_author_meta_box_title() {
        global $wp_meta_boxes;
        $wp_meta_boxes[ 'download' ][ 'normal' ][ 'core' ][ 'authordiv' ][ 'title' ] = __( 'Vendor', 'edd_fes' );
    }

    function add_meta_boxes() {
        add_meta_box('fes-custom-fields', __('Frontend Submissions', 'edd_fes') , array( $this, 'render_form' ) , 'download', 'normal', 'high');
    }

    function render_form($type = 'submission', $id = false, $read_only = false, $args = array()) {
        global $post;

        $form_id = EDD_FES()->helper->get_option( 'fes-submission-form', false );
        if ( !$form_id ){
            return _e( 'Submission form not set in FES settings' , 'edd_fes' );
        }

        $form_settings = get_post_meta($form_id, 'fes-form_settings', true);

        list($post_fields, $taxonomy_fields, $custom_fields) = $this->get_input_fields($form_id);
        $author = false;
        if ( is_object( $post ) ){
            $author = $post->post_author;
        }
        if ( $author ){
        ?>
        <a href="<?php echo admin_url("admin.php?page=fes-vendors&vendor=". $author ."&action=edit"); ?>"><?php echo __('View', 'edd_fes') .  ' ' . EDD_FES()->vendors->get_vendor_constant_name( $plural = true, $uppercase = false ) . ' ' . __('edit page', 'edd_fes');?></a><br /><br />
        <?php
        }
        if (empty($custom_fields)) {
            _e('No custom fields found.', 'edd_fes');
            return;
        }
        ?>

        <input type="hidden" name="fes_cf_update" value="<?php echo wp_create_nonce('fes_cf_update'); ?>" />
        <input type="hidden" name="fes_cf_form_id" value="<?php echo $form_id; ?>" />
        <div class="fes-form">
        <?php
        $this->render_items($custom_fields, $post->ID, 'submission', $form_id, $form_settings);
        ?>
        </div>
        <?php
    }

    function save_meta($post_id, $post) {
        if (!isset($_POST['fes_cf_update']) || !isset($_POST['post_ID'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['fes_cf_update'], 'fes_cf_update')) {
            return;
        }
        // Is the user allowed to edit the post or page?
        if (!current_user_can('edit_post', $_POST['post_ID'])) {
            return $_POST['post_ID'];
        }

        list($post_vars, $tax_vars, $meta_vars) = self::get_input_fields($_POST['fes_cf_form_id']);
        EDD_FES()->forms->update_post_meta($meta_vars, $_POST['post_ID']);
        do_action( 'fes_save_meta_download', $_POST['post_ID'] );
    }
}