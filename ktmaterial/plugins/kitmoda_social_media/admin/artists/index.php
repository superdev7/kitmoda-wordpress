<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



if($_POST['ksm_action'] == 'update_artist_info' && wp_verify_nonce($_POST['ksm_update_artist_info_nonce'], 'updateartistinfo')) {
    $user_id = sanitize_text_field($_POST['user_id']);
    $user = KSM_User::get($user_id);
    
    if($user) {
        
        $tax_info_recieved = $_POST['tax_info_recieved'] ? 'yes' : 'no';
		//Sanitized Input
        $user->update_meta('address', sanitize_text_field($_POST['artist_address']));
        $user->update_meta('tax_info_recieved', $tax_info_recieved);
        echo '<div><div class="update-nag">Changes Saved.</div></div>';
    }
    
} elseif($_POST['ksm_action'] == 'add_check' && wp_verify_nonce($_POST['ksm_add_check_nonce'], 'addcheck')) {
    $user_id = sanitize_text_field($_POST['user_id']);
    $user = KSM_User::get($user_id);
    
    
    
    if($user) {
        
        //Sanitized inputs
        $check_id = sanitize_text_field($_POST['check_id']);
        $amount = sanitize_text_field($_POST['amount']);
        $year = sanitize_text_field($_POST['year']);
        $month = sanitize_text_field($_POST['month']);
        $check_date  = sanitize_text_field($_POST['check_date']);
        $remaining = sanitize_text_field($_POST['remaining']);
        
        $data = array(
           'user_id' => $user->ID,
           'year'=> $year,
           'month'=> $month,
           'amount'=> $amount,
           'check_id'=> $check_id ,
           'check_date'=> $check_date ,
           'remaining'=> $remaining ,
           'add_date' => time()
        );
        
        global $wpdb;
        $table = $wpdb->prefix . "ksm_payment_checks";
        if($wpdb->insert($table, $data, array('%d', '%d', '%d', '%s', '%s', '%s', '%s', '%d'))) {
            echo '<div><div class="update-nag">Changes Saved.</div></div>';
        } else {
            echo '<div><div class="error-nag">Error while saving data.</div></div>';
        }
    }
    
}











if($_REQUEST['view'] == 'artist') {
    include 'artist_view.php';
} else {
    include 'listing.php';
}
//include 'add_check.php';