<?php


$waiting_for_feedback_projects = $non_waiting_for_feedback_projects = array();



foreach ( (Array) $projects as $p ) {
 
    if($p->isWaitingForFeedback()) {
        $waiting_for_feedback_projects[] = $p;
    } else {
        $non_waiting_for_feedback_projects[] = $p;
    }
    
}

?>



<div class="coll_sidebar">


  <?php /*?>  $this->render_element('collaboration_navigation');<?php */?>

    <?php 
    
    
    
    
    
        
        
            
    
    if(!$auth_error && !$no_post_found) : ?>

 

    
    
    
    
 <div class="coll_sidebar_shadow">
    <?php if(!empty($waiting_for_feedback_projects))  : ?>
     <div class="h1"><span>PROJECTS REQUIRING FEEDBACK</span></div>
     <div class="filter_nav">
        
        <ul class="collaboration_types projects_list">
        <?php foreach ($waiting_for_feedback_projects as $p) : 
            
            $duration = $p->CurrentStateDuration();
            $waiting_time = "";
            if($duration) {
                $waiting_time = call_user_func_array('human_time_diff', array_map('strtotime', $duration));
            }
            ?>
            
            <li data-item="<?=$p->ID?>" rel="<?=ksm_get_permalink("collaboration/partner_projects/{$p->ID}")?>">
                <div class="<?=($p->ID == $current_project->ID ? 'active' : '')?>">
                    
                    <div class="thumb"><?=$current_project->Collaboration->the_thumb('avatar_small_3')?></div>
                    
                    <div class="info">
                        <div class="ptitle"><?=$p->post_title?></div>
                        <div class="usernmae"><?=$p->Author->display_name_link()?></div>
                        <div class="info2">
                            <div class="avatar"><?=$p->Author->avatar_link('avatar_tiny_2')?></div>
                            <div class="info3">
                                <div>Awaiting Feedback</div>
                                <div><?=$waiting_time?></div>
                            </div><div class="clr"></div>
                        </div>
                    </div><div class="clr"></div>
                    
                    
                </div>
            </li>
        
        
        <?php endforeach; ?>
        
        </ul>

     </div>
     
        <div class="community_sidebar_footer"></div>
       
        
      

    <?php endif; ?>
    
       
        
          </div>
        
        <div class="clr space"></div>
        
        
 <div class="coll_sidebar_shadow">
        <?php if(!empty($non_waiting_for_feedback_projects))  : ?>
     <div class="h1"><span>PROJECTS YOU ARE WAITING FOR</span></div>
        <div class="filter_nav">
        
        <ul class="collaboration_types projects_list">
        <?php foreach ($non_waiting_for_feedback_projects as $p) : 
            
            $duration = $p->CurrentStateDuration();
            $waiting_time = "";
            if($duration) {
                $waiting_time = call_user_func_array('human_time_diff', array_map('strtotime', $duration));
            }
            ?>
            
            
            <li data-item="<?=$p->ID?>" rel="<?=ksm_get_permalink("collaboration/partner_projects/{$p->ID}")?>">
                <div class="<?=($p->ID == $current_project->ID ? 'active' : '')?>">
                    
                    <div class="thumb"><?=$current_project->Collaboration->the_thumb('avatar_small_3')?></div>
                    
                    <div class="info">
                        <div class="ptitle"><?=$p->post_title?></div>
                        <div class="usernmae"><?=$p->Author->display_name_link()?></div>
                        <div class="info2">
                            <div class="avatar"><?=$p->Author->avatar_link('avatar_tiny_2')?></div>
                            <div class="info3">
                                
                            <?php if($p->isWaitingForWIP()) : ?>
                                <div>Waiting for WIP <div class="duration"><?=$waiting_time?></div></div>
                            <?php elseif($p->isOnSellState()) : ?>
                                <div>Waiting for publish</div>
                            <?php elseif($p->isCompleted()) : ?>
                                <div>Completed</div>
                            <?php endif; ?>
                                <div><?=$waiting_time?></div>
                            </div><div class="clr"></div>
                        </div>
                    </div><div class="clr"></div>
                    
                    
                </div>
            </li>
        <?php endforeach; ?>
        
        </ul>
        </div>
     
        <div class="community_sidebar_footer"></div>
        
    <?php endif; ?>

    </div>
    <div class="clr space"></div>
            
            
            

            
        
        
    
    <?php endif; ?>
    
    
      
        
    

</div>