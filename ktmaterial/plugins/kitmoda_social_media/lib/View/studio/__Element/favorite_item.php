<?php 


$p = get_post($f->item_id);

$img = '';

if($p->post_type == 'attachment') {
    $img = get_image_src($p->ID, 'gallery_grid');
} elseif($p->post_type == 'download') {
    $img = get_image_src($p->_thumbnail_id, 'gallery_grid');
}


$sh_item = KSM_Share::get_shareable_item($p);



$fav_action = KSM_Action::favorite_toggle($p);
$like_action = KSM_Action::post_like_toggle($p);
?>
<div class="item">
    <a class="img_item" href="<?=$img?>"><img src="<?=$img?>" /></a>
    <div class="stats">
        <div class="bg"></div>
        <ul class="image_stats">
            <li class="views">
                <span class="button"></span>
                <span class="count"><?=$p->views_count?></span>
            </li>
            <li class="favorites">
                <span type="favorite" class="button <?=$fav_action['class']?>" rel="<?=$fav_action['action']?>"></span>
                <span class="count"><?=get_number($p->favorites_count)?></span>
            </li>
            <li class="likes">
                <span type="plike" class="button <?=$like_action['class']?>" rel="<?=$like_action['action']?>"></span>
                <span class="count"><?=get_number($p->likes_count)?></span>
            </li>
            <li class="share">
                <span class="button" data-item="<?=$sh_item->ID?>"></span>
            </li>
            
            <li class="extra">
                <?php if($p->post_type == 'download') : ?>
                <a class="buy lp" href="<?=ksm_get_permalink("store/download/{$p->ID}")?>">BUY</a>
                <?php endif; ?>
            </li>
        </ul>
        
        
        <?php if($p->post_type == 'download') : ?>
        <span class="info_btn tooltip tooltipstered">
            <div class="description"><?=$p->post_content?></div>
        </span>
        <?php endif; ?>
        
        
    </div>
</div>
                