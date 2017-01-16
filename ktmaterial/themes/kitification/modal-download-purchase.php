<?php
/**
 *
 */

global $post;
?>

<div id="buy-now-<?php the_ID(); ?>" class="popup">
	<h1 class="section-title"><span><?php _e( 'Buying Options', 'kitification' ); ?></span></h1>

	<?php echo edd_get_purchase_link(); ?>
</div>