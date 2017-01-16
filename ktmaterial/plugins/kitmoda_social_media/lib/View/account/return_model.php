<div class="window_inner">
    
    
    <div class="win_header" hec="1">
        <div class="title">Return Model</div>
        <a class="close"></a>
    </div>
    
    
    
    <iframe name="form_frame" class="formframe"></iframe>
    <form method="post" target="form_frame" action="<?=admin_url( 'admin-ajax.php' )?>">

    <input type="hidden" id="form_id" name="_id" value="<?=$_id?>" />
    <input type="hidden" name="action" value="Account_submit_return_model" />
    <div class="content">
        
        
        <div class="return_message"><?=$message;?></div>
        
    </div>
    <div class="footer form_footer" hec="1">
        
        <?php if($can_return) :  ?>
        <?php $this->render_element('loading'); ?>
        <a href="" class="btn btn_blue btn_form_smt">Return</a>
        <div class="error"></div>
        <?php endif; ?>
    </div>
    
    
    
    
    
    
    </form>
</div>