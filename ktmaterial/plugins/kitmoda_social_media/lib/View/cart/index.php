<div class="cart_main">
    <div class="cart_main_inner">
        <div class="header">
            <div class="inner">
                <div class="heading">REVIEW YOUR PURCHASE</div>
                
                <?php  if(!empty($cart_items)) : ?>
                <a class="btn_save_order" href="">SAVE ORDER</a>
                <?php endif; ?>
                <div class="clr"></div>
            </div>
            
        </div>


        <div class="community_sidebar_linebreak_dark"></div>
        <div class="community_sidebar_linebreak"></div>
        
        <?php if( $cart_items ) : ?>
            <ul class="edd-cart">
                <?php 
                foreach( $cart_items as $key => $item ) : 
                    $this->render_element('cart_item', array('item' => $item, 'key' => $key));
                endforeach; 
                ?>
            </ul>

            <div class="cart_total_bottom">
                <label>PURCHASE TOTAL</label>
                <div class="edd_subtotal"><span class="subtotal"><?=edd_currency_filter( edd_format_amount( edd_get_cart_subtotal() ) );?></span></div>
                <div class="clr"></div>
            </div>
        
            <div class="cart_item ksm_edd_checkout"><a href="<?=edd_get_checkout_uri()?>">Payment</a></div>
            <div class="clr"></div>
            
        <?php else : ?>
            <div class="cart_item_empty"><?=edd_empty_cart_message()?></div>
        <?php endif; ?>
        
            <div class="tc_note">By placing this order you are agreeing to Kitmoda’s Terms of Use and Copyright Policy.</div>
            

        <div class="footer">


        </div>
    </div>
</div>