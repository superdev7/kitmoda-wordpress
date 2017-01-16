<?php




add_filter( 'manage_edit-ksm_post_columns', 'manage_edit_ksm_post_columns' ) ;
add_action( 'manage_ksm_post_posts_custom_column', 'manage_ksm_post_posts_custom_column', 10, 2 );
add_filter( 'manage_edit-ksm_post_sortable_columns', 'manage_edit_ksm_post_sortable_columns' );
add_action( 'load-edit.php', 'ksm_edit_ksm_post_load' );


add_action('add_meta_boxes', 'ksm_post_meta_boxes');
add_action('save_post', 'ksm_post_save');




add_filter('post_row_actions','ksm_post_row_actions', 10, 2);


function ksm_post_row_actions($actions, $post) {
       
    if($post->post_type == 'ksm_post') {
        $actions['post-block'] = '<a href="http://www.google.com/?q='.$post->ID.'">Block</a>';
        //$actions['post-unblock'] = '<a href="http://www.google.com/?q='.$post->ID.'">Unblock</a>';
    }
    return $actions;
}



function ksm_post_save($post_id) {
    if (!wp_verify_nonce($_POST['ksm_post_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    
    
    
    $post = KSM_Social_Post::get($post_id);
    
    
    
    if ($post && 'ksm_post' == $_POST['post_type'] && current_user_can('edit_post', $post_id)) {
        
        if($_POST['blocked']) {
            $post->block();
        } else {
            $post->unblock();
        }
        
        $post->admin_save();
    } else {
        
        exit;
        return $post_id;
    }
}



function ksm_post_meta_boxes() {
    add_meta_box('ksm_post_meta_box_images', 'Images', 'ksm_post_meta_box_images', 'ksm_post', 'normal', 'high');
    add_meta_box('ksm_post_meta_box_stats', 'Post Stats', 'ksm_post_meta_box_stats', 'ksm_post', 'side', 'high');
}



function ksm_post_meta_box_stats() {
    global $post_ID;
    $post = KSM_Social_Post::get($post_ID);
    ?>

    <div class="ksm_post_stats_metabox">

        <div class="field">
            <label>Reports</label>
            <div><?=$post->reports_count?></div>
            <div class="clr"></div>
        </div>
        <div class="field">
            <label>Images</label>
            <div><?=$post->images_count?></div>
            <div class="clr"></div>
        </div>
        <div class="field">
            <label>Views</label>
            <div><?=$post->views_count?></div>
            <div class="clr"></div>
        </div>
        <div class="field">
            <label>Likes</label>
            <div><?=$post->likes_count?></div>
            <div class="clr"></div>
        </div>
    </div>


    <div style="margin-top : 20px">
        <label><input type="checkbox" name="blocked"<?=($post->is_blocked() ? ' checked="checked"' : '')?> />Block</label>
        <div class="clr"></div>
    </div>
    
    <?php
}




function ksm_post_meta_box_images() {
    
    global $post_ID;
    
    
    $post = KSM_Social_Post::get($post_ID);
    
    
    $attachments = $post->image_attachments(array(
            'order'         => 'ASC',
            'meta_key'      => 'image_sort',
            'orderby'       => 'meta_value_num',
            'post_status'   => 'any'
        ));
    
?>

<div class="inside ksm_post_images_inside">
    <ul class="list_images items">
        <?php foreach ((Array) $attachments as $att) :
            
            $img_topic = ksm_get_ds_post_term_names($att->ID, 'topic', 'topic', true);
            $img_topic = $img_topic ? $img_topic : 'general';
            $img_progress = ksm_get_ds_post_term_names($att->ID, 'topic', 'progress', true);
            ?>
        
        <li rel="<?=$att->ID?>" id="img_att_<?=$att->ID?>" class="image_item item">
            <input type="hidden" class="uid" name="kimg[id][]" value="<?=$att->ID?>" />
            
            <div class="preview">
                <div class="img thumbnail">
                    <img src="<?=get_image_src($att->ID, 'community_thumb') ?>" />
                </div>
            </div>
            
            
            <div class="fields">
                <div class="field field_image_name">
                    <label>NAME IMAGE</label>
                    <input type="text" name="kimg[name][]" value="<?=$att->post_title?>" class="input" />
                </div>
                
                <div>
                    <div class="field field_topic">
                        <label>TOPIC</label>
                        <?=KSM_Form::terms_dropdown('topic', array(
                            'section' => 'topic', 
                            'label' => 'post_option_label', 
                            'name' => 'kimg[topic][]',
                            'id' => '',
                            'value' => $img_topic
                            )); ?>
                    </div>
                    <div class="field field_progress">
                        <label>PROGRESS</label>
                        <?=KSM_Form::terms_dropdown('topic', array(
                            'section' => 'progress', 
                            'label' => 'short_label', 
                            'none_text' => 'Unspecified', 
                            'name' => 'kimg[progress][]',
                            'id' => '',
                            'value' => $img_progress
                            )); ?>
                    </div>
                    
                    <div class="clr"></div>
                </div>
                
                
                
            </div>
                
                
            <div class="actions">
                <a href="" class="action_remove remove">REMOVE</a>
                
                <div class="clr"></div>
                
                <div class="field add_to_gallery">
                    <label><input type="checkbox" name="kimg[add_in_gallery][]" <?=(($att->add_in_gallery == 'yes') ? 'checked="checked"' : '')?>value="yes" />ADD TO GALLERIES</label>
                </div>
                
            </div>
            <div class="clr"></div>
            <div class="line2"></div>
        </li>
        <?php endforeach; ?>
        <li class="clr items_clr"></li>
    </ul>

    <input type="hidden" name="ksm_post_nonce" value="<?=wp_create_nonce(basename(__FILE__))?>" />
</div>
    
    <?php
}



function ksm_edit_ksm_post_load() {
    add_filter( 'request', 'ksm_edit_ksm_post_sort' );
}


function ksm_edit_ksm_post_sort( $vars ) {
    
    if ( isset( $vars['post_type'] ) && 'ksm_post' == $vars['post_type'] ) {
        if ( isset( $vars['orderby'] ) && 'images' == $vars['orderby'] ) {
            $vars = array_merge($vars,array(
                'meta_key' => 'images_count',
                'orderby' => 'meta_value_num'
                ));
        } elseif ( isset( $vars['orderby'] ) && 'likes' == $vars['orderby'] ) {
            $vars = array_merge($vars,array(
                'meta_key' => 'likes_count',
                'orderby' => 'meta_value_num'
                ));
        } elseif ( isset( $vars['orderby'] ) && 'reports' == $vars['orderby'] ) {
            $vars = array_merge($vars,array(
                'meta_key' => 'reports_count',
                'orderby' => 'meta_value_num'
                ));
        }
    }
    
    return $vars;
}


function manage_edit_ksm_post_columns($columns) {
    
    $columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Title' ),
		'images' => __( 'Images' ),
                
                'likes' => __( 'Likes' ),
                'reports' => __( 'Reports' ),
		'topic' => __( 'Topic' ),
                'author' => __( 'Post By' ),
                'post_at' => __( 'Post At' ),
                'comments' => __( 'Comments' ),
		'date' => __( 'Date' )
	);
    
    
    

	return $columns;
    
}


function manage_ksm_post_posts_custom_column($column, $post_id) {
    
    switch($column) {
        
        case "topic":
            
            $post = KSM_Social_Post::get($post_id);
            echo $post->get_tags_admin_links('topic');
            
            break;
        
        case "post_at" :
            $post = KSM_Social_Post::get($post_id);
            echo $post->get_tags_admin_links('post_at');
            
            break;
        
        case "images" :
            $images = get_post_meta($post_id, 'images_count', true);
            echo get_number($images);
            break;
        
        case "likes" :
            $likes = get_post_meta($post_id, 'likes_count', true);
            echo get_number($likes);
            break;
        
        case "reports" :
            $reports = get_post_meta($post_id, 'reports_count', true);
            echo get_number($reports);
            break;
        
    }
}


function manage_edit_ksm_post_sortable_columns() {
    
    
    $columns['images'] = 'images';
    $columns['likes'] = 'likes';
    $columns['reports'] = 'reports';

    return $columns;
}



?>