function fit_height() {
    
    var h = $('body').height();
    $('.window').css({height:h});
    window.parent.$.colorbox.normal_resize({height : h});
            
    if($('[hec="1"]').length > 0) {
        $('[hec="1"]').each(function() {
            h = h - ($(this).outerHeight());
        });
    }
    
    $('.mce-tinymce').css({height:h});
}









$(function() {
    
    tinymce.init({
        selector: "#message",
        menubar : false,
        statusbar : false,
        resize: "both", 
        visual : true,
        plugins: [
            "link image anchor paste"
        ],
        paste_block_drop : true,
        paste_remove_styles : true,
        paste_remove_spans : true,
        paste_strip_class_attributes : true,
        valid_elements : "a[href|target|title]",
        content_css : ksm_settings.ksm_url+'css/tinyc.css',
        toolbar: false,
        fixed_toolbar_container: "#ksm_toolbar",
        init_instance_callback : function(editor) {
            fit_height();
        }
    });
    
    $('.btn_attach_link').click(function(e) {
        e.preventDefault();
        tinymce.activeEditor.plugins.link.showDialog();
    });
    
    
    fit_height();
    $(window.parent).resize(function() {
        fit_height();
    });
    
    
    $('.miu_container, .mau_container').bind( "onItemAdded", function(e) {
        window.parent.dispatchEvent(new Event('resize'));
    });
    $('.miu_container, .mau_container').bind( "onItemRemove", function(e) {
        window.parent.dispatchEvent(new Event('resize'));
    });
    
    
    $('.btn_attach_photo').click(function(e) {
        $('.btn_attach_photo_btn').trigger('click');
    });
    
    $('.btn_attachment').click(function(e) {
        $('.btn_attachment_btn').trigger('click');
    });
    
    
    $('#username').autoComplete({
        source: function(term, response){
            $.getJSON(ksm_settings.ajax_url+'?action=users_suggest', { q: term }, function(data){ response(data); });
        }
    });
    
    $('.btn_send').click(function(e) {
        e.preventDefault();
        $(this).closest('form').submit();
    });
    
    
});

