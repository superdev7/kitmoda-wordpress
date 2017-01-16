<div class="window_inner" svinai="full_page_popup">
    
    
    <script type="text/javascript">
    
    $(function() {
        $('.terms_link a').click(function(e) {
        e.preventDefault();
        
        var h = $('form').outerHeight();
        
        $('.term_step [hec=1]').each(function() {
            h = h - $(this).outerHeight();
        });
        $('.term_step .content').css({height:h+'px'});
        $('.term_step').show();
    });
    
    $('.term_step .back_btn').click(function(e) {
        e.preventDefault();
        $('.term_step').hide();
    });
    })
    
    </script>
    
    
    <?php
    
    $form = KSM_Form::get_form('Registration');

    
    
    ?>
    
    
    <iframe name="user_join_frame" class="formframe"></iframe>
    <form method="post" action="<?=admin_url( 'admin-ajax.php' )?>" target="user_join_frame">
    <input type="hidden" name="action" value="User_submit_join" />
    
    <input type="hidden" name="ara" value="<?=$ar_action?>" />
    
    <div class="win_header" hec="1">
        <div class="win_header_inner">
            <div class="title"></div>
            <a class="close"></a>
        </div>
    </div>
    
    <div class="content">
        
        <div class="heading">Join Kitmoda!</div>
        <div class="heading_info">Help us shape an innovative new art community.</div>
        
        <span class="error"></span>
        
        
        <div class="fields">
            
            <?php foreach($form->fields as $f) : ?>
            
        <div class="field">
            <label for="<?=$f->field_id()?>"><?=$f->label?></label>
            <?=$f->field()?>
            
            <div class="clr"></div>
        </div>
        
        <?php endforeach; ?>
        </div>
        
        
    </div>
    
    
    
    <div class="footer" hec="1">
        <div class="footer_inner">
            <div class="info">By joining and participating on Kitmoda.com you are agreeing to these terms of service...</div>

            <div style="margin-top : 3px;">
                <span class="terms_link"><a href="">Terms of Service</a></span>
            </div>
            <a href="" class="btn redButton btn_form_smt">Join</a>
        </div>
    </div>
    
    
    </form>
    
    
    
    <?php
    
    if($this->elementExists('terms')) {
        echo "<div class=\"term_step\">";
        $this->render_element('terms', array());
        echo '</div>';
    }
           
    ?>
</div>