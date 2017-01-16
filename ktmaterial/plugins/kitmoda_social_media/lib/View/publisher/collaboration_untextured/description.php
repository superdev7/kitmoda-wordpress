<div class="win_header" hec="1">
    <div class="title"><?=$step['title']?></div>
    <a class="close"></a>
</div>

<div class="content">    
    
    
    
    
        
    <h1 style="margin-bottom: 34px;">Awesome!  Now let’s describe and price your model.</h1>
        
        
        <div class="line2"></div>
        <div class="section">
            <h2>Title</h2>
            <div class="field_group">
                <div class="field">
                    <input type="text" name="title" class="input" placeholder="Enter your title here..." />
                    
                </div>
            </div>
        </div>
        
        
        <div class="section">
            <h2>Description</h2>
            
            <div class="field_group">
                <div class="field">
                    <textarea class="input" name="description" placeholder="Describe what your concept is without tech specs here..."></textarea>
                </div>
            </div>
        </div>
        
        
        <div class="section">
            <h2>Keywords</h2>
            
            <div class="field_group">
                <div class="field">
                    <textarea class="input" name="keywords" id="pub_keywords" placeholder="Enter up to 10 keywords here..."></textarea>
                </div>
            </div>
        </div>
        
        
        <div class="section">
            <h2>Category</h2>
            
            <div class="field_group">
                
                <div class="kcat">
                    <?=KSM_Taxonomy::dropdown(array('label'=>'Main Category', 'orderby' => 'name', 'order' => 'ASC'));?>
                </div>
            </div>
        </div>
        
        
        <div class="section section_design">
            <h2>Design</h2>
            
            <div class="field_group field_group_concept_created">
                
                <label class="field_title">Did you create custom concept art in the form of sketches, paintings, or concept models to build this model?</label>
                <div class="field">
                    <input type="radio" id="concept_created_yes" value="yes" name="concept_created">
                    <label for="concept_created_yes">Yes</label>
                </div>
                
                <div class="field">
                    <input type="radio" id="concept_created_no" value="no" name="concept_created">
                    <label for="concept_created_no">No</label>
                </div>
                
                
            </div>
        </div>
        
        
        <div class="section section_style">
            <h2>Style</h2>
            
            <div class="field_group">
                <label>Style</label>
                <?=KSM_Taxonomy::dropdown(array('tax'=>'style'), 'label');?>
                <div class="clr"></div>
            </div>
            
            <div class="field_group">
                <label>Era</label>
                <?=KSM_Taxonomy::dropdown(array('tax'=>'era'), 'label');?>
                <div class="clr"></div>
            </div>
            
            <div class="field_group">
                <label>Culture</label>
                <?=KSM_Taxonomy::dropdown(array('tax'=>'culture'), 'label');?>
                <div class="clr"></div>
            </div>
        </div>
        
        
        
        
        
        <div class="section section_pricing">
            <h2>Pricing (Modeler Share)</h2>
            
            <div class="field_group">
                
                <div class="field">
                    <label>Your Price Share Per Sale $USD</label>
                    <input type="text" class="input" name="price_share" />
                    <div class="clr"></div>
                </div>
            </div>
            
            <div class="field_group">
            <div class="note">
                
                This is the amount of “Price Share” per sale on the Kitmoda store that a texture artist and subsequent
artists will have to share with you for sales of this asset.  Also this is the price that the model will be
entered into the store for as an untextured asset prior to a texture artist possibly applying to texture the 
model.  If this value is too high it could discourage texture artists from applying to the project. <br />
Kitmoda pays the modeler 80% of this “Price Share” value per sale of the resulting asset as commisions.      
                
            </div>
            </div>
        </div>
        
        
</div>        
    
<div class="footer" hec="1">
    
    <div style="text-align: center;margin-top:18px;">
        <a class="terms_link" href="">Model submission terms</a>
    </div>
    
    <div style="float: left;width: 500px; margin-top: 5px;">
        <label for="terms_agreed">I have fully read and understand these terms.</label>
        <input type="checkbox" name="terms_agreed" id="terms_agreed" value="yes" />
        <div class="clr"></div>
    </div>
    
    <div class="loading_error">
        <div class="error"></div>
        <?php $this->render_element('loading'); ?>
    </div>
    
    
    <div style="float: right;">
        <a href="" class="btn btn_blue btn_step_next">Next</a>
        <div class="clr"></div>
    </div><div class="clr"></div>
</div>
