
<?php

//$products = EDD_FES()->vendors->get_published_products($ksm_profile->profile_user->ID);


$products = get_posts( array(
				'nopaging' => true,
				'author' => $ksm_profile->profile_user->ID,
				'post_type' => 'download',
				'post_status' => 'publish',
        'meta_query' => array(
                array('key' => '_thumbnail_id', 'value' => '0', 'compare' => '>', 'type' => 'numeric')
            )
				
			) );




?>

<script type="text/javascript">
    
    var jssor_slider1;
    
    jQuery(document).ready(function ($) {
        var options = { 
            $AutoPlay: false, 
            $ArrowKeyNavigation: true,
            $FillMode : 1,
            
            
            $ThumbnailNavigatorOptions: {
                $Class: $JssorThumbnailNavigator$,
                $ChanceToShow: 2,
                $DisplayPieces: 10
            },
            $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$,
                $ChanceToShow: 2
            }
        };
        jssor_slider1 = new $JssorSlider$('main_slider_container', options);
    });
    
    
</script>


<div class="ksm_gallery_full_view">

<div id="main_slider_container" style="position: relative; top: 0px; left: 0px; width: 800px;
        height: 690px; background: #191919; overflow: hidden;">

        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
            <div style="position: absolute; display: block; background: url(<?=KSM_BASE_URL?>img/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
        </div>
<div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 800px; height: 590px; overflow: hidden;">
<?php           
    foreach($products as $p) : ?>
        
        
        <div>
            <img u="image" src="<?=get_image_src($p->_thumbnail_id, 'full')?>" />
                <img u="thumb" src="<?=get_image_src($p->_thumbnail_id, 'avatar_small')?>" />
            </div>
        
    <?php endforeach;
?>
            
    
            
            
            
        </div>




        

        

        
        
        <div u="thumbnavigator" class="jssort01" style="position: absolute; width: 800px; height: 100px; left:0px; bottom: 0px;">
            <div u="slides" style="cursor: move;">
                <div u="prototype" class="p" style="position: absolute; width: 72px; height: 72px; top: 0; left: 0;">
                    <div class=w><div u="thumbnailtemplate" style=" width: 100%; height: 100%; border: none;position:absolute; top: 0; left: 0;"></div></div>
                    <div class=c>
                    </div>
                </div>
            </div>
            
        </div>


</div>
    
    <span u="arrowleft" class="jssora05l arrowleft" style="width: 40px; height: 40px; top: 158px; left: 8px;">
        </span>

        <span u="arrowright" class="jssora05r arrowright" style="width: 40px; height: 40px; top: 158px; right: 8px">
        </span>
    
</div>

