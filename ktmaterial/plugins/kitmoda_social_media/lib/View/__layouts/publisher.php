<?php
wp_enqueue_script('colorbox-js', trailingslashit(KSM_BASE_URL).'js/colorbox.js', array('jquery', 'ksm_scripts'));
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> style="margin-top: 0 !important;height: 100%;overflow-y: hidden">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <?php wp_head(); ?>
    
    
    
</head>



<body <?php body_class('ksm_popup'); ?>>
    <div class="window <?=$this->action?>" h="<?=$h?>">
        <?php 
        
        
        if($publisher && is_object($publisher)) :
            
            $name = "pub_{$publisher->name}" ;
            
            
            
            foreach((Array) $publisher->uploaders as $upl_name) {
                $upl = KSM_Uploader::get_uploader($upl_name);
                if($upl) {
                    $upl->build();
                }
            }
            
            $form_action = admin_url( 'admin-ajax.php' );
        ?>
        
        <div class="window_inner">
            <iframe name="pub_frame" class="formframe"></iframe>
            <form class="<?=$name?> pub_form" method="post" target="pub_frame" action="<?=$form_action?>">

                <input type="hidden" id="pub_id" name="pub_id" value="<?=$publisher->get_action_id()?>" />
                <input type="hidden" name="action" value="Publisher_submit" />
                
                
                <div class="step_nav">
                    <div class="step_nav_inner">
                        <div class="prev"></div>
                        <div class="info">Step <span class="left"></span> of <span class="right"></span></div>
                        <div class="next"></div>
                    </div>
                </div>
                
                
                    <?php
                    
                    $num = 1;
                    foreach((Array) $publisher->steps as $name => $s_args) {
                        $step_class = "step publisher_step_{$name}";
                        echo "<div class=\"{$step_class}\" sindex=\"{$num}\" rel=\"{$name}\">";
                        $step_ele = "{$publisher->view_path}{$name}.php";
                        $this->render_element($step_ele, array('step' => $s_args, 'step_num' => $num), true);
                        echo '</div>';
                        $num++;
                    }
                    ?>
            </form>
            
            
           <?php
           
           $terms_file = $publisher->view_path."terms.php";
           if(is_file($terms_file)) {
               echo "<div class=\"term_step\">";
               $this->render_element($terms_file, array(), true);
               echo '</div>';
           }
           
           ?>
            
            
        </div>
        
        
        
        
        
        
        <?php
        
        endif;
        ?>
    </div>
</body>
</html>