<?php




class KSM_CollaborationRequest extends KSM_Post {
    
    
    public $_post_type = 'collab_join_request';
    
    public function __construct($id) {
        
        parent::__construct($id);
    }
    
    
    function getCollaboration() {
        $this->Collaboration = new KSM_Collaboration($this->post_parent);
    }
    
    
    
    
    public function __get($name) {
        
        if($name == 'Collaboration' && !isset($this->Collaboration)) {
            $this->Collaboration = new KSM_Collaboration($this->post_parent);
        }
        
        return parent::__get($name);
    }


    
    public function Reject() {
        
        if(!$this->ID || !$this->Collaboration->ID) {
            $error = "Invalid Action";
        }
        
        elseif(!$this->Collaboration->isOwner() || $this->request_status != 'active'){
            $error = "You can't perform this action.";
        } 
        
        
        if($error) {
            return $this->Error($error);
        }
        
        
        
        $this->update_meta('request_status', 'rejected');
        
        
        KSM_Count::update_user_collaboration_active_requests($this->Collaboration->post_author);
        
        $this->emit('Rejected');
        
        return $this->Success('');
    }
    
    
    public function isActive() {
        
        if($this->Post && $this->request_status == 'active') {
            return true;
        }
        
        return false;
    }
    
    
    
    
    public function price_share() {
        
        $price_share = 0;
        
        if($this->request_type == 'model' || $this->request_type == 'model_texture') {
            $price_share += $this->model_price;
        }

        if($this->request_type == 'texture' || $this->request_type == 'model_texture') {

            $price_share += $this->texture_price;
        }
        return $price_share;
    }
    
    
    
    public function Accept() {
        
        
        
        
        
        $result = $this->isAcceptable();
        
        
        
        
        if($result['error']) {
            return $result;
        }
        
        
        $this->update_meta('request_status', 'accepted');
        $this->Collaboration->update_meta('can_user_submit_request', 'no');
        
        
        
        if($this->request_type == 'model' || $this->request_type == 'model_texture') {
            $this->Collaboration->update_meta('model_partner', $this->post_author);
            $this->Collaboration->update_meta('model_price', $this->model_price);
        }
        
        if($this->request_type == 'texture' || $this->request_type == 'model_texture') {
            $this->Collaboration->update_meta('texture_partner', $this->post_author);
            $this->Collaboration->update_meta('texture_price', $this->texture_price);
        }
        
        
        $this->addActive();
        
        
        
        $this->Collaboration->reject_all_active_requests();
        
        
        KSM_Count::update_user_collaboration_active_requests($this->Collaboration->post_author);
        
        $this->emit('collaboration_invite_accepted');
        
        return $this->Success('');
        
    }
    
    
    
    
    
    
    
    public function addActive() {
        
        $post_args = array(
            'post_type' => 'collab_active',
            'post_status' => 'publish',
            'post_author' => $this->post_author,
            'post_title' => $this->Collaboration->post_title,
            'post_content' => '',
            'post_parent' => $this->Collaboration->ID
        );
        
        
        $post_id  = wp_insert_post($post_args);
        
        
        if($post_id) {
            
            
            $active = new KSM_CollaborationActive($post_id);
            
            
            
            $active->update_meta('accepted_request_id', $this->ID);
            $active->update_meta('active_type', $this->request_type);
            
            
            $active->update_meta('current_step_active_since', time());
            
            
            $active->update_meta('collaboration_author', $this->Collaboration->post_author);
            
            $active->update_meta('total_price_share', $this->price_share());
            
            
            
            if($this->request_type == 'texture') {
                $active->update_meta('current_step', 'texture_midpoint_feedback');
                $active->update_meta('current_step_state', 'texture_mid_wip');
            }
            else {
                $active->update_meta('current_step', 'model_midpoint_feedback');
                $active->update_meta('current_step_state', 'model_mid_wip');
            }
            
            
            
            
        }
        
    }
    
    
    
    
    
    
    
    
    
    
    

    
    public function isAcceptable() {
        
        
        $user_id = get_current_user_id();
        
        
        //pr($this);
        
        if(!$user_id) {
            $error = "You are not logged in";
        } 
        
        
        
        elseif(!$this->Collaboration->isOwner()) {
            $error = "You don't have access to that collaboration.";
        } 
        
        elseif(!$this->isActive()) {
            $error = "You can't accept this request.";
        } 
        
        elseif($this->Collaboration->isCompleted()) {
            $error = "Collaboration is already completed";
        }
        
        elseif(!$this->Collaboration->isPartnerSlotAvailable($this->request_type)) {
            $error = "You can't accept this request.";
        }
        
        if($error) {
            return array('error' => true, 'msg' => $error);
        }
        
        return array('success' => true);
        
    }
    

    
    
}



class KSM_Collaboration extends KSM_Post {
    
    public $_post_type = 'ksm_collaboration';
    
    
    
    //function __construct($id = 0, $match_type = true) {
    //    parent::__construct($id, $match_type);
    //}
    
    
    
    function gallery_attachments() {
        
        $attachments = post_attacments($this->ID, array() , true);
        if($this->current_stage == 'untextured' && $this->launch_type == 'concept') {
            if($this->untextured_download_id) {
                
                $att_untextured = post_attacments($this->untextured_download_id, array() , true);
                
                $attachments = array_merge($att_untextured, $attachments);
                
            }
        }
        
        
        return $attachments;
    }
    
    
    function full_view_link() {
        return ksm_get_permalink("collaboration/full_view/$this->ID");
    }
    
    
    
    
    
    function concept_partner() {
        return $this->concept_partner;
    }
    
    function model_partner() {
        return $this->model_partner;
    }
    
    function concept_price() {
        return $this->concept_price;
    }
    
    function model_price() {
        return $this->model_price;
    }
    
    public function reject_all_active_requests() {
        
        
        $posts =
        
        get_posts(array(
            'post_type' => 'collab_join_request',
            'posts_per_page' => -1,
            'post_parent' => $this->ID
        ));
        
        
        foreach($posts as $p) {
            
            if($p->request_status == 'active') {
                update_post_meta($p->ID, 'request_status', 'rejected');
            }
        }
        
        
    }
    
    public function add_request($data) {
        
        
        $user_id = get_current_user_id();
        
        $post_args = array(
            'post_type' => 'collab_join_request',
            'post_status' => 'publish',
            'post_author' => $user_id,
            'post_title' => "Collaboration Join Request",
            'post_content' => $data['message'],
            'post_parent' => $this->ID
        );
        
        
        $post_id  = wp_insert_post($post_args);
            
        if($post_id) {
            
            $request = new KSM_CollaborationRequest($post_id);
            
            
            
            if($data['request_type'] == 'model' || $data['request_type'] == 'model_texture') {
                $request->update_meta('model_price', $data['model_price']);
            }
            
            if($data['request_type'] == 'texture' || $data['request_type'] == 'model_texture') {
                $request->update_meta('texture_price', $data['texture_price']);
            }
            
            
            $request->update_meta('request_status', 'active');
            $request->update_meta('request_type', $data['request_type']);
            $request->update_meta('round', $this->current_round);
            
            $request->update_meta('collaboration_author', $this->post_author);
            
            
            
            KSM_Count::update_user_collaboration_active_requests($this->post_author);
            
            $request->emit('collaboration_invite');
            
            return true;
        }
        
        return false;
        
        
    }
    
    
    public function isCompleted() {
        
        if($this->is_completed == 'yes') {
            return true;
        }
        return false;
    }
    
    
    public function isRequestSubmissionOpen() {
        
        $user_id = get_current_user_id();
        
        $submissionOpen = false;
        if($this->ID && $user_id) {
            if($this->can_user_submit_request == 'yes') {
                $submissionOpen = true;
            }
        }
        
        return $submissionOpen;
    }
    
    
    public function acceptableRequestTypes() {
        
        
        $types = array();
        
        if($this->current_stage == 'concept') {
            $types = array('model', 'model_texture');
        } elseif($this->current_stage == 'untextured') {
            $types = array('texture');
        }
        
        return $types;
        
    }
    
    
    public function user_already_submit_join_request() {
        
        $user_id = get_current_user_id();
        
        
        if($this->ID && $user_id) {
            
            $posts = get_posts(array(
                'post_type' => 'collab_join_request',
                'author' => $user_id,
                'post_parent' => $this->ID,
                'meta_query' => array(
                    array(
                        'key' => 'round', 
                        'value' => $this->current_round, 
                        'compare' => '='
                    )
                )
            ));
            
            
            if($posts[0] instanceof WP_Post) {
                return true;
            } 
            return false;
        }
    }
    
    
    
    public function isPartnerSlotAvailable($type) {
        
        if($type == 'model' && $this->isOpenForModel()) { 
            return true;
        } else if($type == 'texture' && $this->isOpenForTexture()) {
            return true;
        } elseif($type == 'model_texture' && $this->isOpenForModelTexture()) {
            return true;
        }
        
        return false;
    }
    
    public function isOpenForModel() {
        
        
        if($this->launch_type == 'concept' && $this->current_stage == 'concept' && !$this->model_partner) {
            return true;
        }
        
        
        return false;
    }
    
    public function isOpenForTexture() {
        
        
        
        if($this->current_stage == 'untextured' && !$this->texture_partner) {
            return true;
        }
        
        
        return false;
    }
    
    public function isOpenForModelTexture() {
        
        
        
        if($this->launch_type == 'concept' && $this->current_stage == 'concept' && !$this->model_partner && !$this->texture_partner) {
            return true;
        }
        
        
        return false;
    }
    
    
    
    
    
    
    
    
    
    
    
    
}


class KSM_CollaborationActive extends KSM_Post {
    
    public $_post_type = 'collab_active';
    
    //public function __construct($id) {
    //    parent::__construct($id);
    //}
    
    
    public function __get($name) {
        
        if($name == 'Collaboration' && !isset($this->Collaboration)) {
            $this->Collaboration = new KSM_Collaboration($this->post_parent);
        }
        
        return parent::__get($name);
    }
    
    
    public function getStepsDS() {
        return KSM_DataStore::Option('CollaborationActiveStep', $this->active_type);
    }
    
    
    public function getStepDS($name) {
        $steps = $this->getStepsDS();
        return $steps[$name];
    }
    
    
    
    
    public function project_state_label($state) {
        
        $step = $this->getStepConfigByState($state);
                
        return $step['states'][$state]['partner_project_label'];
        
    }
    
    
    public function getMessages() {
        $messages = array();
        
        
        return $messages;
    }
    
    
    public function getStepNameByState($state) {
        
        
        $steps = $this->getStepsDS();
        
        
        foreach($steps as $step_name =>  $step) {
            
            $states = (Array) $step['states'];
            
            $states = array_keys($states);
            
            if(!empty($states) && in_array($state, $states)) {
                return $step_name;
            }
            
        }
        
    }
    
    
    
    public function getStatePost($state) {
        
            $posts = get_posts(array(
                'post_type' => 'collab_active_step',
                'post_parent' => $this->ID,
                'meta_query' => array(
                    array(
                        'key' => 'step_state', 
                        'value' => $state, 
                        'compare' => '='
                    )
                )
            ));
            
            
            
            if($posts[0] instanceof WP_Post) {
                return $posts[0];
            } 
            return false;
        
    }
    
    
    
    
    
    public function ProjectViews($args = array()) {
        
        $posts = $this->getProjectPosts($args);
        
        $data = array();
        
        $states = array();
        
        foreach ($posts as $p) {
            
            
            if($p->post_type == 'collab_active_step') {
                if(substr($p->step_state, 0, 8) == 'fb_wait_') {
                    $states['feedback'][$p->step_state] = $p;
                } else {
                    $states['wip'][$p->step_state] = $p;
                }
            } 
            
            elseif($p->post_type == 'ksm_message') {
                $states['message'][$p->step_state][] = $p;
            }
            
            
        }
        
        
        
        foreach((Array) $states['wip'] as $wp) {
            $messages = $states['message'][$wp->step_state] ? $states['message'][$wp->step_state] : array();
            $wp->messages = $messages;
            $feedback = array();
            
            
            
                
            $fb_state_name = "fb_wait_{$wp->step_state}";
            $feedback = $states['feedback'][$fb_state_name] ? $states['feedback'][$fb_state_name] : array();
            
            if(!$feedback) {
                $wp->show_feedback_form = true;
            }
            
            
            $wp->feedback = $feedback;
            $data['wip'][] = array('post' => $wp);
            
        }
        
        
        
        
        if($this->active_type == 'model' || $this->active_type == 'texture') {
            
            if($this->current_step_state == 'model_mid_wip' || $this->current_step_state == 'texture_mid_wip') {
                $data['waiting_wip'] = array('name' => 'waiting_first_wip');
            } elseif($this->current_step_state == 'model_final_wip' || $this->current_step_state == 'texture_final_wip') {
                $data['waiting_wip'] = array('name' => 'waiting_final_wip');
            }
            
        } elseif($this->active_type == 'model_texture') {
            
            if($this->current_step_state == 'model_mid_wip') {
                $data['waiting_wip'] = array('name' => 'waiting_first_wip');
            }
            
            elseif($this->current_step_state == 'model_final_wip') {
                $data['waiting_wip'] = array('name' => 'waiting_final_model_wip');
            }
            elseif($this->current_step_state == 'texture_mid_wip') {
                $data['waiting_wip'] = array('name' => 'waiting_first_texture_wip');
            }
            elseif($this->current_step_state == 'texture_final_wip') {
                $data['waiting_wip'] = array('name' => 'waiting_final_texture_wip');
            }
        }
        
        
        
        if($this->canRate()) {
            $data['ask_rate'] = array('name' => 'ask_rate');
        }
        
        
        
        
        return $data;
        
    }
    
    public function fullStatusText() {
        
        $status = "";
        
        $duration = $this->CurrentStateDuration();
        $waiting_time = "";
        if($duration) {
            $waiting_time = call_user_func_array('human_time_diff', array_map('strtotime', $duration));
        }
        
        if($this->isWaitingForWIP()) {

            if($this->active_type == 'model' || $this->active_type == 'texture') {
                if($this->current_step_state == 'model_mid_wip' || $this->current_step_state == 'texture_mid_wip') {
                    $wip_name = "first WIP";
                } elseif($this->current_step_state == 'model_final_wip' || $this->current_step_state == 'texture_final_wip') {
                    $wip_name = "final WIP";
                }
            
            } elseif($this->active_type == 'model_texture') {
            
                if($this->current_step_state == 'model_mid_wip') {
                    $wip_name = "first WIP";
                } elseif($this->current_step_state == 'model_final_wip') {
                    $wip_name = "final model WIP";
                } elseif($this->current_step_state == 'texture_mid_wip') {
                    $wip_name = "first texture WIP";
                } elseif($this->current_step_state == 'texture_final_wip') {
                    $wip_name = "final texture WIP";
                }
            }
            
            $status = "You are currently waiting for this partners {$wip_name} of this project to review. 
            <div>You have been waiting {$waiting_time}.</div>";
            
        } elseif($this->isWaitingForFeedback()) {
            $status = "Your partner is currently waiting for feedback. 
            <div>He has been waiting {$waiting_time}.</div>";
        }
        
        
        
        
        
        return $status;
        
        
        
        
        
    }
    
    public function getWipFeedbackPost($step) {
        
        $state = "fb_wait_{$step}";
        
        $args = array(
            'posts_per_page' => -1,
            'post_type'   => 'collab_active_step',
            'post_parent' => $this->ID,
            'meta_query' => array(
                array(
                    'key' => 'step_state', 
                    'value' => $state, 
                    'compare' => '='
                    )
                )
            );
        
        $posts = get_posts($args);
        
        
        if($posts) {
            return $posts[0];
        }
    }
    
    
    
    
    
    public function getProjectPosts($args= array()) {
        
        $args['sort'] = $args['sort'] ? $args['sort'] : 'oldest';
        $sort = 'date';
        $sortby = $args['sort'] == 'newest' ? 'DESC' : 'ASC';
            
        $posts = get_posts(array(
            'posts_per_page' => -1,
            'post_type'   => array('collab_active_step', 'ksm_message'),
            'post_parent' => $this->ID,
            'orderby'     => $sort,
            'order'       => $sortby
            ));
        
        
        
        $_posts = array();
        
        foreach($posts as $p) {
            $_posts[] = new KSM_Post($p->ID, false);
        }
        
        
        return $_posts;
        
    }
    
    
    public function isCompleted() {
        
        if($this->is_completed == 'yes') {
            return true;
        }
        return false;
    }
    
    
    public function isOnSellState() {
        
        $states = array('sell_model', 'sell_texture');
        
        
        if(in_array($this->current_step_state, $states)) {
            return true;
        }
        
        return false;
    }
    
    
    public function isOnRateState() {
        
        $states = array('rate_model', 'rate_texture', 'rate_model_texture');
        
        
        if(in_array($this->current_step_state, $states)) {
            return true;
        }
        
        return false;
    }
    
    
    
    public function getUntexturedStep() {
        if($this->active_type == 'model_texture') 
            $post = get_post($this->Collaboration->untextured_download_id);
        
        elseif($this->active_type == 'texture') {
            if($this->Collaboration->launch_type == 'concept') 
                $post = get_post($this->Collaboration->untextured_download_id);
             else 
                $post = $this->Collaboration;
        }
        
        return $post;
    }
    
    public function isRatedBy($user_id = 0) {
        global $wpdb;
        
        $user_id = $user_id ? $user_id : get_current_user_id();
        
        
        
        
        $sql = "SELECT * FROM {$wpdb->prefix}ksm_c_ratings WHERE rate_by = '%d' AND active_id = '%d'";
        $result = $wpdb->get_results($wpdb->prepare($sql, $user_id, $this->ID));
        
        
        if($result) {
            return true;
        }
        
        return false;
    }
    
    
    public function addRating($data = array()) {
        
        
        global $wpdb;
        
        
        
        
        $res = 
        
        $wpdb->insert(
                $wpdb->prefix."ksm_c_ratings", 
                array(
                    'active_id' => $this->ID, 
                    'rate_by' => $data['rate_by'], 
                    'rate_to' => $data['rate_to'] ,
                    'communication_rating' => $data['communication_rating'],
                    'artwork_rating' => $data['artwork_rating'],
                    'date' => current_time('mysql')
                    ), 
                array('%d' ,'%d', '%d' , '%d', '%d', '%s') 
                );
        
        
        if($res) {
            $this->emit('collaboration_feedback');
            KSM_User::update_collaboration_rating($data['rate_to']);
        }
        
        return $res;
        
    }
    
    public function canRate() {
        
        if($this->isOwner() || $this->Collaboration->isOwner()) {
            
            if($this->isCompleted() || $this->isOnRateState()) {
                
                if(!$this->isRatedBy()) {
                    return true;
                }
                
            }
        }
        
        return false;
    }
    
    
    
    public function isWaitingForFeedback() {
        
        $states = array(
            'fb_wait_model_mid_wip', 
            'fb_wait_texture_mid_wip',
            'fb_wait_model_final_wip', 
            'fb_wait_texture_final_wip'
            );
        
        
        if(in_array($this->current_step_state, $states)) {
            return true;
        }
        
        return false;
    }
    
    
    public function isWaitingForWIP() {
        
        $states = array('model_mid_wip', 'model_final_wip', 'texture_mid_wip', 'texture_final_wip');
        
        
        if(in_array($this->current_step_state, $states)) {
            return true;
        }
        
        return false;
    }
    
    
    
    public function isFirstWipSent() {

        
        if($this->active_type == 'model' || $this->active_type == 'model_texture') {
            
            if($this->current_step_state == 'model_mid_wip') {
                return false;
            }
            
        } elseif($this->active_type == 'texture' && $this->current_step_state == 'texture_mid_wip') {
            return false;
        }
        
        
        return true;
    }
    
    
    public function getLastWIPSentPost() {
        
        $this->current_step;
        
    }
    
    
    public function getStepConfig($step) {
        
        $steps = $this->getStepsDS();
        $config = $steps[$step];
        
        return $config;
        
    }
    
    public function getStepConfigByState($state) {
        
        $step_name = $this->getStepNameByState($state);
        return self::getStepConfig($step_name);
    }
    
    
    
    
    // Current state duration
    
    
    public function stateDuration($state) {
        
        $config = $this->getStepConfigByState($state);
        
        $start_duration_post_state = $config['states'][$this->current_step_state]['duration'];
        
        
        $post = null;
        $duration = array();
        
        if($start_duration_post_state == 'active')  {
            $post = $this;
        } else {
            $post = $this->getStatePost($start_duration_post_state);
        }
        
        if($post) {
            $state_post = $this->getStatePost($state);
            $duration['start'] = $post->post_date;
            $duration['end'] = $state_post ? $state_post->post_date : date('Y-m-d H:i:s') ;
        }
        
        
        
        return $duration;
        
    }
    
    public function CurrentStateDuration() {
        
        return $this->stateDuration($this->current_step_state);
        
    }
    
    
    public function isWaitingForFinalWIP() {
        
        
        $states = array('model_final_wip', 'texture_final_wip');
        if(in_array($this->current_step_state, $states)) {
            return true;
        }
        
        return false;
        
    }
    
    
    
    public function getFbRequiredWIP() {
        
        
        $posts = get_posts(array(
            'post_type' => 'collab_active_step',
            'post_status' => 'publish',
            'post_parent' => $this->Active->ID,
            'meta_query' => array(
                array(
                    'key' => 'feedback_required', 
                    'value' => 'yes', 
                    'compare' => '='
                    )
            )
        ));
        
        
        
        if($posts[0]) {
            return $posts[0];
        }
        
        return null;
    }
    
    
    
    public function moveToNextStop() {
        
        $data = $this->nextStop();
        
        if($data['is_completed'] == 'yes') {
            $this->update_meta('is_completed', 'yes');
            $this->emit('collaboration_complete');
        }
        
        
        if($data['submit_to_join']) {
            if($this->active_type == 'model') {
                $this->Collaboration->update_meta('current_stage', 'untextured');
                $this->Collaboration->update_meta('can_user_submit_request', 'yes');
                $this->Collaboration->update_meta('current_round', 2);
            }
        }
        
        $this->update_meta('current_step', $data['step']);
        $this->update_meta('current_step_state', $data['state']);
        
    }
    
    
    
    public function nextStop() {
        
        
        
        switch ($this->active_type) {
            case "model" :
                
                if($this->current_step == 'model_midpoint_feedback') {
                    
                    if($this->current_step_state == 'model_mid_wip') {
                        return array('step' => 'model_midpoint_feedback', 'state' => 'fb_wait_model_mid_wip');
                    } 
                    elseif($this->current_step_state == 'fb_wait_model_mid_wip') {
                        return array('step' => 'model_final_feedback', 'state' => 'model_final_wip');
                    }
                    
                } elseif($this->current_step == 'model_final_feedback') {
                    
                    
                    
                    if($this->current_step_state == 'model_final_wip') {
                        return array('step' => 'model_final_feedback', 'state' => 'fb_wait_model_final_wip');
                    } 
                    elseif($this->current_step_state == 'fb_wait_model_final_wip') {
                        return array('step' => 'model_publish', 'state' => 'sell_model');
                    }
                    
                    
                } elseif($this->current_step == 'model_publish') {
                    
                    if($this->current_step_state == 'sell_model') {
                        return array('step' => 'model_rate', 'state' => 'rate_model', 'submit_to_join' => true);
                    }
                } elseif($this->current_step == 'model_rate') {
                    return array('step' => '', 'state' => '', 'is_completed' => 'yes');
                }
                
                break;
            case "texture" :
                
                if($this->current_step == 'texture_midpoint_feedback') {
                    
                    if($this->current_step_state == 'texture_mid_wip') {
                        return array('step' => 'texture_midpoint_feedback', 'state' => 'fb_wait_texture_mid_wip');
                    } elseif($this->current_step_state == 'fb_wait_texture_mid_wip') {
                        return array('step' => 'texture_final_feedback', 'state' => 'texture_final_wip');
                    }
                    
                } elseif($this->current_step == 'texture_final_feedback') {
                    
                    if($this->current_step_state == 'texture_final_wip') {
                        return array('step' => 'texture_final_feedback', 'state' => 'fb_wait_texture_final_wip');
                    }
                    
                    
                    
                    elseif($this->current_step_state == 'fb_wait_texture_final_wip') {
                        return array('step' => 'texture_publish', 'state' => 'sell_texture');
                    }
                    
                    
                    
                } elseif($this->current_step == 'texture_publish') {
                    
                    if($this->current_step_state == 'sell_texture') {
                        return array('step' => 'texture_rate', 'state' => 'rate_texture');
                    }
                } elseif($this->current_step == 'texture_rate') {
                    return array('step' => '', 'state' => '', 'is_completed' => 'yes');
                }
                
                break;
            
            case "model_texture" :
                
                
                if($this->current_step == 'model_midpoint_feedback') {
                    if($this->current_step_state == 'model_mid_wip') {
                        return array('step' => 'model_midpoint_feedback', 'state' => 'fb_wait_model_mid_wip');
                    }
                    elseif($this->current_step_state == 'fb_wait_model_mid_wip') {
                        return array('step' => 'model_final_feedback', 'state' => 'model_final_wip');
                    }
                }
                
                
                elseif($this->current_step == 'model_final_feedback') {
                    if($this->current_step_state == 'model_final_wip') {
                        return array('step' => 'model_final_feedback', 'state' => 'fb_wait_model_final_wip');
                    }
                    elseif($this->current_step_state == 'fb_wait_model_final_wip') {
                        return array('step' => 'model_publish', 'state' => 'sell_model');
                    }
                }
                
                
                elseif($this->current_step == 'model_publish') {
                    if($this->current_step_state == 'sell_model') {
                        return array('step' => 'texture_midpoint_feedback', 'state' => 'texture_mid_wip');
                    }
                }
                
                
                elseif($this->current_step == 'texture_midpoint_feedback') {
                    if($this->current_step_state == 'texture_mid_wip') {
                        return array('step' => 'texture_midpoint_feedback', 'state' => 'fb_wait_texture_mid_wip');
                    }
                    elseif($this->current_step_state == 'fb_wait_texture_mid_wip') {
                        return array('step' => 'texture_final_feedback', 'state' => 'texture_final_wip');
                    }
                }
                
                
                elseif($this->current_step == 'texture_final_feedback') {
                    if($this->current_step_state == 'texture_final_wip') {
                        return array('step' => 'texture_final_feedback', 'state' => 'fb_wait_texture_final_wip');
                    }
                    elseif($this->current_step_state == 'fb_wait_texture_final_wip') {
                        return array('step' => 'texture_publish', 'state' => 'sell_texture');
                    }
                }
                
                
                elseif($this->current_step == 'texture_publish') {
                    if($this->current_step_state == 'sell_texture') {
                        return array('step' => 'model_texture_rate', 'state' => 'rate_model_texture');
                    }
                }
                
                
                elseif($this->current_step == 'model_texture_rate') {
                    return array('step' => '', 'state' => '', 'is_completed' => 'yes');
                }
                
                
                break;
            }
            
            
        
        
    }
    
    
    public function can_publish_wip($publisher) {
        
        
        
        if(!$this->isOwner()) {
            return false;
        }
        
        
        
        
        switch($publisher) {
            case "collaboration_model_mid_wip" :
                
                
                if($this->current_step == 'model_midpoint_feedback' && $this->current_step_state == 'model_mid_wip') {
                    return true;
                }
                
                break;
            
            case "collaboration_model_final_wip":
                if($this->current_step == 'model_final_feedback' && $this->current_step_state == 'model_final_wip') {
                    return true;
                }
                break;
            
            case "collaboration_texture_mid_wip" : 
                if($this->current_step == 'texture_midpoint_feedback' && $this->current_step_state == 'texture_mid_wip') {
                    return true;
                }
                break;
            
            case "collaboration_texture_final_wip" :
                if($this->current_step == 'texture_final_feedback' && $this->current_step_state == 'texture_final_wip') {
                    return true;
                }
                break;
        }
        
        return false;
        
        
    }
    
    public function header_step() {
        
        if($this->active_type == 'model') {
            $type =  'Model';
        } elseif($this->active_type == 'texture') {
            $type =  'Texture';
        } elseif($this->active_type == 'model_texture') {
            $type =  'Texture and Model';
        }
        
        
        return 
        "<div class=\"step_header\">
            <div class=\"title\">{$this->post_title}</div>
            <div class=\"type\">{$type}</div>
        </div>";
        
    }
    
    
    public function render_steps() {
        
        
        $steps = $this->getStepsDS();
        
        
        $html = $this->header_step();
        
        foreach($steps as $s_name => $s_args) {
            
            $active_step = new KSM_CollaborationActiveStep($this, $s_name);
            $html .= $active_step->render();
            //$this->render_element('step_item', array('post' => $post, 's_name' => $s_name, 's_args' => $s_args));
        }
        
        return $html;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    /*
    public function addStep($step) {
        if($step) {
            $method = "addStep{$step}";
            if(method_exists($this, $method)) {
                $this->{$method}();
            }
        }
    }
    */
    
    
    
}


class KSM_CollaborationActiveStep {
    
    
    public $step, $name, $active;
    
    
    
    
    public function __construct($active, $name) {
        $this->name = $name;
        $this->active = $active;
        $this->step = $active->getStepDS($name);
    }
    
    
    
    public function getNextSteps() {
        
        $steps = $this->active->getStepsDS();
        $next_position = array_search($this->name, array_keys($steps)) + 1;
        $next_steps = array_slice($steps, $next_position);
        
        return array_keys($next_steps);
    }
    
    
    public function getNextStep() {
        $steps = $this->getNextSteps();
        return reset($steps);
    }
    
    
    
    public function isLast() {
        return (($this->step['last']) ? true : false);
    }
    
    public function isLastState() {
        if(end(array_keys($this->step['states'])) == $this->active->current_step_state) {
            return true;
        }
        
        return false;
        
    }
    
    
    public function isCurrent() {
        if($this->active->current_step == $this->name) {
            return true;
        }
        
        return false;
    }
    
    
    
    public function isCompleted() {
        
        if($this->active->isCompleted()) {
            return true;
        }
        
        if($this->isLast()) {
            return false;
        }
        
        
        $next_steps = $this->getNextSteps();
        
        if(in_array($this->active->current_step, $next_steps)) {
            return true;
        }
        
        return false;
        
    }
    
    
    
    public function get__model__step_content() {
        
        if($this->isCompleted()) {
            $thumb_id = get_post_thumbnail_id($this->active->post_parent);
            
            return '<img src="'.get_image_src($thumb_id, 'active_collab').'" />';
        }
    }
    
    
    
    
    public function get__model_midpoint_feedback__step_content() {
        
        
        if($this->isCompleted()) {
            
            $stepPost = $this->active->getStatePost('model_mid_wip');
            
            if($stepPost) {
                
                $thumb_id = get_post_thumbnail_id($stepPost->ID);
                if($thumb_id) {
                    return '<img src="'.get_image_src($thumb_id, 'active_collab').'" />';
                }
            }
        } else {
            
            if($this->isCurrent()) {
                
                
                
                $action = $this->active->current_step_state;
                $title = $this->step['states'][$this->active->current_step_state]['label'];
                
                if($this->active->current_step_state == 'model_mid_wip') {
                    
                    $link = ksm_get_permalink("collaboration/active/mmw/{$this->active->ID}");
                    
                    return "<a class=\"mid_btn active blue colorbox\" href=\"{$link}\">{$title}</a>";
                    
                    
                } elseif($this->active->current_step_state == 'fb_wait_model_mid_wip') {
                    return "<span class=\"l2 mid_btn red\">{$title}</span>";
                    
                }
            }
        }
    }
    
    public function get__model_final_feedback__step_content() {
        
        if($this->isCompleted()) {
            
            $stepPost = $this->active->getStatePost('model_final_wip');
            
            if($stepPost) {
                
                $thumb_id = get_post_thumbnail_id($stepPost->ID);
                if($thumb_id) {
                    return '<img src="'.get_image_src($thumb_id, 'active_collab').'" />';
                }
            }
            
        } else {
            
            
            
            
            
             $state = reset(array_keys($this->step['states']));
            
            
            if($this->isCurrent()) {
                $state = $this->active->current_step_state;
            }
            
            $title = $this->step['states'][$state]['label'];
                
            if($this->isCurrent() && $this->active->current_step_state == 'model_final_wip') {
                $link = ksm_get_permalink("collaboration/active/mfw/{$this->active->ID}");
                return "<a class=\"mid_btn active l2 blue colorbox\" href=\"{$link}\">{$title}</a>";
            } elseif($this->isCurrent() && $this->active->current_step_state == 'fb_wait_model_final_wip') {
                $link = ksm_get_permalink("collaboration/active/mfw/{$this->active->ID}");
                return "<span class=\"mid_btn l2 red\">{$title}</span>";
            } 
            
            else {
                return "<span class=\"mid_btn l2\">{$title}</span>";
            }
            
            
            
        }
        
    }
    
    public function get__model_publish__step_content() {
        
        if($this->isCompleted()) {
            
            $stepPostID = $this->active->Collaboration->untextured_download_id;
            if($stepPostID) {
                $stepPost = get_post($stepPostID);
                
                if($stepPost) {
                    $thumb_id = get_post_thumbnail_id($stepPost->ID);
                    if($thumb_id) {
                        return '<img src="'.get_image_src($thumb_id, 'active_collab').'" />';
                    }
                }
            }
            
            
            
        } else {
            
            
            $state = reset(array_keys($this->step['states']));
            
            
            if($this->isCurrent()) {
                $state = $this->active->current_step_state;
            }
            
            $title = $this->step['states'][$state]['label'];
                
            if($this->isCurrent() && $this->active->current_step_state == 'sell_model') {
                $link = ksm_get_permalink("collaboration/active/cpum/{$this->active->ID}");
                return "<a class=\"mid_btn active blue colorbox\" href=\"{$link}\">{$title}</a>";
            } else {
                return "<span class=\"mid_btn\">{$title}</span>";
            }
        }
    }
    
    
    
    
    
    public function get__model_rate__step_content() {
        if($this->isCompleted()) {
            
            
        } else {
            
            
            $state = reset(array_keys($this->step['states']));
            
            
            if($this->isCurrent()) {
                $state = $this->active->current_step_state;
            }
            
            $title = $this->step['states'][$state]['label'];
                
            if($this->isCurrent() && $this->active->current_step_state == 'rate_model') {
                $link = ksm_get_permalink("collaboration/active/rate/{$this->active->ID}");
                return "<a class=\"mid_btn active blue colorbox\" href=\"{$link}\">{$title}</a>";
            } else {
                return "<span class=\"mid_btn\">{$title}</span>";
            }
        }
    }
    
    
    
    public function get__texture__step_content() {
        
        if($this->isCompleted()) {
            $thumb_id = get_post_thumbnail_id($this->active->post_parent);
            
            return '<img src="'.get_image_src($thumb_id, 'active_collab').'" />';
            
            
            
        }
        
    }
    
    
    public function get__texture_midpoint_feedback__step_content(){
        
        if($this->isCompleted()) {
            
            $stepPost = $this->active->getStatePost('texture_mid_wip');
            
            if($stepPost) {
                
                $thumb_id = get_post_thumbnail_id($stepPost->ID);
                if($thumb_id) {
                    return '<img src="'.get_image_src($thumb_id, 'active_collab').'" />';
                }
            }
        } else {
            
            $state = reset(array_keys($this->step['states']));
            
            
            if($this->isCurrent()) {
                $state = $this->active->current_step_state;
            }
            
            $title = $this->step['states'][$state]['label'];
                
            if($this->isCurrent() && $this->active->current_step_state == 'texture_mid_wip') {
                $link = ksm_get_permalink("collaboration/active/tmw/{$this->active->ID}");
                return "<a class=\"mid_btn active blue colorbox\" href=\"{$link}\">{$title}</a>";
            } elseif($this->isCurrent() && $this->active->current_step_state == 'fb_wait_texture_mid_wip') {
                return "<span class=\"mid_btn l2 red\">{$title}</span>";
            } 
            
            else {
                return "<span class=\"mid_btn\">{$title}</span>";
            }
        }
    }
    
    public function get__texture_final_feedback__step_content() {
        if($this->isCompleted()) {
            
            $stepPost = $this->active->getStatePost('texture_final_wip');
            
            if($stepPost) {
                
                $thumb_id = get_post_thumbnail_id($stepPost->ID);
                if($thumb_id) {
                    return '<img src="'.get_image_src($thumb_id, 'active_collab').'" />';
                }
            }
        } else {
            
            $state = reset(array_keys($this->step['states']));
            
            
            if($this->isCurrent()) {
                $state = $this->active->current_step_state;
            }
            
            $title = $this->step['states'][$state]['label'];
                
            if($this->isCurrent() && $this->active->current_step_state == 'texture_final_wip') {
                $link = ksm_get_permalink("collaboration/active/tfw/{$this->active->ID}");
                return "<a class=\"mid_btn active blue l2 colorbox\" href=\"{$link}\">{$title}</a>";
            } elseif($this->isCurrent() && $this->active->current_step_state == 'fb_wait_texture_final_wip') {
                return "<span class=\"mid_btn l2 red\">{$title}</span>";
            } 
            
            else {
                return "<span class=\"mid_btn l2\">{$title}</span>";
            }
            
            
            
        }
    }
    
    
    public function get__model_texture_publish__step_content() {
        
        if($this->isCompleted()) {
            
            
        } else {
            
            
            $state = reset(array_keys($this->step['states']));
            
            
            if($this->isCurrent()) {
                $state = $this->active->current_step_state;
            }
            
            $title = $this->step['states'][$state]['label'];
                
            if($this->isCurrent() && $this->active->current_step_state == 'sell_model_texture') {
                $link = ksm_get_permalink("collaboration/active/sellmt/{$this->active->ID}");
                return "<a class=\"mid_btn active blue colorbox\" href=\"{$link}\">{$title}</a>";
            } else {
                return "<span class=\"mid_btn\">{$title}</span>";
            }
        }
    }
    
    public function get__model_texture_rate__step_content() {
        if($this->isCompleted()) {
            
            
        } else {
            
            
            $state = reset(array_keys($this->step['states']));
            
            
            if($this->isCurrent()) {
                $state = $this->active->current_step_state;
            }
            
            $title = $this->step['states'][$state]['label'];
                
            if($this->isCurrent() && $this->active->current_step_state == 'rate_model_texture') {
                $link = ksm_get_permalink("collaboration/active/rate/{$this->active->ID}");
                return "<a class=\"mid_btn active blue colorbox\" href=\"{$link}\">{$title}</a>";
            } else {
                return "<span class=\"mid_btn\">{$title}</span>";
            }
        }
    }

    public function get_content() {
        $method = "get__{$this->name}__step_content";
        return $this->{$method}();
    }
    
    
    public function can_publish() {
        
        if(!$this->isOwner()) {
            return false;
        }
        
        if($this->name == 'model_midpoint_feedback' && $this->active->current_step_state == 'model_mid_wip') {
            return true;
        }
    }
      
    
    
    function get__texture_publish__step_content(){
        if($this->isCompleted()) {
            $stepPostID = $this->active->Collaboration->textured_download_id;
            if($stepPostID) {
                $stepPost = get_post($stepPostID);
                
                if($stepPost) {
                    $thumb_id = get_post_thumbnail_id($stepPost->ID);
                    if($thumb_id) {
                        return '<img src="'.get_image_src($thumb_id, 'active_collab').'" />';
                    }
                }
            }
            
        } else {
            
            
            $state = reset(array_keys($this->step['states']));
            
            
            if($this->isCurrent()) {
                $state = $this->active->current_step_state;
            }
            
            $title = $this->step['states'][$state]['label'];
                
            if($this->isCurrent() && $this->active->current_step_state == 'sell_texture') {
                
                
                //if($this->active->Collaboration->launch_type == 'concept') {
                    //$link = ksm_get_permalink("collaboration/active/cpmtm/{$this->active->ID}");
                //} elseif($this->active->Collaboration->launch_type == 'untextured') {
                    $link = ksm_get_permalink("collaboration/active/cptm/{$this->active->ID}");
                //}
                
                
                
                
                return "<a class=\"mid_btn active blue colorbox\" href=\"{$link}\">{$title}</a>";
            } else {
                return "<span class=\"mid_btn\">{$title}</span>";
            }
        }
    }
    
    function get__texture_rate__step_content() {
        if($this->isCompleted()) {
            
            
        } else {
            
            
            $state = reset(array_keys($this->step['states']));
            
            
            if($this->isCurrent()) {
                $state = $this->active->current_step_state;
            }
            
            $title = $this->step['states'][$state]['label'];
                
            if($this->isCurrent() && $this->active->current_step_state == 'rate_texture') {
                $link = ksm_get_permalink("collaboration/active/rate/{$this->active->ID}");
                return "<a class=\"mid_btn active blue colorbox\" href=\"{$link}\">{$title}</a>";
            } else {
                return "<span class=\"mid_btn\">{$title}</span>";
            }
        }
    }
    
    
    
    function get_side_button_content($k, $args) {
        
        
        $btn_class = $this->name.'_'.$k;
        
        
        if(!$this->isCompleted()) {
            return '<span class="btn btn_blue '.$btn_class.'">'.$args['label'].'</span>';
        }
        
        
        if($args['uri']) {
            $url = ksm_get_permalink("collaboration/active/{$args['uri']}/{$this->active->ID}");
        }
        
        
        return '<a href="'.$url.'" class="btn btn_blue colorbox '.$btn_class.'">'.$args['label'].'</a>';
        
        
        //$method = "get__{$this->name}_left_button__{$k}__content";
        //return $this->{$method}($label);
        
    }
    
    function render() {
        
        $completed = $this->isCompleted();
        $current = $this->isCurrent();
        
        
        $content = $this->get_content();
        
        
        $classes = array('step');
        
        if($current) $classes[] = 'current';
        if($completed) $classes[] = 'completed';
        
        $classes = implode(' ', $classes);
        
        ob_start();
    ?>

    <div class="<?=$classes?>" rel="<?=$s_name?>">
        <div class="link top"></div>
    
        <div class="inner">
            <div class="title"><?=$this->step['title']?></div>

            <div class="box_border">
                <div class="box"><?=$content?></div>
            </div>
        </div>
    
        <div class="side_buttons">
            <?php foreach ((Array)$this->step['side_buttons'] as $k => $v) : 
                $s_button_content = $this->get_side_button_content($k, $v);
                echo $s_button_content;
                ?>
            
            <?php endforeach;; ?>
        </div>
        <div class="clr"></div>
        
        <?php if(!$this->isLast()) : ?>
        <div class="link bottom">
            <div class="dot"></div>
        </div>
        <?php endif; ?>
    </div>
    
    <?php
    
    return ob_get_clean();
    
    }
    
    
}





/*

class KSM_CollaborationActiveStepPost extends KSM_Post {
    public $_post_type = 'collab_active_step';
}

class KSM_CollaborationActiveStepModelWip extends KSM_CollaborationActiveStepPost {
    public function submit() { }
}

*/

