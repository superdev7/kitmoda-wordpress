<?php 




$collaboration = $active->Collaboration;


$ksm_download = new KSM_Download($collaboration->ID);

//pr($posts['description']->ID);
//exit;



$_user = $collaboration->Author;




$step_post = $posts['step'];
$tech_post = $posts['tech'];
$description_post = $posts['description'];





//pr($tech_post);


?>

<div class="window_inner" swidth="1228">

<div class="win_header" hec="1">
    <div class="title">Collaboration Full View</div>
    <a class="close"></a>
</div>




    



<div class="ksm_profile_container">    
    <div class="ksm_profile ksm_page_store_product">
        
        
        
        
        <div class="content">
            
            
            <div class="breadcrumb"><?=$ksm_download->breadcrumb();?></div>
            <div class="clr"></div>
                
                    
                    <?php 
                    
                    if($step_post) :
                        
                        slick_attachment_gallery($step_post->ID, array(
                            'with_featured'=> true,
                            'name' => 'download_view_gallery',
                            'thumb_size' => 'avatar_small_2',
                            'full_size' => 'wip_full'
                            ));
        
                    endif;
        
                    ?>
                    
                
            
            
            <div class="details">
            
                <h1 class="page-title"><?=$collaboration->post_title;?></h1><div class="clr"></div>
                
                
                
                <?php if($is_wip_post && $step_post->post_content) : ?>
                
                <div><?=$step_post->post_content?></div>
                    
                <?php endif; ?>
                
                
                
                <div class="partners">
                <?php foreach ((Array) $partners as $p):?>
                <div><?=$p?></div>
                <?php endforeach;?>
                </div>
                
                <!--
                <div class="authors">by <?=$ksm_download->author_links()?> at a price share of <?=edd_currency_filter(edd_format_amount($collaboration->price, false))?></div>
                <div>Your "price share" for completed model <span class="price2"><?=edd_currency_filter(edd_format_amount($active->total_price_share, false))?></span></div>
                -->
                
                <div class="clr"></div>
                <div class="counts">

                    <ul>
                        <li class="rating_item">
                            <?=star_rating_static($_user->c_rating)?>
                        </li>
                        <li class="views">
                            <span class="button"></span>
                            <span class="count"><?=$collaboration->views_count?></span>
                        </li>
                        <li class="likes">
                            <span class="button disabled"></span>
                            <span class="count"><?=get_number($collaboration->likes_count)?></span>
                        </li>
                        
                        
                        <li class="clr"></li>
                    </ul>

                    <div class="clr"></div>
                </div>


                <div class="post_content"><?=$collaboration->post_content;?></div>


                <table class="info_box">
                    <tr>
                        <td class="title">Keywords</td>
                        <td><?=$description_post->get_tax_label('keyword', false)?></td>
                    </tr>
                    <tr>
                        <td class="title">Era</td>
                        <td><?=$description_post->get_tax_label('era')?></td>
                    </tr>
                    <tr>
                        <td class="title">Style</td>
                        <td><?=$description_post->get_tax_label('style')?></td>
                    </tr>
                    <tr>
                        <td class="title">Culture</td>
                        <td><?=$description_post->get_tax_label('culture')?></td>
                    </tr>

                </table>

                
                
                
                <?php if($tech_post): ?>
                
                
                
                <div class="info_box_title">ASSET OVERVIEW</div>
                <table class="info_box">
                    <tr>
                        <td class="title">Primary Format</td>
                        <td><?=$tech_post->primary_file_format?></td>
                    </tr>
                    <tr>
                        <td class="title">Other Formats</td>
                        <td><?=$tech_post->get_tax_label('file_format')?></td>
                    </tr>
                    <tr>
                        <td class="title">Game Ready</td>
                        <td><?=$tech_post->get_tax_label('game_ready')?></td>
                    </tr>
                    <tr>
                        <td class="title">3D Print Ready</td>
                        <td><?=$tech_post->get_tax_label('print_ready')?></td>
                    </tr>
                    <tr>
                        <td class="title">Environment</td>
                        <td><?=$tech_post->get_tax_label('environment')?></td>
                    </tr>

                </table>


                <div class="info_box_title">MODEL DETAILS</div>
                <table class="info_box">
                    <tr>
                        <td class="title">Polygon Count</td>
                        <td><?=$tech_post->poly_count?></td>
                    </tr>
                    <tr>
                        <td class="title">Modeling Method</td>
                        <td><?=$tech_post->get_tax_label('modeling_method')?></td>
                    </tr>
                    <tr>
                        <td class="title">Organization</td>
                        <td><?=$tech_post->get_tax_label('organization')?></td>
                    </tr>
                    <tr>
                        <td class="title">World Scale</td>
                        <td><?=$tech_post->get_tax_label('world_scale')?></td>
                    </tr>
                </table>




                <div class="info_box_title">TEXTURE DETAILS</div>
                <table class="info_box">
                    <tr>
                        <td class="title">Unwrapped</td>
                        <td><?=$tech_post->get_tax_label('unwrap')?></td>
                    </tr>
                    
                    
                    <!--
                    
                    <tr>
                        <td class="title">Textured</td>
                        <td><?=$tech_post->get_tax_label('texturing_method')?></td>
                    </tr>
                    <tr>
                        <td class="title">Detail Maps</td>
                        <td><?=$tech_post->get_tax_label('mapping')?></td>
                    </tr>
                    <tr>
                        <td class="title">Baked Lighting</td>
                        <td><?=$tech_post->get_tax_label('bake_lighting')?></td>
                    </tr>
                    -->
                </table>

                <div class="info_box_title">RENDERING DETAILS</div>
                <table class="info_box">
                    <tr>
                        <td class="title">Lighting Included</td>
                        <td><?=$tech_post->get_tax_label('lighting')?></td>
                    </tr>
                    <tr>
                        <td class="title">Renderer</td>
                        <td><?=$tech_post->get_tax_label('renderer')?></td>
                    </tr>
                </table>
                
                
                
                <?php
                
                endif;
                
                ?>
                
                
                
                
                
                

                
            </div><div class="clr"></div>
            
            
        </div>
        
        
        
        
        
        
        <div class="clr"></div>
    </div>
</div>

<div class="footer" hec="1"></div>
</div>