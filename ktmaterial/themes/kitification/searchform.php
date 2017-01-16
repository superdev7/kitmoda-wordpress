<?php
/**
 * The template for displaying search forms in Kitification
 *
 * @package Kitification
 */

$type = 'post';

if (
	is_post_type_archive( 'download' ) ||
	is_singular( 'download' ) ||
	is_tax( array( 'download_tag', 'download_category' ) ) ||
	is_page_template( 'page-templates/home-search.php' ) ||
	is_front_page()
)
	$type = 'download';
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<button type="submit" class="search-submit"><i class="icon-search"></i></button>
	<label>
		<span class="screen-reader-text"><?php _ex( 'Search for:', 'label', 'kitification' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr__( 'Search', 'kitification' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php echo esc_attr__( 'Search for:', 'kitification' ); ?>">
	</label>

	<input type="hidden" name="post_type" value="<?php echo esc_attr( $type ); ?>" />
</form>
