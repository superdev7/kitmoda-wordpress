<?php

$avatar = $this->avatar($user->ID, 'avatar_large');

$avatar_uploader->build();
?>

<script type="text/javascript">


$(function() {
    
    
    $('#skills').tagEditor({ 
        initialTags: <?=json_encode(explode(',', $user->skills))?>, 
        placeholder: 'Begin entering skills here for a list of tags...' ,
        forceLowercase : false,
        autocomplete: {
            delay: 0,
            position: { collision: 'flip' },
            source: ksm_settings.ajax_url+'?action=skills_suggest',
            minLength: 3
        },
        onChange: function() {
            m_resize();
        }
    });
    
    $('#softwares').tagEditor({ 
        initialTags: <?=json_encode(explode(',', $user->softwares))?>, 
        placeholder: 'Begin entering software here for a list of tags...',
        forceLowercase : false,
        autocomplete: {
            delay: 0,
            position: { collision: 'flip' },
            source: ksm_settings.ajax_url+'?action=softwares_suggest',
            minLength: 3
        },
        onChange: function() {
            m_resize();
        }
    });
    
    
    
    $(".tag-editor input").tagEditorInput();
    
    
    
    
})



</script>
<div class="window_inner">
    <iframe name="edit_profile_frame" class="formframe"></iframe>
    <form method="post" action="<?=admin_url( 'admin-ajax.php' )?>" target="edit_profile_frame">
        
        <input type="hidden" name="current_avatar" value="<?=$avatar?>" class="current_avatar" />
        <input type="hidden" name="action" value="User_update_profile" />
        <div class="win_header" hec="1">
            <div class="title">Edit Profile</div>
            <a class="close"></a>
        </div>
        <div class="content">
            <div class="avatar_container">
                <ul class="items">
                    <li id="defavtar_item" class="item">
                        <div class="preview">
                            <a class="cancel"></a>
                            <div class="thumbnail"><img src="<?=$avatar?>" /></div>
                        </div>
                    </li>
                    <li class="clr"></li>
                </ul>
                <div style="clear: both"></div>
                
                
                
                
                
                
                <div class="field">
                    <a href="" class="btn btn_blue browse_btn">Browse...</a>
                    <div class="avatar_types">jpeg, gif, and png</div>
                </div>
            </div>



            <div class="tagline"><input class="input" name="tagline" value="<?=$user->tagline?>" type="text" placeholder="Enter your motto or introduction statement here..." /></div>
                <div class="clr"></div>


<div class="after_add_post_line"><div class="after_add_post_line_overlay"></div></div>


<div class="content-overlay-bord">
<div class="content-overlay">
<div class="content-overlay-inside">

            <div class="field">

                <label>Display Name</label>

                <input class="input" name="display_name" value="<?=$user->display_name?>" type="text" />
            </div>

            <div class="field">

                <label>Email</label>

                <input class="input" name="email" value="<?=$user->user_email?>" type="text" />
            </div>

            <div class="field">

                <label>Website URL</label>

                <input class="input" name="url" value="<?=$user->user_url?>" type="text" />
            </div>



            <div class="field edit_prf_selct1 field_location">

                <label>Location</label>

                <select name="country" class="edit_prf_selct">

                    <option value="">Country</option>
                    <?php foreach($countries as $k=>$v) : ?>
                    <option<?=(($user->country == $k) ? ' selected="selected"' : '')?> value="<?=$k?>"><?=$v?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="field">

                <label>Skills</label>

                <textarea id="skills" name="skills" class="input"></textarea>
                <div class="field_info">Enter skills separate by comma.</div>
            </div>
                
                

            <div class="field">

                <label>Software</label>

                <textarea id="softwares" name="softwares" class="input"></textarea>
                <div class="field_info">Enter softwares separate by comma.</div>
            </div>



            <div class="field edit_prf_selct2 field_primary_language">

                <label>Primary Language</label>



                <select name="primary_lang" class="edit_prf_selct">

                    <option value="">Language</option>
                    <?php foreach((Array) $languages as $k=>$v) : ?>
                    <option<?=(($user->primary_lang == $k) ? ' selected="selected"' : '')?> value="<?=$k?>"><?=$v?></option>
                    <?php endforeach; ?>
                </select>


            </div>



            <div class="field edit_prf_selct3 field_secondary_language">

                <label>Secondary Language</label>

                <select name="secondary_lang" class="edit_prf_selct">

                    <option value="">Language</option>
                    <?php foreach((Array) $languages as $k=>$v) : ?>
                    <option<?=(($user->secondary_lang == $k) ? ' selected="selected"' : '')?> value="<?=$k?>"><?=$v?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        </div>
        
        </div>
        
        <div class="clear"></div>
        </div>


        <div class="footer" hec="1">
            <a href="" class="btn btn_blue btn_form_smt btn_update_profile">Update</a>
            <div class="error"></div>
            <div style="clear:both"></div>

        </div>
    </form>
</div>



<script type="text/javascript">
		$(function () {
			$(".edit_prf_selct").selectbox({topPositionCorrelation : 4000, keepInViewport : false});
		});
</script>
   <!-- start scroll js -->
                              
                             
                                
                                 <script>
                                    (function ($) {
                                        $(window).load(function () {
                                            $(".window.edit_profile .sbOptions").mCustomScrollbar();
                                        });
                                    })(jQuery);
										
                                </script>
                                
                                  
                                
                                
									
									
                                
                          
                                <!-- end scroll js -->
                                