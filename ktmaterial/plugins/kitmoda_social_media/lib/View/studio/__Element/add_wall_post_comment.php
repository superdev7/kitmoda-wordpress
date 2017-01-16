<div class="add_comment_form_highlight">
    <div class="add_comment_form_radius">
        <div class="add_comment_form">
            <iframe class="formframe" name="add_wall_comment_frame_<?=$wp->ID?>"></iframe>
            <form method="post" action="<?=admin_url( 'admin-ajax.php' )?>" target="add_wall_comment_frame_<?=$wp->ID?>">
                <input type="hidden" name="action" value="Studio_submit_comment" />
                <input type="hidden" name="_id" value="<?=$wp->ID?>" />
                <textarea name="comment" style="resize: none;" placeholder="Add your comment here..."></textarea>

                <div class="buttons">
                    <div class="error"></div>
                    <a href="" class="btn btn_add_comment btn_blue">POST</a>
                </div>
            </form>
        </div><div class="clr"></div>
    </div>
</div>