<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.4.0
 * @author     Thomas Griffin <thomasgriffinmedia.com>
 * @author     Gary Jones <gamajo.com>
 * @copyright  Copyright (c) 2014, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'jobify_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function jobify_register_required_plugins() {

	$plugins = array(
		array(
			'name'      => 'Easy Digital Downloads',
			'slug'      => 'easy-digital-downloads',
			'required'  => true,
		),
		array(
			'name'      => 'Easy Digital Downloads - Featured Downloads',
			'slug'      => 'edd-featured-downloads',
			'required'  => false,
		),
		array(
			'name'      => 'Easy Digital Downloads - Frontend Submission Product Details Widget',
			'slug'      => 'easy-digital-downloads-frontend-submissions-product-details-widget',
			'required'  => false,
		),
		array(
			'name'      => 'Multiple Post Thumbnails',
			'slug'      => 'multiple-post-thumbnails',
			'required'  => false,
		),
		array(
			'name'      => 'Jetpack',
			'slug'      => 'jetpack',
			'required'  => false,
		),
		array(
			'name'      => 'Soliloquy Lite',
			'slug'      => 'soliloquy-lite',
			'required'  => false,
		),
		array(
			'name'      => 'Testimonials',
			'slug'      => 'testimonials-by-woothemes',
			'required'  => false,
		),
		array(
			'name'      => 'Features',
			'slug'      => 'features-by-woothemes',
			'required'  => false,
		),
		array(
			'name'      => 'Nav Menu Roles',
			'slug'      => 'nav-menu-roles',
			'required'  => false,
		),
		array(
			'name'      => 'BAW Login/Logout',
			'slug'      => 'baw-login-logout-menu',
			'required'  => false,
		),
		array(
			'name'      => 'Column Shortcode',
			'slug'      => 'column-shortcodes',
			'required'  => false,
		),
		array(
			'name'      => 'Simple Custom CSS',
			'slug'      => 'simple-custom-css',
			'required'  => false,
		),
		array(
			'name'      => 'Widget Importer & Exporter',
			'slug'      => 'widget-importer-exporter',
			'required'  => false,
		),
	);

	$config = array(
		'id'           => 'tgmpa-kitification'          // Unique ID for hashing notices for multiple instances of TGMPA.
	);

	tgmpa( $plugins, $config );
}