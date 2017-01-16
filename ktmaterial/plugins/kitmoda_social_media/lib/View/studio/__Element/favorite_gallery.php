<?php

$popup_url = ksm_get_permalink("studio/favorites/{$this->KUser->Access->user_login}/");


?>

<div class="sidebar_box favorites">
    <div class="favorites renderbox">  
        <div class="favorites inset_shadow">
            <div class="header_top_highlight">
                <div class="header">
                    <div class="icon"></div>
                    <div class="title">FAVORITES</div>
                    <a title="Favorites" alu="count" href="<?=$popup_url?>" class="count colorbox">
                        <?=get_number($this->KUser->Access->favorites_count)?>
                    </a>
                    <div class="clr"></div>
                </div>

                <?php if($this->KUser->isPrivate) : ?>
                    <input type="hidden" value="no" class="upd" />
                <?php endif;  ?>
            </div>
            <div class="clr"></div>
    
            <div class="content">
                <?php if($this->KUser->isPrivate) : ?>
                    <div class="enc_message" style="display: <?=get_number($this->KUser->Access->favorites_count) == 0 ? 'block':'none'?>">Add Favorite</div>
                <?php endif; ?>
                <span class="alreload" style="display: none"></span>
                <div class="dprms">
                    <input type="hidden" name="studio" value="<?=$studio_id?>" />
                </div>
                <div class="favorites_slider">
                    <div class="slider al_content"></div>
                    <div class="preloader">
                        <?php $this->render_element('loading');?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

