<div class="window_content">
    <script type="text/javascript">
    $(document).ready(function(){
        $(".ksm_gallery_multi_views .grid_view .grid").justifiedGallery({rowHeight: 170, maxRows : 3, itemsPerRow : 4 , margins:12, captions: false});
        
        
    });    
    </script>
    
    <div class="win_header" hec="1">
        <div class="title"><?=$ksm_profile->profile_user->user_login?>'s Favorites<span class="counter"><?=$ksm_profile->favorites['favorites_count']?></span></div>
        <a class="close"></a>
    </div>
    
    <div class="content">
        <div class="favories_multi_gallery ksm_gallery_multi_views">
            <div class="mini_grid_view_container">

                <div class="grid_view">
                    <div class="grid">
                <?php 
                
                foreach($ksm_profile->favorites['results'] as $f) : 
                    $p = get_post($f->item_id);

                    $img = '';

                    if($p->post_type == 'attachment') {
                        $img = get_image_src($p->ID, 'gallery_grid');
                    } elseif($p->post_type == 'download') {
                        $img = get_image_src($p->_thumbnail_id, 'gallery_grid');
                    } elseif($p->post_type == 'ksm_wip') {
                        $img = get_image_src($p->image, 'gallery_grid');
                    }
                    
                    
                    $sh_item = KSM_Share::get_shareable_item($p);
                    
                    

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
                                    <li class="favorites">
                                        <span type="favorite" class="button <?=$fav_action['class']?>" rel="<?=$fav_action['action']?>"></span>
                                        <span class="count"><?=get_number($p->favorites_count)?></span>
                                    </li>
                                    <li class="likes">
                                        <span type="plike" class="button <?=$like_action['class']?>" rel="<?=$like_action['action']?>"></span>
                                        <span class="count"><?=get_number($p->likes_count)?></span>
                                    </li>
                                    <li class="share">
                                        <span class="button" data-item="<?=$sh_item->ID?>"></span>
                                    </li>
                                    
                                    <li class="extra">
                                        <?php if($p->post_type == 'download') : ?>
                                        <a class="buy lp" href="<?=get_permalink($p->ID)?>">BUY</a>
                                        <?php endif; ?>
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

    <div class="footer" hec="1">
        <div class="pagination jspaging">
            <?php
            $prev_page = $ksm_profile->favorites['current_page'] > 1 ? $ksm_profile->favorites['current_page']-1 : false;
            $next_page = $ksm_profile->favorites['current_page'] < $ksm_profile->favorites['pages_count'] ? $ksm_profile->favorites['current_page'] + 1 : false;
            ?>

            <?php if($prev_page) :?>
                <a href="<?=get_pagenum_link($prev_page)?>" rel="<?=$prev_page?>" class="prev"></a>
            <?php endif; ?>
                <span class="info"><?=$ksm_profile->favorites['current_page']?> of <?=$ksm_profile->favorites['pages_count']?></span>
            <?php if($next_page) :?>
                <a href="<?=get_pagenum_link($next_page)?>" rel="<?=$next_page?>" class="next"></a>
            <?php endif; ?>
        </div>
    </div>
</div>