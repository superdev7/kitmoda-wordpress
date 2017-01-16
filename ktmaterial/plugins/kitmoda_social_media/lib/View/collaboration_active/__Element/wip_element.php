<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */





$collaboration = get_post($current_project->post_parent);




$collaboration_thumb = get_image_src(get_post_thumbnail_id($collaboration->ID), 'avatar_small');

$collaboration_name = $collaboration->post_title;






$author = new KSM_User($current_project->post_author);




?>


<div class="post">
    
    <div class="rheader">
        
        
        
        <div class="avatar">
            <?=$author->avatar_link()?>
        </div>
        <div class="userinfo">
            <?=$author->username_link()?>
            <div class="date"><?=$current_project->post_date?></div>
            <div class="price"><?=edd_currency_filter($current_project->total_price_share)?> Price Share</div>
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
            <div class="title"><?=$collaboration_name?></div>
            
            <div class="clr"></div>
        </div>
        
        
        <div class="p_content">
            <?=$wip->post_content?>
        </div>
        
        
        <?php 
        slick_attachment_gallery($wip->ID, array(
            'with_featured'=> true,
            'name' => 'project_wip_gallery',
            'thumb_size' => 'avatar_small_2',
            'full_size' => 'wip_full'
            ));
        ?>
        
        
        <div class="add_post add_the_post">
    
    <div class="add_post_form radius cwip_feedback_form">
        <iframe name="add_wall_post_frame" class="formframe"></iframe>
        <form method="post" action="<?=admin_url( 'admin-ajax.php' )?>" target="add_wall_post_frame">
            <input type="hidden" name="action" value="CollaborationActive_submit_wip_feedback" />
            <input type="hidden" name="_id" value="<?=$current_project->ID?>" />
            <textarea placeholder="Add your thoughts here..." name="post_content"></textarea>
            <div class="buttons">
                <div class="post_img_btn"></div>
                
                <a href="" class="btn_blue btn btn_form_smt">Add Feedback Notes</a>
                
                <?php KSM_Uploader::build_uploader('cwfiu');?>

                <div class="miu_container" align="center">
                    <ul class="items">
                        <li class="clr"></li>
                    </ul>
                    <div style="clear: both"></div>
                </div>
                
                
            </div><div class="clr"></div>
            <div class="error"></div>
        </form>
    </div><div class="clr"></div>
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