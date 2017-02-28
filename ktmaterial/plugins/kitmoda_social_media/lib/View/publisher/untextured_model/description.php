<div class="win_header" hec="1">
    <div class="title"><?=$step['title']?></div>
    <a class="close"></a>
</div>

<div class="content">    
    
    
    
    
        
    <h1 style="margin-bottom: 34px;">Awesome!  Now let&rsquo;s describe and price your model.</h1>
        
        
        <div class="line2"></div>
		<div class="sectionBackgroundDark">
        <div class="section">
				<div class="sectionOverlay">
            <h2>Title</h2>
            <div class="field_group">
                <div class="field">
							<input type="text" name="title" class="inputdark" placeholder="Enter your title here..." />
                    
                </div>
            </div>
        </div>
			</div>
        </div>
        
        <div class="sectionBackgroundDark">
        <div class="section">
			<div class="sectionOverlay">
            <h2>Description</h2>
            
            <div class="field_group">
                <div class="field">
                    <textarea class="input" name="description" placeholder="Describe what your concept is without tech specs here..."></textarea>
                </div>
            </div>
        </div>
        </div>
		</div>
        
        <div class="sectionBackgroundDark">
        <div class="section">
			<div class="sectionOverlay">
            <h2>Keywords</h2>
            
            <div class="field_group">
                <div class="field">
						<textarea class="input_greytext" name="keywords" id="pub_keywords" placeholder="EnterZ up to 10 keywords here..."></textarea>
                </div>
            </div>
        </div>
        </div>
        </div>
        
		<div class="sectionBackgroundDark">
        <div class="section">
				<div class="sectionOverlay">
            <h2>Category</h2>
					<div class="line2"></div>
            
            <div class="field_group">
                
						<div class="kcat" style="margin-bottom: 25px;">
						
                    <?=KSM_Taxonomy::dropdown(array('label'=>'Main Category', 'orderby' => 'term_id', 'order' => 'ASC', 'exclude' => 'uncategorized'));?>
                </div>
                
                
                
            </div>
        </div>
			</div>
		</div>
        
        <div class="sectionBackgroundDark">
        
        <div class="section section_design">
				<div class="sectionOverlay">
            <h2>Design</h2>
            
					<div class="line2"></div>
					
            <div class="field_group field_group_concept_created">
                
						<p class="publisher_question">Did you create custom concept art in the form of sketches, paintings, or concept models to build this model?</p>
                <div class="field">
                    <input type="radio" id="concept_created_yes" value="yes" name="concept_created">
							<label for="concept_created_yes" class="publisher_answer">Yes</label>
                </div>
                
                <div class="field">
                    <input type="radio" id="concept_created_no" value="no" name="concept_created">
							<label for="concept_created_no" class="publisher_answer">No</label>
                </div>
                
                
            </div>
        </div>
				</div>
		</div>
        
        <div class="sectionBackgroundDark">
        <div class="section section_style">
		<div class="sectionOverlay">
            <h2>Style</h2>
            <div class="line2"></div>
            <div class="field_group">
                <label class="publisher_dropdown_label">STYLE</label>
            
                <?=KSM_Taxonomy::dropdown(array('tax'=>'style'), 'label');?>
                <div class="clr"></div>
            </div>
            
            <div class="field_group">
                <label class="publisher_dropdown_label">ERA</label>
                <?=KSM_Taxonomy::dropdown(array('tax'=>'era'), 'label');?>
                <div class="clr"></div>
            </div>
            
            <div class="field_group">
                <label class="publisher_dropdown_label">CULTURE</label>
                <?=KSM_Taxonomy::dropdown(array('tax'=>'culture'), 'label');?>
                <div class="clr"></div>
            </div>
        </div>
           </div>
        </div>
        
        
         <div class="sectionBackgroundDark">
        <div class="section section_collab_invite">
		<div class="sectionOverlay">
            <h2>Collaboration</h2>
        
			<div class="line2"></div>
        
            
            
            <div class="field_group">
			<div>
			<p class="publisher_question">
			Allow Collaboration Invites for this Model?
			</p>
			</div>
                
                
                <div class="field field_invyes" style="margin-bottom: 0px !important;">
                    <input checked="checked" type="radio" name="allow_invites" value="yes" id="allow_invites_yes" />
                    <label for="allow_invites_yes" class="publisher_answer">Yes</label>
                    
                </div>
                
                <div class="field field_invno" style="margin-bottom: 22px !important;">
                    <input type="radio" name="allow_invites" value="no" id="allow_invites_no" />
                    <label for="allow_invites_no" class="publisher_answer">No, Thanks</label>
                </div>
                <div class="clr"></div>
            </div>
            <div class="note">
                You may opt out of allowing for artists to send you invites to texture this model.  Regardless, you will
be able to sell your untextured model in the meantime.
            </div>
            
        </div>
		       </div>
            
            
        </div>
        
        
        
        
        <div class="sectionBackgroundDark">
        <div class="section section_pricing section_share_pricing">
			<div class="sectionOverlay">
            <h2>Pricing (Modeler Share)</h2>
			<div class="line2"></div>
            
            <div class="field_group">
                
                <div class="field">
                    <label>Your Price Share Per Sale $USD</label>
                    <input type="text" class="input" name="price_share" value="" placeholder="Enter your base share..." />
                    <div class="clr"></div>
                </div>
            </div>
            
            
            
            
            <div class="note">
                This is the amount of &ldquo;Price Share&rdquo; per sale on the Kitmoda store that a texture artist and subsequent
artists will have to share with you for sales of this asset.  Also this is the price that the model will be
entered into the store for as an untextured asset prior to a texture artist possibly applying to texture the 
model.  If this value is too high it could discourage texture artists from applying to the project. 
Kitmoda pays the modeler 80% of this &ldquo;Price Share&rdquo; value per sale of the resulting asset as commisions.
            </div>
            
        </div>
		       </div>
        
        </div>
        
        
        <div class="section section_pricing section_normal_pricing" style="display: none;">
            <h2>Pricing</h2>
            
            <div class="field_group">
                
                <div class="field">
                    <label>Price $USD</label>
                    <input type="text" class="input" name="untextured_price" value="" placeholder="Enter Price..." />
                    <div class="clr"></div>
                </div>
            </div>
            
            <div class="note">
                Kitmoda pays the modeler 80% of this &ldquo;Price Share&rdquo; value per sale of the resulting asset as commisions.
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
    
