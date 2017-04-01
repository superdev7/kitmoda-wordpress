<div class="add_post add_the_post" ng-init="post_content_limit = <?=POST_CONTENT_MAX_LENGTH?>; post_content_focused = false">
    <div class="add_post_form_back_shadow">
        <div class="add_post_form_highlight_top">
            <div class="add_post_form_radius_top">
                <div class="add_post_form_highlight_studio_overlay_top">
                </div>
            </div>
        </div>
        <div class="add_post_form_highlight">
            <div class="add_post_form radius">
                <div class="add_post_form_highlight_studio_overlay">		<div style="margin-left: 0px;">
                   <iframe name="add_wall_post_frame" class="formframe"></iframe>			</div>
                   <form method="post" action="<?=admin_url( 'admin-ajax.php' )?>" target="add_wall_post_frame">
                    <input type="hidden" name="action" value="Studio_submit_post" />
                    <input type="hidden" name="_id" value="" />
                    <textarea id="blue_enter_text_area" ng-focus="post_content_focused=true" ng-blur="post_content_focused=false" data-k-check-focus="post_content_focused" placeholder="Add your thoughts here..." style="resize: none;" name="post_content" ng-model="post_content" k-character-limit="post_content_limit"></textarea>

                    <div class="characters_left" ng-style="{'visibility': post_content_focused?'visible':'hidden'}">{{post_content_limit - post_content.length}} characters left</div>

                    <div class="buttons">
                        <div class="post_img_btn">
                            <div class="post_img_btn_hover">
                            </div>
                        </div>
                

                        <div class="add_post_container">
                <a href="" class="btn_add_post btn <?=($auth_required ? '' : 'btn_form_smt')?>"></a>
                                        <div class="add_post">
                                        </div>
                                        <div class="add_post_hover">
                                        </div>                            
                                    
                        </div>
                        <span class="add_post_text">POST</span>
                




                <?php $this->render_element('the_post_image_uploader') ?>
            </div><div class="clr"></div>
                    <div class="error"></div>
                </form>
            </div>
        </div>
    </div>
    <div class="add_post_form_highlight_bottom">
        <div class="add_post_form_radius_bottom">
            <div class="add_post_form_highlight_studio_overlay_bottom">
            </div>
        </div>
    </div>
</div>





<div class="clr"></div>
</div>
