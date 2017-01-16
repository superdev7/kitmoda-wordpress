<?php



class KSM_StudioController  extends KSM_BaseController {
    
    public $scripts = array(
        array('jquery.selectBoxIt', array('jquery', 'jquery-ui-widget')),
        
        
        array('justifiedGallery', array('jquery')),
	array('autosize', array('jquery')),
        array('selectbox/jquery.selectbox-0.2.min', array('jquery', 'ksm_scripts')),
        array('studio', array('jquery', 'jquery-ui-sortable', 'justifiedGallery', 'ksm_scripts', 'jquery.selectBoxIt')),
        array('jquery.kmvg', array('jquery', 'jquery-ui-sortable', 'justifiedGallery', 'ksm_scripts', 'jquery.selectBoxIt')),
        
        
        array('studio-app', array('jquery', 'angular', 'components-common', 'ksm_scripts'))
        
        
    );
    
    public $styles = array('jquery.selectBoxIt', 'justifiedGallery.min', 'selectbox/jquery.selectbox');
    
    
    public function ksm_index() {
        
        
        if($this->KUser->isPrivate && !$this->KUser->Auth) {
            $login_page = ksm_get_permalink('login');
            wp_redirect($login_page);
            exit;
        }
        
        
        $galleries = array();
        
        if($this->KUser->Access) {
            
            $galleries['Product_Studio'] = array('user_id'=> $this->KUser->Access->ID);
            $galleries['Finished_Studio'] = array('user_id'=> $this->KUser->Access->ID);
            $galleries['Wip_Studio'] = array('user_id'=> $this->KUser->Access->ID);
            
            
            $this->Helpers['Mvg'] = array('galleries' => $galleries);
            
            
            $studio_id = KSM_Action::StudioID($this->KUser->Access);
            $this->set('studio_id', $studio_id);
            
        } else {
            exit;
        }
        
        
    }
    
    
    // 
    
    
    function ksm_ajax_kmvg() {
        
        
        $action = KSM_Action::get($_POST['std']);
        
        if(!(is_array($action) && $action['user'])) {
            return;
        }
        
        
        
        $this->KUser = KUser::get_instance($action);
        
        
        if(!$this->KUser->Access) {
            return;
        }
        
        
        $studio_galleries = KSM_DataStore::Options('Studio_Gallery');
        
        
        
        $studio_galleries = array(
            'products' => 'Product_Studio',
            'finished' => 'Finished_Studio',
            'wip' => 'Wip_Studio'
            
            );
        
        $galleries_list = array();
        
        $page = 1;
        switch($_POST['type']) {
            
            case "reset":
                $gal_names = $_POST['galleries'] == 'all' ? $studio_galleries : explode(',', $_POST['galleries']);
                foreach($gal_names as $n) {
                    if(in_array($n, array_keys($studio_galleries))) {
                        $galleries_list[$n] = $studio_galleries[$n];
                    }
                }
                
                break;
            case "ftl" :
                $galleries_list = $studio_galleries;
                break;
            case "":
                
                break;
            
        }
        
        
        
        foreach($galleries_list as $g) {
            $galleries[$g] = array('user_id'=> $this->KUser->Access->ID);
        }
        
        
        
        if(empty($galleries)) {
            echo json_encode(array(
                'galleries' => array()
            ));
            die();
        }
        
        
        $mvg = new KSM_MvgHelper(array('galleries' => $galleries));
        $result = $mvg->ajaxLoad($page, $_POST['type']);
        $response = array('galleries' => $result);
        echo json_encode($response);
    }
    
    
    // cvk
    
    
    public function ksm_ajax_filter_posts() {
        
        
        
        $action = KSM_Action::get($_POST['studio']);
        
        if(!(is_array($action) && $action['user'])) {
            
            return;
        }
        
        
        
        $this->KUser = KUser::get_instance($action);
        
        
        $page = $_POST['page'];
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        
        $rpp = KSM_WALL_POST_RESULTS_PER_PAGE;
        //$rpp = 1;
            
        
        
        $args = array(
            'post_type' => 'ksm_post',
            'posts_per_page' => $rpp,
            'post_status' => 'publish',
            'paged' => $page,
            'author' => $this->KUser->Access->ID,
            'tax_query' => array(
                array(
                    'taxonomy' => 'ksm_tax_post_at',
                    'field' => 'name',
                    'terms' => array('studio')
                )
            ),
            'meta_query' => array(
                array(
                    'key' => 'blocked', 
                    'value' => 'no'
                    )
            ),
            'orderby' => 'date',
            'order' => 'DESC'
        );
        
        
        
        $query = new WP_Query( $args );
        
        $posts = array();
        $data = array();
        
        
        foreach( $query->posts as $p ) {
            $ksm_post = new KSM_Social_Post($p->ID);
            $posts[] = $ksm_post->rest_item();
        }
        
        
        $data['posts'] = $posts;
        
        $data['paging'] = array(
            'currentPage' => $query->query['paged'],
            'totalItems' => $query->found_posts,
            'rpp' => $rpp
            
        );
        
        echo json_encode($data);
        exit;
        
        /*
        $found = false;
        $containers = array();
        $containers['pagination'] = '';
        if($query->post_count > 0) {
            $found = true;
            $containers['pagination'] = 
                $this->Model->paginate_links(array('prev_text' => '', 'next_text' => ''), $query);
        } else {
            $containers['posts'] = '<div class="empty_msg">Wall is empty.</div>';
        }
        
        
        
        
        
        
        wp_reset_query();
        wp_reset_postdata();
        
        if($found) {
            ob_start();
            foreach($posts as $p) {
                $this->render_element('post_item', array('post'=> $p));
            }
            $containers['posts'] = ob_get_clean();
        }
        
        
        echo json_encode($containers);
        */
    }
    
    
    public function ksm_post_options() {
        
        $is_edit = $this->params['action_type'] == 'edit' ? true : false;
        
        
        $this->layout = 'colorbox';
        $id = $this->params['id'];
        
        $post = new KSM_Social_Post($id);
        $post->view_type = 'studio';
        
        
        
        if(!$post->post_options_available($is_edit)) {
            KSM_Js::closeColorBoxWithError("Post options are not available");
            exit;
        }
        
        $this->scripts[] = array('toggles.min', array('jquery'));
        $this->styles[] = 'toggles-full';
        
        
        
        $attachments = $post->image_attachments(array(
            'order'     => 'ASC',
            'meta_key' => 'image_sort',
            'orderby'   => 'meta_value_num',
        ));
        
        
        
        
        
        $post_at = $post->posted_at_type();
        $post_at_options = array('2' => 'Community + Studio', '1'=>'Only my Studio');
        $post_at_settings = array('name' => 'post_to', 'value' => ($post_at ? $post_at : 2));
        
        
        
        $this->set('is_edit', $is_edit);
        $this->set('submit_action', ($is_edit ? 'Studio_submit_edit_post' : 'Studio_submit_post_options'));
        
        $this->set('post_topic', $post->Topic());
        $this->set('post_progress', $post->Progress());
        $this->set('post_at_options', $post_at_options);
        $this->set('post_at_settings', $post_at_settings);
        $this->set('post', $post);
        $this->set('attachments', $attachments);
        
    }
    
    
    
    
    
    public function ksm_ajax_submit_post() {
        $result = $this->Model->add_post();
        
        if($result['error']) {
            KSM_Js::setWallPostError($result['msg']);
        } elseif($result['success']) {
            KSM_Js::onStudioPostAdded($result['post_id']);
        }
        
    }
    
    
    
    
    
    public function ksm_ajax_submit_edit_post() {
        $this->params['action_type'] = 'edit';
        $this->ksm_ajax_submit_post_options();
    }
    
    public function ksm_ajax_submit_post_options() {
        
        
        $is_edit = $this->params['action_type'] == 'edit' ? true : false;
        
        
        $post_id = sanitize_text_field($_POST['_id']);
        $post = new KSM_Social_Post($post_id);
        $post->view_type = 'studio';
        
        
        $result = $post->save_post_options($is_edit);
        
        
        
        if($result['error']) {
            KSM_Js::setPopupError($result['msg']);
        } elseif($result['success']) {
            
            unset($post);
            $post = new KSM_Social_Post($post_id);
            $post->view_type = 'studio';
            
            
            ob_start();
            
            
                
            $this->render_element('post_item', array('post' => $post, 'is_edit' => $is_edit));
            $wall_item_html = ob_get_clean();
            
            
            $wall_item_html = preg_replace( "/\r|\n/", "", $wall_item_html );
            
            $galleries = array();
            
            
            if($result['update_galleries']) {
                $galleries = array_keys(KSM_DataStore::Options('Studio_Gallery'));
            }
            if($is_edit) {
                KSM_Js::editWallPost($post->ID, $wall_item_html, $galleries);
            } else {
                KSM_Js::addWallPost($wall_item_html, $galleries);
            }
            
            
            
            
        }
    }
    
    
    
    
    public function ksm_delete_post() {
        
        $this->layout = 'colorbox';
        $id = $this->params['id'];
        
        
        $post = new KSM_Social_Post($id);
        $result = $post->can_delete_post();
        
        if($result['error']) {
            KSM_Js::closeColorBoxWithError($result['msg']);
            exit;
        }
        
        $this->set('post', $post);
    }
    
    
    
    public function ksm_ajax_submit_delete_post() {
        
        $id = sanitize_text_field($_POST['_id']);
        
        $delete_gallery_images = $_POST['delete_images'] == 'yes' ? true : false;
        
        $post = new KSM_Social_Post($id);
        $result = $post->delete($delete_gallery_images);
        
        
        
        
        
        if($result['error']) {
            KSM_Js::closeColorBoxWithError($result['msg']);
        } else {
            $galleries = array();
            if($result['update_galleries']) {
                $galleries = KSM_DataStore::Options('Studio_Gallery');
            }
            KSM_Js::wallPostDeleted($id, $result['msg'], $galleries);
        }
        
    }
    
    
    
    function ksm_ajax_submit_comment() {
        
        
        $comment = sanitize_text_field($_POST['comment']);
        $post_id = sanitize_text_field($_POST['_id']);
        
        
        
        $args = array(
            'user'=> wp_get_current_user(),
            'post_id' => $post_id,
            'comment' => $comment,
            'comment_type' => 'ksm_post',
            'extra_meta' => array(
                array('post_at', 'studio')
            )
        );
        
        $result = $this->Model->submit_comment($args);
        
        if($result['error']) {
            KSM_Js::setWallCommentError($post_id, $result['error']);
            die();
        } elseif($result['success']) {
            
            $wall_post = get_post($post_id);
            
            $comment_id = $result['comment_id'];
            $wpc = get_comment($comment_id);
            ob_start();
            $this->render_element('wall_comment_item', array('wpc' => $wpc));
            $comment_item_html = ob_get_clean();
            $comment_item_html = preg_replace( "/\r|\n/", "", $comment_item_html );
            
            KSM_Js::addWallComment($post_id, $comment_item_html, $wall_post->comment_count);
        }
    }
    
    
    function ksm_add_gallery_image() {
        
        $this->layout = 'colorbox';
        
    }
    
    
    
    function ksm_ajax_submit_add_gallery_image() {
        
        
        
        
        
    }
    
    
    
    function ksm_ajax_favorites_slider() {
        $action = KSM_Action::get($_POST['studio']);
        
        if(!(is_array($action) && $action['user'])) {
            
            $containers['content'] = '';
            $containers['found'] = false;
            $containers['pagination'] = '';
            $containers['count'] = '0';
            echo json_encode($containers);
            return;
        }
        
        
        
        $this->KUser = KUser::get_instance($action);
        
        
        add_filter('posts_join', array($this->Model, 'favorites_join'), 10, 2);
        
        
        $post_types = explode(',', ALLOWED_FAVORITE_POST_TYPES);
        $args = array(
            'post_type' => $post_types,
            'post_status' => array('inherit', 'publish'),
            'orderby' => 'date',
            'order' => 'DESC',
            'favorites_of_user' => $this->KUser->Access->ID
        );
        
        $query = new WP_Query( $args );
        
        
        
        remove_filter('posts_join', array($this->Model, 'favorites_join'));
        
        
        
        
        $containers = array();
        $found = false;
        ob_start();
        while ( $query->have_posts() ) : $query->the_post();
            $found = true;
            $this->render_element('favorite_slider_item');
        endwhile;
        
        $containers['content'] = ob_get_clean();
        $containers['pagination'] = 
                $this->Model->paginate_links(array('prev_text' => '', 'next_text' => ''), $query);
                
        
        $containers['count'] = $query->found_posts;
        
        $containers['found'] = $found;
        
        
        echo json_encode($containers);
        die();
    }
    
    
    function ksm_ajax_filter_top_sellings() {
        $action = KSM_Action::get($_POST['studio']);
        
        if(!(is_array($action) && $action['user'])) {
            
            $containers['posts'] = '<div class="empty_msg">Error! No Access.</div>';
            $containers['found'] = false;
            $containers['pagination'] = '';
            echo json_encode($containers);
            return;
        }
        
        
        ////////////////////////////
        
        
        
        //$total = get_number($this->KUser->Access->top_selling_count);
        //$pages_count = ceil($total/$rpp);
        //$current_page = $this->params['paged'] ? $this->params['paged'] : 1;
        //$current_page = (!is_numeric($current_page) || $current_page < 1) ? 1 : $current_page;
        
        
        
        
        
        
        
        //$top_sellings = array(
        //    'results' =>  $top_sellings,
        //    'top_selling_count' => $this->KUser->Access->top_selling_count,
        //    'pages_count' => $pages_count,
        //    'current_page' => $current_page
        //);
        
        
        //$this->set('top_sellings', $top_sellings);
        
        
        
        ///////////////////////////
        
        
        $this->KUser = KUser::get_instance($action);
        
        
        $rpp = 12;
        //$total = get_number($this->KUser->Access->favorites_count);
        //$pages_count = ceil($total/$rpp);
        
        $current_page = $_POST['page'] ? $_POST['page'] : 1;
        $current_page = (!is_numeric($current_page) || $current_page < 1) ? 1 : $current_page;
        
        
        
        
        
        
        
        $top_sellings = KSM_TopSelling::get_results($this->KUser->Access->ID, $current_page , $rpp);
        
        
        
        
        
        $args = array(
            'posts_per_page'    => $rpp, 
            'post_type'         => 'download', 
            'post_status'       => 'publish',
            'author'            => $this->KUser->Access->ID,
            'paged'             => $current_page,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => '_edd_download_sales',
                    'value' => '0',
                    'compare' => '>'
                    )
                ),
            'orderby'      => 'meta_value',
            'order'        => 'DESC',
        );
        
        
        
        $query = new WP_Query( $args );
        
        
        
        
        $containers = array();
        $found = false;
        ob_start();
        while ( $query->have_posts() ) : $query->the_post();
            $found = true;
            $this->render_element('top_selling_item');
        endwhile;
        
        $containers['posts'] = ob_get_clean();
        $containers['pagination'] = 
                $this->Model->paginate_links(array('prev_text' => '', 'next_text' => ''), $query);
                
        
        if($query->post_count == 0) {
            $containers['posts'] = '<div class="empty_msg">No product found.</div>';
        }
        
        $containers['found'] = $found;
        
        
        echo json_encode($containers);
        die();
    }
    
    function ksm_ajax_filter_favorites() {
        
        
        $action = KSM_Action::get($_POST['studio']);
        
        if(!(is_array($action) && $action['user'])) {
            
            $containers['posts'] = '<div class="empty_msg">Error! No Access.</div>';
            $containers['found'] = false;
            $containers['pagination'] = '';
            echo json_encode($containers);
            return;
        }
        
        
        
        $this->KUser = KUser::get_instance($action);
        
        
        $rpp = 15;
        //$total = get_number($this->KUser->Access->favorites_count);
        //$pages_count = ceil($total/$rpp);
        
        $current_page = $_POST['page'] ? $_POST['page'] : 1;
        $current_page = (!is_numeric($current_page) || $current_page < 1) ? 1 : $current_page;
        
        
        //$favorites = KSM_Favorite::get_user_favorites($this->KUser->Access->ID, $current_page , $rpp);
        
        
        ////////////////////////////////
        
        add_filter('posts_join', array($this->Model, 'favorites_join'), 10, 2);
        
        
        $post_types = explode(',', ALLOWED_FAVORITE_POST_TYPES);
        
        $args = array(
            'post_type' => $post_types,
            'posts_per_page' => $rpp,
            'post_status' => array('inherit', 'publish'),
            'paged' => $current_page,
            'orderby' => 'date',
            'order' => 'DESC',
            'favorites_of_user' => $this->KUser->Access->ID
        );
        
        $query = new WP_Query( $args );
        
        
        
        remove_filter('posts_join', array($this->Model, 'favorites_join'));
        
        
        
        
        $containers = array();
        $found = false;
        ob_start();
        while ( $query->have_posts() ) : $query->the_post();
            $found = true;
            $this->render_element('favorite_item');
        endwhile;
        
        $containers['posts'] = ob_get_clean();
        $containers['pagination'] = 
                $this->Model->paginate_links(array('prev_text' => '', 'next_text' => ''), $query);
                
        
        if($query->post_count == 0) {
            $containers['posts'] = '<div class="empty_msg">No favorite item found.</div>';
        }
        
        $containers['found'] = $found;
        
        
        echo json_encode($containers);
        die();
    }
    
    
    
    
    function ksm_favorites() {
        
        $studio_id = KSM_Action::StudioID($this->KUser->Access);
        $this->set('studio_id', $studio_id);
        $this->layout = 'colorbox';
    }
    
    function ksm_following() {
        
        
        
        $rpp = 2;
        $total = get_number($this->KUser->Access->followings_count);
        $pages_count = ceil($total/$rpp);
        
        
        $current_page = $this->params['paged'] ? $this->params['paged'] : 1;
        $current_page = (!is_numeric($current_page) || $current_page < 1) ? 1 : $current_page;
        
        
        
        $follows = KSM_Follow::get_user_following_ids($this->KUser->Access->ID, $current_page, $rpp);
        
        
        
        $results = array();
        
        foreach($follows as $f) {
            $results[] = new KSM_User($f->user_to);
        }
        
        
        $following = array(
            'results' =>  $results,
            'total' => $this->KUser->Access->followings_count,
            'pages_count' => $pages_count,
            'current_page' => $current_page
        );
        
        
        $this->set('following', $following);
        $this->layout = 'colorbox';
    }
    
    function ksm_top_selling() {
        
        $studio_id = KSM_Action::StudioID($this->KUser->Access);
        $this->set('studio_id', $studio_id);
        $this->layout = 'colorbox';
        
    }
    
    
}










?>