<?php
$auth_required = get_current_user_id() ? false : true;


?>
<div class="add_post add_the_post" ng-init="post_content_limit = <?=POST_COMMUNITY_MAX_LENGTH?>; post_content_focused = false">
    
        <div class="add_post_form radius">
            <div class="add_post_form_highlight_community_overlay">
                <iframe name="add_wall_post_frame" class="formframe"></iframe>
                
                <form method="post" action="<?=admin_url( 'admin-ajax.php' )?>" target="add_wall_post_frame">
                    <input type="hidden" name="action" value="Community_submit_post" />
                    <input type="hidden" name="_id" value="" />
                    
                    
                    <textarea ng-focus="post_content_focused=true" ng-blur="post_content_focused=false" data-k-check-focus="post_content_focused" <?=($auth_required ? 'atrqt="community_add_post" ' : '')?>placeholder="Add your thoughts here..." name="post_content" ng-model="post_content" k-character-limit="post_content_limit" style="resize: none;"></textarea>
                    <div class="characters_left" ng-style="{'visibility': post_content_focused?'visible':'hidden'}">{{post_content_limit - post_content.length}} characters left</div>
                    <div class="buttons">
                        <div class="post_img_btn" <?=($auth_required ? 'atrqt=community_add_post' : '')?>></div>
                        <a href="" <?=($auth_required ? 'atrqt="community_add_post" ' : '')?>class="btn_add_post btn <?=($auth_required ? '' : 'btn_form_smt')?>"></a>
                        <?php $this->render_element('the_post_image_uploader') ?>
                    </div>
                    <div class="clr"></div>
                    <div class="error"></div>
                </form>
                    
                
                
                
            </div>
        </div>
    
    <div class="clr"></div>
</div>
<div class="after_add_post_line">
    <div class="after_add_post_line_overlay"></div>
</div>