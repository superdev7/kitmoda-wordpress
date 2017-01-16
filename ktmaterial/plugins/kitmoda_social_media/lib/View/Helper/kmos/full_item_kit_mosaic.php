<?php if ($this->count_full_view) KSM_postView::add($p); ?>
    
<?php 

$like_action = KSM_Action::post_like_toggle($p);

?>
<div data-item="<?= $p->ID ?>" id="<?= $this->hash_location ?>_<?= $p->ID ?>">
   <div class="avatar popup_avtar" style="margin-left: 17%">

        <img class="radius" src="<?=ksm_avatar($p->ID, 'avatar_small')?>"/>

    </div>
    <ul style="margin:0; float:left;width: 50%;">
        <li class="post_content_username"
            style="position: absolute; top: -18px; margin-left: 15px;"><?= $p->user_name; ?></li>
        <li class="post_content_age"><?= time_ago($p->post_date) ?>        </li>
        <li class="clr"></li>
    </ul>
    <div class="title full_item_title"><?= $p->post_title ?></div>
    <div class="share">
        <ul class="image_stats new_state">
            <li class="views"><span class="button"></span> <span class="count"><?= get_number($p->views_count) ?></span>
            </li>
            
            <li class="likes"><span type="plike" class="button <?= $like_action['class'] ?>"
                                    rel="<?= $like_action['action'] ?>"></span> <span
                    class="count"><?= get_number($p->likes_count) ?></span></li>
            <li class="share"><span class="button" data-item="<?= $p->ID + 1; ?>"></span> <span class="count"></span>
            </li>        <?php if ($p->post_type == 'download') : ?>
            <li class="extra"><a class="buy" href="<?= ksm_get_permalink("store/download/{
                $p->ID
                }") ?>">BUY</a></li>        <?php endif; ?>    </ul>
    </div>
    <img src="<?= $this->getFullImage($p) ?>"/></div>