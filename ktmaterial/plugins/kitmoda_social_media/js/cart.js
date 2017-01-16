



$(function() {
    
    $('body').on('edd_cart_billing_address_updated', function() {
        
        if($('#edd-card-state-wrap select').length == 0 && $('#edd-card-state-wrap .sbHolder')) {
            $('#edd-card-state-wrap .sbHolder').remove();
        }
                
                
        
        $("select").selectbox();
    })
    $("select").selectbox();
})