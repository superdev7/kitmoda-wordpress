<?php


$user_id = get_current_user_id();
$author_links = $download->author_links(array('excluding' => array($user_id), 'return_as' => 'array'));


?>



<div class="product post">
    <div class="thumb"><a href="<?=ksm_get_permalink("store/download/{$download->ID}")?>"><?=$download->the_thumb('purchase_lib_thumb')?></a></div>
    <div class="prod_info">
        
        <div>
            <div class="name"><a href="<?=ksm_get_permalink("store/download/{$download->ID}")?>"><?=$download->post_title?></a></div>
            
            <div class="clr"></div>
        </div>
        
        
        <ul class="post_stats">
            <li class="views">
                <span class="button"></span>
                <span class="count"><?=get_number($download->views_count) ?></span>
            </li>
            
            <li class="likes">
                <span type="plike" class="button disabled"></span>
                <span class="count"><?=get_number($download->likes_count) ?></span>
            </li>
            <li class="clr"></li>
        </ul>
        <div class="clr"></div>
        
        
        <div class="product_build_info">
        
            <div class="asset_type">
                <span class="field_name">Asset Type</span>
                <span class="rt_txt">
                    <?=($download->isUntextured() ? 'Untextured Model' : 'Textured Model' );?>
                </span>
                <div class="clr"></div>
            </div>


            <div class="project_type">
                <span class="field_name">Project Type</span>
                <span class="rt_txt">
                    <?=($download->isSolo() ? 'Solo' : 'Collaboration' );?>
                </span>
                <div class="clr"></div>
            </div>


            <?php if($download->isCollaboration()): ?>

            <div class="partner">
                <span class="field_name">Partner<?=(count($author_links) > 1 ? 's' : '')?></span>
                <span class="rt_txt">
                    <?=implode('', $author_links)?>
                </span>
                <div class="clr"></div>
            </div>

            <div class="project_role">
                <span class="field_name">Your Project Role</span>
                <span class="rt_txt">
                    <?=$download->userRole($user_id)?>
                </span>
                <div class="clr"></div>
            </div>

            <?php endif; ?>
        
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
        
        
        <div class="primary_file_format">
            <span class="field_name">Primary File Format</span> 
            <span class="rt_txt"> <?=$download->primary_file_format?></span>
            <div class="clr"></div>
        </div>
        <div class="file_format">
            <span class="field_name">Secondary File Format</span> 
            <span class="rt_txt"> <?=$download->get_tax_label('file_format')?></span>
            <div class="clr"></div>
        </div>
        
        
    </div>
    <div class="product_item_stats">
        <div class="date">Published on <?=date('M d, Y', strtotime($download->post_date))?></div>
        <div class="date_ago"><?=human_time_diff(strtotime($download->post_date))?> Ago</div>
        
        
        
        <div class="field_ratings">
            <div class="field_product_rating">
                <span class="field_name">Product Rating</span> 
                <span class="rt_txt"><?=star_rating_static2($download->product_rating, true)?></span>
                <div class="clr"></div>
            </div>


            <div class="field_contribution_rating">
                <span class="field_name">Your Contribution's Rating</span> 
                <span class="rt_txt"><?=star_rating_static2($download->author_contribution_rating($user_id), true)?></span>
                <div class="clr"></div>
            </div>
        </div>
        
        
        
        <div class="field_sale_stats">
            <div class="">
                <span class="field_name">Sales of this Product</span> 
                <span class="rt_txt"> <?=$download->total_sales_inc_returns()?></span>
                <div class="clr"></div>
            </div>

            <div class="">
                <span class="field_name">Return of Product</span> 
                <span class="rt_txt"> <?=$download->total_returns()?></span>
                <div class="clr"></div>
            </div>


            <div class="">
                <span class="field_name">Net Sales After Returns</span> 
                <span class="rt_txt"> <?=$download->total_sales()?></span>
                <div class="clr"></div>
            </div>
        </div>
        
        
        
        
        
        
        <div class="">
            <span class="field_name">Store Price</span> 
            <span class="rt_txt"> <?=edd_currency_filter(edd_format_amount($download->price()))?></span>
            <div class="clr"></div>
        </div>
        
        
        <div class="">
            <span class="field_name">Your Price Share</span> 
            <span class="rt_txt"><?=edd_currency_filter(edd_format_amount($download->author_price_share($user_id)))?></span>
            <div class="clr"></div>
        </div>
        
        
        <div class="field_income_per_sale">
            <span class="field_name">Your Income Per Sale</span> 
            <span class="rt_txt"><?=edd_currency_filter(edd_format_amount($download->author_income_per_sale($user_id)))?></span>
            <div class="clr"></div>
        </div>
        
        
        <div class="">
            <span class="field_name">Sales this Month</span>
            <span class="rt_txt"> <?=$download->author_sales_this_month($user_id);?></span>
            <div class="clr"></div>
        </div>
        
        <div class="field_income_this_month">
            <span class="field_name">Income this Month</span> 
            <span class="rt_txt"> <?=edd_currency_filter(edd_format_amount($download->author_income_this_month($user_id)))?></span>
            <div class="clr"></div>
        </div>
        
        
    </div>
    <div class="clr"></div>
    
    
    
    <div class="total_income">
        <div class="field">
            <span class="field_name">Total Income</span> 
            <span class="rt_txt"> <?=edd_currency_filter(edd_format_amount($download->author_income($user_id)))?></span>
            <div class="clr"></div>
        </div><div class="clr"></div>
    </div>
</div>