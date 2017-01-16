<script type="text/javascript">
    
    function change_tab(t) {
        $('.tabs_content .tab').hide();
        $('.tabs_content #tab_'+t).show();
        $('.share_tabs li').removeClass('active');
        $('.share_tabs li[rel="'+t+'"]').addClass('active');
    }
    
    
    
    
    
    $(function() {
        $('body').height('100%');
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

    <div class="win_header" hec="1">
        <div class="title">Share</div>
        <a class="close"></a>
    </div>

    <div id="fb-root"></div>


    <ul class="share_tabs">
        <li rel="share_email" class="active"><span>Email</span></li>
        <li rel="share_facebook"><span>Facebook</span></li>
        <li rel="share_twitter"><span>Twitter</span></li>
        <li rel="share_link"><span>Link</span></li>
        <li class="clr"></li>
    </ul>



    <div class="tabs_content">
        <?php


        $this->render_element('email', array('params' => $share_params));
        $this->render_element('facebook', array('params' => $share_params));
        $this->render_element('twitter', array('params' => $share_params));
        $this->render_element('link', array('params' => $share_params));
        ?>
    </div>


