<?php
/**
 * Create HTML dropdown list of Categories.
 *
 * @package WordPress
 * @since 2.1.0
 * @uses Walker
 */
class FES_Walker_Category_Multi extends Walker {

    /**
     * @see Walker::$tree_type
     * @var string
     */
    var $tree_type = 'category';

    /**
     * @see Walker::$db_fields
     * @var array
     */
    var $db_fields = array('parent' => 'parent', 'id' => 'term_id');

    /**
     * @see Walker::start_el()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $category Category data object.
     * @param int $depth Depth of category. Used for padding.
     * @param array $args Uses 'selected' and 'show_count' keys, if they exist.
     */
    function start_el( &$output, $category, $depth = 0, $args = array(), $current_object_id = 0 ) {
        $pad = str_repeat( '&nbsp;', $depth * 3 );

        $cat_name = apply_filters( 'list_cats', $category->name, $category );
        $output .= "\t<option class=\"level-$depth\" value=\"" . $category->term_id . "\"";
        if ( in_array( $category->term_id, $args['selected_multiple'] ) )
            $output .= ' selected="selected"';
        $output .= '>';
        $output .= $pad . $cat_name;
        if ( $args['show_count'] )
            $output .= '&nbsp;&nbsp;(' . $category->count . ')';
        $output .= "</option>\n";
    }

}

/**
 * Category checklist walker
 *
 * @since 0.8
 */
class FES_Walker_Category_Checklist extends Walker {

    var $tree_type = 'category';
    var $db_fields = array('parent' => 'parent', 'id' => 'term_id'); //TODO: decouple this

    function start_lvl( &$output, $depth = 0, $args = array()  ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "$indent<ul class='children'>\n";
    }

    function end_lvl( &$output, $depth = 0, $args = array()  ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "$indent</ul>\n";
    }

    function start_el( &$output, $category, $depth = 0, $args = array(), $current_object_id = 0 ) {
        extract( $args );
        if ( empty( $taxonomy ) )
            $taxonomy = 'category';

        if ( $taxonomy == 'category' )
            $name = 'category';
        else
            $name = $taxonomy;

        $output .= "\n<li id='{$taxonomy}-{$category->term_id}'>" . '<label class="selectit"><input value="' . $category->term_id . '" type="checkbox" name="' . $name . '[]" id="in-' . $taxonomy . '-' . $category->term_id . '"' . checked( in_array( $category->term_id, $selected_cats ), true, false ) . disabled( empty( $args['disabled'] ), false, false ) . ' /> ' . esc_html( apply_filters( 'the_category', $category->name ) ) . '</label>';
    }

    function end_el(  &$output, $object, $depth = 0, $args = array()  ) {
        $output .= "</li>\n";
    }

}

/**
 * Displays checklist of a taxonomy
 *
 * @since 0.8
 * @param int $post_id
 * @param array $selected_cats
 */
function fes_category_checklist( $post_id = 0, $selected_cats = false, $attr = array() ) {
    require_once ABSPATH . '/magento-help/includes/template.php';

    $walker = new FES_Walker_Category_Checklist();

    $exclude_type = isset( $attr['exclude_type'] ) ? $attr['exclude_type'] : 'exclude';
    $exclude = $attr['exclude'];
    $tax = $attr['name'];

    $args = array(
        'taxonomy' => $tax,
    );

    if ( $post_id ) {
        $args['selected_cats'] = wp_get_object_terms( $post_id, $tax, array('fields' => 'ids') );
    } elseif ( $selected_cats ) {
        $args['selected_cats'] = $selected_cats;
    } else {
        $args['selected_cats'] = array();
    }

    $categories = (array) get_terms( $tax, array(
        'hide_empty' => false,
        $exclude_type => (int) $exclude,
        'orderby' => isset( $attr['orderby'] ) ? $attr['orderby'] : 'name',
        'order' => isset( $attr['order'] ) ? $attr['order'] : 'ASC',
    ) );

    echo '<ul class="fes-category-checklist">';
    echo call_user_func_array( array(&$walker, 'walk'), array($categories, 0, $args) );
    echo '</ul>';
}

/**
 * Associate attachment to a post
 *
 * @since 2.0
 *
 * @param type $attachment_id
 * @param type $post_id
 */
function fes_associate_attachment( $attachment_id, $post_id ) {

    global $wpdb;

    $wpdb->update(
        $wpdb->posts,
        array(
            'post_parent' => $post_id,
        ),
        array(
            'ID' => $attachment_id,
        ),
        array(
            '%d'
        ),
        array(
            '%d'
        )
    );

    /*
     * We don't use wp_update_post() anymore due to infinite recursion on the save_post hook. See Github #217
     *
    wp_update_post( array(
        'ID' => $attachment_id,
        'post_parent' => $post_id
    ) );
    */
}


/**
 * User avatar wrapper for custom uploaded avatar
 *
 * @since 2.0
 *
 * @param string $avatar
 * @param mixed $id_or_email
 * @param int $size
 * @param string $default
 * @param string $alt
 * @return string image tag of the user avatar
 */
function fes_get_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    if ( is_numeric( $id_or_email ) ) {
        $user = get_user_by( 'id', $id_or_email );
    } elseif ( is_object( $id_or_email ) ) {
        if ( $id_or_email->user_id != '0' ) {
            $user = get_user_by( 'id', $id_or_email->user_id );
        } else {
            return $avatar;
        }
    } else {
        $user = get_user_by( 'email', $id_or_email );
    }

    if( ! $user ) {
        return $avatar;
    }

    // see if there is a user_avatar meta field
    $user_avatar = get_user_meta( $user->ID, 'user_avatar', true );
    if ( empty( $user_avatar ) ) {
        return $avatar;
    }

    return sprintf( '<img src="%1$s" alt="%2$s" height="%3$s" width="%3$s" class="avatar">', esc_url( $user_avatar ), $alt, $size );
}

add_filter( 'get_avatar', 'fes_get_avatar', 99, 5 );

function fes_update_avatar( $user_id, $attachment_id ) {

    $upload_dir = wp_upload_dir();
    $relative_url = wp_get_attachment_url( $attachment_id );

    if ( function_exists( 'wp_get_image_editor' ) ) {
        // try to crop the photo if it's big
        $file_path = str_replace( $upload_dir['baseurl'], $upload_dir['basedir'], $relative_url );

        // as the image upload process generated a bunch of images
        // try delete the intermediate sizes.
        $ext = strrchr( $file_path, '.' );
        $file_path_w_ext = str_replace( $ext, '', $file_path );
        $small_url = $file_path_w_ext . '-avatar' . $ext;

        $editor = wp_get_image_editor( $file_path );

        if ( !is_wp_error( $editor ) ) {
            $avatar_size = apply_filters('fes_avatar_size' , array( 100, 100 ), $user_id, $attachment_id);
            $editor->resize( $avatar_size[0], $avatar_size[1], true );
            $editor->save( $small_url );

            // if the file creation successfull, delete the original attachment
            if ( file_exists( $small_url ) ) {
                $relative_url = str_replace( $upload_dir['basedir'], $upload_dir['baseurl'], $small_url );

                // delete any previous avatar
                $prev_avatar = get_user_meta( $user_id, 'user_avatar', true );

                if ( !empty( $prev_avatar ) && $prev_avatar != $relative_url ) {
                    $prev_avatar_path = str_replace( $upload_dir['baseurl'], $upload_dir['basedir'], $prev_avatar );

                    if ( file_exists( $prev_avatar_path ) ) {
                        unlink( $prev_avatar_path );
                    }
                }

                // now update new user avatar
                update_user_meta( $user_id, 'user_avatar', $relative_url );
            }
        }
    }
}

/**
 * Show custom fields in post content area (beta)
 *
 * @global object $post
 * @param string $content
 * @return string
 */
function fes_show_custom_fields( $content ) {
    global $post;

    // TODO: Disable till 2.3 implementation of per field settings
    return $content;

	if($post->post_type != 'download'){
		return $content;
	}

    $show_custom = EDD_FES()->helper->get_option( 'fes-show-custom-meta', false );
    $form_id = EDD_FES()->helper->get_option( 'fes-submission-form', false );

    if (!$show_custom || !$form_id ) {
        return $content;
    }

    $html = '<ul class="fes_customs">';

    $form_vars = get_post_meta( $form_id, 'fes-form', true );
    $meta = array();

    if ( $form_vars ) {
        foreach ($form_vars as $attr) {
            if ( isset( $attr['is_meta'] ) && $attr['is_meta'] == 'yes' ) {
                $meta[] = $attr;
            }
        }

        if ( !$meta ) {
            return $content;
        }

        foreach ($meta as $attr) {
            $field_value = get_post_meta( $post->ID, $attr['name'] );

            if ( $attr['input_type'] == 'hidden' ) {
                continue;
            }

            if ( $attr['input_type'] == 'image_upload' || $attr['input_type'] == 'file_upload' ) {
                $image_html = '<li><label>' . $attr['label'] . ':</label> ';

                if ( $field_value ) {
                    foreach ($field_value as $attachment_id) {

                        if ( $attr['input_type'] == 'image_upload' ) {
                            $thumb = wp_get_attachment_image( $attachment_id, 'thumbnail' );
                        } else {
                            $thumb = get_post_field( 'post_title', $attachment_id );
                        }

                        $full_size = wp_get_attachment_url( $attachment_id );
                        $image_html .= sprintf( '<a href="%s">%s</a> ', $full_size, $thumb );
                    }
                }

                $html .= $image_html . '</li>';

            }
            else {

                $value = get_post_meta( $post->ID, $attr['name'] );
                $html .= sprintf( '<li><label>%s</label>: %s</li>', $attr['label'], make_clickable( implode( ', ', $value ) ) );
            }
        }
    }

    $html .= '</ul>';

    return $content . $html;
}

add_filter( 'the_content', 'fes_show_custom_fields' );



/**
 * Get attachment ID from a URL
 *
 * @since 2.1.8
 *
 * @link http://philipnewcomer.net/2012/11/get-the-attachment-id-from-an-image-url-in-wordpress/ Original Implementation
 *
 * @global type $wpdb
 * @param type $attachment_url
 * @return type
 */
function fes_get_attachment_id_from_url( $attachment_url = '', $author_id = 0 ) {

    global $wpdb;
    $attachment_id = false;

    // If there is no url, return.
    if ( '' == $attachment_url )
        return;

    // Get the upload directory paths
    $upload_dir_paths = wp_upload_dir();

    // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
    if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

        // If this is the URL of an auto-generated thumbnail, get the URL of the original image
        $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

        // Remove the upload path base directory from the attachment URL
        $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

        // Remove the -avatar suffix
        $attachment_url = str_replace( '-avatar.', '.', $attachment_url );

        // If an author ID is specified
        $author = '';
        if( ! empty( $author_id  ) ) {
            $author = "wposts.post_author = $author_id AND";
        }

        // Finally, run a custom database query to get the attachment ID from the modified attachment URL
        $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE $author wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
    }

    return $attachment_id;
}

/**
 * Retrieve a list of the allowed HTML tags
 *
 * @access  public
 * @since   2.2.2
*/
function fes_allowed_html_tags() {
	$tags = array(
		'p' => array(
			'class' => array(),
            'style' => array()
		),
		'h1' => array(
			'class' => array(),
            'style' => array()
		),
		'h2' => array(
			'class' => array(),
            'style' => array()
		),
		'h3' => array(
			'class' => array(),
            'style' => array()
		),
		'h4' => array(
			'class' => array(),
            'style' => array()
		),
		'h5' => array(
			'class' => array(),
            'style' => array()
		),
        'h6' => array(
            'class' => array(),
            'style' => array()
        ),
		'span' => array(
			'class' => array(),
            'style' => array()
		),
		'a' => array(
			'href' => array(),
			'title' => array(),
			'class' => array(),
			'title' => array(),
            'style' => array()
		),
		'b' => array(),
		'strong' => array(),
		'em' => array(),
		'br' => array(),
		'img' => array(
			'src' => array(),
			'title' => array(),
			'alt' => array(),
            'class' => array(),
            'size' => array(),
            'width' => array(),
            'height' => array(),
            'style' => array()
		),
		'div' => array(
			'class' => array(),
            'style' => array()
		),
		'ul' => array(
			'class' => array(),
            'style' => array()
		),
		'ol' => array(
			'class' => array(),
            'style' => array()
		),
		'li' => array(
			'class' => array(),
            'style' => array()
		),
        'font' => array()
	);

	return apply_filters( 'fes_allowed_html_tags', $tags );
}

/**
 * Retrieves the currently displayed vendor
 *
 * This is used when display a vendor's store page
 *
 * This is a wrapper for FES_Vendor_Shop::get_queried_vendor()
 *
 * @since 2.2.10
 * @return object|false WP User Object or false
 */
function fes_get_vendor() {
    return EDD_FES()->vendor_shop->get_queried_vendor();
}
