<div class="add_post">
    <div class="avatar">
        <img class="radius" src="<?=ksm_avatar($this->KUser->Auth->ID, 'avatar_small')?>" />
    </div>
    <div class="add_post_form radius">
        <iframe name="add_wall_post_frame" class="formframe"></iframe>
        <form method="post" action="<?=admin_url( 'admin-ajax.php' )?>" target="add_wall_post_frame">
            <input type="hidden" name="action" value="post_wall" />
            <input type="hidden" name="wall_id" value="<?=$user_ID?>" />
            <textarea placeholder="Add your thoughts here..." name="post_content"></textarea>
            <div class="buttons">
                <div class="post_img_btn"></div>
                
                <a href="" class="btn_add_wall_post btn btn_blue">POST</a>
                
                <?php include 'wall_images_uploader.php';?>
            </div><div class="clr"></div>
            <div class="error"></div>
        </form>
    </div><div class="clr"></div>
</div>
<hr class="after_add_post" />