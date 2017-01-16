<div class="multi_view_galleries">
    <div class="loading">
        <div class="goverlay"></div>
        <?php include KSM_BASE_PATH.'templates/__elements/loading.php'; ?>
    </div>
    <?php 
    if($ksm_profile->profile_user->products_count > 0) {
        
        $products_gallery = new KSM_MultiViewGallery_Products(array('user_id'=>$ksm_profile->profile_user->ID));
        $products_gallery->load();
        
    }

    if($ksm_profile->profile_user->wip_count > 0) {
        $products_gallery = new KSM_MultiViewGallery_Wips(array('user_id'=>$ksm_profile->profile_user->ID));
        $products_gallery->load();
    }
    
    ?>
    
</div>


