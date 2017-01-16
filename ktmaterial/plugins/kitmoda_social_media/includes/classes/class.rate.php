<?php



// Raw user input
// post parent = download
class KSM_Purchased_Download_Rate extends KSM_Post {
    
    public $_post_type = 'ksm_p_download_rate';
    
    
    public function __get($name) {
        if($name == 'Download' && !isset($this->Download)) {
            $this->Download = new KSM_Download($this->post_parent);
        }
        return parent::__get($name);
    }
    
    
    
    
}



// Product Rating Averages
/*
class KSM_Download_Rate extends KSM_Post {
    
    public $_post_type = 'ksm_download_rate';
    
    
    public function __get($name) {
        if($name == 'Download' && !isset($this->Download)) {
            $this->Download = new KSM_Download($this->post_parent);
        }
        return parent::__get($name);
    }
}

*/





// Per Purchased Item User Score rating
/*
class KSM_User_Purchased_Download_Rate_Score extends KSM_Post {
    public $_post_type = 'ksm_user_p_download_rate';
    
    
    public function __get($name) {
        if($name == 'Download' && !isset($this->Download)) {
            $this->Download = new KSM_Download($this->post_parent);
        }
        return parent::__get($name);
    }
}
*/


// Per Product User Score rating Averages
class KSM_User_Download_Rate_Score extends KSM_Post {
    
    public $_post_type = 'ksm_user_download_rate';
    
    
    public function __get($name) {
        if($name == 'Download' && !isset($this->Download)) {
            $this->Download = new KSM_Download($this->post_parent);
        }
        return parent::__get($name);
    }
}


// KSM_User->solo_av_score, 
// KSM_User->role_av_score
// KSM_User->maintenance_av_score
// KSM_User->team_av_score




