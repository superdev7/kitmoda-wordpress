<?php
$popup_url = ksm_get_permalink("studio/following/{$this->KUser->Access->user_login}/");
?>


<div class="following sidebar_box">
    <div class="following renderbox">
        <div class="following inset_shadow">
    
        <div class="header">
            <div class="icon"></div>
            <div class="title">FOLLOWING</div>
            
            <?php if($this->KUser->Access->followings_count > 0) : ?>
            <a title="Following" href="<?=$popup_url?>" class="count colorbox">
                <?=get_number($this->KUser->Access->followings_count)?>
            </a>
            <?php endif; ?>
            
            <div class="clr"></div>
        </div>	
    <div class="clr"></div>
            
    
    <div class="content">
        
        <?php if($this->KUser->isPrivate) : ?>
            <div class="enc_message" style="display: <?=get_number($this->KUser->Access->followings_count) == 0 ? 'block':'none'?>">Add Following</div>
        <?php endif; ?>
        
        <div class="follows_slider">
            
            <div class="slider">
                
                <?php 
                $follows = KSM_Follow::get_user_followings($this->KUser->Access->ID);
                foreach($follows as $f) :
                    $fuser = new KSM_User($f->user_to);
                
                    if($this->KUser->isPrivate) :
                        $unfollow_action = KSM_Action::unfollow($fuser->ID);
                    endif;
                    ?>
                    <div>
                        <?php if($this->KUser->isPrivate) : ?>
                        <div class="ufusr btn btn_blue" rel="<?=$unfollow_action['action']?>">Remove</div>
                        <?php endif; ?>
                        <div class="image"><?=$fuser->avatar_link()?></div>
                    </div>
                
                <?php endforeach;?>
            
            </div>
            <div class="preloader">
                <?php $this->render_element('loading');?>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
