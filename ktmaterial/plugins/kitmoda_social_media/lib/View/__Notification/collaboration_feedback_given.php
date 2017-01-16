<?php
$content = "Your collaboration partner has provided feedback for your project {$active_collaboration_link}";
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

