<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script>

$(document).ready(function(){
$(":checkbox").on('click', function(){
    $(this).parent().toggleClass("checked");
	
});
$(".opt_remove_all").click(function () {       
		     
          
			$(".sidebar_checkbox ").removeClass("checked");
        });


});





        
    
</script>

<link rel="stylesheet" type="text/css" href="http://staging2.kitmoda.com/ktmaterial/plugins/kitmoda_social_media/css/sunny/account.css" />
<?php $this->render_element('main_tabs'); ?>

<div class="ksm-menu-sub-menu_container">

    	

        <div class="shrink-wrap-backdrop">

            <div class="shrink-wrap-vignette-left">

            </div>

            

            <div class="shrink-wrap-vignette-right">

            </div>

            

             <div class="shrink-wrap-findcenter">

                <div class="shrink-wrap-inner-highlight" style="left: 150px;">

                        <div class="shrink-wrap-inner-highlight-left"></div>

                        <div class="shrink-wrap-inner-highlight-mid"></div>

                        <div class="shrink-wrap-inner-highlight-right"></div>

                </div>

            </div>

	<div class="shrink-wrap-inner-shadow"></div>

        <div class="shrink-wrap-bottom-shadow"></div>  

    </div>



       

	

	

        

   



</div>







<?php



$year_stats = $ksm_user->year_sales();

$month_stats = $ksm_user->month_sales();



$day_stats = $ksm_user->day_sales();

?>









<div class="ksm_profile_container">    







<div class="ksm_profile_container_overlay">

    <div class="ksm_profile ksm_page_collaboration">

        <div class="header_highlight_community">

            <div class="header radius_top">

                <div class="wall_title">ACCOUNT</div><div class="clr"></div>

            </div>

        </div>

        <div class="main_content account_sales_main">

            

            <?php $this->render_element('account_sub_tabs'); ?>

            

            

            

            

            

            

            

            

            <div class="pr-col">

                

                

                

                

                

             <div class="sale_stats-contaner">   
<div class="pr-col_container_top"></div>
        <div class="sale_stats">

            

            <div class="section_heading">

                    <div class="heading" style="float:left;font-size: 15px; font-family: Montserrat;">SALES STATS</div>

                    <div class="clr"></div>

                    <div class="collaboration_sidebar_linebreak_mid"></div>
                    <div class="collaboration_sidebar_linebreak"></div>

            </div>

            <div class="total_stats section">

                <ul>

                    <li>

                        <div class="stat_name">Products Sales Total</div>

                        <div class="stat_count"><?=get_number($ksm_user->count_sales)?></div><div class="clr"></div>

                        <div class="clr"></div>

                    </li>

                    <li>

                        <div class="stat_name">Sales Revenue Total</div>

                        <div class="stat_count amount"><?=edd_currency_filter(get_number($ksm_user->count_revenue))?></div><div class="clr"></div>

                        <div class="clr"></div>

                    </li>

                    <li>

                        <div class="stat_name">Income Total</div>

                        <div class="stat_count amount"><?=edd_currency_filter(get_number($ksm_user->count_income))?></div><div class="clr"></div>

                        <div class="clr"></div>

                    </li>

                    <li class="clr"></li>

                </ul>

            </div>

            

            <div class="collaboration_sidebar_linebreak_mid"></div>
                    <div class="collaboration_sidebar_linebreak"></div>

            

            <div class="dated_sale_stats section">

                

                

                <ul class="year_stats">

                    <li>

                        <div class="stat_name">Products Sold this Year</div>

                        <div class="stat_count"><?=get_number($year_stats['sales'])?></div><div class="clr"></div>

                        <div class="clr"></div>

                    </li>

                    <li>

                        <div class="stat_name">Sales Revenue this Year</div>

                        <div class="stat_count amount"><?=edd_currency_filter(get_number($year_stats['revenue']))?></div><div class="clr"></div>

                        <div class="clr"></div>

                    </li>

                    <li>

                        <div class="stat_name">Income this Year</div>

                        <div class="stat_count amount"><?=edd_currency_filter(get_number($year_stats['income']))?></div><div class="clr"></div>

                        <div class="clr"></div>

                    </li>

                    <li class="clr"></li>

                </ul>

                

                <ul class="month_stats">

                    <li>

                        <div class="stat_name">Products sold this Month</div>

                        <div class="stat_count"><?=get_number($month_stats['sales'])?></div><div class="clr"></div>

                        <div class="clr"></div>

                    </li>

                    <li>

                        <div class="stat_name">Sales this month</div>

                        <div class="stat_count amount"><?=edd_currency_filter(get_number($month_stats['revenue']))?></div><div class="clr"></div>

                        <div class="clr"></div>

                    </li>

                    <li>

                        <div class="stat_name">Income this Month</div>

                        <div class="stat_count amount"><?=edd_currency_filter(get_number($month_stats['income']))?></div><div class="clr"></div>

                        <div class="clr"></div>

                    </li>

                    <li class="clr"></li>

                </ul>

                

                <ul class="day_stats">

                    <li>

                        <div class="stat_name">Products sold today</div>

                        <div class="stat_count"><?=get_number($day_stats['sales'])?></div><div class="clr"></div>

                        <div class="clr"></div>

                    </li>

                    <li>

                        <div class="stat_name">Sales today</div>

                        <div class="stat_count amount"><?=edd_currency_filter(get_number($day_stats['revenue']))?></div><div class="clr"></div>

                        <div class="clr"></div>

                    </li>

                    <li>

                        <div class="stat_name">Income today</div>

                        <div class="stat_count amount"><?=edd_currency_filter(get_number($day_stats['income']))?></div><div class="clr"></div>

                        <div class="clr"></div>

                    </li>

                    <li class="clr"></li>

                </ul>

                

                

            </div>

            

	</div>

           <div class="pr-col_container_bottom"></div>     

                </div>

                

                

                

                <?php $this->render_element('sales_sidebar'); ?>

                

                <div class="coll_page_right">

                    

                    <div class="sectionBackgroundDark">

                        <div class="section">
<div class="pr-col_container_top"></div>
                            <div class="sectionOverlay">

                                <div class="products posts">

                                    <?php 

                                    //foreach($posts as $post) :

                                        

                                        

                                    //    $this->render_element('purchase_library_product_item', array('pd' => $post)); 

                                    //endforeach;

                                    ?>

                                </div>

                                

                                

                            </div>
                            
                                <div class="pr-col_container_bottom"></div>

                        </div>

                    </div>



                    



                    



                    



                </div><div class="clr"></div>

            </div>
            
           
            
            <div class="clr">
            
            </div>

        </div>



       



        



    </div>



</div>







</div>








<script type="text/javascript">

		$(function () {

			$("#ff_sort").selectbox();

		});

</script>