

var kapp = angular.module('kapp', [
                            'ngResource',
                            'ngAnimate',
                            'ngMessages',
                            'ui.bootstrap',
                            //'k.components.confirm', 
                            'k.components.kui',
                            'infinite-scroll',
                            'k.components.comment',
                            'k.util',
                            'k.like',
                            'k.report',
                            'k.user',
                            'k.validation',
                            'k.components.join'
                            ])
                            
                            .config(['$httpProvider', function($httpProvider) {
    $httpProvider.defaults.headers.common['KSM-Access-ID'] = ksm_settings.rest.access_key;
    $httpProvider.defaults.headers.common['X-WP-NONCE'] = ksm_settings.rest.nonce;

}])
    
    
.run(function($rootScope, JoinUiService) {
        $rootScope.join = function() {
            JoinUiService.open();
        }
})
                            

var kfacet = Base.extend({
    
    
    constructor : function(params) {
        this.element = params.element;
        this.action = params.action;
        this.overlay = params.overlay;
        this.wp_id = '';
        
        var _this = this;
        
        var elements =  this.element+' input.opt_filter, '+this.element+' select'+', #ff_sort';
        
        $('body').delegate(elements , 'change', function() {
            _this.reset_page();
            _this.load();
        });
        
        
        
        
        
        $(this.overlay).show();
        
        
        
        
        _this.setParams(_this.getURLParams());
        
        _this.load();

        
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
        })
        
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
    
    
    load : function() {
        var _this = this;
        $(this.overlay).show();
        
        
        
        window.location.hash = this.getParams();
        $('.posts').html('');
        $.ajax({
            type: "POST",
            url: ksm_settings.ajax_url,
            data:this.getParams('array'),
            success: function(res) {
                $(_this.overlay).hide()
                var o = $.parseJSON(res);
                $('.posts').html(o.posts);
                $('.breadcrumb').html(o.breadcrumb);
                /*$(".breadcrumb select").selectBoxIt(
            {autoWidth : false, showEffect : 'none', showFirstOption : false, copyClasses : 'container'}
            );*/
    
			$(".breadcrumb select").selectbox();
			$(".breadcrumb .sbOptions").mCustomScrollbar();
    
    
    
            if(o.found) {
                $('.posts').justifiedGallery({
                    rowHeight: 196, margins:12, captions: false, imagesAnimationDuration : 1000
                });
            }
                
                $('.wall_footer').html(o.pagination);
                
                if(_this.wp_id && $('#wp_'+_this.wp_id).length > 0) {
                    var targetOffset = $('#wp_'+_this.wp_id).offset().top
                    $('html,body').animate({scrollTop: targetOffset}, 300);
                    _this.wp_id = '';
                }
            }
        });
    }
});








function search_form_sb() {
        var args = new Array();
        
        if($('.search_form .sb_category').val()) {
            args.push('cat='+$('.search_form .sb_category').val())
        }
        
        if($('.search_form .sb_style').val()) {
            args.push('style[]='+$('.search_form .sb_style').val())
        }
        
        if($('.search_form #ff_q').val()) {
            args.push('s='+$('.search_form #ff_q').val())
        }
        
        var _args = args.join('&');
        
        var lnk = ksm_settings.home_url+'/store/search';
        if(_args) {
            _args = '#'+_args;
        }
        
        window.location =  lnk+_args
        
    }




_this_page = '';

$(function() {
    
    /*
    kmv = new kmvg({
        container : '.multi_view_galleries',
        switch_nav : '.gallery_tabs',
        gallery_options : '.gallery_options',
        grid_ec : '.grid_ec'
    });
    
    */
    
    
    
    new slick_simple_gallery({ele : '#download_gallery'});
    
    if($('.ksm_store_search').length > 0) {
        _this_page = 'search';
    } else if($('.ksm_store_archive').length > 0) {
        _this_page = 'archive';
    }
    
    if(_this_page == 'search') {
        store_facet = new kfacet({
            element : '.sidebar',
            action : 'Store_filter_posts',
            overlay : '.main_overlay'
        });
        
        $('body').delegate('.select_boxes .sb_category, .breadcrumb .more_nav select', 'change', function() {
            $('.sidebar #ff_cat').val($(this).val());
            store_facet.reset_page();
            store_facet.load();
        });


        $('body').delegate('.sort_field select', 'change', function() {
            $('.sidebar #ff_sort').val($(this).val());
            store_facet.reset_page();
            store_facet.load();
        });


        $('body').delegate('.ksm_pagination a', 'click', function(e) {
            e.preventDefault();
            $('#ff_page').val($(this).attr('rel'));
            store_facet.load();
        });
        
        $('.search_box .field.button').click(function(e) {
            //$('.sidebar #ff_q').val($(this).val());
            store_facet.reset_page();
            store_facet.load();
        });
        
        $('.sidebar .search #ff_q').keypress(function(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if(keycode == 13) {
                store_facet.reset_page();
                store_facet.load();
            }
        });
        
        $('.sidebar').delegate('.field_group .more_options .less, .field_group .more_options .more', 'click', function(e) {
            $(this).closest('.more_options').find('.more_options_list').slideToggle();
            $(this).closest('.more_options').toggleClass('maximized');
        });
        
        
        $('body').delegate('.more_nav', 'click', function(e) {
            e.preventDefault();
            $(this).find('ul:first-child').slideToggle();
        });
        
    } else if(_this_page == 'archive') {
        
        
        new jg_al_container('.section.newest', {action:'Store_getNewest'});
        new jg_al_container('.section.trending', {action:'Store_getTrending'});
        new jg_al_container('.section.top_selling', {action:'Store_getTopSelling'});
        new jg_al_container('.section.top_rated', {action:'Store_getTopRated'});
        
        //$("select").selectbox();
        //$(".sbOptions").mCustomScrollbar();
        
    }
    
    
    
    
    
    
    
    $('.search_form .field.button').click(function(e) {
        search_form_sb();
    });
        
    $('.search_form #ff_q').keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if(keycode == 13) {
            search_form_sb();
        }
    });
    
    
    /*$(".search_box select").selectBoxIt({
        autoWidth : false, 
        showEffect : 'slideDown', 
        showFirstOption : false, 
        copyClasses : 'container'
    });
    
	
    $(".sort_field select").selectBoxIt({
        autoWidth : false, 
        showEffect : 'none', 
        copyClasses : 'container'
    });*/
    
    
    $('.rating_excoll').click(function(e) {
        $('.group_ratings').slideToggle();
        
        $(this).toggleClass('collapsed');
        $(this).toggleClass('expanded');
    });
    
});

