<?php
// $this->render_element('top_banner_box_community_public');
?>
<?php $this->render_element('main_tabs'); ?>

<div class="ksm-menu-sub-menu_container">
    <div class="shrink-wrap-backdrop">
        <div class="shrink-wrap-vignette-left"></div>
        <div class="shrink-wrap-vignette-right"></div>
        <div class="shrink-wrap-findcenter">
            <div class="shrink-wrap-inner-highlight community">
                <div class="shrink-wrap-inner-highlight-left"></div>
                <div class="shrink-wrap-inner-highlight-mid"></div>
                <div class="shrink-wrap-inner-highlight-right"></div>
            </div>
        </div>
        <div class="shrink-wrap-inner-shadow"></div>
        <div class="shrink-wrap-bottom-shadow"></div>
    </div>
</div>

<div class="kit_mosaic_outer">
    <div class="kit_mosaic_upper_shadow_positioner_container">
        <div class="kit_mosaic_upper_shadow"></div>
    </div>
    <?php
    /* jason commented this block out for mosaic
    <div class="ksm_profile">
        <div class="std-out-sm">
            <div class="shrink-wrap-inner">
                <div class="ksm-menu-sub-menu">
                    <div class="gallery_tabs">
                        <select>
                            <?php foreach((Array) $this->Mvg->galleries as $mvgt) : ?>
                            <option value="<?=$mvgt->name?>"><?=$mvgt->tab_name?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <?php if($this->Mvg->galleries) : ?>
                    <div class="gallery_options">
                        <ul>
                            <li class="grid_ec expand"></li>
                            <li class="clr"></li>
                        </ul><div class="clr"></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            */
            ?>
            <div class="multi_view_galleries">
                <?php $this->Mvg_kit_mosaic->design_kit_mosaic();?>
                <?php
                /* jason commented this block out for mosaic
                <div class="dprms">
                    <input type="hidden" name="std" value="<?=$studio_id?>" />
                </div>
                */
                ?>
            </div>
            <?php
        /* jason commented this block out for mosaic
        </div>
    </div>
    */
    ?>
    <div class="kit_mosaic_lower_shadow_positioner_container">
        <?php
        /*
        <div class="kit_mosaic_lower_shadow"></div>
        */
        ?>
    </div>
</div>

<div class="ksm_profile_container_studio_topline">
    <div class="ksm_profile_container_studio_topline_ving_left"></div>
    <div class="ksm_profile_container_studio_topline_ving_right"></div>
</div>

<div class="row row-inset ksm_profile_container_studio">
   <div class="col-xs-12 col-md-10 col-md-offset-1 ksm_profile_container_overlay_studio">
    <div class="ksm_profile">
        <div class="magazine_container_icon"></div>
        <div class="magazine_container_title">
            <span>Kitmoda Focus</span>
            <div class="magazine_title_subtitle">
                <span>Latest Industry News, Featured Artists, and Inspiration</span>
            </div>
        </div>

        <div class="magazine_container">
            <div class="magazine_article_box"></div>
            <div class="magazine_article_box"></div>
            <div class="magazine_article_box"></div>
            <div class="magazine_article_box"></div>
            <div class="magazine_article_box"></div>
        </div>

        <div class="magazine_container_icon feed_icon"></div>
        <div class="magazine_container_title">
            <span>Community Feed</span>
            <div class="magazine_title_subtitle">
                <span>Artist's exhibits and thoughts</span>
            </div>
        </div>

        <div ng-controller="kSPostsController">
            <div class="col-md-9 ksm_community" style="float:left;">
                <div class="main_overlay" ng-show="loading">
                    <div class="overlay"></div>
                    <?=$this->render_element('loading')?>
                </div>

                <div class="content">
                    <div class="posts_container">
                        <?=$this->render_element('add_post')?>
                        <div class="posts">
                            <div k-s-post class="post" id="wp_{{kpost.post_id}}" ng-repeat="kpost in kposts | orderBy : '-post_id'"></div>
                        </div>
                    </div>
                </div>
                <div class="wall_footer">
                    <div class="ksm_pagination">
                        <uib-pagination items-per-page="paging.rpp" total-items="paging.totalItems" ng-change="pageChanged()" ng-model="paging.currentPage" max-size="5" class="pagination-sm" boundary-link-numbers="true" template-url="<?=KSM_PARTIALS_URL."pagination.html"?>" previous-text="&lsaquo;" next-text="&rsaquo;" rotate="false"></uib-pagination>
                    </div>
                </div>
            </div>
            <?php $this->render_element('sidebar'); ?>
        </div>
    </div>
</div>
</div>