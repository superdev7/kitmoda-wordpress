<div class="window_inner">
    
    
    <div class="win_header" hec="1">
        <div class="title">Rate Model</div>
        <a class="close"></a>
    </div>
    
    
    
    <iframe name="form_frame" class="formframe"></iframe>
    <form method="post" target="form_frame" action="<?=admin_url( 'admin-ajax.php' )?>">

    <input type="hidden" id="form_id" name="form_id" value="<?=$form->get_action_id()?>" />
    <input type="hidden" name="action" value="Account_submit_model_rate" />
    <div class="content">
        
        <h1>Customize your experience...</h1>
        
        <?php foreach((Array) $form->sections as $section) : ?>
            <div class="sectionBackgroundDark">
                <div class="section">
                    <div class="sectionOverlay">
                        <h2><?=$section['title']?></h2>
                        <?php 
                        foreach((Array) $section['fields'] as $f) :
                            $field = $form->get_field($f);
                            ?>
                            <div class="field_group">
                                <div class="field_title"><?=$field->label?></div>
                                <div class="field"><?=$field->field()?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
        
    </div>
    <div class="footer form_footer" hec="1">
        <?php $this->render_element('loading'); ?>
        <a href="" class="btn btn_blue btn_form_smt">Rate</a>
        <div class="error"></div>
    </div>
    
    
    
    
    
    
    </form>
</div>