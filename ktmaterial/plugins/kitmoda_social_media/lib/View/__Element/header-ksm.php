<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <main id="main">
 *
 * @package Kitification
 */
?><!DOCTYPE html>
<html ng-app="kapp" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php wp_title( '|', true, 'right' ); ?></title>
  <?php if(!is_front_page()) { ?>
  <link href='https://fonts.googleapis.com/css?family=Montserrat|Roboto' rel='stylesheet' type='text/css'>
  <link href="//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,400,300,600,700,800" rel="stylesheet">
  <?php } ?>
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

  <div id="page" class="hfeed site ksm_page">
    <?php do_action( 'before' ); ?>
    <header class="site-header-kitmoda" role="banner">
      <div class="row row-inset site_header_overlay_vert">
        <div class="col-xs-12 col-md-10 col-md-offset-1 kitmoda_header_container">
          <div class="header_logo">
            <a href="../community/" class="header_logo_image"></a>
          </div>

          <nav id="site-navigation" class="main-navigation pull-right" role="navigation">
            <h1 class="menu-toggle"><i class="icon-list2"></i></h1>
            <?php
            if(function_exists('KSM_TopBarUserMenu')) echo KSM_TopBarUserMenu();
            ?>
            <!--
            <?php if ( ! ( is_front_page() && is_page_template( 'page-templates/home-search.php' ) ) ) : ?>
            <div class="header-search-icon"><i class="icon-search"></i></div>
            <?php endif; ?>
            -->
            <?php
              //locate_template( array( 'searchform.php' ), true );
              //wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'main-menu' ) );
            ?>
          </nav>
          <div class="kitmoda_header_radial_overlay"></div>
        </div>
      </div>
    </header>

    <?php locate_template( array( 'searchform-header.php' ), true ); ?>

