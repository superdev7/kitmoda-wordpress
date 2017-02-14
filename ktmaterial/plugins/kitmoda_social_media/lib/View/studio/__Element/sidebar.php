<?php
$skills = str_replace(',', ', ', $this->KUser->Access->skills);
$softwares = str_replace(',', ', ', $this->KUser->Access->softwares);
?>

<div class="col-xs-12 col-md-4 col-lg-3 ksm_profile_user_sidebar_v2">
    <div class="userinfo">
        <div class="header radius_top">
            <div class="header_region_overlay">
                <div class="avatar">
                    <?=$this->KUser->Access->avatar_link()?>
                </div>
                <div class="info">
                    <div class="username"><?=strtoupper($this->KUser->Access->display_name())?></div>
                    <div class="website">
                        <a target="_blank" href="<?=$this->KUser->Access->user_url?>"><?=$this->KUser->Access->user_url?></a>
                    </div>
                    <?php if($this->KUser->isPublic) :
                    $follow_action = KSM_Action::follow_toggle($this->KUser->Access->ID, $this->KUser->Auth->ID);
                    ?>
                    <div>
                        <a href="<?=ksm_get_permalink("message/compose/{$this->KUser->Access->user_login}")?>" class="btn btn_blue btn_message colorbox"><span>Message</span></a>
                        <a href="" class="btn btn_blue btn_follow <?=$follow_action['class']?>" rel="<?=$follow_action['action']?>"><span><?=$follow_action['text']?></span></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="stats">
        <div class="stats_inset_shadow">
            <div class="project_stats section">
                <div class="section_heading">
                    <div class="heading">STUDIO GALLERY</div>
                    <div class="clr"></div>
                    <div class="studio_sidebar_linebreak_mid"></div>
                    <div class="studio_sidebar_linebreak"></div>
                </div>
                <div class="sub_section">
                    <div class="heading">FINISHED ARTWORK</div>
                    <ul>
                        <li class="finishedart_views">
                            <span class="stat_heading">Views</span>
                            <div class="counter_likes_views">
                                <span class="counter_likes_views_text">
                                    <?=get_number($this->KUser->Access->finished_post_count)?>
                                </span>
                            </div>
                        </li>
                        <li class="finishedart_likes">
                            <span class="stat_heading">Likes</span>
                            <div class="counter_likes_views">
                                <span class="counter_likes_views_text">
                                 <?=get_number($this->KUser->Access->finished_post_likes)?>
                             </span>
                         </div>
                     </li>
                 </ul>
             </div>

             <div class="sub_section">
                <div class="heading">WIP ARTWORK</div>
                <ul>
                    <li class="finishedart_views">
                        <span class="stat_heading">Views</span>
                        <div class="counter_likes_views"><span class="counter_likes_views_text"><?=get_number($this->KUser->Access->wip_post_count)?></span></div>
                    </li>
                    <li class="finishedart_likes">
                        <span class="stat_heading">Likes</span>
                        <div class="counter_likes_views"><span class="counter_likes_views_text"><?=get_number($this->KUser->Access->wip_post_likes)?></span></div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="project_stats section">
            <div class="section_heading">
                <div class="heading">PRODUCT SUCCESS</div>
                <div class="clr"></div>
                <div class="studio_sidebar_linebreak_mid"></div>
                <div class="studio_sidebar_linebreak"></div>
            </div>
            <div class="sub_section">
                <ul>
                    <li class="products_solo<?=((get_number($this->KUser->Access->solo_rating_products) == 0) ? ' empty_rating' : '')?>">
                        <span class="stat_heading">Solo Products</span>
                        <?=star_rating_static($this->KUser->Access->solo_rating, true)?>
                        <div class="counter"><span class="counter_text"><?=get_number($this->KUser->Access->solo_rating_products)?> <?php if ((get_number($this->KUser->Access->solo_rating_products))>1) echo "Reviews";?><?php if ((get_number($this->KUser->Access->solo_rating_products))==1) echo "Review";?></span></div>
                    </li>
                    <li class="products_team<?=((get_number($this->KUser->Access->team_rating_products) == 0) ? ' empty_rating' : '')?>">
                        <span class="stat_heading">Team Products</span>
                        <?=star_rating_static($this->KUser->Access->team_rating, true)?>
                        <div class="counter"><span class="counter_text"><?=get_number($this->KUser->Access->team_rating_products)?> <?php if ((get_number($this->KUser->Access->team_rating_products))>1) echo "Reviews";?><?php if ((get_number($this->KUser->Access->team_rating_products))==1) echo "Review";?></span></div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="project_stats section">
            <div class="section_heading">
                <div class="heading">ROLE SUCCESS</div>
                <div class="clr"></div>
                <div class="studio_sidebar_linebreak_mid"></div>
                <div class="studio_sidebar_linebreak"></div>
            </div>

            <div class="sub_section">
                <ul>
                    <li class="concept_artist<?=((get_number($this->KUser->Access->concept_rating_products) == 0) ? ' empty_rating' : '')?>">
                        <span class="stat_heading">Concept Artist</span>
                        <?=star_rating_static($this->KUser->Access->concept_rating, true)?>
                        <div class="counter"><span class="counter_text"><?=get_number($this->KUser->Access->concept_rating_products)?> <?php if ((get_number($this->KUser->Access->concept_rating_products))>1) echo "Reviews";?><?php if ((get_number($this->KUser->Access->concept_rating_products))==1) echo "Review";?></span></div>
                    </li>
                    <li class="modeler<?=((get_number($this->KUser->Access->model_rating_products) == 0) ? ' empty_rating' : '')?>">
                        <span class="stat_heading">Modeler</span>
                        <?=star_rating_static($this->KUser->Access->model_rating, true)?>
                        <div class="counter"><span class="counter_text"><?=get_number($this->KUser->Access->model_rating_products)?> <?php if ((get_number($this->KUser->Access->model_rating_products))>1) echo "Reviews";?><?php if ((get_number($this->KUser->Access->model_rating_products))==1) echo "Review";?></span></div>
                    </li>
                    <li class="texture_artist<?=((get_number($this->KUser->Access->texture_rating_products) == 0) ? ' empty_rating' : '')?>">
                        <span class="stat_heading">Texture Artist</span>
                        <?=star_rating_static($this->KUser->Access->texture_rating, true)?>
                        <div class="counter"><span class="counter_text"><?=get_number($this->KUser->Access->texture_rating_products)?> <?php if ((get_number($this->KUser->Access->texture_rating_products))>1) echo "Reviews";?><?php if ((get_number($this->KUser->Access->texture_rating_products))==1) echo "Review";?></span></div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="project_stats section">
            <div class="section_heading">
                <div class="heading">COLLABORATION SUCCESS</div>
                <div class="clr"></div>
                <div class="studio_sidebar_linebreak_mid"></div>
                <div class="studio_sidebar_linebreak"></div>
            </div>

            <div class="sub_section">
                <div class="heading">PERFORMANCE</div>
                <ul>
                    <li class="contribution<?=((get_number($this->KUser->Access->contribution_rating_products) == 0) ? ' empty_rating' : '')?>">
                        <span class="stat_heading">Contribution</span>
                        <?=star_rating_static($this->KUser->Access->contribution_rating, true)?>
                        <div class="counter"><span class="counter_text"><?=get_number($this->KUser->Access->contribution_rating_products)?> <?php if ((get_number($this->KUser->Access->contribution_rating_products))>1) echo "Reviews";?><?php if ((get_number($this->KUser->Access->contribution_rating_products))==1) echo "Review";?></span></div>
                    </li>
                    <li class="maintained<?=((get_number($this->KUser->Access->maintained_asset_rating_products) == 0) ? ' empty_rating' : '')?>">
                        <span class="stat_heading">Maintained</span>
                        <?=star_rating_static($this->KUser->Access->maintained_asset_rating, true)?>
                        <div class="counter"><span class="counter_text"><?=get_number($this->KUser->Access->maintained_asset_rating_products)?> <?php if ((get_number($this->KUser->Access->maintained_asset_rating_products))>1) echo "Reviews";?><?php if ((get_number($this->KUser->Access->maintained_asset_rating_products))==1) echo "Review";?></span></div>
                    </li>
                </ul>
            </div>

            <div class="sub_section">
                <div class="heading">INTERACTION</div>
                <ul>
                    <li class="communication<?=((get_number($this->KUser->Access->c_communication_rating_collaborations) == 0) ? ' empty_rating' : '')?>">
                        <span class="stat_heading">Communication</span>
                        <?=star_rating_static($this->KUser->Access->c_communication_rating, true)?>
                        <div class="counter"><span class="counter_text"><?=get_number($this->KUser->Access->c_communication_rating_collaborations)?> <?php if ((get_number($this->KUser->Access->c_communication_rating_collaborations))>1) echo "Reviews";?><?php if ((get_number($this->KUser->Access->c_communication_rating_collaborations))==1) echo "Review";?></span></div>
                    </li>
                    <li class="peer_review<?=((get_number($this->KUser->Access->count_collaboration_ratings) == 0) ? ' empty_rating' : '')?>">
                        <span class="stat_heading">Peer Art Review</span>
                        <?=star_rating_static($this->KUser->Access->c_artwork_rating, true)?>
                        <div class="counter"><span class="counter_text"><?=get_number($this->KUser->Access->count_collaboration_ratings)?> <?php if ((get_number($this->KUser->Access->count_collaboration_ratings))>1) echo "Reviews";?><?php if ((get_number($this->KUser->Access->count_collaboration_ratings))==1) echo "Review";?></span></div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="skills_stats section">
            <div class="heading">SKILLS</div>
            <div class="clr"></div>
            <div class="studio_sidebar_linebreak_mid"></div>
            <div class="studio_sidebar_linebreak"></div>
            <div class="skills"><?=$skills?></div>
        </div>

        <div class="software_stats section">
            <div class="heading">SOFTWARE</div>
            <div class="clr"></div>
            <div class="studio_sidebar_linebreak_mid"></div>
            <div class="studio_sidebar_linebreak"></div>
            <div class="softwares"><?=$softwares?></div>
        </div>

        <div class="languages_stats section">
            <div class="heading">LANGUAGES</div>
            <div class="clr"></div>
            <div class="studio_sidebar_linebreak_mid"></div>
            <div class="studio_sidebar_linebreak"></div>
            <ul>
                <li class="primary"><span class="stat_heading_narrow">Primary</span> <span class="lang"><?=get_Language($this->KUser->Access->primary_lang)?></span></li>
                <li class="secondary"><span class="stat_heading_narrow">Secondary</span> <span class="lang"><?=get_Language($this->KUser->Access->secondary_lang)?></span></li>
            </ul>
        </div>
    </div>
</div>



</div>




<?php


if(get_number($this->KUser->Access->followings_count) > 0 || $this->KUser->isPrivate) :
    include 'following_gallery.php';
endif;
?>

<?php
if(get_number($this->KUser->Access->favorites_count) > 0  || $this->KUser->isPrivate) :
    include 'favorite_gallery.php';
endif;
?>


<?php
if(get_number($this->KUser->Access->top_selling_count) > 0 || $this->KUser->isPrivate) :
    include 'top_selling_gallery.php';
endif;
?>



</div>