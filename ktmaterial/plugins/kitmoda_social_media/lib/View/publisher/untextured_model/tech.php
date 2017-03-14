<div class="win_header" hec="1">
    <div class="title"><?=$step['title']?></div>
    <a class="close"></a>
</div>

<div class="content">
        
        <h1>Provide some tech info about your model...</h1>
        
        
        <div class="sectionBackgroundDark">
        <div class="section">		<div class="sectionOverlay">
            <h2>Model Information</h2>			 <div class="line2"></div>
            
            
            <div class="field_group">
                <div class="field_title">Modeling Method - <span class="subtitle_span">Select all that apply</span></div>
                <?=KSM_Form::terms_checkbox('modeling_method');?>
            </div>
            
            
            <div class="field_group">
                <div class="field_title">Entire Environment or Single Object</div>
                <?=KSM_Form::terms_radio('environment');?>
            </div>
            
            
            <div class="field_group field_group_file_format field_group_file_format_primary">
                <div class="field_title">Primary File Format - <span>Select one format</span></div>
                <?=KSM_Form::terms_radio('file_format', array('name'=> 'primary_file_format'))?>
            </div>
            
            <div class="field_group field_group_file_format field_group_file_format_others">
                <div class="field_title">Other Included Formats - <span>Select all that apply</span></div>
                <?=KSM_Form::terms_checkbox('file_format', array('name'=> 'other_file_formats'))?>
            </div>
            
            
            <div class="field_group">
                <div class="field_title">Polygon Count - Triangles</div>
                <input type="text" class="input poly_count" name="poly_count" placeholder="Enter polygon count..." />
            </div>
            
            
            
            
            <div class="field_group">
                <div class="field_title">Are the Objects Named and Organized</div>
                <?=KSM_Form::terms_radio('organization');?>
            </div>
            
            
            
            <div class="field_group">
                <div class="field_title">Does the model match real world scale?</div>
                <?=KSM_Form::terms_radio('world_scale');?>
            </div>
            
            
            
            <div class="field_group">
                <div class="field_title">Is the Model 3D print ready?</div>
                <?=KSM_Form::terms_radio('print_ready');?>
            </div>
            
            
            <div class="field_group">
                <div class="field_title">Is the model Game and Realtime Rendering Ready?</div>
                <?=KSM_Form::terms_radio('game_ready');?>
            </div>
            
            
            
            <div class="field_group">
                <div class="field_title">Does the model contain quadrangular polygons or triangulated polygons?</div>
                <?=KSM_Form::terms_radio('model_angular')?>
            </div>
            
            
            
        </div>		</div>		</div>
        
        <div class="sectionBackgroundDark">
        <div class="section">		<div class="sectionOverlay">
            <h2>Rendering Information</h2>			 <div class="line2"></div>
            
            <div class="field_group field_group_renderer">
                <div class="field_title">What renderer was used for the featured image?</div>
                <?=KSM_Form::terms_radio('renderer'); ?>
            </div>
            
            
            <div class="field_group">
                <div class="field_title">Is the lighting setup included within the main file?</div>
                <?=KSM_Form::terms_radio('lighting'); ?>
            </div>
            
            <div class="field_group field_group_ap_required">
                <div class="field_title">Are additional plugins required to render within the native file?</div>
                
                <div class="field">
                    <input type="radio" name="ap_required" id="ap_required_yes" value="yes">
                    <label for="ap_required_yes">Yes</label>
                    
                    <div class="additional_plugins_field">
                        <textarea class="input" name="additional_plugins" id="additional_plugins" placeholder="Enter required plugins or software as comma separated flags."></textarea>
                    </div>
                </div>
                
                <div class="field">
                    <input type="radio" name="ap_required" id="ap_required_no" value="no">
                    <label for="ap_required_no">No</label>
                </div>
                
            </div>
            
            <div class="field_group">
                <div class="field_title">Is HDR image based lighting used to illuminate the primary file?</div>
                <?=KSM_Form::terms_radio('hdr_lighting')?>
            </div>
            
            <div class="field_group">
                <div class="field_title">Is GI or Indirect Illumination used to illuminate the primary file?</div>
                <?=KSM_Form::terms_radio('indirect_illuminate')?>
            </div>
            
        </div></div></div>
        
        
        
        
        
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
                        <?=KSM_Form::terms_radio('ambient_occlusion_baked', array('section' => 'untextured')); ?>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
       <div class="sectionBackgroundDark"> 
        <div class="section">
        	<div class="sectionOverlay">
            <h2>UV Unwrap</h2>
            <div class="line2"></div>
            <div class="field_group field_group_is_unwrapped">
                <div class="field_title">Is the model Unwrapped?</div>
                <?=KSM_Form::terms_radio('unwrapped'); ?>
            </div>
            
            
            <div class="unwrap_fields">
            
                <div class="field_group">
                    <div class="field_title">Unwrap Overlap</div>
                    <?=KSM_Form::terms_radio('unwrap_overlap'); ?>
                </div>

                <div class="field_group">
                    <div class="field_title">Unwrap Stretching VS seams</div>
                    <?=KSM_Form::terms_radio('unwrap_stretching'); ?>
                </div>
            
            </div>
            
            
        </div>
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
    