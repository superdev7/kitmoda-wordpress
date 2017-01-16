<?php

if($to_user) $user = new KSM_User($to_user);



?>
<div class="window_inner" swidth="1228">
    <div class="win_header" hec="1">
        <div class="title">Collaboration Rate Artist</div>
        <a class="close"></a>
    </div>
    
    
    
    <iframe name="rate_frame" class="formframe"></iframe>
    <form method="post" target="rate_frame" action="<?=admin_url( 'admin-ajax.php' )?>">
        
        <input type="hidden" name="active_id" value="<?=$active->ID?>" />
        <input type="hidden" name="action" value="CollaborationActive_submit_rate" />
        
    <div class="content">
        
        <div class="cinner">
            
            <div class="cheader">
                
                <?php if($user) : ?>
                <div class="user_info">
                    <div class="thumb"><?=$user->the_avatar();?></div>
                    <div class="info">
                        <div class="proj_name"><?=$user->display_name();?></div>
                        <div class="url"><?=$user->user_url?></div>
                    </div><div class="clr"></div>
                </div>
                <?php endif; ?>
                
                <div class="project_info">
                    <div class="thumb"><?=$active->Collaboration->the_thumb()?></div>
                    <div class="info">
                        <div class="proj_name"><?=$active->Collaboration->post_title?></div>
                    </div><div class="clr"></div>
                </div><div class="clr"></div>
                
            </div>
        
        
            <div class="post_content">
                
                
                
                <div class="title">PLEASE RATE YOUR EXPERIENCE COLLABORATING WITH THIS ARTIST...</div>
                
                
                <div class="communication">
                    <label>COMMUNICATION</label>
                    <?=KSM_Form::star_rating_input('communication_rate');?>
                </div>
                
                <div class="artwork">
                    <label>ARTWORK</label>
                    <?=KSM_Form::star_rating_input('artwork_rate');?>
                </div>
                
                
            </div>
            
            
            
            
            
            

            <div class="cfooter form_footer">
                <div class="error"></div>
                <?php
                $this->render_element('loading');
                ?>
                <a href="#" class="btn btn_blue btn_form_smt">Submit</a>
                <div class="clr"></div>
                
            </div>
            
        </div>
        
    </div>
</form>
    
    <div class="footer" hec="1"></div>
</div>