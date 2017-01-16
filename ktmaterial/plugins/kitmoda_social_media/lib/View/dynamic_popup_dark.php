<?php 
include 'header-popup.php';


global $wp_query;
$win_name = $wp_query->query_vars['ksm_pname'];
$h = $GLOBALS['ksm_win_settings'][$win_name]['height'];


?>
    <div class="window dark <?=$win_name?>" h="<?=$h?>">
        <?php 
            if ( have_posts() ) :
                while ( have_posts() ) : 
                    the_post();
                    the_content();
                endwhile;
            endif;
            ?>
    </div>
</body>
</html>