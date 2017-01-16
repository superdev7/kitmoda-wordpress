<?php
wp_enqueue_script('pp', trailingslashit(KSM_BASE_URL).'js/pp.js', array('jquery', 'ksm_scripts'));
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> style="margin-top: 0 !important; overflow-y: hidden;height: 100%;">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>



<body <?php body_class('ksm_popup'); ?> style="height: 100%">
<?php 
//global $wp_query;
//$win_name = $wp_query->query_vars['ksm_pname'];
//$h = $GLOBALS['ksm_win_settings'][$win_name]['height'];


?>
    <div class="window <?=$this->action?>" h="<?=$h?>">
        <?php $this->render_view(); ?>
    </div>
</body>
</html>