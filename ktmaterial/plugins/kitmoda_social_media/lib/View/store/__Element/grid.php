<div class="grid_view_container">
    <div class="grid_view">
        <div class="grid">
            <div class="grid_page" id="<?=$this->name?>_grid_page_<?=$this->current_page?>">
                <?php
                $c = 0;
                global $wp_query;
                while ( $wp_query->have_posts() ) : $wp_query->the_post();
                    //$this->render_element('grid_item');
                    include 'grid_item.php';
                    $c++;
                endwhile;
                
                //foreach($this->results as $p) : 
                //    $grid_img = $this->getGridImage($p);
                //    include 'grid_item.php';
                //    $c++;
                //endforeach;
                ?>
            </div>
        </div>
    </div>
    
    
    
    
    
    
</div>