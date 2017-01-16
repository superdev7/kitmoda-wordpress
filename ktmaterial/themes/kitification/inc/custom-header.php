<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package Kitification
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * @uses kitification_header_style()
 * @uses kitification_admin_header_style()
 * @uses kitification_admin_header_image()
 *
 * @package Kitification
 */
function kitification_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'kitification_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => 'fff',
		'width'                  => 150,
		'height'                 => 55,
		'flex-height'            => true,
		'flex-width'             => true,
		'wp-head-callback'       => 'kitification_header_style',
		'admin-head-callback'    => 'kitification_admin_header_style',
		'admin-preview-callback' => 'kitification_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'kitification_custom_header_setup' );

if ( ! function_exists( 'kitification_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see kitification_custom_header_setup().
 */
function kitification_header_style() {
	$header_text_color = get_header_textcolor();
?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		.site-branding .site-title,
		.site-branding .site-description,
		.site-header-minimal .site-title,
		.site-header-minimal .site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		$header_text_color = 'fff';
		// If the user has set a custom color for the text use that
		endif;
	?>
	.site-title a,
	.site-description,
	.main-navigation a {
		color: #<?php echo $header_text_color; ?>;
	}

	.site-title {
		line-height: <?php echo get_custom_header()->height; ?>px
	}
	</style>
	<?php
}
endif; // kitification_header_style

if ( ! function_exists( 'kitification_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see kitification_custom_header_setup().
 */
function kitification_admin_header_style() {
	$header_image = get_custom_header();
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
			background-color: <?php echo kitification_theme_mod( 'colors', 'primary' ); ?>;
			padding: 40px;
			width: auto;
		}

		#headimg h1,
		#desc {
		}

		#headimg h1 {
			margin: 0 0 0 40px;
			font-family: 'Montserrat', sans-serif;
			font-weight: 700;
			text-transform: uppercase;
			font-size: 26px;
			clear: none;
			line-height: <?php echo get_custom_header()->height; ?>px
		}

		#headimg h1 a {
			text-decoration: none;
		}

		#desc {
			display: none;
		}

		#headimg img {
			float: left;
		}
	</style>
<?php
}
endif; // kitification_admin_header_style

if ( ! function_exists( 'kitification_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see kitification_custom_header_setup().
 */
function kitification_admin_header_image() {
	$style        = sprintf( ' style="color:#%s;"', get_header_textcolor() );
	$header_image = get_header_image();
?>
	<div id="headimg">
		<?php if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="">
		<?php endif; ?>

		<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div class="displaying-header-text" id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
	</div>
<?php
}
endif; // kitification_admin_header_image
