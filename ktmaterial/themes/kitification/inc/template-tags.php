<?php
/**
 * Custom template tags for this theme.
 *
 * If the function is called directly in the theme or via
 * another function, it is wrapped to check if a child theme has
 * redefined it. Otherwise a child theme can unhook what is being attached.
 *
 * @package Kitification
 */

function kitification_downloads_section_title() {
	if ( is_page_template( 'page-templates/popular.php' ) ) {
		$cat = get_term( get_query_var( 'popular_cat' ), 'download_category' );

		if ( is_wp_error( $cat ) ) {
			$base = '';
		} else {
			$base = $cat->name;
		}

		printf( __( 'Popular %s', 'kitification' ), $base );
	} else {
		$base  = is_tax() ? single_term_title( '', false ) : edd_get_label_plural();
		$order = get_query_var( 'm-orderby' ) ? sprintf( '&nbsp;' . __( 'by %s', 'kitification' ), kitification_edd_sorting_options( get_query_var( 'm-orderby' ) ) ) : '';

		printf( __( 'All %s%s', 'kitification' ), $base, $order );
	}
}

if ( ! function_exists( 'kitification_entry_author_social' ) ) :
/**
 * Social Links
 *
 * @since Kitification 1.0
 *
 * @return void
 */
function kitification_entry_author_social( $user_id = null ) {
	global $post;

	$methods = _wp_get_user_contactmethods();
	$social  = array();

	if ( ! $user_id )
		$user_id = get_the_author_meta( 'ID' );

	foreach ( $methods as $key => $method ) {
		$field = get_the_author_meta( $key, $user_id );

		if ( ! $field )
			continue;

		$social[ $key ] = sprintf( '<a href="%1$s" target="_blank"><i class="icon-%2$s"></i></a>', $field, $key );
	}

	$social = implode( ' ', $social );

	return $social;
}
endif;

if ( ! function_exists( 'kitification_comment' ) ) :
/**
 * Comments
 *
 * @since Kitification 1.0
 *
 * @return void
 */
function kitification_comment( $comment, $args, $depth ) {
	global $post;

	$GLOBALS['comment'] = $comment;
?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">

			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>

					<?php if ( $depth == 1 ) : ?>
						<?php printf( '<cite class="fn">%s</cite>', get_comment_author_link() ); ?>

						<?php
							if ( get_option( 'comment_registration' ) && edd_has_user_purchased( $comment->user_id, $post->ID ) ) :
						?>
							<a class="button purchased"><?php _e( 'Purchased', 'kitification' ); ?></a>
						<?php endif; ?>
					<?php endif; ?>
				</div><!-- .comment-author -->
			</footer><!-- .comment-meta -->

			<div class="comment-content">
				<div class="comment-metadata">
					<?php printf( '<cite class="fn">%s</cite>', get_comment_author_link() ); ?>

					<?php if ( get_comment_meta( $comment->comment_ID, 'edd_rating', true ) ) : ?>
						<?php do_action( 'kitification_edd_rating', $comment ); ?>
					<?php endif; ?>

					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'kitification' ), get_comment_date(), get_comment_time() ); ?>
						</time>
					</a>

					<?php
						comment_reply_link( array_merge( $args, array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<span class="reply-link"> &mdash; ',
							'after'     => '</span>',
						) ) );
					?>

					<?php edit_comment_link( __( 'Edit', 'kitification' ), ' &mdash; <span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-metadata -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'kitification' ); ?></p>
				<?php endif; ?>

				<?php comment_text(); ?>
			</div><!-- .comment-content -->

		</article><!-- .comment-body -->

	<?php
}
endif;

if ( ! function_exists( 'kitification_get_theme_menu' ) ) :
/**
 * Get a nav menu object.
 *
 * @uses get_nav_menu_locations To get all available locations
 * @uses get_term To get the specific theme location
 *
 * @since Kitification 1.0
 *
 * @param string $theme_location The slug of the theme location
 * @return object $menu_obj The found menu object
 */
function kitification_get_theme_menu( $theme_location ) {
	$theme_locations = get_nav_menu_locations();

	if( ! isset( $theme_locations[$theme_location] ) )
		return false;

	$menu_obj = get_term( $theme_locations[$theme_location], 'nav_menu' );

	if( ! $menu_obj )
		return false;

	return $menu_obj;
}
endif;

if ( ! function_exists( 'kitification_get_theme_menu_name' ) ) :
/**
 * Get a nav menu name
 *
 * @uses kitification_get_theme_menu To get the menu object
 *
 * @since Kitification 1.0
 *
 * @param string $theme_location The slug of the theme location
 * @return string The name of the nav menu location
 */
function kitification_get_theme_menu_name( $theme_location ) {
	$menu_obj = kitification_get_theme_menu( $theme_location );
	$default  = _x( 'Menu', 'noun', 'kitification' );

	if( ! $menu_obj )
		return $default;

	if( ! isset( $menu_obj->name ) )
		return $default;

	return $menu_obj->name;
}
endif;

if ( ! function_exists( 'kitification_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function kitification_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'kitification' ); ?></h1>

		<?php
			$big = 999999999;

			echo paginate_links( array(
				'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'  => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total'   => $wp_query->max_num_pages
			) );
		?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif;