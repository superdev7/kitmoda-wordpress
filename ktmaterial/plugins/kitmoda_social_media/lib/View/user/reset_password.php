<div class="window_inner" svinai="full_page_popup">
    <iframe name="user_login_frame" class="formframe"></iframe>
    <form method="post" action="<?=admin_url( 'admin-ajax.php' )?>" target="user_login_frame">
    <input type="hidden" name="action" value="User_submit_reset_password" />

    <input type="hidden" name="ara" value="<?=$ar_action?>" />
    
    <input type="hidden" name="key" value="<?=$key?>" />
    <input type="hidden" name="login" value="<?=$login?>" />

    <div class="win_header" hec="1">
        <div class="win_header_inner">
            <div class="title"></div>
            <a class="close"></a>
        </div>
    </div>

    <div class="content">

        <div class="heading">Reset Password!</div>

        <span class="error"></span>
        <div class="field">
            <label for="pass1">New Password</label>
            <div class="inputi"><input type="password" name="pass1" id="pass1" /></div>
            <div class="clr"></div>
        </div>

        <div class="field">
            <label for="pass2">Confirm Password</label>
            <div class="inputi"><input type="password" name="pass2" id="pass2" /></div>
            <div class="clr"></div>
        </div>

        


    </div>



    <div class="footer" hec="1">
        <div class="footer_inner">
            <a href="" class="btn redButton btn_form_smt">Reset</a>
        </div>
    </div>


    </form>
</div>