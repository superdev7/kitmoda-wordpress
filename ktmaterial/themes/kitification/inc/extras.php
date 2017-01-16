<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Kitification
 */

/**
 * Add extra contact fields to the user profile. This information
 * is used in the author info and byline on entries.
 *
 * @since Kitification 1.0
 *
 * @param array $methods Existing contact methods
 * @param object $user The current user that is being edited
 * @return array $methods The modified contact methods
 */
function kitification_user_contactmethods( $methods, $user ) {
	unset( $methods[ 'aim' ] );
	unset( $methods[ 'yim' ] );
	unset( $methods[ 'jabber' ] );

	$methods[ 'twitter' ]  = 'Twitter';
	$methods[ 'facebook' ] = 'Facebook';
	$methods[ 'gplus' ]    = 'Google+';

	return $methods;
}
add_filter( 'user_contactmethods', 'kitification_user_contactmethods', 10, 2 );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function kitification_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'kitification_page_menu_args' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function kitification_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'kitification_enhanced_image_navigation', 10, 2 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function kitification_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'kitification' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'kitification_wp_title', 10, 2 );

/**
 * Remove ellipsis from the excerpt
 */
function kitification_excerpt_more() {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'kitification_excerpt_more' );

/**
 *
 */
function kitification_get_attached_media_args( $args, $type, $post ) {
	global $post;

	if ( 'image' != $type )
		return $args;

	if ( 'download' != $post->post_type )
		return $args;

	if ( class_exists( 'MultiPostThumbnails' ) && MultiPostThumbnails::get_the_post_thumbnail( 'download', 'grid-image' ) )
		$args[ 'exclude' ] = MultiPostThumbnails::get_post_thumbnail_id( 'download', 'grid-image', $post->ID );

	return $args;
}
add_filter( 'get_attached_media_args', 'kitification_get_attached_media_args', 10, 3 );

// Shortcodes in widgets
add_filter( 'widget_text', 'do_shortcode' );