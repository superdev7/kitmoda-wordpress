<?php


if ( is_user_logged_in() ) :
    $user_data = get_userdata( get_current_user_id() );
endif;
?>


<fieldset id="edd_checkout_user_info">
    <legend>Buyer Info</legend>
    
    <div class="section_info">Please provide accurate details to recieve your purchase information</div>
    
    <div class="fields">
        <p id="edd-first-name-wrap">
            <label class="edd-label" for="edd-first">First Name</label>
            <input class="edd-input required" type="text" name="edd_first" placeholder="First name" id="edd-first" value="<?php echo is_user_logged_in() ? $user_data->first_name : ''; ?>"/>
        </p>

        <p id="edd-last-name-wrap">
            <label class="edd-label" for="edd-last">Last Name</label>
            <input class="edd-input required" type="text" name="edd_last" placeholder="Last name" id="edd-last" value="<?php echo is_user_logged_in() ? $user_data->last_name : ''; ?>"/>
        </p>

        <div class="clr"></div>

        <p id="edd-email-wrap">
            <label class="edd-label" for="edd-email">Email</label>
            <input class="edd-input required" type="email" name="edd_email" placeholder="Email address" id="edd-email" value="<?php echo is_user_logged_in() ? $user_data->user_email : ''; ?>"/>
        </p>
    </div>
    
    <?php do_action( 'edd_purchase_form_user_info' ); ?>
</fieldset>