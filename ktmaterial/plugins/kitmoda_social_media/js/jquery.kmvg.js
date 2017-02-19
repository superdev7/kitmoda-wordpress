



var kmvg_gallery = Base.extend({


    constructor : function(ele, options) {

        var defaults = {
            ele : '',

            full : {
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
            },

            slide : 0,

            navigation : {
                slidesToShow : 8,
                slidesToScroll : 1,
                centerPadding : '8px',
            }
        }




        //this.gallery_ele =

    },
    ///////////////////////////////////////////////////


    onGridItemClick : function() {
        this.switchView('full', $(this).closest('.item').attr('indx'));
    },





    miniGridCountSize : function() {

        var t = 0;
        var r = 0;
        var size = 0;

        $(this.mini_grid_ele + ' .item').each(function() {
            var tt = parseInt($(this).css('top'));
            var th = parseInt($(this).css('height'));
            if(tt > t) {
                r++;
                if(r == 1) {
                    size = tt+th;
                }
                if(r == 2) {
                    size = tt+th;
                }
            }
            t = tt;
        });

        return size+11;
    },



    showTab : function(k) {
        $(_this.params.switch_nav+' select option[value='+k+']').show();
    },

    hideTab : function(k) {
        $(_this.params.switch_nav+'  select option[value='+k+']').hide();
    },


    clearGallery : function(k) {
        //var g_container = this.container + ' .'+k+'_gallery';

        //this.gallery_ele


        //this.mini_grid_ele+ ' .grid'


        var gme = $(this.mini_grid_ele+ ' .grid');
        var ge = $(this.mini_grid_ele+ ' .grid');
        var sfe = $(this.full_ele+ ' .slider');
        var sne = $(this.full_nav_ele+ ' .slider');


        var gmeh = $(gme).height();

        if($(gme).hasClass('justified-gallery'))$(gme).justifiedGallery('destroy');
        $(ge).find('.grid_page').each(function() {
            if($(this).hasClass('justified-gallery')) $(this).justifiedGallery('destroy');
        });



        if($(sfe).hasClass('slick-initialized')) $(sfe).slick('unslick');
        if($(sne).hasClass('slick-initialized')) $(sne).slick('unslick');


        $(gme).html('').css({height: gmeh+'px'});
        $(ge).html('');
        $(sfe).html('');
        $(sne).html('');
    },

    initMiniGrid : function() {

        //var imagesAnimationDuration = _this.params.animate ? 1000 : 0;
        var imagesAnimationDuration = 1000;



        $(this.mini_grid_ele).justifiedGallery({
            rowHeight: 196, margins:12, captions: false, imagesAnimationDuration : imagesAnimationDuration
        }).on('jg.complete', function (e) {

            var height = this.miniGridCountSize();
            if(this.animate) {
                $(this.mini_grid_ele).closest('.mini_grid_view_container').animate({ height: height+'px'});
            } else {
                $(this.mini_grid_ele).closest('.mini_grid_view_container').css({ height: height+'px'});
                this.animate = true;
            }

        })
    },

    initGrid : function(name) {

        var gallery_page = name+'_grid_page_1';
        if($(this.grid_ele+" #"+gallery_page).length > 0) {
            $(this.grid_ele+" #"+gallery_page).justifiedGallery({
                rowHeight: 196, margins:12, captions: false, imagesAnimationDuration : 1000
            });
        }
    },


    switchView : function(v, i) {
        this.current_view = v;

        if(v == 'full') {
            this.expandFull(i);
        }

        if(v == 'grid') {
            this.expandGrid();
        }

        if(v == '') {
            this.hideGrid();
            this.hideFull();
        }
    },


    expandFull : function(index) {
        this.hideGrid();
        $(this.full_view_ele).slideDown();
        this.full_slider.setPosition();
        this.full_slider_nav.setPosition();
        this.setSlide(index);
    },

    hideFull : function() {
        $(this.gallery_ele+' .full_view_container').slideUp();
    },


    expandGrid : function() {
        $(this.grid_ele).closest('.grid_view_container').slideDown()
        $(this.full_view_ele).hide();
        $(this.grid_ec).removeClass('expand').addClass('hide');
    },

    hideGrid : function() {
        $(this.grid_ele).closest('.grid_view_container').slideUp()
        $(this.grid_ec).removeClass('hide').addClass('expand');
    },


    onBackButtonClick : function(e) {
        e.preventDefault();
        this.switchView('');
    },

    onGridBackButtonClick : function(e) {
        e.preventDefault();
        this.switchView("");
    },


    setFullNavSlide : function(index) {
        this.full_slider_nav.slickGoTo(index);
        $(this.full_view_nav_slider_ele+' .slick-slide').removeClass('current')
        $(this.full_view_nav_slider_ele+' .slick-slide[data-slick-index='+index+']').addClass('current')

    },




    setSlide : function(index) {
        this.full_slider.slickGoTo(index);
        this.setFullNavSlide(index);
    },


    initFullSlider : function() {

        if($(_this.params.full_view_slider_ele).hasClass('slick-initialized')) {
            return
        }

        _this.params.full_slider = $(_this.params.full_view_slider_ele).slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: false,
            //asNavFor: _this.params.full_view_nav_slider_ele,
            adaptiveHeight : true,
            appendArrows: _this.params.gallery_ele+' .full_view_container .full_view_controls',
            prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="previous"></button>',
            nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="next"></button>'
        }).slick('getSlick');
    },


    initFullSliderNav : function() {

        if($(_this.params.full_view_nav_slider_ele).hasClass('slick-initialized')) {
            return
        }

        _this.params.full_slider_nav = $(_this.params.full_view_nav_slider_ele).slick({
            slidesToShow: 10,
            slidesToScroll: 5,
            //asNavFor: _this.params.full_view_slider_ele,
            centerMode: false,
            focusOnSelect: false,
            infinite: false,
            centerPadding : '8px',
            arrows: true,
            prevArrow: $(_this.params.gallery_ele+' .nav_container .nav .nav_controls .slick-prev'),
            nextArrow: $(_this.params.gallery_ele+' .nav_container .nav .nav_controls .slick-next')
        }).slick('getSlick');
    },

    afterFullChange : function(e, s, index) {


        if(_this.params.last_nav_item == index && $(_this.params.gallery_ele+' .info_container .info_box').html() != '') {
            return;
        }
        _this.setFullNavSlide(index);
        var item = $(_this.params.full_view_slider_ele+' .slick-active').attr('data-item');


        $.ajax({
            type: "POST",
            url: ksm_settings.ajax_url,
            data: {id:item, action:'fvii', g:_this.params.current_gallery},
            success: function(r) {
                $(_this.params.gallery_ele+' .info_container .info_box').append(r).hide().slideDown();
            }
        });

    },

    beforeFullChange : function(e, s, c, n) {
        _this.params.last_nav_item = c;
        if(c != n) {
            $(_this.params.gallery_ele+' .info_container .info_box').children().each(function() {
                $(this).slideUp("slow", function() { $(this).remove();});
            })
        }
    },


    afterFullNavChange : function() {
        //console.log(this);
    },

    setArrowsPosition : function (e) {
        var t = e.offsetY-65;
        t = t < 0 ? 0 : t;
        t = t > $(_this.params.full_view_slider_ele).height()-130 ? $(_this.params.full_view_slider_ele).height() - 130 : t;
        $(_this.params.gallery_ele+' .full_view_container .full_view_controls .slick-prev, '+_this.params.gallery_ele+' .full_view_container .full_view_controls .slick-next').css('top', t+'px');
    },





    onPageLoaded : function(o) {
        var gallery_page = o.name+'_grid_page_'+o.page;
        _this.params.grid_page_ele = _this.params.grid_ele+" #"+gallery_page;
        $(_this.params.grid_ele+' .grid_page').hide();

        $(_this.params.grid_ele).append('<div class="grid_page" id="'+gallery_page+'"></div>');

        $(o.grid).each(function() {
            $(_this.params.grid_ele+" #"+gallery_page).append(this);
        });

        $(o.full).each(function(k, v) {
            _this.params.full_slider.slickAdd(v);
        });

        $(o.full_nav).each(function(k, v) {
            _this.params.full_slider_nav.slickAdd(v);
        });

        $(_this.params.grid_page_ele).justifiedGallery({
            rowHeight: 196, margins:12, captions: false, imagesAnimationDuration : 1000
        });
        _this.setPagination(o.page)
        $(_this.params.container).trigger( "onAfterPageLoaded" );
    },

    setPagination : function(p) {


        var pages = $(_this.params.gallery_ele).attr('data-pages');
  var current = p;

        var end_size = 1;
        var mid_size = 2;

  var r = "";

        var page_links = Array();
            var dots = false;

  if ( pages > 1 ) {


            if ( current && 1 < current ) {

                page_links.push('<a class="prev page-numbers" href="#" rel="'+(current - 1)+'"></a>');
            }
            for ( var n = 1; n <= pages; n++ ) {
                if ( n == current ) {
                    page_links.push("<span class='page-numbers current'>"+n+"</span>");
                    dots = true;
                } else {
                    if (( n <= end_size || ( current && n >= current - mid_size && n <= current + mid_size ) || n > pages - end_size ) ) {
                        page_links.push('<a class="page-numbers" href="#" rel="'+n+'">'+n+'</a>');
                        dots = true;
                    } else if( dots) {
                        page_links.push('<span class="page-numbers dots">&hellip;</span>');
                        dots = false;
                    }
                }
            }
            if ( current && ( current < pages || -1 == pages ) ) {
                var _nl = parseInt(current) + 1;
                page_links.push('<a class="next page-numbers" href="#" rel="'+_nl+'"></a>');
            }

            r = page_links.join('\n');
        }

        $(_this.params.gallery_ele+  ' .grid_view_container .ksm_pagination').html(r);


  //console.log(r);



    },

    show_loading : function() {
        var h = '100%';
        if(_this.params.current_view == "grid") {
            h = $(this.params.gallery_ele+' .grid_view_container').height();
        }

        $(_this.params.container+' .loading').css('height', h).show();
    },

    hide_loading : function() {
        $(_this.params.container+' .loading').hide();
    },


    reset : function(gs) {



    },


    load_page : function(name, p) {

        _this.show_loading();

        var gallery_page = name+'_grid_page_'+p;
        if($(_this.params.grid_ele+" #"+gallery_page).length > 0) {

            $(_this.params.grid_ele+' .grid_page').hide();

            $(_this.params.grid_ele+' .grid_page#'+gallery_page).show();
            _this.setPagination(p);
            _this.hide_loading()
            return;
        }



        var u = $(_this.params.gallery_ele).attr('data-item');
        $.ajax({
                type: "POST",
                url: ksm_settings.ajax_url,
                data: {action:'kmvg_'+name,p:p,u:u},
                success: function(r) {

                    o = $.parseJSON(r);
                    _this.onPageLoaded(o);

                }
            });

    },




    init_gallery : function(name) {
        _this.initMiniGrid();
        _this.initGrid(name);

        _this.initFullSlider();
        _this.initFullSliderNav();
        _this.params.loaded_galleries.push(name);
    },

    switchGallery : function(name) {


        if(_this.params.gallery_ele) {
            _this.hideGrid();
            $(_this.params.gallery_ele+' .full_view_container').hide();
            $(_this.params.gallery_ele+' .grid_view_container').hide();
            $(_this.params.gallery_ele+' .mini_grid_view_container').css('height', '0px');
            $(_this.params.gallery_ele+' .gallery').hide();
        }

        _this.params.gallery_ele = _this.params.container+' .gallery.'+name+'_gallery';
        _this.params.grid_ele = _this.params.gallery_ele+" .grid_view_container .grid_view .grid"
        _this.params.mini_grid_ele = _this.params.gallery_ele+" .mini_grid_view_container .grid_view .grid"
        _this.params.full_view_ele = _this.params.gallery_ele+' .full_view_container';
        _this.params.full_view_slider_ele = _this.params.full_view_ele+' .full_view .slider';

        _this.params.full_view_nav_slider_ele = _this.params.gallery_ele+' .full_view_container .nav_container .slider';



        $(_this.params.gallery_ele).show();
        _this.init_gallery(name);
        _this.params.full_slider = $(_this.params.full_view_slider_ele).slick('getSlick');
        _this.params.full_slider_nav = $(_this.params.full_view_nav_slider_ele).slick('getSlick');

        //$(_this.params.switch_nav+' li').removeClass('active');
        //$(_this.params.switch_nav+' li[data-name='+name+']').addClass('active');

        _this.params.current_gallery = name;

        if(_this.params.gallery_options) {
            $(_this.params.gallery_options).find('.new').hide();
            $(_this.params.gallery_options).find('.new.'+name).show();
        }
    },




    initSetGalleryFull : function() {
        if(_this.params.initParams) {
            if(_this.params.initParams.view == 'full' && _this.params.initParams.slide) {
                if($(_this.params.initParams.slide).length > 0) {
                    var slide_index = $(_this.params.initParams.slide).attr('data-slick-index');
                    setTimeout(function() {_this.expandFull(slide_index)}, 500);
                }
            }
        }
        _this.params.initParams = null;
    },

    initGalleryParams : function() {

        _this.params.initParams = {};

        $.each(_this.params.galleries , function(k, v) {
            if($(_this.params.container+' .'+v+'_gallery .mini_grid_view_container .grid .item').length > 0) {
                _this.params.initParams.gallery = v;
                _this.params.initParams.view = 'mini_grid';
                return false;
            }
        })


        //if(_this.params.galleries[0]) {
        //    _this.params.initParams.gallery = _this.params.galleries[0];
        //    _this.params.initParams.view = 'mini_grid';
        //}

        if(window.location.hash) {
            var h = window.location.hash;
            var h_parts = h.split('_');

            if(h_parts[0] == '#dl') {
                _this.params.initParams.gallery = 'products';
            }
            if(h_parts[0] == '#wip') {
                _this.params.initParams.gallery = 'wips';
            }
            if(h_parts[0] == '#dl' || h_parts[0] == '#wip') {

                _this.params.initParams.view = 'full'
                _this.params.initParams.slide = h;
                if(h_parts[1]) {
                    _this.params.initParams.page = $.isNumeric(h_parts[1]) ? h_parts[1] : 1;
                }
            }
        }
    },






    ftdl_init : function() {

        _this.initGalleryParams();

        if(_this.params.initParams.gallery) {
            _this.switchGallery(_this.params.initParams.gallery);

            if(_this.params.initParams.slide && _this.params.initParams.view == 'full') {
                if(_this.params.initParams.page > 1) {
                    this.load_page(_this.params.initParams.gallery, _this.params.initParams.page);
                } else {
                    _this.initSetGalleryFull();
                }
            }
        }

    },

    init : function() {


        _this.params.galleries = Array();

        $(_this.params.container+' .gallery').each(function() {
            _this.params.galleries.push($(this).attr('data-name'));
        });





        $(_this.params.container).delegate('.gallery .grid_view .item .bg, '+_this.params.container+' .gallery .grid_view .item img', 'click', _this.onGridItemClick);
        $(_this.params.container).delegate('.gallery .gallery_back_btn', 'click', _this.onBackButtonClick);
        $(_this.params.container).delegate('.gallery .grid_back_btn', 'click', _this.onGridBackButtonClick);
        $(_this.params.container).delegate('.full_view_container .full_view .slider', 'mousemove', _this.setArrowsPosition);
        $(_this.params.container).delegate('.full_view_container .full_view .slider', 'afterChange', _this.afterFullChange);
        $(_this.params.container).delegate('.full_view_container .full_view .slider', 'beforeChange', _this.beforeFullChange);
        $(_this.params.container).delegate('.full_view_container .nav_container .slider', 'beforeChange', _this.afterFullNavChange);


        $(_this.params.container).on( "onAfterPageLoaded" , function() {
            _this.initSetGalleryFull();
            _this.hide_loading();
        });


        $('body').delegate(_this.params.switch_nav+' select', 'change', function(e) {
            //if(_this.params.current_gallery && _this.params.current_gallery != $(this).attr('data-name')) {
                _this.switchGallery($(this).val());
            //}
        });


        $(_this.params.container).delegate('.full_view_container .nav_container .slider .slick-slide', 'click', function() {
            if(!$(this).hasClass('current')) {
                _this.setSlide($(this).attr('data-slick-index'));
            }
        });

        $(_this.params.grid_ec).click(function() {
            if($(this).hasClass('expand')) {
                _this.switchView('grid');
                //_this.expandGrid();
            } else if($(this).hasClass('hide')) {
                _this.switchView('');
                //_this.hideGrid();
            }

        });


        $(_this.params.container).delegate('.grid_view_container .ksm_pagination a.page-numbers', 'click', function(e) {
            e.preventDefault();
            var p = $(this).attr('rel');
            _this.load_page(_this.params.current_gallery , p);

        });






    }




    ////////////////////////////////////////////////////
})



var _kmvg = al_container.extend({


    constructor : function(ele, options) {
        this.base(ele, options);

        this.kmvg = new kmvg(this.settings.kmvg_args)

    },



    reset : function(glrs) {
        var _ = this;
        var edta = new Array();

        _.is_reset = true;

        edta.push({name : 'galleries', value :glrs});
        edta.push({name : 'type' , value:'reset'});

        _.load(1, edta);
    },

    init_load : function(p, edta) {
        var _ = this;

        if(!edta) {
            var edta = new Array();
        }

        edta.push({name : 'type' , value:'ftl'});
        _.load(1, edta);

    },

    addSlide : function(s, gal) {
        console.log(s);
    },


    reset_resph : function(res) {

        var _ = this;

        /*
        var se = _.settings.ele+ ' .slider';

        var old_se = se+'.old';
        var new_se = se+'.new';
        $(se).addClass('old').removeClass('al_content').removeClass('new');
        $(se).parent().append('<div class="slider al_content new"></div>');
        $(old_se).each(function() {
            if($(this).hasClass('slick-initialized')) {
                $(this).slick('unslick_remove');
            }
            $(this).remove();
        });

        */






        var found = false;


        var o = $.parseJSON(res);

        $.each(o.galleries, function(k, gallery) {

            var g_container = _.settings.ele + ' .'+k+'_gallery';

            _.kmvg.clearGallery(k);

            if(gallery.found) {
                found = true;
                if($(g_container).length > 0) {
                    $.each(gallery.mini.slides, function(si, s) {
                        $(g_container+' .mini_grid_view_container .grid').append(s);
                    });




                    var pele_id = k+'_grid_page_1';
                    var pele = '<div class="grid_page" id="'+pele_id+'"></div>';
                    $(g_container+' .grid_view_container .grid').append(pele);
                    $.each(gallery.grid.slides, function(si, s) {
                        $(g_container+' .grid_view_container .grid #'+pele_id).append(s);
                    });


                    $.each(gallery.full.slides, function(si, s) {
                        $(g_container+' .full_view_container .full_view .slider').append(s);
                    });

                    $.each(gallery.full.nav, function(si, s) {
                        $(g_container+' .full_view_container .nav_container .nav .slider').append(s);
                    });
                }
                _.kmvg.showTab(k);
                if(_.kmvg.params.current_gallery == k) {
                    _.kmvg.params.animate = false;
                    _.kmvg.switchGallery(k);
                }
            } else {
                $(g_container).hide();
                //_.kmvg.hideTab(k);
            }



        });







        _.is_reset = false;


    },


    ftl_resph : function(res) {

        var _ = this;
        var found = false;


        var o = $.parseJSON(res);

        $.each(o.galleries, function(k, gallery) {

            var g_container = _.settings.ele + ' .'+k+'_gallery';

            if(gallery.found) {
                found = true;
                if($(g_container).length > 0) {
                    $.each(gallery.mini.slides, function(si, s) {
                        $(g_container+' .mini_grid_view_container .grid').append(s);
                    });


                    var pele_id = k+'_grid_page_1';
                    var pele = '<div class="grid_page" id="'+pele_id+'"></div>';
                    $(g_container+' .grid_view_container .grid').append(pele);
                    $.each(gallery.grid.slides, function(si, s) {
                        $(g_container+' .grid_view_container .grid #'+pele_id).append(s);
                    });


                    $.each(gallery.full.slides, function(si, s) {
                        $(g_container+' .full_view_container .full_view .slider').append(s);
                    });

                    $.each(gallery.full.nav, function(si, s) {
                        $(g_container+' .full_view_container .nav_container .nav .slider').append(s);
                    });
                }

                _.kmvg.showTab(k);
            } else {
                $(g_container).hide();
                //_.kmvg.hideTab(k);
            }
        });



        //if(!found) {
        //    console.log("multi_view_galleries_main");
        //    $('.multi_view_galleries_main').hide();
        //} else {
            _.kmvg.ftdl_init();

            $(_.kmvg.params.switch_nav+' select option[value='+_.kmvg.params.initParams.gallery+']').prop("selected", true);
            $('.multi_view_galleries_main').show();
        //}


    },

    resph : function(res) {

        var _ = this;




        if(_.is_reset) {
            _.reset_resph(res);
        } else if(_.ftl) {
            _.ftl_resph(res);
        }













        //$(_.settings.ele).find('.al_content').html(o.content);
        //$(_.settings.ele).find('.pagination').html(o.pagination);
        _.auto_update(o);


        /*
        if(o.found) {
            $(new_se).on('init', function() {
                $(new_se).show();
                $(_.settings.ele+' .preloader').hide();
            });
            $(new_se).slick(_.settings.slider);
        } else {
            $(_.settings.ele+' .preloader').hide();
        }

        */

        $(_).trigger( "update" , [o.found]);
        //_.hideOverlay();

    }


})




var kmvg = function (params) {


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
        page : 1,
        animate : true
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











    _this.onGridItemClick = function() {
        _this.switchView('full', $(this).closest('.item').attr('indx'));
        $('html, body').animate({
            scrollTop: $('.slick-slider').offset().top - 55
        }, 1000);
    }





    _this.miniGridCountSize = function() {

        var t = 0;
        var r = 0;
        var size = 0;

        $(_this.params.mini_grid_ele + ' .item').each(function() {
            var tt = parseInt($(this).css('top'));
            var th = parseInt($(this).css('height'));
            if(tt > t) {
                r++;
                if(r == 1) {
                    size = tt+th;
                }
                if(r == 2) {
                    size = tt+th;
                }
            }
            t = tt;
        });

        _this.params.mini_grid_size = size+11;
    }


    _this.showTab = function(k) {
        $(_this.params.switch_nav+' select option[value='+k+']').show();
    }

    _this.hideTab = function(k) {
        $(_this.params.switch_nav+'  select option[value='+k+']').hide();
    }


    _this.clearGallery = function(k) {
        var g_container = _this.params.container + ' .'+k+'_gallery';


        var gme = $(g_container+ ' .mini_grid_view_container .grid');
        var ge = $(g_container+ ' .grid_view_container .grid');
        var sfe = $(g_container+ ' .full_view_container .full_view .slider');
        var sne = $(g_container+ ' .full_view_container .nav_container .slider');


        var gmeh = $(gme).height();

        if($(gme).hasClass('justified-gallery'))$(gme).justifiedGallery('destroy');
        if($(ge).hasClass('justified-gallery')) $(ge).justifiedGallery('destroy');
        if($(sfe).hasClass('slick-initialized')) $(sfe).slick('unslick');
        if($(sne).hasClass('slick-initialized')) $(sne).slick('unslick');


        $(gme).html('').css({height: gmeh+'px'});
        $(ge).html('');
        $(sfe).html('');
        $(sne).html('');
    }

    _this.onGridComplete = function() {
        _this.miniGridCountSize();
            if(_this.params.animate) {
                $(_this.params.mini_grid_ele).closest('.mini_grid_view_container').animate({ height: _this.params.mini_grid_size+'px'});
            } else {
                $(_this.params.mini_grid_ele).closest('.mini_grid_view_container').css({ height: _this.params.mini_grid_size+'px'});
                _this.params.animate = true;
            }
    }

    _this.onGridResize = function() {
        _this.miniGridCountSize();
            if(_this.params.animate) {
                $(_this.params.mini_grid_ele).closest('.mini_grid_view_container').animate({ height: _this.params.mini_grid_size+'px'});
            } else {
                $(_this.params.mini_grid_ele).closest('.mini_grid_view_container').css({ height: _this.params.mini_grid_size+'px'});
                _this.params.animate = true;
            }
    }

    _this.initMiniGrid = function() {

        //var imagesAnimationDuration = _this.params.animate ? 1000 : 0;
        var imagesAnimationDuration = 1000;

        console.log('initMiniGrid')

        $(_this.params.mini_grid_ele).justifiedGallery({
            rowHeight: 196, margins:12, captions: false, imagesAnimationDuration : imagesAnimationDuration
        }).on('jg.complete', function (e) {
            console.log('jg.complete')
            _this.onGridComplete();
        }).on('jg.resize', function (e) {
            console.log('jg.resize')
            _this.onGridResize();
        })
    }

    _this.initGrid = function(name) {

        var gallery_page = name+'_grid_page_1';
        if($(_this.params.grid_ele+" #"+gallery_page).length > 0) {
            $(_this.params.grid_ele+" #"+gallery_page).justifiedGallery({
                rowHeight: 196, margins:12, captions: false, imagesAnimationDuration : 1000
            });
        }
    }


    _this.switchView = function(v, i) {
        _this.params.current_view = v;

        if(v == 'full') {
            _this.expandFull(i);
        }

        if(v == 'grid') {
            _this.expandGrid();
        }

        if(v == '') {
            _this.hideGrid();
            _this.hideFull();
        }
    }


    _this.expandFull = function(index) {
        _this.hideGrid();
        $(_this.params.full_view_ele).slideDown();
        _this.params.full_slider.setPosition();
        _this.params.full_slider_nav.setPosition();
        _this.setSlide(index);
    }

    _this.hideFull = function() {
        $(_this.params.gallery_ele+' .full_view_container').slideUp();
    }


    _this.expandGrid = function() {
        $(_this.params.grid_ele).closest('.grid_view_container').slideDown()
        $(_this.params.full_view_ele).hide();
        $(_this.params.grid_ec).removeClass('expand').addClass('hide');
    }

    _this.hideGrid = function() {
        $(_this.params.grid_ele).closest('.grid_view_container').slideUp()
        $(_this.params.grid_ec).removeClass('hide').addClass('expand');
    }


    _this.onBackButtonClick = function(e) {
        e.preventDefault();
        _this.switchView('');


    }

    _this.onGridBackButtonClick = function(e) {
        e.preventDefault();
        _this.switchView("");
    }


    _this.setFullNavSlide = function(index) {
        _this.params.full_slider_nav.slickGoTo(index);
        $(_this.params.full_view_nav_slider_ele+' .slick-slide').removeClass('current')
        $(_this.params.full_view_nav_slider_ele+' .slick-slide[data-slick-index='+index+']').addClass('current')

    }




    _this.setSlide = function(index) {
        _this.params.full_slider.slickGoTo(index);
        _this.setFullNavSlide(index);
    }




    _this.initFullSlider = function() {

        if($(_this.params.full_view_slider_ele).hasClass('slick-initialized')) {
            return
        }

        _this.params.full_slider = $(_this.params.full_view_slider_ele).slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: false,
            //asNavFor: _this.params.full_view_nav_slider_ele,
            adaptiveHeight : true,
            appendArrows: _this.params.gallery_ele+' .full_view_container .full_view_controls',
            prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="previous"></button>',
            nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="next"></button>'
        }).slick('getSlick');
    }

    _this.initFullSliderNav = function() {

        if($(_this.params.full_view_nav_slider_ele).hasClass('slick-initialized')) {
            return
        }

        _this.params.full_slider_nav = $(_this.params.full_view_nav_slider_ele).slick({
            slidesToShow: 10,
            slidesToScroll: 5,
            //asNavFor: _this.params.full_view_slider_ele,
            centerMode: false,
            focusOnSelect: false,
            infinite: false,
            centerPadding : '8px',
            arrows: true,
            prevArrow: $(_this.params.gallery_ele+' .nav_container .nav .nav_controls .slick-prev'),
            nextArrow: $(_this.params.gallery_ele+' .nav_container .nav .nav_controls .slick-next')
        }).slick('getSlick');
    }
    _this.afterFullChange = function(e, s, index) {


        if(_this.params.last_nav_item == index && $(_this.params.gallery_ele+' .info_container .info_box').html() != '') {
            return;
        }
        _this.setFullNavSlide(index);
        var item = $(_this.params.full_view_slider_ele+' .slick-active').attr('data-item');


        $.ajax({
            type: "POST",
            url: ksm_settings.ajax_url,
            data: {id:item, action:'fvii', g:_this.params.current_gallery},
            success: function(r) {
                $(_this.params.gallery_ele+' .info_container .info_box').append(r).hide().slideDown();
            }
        });

    }

    _this.beforeFullChange = function(e, s, c, n) {
        _this.params.last_nav_item = c;
        if(c != n) {
            $(_this.params.gallery_ele+' .info_container .info_box').children().each(function() {
                $(this).slideUp("slow", function() { $(this).remove();});
            })
        }
    }
    _this.afterFullNavChange = function() {
        //console.log(this);
    }

    _this.setArrowsPosition = function (e) {
      //  var t = e.offsetY-65;
      //  t = t < 0 ? 0 : t;
      //  t = t > $(_this.params.full_view_slider_ele).height()-130 ? $(_this.params.full_view_slider_ele).height() - 130 : t;
       // $(_this.params.gallery_ele+' .full_view_container .full_view_controls .slick-prev, '+_this.params.gallery_ele+' .full_view_container .full_view_controls .slick-next').css('top', t+'px');
    }





    _this.onPageLoaded = function(o) {
        var gallery_page = o.name+'_grid_page_'+o.page;
        _this.params.grid_page_ele = _this.params.grid_ele+" #"+gallery_page;
        $(_this.params.grid_ele+' .grid_page').hide();

        $(_this.params.grid_ele).append('<div class="grid_page" id="'+gallery_page+'"></div>');

        $(o.grid).each(function() {
            $(_this.params.grid_ele+" #"+gallery_page).append(this);
        });

        $(o.full).each(function(k, v) {
            _this.params.full_slider.slickAdd(v);
        });

        $(o.full_nav).each(function(k, v) {
            _this.params.full_slider_nav.slickAdd(v);
        });

        $(_this.params.grid_page_ele).justifiedGallery({
            rowHeight: 196, margins:12, captions: false, imagesAnimationDuration : 1000
        });
        _this.setPagination(o.page)
        $(_this.params.container).trigger( "onAfterPageLoaded" );
    }

    _this.setPagination = function(p) {


        var pages = $(_this.params.gallery_ele).attr('data-pages');
  var current = p;

        var end_size = 1;
        var mid_size = 2;

  var r = "";

        var page_links = Array();
            var dots = false;

  if ( pages > 1 ) {


            if ( current && 1 < current ) {

                page_links.push('<a class="prev page-numbers" href="#" rel="'+(current - 1)+'"></a>');
            }
            for ( var n = 1; n <= pages; n++ ) {
                if ( n == current ) {
                    page_links.push("<span class='page-numbers current'>"+n+"</span>");
                    dots = true;
                } else {
                    if (( n <= end_size || ( current && n >= current - mid_size && n <= current + mid_size ) || n > pages - end_size ) ) {
                        page_links.push('<a class="page-numbers" href="#" rel="'+n+'">'+n+'</a>');
                        dots = true;
                    } else if( dots) {
                        page_links.push('<span class="page-numbers dots">&hellip;</span>');
                        dots = false;
                    }
                }
            }
            if ( current && ( current < pages || -1 == pages ) ) {
                var _nl = parseInt(current) + 1;
                page_links.push('<a class="next page-numbers" href="#" rel="'+_nl+'"></a>');
            }

            r = page_links.join('\n');
        }

        $(_this.params.gallery_ele+  ' .grid_view_container .ksm_pagination').html(r);


  //console.log(r);



    }

    _this.show_loading = function() {
        var h = '100%';
        if(_this.params.current_view == "grid") {
            h = $(this.params.gallery_ele+' .grid_view_container').height();
        }

        $(_this.params.container+' .loading').css('height', h).show();
    }

    _this.hide_loading = function() {
        $(_this.params.container+' .loading').hide();
    }


    _this.reset = function(gs) {



    }


    _this.load_page = function(name, p) {

        _this.show_loading();

        var gallery_page = name+'_grid_page_'+p;
        if($(_this.params.grid_ele+" #"+gallery_page).length > 0) {

            $(_this.params.grid_ele+' .grid_page').hide();

            $(_this.params.grid_ele+' .grid_page#'+gallery_page).show();
            _this.setPagination(p);
            _this.hide_loading()
            return;
        }



        var u = $(_this.params.gallery_ele).attr('data-item');
        $.ajax({
                type: "POST",
                url: ksm_settings.ajax_url,
                data: {action:'kmvg_'+name,p:p,u:u},
                success: function(r) {

                    o = $.parseJSON(r);
                    _this.onPageLoaded(o);

                }
            });

    }




    _this.init_gallery = function(name) {
        _this.initMiniGrid();
        _this.initGrid(name);

        _this.initFullSlider();
        _this.initFullSliderNav();
        _this.params.loaded_galleries.push(name);
    }

    _this.switchGallery = function(name) {




        if(_this.params.gallery_ele) {
            _this.hideGrid();
            $(_this.params.gallery_ele+' .full_view_container').hide();
            $(_this.params.gallery_ele+' .grid_view_container').hide();
            $(_this.params.gallery_ele+' .mini_grid_view_container').css('height', '0px');
            $(_this.params.gallery_ele+' .gallery').hide();
            $(_this.params.gallery_ele + ' .mvg_empty_msg').hide();
        }

        _this.params.gallery_ele = _this.params.container+' .gallery.'+name+'_gallery';
        _this.params.grid_ele = _this.params.gallery_ele+" .grid_view_container .grid_view .grid"
        _this.params.mini_grid_ele = _this.params.gallery_ele+" .mini_grid_view_container .grid_view .grid"
        _this.params.full_view_ele = _this.params.gallery_ele+' .full_view_container';
        _this.params.full_view_slider_ele = _this.params.full_view_ele+' .full_view .slider';

        _this.params.full_view_nav_slider_ele = _this.params.gallery_ele+' .full_view_container .nav_container .slider';



        $(_this.params.gallery_ele).show();
        _this.init_gallery(name);
        _this.params.full_slider = $(_this.params.full_view_slider_ele).slick('getSlick');
        _this.params.full_slider_nav = $(_this.params.full_view_nav_slider_ele).slick('getSlick');

        //$(_this.params.switch_nav+' li').removeClass('active');
        //$(_this.params.switch_nav+' li[data-name='+name+']').addClass('active');

        _this.params.current_gallery = name;

        if(_this.params.gallery_options) {
            $(_this.params.gallery_options).find('.new').hide();
            $(_this.params.gallery_options).find('.new.'+name).show();
        }


        console.log($(_this.params.mini_grid_ele + ' .item').length);
        if($(_this.params.mini_grid_ele + ' .item').length == 0) {
            $(_this.params.gallery_ele + ' .mvg_empty_msg').show();
        } else {
            $(_this.params.gallery_ele + ' .mvg_empty_msg').hide();

        }
    }




    _this.initSetGalleryFull = function() {
        if(_this.params.initParams) {
            if(_this.params.initParams.view == 'full' && _this.params.initParams.slide) {
                if($(_this.params.initParams.slide).length > 0) {
                    var slide_index = $(_this.params.initParams.slide).attr('data-slick-index');
                    setTimeout(function() {_this.expandFull(slide_index)}, 500);
                }
            }
        }
        _this.params.initParams = null;
    }

    _this.initGalleryParams = function() {


        _this.params.initParams = {};

        $.each(_this.params.galleries , function(k, v) {
            if($(_this.params.container+' .'+v+'_gallery .mini_grid_view_container .grid .item').length > 0) {
                _this.params.initParams.gallery = v;
                _this.params.initParams.view = 'mini_grid';
                return false;
            }
        });

        if(!_this.params.initParams.gallery) {
            _this.switchGallery(_this.params.galleries[0]);
        }


        //console.log()


        //if(_this.params.galleries[0]) {
        //    _this.params.initParams.gallery = _this.params.galleries[0];
        //    _this.params.initParams.view = 'mini_grid';
        //}

        if(window.location.hash) {
            var h = window.location.hash;
            var h_parts = h.split('_');

            if(h_parts[0] == '#dl') {
                _this.params.initParams.gallery = 'products';
            }
            if(h_parts[0] == '#wip') {
                _this.params.initParams.gallery = 'wips';
            }
            if(h_parts[0] == '#dl' || h_parts[0] == '#wip') {

                _this.params.initParams.view = 'full'
                _this.params.initParams.slide = h;
                if(h_parts[1]) {
                    _this.params.initParams.page = $.isNumeric(h_parts[1]) ? h_parts[1] : 1;
                }
            }
        }
    }






    _this.ftdl_init = function() {

        _this.initGalleryParams();

        if(_this.params.initParams.gallery) {
            _this.switchGallery(_this.params.initParams.gallery);

            if(_this.params.initParams.slide && _this.params.initParams.view == 'full') {
                if(_this.params.initParams.page > 1) {
                    this.load_page(_this.params.initParams.gallery, _this.params.initParams.page);
                } else {
                    _this.initSetGalleryFull();
                }
            }
        }

    }

    _this.init = function() {


        _this.params.galleries = Array();

        $(_this.params.container+' .gallery').each(function() {
            _this.params.galleries.push($(this).attr('data-name'));
        });





        $(_this.params.container).delegate('.gallery .grid_view .item .bg, '+_this.params.container+' .gallery .grid_view .item img', 'click', _this.onGridItemClick);
        $(_this.params.container).delegate('.gallery .gallery_back_btn', 'click', _this.onBackButtonClick);
        $(_this.params.container).delegate('.gallery .grid_back_btn', 'click', _this.onGridBackButtonClick);
        $(_this.params.container).delegate('.full_view_container .full_view .slider', 'mousemove', _this.setArrowsPosition);
        $(_this.params.container).delegate('.full_view_container .full_view .slider', 'afterChange', _this.afterFullChange);
        $(_this.params.container).delegate('.full_view_container .full_view .slider', 'beforeChange', _this.beforeFullChange);
        $(_this.params.container).delegate('.full_view_container .nav_container .slider', 'beforeChange', _this.afterFullNavChange);


        $(_this.params.container).on( "onAfterPageLoaded" , function() {
            _this.initSetGalleryFull();
            _this.hide_loading();
        });


        $('body').delegate(_this.params.switch_nav+' select', 'change', function(e) {
            //if(_this.params.current_gallery && _this.params.current_gallery != $(this).attr('data-name')) {
                _this.switchGallery($(this).val());
            //}

        });


        $(_this.params.container).delegate('.full_view_container .nav_container .slider .slick-slide', 'click', function() {
            if(!$(this).hasClass('current')) {
                _this.setSlide($(this).attr('data-slick-index'));
            }
        });

        $(_this.params.grid_ec).click(function() {
            if($(this).hasClass('expand')) {
                _this.switchView('grid');
                //_this.expandGrid();
            } else if($(this).hasClass('hide')) {
                _this.switchView('');
                //_this.hideGrid();
            }

        });


        $(_this.params.container).delegate('.grid_view_container .ksm_pagination a.page-numbers', 'click', function(e) {
            e.preventDefault();
            var p = $(this).attr('rel');
            _this.load_page(_this.params.current_gallery , p);

        });






    }




    _this.init();


}





setTimeout(function(){

    var maxHeight = 0 ;
    var maxWidth = 0 ;
    var winHeight = $(window).height();
    var winWidth = $(window).width();
//    alert(winWidth);
    $(".slick-slide").each(function(index , element){

        var url = $(element).children('img').attr("src");
        if(typeof  url != 'undefined' && typeof  url != undefined)
        {
            var image = new Image();
            image.src = url ;

            if(index == 0 || maxHeight <  image.naturalHeight)
            {
                maxHeight =  image.naturalHeight ;
                maxWidth =  image.naturalWidth ;
            }
            else if(maxHeight >  image.naturalHeight)
            {
                maxHeight = maxHeight ;
                maxWidth = maxWidth;
            }

//            console.log(('width: ' + image.naturalWidth + ' and height: ' + image.naturalHeight+" and url : "+url+" and MAx Height "+maxHeight));

        }

    });


    if(winWidth > 1300 && winWidth <=1370){
        $(".slick-slide").css({"height":420,  "text-align":"center"});
        $(".slick-slide img").css({"max-height":400  });
        $(".slick-slide img").css({"width":500  });
    }else{
        $(".full_view .slick-slider .slick-list .slick-track .slick-slide").css({"height":winHeight - 250  , "width":winWidth / 2 ,  "text-align":"center"});
        $(".full_view .slick-slider .slick-list .slick-track .slick-slide img").css({"max-height":winHeight - 300  , "width":winWidth / 2 - 50 ,  "text-align":"center"});
//        $(".slick-slide").css({"height":winHeight - 250,  "text-align":"center"});
    }
    $(".slick-slide").each(function(index , element){

        var url = $(element).children('img').attr("src");
        if(typeof  url != 'undefined' && typeof  url != undefined)
        {
            var imageItself = $(element).children('img') ;
            var image = new Image();
            image.src = url ;

            marginTop =  (maxHeight * winHeight / maxWidth)-( image.naturalHeight * winHeight /image.naturalWidth);
//            marginTop =  (maxWidth * winHeight / maxHeight)-( image.naturalWidth * winHeight /image.naturalHeight);
            marginTop = marginTop / 2;
            if(winWidth > 1300 && winWidth <=1370){
//                alert('if');
                if(420 >  image.naturalHeight){
                    marginTop1=(420 - image.naturalHeight)/2;
                    imageItself.css("margin-top",marginTop);
                }
                console.log('natural height'+ image.naturalHeight+'  max height'+maxHeight+'  height'+imageItself.height())


            }else{
//                alert('else');
                if(marginTop >0){
                    imageItself.css("margin-top",marginTop);
                }

            }


        }

    });

    /* $(".slick-slide").each(function(index , element){

        var imageItself = $(element).children('img') ;
        var url = $(element).children('img').attr("src");
        if(typeof  url != 'undefined' && typeof  url != undefined)
        {

            var image = new Image();
            image.src = url ;




            marginTop =  maxHeight-image.naturalHeight;
            marginTop = marginTop / 2;
            console.log((' height: ' + image.naturalHeight +" and url : "+url+" and MAx Height "+maxHeight+" MarginTop "+marginTop));
            imageItself.css("margin-top",marginTop);

        }

    });
*/

},5000);


