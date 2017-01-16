<div class="ksm-menu-container">
    <nav class="ksm-menu">
        <ul>
            <?php foreach((Array) KSM_DataStore::Options('NavTab') as $k=>$v) : ?>
            <li class="<?=$k?><?=($this->main_tab == $k ? ' active' : '')?>">
                <a href="<?=ksm_get_permalink($k);?>"><span><?=strtoupper($v)?></span></a>
            </li>
            <?php endforeach;?>
            <li class="clr"></li>
        </ul>
    </nav>
</div>