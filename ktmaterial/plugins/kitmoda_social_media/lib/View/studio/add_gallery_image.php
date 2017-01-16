
<script type="text/javascript">
    
    
    $(function() {
        $('input.post_to').change(function(e) {
            cbSlide('.c_topics', 't');
            cbSlide('.c_topics_heading', 't');
        });
    });
    

</script>



<div class="window_inner">
    <iframe name="add_gallery_image_frame" class="formframe"></iframe>
    <form method="post" action="<?=admin_url( 'admin-ajax.php' )?>" target="add_gallery_image_frame">
    <input type="hidden" name="action" value="Studio_submit_add_gallery_image" />
    <div class="win_header" hec="1">
        <div class="title">Add Image to Galleries</div>
        <a class="close"></a>
    </div>
    <div class="content">
        
        
        <div class="row">
            
            <h1>Add your image to galleries...</h1>
            
        </div>
        
        <div class="line2"></div>
        
        
        <div class="browse_container">
            <a href="" class="browse_btn">Browse for Images...</a>
            <div class="info">Or, Drag and Drop image into the box below.</div>
            <div class="clr"></div>
        </div>
        
        
        <div class="line2"></div>
        
        <div class="row">
            
            <div class="ubox">
                <div class="b1-bg">
                    <div class="b1">
                        <div class="b2-bg">
                            <div class="b2">
                                <div class="b3"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="gi" id="gi" value="" />
            </div>
        </div>
        
        
        <div class="row">
            
            <div class="section">
                <h2>Title</h2>
                <div class="field">
                    <input type="text" name="title" class="input" placeholder="Enter your title here..." />
                    
                </div>
            </div>
            
            <div class="section">
                <h2>Description</h2>
                <div class="field">
                    <textarea name="description" class="input" placeholder="Describe your WIP image..."></textarea>
                </div>
            </div>
            
            
            
            
            <div class="section options">
                <h2>Description</h2>
                
                
                <div class="left_side heading">POST TO</div>
                <div class="right_side heading c_topics_heading">TOPIC</div>
                <div class="clr"></div>

                <div class="line2"></div>




                <div style="padding-bottom: 36px;padding-top: 10px;">
                    <div class="left_side">
                        <div class="field"><input checked="checked" type="radio" class="post_to" name="post_to" value="2" id="post_to_2" /><label for="post_to_2">COMMUNITY + STUDIO</label></div>
                        <div class="field"><input type="radio" class="post_to" name="post_to" value="1" id="post_to_1" /><label for="post_to_1">ONLY MY STUDIO</label></div>
                    </div>
                    <div class="right_side c_topics">
                        <div class="field"><input checked="checked" type="radio" name="topic" value="general" id="topic_general" /><label for="topic_general">GENERAL</label></div>
                        <div class="field"><input type="radio" name="topic" value="challenge" id="topic_challenge" /><label for="topic_challenge">CHALLENGE</label></div>
                        <div class="field"><input type="radio" name="topic" value="model" id="topic_model" /><label for="topic_model">MODELING</label></div>
                        <div class="field"><input type="radio" name="topic" value="concept" id="topic_concept" /><label for="topic_concept">CONCEPT ART</label></div>
                        <div class="field"><input type="radio" name="topic" value="texture" id="topic_texture" /><label for="topic_texture">TEXTURE</label></div>
                    </div>
                    <div class="clr"></div>

                </div>
        
        
        
                <div class="gallery_section">
                    <div class="line2"></div>

                    <div class="left_side"></div>
                    <div class="right_side heading">ADD IMAGE TO GALLERIES AS...</div>
                    <div class="clr"></div>
                    <div class="line2"></div>

                    <div class="left_side"></div>
                    <div class="right_side" style="padding-top: 8px;">
                        <div class="field"><input type="radio" checked="checked" name="gallery" value="wip" id="gallery_wip" /><label for="gallery_wip">WORK IN PROGRESS</label></div>
                        <div class="field"><input type="radio" name="gallery" value="finished" id="gallery_finished" /><label for="gallery_finished">FINISHED ART</label></div>
                    </div>
                    <div class="clr"></div>

                    <div class="line2"></div>
                </div>
                
            </div>
            
            
        </div>
        
        
        
        
        
        
        
        
        
    </div>
    <div class="footer" hec="1" align="right">
        <div class="error"></div>
        <a href="" class="btn btn_blue btn_form_smt btn_update_profile">Add</a>
    </div>
    </form>
</div>