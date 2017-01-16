<div class="grid_view_container">
    <div class="grid_view">
        <div class="grid">
            <div class="grid_page" id="<?=$this->name?>_grid_page_<?=$this->current_page?>">
                <?php
                //$item_index = 0;
                //foreach($this->results as $p) : 
                //    if($this->count_grid_view) KSM_postView::add($p);
                ///    echo $this->renderGridItem($p, $item_index);
                //    $item_index++;
                //endforeach;
                ?>
            </div>
        </div>
    </div>
    
    
    <div style="padding: 34px 0 60px 0">
    
        <div class="grid_back_btn"><a href="">CLOSE</a></div>    

        <div class="ksm_pagination">
            <?=$this->paginate_links()?>
        </div>
    </div>
    
    
    
</div>