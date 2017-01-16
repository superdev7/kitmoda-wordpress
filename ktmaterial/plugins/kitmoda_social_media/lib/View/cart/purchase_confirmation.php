<?php







?>







<div class="purchase_confirmation_main">
    <div class="cart_main_inner">
        
        <?php if($error) : ?>
        
        <div class="receipt_failed"><?=$error?></div>
        
        <?php else : ?>
        
        
        
            <div class="header">
                <div class="inner">
                    
                    <div class="heading_main">
                        <div class="heading">SUCCESSFUL KITMODA PURCHASE</div>
                        <div class="heading_info">Congratulations on these new additions to your asset collection!</div>
                    </div>
                    
                    <div class="rc_link"><a href="<?=ksm_get_permalink('community')?>">RETURN TO COMMUNITY</a></div>

                    <div class="clr"></div>


                    
                </div>
            </div>


            <div class="community_sidebar_linebreak_dark"></div>
            <div class="community_sidebar_linebreak"></div>


            <div class="download_info">
                <div class="heading">DOWNLOAD YOUR ASSETS</div>
                <div class="info">Download your new assets below.  Or, access them later within <span class="pl_link"><a href="<?=ksm_get_permalink('account/purchase_library/')?>">ACCOUNT > PURCHASE LIBRARY</a></span></div>
            </div>
            
            
            <?php 
            if( $items ) :
                foreach ( $items as $item ) : 
                    $this->render_element('purchased_item', array('pd' => $item));
                endforeach;
            endif;
            
            ?>
            
            
            
            <div class="final_purchase_details">
                
                <div class="heading">PURCHASE DETAILS</div>
                
                
                <div class="section_total">
                    <div>
                        <label>TOTAL</label>
                        <div class="val"><?=$ksm_payment->amount()?></div>
                        <div class="clr"></div>
                    </div>
                </div>
                
                <div class="section_purchaser">
                    
                    <div class="section_heading">PURCHASER</div>
                    <div>
                        <label>FULL NAME</label>
                        <div class="val name"><?=$user['first_name']?> <?=$user['last_name']?></div>
                        <div class="clr"></div>
                    </div>
                    <div>
                        <label>EMAIL</label>
                        <div class="val"><?=$user['email']?></div>
                        <div class="clr"></div>
                    </div>
                    <div>
                        <label>KITMODA USERNAME</label>
                        <div class="val"><?=$user_login?></div>
                        <div class="clr"></div>
                    </div>
                </div>
                
                
                <div class="section_purchaser" style="margin-top: 14px;">
                    <div class="section_heading">PAYMENT</div>
                    <div>
                        <label>METHOD</label>
                        <div class="val name"><?=$ksm_payment->method_label()?></div>
                        <div class="clr"></div>
                    </div>
                    <div>
                        <label>DATE</label>
                        <div class="val"><?=$ksm_payment->payment_date()?></div>
                        <div class="clr"></div>
                    </div>
                    <div>
                        <label>TIME</label>
                        <div class="val"><?=$ksm_payment->payment_time()?></div>
                        <div class="clr"></div>
                    </div>
                </div>
                
            </div>
            
            
            <div class="community_sidebar_linebreak_dark"></div>
            <div class="community_sidebar_linebreak"></div>
            
            <div class="infos">
                
                <div class="heading">BUILD YOUR COMMUNITY - RATE YOUR COLLECTION</div>
                
                <div>After downloading and viewing your new items, rate them to level up with awards.<br />
                Rate your models above or within... </div>
                
                <div class="pl_link"><a href="<?=ksm_get_permalink('account/purchase_library/')?>">ACCOUNT > PURCHASE LIBRARY</a></div>
                <div class="rc_link"><a href="<?=ksm_get_permalink('community')?>">RETURN TO COMMUNITY</a></div>
            </div>
            
            <div class="tc_note">By placing this order you are agreeing to Kitmoda’s Terms of Use and Copyright Policy.</div>
            
        <?php endif; ?>
        
        <div class="footer">


        </div>
    </div>
</div>