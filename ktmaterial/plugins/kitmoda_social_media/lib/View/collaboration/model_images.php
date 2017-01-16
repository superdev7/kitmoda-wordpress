<?php $this->render_element('main_tabs'); ?>
<div class="ksm-menu-sub-menu_container">
    <div class="shrink-wrap">

	<div class="shrink-wrap-backdrop">	

	</div>        

	<div class="shrink-wrap-inner-highlight" style="left: 1439px;">	

	</div>

	<div class="shrink-wrap-inner-shadow">		

	

	</div>	

        <div class="shrink-wrap-inner">
    <div class="ksm-menu-sub-menu">
        
        
        
        
    </div>
</div>
    </div>
</div>




<input type="hidden" value="<?=$filter_action?>" id="ifa" />

    
    
<div class="ksm_profile_container ksm_collab_launch_container">    

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

            <div class="main_overlay">
                    <div class="overlay"></div>
                    <?=$this->render_element('loading')?>
                </div>
            
            <?php $this->render_element('launch_sidebar'); ?>
            <div class="coll_page_right">
               <div class="sectionBackgroundDark">
                <div class="section">
               <div class="sectionOverlay">
               
                <div class="collab_page launch">
                    
                    
                    <div class="intro_box">
                        
                        
                        <div class="title">ADD UNTEXTURED MODEL FOR AN ARTIST TO TEXTURE</div>
                        <div class="info">You will select which applicant textures your model.</div>
                        <a href="<?=ksm_get_permalink('collaboration/launch/untextured/')?>" class="btn btn_blue colorbox">ADD NEW MODEL</a>
                        
                    </div>
                    
                    
                    
                    <div class="back-avail-img">
                    
                    <div class="title2">YOUR AVAILABLE MODEL IMAGES</div>
                    
                    
                    
                    <div class="ksm_gallery_multi_views">
                        <div class="grid_view_container">
                            <div class="grid_view">
                                <div class="grid">
                                    <div class="posts grid_page"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
<div class="wall_footer pagin"></div>
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
    <div class="clr"></div>
    </div>

        <div class="main_footer"></div>
</div>

    </div>
</div>