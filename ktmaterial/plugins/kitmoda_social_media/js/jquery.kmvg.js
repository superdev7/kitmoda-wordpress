
var kmvg = function(params) {
    //'use strict';
    
    var _this = this;
    
    var defaults = {
	
        ele : '.ksm_main_gallery',
        container : '',
        loaded_galleries : Array(),
        current_gallery : '',
        gridSizes : {
            minimized : 0,
            expanded : 0
        },
        gridViewType : 'minimized'
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
        _this.switchFull();
        _this.params.full_slider.setPosition();
        _this.params.full_slider_nav.setPosition();
        _this.setSlide($(this).closest('.item').attr('indx'));
        
        
        
        
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
    
    _this.switchFull = function() {
        $(_this.params.gallery_ele+' .full_view_container').slideToggle();
    }
    
    
    
    
    
    _this.initFullSlider = function() {
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
            data: {id:item, action:'fvii'},
            success: function(r) {
                $(_this.params.gallery_ele+' .info_container .info_box').append(r).hide().slideDown();
            }
        });
        
    }
    
    _this.beforeFullChange = function(e, s, c, n) {
        _this.params.last_nav_item = c;
        if(c != n) {
            $(_this.params.gallery_ele+' .info_container .info_box').children().each(function() {
                
                console.log(_this.params.gallery_ele+' .info_container .info_box');
                $(this).slideUp("slow", function() { $(this).remove();});
            })
        }
    }
    _this.afterFullNavChange = function() {
        console.log(this);
    }
    
    _this.setArrowsPosition = function (e) {
        var t = e.offsetY-65;
        t = t < 0 ? 0 : t;
        t = t > $(_this.params.full_view_slider_ele).height()-130 ? $(_this.params.full_view_slider_ele).height() - 130 : t;
        $(_this.params.gallery_ele+' .full_view_container .full_view_controls .slick-prev, '+_this.params.gallery_ele+' .full_view_container .full_view_controls .slick-next').css('top', t+'px');
    }
    
    _this.gridCountSizes = function() {
        
        _this.params.gridSizes.expanded = 0;
        _this.params.gridSizes.minimized = 0;
        
        var t = 0;
        var r = 0;
        
        $(_this.params.grid_ele + ' .item').each(function() {
            var tt = parseInt($(this).css('top'));
            var th = parseInt($(this).css('height'));
            if(tt > t) {
                r++;
                if(r == 1) {
                    _this.params.gridSizes.minimized = tt+th;
                }
                if(r == 2) {
                    _this.params.gridSizes.expanded = tt+th;
                }
            }
            t = tt;
        });
        
        
        
        if(_this.params.gridSizes.expanded == 0) {
            _this.params.gridSizes.expanded = _this.params.gridSizes.minimized;
        }
        
        _this.params.gridSizes.expanded = _this.params.gridSizes.expanded + 11;
        _this.params.gridSizes.minimized = _this.params.gridSizes.minimized + 11;
        
    }
    
    _this.initGrid = function(name) {
        
        $(_this.params.grid_ele).justifiedGallery({
            rowHeight: 196, margins:12, captions: false, imagesAnimationDuration : 1000
        }).on('jg.complete', function (e) {
            
            _this.gridCountSizes();
            if(_this.params.gridViewType == 'expanded') {
                _this.expandGrid();
            } else {
                _this.minimizeGrid();
            }
        })
    }
    
    _this.expandGrid = function() {
        $(_this.params.gallery_ele+' .grid_view_container').animate({ height: _this.params.gridSizes.expanded+'px'})
        $(_this.params.grid_ec).removeClass('expand').addClass('minimize');
        _this.params.gridViewType = 'expanded';
    }
    
    _this.minimizeGrid = function() {
        $(_this.params.gallery_ele+' .grid_view_container').animate({ height: _this.params.gridSizes.minimized+'px'});
        $(_this.params.grid_ec).removeClass('minimize').addClass('expand');
        _this.params.gridViewType = 'minimized';
    }
    
    
    _this.load_gallery = function(name, view) {
        _this.initGrid(name);
        _this.initFullSlider();
        _this.initFullSliderNav();
        _this.params.loaded_galleries.push(name);
    }
    
    _this.switchGallery = function(name, view) {
        
        
        if(_this.params.gallery_ele) {
            $(_this.params.gallery_ele+' .full_view_container').hide();
            $(_this.params.gallery_ele+' .grid_view_container').css('height', '0px');
            $(_this.params.gallery_ele+' .gallery').hide();
        }
        
        _this.params.gallery_ele = _this.params.container+' .gallery.'+name+'_gallery';
        _this.params.grid_ele = _this.params.gallery_ele+" .grid_view .grid"
        
        _this.params.full_view_slider_ele = _this.params.gallery_ele+' .full_view_container .full_view .slider';
        _this.params.full_view_nav_slider_ele = _this.params.gallery_ele+' .full_view_container .nav_container .slider';
        
        
        
        
        
        
        
        
        
        $(_this.params.gallery_ele).show();
        if($.inArray(name, _this.params.loaded_galleries) == -1) {
            _this.load_gallery(name, view);
        } else {
            _this.gridCountSizes();
            if(_this.params.gridViewType == 'expanded') {
                _this.expandGrid();
            } else {
                _this.minimizeGrid();
            }
        }
        
        
        
        _this.params.full_slider = $(_this.params.full_view_slider_ele).slick('getSlick');
        _this.params.full_slider_nav = $(_this.params.full_view_nav_slider_ele).slick('getSlick');
        
        _this.params.full_slider.setPosition();
        _this.params.full_slider_nav.setPosition();
        
        $(_this.params.switch_nav+' li').removeClass('active');
        $(_this.params.switch_nav+' li[data-name='+name+']').addClass('active');
        
        
        _this.params.current_gallery = name;
        
        if(_this.params.gallery_options) {
            $(_this.params.gallery_options).find('.new').hide();
            $(_this.params.gallery_options).find('.new.'+name).show();
        }
        
    }
    
    _this.init = function() {
        
        
        _this.params.galleries = Array();
        
        $(_this.params.container+' .gallery').each(function() {
            _this.params.galleries.push($(this).attr('data-name'));
        });
        
        
        
        if(_this.params.galleries[0]) {
            _this.switchGallery(_this.params.galleries[0], 'grid');
        }
        
        
        
        $('body').delegate(_this.params.container+' .gallery .grid_view .item .bg, '+_this.params.container+' .gallery .grid_view .item img', 'click', _this.onGridItemClick);
        
        $('body').delegate(_this.params.container+' .gallery .gallery_back_btn', 'click', _this.onBackButtonClick);
        
        
        $('body').delegate(_this.params.switch_nav+' li', 'click', function(e) {
            
            if(_this.params.current_gallery && _this.params.current_gallery != $(this).attr('data-name')) {
                _this.switchGallery($(this).attr('data-name'), 'grid');
            }
        })
        
        
        $(_this.params.container).delegate('.full_view_container .full_view .slider', 'mousemove', _this.setArrowsPosition);
        
        $(_this.params.container).delegate('.full_view_container .full_view .slider', 'afterChange', _this.afterFullChange);
        $(_this.params.container).delegate('.full_view_container .full_view .slider', 'beforeChange', _this.beforeFullChange);
        
        $(_this.params.container).delegate('.full_view_container .nav_container .slider', 'beforeChange', _this.afterFullNavChange);
        
        
        $(_this.params.container).delegate('.full_view_container .nav_container .slider .slick-slide', 'click', function() {
            if(!$(this).hasClass('current')) {
                _this.setSlide($(this).attr('data-slick-index'))
            }
        });
        
        $(_this.params.grid_ec).click(function() {
            if($(this).hasClass('expand')) {
                _this.expandGrid();
            } else if($(this).hasClass('minimize')) {
                _this.minimizeGrid();
            }
            
        });
        
        
        
        
        
        
        
    }
    
    
    
    
    _this.init();
    
    
}