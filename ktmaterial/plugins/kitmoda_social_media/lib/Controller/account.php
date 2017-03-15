<?php

class KSM_AccountController extends KSM_BaseController {
    
    
    
    public $scripts = array(
        array('account', array('jquery', 'ksm_scripts')),
        
        array('selectbox/jquery.selectbox-0.2.min', array('jquery', 'ksm_scripts'))
    );
    
    public $styles = array('selectbox/jquery.selectbox');
    
    
    

    
    
    public function ksm_index() {
        $this->set('sub_tab', 'messages');
        
        $user_id = get_current_user_id();
        if(!$user_id) {
            $login_page = ksm_get_permalink('login/account_messages');
            wp_redirect($login_page);
            exit;
        }
    }
    
    
    
    function ksm_return_model() {
        
        $this->layout = 'colorbox';
        $pd_id = $this->params['id'];
        $pd = new KSM_Purchased_Download($pd_id);
        $res = $this->isReturnable($pd);
        
        //pr($res);
        //exit;
        
        if($res['success']) {
            $this->set('can_return', true);
            $this->set('_id', KSM_Action::return_model($pd_id));
            
        }
        
        
        
        $this->set('message', $res['msg']);
    }
    
    
    function ksm_ajax_submit_return_model() {
        
        
        $_params = KSM_Action::get($_POST['_id']);
        
        if($_params['id'] && $_params['action'] == 'return_model') {
            $pd_id = $_params['id'];
        } else {
            return;
        }
        
        
        
        $pd = new KSM_Purchased_Download($pd_id);
        $res = $this->isReturnable($pd);
        if($res['success']) {
            
            
            $result = $pd->ReturnModel();
            
            if($result['success']) {
                if($pd->is_rated()) {
                    $pd->Download->calculateRating();
                }
                KSM_Js::forceReloadPageWithMessage("Model Returned.");
            } else {
                $error = $result['msg'];
            }
        } else {
            $error = $res['msg'];
        }
        
        
        KSM_Js::setModelReturnError($error);
        exit;
    }
    
    
    public function isReturnable($pd) {
        
        
        $returnable = false;
        $monthly_limit = MONTHLY_MODEL_RETURN_LIMIT;
        $max_limit = MAX_MODEL_RETURN_LIMIT;
        
        $total_returns = $pd->Author->totalModelReturns();
        $this_mo_returns = $pd->Author->monthModelReturns();
        
        if($pd->isOwner()) {
            
            if($pd->isReturned()) {
                $message = "You already returned this model.";
            }
            elseif($pd->isReturnable()) {
                $message = "";
                if($total_returns >= $max_limit) {
                    $message = "Your account has exceeded the limit of maximum returns per account. You can't return this model";
                }
                elseif($this_mo_returns >= $monthly_limit) {
                    $message = "Your account has exceeded the limit of maximum returns per month. You can't return this model";
                } else {
                    $returnable = true;
                    
                    $message = "This product was purchased within 24 hours and is valid for return. 
                        Our terms allow {$monthly_limit} returns per customer per month 
                        and a total of {$max_limit} returns per account. You currently 
                        have made {$this_mo_returns} return this month and {$total_returns} total over the lifetime of your account. 
                        Do you wish to continue?";
                    
                }
            } else {
                $message = "Returns are valid for 24 hours after purchase. 
                        This product is no longer eligible for return. We are sorry for the inconvenience. 
                        If you feel this product needs to be reported. Feel free to email 
                        report_product@kitmoda.com";
            }
        } else {
            $message = "you cannot return this model";
        }
        
        
        if($returnable) {
            return array('success' => true, 'msg' => $message);
        }
        return array('error' => true, 'msg' => $message);
    }
    
    
    public function ksm_rate_model() {
        $this->layout = 'colorbox';
        
        $pd_id = $this->params['id'];
        $can_rate = false;
        
        $this->scripts[] = array('rateit/jquery.rateit.min', array('jquery'));
        $this->styles[] = 'rateit/rateit';
        
        if($pd_id) {
            $pd = new KSM_Purchased_Download($pd_id);
            
            if($pd->isOwner()) {
                if($pd->is_rated()) {
                    $error = "This model is already rated.";
                } else {
                    $can_rate = true;
                }
            }
        }
        
        
        
        
        if(!$can_rate && !$error) {
            $error = "You can't rate this model.";
        }
        
        //$pd->Download->calculateRating();
        //exit;
        
        
        if($can_rate) {
            $form = $pd->Download->getRatingForm();
            
            
            //if(!$pd->Download->rate_assignment_roles) {
            //    $pd->Download->update_meta('rate_assignment_roles', $form->getAssignmentRules());
            //}
            
            $form->purchase_download = $pd;
            $this->set('form', $form);
        } else {
            KSM_Js::closeColorBoxWithError($error);
            //$this->set('error', $error);
        }
        
    }
    
    
    public function ksm_ajax_submit_model_rate() {
        
        
         $form_id = $_POST['form_id'];
        
        $_params = KSM_Action::get($form_id);
        
        
        
        
        $hasAccess = false;
        $error = "";
        
        if($_params && $_params['name'] && $_params['_id']) {
            
            $pd = new KSM_Purchased_Download($_params['_id']);
            if($pd && $pd->isOwner()) {
                if($pd->is_rated()) {
                    $error = "You already rate this model.";
                } else {
                    $hasAccess = true;
                }
            }
        }
        
        
        
        
        if(!$hasAccess && !$error) {
            $error = "You can't rate this model.";
        }
        
        
        if($hasAccess) {
            
            $form = $pd->Download->getRatingForm($_POST);
            $form->purchase_download = $pd;
            $result = $form->submit();
            if($result['success']) {
                $pd->Download->calculateRating();
            }
        } else {
            $result = array('error' => true, 'msg' => $error);
        }
        
        
        
        
        if($result['error']) {
            KSM_Js::setPopupError($result['msg']);
            exit;
        }
        
        
        
        KSM_Js::forceReloadPageWithMessage($result['msg']);
        
        die();
    }
    
    
    public function ksm_pending_purchase() {
        $this->layout = "colorbox";
    }
    
    
    public function ksm_download() {
        $pd_id = $this->params['id'];
        $user_id = get_current_user_id();
        
        if($pd_id && $user_id) {
            $pdownload = new KSM_Post($pd_id, false);
            
            if($pdownload && $pdownload->isOwner()) {
                
                    $downloader = new KSM_Purchase_Downloader(array(
                    'post' => $pdownload,
                    'dl_filename' => 'concept_files'));
                
                    
                    if($downloader->prepare()) {
                        $downloader->init_download();
                    }
                    
                    
                    //pr($download->edd_download_files);
                
                        
                //pr(get_post_meta());
                exit;
                
            }
        }
    }
    
    
    
    
    public function ksm_purchase_library() {
        $this->set('sub_tab', 'purchase_library');
        $user_id = get_current_user_id();
        
        
        
        
        if(!$user_id) {
            $login_page = ksm_get_permalink('login/account_purchase_library');
            wp_redirect($login_page);
            exit;
        }
        
        
        
        $ksm_user = new KSM_User($user_id);
        
        
        $auth_id = KSM_Action::StudioID(wp_get_current_user());
        
        $this->set('ksm_auth_id', $auth_id);
        $this->set('ksm_user', $ksm_user);
    }
    
    
    
    public function ksm_ajax_filter_purchases() {
        
        $action = KSM_Action::get($_POST['ksm_auth_id']);
        if(!(is_array($action) && $action['user'])) {
            return;
        }
        
        
        $auth_user = get_user_by('login', $action['user']);
        $user_id = get_current_user_id();
        
        if(!($user_id && $user_id == $auth_user->ID)) {
            return;
        }
        
        
        $empty_message = "No models within your library match that search criteria.";
        
        
        if(get_number($auth_user->count_total_purchases) == 0) {
            $empty_message = "You have not purchased any models from Kitmoda yet.";
        }
        
        
        
        
        
        $sorts = array('newest', 'oldest');
        $sort = $_POST['sort'];
        $sort_args = array('orderby' => 'date', 'order' => 'DESC');
        if($sort == 'oldest') {
            $sort_args = array('orderby' => 'date', 'order' => 'ASC');
        }
        
        
        $model_types = array('textured', 'untextured');
        $model_types_input = $_POST['mt'] ? (Array) $_POST['mt'] : array();
        $final_model_types = array();
        foreach ($model_types_input as $mti) {
            if(in_array($mti, $model_types)) {
                $final_model_types[] = $mti;
            }
        }
        
        
        
        $page = $_POST['page'];
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        
        $args = array(
            'post_type' => 'ksm_p_download',
            'author' => $user_id,
            'post_status' => 'any',
            'posts_per_page' => 4,
            'paged' => $page,
        );
        
        
        
        
        $args = array_merge($args , $sort_args);
        
        
        
        
        if(!(count($final_model_types) == count($model_types) || empty($final_model_types))) {
            
            
            
            foreach ($final_model_types as $fmt) {
                $args['meta_query'] = array(
                array(
                    'key' => 'model_type',
                    'value' => $fmt ,
                    'compare' => '='
                    )
                );
            }
        }
        
        
        
        
        //$tax_query = array();
        if($_POST['q']) {
            //$args['s'] = $_POST['q'];
            
            $args['tax_query'] = array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'ksm_tax_keyword',
                'field' => 'slug',
                'terms' => sanitize_title_for_query($_POST['q'])
                )
            );
        }
        
        
        
        $query = new WP_Query( $args );
        
        
        
        
        $containers = array();
        
        
        
        ob_start();
        
        
        foreach($query->posts as $post) {
            $pd = new KSM_Purchased_Download($post->ID);
            $this->render_element('purchase_library_product_item', array('pd' => $pd));
        }
        
        $containers['posts'] = ob_get_clean();
        
        $containers['pagination'] = 
                $this->Model->paginate_links(array('prev_text' => '', 'next_text' => ''), $query);
                
        
        
        
        wp_reset_postdata();
        
        
        if($query->post_count == 0) {
            $containers['posts'] = '<div class="empty_msg">'.$empty_message.'</div>';
        }
        
        
        
        
        
        echo json_encode($containers);
        
    }
    
    
    
    public function ksm_sales() {
        $this->set('sub_tab', 'sales');
        $user_id = get_current_user_id();
        if(!$user_id) {
            $login_page = ksm_get_permalink('login/account_sales');
            wp_redirect($login_page);
            exit;
        }
        
        
        
        
        $ksm_user = new KSM_User($user_id);
        
        
        $auth_id = KSM_Action::StudioID(wp_get_current_user());
        
        $this->set('ksm_auth_id', $auth_id);
        $this->set('ksm_user', $ksm_user);
        
    }
    
    
    public function ksm_ajax_filter_sales() {
        
        $action = KSM_Action::get($_POST['ksm_auth_id']);
        if(!(is_array($action) && $action['user'])) {
            return;
        }
        
        
        $auth_user = get_user_by('login', $action['user']);
        $user_id = get_current_user_id();
        
        if(!($user_id && $user_id == $auth_user->ID)) {
            return;
        }
        
        
        $empty_message = "No models within your library match that search criteria.";
        
        
        if(get_number($auth_user->count_total_purchases) == 0) {
            $empty_message = "None of your Kitmoda products have been purchased yet.";
            //None of your models have sold yet.
        }
        
        
        
        
        
        $sorts = array('newest', 'oldest');
        $sort = $_POST['sort'];
        $sort_args = array('orderby' => 'date', 'order' => 'DESC');
        if($sort == 'oldest') {
            $sort_args = array('orderby' => 'date', 'order' => 'ASC');
        }
        
        
        $model_types = array('textured', 'untextured');
        $model_types_input = $_POST['mt'] ? (Array) $_POST['mt'] : array();
        $final_model_types = array();
        foreach ($model_types_input as $mti) {
            if(in_array($mti, $model_types)) {
                $final_model_types[] = $mti;
            }
        }
        
        
        
        $page = $_POST['page'];
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        $meta_query = array();
        
        $args = array(
            'post_type' => 'ksm_p_download',
            'post_status' => 'any',
            'posts_per_page' => 4,
            'paged' => $page,
        );
        
        $meta_query[] = array(
                'key' => "pd_download_author_{$user_id}_share",
                'compare' => 'EXISTS',
                //'value' => ''
            );
        
        
        $args = array_merge($args , $sort_args);
        
        
        
        
        if(!(count($final_model_types) == count($model_types) || empty($final_model_types))) {
            
            
            
            foreach ($final_model_types as $fmt) {
                $meta_query[] = 
                array(
                    'key' => 'model_type',
                    'value' => $fmt ,
                    'compare' => '='
                );
            }
        }
        
        
        $args['meta_query'] = $meta_query;
        
        
        //$tax_query = array();
        if($_POST['q']) {
            //$args['s'] = $_POST['q'];
            
            $args['tax_query'] = array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'ksm_tax_keyword',
                'field' => 'slug',
                'terms' => sanitize_title_for_query($_POST['q'])
                )
            );
        }
        
        //pr($args);
        
        $query = new WP_Query( $args );
        
        //pr($query);
        
        
        $containers = array();
        
        
        
        ob_start();
        
        
        foreach($query->posts as $post) {
            $pd = new KSM_Purchased_Download($post->ID);
            $this->render_element('sale_item', array('pd' => $pd, 'user_id' => $user_id));
        }
        
        $containers['posts'] = ob_get_clean();
        
        $containers['pagination'] = 
                $this->Model->paginate_links(array('prev_text' => '', 'next_text' => ''), $query);
                
        
        
        
        wp_reset_postdata();
        
        
        if($query->post_count == 0) {
            $containers['posts'] = '<div class="empty_msg">'.$empty_message.'</div>';
        }
        
        
        
        
        
        echo json_encode($containers);
        
    }
            
    public function ksm_products() {
        $this->set('sub_tab', 'products');
        $user_id = get_current_user_id();
        if(!$user_id) {
            $login_page = ksm_get_permalink('login/account_products');
            wp_redirect($login_page);
            exit;
        }
        
        
        $ksm_user = new KSM_User($user_id);
        
        
        $auth_id = KSM_Action::StudioID(wp_get_current_user());
        
        $this->set('ksm_auth_id', $auth_id);
        $this->set('ksm_user', $ksm_user);
    }
    
    
    
    public function ksm_ajax_filter_products() {
        
        $action = KSM_Action::get($_POST['ksm_auth_id']);
        if(!(is_array($action) && $action['user'])) {
            return;
        }
        
        
        $auth_user = get_user_by('login', $action['user']);
        $user_id = get_current_user_id();
        
        if(!($user_id && $user_id == $auth_user->ID)) {
            return;
        }
        
        
        $empty_message = "No models within your library match that search criteria.";
        
        
        if(get_number($auth_user->count_total_purchases) == 0) {
            $empty_message = "You have not purchased any models from Kitmoda yet.";
        }
        
        
        
        
        
        $sorts = array('newest', 'oldest');
        $sort = $_POST['sort'];
        $sort_args = array('orderby' => 'date', 'order' => 'DESC');
        if($sort == 'oldest') {
            $sort_args = array('orderby' => 'date', 'order' => 'ASC');
        }
        
        
        $model_types = array('textured', 'untextured');
        $model_types_input = $_POST['mt'] ? (Array) $_POST['mt'] : array();
        $final_model_types = array();
        foreach ($model_types_input as $mti) {
            if(in_array($mti, $model_types)) {
                $final_model_types[] = $mti;
            }
        }
        
        
        
        $page = $_POST['page'];
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        
        $args = array(
            'post_type' => 'download',
            //'author' => $user_id,
            'post_status' => 'any',
            'posts_per_page' => 4,
            'paged' => $page,
        );
        
        
        
        
        
        
        //$meta_query = array();
        
        $args = array_merge($args , $sort_args);
        
        
        
        
        if(!(count($final_model_types) == count($model_types) || empty($final_model_types))) {
            
            
            
            foreach ($final_model_types as $fmt) {
                
                
                
                
                $args['meta_query'] = array(
                array(
                    'key' => 'model_type',
                    'value' => $fmt ,
                    'compare' => '='
                    )
                );
            }
        }
        
        
        //$args['meta_query'] = $meta_query;
        
        //$tax_query = array();
        if($_POST['q']) {
            //$args['s'] = $_POST['q'];
            
            $args['tax_query'] = array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'ksm_tax_keyword',
                'field' => 'slug',
                'terms' => sanitize_title_for_query($_POST['q'])
                )
            );
        }
        
        
        
        add_filter('posts_join', array($this->Model, 'filter_products_join'), 10, 2);
        
        $query = new WP_Query( $args );
        
        
        
        remove_filter('posts_join', array($this->Model, 'filter_products_join'), 10);
        
        
        $containers = array();
        
        
        
        ob_start();
        
        
        foreach($query->posts as $post) {
            $download = new KSM_Download($post->ID);
            $this->render_element('product_item', array('download' => $download));
        }
        
        $containers['posts'] = ob_get_clean();
        
        $containers['pagination'] = 
                $this->Model->paginate_links(array('prev_text' => '', 'next_text' => ''), $query);
                
        
        
        
        wp_reset_postdata();
        
        
        if($query->post_count == 0) {
            $containers['posts'] = '<div class="empty_msg">'.$empty_message.'</div>';
        }
        
        
        
        
        
        echo json_encode($containers);
        
    }
}
?>