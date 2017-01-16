<?php
/**
 * Download Details
 *
 * @since Kitification 1.0
 */
class Kitification_Widget_Download_Share extends Kitification_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'kitification_widget_download_share';
		$this->widget_description = __( 'Display sharing options for this product.', 'kitification' );
		$this->widget_id          = 'kitification_widget_download_share';
		$this->widget_name        = __( 'Kitification - Download Single: Social Sharing', 'kitification' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => 'Sharing Options',
				'label' => __( 'Title:', 'kitification' )
			),
			'description' => array(
				'type'  => 'text',
				'std'   => 'Like this item? Why not share it with your friends?',
				'label' => __( 'Description:', 'kitification' )
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
		$description = isset ( $instance[ 'description' ] ) ? esc_attr( $instance[ 'description' ] ) : null;

		echo $before_widget;

		if ( $title ) echo $before_title . $title . $after_title;

		if ( $description ) {
			echo '<span class="widget-description">' . $description . '</span>';
		}

		do_action( 'kitification_widget_download_share_before' );
		?>

		<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode( get_permalink( $post->ID ) ); ?>&amp;width=300&amp;height=35&amp;colorscheme=light&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;send=false&amp;appId=327226857358730" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:35px;" allowTransparency="true"></iframe>

		<!-- Place this tag where you want the +1 button to render. -->
		<div class="g-plusone" data-size="medium"></div>

		<!-- Place this tag after the last +1 button tag. -->
		<script type="text/javascript">
		  (function() {
		    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		    po.src = 'https://apis.google.com/js/plusone.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script>

		<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

		<a href="//www.pinterest.com/pin/create/button/" data-pin-do="buttonBookmark" ><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>
		<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>

		<?php
		do_action( 'kitification_widget_download_share_after' );

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}