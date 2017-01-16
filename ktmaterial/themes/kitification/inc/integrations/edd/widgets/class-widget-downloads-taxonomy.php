<?php
/**
 * Download Taxonomy
 *
 * @since Kitification 1.0
 */
class Kitification_Widget_Downloads_Taxonomy extends Kitification_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'kitification_widget_downloads_taxonomy';
		$this->widget_description = __( 'Display a list of download taxonomies.', 'kitification' );
		$this->widget_id          = 'kitification_widget_downloads_taxonomy';
		$this->widget_name        = __( 'Kitification - Download Single: Taxonomies', 'kitification' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => 'Categories',
				'label' => __( 'Title:', 'kitification' )
			),
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

		global $post;

		ob_start();

		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$taxonomy = isset ( $instance[ 'taxonomy' ] ) ? $instance[ 'taxonomy' ] : 'download_category';

		echo $before_widget;

		if ( $title ) echo $before_title . $title . $after_title;

		echo '<ul class="edd-taxonomy-widget">';
		wp_list_categories( array(
			'title_li' => '',
			'taxonomy' => $taxonomy
		) );
		echo '</ul>';

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}