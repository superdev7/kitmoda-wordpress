<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



class KSM_Collaboration_Wip extends KSM_Post {
    
    public $_post_type = 'collab_active_step';
    
    public function __construct($id) {
        parent::__construct($id);
    }
    
    
    public function __isValid() {
        if($this->is_collaboration_wip == 'yes') {
            return true;
        }
        
        return true;
    }
    
    
    
    //public function onSent() {
    //    $this->update_meta('is_collaboration_wip', 'yes');
    //}
    
}



?>