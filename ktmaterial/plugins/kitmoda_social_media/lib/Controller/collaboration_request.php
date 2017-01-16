<?php

class KSM_CollaborationRequestController extends KSM_BaseController {
    
    
    
    public $scripts = array(
        //array('justifiedGallery', array('jquery')),
        array('crequest', array('jquery', 'ksm_scripts'))
    );
    
    
    
    
    //public $styles = array('justifiedGallery.min');
    
    public $styles = array('collaboration');
    
    
    
    
    public function ksm_index() {
        
        $user_id = get_current_user_id();
        
        $this->set('collaboration_tab', 'requests');
        
        
        if(!$user_id) {
            $this->set('auth_error', true);
            return;
        }
        
        
        $query = '';
        
        
        $_args = array(
        'posts_per_page' => 20 ,
        'paged' => $page,
        'post_type' => 'collab_join_request',
        'post_status' => 'publish',
        'meta_query' => array(
            //array(
                //'key' => 'request_status', 
                //'value' => 'active', 
                //'compare' => '=', 
                //),
            array(
                'key' => 'collaboration_author', 
                'value' => $user_id, 
                'compare' => '=', 
                'type' => 'INT'
                )
            )
            );
        
        
        
        
        $no_post_found = false;
        $query = new WP_Query( $_args );

        if($query->found_posts == '0') {
            $no_post_found = true;
        }
        
        
        
        $this->set('no_post_found', $no_post_found);
        $this->set('query', $query);
        
        
    }
    
    
    
    
    public function ksm_accept() {
        $this->layout = 'colorbox';
        $id = $this->params['id'];
        
        
        $result = $this->Model->accept_request($id);
        
        if($result['error']) {
            KSM_Js::closeColorBoxWithError($result['msg']);
            exit;
        } else {
            KSM_Js::onCollaborationRequestAccept($id);
        }
        
    }
    
    public function ksm_reject() {
        $this->layout = 'colorbox';
        $id = $this->params['id'];
        
        
        $result = $this->Model->reject_request($id);
        
        if($result['error']) {
            KSM_Js::closeColorBoxWithError($result['msg']);
            exit;
        }
        
        KSM_Js::onCollaborationRequestReject($id);
        exit;
        
    }

    
    public function ksm_join() {
        
        $this->layout = 'colorbox';
        $id = $this->params['id'];
        
        
        $result = $this->Model->can_user_send_join_request($id);
        
        if($result['error']) {
            KSM_Js::closeColorBoxWithError($result['msg']);
            exit;
        }
        
        $this->scripts[] =  array('jquery.mCustomScrollbar.concat.min', array('jquery'));
        $this->styles[] = 'jquery.mCustomScrollbar';
        
        $post = get_post($id);
        
        $this->set('post' , $post);
        
        
    }
    
    
    
    
    
    function ksm_ajax_submit() {
        
        
        $result = $this->Model->send_join_request();
        
        if ($result['error']) {
            KSM_Js::setPopupError($result['msg']);
        } else {
            KSM_Js::setCollaborationJoinRequestSuccess();
        }
        
        
    }
    
    
    
    
    
}
?>