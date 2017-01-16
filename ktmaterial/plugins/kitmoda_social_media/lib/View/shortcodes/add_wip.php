
<script type="text/javascript">

var wip_upl;
$(function() {
    
    
    
        
    wip_upl = new wip_uploader({
        max_size : '<?=KSM_AVATAR_UPLOAD_SIZE?>',
        file_types : '<?=KSM_AVATAR_UPLOAD_TYPES?>',
        action : 'uwipu',
        nonce : '<?=wp_create_nonce('ksm_uwipu')?>'
    });
    wip_upl.params.PLU.init();
    
    
})



</script>


<div class="window_content">
    <iframe name="add_wip_frame" class="formframe"></iframe>
    <form method="post" action="<?=admin_url( 'admin-ajax.php' )?>" target="add_wip_frame">
    <input type="hidden" name="action" value="ksm_add_wip" />
    <div class="win_header" hec="1">
        <div class="title">Add WIP Image</div>
        <a class="close"></a>
    </div>
    <div class="content">
        
        
        <div class="row">
            
            <h1>Add your work in progress image <br />to your gallery...</h1>
            
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
                <input type="hidden" name="wi" id="wi" value="" />
                
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
            
            
        </div>
        
        
        
        
        
        
        
        
        
    </div>
    <div class="footer" hec="1" align="right">
        <div class="error"></div>
        <a href="" class="btn btn_blue btn_form_smt btn_update_profile">Add</a>
    </div>
    </form>
</div>