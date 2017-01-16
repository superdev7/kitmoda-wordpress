<?php
/**
 *
 */

/**
 * Sidebars and Widgets
 *
 * @since Kitification 1.2
 *
 * @return void
 */
function kitification_projects_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Projects Single Sidebar', 'kitification' ),
		'id'            => 'sidebar-single-project',
		'before_widget' => '<aside id="%1$s" class="widget download-single-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="download-single-widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Projects Archive Sidebar', 'kitification' ),
		'id'            => 'sidebar-archive-project',
		'before_widget' => '<aside id="%1$s" class="widget download-archive-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="download-archive-widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'kitification_projects_widgets_init' );

if ( ! function_exists( 'kitification_project_client_link' ) ) :
/**
 * Download Purchase Link
 *
 * @since Kitification 1.0
 *
 * @return void
 */
function kitification_project_client_link() {
	global $post;

	$client = esc_attr( get_post_meta( $post->ID, '_client', true ) );
	$url    = esc_url( get_post_meta( $post->ID, '_url', true ) );

	if ( ! $url )
		return;

	printf( '<a href="%s" class="button">%s</a>', $url, __( 'Visit Project' ) );
}
add_action( 'kitification_project_actions', 'kitification_project_client_link' );
endif;

function kitification_single_project_content_before_content() {
	if ( 'grid' != kitification_theme_mod( 'product-display', 'product-display-single-style' ) )
		return;

	global $post;

	$attachment_ids = projects_get_gallery_attachment_ids( $post->ID );
	$before         = '<div class="download-image-grid-preview">';
	$after          = '</div>';

	echo $before;
	?>

	<div class="row">
		<div class="col-sm-12 image-preview">
			<a id="1" href="<?php echo wp_get_attachment_url( current( $attachment_ids ) ); ?>" class="image-preview-gallery"><?php echo wp_get_attachment_image( current( $attachment_ids ), 'large' ); ?></a>
		</div>

		<div class="col-sm-12 image-grid-previewer">
			<ul class="slides row">
				<?php $i = 1; foreach ( $attachment_ids as $image ) : ?>
				<li class="col-lg-2 col-md-3 col-sm-4 col-xs-6"><a id="<?php echo $i; ?>" href="<?php echo wp_get_attachment_url( $image->ID ); ?>" class="image-preview-gallery"><?php echo wp_get_attachment_image( $image, 'large' ); ?></a></li>
				<?php $i++; endforeach; ?>
			</ul>
		</div>
	</div>

	<?php
	echo $after;
}
add_action( 'kitification_single_project_content_before_content', 'kitification_single_project_content_before_content' );

if ( ! function_exists( 'kitification_project_standard_player' ) ) :
/**
 * Featured Area: Standard (Images)
 *
 * @since Kitification 1.2
 *
 * @return void
 */
function kitification_project_standard_player() {
	global $post;

	if ( 'grid' == kitification_theme_mod( 'product-display', 'product-display-single-style' ) )
		return;

	$images = projects_get_gallery_attachment_ids();
	$before = '<div class="download-image">';
	$after  = '</div>';

	$before = '<div class="download-image flexslider">';

	echo $before;
	?>

	<ul class="slides">
		<?php foreach ( $images as $image ) : ?>
		<li><?php echo wp_get_attachment_image( $image, 'fullsize' ); ?></li>
		<?php endforeach; ?>
	</ul>

	<?php
	echo $after;
}
add_action( 'kitification_project_featured_area', 'kitification_project_standard_player' );
endif;