<?php


class KSM_Award {
    
    
    
    public static $permanent_awards = array(
        'blackCurtainBeta' => array(
            'title' => 'Black Curtain Beta'
        ),
        'earlyAdopter' => array(
            'title' => 'Early Adopter'
        )
    );
    
    public static $temporary_awards = array(
        'topTenSeller',
        'trendingArtist',
        'greatArtwork'
    );
    
    
    static function get_settings($award) {
        $settings = get_option('ksm_award_settings');
        return $settings[$award];
    }
    
    
    static function register_award($user_id, $award) {
        $user = get_user_by('id', $user_id);
        $awards = $user->awards;
        
        $awards[$award] = array(
            'name' => $award,
            'date' => time()
        );
        
        update_user_meta($user->ID, 'awards', $awards);
        update_user_meta($user->ID, 'top_ten_sellers', '1');
        KSM_Notification::add($user_id, 'award', $award);
        
    }
    
    
    static function remove_award($user_id, $award) {
        $user = get_user_by('id', $user_id);
        $awards = $user->awards;
        
        if($awards[$award]) {
            unset($awards[$award]);
        }
        
        $awards = $awards ? $awards : array();
        
        update_user_meta($user->ID, 'awards', $awards);
    }
    
    

    static function blackCurtainBeta($user_id) {
        $settings = self::get_settings('blackCurtainBeta');
        
        $start = validateDate($settings['start']) ? strtotime($settings['start']) : 0;
        $end = validateDate($settings['end']) ? strtotime($settings['end']) : 0;
        
        
        if($start && $end && $start < $end) {
            $user = get_user_by('id', $user_id);
            $register_time = strtotime($user->user_registered);
            
            if($register_time > $start && $register_time < $end) {
                self::register_award($user_id, 'blackCurtainBeta');
            }
        }
    }
    
    
    
    static function earlyAdopter($user_id) {
        $settings = self::get_settings('earlyAdopter');
        
        $start = validateDate($settings['start']) ? strtotime($settings['start']) : 0;
        $end = validateDate($settings['end']) ? strtotime($settings['end']) : 0;
        
        if($start && $end && $start < $end) {
            $user = get_user_by('id', $user_id);
            $register_time = strtotime($user->user_registered);
            
            if($register_time > $start && $register_time < $end) {
                self::register_award($user_id, 'earlyAdopter');
            }
        }
    }
    
    
    
    
    
    
    static function topTenSeller() {
        
        $new_top_ten = KSM_Stats::calculate_top_ten_sellers();
        $old_top_ten = KSM_Stats::top_ten_sellers();
        
        $new_top_ten_ids = array();
        $old_top_ten_ids = array();
        
        foreach($new_top_ten as $u) {
            $new_top_ten_ids[] = $u->ID;
        }
        
        foreach($old_top_ten as $u) {
            $old_top_ten_ids[] = $u->ID;
        }
        
        $new = array_diff($new_top_ten_ids, $old_top_ten_ids);
        $removable = array_diff($old_top_ten_ids, $new_top_ten_ids);
        $existing = array_intersect($new_top_ten_ids, $old_top_ten_ids);
        
        
        foreach($old_top_ten as $u) {
            if(in_array($u->ID, $removable)) {
                self::remove_award($u->ID, 'topTenSeller');
            }
        }
        
        foreach($new_top_ten as $u) {
            if(in_array($u->ID, $new)) {
                self::register_award($u->ID, 'topTenSeller');
            }
        }
    }
    
    static function trendingArtist() {
        
        
    }
    
    
    static function greatArtwork() {
        
        
        
    }

}