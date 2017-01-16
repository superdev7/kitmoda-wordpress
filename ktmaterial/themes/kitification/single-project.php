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
		<?php the_post(); ?>
		<h1 class="page-title"><?php the_title(); ?></h1>

		<div class="download-actions">
			<?php do_action( 'kitification_project_actions' ); ?>
		</div>

		<div class="download-info">
			<?php do_action( 'kitification_project_info' ); ?>
		</div>

		<div class="featured-image container">
			<?php do_action( 'kitification_project_featured_area' ); ?>
		</div>
		<?php rewind_posts(); ?>
	</header><!-- .page-header -->

	<?php do_action( 'kitification_entry_before' ); ?>

	<div class="container">
		<div id="content" class="site-content row">

			<section id="primary" class="content-area <?php echo ! is_active_sidebar( 'sidebar-single-project' ) ? 'col-xs-12' : 'col-md-8 col-sm-7 col-xs-12'; ?>">
				<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content-single', 'project' ); ?>
				<?php endwhile; rewind_posts(); ?>

				</main><!-- #main -->
			</section><!-- #primary -->

			<?php get_sidebar( 'single-project' ); ?>

		</div><!-- #content -->

		<?php do_action( 'kitification_single_download_after' ); ?>
	</div>

<?php get_footer(); ?>