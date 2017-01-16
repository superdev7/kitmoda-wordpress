<?php


class KSM_unInstall {
    
    function init () {
        global $wpdb;

        require_once(ABSPATH . 'magento-help/includes/upgrade.php');
        delete_option( "ksm_plugin_version");
    }
    
}


?>