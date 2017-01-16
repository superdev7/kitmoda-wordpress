<?php


global $post;

	$id = is_array( $item ) ? $item['id'] : $item;

	$remove_url = edd_remove_item_url( $cart_key, $post, $ajax );
	$title      = get_the_title( $id );
	$options    = !empty( $item['options'] ) ? $item['options'] : array();
	$price      = edd_get_cart_item_price( $id, $options );

	if ( ! empty( $options ) ) {
		$title .= ( edd_has_variable_prices( $item['id'] ) ) ? ' <span class="edd-cart-item-separator">-</span> ' . edd_get_price_name( $id, $item['options'] ) : edd_get_price_name( $id, $item['options'] );
	}

	//ob_start();

	//edd_get_template_part( 'widget', 'cart-item' );

	//$item = ob_get_clean();

	//$item = str_replace( '{item_title}', $title, $item );
	//$item = str_replace( '{item_amount}', edd_currency_filter( edd_format_amount( $price ) ), $item );
	//$item = str_replace( '{cart_item_id}', absint( $cart_key ), $item );
	//$item = str_replace( '{item_id}', absint( $id ), $item );
	//$item = str_replace( '{remove_url}', $remove_url, $item );
  	//$subtotal = '';
  	//if ( $ajax ){
   	 //$subtotal = edd_currency_filter( edd_format_amount( edd_get_cart_subtotal() ) ) ;
  	//}
 	

	

        $product = KSM_Download::get($id);
        
        
        //pr($product)

?>








<li class="product post">
    <div class="thumb"><a href="<?=ksm_get_permalink("store/download/{$product->ID}")?>"><?=$product->the_thumb('purchase_lib_thumb')?></a></div>
    <div class="prod_info">
        
        <div>
            <div class="name"><a href="<?=ksm_get_permalink("store/download/{$product->ID}")?>"><?=$product->the_title()?></a></div>
            
            <div class="clr"></div>
        </div>
        
        
        
        <div class="clr"></div>
        
        
        
        <div class="tags">
            
            <div class="keywords">
                <span class="field_name">Category</span>
                <span class="rt_txt"><?=$product->get_tax_label('category', false)?></span>
                <div class="clr"></div>
            </div>
            <div class="keywords">
                <span class="field_name">Keywords</span>
                <span class="rt_txt"><?=$product->get_tax_label('keyword', false)?></span>
                <div class="clr"></div>
            </div>
            <div class="era">
                <span class="field_name">Era</span> 
                <span class="rt_txt"><?=$product->get_tax_label('era')?></span>
                <div class="clr"></div>
            </div>
            <div class="style">
                <span class="field_name">Style</span> 
                <span class="rt_txt"><?=$product->get_tax_label('style')?></span>
                <div class="clr"></div>
            </div>
            <div class="culture">
                <span class="field_name">Culture</span> 
                <span class="rt_txt"> <?=$product->get_tax_label('culture')?></span>
                <div class="clr"></div>
            </div>
            
        </div>
        
        
    </div>
    
    <div class="product_item_stats">
        
        <div class="price"><?=edd_currency_filter( edd_format_amount( $price ) )?></div>
        
        
        <div>
        <a class="btn_item_remove" href="<?=$remove_url?>" data-cart-item="<?=absint( $cart_key )?>" data-download-id="<?=absint( $id )?>" data-action="edd_remove_from_cart" class="edd-remove-from-cart"><?php _e( 'remove', 'edd' ); ?></a>
        </div>
        
        
    </div>
    <div class="clr"></div>
    
</li>