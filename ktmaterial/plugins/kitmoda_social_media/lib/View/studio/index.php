<?php

// $this->render_element('top_banner_box');
$this->render_element('main_tabs');
?>


<div class="ksm-menu-sub-menu_container">
    <div class="shrink-wrap-backdrop">
        <div class="shrink-wrap-vignette-left"></div>
        <div class="shrink-wrap-vignette-right"></div>
        <div class="shrink-wrap-findcenter">
            <div class="shrink-wrap-inner-highlight" style="left: -521px;">
                <div class="shrink-wrap-inner-highlight-left"></div>
                <div class="shrink-wrap-inner-highlight-mid"></div>
                <div class="shrink-wrap-inner-highlight-right"></div>
            </div>
        </div>
        <div class="shrink-wrap-inner-shadow"></div>
        <div class="shrink-wrap-bottom-shadow"></div>
    </div>
</div>
<div class="std-out multi_view_galleries_main">
    <div class="row row-inset col-xs-12 col-md-10 col-md-offset-1 ksm_profile">
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
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="multi_view_galleries">
                <?php $this->Mvg->design();?>
                <div class="dprms">
                    <input type="hidden" name="std" value="<?=$studio_id?>" />
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xs-12 ksm_profile_container_studio_topline">
    <div class="ksm_profile_container_studio_topline_ving_left"></div>
    <div class="ksm_profile_container_studio_topline_ving_right"></div>
</div>

<div class="col-xs-12 ksm_profile_container_studio">
    <div class="col-xs-12 col-md-10 col-md-offset-1 no-left-pad ksm_profile_container_overlay_studio">
        <div class="ksm_profile">
            <?php $this->render_element('sidebar');?>
            <div class="col-xs-12 col-md-8 col-lg-9 ksm_profile_user_wall_container_v2">
                <div ng-controller="kSPostsController" class="ksm_profile_user_wall ksm_profile_user_wall_sty">
                    <div class="content main_content">
                        <?php
                        if($this->KUser->isPrivate) :
                            $this->render_element('add_post');
                        endif;
                        ?>
                        <div class="posts">
                            <div k-s-post class="post" id="wp_{{kpost.post_id}}" ng-repeat="kpost in kposts"></div>
                        </div>
                        <?php if($this->KUser->isPrivate) : ?>
                            <div ng-if="kposts.length == 0">Add new post.</div>
                        <?php endif; ?>
                    </div>
                    <div class="ff_opts">
                        <input type="hidden" name="page" id="ff_page" value="" />
                        <input type="hidden" id="studio_id" value="<?=$studio_id?>" />
                    </div>
                    <div class="community_sidebar_footer wall_footer_pag">
                        <div class="ksm_pagination">
                            <uib-pagination items-per-page="paging.rpp" total-items="paging.totalItems" ng-change="pageChanged()" ng-model="paging.currentPage" max-size="5" class="pagination-sm" boundary-link-numbers="true" template-url="<?=KSM_PARTIALS_URL."pagination.html"?>" previous-text="&lsaquo;" next-text="&rsaquo;" rotate="false"></uib-pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>