<?php

$ar_sorts = array('newest', 'oldest');
$sort = $_GET['sort'] ? $_GET['sort'] : 'oldest';
$sort = in_array($sort, $ar_sorts) ? $sort : 'oldest';

?>



<?php $this->render_element('main_tabs'); ?>
<div class="ksm-menu-sub-menu_container">

<div class="shrink-wrap-backdrop">

            <div class="shrink-wrap-vignette-left">

        </div>
            <div class="shrink-wrap-vignette-right">
    </div>


             <div class="shrink-wrap-findcenter">
                <div class="shrink-wrap-inner-highlight collaboration">

                        <div class="shrink-wrap-inner-highlight-left"></div>

                        <div class="shrink-wrap-inner-highlight-mid"></div>

                        <div class="shrink-wrap-inner-highlight-right"></div>

</div>

            </div>



        </div>

    <div class="shrink-wrap-inner-shadow"></div>

        <div class="shrink-wrap-bottom-shadow"></div>


</div>
<div class="ksm_profile_container">



<div class="ksm_profile_container_collaboration_topline">
    <div class="ksm_profile_container_collaboration_topline_ving_left"></div>
    <div class="ksm_profile_container_collaboration_topline_ving_right"></div>
</div>
<div class="ksm_profile_container_overlay">
    <div class="ksm_profile ksm_page_collaboration">











     <div class="header_highlight_community">

                <div class="header radius_top">

                    <div class="wall_title">COLLABORATION PORTAL</div>

                    <div class="clr"></div>

                </div>

				</div>







        <div class="main_content">

        <div class="top_tabs">

        <?php $this->render_element('collaboration_navigation'); ?>

</div>
  <div class="clr"></div>


<div class="pr-col">
            <?php $this->render_element('partner_projects_sidebar'); ?>

            <div class="coll_page_right">

 <div class="pr-col_container_top"></div>
<div class="sectionBackgroundDark">

                <div class="section">

               <div class="sectionOverlay">



                <div class="collab_page projects">


                    <?php
                    if($auth_error) :
                        echo '<div class="posts">'.login_message('collaboration_partner_projects').'</div>';
                    elseif($no_post_found) : ?>
                        <div class="posts"><div class="empty_msg">You have no partner projects.</div></div>
                    <?php else :

                        $full_status_text = $current_project->fullStatusText();
                        $p_views = $current_project->ProjectViews(array('sort'=>$sort));

                        ?>


                        <div class="posts">

                            <div class="main_header">
                        <div class="project_info">
                            <div class="thumb">
                                <?=$current_project->Collaboration->the_thumb('partner_proj_thumb')?>
                            </div>
                            <div class="info">
                                <div class="proj_name"><?=$current_project->post_title?></div>
                                <div class="status"><?=$current_project_status?></div>
                                <div class="keywords"><span>Keywords :</span>  <span class="rt_txt"><?=$current_project->Collaboration->get_tax_label('keyword', false)?></span><div class="clr"></div></div>
                                <div class="era"><span>Era :</span> <span class="rt_txt"><?=$current_project->Collaboration->get_tax_label('era')?></span><div class="clr"></div></div>
                                <div class="style"><span>Style :</span> <span class="rt_txt"><?=$current_project->Collaboration->get_tax_label('style')?></span><div class="clr"></div></div>
                                <div class="culture"><span>Culture :</span> <span class="rt_txt"> <?=$current_project->Collaboration->get_tax_label('culture')?></span><div class="clr"></div></div>
                            </div><div class="clr"></div>
                        </div>

                        <div class="partner_info">
                            <div class="proj_name"><?=$current_project_author->display_name_link()?></div>
                            <div class="role-out">
                                <div class="role"><?=$current_project_author_role?></div>
                                <div class="price_share">Price Share <?=edd_currency_filter($current_project->total_price_share)?></div>
                                <div class="clr"></div>
                            </div>

                            <div class="avatar">
                                <?=$current_project_author->avatar_link()?>
                            </div>

                            <div class="info info_ryt">
                                <div class="completed">Completed Collaborations <span><?=get_number($current_project_author->completed_collaborations)?></span></div>
                                <div class="artwork">Artwork <span><?=star_rating_static2($current_project_author->artwork_rating)?></span></div>
                                <div class="communication">Communication <span><?=star_rating_static2($current_project_author->communication_rating)?></span> <div class="clr"></div></div>
                            </div>
                            <div class="clr"></div>
                        </div>
                        <div class="clr"></div>
                    </div>

                    <?php if($full_status_text) : ?>
                    <div class="project_full_status">
                        <div class="prj_heading">PROJECT STATUS</div>
                        <div class="status"><?=$full_status_text?></div>
                    </div>
                    <?php endif; ?>

                    <div class="posts_header">
                        <div  class="prj_heading">
                        <div class="col_title">PROJECT STAGES</div>
                        <div class="col_sort">
                            <form method="get">
                                <label>Sort</label>
                                <select name="sort" id="ff_sort">
                                    <option value="newest"<?=($sort == 'newest'?' selected="selected"' : '')?>>NEWEST FIRST</option>
                                    <option value="oldest"<?=($sort == 'oldest'?' selected="selected"' : '')?>>OLDEST FIRST</option>
                                </select>
                            </form>
                        </div><div class="clr"></div>
                        </div>
                    </div>

                        <?php

                        $p_views = $current_project->ProjectViews(array('sort'=>$sort));
                        foreach((Array) $p_views['wip'] as $v => $v_args) {
                            $this->render_element('partner_project_wip', $v_args);
                        }

                        if($p_views['ask_rate']) {
                            $this->render_element("partner_project_ask_rate");
                        }

                        if(!$current_project->isWaitingForFeedback()) {
                            $this->render_element('partner_project_message_form');
                        }

                        ?>
                        </div>
                        <?php endif; ?>







                </div>

            </div>

               </div>

               </div>

 <div class="pr-col_container_bottom"></div>
        <div class="clr"></div>

                <div class="community_sidebar_footer"></div>

                <div class="clr"></div>

        </div>

        <div class="clr"></div>
        </div>


  <div class="clr"></div>
        </div>

        <div class="main_footer"></div>



    </div>

</div>



</div>


<script type="text/javascript">
		$(function () {
			$("#ff_sort").selectbox();
		});
</script>