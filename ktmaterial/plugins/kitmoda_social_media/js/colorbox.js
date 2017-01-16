var cbppres = false;

var use_resize_height = true;

function cb_m_resize() {
    var ele = $('.window .window_inner');
    
    
    if(ele.length == 0) {
        return;
    }
    
    var h = ele.height();
    var w = ele.width() //attr('swidth');
         
    if(!w) {
        w = 726;
    }
    
    if(use_resize_height) {
        $('.window').css({width:w, height:h});
        var h = ele.height();
        $('.window').css({width:w, height:h});
        window.parent.$.colorbox.resize({width : w, height : h});
    }
}


function m_resize() {
    
    var ele = $('.window .window_inner');
    
    
    if(ele.length == 0) {
        return;
    }
    
    var h = ele.height();
    var w = ele.width() //attr('swidth');
         
    if(!w) {
        w = 726;
    }
    
    
    if(use_resize_height) {
        $('.window').css({width:w, height:h});
        var h = ele.height();
        $('.window').css({width:w, height:h});



        if(cbppres) {
            window.parent.$('#cboxLoadedContent,#cboxContent,#cboxWrapper,#colorbox')
                .css({width:w, height:h});
            window.parent.$.colorbox.normal_resize({width : w, height : h});
        } else {
            cbppres = true;
            window.parent.$.colorbox.resize({width : w, height : h});
        }
    }
}

  
function cbSlide(ele, f) {
    if(f=='up') {
        $(ele).slideUp({progress: m_resize});
    }

    else if(f=='down') {
        $(ele).slideDown({progress: m_resize});
    }
    
    
    else if(f=='t') {
        $(ele).slideToggle({progress: m_resize});
    }
}
        
        
        
$(function() {
    $('.win_header .close').click(function() {
        window.parent.$.colorbox.close();
    });
    
    
    $('.footer .win_close').click(function() {
        window.top.$.colorbox.close();
    });
    
    
    
    $('.window').bind('cbarele', function(){
        window.top.m_resize();
    });
    
    //$('.window').trigger("cbarele");

    
    
    
    
    if($('.window_inner').attr('svinai') != '' && window.top === window.self) {
        use_resize_height = false;
        $('.window').css({height:'auto'});
        var cls = $('.window_inner').attr('svinai')
        $('body').addClass(cls);
        if(cls == 'full_page_popup')  {
            $('.colorbox').removeClass('colorbox');
        }
    }
    
    
    
    $(document).bind('keydown', function (e) {
        var key = (e.keyCode ? e.keyCode : e.which);
        if (key === 27) {
            console.log('esc');
            window.parent.$.colorbox.close();
        }
    });
    
    
    $('body').delegate('cbtcbl', 'click', function(e) {
        e.preventDefault();
        cbtcbl($(this).attr('href'));
    });
    
    
    
    
    
    $('.window .footer .btn_submit').click(function(e) {
        e.preventDefault();
        
        if($(this).hasClass('disabled')) {
            return;
        }
        
        $(this).closest('form').submit();
        
        $(this).addClass('disabled');
        
        var f = $(this).closest('.footer');
        f.find('.error').hide();
        f.find('.ksm_loading').show();
        
    })
    
});



//function cbtcbl(l) {
    
//}

$(function() {
    $('body').delegate('textarea', 'resize', function() {
        $('.window').trigger("cbarele");
    });
});

