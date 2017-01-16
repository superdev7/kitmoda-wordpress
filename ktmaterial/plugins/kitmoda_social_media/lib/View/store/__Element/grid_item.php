<?php
global $post;

$grid_img = get_image_src($post->_thumbnail_id, 'gallery_grid');



?>

<?php KSM_postView::add($post); ?>

<div class="item" indx="<?=$c?>">
    <a href="<?=ksm_get_permalink("store/download/{$post->ID}")?>"><img src="<?=$grid_img?>" /></a>
    <div class="price"><?=edd_currency_filter( edd_format_amount( $post->edd_price ) )?></div>
</div>

