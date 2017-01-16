function ppresize() {
    if($('.window').length > 0) {
        var nh = $('.window').attr('h');
        
        
        
        
        if(window.parent) {
            //console.log($(window.parent).height());
            
            var parent_height = $(window.parent).height();
            var max_possible = parent_height - 40;
            var max_height = nh;
            
            if(nh > max_possible) {
                max_height = max_possible;
            }
            
            window.parent.$('#TB_iframeContent').css({height: max_height+'px'});
            window.parent.$("#TB_window").css({marginTop: '-' + parseInt((max_height / 2),10) + 'px'});
            
            
        } else {
            //var max_possible = parent_height - 90;
            //if(max_height > max_possible) {
            //    max_height = max_possible;
            //}
            
            
        }
        
        
        var content_height = max_height;
        
        if($('[hec="1"]').length > 0) {
            $('[hec="1"]').each(function() {
                content_height = content_height - ($(this).height() + 2);
            })
            
        }
        //if($('.window .footer').length > 0) {
        //    var content_height = max_height - ($('.window .footer').height() + 2);
        //}

        $('.content').css({height:content_height+'px'});
        
    }
    
}


function pslider(container, _old , _new, from) {
    
    container.append(_new);
    _new.attr("class", "window_content " + from);
    var transitionEndName = transitionEndEventName();
    
    _old.one(transitionEndName, function(e) {
        (e.target).remove()
    });

    
    container[0].offsetWidth;

    
    _new.attr("class", "window_content transition center");
    _old.attr("class", "window_content old transition " + (from === "left" ? "right" : "left"));
    
}

$(function() {
    ppresize();
    
    $(window.parent).resize(function() {
        ppresize();
    });
    
    $('body').delegate('.window .win_header .close', 'click', function(e) {
        e.preventDefault();
        
        if(window.parent.length > 0) {
            window.parent.tb_remove();
        }
    })
    
    
    
    
    $('body').delegate('.jspaging .next, .jspaging .prev', 'click', function(e) {
        e.preventDefault();
        
        
        var from = $(this).hasClass('next') ? 'right' : 'left';
        
            
            
            $.ajax({
            type: "POST",
            url: $(this).attr('href'),
            data: {action:'jspaging'},
            success: function(r) {
                $('.window .window_content').addClass('old');
                pslider($('.window'), $('.window .window_content.old') , $(r), from);
                ppresize();
            }
        })
            
        
    
        
        
    })
    
    
})