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
                    <div class="iinfo">Concept Art Images</div>
                </div><div class="clr"></div>
                
            </div>
        
        
            <div align="center">
                <a href="<?=ksm_get_permalink("collaboration/active/dl_concept_files/{$active->ID}")?>" class="dl_btn btn btn_blue">Download Concepts ZIP</a>
            </div>
            
            
            
            <div class="files_heading">INDIVIDUAL FILES</div>
            <ul class="files_list">
            <?php foreach($files as $f) :?>
                <li>
                    <div class="thumb"><img src="<?=get_image_src($f->ID, 'avatar_small_2') ?>" /></div>
                    <div class="link"><?=basename($f->guid)?></div>
                    <div class="clr"></div>
                </li>
                
            <?php endforeach;?>
            </ul>
            

            <div class="cfooter"></div>
            
        </div>
        
    </div>
    
    <div class="footer" hec="1"></div>
</div>