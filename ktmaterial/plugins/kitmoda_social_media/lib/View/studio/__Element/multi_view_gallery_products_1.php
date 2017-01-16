<?php


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





<div class="ksm_gallery_multi_views gallery products_gallery" data-name="products" cp="1" tp="2">
    <div class="grid_view_container">
        
        
        <div class="bg_container">
            <div class="bg">
                <div class="level2"></div>
                <div class="level1"></div>
            </div>
        </div>
    
        <div class="grid_view">
            <div class="grid">
        <?php 
        $c = 0;
        foreach($products as $p) : 
            $grid_img = get_image_src($p->_thumbnail_id, 'gallery_grid');
            include KSM_BASE_PATH.'templates/__elements/gallery_grid_item.php';
            $c++;
        endforeach; 

        ?>
        </div>
        <!-- other images... -->
        </div>
    </div>
    
    
    
    <div class="grid_full_view_container">
        
        
    </div>
        
    
    
    
    <div class="full_view_container">
        <div style="position: relative;">
            <div class="full_view_controls"></div>
            <div class="full_view">

                <div class="slider">
                    <?php foreach($products as $p) : ?>
                    <div data-item="<?=$p->ID?>">
                        <img src="<?=get_image_src($p->_thumbnail_id, 'full')?>" />
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    
         
        <div class="gallery_back_btn"><a href="">BACK TO GALLERY</a></div>
        <div class="nav_container">
            
            <div class="nav">
                <div class="nav_controls">
                    <button type="button" data-role="none" class="slick-prev" aria-label="previous"></button>
                    <button type="button" data-role="none" class="slick-next" aria-label="next"></button>
                </div>
                <div class="slider" >
                    <?php foreach($products as $p) : ?>
                    <div>
                        <div class="outer_border">
                            <img src="<?=get_image_src($p->_thumbnail_id, 'avatar_small_2')?>" />
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
        </div>
        
        <div class="info_container">
            <div class="info_box"></div>
        </div>
    </div> 
            
    
    
    


    
    
    

</div>