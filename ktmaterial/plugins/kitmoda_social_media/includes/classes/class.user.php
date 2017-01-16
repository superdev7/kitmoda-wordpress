<?php

class KSM_User {
    
    
    public $User;
    
    
    
    public function __construct($id, $field = 'id') {
        $this->dated_sales = array();
        $this->User = $this->init($id, $field);
    }
    
    
    
    
    
    public function __get($name) {
        
        
        KSM_Download::get($id);
        
        if($name == 'communication_rating') {
            $name = 'c_communication_rating';
        } elseif($name == 'artwork_rating') {
            $name = 'c_artwork_rating';
        }
        
        
        if(property_exists($this, $name)) {
            return $this->{$name};
        } elseif($this->User && (property_exists($this->User, $name) || isset($this->User->{$name}))) {
            return $this->User->{$name};
        }
    }
    
    static function get($id, $field='id') {
        
        $cls = get_called_class();
        
        $_obj = new $cls($id, $field);
        if($_obj->User && $_obj->User != null) {
            return $_obj;
        }
        
        return null;
    }
    
    
    public function init($id, $field = 'id') {
        
        $user = null;
        if($id) {
            $user = get_user_by($field, $id);
            if(!$user || !$user instanceof WP_User) {
                $user = null;
            }
        }
        return $user;
    }
    
    
    
    function request_reset_password() {
        global $wp_hasher;
        
        $key = get_password_reset_key($this->User);
        
        //$key = wp_generate_password( 52, false );
        //if ( empty( $wp_hasher ) ) {
        //    require_once ABSPATH . WPINC . '/class-phpass.php';
        //    $wp_hasher = new PasswordHash( 8, true );
        //}
        
        //$hashed = $wp_hasher->HashPassword( $key );
        //$this->update(array('user_activation_key' => $hashed));
        
        if(!is_wp_error($key)) {
            $this->emit('request_reset_password', array('key' => $key));
            return true;
        }
        return $key;
    }
    
    
    function update($args = array()) {
        
        if(!empty($args)) {
            $args['ID'] = $this->ID;
            wp_update_user( $args );
        }
    }
    
    
    public function tax_info_recieved() {
        return (($this->tax_info_recieved == 'yes') ? true : false);
    }
    
    public function real_full_name() {
        return $this->first_name.' '.$this->last_name;
    }
    
    public function total_assets_count() {
        
    }
    
    
    public function textured_models_count() {
        
    }
    
    
    public function untextured_models_count() {
        
    }
    
    
    public function total_spent_amount() {
        
    }
    
    public function spent_current_year_amount() {
        
    }
    
    public function spent_current_month_amount() {
        
    }
    
    public function total_spent_last_year() {
        
    }
    
    
    public function get_countryName() {
        
        $country = $this->User->country;
        
        if($country) {
            $countries = KSM_DataStore::Options('country');
            return $countries[$country];
        }
        return '';
        
    }
    
    
    
    function dated_sale_stats($key) {
        
        
        $stats = (Array) $this->dated_sales;
        
        if($key) {
            return $stats[$key];
        }
        return $stats;
    }
    
    
    function year_sales($year = '') {
        
        if(!$year) {
            $year = date('Y');
        }
        
        
        $year_key = ksm_date_key($year);
        
        return $this->dated_sale_stats($year_key);
    }
    
    
    function month_sales($year = '', $month = '') {
        
        if(!$year) {
            $year = date('Y');
        }
        
        if(!$month) {
            $month = date('m');
        }
        
        $key = ksm_date_key($year, $month);
        return $this->dated_sale_stats($key);
    }
    
    function day_sales($year = '', $month = '', $day = '') {
        
        if(!$year) {
            $year = date('Y');
        }
        
        if(!$month) {
            $month = date('m');
        }
        
        if(!$day) {
            $day = date('d');
        }
        
        $key = ksm_date_key($year, $month, $day);
        
        $day_sale_stats = KSM_Count::user_day_sales($this->ID, $year, $month, $day);
        
        return $day_sale_stats;
    }
    
    
    public function avatar($size='avatar_small') {
        
        if($this->User->{$size}) {
            $avatar = $this->User->{$size};
        } elseif($this->User->avatar) {
            $avatar = get_image_src($this->User->avatar, $size);
        }
        
        if($avatar) return $avatar;
        return get_default_avatar($size);
    }
    
    
    public function the_avatar($size='avatar_small') {
        $avatar = $this->avatar($size);
        return '<img alt="Avatar" src="'.$avatar.'" />';
    }
    
    
    
    public function studio_link() {
        return ksm_get_permalink("studio/{$this->user_login}");
    }
    
    
    public function avatar_link($size='avatar_small', $kpload = false) {
        $avatar = $this->avatar($size);
        $kpload = $kpload ? 'class="kpload" ' : '';
        return '<a '.$kpload.'href="'.$this->studio_link().'">'.$this->the_avatar($size).'</a>';
    }
    
    
    public function username_link() {
        
        return '<a class="username" href="'.$this->studio_link().'">'.$this->user_login.'</a>';
    }
    
    
    public function display_name() {
        $name = $this->display_name ? $this->display_name : $this->user_login;
        
        return $name;
    }
    
    public function display_name_link($kpload = false) {
        
        $name = $this->display_name();
        $link = $this->studio_link();
        
        
        $kpload = $kpload ? ' kpload' : '';
        
        
        
        return "<a class=\"username{$kpload}\" href=\"{$link}\">{$name}</a>";
    }
    
    
    public function recordModelReturn() {
        
        
        $dated_stats = (Array) get_user_meta($this->ID, 'dated_stats', true);
        
        
        
        
        $time = time();
        $year = date('Y', $time);
        $month = date('d', $time);
        $date_key = "{$year}_{$month}";
        
        
        $this_month_returns = (INT) $this->monthModelReturns($date_key);
        $dated_stats['model_returns'][$date_key] = $this_month_returns + 1;
        
        $this->update_meta('dated_purchases', $dated_stats);
        $this->update_meta('count_model_returns', $this->totalModelReturns() + 1);
    }
    
    
    
    
    
    
    public function update_meta($meta_key, $meta_value) {
        update_user_meta($this->ID, $meta_key, $meta_value);
    }
    
    
    
    
    public function totalModelReturns() {
        
        $total_model_returns = (INT) get_user_meta($this->ID, 'count_model_returns', true);
        
        
        return $total_model_returns;
    }
    
    public function monthModelReturns($date_key='') {
        
        $dated_stats = (Array) get_user_meta($this->ID, 'dated_stats', true);
        
        
        if(!$date_key) {
            $time = time();
            $year = date('Y', $time);
            $month = date('d', $time);
            $date_key = "{$year}_{$month}";
        }
        
        
        return (INT) $dated_stats['model_returns'][$date_key];
    }
    
    
    public function collaboration_communication_rating() {
        return $this->c_communication_rating;
    }
    
    
    public function collaboration_artwork_rating() {
        return $this->c_artwork_rating;
    }
    
    
    public function update_ratings() {
        
        //echo $this->ID;
        KSM_Count::_update_user_concept_rating($this->ID);
        KSM_Count::_update_user_model_rating($this->ID);
        KSM_Count::_update_user_texture_rating($this->ID);
        KSM_Count::_update_user_solo_rating($this->ID);
        KSM_Count::_update_user_contribution_rating($this->ID);
        KSM_Count::_update_user_team_rating($this->ID);
        
        KSM_Count::_update_user_maintained_asset_rating($this->ID);
        
        $this->update_rating_products();
    }
    
    
    public function update_rating_products() {
        
        
        KSM_Count::_update_user_concept_rating_products($this->ID);
        KSM_Count::_update_user_model_rating_products($this->ID);
        KSM_Count::_update_user_texture_rating_products($this->ID);
        
        KSM_Count::_update_user_solo_rating_products($this->ID);
        KSM_Count::_update_user_contribution_rating_products($this->ID);
        KSM_Count::_update_user_team_rating_products($this->ID);
        
        KSM_Count::_update_user_maintained_asset_rating_products($this->ID);
        
        
    }
    
    
    
    
    
    
    
    function calculate_team_products_rating() {
        
    }
    
    function calculate_preserved_rating() {
        
    }
    
    
    
    
    public function generateConfirmKey() {
        $unique = false;
        
        do {
            $key = wp_generate_password( 32, false, false );
            if(!self::confirmKeyExists($key)) {
                $unique = true;
            }
        } while(!$unique);
        return $key;
    }
    
    
    static function confirmKeyExists($key, $type='') {
        
        global $wpdb;
        $table = $wpdb->prefix . 'ksm_confirm_keys';
        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table} WHERE user_key = %s", $key));
        
        if($row) {
            if($type && $type != $row->type)  {
                return false;
            }
            
            return $row;
        }
        return false;
    }
    
    
    public function getConfirmKey($force, $type = '') {
        global $wpdb;
        
        if($this->confirm_key) {
            return $this->confirm_key;
        }
        
        $table = $wpdb->prefix . 'ksm_confirm_keys';
        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table} WHERE user_id = %s", $this->ID));
        
        
        if($row) {
            $this->confirm_key = $row;
        } elseif($force) {
            $this->confirm_key = $this->setConfirmKey($type);
        }
        
        return $this->confirm_key;
    }
    
    
    public function setConfirmKey($type = 'signup') {
        global $wpdb;
        
        $key = $this->generateConfirmKey();
        
        $valid_till = time() * DAY_IN_SECONDS ;
        $table = $wpdb->prefix . 'ksm_confirm_keys';
        
        $data = array(
            'user_id' => $this->ID,
            'user_key' => $key,
            'valid_till' => $valid_till,
            'type' => $type
            );
        
        $wpdb->insert($table, $data, array('%s', '%s', '%s', '%s'));
        
        return (Object) $data;
    }
    
    
    
    
    static function checkUserKey($key, $type) {

        if($key_data = self::confirmKeyExists($key, $type)) {
            if(time() < $key_data->valid_till) {
                return $key_data;
            }
        }
        
        return false;
    }
    
    
    function varefy_key($key, $type) {
        global $wpdb;
        
        if($this->email_confirmed == 'yes') {
            return false;
        }
        
        $key = htmlspecialchars(strip_tags($key), ENT_QUOTES);
        $key_data = $this->getConfirmKey(false, 'signup');
        
        if($key_data) {
            if(time() < $key_data->valid_till) {
                $this->update_meta('email_confirmed', 'yes');
                $wpdb->delete($wpdb->prefix . 'ksm_confirm_keys', array( 'ID' => $key_data->id ),array('%d'));
                return true;
            }
        }
        return false;
    }
    
    
    static function display_name_exists($display_name = '') {
        global $wpdb;
        $q = "SELECT * FROM $wpdb->users WHERE display_name = '%s'";
        
        $row = $wpdb->get_row($wpdb->prepare($q, $display_name));
        
        
        if($row) {
            return true;
        }
        
        return false;
    }
    
    static function email_exists($email = '') {
        global $wpdb;
        
        if(get_user_by('email', $email)) {
            return true;
        }
        
        return false;
    }
    
    
    static function username_exists($username) {
        return username_exists($username);
    }
    
    
    static function get_user_ids_by_collaboration_rating($rating) {
        
        return new WP_User_Query(array(
            'fields' => 'ID',
            'meta_query' => array(
                'key'     => 'collaboration_rating',
                'value'   => $rating,
                'type'    => 'numeric',
                'compare' => '>='
                )
            )
        );
    }
    
    
    
    static function update_collaboration_rating($user_id) {
        
        KSM_Count::_update_user_c_artwork_rating($user_id);
        KSM_Count::_update_user_c_communication_rating($user_id);
        
        
        KSM_Count::update_user_collaboration_ratings($user_id);
        
        //KSM_Count::_update_user_c_artwork_rating_collaborations($user_id);
        //KSM_Count::_update_user_c_communication_rating_collaborations($user_id);
        
        
    }
    
    
    static function update_news($type) {
        
        if($type == 'clb_request_news') {
            
            
            
        }
        
    }
    
    public function total_earning() {
        return get_number($this->count_income) ;
    }
    
    
    static function count_sales($user_id) {
        global $wpdb;
        
        
        $q = "SELECT sum(pm.meta_value) FROM $wpdb->posts p, $wpdb->postmeta pm WHERE p.post_type = 'download' AND p.post_author = '{$user_id}' and pm.post_id = p.ID and pm.meta_key = '_edd_download_earnings' AND meta_value > 0";
        return $wpdb->get_var($q);
        
        
    }
    
    
    
    static function Register($data) {
            $userdata = array();
            
            $userdata['first_name'] = $data['fname'];
            $userdata['last_name'] =  $data['lname'];
            $userdata['user_email'] = $data['email'];
            $userdata['user_pass']  = $data['password'];
            $userdata['display_name'] = $data['display_name'];
            
            $userdata['user_login'] = KSM_Generate_Username($data['display_name']);
            $userdata['user_registered'] = date( 'Y-m-d H:i:s' );
            $userdata['role'] = 'frontend_vendor';
            
            
            $user_id = wp_insert_user( $userdata );
            
            
            if ( $user_id && !is_wp_error( $user_id ) ) {
                $user = new KSM_User($user_id);
                $user->update_meta('email_confirmed', 'no');
                update_user_meta($user_id, 'c_artwork_rating', '0');
                update_user_meta($user_id, 'c_communication_rating', '0');
                $user->setConfirmKey('signup');
                $user->emit('user_register');
                return true;
            }
            
            return false;
        }
    
        
        
        
        
        public function emit($event, $args = array()) {
        
            $args['user_id'] = $this->ID;

            $cls = get_called_class();
            if(strtolower(substr($cls, 0, 4)) == 'ksm_') {
                $cls = substr($cls, 4);
            }
            
            $event_data = KSM_DataStore::Option('Event', $event);
            if(!empty($event_data)) {
                
                if($event_data['email']) {
                    $email = KSM_Email::get($event_data['email'], $args);
                    $email->send();
                }
            }
    }
    
    
}