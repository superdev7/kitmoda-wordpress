<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */








?>


<div class="post">
    
    <div class="rheader">
        
        <div><?=$current_project->project_state_label($post->step_state)?></div>
        
        <?php if($post->show_feedback_form) :?>           
        <div class="await"> Awaiting Your Feedback for <?=human_time_diff(strtotime($post->post_date))?>  </div>      <?php endif;?>  

         <div class="await-divi"></div>  

        <div class="avatar">
            <?=$current_project->Author->avatar_link()?>
        </div>
        <div class="userinfo">
            <?=$current_project->Author->display_name_link()?>
            <div class="date"><?=human_time_diff(strtotime($post->post_date))?> ago</div>
        </div>
        
        
        
        
        
        
        <div class="clr"></div>
        
    </div>
    
    
    <div class="rcontent">
        
        
        
        
         <?php if($post->post_content) :?>        <div class="p_content">            <?=$post->post_content?>        </div>        <?php endif; ?>
        
        
<div class="gallery_container">  <div class="await-divi"></div>  </div>
        

        <?php 
        slick_attachment_gallery($post->ID, array(
            'with_featured'=> true,
            'name' => 'project_'.$post->step_state.'_gallery',
            //'name' => 'project_wip_gallery',
            'thumb_size' => 'avatar_small_2',
            'full_size' => 'wip_full'
            ));
        ?>
        
        
        
        <?php 
        
        if($post->show_feedback_form) {
            $this->render_element('partner_project_feedback_form');
        }
        
        elseif($post->feedback) {
            $this->render_element('partner_project_feedback_wip', array('feedback' => $post->feedback));
        }
        
        ?>
        
        
        
        
        
    </div>
    
    
</div>