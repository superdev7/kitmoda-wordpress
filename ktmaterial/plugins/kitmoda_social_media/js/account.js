
var facet_q_last_val = '';
var facet_q_timer;

var kfacet = Base.extend({
    
    
    constructor : function(params) {
        this.element = params.element;
        this.action = params.action;
        this.overlay = params.overlay;
        this.wp_id = '';
        
        var _this = this;
        
        var elements =  this.element+' input.opt_filter, '+this.element+' select';
        
        
        
        $('body').delegate(elements , 'change', function() {
            _this.reset_page();
            _this.load();
        });
        
        
        $(this.overlay).show();
        
        
        _this.setParams(_this.getURLParams());
        facet_q_last_val = $('#ff_q').val();
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
        } else {
            var name = v.name;
            if($('[name='+name+']').length > 0) {
                return $('[name='+name+']');
            }
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
        
        var _ = this;
        var params = new Array();
        var params_query = new Array();
        
        var data_obj = $(this.element).find('input, select').serializeArray();
        
        $.each(data_obj, function(k, v){
            
            var f = _.getField(v);
            var isP = (f && f.attr('priv') == 'true') ? true : false;
            
            if(v.value != "" && !_.isPriv(v)) {
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
    
    
    isPriv : function (v) {
        
        var f = this.getField(v);
        var isP = (f && f.attr('priv') == 'true') ? true : false;
        return isP;
    },
    
    
    getPrivParams : function() {
        
        var _ = this;
        var params = new Array();
        
        var data_obj = $(this.element).find('input, select').serializeArray();
        $.each(data_obj, function(k, v){
            if(_.isPriv(v)) {
                params.push({name : v.name , value : v.value});
            }
        });
        
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
        
        
        var _data = $.merge(this.getParams('array'), this.getPrivParams());
        
        
        
        $.ajax({
            type: "POST",
            url: ksm_settings.ajax_url,
            data:_data,
            success: function(res) {
                $(_this.overlay).hide()
                var o = $.parseJSON(res);
                $('.posts').html(o.posts);
                $('.main_footer').html(o.pagination);
                
                $('.posts .post:last').css({borderBottom : 0});
                
                if(pagc) {
                    $('.posts').trigger("onPaginateLoaded");
                } else if(_this.wp_id && $('#wp_'+_this.wp_id).length > 0) {
                    var targetOffset = $('#wp_'+_this.wp_id).offset().top
                    $('html,body').animate({scrollTop: targetOffset}, 300);
                    _this.wp_id = '';
                }
            }
        });
    }
});
var f_ac;
$(function() {
    
    if($('.main_content.purchase_library_main').length > 0) {
        f_ac = 'purchases';
    } else if($('.main_content.account_sales_main').length > 0) {
        f_ac = 'sales';
    } else if($('.main_content.account_products_main').length > 0) {
        f_ac = 'products';
    }
    
    if(f_ac) {
        if($('.filter_nav').length > 0) {
            pur_facet = new kfacet({
                element : '.filter_nav',
                action : 'Account_filter_'+f_ac,
                overlay : '.main_overlay'
            });
        }
        
        $('.opt_remove_all a').click(function(e) {
            e.preventDefault();

            $('.filter_nav').find('.opt_filter').prop('checked', false);
            $('.filter_nav select option:first').prop('selected', true);
            $('input').iCheck('update');
            $('.filter_nav .search #ff_q').val('');
            pur_facet.reset_page();
            pur_facet.load();
        });
        
        $('body').delegate('.ksm_pagination a', 'click', function(e) {
            e.preventDefault();
            $('#ff_page').val($(this).attr('rel'));
            pur_facet.load(true);
        })


        $('.posts').on("onPaginateLoaded", function() {
            $('html, body').animate({
                scrollTop: $(".posts").offset().top - 40
            }, 450);
        });
        
        $('.filter_nav .search .ksm_community_search_button').click(function(e) {
            pur_facet.reset_page();
            pur_facet.load();
        });



        $('.filter_nav .search #ff_q').keypress(function(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if(keycode == 13) {
                pur_facet.reset_page();
                pur_facet.load();
            }
        });
        
        $('.filter_nav .search #ff_q').keyup(function(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode !=13) {
                var val = $(this).val();
                if (val == '' && val != facet_q_last_val) {
                    facet_q_last_val = val;
                    clearTimeout(facet_q_timer);
                    facet_q_timer = setTimeout(function(){ 
                        pur_facet.reset_page();
                        pur_facet.load();
                    }, 500);
                } else {
                    facet_q_last_val = val;
                }
            }
        });
    }
    
    
});