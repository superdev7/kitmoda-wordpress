<?php

add_action('add_meta_boxes', 'ksm_kitmoda_update_meta_boxes');
add_action('save_post', 'ksm_kitmoda_update_save');
   

function ksm_kitmoda_update_meta_boxes() {
    add_meta_box('ksm_kitmoda_update_settings_meta_box', 'Settings', 'ksm_kitmoda_update_settings_meta_box', 'ksm_kitmoda_update', 'side');
}


function ksm_kitmoda_update_settings_meta_box() {
    global $post;
    ?>
    <input type="hidden" name="ksm_kitmoda_update_nonce" value="<?=wp_create_nonce(basename(__FILE__))?>" />
    <p>
        <label for="slider_image">Image</label><br />
        <input type="text" name="slider_image" id="slider_image" value="<?=$post->slider_image?>" />
    </p>
    <?php
}



function ksm_kitmoda_update_save($post_id) {
    if (!wp_verify_nonce($_POST['ksm_kitmoda_update_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    
    
    $post = get_post($post_id);
    if ('ksm_kitmoda_update' == $_POST['post_type'] && $post->post_type == 'ksm_kitmoda_update' && current_user_can('edit_post', $post_id)) {
        update_post_meta($post_id, "slider_image", $_POST['slider_image']);
    } else {
        return $post_id;
    }
}

?>