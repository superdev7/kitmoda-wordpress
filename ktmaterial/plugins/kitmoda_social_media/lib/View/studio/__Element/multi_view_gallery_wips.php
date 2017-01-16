
<?php

//$products = EDD_FES()->vendors->get_published_products($ksm_profile->profile_user->ID);


$wips = get_posts( array(
				'posts_per_page' => '20',
                                'paged' => '1',
				'author' => $ksm_profile->profile_user->ID,
				'post_type' => 'ksm_wip',
				'post_status' => 'publish',
        'meta_query' => array(
                array('key' => 'image', 'value' => '0', 'compare' => '>', 'type' => 'numeric')
            )
				
			) );


$total_products = $ksm_profile->profile_user->wips_count;
$current_page = 1;
$total_pages = ceil($total_products/20);


?>





<div class="ksm_gallery_multi_views gallery wips_gallery" data-name="wips">

    <div class="mini_grid_view_container">
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
        foreach($wips as $p) : 
            $grid_img = get_image_src($p->image, 'gallery_grid');
            include KSM_BASE_PATH.'templates/__elements/gallery_grid_item.php';
            ?>
            
        <?php 
        $c++;

            
        endforeach; 

        ?>
        </div>
        <!-- other images... -->
        </div>
    </div>
    
    
    
    
    
    <div class="grid_view_container">
        <div class="grid_view">
            <div class="grid">
                <?php
                $c = 0;
                foreach($wips as $p) : 
                    $grid_img = get_image_src($p->image, 'gallery_grid');
                    include KSM_BASE_PATH.'templates/__elements/gallery_grid_item.php';
                    $c++;
                endforeach; 
                
                ?>
            </div>
        <!-- other images... -->
        </div>
        
        <div class="grid_back_btn"><a href="">CLOSE</a></div>
        
        
        <div class="ksm_pagination">
            <?php 
            
            echo $ksm_profile->profile_user->wips_count;
            echo paginate_links( 
                        
                        array('prev_text' => '',
                            'next_text' => '',
                            'total' => $ksm_profile->profile_user->wip_count
                            )
                        
                        ); ?>
                </div>
        
        
        
        
    </div>
        
    
    
    
    <div class="full_view_container">
        <div style="position: relative;">
            <div class="full_view_controls"></div>
            <div class="full_view">

                <div class="slider">
                    <?php foreach($wips as $p) : ?>
                    <div data-item="<?=$p->ID?>" id="wip_1_<?=$p->ID?>">
                        <img src="<?=get_image_src($p->image, 'full')?>" />
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
                    <?php foreach($wips as $p) : ?>
                    <div>
                        <div class="outer_border">
                            <img src="<?=get_image_src($p->image, 'avatar_small_2')?>" />
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