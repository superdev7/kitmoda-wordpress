<script type="text/javascript">
    
    
    
    
    
    
    $(function() {
        
        $("select").not('.noselectbox').selectbox();
	//$(".sbOptions").mCustomScrollbar();
        
        
        
        $('.toggle').not('.notoggle').each(function() {
            var state_val = $(this).closest('.field').find('input').val();
            $(this).toggles({
                text: {
                    on: 'YES',
                    off: 'NO'
                },
                width : 60,
                drag : false,
                on : (state_val == 'yes' ? true : false)
            });
            m_resize();
        });
        
        $('body').delegate('.toggle', 'toggle', function(e, active) {
            var atg_val = active ? 'yes' : 'no';
            $(this).closest('.action_add_to_gallery').find('input').val(atg_val);
        });
        
        
        $('.section.section_images').on('onItemAdded', function(e, ele_id) {
            var ele = $(this).find('#'+ele_id);
            $(ele).find('select').selectbox();
            
            $(ele).find('.toggle').removeClass('notoggle').toggles({
                text: {
                    on: 'YES',
                    off: 'NO'
                },
                width : 60,
                drag : false,
                on : true
            });
            m_resize();
        });
        
        
        $('.section.section_images').on('onItemRemove', function(e, ele_id) {
            m_resize();
        });

        $("ul.list_images" ).sortable({
            //connectWith: "ul.list_images",
            scroll : false,
            placeholder  : 'sortable-placeholder'
            //start : function(e, ui) {
            //    $(ui.item).find('.line2').hide();
            //},
            //stop : function(e, ui) {
            //    $(ui.item).find('.line2').show();
            //}
        });
        
        $('.list_images li.image_item').each(function() {
            var tog = $(this).find('.action_add_to_gallery .toggle').data('toggles');
            var atg_val = tog.active ? 'yes' : 'no';
            $(this).find('.action_add_to_gallery input').val(atg_val);
        });
        
        
    });
</script>


<?php 

if($is_edit) : 
KSM_Uploader::build_uploader('postiu2');
endif;
?>

<div class="window_inner">
    <iframe name="post_options_frame" class="formframe"></iframe>
    
    
    <form method="post" action="<?=admin_url( 'admin-ajax.php' )?>" target="post_options_frame">
    <input type="hidden" name="action" value="<?=$submit_action?>" />
    <input type="hidden" name="_id" value="<?=$post->ID?>" />
    <div class="win_header" hec="1">
        <div class="title">Post Options</div>
        <a class="close"></a>
    </div>
    <div class="content">
        
        <h1>Control how your post is seen...</h1>
        
        
        
        <div class="sectionBackgroundDark">
            <div class="section section_post_options">
                <div class="sectionOverlay">
                    <div class="section_header">
                        <h2>LET'S HELP PEOPLE FIND YOUR POST</h2>
                        <div class="line2"></div>
                    </div>
                    <div class="fields">
                        <div class="field_group field_group_title">
                            <input type="text" name="post_title" class="input" value="<?=$post->post_title?>" placeholder="Post title..." />
                        </div>
                        
                        
                        <?php if($is_edit) : ?>
                        <div class="field_group field_group_title">
                            <textarea class="cbarele" placeholder="Add your thoughts here..." style="resize: none; overflow: hidden; word-wrap: break-word; height: 72px;" name="post_content"><?=$post->post_content?></textarea>
                        </div>
                        <?php endif; ?>
                        
                        
                        
                        <div class="clr"></div>
                        
                        <div class="field_group field_group_topic">
                            <div class="field_title">TOPIC</div>
                            <?=KSM_Form::terms_radio('topic', array('value' => $post_topic, 'section' => 'topic', 'label' => 'post_option_label')); ?>
                        </div>
                        <div class="field_group field_group_show_within">
                            <div class="field_title">SHOW WITHIN</div>
                            <?=KSM_Form::radio($post_at_options, $post_at_settings);?>
                        </div>
                        <div class="field_group field_group_progress">
                            <div class="field_title">PROGRESS <span>(optional)</span></div>
                            
                            <?=KSM_Form::terms_radio('topic', array('value' => $post_progress, 'name' => 'progress', 'prepend' => array('' => 'Unspecified') , 'section' => 'progress',  'label' => 'post_option_label')); ?>
                        </div>
                        <div class="clr"></div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
        <div class="sectionBackgroundDark">
            <div class="section section_images">
                <div class="sectionOverlay">
                    <div class="section_header">
                        
                        <div style="float : left;">
                            <h2>EDIT YOUR IMAGE CONTENT</h2>
                            <div class="section_note">(Describing images helps users find them)</div>
                        </div>
                        
                        <?php if($is_edit) :  ?>
                            <div class="browse_btn"></div>
                        <?php endif; ?>
                        
                        <div class="clr"></div>
                        
                        <div class="line2"></div>
                    </div>
        
        
        
        <div class="gallery_section">
            
        
        <ul class="list_images items">
            <?php foreach ((Array) $attachments as $att) :
                
                $img_topic = $is_edit ? ksm_get_ds_post_term_names($att->ID, 'topic', 'topic', true) : 'general';
                $img_topic = $img_topic ? $img_topic : 'general';
        
                $img_progress = $is_edit ? ksm_get_ds_post_term_names($att->ID, 'topic', 'progress', true) : '';
                
                $img_add_in_gallery = $is_edit ? $att->add_in_gallery : 'yes';
                
            ?>
            <li rel="<?=$att->ID?>" id="img_att_<?=$att->ID?>" class="image_item item">
                <input type="hidden" class="uid" name="kimg[id][]" value="<?=$att->ID?>" />
                
                <div class="preview">
                    <div class="img thumbnail">
                        <img src="<?=get_image_src($att->ID, 'post_option') ?>" />
                    </div>
                </div>
                
                
                <div class="fields">
                    <div class="field field_image_name">
                        <label>NAME IMAGE</label>
                        <input type="text" name="kimg[name][]" value="<?=$att->post_title?>" class="input" />
                    </div>
                    
                    <div>
                        <div class="field field_topic">
                            <label>TOPIC</label>
                            <?=KSM_Form::terms_dropdown('topic', array(
                                'section' => 'topic', 
                                'label' => 'post_option_label', 
                                'name' => 'kimg[topic][]',
                                'id' => '',
                                'value' => $img_topic
                                )); ?>
                        </div>
                        <div class="field field_progress">
                            <label>PROGRESS</label>
                            <?=KSM_Form::terms_dropdown('topic', array(
                                'section' => 'progress', 
                                'label' => 'short_label', 
                                'none_text' => 'Unspecified', 
                                'name' => 'kimg[progress][]',
                                'id' => '',
                                'value' => $img_progress
                                )); ?>
                        </div>
                        <div class="clr"></div>
                    </div>
                    
                </div>
                
                
                <div class="actions">
                    <a href="" class="action_remove remove">REMOVE</a>
                    <div class="clr"></div>
                    <div class="action_add_to_gallery">
                        <label>ADD TO GALLERIES</label>
                        <div class="field" align="center">
                            <div class="toggle toggle-iphone"></div>
                            <input type="hidden" name="kimg[add_in_gallery][]" value="<?=$img_add_in_gallery?>" />
                        </div>
                    </div>
                </div>
                
                <div class="clr"></div>
                <div class="line2"></div>
            </li>
            <?php endforeach; ?>
            
            <li class="clr items_clr"></li>
        </ul>
            
        <div class="images_empty">Upload Images</div>
        </div>
        
                
        </div></div></div>
        
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
    
    <div id="poiu_item" class="ksm_temp">
        <li id="{filekey}" class="image_item item">
            <input type="hidden" class="uid" name="kimg[id][]" value="" />
            <div class="preview">
                <div class="percent"></div>
                <div class="progress"><div class="bar"></div></div>
                <div class="img thumbnail"></div>
            </div>
            <div class="fields">
                <div class="field field_image_name">
                    <label>NAME IMAGE</label>
                    <input type="text" name="kimg[name][]" value="{name}" class="input" />
                </div>
                <div>
                    <div class="field field_topic">
                        <label>TOPIC</label>
                        <?=KSM_Form::terms_dropdown('topic', array(
                            'section' => 'topic', 
                            'label' => 'post_option_label', 
                            'name' => 'kimg[topic][]',
                            'class' => 'noselectbox',
                            'id' => ''
                            )); ?>
                    </div>
                    <div class="field field_progress">
                        <label>PROGRESS</label>
                        <?=KSM_Form::terms_dropdown('topic', array(
                            'section' => 'progress', 
                            'label' => 'short_label', 
                            'none_text' => 'Unspecified', 
                            'name' => 'kimg[progress][]',
                            'class' => 'noselectbox',
                            'id' => ''
                            )); ?>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
                
                
            <div class="actions">
                <a href="" class="action_remove remove">REMOVE</a>
                <div class="clr"></div>
                <div class="action_add_to_gallery">
                    <label>ADD TO GALLERIES</label>
                    <div class="field" align="center">
                        <div class="toggle notoggle toggle-iphone"></div>
                        <input type="hidden" name="kimg[add_in_gallery][]" value="yes" />
                    </div>
                </div>
            </div>
            <div class="clr"></div>
            <div class="line2"></div>
        </li>
        
        
    </div>
</div>