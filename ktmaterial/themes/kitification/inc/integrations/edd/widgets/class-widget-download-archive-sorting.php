<?php
/**
 * Download Sorting
 *
 * @since Kitification 1.1
 */
class Kitification_Widget_Download_Archive_Sorting extends Kitification_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'kitification_widget_download_archive_sorting';
		$this->widget_description = __( 'Display a way to sort the current product archives.', 'kitification' );
		$this->widget_id          = 'kitification_widget_download_archive_sorting';
		$this->widget_name        = __( 'Kitification - Download Archive: Download Sorting', 'kitification' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => '',
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
		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		if ( is_page_template( 'page-templates/popular.php' ) ) {
			return;
		}

		ob_start();

		extract( $args );

		$title   = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$order   = get_query_var( 'm-order' ) ? strtolower( get_query_var( 'm-order' ) ) : 'desc';
		$orderby = get_query_var( 'm-orderby' ) ? strtolower( kitification_edd_sorting_options( get_query_var( 'm-orderby' ) ) ) : 'post_date';

		echo $before_widget;

		if ( $title ) echo $before_title . $title . $after_title;
		?>

		<form action="" method="get" class="download-sorting">
			<label for="orderby">
				<?php _e( 'Sort by:', 'kitification' ); ?>
				<?php
					echo EDD()->html->select( array(
						'name' => 'm-orderby',
						'id' => 'm-orderby',
						'selected' => $orderby,
						'show_option_all' => false,
						'show_option_none' => false,
						'options' => kitification_edd_sorting_options()
					) );
				?>
			</label>


				<label for="order-asc">
					<input type="radio" name="m-order" id="order-asc" value="asc" <?php checked( 'asc', $order ); ?>><span class="icon-arrow-up"></span>
				</label>

				<label for="order-desc">
					<input type="radio" name="m-order" id="order-desc" value="desc" <?php checked( 'desc', $order ); ?>><span class="icon-arrow-down2"></span>
				</label>



		</form>

		<?php

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}