<?php


$post = get_post();

KSM_postView::add($post);

$user = new KSM_User($post->post_author);

$img = '';

$img = get_image_src($post->_thumbnail_id, 'gallery_grid');


$fav_action = KSM_Action::favorite_toggle($post);
$like_action = KSM_Action::post_like_toggle($post);
?>
<div class="item">
    <a class="img_item" href="<?=$img?>">
        <img src="<?=$img?>" />
    </a>
    <div class="content_box">
        <div class="bg"></div>
        <div class="box_inner">
            
            <div class="left">
            
                <ul class="i_stats">

                    <li class="likes">
                        <span type="plike" class="button <?=$like_action['class']?>" rel="<?=$like_action['action']?>"></span>
                        <span class="count"><?=get_number($post->likes_count)?></span>
                    </li>
                    <li class="views">
                        <span class="button"></span>
                        <span class="count"><?=$post->views_count?></span>
                    </li>
                    
                    <li class="favorites">
                        <span type="favorite" class="button <?= $fav_action['class'] ?>" rel="<?= $fav_action['action'] ?>"></span>
                        <span class="count"><?=($post->favorites_count ? $post->favorites_count : '0') ?></span>
                    </li>
                    
                    <li class="clr"></li>
                </ul>
                
                
                <div dsc="c=minHeight:170,a=display:none">
                    <hr />
                    <div style="height: 22px;"></div>
                </div>
                <hr />
                
            </div>
            
            
            
            <div class="right">
            
                <div class="user_info">
                    <div class="username">
                        <a href="<?=$user->studio_link();?>"><?=$user->display_name()?></a>
                    </div>
                </div>
                
            
            </div><div class="clr"></div>
            
            <hr dsc="c=minHeight:146,a=display:none" />
            
            <div class="left">
            <a ds="marginTop:26,marginBottom:18" href="<?=ksm_get_permalink('collaboration/launch/concept/'.$post->ID)?>" class="colorbox ci_launch">LAUNCH</a>
            </div><div class="clr"></div>
            
        </div>
    </div>

</div>