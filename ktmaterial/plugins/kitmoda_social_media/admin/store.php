<?php
if (!defined('ABSPATH')){
    exit; // Exit if accessed directly
}

$def_count = 10;

if ($_POST['ksm_action'] == 'save_store_settings' && wp_verify_nonce($_POST['ksm_store_settings_nonce'], basename(__FILE__))) {

    $ksm_store_settings = get_option('ksm_store_settings') ? get_option('ksm_store_settings') : array();

    $ksm_store_settings['feat_cats']['count'] = !empty($_POST['feat_cats_count']) ? (int)$_POST['feat_cats_count'] : $def_count;
    $ksm_store_settings['feat_cats']['list'] = !empty($_POST['feat_cats_list']) ? $_POST['feat_cats_list'] : array();
    
    $ksm_store_settings['art_styles']['count'] = !empty($_POST['art_styles_count']) ? (int)$_POST['art_styles_count'] : $def_count;
    $ksm_store_settings['art_styles']['list'] = !empty($_POST['art_styles_list']) ? $_POST['art_styles_list'] : array();
    
    $ksm_store_settings['download']['count'] = !empty($_POST['download_count']) ? (int)$_POST['download_count'] : $def_count;
    $ksm_store_settings['download']['list'] = !empty($_POST['download_list']) ? $_POST['download_list'] : array();

    update_option('ksm_store_settings', $ksm_store_settings);
    ?>
    <div>
        <div class="update-nag">Changes Saved.</div>            
    </div>

    <?php
}
$ksm_store_settings = get_option('ksm_store_settings') ? get_option('ksm_store_settings') : array();
$feat_cats_count = !empty($ksm_store_settings['feat_cats']['count']) ? $ksm_store_settings['feat_cats']['count'] : $def_count;
$feat_cats_list = !empty($ksm_store_settings['feat_cats']['list']) ? $ksm_store_settings['feat_cats']['list'] : array();

$art_styles_count = !empty($ksm_store_settings['art_styles']['count']) ? $ksm_store_settings['art_styles']['count'] : $def_count;
$art_styles_list = !empty($ksm_store_settings['art_styles']['list']) ? $ksm_store_settings['art_styles']['list'] : $def_count;

$download_count = !empty($ksm_store_settings['download']['count']) ? $ksm_store_settings['download']['count'] : $def_count;
$download_list = !empty($ksm_store_settings['download']['list']) ? $ksm_store_settings['download']['list'] : $def_count;
?>
<div class="wrap"><h2>Kitmoda Social Media Store page</h2>

    <form method="post" action="">
        <input type="hidden" name="ksm_action" value="save_store_settings" />
        <input type="hidden" name="ksm_store_settings_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)) ?>" />
        <!--** For Featured Categories **-->
        <h3 class="title">Settings for Featured Categories</h3>
        <div class="inside">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Max count of thumbnails:</th>
                    <td>
                        <input type="text" name="feat_cats_count" value="<?php echo $feat_cats_count; ?>" size="60" style="width: 180px;" /> <span style="color:#424242;font-size:12px">(default <?php echo $def_count; ?>)</span>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">The list of Categories:</th>
                    <td>
                        <?php
                            $terms = get_terms( 'category', array(
                                    'orderby'    => 'id',
                                    'hide_empty' => false,
                                    'fields'     => 'id=>name',
                                    'exclude'    => '1'
                            ) );
                            if( !empty($terms) ){
                                echo '<select name="feat_cats_list[]" multiple size="5" style="width: 30%;min-width: 180px;">';
                                foreach ($terms as $term_id => $term_name) {
                                    echo '<option value="'. $term_id .'" '. selected(true, in_array($term_id, $feat_cats_list), false) .'>'. $term_name .'</option>';                    
                                }
                                echo '</select>';
                            }                            
                            ?>
                    </td>
                </tr>

            </table>
        </div>
        
        <!--** For ART STYLES **-->
        <h3 class="title">Settings for Art styles</h3>
        <div class="inside">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Max count of thumbnails:</th>
                    <td>
                        <input type="text" name="art_styles_count" value="<?php echo $art_styles_count; ?>" size="60" style="width: 180px;" /> <span style="color:#424242;font-size:12px">(default <?php echo $def_count; ?>)</span>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">The list of Styles:</th>
                    <td>
                        <?php
                            $terms = get_terms( 'ksm_tax_style', array(
                                    'orderby'    => 'name',
                                    'hide_empty' => false,
                                    'fields'     => 'id=>name',
                            ) );
                            if( !empty($terms) ){
                                echo '<select name="art_styles_list[]" multiple size="5" style="width: 30%;min-width: 180px;">';
                                foreach ($terms as $term_id => $term_name) {
                                    echo '<option value="'. $term_id .'" '. selected(true, in_array($term_id, $art_styles_list), false) .'>'. $term_name .'</option>';                    
                                }
                                echo '</select>';
                            }                            
                            ?>
                    </td>
                </tr>

            </table>
        </div>
        
        <!--** For "Downloads" **-->
        <h3 class="title">Settings for Downloads</h3>
        <div class="inside">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Max count of thumbnails:</th>
                    <td>
                        <input type="text" name="download_count" value="<?php echo $download_count; ?>" size="60" style="width: 180px;" /> <span style="color:#424242;font-size:12px">(default <?php echo $def_count; ?>)</span>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">The list of Downloads:</th>
                    <td>
                        <?php
                            $args = array(
                                'numberposts' => -1,
                                'post_type' => 'download',
                                'post_status' => 'publish',
                            );
                            $posts = get_posts($args);
                            if( !empty($posts) ){
                                echo '<select name="download_list[]" multiple size="5" style="width: 30%;min-width: 180px;">';
                                foreach ($posts as $key => $value) {
                                    echo '<option value="'. $value->ID .'" '. selected(true, in_array($value->ID, $download_list), false) .'>'. $value->post_title .'</option>';                    
                                }
                                echo '</select>';
                            }                            
                            ?>
                    </td>
                </tr>

            </table>
        </div>

        <div class="submit">
            <input type="submit" class="button-primary" name="info_update" value="Update Options »">
        </div>						
    </form>

</div>