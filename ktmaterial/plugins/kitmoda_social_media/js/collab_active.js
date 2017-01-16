$(function() {
    
    
    
    new slick_simple_gallery({
        ele : '#project_wip_gallery'
    });
    
    new slick_simple_gallery({
        ele : '#project_fb_wait_model_mid_wip_gallery'
    });
    new slick_simple_gallery({
        ele : '#project_fb_wait_texture_mid_wip_gallery'
    });
    
    new slick_simple_gallery({
        ele : '#project_fb_wait_model_final_wip_gallery'
    });
    new slick_simple_gallery({
        ele : '#project_fb_wait_texture_final_wip_gallery'
    });
    
    
    new slick_simple_gallery({
        ele : '#project_model_mid_wip_gallery'
    });
    
    new slick_simple_gallery({
        ele : '#project_model_final_wip_gallery'
    });
    
    new slick_simple_gallery({
        ele : '#project_texture_mid_wip_gallery'
    });
    
    new slick_simple_gallery({
        ele : '#project_texture_final_wip_gallery'
    });
    
    
    
    new slick_simple_gallery({
        ele : '#cnotes_gallery',
        navigation : {
            slidesToShow : 7
        }
        
    });
    
    
    $('.collaboration_types.projects_list li').click(function(e) {
        if(!(e.target.tagName == 'A' || $(e.target).closest('a'))) {
            e.preventDefault();
        }
        window.location = $(this).attr('rel');
    });
    
    $('.col_sort select').change(function() {
        $(this).closest('form').submit();
    })
    
    
})