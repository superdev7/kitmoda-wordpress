jQuery(document).ready(function($) {

        // click on menu
	jQuery('.firstList>li').click(function(){
		jQuery('.secondList').toggleClass('active');
	});
 
        //custom checkbox on refine-menu

	jQuery('.list-options label').on( 'click', function() {
                var input = jQuery(this).parent().find('input');
                console.log('d');
                if(jQuery(input).prop("checked")) {
                    jQuery(this).addClass("active");
                }
                else {
                    jQuery(this).removeClass("active");
                } 
        });

	//open refine-menu
	jQuery('.refine').click(function(){
		jQuery('.refine-menu').show();
	});

	//close refine-menu
	jQuery('.close-refine-button').click(function(){
		jQuery('.refine-menu').hide();
	});
 
        //custom scroll

        jQuery('.scrollbar-inner').scrollbar({
              'showArrows': 'true'
        }); 
  
        jQuery('#mosaic').mason({
	    itemSelector: '.grid-item',
	    ratio: 1,
	    sizes: [
	        [1,1], 
	        [2,1] 
	    ], 
	    columns: [
	    	[0, 999, 3], 
	        [1000,2000,5]
	    ],
	    gutter: 5,
	    layout: 'fluid'
	});
 
    // $('.slider').slider().slider("pips");
    
        //Primary categories
        $('.subCategory.secondList li').click(function(){
            $(this).closest('ul').hide();
            $('.thirdStep').show();
            
//            $.ajax({
//                    method:   'POST',
//                    dataType: 'json',
//                    url:      ksm_settings.ajax_url,
//                    data: { action: 'store_get_subcats', id : $(this).data('parent')},
//                    success: function( response ) {
//                        console.log(response);
//                    }
//            });
        });
        
        //Come back to Primary categories
        $('.thirdStep .back').click(function(){
            $(this).closest('.thirdStep').hide();
            $('.subCategory.secondList').show();
        });
                
});