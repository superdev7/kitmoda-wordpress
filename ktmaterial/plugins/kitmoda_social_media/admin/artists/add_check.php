<form method="POST">
    <input type="hidden" name="user_id" value="<?=$user->ID?>" />
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row" valign="top">
                    <label>Check ID</label>
		</th>
		<td>
                    <input name="check_id" type="text" value="">
		</td>
            </tr>
            
            
            <tr>
                <th scope="row" valign="top">
                    <label>Amount</label>
		</th>
		<td>
                    <input name="amount" type="text" value="">
		</td>
            </tr>
            
            <tr>
                <th scope="row" valign="top">
                    <label>Year</label>
		</th>
		<td>
                    <select name="year" id="edd-type">
                        <?php
                        
                        $year_start = (int)date("Y") - 2;
                        $year_end = (int)date("Y") + 1;
                        $selected_year = (int)date("Y");
                        foreach(range($year_start, $year_end) as $year) : ?>
                            <option <?=($selected_year == $year ? 'selected="selected" ' : '')?>value="<?=$year?>"><?=$year?></option>
                        <?php endforeach;?>
                    </select>
		</td>
            </tr>
            
            <tr>
                <th scope="row" valign="top">
                    <label>Month</label>
		</th>
		<td>
                    <select name="month" id="edd-type">
                        <?php
                        
                        
                        $selected_month = date("m");
                        foreach(range(01, 12) as $month) :?>
                            <option <?=($selected_month == $month ? 'selected="selected" ' : '')?>value="<?=$month?>"><?=$month?></option>
                        <?php endforeach; ?>
                    </select>
		</td>
            </tr>
            
            
            <tr>
                <th scope="row" valign="top">
                    <label>Check Date</label>
		</th>
		<td>
                    <input name="check_date" type="text" value="">
		</td>
            </tr>
            
            
            <tr>
                <th scope="row" valign="top">
                    <label>Remaining</label>
		</th>
		<td>
                    <input name="remaining" type="text" value="">
		</td>
            </tr>
    </table>
    
    <p class="submit" style="float : right;">
        <input type="hidden" name="ksm_action" value="add_check">
        <input type="hidden" name="ksm_add_check_nonce" value="<?=wp_create_nonce('addcheck')?>">
	<input type="submit" value="Add Check" class="button-primary">
    </p>
    <div class="clr"></div>
</form>