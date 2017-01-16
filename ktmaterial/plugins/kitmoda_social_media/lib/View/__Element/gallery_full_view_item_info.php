<?php


KSM_postView::add($p);


$fav_action = KSM_Action::favorite_toggle($p);
$like_action = KSM_Action::post_like_toggle($p);
?>
<ul class="image_stats">
    <li class="share">
        <span class="button" data-item="<?=$p->ID?>"></span>
        <span class="count"></span>
    </li>
    <li class="likes">
        <span type="plike" class="button <?=$like_action['class']?>" rel="<?=$like_action['action']?>"></span>
        <span class="count"><?=get_number($p->likes_count)?></span>
    </li>
    <li class="favorites">
        <span type="favorite" class="button <?=$fav_action['class']?>" rel="<?=$fav_action['action']?>"></span>
        <span class="count"><?=($p->favorites_count ? $p->favorites_count : '0')?></span>
    </li>
    <li class="views">
        <span class="button"></span>
        <span class="count"><?=get_number($p->views_count)?></span>
    </li>
    <li class="clr"></li>
</ul>
<div class="studio_sidebar_linebreak"></div>

<div class="description">
    <?=(strlen($p->post_content) > 300 ? substr($p->post_content, 0, 296).'...' : $p->post_content)?>
    <?php if($p->post_type == 'download') : ?>
        <div><a href="<?=get_permalink($p->ID)?>">READ MORE</a></div>
    <?php endif; ?>
    
</div>
<div class="clr"></div>