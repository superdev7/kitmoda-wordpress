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


<link rel="stylesheet" type="text/css" href="/ktmaterial/plugins/kitmoda_social_media/css/sunny/account.css">
<?php $this->render_element('main_tabs'); ?>

<div class="ksm-menu-sub-menu_container">



        <div class="shrink-wrap-backdrop">

            <div class="shrink-wrap-vignette-left">

            </div>



            <div class="shrink-wrap-vignette-right">

            </div>



             <div class="shrink-wrap-findcenter">

                <div class="shrink-wrap-inner-highlight account">

                        <div class="shrink-wrap-inner-highlight-left"></div>

                        <div class="shrink-wrap-inner-highlight-mid"></div>

                        <div class="shrink-wrap-inner-highlight-right"></div>

                </div>

            </div>

	<div class="shrink-wrap-inner-shadow"></div>

        <div class="shrink-wrap-bottom-shadow"></div>

    </div>















</div>

















<div class="ksm_profile_container">







<div class="ksm_profile_container_overlay">

    <div class="ksm_profile ksm_page_collaboration">

        <div class="header_highlight_community">

            <div class="header radius_top">

                <div class="wall_title">ACCOUNT</div><div class="clr"></div>

            </div>

        </div>

        <div class="main_content purchase_library_main">



            <?php $this->render_element('account_sub_tabs'); ?>



            <div class="pr-col">





                <?php $this->render_element('purchase_library_sidebar'); ?>



                <div class="coll_page_right">



                    <div class="sectionBackgroundDark">

                        <div class="section">
<div class="pr-col_container_top"></div>
                            <div class="sectionOverlay">

                                <div class="products posts"></div>

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