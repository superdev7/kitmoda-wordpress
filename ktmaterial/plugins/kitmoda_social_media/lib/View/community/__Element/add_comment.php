<?php if($post && get_current_user_id()) : ?>
<div class="add_comment">
    <div class="add_post_form_back_shadow">
        <div class="add_post_form_highlight_top">	
                <div class="add_post_form_radius_top">
                    <div class="add_post_form_highlight_studio_overlay_top_community">
                    </div>
                </div>
        </div>
    <div class="add_comment_form">
        <iframe class="formframe" name="add_comment_frame_<?=$post->ID?>"></iframe>
        <form method="post" action="<?=admin_url( 'admin-ajax.php' )?>" target="add_comment_frame_<?=$post->ID?>">
            <input type="hidden" name="action" value="Community_submit_comment" />
            <input type="hidden" name="_id" value="<?=$post->ID?>" />			<div class="expandingbox">
                <textarea name="comment" style="resize: none;" placeholder="Add your comment here..."></textarea>			</div>
                <div class="buttons_highlight_community">
		<div class="error"></div>
                <div class="buttons">
		   <div class="buttons_overlay">
			<a href="" class="btn_add_comment">POST</a>
			<div class="clr"></div>
                    </div>  
                </div>
            </div>
        </form>
    </div><div class="clr"></div>
</div>
</div>
<?php endif; ?>