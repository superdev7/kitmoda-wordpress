
<?php





$dat_pur = $ksm_user->dated_purchases;


$current_year = date('Y');

$last_year = $current_year - 1;

$this_month_key = $current_year.'_'.date('m');


$purchased_this_year = get_number($dat_pur['year'][$current_year]);
$purchased_this_month = get_number($dat_pur['month'][$this_month_key]);

$purchased_last_year = get_number($dat_pur['year'][$last_year]);








?>



<div class="coll_sidebar">
    
    
    
    
    
    
    <div class="coll_sidebar_shadow">



     <div class="h1"><span></span></div>
     
    <div class="filter_nav">
        
        
        <div class="search">
            <input name="q" id="ff_q" type="text" class="roen" placeholder="Search Posts..." />
            <div class="button rocl"><span></span></div>
            <div class="clr"></div>
        </div>
        
        
        
        
        
        
        
        
        
        <div class="filter_header">
                  <div class="heading" style="float:left;font-size: 13px; font-family: Montserrat;">FILTER</div>
                  <div class="opt_remove_all">
                     <a href="" class="community_sidebar_remove_all"
                     style="font-family: Montserrat; font-size: 13px;float:right;">Remove All</a>
                  </div>
                  <div class="clr"></div>
               </div>
                
               <div class="community_sidebar_linebreak"></div>
               
               <div class="field" style="padding-top: 5px; padding-bottom: 2px;">
                  <div class="sidebar_checkbox">
                     <input type="checkbox" name="mt[]" id="ff_mt_textured" value="textured" class="opt_filter" />
                  </div>
                  <div>
                     <label for="ff_mt_textured" class="sidebar_filtername">TEXTURED MODELS</label>
                  </div>
                   <div class="clr"></div>
               </div>
               <div class="field">
                  <div class="sidebar_checkbox">
                     <input type="checkbox" name="mt[]" id="ff_mt_untextured" value="untextured" class="opt_filter" />
                  </div>
                  <div>
                     <label for="ff_mt_untextured" class="sidebar_filtername">UNTEXTURED MODELS</label>
                  </div>
                   <div class="clr"></div>
               </div>
               <div class="community_sidebar_linebreak"></div>
        
               
               
        
        
        
        
        
               <div class="field sort_field" style="margin-top: 20px;">
            <div class="heading" style="float:left;font-size: 13px; font-family: Montserrat;">Sort By</div>
            <div class="clr"></div>
            <div class="community_sidebar_linebreak"></div>
            <select name="sort" id="ff_sort" class="opt_filter roch">
                <option value="">Newest</option>
                <option value="oldest">Oldest</option>
            </select>
        </div>
        <div class="clr space"></div>
        
        <input type="hidden" name="page" id="ff_page" value="" />
        <input type="hidden" name="ksm_auth_id" priv="true" value="<?=$ksm_auth_id?>" />
        
    </div>
    <div class="community_sidebar_footer"></div>
        
    </div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</div>