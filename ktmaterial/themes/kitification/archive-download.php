<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Kitification
 */

get_header(); ?>

	<header class="page-header">
		<h1 class="page-title">
			<?php if ( is_tax() ) : ?>
				<?php single_term_title(); ?>
			<?php elseif ( is_search() ) : ?>
				<?php echo esc_attr( get_search_query() ); ?>
			<?php else : ?>
				<?php echo apply_filters( 'kitification_downloads_archive_title', edd_get_label_plural() ); ?>
			<?php endif; ?>
		</h1>
	</header><!-- .page-header -->

	<?php do_action( 'kitification_entry_before' ); ?>

	<div class="container">

		<?php if ( ! is_paged() && ! get_query_var( 'm-orderby' ) ) : ?>
			<?php get_template_part( 'content-grid-download', 'popular' ); ?>
		<?php endif; ?>

		<div id="content" class="site-content row">

			<section id="primary" class="content-area col-md-<?php echo is_active_sidebar( 'sidebar-download' ) ? '9' : '12'; ?> col-sm-7 col-xs-12">
				<main id="main" class="site-main" role="main">

				<div class="section-title"><span>
					<?php if ( is_search() ) : ?>
						<?php printf( '&quot;%s&quot;', esc_attr( get_search_query() ) ); ?>
					<?php else : ?>
						<?php kitification_downloads_section_title(); ?>
					<?php endif; ?>
				</span></div>

				<?php if ( have_posts() ) : ?>

					<div class="download-grid-wrapper columns-<?php echo kitification_theme_mod( 'product-display', 'product-display-columns' ); ?> row" data-columns>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'content-grid', 'download' ); ?>
						<?php endwhile; ?>
					</div>

					<?php kitification_content_nav( 'nav-below' ); ?>

				<?php else : ?>

					<?php get_template_part( 'no-results', 'download' ); ?>

				<?php endif; ?>

				</main><!-- #main -->
			</section><!-- #primary -->

			<?php get_sidebar( 'archive-download' ); ?>

		</div><!-- #content -->
	</div>

<?php get_footer(); ?>