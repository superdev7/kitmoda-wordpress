<?php
/**
 * Template Name: The Team
 *
 * @package Kitification
 */

get_header(); ?>

	<?php do_action( 'kitification_entry_before' ); ?>

	<div class="container">
		<div id="content" class="site-content row">

			<div id="primary" class="content-area col-sm-12">
				<main id="main" class="site-main" role="main">

				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', 'page' ); ?>

						<div class="row">
						<?php
							$users = array();
							$roles = apply_filters( 'kitification_the_team_roles', array( 'author', 'shop_worker', 'shop_manager', 'editor', 'administrator' ) );

							foreach ( $roles as $role ) {
								$user_ids = get_users( array(
									'role'    => $role,
									'fields'  => 'IDs'
								) );

								foreach( $user_ids as $user_id ) {
									$users[] = $user_id;
								}
							}

							foreach ( $users as $user_id ) :
						?>

						<div class="col-lg-3 col-md-4 col-xs-6 entry-author">
							<?php
								$social = kitification_entry_author_social( $user_id );

								printf( '<div class="gravatar">%1$s %2$s</div>',
									sprintf( '<div class="author-social">%1$s</div>', $social ),
									get_avatar( $user_id, 400 )
								);
							?>
							<?php
								printf( '<span class="byline"><span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span></span>',
									esc_url( get_author_posts_url( $user_id ) ),
									esc_attr( sprintf( __( 'View all posts by %s', 'kitification' ), get_the_author_meta( 'display_name', $user_id ) ) ),
									esc_html( get_the_author_meta( 'display_name', $user_id ) )
								);
							?>
							<?php echo wpautop( get_the_author_meta( 'description', $user_id ) ); ?>
						</div>

						<?php endforeach; ?>
						</div>

						<?php
							// If comments are open or we have at least one comment, load up the comment template
							if ( comments_open() || '0' != get_comments_number() )
								comments_template();
						?>

					<?php endwhile; ?>

					<?php kitification_content_nav( 'nav-below' ); ?>

				<?php else : ?>

					<?php get_template_part( 'no-results', 'index' ); ?>

				<?php endif; ?>

				</main><!-- #main -->
			</div><!-- #primary -->

		</div>
	</div>

<?php get_footer(); ?>