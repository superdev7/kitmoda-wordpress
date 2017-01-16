<?php







class KSM_Ajax {
    
    
    
    
    static function delete_notifications() {
        KSM_Notification::delete_notifications();
    }
    
    
    static function dd_notifications() {
        KSM_Notification::notifications();
    }
    
    static function kcus() {
        KSM_S3::compose_upload_success();
    }
    
    static function ks3uplsuc() {
        KSM_S3::upload_success_action();
    }
    
    static function fvii() {
        fvii();
    }
    
    static function public_fvii() {
        fvii();
    }
    
    static function dd_messages() {
        KSM_Message::messages();
    }
    
    static function delete_messages(){
        KSM_Message::delete_messages();
    }
    
    static function read_messages(){
        KSM_Message::read_messages();
    }
    
    static function users_suggest(){
        ksm_users_suggest();
    }
    
    static function softwares_suggest(){
        ksm_softwares_suggest();
    }
    
    static function skills_suggest(){
        ksm_skills_suggest();
    }
    
    static function ksm_facet() {
        
        if($_POST['facet_type']) {
            $facet_type = $_POST['facet_type'];
            switch ($facet_type) {
                case "community" :
                    KSM_Community::facet();
                    break;
            }
        }
    }
    
    
    
    static function post_wall() {
        KSM_Wall::post();
    }
    
    static function post_wall_comment() {
        KSM_Wall::comment();
    }
    
    static function wiu() {
        KSM_Wall::upload_image(); 
    }
    
    //static function ciu() {
    //    KSM_Message::upload_image();
    //}
    
    static function plike() {
        KSM_Like::like_post_toggle(); 
    }
    
    static function clike() {
        KSM_Like::like_comment_toggle(); 
    }
    
    static function follow() {
        KSM_Follow::follow_toggle();
    }
    
    static function ksm_edit_profile() {
        KSM_profile::edit();
    }
    
    static function ksm_update_settings() {
        KSM_profile::update_settings();
    }
    
    static function uau() {
        KSM_profile::upload_avatar();
    }
    
    
    static function sharefb() {
        KSM_Share::facebook();
    }
    
    static function public_sharefb() {
        KSM_Share::facebook();
    }
    
    static function share_email() {
        KSM_Share::email();
    }
    
    static function public_share_email() {
        KSM_Share::email();
    }
    
    static function kmvg_products() {
        KSM_MultiViewGallery_Products::load_items();
    }
    
    static function public_kmvg_products() {
        KSM_MultiViewGallery_Products::load_items();
    }
    
    static function kmvg_wips() {
        KSM_MultiViewGallery_Wips::load_items();
    }
    
    static function public_kmvg_wips() {
        KSM_MultiViewGallery_Wips::load_items();
    }
    
    static function pub_step_validate() {
        KSMPublisher::validate();
    }
    
    static function pub_submit() {
        KSMPublisher::submit();
    }
    
    static function pub_upl_sa() {
        KSMPublisher::upload_success();
    }
    
    static function kgdfuh() {
        KSM_Uploader::handle_upload();
    }
    
    static function kajl() {
        //ksm_ajax_loader();
    }
    
    static function kcat() {
        KSM_Form::getCetegorySelect();
    }
    
    static function public_kcat() {
        KSM_Form::getCetegorySelect();
    }
    
    static function favorite() {
        KSM_Favorite::favorite_toggle();
    }
    
    static function send_message() {
        KSM_Message::send();
    }
    
    
    
    
    
    
}