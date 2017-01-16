<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Kitification
 */

get_header(); ?>

	<header class="page-header">
		<?php if ( is_search() ) : ?>
			<h1 class="page-title"><?php printf( __( 'Search Results: %s', 'kitification' ), esc_attr( get_search_query() ) ); ?></h1>
		<?php else : ?>
			<h1 class="page-title"><?php echo get_option( 'page_for_posts' ) ? get_the_title( get_option( 'page_for_posts' ) ) : _x( 'Blog', 'blog page title', 'kitification' ); ?></h1>
		<?php endif; ?>
	</header><!-- .page-header -->

	<?php do_action( 'kitification_entry_before' ); ?>

	<div class="container">
		<div id="content" class="site-content row">

			<div id="primary" class="content-area col-md-<?php echo is_active_sidebar( 'sidebar-1' ) ? '8' : '12'; ?>">
				<main id="main" class="site-main" role="main">

				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', get_post_format() ); ?>

					<?php endwhile; ?>

					<?php kitification_content_nav( 'nav-below' ); ?>

				<?php else : ?>

					<?php get_template_part( 'no-results', 'index' ); ?>

				<?php endif; ?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<?php get_sidebar(); ?>
			
		</div>
	</div>
	
<?php get_footer(); ?>