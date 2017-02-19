<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script>

$(document).ready(function(){
$(":checkbox").on('click', function(){
    $(this).parent().toggleClass("checked");

});
$(".opt_remove_all").click(function () {


			$(".sidebar_checkbox ").removeClass("checked");
        });


});







</script>

<link rel="stylesheet" type="text/css" href="http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/css/sunny/account.css" />
<?php $this->render_element('main_tabs'); ?>

<div class="ksm-menu-sub-menu_container">



        <div class="shrink-wrap-backdrop">

            <div class="shrink-wrap-vignette-left">

            </div>



            <div class="shrink-wrap-vignette-right">

            </div>



             <div class="shrink-wrap-findcenter">

                <div class="shrink-wrap-inner-highlight account">

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

    <div class="ksm_profile ksm_page_collaboration">

        <div class="header_highlight_community">

            <div class="header radius_top">

                <div class="wall_title">ACCOUNT</div><div class="clr"></div>

            </div>

        </div>

        <div class="main_content account_products_main">



            <?php $this->render_element('account_sub_tabs'); ?>

















            <div class="pr-col">










<div class="sale_stats-contaner">

<div class="pr-col_container_top"></div>
        <div class="sale_stats">



            <div class="section_heading">

                    <div class="heading" style="float:left;font-size: 15px; font-family: Montserrat;">PRODUCTS</div>

                    <div class="clr"></div>

                    <div class="community_sidebar_linebreak"></div>

            </div>

            <div class="total_stats section">

                <ul>

                    <li>

                        <div class="stat_name">ALL PRODUCTS</div>

                        <div class="stat_content">

                            <div class="stat_rating"><?=star_rating_static2($ksm_user->count_models_rating, true)?></div>

                            <div class="stat_count"><?=get_number($ksm_user->count_models)?></div><div class="clr"></div>

                        </div>

                        <div class="clr"></div>

                    </li>

                    <li>

                        <div class="stat_name">SOLO PRODUCTS</div>

                        <div class="stat_content">

                            <div class="stat_rating"><?=star_rating_static2($ksm_user->count_solo_models_rating, true)?></div>

                            <div class="stat_count amount"><?=get_number($ksm_user->count_solo_models)?></div><div class="clr"></div>

                        </div>

                        <div class="clr"></div>

                    </li>

                    <li class="collab_model_stat">

                        <div class="stat_name">COLLABORATION PRODUCTS</div>

                        <div class="stat_content">

                            <div class="stat_rating"><?=star_rating_static2($ksm_user->count_collaboration_models_rating, true)?></div>

                            <div class="stat_count amount"><?=get_number($ksm_user->count_collaboration_models)?></div><div class="clr"></div>

                        </div>

                        <div class="clr"></div>

                    </li>

                    <li class="clr"></li>

                </ul>

            </div>



            <div class="community_sidebar_linebreak"></div>



            <div class="model_type_stats section">





                <ul class="texture_model_stats">

                    <li>

                        <div class="stat_name">Textured Models</div>

                        <div class="stat_content">

                            <div class="stat_rating"><?=star_rating_static2($ksm_user->count_textured_models_rating, true)?></div>

                            <div class="stat_count"><?=get_number($ksm_user->count_textured_models)?></div><div class="clr"></div>

                        </div>

                        <div class="clr"></div>

                    </li>

                    <li>

                        <div class="stat_name">Textured Models</div>

                        <div class="stat_content">

                            <div class="stat_rating"><?=star_rating_static2($ksm_user->count_solo_textured_models_rating, true)?></div>

                            <div class="stat_count amount"><?=get_number($ksm_user->count_solo_textured_models)?></div><div class="clr"></div>

                        </div>

                        <div class="clr"></div>

                    </li>

                    <li class="collab_model_stat">

                        <div class="stat_name">Textured Models</div>

                        <div class="stat_content">

                            <div class="stat_rating"><?=star_rating_static2($ksm_user->count_collaboration_textured_models_rating, true)?></div>

                            <div class="stat_count amount"><?=get_number($ksm_user->count_collaboration_textured_models)?></div><div class="clr"></div>

                        </div>

                        <div class="clr"></div>

                    </li>

                    <li class="clr"></li>

                </ul>



                <ul class="untexture_model_stats">

                    <li>

                        <div class="stat_name">Untextured Models</div>

                        <div class="stat_content">

                            <div class="stat_rating"><?=star_rating_static2($ksm_user->count_untextured_models_rating, true)?></div>

                            <div class="stat_count"><?=get_number($ksm_user->count_untextured_models)?></div><div class="clr"></div>

                        </div>

                        <div class="clr"></div>

                    </li>

                    <li>

                        <div class="stat_name">Untextured Models</div>

                        <div class="stat_content">

                            <div class="stat_rating"><?=star_rating_static2($ksm_user->count_solo_untextured_models_rating, true)?></div>

                            <div class="stat_count amount"><?=get_number($ksm_user->count_solo_untextured_models)?></div><div class="clr"></div>

                        </div>

                        <div class="clr"></div>

                    </li>

                    <li class="collab_model_stat">

                        <div class="stat_name">Untextured Models</div>

                        <div class="stat_content">

                            <div class="stat_rating"><?=star_rating_static2($ksm_user->count_collaboration_untextured_models_rating, true)?></div>

                            <div class="stat_count amount"><?=get_number($ksm_user->count_collaboration_untextured_models)?></div><div class="clr"></div>

                        </div>

                        <div class="clr"></div>

                    </li>

                    <li class="clr"></li>

                </ul>









            </div>



	</div>

                <div class="pr-col_container_bottom"></div>

                </div>







                <?php $this->render_element('sales_sidebar'); ?>



                <div class="coll_page_right">



                    <div class="sectionBackgroundDark">

                        <div class="section">
<div class="pr-col_container_top"></div>
                            <div class="sectionOverlay">

                                <div class="products posts"></div>

                            </div>

                              <div class="pr-col_container_bottom"></div>

                        </div>

                    </div>















                </div><div class="clr"></div>

            </div>



            <div class="clr">

            </div>

        </div>











    </div>



</div>







</div>







<script type="text/javascript">

		$(function () {

			$("#ff_sort").selectbox();

		});

</script>