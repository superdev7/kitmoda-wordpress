<?php
$this->render_element('main_tabs');
$path_to_plugin = home_url(). '/ktmaterial/plugins/kitmoda_social_media/';
?>
   
<link rel="stylesheet" href="<?php echo $path_to_plugin; ?>css/jquery.scrollbar.css" />  
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

<link rel="stylesheet" href="<?php echo $path_to_plugin; ?>css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo $path_to_plugin; ?>css/jquery-ui-pips.css">
<link rel="stylesheet" href="<?php echo $path_to_plugin; ?>css/custom.css" /> 

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

                <div class="sectionBackgroundDark" ng-controller="page_content">

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

                    <div class="content" ng-show="show_page_part == 'content' ">
                        <div class="sections">
                            <section class="top-image">
                                <img src="<?php echo $path_to_plugin; ?>images/top-img.png"  alt="pic" class="bg-img">
                                <h2 class="main-idea">For artists by artists. Start exploring our richly creative model library.</h2>
                                <div class="title-img">By <span class="author">John Doe</span> - Tower in the cliffs 2017</div>
                            </section>

                            <section class="show-img-download" id="mosaic"> 
                                <?php echo $this->render_element('loading') ?>
<!--                                <a href="#"> <img src="<?php // echo $path_to_plugin; ?>images/galery/untitled-3-13.jpg" width="400" height="267"/></a>
                                <a href="#"> <img src="<?php // echo $path_to_plugin; ?>images/galery/untitled-3-19.jpg" width="400" height="267"/></a>
                                <a href="#"> <img src="<?php // echo $path_to_plugin; ?>images/galery/untitled-3-7.jpg" width="400" height="267"/></a>
                                <a href="#"> <img src="<?php // echo $path_to_plugin; ?>images/galery/untitled-3-12.jpg" width="267" height="400"/></a>
                                <a href="#"> <img src="<?php // echo $path_to_plugin; ?>images/galery/untitled-3-15.jpg" width="400" height="267"/></a>
                                <a href="#"> <img src="<?php // echo $path_to_plugin; ?>images/galery/untitled-3-18.jpg" width="400" height="267"/></a>
                                <a href="#"> <img src="<?php // echo $path_to_plugin; ?>images/galery/untitled-3-6.jpg" width="400" height="267"/></a>
                                <a href="#"> <img src="<?php // echo $path_to_plugin; ?>images/galery/untitled-3-11.jpg" width="267" height="400"/></a>
                                <a href="#"> <img src="<?php // echo $path_to_plugin; ?>images/galery/untitled-3-17.jpg" width="267" height="400"/></a>-->
                                <div class="clear"></div>                                                  
                            </section>

                            <section class="feat-categ categ">
                                <h3>featured categories</h3>
                                <div class="description">
                                    Most popular categories
                                    <a href="#" class="state">all</a>
                                </div>
                                <div class="container-categ">
                                    <?php echo $this->render_element('loading') ?>

                                    <a href="#" class="single-category"><img src="<?php  echo $path_to_plugin; ?>images/store_categories_icons/Castles.svg" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php  echo $path_to_plugin; ?>images/store_categories_icons/dragons.svg" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php  echo $path_to_plugin; ?>images/store_categories_icons/Dungeons-&-Labyrinths.svg" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php  echo $path_to_plugin; ?>images/store_categories_icons/ExtinctLifeDinosaurs.svg" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php  echo $path_to_plugin; ?>images/store_categories_icons/Farm-Scenes.svg" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php  echo $path_to_plugin; ?>images/store_categories_icons/humans.svg" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php  echo $path_to_plugin; ?>images/store_categories_icons/jets.svg" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php  echo $path_to_plugin; ?>images/store_categories_icons/Land-Mammals.svg" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php  echo $path_to_plugin; ?>images/store_categories_icons/Sci-Fi-Vehicles.svg" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php  echo $path_to_plugin; ?>images/store_categories_icons/Spacecraft-interiors.svg" alt="pict"></a>         

                                </div>
                            </section>

                            <section class="art-categ categ">
                                <h3>art styles</h3>
                                <div class="description">
                                    isolate your projects artistic style
                                    <a href="#" class="state">all</a>
                                </div>
                                <div class="container-categ">
                                    <?php echo $this->render_element('loading') ?>
                                    <a href="#" class="single-category"><img src="<?php  echo $path_to_plugin; ?>images/store_styles_icons/classic_toon.svg" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php  echo $path_to_plugin; ?>images/store_styles_icons/decay_dystopia.svg" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php  echo $path_to_plugin; ?>images/store_styles_icons/dragons_lore.svg" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php  echo $path_to_plugin; ?>images/store_styles_icons/expressive_emotional.svg" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php  echo $path_to_plugin; ?>images/store_styles_icons/gothic_vampire.svg" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php  echo $path_to_plugin; ?>images/store_styles_icons/realism.svg" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php  echo $path_to_plugin; ?>images/store_styles_icons/sci_fi.svg" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php  echo $path_to_plugin; ?>images/store_styles_icons/steampunk.svg" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php  echo $path_to_plugin; ?>images/store_styles_icons/surreal.svg" alt="pict"></a>
                                    <a href="#" class="single-category"><img src="<?php  echo $path_to_plugin; ?>images/store_styles_icons/whimsical_fairytale.svg" alt="pict"></a>         
                                </div>
                            </section>

                            <!-- <div class="section newest">
                                <div class="post_content_container_top"></div>
                                <div class="al_overlay">

                                    <div class="overlay"></div>

                                    <?php // echo $this->render_element('loading') ?>

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

                                    <?php // echo $this->render_element('loading') ?>

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

                                    <?php // echo $this->render_element('loading') ?>

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

                                    <?php // echo $this->render_element('loading') ?>

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

<div class="ksm-store"  ng-show="show_page_part == 'search' " ng-controller="search">
    <aside class="ksm-sidebar" id="sidebar-store">
        <div class="ksm_store_search ">
            <div class="content">
                <div class="inner_content">
                    <div class="sidebar kit-sidebar">

                        <div class="header">
                            <span>Options</span>
                        </div>

                        <div class="coll_sidebar_shadow">
                            <div class="sb_content">
                                 <div class="field_group"  ng-if="breadcrumbs">
                                    <div class="category">
                                        <div class="title">Category</div>
                                        <div class="edit">EDIT</div>
                                    </div>
                                     <div class="community_sidebar_linebreak_dark"></div>
                                    <div class="community_sidebar_linebreak"></div>
                                    <div class="breadcrumbs">
                                        <a ng-repeat="item in breadcrumbs" ng-click="change_cat(item['id'])">{{item['name']}}{{ ($last != true)? ' > ':'' }}</a>
                                    </div> 
                                </div>
<!-- Style -->
                                <div class="field_group">
                                    <div class="title">Style</div>
                                    <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>
                                    <?php
                                    $arr_tax_styles = KSM_Taxonomy::custom_list(array('tax'=>'style'));
                                    if( !empty($arr_tax_styles) ){ ?>
                                        <div class="field">
                                            <input type="checkbox" class="opt_filter" name="style[]" ng-model="style['all']" ng-click="filtering()" id="ff_style_all" value="all">
                                            <label for="ff_style_all">All</label>
                                        </div>
                                            <?php
                                                $i = 0;
                                                foreach ($arr_tax_styles as $key => $tax_style) {
                                                    if($i == (int)(sizeof($arr_tax_styles)/2)) {
                                                        ?>
                                                                <div class="more_options">
                                                                    <div class="more_options_list">
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="field">
                                                        <input type="checkbox"
                                                               class="opt_filter"
                                                               name="style[]"
                                                               ng-model="style['<?php echo $tax_style; ?>']"
                                                               ng-click="filtering()" id="ff_style_<?php echo $tax_style; ?>"
                                                               value="<?php echo $tax_style; ?>">
                                                        <label for="ff_style_<?php echo $tax_style; ?>"><?php echo $tax_style; ?></label>
                                                    </div>
                                                    <?php
                                                    $i++;
                                                    if($i == (int)(sizeof($arr_tax_styles))) {
                                                        ?>
                                                        </div>
                                                        <div class="more">Show More</div>
                                                        <div class="less">Less</div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                    <?php } ?>
                                </div>
<!-- Culture -->
                                <div class="field_group"> 
                                    <div class="title">Culture</div>
                                    <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>

                                    <?php
                                    $arr_tax_cultures = KSM_Taxonomy::custom_list(array('tax'=>'culture'));
                                    if( !empty($arr_tax_cultures) ){ ?>
                                        <div class="field">
                                            <input type="checkbox" class="opt_filter" name="culture[]" ng-model="culture['all']" ng-click="filtering()" id="ff_culture_all" value="all">
                                            <label for="ff_culture_all">All</label>
                                        </div>
                                        <?php
                                        $i = 0;
                                        foreach ($arr_tax_cultures as $key => $tax_culture) {
                                            if($i == (int)(sizeof($arr_tax_cultures)/2)) {
                                                ?>
                                                <div class="more_options">
                                                <div class="more_options_list">
                                                <?php
                                            }
                                            ?>
                                            <div class="field">
                                                <input type="checkbox"
                                                       class="opt_filter"
                                                       name="culture[]"
                                                       ng-model="culture['<?php echo $tax_culture; ?>']"
                                                       ng-click="filtering()" id="ff_culture_<?php echo $tax_culture; ?>"
                                                       value="<?php echo $tax_culture; ?>">
                                                <label for="ff_culture_<?php echo $tax_culture; ?>"><?php echo $tax_culture; ?></label>
                                            </div>
                                            <?php
                                            $i++;
                                            if($i == (int)(sizeof($arr_tax_cultures))) {
                                                ?>
                                                </div>
                                                <div class="more">Show More</div>
                                                <div class="less">Less</div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    <?php } ?>
                                </div>
<!-- Era -->
                                <div class="field_group era-slider">
                                    <div class="title">Era</div>
                                    <div class="community_sidebar_linebreak_dark"></div>
                                    <div class="community_sidebar_linebreak"></div>

                                    <div class="slider-desciption">
                                        <span class="first">prehistoric</span>
                                        <span class="to">to</span>
                                        <span class="second">future</span>
                                    </div>
                                    <div id="slider"></div>
                                </div>
<!-- polygon count -->
                                <div class="field_group polygon-count-slider">
                                    <div class="title">polygon count</div>
                                    <div class="community_sidebar_linebreak_dark"></div>
                                    <div class="community_sidebar_linebreak"></div>

                                    <div class="slider-desciption">
                                        <span class="first">0</span>
                                        <span class="to">to</span>
                                        <span class="second">15</span>
                                    </div>
                                    <div id="polygonCount"></div>
                                </div>  
<!-- File Format -->
                                <div class="field_group">
                                    <div class="title">File Format</div>
                                    <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>

                                    <?php
                                    $arr_tax_file_formats = KSM_Taxonomy::custom_list(array('tax'=>'file_format'));
                                    if( !empty($arr_tax_file_formats) ){
                                        $i = 0;
                                        foreach ($arr_tax_file_formats as $key => $tax_file_format) {
                                            if($i == (int)(sizeof($arr_tax_file_formats)/2)) {
                                                ?>
                                                <div class="more_options">
                                                <div class="more_options_list">
                                                <?php
                                            }
                                            ?>
                                            <div class="field">
                                                <input type="checkbox"
                                                       class="opt_filter"
                                                       name="file_format[]"
                                                       ng-model="file_format['<?php echo $tax_file_format; ?>']"
                                                       ng-click="filtering()" id="ff_file_format_<?php echo $tax_file_format; ?>"
                                                       value="<?php echo $tax_file_format; ?>">
                                                <label for="ff_file_format_<?php echo $tax_file_format; ?>"><?php echo $tax_file_format; ?></label>
                                            </div>
                                            <?php
                                            $i++;
                                            if($i == (int)(sizeof($arr_tax_file_formats))) {
                                                ?>
                                                </div>
                                                <div class="more">Show More</div>
                                                <div class="less">Less</div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    <?php } ?>
                                </div>


<!-- Model Type -->
                                <div class="field_group">
                                    <div class="title">Model Type</div>
                                    <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>

                                    <?php
                                    $arr_tax_game_readys = KSM_Taxonomy::custom_list(array('tax'=>'game_ready'));
                                    if( !empty($arr_tax_game_readys) ){
                                                foreach ($arr_tax_game_readys as $key => $tax_game_ready) {
                                                    ?>
                                                    <div class="field">
                                                        <input type="checkbox"
                                                               class="opt_filter"
                                                               name="game_ready[]"
                                                               ng-model="game_ready['<?php echo $tax_game_ready; ?>']"
                                                               ng-click="filtering()" id="ff_game_ready_<?php echo $tax_game_ready; ?>"
                                                               value="<?php echo $tax_game_ready; ?>">
                                                        <label for="ff_game_ready_<?php echo $tax_game_ready; ?>"><?php echo $tax_game_ready; ?></label>
                                                    </div>
                                                    <?php
                                                }
                                        ?>
                                    <?php } ?>



                                    <div class="field">
                                        <input type="checkbox" class="opt_filter" name="print_ready[]" ng-model="print_ready['yes']" ng-click="filtering()" id="ff_print_ready_yes" value="yes">
                                        <label for="ff_print_ready_yes">3D PRINT READY</label>
                                    </div>
                                    <div class="field">
                                        <input type="checkbox" class="opt_filter" name="environment[]" ng-model="environment['yes']" ng-click="filtering()" id="ff_environment_yes" value="yes">
                                        <label for="ff_environment_yes">FULL ENVIRONMENT</label>
                                    </div>
                                </div>



                                <div class="field_group">
                                    <div class="title">model construction</div>
                                    <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>
                                    <div class="field">
                                        <input type="checkbox" class="opt_filter" name="model_constr[]" ng-model="model_constr['all']" ng-click="filtering()" id="ff_model_const_all" value="all">
                                        <label for="ff_model_const_all">all</label>
                                    </div>
                                    <div class="field">
                                        <input type="checkbox" class="opt_filter" name="model_constr[]" ng-model="model_constr['triagles']" ng-click="filtering()" id="ff_model_const_triagles" value="triagles">
                                        <label for="ff_model_const_triagles">triagles</label>
                                    </div>
                                </div>

                                <div class="field_group">
                                    <div class="title">model scale</div>
                                    <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>
                                    <div class="field">
                                        <input type="checkbox" class="opt_filter" name="model_scale[]" ng-model="model_scale['all']" ng-click="filtering()" id="ff_model_scale_all" value="all">
                                        <label for="ff_model_scale_all">all</label>
                                    </div>
                                    <div class="field">
                                        <input type="checkbox" class="opt_filter" name="model_scale[]" ng-model="model_scale['any scale']" ng-click="filtering()" id="ff_model_scale_any" value="any scale">
                                        <label for="ff_model_scale_any">any scale</label>
                                    </div> 
                                </div> 

                                <div class="field_group">
                                    <div class="title">texture status</div>
                                    <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>
                                    
                                    <div class="field">
                                        <input type="checkbox" class="opt_filter" name="texturing_status[]"  ng-model="texturing_status['all']" ng-click="filtering()" id="ff_texturing_status_all" value="all">
                                        <label for="ff_texturing_status_all">all</label>
                                    </div> 
                                    <div class="more_options">
                                    <div class="more_options_list">
                                        <div class="field">
                                            <input type="checkbox" class="opt_filter" name="texturing_status[]"  ng-model="texturing_status['procedural']" ng-click="filtering()" id="ff_texturing_method_procedural" value="procedural">
                                            <label for="ff_texturing_status_none">none <span class="remark">(untextured)</span></label>
                                        </div> 
                                    </div>
                                    <div class="more">Show More</div>
                                    <div class="less">Less</div>
                                 </div>
                                </div>

                                <div class="field_group">

                                    <div class="title">Detail Mapping</div>
                                    <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>

                                    <?php
                                    $arr_tax_mappings = KSM_Taxonomy::custom_list(array('tax'=>'mapping'));
                                    if( !empty($arr_tax_mappings) ){
                                        foreach ($arr_tax_mappings as $key => $tax_mapping) {
                                            ?>
                                            <div class="field">
                                                <input type="checkbox"
                                                       class="opt_filter"
                                                       name="mapping[]"
                                                       ng-model="mapping['<?php echo $tax_mapping; ?>']"
                                                       ng-click="filtering()" id="ff_mapping_<?php echo $tax_mapping; ?>"
                                                       value="<?php echo $tax_mapping; ?>">
                                                <label for="ff_mapping_<?php echo $tax_mapping; ?>"><?php echo $tax_mapping; ?></label>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    <?php } ?>
                                </div>



                                <div class="field_group">

                                    <div class="title">Lighting Setup</div>
                                    <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>

                                    <?php
                                    $arr_tax_lightings = KSM_Taxonomy::custom_list(array('tax'=>'lighting'));
                                    if( !empty($arr_tax_lightings) ){
                                        foreach ($arr_tax_lightings as $key => $tax_lighting) {
                                            ?>
                                            <div class="field">
                                                <input type="checkbox"
                                                       class="opt_filter"
                                                       name="lighting[]"
                                                       ng-model="lighting['<?php echo $tax_lighting; ?>']"
                                                       ng-click="filtering()" id="ff_lighting_<?php echo $tax_lighting; ?>"
                                                       value="<?php echo $tax_lighting; ?>">
                                                <label for="ff_lighting_<?php echo $tax_lighting; ?>"><?php echo $tax_lighting; ?></label>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    <?php } ?>
                                </div>



                                <div class="field_group">

                                    <div class="title">Renderer</div>
                                    <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>
                                    <?php
                                    $arr_tax_renderers = KSM_Taxonomy::custom_list(array('tax'=>'renderer'));
                                    if( !empty($arr_tax_renderers) ){ ?>
                                        <div class="field">
                                            <input type="checkbox" class="opt_filter" name="renderer[]" ng-model="renderer['all']" ng-click="filtering()" id="ff_renderer_all" value="all">
                                            <label for="ff_renderer_all">All</label>
                                        </div>
                                        <?php
                                        $i = 0;
                                        foreach ($arr_tax_renderers as $key => $tax_renderer) {
                                            if($i == (int)(sizeof($arr_tax_renderers)/2)) {
                                                ?>
                                                <div class="more_options">
                                                <div class="more_options_list">
                                                <?php
                                            }
                                            ?>
                                            <div class="field">
                                                <input type="checkbox"
                                                       class="opt_filter"
                                                       name="renderer[]"
                                                       ng-model="renderer['<?php echo $tax_renderer; ?>']"
                                                       ng-click="filtering()" id="ff_renderer_<?php echo $tax_renderer; ?>"
                                                       value="<?php echo $tax_renderer; ?>">
                                                <label for="ff_renderer_<?php echo $tax_renderer; ?>"><?php echo $tax_renderer; ?></label>
                                            </div>
                                            <?php
                                            $i++;
                                            if($i == (int)(sizeof($arr_tax_renderers))) {
                                                ?>
                                                </div>
                                                <div class="more">Show More</div>
                                                <div class="less">Less</div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
    <section class="ksm-content posts">
        <div class="pictures">
        </div>
    </section>
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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src='<?php echo $home_url; ?>/ktmaterial/plugins/kitmoda_social_media/css/sunny/js/jquery.mCustomScrollbar.concat.min.js'></script> 
<script src="<?php echo $home_url; ?>/ktmaterial/plugins/kitmoda_social_media/js/jquery.scrollbar.min.js"></script>  
 
<script src="<?php echo $home_url; ?>/ktmaterial/plugins/kitmoda_social_media/js/jquery-gp-gallery.js"></script>
<script src='<?php echo $home_url; ?>/ktmaterial/plugins/kitmoda_social_media/js/jquery-ui-pips.js'></script>

<!--<script src="<?php // echo $home_url; ?>/ktmaterial/plugins/kitmoda_social_media/js/custom.js"></script>-->
<script>
        jQuery.noConflict()(function ($) { 
            $(document).ready(function () {
                $(".select_boxes .sbOptions").mCustomScrollbar(); 
            });
        });
</script>