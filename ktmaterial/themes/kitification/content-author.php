<?php
/**
 *
 * @since Kitification 1.0
 */

if ( is_singular( 'page' ) || ( function_exists( 'is_bbpress' ) && is_bbpress() ) )
	return;

global $post;
?>

<section class="entry-author">
	<?php
		$social = kitification_entry_author_social();

		printf( '<div class="gravatar">%1$s %2$s</div>',
			sprintf( '<div class="author-social">%1$s</div>', $social ),
			get_avatar( get_the_author_meta( 'ID' ), 140 )
		);
	?>
	<?php
		printf( '<span class="byline"><span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'kitification' ), get_the_author() ) ),
			esc_html( get_the_author() )
		);
	?>
</section>