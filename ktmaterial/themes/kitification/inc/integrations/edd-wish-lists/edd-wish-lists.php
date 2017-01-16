<?php
/**
 * Easy Digital Downloads - Wish Lists
 *
 * @package Kitification
 */

/**
 * Move the wish list button from the purchase form to below the content.
 *
 * @since Kitification 1.1.1
 */
function kitification_wish_lists_location() {
	remove_action( 'edd_purchase_link_top', 'edd_wl_load_wish_list_link' );
	add_action( 'kitification_single_download_content_after', 'edd_wl_load_wish_list_link' );
}
add_action( 'init', 'kitification_wish_lists_location' );