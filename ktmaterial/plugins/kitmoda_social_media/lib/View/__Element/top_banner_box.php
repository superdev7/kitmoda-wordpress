<?php

$KUser = KUser::get_instance();

if(!$KUser->Access) {
    return;
}



$progress_width = get_number($KUser->Access->completeness).'%';



?>

<div id="top_banner_box_container" class="row row-inset">
    <div class="mosaic_banner_horizontal_dark_overlay"></div>
    <div class="mosaic_banner_vertical_dark_overlay"></div>

    <div class="triangle_banner_svg"></div>

    <!-- <div class="traingle_banner_container">
       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 35%, 10%); left: -1289.8604651163px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>


       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 16%); left: -1289.8604651163px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 26%); left: -1274.8813953488px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 19%); left: -1258.6604651163px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 18%); left: -1243.6813953488px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 28%); left: -1227.4604651163px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 18%); left: -1212.4813953488px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 26%); left: -1196.2604651163px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 27%); left: -1181.2813953488px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 28%); left: -1165.0604651163px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 23%); left: -1150.0813953488px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 22%); left: -1133.8604651163px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 20%); left: -1118.8813953488px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 15%); left: -1102.6604651163px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 17%); left: -1087.6813953488px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 25%); left: -1071.4604651163px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 19%); left: -1056.4813953488px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 26%); left: -1040.2604651163px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 24%); left: -1025.2813953488px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 28%); left: -1009.0604651163px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 19%); left: -994.08139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 18%); left: -977.86046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 23%); left: -962.88139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 22%); left: -946.66046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 26%); left: -931.68139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 28%); left: -915.46046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 24%); left: -900.48139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 24%); left: -884.26046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 28%); left: -869.28139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 25%); left: -853.06046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 27%); left: -838.08139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 25%); left: -821.86046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 19%); left: -806.88139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 19%); left: -790.66046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 25%); left: -775.68139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 28%); left: -759.46046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 19%); left: -744.48139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 22%); left: -728.26046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 19%); left: -713.28139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 20%); left: -697.06046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 23%); left: -682.08139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 22%); left: -665.86046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 27%); left: -650.88139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 19%); left: -634.66046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 27%); left: -619.68139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 15%); left: -603.46046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 22%); left: -588.48139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 15%); left: -572.26046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 19%); left: -557.28139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 26%); left: -541.06046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 24%); left: -526.08139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 16%); left: -509.86046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 15%); left: -494.88139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 27%); left: -478.66046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 25%); left: -463.68139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 21%); left: -447.46046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 24%); left: -432.48139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 23%); left: -416.26046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 17%); left: -401.28139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 21%); left: -385.06046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 15%); left: -370.08139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 27%); left: -353.86046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 17%); left: -338.88139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 20%); left: -322.66046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 18%); left: -307.68139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 23%); left: -291.46046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 28%); left: -276.48139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 27%); left: -260.26046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 19%); left: -245.28139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 19%); left: -229.06046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 16%); left: -214.08139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 19%); left: -197.86046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 26%); left: -182.88139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 20%); left: -166.66046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 26%); left: -151.68139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 15%); left: -135.46046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 19%); left: -120.48139534884px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 20%); left: -104.26046511628px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 25%); left: -89.281395348836px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 16%); left: -73.060465116278px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 28%); left: -58.081395348836px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 27%); left: -41.860465116278px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 19%); left: -26.881395348836px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 28%); left: -10.660465116278px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 23%); left: 4.3186046511638px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 24%); left: 20.539534883722px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 16%); left: 35.518604651164px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 23%); left: 51.739534883722px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 27%); left: 66.718604651164px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 27%); left: 82.939534883722px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 27%); left: 97.918604651164px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 23%); left: 114.13953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 25%); left: 129.11860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 26%); left: 145.33953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 26%); left: 160.31860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 21%); left: 176.53953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 23%); left: 191.51860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 24%); left: 207.73953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 17%); left: 222.71860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 23%); left: 238.93953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 27%); left: 253.91860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 23%); left: 270.13953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 18%); left: 285.11860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 27%); left: 301.33953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 17%); left: 316.31860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 28%); left: 332.53953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 24%); left: 347.51860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 18%); left: 363.73953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 23%); left: 378.71860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 28%); left: 394.93953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 28%); left: 409.91860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 17%); left: 426.13953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 27%); left: 441.11860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 22%); left: 457.33953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 20%); left: 472.31860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 27%); left: 488.53953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 19%); left: 503.51860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 19%); left: 519.73953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 23%); left: 534.71860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 25%); left: 550.93953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 28%); left: 565.91860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 26%); left: 582.13953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 18%); left: 597.11860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 16%); left: 613.33953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 17%); left: 628.31860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 19%); left: 644.53953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 22%); left: 659.51860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 25%); left: 675.73953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 18%); left: 690.71860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 21%); left: 706.93953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 19%); left: 721.91860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 15%); left: 738.13953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 26%); left: 753.11860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 18%); left: 769.33953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 22%); left: 784.31860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 18%); left: 800.53953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 24%); left: 815.51860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 17%); left: 831.73953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 17%); left: 846.71860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 26%); left: 862.93953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 21%); left: 877.91860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 23%); left: 894.13953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 23%); left: 909.11860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 21%); left: 925.33953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 23%); left: 940.31860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 23%); left: 956.53953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 18%); left: 971.51860465116px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 23%); left: 987.73953488372px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 27%); left: 1002.7186046512px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 22%); left: 1018.9395348837px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 26%); left: 1033.9186046512px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 28%); left: 1050.1395348837px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 27%); left: 1065.1186046512px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 21%); left: 1081.3395348837px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 22%); left: 1096.3186046512px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 22%); left: 1112.5395348837px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 21%); left: 1127.5186046512px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 28%); left: 1143.7395348837px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 21%); left: 1158.7186046512px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 27%); left: 1174.9395348837px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 19%); left: 1189.9186046512px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 15%); left: 1206.1395348837px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 16%); left: 1221.1186046512px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 24%); left: 1237.3395348837px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 21%); left: 1252.3186046512px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 21%); left: 1268.5395348837px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 15%); left: 1283.5186046512px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 26%); left: 1299.7395348837px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 23%); left: 1314.7186046512px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 15%); left: 1330.9395348837px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 23%); left: 1345.9186046512px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 17%); left: 1362.1395348837px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 23%); left: 1377.1186046512px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 16%); left: 1393.3395348837px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 22%); left: 1408.3186046512px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 17%); left: 1424.5395348837px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 21%); left: 1439.5186046512px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 21%); left: 1455.7395348837px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 26%); left: 1470.7186046512px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 23%); left: 1486.9395348837px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 20%); left: 1501.9186046512px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 23%); left: 1518.1395348837px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 21%); left: 1533.1186046512px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 20%); left: 1549.3395348837px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 24%); left: 1564.3186046512px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 18%); left: 1580.5395348837px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 27%); left: 1595.5186046512px; top: 0px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 19%); left: -1306.1395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 22%); left: -1291.1604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 24%); left: -1274.9395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 20%); left: -1259.9604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 28%); left: -1243.7395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 15%); left: -1228.7604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 21%); left: -1212.5395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 22%); left: -1197.5604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 17%); left: -1181.3395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 15%); left: -1166.3604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 20%); left: -1150.1395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 18%); left: -1135.1604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 24%); left: -1118.9395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 16%); left: -1103.9604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 18%); left: -1087.7395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 20%); left: -1072.7604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 23%); left: -1056.5395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 28%); left: -1041.5604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 15%); left: -1025.3395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 15%); left: -1010.3604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 18%); left: -994.13953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 20%); left: -979.16046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 28%); left: -962.93953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 24%); left: -947.96046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 28%); left: -931.73953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 15%); left: -916.76046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 19%); left: -900.53953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 16%); left: -885.56046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 18%); left: -869.33953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 27%); left: -854.36046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 18%); left: -838.13953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 16%); left: -823.16046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 17%); left: -806.93953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 15%); left: -791.96046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 20%); left: -775.73953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 17%); left: -760.76046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 17%); left: -744.53953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 19%); left: -729.56046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 23%); left: -713.33953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 20%); left: -698.36046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 25%); left: -682.13953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 28%); left: -667.16046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 24%); left: -650.93953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 28%); left: -635.96046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 18%); left: -619.73953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 20%); left: -604.76046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 16%); left: -588.53953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 20%); left: -573.56046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 22%); left: -557.33953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 21%); left: -542.36046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 23%); left: -526.13953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 23%); left: -511.16046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 18%); left: -494.93953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 28%); left: -479.96046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 27%); left: -463.73953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 21%); left: -448.76046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 24%); left: -432.53953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 25%); left: -417.56046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 21%); left: -401.33953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 18%); left: -386.36046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 22%); left: -370.13953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 18%); left: -355.16046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 17%); left: -338.93953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 27%); left: -323.96046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 17%); left: -307.73953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 24%); left: -292.76046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 28%); left: -276.53953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 22%); left: -261.56046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 18%); left: -245.33953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 16%); left: -230.36046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 26%); left: -214.13953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 26%); left: -199.16046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 28%); left: -182.93953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 27%); left: -167.96046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 18%); left: -151.73953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 16%); left: -136.76046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 25%); left: -120.53953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 21%); left: -105.56046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 16%); left: -89.33953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 23%); left: -74.360465116278px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 24%); left: -58.13953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 28%); left: -43.160465116278px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 23%); left: -26.93953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 26%); left: -11.960465116278px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 15%); left: 4.2604651162802px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 15%); left: 19.239534883722px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 22%); left: 35.46046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 20%); left: 50.439534883722px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 21%); left: 66.66046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 27%); left: 81.639534883722px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 20%); left: 97.86046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 22%); left: 112.83953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 20%); left: 129.06046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 15%); left: 144.03953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 18%); left: 160.26046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 24%); left: 175.23953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 27%); left: 191.46046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 22%); left: 206.43953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 17%); left: 222.66046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 20%); left: 237.63953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 19%); left: 253.86046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 16%); left: 268.83953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 18%); left: 285.06046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 19%); left: 300.03953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 26%); left: 316.26046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 20%); left: 331.23953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 17%); left: 347.46046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 19%); left: 362.43953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 26%); left: 378.66046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 28%); left: 393.63953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 28%); left: 409.86046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 15%); left: 424.83953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 19%); left: 441.06046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 20%); left: 456.03953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 28%); left: 472.26046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 25%); left: 487.23953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 17%); left: 503.46046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 17%); left: 518.43953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 19%); left: 534.66046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 16%); left: 549.63953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 24%); left: 565.86046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 19%); left: 580.83953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 20%); left: 597.06046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 20%); left: 612.03953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 15%); left: 628.26046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 19%); left: 643.23953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 15%); left: 659.46046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 26%); left: 674.43953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 28%); left: 690.66046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 26%); left: 705.63953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 28%); left: 721.86046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 18%); left: 736.83953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 20%); left: 753.06046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 22%); left: 768.03953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 28%); left: 784.26046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 27%); left: 799.23953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 16%); left: 815.46046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 22%); left: 830.43953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 27%); left: 846.66046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 25%); left: 861.63953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 18%); left: 877.86046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 26%); left: 892.83953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 21%); left: 909.06046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 23%); left: 924.03953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 27%); left: 940.26046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 20%); left: 955.23953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 28%); left: 971.46046511628px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 27%); left: 986.43953488372px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 15%); left: 1002.6604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 15%); left: 1017.6395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 15%); left: 1033.8604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 23%); left: 1048.8395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 17%); left: 1065.0604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 25%); left: 1080.0395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 28%); left: 1096.2604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 28%); left: 1111.2395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 23%); left: 1127.4604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 22%); left: 1142.4395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 21%); left: 1158.6604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 21%); left: 1173.6395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 22%); left: 1189.8604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 17%); left: 1204.8395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 21%); left: 1221.0604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 26%); left: 1236.0395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 21%); left: 1252.2604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 21%); left: 1267.2395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 26%); left: 1283.4604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 25%); left: 1298.4395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 17%); left: 1314.6604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 15%); left: 1329.6395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 28%); left: 1345.8604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 20%); left: 1360.8395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 26%); left: 1377.0604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 23%); left: 1392.0395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 16%); left: 1408.2604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 24%); left: 1423.2395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 28%); left: 1439.4604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 17%); left: 1454.4395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 27%); left: 1470.6604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 28%); left: 1485.6395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 27%); left: 1501.8604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 27%); left: 1516.8395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 21%); left: 1533.0604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 23%); left: 1548.0395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 16%); left: 1564.2604651163px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 25%); left: 1579.2395348837px; top: 28px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 24%); left: -1289.8604651163px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 23%); left: -1274.8813953488px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 17%); left: -1258.6604651163px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 27%); left: -1243.6813953488px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 19%); left: -1227.4604651163px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 28%); left: -1212.4813953488px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 20%); left: -1196.2604651163px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 25%); left: -1181.2813953488px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 17%); left: -1165.0604651163px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 23%); left: -1150.0813953488px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 16%); left: -1133.8604651163px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 24%); left: -1118.8813953488px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 17%); left: -1102.6604651163px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 17%); left: -1087.6813953488px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 15%); left: -1071.4604651163px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 19%); left: -1056.4813953488px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 16%); left: -1040.2604651163px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 18%); left: -1025.2813953488px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 16%); left: -1009.0604651163px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 23%); left: -994.08139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 24%); left: -977.86046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 25%); left: -962.88139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 25%); left: -946.66046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 19%); left: -931.68139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 17%); left: -915.46046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 28%); left: -900.48139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 21%); left: -884.26046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 25%); left: -869.28139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 28%); left: -853.06046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 27%); left: -838.08139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 27%); left: -821.86046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 24%); left: -806.88139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 16%); left: -790.66046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 19%); left: -775.68139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 15%); left: -759.46046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 24%); left: -744.48139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 22%); left: -728.26046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 25%); left: -713.28139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 27%); left: -697.06046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 18%); left: -682.08139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 28%); left: -665.86046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 19%); left: -650.88139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 27%); left: -634.66046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 16%); left: -619.68139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 15%); left: -603.46046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 27%); left: -588.48139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 18%); left: -572.26046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 27%); left: -557.28139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 22%); left: -541.06046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 23%); left: -526.08139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 17%); left: -509.86046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 19%); left: -494.88139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 25%); left: -478.66046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 16%); left: -463.68139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 16%); left: -447.46046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 24%); left: -432.48139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 23%); left: -416.26046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 22%); left: -401.28139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 16%); left: -385.06046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 21%); left: -370.08139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 24%); left: -353.86046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 15%); left: -338.88139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 28%); left: -322.66046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 17%); left: -307.68139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 17%); left: -291.46046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 16%); left: -276.48139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 15%); left: -260.26046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 17%); left: -245.28139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 21%); left: -229.06046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 20%); left: -214.08139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 23%); left: -197.86046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 23%); left: -182.88139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 17%); left: -166.66046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 26%); left: -151.68139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 26%); left: -135.46046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 20%); left: -120.48139534884px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 24%); left: -104.26046511628px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 19%); left: -89.281395348836px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 20%); left: -73.060465116278px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 17%); left: -58.081395348836px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 19%); left: -41.860465116278px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 15%); left: -26.881395348836px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 24%); left: -10.660465116278px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 17%); left: 4.3186046511638px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 20%); left: 20.539534883722px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 24%); left: 35.518604651164px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 24%); left: 51.739534883722px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 18%); left: 66.718604651164px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 20%); left: 82.939534883722px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 16%); left: 97.918604651164px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 20%); left: 114.13953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 24%); left: 129.11860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 28%); left: 145.33953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 23%); left: 160.31860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 22%); left: 176.53953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 15%); left: 191.51860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 15%); left: 207.73953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 17%); left: 222.71860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 18%); left: 238.93953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 26%); left: 253.91860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 27%); left: 270.13953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 25%); left: 285.11860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 25%); left: 301.33953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 21%); left: 316.31860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 16%); left: 332.53953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 20%); left: 347.51860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 16%); left: 363.73953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 21%); left: 378.71860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 15%); left: 394.93953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 22%); left: 409.91860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 27%); left: 426.13953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 20%); left: 441.11860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 24%); left: 457.33953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 23%); left: 472.31860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 28%); left: 488.53953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 23%); left: 503.51860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 28%); left: 519.73953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 22%); left: 534.71860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 19%); left: 550.93953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 28%); left: 565.91860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 23%); left: 582.13953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 27%); left: 597.11860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 20%); left: 613.33953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 27%); left: 628.31860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 20%); left: 644.53953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 15%); left: 659.51860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 28%); left: 675.73953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 17%); left: 690.71860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 28%); left: 706.93953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 23%); left: 721.91860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 18%); left: 738.13953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 26%); left: 753.11860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 22%); left: 769.33953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 15%); left: 784.31860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 19%); left: 800.53953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 18%); left: 815.51860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 18%); left: 831.73953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 23%); left: 846.71860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 21%); left: 862.93953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 16%); left: 877.91860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 27%); left: 894.13953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 16%); left: 909.11860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 22%); left: 925.33953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 22%); left: 940.31860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 16%); left: 956.53953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 21%); left: 971.51860465116px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 20%); left: 987.73953488372px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 23%); left: 1002.7186046512px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 23%); left: 1018.9395348837px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 25%); left: 1033.9186046512px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 23%); left: 1050.1395348837px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 26%); left: 1065.1186046512px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 16%); left: 1081.3395348837px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 22%); left: 1096.3186046512px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 27%); left: 1112.5395348837px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 20%); left: 1127.5186046512px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 26%); left: 1143.7395348837px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 24%); left: 1158.7186046512px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 25%); left: 1174.9395348837px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 27%); left: 1189.9186046512px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 20%); left: 1206.1395348837px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 17%); left: 1221.1186046512px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 23%); left: 1237.3395348837px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 24%); left: 1252.3186046512px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 21%); left: 1268.5395348837px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 16%); left: 1283.5186046512px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 20%); left: 1299.7395348837px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 28%); left: 1314.7186046512px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 19%); left: 1330.9395348837px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 15%); left: 1345.9186046512px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 17%); left: 1362.1395348837px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 28%); left: 1377.1186046512px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 27%); left: 1393.3395348837px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 20%); left: 1408.3186046512px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 28%); left: 1424.5395348837px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 21%); left: 1439.5186046512px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 23%); left: 1455.7395348837px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 17%); left: 1470.7186046512px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 21%); left: 1486.9395348837px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 20%); left: 1501.9186046512px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 18%); left: 1518.1395348837px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 28%); left: 1533.1186046512px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 20%); left: 1549.3395348837px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 16%); left: 1564.3186046512px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 20%); left: 1580.5395348837px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 26%); left: 1595.5186046512px; top: 56px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 22%); left: -1306.1395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 23%); left: -1291.1604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 22%); left: -1274.9395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 15%); left: -1259.9604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 18%); left: -1243.7395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 27%); left: -1228.7604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 16%); left: -1212.5395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 15%); left: -1197.5604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 27%); left: -1181.3395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 21%); left: -1166.3604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 28%); left: -1150.1395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 26%); left: -1135.1604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 20%); left: -1118.9395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 28%); left: -1103.9604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 16%); left: -1087.7395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 20%); left: -1072.7604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 24%); left: -1056.5395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 16%); left: -1041.5604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 15%); left: -1025.3395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 24%); left: -1010.3604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 23%); left: -994.13953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 17%); left: -979.16046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 23%); left: -962.93953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 19%); left: -947.96046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 24%); left: -931.73953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 25%); left: -916.76046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 18%); left: -900.53953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 28%); left: -885.56046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 22%); left: -869.33953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 21%); left: -854.36046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 25%); left: -838.13953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 19%); left: -823.16046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 28%); left: -806.93953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 22%); left: -791.96046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 23%); left: -775.73953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 19%); left: -760.76046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 26%); left: -744.53953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 28%); left: -729.56046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 24%); left: -713.33953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 15%); left: -698.36046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 15%); left: -682.13953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 28%); left: -667.16046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 19%); left: -650.93953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 28%); left: -635.96046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 26%); left: -619.73953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 22%); left: -604.76046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 19%); left: -588.53953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 27%); left: -573.56046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 19%); left: -557.33953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 18%); left: -542.36046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 24%); left: -526.13953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 16%); left: -511.16046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 15%); left: -494.93953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 28%); left: -479.96046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 19%); left: -463.73953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 15%); left: -448.76046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 25%); left: -432.53953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 24%); left: -417.56046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 27%); left: -401.33953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 27%); left: -386.36046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 16%); left: -370.13953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 18%); left: -355.16046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 19%); left: -338.93953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 24%); left: -323.96046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 24%); left: -307.73953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 21%); left: -292.76046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 21%); left: -276.53953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 26%); left: -261.56046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 23%); left: -245.33953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 16%); left: -230.36046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 25%); left: -214.13953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 19%); left: -199.16046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 16%); left: -182.93953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 22%); left: -167.96046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 24%); left: -151.73953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 25%); left: -136.76046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 27%); left: -120.53953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 18%); left: -105.56046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 18%); left: -89.33953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 26%); left: -74.360465116278px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 26%); left: -58.13953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 18%); left: -43.160465116278px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 27%); left: -26.93953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 25%); left: -11.960465116278px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 27%); left: 4.2604651162802px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 20%); left: 19.239534883722px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 28%); left: 35.46046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 16%); left: 50.439534883722px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 25%); left: 66.66046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 17%); left: 81.639534883722px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 15%); left: 97.86046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 19%); left: 112.83953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 28%); left: 129.06046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 17%); left: 144.03953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 20%); left: 160.26046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 15%); left: 175.23953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 19%); left: 191.46046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 21%); left: 206.43953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 19%); left: 222.66046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 24%); left: 237.63953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 15%); left: 253.86046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 26%); left: 268.83953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 26%); left: 285.06046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 17%); left: 300.03953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 22%); left: 316.26046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 16%); left: 331.23953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 18%); left: 347.46046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 22%); left: 362.43953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 27%); left: 378.66046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 19%); left: 393.63953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 24%); left: 409.86046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 22%); left: 424.83953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 23%); left: 441.06046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 17%); left: 456.03953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 17%); left: 472.26046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 17%); left: 487.23953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 28%); left: 503.46046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 19%); left: 518.43953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 27%); left: 534.66046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 20%); left: 549.63953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 26%); left: 565.86046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 15%); left: 580.83953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 27%); left: 597.06046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 17%); left: 612.03953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 18%); left: 628.26046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 15%); left: 643.23953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 26%); left: 659.46046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 28%); left: 674.43953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 22%); left: 690.66046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 20%); left: 705.63953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 15%); left: 721.86046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 15%); left: 736.83953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 23%); left: 753.06046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 26%); left: 768.03953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 26%); left: 784.26046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 28%); left: 799.23953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 24%); left: 815.46046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 23%); left: 830.43953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 22%); left: 846.66046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 19%); left: 861.63953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 18%); left: 877.86046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 25%); left: 892.83953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 27%); left: 909.06046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 23%); left: 924.03953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 28%); left: 940.26046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 18%); left: 955.23953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 23%); left: 971.46046511628px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 28%); left: 986.43953488372px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 23%); left: 1002.6604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 25%); left: 1017.6395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 28%); left: 1033.8604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 15%); left: 1048.8395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 24%); left: 1065.0604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 18%); left: 1080.0395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 21%); left: 1096.2604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 28%); left: 1111.2395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 28%); left: 1127.4604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 27%); left: 1142.4395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 22%); left: 1158.6604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 19%); left: 1173.6395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 21%); left: 1189.8604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 21%); left: 1204.8395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 26%); left: 1221.0604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 18%); left: 1236.0395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 18%); left: 1252.2604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 27%); left: 1267.2395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 23%); left: 1283.4604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 28%); left: 1298.4395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 24%); left: 1314.6604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 21%); left: 1329.6395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 25%); left: 1345.8604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 27%); left: 1360.8395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 17%); left: 1377.0604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 22%); left: 1392.0395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 18%); left: 1408.2604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 17%); left: 1423.2395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 21%); left: 1439.4604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 24%); left: 1454.4395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 16%); left: 1470.6604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 25%); left: 1485.6395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 27%); left: 1501.8604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 23%); left: 1516.8395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 24%); left: 1533.0604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 26%); left: 1548.0395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 24%); left: 1564.2604651163px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 22%); left: 1579.2395348837px; top: 84px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 24%); left: -1289.8604651163px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 17%); left: -1274.8813953488px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 18%); left: -1258.6604651163px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 23%); left: -1243.6813953488px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 23%); left: -1227.4604651163px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 16%); left: -1212.4813953488px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 21%); left: -1196.2604651163px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 20%); left: -1181.2813953488px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 25%); left: -1165.0604651163px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 27%); left: -1150.0813953488px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 27%); left: -1133.8604651163px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 16%); left: -1118.8813953488px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 15%); left: -1102.6604651163px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 28%); left: -1087.6813953488px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 17%); left: -1071.4604651163px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 18%); left: -1056.4813953488px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 27%); left: -1040.2604651163px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 25%); left: -1025.2813953488px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 17%); left: -1009.0604651163px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 22%); left: -994.08139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 17%); left: -977.86046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 27%); left: -962.88139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 20%); left: -946.66046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 18%); left: -931.68139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 22%); left: -915.46046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 25%); left: -900.48139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 24%); left: -884.26046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 28%); left: -869.28139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 26%); left: -853.06046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 20%); left: -838.08139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 20%); left: -821.86046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 27%); left: -806.88139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 15%); left: -790.66046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 21%); left: -775.68139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 16%); left: -759.46046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 15%); left: -744.48139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 23%); left: -728.26046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 28%); left: -713.28139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 18%); left: -697.06046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 17%); left: -682.08139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 19%); left: -665.86046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 17%); left: -650.88139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 26%); left: -634.66046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 24%); left: -619.68139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 16%); left: -603.46046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 24%); left: -588.48139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 24%); left: -572.26046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 26%); left: -557.28139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 18%); left: -541.06046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 28%); left: -526.08139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 18%); left: -509.86046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 23%); left: -494.88139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 27%); left: -478.66046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 27%); left: -463.68139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 24%); left: -447.46046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 27%); left: -432.48139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 15%); left: -416.26046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 28%); left: -401.28139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 18%); left: -385.06046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 23%); left: -370.08139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 24%); left: -353.86046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 27%); left: -338.88139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 26%); left: -322.66046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 17%); left: -307.68139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 27%); left: -291.46046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 21%); left: -276.48139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 16%); left: -260.26046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 15%); left: -245.28139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 23%); left: -229.06046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 17%); left: -214.08139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 16%); left: -197.86046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 19%); left: -182.88139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 17%); left: -166.66046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 15%); left: -151.68139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 28%); left: -135.46046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 26%); left: -120.48139534884px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 27%); left: -104.26046511628px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 15%); left: -89.281395348836px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 20%); left: -73.060465116278px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 27%); left: -58.081395348836px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 19%); left: -41.860465116278px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 21%); left: -26.881395348836px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 20%); left: -10.660465116278px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 21%); left: 4.3186046511638px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 21%); left: 20.539534883722px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 19%); left: 35.518604651164px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 26%); left: 51.739534883722px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 25%); left: 66.718604651164px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 28%); left: 82.939534883722px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 21%); left: 97.918604651164px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 20%); left: 114.13953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 22%); left: 129.11860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 28%); left: 145.33953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 15%); left: 160.31860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 26%); left: 176.53953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 23%); left: 191.51860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 18%); left: 207.73953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 23%); left: 222.71860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 23%); left: 238.93953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 23%); left: 253.91860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 25%); left: 270.13953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 24%); left: 285.11860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 23%); left: 301.33953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 22%); left: 316.31860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 17%); left: 332.53953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 22%); left: 347.51860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 19%); left: 363.73953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 27%); left: 378.71860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 24%); left: 394.93953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 23%); left: 409.91860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 27%); left: 426.13953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 23%); left: 441.11860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 19%); left: 457.33953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 25%); left: 472.31860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 18%); left: 488.53953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 15%); left: 503.51860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 19%); left: 519.73953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 22%); left: 534.71860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 16%); left: 550.93953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 22%); left: 565.91860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 16%); left: 582.13953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 26%); left: 597.11860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 16%); left: 613.33953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 24%); left: 628.31860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 24%); left: 644.53953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 18%); left: 659.51860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 22%); left: 675.73953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 24%); left: 690.71860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 15%); left: 706.93953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 26%); left: 721.91860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 26%); left: 738.13953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 18%); left: 753.11860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 23%); left: 769.33953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 16%); left: 784.31860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 28%); left: 800.53953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 27%); left: 815.51860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 24%); left: 831.73953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 21%); left: 846.71860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 21%); left: 862.93953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 23%); left: 877.91860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 20%); left: 894.13953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 25%); left: 909.11860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 23%); left: 925.33953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 26%); left: 940.31860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 26%); left: 956.53953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 27%); left: 971.51860465116px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 23%); left: 987.73953488372px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 25%); left: 1002.7186046512px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 15%); left: 1018.9395348837px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 26%); left: 1033.9186046512px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 21%); left: 1050.1395348837px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 15%); left: 1065.1186046512px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 21%); left: 1081.3395348837px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 28%); left: 1096.3186046512px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 23%); left: 1112.5395348837px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 17%); left: 1127.5186046512px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 19%); left: 1143.7395348837px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 28%); left: 1158.7186046512px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 19%); left: 1174.9395348837px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 23%); left: 1189.9186046512px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 21%); left: 1206.1395348837px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 26%); left: 1221.1186046512px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 23%); left: 1237.3395348837px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 18%); left: 1252.3186046512px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 20%); left: 1268.5395348837px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 23%); left: 1283.5186046512px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 26%); left: 1299.7395348837px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 15%); left: 1314.7186046512px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 16%); left: 1330.9395348837px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 19%); left: 1345.9186046512px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 22%); left: 1362.1395348837px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 25%); left: 1377.1186046512px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 20%); left: 1393.3395348837px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 26%); left: 1408.3186046512px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 22%); left: 1424.5395348837px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 27%); left: 1439.5186046512px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 27%); left: 1455.7395348837px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 15%); left: 1470.7186046512px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 18%); left: 1486.9395348837px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 17%); left: 1501.9186046512px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 19%); left: 1518.1395348837px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 21%); left: 1533.1186046512px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 21%); left: 1549.3395348837px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 21%); left: 1564.3186046512px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 21%); left: 1580.5395348837px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 19%); left: 1595.5186046512px; top: 112px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 17%); left: -1306.1395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 27%); left: -1291.1604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 25%); left: -1274.9395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 18%); left: -1259.9604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 17%); left: -1243.7395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 18%); left: -1228.7604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 26%); left: -1212.5395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 23%); left: -1197.5604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 22%); left: -1181.3395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 24%); left: -1166.3604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 23%); left: -1150.1395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 28%); left: -1135.1604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 23%); left: -1118.9395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 23%); left: -1103.9604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 16%); left: -1087.7395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 17%); left: -1072.7604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 28%); left: -1056.5395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 27%); left: -1041.5604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 26%); left: -1025.3395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 27%); left: -1010.3604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 18%); left: -994.13953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 16%); left: -979.16046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 20%); left: -962.93953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 15%); left: -947.96046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 23%); left: -931.73953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 25%); left: -916.76046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 26%); left: -900.53953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 18%); left: -885.56046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 16%); left: -869.33953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 23%); left: -854.36046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 25%); left: -838.13953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 22%); left: -823.16046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 26%); left: -806.93953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 20%); left: -791.96046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 22%); left: -775.73953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 25%); left: -760.76046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 21%); left: -744.53953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 26%); left: -729.56046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 23%); left: -713.33953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 25%); left: -698.36046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 23%); left: -682.13953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 20%); left: -667.16046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 18%); left: -650.93953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 26%); left: -635.96046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 21%); left: -619.73953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 23%); left: -604.76046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 17%); left: -588.53953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 27%); left: -573.56046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 23%); left: -557.33953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 24%); left: -542.36046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 22%); left: -526.13953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 28%); left: -511.16046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 18%); left: -494.93953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 27%); left: -479.96046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 24%); left: -463.73953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 16%); left: -448.76046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 17%); left: -432.53953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 24%); left: -417.56046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 16%); left: -401.33953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 25%); left: -386.36046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 28%); left: -370.13953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 25%); left: -355.16046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 21%); left: -338.93953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 17%); left: -323.96046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 28%); left: -307.73953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 17%); left: -292.76046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 18%); left: -276.53953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 22%); left: -261.56046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 27%); left: -245.33953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 20%); left: -230.36046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 15%); left: -214.13953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 26%); left: -199.16046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 28%); left: -182.93953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 23%); left: -167.96046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 28%); left: -151.73953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 23%); left: -136.76046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 23%); left: -120.53953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 15%); left: -105.56046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 28%); left: -89.33953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 16%); left: -74.360465116278px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 15%); left: -58.13953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 20%); left: -43.160465116278px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 20%); left: -26.93953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 25%); left: -11.960465116278px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 19%); left: 4.2604651162802px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 26%); left: 19.239534883722px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 24%); left: 35.46046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 21%); left: 50.439534883722px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 15%); left: 66.66046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 25%); left: 81.639534883722px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 19%); left: 97.86046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 27%); left: 112.83953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 23%); left: 129.06046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 15%); left: 144.03953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 16%); left: 160.26046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 22%); left: 175.23953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 20%); left: 191.46046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 19%); left: 206.43953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 27%); left: 222.66046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 15%); left: 237.63953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 19%); left: 253.86046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 22%); left: 268.83953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 21%); left: 285.06046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 24%); left: 300.03953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 15%); left: 316.26046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 22%); left: 331.23953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 25%); left: 347.46046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 20%); left: 362.43953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 19%); left: 378.66046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 15%); left: 393.63953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 22%); left: 409.86046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 22%); left: 424.83953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 23%); left: 441.06046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 24%); left: 456.03953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 28%); left: 472.26046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 24%); left: 487.23953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 22%); left: 503.46046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 19%); left: 518.43953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 18%); left: 534.66046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 22%); left: 549.63953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 21%); left: 565.86046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 24%); left: 580.83953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 22%); left: 597.06046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 23%); left: 612.03953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 20%); left: 628.26046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 18%); left: 643.23953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 18%); left: 659.46046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 27%); left: 674.43953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 23%); left: 690.66046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 19%); left: 705.63953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 18%); left: 721.86046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 27%); left: 736.83953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 18%); left: 753.06046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 27%); left: 768.03953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 19%); left: 784.26046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 25%); left: 799.23953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 22%); left: 815.46046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 28%); left: 830.43953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 20%); left: 846.66046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 27%); left: 861.63953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 18%); left: 877.86046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 26%); left: 892.83953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 27%); left: 909.06046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 18%); left: 924.03953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 18%); left: 940.26046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 17%); left: 955.23953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 22%); left: 971.46046511628px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 19%); left: 986.43953488372px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 18%); left: 1002.6604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 18%); left: 1017.6395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 24%); left: 1033.8604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 19%); left: 1048.8395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 20%); left: 1065.0604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 18%); left: 1080.0395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 28%); left: 1096.2604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 24%); left: 1111.2395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 18%); left: 1127.4604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 23%); left: 1142.4395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 16%); left: 1158.6604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 25%); left: 1173.6395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 21%); left: 1189.8604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 26%); left: 1204.8395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 27%); left: 1221.0604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 26%); left: 1236.0395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 20%); left: 1252.2604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 25%); left: 1267.2395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 16%); left: 1283.4604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 18%); left: 1298.4395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 20%); left: 1314.6604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 19%); left: 1329.6395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 22%); left: 1345.8604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 22%); left: 1360.8395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 21%); left: 1377.0604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 28%); left: 1392.0395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 16%); left: 1408.2604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 27%); left: 1423.2395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 23%); left: 1439.4604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 22%); left: 1454.4395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 27%); left: 1470.6604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 24%); left: 1485.6395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 22%); left: 1501.8604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 19%); left: 1516.8395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 22%); left: 1533.0604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 16%); left: 1548.0395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 15%); left: 1564.2604651163px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 19%); left: 1579.2395348837px; top: 140px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 21%); left: -1289.8604651163px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 20%); left: -1274.8813953488px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 15%); left: -1258.6604651163px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 21%); left: -1243.6813953488px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 16%); left: -1227.4604651163px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 24%); left: -1212.4813953488px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 16%); left: -1196.2604651163px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 18%); left: -1181.2813953488px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 23%); left: -1165.0604651163px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 19%); left: -1150.0813953488px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 20%); left: -1133.8604651163px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 25%); left: -1118.8813953488px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 18%); left: -1102.6604651163px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 26%); left: -1087.6813953488px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 20%); left: -1071.4604651163px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 28%); left: -1056.4813953488px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 15%); left: -1040.2604651163px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 25%); left: -1025.2813953488px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 26%); left: -1009.0604651163px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 18%); left: -994.08139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 24%); left: -977.86046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 23%); left: -962.88139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 18%); left: -946.66046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 26%); left: -931.68139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 25%); left: -915.46046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 15%); left: -900.48139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 26%); left: -884.26046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 15%); left: -869.28139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 24%); left: -853.06046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 21%); left: -838.08139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 15%); left: -821.86046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 27%); left: -806.88139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 25%); left: -790.66046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 18%); left: -775.68139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 28%); left: -759.46046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 21%); left: -744.48139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 21%); left: -728.26046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 19%); left: -713.28139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 28%); left: -697.06046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 23%); left: -682.08139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 18%); left: -665.86046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 26%); left: -650.88139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 19%); left: -634.66046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 17%); left: -619.68139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 25%); left: -603.46046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 15%); left: -588.48139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 28%); left: -572.26046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 27%); left: -557.28139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 24%); left: -541.06046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 18%); left: -526.08139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 24%); left: -509.86046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 17%); left: -494.88139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 26%); left: -478.66046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 27%); left: -463.68139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 24%); left: -447.46046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 22%); left: -432.48139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 15%); left: -416.26046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 28%); left: -401.28139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 17%); left: -385.06046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 20%); left: -370.08139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 25%); left: -353.86046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 24%); left: -338.88139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 21%); left: -322.66046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 21%); left: -307.68139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 25%); left: -291.46046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 24%); left: -276.48139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 22%); left: -260.26046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 22%); left: -245.28139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 19%); left: -229.06046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 17%); left: -214.08139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 27%); left: -197.86046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 27%); left: -182.88139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 15%); left: -166.66046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 19%); left: -151.68139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 15%); left: -135.46046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 17%); left: -120.48139534884px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 18%); left: -104.26046511628px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 23%); left: -89.281395348836px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 21%); left: -73.060465116278px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 25%); left: -58.081395348836px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 27%); left: -41.860465116278px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 23%); left: -26.881395348836px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 18%); left: -10.660465116278px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 25%); left: 4.3186046511638px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 23%); left: 20.539534883722px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 22%); left: 35.518604651164px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 23%); left: 51.739534883722px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 20%); left: 66.718604651164px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 19%); left: 82.939534883722px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 26%); left: 97.918604651164px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 22%); left: 114.13953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 18%); left: 129.11860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 26%); left: 145.33953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 21%); left: 160.31860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 27%); left: 176.53953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 21%); left: 191.51860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 23%); left: 207.73953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 17%); left: 222.71860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 18%); left: 238.93953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 21%); left: 253.91860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 28%); left: 270.13953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 19%); left: 285.11860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 21%); left: 301.33953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 17%); left: 316.31860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 21%); left: 332.53953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 17%); left: 347.51860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 28%); left: 363.73953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 25%); left: 378.71860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 18%); left: 394.93953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 16%); left: 409.91860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 20%); left: 426.13953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 28%); left: 441.11860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 25%); left: 457.33953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 27%); left: 472.31860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 17%); left: 488.53953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 25%); left: 503.51860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 20%); left: 519.73953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 23%); left: 534.71860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 26%); left: 550.93953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 24%); left: 565.91860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 26%); left: 582.13953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 19%); left: 597.11860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 18%); left: 613.33953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 23%); left: 628.31860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 19%); left: 644.53953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 24%); left: 659.51860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 20%); left: 675.73953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 25%); left: 690.71860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 26%); left: 706.93953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 15%); left: 721.91860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 15%); left: 738.13953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 15%); left: 753.11860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 27%); left: 769.33953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 19%); left: 784.31860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 21%); left: 800.53953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 15%); left: 815.51860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 26%); left: 831.73953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 16%); left: 846.71860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 20%); left: 862.93953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 23%); left: 877.91860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 21%); left: 894.13953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 20%); left: 909.11860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 27%); left: 925.33953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 28%); left: 940.31860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 25%); left: 956.53953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 23%); left: 971.51860465116px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 27%); left: 987.73953488372px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 17%); left: 1002.7186046512px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 19%); left: 1018.9395348837px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 22%); left: 1033.9186046512px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 21%); left: 1050.1395348837px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 16%); left: 1065.1186046512px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 26%); left: 1081.3395348837px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 20%); left: 1096.3186046512px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 27%); left: 1112.5395348837px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 27%); left: 1127.5186046512px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 17%); left: 1143.7395348837px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 17%); left: 1158.7186046512px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 20%); left: 1174.9395348837px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 24%); left: 1189.9186046512px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 17%); left: 1206.1395348837px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 27%); left: 1221.1186046512px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 28%); left: 1237.3395348837px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 26%); left: 1252.3186046512px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 23%); left: 1268.5395348837px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 17%); left: 1283.5186046512px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 27%); left: 1299.7395348837px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 20%); left: 1314.7186046512px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 21%); left: 1330.9395348837px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 27%); left: 1345.9186046512px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 24%); left: 1362.1395348837px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 25%); left: 1377.1186046512px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 15%); left: 1393.3395348837px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 27%); left: 1408.3186046512px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 16%); left: 1424.5395348837px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 22%); left: 1439.5186046512px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 27%); left: 1455.7395348837px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 19%); left: 1470.7186046512px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 22%); left: 1486.9395348837px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 17%); left: 1501.9186046512px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 22%); left: 1518.1395348837px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 18%); left: 1533.1186046512px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 23%); left: 1549.3395348837px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 15%); left: 1564.3186046512px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 19%); left: 1580.5395348837px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 21%); left: 1595.5186046512px; top: 168px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 25%); left: -1306.1395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 27%); left: -1291.1604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 16%); left: -1274.9395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 18%); left: -1259.9604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 19%); left: -1243.7395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 22%); left: -1228.7604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 17%); left: -1212.5395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 16%); left: -1197.5604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 15%); left: -1181.3395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 26%); left: -1166.3604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 24%); left: -1150.1395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 28%); left: -1135.1604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 24%); left: -1118.9395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 20%); left: -1103.9604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 28%); left: -1087.7395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 15%); left: -1072.7604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 16%); left: -1056.5395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 22%); left: -1041.5604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 24%); left: -1025.3395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 21%); left: -1010.3604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 22%); left: -994.13953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 18%); left: -979.16046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 26%); left: -962.93953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 20%); left: -947.96046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 24%); left: -931.73953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 20%); left: -916.76046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 19%); left: -900.53953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 24%); left: -885.56046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 19%); left: -869.33953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 15%); left: -854.36046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 28%); left: -838.13953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 15%); left: -823.16046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 15%); left: -806.93953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 19%); left: -791.96046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 18%); left: -775.73953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 26%); left: -760.76046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 25%); left: -744.53953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 21%); left: -729.56046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 21%); left: -713.33953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 21%); left: -698.36046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 16%); left: -682.13953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 22%); left: -667.16046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 18%); left: -650.93953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 21%); left: -635.96046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 19%); left: -619.73953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 27%); left: -604.76046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 23%); left: -588.53953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 20%); left: -573.56046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 20%); left: -557.33953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 21%); left: -542.36046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 21%); left: -526.13953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 21%); left: -511.16046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 19%); left: -494.93953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 26%); left: -479.96046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 25%); left: -463.73953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 27%); left: -448.76046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 17%); left: -432.53953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 19%); left: -417.56046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 24%); left: -401.33953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 15%); left: -386.36046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 18%); left: -370.13953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 20%); left: -355.16046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 26%); left: -338.93953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 22%); left: -323.96046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 22%); left: -307.73953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 27%); left: -292.76046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 17%); left: -276.53953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 19%); left: -261.56046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 18%); left: -245.33953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 18%); left: -230.36046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 21%); left: -214.13953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 27%); left: -199.16046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 24%); left: -182.93953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 16%); left: -167.96046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 28%); left: -151.73953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 21%); left: -136.76046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 15%); left: -120.53953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 15%); left: -105.56046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 24%); left: -89.33953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 16%); left: -74.360465116278px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 22%); left: -58.13953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 18%); left: -43.160465116278px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 21%); left: -26.93953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 18%); left: -11.960465116278px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 25%); left: 4.2604651162802px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 25%); left: 19.239534883722px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 25%); left: 35.46046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 26%); left: 50.439534883722px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 27%); left: 66.66046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 26%); left: 81.639534883722px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 15%); left: 97.86046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 15%); left: 112.83953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 15%); left: 129.06046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 28%); left: 144.03953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 23%); left: 160.26046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 28%); left: 175.23953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 17%); left: 191.46046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 28%); left: 206.43953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 26%); left: 222.66046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 19%); left: 237.63953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 25%); left: 253.86046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 25%); left: 268.83953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 25%); left: 285.06046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 28%); left: 300.03953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 21%); left: 316.26046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 21%); left: 331.23953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 28%); left: 347.46046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 23%); left: 362.43953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 22%); left: 378.66046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 26%); left: 393.63953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 25%); left: 409.86046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 19%); left: 424.83953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 28%); left: 441.06046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 22%); left: 456.03953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 22%); left: 472.26046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 19%); left: 487.23953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 28%); left: 503.46046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 26%); left: 518.43953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 22%); left: 534.66046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 20%); left: 549.63953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 21%); left: 565.86046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 21%); left: 580.83953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 20%); left: 597.06046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 22%); left: 612.03953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 24%); left: 628.26046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 16%); left: 643.23953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 15%); left: 659.46046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 19%); left: 674.43953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 25%); left: 690.66046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 25%); left: 705.63953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 24%); left: 721.86046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 21%); left: 736.83953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 16%); left: 753.06046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 20%); left: 768.03953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 15%); left: 784.26046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 24%); left: 799.23953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 24%); left: 815.46046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 28%); left: 830.43953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 18%); left: 846.66046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 28%); left: 861.63953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 25%); left: 877.86046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 19%); left: 892.83953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 21%); left: 909.06046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 26%); left: 924.03953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 20%); left: 940.26046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 21%); left: 955.23953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 24%); left: 971.46046511628px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 25%); left: 986.43953488372px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 18%); left: 1002.6604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 21%); left: 1017.6395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 27%); left: 1033.8604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 25%); left: 1048.8395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 19%); left: 1065.0604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 23%); left: 1080.0395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 17%); left: 1096.2604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 21%); left: 1111.2395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 23%); left: 1127.4604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 25%); left: 1142.4395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 20%); left: 1158.6604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 19%); left: 1173.6395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 17%); left: 1189.8604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 28%); left: 1204.8395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 25%); left: 1221.0604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 23%); left: 1236.0395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 26%); left: 1252.2604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 18%); left: 1267.2395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 17%); left: 1283.4604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 19%); left: 1298.4395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 24%); left: 1314.6604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 15%); left: 1329.6395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 21%); left: 1345.8604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 25%); left: 1360.8395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 19%); left: 1377.0604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 17%); left: 1392.0395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 17%); left: 1408.2604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 22%); left: 1423.2395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 19%); left: 1439.4604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 17%); left: 1454.4395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 17%); left: 1470.6604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 15%); left: 1485.6395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 27%); left: 1501.8604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 26%); left: 1516.8395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 17%); left: 1533.0604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 22%); left: 1548.0395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 15%); left: 1564.2604651163px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 24%); left: 1579.2395348837px; top: 196px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 15%); left: -1289.8604651163px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 24%); left: -1274.8813953488px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 15%); left: -1258.6604651163px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 16%); left: -1243.6813953488px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 20%); left: -1227.4604651163px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 22%); left: -1212.4813953488px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 17%); left: -1196.2604651163px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 25%); left: -1181.2813953488px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 22%); left: -1165.0604651163px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 20%); left: -1150.0813953488px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 15%); left: -1133.8604651163px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 20%); left: -1118.8813953488px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 19%); left: -1102.6604651163px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 15%); left: -1087.6813953488px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 21%); left: -1071.4604651163px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 28%); left: -1056.4813953488px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 16%); left: -1040.2604651163px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 28%); left: -1025.2813953488px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 21%); left: -1009.0604651163px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 19%); left: -994.08139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 25%); left: -977.86046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 23%); left: -962.88139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 22%); left: -946.66046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 19%); left: -931.68139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 17%); left: -915.46046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 20%); left: -900.48139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 28%); left: -884.26046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 20%); left: -869.28139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 25%); left: -853.06046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 24%); left: -838.08139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 16%); left: -821.86046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 26%); left: -806.88139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 18%); left: -790.66046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 19%); left: -775.68139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 26%); left: -759.46046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 23%); left: -744.48139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 21%); left: -728.26046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 21%); left: -713.28139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 23%); left: -697.06046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 28%); left: -682.08139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 22%); left: -665.86046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 15%); left: -650.88139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 18%); left: -634.66046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 25%); left: -619.68139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 26%); left: -603.46046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 18%); left: -588.48139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 15%); left: -572.26046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 16%); left: -557.28139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 26%); left: -541.06046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 28%); left: -526.08139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 16%); left: -509.86046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 16%); left: -494.88139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 26%); left: -478.66046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 21%); left: -463.68139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 21%); left: -447.46046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 18%); left: -432.48139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 26%); left: -416.26046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 21%); left: -401.28139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 23%); left: -385.06046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 16%); left: -370.08139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 24%); left: -353.86046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 19%); left: -338.88139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 20%); left: -322.66046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 15%); left: -307.68139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 26%); left: -291.46046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 25%); left: -276.48139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 22%); left: -260.26046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 21%); left: -245.28139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 22%); left: -229.06046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 25%); left: -214.08139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 20%); left: -197.86046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 28%); left: -182.88139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 18%); left: -166.66046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 19%); left: -151.68139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 24%); left: -135.46046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 18%); left: -120.48139534884px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 25%); left: -104.26046511628px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 17%); left: -89.281395348836px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 28%); left: -73.060465116278px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 18%); left: -58.081395348836px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 17%); left: -41.860465116278px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 25%); left: -26.881395348836px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 28%); left: -10.660465116278px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 16%); left: 4.3186046511638px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 17%); left: 20.539534883722px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 20%); left: 35.518604651164px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 27%); left: 51.739534883722px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 27%); left: 66.718604651164px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 26%); left: 82.939534883722px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 28%); left: 97.918604651164px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 22%); left: 114.13953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(215, 43%, 27%); left: 129.11860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 25%); left: 145.33953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 20%); left: 160.31860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 18%); left: 176.53953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 22%); left: 191.51860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 24%); left: 207.73953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 18%); left: 222.71860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 22%); left: 238.93953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 16%); left: 253.91860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 18%); left: 270.13953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 19%); left: 285.11860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 27%); left: 301.33953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 18%); left: 316.31860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 20%); left: 332.53953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 18%); left: 347.51860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 20%); left: 363.73953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 18%); left: 378.71860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 18%); left: 394.93953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 27%); left: 409.91860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 19%); left: 426.13953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 15%); left: 441.11860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 25%); left: 457.33953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 24%); left: 472.31860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 23%); left: 488.53953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 28%); left: 503.51860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 19%); left: 519.73953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 28%); left: 534.71860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 22%); left: 550.93953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 28%); left: 565.91860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 20%); left: 582.13953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 26%); left: 597.11860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 20%); left: 613.33953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 28%); left: 628.31860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 25%); left: 644.53953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 18%); left: 659.51860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 20%); left: 675.73953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 15%); left: 690.71860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 22%); left: 706.93953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 19%); left: 721.91860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 22%); left: 738.13953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 15%); left: 753.11860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(222, 43%, 24%); left: 769.33953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 15%); left: 784.31860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 17%); left: 800.53953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 15%); left: 815.51860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 18%); left: 831.73953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 19%); left: 846.71860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 28%); left: 862.93953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(219, 43%, 20%); left: 877.91860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 18%); left: 894.13953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 25%); left: 909.11860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 28%); left: 925.33953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(218, 43%, 24%); left: 940.31860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 21%); left: 956.53953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 25%); left: 971.51860465116px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 20%); left: 987.73953488372px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 26%); left: 1002.7186046512px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 25%); left: 1018.9395348837px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 18%); left: 1033.9186046512px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 27%); left: 1050.1395348837px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 21%); left: 1065.1186046512px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 17%); left: 1081.3395348837px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 27%); left: 1096.3186046512px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(215, 43%, 16%); left: 1112.5395348837px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 27%); left: 1127.5186046512px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 28%); left: 1143.7395348837px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(222, 43%, 28%); left: 1158.7186046512px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 20%); left: 1174.9395348837px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 22%); left: 1189.9186046512px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 25%); left: 1206.1395348837px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 26%); left: 1221.1186046512px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(219, 43%, 28%); left: 1237.3395348837px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 17%); left: 1252.3186046512px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 22%); left: 1268.5395348837px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(216, 43%, 23%); left: 1283.5186046512px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(212, 43%, 24%); left: 1299.7395348837px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 23%); left: 1314.7186046512px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(217, 43%, 27%); left: 1330.9395348837px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(212, 43%, 15%); left: 1345.9186046512px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 26%); left: 1362.1395348837px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 20%); left: 1377.1186046512px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(216, 43%, 22%); left: 1393.3395348837px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 25%); left: 1408.3186046512px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(214, 43%, 16%); left: 1424.5395348837px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 25%); left: 1439.5186046512px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(218, 43%, 21%); left: 1455.7395348837px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(217, 43%, 28%); left: 1470.7186046512px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 18%); left: 1486.9395348837px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(220, 43%, 17%); left: 1501.9186046512px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(221, 43%, 23%); left: 1518.1395348837px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(214, 43%, 17%); left: 1533.1186046512px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(220, 43%, 28%); left: 1549.3395348837px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(221, 43%, 16%); left: 1564.3186046512px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

       <div class="test_triangle_up" style="border-bottom: 28px solid hsl(213, 43%, 19%); left: 1580.5395348837px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>
       <div class="test_triangle_down" style="border-top: 28px solid hsl(213, 43%, 26%); left: 1595.5186046512px; top: 224px; border-left: 16.279069767442px solid transparent; border-right: 16.279069767442px solid transparent;"></div>

   </div> -->


   <div id="top_banner_box_v2" class="col-xs-12 col-md-10 col-md-offset-1 top-banner-box">
    <div class="banner">
        <div class="header_container">
            <div class="header">
                <div class="left">
                    <?=$KUser->Access->display_name_link()?>
                    <span class="awards">
                        <?php
                        $awards = $KUser->Access->awards ? $KUser->Access->awards : array();
                        foreach($awards as $awrd) :?>
                        <img src="<?=KSM_BASE_URL?>images/awards/<?=$awrd['name']?>.png" />
                    <?php endforeach;?>
                </span>
                <div class="clr"></div>
            </div>





            <div class="clr"></div>

        </div>

    </div>





    <div id="top_banner_dark_glass"></div>
    <div class="top_banner_header_shadowgradient"></div>
    <div class="content">



        <div class="tagline"><?=$KUser->Access->tagline?></div>

        <div class="location"><?=get_countryName($KUser->Access->country)?></div>

        <div class="website"><a target="_blank" href="<?=$KUser->Access->user_url?>"><?=$KUser->Access->user_url?></a></div>



        <?php if($KUser->isPrivate) : ?>

            <div class="private">

                <div class="profile_completeness">

                    <div class="progress"><div class="bar" style="width: <?=$progress_width?>"></div></div>

                    <div style="line-height: 12px;">PROFILE COMPLETE</div>

                </div>



                <div class="edit_profile_container">
                    <a title="Edit Profile" class="colorbox" href="<?=ksm_get_permalink('edit_profile')?>">

                        <div class="edit_profile">
                        </div>
                        <div class="edit_profile_hover">
                        </div>
                    </a>
                </div>

                <div class="edit_settings_container">
                    <a title="Account Settings" class="colorbox" href="<?=ksm_get_permalink('account_settings')?>">

                        <div class="edit_settings">
                        </div>
                        <div class="edit_settings_hover">
                        </div>
                    </a>
                </div>




                <div class="clr"></div>

            </div>

        <?php endif; ?>

    </div>





    <div class="stats">

        <?php if($KUser->isPrivate) : ?>

            <div class="col">

                <div class="lifetime_earning"><?=edd_currency_filter(edd_format_amount($KUser->Access->sales_lifetime, false))?></div>

                <div class="monthly_earning"><?=edd_currency_filter(edd_format_amount($KUser->Access->sales_month, false))?></div>

            </div>

        <?php endif; ?>

        <div class="col">

            <div class="projects"><?=get_number($KUser->Access->products_count)?></div>

            <div class="rank"><?=edd_format_amount($KUser->Access->rank)?></div>

        </div>

        <div class="col">

            <div class="views"><?=get_number($KUser->Access->projects_views)?></div>

            <div class="likes"><?=get_number($KUser->Access->projects_likes_count)?></div>

            <div class="followers"><?=get_number($KUser->Access->followers_count)?></div>

        </div>

    </div>






    <div class="avatar_container">
        <div class="avatar">

            <?=$KUser->Access->avatar_link('avatar_large')?>

        </div>
    </div>

</div>



</div>

</div>