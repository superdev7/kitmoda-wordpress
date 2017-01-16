<?php 
$comment_meta = get_comment_meta($comment->comment_ID);



$likes_count = ($comment_meta['likes_count'][0]) ? $comment_meta['likes_count'][0] : 0;;
$clike_action = KSM_Action::comment_like_toggle($comment);


if($comment->user_id) :
    $cauthor = new KSM_User($comment->user_id);


?>


<div class="comment">
    <div class="avatar_comment_small">
        <?=$cauthor->avatar_link()?>
    </div>
    
    
    <div class="comment_content_container">
        <div class="comment_header">
            <?=$cauthor->display_name_link()?>
            <div class="date"><?=(date('M j, Y', strtotime($comment->comment_date)))?></div>
            <div class="clr"></div>
        </div> 

        <div class="comment_content_community">
            <?=htmlentities($comment->comment_content)?>
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

<?php endif; ?>