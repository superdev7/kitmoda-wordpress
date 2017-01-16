<div class="window_inner" swidth="726">


<script type="text/javascript">





$(function() {
    $('#model_price, #texture_price').keyup(function(e) {
        join_calculator();
    });
    
    join_calculator();
    
    $('.section_request_type input').change(function() {
        if($(this).val() == 1) {
            $('.section_texture_price_share').slideUp();
        } else {
            $('.section_texture_price_share').slideDown();
        }
        
        
        m_resize();
        
    })
});




</script>


    <iframe name="pub_frame" class="formframe"></iframe>
    <form method="post" target="pub_frame" action="<?=admin_url( 'admin-ajax.php' )?>">

    <input type="hidden" name="action" value="Collaboration_submit_join_request" />
    <input type="hidden" name="_id" value="<?=$post->ID?>" />    

    <div class="win_header" hec="1">
        <div class="title">Request to Join Collaboration</div>
        <a class="close"></a>
    </div>


    
    
    


    <div class="content">    









            <div class="field field_notes">

                <textarea name="notes"></textarea>

            </div>

        <input type="hidden" name="base_price" value="<?=$post->price?>" id="base_price" />

    <?php if($post->collaboration_type == 'concept') : ?>
        <div class="section section_request_type">

            <div class="field_group">
                    <div class="field_title">What role would you like to apply for?</div>
                    <div class="field">
                        <input type="radio" name="request_type" id="request_type_1" value="1" checked="checked" />
                        <label for="request_type_1">Modeler</label>
                    </div>

                    <div class="field">
                        <input type="radio" name="request_type" id="request_type_3" value="3" />
                        <label for="request_type_3">Both Modeler and Texture Artist</label>
                    </div>


                    <div class="note">
                        The artist who launches a collaboration maintains creative contol over the project.<br>
    If you do not texture the model now, the concept artist might select another applicant for that
    portion of the project.
                    </div>

            </div>
        </div>





            <div class="section section_model_price_share">
                <h2>Price Share for Model</h2>


                <div class="field_group">
                    <label>Price of Asset before Model</label>
                    <span class="amount"></span>
                    <div class="clr"></div>
                </div>


                <div class="field_group">
                    <label>Your Price Share Per Sale $USD</label>
                    <input type="text" class="input" name="model_price" id="model_price" placeholder="Enter your price share..." />
                    <div class="clr"></div>
                </div>
                <div class="field_group">
                    <div class="line2"></div>
                </div>
                <div class="field_group">
                    <label>New Proposed Store Price</label>
                    <span class="amount_total"></span>
                    <div class="clr"></div>
                </div>
            </div>

      <?php endif; ?>




        <div class="section section_texture_price_share" style="<?=($post->collaboration_type == 'concept' ? 'display:none' : '')?>">
                <h2>Price Share for Texture</h2>


                <div class="field_group">
                    <label> Price of Asset before Texture</label>
                    <span class="amount"></span>
                    <div class="clr"></div>
                </div>


                <div class="field_group">
                    <label>Your Price Share Per Sale $USD</label>
                    <input type="text" class="input" name="texture_price" id="texture_price" placeholder="Enter your price share..." />
                    <div class="clr"></div>
                </div>
                <div class="field_group">
                    <div class="line2"></div>
                </div>
                <div class="field_group">
                    <label>New Proposed Store Price</label>
                    <span class="amount_total"></span>
                    <div class="clr"></div>
                </div>

            </div>


            <div class="line2"></div>

            <div class="section">
                <div class="field_group">
                    <div class="note">
                        “Price Share” is the amount per sale on the Kitmoda store that other collaborating artist’s <br>
            will have to share with you for sales of this asset.  Also this is the price that the model will be <br>
            entered into the store for as an untextured asset prior to a texture artist possibly applying to texture the 
            model.  If this value is too high it could discourage texture artists from applying to the project. <br />
            Kitmoda pays the modeler 80% of this “Price Share” value per sale of the resulting asset as commisions.      
                    </div>
                </div>
            </div>

    </div>




  



    <div class="footer" hec="1">

        <div style="width: 420px;margin-top: 18px;">
            <a class="terms_link" href="">Collaboration Terms...</a>
        </div>

        <div style="float: left;width: 440px; margin-top: 5px;">
            <input type="checkbox" name="terms_agreed" id="terms_agreed" value="yes" />
            <label for="terms_agreed">I have fully read and understand these terms.</label>
            <div class="clr"></div>
        </div>

        <div class="loading_error">
            <div class="error"></div>
            <?php $this->render_element('loading'); ?>
        </div>


        <div style="float: right;">
            <a href="" class="btn btn_blue btn_submit">SUBMIT</a>
            <div class="clr"></div>
        </div><div class="clr"></div>
    </div>
</form>
</div>