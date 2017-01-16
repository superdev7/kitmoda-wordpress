<?php


$f_user = get_user_by('id', $not->value);

if(in_array($not->value, array_keys(KSM_Award::$permanent_awards))) {
    $award = KSM_Award::$permanent_awards[$not->value];
} elseif(in_array($not->value, array_keys(KSM_Award::$temporary_awards))) {
    $award = KSM_Award::$temporary_awards[$not->value];
}





$img = KSM_BASE_URL."images/awards/{$not->value}.png";
$content = "congratulations, you have received the {$award['title']} award.";



?>


<li class="<?=($not->read ? 'read' : '')?>">
    <div class="l2">
        <div class="avatar">
            <?php if($img) : ?><img src="<?=$img?>" /><?php endif; ?>
        </div>
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