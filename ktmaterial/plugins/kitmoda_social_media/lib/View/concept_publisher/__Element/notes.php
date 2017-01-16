<div class="win_header" hec="1">
    <div class="title"><?=$step['title']?></div>
    <a class="close"></a>
</div>

<div class="content">    
    
    
    <h1 style="margin-bottom: 34px;">Optionally, add notes for the modeler...</h1>
        
        
        <div class="line2"></div>
        
        
        
        <div class="field field_notes">
            
            <textarea name="notes"></textarea>
            
        </div>
        
        
        
        
        
        
        
</div>

<div class="footer" hec="1">
    <div style="float: right;">
        <div class="error"></div>
        <?php $this->render_element('loading'); ?>
        <a href="" class="btn btn_blue btn_step_next final">Publish</a>
        <div class="clr"></div>
    </div><div class="clr"></div>
</div>