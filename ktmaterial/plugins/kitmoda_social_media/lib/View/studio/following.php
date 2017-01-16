<div class="window_inner">
    
    <div class="win_header" hec="1">
        
        <div class="title">Following <span class="counter"><?=get_number($following['total'])?></span></div>
        <a class="close"></a>
    </div>
    
    <div class="content">

        <ul class="followings">
            <?php foreach($following['results'] as $f) : 
                $avatar = ksm_avatar($f->ID, 'avatar_large');
                $class = $class == 'even' ? 'odd' : 'even';
                
                //pr($f->country);
                
                $country = $f->country ? KSM_DataStore::Option('country', $f->country) : '';
                
                $tagline = $f->tagline;
                $tagline = strlen($tagline) > 28 ? substr($tagline, 0, 25).'...' : $tagline;?>
                <li class="<?=$class?>">
                    
                    <div class="avatar"><?=$f->avatar_link('avatar_small_2', 'kpload')?></div>
                    <div class="info">
                        <div class="username"><?=$f->display_name_link(true);?></div>
                        <?php if($f->tagline) :?>
                        <div class="tagline"><blockquote><?=$tagline?></blockquote></div>
                        <?php endif; ?>
                        <?php if($f->country) :?>
                        <div class="location"><?=$country?></div>
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
            $prev_page = $following['current_page'] > 1 ? $following['current_page']-1 : false;
            $next_page = $following['current_page'] < $following['pages_count'] ? $following['current_page'] + 1 : false;
            ?>

            <?php if($prev_page) :?>
                <a href="<?=get_pagenum_link($prev_page)?>" class="colorbox prev"></a>
            <?php endif; ?>
                <span class="info"><?=$following['current_page']?> of <?=$following['pages_count']?></span>
            <?php if($next_page) :?>
                <a href="<?=get_pagenum_link($next_page)?>" class="colorbox next"></a>
            <?php endif; ?>
        </div>
    </div>
</div>