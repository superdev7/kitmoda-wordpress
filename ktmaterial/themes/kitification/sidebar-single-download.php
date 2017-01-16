<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Kitification
 */

if ( ! is_active_sidebar( 'sidebar-download-single' ) )
	return;
?>
	<div id="secondary" class="col-md-4 col-sm-5 col-xs-12" role="complementary">

		<?php dynamic_sidebar( 'sidebar-download-single' ); ?>

	</div><!-- #secondary -->
