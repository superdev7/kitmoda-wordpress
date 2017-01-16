<?php

$post = get_post();

KSM_postView::add($post);

$user = new KSM_User($post->post_author);

$img = '';

$img = get_image_src($post->_thumbnail_id, 'gallery_grid');

if($post->current_stage == 'untextured' && $post->launch_type == 'concept') {
    if($post->untextured_download_id) {
        $img = get_image_src(get_post_thumbnail_id($post->untextured_download_id), 'gallery_grid');
    }
}
    






$user_id = get_current_user_id();

$fav_action = KSM_Action::favorite_toggle($post);
$like_action = KSM_Action::post_like_toggle($post);


$show_join_btn = ($user_id && $post->post_author == $user_id) ? false : true;




$_box_items = array();


$_box_items[]['left'] = '<ul class="i_stats">
                    <li class="likes">
                        <span type="plike" class="button '.$like_action['class'].'" rel="'.$like_action['action'].'"></span>
                        <span class="count">'.get_number($post->likes_count).'</span>
                    </li>
                    <li class="views">
                        <span class="button"></span>
                        <span class="count">'.$post->views_count.'</span>
                    </li>
                    <li class="clr"></li>
                </ul><hr />';



$_box_items[]['right'] = '<div class="username">
                            <a href="'.$user->studio_link().'">'.$user->display_name().'</a>
                        </div>';


$_box_items[]['clr'] = '';



$_box_items[]['left'] = '<div class="price_share"><span>'.edd_currency_filter($post->price).'</span> share per sale</div><hr />';


$_box_items[]['right'] = '<div class="communication_rating">
                                '.star_rating_static2($user->collaboration_communication_rating(), true).'
                                <div class="rating_info">'.get_number($user->collaboration_communication_rating()).'</div>
                                <div class="clr"></div>
                            </div>';


$_box_items[]['clr'] = '';






$_box_items[]['left ic'] = '<div class="artwork_rating">
                                '.star_rating_static2($user->collaboration_artwork_rating(), true).'
                                <div class="rating_info">'.get_number($user->collaboration_artwork_rating()).'</div>
                                <div class="clr"></div>
                            </div>';



if(!$show_join_btn) {
    $_box_items[]['right ic'] = '<div class="full_view_btn"><a href="'.ksm_get_permalink('collaboration/full_view/'.$post->ID).'" class="colorbox">FULL VIEW</a> </div>';
    
} 


$_box_items[]['clr'] = '';

if($show_join_btn) {
    
    $_box_items[]['left ic'] = '<div class="full_view_btn"><a href="'.ksm_get_permalink('collaboration/full_view/'.$post->ID).'" class="colorbox">FULL VIEW</a> </div>';
    $_box_items[]['right ic'] = '<a href="'.ksm_get_permalink('collaboration/request/join/'.$post->ID).'" class="colorbox request_join_btn">REQUEST TO JOIN</a>';
    
} else {
    //$_box_items[]['left'] = '<div class="full_view_btn"><a href="'.ksm_get_permalink('collaboration/full_view/'.$post->ID).'" class="colorbox">FULL VIEW</a> </div>';
}

?>




<div class="item">
    <a class="img_item" href="<?=$img?>">
        <img src="<?=$img?>" />
    </a>
    <div class="content_box">
        <div class="bg"></div>
        <div class="box_inner">
            
            
            <?php
            
            foreach($_box_items as $_k => $_ele) {
                $_key = key($_ele);
                echo "<div class=\"{$_key}\">".$_ele[$_key]."</div>";
            }
            
            ?>
        </div>
    </div>

</div>