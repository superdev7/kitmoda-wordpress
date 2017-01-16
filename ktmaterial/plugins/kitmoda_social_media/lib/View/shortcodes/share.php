<script type="text/javascript">
    
    function change_tab(t) {
        $('.tabs_content .tab').hide();
        $('.tabs_content #tab_'+t).show();
        $('.share_tabs li').removeClass('active');
        $('.share_tabs li[rel="'+t+'"]').addClass('active');
    }
    
    
    
    
    
    $(function() {
        $('.share_tabs li').click(function() {
            var t = $(this).attr('rel');
            change_tab(t);
        });
        change_tab('share_email');
        
        $('#share_tweet').keypress(function() {
            var tw = $(this).val();
            if (tw.length > 140) {
                $(this).val(tw.substring(0, 140));
            }
        });
        
        
        $('.btn_share_tweet').click(function() {
            var d = "https://twitter.com/share";
            var f = $("#share_tweet").val();
            f = encodeURI(f);
            d += "?text=" + f;
            d += "&url=null";
            var a = "twitterdotcom";
            var b = "width=600,height=400";
            window.open(d, a, b);
            window.parent.$.colorbox.close();
        })
        
        
    })
    
    
    
    
    
    
    
    
    window.fbAsyncInit = function() {
        FB.init({
          appId      : '<?=KSM_FACEBOOK_APP_ID?>',
          xfbml      : true,
          version    : 'v2.2'
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
    
    
</script>



<div id="fb-root"></div>




    <ul class="share_tabs">
        <li rel="share_email" class="active"><span>Email</span></li>
        <li rel="share_facebook"><span>Facebook</span></li>
        <li rel="share_twitter"><span>Twitter</span></li>
        <li rel="share_link"><span>Link</span></li>
        <li class="clr"></li>
    </ul>
    


    <div class="tabs_content">
        <div id="tab_share_email" style="padding: 0 10px;" class="tab">
            
            <iframe name="email_share_iframe" class="formframe"></iframe>
            <form method="post" target="email_share_iframe" action="<?=admin_url( 'admin-ajax.php' )?>">
                <input type="hidden" name="id" value="<?=$params['id']?>" />
                <input type="hidden" name="action" value="share_email" />
                <div class="field">
                    <label>From your email address</label>
                    <input type="text" name="email_from" id="email_from" class="input">
                </div>

                <div class="field">
                    <label>To email address</label>
                    <input type="text" name="email_to" id="email_to" class="input">
                </div>


                <div class="field">
                    <label>Subject</label>
                    <input type="text" name="email_subject" id="email_subject" value="<?=$params['email_subject']?>" class="input" />
                </div>

                <div class="field">
                    <label>Message</label>
                    <textarea name="email_message" id="email_message"><?=$params['email_message']?></textarea>
                </div>
                <div style="position: absolute; bottom: 0;width : 96%;">
                    <a href="" class="btn btn_blue btn_share_email btn_form_smt" style="float: left;">Share</a>
                    <div class="error" style="float: right;margin-right: 45px;"></div>
                    <div class="form_loading"></div>
                </div>
            </form>
        </div>
        
        
        <div id="tab_share_facebook" style="padding: 0 10px;" class="tab">
            
            <iframe name="facebook_share_iframe" class="formframe"></iframe>
            <form method="post" target="facebook_share_iframe" action="<?=admin_url( 'admin-ajax.php' )?>">
                <input type="hidden" name="id" value="<?=$params['id']?>" />
                <input type="hidden" name="action" value="sharefb" />
                <div class="field" style="margin-bottom: 10px">
                    <textarea name="facebook_comment" id="facebook_comment" placeholder="Enter your comment"></textarea>
                </div>
                <br />

                <?php if($params['picture']) :?>

                <div style="float: left;margin-right: 10px;">
                    <img src="<?=$params['picture']?>" width="100">
                </div>
                <?php endif; ?>


                <div>
                    <div class="caption"><?=$params['caption']?></div>
                    <div class="link"><?=$params['link']?></div>
                    <div class="description"><?=(strlen($params['description']) > 200 ? substr($params['description'], 0, 200).'...' : $params['description'])?></div>
                </div>
                <div class="clr"></div>


                <div style="position: absolute; bottom: 0;width : 96%;">
                    <a href="" class="btn btn_blue btn_share_facebook btn_form_smt">Post</a>
                    <div class="form_loading"></div>
                </div>
                
            </form>
        </div>
        
        
        <div id="tab_share_twitter" style="padding: 0 10px;" class="tab">
            <div class="field" style="margin-bottom: 10px">
                <label>Tweet</label>
                <textarea id="share_tweet" name="share_tweet" rows="4" cols="70"><?=$params['tweet']?></textarea>
            </div>
            <div style="position: absolute; bottom: 0;width : 96%">
                    <a href="" class="btn btn_blue btn_share_tweet">Tweet</a>
                    <div class="form_loading"></div>
                </div>
        </div>
        
        
        
        
        <div id="tab_share_link" style="padding: 0 10px;" class="tab">
            <div class="field" style="margin-bottom: 10px">
                <label>Paste this link into email or IM</label>
                <input type="text" value="<?=$params['link']?>" class="input" />
            </div>
        </div>
        

    </div>


