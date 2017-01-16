<?php


class KSM_Download extends KSM_Post {
    
    
    
    public $_post_type = 'download';
    
    //public function __construct($post) {
    //    $this->post = $post;
    //}
    

    
    public function __get($name) {
        
        if($name == 'Collaboration' && !isset($this->Collaboration)) {
            $this->Collaboration = new KSM_Collaboration($this->collaboration_id);
        } 
        
        /*
        elseif($name == 'Rate' && !isset($this->Rate)) {
            if($this->rate_id()) {
                $this->Rate = new KSM_Download_Rate($this->rate_id());
            }
        }
        */
        
        
        return parent::__get($name);
    }
    
    
    function link() {
        return ksm_get_permalink("store/download/{$this->ID}");
    }
    
    public function rate_id() {
        return $this->rate_post_id;
    }
    
    
    function is_partner($user_id = 0) {
        if($user_id == 0) {
            $user_id = get_current_user_id();
        }
        
        if($user_id) {
            $authors = $this->authors();
            if($this->isCollaboration() && in_array($user_id, $authors)) {
                return true;
            }
        }
        return false;
    }
    
    public function discounted_price() {
        $discount = $this->partner_discount();
        return $this->price() - $discount;
    }
    
    
    public function partner_discount($user_id = 0) {
        $discount = 0;
        
        if($user_id == 0) {
            $user_id = get_current_user_id();
        }
        
        if($user_id && $this->isCollaboration() && $this->is_partner($user_id)) {
            $discount = $this->author_price_share($user_id);
        }
        return $discount;
    }
    
    
    
    public function partner_commission($user_id = 0) {
        $commission = 0;
        
        if($user_id && $this->isCollaboration() && $this->is_partner($user_id)) {
            
            foreach ((Array) $this->collaboration_partners as $partner) {
                
                if($partner['id'] == $user_id) {
                    $commission = $partner['commission'];
                    break;
                }
            }
        }
        return $commission;
    }
    
    
    
    

    public function author_links($params = array()) {
        
        $authors = $this->authors();
        $link_list = array();
        
        $class = $params['class'] ? " class=\"{$params['class']}\"" : '';
        $join_with = $params['join_with'] ? $params['join_with'] : ', ';
        $return_as = $params['return_as'] ? $params['return_as'] : 'string';
        $excluding = $params['excluding'] ? (Array) $params['excluding'] : array();
        
        foreach($authors as $a) {
            if(in_array($a, $excluding)) continue;
            
            $author = get_user_by('id', $a);
            $name = $author->display_name;
            $link = ksm_get_permalink('studio', $author->user_login);
            $link_list[] = "<a{$class} href=\"{$link}\">{$name}</a>";
        }
        
        if($return_as == 'string') {
            return implode($join_with, $link_list) ;
        } 
        
        return $link_list;
    }
    
    
    function price() {
        return $this->edd_price;
    }
    
    
    function authors() {
        $authors = array();
        
        if($this->isCollaboration()) {
            foreach ((Array) $this->collaboration_partners as $k => $v) {
                if(!in_array($v['id'], $authors)) $authors[] = $v['id'];
            }
        } else {
            $authors[] = $this->post_author;
        }
        
        return $authors;
    }
    
    function author_exists_in_d_authors($user_id) {
        global $wpdb;
        
        $q = "SELECT id FROM {$wpdb->prefix}ksm_d_authors WHERE user_id= '{$user_id}' AND download_id = '{$this->ID}'";
        return $wpdb->get_var($q);
    }
    
    
    function add_author_in_d_authors($user_id) {
        global $wpdb;
        
        
        
        $wpdb->insert($wpdb->prefix.'ksm_d_authors', 
                array('user_id' => $user_id, 'download_id' => $this->ID),
                array('%d', '%d')
                );
        
    }
    
    
    function total_sales_inc_returns() {
        
        
        return $this->total_sales() + $this->total_returns();
    }
    
    
    function author_contribution_rating($user_id) {
        
        if(!$user_id) {
            return '0';
        }
        
        global $wpdb;
        
        $q = "SELECT score FROM {$wpdb->prefix}ksm_d_ratings 
            WHERE rate_key = 'role_%d_%d'";
        
        return $wpdb->get_var($wpdb->prepare($q, $this->ID, $user_id));
        
    }
    
    
    function total_sales() {
        return get_number($this->sales);
    }
    
    function total_returns() {
        return get_number($this->model_returns);
    }
    
    
    function author_price_share($user_id) {
        
        $price = 0;
        
        if($this->isCollaboration()) {
            foreach ((Array) $this->collaboration_partners as $k => $v) {
                
                if($user_id && $v['id'] == $user_id) {
                    $price += $v['price'];
                }
            }
        } else {
            $price = $this->price();
        }
        
        return get_number($price);
    }
    
    function author_income_per_sale($user_id) {
        $share = $this->author_price_share($user_id);
        
        $artist_commission_rate = KSM_ARTIST_COMMISSION_RATE;
        $income = $share * ( $artist_commission_rate / 100 );
        
        return $income;
    }
    
    function author_dated_stat($author, $key) {
        $author_dated_stats_key = "download_author_{$author}_dated_stats";
        
        $stats = (Array) $this->{$author_dated_stats_key};
        
        if($key) {
            return $stats[$key];
        }
        return $stats;
    }
    
    function author_sales_this_month($author) {
        $time = time();
        $year = date('Y', $time);
        $month = date('m', $time);
        
        $month_key = ksm_date_key($year, $month);
        
        
        $stats = $this->author_dated_stat($author, $month_key);
        return get_number($stats['sales']);
    }
    
    function author_income_this_month($author) {
        
        $time = time();
        $year = date('Y', $time);
        $month = date('m', $time);
        
        $month_key = ksm_date_key($year, $month);
        
        
        $stats = $this->author_dated_stat($author, $month_key);
        return get_number($stats['income']);
    }
    
    
    function author_income($author) {
        $income_key = "download_author_{$author}_income";
        return get_number($this->$income_key);
    }
    
    function isSolo() {
        return (!$this->collaboration_id ? true : false);
    }
    
    function isCollaboration() {
        return ($this->collaboration_id ? true : false);
    }
    
    function isTextured() {
        if($this->model_type == 'textured') 
            return true;
        return false;
    }
    
    
    function isSoloTextured() {
        if($this->isSolo() && $this->model_type == 'textured')
            return true;
        return false;
    }
    
    
    function isCollaborationTextured() {
        if($this->isCollaboration() && $this->model_type == 'textured')
            return true;
        return false;
    }
    
    
    function isUntextured() {
        if($this->model_type == 'untextured')
            return true;
        return false;
    }
    
    
    function isSoloUntextured() {
        if($this->isSolo() && $this->model_type == 'untextured')
            return true;
        return false;
    }
    
    function isCollaborationUntextured() {
        if($this->isCollaboration() && $this->model_type == 'untextured')
            return true;
        return false;
    }
    
    
    function update_user_rating_score($data = array()) {
        global $wpdb;
        
        $rate_key = $data['rate_key'];
        if($this->user_rating_score_exists($rate_key)) {
            $score = $data['score'];
            $q = "UPDATE {$wpdb->prefix}ksm_d_ratings SET score = '$score' WHERE rate_key='{$rate_key}'";
        } else {
            $fields = '`'.implode('` , `', array_keys($data)).'`';
            $values = "'".implode("' , '", $data)."'";
            $q = "INSERT INTO {$wpdb->prefix}ksm_d_ratings ($fields) VALUES ($values)";
        }
        
        $wpdb->query($q);
    }
    
    
    function user_rating_score_exists($rate_key) {
        return ($this->get_user_rating_score($rate_key) ? true : false);
    }
    
    
    function get_user_rating_score($rate_key) {
        global $wpdb;
        $query = "SELECT * FROM {$wpdb->prefix}ksm_d_ratings WHERE rate_key = '{$rate_key}'";
        $row = $wpdb->get_row($query);
        if($row) {
            return true;
        }
        return false;
    }
    
    
    public function calculateRating() {
        global $wpdb;
        
        $fields = $field_args = array();
        $rate_data = array();
        
        
        
        $score_groups = array();
        
        $sections = KSM_DataStore::Options('Form/Rate');
        
        
        foreach ($sections as $section) {
            foreach($section['fields'] as $fn => $fargs) {
                $fields[] = $fn;
                $field_args[$fn] = $fargs;
            }
        }
        
        
        
        $query = "SELECT meta_key, AVG(meta_value) average FROM {$wpdb->postmeta} pm
                    INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id 
                    AND p.post_parent = '{$this->ID}'
                    AND p.post_type = 'ksm_p_download_rate' 
                    AND p.post_status = 'publish'
                    GROUP BY meta_key";
        
        $results = $wpdb->get_results($query);
        
        
        
        
        foreach ($results as $r) {
            if(in_array($r->meta_key, $fields)) {
                $rate_data[$r->meta_key] = $r->average;
                foreach((Array)$field_args[$r->meta_key]['score_groups'] as $sg) {
                    $score_groups[$sg][$r->meta_key] = $r->average;
                }
            }
        }
        
        //pr($fields);
        //pr($score_groups);
        //exit;
        
        foreach($score_groups as $sg_name => $sg) {
            if($sg) {
                $this->update_meta("rating__{$sg_name}", array_average($sg));
            }
        }
        if($rate_data) {
            $this->update_meta('product_rating', array_average($rate_data));
        }
        
        
        
        foreach((Array) $this->authors() as $author) {
            ksm_update_author_model_ratings($author);
        }
        
        
        
        
        $rate_assignment_roles = (Array) $this->rate_assignment_roles;
        
        $roles = $rate_assignment_roles['roles'];
        $role_users = $rate_assignment_roles['users'];
        
        $_rules = array();
            
        foreach($roles as $score_type => $user_score) {
            foreach($user_score as $ru => $fields) {
                foreach($fields as $f) {
                    if($rate_data[$f]) {
                        $_rules[$score_type][$ru][$f] = $rate_data[$f];
                    }
                }
                
            }
        }
            
        
            
        $split_types = array('concept', 'model', 'texture');
        
        $final_result = array();
        
        $split_user_roles = array(
            1 => $this->concept_artist,
            2 => $this->model_artist,
            3 => $this->texture_artist,
        );
        
        foreach($_rules as $score_type => $user_score) {
            foreach($user_score as $ru => $fields) {
                
                
                if(in_array($score_type, $split_types)) {
                    $_user_id = $split_user_roles[$ru];
                } else {
                    $_user_id = $role_users[$ru];
                }
                
                
                $score = array_average($fields);
                $final_result[] = array(
                    'rate_key' => "{$score_type}_{$this->ID}_{$_user_id}",
                    'user_rate_key' => "{$score_type}_{$_user_id}",
                    'download_id' => $this->ID,
                    'score_type' => $score_type,
                    'user_id' => $_user_id,
                    'user_role_id' => $ru,
                    'score' => $score
                );
            }
        }
        
        
        
        
        $update_users = array();
        foreach($final_result as $r) {
            if(!in_array($r['user_id'], $update_users)) {
                $update_users[] = $r['user_id'];
            }
            $this->update_user_rating_score($r);
        }
        
        
        
        foreach($split_user_roles as $u) {
            if($u) {
                
                $_user = new KSM_User($u);
                
                $_user->update_ratings();
                
            }
        }
        
        
    }
    
    
    
    public function getRateAssignmentRules() {
        
        
    }
    
    
    public function getRatingForm($data = array()) {
        $pdata = $this->getRateFormPrepareData();
        $pdata['data'] = $data;
        
        return KSM_Form::get_form('Rate', $pdata);
    }
    
    
    
    public function getRateFormPrepareData() {
        
        $build_type = $this->getBuildType();
        
        
        
        $untextured_download = $textured_download = null;
        
        if($this->isUntextured()) {
            $untextured_download = $this;
            if($this->isCollaboration()) {
                if($this->Collaboration->textured_download_id) {
                    $textured_download = new KSM_Download($this->Collaboration->textured_download_id);
                }
            }
        }
        elseif($this->isTextured()) {
            $textured_download = $this;
            if($this->isCollaboration()) {
                if($this->Collaboration->untextured_download_id) {
                    $untextured_download = new KSM_Download($this->Collaboration->untextured_download_id);
                }
            }
        }
            
        
        
        return
        array(
            'download' => $this,
            'untextured_download' => $untextured_download,
            'textured_download' => $textured_download,
            'build_type' => $build_type
        );
        
        
        
        
        
        
    }
    
    
    
    //1-Concept Artist
    //2-Modeler
    //3-Texture Artist
    //4-Concept Artist / Modeler
    //5-Modeler / Texture Artist
    //6-Concept Artist / Modeler / Texture Artist
    
    
    
    public function getUserRole__1() {
        
        $role = '';
        
        
        
        if($this->isCollaboration() && $this->Collaboration->launch_type == 'concept') {
            $role = $this->Collaboration->concept_partner;
        }
        
        
        return $role;
    }
    
    public function getUserRole__2() {
        $role = '';
        
        
        if($this->isSolo() && !$this->concept_created) {
            $role = $this->post_author;
        }
        elseif($this->isCollaboration()) {
            if($this->Collaboration->launch_type == 'concept') {
                $role = $this->Collaboration->model_partner;
            } elseif($this->Collaboration->launch_type == 'untextured' && $this->Collaboration->concept_created == 'no') {
                $role = $this->Collaboration->model_partner;
            }
        }
        
        return $role;
    }
    
    
    public function getUserRole__3() {
        $role = '';
        
        if($this->isCollaborationTextured()) {
            if($this->Collaboration->model_partner != $this->Collaboration->texture_partner) {
                    $role = $this->Collaboration->texture_partner;
            }
        }
        
        return $role;
    }
    
    
    
    
    public function getUserRole__4() {
        
        $role = '';
        
        if($this->isSoloUntextured() && $this->concept_created == 'yes') {
            $role = $this->post_author;
        } elseif($this->isCollaborationUntextured()) {
            if($this->Collaboration->launch_type == 'untextured' && $this->concept_created == 'yes') {
                $role = $this->Collaboration->post_author;
            }
        }
        
        return $role;
    }
    
    
    
    public function getUserRole__5() {
        
        
        $role = '';
        
        if($this->isSoloTextured() && $this->concept_created == 'no') {
            $role = $this->post_author;
        } elseif($this->isCollaborationTextured()) {
            if($this->Collaboration->launch_type == 'concept') {
                if($this->Collaboration->model_partner == $this->Collaboration->texture_partner) {
                    $role = $this->Collaboration->model_partner;
                }
            }
        }
        
        return $role;
        
    }
    
    public function getUserRole__6() {
        
        $role = '';
        if($this->isSoloTextured() && $this->concept_created == 'yes') {
            $role = $this->post_author;
        }
        return $role;
    }
    
    
    
    function getConceptArtist() {
        $artist = '';
        
        
        if($this->isSolo() && $this->concept_created == 'yes') {
            $artist = $this->post_author;
        }
        
        elseif($this->isCollaboration()) {
            if($this->Collaboration->launch_type == 'concept') {
                $artist = $this->Collaboration->concept_partner;
            } elseif($this->Collaboration->launch_type == 'untextured' && $this->Collaboration->concept_created == 'yes') {
                $artist = $this->Collaboration->model_partner;
            }
        } 
        
        
        return $artist;
    }
    
    function getModelArtist() {
        $artist = '';
        
        if($this->isSolo()) {
            $artist = $this->post_author;
        } elseif($this->isCollaboration()) {
            $artist = $this->Collaboration->model_partner;
        }
        
        return $artist;
    }
    
    function getTextureArtist() {
        $artist = '';
        
        if($this->isTextured()) {
            if($this->isSolo()) {
                $artist = $this->post_author;
            } else {
                $artist = $this->Collaboration->texture_partner;
            }
            
        }
        return $artist;
    }
    
    
    public function getUserSplitRoles() {
        
        
        return array(
            1 => $this->getConceptArtist(),
            2 => $this->getModelArtist(),
            3 => $this->getTextureArtist()
        );
        
    }
    
    
    function update_split_artist_roles() {
                
        $roles = $this->getUserSplitRoles();
        
        $this->update_meta('concept_artist', $roles[1]);
        $this->update_meta('model_artist', $roles[2]);
        $this->update_meta('texture_artist', $roles[3]);
    }
    
    public function getUserRoles() {
        
        $roles = array();
        
        
        $role_types = range(1, 6);
        
        
        foreach($role_types as $t) {
            
            $r = call_user_func(array($this, "getUserRole__{$t}"));
            if($r) {
                $roles[$t] = $r;
            }
        }
        
        return $roles;
        
        
    }
    
    
    public function getRoleUser($role) {
        
        
        
        
        //{
            //1-Concept Artist
            //2-Modeler
            //3-Texture Artist
            //4-Concept Artist / Modeler
            //5-Modeler / Texture Artist
            //6-Concept Artist / Modeler / Texture Artist
        //}
        
        
        
        
        
        
        switch($role) {
            
            case "4":
                if($this->buildType == 1) {
                    return $this->Author;
                } elseif($this->buildType == 5) {
                    return $this->Author;
                }
                
                
                break;
            
            
            case "6":
                if($this->buildType == 2) {
                    return $this->Author;
                }
                break;
            
                
                
            
        }
        
        
        
    }
    
    
    
    
    
    
    
    

    

    function userRole($user_id = '') {
        
        
        
        if(!$user_id) {
            return '';
        }
        
        
        if($this->isCollaborationUntextured()) {
            if($this->concept_artist && $this->concept_artist == $user_id) {
                return 'concept';
            } elseif($this->model_artist && $this->model_artist == $user_id) {
                return 'model';
            } 
        } elseif($this->isCollaborationTextured()) {
            if($this->concept_artist && $this->concept_artist == $user_id) {
                return 'concept';
            } elseif($this->model_artist && $this->texture_artist && $this->model_artist == $this->texture_artist && $this->texture_artist == $user_id) {
                return 'model_texture';
            } elseif($this->model_artist && $this->model_artist == $user_id) {
                return 'model';
            } elseif($this->texture_artist && $this->texture_artist == $user_id) {
                return 'texture';
            } 
        }
        
        
    }
    
    
    
    
    /**
     * 
     * @return int 1 - solo create untextured model
                   2 - solo create textured model
                   3 - collaboration textured = 2 Artists (Concept Artist > Modeler / Texture Artist)
                   4 - collaboration textured = 3 Artists (Concept Artist >Modeler>Texture Artist)
                   5 - collaboration textured = 2 Artists (Concept Artist / Modeler > Texture Artist)
                   6 - collaboration untextured = 2 Artists (Concept> Modeler)
     */
    public function getBuildType() {
        
        
        $type = 0;
        
        
        switch ($this->model_type) {
            case "untextured":
                $type = 1;
                if($this->collaboration_id) {
                    $type = 6;
                }
                break;
            case "textured":
                $type = 2;
                if($this->collaboration_id) {
                    if($this->Collaboration->launch_type == 'concept') {
                        if($this->Collaboration->model_partner == $this->Collaboration->texture_partner) {
                            $type = 3;
                        } else {
                            $type = 4;
                        }
                    } else {
                        $type = 5;
                    }
                }
                break;
        }
        
        return $type;
    }
    
    
    
}