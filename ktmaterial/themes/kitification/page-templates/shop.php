<?php
/**
 * Template Name: Shop
 *
 * Load the [downloads] shortcode.
 *
 * @package Kitification
 */

get_header(); ?>

	<header class="page-header">
		<h1 class="page-title"><?php the_title(); ?></h1>
	</header><!-- .page-header -->

	<?php do_action( 'kitification_entry_before' ); ?>

	<div class="container">

		<?php if ( ! is_paged() && ! get_query_var( 'm-orderby' ) && ! is_page_template( 'page-templates/popular.php' ) ) : ?>
			<?php get_template_part( 'content-grid-download', 'popular' ); ?>
		<?php endif; ?>

		<div id="content" class="site-content row">

			<section id="primary" class="content-area col-md-<?php echo is_active_sidebar( 'sidebar-download' ) ? '9' : '12'; ?> col-sm-7 col-xs-12">
				<main id="main" class="site-main" role="main">

				<div class="section-title"><span>
					<?php kitification_downloads_section_title(); ?>
				</span></div>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php if ( '' == get_the_content() ) : ?>
						<?php echo do_shortcode( sprintf( '[downloads number="%s"]', get_option( 'posts_per_page' ) ) ); ?>
					<?php else : ?>
						<?php the_content(); ?>
					<?php endif; ?>

				<?php endwhile; ?>

				</main><!-- #main -->
			</section><!-- #primary -->

			<?php get_sidebar( 'archive-download' ); ?>

		</div><!-- #content -->
	</div>

<?php get_footer(); ?>