<div id="tab_share_email" style="padding: 0 10px;" class="tab">
    <iframe name="email_share_iframe" class="formframe"></iframe>
    <form method="post" target="email_share_iframe" action="<?=admin_url( 'admin-ajax.php' )?>">
        <input type="hidden" name="id" value="<?=$params['id']?>" />
        <input type="hidden" name="action" value="share_email" />
        <div class="field">
            <label>From your email address</label>
            <input type="text" name="email_from" id="email_from" class="input">
        </div>

        <div class="field">
            <label>To email address</label>
            <input type="text" name="email_to" id="email_to" class="input">
        </div>
        
        <div class="field">
            <label>Subject</label>
            <input type="text" name="email_subject" id="email_subject" value="<?=$params['email_subject']?>" class="input" />
        </div>

        <div class="field">
            <label>Message</label>
            <textarea name="email_message" id="email_message"><?=$params['email_message']?></textarea>
        </div>
        <div style="position: absolute; bottom: 10px;width : 96%;">
            <a href="" class="btn btn_blue btn_share_email btn_form_smt" style="float: left;">Share</a>
            <div class="error" style="float: right;margin-right: 45px;"></div>
            <div class="form_loading"></div>
        </div>
    </form>
</div>