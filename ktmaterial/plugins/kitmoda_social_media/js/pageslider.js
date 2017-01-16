/* Notes:
 * - History management is currently done using window.location.hash.  This could easily be changed to use Push State instead.
 * - jQuery dependency for now. This could also be easily removed.
 */

function PageSlider(container) {

    var container = container,
        currentPage,
        stateHistory = [];

    // Use this function if you want PageSlider to automatically determine the sliding direction based on the state history
    this.slidePage = function(page) {

        var l = stateHistory.length,
            state = window.location.hash;
    

        if (l === 0) {
            stateHistory.push(state);
            this.slidePageFrom(page);
            return;
        }
        if (state === stateHistory[l-2]) {
            stateHistory.pop();
            this.slidePageFrom(page, 'left');
        } else {
            stateHistory.push(state);
            this.slidePageFrom(page, 'right');
        }

    };

    // Use this function directly if you want to control the sliding direction outside PageSlider
    this.slidePageFrom = function(page, from, hash) {
        container.append(page);
        
        $('#slide_page_container').attr('rel', hash);
        
        $('#main').trigger( "onSlidePage", [hash]);
        
        
        
        
            
        
        
        if(hash == 'user_blackout-days') {
            if(typeof cal2 == 'object') {
                cal2.destroy();
                delete cal2;
            }
            initBlackoutCal();
                
            }
        
        if (!currentPage || !from) {
            reset_layout();
            
            
            
            page.attr("class", "page center");
            currentPage = page;
            if(page.find('.swiper-container').length > 0) {
                initSwiper('#'+page.find('.swiper-container').attr('id'));
                setTimeout('ListSwiper_reInit()', 1000)
            }
            //
            return;
        }

        // Position the page at the starting position of the animation
        page.attr("class", "page " + from);
        //console.log()
        var transitionEndName = this.transitionEndEventName();
        currentPage.one(transitionEndName, function(e) {
            
            active = $(e.target).attr('rel');
            $('#page_'+active+'_temp').append($(e.target).attr('class', 'page_slider'));
            $('#main .temps_container.old').remove();
            $('#main .temps_container.new').removeClass('new');
            if(page.find('.swiper-container').length > 0) {
                initSwiper('#'+page.find('.swiper-container').attr('id'));
                setTimeout('ListSwiper_reInit()', 1000)
            }
            //ListSwiper_reInit();
            
        });

        // Force reflow. More information here: http://www.phpied.com/rendering-repaint-reflowrelayout-restyle/
        container[0].offsetWidth;

        // Position the new page and the current page at the ending position of their animation with a transition class indicating the duration of the animation
        page.attr("class", "page transition center");
        currentPage.attr("class", "page transition " + (from === "left" ? "right" : "left"));
        currentPage = page;
    };
    
    
    this.transitionEndEventName = function() {
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

}