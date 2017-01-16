

/*
var kfacet = Base.extend({
    
    
    constructor : function(params) {
        this.element = params.element;
        this.action = params.action;
        this.overlay = params.overlay;
        this.wp_id = '';
        
        
        
        $(this.overlay).show();
        this.setParams(this.getURLParams());
        this.load();

        
    },
    
    reset_page : function() {
        $('#ff_page').val('');
    },
    
    
    getURLParams : function() {
        _params = new Array();
        if(window.location.hash) {
            var params = decodeURI(window.location.hash).substr(1).split('&');
            $.each(params, function(k, v) {
                var parts = v.split('=');
                var pname = parts[0];
                pvalue = parts[1];
                _params.push({name : pname, value : pvalue});
            });
        }
        return _params;
    },
    
    getField : function(v) {
        var name = '#ff_' + v.name;
        var value = v.value;
        var fname = name;
        
        
        if(fname.substr(-2) == '[]') {
            fname = fname.replace('[]', '') + '_' + value;
        }
        
        if($(fname).length > 0) {
            return $(fname);
        }
        
    },
    
    setParams : function(params) {
        var _this = this;
        
        $.each(params, function(k, v){
            
            var field = _this.getField(v);
            
            if(v.name == 'wp_id') {
                _this.wp_id = v.value;
            }
            
            if(field) {
                if(field.prop('tagName') == 'INPUT') {
                    if(field.attr('type') == 'checkbox' || field.attr('type') == 'radio') {
                        field.prop('checked', true);
                    } else if(field.attr('type') == 'text' || field.attr('type') == 'hidden') {
                        field.val(v.value);
                    }
                } else if(field.prop('tagName') == 'SELECT') {
                    field.val(v.value);
                }
            }
        });
        
    },
    
    getParams : function(type) {
        
        var params = new Array();
        var params_query = new Array();
        
        var data_obj = $(this.element).find('input, select').serializeArray();
        
        $.each(data_obj, function(k, v){
            if(v.value != "") {
                params.push({name : v.name , value : v.value});
                params_query.push(v.name+'='+ v.value);
            }
        });
        
        
        if(type == 'array') {
            params.push({name : 'action', value : this.action});
        } else {
            params = params_query.join('&');
        }
        
        return params;
    },
    
    
    load : function(pagc) {
        var _this = this;
        $(this.overlay).show();
        
        
        
        var _new_h = this.getParams();
        
        
        if(_new_h == '') {
            history.pushState("", document.title, window.location.pathname + window.location.search);
        } else {
            window.location.hash = _new_h;
        }
        
        var aja = this.getParams('array');
        aja.push({name : 'studio', value:$('#studio_id').val()});
        //console.log(aja)
        $.ajax({
            type: "POST",
            url: ksm_settings.ajax_url,
            data:aja,
            success: function(res) {
                $(_this.overlay).hide()
                var o = $.parseJSON(res);
                $('.posts').html(o.posts);
                $('.wall_footer_pag').html(o.pagination);
                
                
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


function sslider() {
    
    
    
}


function kslicks(ele, params) {
    
    
    var se = ele+' .slider';
    
    $(se).on('init', function() {$(ele+' .preloader').hide();});
    $(se).slick(params);
}

function resstu() {
        
    if($('.ksm_profile_user_sidebar').children().last().prop('tagName') == 'HR') {
        $('.ksm_profile_user_sidebar').children().last().remove()
    }
    
    
    if($('.ksm_profile_user_wall .posts').children().last().prop('tagName') == 'HR') {
        
        if($('.ksm_profile_user_wall .posts').children().last().hasClass('after_post')) {
            $('.ksm_profile_user_wall .posts').children().last().remove();
        }
    }
    
    
    
    
    /*
    $('hr.after_post')
    $('.ksm_profile_user_wall').css({height : 'auto'});
    var sh = $('.ksm_profile_user_sidebar').outerHeight();
    var wh = parseInt($('.ksm_profile_user_wall .content.main_content').height()) + 32;
    if(wh < sh) {
        var h = sh-25;
        $('.ksm_profile_user_wall').css({height : h+'px'});
    } else {
        $('.ksm_profile_user_wall').css({height : 'auto'});
    }
    */
}





var fav_slider;



        
        


$(function() {
    
    if($('.ksm_profile_user_sidebar').length) {
        
        resstu();
        
        kslicks('.follows_slider', {
            infinite: false,
            speed: 500,
            slidesToShow: 5,
            slidesToScroll: 5,
            centerPadding : '2px',
            prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="previous"></button>',
            nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="next"></button>'
        });
        
        kslicks('.top_selling_slider', {
            infinite: false,
            speed: 500,
            slidesToShow: 4,
            slidesToScroll: 4,
            centerPadding : '14px',
            prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="previous"></button>',
            nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="next"></button>'
        });
        
        kmv = new _kmvg('.multi_view_galleries', {
            action : 'Studio_kmvg',
            kmvg_args : {
                    container : '.multi_view_galleries',
                    switch_nav : '.gallery_tabs',
                    gallery_options : '.gallery_options',
                    grid_ec : '.grid_ec'
                }
        });
        
        
        fav_slider = new sslider_al_container('.sidebar_box.favorites', {
            action:'Studio_favorites_slider', 
            slider : {
                infinite: true,
                speed: 500,
                slidesToShow: 1,
                slidesToScroll: 1,
                prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="previous"></button>',
                nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="next"></button>'
            }});


        $(fav_slider).on('update', function(e, found) {
            if(!found) {
                if($('.sidebar_box.favorites .enc_message').length > 0) {
                    $('.sidebar_box.favorites .enc_message').show();
                } else {
                    $('.sidebar_box.favorites').hide();
                }
                $('.sidebar_box.favorites .header .count').hide();
            } else {
                $('.sidebar_box.favorites .header .count').show();
                $('.sidebar_box.favorites .enc_message').hide();
                $('.sidebar_box.favorites').show();
                $(window).trigger('resize');
            }
        });
    }
    
    
    
    
    
    
    
    
    /*
    if($('.ksm_profile_user_wall').length > 0)  {
        studio_facet = new kfacet({
            element : '.ff_opts',
            action : 'Studio_filter_posts',
            overlay : '.main_overlay'
        });

        $('body').delegate('.ksm_pagination a', 'click', function(e) {
            e.preventDefault();
            $('#ff_page').val($(this).attr('rel'));
            studio_facet.load(true);
        });
    }
    
    
    
    
    $('.posts').on("onPaginateLoaded", function() {
        $('html, body').animate({
            scrollTop: $(".posts").offset().top - 40
        }, 450);
    });
    */
    
    
    $('body').delegate('.sidebar_box.favorites .favorites_slider .slick-slide', 'click', function() {
        var fpu = $('.sidebar_box.favorites .header .count').attr('href');
        if(fpu) {
            opencb(fpu);
        }
    })
    
    
    
    
    autosize($('textarea'));
    
    
    
    /*
    $('body').delegate('.post .post_comments .comments_header .comments_toggle', 'click', function() {
        if($(this).closest('.post').find('.post_comments .comments .comment').length > 0) {
            $(this).closest('.post').find('.post_comments .comments').slideToggle();
            if($(this).attr('rel') == 'hide') {
                $(this).html('HIDE COMMENTS');
                
                $(this).removeClass('hide').addClass('show').attr('rel', 'show');
                
            } else if($(this).attr('rel') == 'show') {
                $(this).html('SHOW COMMENTS');
                
                $(this).removeClass('show').addClass('hide').attr('rel', 'hide');
                
                //$(this).attr('rel', 'hide');
            }
        }
    });
    */
})