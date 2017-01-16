<?php
/**
 * Easy Digital Downloads
 *
 * @package Kitification
 */

/**
 * EDD Sidebars and Widgets
 *
 * @since Kitification 1.2
 *
 * @return void
 */
function kitification_edd_widgets_init() {
	register_widget( 'Kitification_Widget_Recent_Downloads' );
	register_widget( 'Kitification_Widget_Curated_Downloads' );
	register_widget( 'Kitification_Widget_Featured_Popular_Downloads' );
	register_widget( 'Kitification_Widget_Download_Details' );
	register_widget( 'Kitification_Widget_Download_Share' );
	register_widget( 'Kitification_Widget_Download_Archive_Sorting' );
	register_widget( 'Kitification_Widget_Downloads_Taxonomy' );
	register_widget( 'Kitification_Widget_Taxonomy_Stylized' );

	if ( class_exists( 'EDD_Reviews' ) ) {
		register_widget( 'Kitification_Widget_Download_Review_Details' );
	}

	/* Download Achive (archive-download.php) */
	register_sidebar( array(
		'name'          => sprintf( __( '%s Archive Sidebar', 'kitification' ), edd_get_label_singular() ),
		'id'            => 'sidebar-download',
		'before_widget' => '<aside id="%1$s" class="widget download-archive-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="download-archive-widget-title">',
		'after_title'   => '</h1>',
	) );

	/* Download Single (single-download.php) */
	register_sidebar( array(
		'name'          => sprintf( __( '%s Single Sidebar', 'kitification' ), edd_get_label_singular() ),
		'id'            => 'sidebar-download-single',
		'before_widget' => '<aside id="%1$s" class="widget download-single-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="download-single-widget-title">',
		'after_title'   => '</h1>',
	) );

	/* Download Single Comments/Reviews (single-download.php) */
	register_sidebar( array(
		'name'          => sprintf( __( '%s Single Comments Sidebar', 'kitification' ), edd_get_label_singular() ),
		'id'            => 'sidebar-download-single-comments',
		'before_widget' => '<aside id="%1$s" class="widget download-single-widget comments %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="download-single-widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'kitification_edd_widgets_init' );

/**
 * Set the "Download" labels based on the customizer values.
 *
 * @since Kitification 1.0
 *
 * @param array $name
 * @return array unknown
 */
function kitification_edd_default_downloads_name( $name ) {
	return array(
		'singular' => kitification_theme_mod( 'general', 'general-downloads-label-singular' ),
		'plural'   => kitification_theme_mod( 'general', 'general-downloads-label-plural' )
	);
}
add_filter( 'edd_default_downloads_name', 'kitification_edd_default_downloads_name' );

/**
 * Cart menu item
 *
 * @since Kitification 1.0
 *
 * @param string $items
 * @param object $args
 * @return string $items
 */
function kitification_wp_nav_menu_items( $items, $args ) {
	if ( 'primary' != $args->theme_location )
		return $items;

	ob_start();

	$widget_args = array(
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => ''
	);

	$widget = the_widget( 'edd_cart_widget', array( 'title' => '' ), $widget_args );

	$widget = ob_get_clean();

	$link = sprintf( '<li class="current-cart"><a href="%s"><i class="icon-cart"></i> <span class="edd-cart-quantity">%d</span></a><ul class="sub-menu nav-menu"><li class="widget">%s</li></ul></li>', get_permalink( edd_get_option( 'purchase_page' ) ), edd_get_cart_quantity(), $widget );

	return $link . $items;
}
add_filter( 'wp_nav_menu_items', 'kitification_wp_nav_menu_items', 10, 2 );

/**
 * EDD Download wrapper class.
 *
 * When using the [downloads] shortcode, add our own class to the wrapper.
 *
 * @since Kitification 1.0
 *
 * @param string $class
 * @return string The updated class list
 */
function kitification_edd_downloads_list_wrapper_class( $class, $atts ) {
	$columns = kitification_theme_mod( 'product-display', 'product-display-columns' );

	return 'row download-grid-wrapper columns-' . $columns . ' ' . $class;
}
add_filter( 'edd_downloads_list_wrapper_class', 'kitification_edd_downloads_list_wrapper_class', 10, 2 );

/**
 *
 */
function kitification_downloads_shortcode( $display ) {
	$display = str_replace( '<div class="edd_downloads_list', '<div data-columns class="edd_downloads_list', $display );

	return $display;
}
add_filter( 'downloads_shortcode', 'kitification_downloads_shortcode' );

/**
 * EDD Download Class
 *
 * When using the [downloads] shortcode, add our own class to match
 * our awesome styling.
 *
 * @since Kitification 1.0
 *
 * @param string $class
 * @param string $id
 * @param array $atts
 * @return string The updated class list
 */
function kitification_edd_download_class( $class, $id, $atts ) {
	$classes   = kitification_post_classes( array() );
	$classes[] = $class;
	$classes[] = 'content-grid-download';

	return implode( ' ', $classes );
}
add_filter( 'edd_download_class', 'kitification_edd_download_class', 10, 3 );

/**
 * EDD Download Shortcode Attributes
 *
 * @since Kitification 1.0
 *
 * @param array $atts
 * @return array $atts
 */
function kitification_shortcode_atts_downloads( $atts ) {
	$atts[ 'excerpt' ]      = 'no';
	$atts[ 'full_content' ] = 'no';
	$atts[ 'price' ]        = 'no';
	$atts[ 'buy_button' ]   = 'no';
	$atts[ 'columns' ] = 9999;

	return $atts;
}
add_filter( 'shortcode_atts_downloads', 'kitification_shortcode_atts_downloads' );

/**
 * Add standard comments to the Downloads post type.
 *
 * @since Kitification 1.0
 *
 * @param array $supports
 * @return array $supports
 */
function kitification_edd_product_supports( $supports ) {
	$supports[] = 'comments';

	return $supports;
}
add_filter( 'edd_download_supports', 'kitification_edd_product_supports' );

/**
 * Add an extra class to the purchase form if the download has
 * variable pricing. There is no filter for the class, so we have to hunt.
 *
 * @since Kitification 1.0
 *
 * @param string $purchase_form
 * @param array $args
 * @return string $purchase_form
 */
function kitification_edd_purchase_download_form( $purchase_form, $args ) {
	$download_id = $args[ 'download_id' ];

	if ( ! $download_id )
		return $purchase_form;

	if ( ! edd_has_variable_prices( $download_id ) )
		return $purchase_form;

	$purchase_form = str_replace( 'class="edd_download_purchase_form"', 'class="edd_download_purchase_form download-variable"', $purchase_form );

	return $purchase_form;
}
add_filter( 'edd_purchase_download_form', 'kitification_edd_purchase_download_form', 10, 2 );

/**
 * Make sure the only available color is the one we want (inherit)
 *
 * @since Kitification 1.0
 *
 * @param array $colors
 * @return array $colors
 */
function kitification_edd_button_colors( $colors ) {
	$unset = array( 'white', 'blue', 'gray', 'red', 'green', 'yellow', 'orange', 'dark-gray' );

	foreach ( $unset as $color ) {
		unset( $colors[ $color ] );
	}

	return $colors;
}
add_filter( 'edd_button_colors', 'kitification_edd_button_colors' );

/**
 * Login redirect
 */
function kitification_shortcode_atts_edd_login( $atts ) {
	$atts[ 'redirect' ] = apply_filters( 'kitification_edd_force_login_redirect', site_url() );

	return $atts;
}
add_filter( 'shortcode_atts_edd_login', 'kitification_shortcode_atts_edd_login' );

function kitification_edd_sorting_options( $single_key = false  ) {
	$options = array(
		'date'  => __( 'Date', 'kitification' ),
		'title' => __( 'Title', 'kitification' ),
		'sales' => __( 'Sales', 'kitification' ),
		'pricing' => __( 'Price', 'kitification' )
	);

	if ( 'edd_price' == get_query_var( 'meta_key' ) ) {
		$key = 'pricing';
	} elseif ( '_edd_download_sales' == get_query_var( 'meta_key' ) ) {
		$key = 'sales';
	} else {
		$key = $single_key;
	}

	if ( $single_key && $key ) {
		return $key;
	}

	return $options;
}

/**
 * Sorting for standard query
 */
function kitification_edd_orderby( $query ) {
	if ( ! $query->is_main_query() || is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || is_page_template( 'page-templates/shop.php' ) ) {
		return;
	}

	if ( get_query_var( 'm-orderby' ) && 'pricing' == get_query_var( 'm-orderby' ) ) {
		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'meta_key', 'edd_price' );
	} elseif ( get_query_var( 'm-orderby' ) && 'sales' == get_query_var( 'm-orderby' ) ) {
		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'meta_key', '_edd_download_sales' );
	}
}
add_filter( 'pre_get_posts', 'kitification_edd_orderby' );

/**
 * Sorting for standard shortcode
 */
function kitification_edd_downloads_query( $query, $atts ) {
	if ( is_page_template( 'page-templates/popular.php' ) ) {
		$query[ 'meta_key' ] = '_edd_download_sales';
		$query[ 'orderby' ]  = 'meta_value_num';

		if ( get_query_var( 'popular_cat' ) ) {
			$query[ 'tax_query' ] = array(
				array(
					'taxonomy' => 'download_category',
					'field'    => 'id',
					'terms'    => explode( ',', get_query_var( 'popular_cat' ) )
				)
			);
		}
	} else {
		foreach ( array( 'm-orderby', 'm-order' ) as $key ) {
			if ( isset( $atts[ $key ] ) ) {
				continue;
			} else if ( get_query_var( $key ) ) {
				$query[ str_replace( 'm-', '', $key ) ] = get_query_var( $key );
			} else {
				$query[ str_replace( 'm-', '', $key ) ] = null;
			}
		}

		if ( 'sales' == get_query_var( 'm-orderby' ) ) {
			$query[ 'orderby' ]  = 'meta_value_num';
			$query[ 'meta_key' ] = '_edd_download_sales';
		} elseif( 'pricing' == get_query_var( 'm-orderby' ) ) {
			$query[ 'orderby' ]  = 'meta_value_num';
			$query[ 'meta_key' ] = 'edd_price';
		}
	};

	return $query;
}
add_filter( 'edd_downloads_query', 'kitification_edd_downloads_query', 10, 2 );

/**
 * Excerpt length on downloads
 */
function kitification_download_excerpt_grid( $length ) {
	if ( 'download' == get_post_type() ) {
		return 15;
	}

	return $length;
}
add_filter( 'excerpt_length', 'kitification_download_excerpt_grid' );

/**
 * Extra Files
 */
require get_template_directory() . '/inc/integrations/edd/edd-metaboxes.php';
require get_template_directory() . '/inc/integrations/edd/edd-template-tags.php';

// Widgets
$widgets = array(
	'class-widget-downloads-recent.php',
	'class-widget-downloads-curated.php',
	'class-widget-featured-popular.php',
	'class-widget-download-details.php',
	'class-widget-download-share.php',
	'class-widget-download-archive-sorting.php',
	'class-widget-downloads-taxonomy.php',
	'class-widget-downloads-taxonomy-stylized.php'
);

foreach ( $widgets as $widget ) {
	require get_template_directory() . '/inc/integrations/edd/widgets/' . $widget;
}

if ( class_exists( 'EDD_Reviews' ) ) {
	require get_template_directory() . '/inc/integrations/edd/widgets/class-widget-download-review-details.php';
}