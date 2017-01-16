<?php
/**
 * @package Kitification
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'content-grid-download' ); ?>>
	<?php edd_get_template_part( 'shortcode', 'content-image' ); ?>

	<?php edd_get_template_part( 'shortcode', 'content-title' ); ?>
</article><!-- #post-## -->
