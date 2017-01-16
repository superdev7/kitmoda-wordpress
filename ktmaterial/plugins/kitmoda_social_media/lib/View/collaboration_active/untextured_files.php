<div class="window_inner" swidth="1228">
    <div class="win_header" hec="1">
        <div class="title">Collaboration Files</div>
        <a class="close"></a>
    </div>
    
    <div class="content">
        
        <div class="cinner">
            
            <div class="cheader">
                
                <div class="thumb"><?=$active->Collaboration->the_thumb()?></div>
                
                <div class="info">
                    <div class="proj_name"><?=$active->Collaboration->post_title?></div>
                    <div class="iinfo">Untextured Model Assets</div>
                </div><div class="clr"></div>
                
            </div>
        
        
            <div align="center">
                <a href="<?=ksm_get_permalink("collaboration/active/dl_untextured_file/{$active->ID}")?>" class="dl_btn btn btn_blue">Download Model ZIP</a>
            </div>

            <div class="cfooter"></div>
            
        </div>
        
    </div>
    
    <div class="footer" hec="1"></div>
</div>