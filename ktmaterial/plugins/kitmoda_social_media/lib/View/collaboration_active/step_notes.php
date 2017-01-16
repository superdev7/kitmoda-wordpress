<?php

$user = new KSM_User($post->post_author);



?>
<div class="window_inner" swidth="1228">
    <div class="win_header" hec="1">
        <div class="title">Collaboration Notes</div>
        <a class="close"></a>
    </div>
    
    <div class="content">
        
        <div class="cinner">
            
            <div class="cheader">
                
                <div class="user_info">
                    <div class="thumb"><?=$user->avatar_link('avatar_small', true);?></div>
                    <div class="info">
                        <div class="proj_name"><?=$user->display_name_link(true);?></div>
                        <div class="url"><?=$user->user_url?></div>
                        <a href="<?=ksm_get_permalink("message/compose/{$user->user_login}")?>" class="btn btn_blue btn_message colorbox"><span>Message</span></a>
                    </div><div class="clr"></div>
                </div>
                
                <div class="project_info">
                    <div class="thumb">
                        
                        <a class="colorbox" href="<?=ksm_get_permalink("collaboration/full_view/{$active->Collaboration->ID}")?>">
                        <?=$active->Collaboration->the_thumb()?>
                        </a>
                    </div>
                    <div class="info">
                        <div class="proj_name">
                        <a class="colorbox" href="<?=ksm_get_permalink("collaboration/full_view/{$active->Collaboration->ID}")?>">    
                            <?=$active->Collaboration->post_title?>
                        </a>
                        </div>
                        <div class="iinfo"><?=$stage?></div>
                    </div><div class="clr"></div>
                </div><div class="clr"></div>
                
            </div>
        
        
            <div class="post_content">
                
                <?=$post->post_content?>
                
                
                
            </div>
            
            
            
            
            
            

            <div class="cfooter">
                
                <?php
                
                slick_attachment_gallery($post->ID, array(
                    //'full' => false,
                    'full_size' => 'step_feedback',
                    'with_featured'=> true,
                    'name' => 'cnotes_gallery',
                    'thumb_size' => 'avatar_small_2',
                    ));
                
                ?>
                
                
                
            </div>
            
        </div>
        
    </div>
    
    <div class="footer" hec="1"></div>
</div>