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
		<h1 class="page-title"><?php _e( 'Projects', 'kitification' ); ?></h1>
	</header><!-- .page-header -->

	<?php do_action( 'kitification_entry_before' ); ?>

	<div class="container">

		<div id="content" class="site-content row">

			<section id="primary" class="content-area col-md-<?php echo is_active_sidebar( 'sidebar-archive-project' ) ? '9' : '12'; ?> col-sm-7 col-xs-12">
				<main id="main" class="site-main" role="main">

				<div class="section-title"><span>
					<?php if ( is_tax( 'project-category' ) ) : ?>
						<?php single_term_title( '' ); ?>
					<?php else : ?>
						<?php _e( 'All Projects', 'kitification' ); ?>
					<?php endif; ?>
				</span></div>

				<?php if ( have_posts() ) : ?>

					<div class="row">
						<?php while ( have_posts() ) : the_post(); ?>

							<div class="col-lg-4 col-md-6 col-sm-12">
								<?php get_template_part( 'content-grid', 'project' ); ?>
							</div>

						<?php endwhile; ?>
					</div>

					<?php kitification_content_nav( 'nav-below' ); ?>

				<?php else : ?>

					<?php get_template_part( 'no-results', 'download' ); ?>

				<?php endif; ?>

				</main><!-- #main -->
			</section><!-- #primary -->

			<?php get_sidebar( 'archive-project' ); ?>

		</div><!-- #content -->
	</div>

<?php get_footer(); ?>