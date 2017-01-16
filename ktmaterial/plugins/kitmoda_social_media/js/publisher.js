var kpub = function(params) {
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
        disabled : false
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
    }
    
    
    _this.initAddConcept = function(e) {
        e.preventDefault();
        
        
        
    }
    
    
    _this.resize = function() {
        var ele = _this.currentStep()
        
        var h = ele.height();
        //var w = ele.attr('swidth');
            
        //var h = ele.attr('sheight');
        $('.window').css({height:h});
        var h = ele.height();
        $('.window').css({height:h});
        
        window.parent.$.colorbox.resize({height : h});
    }
    
    
    _this.mresize = function() {
        var ele = _this.currentStep()
        
        var h = ele.height();
        //var w = ele.attr('swidth');
            
        //var h = ele.attr('sheight');
        $('.window').css({height:h});
        var h = ele.height();
        $('.window').css({height:h});
        
        window.parent.$('#cboxLoadedContent,#cboxContent,#cboxWrapper,#colorbox')
                .css({height:h});
        
        window.parent.$.colorbox.normal_resize({height : h})
        
        

        
    }
    
    
    _this.changeStep = function(sndx) {
        $('.step').hide();
        if($('.step[sindex='+sndx+']').length > 0) {
            
            var ele = $('.step[sindex='+sndx+']');
            ele.show();
            $('.step').removeClass('current');
            ele.addClass('current');
            
            var ts = _this.totalSteps();
            
            $('.step_nav .info .left').html(sndx);
            $('.step_nav .info .right').html(ts);
            
            if(ts > 1)  {
                if(sndx == 1) {
                    $('.step_nav .prev').hide();
                } else {
                    $('.step_nav .prev').show();
                }


                if(sndx == ts) {
                    $('.step_nav .next').hide();
                } else {
                    $('.step_nav .next').show();
                }
            }
            
            
            
            _this.resize();
            
            
        }
    }
    
    _this.moveNext = function(e) {
        //e.preventDefault();
        var c = _this.currentStep();
        ci = parseInt(c.attr('sindex'));
        
        _this.changeStep(ci+1);
    }
    
    _this.close = function(e) {
        e.preventDefault();
        window.parent.$.colorbox.close();
    }
    
    _this.currentStep = function() {
        return $('.step.current');
    }
    
    _this.currentStepI = function() {
        var s = _this.currentStep();
        return parseInt(s.attr('sindex'));
    }
    
    _this.totalSteps = function() {
        return parseInt($('.step').length);
        
    }
    
    
    _this.submit = function() {
        $('.pub_form').submit();
        
        //$('#cboxOverlay').show();
        
    }
    
    _this.setError = function(error, step) {
        
        var _stp = _this.currentStep();
        
        if(step && _stp.attr('sindex') != step) {
            _this.changeStep(step);
            var _stp = _this.currentStep();
        }
        
        _stp.find('.footer .error').html(error).show();
        _this.finish_loading();
    }
    
    _this.start_loading = function() {
        _this.params.disabled = true;
        var _stp = _this.currentStep();
        var _btn = _stp.find('.footer .btn_step_next');
        _btn.addClass('disabled');
        _stp.find('.footer .ksm_loading').show();
    }
    
    _this.finish_loading = function() {
        _this.params.disabled = false;
        $('.footer .btn_step_next').removeClass('disabled');
        $('.footer .ksm_loading').hide();
    }
    
    
    _this.stepChangeHandler = function(e) {
        e.preventDefault();
        
        
        var _stp = _this.currentStep();
        var _btn = _stp.find('.footer .btn_step_next');
        
        
        
        if(_this.params.disabled) {
            return;
        }
        
        
        _this.start_loading();
        
        var data_obj = _stp.find('input, select, textarea').serializeArray();  
        
        var _action = $('#pub_type').val()+'_validate_'+_stp.attr('rel');
        
        data_obj.push({name : 'step', value : _stp.attr('rel')});
        data_obj.push({name : 'action', value : 'Publisher_validate'});
        data_obj.push({name : 'pub_id', value : $('#pub_id').val()});
        
        _stp.find('.footer .error').hide().html('');
        
        $.ajax({
            type: "POST",
            url: ksm_settings.ajax_url,
            data:data_obj,
            success: function(res) {
                var o = $.parseJSON(res);
                
                if(o.error) {
                    _stp.find('.footer .error').show().html(o.msg);
                    _this.finish_loading();
                } else if(o.success) {
                    _stp.find('.footer .error').html('').hide();
                    if(_btn.hasClass('final')) {
                        _this.submit();
                    } else {
                        _this.finish_loading();
                        _this.moveNext();
                    }
                }
                
                
                
                
                //if(o.success) {
                    //$(form + ' label.error').removeClass('error');
                    //params.selection[_ele.attr('rel')] = $(form).serializeArray();
                    //if(_ele.hasClass('signup_step_finish')) {
                    //    _this.submit();
                    //} else {
                    //    _this.moveNext();
                    //}
                //} else {
                    //$(form + ' label.error').removeClass('error');
                    //if(o.name) {
                    //    $(form + ' [name='+o.name+']').closest('label').addClass('error');
                    //}
                //}
            }
        });
                
                
                

                
            
        
        
    }
    
    _this.init = function() {
        
        _this.changeStep(1);
        
        $('body').delegate('.kcat select', 'change', function() {
            var _ele = $(this);
            
            _ele.closest('select').prop('disabled', true);
            _ele.closest('.field').nextAll().remove();
            
            var id = $(this).val();
            _this.mresize();
            $.ajax({
                type : "POST",
                url : ksm_settings.ajax_url,
                data : {action:'kcat', id : id},
                success: function(res) {
                    if($(res).find('select').length > 0) {
                        
                        var sel_id = $(res).find('select').attr('id');
                        
                        _ele.closest('.kcat').append(res);
                        console.log(sel_id);
                        new SelectBox({
                            selectbox: $('#'+sel_id),
                            height: 150,
                            width: 200,
                            changeCallback : function(val) {
                                $(this.selectbox).trigger('change');
                            }
                        });
                    }
                    
                    _ele.closest('select').prop('disabled', false);
                    _this.mresize();
                    
                }
            });
            
        })
        
        
        
        
        $('body').delegate('.btn_step_next', 'click', _this.stepChangeHandler);
        //$('body').delegate('.coll_sidebar .filter_nav li a.concept', 'click', _this.initAddConcept);
        
        $('body').delegate('.step .close', 'click', _this.close);
        
        
        
        
    }
    
    
    
    
    _this.init();
    
    
}

$(function() {
    kp = new kpub();
    
    
    $('.pub_textured_model.pub_form .section.section_sell input:radio').on('change', function(){
        //console.log(this);
        
        cbSlide('.section.section_pricing .field_group.field_group_untextured_price', 't');
        cbSlide('.section.section_untextured_upload', 't');
        
        $('.step.publisher_step_upload #upload_sell_type').val($(this).val());
        
        
    });
    
    
    $('body').delegate('.step_nav .prev', 'click', function(e) {
        var s = kp.currentStepI();
        var t = kp.totalSteps();
        if(s != 1 && s > 1 && t > 1) {
            kp.changeStep(s-1);
        }
    });
    
    $('body').delegate('.step_nav .next', 'click', function(e) {
        var s = kp.currentStepI();
        var t = kp.totalSteps();
        if(s != t && s < t && t > 1) {
            kp.changeStep(s+1);
        }
    });
    
    
    $('.pub_untextured_model .section.section_collab_invite input:radio').on('change', function(){
        cbSlide('.section.section_pricing.section_normal_pricing', 't')
        cbSlide('.section.section_pricing.section_share_pricing', 't')
    });
    
    
    
    
    $('.field_group_is_unwrapped input:radio').on('change', function(){
        if($(this).val() == 'no') {
            cbSlide('.unwrap_fields', 'up')
        } else {
            cbSlide('.unwrap_fields', 'down')
        }
    });
    
    
    

    
    
    $('.field_group_file_format_primary input:radio').on('change', function(){
        
        var _v = $(this).val();
        var _i = '#other_file_formats_i_'+_v;
        
        
        $('.field_group_file_format_others .field.disabled')
                .removeClass('disabled')
                .find('input')
                .prop('disabled', false);
                
        
        var _f = $('.field_group_file_format_others '+_i).closest('.field');
        _f.addClass('disabled');
        _f.find('input')
                .iCheck('uncheck')
                .prop('disabled', true)
                
                .prop('checked', false)
    })
    
    
    
    
				
    $("select").each(function() {
        var sb = new SelectBox({
            selectbox: $(this),
            height: 150,
            width: 200,
            changeCallback : function(val) {
                $(this.selectbox).trigger('change');
            }
        });
    });
    
    $('#pub_keywords').tagEditor({
        placeholder: 'Enter up to 10 keywords here...' ,
        forceLowercase : false,
        onChange: function() {
            kp.mresize();
        }
    });
    $(".tag-editor input").tagEditorInput();
    
    
    $('.term_step .back_btn').click(function(e) {
        e.preventDefault();
        $('.term_step').hide();
    });
    
    $('.terms_link').click(function(e) {
        e.preventDefault();
        
        var h = kp.currentStep().outerHeight();
        
        $('.term_step [hec=1]').each(function() {
            h = h - $(this).outerHeight();
        });
        $('.term_step .content').css({height:h+'px'});
        $('.term_step').show();
    });
    
    $('.field_group_ap_required input').on('change', function(){
        if($(this).val() == 'yes') {
            cbSlide('.additional_plugins_field', 'down');
        } else {
            cbSlide('.additional_plugins_field', 'up');
        }
    });
    
	$(".search_box select").selectBoxIt({
		showEffect: "fadeIn",
        autoWidth : false, 
        showEffect : 'slideDown', 
        showFirstOption : false, 
        copyClasses : 'container'
    });
    
});