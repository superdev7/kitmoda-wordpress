<?php
/**
 * The Sidebar containing the project widget area.
 *
 * @package Kitification
 */

if ( ! is_active_sidebar( 'sidebar-single-project' ) )
	return;
?>
	<div id="secondary" class="col-md-4 col-sm-5 col-xs-12" role="complementary">

		<?php dynamic_sidebar( 'sidebar-single-project' ); ?>

	</div><!-- #secondary -->
