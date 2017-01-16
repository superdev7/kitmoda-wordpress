<?php

$popup_url = ksm_get_permalink("studio/top_selling/{$this->KUser->Access->user_login}/");
        
?>


<div class="topselling sidebar_box">
    <div class="topselling renderbox">
        <div class="topselling inset_shadow">
    <div class="header_top_highlight">
    
        <div class="header">
            <div class="icon"></div>
            <div class="title">TOP SELLING</div>
            
            <?php if($this->KUser->Access->top_selling_count > 0) : ?>
            <a title="Top Selling" href="<?=$popup_url?>" class="count colorbox">
                <?=get_number($this->KUser->Access->top_selling_count)?>
            </a>
            <?php endif; ?>
            <div class="clr"></div>
        </div>
    </div><div class="clr"></div>
            
    
    
    
    <div class="content">
        <?php if($this->KUser->isPrivate) : ?>
            <div class="enc_message" style="display: <?=get_number($this->KUser->Access->top_selling_count) == 0 ? 'block':'none'?>">Add Top Selling</div>
        <?php endif; ?>
            
        <div class="top_selling_slider">
            
            <div class="slider">
            <?php 
            $tss = KSM_TopSelling::get_results($this->KUser->Access->ID);
            
            foreach($tss as $p) {
                $img = get_image_src($p->_thumbnail_id, 'avatar_small_2');
                if($img) {
                    echo '<div class="image"><a href="'.ksm_get_permalink("store/download/{$p->ID}").'"><img src="'.$img.'"/></a></div>';
                }
            }
            ?>
            </div>
            <div class="preloader">
                <?php $this->render_element('loading');?>
            </div>
        </div>
    </div>
</div>
        </div>
    
    </div>
