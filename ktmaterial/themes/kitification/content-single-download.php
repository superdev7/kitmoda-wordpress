<?php
/**
 * @package Kitification
 */
?>

<?php do_action( 'kitification_single_download_content_before_content' ); ?>

<?php if ( get_post()->post_content ) : ?>
<h2 class="section-title"><span><?php printf( __( 'About the %s', 'kitification' ), edd_get_label_singular() ); ?></span></h2>
<?php endif; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php do_action( 'kitification_single_download_content_before' ); ?>

		<?php the_content(); ?>

		<?php do_action( 'kitification_single_download_content_after' ); ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'kitification' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php locate_template( array( 'modal-download-purchase.php' ), true, false ); ?>
</article><!-- #post-## -->

<?php do_action( 'kitification_single_download_after_content' ); ?>
