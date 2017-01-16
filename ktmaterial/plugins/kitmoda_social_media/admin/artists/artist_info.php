<?php if($user instanceof KSM_User) : ?>
<table class="form-table">
    <tbody>
        <tr>
            <th scope="row" valign="top">
                <label>Full name</label>
            </th>
            <td><?=$user->real_full_name()?></td>
        </tr>
        <tr>
            <th scope="row" valign="top">
                <label>Username</label>
            </th>
            <td><?=$user->user_login?></td>
        </tr>
        <tr>
            <th scope="row" valign="top">
                <label>Email</label>
            </th>
            <td><?=$user->user_email?></td>
        </tr>
        <tr>
            <th scope="row" valign="top">
                <label>Earning</label>
            </th>
            <td>
                <?=$user->total_earning()?>
            </td>
        </tr>

    </tbody>
</table>


<p style="margin-bottom: 20px;">
    <label style="font-weight: bold;"><input type="checkbox" name="tax_info_recieved" value="yes"<?=(($user->tax_info_recieved())? ' checked="checked"' : '')?> />Tax Info Recieved</label>
</p>

<p>
    <label style="font-weight: bold;">Address</label><br />
    <textarea style="width : 100%" name="artist_address"><?=$user->address?></textarea>
</p>
       


        
<p class="submit">
    <input type="hidden" name="ksm_action" value="update_artist_info">
    <input type="hidden" name="ksm_update_artist_info_nonce" value="<?=wp_create_nonce('updateartistinfo')?>">
    <input type="submit" value="Update" class="button-primary">
</p>

<?php endif; ?>