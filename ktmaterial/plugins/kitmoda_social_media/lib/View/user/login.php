
<div class="down-header-bordr">
<div class="back-sharder">
<div class="back-sharder_overlay_noshadow">
<div class="window_inner" svinai="full_page_popup">
    
    
    <script type="text/javascript">
    
    $(function() {
        $('.terms_link a').click(function(e) {
        e.preventDefault();
        
        var h = $('form').outerHeight();
        
        $('.term_step [hec=1]').each(function() {
            h = h - $(this).outerHeight();
        });
        $('.term_step .content').css({height:h+'px'});
        $('.term_step').show();
    });
    
    $('.term_step .back_btn').click(function(e) {
        e.preventDefault();
        $('.term_step').hide();
    });
    })
    
    </script>
    
    <iframe name="user_login_frame" class="formframe"></iframe>
    <form method="post" action="<?=admin_url( 'admin-ajax.php' )?>" target="user_login_frame">
    <input type="hidden" name="action" value="User_submit_login" />
    
    <input type="hidden" name="ara" value="<?=$ar_action?>" />
    
    <!-- <div class="win_header" hec="1">
        <div class="win_header_inner">
            <div class="title"></div>
            <a class="close"></a>
        </div>
    </div> -->
    
    <div class="join_content_container_top"></div>
    <div class="content">

        <div class="dragon-animation">
            <div style="position: absolute; left: 85px; height: 107px; width: 91px; top: 5px;">
                            
                <img id="leftwingflap" src="/ktmaterial/plugins/kitmoda_social_media/images/dragon_leftwing.png" alt="bulb">
                            
            </div>
            <div style="position: absolute; top: 38px; left: 149px; height: 116px;  width: 43px;">
                            
                <img src="/ktmaterial/plugins/kitmoda_social_media/images/dragon_body.png" alt="bulb">
                            
            </div>
            <div style="position: absolute; top: -6px;  left: 162px; height:121px; width: 111px;">
                            
                <img id="rightwingflap" src="/ktmaterial/plugins/kitmoda_social_media/images/dragon_rightwing.png">
                            
            </div>
        </div>
        
        <div class="heading">Kitmoda Login<br />
        <div class="under-heading-sec"><span class="join_link">Not a member?<a class="colorbox" href="<?=ksm_get_permalink("join/{$ar_action}")?>">Join Kitmoda</a></span></div></div>

        <?php if($error) : ?>
        <span class="error" style="display: inline;"><?=$error?></span>
        <?php else: ?>
        <span class="error"></span>
        <?php endif; ?>
        
        
        <?php if($success) : ?>
            <span class="success" style="display: inline;"><?=$success?></span>
        <?php endif; ?>
        
        
        
        
        <div class="field">
            <label for="login_user">Email</label>
            <div class="inputi"><input type="text" name="user" id="login_user" /></div>
            <div class="clr"></div>
        </div>
        
        <div class="field">
            <label for="login_pass">Password</label>
            <div class="inputi"><input type="password" name="pass" id="login_pass" /></div>
            <div class="clr"></div>
        </div>
        
            <span class="forgot_pass_link"><a ng-click="forgot_password()">Forgot Password</a></span>
        
        
        
    </div>
    
    
    
    <div class="footer" hec="1">
        <div class="footer_inner">
            <div class="info">By joining and participating on Kitmoda.com you are agreeing to these terms of service...</div>

            <div style="margin-top : 3px;">
                
                <span class="terms_link"><a href="">Terms of Service</a></span>
            </div>
            <a href="" class="btn redButton btn_form_smt">Login
            <span class="join-redButton-hover"></span></a>
        </div>
    </div>
    
    
    </form>
    
    
    
    
    <?php
    
    if($this->elementExists('terms')) {
        echo "<div class=\"term_step\">";
        $this->render_element('terms', array());
        echo '</div>';
    }
           
    ?>
    
    
    
</div>
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>