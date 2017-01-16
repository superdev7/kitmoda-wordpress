<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Kitification
 */

if ( ! is_active_sidebar( 'sidebar-archive-project' ) )
	return;
?>
	<div id="secondary" class="download-archive-widget-area col-md-3 col-sm-5 col-xs-12" role="complementary">
		<?php do_action( 'before_sidebar' ); ?>

		<?php dynamic_sidebar( 'sidebar-archive-project' ); ?>
	</div><!-- #secondary -->
