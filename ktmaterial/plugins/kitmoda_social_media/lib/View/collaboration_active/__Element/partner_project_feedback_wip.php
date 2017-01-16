<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>


<div class="wip_feedback_post">
    
    
  <div class="gallery_container "> <div class="await-divi"></div> </div> 
    
    <div class="rheader">
        
        <div><?=$current_project->project_state_label($feedback->step_state)?></div>
        
        
 <div class="await-divi"></div>
        <div class="avatar">
            <?=$feedback->Author->avatar_link()?>
        </div>
        <div class="userinfo">
            <?=$feedback->Author->display_name_link()?>
            <div class="date"><?=human_time_diff(strtotime($feedback->post_date))?> ago</div>
        </div>
        
        
        
        
        
        
        <div class="clr"></div>
        
    </div>
    
    
    <div class="rcontent">
        
        <?php if($feedback->post_content) :?>
        <div class="p_content">
            <?=$feedback->post_content?>
        </div>
        <?php endif; ?>
        
        
        
        
  <div class="gallery_container "> <div class="await-divi"></div> </div> 
        <?php 
        slick_attachment_gallery($feedback->ID, array(
            'with_featured'=> true,
            'name' => 'project_'.$feedback->step_state.'_gallery',
            'thumb_size' => 'avatar_small_2',
            'full_size' => 'wip_full'
            ));
        ?>
        
        
        
        
        
        
    </div>
    
    
</div>