<?php 



$posts->the_post();
global $post;

//ksm_slick_gallery($attachments, $settings = array());


$ksm_collaboration = new KSM_Collaboration($post->ID);


$like_action = KSM_Action::post_like_toggle($post);




?>

<div class="window_inner" swidth="1228">

<div class="win_header" hec="1">
    <div class="title">Collaboration Full View</div>
    <a class="close"></a>
</div>




    



<div class="ksm_profile_container">    
    <div class="ksm_profile ksm_page_store_product">
        
        
        
        
        <div class="content">
            
            
            <div class="breadcrumb"><?=$ksm_collaboration->breadcrumb();?></div>
            
                
                    
                <?php 
                    
                ksm_slick_gallery($ksm_collaboration->gallery_attachments(), array(
                        'with_featured'=> true,
                        'name' => 'download_view_gallery',
                        'thumb_size' => 'avatar_small_2',
                        'full_size' => 'wip_full'
                        ));
                ?>
                    
                
            
            
            <div class="details">
            
                <h1 class="page-title"><?php the_title(); ?></h1><div class="clr"></div>
                
                
                
                <?php
                
                if($ksm_collaboration->current_stage == 'untextured' && $ksm_collaboration->launch_type == 'concept') {
                    $kcp = new KSM_User($ksm_collaboration->concept_partner());
                    $kmp = new KSM_User($ksm_collaboration->model_partner());
                    
                    
                    echo '<div class="authors"><ul>';
                    
                    if($kcp->ID) {
                        echo "<li><span class=\"first\">Concept by </span>
                            <span>{$kcp->display_name_link(true)}</span>
                            <span class=\"price\">".edd_currency_filter(edd_format_amount($ksm_collaboration->concept_price()))."</span><span class=\"clr\"></span>
                            </li>";
                    }
                    
                    if($kmp->ID) {
                        echo "<li><span class=\"first\">Model by </span>
                            <span>{$kmp->display_name_link(true)}</span>
                            <span class=\"price\">".edd_currency_filter(edd_format_amount($ksm_collaboration->model_price()))."</span><span class=\"clr\"></span>
                            </li>";
                    }
                    echo '</ul></div>';
                    
                    echo "<div class=\"price_share_total\">
                        <span class=\"first\">Price share total</span>
                        <span class=\"price\">".edd_currency_filter(edd_format_amount($post->price, false))."</span><span class=\"clr\"></span>
                        </div>";
                } else { ?>
                
                <div class="authors">by <?=$ksm_collaboration->Author->display_name_link(true)?> at a price share of <?=edd_currency_filter(edd_format_amount($post->price, false))?></div>
                
                <?php } ?>
                
                
                
                
                <div class="clr"></div>
                <div class="counts">

                    <ul>
                        
                        <?php if($ksm_collaboration->current_stage == 'untextured') : 
                            $rating = 0;
                            if($ksm_collaboration->untextured_download_id) {
                                $rating = get_post_meta($ksm_collaboration->untextured_download_id, 'product_rating', true);
                            }
                            
                            ?>
                        <li class="rating_item">
                            <?=star_rating_static($rating, true)?>
                        </li>
                        <?php endif; ?>
                        <li class="views">
                            <span class="button"></span>
                            <span class="count"><?=$post->views_count?></span>
                        </li>
                        <li class="likes">
                            <span type="plike" class="button <?=$like_action['class']?>" rel="<?=$like_action['action']?>"></span>
                            <span class="count"><?=get_number($post->likes_count)?></span>
                        </li>
                        
                        
                        <li class="clr"></li>
                    </ul>

                    <div class="clr"></div>
                    <div class="studio_sidebar_linebreak_mid"></div>
                <div class="studio_sidebar_linebreak_dark"></div>
                <div class="studio_sidebar_linebreak"></div>
                    <div class="clr"></div>
                 
                </div>


                <div class="post_content"><?php the_content();?></div>


                <table class="info_box">
                    <tr>
                        <td class="title">Keywords</td>
                        <td><?=$ksm_collaboration->get_tax_label('keyword', false)?></td>
                    </tr>
                    <tr>
                        <td class="title">Era</td>
                        <td><?=$ksm_collaboration->get_tax_label('era')?></td>
                    </tr>
                    <tr>
                        <td class="title">Style</td>
                        <td><?=$ksm_collaboration->get_tax_label('style')?></td>
                    </tr>
                    <tr>
                        <td class="title">Culture</td>
                        <td><?=$ksm_collaboration->get_tax_label('culture')?></td>
                    </tr>

                </table>

                <?php if($post->launch_type == 'untextured') : ?>
                <div class="info_box_title">ASSET OVERVIEW</div>
                <table class="info_box">
                    <tr>
                        <td class="title">Primary Format</td>
                        <td><?=$post->primary_file_format?></td>
                    </tr>
                    <tr>
                        <td class="title">Other Formats</td>
                        <td><?=$post->primary_file_format?></td>
                    </tr>
                    <tr>
                        <td class="title">Game Ready</td>
                        <td><?=$ksm_collaboration->get_tax_label('game_ready')?></td>
                    </tr>
                    <tr>
                        <td class="title">3D Print Ready</td>
                        <td><?=$ksm_collaboration->get_tax_label('print_ready')?></td>
                    </tr>
                    <tr>
                        <td class="title">Environment</td>
                        <td><?=$ksm_collaboration->get_tax_label('environment')?></td>
                    </tr>

                </table>


                <div class="info_box_title">MODEL DETAILS</div>
                <table class="info_box">
                    <tr>
                        <td class="title">Polygon Count</td>
                        <td><?=$post->poly_count?></td>
                    </tr>
                    <tr>
                        <td class="title">Modeling Method</td>
                        <td><?=$ksm_collaboration->get_tax_label('modeling_method')?></td>
                    </tr>
                    <tr>
                        <td class="title">Organization</td>
                        <td><?=$ksm_collaboration->get_tax_label('organization')?></td>
                    </tr>
                    <tr>
                        <td class="title">World Scale</td>
                        <td><?=$ksm_collaboration->get_tax_label('world_scale')?></td>
                    </tr>
                </table>




                <div class="info_box_title">TEXTURE DETAILS</div>
                <table class="info_box">
                    <tr>
                        <td class="title">Unwrapped</td>
                        <td><?=$ksm_collaboration->get_tax_label('unwrap')?></td>
                    </tr>
                    
                    
                    <!--
                    
                    <tr>
                        <td class="title">Textured</td>
                        <td><?=$ksm_collaboration->get_tax_label('texturing_method')?></td>
                    </tr>
                    <tr>
                        <td class="title">Detail Maps</td>
                        <td><?=$ksm_collaboration->get_tax_label('mapping')?></td>
                    </tr>
                    <tr>
                        <td class="title">Baked Lighting</td>
                        <td><?=$ksm_collaboration->get_tax_label('bake_lighting')?></td>
                    </tr>
                    -->
                </table>

                <div class="info_box_title">RENDERING DETAILS</div>
                <table class="info_box">
                    <tr>
                        <td class="title">Lighting Included</td>
                        <td><?=$ksm_collaboration->get_tax_label('lighting')?></td>
                    </tr>
                    <tr>
                        <td class="title">Renderer</td>
                        <td><?=$ksm_collaboration->get_tax_label('renderer')?></td>
                    </tr>
                </table>

                <?php endif; ?>
            </div><div class="clr"></div>
            
            
        </div>
        
        
        
        
        
        
        <div class="clr"></div>
    </div>
</div>

<div class="footer" hec="1"></div>
</div>