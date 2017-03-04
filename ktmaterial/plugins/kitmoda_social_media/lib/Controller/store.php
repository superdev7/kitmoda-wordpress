<?php

class KSM_StoreController extends KSM_BaseController {
    
    
    
    public $scripts = array(
        array('jquery.selectBoxIt', array('jquery', 'jquery-ui-widget')),
        array('justifiedGallery', array('jquery')),
        array('store', array('jquery', 'ksm_scripts', 'angular' ,'jquery.selectBoxIt', 'justifiedGallery')),
        array('selectbox/jquery.selectbox-0.2.min', array('jquery', 'ksm_scripts')),
        array('jquery.mCustomScrollbar.concat.min', array('jquery', 'ksm_scripts')),
        array('custom', array('jquery')),
    );
    
    
    public $styles = array('jquery.selectBoxIt', 'justifiedGallery.min', 'selectbox/jquery.selectbox');
    
    
    
            
            
            
    
    public function ksm_index() {
        
        $this->scripts[] = array('jScrollPane', array('jquery'));
        $this->scripts[] = array('SelectBox', array('jquery'));
        $this->scripts[] = array('custom', array('jquery'));
        
        
        $this->styles[] = 'jquery.jscrollpane';
        $this->styles[] = 'customSelectBox';
    }
    
    
    public function ksm_search() {
        
        
    }
    
    public function ksm_download() {
        $id = $this->params['id'];
        
        $posts = null;
        
        if($id) {
            $args = array(
                'post__in' => array($id), 
                'post_type'=>'download', 
                'post_status' => 'any',
                'limit'=> '1');
            $posts = new WP_Query($args);
        }
        
        
        $this->set('posts', $posts);
        
    }
    
    public function ksm_ajax_getTrending() {
        
        $page = $_POST['p'];
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        $sort_args = array('meta_key' => 'trending','orderby' => 'meta_value_num', 'order' => 'DESC');
        
        $args = array(
            'posts_per_page' => 10,
            'paged' => $page,
            'post_type' => $this->Model->post_type,
            'post_status' => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'trending',
                    'value' => '0',
                    'compare' => '>',
                ),
            )
        );
        
        
        $args = array_merge($args , $sort_args);
        $query = new WP_Query( $args );
        
        $containers = array();
        $found = false;
        
        
        
        ob_start();
        while ( $query->have_posts() ) : $query->the_post();
            $found = true;
            $this->render_element('grid_item');
        endwhile;
        
        $containers['content'] = ob_get_clean();
        
        $containers['pagination'] = 
                $this->Model->paginate_links(array('prev_text' => '', 'next_text' => ''), $query);
        
        
        wp_reset_postdata();
        
        
        if($query->post_count == 0) {
            $containers['content'] = '<div class="empty_msg">No product found.</div>';
        }
        
        $containers['found'] = $found;
        
        echo json_encode($containers);
    }
    
    public function ksm_ajax_getTopSelling() {
        $page = $_POST['p'];
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        $sort_args = array('meta_key' => '_edd_download_earnings','orderby' => 'meta_value_num', 'order' => 'DESC');
        
        $args = array(
            'posts_per_page' => 10,
            'paged' => $page,
            'post_type' => $this->Model->post_type,
            'post_status' => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => '_edd_download_earnings',
                    'value' => '0',
                    'compare' => '>',
                ),
            )
        );
        
        
        $args = array_merge($args , $sort_args);
        $query = new WP_Query( $args );
        
        $containers = array();
        $found = false;
        
        
        
        ob_start();
        while ( $query->have_posts() ) : $query->the_post();
            $found = true;
            $this->render_element('grid_item');
        endwhile;
        
        $containers['content'] = ob_get_clean();
        
        $containers['pagination'] = 
                $this->Model->paginate_links(array('prev_text' => '', 'next_text' => ''), $query);
        
        
        wp_reset_postdata();
        
        
        if($query->post_count == 0) {
            $containers['content'] = '<div class="empty_msg">No product found.</div>';
        }
        
        $containers['found'] = $found;
        
        echo json_encode($containers);
    }
    
    public function ksm_ajax_getTopRated() {
        $page = $_POST['p'];
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        $sort_args = array('meta_key' => 'rating_coefficient','orderby' => 'meta_value_num', 'order' => 'DESC');
        
        $args = array(
            'posts_per_page' => 10,
            'paged' => $page,
            'post_type' => $this->Model->post_type,
            'post_status' => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'rating_coefficient',
                    'value' => '0',
                    'compare' => '>',
                ),
            )
        );
        
        
        $args = array_merge($args , $sort_args);
        $query = new WP_Query( $args );
        
        $containers = array();
        $found = false;
        
        
        
        ob_start();
        while ( $query->have_posts() ) : $query->the_post();
            $found = true;
            $this->render_element('grid_item');
        endwhile;
        
        $containers['content'] = ob_get_clean();
        
        $containers['pagination'] = 
                $this->Model->paginate_links(array('prev_text' => '', 'next_text' => ''), $query);
        
        
        wp_reset_postdata();
        
        
        if($query->post_count == 0) {
            $containers['content'] = '<div class="empty_msg">No product found.</div>';
        }
        
        $containers['found'] = $found;
        
        echo json_encode($containers);
    }
    
    
    public function ksm_ajax_getNewest() {
        $page = $_POST['p'];
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        
        
        $args = array(
            'posts_per_page' => 10,
            'paged' => $page,
            'post_type' => $this->Model->post_type,
            'orderby' => 'date', 
            'order' => 'DESC',
            'post_status' => 'publish'
        );
        
        
        
        $query = new WP_Query( $args );
        
        $containers = array();
        $found = false;
        
        
        ob_start();
        while ( $query->have_posts() ) : $query->the_post();
            $found = true;
            $this->render_element('grid_item');
        endwhile;
        
        $containers['content'] = ob_get_clean();
        
        $containers['pagination'] = 
                $this->Model->paginate_links(array('prev_text' => '', 'next_text' => ''), $query);
        
        
        wp_reset_postdata();
        
        
        if($query->post_count == 0) {
            $containers['content'] = '<div class="empty_msg">No product found.</div>';
        }
        
        $containers['found'] = $found;
        
        echo json_encode($containers);
    }
    
    
    public function ksm_ajax_filter_posts() {
        
        
        $list_taxonomies = array(
            'price',
            'style',
            'era',
            'file_format',
            'game_ready',
            'print_ready',
            'environment',
            'model_quads',
            'world_scale',
            'poly_count',
            'texturing_method',
            'mapping',
            'lighting',
            'renderer'
            );
        
        
        
        
        
        $tax_filters = array();
        
        foreach($list_taxonomies as $t) {
            if($_POST[$t]) {
                $_tax = new KSM_Taxonomy($t);
                foreach ((Array) $_POST[$t] as $trm) {
                    if($_tax->term_exists($trm)) {
                        $tax_filters[$_tax->key][] = $trm;
                    }
                }
            }
        }
        
        
        
        
        
        $cat = $_POST['cat'];
        
        $breadcrumb = store_search_breadcrumb($cat);
         
        
        
        
        $tax_terms = array();
        $sort_args = array();
        
        
        
        
        $sorts = array('price', 'rating', 'trending', 'top_selling');
        $sort = $_POST['sort'];
        $sort_args = array('orderby' => 'date', 'order' => 'DESC');
        
        
        if($sort == 'price') {
            $sort_args = array('meta_key' => 'edd_price', 'orderby' => 'meta_value_num', 'order' => 'DESC');
        } elseif($sort == 'rating') {
            $sort_args = array('meta_key' => 'product_rating','orderby' => 'meta_value_num', 'order' => 'DESC');
        } elseif($sort == 'trending'){
            $sort_args = array('meta_key' => 'trending','orderby' => 'meta_value_num', 'order' => 'DESC');
        } else if($sort == 'top_selling') {
            $sort_args = array('meta_key' => '_edd_download_earnings','orderby' => 'meta_value_num', 'order' => 'DESC');
        }
        
        
        $tax_query = array();
        
        
        if($tax_filters) {
            foreach($tax_filters as $k => $v) {
                $tax_query[] = array(
                    'taxonomy' => $k,
                    'field' => 'name',
                    'terms' => $v);
            }
        }
        
        if($cat) {
            $tax_query[] = array(
                'taxonomy' => 'category',
                'field' => 'id',
                'terms' => $cat);
        }
        
        
        $page = $_POST['page'];
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        $args = array(
            'posts_per_page' => COMMUNITY_POSTS_PER_PAGE,
            'paged' => $page,
            'post_type' => $this->Model->post_type,
            'post_status' => 'publish'
            
            
            );
        
        
        $args = array_merge($args , $sort_args);
        
        
        
        if(!empty($tax_query)) 
            $args['tax_query'] = $tax_query;
        
        
        
        
        
        if($_POST['q']) {
            $args['s'] = $_POST['q'];
        }
        
        
        
        //pr($args);
        //exit;
        
        $query = new WP_Query( $args );
        
        
        
        
        $containers = array();
        
        
        $containers['breadcrumb'] = $breadcrumb;
        
        
        ob_start();
        
        
        $found = false;
        
        while ( $query->have_posts() ) : $query->the_post();
            $found = true;
            $this->render_element('grid_item');
        endwhile;
        
        //$this->render_element('grid');
        
        $containers['posts'] = ob_get_clean();
        
        $containers['pagination'] = 
                $this->Model->paginate_links(array('prev_text' => '', 'next_text' => ''), $query);
                
        
        
        
        wp_reset_postdata();
        
        
        if($query->post_count == 0) {
            $containers['posts'] = '<div class="empty_msg">No product found.</div>';
        }
        
        $containers['found'] = $found;
        
        
        
        echo json_encode($containers);
    }
    
    
    function post_comment() {
        
        
        $comment = sanitize_text_field($_POST['comment']);
        $post_id = $_POST['_id'];
        
        $args = array(
            'user'=> $this->KUser->Auth,
            'post_id' => $post_id,
            'comment' => $comment
        );
        
        $result = $this->Model->submit_comment($args);
        
        if($result['error']) {
            KSM_Js::setCommunityCommentError($post_id, $result['error']);
            die();
        } elseif($result['success']) {
            $comment_id = $result['comment_id'];
            $wpc = get_comment($comment_id);
            ob_start();
            $this->render_element('comment_item', array('comment' => $wpc));
            $comment_item_html = ob_get_clean();
            $comment_item_html = preg_replace( "/\r|\n/", "", $comment_item_html );
            KSM_Js::addCommunityComment($post_id, $comment_item_html);
        }
    }
    
//    public function ksm_ajax_get_subcats() {
//        pr($_POST);
//    }
    
}
?>