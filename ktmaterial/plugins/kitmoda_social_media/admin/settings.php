<?php


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



wp_enqueue_script( 'jquery-ui-datepicker' );



if($_POST['ksm_action'] == 'save_settings' && wp_verify_nonce($_POST['ksm_settings_nonce'], basename(__FILE__))) {
    
    
    $ksm_award_settings = array();
    
    
    if($_POST['blackCurtainBeta']['start'] && $_POST['blackCurtainBeta']['end']) {
        $ksm_award_settings['blackCurtainBeta'] =  esc_html($_POST['blackCurtainBeta']);
    }
    
    if($_POST['earlyAdopter']['start'] && $_POST['earlyAdopter']['end']) {
        $ksm_award_settings['earlyAdopter'] = esc_html($_POST['earlyAdopter']);
    }
    
    
    
    
    
    
    update_option('ksm_award_settings', $ksm_award_settings);
    
    $ksm_award_settings = get_option('ksm_award_settings') ? get_option('ksm_award_settings') : array();
    
    
    
    ?>
<div>
    <div class="update-nag">Changes Saved.</div></div>
    
    <?php          
    
}



?>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.datepicker').datepicker();
    });
</script>
<div class="wrap"><h2>Kitmoda Social Media Settings</h2>
    
    
    
        <form method="post" action="">
            <input type="hidden" name="ksm_action" value="save_settings" />
            <input type="hidden" name="ksm_settings_nonce" value="<?=wp_create_nonce(basename(__FILE__))?>" />
                <h3 class="title">Award Settings</h3>
                <h4 scope="row"></h4>
                <div class="inside">
                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row">Black Curtain Beta</th>
                            <td>
                                <label>Date Start</label><input type="text" class="datepicker" name="blackCurtainBeta[start]" value="<?=$ksm_award_settings['blackCurtainBeta']['start']?>" size="60" style="width: 180px;margin-right: 40px;" />
                                <label>Date End</label><input type="text" class="datepicker" name="blackCurtainBeta[end]" value="<?=$ksm_award_settings['blackCurtainBeta']['end']?>" size="60" style="width: 180px;" />
                            </td>
                        </tr>
                        
                        <tr valign="top">
                            <th scope="row">Early Adopter</th>
                            <td>
                                <label>Date Start</label><input type="text" class="datepicker" name="earlyAdopter[start]" value="<?=$ksm_award_settings['earlyAdopter']['start']?>" size="60" style="width: 180px;margin-right: 40px;" />
                                <label>Date End</label><input type="text" class="datepicker" name="earlyAdopter[end]" value="<?=$ksm_award_settings['earlyAdopter']['end']?>" size="60" style="width: 180px;" />
                            </td>
                        </tr>
                        
                    </table>
                </div>
                
                
              


    <div class="submit">
        <input type="submit" class="button-primary" name="info_update" value="Update Options »">
    </div>						
 </form>


    
    </div>