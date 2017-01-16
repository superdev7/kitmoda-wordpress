<?php
if (!defined('ABSPATH')) {
  exit;
}

add_filter('post_updated_messages', 'fes_forms_form_updated_message');
add_action('add_meta_boxes_fes-forms', 'fes_forms_add_meta_boxes');
add_action('wp_ajax_fes-form_add_el', 'fes_forms_ajax_post_add_field');
add_action('save_post', 'fes_forms_save_form', 1, 2);

function fes_forms_form_updated_message($messages) {
  $message = array(
    0 => '',
    1 => __('Form updated.', 'edd_fes') ,
    2 => __('Custom field updated.', 'edd_fes') ,
    3 => __('Custom field deleted.', 'edd_fes') ,
    4 => __('Form updated.', 'edd_fes') ,
    5 => isset($_GET['revision']) ? sprintf(__('Form restored to revision from %s', 'edd_fes') , wp_post_revision_title((int)$_GET['revision'], false)) : false,
    6 => __('Form published.', 'edd_fes') ,
    7 => __('Form saved.', 'edd_fes') ,
    8 => __('Form submitted.', 'edd_fes') ,
    9 => '',
    10 => __('Form draft updated.', 'edd_fes') ,
  );
  $messages['fes-forms'] = $message;
  return $messages;
}

function fes_forms_add_meta_boxes() {
  global $post;
  if (get_the_ID() == EDD_FES()->helper->get_option( 'fes-submission-form', false ) )  {
    add_meta_box('fes-metabox-editor', __('Submission Form Editor', 'edd_fes') , 'fes_forms_metabox', 'fes-forms', 'normal', 'high');
    add_meta_box('fes-metabox-save', __('Save', 'edd_fes') , 'fes_forms_form_elements_save', 'fes-forms', 'side', 'core');
    add_meta_box('fes-metabox-fields', __('Add a Field', 'edd_fes') , 'fes_forms_form_elements_post', 'fes-forms', 'side', 'core');
  }
  if (get_the_ID() == EDD_FES()->helper->get_option( 'fes-profile-form', false ) ) {
    add_meta_box('fes-metabox-editor', __('Profile Form Editor', 'edd_fes') , 'fes_forms_metabox', 'fes-forms', 'normal', 'high');
    add_meta_box('fes-metabox-save', __('Save', 'edd_fes') , 'fes_forms_form_elements_save', 'fes-forms', 'side', 'core');
    add_meta_box('fes-metabox-fields', __('Add a Field', 'edd_fes') , 'fes_forms_form_elements_profile', 'fes-forms', 'side', 'core');
  }
  if (get_the_ID() == EDD_FES()->helper->get_option( 'fes-registration-form', false ) ) {
    add_meta_box('fes-metabox-editor', __('Registration Form Editor', 'edd_fes') , 'fes_forms_metabox', 'fes-forms', 'normal', 'high');
    add_meta_box('fes-metabox-save', __('Save', 'edd_fes') , 'fes_forms_form_elements_save', 'fes-forms', 'side', 'core');
    add_meta_box('fes-metabox-fields', __('Add a Field', 'edd_fes') , 'fes_forms_form_elements_registration', 'fes-forms', 'side', 'core');
  } else {
    do_action('fes_add_meta_boxes', get_the_ID());
  }
  do_action('fes_add_custom_meta_boxes', get_the_ID());
  remove_meta_box('submitdiv', 'fes-forms', 'side');
  remove_meta_box('slugdiv', 'fes-forms', 'normal');
}

function fes_forms_publish_button() {
  global $post, $pagenow;
  ?>
    <div id="minor-publishing-actions">
      <center>
      <input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e('Save') ?>" />
      <input name="save" type="submit" class="button button-primary button-large" id="publish" accesskey="p" value="<?php esc_attr_e('Save') ?>" />
      <span class="spinner"></span>
      </center>
    </div>
    <div class="fes-clear"></div>
  <?php
}

function fes_forms_metabox($post) {
  if (get_the_ID() == EDD_FES()->helper->get_option( 'fes-submission-form', false )  ) {
    $title = __('FES Submission Form Editor', 'edd_fes');
  } else if (get_the_ID() == EDD_FES()->helper->get_option( 'fes-profile-form', false ) ) {
    $title = __('FES Profile Form Editor', 'edd_fes');
  } else {
    $title = __('FES Registration Form Editor', 'edd_fes');
  }
  $title = apply_filters('fes_forms_metabox_title', $title, get_the_ID());
  ?>
  <h1><?php echo $title; ?></h1>
  <div class="tab-content">
      <div id="fes-metabox" class="group">
           <?php fes_forms_edit_form_area(); ?>
      </div>
  </div>
  <?php
}

function fes_forms_form_elements_post() {
  $title = esc_attr(__('Click to add to the editor', 'edd_fes'));
  ?>
  <div class="fes-form-buttons">
  <button class="fes-button button" data-name="post_title" data-type="post_title" title="<?php echo $title; ?>"><?php _e('Title', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="post_content" data-type="post_content" title="<?php echo $title; ?>"><?php _e('Description', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="featured_image" data-type="featured_image" title="<?php echo $title; ?>"><?php _e('Featured Image', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="download_category" data-type="download_category" title="<?php echo $title; ?>"><?php _e('Categories', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="download_tag" data-type="download_tag" title="<?php echo $title; ?>"><?php _e('Tags', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="multiple_pricing" data-type="multiple_pricing" title="<?php echo $title; ?>"><?php _e('Prices and Files', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="post_excerpt" data-type="post_excerpt" title="<?php echo $title; ?>"><?php _e('Excerpt', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="custom_text" data-type="text" title="<?php echo $title; ?>"><?php _e('Text', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_textarea" data-type="textarea" title="<?php echo $title; ?>"><?php _e('Textarea', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="custom_select" data-type="select" title="<?php echo $title; ?>"><?php _e('Dropdown', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_date" data-type="date" title="<?php echo $title; ?>"><?php _e('Date', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="custom_multiselect" data-type="multiselect" title="<?php echo $title; ?>"><?php _e('Multi Select', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_radio" data-type="radio" title="<?php echo $title; ?>"><?php _e('Radio', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="custom_checkbox" data-type="checkbox" title="<?php echo $title; ?>"><?php _e('Checkbox', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_file" data-type="file" title="<?php echo $title; ?>"><?php _e('File Upload', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="custom_url" data-type="url" title="<?php echo $title; ?>"><?php _e('URL', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_email" data-type="email" title="<?php echo $title; ?>"><?php _e('Email', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="custom_repeater" data-type="repeat" title="<?php echo $title; ?>"><?php _e('Repeat Field', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_hidden" data-type="hidden" title="<?php echo $title; ?>"><?php _e('Hidden Field', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="recaptcha" data-type="captcha" title="<?php echo $title; ?>"><?php _e('Captcha', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="section_break" data-type="break" title="<?php echo $title; ?>"><?php _e('Section Break', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="custom_html" data-type="html" title="<?php echo $title; ?>"><?php _e('HTML', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="action_hook" data-type="action" title="<?php echo $title; ?>"><?php _e('Do Action', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="toc" data-type="action" title="<?php echo $title; ?>"><?php _e('Accept Terms', 'edd_fes'); ?></button>
  <?php
  do_action('fes_custom_post_button', $title); ?>
  </div>
  <?php
}

function fes_forms_form_elements_profile() {
  $title = esc_attr(__('Click to add to the editor', 'edd_fes'));
  ?>
  <div class="fes-form-buttons">
  <button class="fes-button button" data-name="first_name" data-type="textarea" title="<?php echo $title; ?>"><?php _e('First Name', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="last_name" data-type="textarea" title="<?php echo $title; ?>"><?php _e('Last Name', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="user_login" data-type="text" title="<?php echo $title; ?>"><?php _e('Username', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="password" data-type="password" title="<?php echo $title; ?>"><?php _e('Password', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="user_email" data-type="category" title="<?php echo $title; ?>"><?php _e('User E-mail', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="nickname" data-type="text" title="<?php echo $title; ?>"><?php _e('Nickname', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="display_name" data-type="text" title="<?php echo $title; ?>"><?php _e('Display Name', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="user_bio" data-type="textarea" title="<?php echo $title; ?>"><?php _e('Biography', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="user_url" data-type="text" title="<?php echo $title; ?>"><?php _e('Website', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="custom_url" data-type="url" title="<?php echo $title; ?>"><?php _e('URL', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_text" data-type="text" title="<?php echo $title; ?>"><?php _e('Text', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="custom_textarea" data-type="textarea" title="<?php echo $title; ?>"><?php _e('Textarea', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_select" data-type="select" title="<?php echo $title; ?>"><?php _e('Dropdown', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="custom_multiselect" data-type="multiselect" title="<?php echo $title; ?>"><?php _e('Multi Select', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_date" data-type="date" title="<?php echo $title; ?>"><?php _e('Date', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="custom_radio" data-type="radio" title="<?php echo $title; ?>"><?php _e('Radio', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_checkbox" data-type="checkbox" title="<?php echo $title; ?>"><?php _e('Checkbox', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="custom_repeater" data-type="repeat" title="<?php echo $title; ?>"><?php _e('Repeat Field', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_file" data-type="file" title="<?php echo $title; ?>"><?php _e('File Upload', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="custom_email" data-type="email" title="<?php echo $title; ?>"><?php _e('Email', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_hidden" data-type="hidden" title="<?php echo $title; ?>"><?php _e('Hidden Field', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="recaptcha" data-type="captcha" title="<?php echo $title; ?>"><?php _e('Captcha', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="toc" data-type="action" title="<?php echo $title; ?>"><?php _e('Accept Terms', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="section_break" data-type="break" title="<?php echo $title; ?>"><?php _e('Section Break', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_html" data-type="html" title="<?php echo $title; ?>"><?php _e('HTML', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="action_hook" data-type="action" title="<?php echo $title; ?>"><?php _e('Do Action', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="user_avatar" data-type="avatar" title="<?php echo $title; ?>"><?php _e('Avatar', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="custom_country" data-type="action" title="<?php echo $title; ?>"><?php _e('Country', 'edd_fes'); ?></button>
  <?php
  if (EDD_FES()->integrations->is_commissions_active()) { ?>
    <button class="fes-button button" data-name="eddc_user_paypal" data-type="eddc_user_paypal"><?php _e('PayPal Email', 'edd_fes'); ?></button>
 <?php
  }
  do_action('fes_custom_profile_button'); ?>
  </div>
  <?php
}

function fes_forms_form_elements_save() {
  ?>
  <div class="submitbox" id="submitpost">
    <div id="minor-publishing">
      <?php fes_forms_publish_button(); ?>
    </div>
  </div>
  <?php
}

function fes_forms_form_elements_registration() {
  $title = esc_attr(__('Click to add to the editor', 'edd_fes'));
  ?>
  <div class="fes-loading hide"></div>
  <div class="fes-form-buttons">
  <button class="fes-button button" data-name="nickname" data-type="text" title="<?php echo $title; ?>"><?php _e('Nickname', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="user_bio" data-type="textarea" title="<?php echo $title; ?>"><?php _e('Biography', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="user_url" data-type="text" title="<?php echo $title; ?>"><?php _e('Website', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="custom_url" data-type="url" title="<?php echo $title; ?>"><?php _e('URL', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_text" data-type="text" title="<?php echo $title; ?>"><?php _e('Text', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="custom_textarea" data-type="textarea" title="<?php echo $title; ?>"><?php _e('Textarea', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_select" data-type="select" title="<?php echo $title; ?>"><?php _e('Dropdown', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="custom_multiselect" data-type="multiselect" title="<?php echo $title; ?>"><?php _e('Multi Select', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_date" data-type="date" title="<?php echo $title; ?>"><?php _e('Date', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="custom_radio" data-type="radio" title="<?php echo $title; ?>"><?php _e('Radio', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_checkbox" data-type="checkbox" title="<?php echo $title; ?>"><?php _e('Checkbox', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="custom_repeater" data-type="repeat" title="<?php echo $title; ?>"><?php _e('Repeat Field', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_email" data-type="email" title="<?php echo $title; ?>"><?php _e('Email', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_hidden" data-type="hidden" title="<?php echo $title; ?>"><?php _e('Hidden Field', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="recaptcha" data-type="captcha" title="<?php echo $title; ?>"><?php _e('Captcha', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="toc" data-type="action" title="<?php echo $title; ?>"><?php _e('Accept Terms', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="section_break" data-type="break" title="<?php echo $title; ?>"><?php _e('Section Break', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_html" data-type="html" title="<?php echo $title; ?>"><?php _e('HTML', 'edd_fes'); ?></button>
  <button class="fes-button button" data-name="action_hook" data-type="action" title="<?php echo $title; ?>"><?php _e('Do Action', 'edd_fes'); ?></button><br />
  <button class="fes-button button" data-name="custom_country" data-type="country" title="<?php echo $title; ?>"><?php _e('Country', 'edd_fes'); ?></button>
  <?php
  if (EDD_FES()->integrations->is_commissions_active()) { ?>
    <button class="fes-button button" data-name="eddc_user_paypal" data-type="eddc_user_paypal"><?php _e('PayPal Email', 'edd_fes'); ?></button><br />
    <button class="fes-button button" data-name="toc" data-type="action" title="<?php echo $title; ?>"><?php _e('Accept Terms', 'edd_fes'); ?></button>
  <?php
  } else { ?>
      <button class="fes-button button" data-name="toc" data-type="action" title="<?php echo $title; ?>"><?php _e('Accept Terms', 'edd_fes'); ?></button><br />
      <?php
  }
  do_action('fes_custom_registration_button'); ?>
  </div>
  <?php
}

function fes_forms_save_form($post_id, $post) {
  if (!isset($_POST['fes-form-editor'])) {
    return $post->ID;
  }
  
  if (!wp_verify_nonce($_POST['fes-form-editor'], 'fes-form-editor')) {
    return $post->ID;
  }
  // Is the user allowed to edit the post or page?
  if (!current_user_can('edit_post', $post->ID)) {
    return $post->ID;
  }
  
  update_post_meta($post->ID, 'fes-form', $_POST['fes_input']);
}

function fes_forms_edit_form_area() {
  global $post, $pagenow;
  if (get_the_ID() == EDD_FES()->helper->get_option( 'fes-submission-form', false ) ) {
    $form = __('Your submission form has no fields', 'edd_fes');
  } else if (get_the_ID() == EDD_FES()->helper->get_option( 'fes-profile-form', false ) ) {
    $form = __('Your profile form has no fields', 'edd_fes');
  } else {
    $form = __('Your registration form has no fields', 'edd_fes');
  }
  $form = apply_filters('fes_edit_form_area_no_fields', $form, get_the_ID());
  $form_inputs = get_post_meta($post->ID, 'fes-form', true);
?>

  <input type="hidden" name="fes-form-editor" id="fes-form-editor" value="<?php echo wp_create_nonce("fes-form-editor"); ?>" />
  <div style="margin-bottom: 10px">
    <button class="button fes-collapse"><?php _e('Toggle All Fields Open/Close', 'edd_fes'); ?></button>
  </div>
  
  <?php
  if (empty($form_inputs)) { ?>
    <div class="fes-updated">
      <p><?php echo $form; ?></p>
    </div>
    <?php
  } ?>
  
  <ul id="fes-form-editor" class="fes-form-editor unstyled">

  <?php
  if ($form_inputs) {
    $count = 0;
    foreach ($form_inputs as $order => $input_field) {
      $name = ucwords(str_replace('_', ' ', $input_field['template']));
      $is_custom = apply_filters( 'fes_formbuilder_custom_field', false, $input_field );
      if ( $is_custom ){
         $name = $input_field['input_type'];
         do_action('fes_admin_field_' . $name, $count, $name, $input_field );
         $count++;
      } else if ($input_field['input_type'] == 'really_simple_captcha' || $input_field['input_type'] == 'google_map') {
        continue;
      } else if ($input_field['template'] == 'taxonomy') {
        FES_Formbuilder_Templates::$input_field['template']($count, $name, $input_field['name'], $input_field);
        $count++;
      } else {
        FES_Formbuilder_Templates::$input_field['template']($count, $name, $input_field);
        $count++;
      }
    }
  } 
  ?>
  </ul>
  <?php
}
function fes_forms_ajax_post_add_field() {
  
  $name = $_POST['name'];
  $type = $_POST['type'];
  $field_id = $_POST['order'];
  
  switch ($name) {
    case 'post_title':
      FES_Formbuilder_Templates::post_title($field_id, __('Title', 'edd_fes'));
      break;

    case 'post_content':
      FES_Formbuilder_Templates::post_content($field_id, __('Body', 'edd_fes'));
      break;

    case 'post_excerpt':
      FES_Formbuilder_Templates::post_excerpt($field_id, __('Excerpt', 'edd_fes'));
      break;

    case 'featured_image':
      FES_Formbuilder_Templates::featured_image($field_id, __('Featured Image', 'edd_fes'));
      break;

    case 'download_category':
      FES_Formbuilder_Templates::taxonomy($field_id, 'Category', __('download_category', 'edd_fes'));
      break;

    case 'download_tag':
      FES_Formbuilder_Templates::taxonomy($field_id, 'Tags', __('download_tag', 'edd_fes'));
      break;

    case 'multiple_pricing':
      FES_Formbuilder_Templates::multiple_pricing($field_id, __('Prices and Files', 'edd_fes'));
      break;

    case 'custom_text':
      FES_Formbuilder_Templates::text_field($field_id, __('Custom field: Text', 'edd_fes'));
      break;

    case 'custom_textarea':
      FES_Formbuilder_Templates::textarea_field($field_id, __('Custom field: Textarea', 'edd_fes'));
      break;

    case 'custom_select':
      FES_Formbuilder_Templates::dropdown_field($field_id, __('Custom field: Select', 'edd_fes'));
      break;

    case 'custom_multiselect':
      FES_Formbuilder_Templates::multiple_select($field_id, __('Custom field: Multiselect', 'edd_fes'));
      break;

    case 'custom_radio':
      FES_Formbuilder_Templates::radio_field($field_id, __('Custom field: Radio', 'edd_fes'));
      break;

    case 'custom_checkbox':
      FES_Formbuilder_Templates::checkbox_field($field_id, __('Custom field: Checkbox', 'edd_fes'));
      break;

    case 'custom_file':
      FES_Formbuilder_Templates::file_upload($field_id, __('Custom field: File Upload', 'edd_fes'));
      break;

    case 'custom_url':
      FES_Formbuilder_Templates::website_url($field_id, __('Custom field: URL', 'edd_fes'));
      break;

    case 'custom_email':
      FES_Formbuilder_Templates::email_address($field_id, __('Custom field: E-Mail', 'edd_fes'));
      break;

    case 'custom_repeater':
      FES_Formbuilder_Templates::repeat_field($field_id, __('Custom field: Repeat Field', 'edd_fes'));
      break;

    case 'custom_html':
      FES_Formbuilder_Templates::custom_html($field_id, __('HTML', 'edd_fes'));
      break;

    case 'section_break':
      FES_Formbuilder_Templates::section_break($field_id, __('Section Break', 'edd_fes'));
      break;

    case 'action_hook':
      FES_Formbuilder_Templates::action_hook($field_id, __('Action Hook', 'edd_fes'));
      break;

    case 'user_avatar':
      FES_Formbuilder_Templates::avatar($field_id, __('Avatar', 'edd_fes'));
      break;

    case 'recaptcha':
      FES_Formbuilder_Templates::recaptcha($field_id, __('reCaptcha', 'edd_fes'));
      break;

    case 'custom_date':
      FES_Formbuilder_Templates::date_field($field_id, __('Custom Field: Date', 'edd_fes'));
      break;

    case 'custom_hidden':
      FES_Formbuilder_Templates::custom_hidden_field($field_id, __('Hidden Field', 'edd_fes'));
      break;

    case 'custom_country':
      FES_Formbuilder_Templates::country($field_id, __('Country', 'edd_fes'));
      break;

    case 'toc':
      FES_Formbuilder_Templates::toc($field_id, 'TOC');
      break;

    case 'user_login':
      FES_Formbuilder_Templates::user_login($field_id, __('Username', 'edd_fes'));
      break;

    case 'first_name':
      FES_Formbuilder_Templates::first_name($field_id, __('First Name', 'edd_fes'));
      break;

    case 'last_name':
      FES_Formbuilder_Templates::last_name($field_id, __('Last Name', 'edd_fes'));
      break;

    case 'nickname':
      FES_Formbuilder_Templates::nickname($field_id, __('Nickname', 'edd_fes'));
      break;

    case 'display_name':
      FES_Formbuilder_Templates::display_name($field_id, __('Display Name', 'edd_fes'));
      break;

    case 'user_email':
      FES_Formbuilder_Templates::user_email($field_id, __('E-mail', 'edd_fes'));
      break;

    case 'user_url':
      FES_Formbuilder_Templates::user_url($field_id, __('Website', 'edd_fes'));
      break;

    case 'user_bio':
      FES_Formbuilder_Templates::description($field_id, __('Biographical Info', 'edd_fes'));
      break;

    case 'password':
      FES_Formbuilder_Templates::password($field_id, __('Password', 'edd_fes'));
      break;

    case 'eddc_user_paypal':
      FES_Formbuilder_Templates::eddc_user_paypal($field_id, __('PayPal Email', 'edd_fes'));
      break;

    default:
      do_action('fes_admin_field_' . $name, $field_id);
      break;
  }
  
  exit;
}
