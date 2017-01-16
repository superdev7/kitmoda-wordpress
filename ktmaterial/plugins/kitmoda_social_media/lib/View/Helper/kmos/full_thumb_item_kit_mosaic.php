<div>
    <div class="outer_border">        
        <img src="<?=$this->getTinyImage($p)?>" />    
    </div>    
    <?php if($p->total_img <= 10) : ?>
    <style>            
        .ksm_gallery_multi_views .full_view_container .nav_container .nav .nav_controls .slick-prev,            
        .ksm_gallery_multi_views .full_view_container .nav_container .nav .nav_controls .slick-next {
            display: none;
        }        
    </style>
            
    <?php endif; ?>
</div>