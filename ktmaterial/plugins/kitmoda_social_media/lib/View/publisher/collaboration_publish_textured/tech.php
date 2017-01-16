<div class="win_header" hec="1">
    <div class="title"><?=$step['title']?></div>
    <a class="close"></a>
</div>

<div class="content">
        
        <h1>Provide some tech info about your model...</h1>
        
        
        
        
        
        
        <div class="section">
            <h2>Rendering Information</h2>
            
            <div class="field_group field_group_renderer">
                <div class="field_title">What renderer was used for the featured image?</div>
                <?=KSM_Form::terms_radio('renderer'); ?>
            </div>
            
            
            <div class="field_group">
                <div class="field_title">Is the lighting setup included within the main file?</div>
                <?=KSM_Form::terms_radio('lighting'); ?>
            </div>
            
            
            
            <div class="field_group">
                <div class="field_title">Is HDR image based lighting used to illuminate the primary file?</div>
                <?=KSM_Form::terms_radio('hdr_lighting')?>
            </div>
            
            <div class="field_group">
                <div class="field_title">Is GI or Indirect Illumination used to illuminate the primary file?</div>
                <?=KSM_Form::terms_radio('indirect_illuminate')?>
            </div>
        </div>
        
        
        
        <div class="sectionBackgroundDark">
            <div class="section">
                <div class="sectionOverlay">
                    <h2>Shape Defining Image Maps</h2>
                    <div class="line2"></div>
                    <div class="field_group">
                        <div class="field_title">Does the model rely on normal maps or displacements to create form or detail?</div>
                        <?=KSM_Form::terms_radio('mapping')?>
                    </div>
                    <div class="field_group">
                        <div class="note">
                            Note: If normal maps or displacement maps are needed, modelers are responsible for rendering required maps for collaboration assets. Please include these image maps within your model upload.
                        </div>
                    </div>
                    <div class="field_group">
                        <div class="field_title">Is ambient occlusion baked into this model?</div>
                        <?=KSM_Form::terms_radio('ambient_occlusion_baked'); ?>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
        
        <div class="section">
            <h2>Texture Information</h2>
            
            <div class="field_group">
                <div class="field_title">How were the textures created?</div>
                <?=KSM_Form::terms_radio('texturing_method'); ?>
            </div>
            
            <div class="field_group">
                <div class="field_title">Unwrap Overlap</div>
                <?=KSM_Form::terms_radio('unwrap_overlap'); ?>
            </div>
            
            <div class="field_group">
                <div class="field_title">Select all image map types below that are included.</div>
                <div class="sub_group">
                    <div class="sub_group">STANDARD SHADER MAPS</div>
                    <?=KSM_Form::terms_checkbox('map_type', array('section' => 'standard')); ?>
                </div>
                <div class="sub_group">
                    <div class="sub_group">PHYSICALLY BASED RENDERING MAPS</div>
                    <?=KSM_Form::terms_checkbox('map_type', array('section' => 'physical')); ?>
                </div>
            </div>
            
            
            <div class="field_group">
                <div class="field_title">Are procedural textures used within the primary file?</div>
                <?=KSM_Form::terms_radio('procedural_texture'); ?>
            </div>
            
            
            
        </div>
        
    </div>
    
    <div class="footer" hec="1">
        <div style="float: right;">
            <div class="error"></div>
            <?php $this->render_element('loading'); ?>
            <a href="" class="btn btn_blue btn_step_next">Next</a>
            <div class="clr"></div>
        </div><div class="clr"></div>
    </div>
    