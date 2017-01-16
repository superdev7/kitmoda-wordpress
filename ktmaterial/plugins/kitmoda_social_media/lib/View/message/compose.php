<?php

global $user_login;


    

$win_title = $to_user ? "Message to {$to_user->user_login}" : "Message";

$images_uploader->build();

$attachment_uploader->build();
?>



<div class="window_inner">

    <iframe name="compose_iframe" class="formframe"></iframe>
    <form method="post" target="compose_iframe" action="<?=admin_url( 'admin-ajax.php' )?>">
    
        
        <div class="win_header" hec="1">
            <div class="title"><?=$win_title?></div>
            <a class="close"></a>
        </div>



        <div class="content">

            <input type="hidden" name="action" value="Message_send">
            <?php if($to_user) : ?>
                <input type="hidden" name="id" value="<?=KSM_Action::compose($to_user->ID)?>" />

            <?php else : ?>
                <div hec="1">
                    <input placeholder="Username" id="username" name="username" type="text" />
                </div>
            <?php endif; ?>

            <textarea name="message" id="message"></textarea>


            <div class="miu_container" align="center" hec="1">
                <span class="btn_attach_photo_btn"></span>
                <ul class="items">
                    <li class="clr"></li>
                </ul>
                <div style="clear: both"></div>
            </div>

            <div class="mau_container" align="center" hec="1">
                <span class="btn_attachment_btn"></span>
                <ul class="items">
                    <li class="clr"></li>
                </ul>
                <div style="clear: both"></div>
            </div>

        </div>

        <div class="footer" id="ksm_toolbar" hec="1">
            <a href="" class="btn btn_blue btn_send">SEND</a>
            <span class="btn_attachment"></span>
            <span class="btn_attach_photo"></span>
            <a href="" class="btn_attach_link"></a>
            <span class="error"></span>

        </div>
    </form>

</div>