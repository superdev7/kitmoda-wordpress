<div class="win_header" hec="1">
    <div class="title"><?=$step['title']?></div>
    <a class="close"></a>
</div>

<div class="content">
    
    <h1 style="font-family: Roboto;">Great! Let&rsquo;s add images of your untextured model.</h1>
    <div class="pinfo" style="padding:6px 0;">&ldquo;900x900 or Larger</div>
    <div class="pinfo">&ldquo;High Quality JPEG</div>
    <div class="line2" style="margin-top:15px;"></div>
    
    <div class="images_upl_container">
        <div class="browse_container collab_concept_browse_container">
            <a href="" class="browse_btn" style="z-index: 1; padding-bottom: 10px; margin: auto; width: 100%">BROWSE FOR IMAGES...</a>
            <div class="clr"></div>
			<div class="bottomLightGreyText" style="text-align: center; font-size: 16px;">Or, drag and drop</div>
        </div>

        <div class="line2" style="margin-bottom : 10px;"></div>

        <div class="ubox items_container">
            
            <?=KSM_Form::images_upload_placeholder(reset($step['uploader']));?>
        </div>
        
        
        
    
</div>
    
    <hr class="line2">
    
    <div class="bottomLightGreyText" style="text-align: center;">Sort by dragging into categories</div>
</div>

<div class="footer" hec="1">
    <div style="float: right;">
        <div class="error"></div>
        <?php $this->render_element('loading'); ?>
        <a href="" class="btn btn_blue btn_step_next">Next</a>
        <div class="clr"></div>
    </div><div class="clr"></div>
</div>