<?php

class KSM_CollaborationController extends KSM_BaseController {
    
    
    
    public $scripts = array(
        array('justifiedGallery', array('jquery')),
        array('collaboration', array('jquery', 'ksm_scripts', 'justifiedGallery'))
    );
    
    
    
    
    public $styles = array('justifiedGallery.min');
    
    
    
    
    public function ksm_index() {
        
        
        //$collaboration_type = $this->params['collaboration_type'] ? $this->params['collaboration_type'] : 'concept';
        //$collaboration_type = in_array($collaboration_type, $this->Model->collaboration_types) ? $collaboration_type : 'concept';
        
        
        
        //$p = get_post('1642');
        //pr(wp_get_post_terms($p->ID, 'ksm_tax_keyword'));
        //exit;
        
        $this->scripts[] = array('rateit/jquery.rateit.min', array('jquery'));
        $this->scripts[] = array('selectbox/jquery.selectbox-0.2.min', array('jquery'));
        
        $this->styles[] = 'rateit/rateit';
        
        $this->styles[] = 'selectbox/jquery.selectbox';
        
        
        
        //$this->set('collaboration_type', $collaboration_type);
        
        $this->set('collaboration_tab', 'join');
        
    }
    
    
    
    
    
    function ksm_ajax_filter()  {
        
        
        
        $sorts = array('newest', 'likes', 'views');
        
        $sort = $_POST['sort'];
        
        
        $sort_args = array('orderby' => 'date', 'order' => 'DESC');
        
        if($sort == 'likes') {
            $sort_args = array('meta_key' => 'likes_count', 'orderby' => 'meta_value_num', 'order' => 'DESC');
        } elseif($sort == 'views') {
            $sort_args = array('meta_key' => 'views_count','orderby' => 'meta_value_num', 'order' => 'DESC');
        }
        
        
        
        $page = $_POST['page'];
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        $args = array(
            'posts_per_page' => '20',
            'paged' => $page,
            'post_type' => 'ksm_collaboration',
            'post_status' => 'publish'
            );
        
        
        $args = array_merge($args , $sort_args);
        
        
        
        if($_POST['communication_rating'] || $_POST['artwork_rating']) {
            
            
            
            $args['ratings'] = array(
                'artwork' => $_POST['artwork_rating'] ? $_POST['artwork_rating'] : '',
                'communication' => $_POST['communication_rating'] ? $_POST['communication_rating'] : ''
            );
            
            
            
            
            
            
            
            //$authors = KSM_User::get_user_ids_by_collaboration_rating($_POST['rating']);
                    
            //if(empty($authors)) {
            //    echo json_encode(array('posts' => '<div class="empty_msg">No Post found.</div>', 'pagination' => ''));
            //    die();
            //} else {
            //    $args['author__in'] = $authors;
            //}
        }
        
        
        $types = array('concept', 'untextured');
        
        
        $type = ($_POST['type'] && in_array($_POST['type'], $types)) ? $_POST['type'] : '';
        
        
        if($type) {
            $meta_query[] = array(
                'key' => 'current_stage', 
                'value' => $type, 
                'compare' => '='
                );
        }
        
        $meta_query[] = array(
            'key' => 'can_user_submit_request', 
            'value' => 'yes', 
            'compare' => '='
            );
        
        
        $min_share = $_POST['min_share'];
        $max_share = $_POST['max_share'];
        
        $likes = $_POST['likes'];
        
        
        if($min_share && $max_share) {
            $meta_query[] = array(
                'key' => 'price',
                'value' => array($min_share, $max_share) ,
                'compare' => 'BETWEEN'
                );
        } else {
            
            if($min_share) {
            $meta_query[] = array(
                'key' => 'price',
                'value' => $min_share ,
                'compare' => '>='
                );
            } elseif($max_share) {
                $meta_query[] = array(
                    'key' => 'price',
                    'value' => $max_share ,
                    'compare' => '<='
                    );
            }
            
        }
        
        if($likes) {
            $meta_query[] = array(
                'key' => 'likes_count',
                'value' => $likes ,
                'compare' => '>=',
                'type' => 'NUMERIC'
                );
        
        }
        
        $tax_query = array();
        
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
        
        $args['meta_query'] = $meta_query;
        
        
        
        
        
        
        
        
        
        if($args['ratings']) add_filter('posts_join', array($this->Model, 'filter_join'), 10, 2);
        
        $query = new WP_Query( $args );
        
        if($args['ratings']) remove_filter('posts_join', array($this->Model, 'filter_join'), 10);
        
        
        
        $containers = array();
        ob_start();
        $found = false;
        
        while ( $query->have_posts() ) : 
            $found = true;
            $query->the_post();
            $this->render_element('post_item');
        endwhile;
        
        
        $containers['posts'] = ob_get_clean();
        
        $containers['pagination'] = 
                $this->Model->paginate_links(array('prev_text' => '', 'next_text' => ''), $query);
                
        
        
        $containers['found'] = $found;
        wp_reset_postdata();
        
        
        if($query->post_count == 0) {
            $containers['posts'] = '<div class="empty_msg">No Post found.</div>';
        }
        
        
        
        
        
        echo json_encode($containers);
        die();
    }
    
    
    
    
    function ksm_full_view() {
        $this->layout = 'colorbox';
        $this->styles[] = 'store';
        
        $id = $this->params['id'];
        
        if($id) {
            $args = array(
                'post__in' => array($id), 
                'post_type'=>'ksm_collaboration', 
                'limit'=> '1');
            $posts = new WP_Query($args);
        }
        
        
        if(!$posts) {
            exit;
        }
        
        
        $this->set('posts', $posts);
    }
    
    
    
    
    function ksm_launch() {
        $this->set('collaboration_tab', 'launch');
    }
    
    
    function ksm_concept_images() {
        
        
        $this->set('filter_action', 'Collaboration_launch_concepts_filter');
        $this->set('collaboration_tab', 'launch');
        $this->set('ltype', 'concept');
    }
    
    function ksm_model_images() {
        
        $this->set('filter_action', 'Collaboration_launch_models_filter');
        $this->set('collaboration_tab', 'launch');
        
        $this->set('ltype', 'model');
    }
    
    
    
    function ksm_ajax_launch_concepts_filter() {
        
        
        $user_id = get_current_user_id();
        
        if(!$user_id) {
            echo json_encode(array('posts' => '','pagination' => '', 'found' => false));
            die();
        }
        
        
        
        
        
        $page = $_POST['page'];
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        $args = array(
            'posts_per_page' => 12,
            'paged' => $page,
            'post_type' => 'attachment',
            'author' => $user_id,
            'orderby' => 'date', 
            'order' => 'DESC',
            'post_status' => array('inherit', 'publish'),
            'meta_query' => array(
                array(
                    'key' => 'user_upload_type', 
                    'value' => 'post_image', 
                    'compare' => '='
                    ),
                array(
                    'key' => 'not_attached', 
                    'compare' => 'NOT EXISTS'
                    )
                ),
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'ksm_tax_topic',
                    'field' => 'name',
                    'terms' => 'concept'
                )
            )
            
            );
        
        
        
        $query = new WP_Query( $args );
        
        
        
        $containers = array();
        ob_start();
        $found = false;
        
        while ( $query->have_posts() ) : 
            $found = true;
            $query->the_post();
            $this->render_element('concept_image_item');
        endwhile;
        
        
        $containers['posts'] = ob_get_clean();
        
        $containers['pagination'] = 
                $this->Model->paginate_links(array('prev_text' => '', 'next_text' => ''), $query);
                
        
        
        $containers['found'] = $found;
        wp_reset_postdata();
        
        
        if($query->post_count == 0) {
            $containers['posts'] = '<div class="empty_msg">No Concept Image found.</div>';
        }
        
        
        
        
        
        echo json_encode($containers);
        
    }
    
    
    
    
    
    
    function ksm_ajax_launch_models_filter() {
        
        
        $user_id = get_current_user_id();
        
        if(!$user_id) {
            echo json_encode(array('posts' => '','pagination' => '', 'found' => false));
            die();
        }
        
        
        
        
        
        $page = $_POST['page'];
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        $args = array(
            'posts_per_page' => 12,
            'paged' => $page,
            'post_type' => 'attachment',
            'author' => $user_id,
            'orderby' => 'date', 
            'order' => 'DESC',
            'post_status' => array('inherit', 'publish'),
            'meta_query' => array(
                array(
                    'key' => 'user_upload_type', 
                    'value' => 'post_image', 
                    'compare' => '='
                    ),
                array(
                    'key' => 'not_attached', 
                    'compare' => 'NOT EXISTS'
                    )
                ),
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'ksm_tax_topic',
                        'field' => 'name',
                        'terms' => 'model'
                    )
                )
            );
        
        
        
        $query = new WP_Query( $args );
        
        
        
        $containers = array();
        ob_start();
        $found = false;
        
        while ( $query->have_posts() ) : 
            $found = true;
            $query->the_post();
            $this->render_element('model_image_item');
        endwhile;
        
        
        $containers['posts'] = ob_get_clean();
        
        $containers['pagination'] = 
                $this->Model->paginate_links(array('prev_text' => '', 'next_text' => ''), $query);
                
        
        
        $containers['found'] = $found;
        wp_reset_postdata();
        
        
        if($query->post_count == 0) {
            $containers['posts'] = '<div class="empty_msg">No Model Image found.</div>';
        }
        
        
        
        
        
        echo json_encode($containers);
        
    }
    
}
?>