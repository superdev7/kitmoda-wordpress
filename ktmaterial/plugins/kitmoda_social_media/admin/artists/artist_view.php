<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$user_id = htmlentities($_REQUEST['user_id'], ENT_QUOTES);
$user = KSM_User::get($user_id);

add_thickbox();

$obj = new Check_List_Table();
$obj->prepare_items();

?>
<div class="wrap">
    
    <a href="?page=<?= urlencode($_REQUEST['page'])?>">Back</a>
    
    <h1>Checks <a title="Add Check" href="#TB_inline&height=450&width=500&inlineId=add_new_check_form" class="page-title-action thickbox">New Check</a></h1>
    
    <div id="add_new_check_form" style="display: none">
        <?php include 'add_check.php' ?>
    </div>
    
    <form method="post">
        <input type="hidden" name="user_id" value="<?=$user->ID?>" />
        <div id="artist_view_page">
            
            
            <div class="left_main" id="user_checks_listing">
                    <?php $obj->display();?>
            </div>
            
            <div class="side_container">
                    
                <h2>Stats</h2>
                <div class="inside">
                    <?php include 'artist_info.php' ?>
                </div>
                    
            </div>

            
            <div class="clr"></div>
        </div>
    </form>
</div>