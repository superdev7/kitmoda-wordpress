<?php
/**
 * Wish List template
 *
 *
 * @since 1.0
*/

$list_id = get_query_var( 'view' );

// gets the list
$downloads = edd_wl_get_wish_list( $list_id );

if ( ! is_array( $downloads ) ) {
	return;
}

$downloads = wp_list_pluck( $downloads, 'id' );

$downloads = new WP_Query( array(
	'post_type'   => 'download',
	'post_status' => 'publish',
	'post__in'    => $downloads
) );

// get list post object
$list = get_post( $list_id );
// title
remove_filter( 'the_title', 'edd_wl_the_title', 10, 2 );
//status
$privacy = get_post_status( $list_id );

?>
<p><?php echo $list->post_content; ?></p>

<?php if ( $downloads->have_posts() ) : ?>

	<?php
		/**
		 * All all items in list to cart
		*/
		echo '<p>' . edd_wl_add_all_to_cart_link( $list_id ) . '</p>';
	?>


	<div class="row">
		<?php while ( $downloads->have_posts() ) : $downloads->the_post(); ?>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<?php get_template_part( 'content-grid', 'download' ); ?>
			</div>
		<?php endwhile; ?>
	</div>

	<?php
	/**
	 * Sharing - only shown for public lists
	*/
	if ( 'private' !== get_post_status( $list_id ) ) : ?>
		<div class="edd-wl-sharing">
			<h3>
				<?php _e( 'Share', 'edd-wish-lists' ); ?>
			</h3>
			<p>
				<?php
				/**
				 * Shortlink to share
				 */
				echo wp_get_shortlink( $list_id );
				?>
			</p>
			<p>
				<?php
				/**
				 * Share via email
				 */
				echo edd_wl_share_via_email_link();
				?>
			</p>
			<?php
				/**
				 * Social sharing services
				 */
				echo edd_wl_sharing_services();
			?>
		</div>
	<?php endif; ?>

<?php endif; ?>

<?php
/**
 * Edit list
*/
if ( edd_wl_is_users_list( $list_id ) ) : ?>

	<p><a href="<?php echo edd_wl_get_wish_list_edit_uri( $list_id ); ?>"><?php printf( __( 'Edit %s', 'edd-wish-lists' ), edd_wl_get_label_singular( true ) ); ?></a></p>

<?php endif; wp_reset_query(); ?>