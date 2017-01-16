<div class="window_inner">
    
    <iframe name="post_delete_frame" class="formframe"></iframe>
    
    
    <form method="post" action="<?=admin_url( 'admin-ajax.php' )?>" target="post_delete_frame">
        <input type="hidden" name="action" value="Studio_submit_delete_post" />
        <input type="hidden" name="_id" value="<?=$post->ID?>" />
        <div class="win_header" hec="1">
            <div class="title"></div>
            <a class="close"></a>
        </div>
        <div class="content">
            <div class="confirm_msg">Are you sure you would like to delete this post?</div>
        </div>

        <div class="footer" hec="1" align="right">
            
            <?php if($post->have_gallery_images()) : ?>
            <div class="field">
                <input id="delete_images" type="checkbox" name="delete_images" value="yes" />
                <label for="delete_images">Also delete post images from galleries</label>
                <div class="clr"></div>
            </div>
             <?php endif; ?>
                    
            <div style="float: right;">
                <div class="error"></div>
                <?php $this->render_element('loading'); ?>
                
                <a href="" class="btn_cancel win_close btn btn_blue">CANCEL</a>
                <a href="" class="btn btn_blue btn_form_smt">DELETE</a>
                <div class="clr"></div>
            </div><div class="clr"></div>
        </div>
    </form>
    
    
</div>