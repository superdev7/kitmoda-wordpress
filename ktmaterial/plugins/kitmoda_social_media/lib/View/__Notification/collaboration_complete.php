<?php




$download = KSM_Download::get($download_id);


$img = $download->thumb();

$download_link = '<a href="'.$download->link().'">'.$download->post_title.'</a>';
$rate_link = '<a href="'.$download->link().'">HERE</a>';




$content = "Your collaboration partner has completed the project and published it to the store {$download_link}.  Rate this interaction {$rate_link}";



?>


<li class="<?=($read ? 'read' : '')?>">
    <div class="l2">
        <div class="avatar"><?=($thumb ? $thumb : '')?></div>
        <div class="right">
            <input type="checkbox" class="cb" name="id" value="<?=$id?>" />
        </div>
        <div class="message">
            <div style="height: 28px;"><?=$content?></div>
            <div class="date"><?=$time_ago?></div>
        </div>
        
        <div class="clr"></div>
    </div>
    <div class="l3"></div>
        
</li>