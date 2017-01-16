<div id="tab_share_facebook" style="padding: 0 10px;" class="tab">
    <iframe name="facebook_share_iframe" class="formframe"></iframe>
    <form method="post" target="facebook_share_iframe" action="<?=admin_url( 'admin-ajax.php' )?>">
        <input type="hidden" name="id" value="<?=$params['id']?>" />
        <input type="hidden" name="action" value="sharefb" />
        <div class="field" style="margin-bottom: 10px">
            <textarea name="facebook_comment" id="facebook_comment" placeholder="Enter your comment"></textarea>
        </div>
        <br />
        <?php if($params['picture']) :?>
        
        <div style="float: left;margin-right: 10px;">
            <img src="<?=$params['picture']?>" width="100">
        </div>
        <?php endif; ?>
        
        <div>
            <div class="caption"><?=$params['caption']?></div>
            <div class="link"><?=$params['link']?></div>
            <div class="description"><?=(strlen($params['description']) > 200 ? substr($params['description'], 0, 200).'...' : $params['description'])?></div>
        </div>
        <div class="clr"></div>


        <div style="position: absolute; bottom: 10px;width : 96%;">
            <a href="" class="btn btn_blue btn_share_facebook btn_form_smt">Post</a>
            <div class="form_loading"></div>
        </div>
    </form>
</div>