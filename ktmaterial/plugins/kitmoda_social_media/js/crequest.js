function join_calculator() {
    var mp = $('#model_price').val() || 0;
    var tp = $('#texture_price').val() || 0;
    
    var err = false;
    
    
    
    if(!is_amount(mp)) {
        $('#model_price').addClass('err');
        err = true;
    } else {
        $('#model_price').removeClass('err');
    }
    
    
    if(!is_amount(tp)) {
        $('#texture_price').addClass('err');
        err = true;
    } else {
        $('#texture_price').removeClass('err');
    }
    
    if(err) {
        return;
    }
    
    mp = parseFloat(mp);
    tp = parseFloat(tp);
    
    
    var bp = parseFloat($('#base_price').val()) || 0;
    var mbp = bp;
    var mlp = parseFloat(bp + mp);
    var tbp = mlp;
    var tlp = parseFloat(tbp + tp);
     
     
    $('.section_model_price_share .amount').html('$'+mbp.toFixed(2));
    $('.section_model_price_share .amount_total').html('$'+mlp.toFixed(2));

    $('.section_texture_price_share .amount').html('$'+tbp.toFixed(2));
    $('.section_texture_price_share .amount_total').html('$'+tlp.toFixed(2));
}
