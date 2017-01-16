<div class="window_inner">
    <iframe name="edit_settings_frame" class="formframe"></iframe>
    <form method="post" action="<?=admin_url( 'admin-ajax.php' )?>" target="edit_settings_frame">
    <input type="hidden" name="action" value="User_update_settings" />
    <div class="win_header" hec="1">
        <div class="title">Account Settings</div>
        <a class="close"></a>
    </div>
    <div class="content">
        
        <h1>Customize your experience...</h1>
        
        
        
        <div class="section">
            <h2>Email Preferences</h2>
            
            
            <div class="field_group">
                <div class="field_title">Receive Challenge Updates</div>
                <div class="field">
                    <input type="radio" name="email_challenge" id="email_challenge_1" value="1"<?=($settings['email_challenge'] == '1' ? ' checked="checked"':'')?> />
                    <label for="email_challenge_1">All challenge posts and updates</label>
                </div>
                
                <div class="field">
                    <input type="radio" name="email_challenge" id="email_challenge_2" value="2"<?=($settings['email_challenge'] == '2' ? ' checked="checked"':'')?> />
                    <label for="email_challenge_2">Only receive info about the monthly rules and winners</label>
                </div>
                
                <div class="field">
                    <input type="radio" name="email_challenge" id="email_challenge_3" value="3"<?=($settings['email_challenge'] == '3' ? ' checked="checked"':'')?> />
                    <label for="email_challenge_3">Do not send me any challenge related news</label>
                </div>
            </div>
            
            
            <div class="field_group">
                <div class="field_title">Receive info about updates and features on Kitmoda</div>
                <div class="field">
                    <input type="radio" name="email_updates" id="email_updates_1" value="1"<?=($settings['email_updates'] == '1' ? ' checked="checked"':'')?> />
                    <label for="email_updates_1">All feature and site related emails</label>
                </div>
                <div class="field">
                    <input type="radio" name="email_updates" id="email_updates_2" value="2"<?=($settings['email_updates'] == '2' ? ' checked="checked"':'')?> />
                    <label for="email_updates_2">Do not send me site related news</label>
                </div>
            </div>
            
            
            <div class="field_group">
                <div class="field_title">Receive email reports about your sales</div>
                <div class="field">
                    <input type="radio" name="email_sales" id="email_sales_1" value="1"<?=($settings['email_sales'] == '1' ? ' checked="checked"':'')?> />
                    <label for="email_sales_1">Receive sales reports via email</label>
                </div>
                <div class="field">
                    <input type="radio" name="email_sales" id="email_sales_2" value="2"<?=($settings['email_sales'] == '2' ? ' checked="checked"':'')?> />
                    <label for="email_sales_2">Do not send me any sales reports</label>
                </div>
            </div>
            
            
            <div class="field_group">
                <div class="field_title">Unsubscribe to all Kitmoda email</div>
                <div class="field">
                    <input type="checkbox" name="email_all" id="email_all_1" value="1"<?=($settings['email_all'] == '1' ? ' checked="checked"':'')?> />
                    <label for="email_all_1">Unsubscribe - we will still need to send tax and business related emails but only as absolutely needed.</label>
                </div>
            </div>
        </div>
        
        
        <div class="section">
            <h2>Site Preferences</h2>
            
            <div class="field_group">
                <div class="field_title">I am mostly interested in...</div>
                <div class="field">
                    <input type="radio" name="site_interested" id="site_interested_1" value="1"<?=($settings['site_interested'] == '1' ? ' checked="checked"':'')?>  />
                    <label for="site_interested_1">Creating/Selling Artwork on Kitmoda</label>
                </div>
                <div class="field">
                    <input type="radio" name="site_interested" id="site_interested_2" value="2"<?=($settings['site_interested'] == '2' ? ' checked="checked"':'')?>  />
                    <label for="site_interested_2">Buying Artwork on Kitmoda</label>
                </div>
                <div class="field">
                    <input type="radio" name="site_interested" id="site_interested_3" value="3"<?=($settings['site_interested'] == '3' ? ' checked="checked"':'')?>  />
                    <label for="site_interested_3">Equally interested in both Buying and Selling</label>
                </div>
            </div>
            
            
            <div class="field_group">
                <div class="field_title">Set my default entry page to...</div>
                <div class="field">
                    <input type="radio" name="site_default_page" id="site_default_page_1" value="1"<?=($settings['site_default_page'] == '1' ? ' checked="checked"':'')?>  />
                    <label for="site_default_page_1">Community (Default)</label>
                </div>
                <div class="field">
                    <input type="radio" name="site_default_page" id="site_default_page_2" value="2"<?=($settings['site_default_page'] == '2' ? ' checked="checked"':'')?>  />
                    <label for="site_default_page_2">Studio</label>
                </div>
                <div class="field">
                    <input type="radio" name="site_default_page" id="site_default_page_3" value="3"<?=($settings['site_default_page'] == '3' ? ' checked="checked"':'')?>  />
                    <label for="site_default_page_3">Collaboration</label>
                </div>
                <div class="field">
                    <input type="radio" name="site_default_page" id="site_default_page_4" value="4"<?=($settings['site_default_page'] == '4' ? ' checked="checked"':'')?>  />
                    <label for="site_default_page_4">Store</label>
                </div>
                <div class="field">
                    <input type="radio" name="site_default_page" id="site_default_page_5" value="5"<?=($settings['site_default_page'] == '5' ? ' checked="checked"':'')?>  />
                    <label for="site_default_page_5">Stats</label>
                </div>
            </div>
            
        </div>
        
    </div>
    <div class="footer" hec="1">
        <a href="" class="btn btn_blue btn_form_smt btn_update_profile">Update</a>
    </div>
    </form>
</div>