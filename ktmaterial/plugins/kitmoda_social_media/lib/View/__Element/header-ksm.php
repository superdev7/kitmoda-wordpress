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
            <div class="site_header_overlay_vert">
		<div class="kitmoda_header_container">
                   
                        <div class="header_logo">
                             <a href="../community/" class="header_logo_image">
                                                                 
                            </a> 
                        
                        
                        </div>
                        
                    <div class="kitmoda_header_radial_overlay">
                        
                    </div>

			
		</div>
                </div>
            <div style="margin: 0 auto; width: 0px; height: 0px; background: orange;">
                <div style="position: relative; width: 0px; height: 0px; top: -85px; left: 80px;">
                    <div class="navigation_container" style="position: absolute;">
			<nav id="site-navigation" class="main-navigation" role="navigation">
                            
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
                                ?>

				<?php 
                                //wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'main-menu' ) ); 
                                ?>
                                    </nav>
			</div>
		</div>
           </div>  
	</header>

	<?php locate_template( array( 'searchform-header.php' ), true ); ?>

