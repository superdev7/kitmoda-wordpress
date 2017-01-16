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



        <div class="ksm_store_search">

            <div class="main_overlay">

                    <div class="overlay"></div>

                    <?=$this->render_element('loading')?>

                </div>

                

                <div class="content">

                    

<div class="sectionBackgroundDark">

  <div class="section">
<div class="add_post_form_highlight_top">	
                <div class="add_post_form_radius_top">
                    <div class="add_post_form_highlight_studio_overlay_top">
                    </div>
                </div>
        </div>
  <div class="section-inside srchsrch">

<div class="breadcrumb"></div>

                    <div class="search_box">

                        

                        

                        <div class="select_boxes ">

                            <div class="clr"></div>

                        </div>



                        <div class="field field_inp"><input type="text" name="q" id="ff_q" value="" placeholder="Search..."> <div class="field button"><span></span></div></div>



                       



                        <div class="clr"></div>

                    </div>

                    

                    

                    

                    

                    

                    <div class="sort_field">

                        <select class="light">

                            <option value="">SORT</option>

                            <option value="price">Price</option>

                            <option value="rating">Rating</option>

                            <option value="trending">Trending</option>

                            <option value="top_selling">Top Selling</option>

                        </select>

                    </div>

                    <div class="clr"></div>



                       </div>
                       
                       
             <div class="add_post_form_highlight_bottom">
                <div class="add_post_form_radius_bottom">
                    <div class="add_post_form_highlight_studio_overlay_bottom">
                    </div>
                </div>
        </div>          
                       

                    </div>

                    </div>

                    <div class="inner_content">

                        <?php $this->render_element('sidebar'); ?>

                        

                        <div class="posts_container">

                            <div class="ksm_gallery_multi_views">



                           <div class="sectionBackgroundDark-right">
 
 <div class="pr-col_container_top"></div>
 
                           <div class="section-right">

                           <div class="sectionOverlay-right">

                            <div class="grid_view_container">

                                <div class="grid_view">

                                    <div class="grid">

                                        <div class="posts grid_page">

                                        </div>

                                    </div>

                                </div>

                            </div>

                            </div>

                        </div>

<div class="pr-col_container_bottom"></div>

                            </div>

                            

                            

                <div class="community_sidebar_footer"></div>

      



                            </div>



                        </div>

                        <div class="clr"></div>

                    </div>

                

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













        

        <div class="clr"></div>

    </div>

</div>




		<script src='http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/css/sunny/js/store.js'></script>
		<script src="http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/js/SelectBox.js?ver=4.4"></script>



  
<script>
		  jQuery.noConflict()(function($){	
			$(function() {
				
				$("select").each(function() {					
					var sb = new SelectBox({
						selectbox: $(this),
					});
				});
				});
			});
		</script>

                                
