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


$duration = $current_project->CurrentStateDuration();
$waiting_time = "";
if($duration) {
    $waiting_time = call_user_func_array('human_time_diff', array_map('strtotime', $duration));
}

?>


<div class="post">
    
    <div class="rheader">
        
        
        
        <div class="avatar">
            <?=$author->avatar_link()?>
        </div>
        <div class="userinfo">
            <?=$author->username_link()?>
            <div class="date"><?=$current_project_status?></div>
        </div>
        
        
        <div class="clr"></div>
    </div>
    
    
    <div class="rcontent">
        
        <div class="p_content">
            
            <div style="padding-left: 80px;">
            You are currently waiting for this partners final texture WIP of this project to review. 
            <div>You have been waiting <?=$waiting_time?>.</div>
            </div>
            
        </div>
        
        
        <?php
        
        $this->render_element('partner_project_message_form');
        
        ?>
        
        
    </div>
    
    
</div>