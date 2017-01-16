<?php
$f_user = new KSM_User($not->value);
$content = $f_user->display_name_link() . " is now following you";
?>


<li class="<?=($not->read ? 'read' : '')?>">
    <div class="l2">
        <div class="avatar"><?=$f_user->avatar_link('avatar_small')?></div>
        <div class="right">
            <input type="checkbox" class="cb" name="id" value="<?=$not->id?>" />
        </div>
        <div class="message">
            <div style="height: 28px;"><?=$content?></div>
            <div class="date"><?=time_ago($not->date)?></div>
        </div>
        
        <div class="clr"></div>
    </div>
    <div class="l3"></div>
        
</li>