<?php
/**
 * @package Kitification
 */

global $post;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'content-grid-download' ); ?>>
	<div class="entry-image">
		<div class="overlay">
			<?php do_action( 'kitification_content_image_overlay_before' ); ?>

			<div class="actions">
				<a href="<?php the_permalink(); ?>" rel="bookmark" class="button"><?php _e( 'Read More', 'kitification' ); ?></a>
			</div>

			<strong class="item-price">
				<span><?php comments_number( __( '0 Comments', 'kitification' ), __( '1 Comment', 'kitification' ), __( '%s Comments', 'kitification' ) ); ?></span>
			</strong>

			<?php do_action( 'kitification_content_image_overlay_after' ); ?>
		</div>

		<?php the_post_thumbnail( 'content-grid-download' ); ?>
	</div>

	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<div class="entry-meta">
			<?php do_action( 'kitification_entry_meta_before_' . get_post_format() ); ?>

			<?php
				printf(
					__( '<span class="byline"> by %1$s</span>', 'kitification' ),
					sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s %4$s</a></span>',
						get_author_posts_url( get_the_author_meta( 'ID' ) ),
						esc_attr( sprintf( __( 'View all posts by %s', 'kitification' ), get_the_author() ) ),
						esc_html( get_the_author_meta( 'display_name' ) ),
						get_avatar( get_the_author_meta( 'ID' ), 50, apply_filters( 'kitification_default_avatar', null ) )
					)
				);
			?>

			<?php do_action( 'kitification_entry_meta_after_' . get_post_format() ); ?>
		</div>
	</header><!-- .entry-header -->
</article><!-- #post-## -->
