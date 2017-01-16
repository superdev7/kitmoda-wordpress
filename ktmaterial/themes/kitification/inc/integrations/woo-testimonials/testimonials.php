<?php
/**
 * Testimonials by WooThemes
 *
 * @package Kitification
 */

/**
 * Testimonials by WooThemes
 *
 * Depending on the settings of the testimonials widgets, apply a filter to
 * the output.
 *
 * @since Kitification 1.0
 *
 * @return void
 */
function kitification_woothemes_testimonials_item( $widget ) {
	if ( 'widget_woothemes_testimonials' != $widget[ 'classname' ] )
		return $widget;

	$options = get_option( $widget[ 'classname' ] );
	$options = $options[ $widget[ 'params' ][0][ 'number' ] ];

	if ( 1 == $options[ 'display_avatar' ] && null == $options[ 'display_author' ] ) {
		add_filter( 'woothemes_testimonials_item_template', 'kitification_woothemes_testimonials_item_template', 10, 2 );
	} else {
		add_filter( 'woothemes_testimonials_item_template', 'kitification_woothemes_testimonials_item_template_individual', 10, 2 );
	}

	return $widget;
}
add_action( 'dynamic_sidebar', 'kitification_woothemes_testimonials_item' );

/**
 * Company Testimonial 
 *
 * @since Kitification 1.0
 *
 * @return string
 */
function kitification_woothemes_testimonials_item_template( $template, $args ) {
	return '<div class="%%CLASS%% company-testimonial">%%AVATAR%%</div>';
}

/**
 * Individual Testimonial
 *
 * @since Kitification 1.0
 *
 * @return string
 */
function kitification_woothemes_testimonials_item_template_individual( $template, $args ) {
	return '<div id="quote-%%ID%%" class="%%CLASS%% individual-testimonial col-md-6 col-sm-12"><blockquote class="testimonials-text">%%TEXT%%</blockquote>%%AVATAR%% %%AUTHOR%%<div class="fix"></div></div>';
}