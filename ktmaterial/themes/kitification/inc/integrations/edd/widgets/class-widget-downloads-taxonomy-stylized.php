<?php
/**
 * Taxonomy display on the homepage.
 *
 * @since Kitification 1.0
 */
class Kitification_Widget_Taxonomy_Stylized extends Kitification_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'kitification_widget_taxonomy_stylized';
		$this->widget_description = __( 'Display a taxonomy in a styled way.', 'kitification' );
		$this->widget_id          = 'kitification_widget_taxonomy_stylized';
		$this->widget_name        = __( 'Kitification - Home: Taxonomy', 'kitification' );
		$this->settings           = array(
			'taxonomy' => array(
				'type'  => 'select',
				'std'   => 'category',
				'label' => __( 'Taxonomy:', 'kitification' ),
				'options' => array(
					'download_category' => __( 'Category', 'kitification' ),
					'download_tag'      => __( 'Tag', 'kitification' )
				)
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

		ob_start();

		extract( $args );

		$taxonomy = isset ( $instance[ 'taxonomy' ] ) ? $instance[ 'taxonomy' ] : 'download_category';

		echo '</div>'; // end .container
		echo $before_widget;
		?>

		<div class="container">

		<ul class="edd-taxonomy-widget">
			<?php wp_list_categories( array(
				'title_li' => '',
				'taxonomy' => $taxonomy,
				'depth'    => 1
			) ); ?>
		</ul>

		</div>

		<?php
		echo $after_widget;
		echo '<div class="container">'; // start container again

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}