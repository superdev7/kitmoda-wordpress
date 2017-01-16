<?php
/**
 * Download Details
 *
 * @since Kitification 1.0
 */
class Kitification_Widget_Download_Review_Details extends Kitification_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'kitification_widget_download_review_details';
		$this->widget_description = __( 'Display average review information.', 'kitification' );
		$this->widget_id          = 'kitification_widget_download_review_details';
		$this->widget_name        = __( 'Kitification - Download Single: Review Details ', 'kitification' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => 'Review Details',
				'label' => __( 'Title:', 'kitification' )
			)
		);
		parent::__construct();
	}

	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) )
			return;

		global $post;

		ob_start();

		extract( $args );

		$reviews = get_comments( apply_filters( 'edd_reviews_average_rating_query_args', array(
			'post_id' => $post->ID
		) ) );

		$total_ratings = 0;

		foreach ( $reviews as $review ) {
			$rating = get_comment_meta( $review->comment_ID, 'edd_rating', true );
			$total_ratings += $rating;
		}

		$total = wp_count_comments( $post->ID )->total_comments;

		if ( 0 == $total )
			$total = 1;

		$average = $total_ratings / $total;

		$title   = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$reviews = edd_reviews();

		echo $before_widget;

		if ( $title ) echo '<h1 class="section-title"><span>' . $title . '</span></h1>';
		?>
			<div class="download-product-review-details">
				<h1 class="download-single-widget-title"><?php _e( 'Buyer Ratings', 'kitification' ); ?></h1>

				<?php $rating = $reviews->average_rating( false ); ?>
				<div class="download-ratings">
					<strong>
						<?php for ( $i = 1; $i <= $rating; $i++ ) : ?>
						<i class="icon-star"></i>
						<?php endfor; ?>

						<?php for( $i = 0; $i < ( 5 - $rating ); $i++ ) : ?>
						<i class="icon-star2"></i>
						<?php endfor; ?>
					</strong>
				</div>

				<p><?php printf( __( '%s average based on %d reviews.', 'kitification' ), sprintf( "%0.2f", $average ), wp_count_comments( $post->ID )->total_comments ); ?></p>

				<?php echo $reviews->maybe_show_review_breakdown(); ?>
			</div>
		<?php
		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}