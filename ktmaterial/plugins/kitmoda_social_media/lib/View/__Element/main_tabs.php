<div class="row row-inset ksm-menu-container">
    <nav class="col-xs-12 col-md-10 col-md-offset-1 ksm-menu">
        <ul>
            <?php foreach((Array) KSM_DataStore::Options('NavTab') as $k=>$v) : ?>
                <li class="<?=$k?><?=($this->main_tab == $k ? ' active' : '')?>">
                    <a href="<?=ksm_get_permalink($k);?>"><span><?=strtoupper($v)?></span></a>
                </li>
            <?php endforeach;?>
        </ul>
    </nav>
</div>