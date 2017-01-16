<?php

class KSM_Js {
    
    
    
    
    static function get_parent($level = 1) {
        
        $parent = array();
        
        for($i = 1; $i <= $level; $i++) {
            $parent[] = 'window.parent';
        }
        
        $window = implode('.', $parent);
        
        return $window;
    }
    
    static function reloadPage($url, $level = 1) {
        
        
        $window = KSM_Js::get_parent($level);
        
        
        $script = "{$window}.location = '{$url}'";
        echo self::run($script);
        
        
    }
    
    
    
    
    static function forceReloadPageWithMessage($msg) {
        
        
        $script  = "window.top.showfmsg(\"{$msg}\");";
        
        $script .= 'window.top.location.reload();';
        $script .= 'window.top.$.colorbox.close();';
        
        
        echo self::run($script);
    }
    
    
    static function reloadPageWithMessage($url, $msg , $level = 1) {
        $window = KSM_Js::get_parent($level);
        
        
        
        
        $script  = "{$window}.showfmsg(\"{$msg}\");";
        
        
        if(!$url) {
            $script .= "var loc = {$window}.location;";
            $script .= "{$window}.location = loc;";
        } else {
            $script .= "{$window}.location = '{$url}';";
        }
        
        $script  .= "{$window}.$.colorbox.close();";
        
        echo self::run($script);
    }
    
    static function setWallPostError($error) {
        
        
        $script = 'window.parent.$(".add_the_post .add_post_form .error").html("'.$error.'").show();';
        $script .= 'window.parent.$(".add_the_post .add_post_form .success").html("").hide();';
        echo self::run($script);
    }
    
    
    static function setCWipFeedbackError($error) {
        
        
        $script = 'window.parent.$(".cwip_feedback_form .error").html("'.$error.'").show();';
        $script .= 'window.parent.$(".cwip_feedback_form .success").html("").hide();';
        echo self::run($script);
    }
    
    
    
    static function setCMessageError($error) {
        
        
        $script = 'window.parent.$(".cmiu_message_form .error").html("'.$error.'").show();';
        $script .= 'window.parent.$(".cmiu_message_form .success").html("").hide();';
        echo self::run($script);
    }
    
    
    static function onStudioPostAdded($post_id) {
        
        $_id = KSM_Action::ksmPostID($post_id);
        
        $url = home_url("studio/post_options/{$post_id}");
        
        $script ='window.parent.$(".add_post_form [name=_id]").val("'.$_id.'");';
        $script .='window.parent.opencb("'.$url.'")';
        
        echo self::run($script);
    }
    
    
    static function onCommunityPostAdded($post_id) {
        
        $_id = KSM_Action::ksmPostID($post_id);
        
        $url = home_url("community/post_options/{$post_id}");
        
        $script ='window.parent.$(".add_post_form [name=_id]").val("'.$_id.'");';
        $script .='window.parent.opencb("'.$url.'")';
        
        echo self::run($script);
    }
    
    
    
    static function setLoginError($error) {
        $script = 'window.parent.$(".error").html("'.$error.'").show();';
        $script .= 'window.parent.$(".success").html("").hide();';
        echo self::run($script);
    }
    
    
    static function success_forgot_password() {
        
        
        $script = '
            window.top.showfmsg("Check your email for a link to reset your password." , "success");
            
            window.top.$.colorbox.close();
            
        ';
        echo self::run($script);
    }
    
    
    static function setLoginSuccess($ara = '') {
        $url = ksm_get_permalink('studio');
            
        if($ara == 'community_add_post') {
            $url = ksm_get_permalink('community');
        } elseif($ara == 'collaboration_active') {
            $url = ksm_get_permalink('collaboration/active/');
        } elseif($ara == 'collaboration_launch') {
            $url = ksm_get_permalink('collaboration/launch/');
        } elseif($ara == 'collaboration_requests') {
            $url = ksm_get_permalink('collaboration/requests/');
        } elseif($ara == 'collaboration_partner_projects') {
            $url = ksm_get_permalink('collaboration/partner_projects/');
        } elseif($ara == 'account_messages') {
            $url = ksm_get_permalink('account/messages/');
        } elseif($ara == 'account_purchase_library') {
            $url = ksm_get_permalink('account/purchase_library/');
        } elseif($ara == 'account_sales') {
            $url = ksm_get_permalink('account/sales/');
        } elseif($ara == 'account_products') {
            $url = ksm_get_permalink('account/products/');
        }
        
        
        
        
        $script = 'window.top.$(".error").html("").hide();';
        $script .= 'window.top.location = "'.$url.'";';
        $script .= 'window.top.$.colorbox.close();';
        echo self::run($script);
    }
    
    
    static function setModelReturnError($error) {
        $script = 'window.parent.$(".return_message").html("'.$error.'").show();';
        echo self::run($script);
    }
    
    static function setProfileEditError($error) {
        $script = 'window.parent.$(".error").html("'.$error.'").show();';
        echo self::run($script);
    }
    
    static function setWipPostError($error) {
        $script = 'window.parent.$(".error").html("'.$error.'").show();';
        echo self::run($script);
    }
    
    static function setEmailShareError($error) {
        $script = 'window.parent.$("#tab_share_email .error").html("'.$error.'").show();';
        $script .= 'window.parent.$("#tab_share_email .form_loading").hide();';
        echo self::run($script);
    }
    
    static function setEmailShareSuccess() {
        
        $script  = 'window.parent.$("#tab_share_email .error").html("").hide();';
        $script .= 'window.parent.$("#tab_share_email .form_loading").hide();';
        $script .= 'window.parent.window.parent.showfmsg("Your message has been sent.");';
        $script .= 'window.parent.window.parent.$.colorbox.close();';
        echo self::run($script);
    }
    
    
    static function setCollaborationJoinRequestSuccess() {
        $script = 'window.parent.window.parent.showfmsg("Your request has been sent.");';
        $script .= 'window.parent.window.parent.$.colorbox.close();';
        echo self::run($script);
    }
    
    
    static function closeColorBoxWithError($error) {
        $script  = 'window.parent.window.parent.showfmsg("'.$error.'" , "error");';
        $script .= 'window.parent.window.parent.$.colorbox.close();';
        echo self::run($script);
    }
    
    
    
    static function onCollaborationRequestReject($id) {
        $script = 'window.parent.$("#req_'.$id.' .rfooter .buttons").html("<div class=\"rejected\">Rejected</div>");';
        $script .= 'window.parent.$.colorbox.close();';
        echo self::run($script);
    }
    
    
    static function onCollaborationRequestAccept($id) {
        $script = 'window.parent.$("#req_'.$id.' .rfooter .buttons").html("<div class=\"accepted\">Accepted</div>");';
        echo self::run($script);
    }
    
    
    static function AddWipImage($post, $img_attachment) {
        
        $script = 'window.parent.$(".error").html("").hide();';
        $script .= 'window.parent.window.parent.showfmsg("WIP Image added");';
        $script .= 'window.parent.window.parent.tb_remove();';
        echo self::run($script);
    }
    
    
    static function fb_init_share($params) {
        
        $script = 
        'function fb_feed_post() {
            window.parent.FB.api("/me/feed", "post", {
                description: "'.$params['description'].'" ,
                message : "'.$params['comment'].'" ,
                picture: "'.$params['picture'].'",
                caption: "'.$params['caption'].'",
                link : "'.$params['link'].'"
            }, function(response) {
                if (!response || response.error) {
                    window.parent.$("#tab_share_facebook .form_loading").hide();
                } else {
                    window.parent.window.parent.showfmsg("Your message has been posted.");
                    window.parent.window.parent.$.colorbox.close();
                }
            });
        };
        
        
        window.parent.FB.getLoginStatus(function(response) {
            if (response.status === "connected") {
                fb_feed_post();
            }
          else {
            window.parent.FB.login(function(response) {
                fb_feed_post();
            }, {scope: "publish_actions"});
          }
        });';
        echo self::run($script);
        
        
    }
    
    static function setProfileEditSuccess() {
        $script = 'window.parent.$(".error").html("").hide();';
        $script .= 'window.top.location.reload();';
        $script .= 'window.top.$.colorbox.close();';
        echo self::run($script);
    }
    
    
    static function cbCloseWithMessage($msg) {
        $script = 'window.parent.window.parent.showfmsg("'.$msg.'");';
        $script .= 'window.parent.window.parent.$.colorbox.close();';
        echo self::run($script);
    }
    
    
    static function MessageSent() {
        $script = 'window.parent.window.parent.showfmsg("Message Sent");';
        $script .= 'window.parent.window.parent.$.colorbox.close();';
        echo self::run($script);
    }
    
    static function SettingsSaved() {
        $script = 'window.parent.window.parent.showfmsg("Settings saved");';
        $script .= 'window.parent.window.parent.$.colorbox.close();';
        echo self::run($script);
    }
    
    
    
    
    static function setMessageSendError($error) {
        $script .= 'window.parent.$(".footer .error").html("'.$error.'").show();';
        
        echo self::run($script);
    }
    
    
    static function setPopupError($error) {
        $script = 'window.parent.$(".footer .error").html("'.$error.'").show();';
        $script .= 'window.parent.$(".footer .ksm_loading").hide();';
        $script .= 'window.parent.$(".footer .success").html("").hide();';
        $script .= 'window.parent.$(".footer .btn").removeClass("disabled");';
        
        echo self::run($script);
    }
    
    
    static function setRateError($error) {
        $script = 'window.parent.$(".cfooter .error").html("'.$error.'").show();';
        $script .= 'window.parent.$(".cfooter .ksm_loading").hide();';
        $script .= 'window.parent.$(".cfooter .success").html("").hide();';
        $script .= 'window.parent.$(".cfooter .btn").removeClass("disabled");';
        
        echo self::run($script);
    }
    
    static function setPublisherError($error, $step = '') {
        
        $script = 'window.parent.kp.setError("'.$error.'", "'.$step.'");';
        
        echo self::run($script);
    }
    
    
    static function setWallCommentError($wpid, $error) {
        
        
        $script .= 'window.parent.$(".ksm_profile_user_wall .content .posts .post#wp_'.$wpid.' .post_comments .error").html("'.$error.'").show();';
        $script .= 'window.parent.$(".ksm_profile_user_wall .content .posts .post#wp_'.$wpid.' .post_comments .success").html("").hide();';
        
        echo self::run($script);
        
    }

    static function setCommunityCommentError($wpid, $error) {
        
        
        $script .= 'window.parent.$(".posts .post#wp_'.$wpid.' .add_comment .error").html("'.$error.'").show();';
        $script .= 'window.parent.$(".posts .post#wp_'.$wpid.' .add_comment .success").html("").hide();';
        
        echo self::run($script);
        
    }
    
    
    static function wallPostDeleted($post_id, $msg, $galleries = array()) {
        $script = 'window.top.$(".ksm_profile_user_wall .content .posts .post#wp_'.$post_id.'").remove();';
        $script .= 'window.top.showfmsg("'.$msg.'");';
        
        if($galleries) {
            $script .= 'window.top.kmv.reset("'.implode(',', $galleries).'");';
        }
        
        $script .= 'window.top.$.colorbox.close();';
        
        echo self::run($script);
    }
    
    static function communityPostDeleted($post_id, $msg, $galleries = array()) {
        
        
        
        $script = 'window.top.community_facet.load();';
        $script .= 'window.top.showfmsg("'.$msg.'");';
        
        if($galleries) {
            $script .= 'window.top.kmv.reset("'.implode(',', $galleries).'");';
        }
        
        $script .= 'window.top.$.colorbox.close();';
        
        echo self::run($script);
    }
    
    
    static function editCommunityPost($post_id, $item, $galleries='') {
        
        $script .= 'window.top.edit_post("'.$post_id.'", "'.addslashes($item).'", "'.$galleries.'");';
        echo self::run($script);
    }
    
    static function editWallPost($post_id, $wall_item, $galleries = array()) {
        $msg = "Post updated.";
        
        $wall_item = addslashes($wall_item);
        
        
        
        $script = 'window.top.$(".ksm_profile_user_wall .content .posts .post#wp_'.$post_id.' .post_content").html(window.top.$("'.$wall_item.'").find(".post_content").html());';
        $script .= 'window.top.showfmsg("'.$msg.'");';
        
        
        
        if($galleries) {
            $script .= 'window.top.kmv.reset("'.implode(',', $galleries).'");';
        }
        
        
        $script .= 'window.top.$.colorbox.close();';
        
        echo self::run($script);
    }
    
    static function addWallPost($wall_item, $galleries = array()) {
        
        $msg = "Post submitted.";
        //$script = 'window.top.$(".ksm_profile_user_wall .content .posts").prepend("'.addslashes($wall_item).'");';
        $script .= 'window.parent.$(".ksm_profile_user_wall .add_post_form .success").html("'.$msg.'").show();';
        $script .= 'window.top.$(".ksm_profile_user_wall .add_post_form .error").html("").hide();';
        $script .= 'window.top.$(".ksm_profile_user_wall .add_post_form textarea").val("");';        
        $script .= 'window.top.$(".ksm_profile_user_wall .add_post_form .miu_container li.item").remove();';
        if($galleries) {
            $script .= 'window.top.kmv.reset("'.implode(',', $galleries).'");';
        }
        $script .= 'window.top.$(".add_post_form [name=_id]").val("");';
        
        $script .= 'window.top.$(".ksm_profile_user_wall .empty_msg").hide();';
        
        
        //$script .= 'window.top.$(".ksm_profile_user_wall .content .posts").trigger("post_added");';
        
        $script .= 'window.top.angular.element(".ksm_profile_user_wall .content .posts").scope().post_reload();';
        
                
                
        
        $script .= 'window.top.$.colorbox.close();';
        
        
        
        
        
        echo self::run($script);
    }
    
    
    
    static function addCommunityPost($item, $galleries=array()) {
        
        $script .= 'window.top.add_new_post(\''. $item .'\', "'.implode(',', $galleries).'");';
        echo self::run($script);
    }
    
    
    
    
    
    static function openCbox($url) {
        
        $script .='window.parent.opencb("'.$url.'")';
        echo self::run($script);
    }
    
    static function addWallComment($wpid, $item, $count) {
        $msg = "Comment posted.";
        $script = 'var wpc_item = window.parent.$("'.addslashes($item).'").hide();';
        $script .= 'window.top.$(".ksm_profile_user_wall .content .posts .post#wp_'.$wpid.' .post_comments .comments").prepend(wpc_item);';
        $script .= 'wpc_item.slideDown();';
        $script .= 'window.top.$(".ksm_profile_user_wall .content .posts .post#wp_'.$wpid.' .post_comments .comments_stats .stat_comments .count").html("'.$count.'");';
        //$script .= 'window.parent.$(".ksm_profile_user_wall .content .posts .post#wp_'.$wpid.' .post_comments .success").html("'.$msg.'").show();';
        $script .= 'window.parent.$(".ksm_profile_user_wall .content .posts .post#wp_'.$wpid.' .post_comments .error").html("").hide();';
        $script .= 'window.parent.$(".ksm_profile_user_wall .content .posts .post#wp_'.$wpid.' .post_comments .add_comment_form textarea").val("");';
        
        
        
        
        
        $script .=
        
        'if(window.parent.$(".ksm_profile_user_wall .content .posts .post#wp_'.$wpid.' .post_comments .comments:hidden").length > 0) {
            window.parent.$(".ksm_profile_user_wall .content .posts .post#wp_'.$wpid.' .post_comments .comments_toggle").trigger( "click" );
            window.parent.$(".ksm_profile_user_wall .content .posts .post#wp_'.$wpid.' .post_comments .comments_header").removeClass( "no_comments" );
         }';
        
        
        echo self::run($script);
    }
    
    
    static function addCommunityComment($post_id, $item) {
        $msg = "Comment posted.";
        $script = 'var _item = window.parent.$("'.addslashes($item).'").hide();';
        $script .= 'window.parent.$(".posts .post#wp_'.$post_id.' .post_comments .comments").prepend(_item);';
        $script .= '_item.slideDown();';
        //$script .= 'window.parent.$(".ksm_profile_user_wall .content .posts .post#wp_'.$wpid.' .post_comments .success").html("'.$msg.'").show();';
        
        
        
        
        
        $script .= 'window.top.new_comment_added('.$post_id.');';
        
        
        echo self::run($script);
    }
    
    
    
    
    
    
    
    

    static function run($script) {
        ob_start();
        ?>
        <script type="text/javascript">
            <?=$script?>
        </script>
        <?php
        return ob_get_clean();
    }
    
    
}



?>