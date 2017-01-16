<?php
$fav_action = KSM_Action::favorite_toggle($p);

$like_action = KSM_Action::post_like_toggle($p);

$grid_img = $this->getGridImage($p);


$share_item = ($this->share_post == 'parent') ? $p->post_parent : $p->ID;

?>

<div class="item_kit_mosaic" indx="<?=$item_index?>">
    <img src="<?=$grid_img?>" />
    
  <?php /*  
    <div class="stats">
        <div class="bg"></div>
        <div class="title"><?=$p->post_title?></div>
        <ul class="image_stats">
            <li class="views">
                <span class="button"></span>
                <span class="count"><?=get_number($p->views_count)?></span>
            </li>
            <li class="favorites">
                <span type="favorite" class="button <?=$fav_action['class']?>" rel="<?=$fav_action['action']?>"></span>
                <span class="count"><?=($p->favorites_count ? $p->favorites_count : '0')?></span>
            </li>
            <li class="likes">
                <span type="plike" class="button <?=$like_action['class']?>" rel="<?=$like_action['action']?>"></span>
                <span class="count"><?=get_number($p->likes_count)?></span>
            </li>
            <li class="share">
                <span class="button" data-item="<?=$share_item?>"></span>
                <span class="count"></span>
            </li>
            <?php if($p->post_type == 'download') : ?>
            <li class="extra">
                <a class="buy" href="<?=ksm_get_permalink("store/download/{$p->ID}")?>">BUY</a>
            </li>
            <?php endif; ?>
        </ul>
        <span class="info_btn tooltip tooltipstered">
            <div class="description"><?=$p->post_content?></div>
        </span>
    </div>
    */ ?>
    
</div>
