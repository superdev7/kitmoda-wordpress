
	<script>
		(function($){
			$(window).load(function(){
				var textArea=$(".content1 textarea");
				textArea.wrap("<div class='textarea-wrapper' />");
				var textAreaWrapper=textArea.parent(".textarea-wrapper");
				textAreaWrapper.mCustomScrollbar({
					scrollInertia:0,
					advanced:{autoScrollOnFocus:false}
				});
				var hiddenDiv=$(document.createElement("div")),
        			content=null;
    			hiddenDiv.addClass("hiddendiv");
    			$("body").prepend(hiddenDiv);
    			textArea.bind("keyup",function(e){
        			content=$(this).val();
					var clength=content.length;
        			var cursorPosition=textArea.getCursorPosition();
					content="<span>"+content.substr(0,cursorPosition)+"</span>"+content.substr(cursorPosition,content.length);
					content=content.replace(/\n/g,"<br />");
        			hiddenDiv.html(content+"<br />");
        			$(this).css("height",hiddenDiv.height());
					textAreaWrapper.mCustomScrollbar("update");
					var hiddenDivSpan=hiddenDiv.children("span"),
						hiddenDivSpanOffset=0,
						viewLimitBottom=(parseInt(hiddenDiv.css("min-height")))-hiddenDivSpanOffset,
						viewLimitTop=hiddenDivSpanOffset,
						viewRatio=Math.round(hiddenDivSpan.height()+textAreaWrapper.find(".mCSB_container").position().top);
					if(viewRatio>viewLimitBottom || viewRatio<viewLimitTop){
						if((hiddenDivSpan.height()-hiddenDivSpanOffset)>0){
							textAreaWrapper.mCustomScrollbar("scrollTo",hiddenDivSpan.height()-hiddenDivSpanOffset);
						}else{
							textAreaWrapper.mCustomScrollbar("scrollTo","top");
						}
					}
    			});
				$.fn.getCursorPosition=function(){
        			var el=$(this).get(0),
						pos=0;
        			if("selectionStart" in el){
            			pos=el.selectionStart;
        			}else if("selection" in document){
            			el.focus();
            			var sel=document.selection.createRange(),
							selLength=document.selection.createRange().text.length;
            			sel.moveStart("character",-el.value.length);
            			pos=sel.text.length-selLength;
        			}
        			return pos;
    			}
			});
		})(jQuery);
	</script>


<div class="window_inner" swidth="726">




<script type="text/javascript">





$(function() {
    $('#model_price, #texture_price').keyup(function(e) {
        join_calculator();
    });

    join_calculator();

    $('.section_request_type input').on('change', function(){
        if($(this).val() == 'model') {
            cbSlide('.section_texture_price_share', 'up');
        } else {
            cbSlide('.section_texture_price_share', 'down');
        }

        
        m_resize();

    });

    

    $('.terms_link').click(function(e) {
        e.preventDefault();

        var h = $('.step_join_form').outerHeight();

        $('.term_step [hec=1]').each(function() {
            h = h - $(this).outerHeight();
        });

        $('.term_step .content1').css({height:h+'px'});

        $('.term_step').show();
    });

    $('.term_step .back_btn').click(function(e) {
        e.preventDefault();
        $('.term_step').hide();

    });

    

});









</script>







<div class="step_join_form" sindex="1" rel="">

    <iframe name="pub_frame" class="formframe"></iframe>

    <form method="post" target="pub_frame" action="<?=admin_url( 'admin-ajax.php' )?>">



    <input type="hidden" name="action" value="CollaborationRequest_submit" />

    <input type="hidden" name="_id" value="<?=$post->ID?>" />    



    <div class="win_header" hec="1">

        <div class="title">Request to Join Collaboration</div>

        <a class="close"></a>

    </div>



    <div class="content">    




		</section>
		<div class="field field_notes my_area">
		<div class="content1">
					
					<textarea name="message" class="edit_prf_selct">Hello, I would like to join your project.</textarea>
				
			</div>
			</div>
	
        <input type="hidden" name="base_price" value="<?=$post->price?>" id="base_price" />

    <?php if($post->current_stage == 'concept') : ?>
        <div class="section section_request_type">


   <div class="combind-feald">
            <div class="field_group">
                    <div class="field_title">What role would you like to apply for?</div>

                    <div class="sep-sec">

                        <input type="radio" name="request_type" id="request_type_model" value="model" checked="checked" />
                        <label for="request_type_model">Modeler</label>
                    </div>



                    <div class="sep-sec">

                        <input type="radio" name="request_type" id="request_type_model_texture" value="model_texture" />
                        <label for="request_type_model_texture">Both Modeler and Texture Artist</label>
                    </div>


                    <div class="note">
                        The artist who launches a collaboration maintains creative contol over the project.<br>
    If you do not texture the model now, the concept artist might select another applicant for that
    portion of the project.
                    </div>

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
                    <input type="text" class="input" name="model_price" id="model_price" autocomplete="off" placeholder="Enter your price share..." />
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

        
        <?php else : ?>

        <input type="hidden" name="request_type" value="texture" />
      <?php endif; ?>




        <div class="section section_texture_price_share" style="<?=($post->current_stage == 'concept' ? 'display:none' : '')?>">
                <h2>Price Share for Texture</h2>


                <div class="field_group">
                    <label> Price of Asset before Texture</label>
                    <span class="amount"></span>
                    <div class="clr"></div>
                </div>


                <div class="field_group">
                    <label>Your Price Share Per Sale $USD</label>
                    <input type="text" class="input" name="texture_price" id="texture_price" autocomplete="off" placeholder="Enter your price share..." />
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

                        Ã¢â‚¬Å“Price ShareÃ¢â‚¬ï¿½ is the amount per sale on the Kitmoda store that other collaborating artistÃ¢â‚¬â„¢s <br>

            will have to share with you for sales of this asset.  Also this is the price that the model will be <br>
            entered into the store for as an untextured asset prior to a texture artist possibly applying to texture the 
            model.  If this value is too high it could discourage texture artists from applying to the project. <br />

            Kitmoda pays the modeler 80% of this Ã¢â‚¬Å“Price ShareÃ¢â‚¬ï¿½ value per sale of the resulting asset as commisions.      

                    </div>
                </div>

            </div>



    </div>


    <div class="footer" hec="1">



        <div style="width: 420px;margin-top: 7px;">

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

    <?php

    if($this->elementExists('join_terms')) {
        echo "<div class=\"term_step\">";
        $this->render_element('join_terms', array());
        echo '</div>';
    }

    ?>

</div>



   <!-- start scroll js -->

                              

                             

                                

                                 <script>

                                    (function ($) {

                                        $(window).load(function () {

                                            $(".window.join .sbOptions").mCustomScrollbar();

                                        });

                                    })(jQuery);

										

                                </script>
                      




