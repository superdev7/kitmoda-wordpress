
<link rel='stylesheet' id='jquery.jscrollpane-css'  href='http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/css/jquery.jscrollpane.css?ver=4.4' type='text/css' media='all' />
<link rel='stylesheet' id='customSelectBox-css'  href='http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/css/customSelectBox.css?ver=4.4' type='text/css' media='all' />


<script type='text/javascript' src='http://staging2.kitmoda.com/kt-encased/js/jquery/jquery.js?ver=1.11.3'></script>
<script type='text/javascript' src='http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/js/jquery.selectBoxIt.js?ver=4.4'></script>

<script type='text/javascript' src='http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/js/slick/slick.js?ver=4.4'></script>

<script type='text/javascript' src='http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/js/functions.js?ver=4.4'></script>

<script type='text/javascript' src='http://staging2.kitmoda.com/kt-encased/js/jquery/ui/mouse.min.js?ver=1.11.4'></script>
<script type='text/javascript' src='http://staging2.kitmoda.com/kt-encased/js/jquery/ui/sortable.min.js?ver=1.11.4'></script>
<script type='text/javascript' src='http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/js/publisher.js?ver=4.4'></script>
<script type='text/javascript' src='http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/js/jquery.caret.min.js?ver=4.4'></script>
<script type='text/javascript' src='http://staging2.kitmoda.com/kt-encased/js/jquery/ui/position.min.js?ver=1.11.4'></script>
<script type='text/javascript' src='http://staging2.kitmoda.com/kt-encased/js/jquery/ui/menu.min.js?ver=1.11.4'></script>




<script type='text/javascript' src='http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/js/jScrollPane.js?ver=4.4'></script>

<script type='text/javascript' src='http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/js/SelectBox.js?ver=4.4'></script>



<script type='text/javascript' src='http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/js/jquery.tooltipster.js?ver=4.4'></script>


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

    <div class="coll_sidebar_shadow purchase_library_stats_box">

        <div class="h1"><span></span></div>

        

        

        

        

        

        <div class="stats">

            

            <div class="collaction_stats section">

                <div class="section_heading">

                    <div class="heading" style="float:left;font-size: 15px; font-family: Montserrat;">YOUR COLLECTION</div>

                    <div class="clr"></div>

                    <div class="community_sidebar_linebreak_dark"></div>
               <div class="community_sidebar_linebreak"></div>

                </div>

                <ul>

                    <li>

                        <span class="stat_name">Total Assets</span>

                        <div class="stat_count"><?=get_number($ksm_user->count_total_purchases)?></div><div class="clr"></div>

                    </li>

                    <li>

                        <span class="stat_name">Textured Models</span>

                        <div class="stat_count"><?=get_number($ksm_user->count_textured_purchases)?></div><div class="clr"></div>

                    </li>

                    <li>

                        <span class="stat_name">Untextured Models</span>

                        <div class="stat_count"><?=get_number($ksm_user->count_untextured_purchases)?></div><div class="clr"></div>

                    </li>

                </ul>

            </div>

            

            

            <div class="purchases_stats section">

                <div class="section_heading">

                    <div class="heading" style="float:left;font-size: 15px; font-family: Montserrat;">YOUR PURCHASES</div>

                    <div class="clr"></div>

                    <div class="community_sidebar_linebreak_dark"></div>
               <div class="community_sidebar_linebreak"></div>

                </div>

                <ul>

                    <li>

                        <span class="stat_name">Total Purchases</span>

                        <div class="stat_count"><?=edd_currency_filter(get_number($ksm_user->count_total_purchased_amount))?></div><div class="clr"></div>

                    </li>

                    <li>

                        <span class="stat_name">Purchased this Year</span>

                        <div class="stat_count"><?=edd_currency_filter($purchased_this_year)?></div><div class="clr"></div>

                    </li>

                    <li>

                        <span class="stat_name">Purchased this Month</span>

                        <div class="stat_count"><?=edd_currency_filter($purchased_this_month)?></div><div class="clr"></div>

                    </li>

                    

                    <li>

                        <span class="stat_name">Purchased <?=$last_year?></span>

                        <div class="stat_count"><?=edd_currency_filter($purchased_last_year)?></div><div class="clr"></div>

                    </li>

                </ul>

            </div>

            

	</div>

        

        

        <div class="community_sidebar_footer"></div>

    </div>

    <div class="clr space20"></div>

    

    

    

    

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

                     <a href="" class="community_sidebar_remove_all remove-btn"

                     style="font-family: Montserrat; font-size: 13px;float:right;">Remove All</a>

                  </div>

                  <div class="clr"></div>

               </div>

                

              <div class="community_sidebar_linebreak_dark"></div>
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

             <div class="community_sidebar_linebreak_dark"></div>
               <div class="community_sidebar_linebreak"></div>

        

               

               

        

        

        

        

        

               <div class="field sort_field" style="margin-top: 20px;">

            <div class="heading" style="float:left;font-size: 13px; font-family: Montserrat;">Sort By</div>

            <div class="clr"></div>

            <div class="community_sidebar_linebreak_dark"></div>
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
