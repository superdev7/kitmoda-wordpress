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
        <link href='https://fonts.googleapis.com/css?family=Montserrat|Roboto' rel='stylesheet' type='text/css'>
        <link href="//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,400,300,600,700,800" rel="stylesheet">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div id="page" class="hfeed site ksm_page">
    <?php do_action( 'before' ); ?>
    <header class="site-header-kitmoda" role="banner">
        <div>
            <div class="kitmoda_header_container">
                <div class="header_logo">
                     <a href="../community/">
                         <img src="<?=KSM_BASE_URL?>css/images/kitmodalogoSmallheader.png" alt="Kitmoda - The creative model place" class="header_logo_image">                                 
                    </a>
                </div>
            </div>
        </div>
    </header>

	

