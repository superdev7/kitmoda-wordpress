<div class="pagination">
    <?php if($p != 1): ?>
        <a p="<?=($p-1)?>" href="" class="prev"></a>
    <?php endif; ?>
    
    <span class="info"><?=$p?> of <?=$total_pages?></span>
    
    <?php if($p != $total_pages): ?>
        <a p="<?=($p+1)?>" href="" class="next"></a>
    <?php endif; ?>
    
</div>