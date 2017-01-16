<?php
/**
 * Features by WooThemes
 *
 * @package Kitification
 */

/**
 * Don't link things.
 *
 * @since Kitification 1.2
 *
 * @return void
 */
function kitification_woothemes_features_default_args( $args ) {
	$args[ 'link_title' ] = false;

	return $args;
}
add_filter( 'woothemes_features_default_args', 'kitification_woothemes_features_default_args' );

/**
 * Depending on the settings of the features widgets, apply a filter to
 * the output.
 *
 * @since Kitification 1.0
 *
 * @return void
 */
function kitification_woothemes_features_item( $widget ) {
	if ( 'widget_woothemes_features' != $widget[ 'classname' ] )
		return $widget;

	$options = get_option( $widget[ 'classname' ] );
	$options = $options[ $widget[ 'params' ][0][ 'number' ] ];

	if ( 25 == $options[ 'size' ] )
		add_filter( 'woothemes_features_item_template', 'kitification_woothemes_features_item_template_mini', 10, 2 );
	else
		add_filter( 'woothemes_features_item_template', 'kitification_woothemes_features_item_template', 10, 2 );
}
add_action( 'dynamic_sidebar', 'kitification_woothemes_features_item' );

/**
 * Standard Features
 *
 * @since Kitification 1.0
 *
 * @return string
 */
function kitification_woothemes_features_item_template( $template, $args ) {
	return '<div class="%%CLASS%% feature-large">%%IMAGE%%<h3 class="feature-title">%%TITLE%%</h3><div class="feature-content">%%CONTENT%%</div></div>';
}

/**
 * Mini Features
 *
 * @since Kitification 1.0
 *
 * @return string
 */
function kitification_woothemes_features_item_template_mini( $template, $args ) {
	return '<div class="%%CLASS%% feature-mini">%%IMAGE%%<h3 class="feature-title">%%TITLE%%</h3><div class="feature-content">%%CONTENT%%</div></div>';
}

function kitification_woothemes_features_html( $html ) {
	$html = str_replace( '<div class="features', '<div data-columns class="features', $html );

	return $html;
}
add_filter( 'woothemes_features_html', 'kitification_woothemes_features_html' );