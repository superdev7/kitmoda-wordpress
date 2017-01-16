<?php
wp_enqueue_script('colorbox-js', trailingslashit(KSM_BASE_URL).'js/colorbox.js', array('jquery', 'ksm_scripts'));

wp_enqueue_script('attrchange', trailingslashit(KSM_BASE_URL).'js/attrchange.js', array('jquery', 'ksm_scripts'));
?>
<!DOCTYPE html>
<html ng-app="kapp" <?php language_attributes(); ?> style="margin-top: 0 !important;overflow-y: hidden;height: 100%">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <?php wp_head(); ?>
    
    
    
</head>



<body <?php body_class('ksm_popup'); ?>>
    
    <div class="header-outer">
    <header id="masthead" class="site-header" role="banner">
        <div class="container">
            
            <div class="site-branding">
				<?php $header_image = get_header_image(); ?>
				<?php if ( ! empty( $header_image ) ) : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="custom-header"><img src="<?=KSM_BASE_URL.'images/kitmodalogoSmallheader.png'?>" alt=""></a>
				<?php endif; ?>

				
			</div>
            
            
	</div>
    </header>
    </div>
    
    <div class="window <?=$this->action?>" h="<?=$h?>">
        <?php $this->render_view(); ?>
    </div>
    
    <div id="mastfooter" class="mast-footer">
        <?php $this->render_element('footer-ksm');?>
    </div>
</body>
</html>