<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to kitification_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package Kitification
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area row">

	<section class="<?php echo ! is_active_sidebar( 'sidebar-download-single-comments' ) || ! is_singular( 'download' ) ? 'col-xs-12' : 'col-sm-8 col-xs-12'; ?>">


		<h2 class="comments-title section-title"><span>
			<?php if ( class_exists( 'EDD_Reviews' ) && is_singular( 'download' ) ) : ?>
				<?php $reviews = edd_reviews(); $reviews->reviews_title( $reviews->average_rating( false )); ?>
			<?php else : ?>
				<?php _e( 'Comments', 'kitification' ); ?>
			<?php endif; ?>
		</span></h2>

		<?php if ( have_comments() ) : ?>
			<ol class="comment-list">
				<?php
					/* Loop through and list the comments. Tell wp_list_comments()
					 * to use kitification_comment() to format the comments.
					 * If you want to override this in a child theme, then you can
					 * define kitification_comment() and that will be used instead.
					 * See kitification_comment() in inc/template-tags.php for more.
					 */
					wp_list_comments( array( 'callback' => 'kitification_comment', 'avatar_size' => 180 ) );
				?>
			</ol><!-- .comment-list -->

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<nav id="comment-nav-below" class="comment-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'kitification' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( '<i class="icon-arrow-left4"></i> <span class="nav-title">' . __( 'Older Comments', 'kitification' ) . '</span>' ); ?></div>
				<div class="nav-next"><?php next_comments_link( '<span class="nav-title">' . __( 'Newer Comments', 'kitification' ) . '</span> <i class="icon-arrow-right4"></i>' ); ?></div>
			</nav><!-- #comment-nav-below -->
			<?php endif; // check for comment navigation ?>

		<?php endif; // have_comments() ?>

		<?php
			comment_form( array(
				'comment_notes_after' => ''
			) );
		?>
	</section>

	<?php get_sidebar( 'single-download-comments' ); ?>

</div><!-- #comments -->