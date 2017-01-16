<?php
/**
 * Related Items
 *
 * @since Kitification 1.0
 */
class Kitification_Widget_Featured_Popular_Downloads extends Kitification_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'kitification_widget_featured_popular';
		$this->widget_description = sprintf( __( 'Display featured and popular %s in sliding grid.', 'kitification' ), edd_get_label_plural() );
		$this->widget_id          = 'kitification_widget_featured_popular';
		$this->widget_name        = sprintf( __( 'Kitification - Home:  Featured &amp; Popular %s', 'kitification' ), edd_get_label_plural() );
		$this->settings           = array(
			'featured-title' => array(
				'type'  => 'text',
				'std'   => 'Featured',
				'label' => __( 'Featured Title:', 'kitification' )
			),
			'popular-title' => array(
				'type'  => 'text',
				'std'   => 'Popular',
				'label' => __( 'Popular Title:', 'kitification' )
			),
			'number' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 6,
				'label' => __( 'Number to display:', 'kitification' )
			),
			'timeframe' => array(
				'type'  => 'select',
				'std'   => 'week',
				'label' => __( 'Based on the current:', 'kitification' ),
				'options'   => array(
					'day'   => __( 'Day', 'kitification' ),
					'week'  => __( 'Week', 'kitification' ),
					'month' => __( 'Month', 'kitification' ),
					'year'  => __( 'Year', 'kitification' )
				)
			),
			'scroll' => array(
				'type'  => 'checkbox',
				'std'   => 1,
				'label' => __( 'Automatically scroll items', 'kitification' )
			),
			'speed' => array(
				'type'  => 'text',
				'std'   => 7000,
				'label' => __( 'Slideshow Speed (ms)', 'kitification' )
			),
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

		ob_start();

		global $post;

		extract( $args );

		$number    = isset( $instance[ 'number' ] ) ? absint( $instance[ 'number' ] ) : 8;
		$timeframe = isset( $instance[ 'timeframe' ] ) ? $instance[ 'timeframe' ] : 'week';
		$f_title   = isset( $instance[ 'featured-title' ] ) ? $instance[ 'featured-title' ] : __( 'Featured', 'kitification' );
		$p_title   = isset( $instance[ 'popular-title' ] ) ? $instance[ 'popular-title' ] : __( 'Popular', 'kitification' );

		$featured_args = array(
			'post_type'              => 'download',
			'posts_per_page'         => $number,
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'cache_results'          => false,
			'meta_query'             => array(
				array(
					'key'   => 'edd_feature_download',
					'value' => true
				)
			)
		);

		$popular_args = array(
			'post_type'              => 'download',
			'posts_per_page'         => $number,
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'cache_results'          => false,
			'meta_key'               => '_edd_download_sales',
			'orderby'                => 'meta_value',
		);

		if ( 'day' == $timeframe ) {
			$frame = date( 'd' );
		} else if ( 'week' == $timeframe ) {
			$frame = date( 'W' );
		} else if ( 'month' == $timeframe ) {
			$frame = date( 'm' );
		} else {
			$frame = date( 'Y' );
		}

		$featured_args[ 'date_query' ] = array( array( $timeframe => $frame ) );
		$popular_args[  'date_query' ] = array( array( $timeframe => $frame ) );

		$featured = new WP_Query( $featured_args );
		$popular  = new WP_Query( $popular_args );

		if ( ! $featured->have_posts() && ! $popular->have_posts() )
			return;

		echo $before_widget;

		?>

		<h1 class="home-widget-title">
			<?php if ( $featured->have_posts() ) : ?>
			<span><?php echo esc_attr( $f_title ); ?> </span>
			<?php endif; ?>

			<?php if ( $popular->have_posts() ) : ?>
			<span><?php echo esc_attr( $p_title ); ?></span>
			<?php endif; ?>
		</h1>

		<?php if ( $featured->have_posts() ) : ?>
		<div id="items-featured" class="row flexslider">
			<ul class="slides">
				<?php while ( $featured->have_posts() ) : $featured->the_post(); ?>
				<li class="col-lg-3 col-sm-6">
					<?php get_template_part( 'content-grid', 'download' ); ?>
				</li>
				<?php endwhile; ?>
			</ul>
		</div>
		<?php endif; ?>

		<?php if ( $popular->have_posts() ) : ?>
		<div id="items-popular" class="row flexslider">
			<ul class="slides">
				<?php while ( $popular->have_posts() ) : $popular->the_post(); ?>
				<li class="col-lg-3 col-sm-6">
					<?php get_template_part( 'content-grid', 'download' ); ?>
				</li>
				<?php endwhile; ?>
			</ul>
		</div>
		<?php endif; ?>

		<?php
		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}