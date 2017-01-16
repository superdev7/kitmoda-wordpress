<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * FES Form builder template
 */
class FES_Formbuilder_Templates {

    /**
     * Legend of a form item
     *
     * @param string $title
     * @param array $values
     */
    public static function legend( $title = 'Field Name', $values = array(), $removeable = true ) {
        $field_label = $values && isset( $values['label'] ) ? ': <strong>' . $values['label'] . '</strong>' : '';
        ?>
        <div class="fes-legend" title="<?php _e( 'Click and Drag to rearrange', 'edd_fes'); ?>">
            <div class="fes-label"><?php echo $title . $field_label; ?></div>
            <div class="fes-actions">
				<?php if ($removeable){ ?>
                <a href="#" class="fes-remove"><?php _e( 'Remove', 'edd_fes' ); ?></a>
				<?php } ?>
                <a href="#" class="fes-toggle"><?php _e( 'Toggle', 'edd_fes' ); ?></a>
            </div>
        </div> <!-- .fes-legend -->
        <?php
    }

    /**
     * Common Fields for a input field
     *
     * Contains required, label, meta_key, help text, css class name
     *
     * @param int $id field order
     * @param mixed $field_name_value
     * @param bool $custom_field if it a custom field or not
     * @param array $values saved value
     */
    public static function common( $id, $field_name_value = '', $custom_field = true, $values = array(), $force_required = false, $input_type = 'text' ) {
        global $post;

        $tpl = '%s[%d][%s]';
        $required_name = sprintf( $tpl, 'fes_input', $id, 'required' );
        $field_name = sprintf( $tpl, 'fes_input', $id, 'name' );
        $label_name = sprintf( $tpl, 'fes_input', $id, 'label' );
        $is_meta_name = sprintf( $tpl, 'fes_input', $id, 'is_meta' );
        $help_name = sprintf( $tpl, 'fes_input', $id, 'help' );
        $css_name = sprintf( $tpl, 'fes_input', $id, 'css' );

        $required = $values && isset($values['required']) ? esc_attr( $values['required'] ) : 'yes';
        $input_type = !empty($values['input_type']) ? $values['input_type'] : $input_type;
        $label_value = $values && isset($values['label']) && ! empty($values['label']) ? esc_attr( $values['label'] ) : esc_attr( ucwords( str_replace( '_', ' ', $input_type ) ) );
        $help_value = $values && isset($values['help'])? esc_textarea( $values['help'] ) : '';
        $css_value = $values && isset($values['css'])? esc_attr( $values['css'] ) : '';
        $meta_type = "yes"; // for post meta on custom fields

        if ($custom_field && $values) {
            $field_name_value = $values['name'];
        }

        $exclude = array( 'email_to_use_for_contact_form', 'name_of_store' );
        if ( $custom_field && in_array( $field_name_value, $exclude ) ){
            $custom_field = false;
        }

		do_action('fes_add_field_to_common_form_element', $tpl, 'fes_input', $id, $values);
        ?>

        <div class="fes-form-rows required-field">
            <label><?php _e( 'Required', 'edd_fes' ); ?></label>
            <div class="fes-form-sub-fields">
                <label><input type="radio" name="<?php echo htmlentities($required_name,ENT_QUOTES); ?>" value="yes"<?php checked( $required, 'yes' ); ?>> <?php _e( 'Yes', 'edd_fes' ); ?> </label>
				<?php if( !$force_required ){ ?>
				<label><input type="radio" name="<?php echo htmlentities($required_name,ENT_QUOTES); ?>" value="no"<?php checked( $required, 'no' ); ?>> <?php _e( 'No', 'edd_fes' ); ?> </label>
				<?php } ?>
			</div>
        </div> <!-- .fes-form-rows -->

        <div class="fes-form-rows">
            <label><?php _e( 'Field Label', 'edd_fes' ); ?></label>
            <input type="text" data-type="label" name="<?php echo htmlentities($label_name,ENT_QUOTES); ?>" value="<?php echo $label_value; ?>" class="smallipopInput" title="<?php _e( 'Enter a title of this field', 'edd_fes' ); ?>">
        </div> <!-- .fes-form-rows -->

        <?php if ( $custom_field ) { ?>
            <div class="fes-form-rows">
                <label><?php _e( 'Meta Key', 'edd_fes' ); ?></label>
                <input type="text" name="<?php echo htmlentities($field_name,ENT_QUOTES); ?>" value="<?php echo $field_name_value; ?>" class="smallipopInput" title="<?php _e( 'Name of the meta key this field will save to', 'edd_fes' ); ?>">
                <input type="hidden" name="<?php echo htmlentities($is_meta_name,ENT_QUOTES); ?>" value="<?php echo $meta_type; ?>">
            </div> <!-- .fes-form-rows -->
        <?php } else { ?>

            <input type="hidden" name="<?php echo htmlentities($field_name,ENT_QUOTES); ?>" value="<?php echo $field_name_value; ?>">
            <input type="hidden" name="<?php echo htmlentities($is_meta_name,ENT_QUOTES); ?>" value="no">

        <?php } ?>

        <div class="fes-form-rows">
            <label><?php _e( 'Help text', 'edd_fes' ); ?></label>
            <textarea name="<?php echo htmlentities($help_name,ENT_QUOTES); ?>" class="smallipopInput" title="<?php _e( 'Give the user some information about this field', 'edd_fes' ); ?>"><?php echo $help_value; ?></textarea>
        </div> <!-- .fes-form-rows -->
        <?php if ( !isset( $values['no_css'] ) || !$values['no_css'] ){ ?>
        <div class="fes-form-rows">
            <label><?php _e( 'CSS Class Name', 'edd_fes' ); ?></label>
            <input type="text" name="<?php echo htmlentities($css_name,ENT_QUOTES); ?>" value="<?php echo $css_value; ?>" class="smallipopInput" title="<?php _e( 'Add a CSS class name for this field', 'edd_fes' ); ?>">
        </div> <!-- .fes-form-rows -->
        <?php } ?>
        <?php
    }

    /**
     * Common fields for a text area
     *
     * @param int $id
     * @param array $values
     */
    public static function common_text( $id, $values = array() ) {
        $tpl = '%s[%d][%s]';
        $placeholder_name = sprintf( $tpl, 'fes_input', $id, 'placeholder' );
        $default_name = sprintf( $tpl, 'fes_input', $id, 'default' );
        $size_name = sprintf( $tpl, 'fes_input', $id, 'size' );

        $placeholder_value = $values && isset($values['placeholder'])? esc_attr( $values['placeholder'] ) : '';
        $default_value = $values && isset($values['default']) ? esc_attr( $values['default'] ) : '';
        $size_value = $values && isset($values['size']) ? esc_attr( $values['size'] ) : '40';
        $show_placeholder =  $values && isset($values['show_placeholder']) ? $values['show_placeholder'] : true;
        $show_default_value =  $values && isset($values['default_value']) ? $values['default_value'] : true;

        if ( $show_placeholder ){ ?>
        <div class="fes-form-rows">
            <label><?php _e( 'Placeholder text', 'edd_fes' ); ?></label>
            <input type="text" class="smallipopInput" name="<?php echo htmlentities($placeholder_name,ENT_QUOTES); ?>" title="<?php esc_attr_e( 'Text for HTML5 placeholder attribute', 'edd_fes' ); ?>" value="<?php echo $placeholder_value; ?>" />
        </div> <!-- .fes-form-rows -->
        <?php }
        if ( $show_default_value ){ ?>
        <div class="fes-form-rows">
            <label><?php _e( 'Default value', 'edd_fes' ); ?></label>
            <input type="text" class="smallipopInput" name="<?php echo htmlentities($default_name,ENT_QUOTES); ?>" title="<?php esc_attr_e( 'The default value this field will have', 'edd_fes' ); ?>" value="<?php echo $default_value; ?>" />
        </div> <!-- .fes-form-rows -->
        <?php } ?>
        <div class="fes-form-rows">
            <label><?php _e( 'Size', 'edd_fes' ); ?></label>
            <input type="text" class="smallipopInput" name="<?php echo htmlentities($size_name,ENT_QUOTES); ?>" title="<?php esc_attr_e( 'Size of this input field', 'edd_fes' ); ?>" value="<?php echo $size_value; ?>" />
        </div> <!-- .fes-form-rows -->
        <?php
    }

    /**
     * Common fields for a textarea
     *
     * @param int $id
     * @param array $values
     */
    public static function common_textarea( $id, $values = array() ) {
        $tpl = '%s[%d][%s]';
        $rows_name = sprintf( $tpl, 'fes_input', $id, 'rows' );
        $cols_name = sprintf( $tpl, 'fes_input', $id, 'cols' );
        $rich_name = sprintf( $tpl, 'fes_input', $id, 'rich' );
        $placeholder_name = sprintf( $tpl, 'fes_input', $id, 'placeholder' );
        $default_name = sprintf( $tpl, 'fes_input', $id, 'default' );

        $rows_value = $values && isset( $values['rows'] )? esc_attr( $values['rows'] ) : '5';
        $cols_value = $values && isset( $values['cols'] )? esc_attr( $values['cols'] ) : '25';
        $rich_value = $values && isset( $values['rich'] )? esc_attr( $values['rich'] ) : 'no';
        $placeholder_value = $values && isset( $values['placeholder'] )? esc_attr( $values['placeholder'] ) : '';
        $default_value = $values && isset( $values['default'] )? esc_attr( $values['default'] ) : '';

        ?>
        <div class="fes-form-rows">
            <label><?php _e( 'Rows', 'edd_fes' ); ?></label>
            <input type="text" class="smallipopInput" name="<?php echo htmlentities($rows_name,ENT_QUOTES); ?>" title="Number of rows in textarea" value="<?php echo $rows_value; ?>" />
        </div> <!-- .fes-form-rows -->

        <div class="fes-form-rows">
            <label><?php _e( 'Columns', 'edd_fes' ); ?></label>
            <input type="text" class="smallipopInput" name="<?php echo htmlentities($cols_name,ENT_QUOTES); ?>" title="Number of columns in textarea" value="<?php echo $cols_value; ?>" />
        </div> <!-- .fes-form-rows -->

        <div class="fes-form-rows">
            <label><?php _e( 'Placeholder text', 'edd_fes' ); ?></label>
            <input type="text" class="smallipopInput" name="<?php echo htmlentities($placeholder_name,ENT_QUOTES); ?>" title="text for HTML5 placeholder attribute" value="<?php echo $placeholder_value; ?>" />
        </div> <!-- .fes-form-rows -->

        <div class="fes-form-rows">
            <label><?php _e( 'Default value', 'edd_fes' ); ?></label>
            <input type="text" class="smallipopInput" name="<?php echo htmlentities($default_name,ENT_QUOTES); ?>" title="the default value this field will have" value="<?php echo $default_value; ?>" />
        </div> <!-- .fes-form-rows -->

        <div class="fes-form-rows">
            <label><?php _e( 'Textarea', 'edd_fes' ); ?></label>

            <div class="fes-form-sub-fields">
                <label><input type="radio" name="<?php echo htmlentities($rich_name,ENT_QUOTES); ?>" value="no"<?php checked( $rich_value, 'no' ); ?>> <?php _e( 'Normal', 'edd_fes' ); ?></label>
                <label><input type="radio" name="<?php echo htmlentities($rich_name,ENT_QUOTES); ?>" value="yes"<?php checked( $rich_value, 'yes' ); ?>> <?php _e( 'Rich textarea', 'edd_fes' ); ?></label>
                <label><input type="radio" name="<?php echo htmlentities($rich_name,ENT_QUOTES); ?>" value="teeny"<?php checked( $rich_value, 'teeny' ); ?>> <?php _e( 'Teeny Rich textarea', 'edd_fes' ); ?></label>
            </div>
        </div> <!-- .fes-form-rows -->
        <?php
    }

    /**
     * Hidden field helper function
     *
     * @param string $name
     * @param string $value
     */
    public static function hidden_field( $name, $value = '' ) {
        printf( '<input type="hidden" name="%s" value="%s" />', 'fes_input' . $name, $value );
    }

    /**
     * Displays a radio custom field
     *
     * @param int $field_id
     * @param string $name
     * @param array $values
     */
    public static function radio_fields( $field_id, $name, $values = array() ) {
        $selected_name = sprintf( '%s[%d][selected]', 'fes_input', $field_id );
        $input_name = sprintf( '%s[%d][%s]', 'fes_input', $field_id, $name );

        $selected_value = ( $values && isset( $values['selected'] ) ) ? $values['selected'] : '';

        if ( $values && $values['options'] > 0 ) {
            foreach ($values['options'] as $key => $value) {
                ?>
                <div>
                    <input type="radio" name="<?php echo htmlentities($selected_name,ENT_QUOTES) ?>" value="<?php echo $value; ?>" <?php checked( $selected_value, $value ); ?>>
                    <input type="text" name="<?php echo htmlentities($input_name,ENT_QUOTES); ?>[]" value="<?php echo $value; ?>">

                    <?php self::remove_button(); ?>
                </div>
                <?php
            }
        } else {
        ?>
            <div>
                <input type="radio" name="<?php echo htmlentities($selected_name,ENT_QUOTES) ?>">
                <input type="text" name="<?php echo htmlentities($input_name,ENT_QUOTES); ?>[]" value="">

                <?php self::remove_button(); ?>
            </div>
        <?php
        }
    }

    /**
     * Displays a checkbox custom field
     *
     * @param int $field_id
     * @param string $name
     * @param array $values
     */
    public static function common_checkbox( $field_id, $name, $values = array() ) {
        $selected_name = sprintf( '%s[%d][selected]', 'fes_input', $field_id );
        $input_name = sprintf( '%s[%d][%s]', 'fes_input', $field_id, $name );

        $selected_value = ( $values && isset( $values['selected'] ) ) ? $values['selected'] : array();

        if ( $values && $values['options'] > 0 ) {
            foreach ($values['options'] as $key => $value) {
                ?>
                <div>
                    <input type="checkbox" name="<?php echo htmlentities($selected_name,ENT_QUOTES) ?>[]" value="<?php echo $value; ?>"<?php echo in_array($value, $selected_value) ? ' checked="checked"' : ''; ?> />
                    <input type="text" name="<?php echo htmlentities($input_name,ENT_QUOTES); ?>[]" value="<?php echo $value; ?>">

                    <?php self::remove_button(); ?>
                </div>
                <?php
            }
        } else {
        ?>
            <div>
                <input type="checkbox" name="<?php echo htmlentities($selected_name,ENT_QUOTES) ?>[]">
                <input type="text" name="<?php echo htmlentities($input_name,ENT_QUOTES); ?>[]" value="">

                <?php self::remove_button(); ?>
            </div>
        <?php
        }
    }

    /**
     * Add/remove buttons for repeatable fields
     *
     * @return void
     */
    public static function remove_button() {
        $add = fes_assets_url .'img/add.png';
        $remove = fes_assets_url. 'img/remove.png';
        ?>
        <img style="cursor:pointer; margin:0 3px;" alt="add another choice" title="add another choice" class="fes-clone-field" src="<?php echo $add; ?>">
        <img style="cursor:pointer;" class="fes-remove-field" alt="remove this choice" title="remove this choice" src="<?php echo $remove; ?>">
        <?php
    }

    public static function get_buffered($func, $field_id, $label) {
        ob_start();

        self::$func( $field_id, $label );

        return ob_get_clean();
    }

    public static function text_field( $field_id, $label, $values = array(), $removeable = true, $force_required = false ) {
        ?>
        <li class="custom-field text_field">
            <?php self::legend( $label, $values, $removeable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'text' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'text_field' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, '', true, $values, $force_required, 'text' ); ?>
                <?php self::common_text( $field_id, $values ); ?>
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function textarea_field( $field_id, $label, $values = array(), $removeable = true, $force_required = false  ) {
        ?>
        <li class="custom-field textarea_field">
            <?php self::legend( $label, $values, $removeable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'textarea' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'textarea_field' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, '', true, $values, $force_required, 'textarea' ); ?>
                <?php self::common_textarea( $field_id, $values ); ?>
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function radio_field( $field_id, $label, $values = array(), $removeable = true, $force_required = false  ) {
        ?>
        <li class="custom-field radio_field">
            <?php self::legend( $label, $values, $removeable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'radio' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'radio_field' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, '', true, $values, $force_required, 'radio' ); ?>

                <div class="fes-form-rows">
                    <label><?php _e( 'Options', 'edd_fes' ); ?></label>

                    <div class="fes-form-sub-fields">
                        <?php self::radio_fields( $field_id, 'options', $values ); ?>
                    </div> <!-- .fes-form-sub-fields -->
                </div> <!-- .fes-form-rows -->
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function checkbox_field( $field_id, $label, $values = array(), $removeable = true, $force_required = false  ) {
        ?>
        <li class="custom-field checkbox_field">
            <?php self::legend( $label, $values, $removeable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'checkbox' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'checkbox_field' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, '', true, $values, $force_required, 'checkbox' ); ?>

                <div class="fes-form-rows">
                    <label><?php _e( 'Options', 'edd_fes' ); ?></label>

                    <div class="fes-form-sub-fields">
                        <?php self::common_checkbox( $field_id, 'options', $values ); ?>
                    </div> <!-- .fes-form-sub-fields -->
                </div> <!-- .fes-form-rows -->
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function dropdown_field( $field_id, $label, $values = array(), $removeable = true, $force_required = false  ) {
        $first_name = sprintf('%s[%d][first]', 'fes_input', $field_id);
        $first_value = $values && isset( $values['first'] ) ? $values['first'] : ' - select -';
        $help = esc_attr( __( 'First element of the select dropdown. Leave this empty if you don\'t want to show this field', 'edd_fes' ) );
        ?>
        <li class="custom-field dropdown_field">
            <?php self::legend( $label, $values, $removeable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'select' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'dropdown_field' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, '', true, $values, $force_required, 'select' ); ?>

                <div class="fes-form-rows">
                    <label><?php _e( 'Select Text', 'edd_fes' ); ?></label>
                    <input type="text" class="smallipopInput" name="<?php echo htmlentities($first_name,ENT_QUOTES); ?>" value="<?php echo $first_value; ?>" title="<?php echo $help; ?>">
                </div> <!-- .fes-form-rows -->

                <div class="fes-form-rows">
                    <label><?php _e( 'Options', 'edd_fes' ); ?></label>

                    <div class="fes-form-sub-fields">
                        <?php self::radio_fields( $field_id, 'options', $values ); ?>
                    </div> <!-- .fes-form-sub-fields -->
                </div> <!-- .fes-form-rows -->
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function multiple_select( $field_id, $label, $values = array(), $removeable = true, $force_required = false  ) {
        $first_name = sprintf('%s[%d][first]', 'fes_input', $field_id);
        $first_value = $values && isset( $values['first'] ) ? $values['first'] : ' - select -';
        $help = esc_attr( __( 'First element of the select dropdown. Leave this empty if you don\'t want to show this field', 'edd_fes' ) );
        ?>
        <li class="custom-field multiple_select">
            <?php self::legend( $label, $values, $removeable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'multiselect' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'multiple_select' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, '', true, $values, $force_required, 'multiselect' ); ?>

                <div class="fes-form-rows">
                    <label><?php _e( 'Select Text', 'edd_fes' ); ?></label>
                    <input type="text" class="smallipopInput" name="<?php echo htmlentities($first_name,ENT_QUOTES); ?>" value="<?php echo $first_value; ?>" title="<?php echo $help; ?>">
                </div> <!-- .fes-form-rows -->

                <div class="fes-form-rows">
                    <label><?php _e( 'Options', 'edd_fes' ); ?></label>

                    <div class="fes-form-sub-fields">
                        <?php self::radio_fields( $field_id, 'options', $values ); ?>
                    </div> <!-- .fes-form-sub-fields -->
                </div> <!-- .fes-form-rows -->
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function country( $field_id, $label, $values = array(), $removeable = true, $force_required = false  ) {
        $first_name = sprintf('%s[%d][first]', 'fes_input', $field_id);
        $first_value = $values && isset( $values['first'] ) ? $values['first'] : ' - select -';
        $values['options'] = empty( $values['options'] ) ? edd_get_country_list() : $values['options'];
        $values['label']   = empty( $label ) || empty( $values['label'] ) ? __( 'Vendor Country', 'edd_fes' ) : $values['label'];
        $values['name']    = empty( $values['name'] ) ? 'vendor_country' : $values['name'];
        $help = esc_attr( __( 'First element of the select dropdown. Leave this empty if you don\'t want to show this field', 'edd_fes' ) );
        ?>
        <li class="custom-field country">
            <?php self::legend( $label, $values, $removeable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'select' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'country' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, '', true, $values, $force_required, 'select' ); ?>

                <div class="fes-form-rows">
                    <label><?php _e( 'Select Text', 'edd_fes' ); ?></label>
                    <input type="text" class="smallipopInput" name="<?php echo htmlentities($first_name,ENT_QUOTES); ?>" value="<?php echo $first_value; ?>" title="<?php echo $help; ?>">
                </div> <!-- .fes-form-rows -->

                <div class="fes-form-rows">
                    <label><?php _e( 'Countries', 'edd_fes' ); ?></label>

                    <div class="fes-form-sub-fields">
                        <?php self::radio_fields( $field_id, 'options', $values ); ?>
                    </div> <!-- .fes-form-sub-fields -->
                </div> <!-- .fes-form-rows -->
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

     public static function prices_and_files( $id, $values = array() ) {
        $tpl = '%s[%d][%s]';
		$single_name = sprintf( $tpl, 'fes_input', $id, 'single' );
        $names_name = sprintf( $tpl, 'fes_input', $id, 'names' );
        $prices_name = sprintf( $tpl, 'fes_input', $id, 'prices' );
        $files_name = sprintf( $tpl, 'fes_input', $id, 'files' );
        $single = $values && isset($values['single']) ? esc_attr( $values['single'] ) : 'no';
        $names = $values && isset($values['names']) ? esc_attr( $values['names'] ) : 'yes';
        $prices = $values && isset($values['prices']) ? esc_attr( $values['prices'] ) : 'yes';
        $files = $values && isset($values['files']) ? esc_attr( $values['files'] ) : 'yes';
        ?>

        <div class="fes-form-rows required-field">
            <label><?php _e( 'Single Price/Upload', 'edd_fes' ); ?></label>

            <?php //self::hidden_field($order_name, ''); ?>
            <div class="fes-form-sub-fields">
                <label><input type="radio" name="<?php echo htmlentities($single_name,ENT_QUOTES); ?>" value="yes"<?php checked( $single, 'yes' ); ?>> <?php _e( 'Yes', 'edd_fes' ); ?> </label>
				<label><input type="radio" name="<?php echo htmlentities($single_name,ENT_QUOTES); ?>" value="no"<?php checked( $single, 'no' ); ?>> <?php _e( 'No', 'edd_fes' ); ?> </label>
			</div>
        </div> <!-- .fes-form-rows -->

        <div class="fes-form-rows required-field">
            <label><?php printf( __( 'Allow %s to Set Names of Options', 'edd_fes' ), EDD_FES()->vendors->get_vendor_constant_name( $plural = true, $uppercase = true ) ); ?></label>

            <?php //self::hidden_field($order_name, ''); ?>
            <div class="fes-form-sub-fields">
                <label><input type="radio" name="<?php echo htmlentities($names_name,ENT_QUOTES); ?>" value="yes"<?php checked( $names, 'yes' ); ?>> <?php _e( 'Yes', 'edd_fes' ); ?> </label>
                <label><input type="radio" name="<?php echo htmlentities($names_name,ENT_QUOTES); ?>" value="no"<?php checked( $names, 'no' ); ?>> <?php _e( 'No', 'edd_fes' ); ?> </label>
            </div>
        </div> <!-- .fes-form-rows -->

        <div class="fes-form-rows required-field">
            <label><?php printf( __( 'Allow %s to Set Prices of Options', 'edd_fes' ), EDD_FES()->vendors->get_vendor_constant_name( $plural = true, $uppercase = true ) ); ?></label>

            <?php //self::hidden_field($order_name, ''); ?>
            <div class="fes-form-sub-fields">
                <label><input type="radio" name="<?php echo htmlentities($prices_name,ENT_QUOTES); ?>" value="yes"<?php checked( $prices, 'yes' ); ?>> <?php _e( 'Yes', 'edd_fes' ); ?> </label>
				<label><input type="radio" name="<?php echo htmlentities($prices_name,ENT_QUOTES); ?>" value="no"<?php checked( $prices, 'no' ); ?>> <?php _e( 'No', 'edd_fes' ); ?> </label>
			</div>
        </div> <!-- .fes-form-rows -->

        <div class="fes-form-rows required-field">
            <label><?php printf( __( 'Allow %s to Upload Files', 'edd_fes' ), EDD_FES()->vendors->get_vendor_constant_name( $plural = true, $uppercase = true ) ); ?></label>

            <?php //self::hidden_field($order_name, ''); ?>
            <div class="fes-form-sub-fields">
                <label><input type="radio" name="<?php echo htmlentities($prices_name,$files_name,ENT_QUOTES); ?>" value="yes"<?php checked( $files, 'yes' ); ?>> <?php _e( 'Yes', 'edd_fes' ); ?> </label>
				<label><input type="radio" name="<?php echo htmlentities($prices_name,$files_name,ENT_QUOTES); ?>" value="no"<?php checked( $files, 'no' ); ?>> <?php _e( 'No', 'edd_fes' ); ?> </label>
			</div>
        </div> <!-- .fes-form-rows -->
        <?php
    }

	public static function file_upload( $field_id, $label, $values = array(), $removeable = true, $force_required = false  ) {
        $max_files_name = sprintf('%s[%d][count]', 'fes_input', $field_id);
        $max_files_value = $values && isset( $values['count'] ) ? $values['count'] : '1';
        $count = esc_attr( __( 'Number of files which can be uploaded', 'edd_fes' ) );
        ?>
        <li class="custom-field custom_image">
            <?php self::legend( $label, $values, $removeable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'file_upload' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'file_upload' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, '', true, $values, $force_required, 'file_upload' ); ?>

                <div class="fes-form-rows">
                    <label><?php _e( 'Max. files', 'edd_fes' ); ?></label>
                    <input type="text" class="smallipopInput" name="<?php echo htmlentities($max_files_name,ENT_QUOTES); ?>" value="<?php echo $max_files_value; ?>" title="<?php echo $count; ?>">
                </div> <!-- .fes-form-rows -->
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function website_url( $field_id, $label, $values = array(), $removeable = true, $force_required = false  ) {
        ?>
        <li class="custom-field website_url">
            <?php self::legend( $label, $values, $removeable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'url' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'website_url' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, '', true, $values, $force_required, 'url' ); ?>
                <?php self::common_text( $field_id, $values ); ?>
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function email_address( $field_id, $label, $values = array(), $removeable = true, $force_required = false  ) {
        ?>
        <li class="custom-field eamil_address">
            <?php self::legend( $label, $values, $removeable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'email' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'email_address' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, '', true, $values, $force_required, 'email' ); ?>
                <?php self::common_text( $field_id, $values ); ?>
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function repeat_field( $field_id, $label, $values = array(), $removeable = true, $force_required = false  ) {
        $tpl = '%s[%d][%s]';

        $enable_column_name = sprintf( '%s[%d][multiple]', 'fes_input', $field_id );
        $column_names = sprintf( '%s[%d][columns]', 'fes_input', $field_id );
        $has_column = ( $values && isset( $values['multiple'] ) ) ? true : false;

        $placeholder_name = sprintf( $tpl, 'fes_input', $field_id, 'placeholder' );
        $default_name = sprintf( $tpl, 'fes_input', $field_id, 'default' );
        $size_name = sprintf( $tpl, 'fes_input', $field_id, 'size' );

        $placeholder_value = $values && isset( $values['placeholder'] ) ? esc_attr( $values['placeholder'] ) : '';
        $default_value = $values && isset( $values['default'] ) ? esc_attr( $values['default'] ) : '';
        $size_value = $values && isset( $values['size'] ) ? esc_attr( $values['size'] ) : '40';

        ?>
        <li class="custom-field custom_repeater">
            <?php self::legend( $label, $values, $removeable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'repeat' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'repeat_field' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, '', true, $values, $force_required, 'repeat' ); ?>

                <div class="fes-form-rows">
                    <label><?php _e( 'Multiple Column', 'edd_fes' ); ?></label>

                    <div class="fes-form-sub-fields">
                        <label><input type="checkbox" class="multicolumn" name="<?php echo htmlentities($enable_column_name,ENT_QUOTES) ?>"<?php echo $has_column ? ' checked="checked"' : ''; ?> value="true"> Enable Multi Column</label>
                    </div>
                </div>

                <div class="fes-form-rows<?php echo $has_column ? ' fes-hide' : ''; ?>">
                    <label><?php _e( 'Placeholder text', 'edd_fes' ); ?></label>
                    <input type="text" class="smallipopInput" name="<?php echo htmlentities($placeholder_name,ENT_QUOTES); ?>" title="text for HTML5 placeholder attribute" value="<?php echo $placeholder_value; ?>" />
                </div> <!-- .fes-form-rows -->

                <div class="fes-form-rows<?php echo $has_column ? ' fes-hide' : ''; ?>">
                    <label><?php _e( 'Default value', 'edd_fes' ); ?></label>
                    <input type="text" class="smallipopInput" name="<?php echo htmlentities($default_name,ENT_QUOTES); ?>" title="the default value this field will have" value="<?php echo $default_value; ?>" />
                </div> <!-- .fes-form-rows -->

                <div class="fes-form-rows">
                    <label><?php _e( 'Size', 'edd_fes' ); ?></label>
                    <input type="text" class="smallipopInput" name="<?php echo htmlentities($size_name,ENT_QUOTES); ?>" title="Size of this input field" value="<?php echo $size_value; ?>" />
                </div> <!-- .fes-form-rows -->

                <div class="fes-form-rows column-names<?php echo $has_column ? '' : ' fes-hide'; ?>">
                    <label><?php _e( 'Columns', 'edd_fes' ); ?></label>

                    <div class="fes-form-sub-fields">
                    <?php

                        if ( $values && $values['columns'] > 0 ) {
                            foreach ($values['columns'] as $key => $value) {
                                ?>
                                <div>
                                    <input type="text" name="<?php echo htmlentities($column_names,ENT_QUOTES); ?>[]" value="<?php echo $value; ?>">

                                    <?php self::remove_button(); ?>
                                </div>
                                <?php
                            }
                        } else {
                        ?>
                            <div>
                                <input type="text" name="<?php echo htmlentities($column_names,ENT_QUOTES); ?>[]" value="">

                                <?php self::remove_button(); ?>
                            </div>
                        <?php
                        }
                    ?>
                    </div>
                </div> <!-- .fes-form-rows -->
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function custom_html( $field_id, $label, $values = array(), $removeable = true, $force_required = false  ) {
        $title_name = sprintf( '%s[%d][label]', 'fes_input', $field_id );
        $html_name = sprintf( '%s[%d][html]', 'fes_input', $field_id );

        $title_value = $values && isset( $values['label'] ) ? esc_attr( $values['label'] ) : '';
        $html_value = $values && isset( $values['html'] ) ? esc_attr( $values['html'] ) : '';
        ?>
        <li class="custom-field custom_html">
            <?php self::legend( $label, $values, $removeable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'html' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'custom_html' ); ?>

            <div class="fes-form-holder">
                <div class="fes-form-rows">
                    <label><?php _e( 'Title', 'edd_fes' ); ?></label>
                    <input type="text" class="smallipopInput" title="Title of the section" name="<?php echo esc_attr($title_name); ?>" value="<?php echo esc_attr( $title_value ); ?>" />
                </div> <!-- .fes-form-rows -->

                <div class="fes-form-rows">
                    <label><?php _e( 'HTML Codes', 'edd_fes' ); ?></label>
                    <textarea class="smallipopInput" title="Paste your HTML codes, WordPress shortcodes will also work here" name="<?php echo  esc_attr($html_name); ?>" rows="10"><?php echo esc_html( $html_value ); ?></textarea>
                </div>
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function custom_hidden_field( $field_id, $label, $values = array(), $removeable = true, $force_required = false  ) {
        $meta_name = sprintf( '%s[%d][name]', 'fes_input', $field_id );
        $value_name = sprintf( '%s[%d][meta_value]', 'fes_input', $field_id );
        $is_meta_name = sprintf( '%s[%d][is_meta]', 'fes_input', $field_id );
        $label_name = sprintf( '%s[%d][label]', 'fes_input', $field_id );

        $meta_value = $values && isset( $values['name'] ) ? esc_attr( $values['name'] ) : '';
        $value_value = $values && isset( $values['meta_value'] ) ? esc_attr( $values['meta_value'] ) : '';
        ?>
        <li class="custom-field custom_hidden_field">
            <?php self::legend( $label, $values, $removeable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'hidden' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'custom_hidden_field' ); ?>

            <div class="fes-form-holder">
                <div class="fes-form-rows">
                    <label><?php _e( 'Meta Key', 'edd_fes' ); ?></label>
                    <input type="text" name="<?php echo esc_attr($meta_name); ?>" value="<?php echo  esc_attr($meta_value); ?>" class="smallipopInput" title="<?php _e( 'Name of the meta key this field will save to', 'edd_fes' ); ?>">
                    <input type="hidden" name="<?php echo esc_attr($is_meta_name); ?>" value="yes">
                    <input type="hidden" name="<?php echo esc_attr($label_name); ?>" value="">
                </div> <!-- .fes-form-rows -->

                <div class="fes-form-rows">
                    <label><?php _e( 'Meta Value', 'edd_fes' ); ?></label>
                    <input type="text" class="smallipopInput" title="<?php esc_attr_e( 'Enter the meta value', 'edd_fes' ); ?>" name="<?php echo esc_attr($value_name); ?>" value="<?php echo esc_attr($value_value); ?>">
                </div>
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function section_break( $field_id, $label, $values = array(), $removeable = true, $force_required = false  ) {
        $title_name = sprintf( '%s[%d][label]', 'fes_input', $field_id );
        $description_name = sprintf( '%s[%d][description]', 'fes_input', $field_id );
        $css_name = sprintf( '%s[%d][css]', 'fes_input', $field_id );

        $title_value = $values && isset( $values['label'] ) ? esc_attr( $values['label'] ) : '';
        $description_value = $values && isset( $values['description'] ) ? esc_attr( $values['description'] ) : '';
        $css_value = $values && isset( $values['css'] ) ? esc_attr( $values['css'] ) : '';
        ?>
        <li class="custom-field custom_html">
            <?php self::legend( $label, $values, $removeable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'section_break' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'section_break' ); ?>

            <div class="fes-form-holder">
                <div class="fes-form-rows">
                    <label><?php _e( 'Title', 'edd_fes' ); ?></label>
                    <input type="text" class="smallipopInput" title="Title of the section" name="<?php echo esc_attr($title_name); ?>" value="<?php echo esc_attr( $title_value ); ?>" />
                </div> <!-- .fes-form-rows -->

                <div class="fes-form-rows">
                    <label><?php _e( 'Description', 'edd_fes' ); ?></label>
                    <textarea class="smallipopInput" title="Some details text about the section" name="<?php echo $description_name; ?>" rows="3"><?php echo esc_html( $description_value ); ?></textarea>
                </div> <!-- .fes-form-rows -->

                <div class="fes-form-rows">
                    <label><?php _e( 'CSS Class Name', 'edd_fes' ); ?></label>
                    <input type="text" name="<?php echo esc_attr($css_name); ?>" value="<?php echo esc_attr($css_value); ?>" class="smallipopInput" title="<?php _e( 'Add a CSS class name for this field', 'edd_fes' ); ?>">
                </div> <!-- .fes-form-rows -->
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }


    public static function recaptcha( $field_id, $label, $values = array(), $removeable = true, $force_required = false  ) {
        $title_name = sprintf( '%s[%d][label]', 'fes_input', $field_id );
        $html_name = sprintf( '%s[%d][html]', 'fes_input', $field_id );

        $title_value = $values && isset( $values['label'] ) ? esc_attr( $values['label'] ) : '';
        $html_value = $values && isset( $values['html'] ) ? esc_attr( $values['html'] ) : '';
        ?>
        <li class="custom-field custom_html">
            <?php self::legend( $label, $values, $removeable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'recaptcha' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'recaptcha' ); ?>

            <div class="fes-form-holder">
                <div class="fes-form-rows">
                    <label><?php _e( 'Title', 'edd_fes' ); ?></label>

                    <div class="fes-form-sub-fields">
                        <input type="text" class="smallipopInput" title="Title of the section" name="<?php echo esc_attr($title_name); ?>" value="<?php echo esc_attr( $title_value ); ?>" />

                        <div class="description" style="margin-top: 8px;">
                            <?php __( "Insert your public key and private key in plugin settings. <a href='https://www.google.com/recaptcha/' target='_blank'>Register</a> first if you don't have any keys.", 'edd_fes' ); ?>
                        </div>
                    </div> <!-- .fes-form-rows -->
                </div>
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }


    public static function action_hook( $field_id, $label, $values = array(), $removeable = true, $force_required = false  ) {
        $title_name = sprintf( '%s[%d][label]', 'fes_input', $field_id );
        $title_value = $values && isset( $values['label'] ) ? esc_attr( $values['label'] ) : '';
        ?>
        <li class="custom-field custom_html">
            <?php self::legend( $label, $values, $removeable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'action_hook' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'action_hook' ); ?>

            <div class="fes-form-holder">
                <div class="fes-form-rows">
                    <label><?php _e( 'Hook Name', 'edd_fes' ); ?></label>

                    <div class="fes-form-sub-fields">
                        <input type="text" class="smallipopInput" title="<?php _e( 'Name of the hook', 'edd_fes' ); ?>" name="<?php echo esc_attr($title_name); ?>" value="<?php echo esc_attr( $title_value ); ?>" />

                        <div class="description" style="margin-top: 8px;">
								<?php _e( "This is for developers to add dynamic elements as they want. It provides the chance to add whatever input type you want to add in this form.", 'edd_fes' ); ?>
                            <?php _e( 'You can bind your own functions to render the form to this action hook. You\'ll be given 3 parameters to play with: $form_id, $post_id, $form_settings.', 'edd_fes' ); ?>
<pre>
add_action('HOOK_NAME', 'your_function_name', 10, 3 );
function your_function_name( $form_id, $post_id, $form_settings ) {
    // do what ever you want
}
</pre>
                        </div>
                    </div> <!-- .fes-form-rows -->
                </div>
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function date_field( $field_id, $label, $values = array(), $removeable = true, $force_required = false  ) {
        $format_name = sprintf('%s[%d][format]', 'fes_input', $field_id);
        $time_name = sprintf('%s[%d][time]', 'fes_input', $field_id);

        $format_value = $values && isset( $values['format'] ) ? $values['format'] : 'dd/mm/yy';
        $time_value = $values && isset( $values['time'] ) ? $values['time'] : 'no';

        $help = esc_attr( __( 'The date format', 'edd_fes' ) );
        ?>
        <li class="custom-field custom_image">
            <?php self::legend( $label, $values, $removeable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'date' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'date_field' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, '', true, $values, $force_required, 'date' ); ?>

                <div class="fes-form-rows">
                    <label><?php _e( 'Date Format', 'edd_fes' ); ?></label>
                    <input type="text" class="smallipopInput" name="<?php echo esc_attr($format_name); ?>" value="<?php echo esc_attr($format_value); ?>" title="<?php echo $help; ?>">
                </div> <!-- .fes-form-rows -->

                <div class="fes-form-rows">
                    <label><?php _e( 'Time', 'edd_fes' ); ?></label>

                    <div class="fes-form-sub-fields">
                        <label>
                            <?php self::hidden_field( "[$field_id][time]", 'no' ); ?>
                            <input type="checkbox" name="<?php echo esc_attr($time_name) ?>" value="yes"<?php checked( $time_value, 'yes' ); ?> />
                            <?php _e( 'Enable time input', 'edd_fes' ); ?>
                        </label>
                    </div>
                </div> <!-- .fes-form-rows -->
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }


    public static function toc( $field_id, $label, $values = array(), $removeable = true, $force_required = false  ) {
        $title_name = sprintf( '%s[%d][label]', 'fes_input', $field_id );
        $description_name = sprintf( '%s[%d][description]', 'fes_input', $field_id );
        $css_name = sprintf( '%s[%d][css]', 'fes_input', $field_id );

        $title_value = $values && isset( $values['label'] ) ? esc_attr( $values['label'] ) : '';
        $description_value = $values && isset( $values['description'] ) ? esc_attr( $values['description'] ) : '';
        $css_value = $values && isset( $values['css'] ) ? esc_attr( $values['css'] ) : '';
        ?>
        <li class="custom-field custom_html">
            <?php self::legend( $label, $values, $removeable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'toc' ); ?>
            <?php self::hidden_field( "[$field_id][name]", 'fes_accept_toc' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'toc' ); ?>

            <div class="fes-form-holder">
                <div class="fes-form-rows">
                    <label><?php _e( 'Label', 'edd_fes' ); ?></label>
                    <input type="text" name="<?php echo esc_attr($title_name); ?>" value="<?php echo esc_attr( $title_value ); ?>" />
                </div> <!-- .fes-form-rows -->

                <div class="fes-form-rows">
                    <label><?php _e( 'Terms & Conditions', 'edd_fes' ); ?></label>
                    <textarea class="smallipopInput" title="<?php _e( 'Insert terms and condtions here.', 'edd_fes'); ?>" name="<?php echo $description_name; ?>" rows="3"><?php echo esc_html( $description_value ); ?></textarea>
                </div> <!-- .fes-form-rows -->

                <div class="fes-form-rows">
                    <label><?php _e( 'CSS Class Name', 'edd_fes' ); ?></label>
                    <input type="text" name="<?php echo esc_attr($css_name); ?>" value="<?php echo esc_attr($css_value); ?>" class="smallipopInput" title="<?php _e( 'Add a CSS class name for this field', 'edd_fes' ); ?>">
                </div> <!-- .fes-form-rows -->
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }
	 public static function post_title( $field_id, $label, $values = array() ) {
        if(!isset($values['label']) || $values['label'] == ''){
			$values['label'] = edd_get_label_singular().' '.$label;
		}
		$values['required'] = $values && isset($values['required']) ? $values['required']  : 'yes';
        $values['label'] = $values && isset($values['label']) ? $values['label']  : '';
        $values['help'] = $values && isset($values['help'])? $values['help']  : '';
        $values['css'] = $values && isset($values['css'])?  $values['css']  : '';
		?>
        <li class="post_title">
            <?php self::legend( $label, $values, false ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'text' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'post_title' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, 'post_title', false, $values, false, 'text' ); ?>
                <?php self::common_text( $field_id, $values ); ?>
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function post_content( $field_id, $label, $values = array() ) {
        if(!isset($values['label']) ||  $values['label'] == ''){
			$values['label'] = edd_get_label_singular().' '.$label;
		}
		$values['required'] = $values && isset($values['required']) ? $values['required']  : 'yes';
        $values['label'] = $values && isset($values['label']) ? $values['label']  : '';
        $values['help'] = $values && isset($values['help'])? $values['help']  : '';
        $values['css'] = $values && isset($values['css'])?  $values['css']  : '';


        $image_insert_name = sprintf( '%s[%d][insert_image]', 'fes_input', $field_id );
        $image_insert_value = isset( $values['insert_image'] ) ? $values['insert_image'] : 'yes';
        ?>
        <li class="post_content">
            <?php self::legend( $label, $values, false ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'textarea' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'post_content' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, 'post_content', false, $values, false, 'textarea' ); ?>
                <?php self::common_textarea( $field_id, $values ); ?>

                <div class="fes-form-rows">
                    <label><?php _e( 'Enable Image Insertion', 'edd_fes' ); ?></label>

                    <div class="fes-form-sub-fields">
                        <label>
                            <?php self::hidden_field( "[$field_id][insert_image]", 'no' ); ?>
                            <input type="checkbox" name="<?php echo esc_attr($image_insert_name) ?>" value="yes"<?php checked( $image_insert_value, 'yes' ); ?> />
                            <?php _e( 'Enable image upload in post area', 'edd_fes' ); ?>
                        </label>
                    </div>
                </div> <!-- .fes-form-rows -->
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function post_excerpt( $field_id, $label, $values = array() ) {
        if(!isset($values['label']) || $values['label'] == ''){
			$values['label'] = edd_get_label_singular().' '.$label;
		}
		?>
        <li class="post_excerpt">
            <?php self::legend( $label, $values); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'textarea' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'post_excerpt' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, 'post_excerpt', false, $values, false, 'textarea'); ?>
                <?php self::common_textarea( $field_id, $values ); ?>
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

	public static function multiple_pricing( $field_id, $label, $values = array() ) {
        if(!isset($values['label']) || $values['label'] == ''){
			$values['label'] = edd_get_label_singular().' '.$label;
		}
        $enable_column_name = sprintf( '%s[%d][multiple]', 'fes_input', $field_id );
        $column_names = sprintf( '%s[%d][columns]', 'fes_input', $field_id );
        $has_column = ( $values && isset( $values['multiple'] ) ) ? true : false;
        $values['has_column'] = $has_column;
		?>
        <li class="multiple_pricing">
            <?php self::legend( $label, $values); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'multiple_pricing' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'multiple_pricing' ); ?>
            <div class="fes-form-holder">
                <?php self::common( $field_id, 'multiple', false, $values, false, 'multiple_pricing' ); ?>
                <?php self::prices_and_files( $field_id, $values ); ?>

            <div class="fes-form-rows">
                    <label><?php _e( 'Set Options', 'edd_fes' ); ?></label>

                    <div class="fes-form-sub-fields">
                        <label><input type="checkbox" class="multicolumn" name="<?php echo esc_attr($enable_column_name); ?>"<?php echo $has_column ? ' checked="checked"' : ''; ?> value="true"> Set Default Names/Prices</label>
                    </div>
                </div>
                <div class="fes-form-rows column-names<?php echo $has_column ? '' : ' fes-hide'; ?>">
                    <label><?php _e( 'Predefined Names/Prices', 'edd_fes' ); ?></label>

                    <div class="fes-form-sub-fields">
                    <?php
                        if ( $values && isset( $values['columns'] ) && $values['columns'] > 0 ) {
                            $keys = count( $values['columns'] );
                            $new_values = array();
                            $key = 0;
                            foreach ( $values['columns'] as $old_key => $value ){
                                if ( $old_key === 0 || $old_key % 2 == 0 ){
                                    $new_values[$key]['name'] = $value['name'];
                                }
                                else{
                                     $new_values[$key]['price'] = $value['price'];
                                     $key++;
                                }
                                unset( $values[$old_key] );
                            }
                            $values['columns'] = $new_values;
                            foreach ( $values['columns'] as $key => $value ) {
                                ?>
                                <div>
                                    <?php _e('Name: ', 'edd_fes'); ?><input type="text" name="<?php echo esc_attr($column_names); ?>[][name]" value="<?php echo esc_attr($value['name']); ?>">
                                    <?php _e('Price: ', 'edd_fes'); ?><input type="text" name="<?php echo esc_attr($column_names); ?>[][price]" value="<?php echo esc_attr($value['price']); ?>">
                                    <?php self::remove_button(); ?>
                                </div>
                                <?php
                            }
                        } else {
                        ?>
                            <div>
                                <?php _e('Name: ', 'edd_fes'); ?><input type="text" name="<?php echo esc_attr($column_names); ?>[][name]" value="">
                                <?php _e('Price: ', 'edd_fes'); ?><input type="text" name="<?php echo esc_attr($column_names); ?>[][price]" value="">
                                <?php self::remove_button(); ?>
                            </div>
                        <?php
                        }
                    ?>
                    </div>
                </div> <!-- .fes-form-rows -->
                </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function featured_image( $field_id, $label, $values = array() ) {
		 if(!isset($values['label']) || $values['label'] == ''){
			$values['label'] = edd_get_label_singular().' '.$label;
		}
        ?>
        <li class="featured_image">
            <?php self::legend( $label, $values); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'image_upload' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'featured_image' ); ?>
            <?php self::hidden_field( "[$field_id][count]", '1' ); ?>
            <div class="fes-form-holder">
                <?php self::common( $field_id, 'featured_image', false, $values, false, 'image_upload' ); ?>
            </div> <!-- .fes-form-holder -->

        </li>
        <?php
    }

    public static function taxonomy( $field_id, $label, $taxonomy = '', $values = array() ) {
        $type_name = sprintf( '%s[%d][type]', 'fes_input', $field_id );
        $order_name = sprintf( '%s[%d][order]', 'fes_input', $field_id );
        $orderby_name = sprintf( '%s[%d][orderby]', 'fes_input', $field_id );
        $exclude_type_name = sprintf( '%s[%d][exclude_type]', 'fes_input', $field_id );
        $exclude_name = sprintf( '%s[%d][exclude]', 'fes_input', $field_id );

        $type_value = $values  && isset($values['type'])? esc_attr( $values['type'] ) : 'select';
        $order_value = $values && isset($values['order'])? esc_attr( $values['order'] ) : 'ASC';
        $orderby_value = $values && isset($values['orderby'] )? esc_attr( $values['orderby'] ) : 'name';
        $exclude_type_value = $values && isset( $values['exclude_type'] )? esc_attr( $values['exclude_type'] ) : 'exclude';
        $exclude_value = $values && isset($values['exclude'] )? esc_attr( $values['exclude'] ) : '';
        if(!isset($values['label']) || $values['label'] == ''){
			$values['label'] = edd_get_label_singular().' '.$label;
		}
        ?>
        <li class="taxonomy <?php echo $taxonomy; ?>">
            <?php self::legend( $label, $values ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'taxonomy' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'taxonomy' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, $taxonomy, false, $values, false, 'taxonomy' ); ?>

                <div class="fes-form-rows">
                    <label><?php _e( 'Type', 'edd_fes' ); ?></label>
                    <select name="<?php echo esc_attr($type_name); ?>">
                        <option value="select"<?php selected( $type_value, 'select' ); ?>><?php _e( 'Dropdown', 'edd_fes' ); ?></option>
                        <option value="multiselect"<?php selected( $type_value, 'multiselect' ); ?>><?php _e( 'Multi Select', 'edd_fes' ); ?></option>
                        <option value="checkbox"<?php selected( $type_value, 'checkbox' ); ?>><?php _e( 'Checkbox', 'edd_fes' ); ?></option>
                        <option value="text"<?php selected( $type_value, 'text' ); ?>><?php _e( 'Text Input', 'edd_fes' ); ?></option>
                    </select>
                </div> <!-- .fes-form-rows -->

                <div class="fes-form-rows">
                    <label><?php _e( 'Order By', 'edd_fes' ); ?></label>
                    <select name="<?php echo esc_attr($orderby_name); ?>">
                        <option value="name"<?php selected( $orderby_value, 'name' ); ?>><?php _e( 'Name', 'edd_fes' ); ?></option>
                        <option value="id"<?php selected( $orderby_value, 'id' ); ?>><?php _e( 'Term ID', 'edd_fes' ); ?></option>
                        <option value="slug"<?php selected( $orderby_value, 'slug' ); ?>><?php _e( 'Slug', 'edd_fes' ); ?></option>
                        <option value="count"<?php selected( $orderby_value, 'count' ); ?>><?php _e( 'Count', 'edd_fes' ); ?></option>
                        <option value="term_group"<?php selected( $orderby_value, 'term_group' ); ?>><?php _e( 'Term Group', 'edd_fes' ); ?></option>
                    </select>
                </div> <!-- .fes-form-rows -->

                <div class="fes-form-rows">
                    <label><?php _e( 'Order', 'edd_fes' ); ?></label>
                    <select name="<?php echo esc_attr($order_name) ?>">
                        <option value="ASC"<?php selected( $order_value, 'ASC' ); ?>><?php _e( 'ASC', 'edd_fes' ); ?></option>
                        <option value="DESC"<?php selected( $order_value, 'DESC' ); ?>><?php _e( 'DESC', 'edd_fes' ); ?></option>
                    </select>
                </div> <!-- .fes-form-rows -->

                <div class="fes-form-rows">
                    <label><?php _e( 'Selection Type', 'edd_fes' ); ?></label>
                    <select name="<?php echo esc_attr($exclude_type_name) ?>">
                        <option value="exclude"<?php selected( $exclude_type_value, 'exclude' ); ?>><?php _e( 'Exclude', 'edd_fes' ); ?></option>
                        <option value="include"<?php selected( $exclude_type_value, 'include' ); ?>><?php _e( 'Include', 'edd_fes' ); ?></option>
                        <option value="child_of"<?php selected( $exclude_type_value, 'child_of' ); ?>><?php _e( 'Child of', 'edd_fes' ); ?></option>
                    </select>
                </div> <!-- .fes-form-rows -->

                <div class="fes-form-rows">
                    <label><?php _e( 'Selection terms', 'edd_fes' ); ?></label>
                    <input type="text" class="smallipopInput" name="<?php echo esc_attr($exclude_name); ?>" title="<?php _e( 'Enter the term IDs as comma separated (without space) to exclude/include in the form.', 'edd_fes' ); ?>" value="<?php echo $exclude_value; ?>" />
                </div> <!-- .fes-form-rows -->

            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function user_login( $field_id, $label, $values = array() ) {
        global $post;
		if(!isset($values['label']) || $values['label'] == ''){
			$values['label'] = $label;
		}
        $force_required = false;
        $removable = true;
        if ( is_object( $post ) && get_the_ID() == EDD_FES()->helper->get_option( 'fes-registration-form', false )  ) {
            $force_required = true;
            $removable = false;
        }
        $values['show_placeholder'] = false;
        $values['default_value'] = false;
        $minus_label = $values;
        unset($minus_label['label']);
        ?>
        <li class="user_login">
            <?php self::legend( $label, $minus_label, $removable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'text' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'user_login' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, 'user_login', false, $values, $force_required, 'text' ); ?>
                <?php self::common_text( $field_id, $values ); ?>
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function first_name( $field_id, $label, $values = array() ) {
        global $post;
	    if(!isset($values['label']) || $values['label'] == ''){
			$values['label'] = $label;
		}
        $force_required = false;
        $removable = true;
        if ( is_object( $post ) && get_the_ID() == EDD_FES()->helper->get_option( 'fes-registration-form', false ) ) {
            $force_required = true;
            $removable = false;
        }
        $values['show_placeholder'] = false;
        $values['default_value'] = false;
        $minus_label = $values;
        unset($minus_label['label']);
        ?>
        <li class="first_name">
            <?php self::legend( $label, $minus_label, $removable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'text' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'first_name' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, 'first_name', false, $values, $force_required, 'text' ); ?>
                <?php self::common_text( $field_id, $values ); ?>
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function last_name( $field_id, $label, $values = array() ) {
        global $post;
		if(!isset($values['label']) || $values['label'] == ''){
			$values['label'] = $label;
		}
        $force_required = false;
        $removable = true;
        if ( is_object( $post ) && get_the_ID() == EDD_FES()->helper->get_option( 'fes-registration-form', false ) ) {
            $force_required = true;
            $removable = false;
        }
        $values['show_placeholder'] = false;
        $values['default_value'] = false;
        $minus_label = $values;
        unset($minus_label['label']);
        ?>
        <li class="last_name">
            <?php self::legend( $label, $minus_label, $removable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'text' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'last_name' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, 'last_name', false, $values, $force_required, 'text' ); ?>
                <?php self::common_text( $field_id, $values ); ?>
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function nickname( $field_id, $label, $values = array() ) {
		if(!isset($values['label']) || $values['label'] == ''){
			$values['label'] = $label;
		}
        $values['show_placeholder'] = false;
        $values['default_value'] = false;
        $minus_label = $values;
        unset($minus_label['label']);
        ?>
        <li class="nickname">
            <?php self::legend( $label, $minus_label ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'text' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'nickname' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, 'nickname', false, $values, false, 'text' ); ?>
                <?php self::common_text( $field_id, $values ); ?>
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function display_name( $field_id, $label, $values = array() ) {
        global $post;
		if(!isset($values['label']) || $values['label'] == ''){
			$values['label'] = $label;
		}
        $force_required = false;
        $removable = true;
        if ( is_object( $post ) &&  get_the_ID() == EDD_FES()->helper->get_option( 'fes-registration-form', false ) ) {
            $force_required = true;
            $removable = false;
        }
        $values['show_placeholder'] = false;
        $values['default_value'] = false;
        $minus_label = $values;
        unset($minus_label['label']);
        ?>
        <li class="display_name">
            <?php self::legend( $label, $minus_label, $removable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'text' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'display_name' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, 'display_name', false, $values, $force_required, 'text' ); ?>
                <?php self::common_text( $field_id, $values ); ?>
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function user_email( $field_id, $label, $values = array() ) {
        global $post;
		if(!isset($values['label']) || $values['label'] == ''){
			$values['label'] = $label;
		}
        $force_required = false;
        $removable = true;
        if ( is_object( $post ) && get_the_ID() == EDD_FES()->helper->get_option( 'fes-registration-form', false ) ) {
            $force_required = true;
            $removable = false;
        }
        $values['show_placeholder'] = false;
        $values['default_value'] = false;
        $minus_label = $values;
        unset($minus_label['label']);
        if( $force_required ){
        ?>
        <style>.fes-form-editor li.user_email .required-field { display: none; }</style>
        <?php } ?>
        <li class="user_email">
            <?php self::legend( $label, $minus_label, $removable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'email' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'user_email' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, 'user_email', false, $values, $force_required, 'email' ); ?>
                <?php self::common_text( $field_id, $values ); ?>
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function user_url( $field_id, $label, $values = array() ) {
		if(!isset($values['label']) || $values['label'] == ''){
			$values['label'] = $label;
		}
        ?>
        <li class="user_url">
            <?php self::legend( $label, $values ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'url' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'user_url' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, 'user_url', false, $values, false, 'url' ); ?>
                <?php self::common_text( $field_id, $values ); ?>
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function description( $field_id, $label, $values = array() ) {
		if(!isset($values['label']) || $values['label'] == ''){
			$values['label'] = $label;
		}
        ?>
        <li class="user_bio">
            <?php self::legend( $label, $values ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'textarea' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'description' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, 'description', false, $values, false, 'textarea' ); ?>
                <?php self::common_textarea( $field_id, $values ); ?>
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function password( $field_id, $label, $values = array() ) {
        global $post;
		if(!isset($values['label']) || $values['label'] == ''){
			$values['label'] = $label;
		}

        $force_required = false;
        $removable = true;
        if ( is_object( $post ) && get_the_ID() == EDD_FES()->helper->get_option( 'fes-registration-form', false ) ) {
            $force_required = true;
            $removable = false;
        }
        $values['show_placeholder'] = false;
        $values['default_value'] = false;
        $minus_label = $values;
        unset($minus_label['label']);
        $min_length_name = sprintf( '%s[%d][min_length]', 'fes_input', $field_id );
        $pass_repeat_name = sprintf( '%s[%d][repeat_pass]', 'fes_input', $field_id );
        $re_pass_label = sprintf( '%s[%d][re_pass_label]', 'fes_input', $field_id );

        $min_length_value = isset( $values['min_length'] ) ? $values['min_length'] : '6';
        $pass_repeat_value = isset( $values['repeat_pass'] ) ? $values['repeat_pass'] : 'yes';
        $re_pass_label_value = isset( $values['re_pass_label'] ) ? $values['re_pass_label'] : __( 'Confirm Password', 'edd_fes' );
        if( $force_required ){ ?>
        <style>.fes-form-editor li.password .required-field { display: none; } </style>
        <?php } ?>
        <li class="password">
            <?php self::legend( $label, $minus_label, $removable ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'password' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'password' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, 'password', false, $values, $force_required, 'password' ); ?>

                <div class="fes-form-rows">
                    <label><?php _e( 'Minimum password length', 'edd_fes' ); ?></label>

                    <input type="text" name="<?php echo esc_attr($min_length_name) ?>" value="<?php echo esc_attr( $min_length_value ); ?>" />
                </div> <!-- .fes-form-rows -->

                <div class="fes-form-rows">
                    <label><?php _e( 'Password Re-type', 'edd_fes' ); ?></label>

                    <div class="fes-form-sub-fields">
                        <label>
                            <?php self::hidden_field( "[$field_id][repeat_pass]", 'no' ); ?>
                            <input class="retype-pass" type="checkbox" name="<?php echo esc_attr($pass_repeat_name) ?>" value="yes"<?php checked( $pass_repeat_value, 'yes' ); ?> />
                            <?php _e( 'Require Password repeat', 'edd_fes' ); ?>
                        </label>
                    </div>
                </div> <!-- .fes-form-rows -->

                <div class="fes-form-rows<?php echo $pass_repeat_value != 'yes' ? ' fes-hide' : ''; ?>">
                    <label><?php _e( 'Re-type password label', 'edd_fes' ); ?></label>

                    <input type="text" name="<?php echo esc_attr($re_pass_label); ?>" value="<?php echo esc_attr( $re_pass_label_value ); ?>" />
                </div> <!-- .fes-form-rows -->
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }

    public static function eddc_user_paypal( $field_id, $label, $values = array() ) {
		if(!isset($values['label']) || $values['label'] == ''){
			$values['label'] = $label;
		}
		$values['is_meta'] = true;
		$values['name'] = 'eddc_user_paypal';
        ?>
        <li class="eddc_user_paypal">
            <?php self::legend( $label, $values ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'email' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'eddc_user_paypal' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, 'eddc_user_paypal', true, $values, false, 'email' ); ?>
                <?php self::common_text( $field_id, $values ); ?>
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }
    public static function avatar( $field_id, $label, $values = array() ) {
		if(!isset($values['label']) || $values['label'] == ''){
			$values['label'] = $label;
		}
        ?>
        <li class="user_avatar">
            <?php self::legend( $label, $values ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'image_upload' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'avatar' ); ?>
            <?php self::hidden_field( "[$field_id][count]", '1' ); ?>

            <div class="fes-form-holder">
                <?php self::common( $field_id, 'avatar', false, $values, false, 'image_upload' ); ?>
            </div> <!-- .fes-form-holder -->
        </li>
        <?php
    }
}