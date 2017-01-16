<?php
/**
 * Download Details
 *
 * @since Kitification 1.0
 */
class Kitification_Widget_Download_Details extends Kitification_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'kitification_widget_download_details';
		$this->widget_description = __( 'Display information related to the current download', 'kitification' );
		$this->widget_id          = 'kitification_widget_download_details';
		$this->widget_name        = __( 'Kitification - Download Single: Product Details', 'kitification' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => 'Product Details',
				'label' => __( 'Title:', 'kitification' )
			),
			'purchase-count' => array(
				'type'  => 'checkbox',
				'std'   => '',
				'label' => __( 'Hide purchase count', 'kitification' )
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

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$count = isset( $instance[ 'purchase-count' ] ) && 1 == $instance[ 'purchase-count' ] ? false : true;

		echo $before_widget;

		if ( $title ) echo '<h1 class="section-title"><span>' . $title . '</span></h1>';

		do_action( 'kitification_product_details_widget_before', $instance );

		?>
			<div class="download-product-details">
				<?php do_action( 'kitification_product_details_before', $instance ); ?>

				<div class="download-author">
					<?php do_action( 'kitification_download_author_before' ); ?>
					<?php printf( '<a class="author-link" href="%s" rel="author">%s</a>', kitification_edd_fes_author_url( get_the_author_meta( 'ID' ) ), get_avatar( get_the_author_meta( 'ID' ), 130 ) ); ?>
					<?php printf( '<a class="author-link" href="%s" rel="author">%s</a>', kitification_edd_fes_author_url( get_the_author_meta( 'ID' ) ), get_the_author() ); ?>
					<span class="author-joined"><?php printf( __( 'Author since: %s', 'kitification' ), date_i18n( get_option( 'date_format' ), strtotime( get_the_author_meta( 'user_registered' ) ) ) ); ?></span>
					<?php do_action( 'kitification_download_author_after' ); ?>
				</div>

				<?php if ( $count ) : ?>
				<div class="download-purchases">
					<strong><?php echo edd_get_download_sales_stats( get_the_ID() ); ?></strong>
					<?php echo _n( 'Purchase', 'Purchases', edd_get_download_sales_stats( get_the_ID() ), 'kitification' ); ?>
				</div>
				<?php endif; ?>

				<?php if ( class_exists( 'EDD_Reviews' ) ) : ?>
				<?php $rating = edd_reviews()->average_rating( false ); ?>
				<div class="download-ratings <?php echo ! $count ? 'full' : ''; ?>">
					<a href="#comments"><strong>
						<?php for ( $i = 1; $i <= $rating; $i++ ) : ?>
						<i class="icon-star"></i>
						<?php endfor; ?>

						<?php for( $i = 0; $i < ( 5 - $rating ); $i++ ) : ?>
						<i class="icon-star2"></i>
						<?php endfor; ?>
					</strong>
					<?php _e( 'Average Rating', 'kitification' ); ?></a>
				</div>
				<?php else : ?>
				<div class="download-comments <?php echo ! $count ? 'full' : ''; ?>">
					<a href="#comments"><strong><?php echo get_comments_number(); ?></strong>
					<?php echo _n( 'Comment', 'Comments', get_comments_number(), 'kitification' ); ?></a>
				</div>
				<?php endif; ?>

				<?php do_action( 'kitification_product_details_after', $instance ); ?>
			</div>
		<?php

		do_action( 'kitification_product_details_widget_after', $instance );

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}