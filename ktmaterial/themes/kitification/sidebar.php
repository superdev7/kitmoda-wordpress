<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Kitification
 */

if ( ! is_active_sidebar( 'sidebar-1' ) )
	return;
?>
	<div id="secondary" class="widget-area col-md-4 col-xs-12" role="complementary">
		<?php do_action( 'before_sidebar' ); ?>

		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div><!-- #secondary -->
