<?php
$this->render_element('main_tabs');
$path_to_plugin = home_url(). '/ktmaterial/plugins/kitmoda_social_media/';
?>

<link rel="stylesheet" href="<?php echo $path_to_plugin; ?>css/jquery.jscrollpane.css?ver=4.4" />
<link rel="stylesheet" href="<?php echo $path_to_plugin; ?>css/customSelectBox.css?ver=4.4" />
<link rel="stylesheet" href="<?php echo $path_to_plugin; ?>css/custom.css" /> 
<link rel="stylesheet" href="<?php echo $path_to_plugin; ?>css/jquery.scrollbar.css" />
<link rel="stylesheet" href="<?php echo $path_to_plugin; ?>css/jquery-ui-slider-pips.css" />
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

<div class="ksm-menu-sub-menu_container">

    <div class="shrink-wrap-backdrop">

        <div class="shrink-wrap-vignette-left"></div>
        <div class="shrink-wrap-vignette-right"></div>

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

        <div class="ksm_profile ksm_page_collaboration">

            <div class="ksm_store_archive">

                <div class="main_overlay">

                    <div class="overlay"></div>

                    <?= $this->render_element('loading') ?>

                </div>

                <div class="sectionBackgroundDark">

                    <div class="section">

                        <!-- <div class="add_post_form_highlight_top">
                            <div class="add_post_form_radius_top">
                                <div class="add_post_form_highlight_studio_overlay_top">
                                </div>
                            </div>
                        </div> -->

                        <div class="section-inside">
                            <?php $this->render_element('search_form') ?>
                        </div>

                        <!-- <div class="add_post_form_highlight_bottom">
                            <div class="add_post_form_radius_bottom">
                                <div class="add_post_form_highlight_studio_overlay_bottom"></div>
                            </div>
                        </div> -->
                        
                    </div>

                    <div class="content">

                        <div class="sections">
                            <section class="top-image">
                                <img src="<?php echo $path_to_plugin; ?>images/top-img.png"  alt="pic" class="bg-img">
                                <h2 class="main-idea">For artists by artists. Start exploring our richly creative model library.</h2>
                                <div class="title-img">By <span class="author">John Doe</span> - Tower in the cliffs 2017</div>
                            </section>

                            <section class="show-img-download" id="mosaic"> 
                                 <a href="#" class="grid-item"><img src="<?php echo $path_to_plugin; ?>images/store/pict1.jpg" alt="pict"></a> 
                                 <a href="#" class="grid-item"><img src="<?php echo $path_to_plugin; ?>images/store/pict3.jpg" alt="pict"></a> 
                                 <a href="#" class="grid-item"><img src="<?php echo $path_to_plugin; ?>images/store/pict2.jpg" alt="pict"></a>
                                 <a href="#" class="grid-item"><img src="<?php echo $path_to_plugin; ?>images/store/pict4.jpg" alt="pict"></a> 
                                 <a href="#" class="grid-item"><img src="<?php echo $path_to_plugin; ?>images/store/pict1.jpg" alt="pict"></a> 
                                 <a href="#" class="grid-item"><img src="<?php echo $path_to_plugin; ?>images/store/pict2.jpg" alt="pict"></a>
                                 <a href="#" class="grid-item"><img src="<?php echo $path_to_plugin; ?>images/store/pict1.jpg" alt="pict"></a> 
                                 <a href="#" class="grid-item"><img src="<?php echo $path_to_plugin; ?>images/store/pict1.jpg" alt="pict"></a> 
                                 <a href="#" class="grid-item"><img src="<?php echo $path_to_plugin; ?>images/store/pict1.jpg" alt="pict"></a> 
                                 <a href="#" class="grid-item"><img src="<?php echo $path_to_plugin; ?>images/store/pict2.jpg" alt="pict"></a>
                                  
                            </section>

                            <section class="feat-categ categ">
                                <h3>featured categories</h3>
                                <div class="description">
                                    Most popular categories
                                    <a href="#" class="state">all</a>
                                </div>
                                <div class="container-categ">
                                    <a href="#" class="single-category"><img src="<?php echo $path_to_plugin; ?>images/store_categories_icons/Castles.png" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php echo $path_to_plugin; ?>images/store_categories_icons/dragons.png" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php echo $path_to_plugin; ?>images/store_categories_icons/Dungeons-&-Labyrinths.png" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php echo $path_to_plugin; ?>images/store_categories_icons/ExtinctLifeDinosaurs.png" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php echo $path_to_plugin; ?>images/store_categories_icons/Farm-Scenes.png" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php echo $path_to_plugin; ?>images/store_categories_icons/humans.png" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php echo $path_to_plugin; ?>images/store_categories_icons/jets.png" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php echo $path_to_plugin; ?>images/store_categories_icons/Land-Mammals.png" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php echo $path_to_plugin; ?>images/store_categories_icons/Sci-Fi-Vehicles.png" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php echo $path_to_plugin; ?>images/store_categories_icons/Spacecraft-interiors.png" alt="pict"></a>         
                                </div>
                            </section>

                            <section class="art-categ categ">
                                <h3>art styles</h3>
                                <div class="description">
                                    isolate your projects artistic style
                                    <a href="#" class="state">all</a>
                                </div>
                                <div class="container-categ">
                                    <a href="#" class="single-category"><img src="<?php echo $path_to_plugin; ?>images/store_categories_icons/Castles.png" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php echo $path_to_plugin; ?>images/store_categories_icons/Castles.png" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php echo $path_to_plugin; ?>images/store_categories_icons/Castles.png" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php echo $path_to_plugin; ?>images/store_categories_icons/Castles.png" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php echo $path_to_plugin; ?>images/store_categories_icons/Castles.png" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php echo $path_to_plugin; ?>images/store_categories_icons/Castles.png" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php echo $path_to_plugin; ?>images/store_categories_icons/Castles.png" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php echo $path_to_plugin; ?>images/store_categories_icons/Castles.png" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php echo $path_to_plugin; ?>images/store_categories_icons/Castles.png" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php echo $path_to_plugin; ?>images/store_categories_icons/Castles.png" alt="pict"></a>         
                                </div>
                            </section>

                            <!-- <div class="section newest">
                                <div class="post_content_container_top"></div>
                                <div class="al_overlay">

                                    <div class="overlay"></div>

                                    <?= $this->render_element('loading') ?>

                                </div>
                                <div class="sec_header"><span>Newest Models</span></div>

                                <div class="ksm_gallery_multi_views">

                                    <div class="grid_view_container">

                                        <div class="grid_view">

                                            <div class="grid">

                                                <div class="posts al_content"></div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="post_content_container_bottom"></div>

                            </div> -->

                            <!-- <div class="section trending">
                                <div class="post_content_container_top"></div>
                                <div class="al_overlay">

                                    <div class="overlay"></div>

                                    <?= $this->render_element('loading') ?>

                                </div>

                                <div class="sec_header"><span>Trending Models</span></div>

                                <div class="ksm_gallery_multi_views">

                                    <div class="grid_view_container">

                                        <div class="grid_view">

                                            <div class="grid">

                                                <div class="posts al_content"></div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="post_content_container_bottom"></div>

                            </div> -->

                           <!--  <div class="section top_selling">
                                <div class="post_content_container_top"></div>
                                <div class="al_overlay">

                                    <div class="overlay"></div>

                                    <?= $this->render_element('loading') ?>

                                </div>

                                <div class="sec_header"><span>Top Selling Models</span></div>

                                <div class="ksm_gallery_multi_views">

                                    <div class="grid_view_container">

                                        <div class="grid_view">

                                            <div class="grid">

                                                <div class="posts al_content"></div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="post_content_container_bottom"></div>

                            </div> -->

                            <!-- <div class="section top_rated">
                                <div class="post_content_container_top"></div>
                                <div class="al_overlay">

                                    <div class="overlay"></div>

                                    <?= $this->render_element('loading') ?>

                                </div>

                                <div class="sec_header"><span>Top Rated Models</span></div>

                                <div class="ksm_gallery_multi_views">

                                    <div class="grid_view_container">

                                        <div class="grid_view">

                                            <div class="grid">

                                                <div class="posts al_content"></div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="post_content_container_bottom"></div>

                            </div> -->

                        </div>

                        <div class="clr"></div>

                    </div>

                    <div class="wall_footer">

                        <div class="ksm_pagination">

                            <?php
                            echo paginate_links(
                                    array('prev_text' => '',
                                        'next_text' => '')
                            );
                            ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="clr"></div>

    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src='<?php echo $home_url; ?>/ktmaterial/plugins/kitmoda_social_media/css/sunny/js/jquery.mCustomScrollbar.concat.min.js'></script>
<script src="<?php echo $home_url; ?>/ktmaterial/plugins/kitmoda_social_media/js/jScrollPane.js?ver=4.4"></script>
<script src="<?php echo $home_url; ?>/ktmaterial/plugins/kitmoda_social_media/js/SelectBox.js?ver=4.4"></script>
<script src="<?php echo $home_url; ?>/ktmaterial/plugins/kitmoda_social_media/js/mason.js"></script> 
<script src="<?php echo $home_url; ?>/ktmaterial/plugins/kitmoda_social_media/js/jquery.scrollbar.min.js"></script>  

<!--<script src="<?php // echo $home_url; ?>/ktmaterial/plugins/kitmoda_social_media/js/custom.js"></script>-->

<script>

        jQuery.noConflict()(function ($) {
            $(function () { 
                $("select").each(function () {
                    var sb = new SelectBox({
                        selectbox: $(this),
                        height: 150,
                        width: 200
                    });
                });
            });
            $(document).ready(function () {

                $(".select_boxes .sbOptions").mCustomScrollbar();

                $(".sort_field select").mCustomScrollbar();

            });
        });
</script>