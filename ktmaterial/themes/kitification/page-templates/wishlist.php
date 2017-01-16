<?php
/**
 * Template Name: Likes
 *
 * @package Kitification
 */

$author = get_query_var( 'author_wishlist' );

if ( ! $author ) {
	$author = get_current_user_id();
}

$author = new WP_User( $author );

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

	<header class="page-header">
		<h1 class="page-title"><?php the_title(); ?></h1>
	</header><!-- .page-header -->

	<?php do_action( 'kitification_entry_before' ); ?>

	<div class="container">
		<div id="content" class="site-content row">

			<div id="secondary" class="author-widget-area col-md-3 col-sm-5 col-xs-12" role="complementary">
				<div class="download-product-details author-archive">
					<div class="download-author">
						<?php echo get_avatar( $author->ID, 130 ); ?>
						<a href="#" class="author-link"><?php echo esc_attr( $author->display_name ); ?></a>
						<span class="author-joined"><?php printf( __( 'Author since: %s', 'kitification' ), date_i18n( 'Y', strtotime( $author->user_registered ) ) ); ?></span>
					</div>

					<div class="download-author-bio">
						<?php echo esc_attr( $author->description ); ?>
					</div>

					<div class="download-author-sales">
						<?php
							$loves = get_user_option( 'li_user_loves', $author->ID );

							if ( ! is_array( $loves ) ) {
								$loves = array();
							}
						?>

						<strong><?php echo count( $loves ); ?></strong>

						<?php echo _n( 'Like', 'Likes', count( $loves ), 'kitification' ); ?>
					</div>

					<?php if ( kitification_entry_author_social( $author->ID ) ) : ?>
					<div class="download-author-social">
						<?php echo kitification_entry_author_social( $author->ID ); ?>
					</div>
					<?php endif; ?>
				</div>
			</div><!-- #secondary -->

			<section id="primary" class="content-area col-md-9 col-sm-7 col-xs-12">
				<main id="main" class="site-main" role="main">

					<?php the_content(); ?>

				</main><!-- #main -->
			</section><!-- #primary -->

		</div><!-- #content -->
	</div>

	<?php endwhile; ?>

<?php get_footer(); ?>