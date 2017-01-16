<?php
/**
 * bbPress
 *
 * @package Kitification
 */

function kitification_bbp_default_styles( $styles ) {
	$styles[ 'bbp-default' ][ 'file' ] = 'css/bbpress.min.css';

	return $styles;
}
add_filter( 'bbp_default_styles', 'kitification_bbp_default_styles' );

/**
 * Override bbPress breadcrumb home text.
 *
 * Since our static homepage most likely has a long title,
 * lets reset that to a standard home text.
 *
 * @since Kitification 1.0
 *
 * @param array $args
 * @return array $args
 */
function kitification_bbp_before_get_breadcrumb_parse_args( $args ) {
	$args[ 'home_text' ] = __( 'Home', 'kitification' );

	return $args;
}
add_filter( 'bbp_before_get_breadcrumb_parse_args', 'kitification_bbp_before_get_breadcrumb_parse_args' );