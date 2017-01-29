var $ = jQuery;


////////////////////////



/*
	Base.js, version 1.1a
	Copyright 2006-2010, Dean Edwards
	License: http://www.opensource.org/licenses/mit-license.php
*/

var Base = function() {};

Base.extend = function(_instance, _static) { // subclass
	var extend = Base.prototype.extend;
	
	// build the prototype
	Base._prototyping = true;
	var proto = new this;
	extend.call(proto, _instance);
  proto.base = function() {
    // call this method from any other method to invoke that method's ancestor
  };
	delete Base._prototyping;
	
	// create the wrapper for the constructor function
	//var constructor = proto.constructor.valueOf(); //-dean
	var constructor = proto.constructor;
	var klass = proto.constructor = function() {
		if (!Base._prototyping) {
			if (this._constructing || this.constructor == klass) { // instantiation
				this._constructing = true;
				constructor.apply(this, arguments);
				delete this._constructing;
			} else if (arguments[0] != null) { // casting
				return (arguments[0].extend || extend).call(arguments[0], proto);
			}
		}
	};
	
	// build the class interface
	klass.ancestor = this;
	klass.extend = this.extend;
	klass.forEach = this.forEach;
	klass.implement = this.implement;
	klass.prototype = proto;
	klass.toString = this.toString;
	klass.valueOf = function(type) {
		//return (type == "object") ? klass : constructor; //-dean
		return (type == "object") ? klass : constructor.valueOf();
	};
	extend.call(klass, _static);
	// class initialisation
	if (typeof klass.init == "function") klass.init();
	return klass;
};

Base.prototype = {	
	extend: function(source, value) {
		if (arguments.length > 1) { // extending with a name/value pair
			var ancestor = this[source];
			if (ancestor && (typeof value == "function") && // overriding a method?
				// the valueOf() comparison is to avoid circular references
				(!ancestor.valueOf || ancestor.valueOf() != value.valueOf()) &&
				/\bbase\b/.test(value)) {
				// get the underlying method
				var method = value.valueOf();
				// override
				value = function() {
					var previous = this.base || Base.prototype.base;
					this.base = ancestor;
					var returnValue = method.apply(this, arguments);
					this.base = previous;
					return returnValue;
				};
				// point to the underlying method
				value.valueOf = function(type) {
					return (type == "object") ? value : method;
				};
				value.toString = Base.toString;
			}
			this[source] = value;
		} else if (source) { // extending with an object literal
			var extend = Base.prototype.extend;
			// if this object has a customised extend method then use it
			if (!Base._prototyping && typeof this != "function") {
				extend = this.extend || extend;
			}
			var proto = {toSource: null};
			// do the "toString" and other methods manually
			var hidden = ["constructor", "toString", "valueOf"];
			// if we are prototyping then include the constructor
			var i = Base._prototyping ? 0 : 1;
			while (key = hidden[i++]) {
				if (source[key] != proto[key]) {
					extend.call(this, key, source[key]);

				}
			}
			// copy each of the source object's properties to this object
			for (var key in source) {
				if (!proto[key]) extend.call(this, key, source[key]);
			}
		}
		return this;
	}
};

// initialise
Base = Base.extend({
	constructor: function() {
		this.extend(arguments[0]);
	}
}, {
	ancestor: Object,
	version: "1.1",
	
	forEach: function(object, block, context) {
		for (var key in object) {
			if (this.prototype[key] === undefined) {
				block.call(context, object[key], key, object);
			}
		}
	},
		
	implement: function() {
		for (var i = 0; i < arguments.length; i++) {
			if (typeof arguments[i] == "function") {
				// if it's a function, call it
				arguments[i](this.prototype);
			} else {
				// add the interface using the extend method
				this.prototype.extend(arguments[i]);
			}
		}
		return this;
	},
	
	toString: function() {
		return String(this.valueOf());
	}
});




var kajl = Base.extend({
    
    pu : function(url) {
        
        var uri = URI(url);
        
        
        return uri.pathname();
    }
    
});


///////////////////////

var kjgajlist = Base.extend({
    
    
    constructor : function(params) {
        this.element = params.element;
        this.action = params.action;
        this.overlay = params.overlay;
        this.wp_id = '';
        this.resize = params.resize;
        
        var _this = this;
        
        
        $('body').delegate(_this.element+' .ksm_pagination a.page-numbers', 'click', function(e) {
            e.preventDefault();
            $(_this.element+ ' .ff_opts #ff_page').val($(this).attr('rel'));
            _this.load();
        });
        
        
        
                //.ff_opts
        
        _this.load();
    },
    
    //reset_page : function() {
    //    $('#ff_page').val('');
    //},
    
    
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
    
    getParams : function(type, isPub) {
        
        var params = new Array();
        var params_query = new Array();
        
        
        if(isPub) {
            var data_obj = $('.window_inner').find('input, select').not('[prv=1]').serializeArray();
        } else {
            var data_obj = $(this.element).find('input, select').serializeArray();
        }
        
        
        
        
        
        
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
        
        if(this.overlay && $(this.overlay).length > 0) {
            $(this.overlay).show();
        }
        
        
        var _new_h = this.getParams('', true);
        
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
                $('.pagination').html(o.pagination);
                
                if(o.found) _this.init_gallery();
                else _this.destroy_gallery();

            }
        });
    },
    
    
    destroy_gallery : function() {
        $('.posts').justifiedGallery('destroy');
        $('.posts').removeClass('justified-gallery');
    },
    
    
    init_gallery : function() {
        var _ = this;
        
        
        $('.posts').justifiedGallery({
            rowHeight: 196, margins:12, captions: false, imagesAnimationDuration : 1000
        }).on('jg.complete', function (e) {
            if(_.resize == 'cb_resize') window.parent.$.colorbox.resize();
            else if(_.resize == 'cb_m_resize') cb_m_resize();
            else m_resize();
        });
    }
    
    
})






//////////////////////////





    
var al_container = Base.extend({
    
    constructor : function(ele, options) {
        
        var settings = $.extend({
            p: 1,
            action : '',
            load_on_init : true,
            slider : {}
        }, options );
        
        
        
        
        
        settings.ele = ele;
        settings.overlay = settings.ele+ ' .al_overlay';
        
        
        this.settings = settings;
        var _ = this;
        
        
        _.ftl = true;
        
        if(settings.load_on_init) {
            _.init_load(settings.p);
        }
        
        
        
        $('body').delegate(settings.ele+' .ksm_pagination a.page-numbers', 'click', function(e) {
            e.preventDefault();
            _.load($(this).attr('rel'));
        });
        
        $('body').delegate(settings.ele+' .alreload', 'click', function(e) {
            e.preventDefault();
            _.load(1);
        });
        
    },
    
    
    
    hideOverlay : function() {
        if($(this.settings.overlay).length > 0) {
            $(this.settings.overlay).hide();
        }
    },
    
    showOverlay : function() {
        //console.log(this.settings);
        if($(this.settings.overlay).length > 0) {
            $(this.settings.overlay).show();
        }
    },
    
    auto_update : function(o) {
        var _ = this;
        $(_.settings.ele+ ' [alu]').each(function() {
            var alu_val = $(this).attr('alu');
            if(o[alu_val]) {
                $(this).html(o[alu_val]);
            }
        })
        
    },
    
    resph : function(res) {
        var _ = this;
        
        var o = $.parseJSON(res);
        $(_.settings.ele).find('.al_content').html(o.content);
        $(_.settings.ele).find('.pagination').html(o.pagination);
        _.auto_update(o);
        
        
        $(_).trigger( "update" , [o.found]);
        
        _.hideOverlay();
    },
    
    
    onInitLoad : function() {},
    
    init_load : function(p, edta) {
        this.load(p, edta);
    },
    
    load : function (p, edta) {
        var _ = this;
        _.showOverlay();
        var data_obj = $(_.settings.ele).find('.dprms').find('input, select').serializeArray();
        data_obj.push({name : 'action', value : _.settings.action});
        data_obj.push({name : 'p', value :p});
        
        if(edta) {
            data_obj = data_obj.concat(edta);
        }
        _.onInitLoad();
        $.ajax({type: "POST",
            url: ksm_settings.ajax_url,
            data:data_obj,
            success: function(res) {
                _.resph(res);
                _.ftl = false;
            }
        });
    }
    
});


var sslider_al_container = al_container.extend({
    
    onInitLoad : function() {
        var _ = this;
        $(_.settings.ele+' .preloader').show();
    },
    
    resph : function(res) {
        
        var _ = this;
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
        
        
        var o = $.parseJSON(res);
        $(_.settings.ele).find('.al_content').html(o.content);
        $(_.settings.ele).find('.pagination').html(o.pagination);
        _.auto_update(o);
        
        
        if(o.found) {
            $(new_se).on('init', function() {
                $(new_se).show();
                $(_.settings.ele+' .preloader').hide();
            });
            $(new_se).slick(_.settings.slider);
        } else {
            $(_.settings.ele+' .preloader').hide();
        }
        
        $(_).trigger( "update" , [o.found]);
        _.hideOverlay();
    },
});



////////////////////////


var jg_al_container = al_container.extend({
    
    onInitLoad : function() {
        var _ = this;
        $(_.settings.ele+' .preloader').show();
    },
    
    resph : function(res) {
        
        var _ = this;
        var se = _.settings.ele+ ' .posts';
        
        var old_se = se+'.old';
        var new_se = se+'.new';
        $(se).addClass('old').removeClass('al_content').removeClass('new');
        $(se).parent().append('<div class="posts al_content new"></div>');
        $(old_se).each(function() {
            if($(this).hasClass('justified-gallery')) {
                $(this).justifiedGallery('destroy');
            }
            $(this).remove();
        });
        
        
        var o = $.parseJSON(res);
        $(_.settings.ele).find('.al_content').html(o.content);
        $(_.settings.ele).find('.pagination').html(o.pagination);
        _.auto_update(o);
        
        
        if(o.found) {
            
            $(new_se).justifiedGallery({
                rowHeight: 196, margins:12, captions: false, imagesAnimationDuration : 1000
            }).on('jg.complete', function() {
                $(_.settings.ele+' .preloader').hide();
            });
            
        } else {
            $(_.settings.ele+' .preloader').hide();
        }
        
        $(_).trigger( "update" , [o.found]);
        _.hideOverlay();
    },
});


////////////////////////


slick_simple_gallery = Base.extend({
    
    
    constructor : function(params) {
        
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
        
        
        
        this.params = params;
        
        
        
        this.params.full_element = params.ele+' .full';
        this.params.nav_element = params.ele+' .nav';
        this.params.navz_element = params.ele+' .navz';
        
        var _this = this;
        
        $('body').delegate(_this.params.nav_element+' .slider .slick-slide' , 'click', function() {
            if(!$(this).hasClass('current')) {
                _this.setSlide($(this).attr('data-slick-index'));
            }
            $(_this).trigger('nav_change');
        });
        
        $(this.params.nav_element+' .slider').on('init', function(e) {
            //console.log('init');
            if(_this.params.full_slick.slideCount == 1) {
                if(typeof window.m_resize !== 'undefined' && $.isFunction(window.m_resize)) {
                    setTimeout(m_resize, 500);
                }
            }
            _this.setSlide(_this.params.slide);
            
        });
        
        
        
        $(this.params.full_element+' .slider').on('heightChange', function(e) {
            //console.log('heightChange');
            if(typeof window.m_resize !== 'undefined' && $.isFunction(window.m_resize)) {
                m_resize();
            }
        });
        
        $(this.params.full_element+' .slider').on('afterChange', function(e) {
            //console.log('afterChange');
            if(typeof window.m_resize !== 'undefined' && $.isFunction(window.m_resize)) {
                setTimeout(m_resize, 100);
            }
        });
        
        
        
        
        
        _this.init_full_gallery();
        _this.init_nav_gallery();
        _this.init_navz_gallery();
        
        //$(this.params.nav_element+' .slick-slide[data-slick-index='+_this.params.slide+']').addClass('current');
        
        
        
        
        //init
        
        
        //
    },
    
    
    
    
    
    setSlide : function(index) {
        
        this.params.full_slick.slickGoTo(index);
        $(this.params.nav_element+' .slick-slide').removeClass('current');
        $(this.params.nav_element+' .slick-slide[data-slick-index='+index+']').addClass('current');
    },
    
    
    init_full_gallery : function() {
        
        this.params.full_slick = 
        $(this.params.full_element+' .slider').slick({
            slidesToShow: this.params.full.slidesToShow,
            slidesToScroll: this.params.full.slidesToScroll,
            arrows: this.params.full.arrows,
            fade: false,
            infinite: false,
            adaptiveHeight : true,
            //appendArrows: _this.params.gallery_ele+' .full_view_container .full_view_controls',
            //prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="previous"></button>',
            //nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="next"></button>'
        }).slick('getSlick');
    },
    
    
    init_nav_gallery : function() {
        
        this.params.nav_slick = 
        
        $(this.params.nav_element+' .slider').slick({
            slidesToShow: this.params.navigation.slidesToShow,
            slidesToScroll: this.params.navigation.slidesToScroll,
            centerPadding: this.params.navigation.centerPadding,
            
            centerMode: false,
            focusOnSelect: true,
            infinite: false,
            arrows: true,
            variableWidth: false,
            prevArrow: $(this.params.nav_element+' .nav_controls .slick-prev'),
            nextArrow: $(this.params.nav_element+' .nav_controls .slick-next')
        }).slick('getSlick');
        
        
    },
    
      init_navz_gallery : function() {
        
        this.params.navz_slick = 
        
        $(this.params.navz_element+' .slider').slick({
            slidesToShow: this.params.navigation.slidesToShow,
            slidesToScroll: this.params.navigation.slidesToScroll,
            centerPadding: this.params.navigation.centerPadding,
            
            centerMode: false,
            focusOnSelect: true,
            infinite: false,
            arrows: true,
            variableWidth: true,
            prevArrow: $(this.params.navz_element+' .nav_controls .slick-prev'),
            nextArrow: $(this.params.navz_element+' .nav_controls .slick-next')
        }).slick('getSlick');
        
      
    }
    
});

//////////////////////////

var kmv;
var active_cb;

transitionEndEventName = function() {
        var i,
        undefined,
        el = document.createElement('div'),
        transitions = {
            'transition':'transitionend',
            'OTransition':'otransitionend',  // oTransitionEnd in very old Opera
            'MozTransition':'transitionend',
            'WebkitTransition':'webkitTransitionEnd'
        };

        for (i in transitions) {
            if (transitions.hasOwnProperty(i) && el.style[i] !== undefined) {
                return transitions[i];
            }
        }

    //TODO: throw 'TransitionEnd event is not supported in this browser'; 
}




function showfmsg(msg, cls) {
    
    var _id = 'fmsg_'+ Math.floor((Math.random() * 100) + 1);
    
    var _class = 'fmsg';
    if(cls) {
        _class += " "+cls;
    }
    
    $ele = '<div id="'+_id+'" class="'+_class+'"><div class="msg">'+msg+'</div></div>';
    $('body').append($ele);
    
    setTimeout(function() {
        $('#'+_id).remove();
    }, 5000);
    
}




function opencb(u, esc) {
    
    if(window==window.top) {
        
        active_cb = $.colorbox({
            iframe : true, 

            innerWidth : '300', 

            innerHeight : '300',

            href : u,
            escKey : true,
            overlayClose : false,
            opacity : 0.66,
            fastIframe : false,
            onComplete : function() {
                console.log('onComplete');
                if(typeof $('#colorbox .cboxIframe')[0].contentWindow.m_resize !== 'undefined' && $.isFunction($('#colorbox .cboxIframe')[0].contentWindow.m_resize)) {
                    $('#colorbox .cboxIframe')[0].contentWindow.m_resize();
                }
            },
            onCleanup : function(a) {
                
                
                
                if($('.sidebar_box.favorites .upd').length > 0 && $('.sidebar_box.favorites .upd').val() == 'yes') {
                    $('.sidebar_box.favorites .alreload').trigger('click');
                    $('.sidebar_box.favorites .upd').val('no');
                }
            }
        });
        
    } else {
        window.parent.opencb(u);
    }
}



/*
function opencb(u, esc) {
    if(window==window.top) {
        
        active_cb = $.colorbox({
            iframe : true, 
            //innerWidth : '40', 
            //innerHeight : '40',
            href : u,
            escKey : true,
            overlayClose : false,
            opacity : 0.66,
            fastIframe : false,
            onComplete : function() {
                if(typeof $('#colorbox .cboxIframe')[0].contentWindow.m_resize !== 'undefined' && $.isFunction($('#colorbox .cboxIframe')[0].contentWindow.m_resize)) {
                    $('#colorbox .cboxIframe')[0].contentWindow.m_resize();
                }
            }
        });
        
    } else {
        window.parent.opencb(u);
    }
}
*/


function kslick(ele, params) {
        
    $(ele+' .slider').on('init', function() {
        $(ele+' .slider').show();
        $(ele+' .preloader').removeClass('preloader').addClass('loader');
    });
    
    $(ele+' .slider').slick(params);
}






function load_dd_list(_dd_list, a, p) {
    _dd_list.find('.ksm_loading').slideToggle();
    $.ajax({
            type: "POST",
            url: ksm_settings.ajax_url,
            data: {action:a,p:p},
            success: function(r) {
                onListLoaded(r, _dd_list)
            }
        });
    
}


function onListLoaded(response, _dd_list) {
    
    var o = $.parseJSON(response);
    _dd_list.find('.list li .l3').show();
    _dd_list.find('.list li.old').slideUp("slow", function() { $(this).remove();});
    _dd_list.find('.list').append(o.messages).slideDown();
    
    _dd_list.find('.list li').last().find('.l3').hide();
    _dd_list.attr('page', o.p);
    if(o.paging) {
        _dd_list.find('.header .options ul').show();
        _dd_list.find('.footer').html(o.paging).show();
    } else {
        _dd_list.find('.header .options ul').hide();
        _dd_list.find('.footer').html('').hide();
    }
    _dd_list.find('.ksm_loading').slideToggle();
    _dd_list.find('.options .checkbox_bulk input').prop('checked', false)
}

var kp;
$(function() {
    
    
    $('.user_nav .menu_btn').click(function() {
        $('.user_nav .menu').toggle();
    });
    
    
    $(function() {
        $('input:not([icheck])').iCheck({
            checkboxClass: 'icheckbox_futurico',
            radioClass: 'iradio_futurico',
            increaseArea: '20%'
        });
        
        $('input').on('ifChanged', function(e) {
            if($(this).is('[type=radio]')) {
                if($(this).is(':checked')) {
                    $(this).trigger('change');
                }
            } else {
                $(this).trigger('change');
            }
        });
        
    });
    
    
    new slick_simple_gallery({
        ele : '#download_view_gallery'
    });
    
    if(ksm_settings.kmod) {
        if(ksm_settings.kmod == 'kcoll') {
            var kcoll = new kcollab();
        }else if(ksm_settings.kmod == 'kp') {
            kp = new kpub();
        }
    }
    
    
    
    $('.tooltip').tooltipster({
                    minWidth: 300,
                    maxWidth: 300,
                    functionBefore: function(origin, continueTooltip) {
                        if(origin.find('.description').length && origin.find('.description').html()) {
                            origin.tooltipster('content', origin.find('.description').html());
                            continueTooltip();
                        }
                    }
                    
                });

    
    
    
    
    
    
    $('body').delegate('.ddlist .pagination a.prev, .ddlist .pagination a.next', 'click', function(e) {
        e.preventDefault();
        
        _dd_list = $(this).closest('.ddlist');
        var n = _dd_list.attr('name');
        if(!n) {return;}
        _dd_list.find('.list li').addClass('old');
        load_dd_list(_dd_list, n, $(this).attr('p'));
    })
    
    $('body').delegate('a.lp', 'click', function(e) {
        e.preventDefault();
        window.parent.location = $(this).attr('href');
        window.parent.tb_remove();
    })
    
                

    
    $('.messages_dd_btn .icon, .messages_dd_btn .counter').click(function() {
        $('.notification_dd_btn .ddlist').fadeOut(200);
    })
    
    
    $('.notification_dd_btn .icon, .notification_dd_btn .counter').click(function() {
        $('.messages_dd_btn .ddlist').fadeOut(200);
    })
    
    $('.messages_dd_btn .icon, .messages_dd_btn .counter, .notification_dd_btn .icon, .notification_dd_btn .counter').click(function(e) {
        e.stopPropagation();
        _dd_list = $(this).closest('li').find('.ddlist');
        
        var n = _dd_list.attr('name')
        if(!n) {return;}
        _dd_list.slideToggle();
        if(_dd_list.attr('page')) {
            return;
        }
        load_dd_list(_dd_list, n , '1');
    });
    
    $('.ddlist .options .checkbox_bulk input').on('change', function(){
        if($(this).is(':checked')) {
            $(this).closest('.ddlist').find('.list li input.cb').prop('checked', true);
        } else {
            $(this).closest('.ddlist').find('.list li input.cb').prop('checked', false);
        }
    });
    
    $('body').delegate('.ddlist .list input.cb', 'change', function() {
        if($(this).closest('.list').find('li input.cb').not(':checked').length == '0') {
            $(this).closest('.ddlist').find('.options .checkbox_bulk input').prop('checked', true);
        } else {
            $(this).closest('.ddlist').find('.options .checkbox_bulk input').prop('checked', false);
        }
    })
    
    $('.ddlist .options .delete_bulk').click(function() {
        var list = $(this).closest('.ddlist').find('.list li input.cb:checked');
        list.closest('li').addClass('old');
        _dd_list = $(this).closest('.ddlist');
        if(list.length > 0) {
            
            action = $(this).attr('action');
            list.closest('.ddlist').find('.ksm_loading').slideToggle();
            $.ajax({
                type: "POST",
                url: ksm_settings.ajax_url,
                data: {items:$(list).serializeArray(), action:action,p:$(this).closest('.ddlist').attr('page')},
                success: function(r) {
                   onListLoaded(r, _dd_list);
                }
            })
        }
    })
    
    $('.ddlist .options .read_bulk').click(function() {
        var list = $(this).closest('.ddlist').find('.list li input.cb:checked');
        
        if(list.length > 0) {
            action = $(this).attr('action');
            list.closest('.ddlist').find('.ksm_loading').slideToggle();
            $.ajax({
                type: "POST",
                url: ksm_settings.ajax_url,
                data: {items:$(list).serializeArray(), action:action},
                success: function(r) {
                   list.closest('li').addClass('read');
                   list.closest('.ddlist').find('.ksm_loading').slideToggle();
                   list.prop('checked', false);
                }
            })
        }
    })
    
    
    $('body').delegate('.btn_form_smt', 'click' ,function(e) {
        e.preventDefault();

        if($(this).hasClass('uploadip')) {
            $(this).tooltipster({content: 'Uploading images...',once : true});
            $(this).tooltipster('show');
        } else {
            
            
            var ff = $(this).closest('form').find('.form_footer');
            
            if(ff.length == 1){
                $(ff).find('.error').html('').hide();
                
                $(ff).find('.ksm_loading').show();
            }
            
            //$(this).addClass('disabled');
            $(this).closest('form').submit();
            $(this).closest('form').find('.form_loading').show();
        }
    })
    
    
    $(document).on('click', function (e, b) {
        if ($(e.target).closest(".ddlist").length === 0) {
            $(".ddlist").fadeOut(200);
        } 
        if ($(e.target).closest(".user_nav").find('.menu').length === 0) {
            $(".user_nav .menu").hide();
        }
        
        
        
    });
    
    
    
    $('.ksm_profile').delegate('.btn_add_wall_post', 'click', function(e) {
        e.preventDefault();
        $(this).closest('form').submit();
    });
    
    
    
    
    
    $('.ufusr').click(function(e) {
        e.preventDefault();
        
        var _id = $(this).attr('rel');
        _this = $(this);
        $.ajax({
            type: "POST",
            url: ksm_settings.ajax_url,
            data: {id:_id, action:'User_unfollow'},
            success: function(r) {
                var o = $.parseJSON(r);
                if(o) {
                    
                    
                    $('.following.sidebar_box .header .count').html(o.followings);
                    var _in = _this.closest('.slick-slide').attr('data-slick-index');
                    _this.closest('.slider').slick('slickRemove', _in);
                    
                    if(o.followings == 0) {
                        $('.following.sidebar_box .follows_slider').hide();
                        $('.following.sidebar_box .enc_message').show();
                    } 
                    
                    
                }
            }
        });
    })
    
    
    
    //$('body').delegate('.image_stats .share .button', 'click', function(e) {
        
    //});
    
    
    $('body').delegate('.item', 'favorite_change', function() {
        var win = window;
        var ispup = false;
        if($(this).closest('.window').length > 0) {
            ispup = true;
            win = window.parent;
        }
        if(win.$('.sidebar_box.favorites .upd').length > 0) {
            if(ispup) {
                win.$('.sidebar_box.favorites .upd').val('yes');
            } else {
                $('.sidebar_box.favorites .alreload').trigger('click');
            }
        }
    });
    
    
    $('body').delegate('.comment_stats .likes .button, .post_stats .likes .button, .image_stats .favorites .button, .i_stats .favorites .button, .image_stats .likes .button, .i_stats .likes .button, .counts .likes .button', 'click', function(e) {
        e.preventDefault();
        
        _this = $(this);
        
        if(_this.hasClass('kng')) {
            return;
        }
        
        if(_this.hasClass('disabled') || _this.hasClass('loading')) {
            return;
        }
        
        _this.addClass('loading');
        
        var _id = $(this).attr('rel');
        var type = $(this).attr('type');
        
        $.ajax({
            type: "POST",
            url: ksm_settings.ajax_url,
            data: {id:_id, action:type},
            success: function(r) {
                
                _this.removeClass('loading');
                var o = $.parseJSON(r);
                if((o.count !== false)) _this.closest('li').find('.count').html(o.count);
                if(o.class) _this.closest('li').find('.button').addClass(o.class);
                if(o.removeClass) _this.closest('li').find('.button').removeClass(o.removeClass);
                if(o.action) _this.closest('li').find('.button').attr('rel', o.action);
                
                
                
                
                
                if(type == 'favorite') {
                    _this.closest('.item').trigger('favorite_change');
                    
                    
                    
                }
                
            }
        })
    });
    
    
    $('body').delegate('.colorbox', 'click' , function(e) {
       e.preventDefault(); 
       
       if($(this).hasClass('cbtcb')) {
           
       }
       
       var esc = $(this).attr('esc') == '0' ? false : true;
       
        opencb($(this).attr('href'), esc); 
    });
    
    $('body').delegate('.post_stats .share .button, .image_stats .share .button, .counts .share .button', 'click', function(e) {
        var di = $(this).attr('data-item');
        var u = ksm_settings.share_page+di;
        
        $.colorbox({
            iframe:true, 
            innerWidth:'540', 
            innerHeight:'450',
            href : u,
            opacity : 0.66,
            fastIframe : false
        });

        
        
        
        
        /*if(di) {
            $.ajax({
                type: "POST",
                url: ksm_settings.ajax_url,
                data: {item:di, action:'sh_params'},
                success: function(r) {
                    console.log(r)
                }
            })
        }
        */
    });
    
    
    
    $('.btn_follow').click(function(e) {
        e.preventDefault();
        var _id = $(this).attr('rel');
        _this = $(this);
        $.ajax({
            type: "POST",
            url: ksm_settings.ajax_url,
            data: {id:_id, action:'follow'},
            success: function(r) {
                obj = $.parseJSON(r);
                
                _this.attr('rel', obj.action);
                _this.find('span').html(obj.text);
                _this.addClass(obj.class).removeClass(obj.removeClass);
                
            }
        })
    });
    
    
    
    
    
    
    
    
    $('.tbjs').click(function(e){
        e.preventDefault();
        tb_show($(this).find('.cpt').html() ,$(this).attr('href'), false);
    })
    
    
    $('body').delegate('[atrqt]', 'click' , function(e) {
        e.preventDefault();
        
        opencb(ksm_settings.home_url+'/login/'+$(this).attr('atrqt'));
        
    });
    
    
    
    $('body').delegate('.kpload', 'click' , function(e) {
        e.preventDefault();
        if($('.window').length) {
            window.parent.location = $(this).attr('href');
        } else {
            window.location = $(this).attr('href');
        }
    })
    
    
    
    
    if(window.m_resize !== 'undefined' && $.isFunction(window.m_resize)) {
        window.m_resize();
    }
    
    
})








function is_amount(num) {    
    var regex =  /^([0-9]+(\.[0-9]+)?)$/;
    
    return regex.test(num);
}



//////////////////////////////////////////////////////////////////////////////////