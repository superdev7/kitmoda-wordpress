<div class="window_inner" svinai="full_page_popup">
    <iframe name="user_login_frame" class="formframe"></iframe>
    <form method="post" action="<?=admin_url( 'admin-ajax.php' )?>" target="user_login_frame">
    <input type="hidden" name="action" value="User_submit_forgot_password" />
    
    
    
    <div class="win_header" hec="1">
        <div class="win_header_inner">
            <div class="title"></div>
            <a class="close"></a>
        </div>
    </div>
    
    <div class="content">
        
        <div class="heading">Recover Password</div>
        
        <span class="error"></span>
        <div class="field">
            <label for="login_user">Email</label>
            <div class="inputi"><input type="text" name="email" id="email" /></div>
            <div class="clr"></div>
        </div>
        
        
        
        
    </div>
    
    
    
    <div class="footer" hec="1">
        <div class="footer_inner">
            

            <div class="links">
                <span class="join_link"><a class="colorbox" href="<?=ksm_get_permalink("join/{$ar_action}")?>">Join</a></span>
                <span class="login_link"><a class="colorbox" href="<?=ksm_get_permalink("login/{$ar_action}")?>">Login</a></span>
            </div>
            <a href="" class="btn redButton btn_form_smt">Recover</a>
            <div class="clr"></div>
        </div>
    </div>
    
    
    </form>
</div>