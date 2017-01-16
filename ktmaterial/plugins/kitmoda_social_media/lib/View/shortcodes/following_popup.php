<div class="window_content">
    
    <div class="win_header" hec="1">
        
        <div class="title">Following <span class="counter"><?=get_number($ksm_profile->profile_user->followings_count)?></span></div>
        <a class="close"></a>
    </div>
    
    <div class="content">

        <ul class="followings">
            <?php foreach($ksm_profile->following['results'] as $f) : 
                $avatar = ksm_avatar($f->ID, 'avatar_large');
                $class = $class == 'even' ? 'odd' : 'even';

                $tagline = $f->tagline;
                $tagline = strlen($tagline) > 28 ? substr($tagline, 0, 25).'...' : $tagline;?>
                <li class="<?=$class?>">
                    <div class="avatar"><img src="<?=$avatar?>" width="85" /></div>
                    <div class="info">
                        <div class="username"><?=$f->display_name();?></div>
                        <?php if($f->tagline) :?>
                        <div class="tagline"><blockquote><?=$tagline?></blockquote></div>
                        <?php endif; ?>
                        <?php if($f->country) :?>
                        <div class="location"><?=$GLOBALS['countries'][$f->country]?></div>
                        <?php endif; ?>
                        <div class="followers"><?=get_number($f->followers_count)?></div>
                    </div><div class="clr"></div>
                </li>
            <?php endforeach;?>
                <li class="clr"></li>
        </ul>

    </div>
    <div class="footer" hec="1">
        <div class="pagination jspaging">
            <?php
            $prev_page = $ksm_profile->following['current_page'] > 1 ? $ksm_profile->following['current_page']-1 : false;
            $next_page = $ksm_profile->following['current_page'] < $ksm_profile->following['pages_count'] ? $ksm_profile->following['current_page'] + 1 : false;
            ?>

            <?php if($prev_page) :?>
                <a href="<?=get_pagenum_link($prev_page)?>" class="prev"></a>
            <?php endif; ?>
                <span class="info"><?=$ksm_profile->following['current_page']?> of <?=$ksm_profile->following['pages_count']?></span>
            <?php if($next_page) :?>
                <a href="<?=get_pagenum_link($next_page)?>" class="next"></a>
            <?php endif; ?>
        </div>
    </div>
</div>