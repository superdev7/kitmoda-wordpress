<?php 
$comment_meta = get_comment_meta($wpc->comment_ID);


//$comment_views = ($comment_meta['views_count'][0]) ? $comment_meta['views_count'][0] : 0;
$likes_count = ($comment_meta['likes_count'][0]) ? $comment_meta['likes_count'][0] : 0;


$clike_action = KSM_Action::comment_like_toggle($wpc);



if($wpc->user_id) :
    $cauthor = new KSM_User($wpc->user_id);

?>


        
<div class="comment" id="wpc_<?=$wpc->comment_ID?>">
    <div class="avatar">
        <img class="radius" src="<?=ksm_avatar($wpc->user_id)?>" />
    </div>
    <div class="comment_content_container">
        <div class="comment_header">
            <?=$cauthor->display_name_link()?>
            <div class="date"><?=(date('M j, Y', strtotime($wpc->comment_date)))?></div>
            
            <?php if($wpc->user_id == get_current_user_id()) : ?>
                    
                    <ul class="comment_actions">
                        <li class="edit_comment"><a class="colorbox" href="<?=ksm_get_permalink("studio/edit_comment/$wpc->comment_ID")?>">EDIT</a></li>
                        <li class="delete_comment"><a>DELETE</a></li>
                        <li class="clr"></li>
                    </ul>
                    
                    <?php endif; ?>
            <div class="clr"></div>
        </div> 
        <div class="comment_content">
            <?=htmlentities($wpc->comment_content)?>
        </div>
        <div class="footer">
            <ul class="comment_stats">
                <li class="likes">
                    <span type="clike" class="button <?=$clike_action['class']?>" rel="<?=$clike_action['action']?>"></span>
                    <span class="count"><?=$likes_count?></span>
                </li><li class="clr"></li>
            </ul>
        </div>
    </div><div class="clr"></div>
</div>

<?php 
endif;
//$comment_views++;
//update_comment_meta($wpc->comment_ID , 'views_count', $comment_views); 
?>