<?php

get_header('ksm');







$ar_sorts = array('newest', 'oldest');

$sort = $_GET['sort'] ? $_GET['sort'] : 'oldest';

$sort = in_array($sort, $ar_sorts) ? $sort : 'oldest';

?>

<?php $this->render_element('main_tabs'); ?>
<div class="ksm-menu-sub-menu_container">
    <div class="shrink-wrap">
	<div class="shrink-wrap-backdrop"></div>
	<div class="shrink-wrap-inner-highlight" style="left: 1439px;"></div>
	<div class="shrink-wrap-inner-shadow"></div>
        <div class="shrink-wrap-inner">
            <div class="ksm-menu-sub-menu"></div>
        </div>
    </div>
</div>




    
<div class="ksm_profile_container">    

<div class="ksm_profile_container_overlay">

    <div class="ksm_profile ksm_page_collaboration">
        
        
        
        

     <div class="header_highlight_community">
                <div class="header radius_top">
                    <div class="wall_title">COLLABORATION PORTAL</div>
                    <div class="clr"></div>
                </div>
				</div>

        

        <div class="main_content">
            <?php $this->render_element('partner_projects_sidebar'); ?>
            <div class="coll_page_right">
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
                                        <div class="keywords">Keywords :  <?=$current_project->Collaboration->get_tax_label('keyword', false)?></div>
                                        <div class="era">Era : <?=$current_project->Collaboration->get_tax_label('era')?></div>
                                        <div class="style">Style : <?=$current_project->Collaboration->get_tax_label('style')?></div>
                                        <div class="culture">Culture : <?=$current_project->Collaboration->get_tax_label('culture')?></div>
                                    </div><div class="clr"></div>
                                </div>
                        
                        
                        
                                <div class="partner_info">
                                    <div class="proj_name"><?=$current_project_author->display_name_link()?></div>
                                    <div>
                                        <div class="role"><?=$current_project_author_role?></div>
                                        <div class="price_share">Price Share <?=edd_currency_filter($current_project->total_price_share)?></div>
                                        <div class="clr"></div>
                                    </div>
                                    <div class="avatar">
                                        <?=$current_project_author->avatar_link()?>
                                    </div>
                                    <div class="info">
                                        <div class="completed">Completed Collaborations <?=get_number($current_project_author->completed_collaborations)?></div>
                                        <div class="artwork">Artwork <?=star_rating_static2($current_project_author->artwork_rating)?> <div class="clr"></div></div>
                                        <div class="communication">Communication <?=star_rating_static2($current_project_author->communication_rating)?> <div class="clr"></div></div>
                                    </div>
                                    <div class="clr"></div>
                                </div><div class="clr"></div>
                            </div>
                    
                            <?php if($full_status_text) : ?>
                            <div class="project_full_status">
                                <div>PROJECT STATUS</div>

                                <div class="status">
                                    <?=$full_status_text?>
                                </div>
                            </div>
                            <?php endif; ?>
                    
                    
                            <div class="posts_header">

                                <div class="col_title">PROJECT STAGES</div>
                                <div class="col_sort">
                                    <form method="get">
                                        <label>Sort</label>
                                        <select name="sort">
                                            <option value="newest"<?=($sort == 'newest'?' selected="selected"' : '')?>>NEWEST FIRST</option>
                                            <option value="oldest"<?=($sort == 'oldest'?' selected="selected"' : '')?>>OLDEST FIRST</option>
                                        </select>
                                    </form>
                                </div><div class="clr"></div>
                            </div>
                            
                            
                        
                        <?php 
                        
                        
                        
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
        <div class="clr"></div>
                <div class="community_sidebar_footer"></div>
                <div class="clr"></div>
        </div>
        <div class="clr"></div>
        </div>
        <div class="main_footer"></div>
        
    </div>
</div>

</div>
<?php get_footer(); ?>