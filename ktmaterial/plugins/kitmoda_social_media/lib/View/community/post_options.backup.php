<script type="text/javascript">
    $(function() {
        $("ul.list_images" ).sortable({
            connectWith: "ul.list_images",
            scroll : false,
            stop : function(e, ui) {
                if($('.drop_target .list_images li').length > 0) {
                    $('.drop_target .empty_note').hide();
                } else {
                    $('.drop_target .empty_note').show();
                }
                
                $('.list_images.all_images input').attr('name', 'kimg[]');
                $('.list_images.gallery_images input').attr('name', 'kgimg[]');
                
            }
        });
        
        
    });
    

</script>
<div class="window_inner">
    <iframe name="post_options_frame" class="formframe"></iframe>
    
    
    <form method="post" action="<?=admin_url( 'admin-ajax.php' )?>" target="post_options_frame">
    <input type="hidden" name="action" value="Community_submit_post_options" />
    <input type="hidden" name="_id" value="<?=$post->ID?>" />
    <div class="win_header" hec="1">
        <div class="title">Post Options</div>
        <a class="close"></a>
    </div>
    <div class="content">
        
        <h1>Control how your post is seen...</h1>
        
        
        <div class="line2"></div>
        
        <div class="left_side heading">POST TO</div>
        <div class="right_side heading c_topics_heading">TOPIC</div>
        <div class="clr"></div>
        
        <div class="line2"></div>
        
        
            
        
        <div style="padding-bottom: 36px;padding-top: 10px;">
            <div class="left_side">
                <div class="field"><input checked="checked" type="radio" class="post_to" name="post_to" value="2" id="post_to_2" /><label for="post_to_2">COMMUNITY + STUDIO</label></div>
                <div class="field"><input type="radio" class="post_to" name="post_to" value="1" id="post_to_1" /><label for="post_to_1">ONLY COMMUNITY</label></div>
            </div>
            <div class="right_side c_topics">
                <div class="field"><input checked="checked" type="radio" name="topic" value="general" id="topic_general" /><label for="topic_general">GENERAL</label></div>
                <div class="field"><input type="radio" name="topic" value="challenge" id="topic_challenge" /><label for="topic_challenge">CHALLENGE</label></div>
                <div class="field"><input type="radio" name="topic" value="model" id="topic_model" /><label for="topic_model">MODELING</label></div>
                <div class="field"><input type="radio" name="topic" value="concept" id="topic_concept" /><label for="topic_concept">CONCEPT ART</label></div>
                <div class="field"><input type="radio" name="topic" value="texture" id="topic_texture" /><label for="topic_texture">TEXTURE</label></div>
                <div class="field"><input type="radio" name="topic" value="question" id="topic_question" /><label for="topic_question">QUESTIONS</label></div>

            </div>
            <div class="clr"></div>
        
        </div>
        
        <?php if($attachments) : ?>
        
        <div class="gallery_section">
            <div class="line2"></div>

            <div class="left_side heading">ADD ANY OF THESE IMAGES TO GALLERIES?</div>
            <div class="right_side heading">ADD IMAGES TO GALLERIES AS...</div>
            <div class="clr"></div>
            <div class="line2"></div>
        
        
        
        
            <div class="left_side">
                <div class="drop_target">
                    <div class="empty_note">DRAG AND DROP IMAGES FROM BELLOW</div>
                    <ul class="list_images gallery_images"></ul>
                </div>
            </div>
            <div class="right_side" style="padding-top: 8px;">
                <div class="field"><input type="radio" checked="checked" name="gallery" value="wip" id="gallery_wip" /><label for="gallery_wip">WORK IN PROGRESS</label></div>
                <div class="field"><input type="radio" name="gallery" value="finished" id="gallery_finished" /><label for="gallery_finished">FINISHED ART</label></div>
            </div>
            <div class="clr"></div>
        
            <div class="line2"></div>

            <div class="left_side" style="height: 55px;">
                <ul class="list_images all_images">
                    <?php foreach ((Array) $attachments as $att) :?>
                    <li>
                        <img src="<?= get_image_src($att->ID, 'avatar_tiny') ?>" />
                        <input type="hidden" name="kimg[]" value="<?=$att->ID?>" />
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>
        
    </div>
    
    <div class="footer" hec="1" align="right">
        <div style="float: right;">
            <div class="error"></div>
            <?php $this->render_element('loading'); ?>
            <a href="" class="btn btn_blue btn_form_smt">GO</a>
            <div class="clr"></div>
        </div><div class="clr"></div>
    </div>
    
    
    
    </form>
</div>