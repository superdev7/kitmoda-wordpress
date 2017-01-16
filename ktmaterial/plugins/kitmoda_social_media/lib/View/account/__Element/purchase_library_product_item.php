<?php







$download = new KSM_Post($pd->download_id, false);













//$post_terms = wp_get_object_terms($download->ID, 'ksm_tax_keyword', array('fields' => 'slugs'));





//pr($post_terms);





//$post_terms = wp_get_object_terms($pd->ID, 'ksm_tax_keyword', array('fields' => 'slugs'));





//pr($post_terms);



?>







<div class="product post">

    <div class="thumb"><a href="<?=ksm_get_permalink("store/download/{$download->ID}")?>"><?=$download->the_thumb('purchase_lib_thumb')?></a></div>

    <div class="prod_info">

        

        <div>

            <div class="name"><a href="<?=ksm_get_permalink("store/download/{$download->ID}")?>"><?=$pd->post_title?></a></div>

            <div class="price"><?=edd_currency_filter($pd->price)?></div>

            <div class="clr"></div>

        </div>

        

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

        <div class="date">Purchased <?=date('M d, Y', strtotime($pd->post_date))?></div>

        <div class="date_ago"><?=human_time_diff(strtotime($pd->post_date))?> Ago</div>

        

        

        

        

        <?php if($pd->post_status == 'pending') : ?>

        

        

        

        <div><a href="<?=ksm_get_permalink("account/pending_purchase/{$pd->ID}")?>" class="colorbox btn_pending">Payment confirmation pending</a><div class="clr"></div></div>

        <?php elseif($pd->post_status == 'publish') : ?>

        

        <div><a href="<?=ksm_get_permalink("account/return/{$pd->ID}")?>" class="colorbox btn_return">Return</a><div class="clr"></div></div>

        <div><a href="<?=ksm_get_permalink("account/purchases/download/{$pd->ID}")?>" class="btn_download">Download</a><div class="clr"></div></div>

        <?php endif ?>

        

        

        <?php

        if($pd->isReturned()) :?>

            

            <div class="returned">Returned</div>

            

            <?php else :?>

            

                <?php if($pd->is_rated()) : ?>

            <div class="rated">Rated <?=star_rating_static($pd->rating_average, true)?></div>

                <?php else : ?>

                <div><a href="<?=ksm_get_permalink("account/rate/{$pd->ID}")?>" class="colorbox btn_rate btn btn_blue">
                <div class="blue-button"></div> <div class="blue-button-hover"></div>RATE</a><div class="clr"></div></div>

                <?php endif;?>

            

        <?php endif; ?>

        

        

        

        

        

        

    </div>

    <div class="clr"></div>

</div>