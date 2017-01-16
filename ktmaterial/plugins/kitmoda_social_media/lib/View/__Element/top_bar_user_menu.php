<?php

$user = new KSM_User($user_id);
    
$studio_url = ksm_get_permalink('studio');
$avatar = ksm_avatar($user_id);

?>


<div class="user_menu">

    
        <ul class="notification_menu">
            
            
                    
                
            <div class="upload_launch_container">
                            <a class="colorbox" href="<?=ksm_get_permalink('publisher')?>" style="border: none; padding-bottom: 22px; z-index: 50000; margin-bottom: 0px; width: 22px; padding-top: 22px; padding-left: 22px; border-bottom-width: 0px;"></a>
            
                                    <div class="upload_launch">
                                    </div>
                                    <div class="upload_launch_hover">
                                    </div>
                            </a>
            </div>
            
            
            
              
            
            <li class="messages_dd_btn">
                <div class="icon"></div>
                <?php if(get_number($user->inbox_news_count) > 0) : ?>
                <div class="counter"><?=get_number($user->inbox_news_count)?></div>
                <?php endif; ?>
                <div class="clr"></div>
                <?php include 'messages_dropdown.php'; ?>
            </li>
            <li class="notification_dd_btn">
                    <div class="icon"></div>
                    <?php if(get_number($user->notifications_news_count) > 0) : ?>
                    <div class="counter"><?=get_number($user->notifications_news_count)?></div>
                    <?php endif ?>
                    <div class="clr"></div>
                    <?php include 'notifications_dropdown.php'; ?>
            </li>
            
             <?=ksm_nav_cart_menu_item('', (Object) array('theme_location' => 'primary'));?>
            
            
           
            
           
            
            <li class="settings_nav">
                <div class="avatar">
                    <a href="<?=$studio_url?>"><img src="<?=$avatar?>" /></a>
                </div>
                
                <div class="user_nav">
                    <div class="menu_btn"></div>
                    <div class="menu_btn_hover_bridge"></div>
                    <div class="menu_kitmoda">
                        <div class="edge"><div class="inner"></div></div>
                        <ul>
                            <li class="profile"><a title="Edit Profile" class="colorbox" href="<?=ksm_get_permalink('edit_profile')?>">EDIT PROFILE</a></li>
                            <li class="setting"><a title="Account Settings" class="colorbox" href="<?=ksm_get_permalink('account_settings')?>">ACCOUNT SETTINGS</a></li>
                            <li class="signout"><a href="<?=ksm_get_permalink('signout')?>">SIGN OUT</a></li>
                        </ul>
                    </div>
                    <div class="menu_btn_afterglow"></div>
                </div>
            </li>
            
            <li class="clr"></li>
        </ul>
        
    


    

    
</div>