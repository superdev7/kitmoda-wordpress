<div class="add_post add_the_post">
    
    <div class="add_post_form radius cmiu_message_form">
        <iframe name="add_wall_post_frame" class="formframe"></iframe>
        <form method="post" action="<?=admin_url( 'admin-ajax.php' )?>" target="add_wall_post_frame">
            <input type="hidden" name="action" value="CollaborationActive_send_message" />
            <input type="hidden" name="_id" value="<?=$current_project->ID?>" />
            <textarea placeholder="Add your thoughts here..." name="post_content"></textarea>
            <div class="buttons">
                <div class="post_img_btn"></div>
                
                <a href="" class="btn_blue btn btn_form_smt">Message Partner</a>
                
                <?php KSM_Uploader::build_uploader('cmiu');?>

                <div class="miu_container" align="center">
                    <ul class="items">
                        <li class="clr"></li>
                    </ul>
                    <div style="clear: both"></div>
                </div>
                
                
            </div><div class="clr"></div>
            <div class="error"></div>
        </form>
    </div><div class="clr"></div>
</div>