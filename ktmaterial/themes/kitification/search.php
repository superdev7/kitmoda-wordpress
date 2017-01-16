<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Kitification
 */

$post_type = get_query_var( 'post_type' );

if ( 'download' == $post_type )
	locate_template( array( 'archive-download.php' ), true );
else
	locate_template( array( 'index.php' ), true );