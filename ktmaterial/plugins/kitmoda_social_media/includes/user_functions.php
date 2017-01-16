<?php




function KSM_Generate_Username($display_name = '') {
    return str_replace(' ', '_', strtolower(trim($display_name)));
}


function KSM_display_name_available($display_name = '') {
    if(!KSM_User::display_name_exists($display_name)) {
        
        $username = KSM_Generate_Username($display_name);
        
        if(!KSM_User::username_exists($username)) {
            return true;
        }
    }
    
    return false;
}



?>