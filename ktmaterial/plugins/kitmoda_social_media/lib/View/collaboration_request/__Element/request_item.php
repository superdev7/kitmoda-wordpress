<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


if($post->request_type == 'model') {
    $title =  'Request to <span>Model</span>';
} elseif($post->request_type == 'texture') {
    $title =  'Request to <span>Texture</span>';
} elseif($post->request_type == 'model_texture') {
    $title =  'Request to <span>Texture & Model</span>';
}


$collaboration = get_post($post->post_parent);




$collaboration_thumb = get_image_src(get_post_thumbnail_id($collaboration->ID), 'avatar_small');

$collaboration_name = $collaboration->post_title;



$prices = array();

$proposed_new_price = 0;

$prices[] = array(
    'label' => 'YOUR CURRENT PRICE SHARE',
    'price' => $collaboration->price
);

$proposed_new_price += $collaboration->price;

if($post->request_type == 'model' || $post->request_type == 'model_texture') {
    $prices[] = array(
        'label' => 'PROPOSED PRICE SHARE FOR MODEL',
        'price' => $post->model_price,
        'class' => 'request_price'
    );
    $proposed_new_price += $post->model_price;
}

if($post->request_type == 'texture' || $post->request_type == 'model_texture') {
    $prices[] = array(
        'label' => 'PROPOSED PRICE SHARE FOR TEXTURE',
        'price' => $post->texture_price,
        'class' => 'request_price'
    );
    $proposed_new_price += $post->texture_price;
}


$author = new KSM_User($post->post_author);




?>


<div class="post" id="req_<?=$post->ID?>">
    
    <div class="rheader">
        
        
        
        <div class="avatar">
            <?=$author->avatar_link()?>
        </div>
        <div class="userinfo">
            <?=$author->username_link()?>
            <div class="date"><?=$post->post_date?></div>
        </div>
        
        <div class="user_rating">
            <div class="communication">Communication <?=star_rating_static2($author->communication_rating)?> <div class="clr"></div></div>
            <div class="artwork">Artwork <?=star_rating_static2($author->artwork_rating)?> <div class="clr"></div></div>
        </div>
        
        
        <div class="thumb">
            <img src="<?=$collaboration_thumb?>" />
        </div>
        
        <div class="clr"></div>
        
    </div>
    
    
    <div class="rcontent">
        
        <div>
            <div class="title"><?=$title?></div>
            <div class="project_name"><?=$collaboration_name?></div>
            <div class="clr"></div>
        </div>
        
        
        <div class="p_content">
            <?=$post->post_content?>
        </div>
        
        <div class="price_shares">
            
            <?php foreach($prices as $pr) : ?>
            <div class="<?=$pr['class']?>">
                <label><?=$pr['label']?></label>
                <div class="price"><?=edd_currency_filter($pr['price'])?></div>
                <div class="clr"></div>
            </div>
            <?php endforeach; ?>
            <hr />
            
            <div>
                <label>PROPOSED NEW PRICE</label>
                <div class="price"><?=edd_currency_filter($proposed_new_price)?></div>
                <div class="clr"></div>
            </div>
        </div>
        
        
        
    </div>
    
    <div class="rfooter">
        <div class="buttons">
            
            <?php if($post->request_status == 'active') : ?>
            
            <a class="btn btn_blue btn_reject colorbox" href="<?=ksm_get_permalink('collaboration/request/reject/'.$post->ID)?>">No, Thanks</a>
            <a class="btn btn_blue btn_accept colorbox" href="<?=ksm_get_permalink('collaboration/request/accept/'.$post->ID)?>">Accept</a>
            
            
            <?php elseif($post->request_status == 'accepted') : ?>
                <div class="accepted">Accepted</div>
            <?php elseif($post->request_status == 'rejected') : ?>
                <div class="rejected">Rejected</div>
            <?php endif ;?>
            
        </div><div class="clr"></div>
    </div>
</div>