<?php
/**
 * @package Kitification
 */

// Are we on a homepage widget?
$is_home = is_page_template( 'page-templates/home.php' ) || is_page_template( 'page-templates/home-search.php' );

global $more;

$more = 0;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'row' ); ?>>
	<?php if ( has_post_thumbnail() && ! $is_home ) : ?>
	<div class="col-md-3 col-sm-4 col-xs-12 blog-archive-image">
		<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
	</div>
	<?php endif; ?>

	<div class="<?php echo has_post_thumbnail() && ! $is_home ? 'col-md-9 col-sm-8 ' : ''; ?>col-xs-12">
		<header class="entry-header">
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

			<div class="entry-meta">
				<?php
					printf(
						__( '<span class="byline">%1$s</span>', 'kitification' ),
						sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s %4$s</a></span>',
							esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
							esc_attr( sprintf( __( 'View all posts by %s', 'kitification' ), get_the_author() ) ),
							get_avatar( get_the_author_meta( 'ID' ), 50, apply_filters( 'kitification_default_avatar', null ) ),
							esc_html( get_the_author_meta( 'display_name' ) )
						)
					);
				?>

				<span class="entry-date">
					<i class="icon-calendar"></i> <?php echo get_the_date(); ?>
				</span>

				<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
				<span class="comments-link"><?php comments_popup_link( __( '<i class="icon-chat"></i> 0 Comments', 'kitification' ), __( '<i class="icon-chat"></i> 1 Comment', 'kitification' ), __( '<i class="icon-chat"></i> % Comments', 'kitification' ) ); ?></span>
				<?php endif; ?>

				<?php edit_post_link( __( '<i class="icon-pencil"></i> Edit', 'kitification' ), '<span class="edit-link">', '</span>' ); ?>
			</div><!-- .entry-meta -->
		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	</div>
</article><!-- #post-## -->
