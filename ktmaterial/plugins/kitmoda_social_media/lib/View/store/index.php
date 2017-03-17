<?php
$this->render_element('main_tabs');
$path_to_plugin = home_url(). '/ktmaterial/plugins/kitmoda_social_media/';
?>
   
<link rel="stylesheet" href="<?php echo $path_to_plugin; ?>css/jquery.mCustomScrollbar.css" />

<link rel="stylesheet" href="<?php echo $path_to_plugin; ?>css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo $path_to_plugin; ?>css/jquery.flex-images.css">
<link rel="stylesheet" href="<?php echo $path_to_plugin; ?>css/jquery-ui-pips.css"> 
<style>
    .v2 .ksm-store .ksm-sidebar .ksm_store_search .sidebar .field_group .more_options .more, .v2 .ksm-store .ksm-sidebar .ksm_store_search .sidebar .field_group .more_options .less {

        height: auto;
    }
</style>
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

<div class="ksm_profile_container store-page">

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
                    <div id="fadingCover"></div>
                    
                    <div class="content <?php if(isset($_GET['search'])){ echo 'ng-hide'; }else{ echo 'ng-scope'; } ?>" ng-show="show_page_part == 'content' ">
                        <div class="sections">
                            <section class="top-image">
                                <img src="<?php echo $path_to_plugin; ?>images/top-img.png"  alt="pic" class="bg-img">
                                <h2 class="main-idea">For artists by artists. Start exploring our richly creative model library.</h2>
                                <div class="title-img">By <span class="author">John Doe</span> - Tower in the cliffs 2017</div>
                            </section>

                            <section class="show-img-download" id="mosaic"> 
                                <?php echo $this->render_element('loading') ?>
<!--                                <a href="#"  class="item" data-w="400" data-h="267"> <img src="<?php //  echo $path_to_plugin; ?>images/galery/untitled-3-13.jpg"/></a>
                                <a href="#"  class="item" data-w="400" data-h="267"> <img src="<?php //  echo $path_to_plugin; ?>images/galery/untitled-3-13.jpg"/></a>
                                <a href="#"  class="item" data-w="400" data-h="267"> <img src="<?php //  echo $path_to_plugin; ?>images/galery/untitled-3-19.jpg"/></a>
                                <a href="#"  class="item" data-w="400" data-h="267"> <img src="<?php //  echo $path_to_plugin; ?>images/galery/untitled-3-7.jpg"/></a>-->
<!--                                <a href="#"  class="item" data-w="267" data-h="400"> <img src="<?php //  echo $path_to_plugin; ?>images/galery/untitled-3-12.jpg"/></a>
                                <a href="#"  class="item" data-w="400" data-h="267"> <img src="<?php //  echo $path_to_plugin; ?>images/galery/untitled-3-15.jpg"/></a>
                                <a href="#"  class="item" data-w="400" data-h="267"> <img src="<?php //  echo $path_to_plugin; ?>images/galery/untitled-3-19.jpg"/></a>
                                <a href="#"  class="item" data-w="400" data-h="267"> <img src="<?php //  echo $path_to_plugin; ?>images/galery/untitled-3-7.jpg"/></a>
                                <a href="#"  class="item" data-w="400" data-h="267"> <img src="<?php //  echo $path_to_plugin; ?>images/galery/untitled-3-19.jpg"/></a>
                                <a href="#"  class="item" data-w="400" data-h="267"> <img src="<?php //  echo $path_to_plugin; ?>images/galery/untitled-3-7.jpg"/></a>
                                <a href="#"  class="item" data-w="400" data-h="267"> <img src="<?php //  echo $path_to_plugin; ?>images/galery/untitled-3-19.jpg"/></a>
                                <a href="#"  class="item" data-w="400" data-h="267"> <img src="<?php //  echo $path_to_plugin; ?>images/galery/untitled-3-7.jpg"/></a>
                                <a href="#"  class="item" data-w="400" data-h="267"> <img src="<?php //  echo $path_to_plugin; ?>images/galery/untitled-3-19.jpg"/></a>
                                <a href="#"  class="item" data-w="400" data-h="267"> <img src="<?php //  echo $path_to_plugin; ?>images/galery/untitled-3-7.jpg"/></a>
                                <a href="#"  class="item" data-w="400" data-h="267"> <img src="<?php //  echo $path_to_plugin; ?>images/galery/untitled-3-19.jpg"/></a>
                                <a href="#"  class="item" data-w="400" data-h="267"> <img src="<?php //  echo $path_to_plugin; ?>images/galery/untitled-3-7.jpg"/></a>
                                <a href="#"  class="item" data-w="400" data-h="267"> <img src="<?php //  echo $path_to_plugin; ?>images/galery/untitled-3-19.jpg"/></a>
                                <a href="#"  class="item" data-w="400" data-h="267"> <img src="<?php //  echo $path_to_plugin; ?>images/galery/untitled-3-7.jpg"/></a>-->
                            
                                <div class="clear"></div>                                                  
                            </section>

                            <section class="feat-categ categ">
                                <h3>featured categories</h3>
                                <div class="description">
                                    Most popular categories
                                    <a href="#" onclick="event.preventDefault();" class="state" ng-click="goto_all('cat')">all</a>
                                </div>
                                <div class="container-categ">
                                    <?php echo $this->render_element('loading') ?>

                                    <a href="#" onclick="event.preventDefault();" class="single-category" ng-click="goto_cat(<?php echo $this->breadcrumbs('7411','category'); ?>)"><img src="<?php  echo $path_to_plugin; ?>images/store_categories_icons/Castles.svg" alt="pict"></a>
                                    <a href="#" onclick="event.preventDefault();" class="single-category" ng-click="goto_cat(<?php echo $this->breadcrumbs('8630','category'); ?>)"><img src="<?php  echo $path_to_plugin; ?>images/store_categories_icons/dragons.svg" alt="pict"></a>
                                    <a href="#" onclick="event.preventDefault();" class="single-category" ng-click="goto_cat(<?php echo $this->breadcrumbs('7521','category'); ?>)"><img src="<?php  echo $path_to_plugin; ?>images/store_categories_icons/Dungeons-&-Labyrinths.svg" alt="pict"></a>
                                    <a href="#" onclick="event.preventDefault();" class="single-category" ng-click="goto_cat(<?php echo $this->breadcrumbs('8510','category'); ?>)"><img src="<?php  echo $path_to_plugin; ?>images/store_categories_icons/ExtinctLifeDinosaurs.svg" alt="pict"></a>
                                    <a href="#" onclick="event.preventDefault();" class="single-category" ng-click="goto_cat(<?php echo $this->breadcrumbs('7374','category'); ?>)"><img src="<?php  echo $path_to_plugin; ?>images/store_categories_icons/Farm-Scenes.svg" alt="pict"></a>
                                    <a href="#" onclick="event.preventDefault();" class="single-category" ng-click="goto_cat(<?php echo $this->breadcrumbs('8508','category'); ?>)"><img src="<?php  echo $path_to_plugin; ?>images/store_categories_icons/humans.svg" alt="pict"></a>
                                    <a href="#" onclick="event.preventDefault();" class="single-category" ng-click="goto_cat(<?php echo $this->breadcrumbs('7855','category'); ?>)"><img src="<?php  echo $path_to_plugin; ?>images/store_categories_icons/jets.svg" alt="pict"></a>
                                    <a href="#" onclick="event.preventDefault();" class="single-category" ng-click="goto_cat(<?php echo $this->breadcrumbs('8575','category'); ?>)"><img src="<?php  echo $path_to_plugin; ?>images/store_categories_icons/Land-Mammals.svg" alt="pict"></a>
                                    <a href="#" onclick="event.preventDefault();" class="single-category" ng-click="goto_cat(<?php echo $this->breadcrumbs('7829','category'); ?>)"><img src="<?php  echo $path_to_plugin; ?>images/store_categories_icons/Sci-Fi-Vehicles.svg" alt="pict"></a>
                                    <a href="#" onclick="event.preventDefault();" class="single-category" ng-click="goto_cat(<?php echo $this->breadcrumbs('7531','category'); ?>)"><img src="<?php  echo $path_to_plugin; ?>images/store_categories_icons/Spacecraft-interiors.svg" alt="pict"></a>

                                </div>
                            </section>

                            <section class="art-categ categ">
                                <h3>art styles</h3>
                                <div class="description">
                                    isolate your projects artistic style
                                    <a href="#" onclick="event.preventDefault();" class="state" ng-click="goto_all('all')">all</a>
                                </div>
                                <div class="container-categ">
                                    <?php echo $this->render_element('loading') ?>
                                    <a href="#" onclick="event.preventDefault();" class="single-category" ng-click="goto_cat(<?php echo $this->breadcrumbs('7411','ksm_tax_style'); ?>)"><img src="<?php  echo $path_to_plugin; ?>images/store_styles_icons/classic_toon.svg" alt="pict"></a>
                                    <a href="#" onclick="event.preventDefault();" class="single-category" ng-click="goto_cat(<?php echo $this->breadcrumbs('8669','ksm_tax_style'); ?>)"><img src="<?php  echo $path_to_plugin; ?>images/store_styles_icons/decay_dystopia.svg" alt="pict"></a>
                                    <a href="#" onclick="event.preventDefault();" class="single-category" ng-click="goto_cat(<?php echo $this->breadcrumbs('8665','ksm_tax_style'); ?>)"><img src="<?php  echo $path_to_plugin; ?>images/store_styles_icons/dragons_lore.svg" alt="pict"></a>
                                    <a href="#" onclick="event.preventDefault();" class="single-category" ng-click="goto_cat(<?php echo $this->breadcrumbs('8678','ksm_tax_style'); ?>)"><img src="<?php  echo $path_to_plugin; ?>images/store_styles_icons/expressive_emotional.svg" alt="pict"></a>
                                    <a href="#" onclick="event.preventDefault();" class="single-category" ng-click="goto_cat(<?php echo $this->breadcrumbs('8664','ksm_tax_style'); ?>)"><img src="<?php  echo $path_to_plugin; ?>images/store_styles_icons/gothic_vampire.svg" alt="pict"></a>
                                    <a href="#" onclick="event.preventDefault();" class="single-category" ng-click="goto_cat(<?php echo $this->breadcrumbs('8662','ksm_tax_style'); ?>)"><img src="<?php  echo $path_to_plugin; ?>images/store_styles_icons/realism.svg" alt="pict"></a>
                                    <a href="#" onclick="event.preventDefault();" class="single-category" ng-click="goto_cat(<?php echo $this->breadcrumbs('8668','ksm_tax_style'); ?>)"><img src="<?php  echo $path_to_plugin; ?>images/store_styles_icons/sci_fi.svg" alt="pict"></a>
                                    <a href="#" onclick="event.preventDefault();" class="single-category" ng-click="goto_cat(<?php echo $this->breadcrumbs('8663','ksm_tax_style'); ?>)"><img src="<?php  echo $path_to_plugin; ?>images/store_styles_icons/steampunk.svg" alt="pict"></a>
                                    <a href="#" onclick="event.preventDefault();" class="single-category" ng-click="goto_cat(<?php echo $this->breadcrumbs('8677','ksm_tax_style'); ?>)"><img src="<?php  echo $path_to_plugin; ?>images/store_styles_icons/surreal.svg" alt="pict"></a>
                                    <a href="#" onclick="event.preventDefault();" class="single-category" ng-click="goto_cat(<?php echo $this->breadcrumbs('8666','ksm_tax_style'); ?>)"><img src="<?php  echo $path_to_plugin; ?>images/store_styles_icons/whimsical_fairytale.svg" alt="pict"></a>
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

<div class="ksm-store <?php if(isset($_GET['search'])){ echo 'ng-scope'; }else{ echo 'ng-hide'; } ?>"  ng-show="show_page_part == 'search' " ng-controller="search">
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
                                 <div class="field_group ng-hide"  ng-show="breadcrumbs">
                                    <div class="category">
                                        <div class="title">Category</div>
                                        <div class="edit" ng-click="switch_icon()">EDIT</div>
                                    </div>
                                     <div class="community_sidebar_linebreak_dark"></div>
                                    <div class="community_sidebar_linebreak"></div>
                                    <div class="breadcrumbs ng-hide" ng-show="breadcrumbs.length > 0">
                                        <a ng-repeat-start="item in breadcrumbs" ng-if="$last != true" ng-click="change_cat(item['id'])" style="cursor: pointer;">{{item['name']}}</a>
                                        <span ng-if="$last == true" style="color: grey; cursor: default;">{{item['name']}}</span>
                                        <span ng-repeat-end style="color: grey; cursor: default;">{{ ($last != true)? ' > ':'' }}</span>
                                    </div>
                                    <div class="breadcrumbs ng-hide" ng-show="breadcrumbs.length == 0">
                                        <a style="cursor: default;">Home</a>
                                    </div>
                                </div>
<!-- Style -->
                                <div class="field_group">
                                    <div class="title">Style</div>
                                    <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>
                                    <?php
                                    $arr_tax_styles = KSM_Taxonomy::custom_list(array('tax'=>'style'), true);
                                    if( !empty($arr_tax_styles) ){ ?>
                                        <div class="field">
                                            <input type="checkbox" class="opt_filter" name="style[]" ng-model="style['all']" ng-click="filtering()" id="ff_style_all" value="all">
                                            <label for="ff_style_all">All</label>
                                        </div>
                                            <?php
                                                $i = 0;
                                                foreach ($arr_tax_styles as $key => $tax_style) {
                                                    if($i == 6) {
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
                                    $arr_tax_cultures = KSM_Taxonomy::custom_list(array('tax'=>'culture'), true);
                                    if( !empty($arr_tax_cultures) ){ ?>
                                        <div class="field">
                                            <input type="checkbox" class="opt_filter" name="culture[]" ng-model="culture['all']" ng-click="filtering()" id="ff_culture_all" value="all">
                                            <label for="ff_culture_all">All</label>
                                        </div>
                                        <?php
                                        $i = 0;
                                        foreach ($arr_tax_cultures as $key => $tax_culture) {
                                            if($i == 6) {
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

                                    <div class="field">
                                        <input type="checkbox" class="opt_filter" name="file_format[]" ng-model="file_format['all']" ng-click="filtering()" id="ff_file_format_all" value="all">
                                        <label for="ff_file_format_all">all</label>
                                    </div>

                                    <?php
                                    $arr_tax_file_formats = KSM_Taxonomy::custom_list(array('tax'=>'file_format'), true);
                                    if( !empty($arr_tax_file_formats) ){
                                        $i = 0;
                                        foreach ($arr_tax_file_formats as $key => $tax_file_format) {
                                            if($i == 6) {
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


                                    <div class="field">
                                        <input type="checkbox" class="opt_filter" name="game_ready[]" ng-model="game_ready['all']" ng-click="filtering()" id="ff_game_ready_all" value="all">
                                        <label for="ff_game_ready_all">all</label>
                                    </div>

                                    <div class="field">
                                        <input type="checkbox" class="opt_filter" name="print_ready[]" ng-model="print_ready['yes']" ng-click="filtering()" id="ff_print_ready_yes" value="yes">
                                        <label for="ff_print_ready_yes">3D PRINT READY</label>
                                    </div>
                                    <?php
                                    $options = KSM_DataStore::Terms('game_ready', null, null);
                                    foreach ($options as $key => $value) {
                                        if(isset($value['filterable']) && $value['filterable'] == false){
                                            continue;
                                        }else {
                                            if($value['filter_label'] == 'GAME READY (MOBILE DEV)'){
                                                $value['filter_label'] = 'game ready <span>(low poly - mobile dev)</span>';
                                            }else if($value['filter_label'] == 'GAME READY (MID GEN)'){
                                                $value['filter_label'] = 'game ready <span>(mid poly)</span>';
                                            }else if($value['filter_label'] == 'GAME READY (NEXT GEN)'){
                                                $value['filter_label'] = 'game ready <span>(high poly - next gen)</span>';
                                            }else{
                                                $value['filter_label'] = false;
                                            }

                                            if($value['filter_label'] != false) {
                                                ?>
                                                <div class="field">
                                                    <input type="checkbox"
                                                           class="opt_filter"
                                                           name="game_ready[]"
                                                           ng-model="game_ready['<?php echo $key; ?>']"
                                                           ng-click="filtering()" id="ff_game_ready_<?php echo $key; ?>"
                                                           value="<?php echo $key; ?>">
                                                    <label for="ff_game_ready_<?php echo $key; ?>"><?php echo $value['filter_label']; ?></label>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </div>
<!--model construction-->
                                <div class="field_group">
                                    <div class="title">model construction</div>
                                    <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>
                                    <div class="field">
                                        <input type="checkbox" class="opt_filter" name="model_angular[]" ng-model="model_angular['all']" ng-click="filtering()" id="ff_model_angular_all" value="all">
                                        <label for="ff_model_angular_all">all</label>
                                    </div>
                                        <?php
                                        $options = KSM_DataStore::Terms('model_angular', null, null);
                                        foreach ($options as $key => $value) {
                                            if(isset($value['filterable']) && $value['filterable'] == false){
                                                continue;
                                            }else {
                                                if($value['filter_label'] == 'All Triangulated'){
                                                    $value['filter_label'] = 'triangles';
                                                }else if($value['filter_label'] == 'ALL QUADS'){
                                                    $value['filter_label'] = 'all quads';
                                                }else if($value['filter_label'] == 'OVER 90% QUADS'){
                                                    $value['filter_label'] = 'over 90% quads';
                                                }else{
                                                    $value['filter_label'] = false;
                                                }

                                                if($value['filter_label'] != false) {
                                                    ?>
                                                    <div class="field">
                                                        <input type="checkbox"
                                                               class="opt_filter"
                                                               name="model_angular[]"
                                                               ng-model="model_angular['<?php echo $key; ?>']"
                                                               ng-click="filtering()" id="ff_model_angular_<?php echo $key; ?>"
                                                               value="<?php echo $key; ?>">
                                                        <label for="ff_model_angular_<?php echo $key; ?>"><?php echo $value['filter_label']; ?></label>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                </div>
<!--model scale-->
                                <div class="field_group">
                                    <div class="title">model scale</div>
                                    <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>


<!--                                    <div class="field">-->
<!--                                        <input type="checkbox" class="opt_filter" name="model_scale[]" ng-model="model_scale['all']" ng-click="filtering()" id="ff_model_scale_all" value="all">-->
<!--                                        <label for="ff_model_scale_all">all</label>-->
<!--                                    </div>-->

                                    <?php
                                    $options = KSM_DataStore::Terms('world_scale', null, null);
                                    foreach ($options as $key => $value) {
                                        if(isset($value['filterable']) && $value['filterable'] == false){
                                            continue;
                                        }else {
                                            if($value['filter_label'] == 'REAL WORLD SCALE'){
                                                $value['filter_label'] = 'accurate world scale';
                                            }else{
                                                $value['filter_label'] = false;
                                            }

                                            if($value['filter_label'] != false) {
                                                ?>
                                                <div class="field">
                                                    <input type="checkbox"
                                                           class="opt_filter"
                                                           name="model_scale[]"
                                                           ng-model="model_scale['<?php echo $key; ?>']"
                                                           ng-click="filtering()" id="ff_model_scale_<?php echo $key; ?>"
                                                           value="<?php echo $key; ?>">
                                                    <label for="ff_model_scale_<?php echo $key; ?>"><?php echo $value['filter_label']; ?></label>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>


                                    <div class="field">
                                        <input type="checkbox" class="opt_filter" name="model_scale[]" ng-model="model_scale['no']" ng-click="filtering()" id="ff_model_scale_any" value="no">
                                        <label for="ff_model_scale_any">any scale</label>
                                    </div>


                                </div> 
<!--texture status-->
                                <div class="field_group">
                                    <div class="title">texture status</div>
                                    <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>
                                    
                                    <div class="field">
                                        <input type="checkbox" class="opt_filter" name="texturing_status[]"  ng-model="texturing_status['all']" ng-click="filtering()" id="ff_texturing_status_all" value="all">
                                        <label for="ff_texturing_status_all">all</label>
                                    </div>
                                    <div class="field">
                                        <input type="checkbox" class="opt_filter" name="texturing_status[]"  ng-model="texturing_status['none']" ng-click="filtering()" id="ff_texturing_status_none" value="none">
                                        <label for="ff_texturing_status_none">none <span>(untextured)</span></label>
                                    </div>
                                    <div class="field">
                                        <input type="checkbox" class="opt_filter" name="texturing_status[]"  ng-model="texturing_status['textured']" ng-click="filtering()" id="ff_texturing_status_textured" value="textured">
                                        <label for="ff_texturing_status_textured">textured</label>
                                    </div>
                                        <?php
                                        // texturing_status -> texturing_method
                                        $options = KSM_DataStore::Terms('texturing_method', null, null);
                                        foreach ($options as $key => $value) {
                                            if(isset($value['filterable']) && $value['filterable'] == false){
                                                continue;
                                            }else {
                                                if($value['filter_label'] == 'HAND PAINTED TEXTURES'){
                                                    $value['filter_label'] = 'textured <span>(hand painted)</span>';
                                                }else if($value['filter_label'] == 'PHOTOGRAPHS'){
                                                    $value['filter_label'] = 'textured <span>(photographs)</span>';
                                                }else if($value['filter_label'] == 'PROCEDURAL'){
                                                    $value['filter_label'] = 'textured <span>(procedural)</span>';
                                                }else{
                                                    $value['filter_label'] = false;
                                                }
                                                if($value['filter_label'] != false) {
                                                    ?>
                                                    <div class="field">
                                                        <input type="checkbox"
                                                               class="opt_filter"
                                                               name="texturing_status[]"
                                                               ng-model="texturing_status['<?php echo $key; ?>']"
                                                               ng-click="filtering()" id="ff_texturing_status_<?php echo $key; ?>"
                                                               value="<?php echo $key; ?>">
                                                        <label for="ff_texturing_status_<?php echo $key; ?>"><?php echo $value['filter_label']; ?></label>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>

                                </div>
<!--Detail Mapping-->
                                <div class="field_group">

                                    <div class="title">Detail Mapping</div>
                                    <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>


                                    <div class="field">
                                        <input type="checkbox"
                                               class="opt_filter"
                                               name="mapping[]"
                                               ng-model="mapping['none']"
                                               ng-click="filtering()"
                                               id="ff_mapping_none"
                                               value="all">
                                        <label for="ff_mapping_none">none</label>
                                    </div>

                                    <?php
                                    $options = KSM_DataStore::Terms('mapping', null, null);
                                    foreach ($options as $key => $value) {
                                        if(isset($value['filterable']) && $value['filterable'] == false){
                                            continue;
                                        }else {
                                            if($value['filter_label'] == 'NORMALS MAP'){
                                                $value['filter_label'] = 'normal mapping';
                                            }else if($value['filter_label'] == 'DISPLACEMENT MAP'){
                                                $value['filter_label'] = 'displacement mapping';
                                            }else{
                                                $value['filter_label'] = false;
                                            }

                                            if($value['filter_label'] != false) {
                                                ?>
                                                <div class="field">
                                                    <input type="checkbox"
                                                           class="opt_filter"
                                                           name="mapping[]"
                                                           ng-model="mapping['<?php echo $key; ?>']"
                                                           ng-click="filtering()" id="ff_mapping_<?php echo $key; ?>"
                                                           value="<?php echo $key; ?>">
                                                    <label for="ff_mapping_<?php echo $key; ?>"><?php echo $value['filter_label']; ?></label>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </div>
<!--Lighting Setup-->
                                <div class="field_group">

                                    <div class="title">Lighting Setup</div>
                                    <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>

                                    <div class="field">
                                        <input type="checkbox"
                                               class="opt_filter"
                                               name="lighting[]"
                                               ng-model="lighting['none']"
                                               ng-click="filtering()"
                                               id="ff_lighting_all"
                                               value="all">
                                        <label for="ff_lighting_all">none</label>
                                    </div>

                                    <?php
                                    $options = KSM_DataStore::Terms('lighting', null, null);
                                    foreach ($options as $key => $value) {
                                        if(isset($value['filterable']) && $value['filterable'] == false){
                                            continue;
                                        }else {
                                            if($value['filter_label'] == 'INCLUDED WITHIN FILE'){
                                                $value['filter_label'] = 'included';
                                            }else if($value['filter_label'] == 'NOT INCLUDED'){
                                                $value['filter_label'] = 'not included';
                                            }else{
                                                $value['filter_label'] = false;
                                            }

                                            if($value['filter_label'] != false) {
                                                ?>
                                                <div class="field">
                                                    <input type="checkbox"
                                                           class="opt_filter"
                                                           name="lighting[]"
                                                           ng-model="lighting['<?php echo $key; ?>']"
                                                           ng-click="filtering()" id="ff_lighting_<?php echo $key; ?>"
                                                           value="<?php echo $key; ?>">
                                                    <label for="ff_lighting_<?php echo $key; ?>"><?php echo $value['filter_label']; ?></label>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </div>
<!--Renderer-->
                                <div class="field_group">

                                    <div class="title">Renderer</div>
                                    <div class="community_sidebar_linebreak_dark"></div>     <div class="community_sidebar_linebreak"></div>

                                    <?php
                                    $options = KSM_DataStore::Terms('renderer', null, null);
                                    $i = 1;
                                    foreach ($options as $key => $value) {
                                        if($i == 8) {
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
                                                           ng-model="renderer['<?php echo $key; ?>']"
                                                           ng-click="filtering()" id="ff_renderer_<?php echo $key; ?>"
                                                           value="<?php echo $key; ?>">
                                                    <label for="ff_renderer_<?php echo $key; ?>"><?php echo $value['label']; ?></label>
                                                </div>
                                                <?php
                                        if($i == (int)(sizeof($options))) {
                                            ?>
                                            </div>
                                            <div class="more">Show More</div>
                                            <div class="less">Less</div>
                                            </div>
                                            <?php
                                        }
                                        $i += 1;
                                    }
                                    ?>
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
<script src="<?php echo $home_url; ?>/ktmaterial/plugins/kitmoda_social_media/js/jquery.flex-images.js"></script>
<script src='<?php echo $home_url; ?>/ktmaterial/plugins/kitmoda_social_media/js/jquery-ui-pips.js'></script>

<script>
        jQuery.noConflict()(function ($) { 
            $(document).ready(function () {
                $(".select_boxes .sbOptions").mCustomScrollbar(); 
            });
        });
</script>