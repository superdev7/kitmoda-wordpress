<?php 
$total_slides = count($kitmoda_updates);

if($total_slides > 0) : ?>


<div class="slider updates_slider">
    <?php 
    $i = 0;
    foreach((Array) $kitmoda_updates as $upd) :
        $i++;
        $image = $upd->slider_image ? KSM_BASE_URL .'images/sliders/updates/'.$upd->slider_image : '';
        if($image) : ?>
            <div class="item">
                <div class="image"><img src="<?=$image?>"/></div>
                <div class="uinfo">
                    <div class="community_updates_slider_header">
                        
                            </div>
                    <div class="uinfo_title"><?=$upd->post_title?></div>
                    <div class="uinfo_content"><?=$upd->post_content?></div>
                </div>
                <div class="clr"></div>
            </div>
        <?php endif;
    endforeach;
    ?>
</div>
<?php endif; ?>