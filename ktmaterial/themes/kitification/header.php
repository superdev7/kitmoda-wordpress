<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <main id="main">
 *
 * @package Kitification
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">
		<div class="container">
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<h1 class="menu-toggle"><i class="icon-list2"></i></h1>

				<?php if ( ! ( is_front_page() && is_page_template( 'page-templates/home-search.php' ) ) ) : ?>
				<div class="header-search-icon"><i class="icon-search"></i></div>
				<?php endif; ?>

				<?php locate_template( array( 'searchform.php' ), true ); ?>

				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'main-menu' ) ); ?>
			</nav><!-- #site-navigation -->

			<div class="site-branding">
				<?php $header_image = get_header_image(); ?>
				<?php if ( ! empty( $header_image ) ) : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="custom-header"><img src="<?php echo esc_url( $header_image ); ?>" alt=""></a>
				<?php endif; ?>

				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description screen-reader-text"><?php bloginfo( 'description' ); ?></h2>
			</div>
		</div>
	</header><!-- #masthead -->

	<?php locate_template( array( 'searchform-header.php' ), true ); ?>

