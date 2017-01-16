<?php $this->render_element('main_tabs'); ?>

<link rel="stylesheet" href="http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/css/jquery.jscrollpane.css?ver=4.4" />
		<link rel="stylesheet" href="http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/css/customSelectBox.css?ver=4.4" />
	



<div class="ksm-menu-sub-menu_container">

    	

        <div class="shrink-wrap-backdrop">

            <div class="shrink-wrap-vignette-left">

            </div>

            

            <div class="shrink-wrap-vignette-right">

            </div>

            

             <div class="shrink-wrap-findcenter">

                <div class="shrink-wrap-inner-highlight" style="left: -80px;">

                        <div class="shrink-wrap-inner-highlight-left"></div>

                        <div class="shrink-wrap-inner-highlight-mid"></div>

                        <div class="shrink-wrap-inner-highlight-right"></div>

                </div>

            </div>

	<div class="shrink-wrap-inner-shadow"></div>

        <div class="shrink-wrap-bottom-shadow"></div>  

    </div>



       

	

	

        

   



</div>

















<div class="ksm_profile_container">    

<div class="ksm_profile_container_overlay">

        

    <div class="ksm_profile ksm_page_collaboration">

        <div class="ksm_store_archive">

            <div class="main_overlay">

                <div class="overlay"></div>

                <?=$this->render_element('loading')?>

            </div>

            

<div class="sectionBackgroundDark">

  <div class="section">

<div class="add_post_form_highlight_top">	
                <div class="add_post_form_radius_top">
                    <div class="add_post_form_highlight_studio_overlay_top">
                    </div>
                </div>
        </div>



  <div class="section-inside">

                    <?php $this->render_element('search_form') ?>

                </div>
                
                
                
<div class="add_post_form_highlight_bottom">
                <div class="add_post_form_radius_bottom">
                    <div class="add_post_form_highlight_studio_overlay_bottom">
                    </div>
                </div>
        </div>
        
        
        


</div>

                <div class="content">

                    

                    

                    

                    <div class="sections">

                        

                        

                        <div class="section newest">
<div class="post_content_container_top"></div>
                            <div class="al_overlay">

                                <div class="overlay"></div>

                                <?=$this->render_element('loading')?>

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

                        </div>

                        

                        

                        

                        

                        

                        <div class="section trending">
<div class="post_content_container_top"></div>
                            <div class="al_overlay">

                                <div class="overlay"></div>

                                <?=$this->render_element('loading')?>

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

                        </div>

                        

                        <div class="section top_selling">
<div class="post_content_container_top"></div>
                            <div class="al_overlay">

                                <div class="overlay"></div>

                                <?=$this->render_element('loading')?>

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

                        </div>

                        

                        <div class="section top_rated">
<div class="post_content_container_top"></div>
                            <div class="al_overlay">

                                <div class="overlay"></div>

                                <?=$this->render_element('loading')?>

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

                        </div>

                        

                    </div>



                    

                <div class="clr"></div>

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
<script src='http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/css/sunny/js/jquery.mCustomScrollbar.concat.min.js'></script>
<script src="http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/js/jScrollPane.js?ver=4.4"></script>
		<script src="http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/js/SelectBox.js?ver=4.4"></script>
        <script>
		  jQuery.noConflict()(function($){	
			$(function() {
				
				$("select").each(function() {					
					var sb = new SelectBox({
						selectbox: $(this),
						height: 150,
						width: 200
					});
				});
				});
			});
		</script>
        
        <script>

                                    $(document).ready(function(){

                                     

                                            $(".select_boxes .sbOptions").mCustomScrollbar();

											$(".sort_field select").mCustomScrollbar();

										

											

                                       

                                    })(jQuery);

										

                                </script>