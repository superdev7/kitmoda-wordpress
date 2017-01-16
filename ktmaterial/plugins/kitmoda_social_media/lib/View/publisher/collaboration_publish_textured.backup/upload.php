<div class="win_header" hec="1">
    <div class="title"><?=$step['title']?></div>
    <a class="close"></a>
</div>

<div class="content">
    <h1>Let’s upload and your model!</h1>
    <input type="hidden" id="upload_sell_type" name="upload_sell_type" value="2" />
    <div class="line2" style="margin-top:15px;"></div>
    
    
    <div class="section">
        <h2>Textured Model Upload</h2>
            
        <div class="final_upl_box textured_file_upl_container">
            <div class="browse_container">
                <a href="" class="browse_btn" style="position: relative; z-index: 1;">Browse for Zip...</a>
                <div class="info">Or, Drag and Drop image into the box below.</div>
                <div class="clr"></div>
            </div>

            <div class="line2" style="margin-bottom : 10px;"></div>

            <div class="dropbox">
                <div class="empty">Or, Drag and Drop Here...</div>
                
                <ul class="items">
                    
                    
                    
                    <li class="clr"></li>
                </ul>
                
                
                
            </div>
        </div>
            
        
            
    </div>
    
    
    
    
    
    <div class="section section_untextured_upload">
        <h2>Untextured Model Upload</h2>
            
        <div class="final_upl_box untextured_file_upl_container">
            <div class="browse_container">
                <a href="" class="browse_btn" style="position: relative; z-index: 1;">Browse for Zip...</a>
                <div class="info">Or, Drag and Drop image into the box below.</div>
                <div class="clr"></div>
            </div>

            <div class="line2" style="margin-bottom : 10px;"></div>

            <div class="dropbox">
                
                <div class="empty">Or, Drag and Drop Here...</div>
                <ul class="items">
                
                    <li class="clr"></li>
                </ul>
            </div>
        </div>
            
        
            
    </div>
    
    
    
    
</div>

<div class="footer" hec="1">
    <div style="float: right;">
        <div class="error"></div>
        <?php $this->render_element('loading'); ?>
        <a href="" class="btn btn_blue btn_step_next final">Next</a>
        <div class="clr"></div>
    </div><div class="clr"></div>
</div>