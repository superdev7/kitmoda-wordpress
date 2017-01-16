<?php



class KSM_Message extends KSM_Post {
    
    
    public $_post_type = 'ksm_message';
    
    public function __construct($id = 0) {
        
        
        
        parent::__construct($id);
    }
    
    
    public function hasAccess() {
        $user_id = get_current_user_id();
        
        if($this->ID) {
            if($this->sent_from == $user_id || $this->sent_to == $user_id) {
                return true;
            }
        }
        
        return false;
    }
    
    
    public function download_images() {
        
        
        $downloader = new KSM_Message_Images_Archive_Downloader(array('message' => $this));
        
        
        if($downloader->prepare()) {
            $downloader->init_download();
        }
    }
}






?>