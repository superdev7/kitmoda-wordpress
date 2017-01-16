


var kfacet = Base.extend({
    
    
    constructor : function(params) {
        this.element = params.element;
        this.action = params.action;
        this.overlay = params.overlay;
        this.wp_id = '';
        
        var _this = this;
        
        
        
        
        $('body').delegate(_this.element+ ' .roch' , 'change', function() {
            if($(this).attr('id') == 'ff_artwork_rating' || $(this).attr('id') == 'ff_communication_rating') {
                
            } else {
                _this.reload();
            }
        });
        
        
        $('.rateit').bind('rated', function() {
            //$(this).rateit('value');
            _this.reload();
        });
        
        
        $('.rateit').bind('reset', function() {
            
            var inp = $(this).attr('data-rateit-backingfld');
            $(inp).val('');
            _this.reload();
        });

        
        
        $('body').delegate(_this.element+ ' .rocl' , 'click', function(e) {
            e.preventDefault();
            _this.reload();
        });
        
        
        $('body').delegate(_this.element+ ' .roen' , 'keypress', function(e) {
            if((e.keyCode ? e.keyCode : e.which) == 13) {
                _this.reload();
            }
        });
        
        
        
        
        $(this.overlay).show();
        
        
        
        
        
        _this.setParams(_this.getURLParams());
        
        _this.load();

        
    },
    
    reset_page : function() {
        $('#ff_page').val('');
    },
    
    
    reload : function() {
        this.reset_page();
        this.load();
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
            } else if(v.name == 'type') {
                $('.collaboration_types li').removeClass('active');
                $('.collaboration_types li a[rel='+v.value+']').closest('li').addClass('active');
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
        //var _this = this;
        //$(this.overlay).show();
        //window.location.hash = this.getParams();
        //$('.posts').html('');
        
        
        
        var _this = this;
        $(this.overlay).show();
        
        
        
        var _new_h = this.getParams();
        
        
        
        if(_new_h == '') {
            history.pushState("", document.title, window.location.pathname + window.location.search);
        } else {
            window.location.hash = _new_h;
        }
        
        
        //$('.posts').justifiedGallery('destroy');
        
        //$('#commandtest').justifiedGallery('norewind')
        
        
        
        
        
        
        
        
        $.ajax({
            type: "POST",
            url: ksm_settings.ajax_url,
            data:this.getParams('array'),
            success: function(res) {
                $(_this.overlay).hide()
                var o = $.parseJSON(res);
                $('.posts').html(o.posts);
                
                if(o.found) {
                    $('.posts').justifiedGallery({
                        //lastRow : 'nojustify',
                        //justifyThreshold : 0.75,
                        rowHeight: 196, 
                        //maxRowHeight : '120%',
                        margins:12, 
                        captions: false, 
                        imagesAnimationDuration : 1000
                    }).on('jg.complete', function (e) {
                        
                        /*
                        if($('.collab_page.join').length > 0) {
                            var gh = $('.grid_view_container').height();
                            $('.coll_page_right').css({height : gh+'px'});
                        }
                        */
                        $('.posts .item.jg-entry').each(function() {
                            
                            if($(this).height() < 160) {
                                $(this).addClass('byside');
                            } else {
                                $(this).removeClass('byside');
                            }
                            
                            
                            var _item = this;
                            
                            $(this).find('.ic').each(function() {
                                console.log(this);
                                if($(this).hasClass('left')) {
                                    $(this).removeClass('left').addClass('right');
                                }
                                else if($(this).hasClass('right')) {
                                    $(this).removeClass('right').addClass('left');
                                }
                            })
                            
                            
                            $(this).find('[ds]').each(function() {
                                var _r = $(this).attr('ds').split(',') ;
                                var _ele = this;
                                $(_r).each(function() {
                                    var _kv = this.split(':');
                                    var new_val = (_kv[1] * $(_item).height() ) / 196;
                                    $(_ele).css(_kv[0], new_val+'px');
                                });
                            })
                        });
                        
                        
                        
                        $('.posts .item.jg-entry').each(function() {
                            var _item = this;
                            $(this).find('[dsc]').each(function() {
                                var _r = $(this).attr('dsc').split('|') ;
                                var _ele = this;
                                $(_r).each(function() {
                                    
                                    var _rp = this.split(/,/)
                                    
                                    var _c = _rp[0].split('=')[1];
                                    var _a = _rp[1].split('=')[1];
                                    
                                    
                                    var _cp =  _c.split(':')[0];
                                    var _cv = _c.split(':')[1]
                                    
                                    if(_cp == 'minHeight' && $(_item).height() < _cv) {
                                        var _ap =  _a.split(':')[0];
                                        var _av = _a.split(':')[1];
                                        $(_ele).css(_ap, _av);
                                    }
                                });
                            })
                        });
                        
                        
                    });
                    
                    
                    
                    
                    
                } else {
                    $('.posts').removeClass('justified-gallery').css('height', 'auto');
                    
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





























var collab_facet;

$(function() {
    
    
    $(".sbHolder").click(function() {
        $(this).toggleClass("sbh"); 
    });
    
    

    
    if($('.collab_page.join').length > 0) {
        
        $("#ff_sort").selectbox();
    
        collab_facet = new kfacet({
            element : '.coll_sidebar',
            action : 'Collaboration_filter',
            overlay : '.main_overlay',
            reload : {
                change : Array('#ff_sort', '#ff_communication_rating', '#ff_artwork_rating'),
                click :  Array('.button', '.btn'),
                enter :  Array('#ff_min_share', '#ff_max_share', '#ff_likes', '#ff_q')
            }
        });
        
        
        $('body').delegate('.collab_page.join .grid .item .bg, .collab_page.join .grid .item .full_view_btn', 'click', function(e) {
            e.preventDefault();
            if($(e.target).prop("tagName").toLowerCase() == 'a') {
                
            } else {
                var el = $(this).closest('.item').find('.full_view_btn a');
                opencb(el.attr('href'));
            }
            
        });
        


        $('body').delegate('.collaboration_types a', 'click', function(e) {
            e.preventDefault();
            $(this).closest('.collaboration_types').find('li').removeClass('active');
            $(this).closest('li').addClass('active');
            $('#ff_type').val($(this).attr('rel'));
            $('#ff_type').trigger( "change" );
        })


        $('body').delegate('.ksm_pagination a', 'click', function(e) {
            e.preventDefault();
            $('#ff_page').val($(this).attr('rel'));
            collab_facet.load();
        });
    
    } else if($('.collab_page.launch').length > 0 && $('#ifa').val()) {
        collabl_facet = new kfacet({
            element : '.coll_sidebar',
            action : $('#ifa').val(),
            overlay : '.main_overlay',
        });
        $('body').delegate('.ksm_pagination a', 'click', function(e) {
            e.preventDefault();
            $('#ff_page').val($(this).attr('rel'));
            collabl_facet.load();
        });
    }
    
    
    
})


var kcollab = function(params) {
    //'use strict';
    
    var _this = this;
    
    var defaults = {
	
        ele : '.ksm_main_gallery',
        container : '',
        loaded_galleries : Array(),
        current_gallery : '',
        current_view : '',
        views : Array('mini_grid', 'grid', 'full'),
        gridSizes : {
            minimized : 0,
            expanded : 0
        },
        gridViewType : 'minimized',
        page : 1
    }
    
    
        
        
        
    params = params || {};
    for (var prop in defaults) {
        if (prop in params && typeof params[prop] === 'object') {
            for (var subProp in defaults[prop]) {
                if (! (subProp in params[prop])) {
                    params[prop][subProp] = defaults[prop][subProp];
                }
            }
        }
        else if (! (prop in params)) {
            params[prop] = defaults[prop];
        }
    }
    
    _this.params = params;
    
    
    _this.onNavItemClick = function(e) {
        e.preventDefault();
        var u = $(this).attr('href');
        u = kajl.prototype.pu(u);
        
        $.ajax({
            type: "POST",
            url: ksm_settings.ajax_url,
            data: {u:u, action:'kajl'},
            success: function(r) {
                console.log(r);
            }
        })
    }
    
    
    _this.initAddConcept = function(e) {
        e.preventDefault();
        
        $.colorbox({
            iframe : true, 
            innerWidth : '726', 
            innerHeight : '500',
            href : $(this).attr('href'),
            opacity : 0.66,
            title : $(this).attr('title'),
            fastIframe : false
        });
    
        
    }
    
    _this.init = function() {
        
        
        
        
                
        
        $('body').delegate('.coll_sidebar .nav li a', 'click', _this.onNavItemClick);
        $('body').delegate('.coll_sidebar .filter_nav li a', 'click', _this.initAddConcept);
        
        
        
        
    }
    
    
    
    
    _this.init();
    
    
}