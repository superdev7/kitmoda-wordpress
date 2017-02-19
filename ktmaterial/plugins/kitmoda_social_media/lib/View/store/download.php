<link rel="stylesheet" href="http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/css/jquery.jscrollpane.css?ver=4.4" />
		<link rel="stylesheet" href="http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/css/customSelectBox.css?ver=4.4" />


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src='http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/css/sunny/js/jquery.mCustomScrollbar.concat.min.js'></script>
<script src="http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/js/jScrollPane.js?ver=4.4"></script>
		<script src="http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/js/SelectBox.js?ver=4.4"></script>
        <script>
		  jQuery.noConflict()(function($){
			$(function() {

				$("select").each(function() {
					var sb = new SelectBox({
						selectbox: $(this),
						height: 150,
						width: 200
					});
				});
				});
			});
		</script>

        <script>

                                    $(document).ready(function(){



                                            $(".select_boxes .sbOptions").mCustomScrollbar();

											$(".sort_field select").mCustomScrollbar();







                                    })(jQuery);



                                </script>
<?php





$this->render_element('main_tabs');



$posts->the_post();

global $post;









if($post && $post->post_status == 'publish' || $post && current_user_can('manage_options')) {





    $ksm_download = new KSM_Download($post->ID);

    $like_action = KSM_Action::post_like_toggle($post);

} else {

    $error = "Product is not available";

}





KSM_postView::add($post);



?>





















<div class="ksm-menu-sub-menu_container">



<div class="shrink-wrap-backdrop">

            <div class="shrink-wrap-vignette-left">

            </div>



            <div class="shrink-wrap-vignette-right">

            </div>



             <div class="shrink-wrap-findcenter">

                <div class="shrink-wrap-inner-highlight store">

                        <div class="shrink-wrap-inner-highlight-left"></div>

                        <div class="shrink-wrap-inner-highlight-mid"></div>

                        <div class="shrink-wrap-inner-highlight-right"></div>

                </div>

            </div>

	<div class="shrink-wrap-inner-shadow"></div>

        <div class="shrink-wrap-bottom-shadow"></div>


    </div>

</div>















<div class="ksm_profile_container">



<div class="ksm_profile_container_overlay">





    <div class="ksm_profile ksm_page_collaboration ksm_page_store_product">





        <div class="ksm_store_archive">



<div class="sectionBackgroundDark">

  <div class="section">

  <div class="add_post_form_highlight_top">
                <div class="add_post_form_radius_top">
                    <div class="add_post_form_highlight_studio_overlay_top">
                    </div>
                </div>
        </div>

  <div class="section-inside">

        <?php $this->render_element('search_form') ?>





</div>

<div class="add_post_form_highlight_bottom">
                <div class="add_post_form_radius_bottom">
                    <div class="add_post_form_highlight_studio_overlay_bottom">
                    </div>
                </div>
        </div>

</div>

</div>





        <div class="content">





            <?php if($error) : ?>



            <div class="empty_error"><?=$error?></div>



            <?php else : ?>







            <div class="breadcrumb"><?=$ksm_download->breadcrumb();?></div>

            <div class="clr"></div>









                    <?php

        slick_attachment_gallery($post->ID, array(

            'with_featured'=> true,

            'name' => 'download_gallery',

            'thumb_size' => 'avatar_small_2',

            'full_size' => 'wall_full'

            ));

        ?>
   <div class="full-view-right-sec">
<div class="pr-col_container_top"> </div>
            <div class="details">



                <h1 class="page-title"><?php the_title()?></h1><div class="clr"></div>

                <div class="authors">by <?=$ksm_download->author_links()?></div>



                <div class="add_to_cart_btn"><?php do_action( 'kitification_download_actions' ); ?></div>



                <div class="clr"></div>

                <div class="counts">



                    <ul>

                        <li class="views">

                            <span class="button"></span>

                            <span class="count"><?=$post->views_count?></span>

                        </li>

                        <li class="likes">

                            <span type="plike" class="button <?=$like_action['class']?>" rel="<?=$like_action['action']?>"></span>
<span class="button-hover"></span>
                            <span class="count"><?=get_number($post->likes_count)?></span>

                        </li>

                        <li class="share">

                            <span class="button" data-item="<?=$post->ID?>"></span>
                            <span class="share-button-hover"></span>



                        </li>

                        <li class="price">

                            <span class="edd_price" id="edd_price_1"><?=edd_currency_filter(edd_format_amount($post->edd_price))?></span>

                        </li>

                        <li class="clr"></li>

                    </ul>

                    <div class="studio_sidebar_linebreak_mid"></div>

                <div class="studio_sidebar_linebreak_dark"></div>

                <div class="studio_sidebar_linebreak"></div>

                    <div class="clr"></div>




                </div>







                <div class="ratings">



                    <div class="overall">

                        <label>OVERALL RATING</label>

                        <?=star_rating_static($post->product_rating, true)?>

                        <div class="clr"></div>

                    </div>



                    <span class="rating_excoll collapsed">

                        <span class="collapsed_btn">SHOW MORE</span>

                        <span class="expanded_btn">SHOW LESS</span>

                    </span>



                    <div class="studio_sidebar_linebreak_mid"></div>

                <div class="studio_sidebar_linebreak_dark"></div>

                <div class="studio_sidebar_linebreak"></div>

                    <div class="group_ratings">



                        <ul>

                            <li>

                                <label>ALL FILES INCLUDED</label>

                                <?=star_rating_static($post->rating__file_error, true)?>

                                <div class="clr"></div>

                            </li>

                            <li>

                                <label>SCENE ORGANIZATION</label>

                                <?=star_rating_static($post->rating__scene_org, true)?>

                                <div class="clr"></div>

                            </li>

                            <li>

                                <label>MODEL</label>

                                <?=star_rating_static($post->rating__model, true)?>

                                <div class="clr"></div>

                            </li>

                            <li>

                                <label>TEXTURE</label>

                                <?=star_rating_static($post->rating__texture, true)?>

                                <div class="clr"></div>

                            </li>

                            <li>

                                <label>UV UNWRAP</label>

                                <?=star_rating_static($post->rating__uv_unwrap, true)?>

                                <div class="clr"></div>

                            </li>

                            <li>

                                <label>LIGHTING AND RENDERING</label>

                                <?=star_rating_static($post->rating__lighting, true)?>

                                <div class="clr"></div>

                            </li>

                            <li>

                                <label>CONCEPT</label>

                                <?=star_rating_static($post->rating__concept, true)?>

                                <div class="clr"></div>

                            </li>

                        </ul>



                    </div>



                </div>





                <div class="post_content"><?php the_content(); ?></div>





                <table class="info_box">

                    <tr>

                        <td class="title">Keywords</td>

                        <td><?=$ksm_download->get_tax_label('keyword', false)?></td>

                    </tr>

                    <tr>

                        <td class="title">Era</td>

                        <td><?=$ksm_download->get_tax_label('era')?></td>

                    </tr>

                    <tr>

                        <td class="title">Style</td>

                        <td><?=$ksm_download->get_tax_label('style')?></td>

                    </tr>

                    <tr>

                        <td class="title">Culture</td>

                        <td><?=$ksm_download->get_tax_label('culture')?></td>

                    </tr>



                </table>





                <div class="info_box_title">ASSET OVERVIEW</div>

                <table class="info_box">

                    <tr>

                        <td class="title">Primary Format</td>

                        <td style="text-transform: uppercase"><?=$post->primary_file_format?></td>

                    </tr>

                    <tr>

                        <td class="title">Other Formats</td>

                        <td><?=$ksm_download->get_tax_label('file_format')?></td>

                    </tr>

                    <tr>

                        <td class="title">Game Ready</td>

                        <td><?=$ksm_download->get_tax_label('game_ready')?></td>

                    </tr>

                    <tr>

                        <td class="title">3D Print Ready</td>

                        <td><?=$ksm_download->get_tax_label('print_ready')?></td>

                    </tr>

                    <tr>

                        <td class="title">Environment</td>

                        <td><?=$ksm_download->get_tax_label('environment')?></td>

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

                        <td><?=$ksm_download->get_tax_label('modeling_method')?></td>

                    </tr>

                    <tr>

                        <td class="title">Organization</td>

                        <td><?=$ksm_download->get_tax_label('organization')?></td>

                    </tr>

                    <tr>

                        <td class="title">World Scale</td>

                        <td><?=$ksm_download->get_tax_label('world_scale')?></td>

                    </tr>

                </table>









                <div class="info_box_title">TEXTURE DETAILS</div>

                <table class="info_box">

                    <tr>

                        <td class="title">Unwrapped</td>

                        <td><?=$ksm_download->get_tax_label('unwrap')?></td>

                    </tr>

                    <tr>

                        <td class="title">Textured</td>

                        <td><?=$ksm_download->get_tax_label('texturing_method')?></td>

                    </tr>

                    <tr>

                        <td class="title">Detail Maps</td>

                        <td><?=$ksm_download->get_tax_label('mapping')?></td>

                    </tr>

                    <tr>

                        <td class="title">Baked Lighting</td>

                        <td><?=$ksm_download->get_tax_label('bake_lighting')?></td>

                    </tr>

                </table>



                <div class="info_box_title">RENDERING DETAILS</div>

                <table class="info_box">

                    <tr>

                        <td class="title">Lighting Included</td>

                        <td><?=$ksm_download->get_tax_label('lighting')?></td>

                    </tr>

                    <tr>

                        <td class="title">Renderer</td>

                        <td><?=$ksm_download->get_tax_label('renderer')?></td>

                    </tr>

                </table>





            </div>

            <div class="clr"></div>

            <div class="pr-col_container_bottom"></div>

            </div>



            <?php endif; ?>







        </div>













        <div class="clr"></div>



        <div class="wall_footer">



                    <div class="ksm_pagination">





    </div>

</div>



</div>

</div>



    </div>



</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script>
$.noConflict()(function($){
$( document ).ready(function() {

$( ".gallery_container" ).before("<div class='pr-col_container_top alla'></div>");


});
});
</script>