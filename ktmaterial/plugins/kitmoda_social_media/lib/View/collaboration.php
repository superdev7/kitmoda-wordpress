<?php

get_header('ksm');


$ksm_profile = KSM_profile::getInstance();




///include '__elements/top_banner_box.php';
?>

<?php   include '__elements/main_tabs.php'; ?>



    
<script type="text/javascript">
    $(document).ready(function(){
        $(".ksm_gallery_multi_views .grid_view .grid").justifiedGallery({rowHeight: 170, maxRows : 3, itemsPerRow : 4 , margins:12, captions: false});
        
        
    });    
    </script>




    
<div class="ksm_profile_container">    

    <div class="ksm_profile ksm_page_collaboration">
        
        
        <div class="main_header"><div class="title">COLLABORATION PORTAL</div></div>
        
        <div class="main_content">
            <?php include 'collaboration/sidebar.php'; ?>
            <div class="coll_page_right">
                <div class="collab_page join">
                    
                    <?php
                    
                    //$posts = KSM_Collaboration::search(array('type'=>'concept'));
                    
                    
                    ?>
                    
                    
                    
                    
                    
                    <div class="favories_multi_gallery ksm_gallery_multi_views">
            <div class="mini_grid_view_container">

                <div class="grid_view">
                    <div class="grid">
                <?php 
                
                foreach($posts as $p) : 
                    //$p = get_post($f->item_id);

                    $img = '';

                    
                    $img = get_image_src($p->_thumbnail_id, 'gallery_grid');
                    
                    
                    
                    
                    
                    

                    $fav_action = KSM_Action::favorite_toggle($p);
                    $like_action = KSM_Action::post_like_toggle($p);
                    ?>
                    <div class="item">
                        <a class="img_item" href="<?=$img?>">
                            <img src="<?=$img?>" />
                        </a>
                        <div class="stats">
                            <div class="bg"></div>
                            <ul class="image_stats">
                                <li class="views">
                                    <span class="button"></span>
                                    <span class="count"><?=$p->views_count?></span>
                                </li>
                                <li class="likes">
                                    <span type="plike" class="button <?=$like_action['class']?>" rel="<?=$like_action['action']?>"></span>
                                    <span class="count"><?=get_number($p->likes_count)?></span>
                                </li>
                            </ul>
                            <?php if($p->post_type == 'download') : ?>
                            <span class="info_btn tooltip tooltipstered">
                                <div class="description"><?=$p->post_content?></div>
                            </span>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php 
                KSM_postView::add($p);
                
                endforeach; 

                ?>

                <!-- other images... -->
                </div>
                    </div>

            </div>





        </div>
                    
                    
                    
                    
                    
                    
                    
                    
                    
                   
                    
                    
                </div>
            </div>
        <div class="clr"></div>
        </div>
        <div class="main_footer"></div>
        
    </div>
</div>

<?php get_footer(); ?>