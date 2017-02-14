<div class="col-md-3 community_sidebar">
    <div class="community_sidebar_outline_shadow">
    <div class="community_sidebar_inset_shadow">
        <div class="community_sidebar_overlay_radial">

            <div class="inner_sidebar" style="padding-left: 20px; padding-right: 20px;">
               <div class="search">
                   <input name="q" id="ff_q" ng-model="fData_q" facet-input-model="fData.q" type="text" placeholder="Search Posts..." value="" />
                   <div ng-click="faset_set_q($event)" class="ksm_community_search_magnify"><div class="ksm_community_search_magnify_glow"></div></div>

                  <div class="clr"></div>
               </div>
               <div class="filter_header">
                  <div class="heading" style="float:left;font-size: 13px; font-family: Montserrat;">FILTER</div>
                  <div class="opt_remove_all">
                      <a href="" ng-click="clearSelection()" class="community_sidebar_remove_all"
                     style="font-family: Montserrat; font-size: 13px;float:right;">Remove All</a>
                  </div>
                  <div class="clr"></div>
               </div>
               <div class="community_sidebar_linebreak_dark"></div>
               <div class="community_sidebar_linebreak"></div>

               <div class="field" style="padding-top: 5px; padding-bottom: 2px;">
                  <div class="sidebar_checkbox">
                      <input type="checkbox" icheck-class="icheckbox_futurico" icheck-collection="fData.topic" ng-model="fData_topic_model" id="ff_topic_model" value="model" class="opt_filter" />
                  </div>
                  <div>
                     <label for="ff_topic_model" class="sidebar_filtername">Models</label>
                  </div>
               </div>
               <div class="field">
                  <div class="sidebar_checkbox">
                      <input type="checkbox" icheck-class="icheckbox_futurico" icheck-collection="fData.topic" ng-model="fData_topic_concept" id="ff_topic_concept" value="concept" class="opt_filter" />
                  </div>
                  <div>
                     <label for="ff_topic_concept" class="sidebar_filtername">Concepts</label>
                  </div>
               </div>
               <div class="field">
                  <div class="sidebar_checkbox">
                      <input type="checkbox" icheck-class="icheckbox_futurico" icheck-collection="fData.topic" ng-model="fData_topic_challenge" id="ff_topic_challenge" class="opt_filter" value="challenge" />
                  </div>
                  <div>
                     <label for="ff_topic_challenge" class="sidebar_filtername">Challenge</label>
                  </div>
               </div>
               <div class="field">
                  <div class="sidebar_checkbox">
                      <input type="checkbox" icheck-class="icheckbox_futurico" icheck-collection="fData.topic" ng-model="fData_topic_wip" id="ff_topic_wip" class="opt_filter" value="wip" />
                  </div>
                  <div>
                     <label for="ff_topic_wip" class="sidebar_filtername">WIP</label>
                  </div>
               </div>
               <div class="field">
                  <div class="sidebar_checkbox">
                      <input type="checkbox" icheck-class="icheckbox_futurico" icheck-collection="fData.topic" ng-model="fData_topic_finished" id="ff_topic_finished" class="opt_filter" value="finished" />
                  </div>
                  <div>
                     <label for="ff_topic_finished" class="sidebar_filtername">Completed Projects</label>
                  </div>
               </div><?php if($this->KUser->Auth) : ?>


               <div class="field" style="">
                  <div class="sidebar_checkbox">
                     <input icheck="icheckbox_futurico" type="checkbox" ng-model="fData.following" id="ff_following" ng-true-value="'following'" class="opt_filter" />
                  </div>
                  <div>
                     <label for="ff_following" class="sidebar_filtername">Following</label>
                  </div>
               </div><?php endif; ?>



               <div class="field" style="">
                  <div class="sidebar_checkbox">
                      <input icheck="icheckbox_futurico" type="checkbox" name="with_images" ng-model="fData.with_images" ng-true-value="'with_images'" id="ff_with_images" class="opt_filter" />
                  </div>
                  <div>
                     <label for="ff_with_images" class="sidebar_filtername">With Images</label>
                  </div>
               </div>


               <?php if($this->KUser->Auth) : ?>
               <div class="community_sidebar_linebreak_dark"></div>
               <div class="community_sidebar_linebreak"></div>

               <div class="field" style="">
                  <div class="sidebar_checkbox">
                      <input icheck="icheckbox_futurico" type="checkbox" name="my_posts" ng-model="fData.my_posts" ng-true-value="'my_posts'" id="ff_my_posts" class="opt_filter" />
                  </div>
                  <div>
                     <label for="ff_my_posts" class="sidebar_filtername">Show only my posts</label>
                  </div>
               </div>

               <?php endif; ?>

               <div class="community_sidebar_linebreak_dark"></div>
               <div class="community_sidebar_linebreak"></div>

               <div class="sort_header" style="">
                  <div class="heading" style="font-size: 13px; font-family: Montserrat;padding-top: 10px;">SORT BY</div>
                  <div class="clr"></div>
               </div>

               <div class="community_sidebar_linebreak_dark"></div>
               <div class="community_sidebar_linebreak"></div>

               <div class="field">
                   <select ng-model="fData.sort" id="ff_sort" class="dropdown_select_test">
                          <option value="">Newest</option>
                          <option value="likes">Most Likes</option>
                          <option value="views">Most Viewed</option>
                  </select>
               </div>
               <input type="hidden" ng-model="fData.page" value="" id="ff_page" class="opt_filter" />
            </div>


            </div>
        </div>
    </div>
</div>