<?php

class KSM_CollaborationActiveController extends KSM_BaseController {
    
    
    
    public $scripts = array(
        //array('justifiedGallery', array('jquery')),
        array('collab_active', array('jquery', 'ksm_scripts')),
        array('selectbox/jquery.selectbox-0.2.min', array('jquery', 'ksm_scripts'))
    );
    
    
    
    
    
    //public $styles = array('justifiedGallery.min');
    
    public $styles = array('collaboration', 'selectbox/jquery.selectbox');
    
    
    
    
    public function ksm_index() {
        
        $this->set('collaboration_tab', 'active');
        
        $user_id = get_current_user_id();
        
        if(!$user_id) {
            $this->set('auth_error', true);
            return;
        }
        
        
        
        
        $page = $_POST['page'];
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        
        $_args = array(
            'posts_per_page' => 3 ,
            'paged' => $page,
            'post_type' => 'collab_active',
            'post_status' => 'publish',
            'author' => $user_id,
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => 'is_completed',
                    'value' => '',
                    'compare' => 'NOT EXISTS'
                ),
                array(
                    'key' => 'is_completed',
                    'value' => 'yes',
                    'compare' => '!='
                )
                
                
            )
        );
        
        
        
        $query = new WP_Query( $_args );
        
        
        
        $no_post_found = false;
        
        $query = new WP_Query( $_args );
        
        if($query->found_posts == '0') {
            $no_post_found = true;
        }
        
        
        $this->set('no_post_found', $no_post_found);
        $this->set('query', $query);
        
    }
    
    
    
    public function ksm_partner_projects() {
        
        $this->set('collaboration_tab', 'partner_projects');
        $this->styles[] = 'collaboration_request';
        
        $user_id = get_current_user_id();
        
        
        if(!$user_id) {
            $this->set('auth_error', true);
            return;
        }
        
        
        $_args = array(
            'posts_per_page' => -1 ,
            'post_type' => 'collab_active',
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'collaboration_author', 
                    'value' => $user_id, 
                    'compare' => '=', 
                    )
            )
        );
        
        $no_post_found = false;
        
        $query = new WP_Query( $_args );
        if($query->found_posts == '0') {
            $no_post_found = true;
        } else {
            $current_project = '';
            $projects = array();
            
            foreach($query->posts as $p) {
                $projects[$p->ID] = new KSM_CollaborationActive($p->ID);
                if($this->params['id'] && $p->ID == $this->params['id'])
                    $current_project = $p->ID;
            }
            
            
            if(!$current_project || !in_array ($current_project, array_keys($projects))) {
                $current_project = reset($projects);
                $current_project = $current_project->ID;
            }
            
            if($current_project) {
                $current_project = $projects[$current_project];
                $current_project_author = new KSM_User($current_project->post_author);
                
                
                
                if($current_project->active_type == 'model') {
                    $role = 'Collaborating Model Artist';
                } elseif($current_project->active_type == 'texture') {
                    $role = 'Collaborating Teture Artist';
                } elseif($current_project->active_type == 'model_texture') {
                    $role = 'Collaborating Model & Teture Artist';
                }
                
                
                $duration = $current_project->CurrentStateDuration();
                $waiting_time = "";
                if($duration) {
                    $waiting_time = call_user_func_array('human_time_diff', array_map('strtotime', $duration));
                }
                
                
                if($current_project->isWaitingForFeedback()) {
                    $status = "Awating your Feedback for {$waiting_time}";
                } elseif($current_project->isWaitingForWIP()) {
                    $status = "Waiting for WIP {$waiting_time}";
                } elseif($current_project->isOnSellState()) {
                    $status = "Waiting for publish {$waiting_time}";
                } elseif($current_project->isCompleted()) {
                    $status = "Completed";
                }
            }
            
        }
        
        
        $this->set('no_post_found', $no_post_found);
        
        $this->set('current_project', $current_project);
        $this->set('current_project_author', $current_project_author);
        $this->set('current_project_author_role', $role);
        $this->set('current_project_status', $status);
        $this->set('projects', $projects);
    }
    
    
    
    
    public function ksm_ajax_send_message() {
        
        
        $result = $this->Model->send_message();
        
        if($result['error']) {
            KSM_Js::setCMessageError($result['msg']);
            exit;
        }
        
        
        $url = ksm_get_permalink('collaboration/partner_projects/'.$_POST['_id']);
        
        KSM_Js::reloadPageWithMessage($url, "Message Sent" , 2);
        
        
        exit;
        
        
    }
    
    
    public function ksm_ajax_submit_wip_feedback() {
        
        
        
        $result = $this->Model->submit_wip_feedback();
        
        if($result['error']) {
            KSM_Js::setCWipFeedbackError($result['msg']);
            exit;
        }
        
        KSM_Js::reloadPageWithMessage('', $result['msg'] , 2);
        
    }
    
    
    
    public function ksm_accept() {
        $this->layout = 'colorbox';
        $id = $this->params['id'];
        
        
        $result = $this->Model->accept_request($id);
        
        if($result['error']) {
            KSM_Js::closeColorBoxWithError($result['msg']);
            exit;
        }
        
    }
    
    public function ksm_reject() {
        $this->layout = 'colorbox';
        $id = $this->params['id'];
        $error = "";
        
        
        if($id) {
            
            
        }
        
        
    }

    
    public function ksm_join() {
        
        $this->layout = 'colorbox';
        $id = $this->params['id'];
        $error = "";
        
        
        if($id) {
            if(!$this->Model->can_user_send_join_request($id)) {
                $error = "You can't send a request to join this collaboration.";
            } elseif($this->Model->join_request_exists($id)) {
                $error = "Your request to join this collaboration was already sent.";
            }
            
            
        }
        
        if($error) {
            
            KSM_Js::closeColorBoxWithError($error);
            exit;
        }
        
        $post = get_post($id);
        
        $this->set('post' , $post);
        
        
    }
    
    
    
    
    /*
    function ksm_ajax_submit_join() {
        
        $post_id = $_POST['_id'];
        
        
        $result = $this->Model->send_join_request();
        
        if ($result['error']) {
            KSM_Js::setPopupError($result['msg']);
        } else {
            KSM_Js::setCollaborationJoinRequestSuccess();
        }
    }
    
    */
    
    function ksm_download_untextured_files() {
        $active_id = $this->params['id'];
        
        $error = "You dont have access to this section";
        
        if($active_id) {
            
            
            $active = new KSM_CollaborationActive($active_id);
            
            if($active && $active->isOwner()) {
                
                
                if($active->active_type == 'texture' || $active->active_type == 'model_texture') {
                    
                    $step = new KSM_CollaborationActiveStep($active, 'texture');
                    
                    if($step->isCompleted()) {
                        $download_id = $active->Collaboration->untextured_download_id;
                        
                        
                        
                        if($download_id && $download = KSM_Download::get($download_id)) {
                            
                            $error = "";
                            
                            $downloader = new KSM_Collaboration_Untextured_Downloader(
                                    array('post' => $download)
                                    );
                            
                            if($downloader->prepare()) {
                                $downloader->init_download();
                            } else {
                                $error = $downloader->error;
                            }
                        } else {
                            $error = "File not found";
                        }
                    }
                }
            }
        }
        
        
        if($error) {
            KSM_Js::closeColorBoxWithError($error);
        }
        
        
    }
    
    
    function ksm_download_concept_files() {
        
        $active_id = $this->params['id'];
        
        if($active_id) {
            $active = new KSM_CollaborationActive($active_id);
            
            if($active && $active->isOwner()) {
                
                $downloader = new KSM_Post_Images_Archive_Downloader(array(
                    'post' => $active->Collaboration,
                    'dl_filename' => 'concept_files'));
                
                
                
                if($downloader->prepare()) {
                    $downloader->init_download();
                }
            }
        }
        
    }
    
    function ksm_concept_files() {
        $this->layout = 'colorbox';
        
        $active_id = $this->params['id'];
        
        if($active_id) {
            $active = new KSM_CollaborationActive($active_id);
            
            if($active && $active->isOwner()) {
                $files = post_attacments($active->Collaboration->ID);
                $this->set('active', $active);
                $this->set('files', $files);
            }
        }
        
        
        
        
    }
    
    
    function ksm_untextured_files () {
        $this->layout = 'colorbox';
        
        $active_id = $this->params['id'];
        
        if($active_id) {
            $active = new KSM_CollaborationActive($active_id);
            
            if($active && $active->isOwner()) {
                //$files = post_attacments($active->Collaboration->ID);
                $this->set('active', $active);
            }
        }
        
        
    }
    
    
    function ksm_rate() {
        
        
        $this->layout = 'colorbox';
        $this->styles[] = 'store';
        
        $active_id = $this->params['id'];
        
        
        
        
        $haveAccess = false;
        
        $to_user = null;
        
        if($active_id) {
            $active = new KSM_CollaborationActive($active_id);
            
            if($active && $active->canRate()) {
                
                
                if($active->isOwner()) {
                    $to_user = $active->Collaboration->post_author;
                } elseif($active->Collaboration->isOwner()) {
                    $to_user = $active->post_author;
                }
                
                
                $haveAccess = true;
            }
        }
        
        
        if(!$haveAccess) {
            exit;
        }
        
        
        $this->scripts[] = array('rateit/jquery.rateit.min', array('jquery'));
        $this->styles[] = 'rateit/rateit';
        
        $this->set('active', $active);
        $this->set('to_user', $to_user);
    }
    
    
    
    function ksm_ajax_submit_rate() {
        
        $active_id = $_POST['active_id'];

        
        
        //pr($_POST['active_id']);
        
        $haveAccess = false;
        
        $to_user = null;
        
        if($active_id) {
            $active = new KSM_CollaborationActive($active_id);
            
            if($active && $active->canRate()) {
                
                
                if($active->isOwner()) {
                    $to_user = $active->Collaboration->post_author;
                } elseif($active->Collaboration->isOwner()) {
                    $to_user = $active->post_author;
                }
                
                $valid_ratings = range(1, 5);
                
                
                
                $communication_rate = $_POST['communication_rate'];
                $artwork_rate = $_POST['artwork_rate'];
                
                $error = "";
                
                if(!in_array($communication_rate, $valid_ratings)) {
                    $error = "Rate communication";
                }
                
                elseif(!in_array($artwork_rate, $valid_ratings)) {
                    $error = "Rate artwork";
                }
                
                
                if($error) {
                    KSM_Js::setRateError($error);
                    exit;
                }
                
                
                
                $res = $active->addRating(array(
                    'communication_rating' => $communication_rate,
                    'artwork_rating' => $artwork_rate,
                    'rate_by' => get_current_user_id(), 
                    'rate_to' => $to_user
                ));
                
                
                if($res) {
                    if($active->isOwner()) {
                        $active->moveToNextStop();
                    }
                    KSM_JS::reloadPageWithMessage('',"Rating successfully posted.", 2);
                }
            }
        }
        
        
        
        
    }
    
    
    function ksm_step_info() {
        
        $this->layout = 'colorbox';
        $this->styles[] = 'store';
        
        $active_id = $this->params['id'];
        
        $info = $this->params['info'];
        $wip_states = array('model_mid_wip', 'model_final_wip', 'texture_mid_wip', 'texture_final_wip');
        
        $step_post = null;
        
        
        $posts = array();
        
        
        $hasAccess = false;
        
        if($active_id && $info) {
            $active = new KSM_CollaborationActive($active_id);
            
            
            
            if($active && $active->isOwner()) {
                if(in_array($info, $wip_states)) {
                    $step_name = $active->getStepNameByState($info);
                    
                    $this->set('is_wip_post', true);
                    
                } elseif($info == 'model' || $info == 'texture') {
                    $step_name = $info;
                }
                    
                
                if($step_name) {
                    $step = new KSM_CollaborationActiveStep($active, $step_name);
                    if($step->isCompleted()) {
                        $hasAccess = true;
                    }
                }
            }
        }
        
        
        if(!$hasAccess) {
            exit;
        }
        
        
        switch ($info) {
            case "model":
                
                $posts['step'] = $active->Collaboration;
                $posts['description'] = $active->Collaboration;
                
                
                
                $partners = array(
                    'author' => 'by '.$active->Collaboration->Author->display_name_link(true).' at a price share of ' . edd_currency_filter(edd_format_amount($active->Collaboration->concept_price, true)),
                    'model_share' => 'Your "price share" for completed model <span class="price2">'.edd_currency_filter(edd_format_amount($active->Collaboration->model_price, true)).'</span>'
                );
                
                //$this->viewName = 'model_step_info';
                break;
            case "texture":
                
                if($active->active_type == 'texture' && $active->Collaboration->launch_type == 'concept') {
                    $posts['step'] = KSM_Download::get($active->Collaboration->untextured_download_id);
                } else {
                    $posts['step'] = $active->Collaboration;
                }
                
                $posts['description'] = $active->Collaboration;
                
                if($active->Collaboration->launch_type == 'concept') {
                    if($active->Collaboration->untextured_download_id) {
                        $posts['tech'] = KSM_Post::get_post($active->Collaboration->untextured_download_id);
                    }
                    
                    $partners['author'] = 'by '.$active->Collaboration->Author->display_name_link(true).' at a price share of ' . edd_currency_filter(edd_format_amount($active->Collaboration->concept_price, true));
                    
                } else {
                    $posts['tech'] = $active->Collaboration;
                    $partners['author'] = 'by '.$active->Collaboration->Author->display_name_link(true).' at a price share of ' . edd_currency_filter(edd_format_amount($active->Collaboration->model_price, true));
                }
                
                
                $partners['model_share'] = 'Your "price share" for completed texture <span class="price2">'.edd_currency_filter(edd_format_amount($active->Collaboration->texture_price, true)).'</span>';
                //$this->viewName = 'texture_step_info';
                
                break;
            case "model_mid_wip" :
            case "model_final_wip":
                $posts['step'] = $active->getStatePost($info);
                $posts['description'] = $active->Collaboration;
                
                
                $partners = array(
                    'author' => 'by '.$active->Collaboration->Author->display_name_link(true).' at a price share of ' . edd_currency_filter(edd_format_amount($active->Collaboration->concept_price, true)),
                    'model_share' => 'Your "price share" for completed model <span class="price2">'.edd_currency_filter(edd_format_amount($active->Collaboration->model_price, true)).'</span>'
                );
                
                //$this->viewName = 'model_wip_step_info';
                break;
            case "texture_mid_wip" :
            case "texture_final_wip":
                
                $posts['step'] = $active->getStatePost($info);
                $posts['description'] = $active->Collaboration;
                
                
                $step_post = $active->getStatePost($info);
                
                if($active->Collaboration->launch_type == 'concept') {
                    if($active->Collaboration->untextured_download_id) {
                        $posts['tech'] = KSM_Post::get_post($active->Collaboration->untextured_download_id);
                    }
                    
                    $partners['author'] = 'by '.$active->Collaboration->Author->display_name_link(true).' at a price share of ' . edd_currency_filter(edd_format_amount($active->Collaboration->concept_price, true));
                    
                } else {
                    $posts['tech'] = $active->Collaboration;
                    $partners['author'] = 'by '.$active->Collaboration->Author->display_name_link(true).' at a price share of ' . edd_currency_filter(edd_format_amount($active->Collaboration->model_price, true));
                }
                
                
                $partners['model_share'] = 'Your "price share" for completed texture <span class="price2">'.edd_currency_filter(edd_format_amount($active->Collaboration->texture_price, true)).'</span>';
                
                
                break;
        }
        
        
        
        
        $this->set('partners', $partners);
        $this->set('posts', $posts);
        $this->set('active', $active);
    }
    
    
    
    function ksm_step_notes() {
        
        
        
        $this->layout = 'colorbox';
        $this->styles[] = 'store';
        
        $active_id = $this->params['id'];
        
        $state = $this->params['step'];
        $wip_states = array('model_mid_wip', 'model_final_wip', 'texture_mid_wip', 'texture_final_wip');
        
        
        
        $post = null;
        if($active_id && $state) {
            $active = new KSM_CollaborationActive($active_id);
            
            
            
            if($active && $active->isOwner()) {
                if(in_array($state, $wip_states)) {
                    $step_name = $active->getStepNameByState($state);
                    $step = new KSM_CollaborationActiveStep($active, $step_name);
                    if($step->isCompleted()) {
                        $post = $active->getWipFeedbackPost($state);
                        
                        
                        
                        if($state == 'model_mid_wip')
                            $stage = "STAGE 1 - Start of project";
                        elseif($state == 'model_final_wip')
                            $stage = "STAGE 2";
                        elseif($state == 'texture_mid_wip')
                            $stage = "STAGE 3";
                        elseif($state == 'texture_final_wip') 
                            $stage = "STAGE 4";
                    }
                }
            }
        }
        
        
        if(!$post) {
            exit;
        }
        
        $this->set('post', $post);
        $this->set('stage', $stage);
        $this->set('active', $active);
    }
    
    
    function ksm_sell() {
        
        
        
        $this->layout = 'publisher';
        
        
        $active_id = $this->params['id'];
        
        $type = $this->params['type'];
        
        
        $step_post = null;
        
        
        $can_sell = false;
        
        if($active_id && $type) {
            $active = new KSM_CollaborationActive($active_id);
            
            if($active && $active->isOwner()) {
                
                $state = "sell_{$type}";
                if($active->isOnSellState() && $active->current_step_state == $state) {
                    $can_sell = true;
                }
            }
        }
        
        
        if(!$can_sell) {
            
            KSM_Js::closeColorBoxWithError("not available to sell");
            
        }
        
        
        $collboration = get_post($active->post_parent);
        
        $this->set('active', $active);
        $this->set('collaboration', $collboration);
        
        
        
        if($collboration->launch_type == 'untextured') {
            $this->viewName = 'untextured_step_info';
        }
        
        
    }
    
    
}
?>