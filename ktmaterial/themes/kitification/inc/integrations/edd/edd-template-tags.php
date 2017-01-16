<?php

function kitification_download_columns() {
	echo kitification_get_download_columnns();
}

function kitification_get_download_columnns() {
	return absint( 12 / kitification_theme_mod( 'product-display', 'product-display-columns' ) );
}

/**
 * Depending on the type of download, display some featured stuff.
 *
 * @since Kitification 1.0
 *
 * @return void
 */
function kitification_download_viewer() {
	if ( 'classic' != kitification_theme_mod( 'product-display', 'product-display-single-style' ) )
		return;

	global $post;

	$format = get_post_format();

	switch( $format ) {
		case 'audio' :
			kitification_download_audio_player();
			break;
		case 'video' :
			kitification_download_video_player();
			break;
		case false :
			kitification_download_standard_player();
			break;
		default :
			do_action( 'kitification_download_' . $format . '_player', $post );
			break;
	}
}
add_action( 'kitification_download_featured_area', 'kitification_download_viewer' );

if ( ! function_exists( 'kitification_download_standard_player' ) ) :
/**
 * Featured Area: Standard (Images)
 *
 * @since Kitification 1.0
 *
 * @return void
 */
function kitification_download_standard_player() {
	global $post;

	if ( 'grid' == kitification_theme_mod( 'product-display', 'product-display-single-style' ) )
		return;

	$images  = array();
	$_images = get_post_meta( $post->ID, 'preview_images', true );
        
        

	if ( is_array( $_images ) && ! empty( $_images ) ) {
		foreach ( $_images as $image ) {
			$images[] = get_post( $image );
		}
	} else {
		$images = get_attached_media( 'image', $post );
	}
        
        
        // Start Tahir
	$before = '<div class="download-image">';
	$after  = '</div>';


	if ( empty( $images ) && has_post_thumbnail( $post->ID ) ) {
		echo $before;
		echo get_the_post_thumbnail( $post->ID, 'fullsize' );
		echo $after;

		return;
	} else {
		$before = '<div class="clearfix" style="max-width:840px">';

		echo $before;
	?>

		





<ul id="imageGallery" class="gallery list-unstyled">
                    
                    <?php foreach ( $images as $image ) : 
                     $thumb_image   = wp_get_attachment_thumb_url( $image->ID);
                     $full_size_image   = wp_get_attachment_url( $image->ID, 'fullsize');
                     ?>
                    <li data-thumb="<?=$thumb_image?>" data-src="<?=$full_size_image?>">
                        <img src="<?=$full_size_image?>" />
                    </li>
                    <?php endforeach; ?>
                </ul>




	<?php
		echo $after;
                
                // End Tahir
	}
}
endif;

if ( ! function_exists( 'kitification_download_video_player' ) ) :
/**
 * Download Video Player
 *
 * @since Kitification 1.0
 *
 * @return void
 */
function kitification_download_video_player() {
	global $post;

	$field = apply_filters( 'kitification_video_field', 'video' );
	$video = get_post_meta( $post->ID, $field, true );

	if ( ! $video )
		return;

	$oembed = wp_oembed_get( $video );

	if ( $oembed ) {
		global $wp_embed;

		$output = $wp_embed->run_shortcode( '[embed]' . $video . '[/embed]' );
	} else {
		$file = wp_get_attachment_url( $video );
		$info = wp_check_filetype( $file );

		$output = do_shortcode( sprintf( '[video %s="%s"]', $info[ 'ext' ], $video ) );
	}
	?>
		<div class="download-video"><?php echo $output; ?></div>
	<?php
}
endif;

if ( ! function_exists( 'kitification_download_audio_player' ) ) :
/**
 * Download Audio Player
 *
 * @since Kitification 1.0
 *
 * @return void
 */
function kitification_download_audio_player() {
	global $post;

	$download_id = $post->ID;
	$_attachments = get_post_meta( $download_id, 'preview_files', true );

	$audio       = array();
	$exts        = array();
	$attachments = array();

	if ( $_attachments ) {
		foreach ( $_attachments as $attachment ) {
			$attachments[$attachment] = get_post( $attachment );
		}
	} else {
		$attachments = get_attached_media( 'audio', $download_id );
	}

	foreach ( $attachments as $attachment ) {
		$file = wp_get_attachment_url( $attachment->ID );
		$info = wp_check_filetype( $file );

		if ( ! in_array( $info[ 'ext' ], $exts ) )
			$exts[] = $info[ 'ext' ];

		$audio[] = array(
			'title'          => get_the_title( $attachment->ID ),
			$info[ 'ext' ]   => $file
		);
	}
	?>
	<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready(function($){
			new jPlayerPlaylist({
				jPlayer: "#jplayer_<?php echo $download_id; ?>",
				cssSelectorAncestor: "#jp_container_<?php echo $download_id; ?>"
			}, <?php echo json_encode( $audio ); ?>, {
				swfPath        : "<?php echo get_template_directory_uri(); ?>/js",
				supplied       : "<?php echo implode( ', ', $exts ); ?>",
				wmode          : "window",
				smoothPlayBar  : true,
				keyEnabled     : true
			});
		});
		//]]>
		</script>

	<div id="jplayer_<?php echo $download_id; ?>" class="jp-jplayer"></div>

	<div id="jp_container_<?php echo $download_id; ?>" class="jp-audio">
		<div class="jp-type-playlist">
			<div class="jp-playlist">
				<ul>
					<li></li>
				</ul>
			</div>
			<div class="jp-gui jp-interface">
				<ul class="jp-controls">
					<li><a href="javascript:;" class="jp-previous" tabindex="1"><i class="icon-previous"></i></a></li>
					<li><a href="javascript:;" class="jp-play" tabindex="1"><i class="icon-play"></i></a></li>
					<li><a href="javascript:;" class="jp-pause" tabindex="1"><i class="icon-pause"></i></a></li>
					<li><a href="javascript:;" class="jp-next" tabindex="1"><i class="icon-next"></i></a></li>
				</ul>
				<div class="jp-progress">
					<div class="jp-seek-bar">
						<div class="jp-play-bar"></div>
					</div>
				</div>
				<div class="jp-volume-bar">
					<div class="jp-volume-bar-value"></div>
				</div>
			</div>
			<div class="jp-no-solution">
				<span><?php _e( 'Update Required', 'kitification' ); ?></span>
				<?php _e( 'To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.', 'kitification' ); ?>
			</div>
		</div>
	</div>

	<?php
		if ( is_singular( 'download' ) ) {
			if ( 'grid' == kitification_theme_mod( 'product-display', 'product-display-single-style' ) ) {
				kitification_download_grid_previewer();
			} else {
				kitification_download_standard_player();
			}
		}
	?>

	<?php
}
add_action( 'kitification_download_entry_meta_before_audio', 'kitification_download_audio_player' );
endif;

if ( ! function_exists( 'kitification_single_download_content_before_content' ) ) :
/**
 *
 * @since Kitification 1.1.0
 *
 * @return void
 */
function kitification_single_download_content_before_content() {
	if ( 'grid' != kitification_theme_mod( 'product-display', 'product-display-single-style' ) )
		return;

	global $post;

	$format = get_post_format();

	switch( $format ) {
		case 'audio' :
			kitification_download_audio_player();
			break;
		case 'video' :
			kitification_download_video_player();
			break;
		case false :
			kitification_download_grid_previewer();
			break;
		default :
			do_action( 'kitification_download_' . $format . '_player', $post );
			break;
	}
}
add_action( 'kitification_single_download_content_before_content', 'kitification_single_download_content_before_content' );
endif;

if ( ! function_exists( 'kitification_download_grid_previewer' ) ) :
/**
 *
 * @since Kitification 1.1.0
 *
 * @return void
 */
function kitification_download_grid_previewer() {
	global $post;

	if ( in_array( get_post_format(), array( 'video' ) ) )
		return;

	$images  = array();
	$_images = get_post_meta( $post->ID, 'preview_images', true );

	if ( $_images ) {
		foreach ( $_images as $image ) {
			$images[] = get_post( $image );
		}
	} else {
		$images = get_attached_media( 'image', $post->ID );
	}

	$before = '<div class="download-image-grid-preview">';
	$after  = '</div>';

	/*
	 * Just one image and it's featured.
	 */
	if ( empty( $images ) && has_post_thumbnail( $post->ID ) ) {
		echo $before;
		echo '<a href="' . wp_get_attachment_url( get_post_thumbnail_id() ) . '">' . get_the_post_thumbnail( $post->ID, 'large' ) . '</a>';
		echo $after;

		return;
	} else {
		echo $before;
	?>

		<div class="row image-grid-previewer-wrap">
			<?php do_action( 'kitification_download_grid_previewer_before' ); ?>
			<div class="col-sm-12 image-preview">
				<a id="1" href="<?php echo wp_get_attachment_url( current( $images )->ID ); ?>" class="image-preview-gallery"><?php echo wp_get_attachment_image( current( $images )->ID, 'large' ); ?></a>
			</div>

			<div class="col-sm-12 image-grid-previewer">
				<ul class="slides row">
					<?php $i = 1; foreach ( $images as $image ) : ?>
					<li class="col-lg-2 col-md-3 col-sm-4 col-xs-6"><a id="<?php echo $i; ?>" href="<?php echo wp_get_attachment_url( $image->ID ); ?>" class="image-preview-gallery"><?php echo wp_get_attachment_image( $image->ID, 'large' ); ?></a></li>
					<?php $i++; endforeach; ?>
				</ul>
			</div>
		</div>

	<?php
		echo $after;

	}
}
endif;

if ( ! function_exists( 'kitification_purchase_link' ) ) :
/**
 * Download Purchase Link
 *
 * @since Kitification 1.0
 *
 * @return void
 */
function kitification_purchase_link( $download_id = null ) {
	global $post, $edd_options;

	if ( ! $download_id )
		$download_id = $post->ID;

	$variable = edd_has_variable_prices( $download_id );

	if ( ! $variable ) {
		echo edd_get_purchase_link( array( 'download_id' => $download_id, 'price' => false ) );
	} else {
		$button = ! empty( $edd_options[ 'add_to_cart_text' ] ) ? $edd_options[ 'add_to_cart_text' ] : __( 'Purchase', 'kitification' );

		printf( '<a href="#buy-now-%s" class="button buy-now popup-trigger">%s</a>', $post->ID, $button );
	}
}
add_action( 'kitification_download_actions', 'kitification_purchase_link' );
endif;

/**
 * Add the Price to the download information at the top of the page.
 *
 * @since Kitification 1.0
 *
 * @return void
 */
function kitification_download_price() {
	global $post;

	edd_price( $post->ID );
}
add_action( 'kitification_download_info', 'kitification_download_price', 5 );

if ( ! function_exists( 'kitification_demo_link' ) ) :
/**
 * Download Purchase Link
 *
 * @since Kitification 1.0
 *
 * @return void
 */
function kitification_demo_link( $download_id = null ) {
	global $post, $edd_options;

	if ( 'download' != get_post_type() ) {
		return;
	}

	if ( ! $download_id ) {
		$download_id = $post->ID;
	}

	$field = apply_filters( 'kitification_demo_field', 'demo' );
	$demo  = get_post_meta( $download_id, $field, true );

	if ( ! $demo ) {
		return;
	}

	$label = apply_filters( 'kitification_demo_button_label', __( 'Demo', 'kitification' ) );

	if ( $post->_edd_cp_custom_pricing ) {
		echo '<br /><br />';
	}

	echo apply_filters( 'kitification_demo_link', sprintf( '<a href="%s" class="button" target="_blank">%s</a>', esc_url( $demo ), $label ) );
}
add_action( 'kitification_download_actions', 'kitification_demo_link' );
endif;

function kitification_product_details_widget_before() {
	if ( 'classic' == kitification_theme_mod( 'product-display', 'product-display-single-style' ) )
		return;
?>
	<div class="product-details-pull">
		<div class="download-info">
			<?php do_action( 'kitification_download_info' ); ?>
		</div>

		<div class="download-actions">
			<?php do_action( 'kitification_download_actions' ); ?>
		</div>
	</div>
<?php
}
add_action( 'kitification_product_details_after', 'kitification_product_details_widget_before' );

function kitification_download_archive_popular( $args = array() ) {
	$defaults = array(
		'posts_per_page'         => 9,
		'meta_key'               => '_edd_download_sales',
		'orderby'                => 'meta_value',
		'timeframe'              => 'month' // 'week'
	);

	$args = apply_filters( 'kitification_download_archive_popular', wp_parse_args( $args, $defaults ) );

	$query_args = array(
		'post_type'              => 'download',
		'no_found_rows'          => true,
		'update_post_term_cache' => false,
		'update_post_meta_cache' => false,
		'cache_results'          => false,
	);

	$query_args = wp_parse_args( $query_args, $args );

	// Date
	if ( 'day' == $args[ 'timeframe' ] ) {
		$frame = date( 'd' );
	} else if ( 'week' == $args[ 'timeframe' ] ) {
		$frame = date( 'W' );
	} else if ( 'month' == $args[ 'timeframe' ] ) {
		$frame = date( 'm' );
	} else {
		$frame = date( 'Y' );
	}

	$query_args[  'date_query' ] = array( array( $args[ 'timeframe' ] => $frame ) );

	// Taxonomy
	if ( is_tax( array( 'download_category', 'download_tag' ) ) ) {
		$obj = get_queried_object();

		$query_args[ 'tax_query' ] = array(
			array(
				'taxonomy' => $obj->taxonomy,
				'field'    => 'ids',
				'terms'    => array( $obj->term_id )
			)
		);
	}

	// Search
	if ( is_search() ) {
		$query_args[ 's' ] = esc_attr( get_search_query() );
	}

	$popular  = new WP_Query( $query_args );

	return $popular;
}