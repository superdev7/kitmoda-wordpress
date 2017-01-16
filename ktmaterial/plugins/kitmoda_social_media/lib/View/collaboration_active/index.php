<?php $this->render_element('main_tabs'); ?>

<div class="ksm-menu-sub-menu_container">



	<div class="shrink-wrap-backdrop">	

            <div class="shrink-wrap-vignette-left">

	</div>

            

            <div class="shrink-wrap-vignette-right">

	</div>
        
        
        
             <div class="shrink-wrap-findcenter">
        
                <div class="shrink-wrap-inner-highlight" style="left: -315px;">
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
        
        
        
        


        

        <div class="main_content">
        
        <div class="top_tabs">
        <?php $this->render_element('collaboration_navigation'); ?>
         </div>
         
         <div class="clr"></div>
         
         
         <div class="pr-col">


            <?php $this->render_element('sidebar'); ?>
            <div class="coll_page_right">
 <div class="pr-col_container_top"></div>
<div class="sectionBackgroundDark">
                <div class="section">
               <div class="sectionOverlay">
               
                <div class="collab_page requests">
                    
                    <div class="posts">
                        
                        
                        
                        <?php 
                        if($auth_error) :
                            echo login_message('collaboration_active');
                        elseif($no_post_found) : 
                            echo '<div class="empty_msg">You have no active collaboration.</div>';
                        else :
                            
                            $first = ' first';
                        
                            while ( $query->have_posts() ) : $query->the_post();
                                $post = get_post();
                                echo "<div class=\"steps {$first}\">";
                                $active = new KSM_CollaborationActive($post->ID);
                                echo $active->render_steps();
                                echo '</div>';
                                $first = '';
                            endwhile;
                        endif;
                        ?>
                        <div class="clr"></div>
                    </div>
                    
                    
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
