<?php

class KSM_Rest_Controller_Posts extends KSM_BaseRest {
    
    
    public $topic_terms = array(
            'general',
            'challenge',
            'model',
            'concept',
            'texture',
            'question'
        ),

        $gallery_terms = array(
            'wip',
            'finished'
        );
    
    
    
    
    function report_permission($request) {
        $this->request = $request;
        
        if($this->is_access_valid()) {
            $post = KSM_Social_Post::get($this->param('id'));
            if($post) {
                unset($post);
                return true;
            }
            
        }
        
        return false;
    }
    
    function report() {
        
        $user_id = get_current_user_id();
        $post = KSM_Social_Post::get($this->param('id'));
        
        $reasons = (Array) $this->param('reasons');
        $all_reasons = array_keys((Array)KSM_DataStore::Options('Post_Inappropriate_Type'));
        $final_reasons = array();
        foreach($reasons as $r) {
            if(in_array($r, $all_reasons)) {
                $final_reasons[] = $r;
            }
        }
        
        
        if($post->is_reported_by($user_id)) {
            $this->Error('already_reported', "You have already reported this post.");
        }
        elseif(empty($final_reasons)) {
            $this->Error('reasons', "Please select at least one option.");
        } else {
            if($post->addReport($final_reasons)) {
                if(!$post->is_blocked() && $post->should_auto_block()) {
                    $post->block();
                }
                
                $this->setSuccess('Thanks for feedback.');
            }
            
        }
        
        $this->send_result();
    }
    
    
    function community_query_permission($request) {
        
        $this->request = $request;
        
        if(!$this->param('action') && !$this->param('id')) {
            return true;
        }
        
    }
    
    
    
    function community_query() {
        
        
        $user_id = get_current_user_id();
        
        $topics = (Array) $this->param('topic');
        
        $only_following = $this->param('following') == 'following' ? true : false;
        $only_with_images = $this->param('with_images') == 'with_images' ? true : false;
        
        $only_my_posts = $this->param('my_posts') == 'my_posts' ? true : false;
        
        
        if($only_my_posts && !$user_id) {
            
            $error = "No Post found";
            
        }
        
        
        
        $tax_terms = array();
        
        $sorts = array('newest', 'likes', 'views');
        
        $sort = $this->param('sort');
        
        
        $sort_args = array('orderby' => 'date', 'order' => 'DESC');
        
        if($sort == 'likes') {
            $sort_args = array('meta_key' => 'likes_count', 'orderby' => 'meta_value_num', 'order' => 'DESC');
        } elseif($sort == 'views') {
            $sort_args = array('meta_key' => 'views_count','orderby' => 'meta_value_num', 'order' => 'DESC');
        }
        
        foreach ($topics as $t) {
            if(in_array($t, $this->topic_terms) || in_array($t, $this->gallery_terms)) {
                $tax_terms[] = $t;
            }
        }
        
        
        
        
        
        $page = $this->param('page');
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        
        $rpp = 4;
        //$rpp = COMMUNITY_POSTS_PER_PAGE;
        
        $args = array(
            'posts_per_page' => $rpp,
            'paged' => $page,
            'post_type' => 'ksm_post'
            );
        
        
        
        if($only_my_posts) {
            $args['author'] = get_current_user_id();
        }
        
        
        $args['tax_query'] = array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'ksm_tax_post_at',
                'field' => 'name',
                'terms' => 'community'
                )
            );
        
        if($tax_terms) {
            $args['tax_query'][] = array(
                'taxonomy' => 'ksm_tax_topic',
                'field' => 'name',
                'terms' => $tax_terms);
        }
        
        
        
        $args = array_merge($args , $sort_args);
        
        
        
        
        
        
        $args['meta_query'] = array(
            array('key' => 'blocked', 'value' => 'no')
            );
        
        if($only_with_images) {
            $args['meta_query'][] = array(
                'key' => 'images_count',
                'value' => 0 ,
                'compare' => '>'
                );
        }
        
        if($only_following) {
            
            if(get_current_user_id()) {
                $authors = KSM_Follow::get_all_user_following_ids(get_current_user_id());
                if(!empty($authors)) {
                    $args['author'] = implode(',', $authors);
                }
            }
            
            if(!$args['author']) {
                echo json_encode(array('posts' => '<div class="empty_msg">No Post found.</div>', 'pagination' => ''));
                die();
            }
        }
        
        
        if($this->param('q')) {
            $args['s'] = $this->param('q');
        }
        
        
        $query = new WP_Query( $args );
        
        $posts = array();
        $data = array();
        
        
        foreach( $query->posts as $p ) {
            $ksm_post = new KSM_Social_Post($p->ID);
            $posts[] = $ksm_post->rest_item('get', array('images' => null ,
                                                  'is_community' => true,
                                                  'gallery' => true
                                                  ));
        }
        
        
        $data['posts'] = $posts;
        
        $data['paging'] = array(
            'currentPage' => $query->query['paged'],
            'totalItems' => $query->found_posts,
            'rpp' => $rpp
            
        );
        
        echo json_encode($data);
        exit;
        
        
        
        
        
        
        
        
        $found = false;
        
        
        $containers = array();
        $containers['pagination'] = '';
        if($query->post_count > 0) {
            $found = true;
            $containers['pagination'] = 
                $this->Model->paginate_links(array('prev_text' => '', 'next_text' => ''), $query);
        } else {
            $containers['posts'] = '<div class="empty_msg">No Post found.</div>';
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
        
        
        
    }
    
    function get() {
        
    }
    
    function update() {
        
    }
    
    
    function delete() {
        
    }
    
}