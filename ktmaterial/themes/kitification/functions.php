<?php
/**
 * Kitification functions and definitions
 *
 * @package Kitification
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 750; /* pixels */

if ( ! function_exists( 'kitification_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Kitification 1.0
 *
 * @return void
 */
function kitification_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Kitification, use a find and replace
	 * to change 'kitification' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'kitification', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	if ( kitification_theme_mod( 'product-display', 'product-display-aspect' ) ) {
		$g_w = 520;
		$g_h = 640;
		$g_c = true;

		$s_w = 9999;
		$s_h = 9999;
		$s_c = false;
	} else {
		$g_w = 640;
		$g_h = 520;
		$g_c = true;

		$s_w = 9999;
		$s_h = 520;
		$s_c = true;
	}

	add_image_size(
		'content-grid-download',
		apply_filters( 'kitification_image_content_grid_download_w', $g_w ),
		apply_filters( 'kitification_image_content_grid_download_h', $g_h ),
		apply_filters( 'kitification_image_content_grid_download_c', $g_c )
	);

	add_image_size(
		'content-single-download',
		apply_filters( 'kitification_image_content_single_download_w', $s_w ),
		apply_filters( 'kitification_image_content_single_download_h', $s_h ),
		apply_filters( 'kitification_image_content_single_download_c', $s_c )
	);

	if (class_exists('MultiPostThumbnails')) {
		new MultiPostThumbnails(
			array(
				'label'     => __( 'Grid Image', 'kitification' ),
				'id'        => 'grid-image',
				'post_type' => 'download'
			)
		);
	}

	/*
	Nav Menus
	*/
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'kitification' ),
		'social'  => __( 'Footer Social', 'kitification' ),
		'footer1' => __( 'Footer 1', 'kitification' ),
		'footer2' => __( 'Footer 2', 'kitification' ),
		'footer3' => __( 'Footer 3', 'kitification' ),
		'footer4' => __( 'Footer 4', 'kitification' )
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'audio', 'video' ) );

	/**
	 * Enable Post Formats for Downloads
	 */
	add_post_type_support( 'download', 'post-formats' );

	/**
	 * Editor Style
	 */
	add_editor_style( 'css/editor-style.min.css' );

	/**
	 * Setup the WordPress core custom background feature.
	 */
	add_theme_support( 'custom-background', apply_filters( 'kitification_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'kitification_setup' );

/**
 * Check if EDD is active
 *
 * @since Kitification 1.0
 *
 * @return boolean
 */
function kitification_is_edd() {
	return class_exists( 'Easy_Digital_Downloads' );
}

/**
 * Check if we are using bbPress
 *
 * @since Kitification 1.0
 *
 * @return boolean
 */
function kitification_is_bbpress() {
	if ( ! function_exists( 'is_bbpress' ) )
		return false;

	return is_bbpress();
}

/**
 * Check if we are a standard Easy Digital Download install,
 * or a multi-vendor marketplace.
 *
 * @since Kitification 1.0
 *
 * @return boolean
 */
function kitification_is_multi_vendor() {
	if ( ! class_exists( 'Easy_Digital_Downloads' ) )
		return false;

	if ( false === ( $is_multi_vendor = get_transient( 'kitification_is_multi_vendor' ) ) ) {
		$vendors = get_users( apply_filters( 'kitification_is_multi_vendor_check', array() ) );

		$total = count( $vendors );
		$is_multi_vendor = $total > 0 ? true : false;

		set_transient( 'kitification_is_multi_vendor', $is_multi_vendor );
	}

	return $is_multi_vendor;
}

/**
 * When a user is updated, or created, clear the multi vendor
 * cache check.
 *
 * @since Kitification 1.0
 *
 * @return void
 */
function __kitification_clear_multi_vendor_cache() {
	delete_transient( 'kitification_is_multi_vendor' );
}
add_action( 'profile_update', '__kitification_clear_multi_vendor_cache' );
add_action( 'user_register',  '__kitification_clear_multi_vendor_cache' );

/**
 * Remove Post Formats from Posts
 *
 * Since `add_theme_support( 'post-formats' )` cant specify a post type, we need
 * to remove the formats from the standard post type as we just want downloads.
 *
 * @since Kitification 1.0
 *
 * @return void
 */
function kitification_remove_post_formats() {
	 remove_post_type_support( 'post', 'post-formats' );
}
add_action( 'init', 'kitification_remove_post_formats' );

/**
 * Hip Header Start
 *
 * If the current page qualifies, add a wrapping div above everything else
 * in order to create full width header backgrounds that cover the main
 * header as well as extend below the page title.
 *
 * @since Kitification 1.0
 *
 * @return mixed
 */
function kitification_before_shim() {
	global $post;

	if ( ! $background = kitification_has_header_background() ) {
		echo '<div class="header-outer">';

		return;
	}

	$background = apply_filters( 'kitification_header_outer_image', $background );

	printf( '<div class="header-outer%2$s" style="background-image: url(%1$s);">', $background[0], is_array( $background ) ? ' custom-featured-image' : '' );
}
add_action( 'before', 'kitification_before_shim' );

/**
 * Hip Header End
 *
 * If the current page qualifies, end the hip header.
 *
 * @since Kitification 1.0
 *
 * @return mixed
 */
function kitification_entry_header_background_end() {
	echo '</div><!-- .header-outer -->';
}
add_action( 'kitification_entry_before', 'kitification_entry_header_background_end', 100 );

/**
 * Hip Header CSS
 *
 * If the current page qualifies, add extra CSS so the hip header
 * background shines through.
 *
 * @since Kitification 1.0
 *
 * @return mixed
 */
function kitification_before_shim_css() {
	global $post;

	if ( ! kitification_has_header_background() )
		return;

	wp_add_inline_style( 'kitification-base', '.site-header, .page-header { background-color: transparent; }' );
}
add_action( 'wp_enqueue_scripts', 'kitification_before_shim_css', 11 );

/**
 * Hip Header Qualification
 *
 * @since Kitification 1.0
 *
 * @return mixed boolean|string False if not qualified or no header, URL to image if one exists.
 */
function kitification_has_header_background() {
	global $post;

	$_post = $post;

	$is_correct = apply_filters( 'kitification_has_header_background', (
		kitification_is_bbpress() ||
		( is_singular( 'download' ) && in_array( get_post_format(), array( 'video' ) ) ) ||
		is_singular( array( 'page', 'post' ) ) ||
		is_page_template( 'page-templates/home.php' ) ||
		is_page_template( 'page-templates/home-search.php' ) ||
		is_home()
	) );

	if ( ! $is_correct || is_post_type_archive( 'download' ) )
		return false;

	if ( is_home() ) {
		$post = get_post( get_option( 'page_for_posts' ) );
	}

	$background = apply_filters( 'kitification_has_header_background_force', is_singular( array( 'post', 'page' ) ) || kitification_is_bbpress() ) ? true : false;

	if ( has_post_thumbnail( $post->ID ) && ! is_array( $background ) ) {
		$background = wp_get_attachment_image_src( get_post_thumbnail_id(), 'fullsize' );
	}

	$post = $_post;

	return $background;
}

/**
 * On posts and pages, add extra header information.
 *
 * @since Kitification 1.0
 *
 * @return void
 */
function kitification_entry_page_title() {
	if (
		! is_singular( array( 'post', 'page' ) ) &&
		! kitification_is_bbpress() ||
		is_page_template( 'page-templates/shop.php' ) ||
		is_page_template( 'page-templates/popular.php' ) ||
		is_page_template( 'page-templates/vendor.php' ) ||
		is_page_template( 'page-templates/wishlist.php' ) ||
		is_post_type_archive( 'download' )
	)
		return;

	the_post();
?>
	<div class="entry-page-title container">
		<?php get_template_part( 'content', 'author' ); ?>

		<h1 class="entry-title"><?php the_title(); ?></h1>

		<?php
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) )
				$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';

			if ( is_singular( 'post' ) )
				printf( $time_string,
					esc_attr( get_the_date( 'c' ) ),
					esc_html( get_the_date() ),
					esc_attr( get_the_modified_date( 'c' ) ),
					esc_html( get_the_modified_date() )
				);
		?>
	</div>
<?php
	rewind_posts();
}
add_action( 'kitification_entry_before', 'kitification_entry_page_title' );

/**
 * Sidebars and Widgets
 *
 * @since Kitification 1.0
 *
 * @return void
 */
function kitification_widgets_init() {
	register_widget( 'Kitification_Widget_Slider' );
	register_widget( 'Kitification_Widget_Price_Table' );
	register_widget( 'Kitification_Widget_Price_Option' );
	register_widget( 'Kitification_Widget_Recent_Posts' );

	if ( function_exists( 'soliloquy' ) ) {
		register_widget( 'Kitification_Widget_Slider_Soliloquy' );
	}

	/* Custom Homepage */
	register_sidebar( array(
		'name'          => __( 'Homepage', 'kitification' ),
		'description'   => __( 'Widgets that appear on the "Homepage" Page Template', 'kitification' ),
		'id'            => 'home-1',
		'before_widget' => '<aside id="%1$s" class="home-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="home-widget-title"><span>',
		'after_title'   => '</span></h1>',
	) );

	/* Standard Sidebar */
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'kitification' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title section-title"><span>',
		'after_title'   => '</span></h1>',
	) );

	/*
	 * Figure out how many columns the footer has
	 */
	$the_sidebars = wp_get_sidebars_widgets();
	$footer       = isset ( $the_sidebars[ 'footer-1' ] ) ? $the_sidebars[ 'footer-1' ] : array();
	$count        = count( $footer );
	$count        = floor( 12 / ( $count == 0 ? 1 : $count ) );

	/* Footer */
	register_sidebar( array(
		'name'          => __( 'Footer', 'kitification' ),
		'description'   => __( 'Widgets that appear in the page footer', 'kitification' ),
		'id'            => 'footer-1',
		'before_widget' => '<aside id="%1$s" class="footer-widget %2$s col-md-' . $count . '">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="footer-widget-title">',
		'after_title'   => '</h1>',
	) );

	/*
	 * Figure out how many columns the price table has
	 */
	$prices = isset ( $the_sidebars[ 'widget-area-price-options' ] ) ? $the_sidebars[ 'widget-area-price-options' ] : array();
	$count = count( $prices );
	$count = floor( 12 / ( $count == 0 ? 1 : $count ) );

	/* Price Table */
	register_sidebar( array(
		'name'          => __( 'Price Table', 'kitification' ),
		'id'            => 'widget-area-price-options',
		'description'   => __( 'Drag multiple "Price Option" widgets here. Then drag the "Pricing Table" widget to the "Homepage" Widget Area.', 'kitification' ),
		'before_widget' => '<div id="%1$s" class="pricing-table-widget %2$s col-lg-' . $count . ' col-md-6">',
		'after_widget'  => '</div>'
	) );
}
add_action( 'widgets_init', 'kitification_widgets_init' );

/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of Source Sans Pro and Varela Round by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @since Kitification 1.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function kitification_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Source Sans Pro, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$source_sans_pro = _x( 'on', 'Source Sans Pro font: on or off', 'kitification' );

	/* Translators: If there are characters in your language that are not
	 * supported by Roboto Slab, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$roboto = _x( 'on', 'Roboto Slab font: on or off', 'kitification' );

	/* Translators: If there are characters in your language that are not
	 * supported by Montserrat, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$montserrat = _x( 'on', 'Montserrat font: on or off', 'kitification' );

	if ( 'off' !== $source_sans_pro || 'off' !== $roboto || 'off' !== $montserrat ) {
		$font_families = array();

		if ( 'off' !== $source_sans_pro )
			$font_families[] = apply_filters( 'kitification_font_source_sans', 'Source Sans Pro:300,400,700,300italic,400italic,700italic' );

		if ( 'off' !== $roboto )
			$font_families[] = apply_filters( 'kitification_font_roboto', 'Roboto Slab:300,400' );

		if ( 'off' !== $montserrat )
			$font_families[] = apply_filters( 'kitification_font_montserrat', 'Montserrat:400,700' );

		$query_args = array(
			'family' => urlencode( implode( '|', apply_filters( 'kitification_font_families', $font_families ) ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Load fonts in TinyMCE
 *
 * @since Kitification 1.0
 *
 * @return string $css
 */
function kitification_mce_css( $css ) {
	$css .= ', ' . kitification_fonts_url();

	return $css;
}
add_filter( 'mce_css', 'kitification_mce_css' );

/**
 * Scripts and Styles
 *
 * Load Styles and Scripts depending on certain conditions. Not all assets
 * will be loaded on every page.
 *
 * @since Kitification 1.0
 *
 * @return void
 */
function kitification_scripts() {
	/*
	 * Styles
	 */

	/* Supplimentary CSS */
	wp_enqueue_style( 'kitification-fonts', kitification_fonts_url() );
	wp_enqueue_style( 'entypo', get_template_directory_uri() . '/css/entypo.min.css' );
	wp_enqueue_style( 'kitification-plugins', get_template_directory_uri() . '/css/plugins.min.css' );

	/* Custom CSS */
	if (!is_front_page())
		wp_enqueue_style( 'kitification-base', get_stylesheet_uri() );
	else
		wp_enqueue_style( 'v2', get_template_directory_uri() . '/css/v2.css' );

	/*
	 * Scripts
	 */

	/* Comments */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'kitification-plugins', get_template_directory_uri() . '/js/plugins.min.js', array( 'jquery' ), '20140515', true );
	wp_enqueue_script( 'kitification', get_template_directory_uri() . '/js/main.min.js', array( 'jquery', 'kitification-plugins' ), '20140515', true );


        // Start Tahir
        wp_enqueue_script('lightSlider-js', get_template_directory_uri()."/js/jquery.lightSlider.min.js", array('jquery'));
        wp_enqueue_script('light-gallery-js', get_template_directory_uri()."/js/lightGallery.min.js", array('jquery'));


        wp_enqueue_style('lightSlider_css', get_template_directory_uri().'/css/lightSlider.css');
        wp_enqueue_style('lightGallery_css', get_template_directory_uri().'/css/lightGallery.css');


        // End Tahir

	$kitification_js_settings = apply_filters( 'kitification_jsparams', array(
		'widgets' => array()
	) );

	/*
	 * Pass all widget settings to the JS so we can customize things
	 */
	global $wp_registered_widgets;

	$widgetized = wp_get_sidebars_widgets();
	$widgets    = isset( $widgetized[ 'home-1' ] ) ? $widgetized[ 'home-1' ] : null;

	if ( $widgets ) {
		foreach ( $widgets as $widget ) {
			if ( ! isset( $wp_registered_widgets[ $widget ] ) ) {
				continue;
			}

			$widget_obj = $wp_registered_widgets[ $widget ];
			$prefix     = substr( $widget_obj[ 'classname' ], 0, 7 ) == 'widget_' ? '' : 'widget_';
			$settings   = get_option( $prefix . $widget_obj[ 'classname' ] );

			if ( ! $settings )
				continue;

			$params = $settings[ $widget_obj[ 'params' ][0][ 'number' ] ];

			$kitification_js_settings[ 'widgets' ][ $widget ] = array(
				'cb'       => $widget_obj[ 'classname' ],
				'settings' => $params
			);

			// Suppliment stuff. Should probably be added to a hook
			if ( 'widget_woothemes_testimonials' == $widget_obj[ 'classname' ] && isset ( $params[ 'display_author' ] ) ) {
				$kitification_js_settings[ 'widgets' ][ $widget ][ 'settings' ][ 'speed' ] = apply_filters( $widget_obj[ 'classname' ] . '_scroll', 5000 );
			}
		}
	}

	wp_localize_script( 'kitification', 'kitificationSettings', $kitification_js_settings );

	/** Misc Support */
	wp_dequeue_style( 'edd-software-specs' );
}
add_action( 'wp_enqueue_scripts', 'kitification_scripts' );

/**
 * Adds custom classes to the array of body classes.
 */
function kitification_body_classes( $classes ) {
	global $wp_query;

	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( is_page_template( 'page-templates/home.php' ) ) {
		$classes[] = 'home-1';
	}

	if ( is_page_template( 'page-templates/home-search.php' ) ) {
		$classes[] = 'home-search';
	}

	if ( is_page_template( 'page-templates/minimal.php' ) ) {
		$classes[] = 'minimal';
	}

	if ( get_query_var( 'author_ptype' ) ) {
		$classes[] = 'archive-download';
	}

	if ( class_exists( 'EDD_Front_End_Submissions' ) && is_page( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page' ) ) ) {
		$classes[] = 'fes-page';
	}

	if ( class_exists( 'Love_It_Pro' ) ) {
		$classes[] = 'love-it-pro';
	}

	if ( is_singular( 'download' ) && 'classic' != kitification_theme_mod( 'product-display', 'product-display-single-style' ) ) {
		$classes[] = 'product-display-inline';
	}

	if ( is_singular( 'download' ) && kitification_theme_mod( 'product-display', 'product-display-show-buy' ) ) {
		$classes[] = 'force-buy';
	}

	return $classes;
}
add_filter( 'body_class', function( $classes ) {
    return array_merge( $classes, array( 'v2' ) );
} );
add_filter( 'body_class', 'kitification_body_classes' );

/**
 * Adds custom classes to the array of post classes.
 */
function kitification_post_classes( $classes ) {
	global $post;

	if ( '1' == kitification_theme_mod( 'product-display', 'product-display-grid-info' ) ) {
		$classes[] = 'force-info';
	} elseif ( '2' == kitification_theme_mod( 'product-display', 'product-display-grid-info' ) ) {
		$classes[] = 'hide-info';
	}

	if ( kitification_theme_mod( 'product-display', 'product-display-truncate-title' ) ) {
		$classes[] = 'truncate-title';
	}

	if ( kitification_theme_mod( 'product-display', 'product-display-aspect' ) ) {
		$classes[] = 'portrait';
	}

	return $classes;
}
add_filter( 'post_class', 'kitification_post_classes' );

/**
 * Append a searchform to the page content on the "Homepage (with Search)
 * page template.
 *
 * @since Kitification 1.1
 */
function kitification_homepage_search( $content ) {
	global $post;

	if ( ! is_a( $post, 'WP_Post' ) ) {
		return $content;
	}

	if ( 'page' != $post->post_type )
		return $content;

	if ( ! is_page_template( 'page-templates/home-search.php' ) )
		return $content;

	return $content . get_search_form(false);
}
add_filter( 'the_content', 'kitification_homepage_search' );

/**
 * Popular Categories
 *
 * @since Kitification 1.0
 */
function kitification_query_vars( $vars ) {
	$vars[] = 'popular_cat';
	$vars[] = 'm-orderby';
	$vars[] = 'm-order';

	return $vars;
}
add_filter( 'query_vars', 'kitification_query_vars' );

/**
 * Popular Categories links
 *
 * @since Kitification 1.0
 */
function kitification_popular_get_term_link( $link, $term, $taxonomy ) {
	if ( ! is_page_template( 'page-templates/popular.php' ) )
		return $link;

	global $wp_query;

	return add_query_arg( array( 'popular_cat' => $term->term_id ), get_permalink( get_page_by_path( $wp_query->query[ 'pagename' ] ) ) );
}
add_filter( 'term_link', 'kitification_popular_get_term_link', 10, 3 );

/**
 * Find pages that contain shortcodes.
 *
 * To avoid options, try to find pages for them.
 *
 * @since Kitification 1.2
 *
 * @return $_page
 */
function kitification_find_page_with_template( $template ) {
	$_page = 0;

	if ( ! get_option( 'kitification_page_' . sanitize_title( $template ) ) ) {
		$pages = new WP_Query( array(
			'post_type'              => 'page',
			'post_status'            => 'publish',
			'ignore_sticky_posts'    => 1,
			'no_found_rows'          => true,
			'nopaging'               => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'meta_query'             => array(
				array(
					'key' => '_wp_page_template',
					'value' => $template,
					'compare' => '='
				)
			)
		) );

		if ( $pages->have_posts() ) {
			$_page = $pages->post->ID;
		}

		add_option( 'kitification_page_' . sanitize_title( $template ), $_page );
	} else {
		$_page = get_option( 'kitification_page_' . sanitize_title( $template ) );
	}

	return $_page;
}

function kitification_edd_fes_author_url( $author = null ) {
	if ( ! $author ) {
		$author = wp_get_current_user();
	} else {
		$author = new WP_User( $author );
	}

	if ( ! class_exists( 'EDD_Front_End_Submissions' ) ) {
		return get_author_posts_url( $author->ID, $author->user_nicename );
	}

	return FES_Vendors::get_vendor_store_url( $author->ID );
}

function kitification_count_user_downloads( $userid, $post_type = 'download' ) {
	global $wpdb;

	$where = get_posts_by_author_sql( $post_type, true, $userid );

	$count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts $where" );

  	return apply_filters( 'get_usernumposts', $count, $userid );
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Widgets
 */
require get_template_directory() . '/inc/class-widget.php';
require get_template_directory() . '/inc/widgets/class-widget-slider.php';
require get_template_directory() . '/inc/widgets/class-widget-price-option.php';
require get_template_directory() . '/inc/widgets/class-widget-price-table.php';
require get_template_directory() . '/inc/widgets/class-widget-blog-posts.php';

if ( function_exists( 'soliloquy' ) ) {
	require get_template_directory() . '/inc/widgets/class-widget-slider-soliloquy.php';
}

/**
 * Integrations
 */

// TGM Plugin Activation
require_once( get_template_directory() . '/inc/tgmpa/plugins.php' );

// Jetpack
require get_template_directory() . '/inc/integrations/jetpack/jetpack.php';

// bbPress
if ( class_exists( 'bbPress' ) ) {
	require get_template_directory() . '/inc/integrations/bbpress/bbpress.php';
}

// Easy Digital Downloads
if ( class_exists( 'Easy_Digital_Downloads' ) ) {
	require get_template_directory() . '/inc/integrations/edd/edd.php';

	if ( class_exists( 'EDD_Front_End_Submissions' ) ) {
		require get_template_directory() . '/inc/integrations/edd-fes/fes.php';
	}

	if ( defined( 'EDD_CSAU_DIR' ) ) {
		require get_template_directory() . '/inc/integrations/edd-csau/csau.php';
	}

	if ( class_exists( 'EDD_Reviews' ) ) {
		require get_template_directory() . '/inc/integrations/edd-reviews/reviews.php';
	}

	if ( class_exists( 'EDDRecommendedDownloads' ) ) {
		require get_template_directory() . '/inc/integrations/edd-recommended/recommended.php';
	}

	if ( class_exists( 'EDD_Wish_Lists' ) ) {
		require get_template_directory() . '/inc/integrations/edd-wish-lists/edd-wish-lists.php';
	}
}

// WooThemes Features
if ( class_exists( 'Woothemes_Features' ) ) {
	require get_template_directory() . '/inc/integrations/woo-features/features.php';
}

// WooThemes Testimonials
if ( class_exists( 'Woothemes_Testimonials' ) ) {
	require get_template_directory() . '/inc/integrations/woo-testimonials/testimonials.php';
}

// WooTheme Projects
if ( class_exists( 'Projects' ) ) {
	require get_template_directory() . '/inc/integrations/woo-projects/projects.php';
}

// Love It
if ( defined( 'LI_BASE_DIR' ) || class_exists( 'Love_It_Pro' ) ) {
	require get_template_directory() . '/inc/integrations/love-it/love-it.php';
}


if(current_user_can('administrator')) {
    show_admin_bar(true);
} else {
    show_admin_bar(false);
}