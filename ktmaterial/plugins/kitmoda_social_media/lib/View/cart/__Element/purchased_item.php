<?php



$download = $pd->Download;

?>



<div class="product post">
    <div class="thumb"><a href="<?=ksm_get_permalink("store/download/{$download->ID}")?>"><?=$download->the_thumb('purchase_lib_thumb')?></a></div>
    <div class="prod_info">
        
        <div>
            <div class="name"><a href="<?=ksm_get_permalink("store/download/{$download->ID}")?>"><?=$download->post_title?></a></div>
            <div class="clr"></div>
        </div>
        
        <div class="keywords">
            <span class="field_name">Category</span>
            <span class="rt_txt"><?=$download->get_tax_label('category', false)?></span>
            <div class="clr"></div>
        </div>
        <div class="keywords">
            <span class="field_name">Keywords</span>
            <span class="rt_txt"><?=$download->get_tax_label('keyword', false)?></span>
            <div class="clr"></div>
        </div>
        <div class="era">
            <span class="field_name">Era</span> 
            <span class="rt_txt"><?=$download->get_tax_label('era')?></span>
            <div class="clr"></div>
        </div>
        <div class="style">
            <span class="field_name">Style</span> 
            <span class="rt_txt"><?=$download->get_tax_label('style')?></span>
            <div class="clr"></div>
        </div>
        <div class="culture">
            <span class="field_name">Culture</span> 
            <span class="rt_txt"> <?=$download->get_tax_label('culture')?></span>
            <div class="clr"></div>
        </div>
        
    </div>
    <div class="purchase_info">
        
        
        <div class="price"><?=edd_currency_filter($pd->price)?></div>
        
        
        
        
        <div>
            <?php if($pd->post_status == 'pending') : ?>
            <div><a href="<?=ksm_get_permalink("account/pending_purchase/{$pd->ID}")?>" class="colorbox btn_pending">Payment confirmation pending</a><div class="clr"></div></div>
        <?php elseif($pd->post_status == 'publish') : ?>
        
        
            <div class="btn_download"><a href="<?=ksm_get_permalink("account/purchases/download/{$pd->ID}")?>">Download</a><div class="clr"></div></div>
        <?php endif ?>
        
        
        <?php
        if($pd->isReturned()) : ?>
            
            <div class="returned">Returned</div>
            
            <?php else :?>
            
                <?php if($pd->is_rated()) : ?>
                    <div class="rated">Rated <?=star_rating_static($pd->rating_average, true)?></div>
                <?php else : ?>
                    <div class="btn_rate"><a href="<?=ksm_get_permalink("account/rate/{$pd->ID}")?>" class="colorbox">RATE</a><div class="clr"></div></div>
                <?php endif;?>
            
        <?php endif; ?>
                    <div class="clr"></div>
        </div>
        
        
        
        
        
    </div>
    <div class="clr"></div>
</div>