<div class="win_header" hec="1">
    <div class="title"><?=$step['title']?></div>
    <a class="close"></a>
</div>

<div class="content">    
    
    
        
    <h1 style="margin-bottom: 34px;">Awesome!  Now let&rsquo;s describe and price your concept.</h1>
        
        
        <div class="line2"></div><div class="sectionBackgroundDark">
        <div class="section"><div class="sectionOverlay">
            <h2>Title</h2>
            <div class="field_group">
                <div class="field">
                    <input type="text" name="title" class="input" placeholder="Enter your title here..." />
                    
                </div>
            </div>
        </div>		</div>		</div>
        
        <div class="sectionBackgroundDark">
        <div class="section">		<div class="sectionOverlay">
            <h2>Description</h2>
            
            <div class="field_group">
                <div class="field">
                    <textarea class="input" name="description" placeholder="Describe what your concept is without tech specs here..."></textarea>
                </div>
            </div>
        </div>		 </div>		  </div>
        
        <div class="sectionBackgroundDark">
        <div class="section">		<div class="sectionOverlay">
            <h2>Keywords</h2>
            
            <div class="field_group">
                <div class="field">
                    <textarea class="input" name="keywords" id="pub_keywords" placeholder="Enter up to 10 keywords here..."></textarea>
                </div>
            </div>
        </div>		 </div>		  </div>
        
        
        <div class="sectionBackgroundDark">        <div class="section">		<div class="sectionOverlay">
            <h2>Category</h2>
            
                
            <div class="field_group ">
                <div class="kcat">
                    <?=KSM_Taxonomy::dropdown(array('label'=>'Main Category', 'orderby' => 'name', 'order' => 'DESC'));?>
                </div>
                
                
                
            </div>
        </div>		 </div>		  </div>
           
         <div class="sectionBackgroundDark">
        <div class="section section_style">		<div class="sectionOverlay">
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
        </div>		 </div>		  </div>
        
        
        
        
         <div class="sectionBackgroundDark">
        <div class="section section_pricing">		<div class="sectionOverlay">
            <h2>Pricing (Concept Artist Share)</h2>
            
            <div class="field_group">
                
                <div class="field">
                    <label>Your Price Share Per Sale $USD</label>
                    <input type="text" class="input" name="price_share" value="" />
                    <div class="clr"></div>
                </div>
            </div>
            
            <div class="field_group">
            <div class="note">
                This is the amount of &ldquo;Price Share&rdquo; per sale on the Kitmoda store that a modeler and subesquent artists will have to share with you for sales of assets created directly from this exact design.<br >
If this value is too high it could discourage modelers from applying to the project.  Kitmoda pays 
the concept artist 80% of this &ldquo;Price Share&rdquo; value per sale of the resulting asset as commisions.
            </div>
            </div>
        </div>		</div>		</div>
        
        
</div>        
    
<div class="footer" hec="1">
    
    <div style="text-align: center;margin-top:18px;">
        <a class="terms_link" href="">Concept art submission terms</a>
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
        <a href="" class="btn btn_blue btn_step_next final">Next</a>
        <div class="clr"></div>
    </div><div class="clr"></div>
</div>