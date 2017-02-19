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

         <div class="pr-col_container_top"></div>
         <div class="pr-col">


            <?php $this->render_element('sidebar'); ?>
            <div class="coll_page_right">
<div class="sectionBackgroundDark">
                <div class="section">
               <div class="sectionOverlay">

                <div class="collab_page requests">

<div class="">
                        <div class="space-post">


                    <div class="posts">

                        <?php

                        if($auth_error) :
                            echo login_message('collaboration_requests');
                        elseif($no_post_found) :
                            echo "<div class=\"empty_msg\">You have no incoming collaboration requests.</div>";

                        else :

                            while ( $query->have_posts() ) : $query->the_post();
                                $this->render_element('request_item', array('post' => get_post()));
                            endwhile;

                        endif;

                        ?>



                    </div>


                    </div>


</div>
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

                   <div class="pr-col_container_bottom"></div>
           <div class="clr"></div>
        </div>

        <div class="main_footer"></div>



    </div>

                </div>

    </div>