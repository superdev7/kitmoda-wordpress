<div class="win_header" hec="1">
    <div class="title"><?=$step['title']?></div>
    <a class="close"></a>
</div>

<div class="content">
    <h1>Great! Let’s add images of your model.</h1>
    <div class="pinfo" style="padding:6px 0;">900x900 or Larger</div>
    <div class="pinfo">High Quality jpeg</div>
    
    <div class="line2" style="margin-top:15px;"></div>
    
    <div class="images_upl_container">
        <div class="browse_container collab_concept_browse_container">
            <a href="" class="browse_btn" style="position: relative; z-index: 1;">Browse for Images...</a>
            <div class="info">Or, Drag and Drop to Boxes Below<br />Drag to sort</div>
            <div class="clr"></div>
        </div>

        <div class="line2" style="margin-bottom : 10px;"></div>

        <div class="ubox items_container">

            
            <?=KSM_Form::images_upload_placeholder(reset($step['uploader']));?>
            

        </div>
        
        
        
    
</div>
    
    <hr class="line2">
    
    <div style="text-align: center">Be sure you have sorted images into the correct categories.</div>
</div>

<div class="footer" hec="1">
    <div style="float: right;">
        <div class="error"></div>
        <?php $this->render_element('loading'); ?>
        <a href="" class="btn btn_blue btn_step_next">Next</a>
        <div class="clr"></div>
    </div><div class="clr"></div>
</div>