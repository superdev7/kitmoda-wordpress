<?php



$download = new KSM_Download($pd->download_id);



//$post_terms = wp_get_object_terms($download->ID, 'ksm_tax_keyword', array('fields' => 'slugs'));


//pr($post_terms);


//$post_terms = wp_get_object_terms($pd->ID, 'ksm_tax_keyword', array('fields' => 'slugs'));


//pr($post_terms);

$income_key = "pd_download_author_{$user_id}_income";
?>



<div class="product post">
    <div class="thumb"><a href="<?=ksm_get_permalink("store/download/{$download->ID}")?>"><?=$download->the_thumb('purchase_lib_thumb')?></a></div>
    <div class="prod_info">
        
        <div>
            <div class="name"><a href="<?=ksm_get_permalink("store/download/{$download->ID}")?>"><?=$pd->post_title?></a></div>
            <div class="price"><?=edd_currency_filter($pd->price)?></div>
            <div class="clr"></div>
        </div>
        
        <?php if($download->isCollaboration()) :  ?>
        
        <div class="collab_note">(Collaboration with your price share at <?=edd_currency_filter($download->author_price_share($user_id))?>)</div>
        
        <?php endif; ?>
        
        <div class="keywords">
            <span class="field_name">Category</span>
            <span class="rt_txt"><?=$download->get_tax_label('category', false)?></span>
            <div class="clr"></div>
        </div>
        <div class="keywords">
            <span class="field_name">Keywords</span>
            <span class="rt_txt"><?=$pd->get_tax_label('keyword', false)?></span>
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
        <div class="date">Sold <?=date('M d, Y', strtotime($pd->post_date))?></div>
        <div class="date_ago"><?=human_time_diff(strtotime($pd->post_date))?> Ago</div>
        
        <div class="purchased_by">
            <span class="field_name">Purchase By</span> 
            <span class="rt_txt"><?=$pd->Author->display_name_link()?></span>
            <div class="clr"></div>
        </div>
        
        <div class="rated_product">
            <span class="field_name">Rated Product</span> 
            <span class="rt_txt"><?=star_rating_static2($pd->rating_average, true)?></span>
            <div class="clr"></div>
        </div>
        
        
        <?php if($download->isCollaboration()) :?>
        <div class="rated_contibution">
            <span class="field_name">Rated your contribution</span> 
            <span class="rt_txt"><?=star_rating_static2 ($pd->contribution_rating_average, true)?></span>
            <div class="clr"></div>
        </div>
        <?php endif; ?>
        
        
        <div class="purchase_income">
            <span class="field_name">Your income from purchase</span> 
            <span class="rt_txt"><?=edd_currency_filter($pd->{$income_key})?></span>
            <div class="clr"></div>
        </div>
        
        
        
        
        
        <?php
        if($pd->isReturned()) :?>
            
            <div class="returned">Returned</div>
            
        <?php endif; ?>
        
        
        
        
        
        
    </div>
    <div class="clr"></div>
</div>