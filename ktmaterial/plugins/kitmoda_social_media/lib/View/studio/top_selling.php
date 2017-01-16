<div class="window_inner">
    
    
    <script type="text/javascript">
    
    var _facet;
    $(function() {
        
        _facet = new kjgajlist({
            element : '.window_inner',
            action : 'Studio_filter_top_sellings',
            resize : 'cb_m_resize'
        });
        
        
        
        $('body').delegate('.stats .bg', 'click', function() {
        window.top.location = $(this).closest('.item').find('.item_link').attr('href');
        });
        
    });
    
    
    
    
    </script>
    
    
    
    <div class="win_header" hec="1">
        <div class="title">Top Selling <span class="counter"><?=get_number($this->KUser->Access->top_selling_count)?></span></div>
        <a class="close"></a>
    </div>
    
    <div class="content">
        <div class="favories_multi_gallery ksm_gallery_multi_views">
            <div class="mini_grid_view_container">
                <div class="grid_view">
                    <div class="grid">
                        <div class="posts">
                            <?=$this->render_element('loading');?>
                        </div>
                    </div>
                <!-- other images... -->
                </div>
            </div>
        </div>
    </div>
    <div class="ff_opts">
        <input type="hidden" name="page" id="ff_page" value="" />
        <input type="hidden" name="studio" prv="1" value="<?=$studio_id?>" />
    </div>
    <div class="footer" hec="1">
        <div class="pagination"></div>
    </div>
</div>