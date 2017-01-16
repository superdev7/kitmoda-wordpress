<?php
/**
 * Template Name: Minimal
 *
 * @package Kitification
 */

get_header( 'minimal' ); ?>

	<div class="container">
		<div id="content" class="site-content row">
			<main id="primary" class="content-area col-lg-5 col-lg-offset-3 col-sm-8 col-sm-offset-2" role="main">

				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', 'page' ); ?>

					<?php endwhile; ?>

				<?php else : ?>

					<?php get_template_part( 'no-results', 'index' ); ?>

				<?php endif; ?>

			</main><!-- #main -->
		</div>
	</div>
	
<?php get_footer( 'minimal' ); ?>