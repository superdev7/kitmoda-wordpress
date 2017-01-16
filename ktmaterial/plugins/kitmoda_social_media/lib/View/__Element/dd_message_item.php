<?php
$sender = new KSM_User($msg->sent_from);
//$avatar = ksm_avatar($msg->sent_from, 'avatar_small');



$content = strip_tags($msg->post_content);
//$content = htmlentities($msg->post_content);
$content = strlen($content) > 120 ? substr($content, 0, 120).'...' : $content;

$have_photos = $msg->have_photos;
$have_photos = $msg->have_files;
$att_indicators = array();

if($msg->have_photos) {
    $att_indicators[] = 'photo';
}
if($msg->have_attachments) {
    $att_indicators[] = 'files';
}



?>


<li class="<?=(($msg->read) ? 'read' : '')?>">
    <div class="l1">
        <?=$sender->display_name_link();?>
        <div class="right">
            <div class="date"><?=time_ago($msg->post_date)?></div>
            <input type="checkbox" class="cb" name="id" value="<?=$msg->ID?>" />
            <div class="clr"></div>
        </div>
        <div class="clr"></div>
    </div>
    <div class="l2 <?=$have_photos?>">
        <div class="avatar"><?=$sender->avatar_link()?></div>
        <div class="message"><?=$content?></div>
        <div class="clr"></div>
        <?php if($att_indicators) :?>
            <ul class="attach_types">
                <?php if(in_array('photo', $att_indicators)): ?>
                <li class="photo"><a href="<?=ksm_get_permalink("message/dl_images/{$msg->ID}")?>"></a></li>
                    <?php endif;
                if(in_array('files', $att_indicators)) : ?>
                    <li class="files"></li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </div>
    <div class="l3"></div>
        
</li>