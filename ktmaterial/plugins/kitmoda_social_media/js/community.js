
var facet_q_last_val = '';
var facet_q_timer;
/*
var kfacet = Base.extend({
    
    
    
    load : function(pagc) {
        var _this = this;
        $(this.overlay).show();
        
        
        
        var _new_h = this.getParams();
        
        if(_new_h == '') {
            history.pushState("", document.title, window.location.pathname + window.location.search);
        } else {
            window.location.hash = _new_h;
        }
        $.ajax({
            type: "POST",
            url: ksm_settings.ajax_url,
            data:this.getParams('array'),
            success: function(res) {
                $(_this.overlay).hide()
                var o = $.parseJSON(res);
                $('.posts').html(o.posts);
                $('.wall_footer').html(o.pagination);
                
                
                
                $('.posts .post .slick_attachment_gallery').each(function() {
                    
                    var gal_id = $(this).find('.gallery').attr('id');
                    
                    new slick_simple_gallery({
                        ele : '#'+gal_id
                    });
                    
                })
                
                if(pagc) {
                    $('.posts').trigger("onPaginateLoaded");
                } else if(_this.wp_id && $('#wp_'+_this.wp_id).length > 0) {
                    var targetOffset = $('#wp_'+_this.wp_id).offset().top
                    $('html,body').animate({scrollTop: targetOffset}, 300);
                    _this.wp_id = '';
                }
                
                autosize($('textarea'));
            }
        });
    }
});




*/


$(function() {
    
    
    
    
    kmv = new _kmvg('.multi_view_galleries', {
        action : 'Community_kmvg',
        kmos_args : {
                container : '.multi_view_galleries',
                switch_nav : '.gallery_tabs',
                gallery_options : '.gallery_options',
                grid_ec : '.grid_ec'
            }
    });
    
    
    $('.updates_slider').slick({
        infinite: false,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        //centerPadding : '2px',
        prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="previous"></button>',
        nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="next"></button>'
    });
    
    
    
    /*
    community_facet = new kfacet({
        element : '.community_sidebar',
        action : 'community_filter_posts',
        overlay : '.main_overlay'
    });
    
    
    $('.opt_remove_all a').click(function(e) {
        e.preventDefault();
        //$('.community_sidebar').find('.opt_filter').not('#ff_with_images').prop('checked', false);
        
        $('.community_sidebar').find('.opt_filter').prop('checked', false);
        $('.community_sidebar select option:first').prop('selected', true);
        $('input').iCheck('update');
        $('.community_sidebar .search #ff_q').val('');
        community_facet.reset_page();
        community_facet.load();
    });
    
    */
    
    
    /*
    $('.posts').delegate('.post .post_min_max .legend', 'click', function(e) {
        e.preventDefault();
        var container = $(this).closest('.post');
        
        
        container.find('.post_inner .mainp.minimized').toggle();
        container.find('.post_inner .mainp.maximized').toggle();
        
        if($(container.find('.post_inner .mainp.maximized')).is(":hidden")) {
            $(this).html('SHOW MORE')
        } else {
            $(this).html('SHOW LESS')
        }
        
        
        
        $(this).closest('fieldset').toggleClass('maximized');
        $(this).closest('fieldset').toggleClass('minimized');
        
    });
    
    
    $('.posts').delegate('.post_comments_container .legend', 'click', function() {
        var container = $(this).closest('.post_comments_container');
        
        if($(container.find('.post_comments')).is(":hidden")) {
            $(this).html('Hide Comments')
        } else {
            $(this).html('Show Comments')
        }
        
        container.toggleClass('maximized');
        container.toggleClass('minimized');
        container.find('.post_comments').slideToggle();
    });
    
    
    
    $('body').delegate('.ksm_pagination a', 'click', function(e) {
        e.preventDefault();
        $('#ff_page').val($(this).attr('rel'));
        community_facet.load(true);
    })
    
    
   
    $('.posts').on("onPaginateLoaded", function() {
        $('html, body').animate({
            scrollTop: $(".posts").offset().top - 40
        }, 450);
    });
    
    
    
    $('.community_sidebar .search .ksm_community_search_button').click(function(e) {
        community_facet.reset_page();
        community_facet.load();
    });
    
    
    
    $('.community_sidebar .search #ff_q').keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if(keycode == 13) {
            community_facet.reset_page();
            community_facet.load();
        }
    });
    
    
   
    $('.community_sidebar .search #ff_q').keyup(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode !=13) {
            var val = $(this).val();
            if (val == '' && val != facet_q_last_val) {
                facet_q_last_val = val;
                clearTimeout(facet_q_timer);
                facet_q_timer = setTimeout(function(){ 
                    community_facet.reset_page();
                    community_facet.load();
                }, 500);
            } else {
                facet_q_last_val = val;
            }
        }
    });
    
    */
    
    /*
    $('body').delegate('.posts .post .thumb', 'click', function(e) {
        $(this).hide();
        
        var gal = $(this).closest('.post').find('.gallery_container');
        
        
        gal.show();
        
        var ssf = gal.find('.gallery .full .slider').slick('getSlick');
        var ssn = gal.find('.gallery .nav .slider').slick('getSlick');
        ssf.setPosition();
        ssn.setPosition();
    });
    
    
    
    $('body').delegate('.posts .post .gallery_container .gallery_back_btn', 'click', function(e) {
        $(this).closest('.gallery_container').hide();
        $(this).closest('.post').find('.thumb').show();
    });
    
   */
    
    autosize($('textarea'));
    $("#ff_sort").selectbox();
})



function add_new_post(_item, galleries) {
    
    
    angular.element(".ksm_community .content .posts").scope().kposts.push($.parseJSON(_item));
    angular.element(".ksm_community .content .posts").scope().$apply();
    
    $(".ksm_community .content .posts .empty").html("");
    $(".ksm_community .add_post_form .error").html("").hide();
    $(".ksm_community .add_post_form textarea").val("");
    $(".ksm_community .add_post_form .miu_container li.item").remove();
    $(".add_post_form [name=_id]").val("");
    
    showfmsg("Post updated.");
    autosize($('textarea'));
    
    if(galleries) {
        kmv.reset(galleries);
    }
    
    $.colorbox.close();
    
}


function edit_post(post_id, _item, galleries) {
    
    
    var msg = "Post updated.";
    
    angular.element(".ksm_community .content .posts #wp_"+post_id).scope().kpost = $.parseJSON(_item);
    angular.element(".ksm_community .content .posts #wp_"+post_id).scope().$apply();
    
    
    //console.log($(_item).find('.post_inner').html());
    //$('.ksm_community .posts .post#wp_'+post_id+' .post_inner').html($(_item).find('.post_inner').html());
    
    
    //var gal_id = $('.ksm_community .posts .post#wp_'+post_id+' .post_inner').find('.gallery').attr('id');
    //if(gal_id) {
    //    new slick_simple_gallery({ele : '#'+gal_id});
    //}
    showfmsg(msg);
    
    if(galleries) {
        kmv.reset(galleries);
    }
    $.colorbox.close();
}


function new_comment_added(pid) {
    
    
    var ccc = $(".posts .post#wp_"+pid+" .comments_count").html() || 0;
    ccc = parseInt(ccc);
    $(".posts .post#wp_"+pid+" .comments_count").html(ccc+1);
    $(".posts .post#wp_"+pid+" .post_comments_container").removeClass("no_comments");
    $(".posts .post#wp_"+pid+" .add_comment .error").html("").hide();
    $(".posts .post#wp_"+pid+" .add_comment_form textarea").val("");
    
    
    
    if($(".posts .post#wp_"+pid+" .post_comments:hidden").length > 0) {
        $(".posts .post#wp_"+pid+" .post_comments_container .legend").trigger( "click" );
    }
    
    
    
}