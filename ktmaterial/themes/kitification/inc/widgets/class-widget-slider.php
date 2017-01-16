<?php
/**
 * Slider widget that will allow a slider shortcode to be full-width.
 *
 * @since Kitification 1.0
 */
class Kitification_Widget_Slider extends Kitification_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'kitification_widget_slider';
		$this->widget_description = __( 'Display any slider that supports shortcodes.', 'kitification' );
		$this->widget_id          = 'kitification_widget_slider';
		$this->widget_name        = __( 'Kitification - Home: Slider', 'kitification' );
		$this->settings           = array(
			'shortcode' => array(
				'type'  => 'text',
				'std'   => '',
				'label' => __( 'Slider Shortcode', 'kitification' )
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

		extract( $args );

		if ( ! isset( $instance[ 'shortcode' ] ) )
			return;

		echo '</div>'; // end .container
		echo $before_widget;
		echo do_shortcode( $instance[ 'shortcode' ] );
		echo $after_widget;
		echo '<div class="container">'; // start container again

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}