<?php

class KSM_StoreController extends KSM_BaseController {

    public $scripts = array(
        array('jquery.selectBoxIt', array('jquery', 'jquery-ui-widget')),
        array('justifiedGallery', array('jquery')),
        array('selectbox/jquery.selectbox-0.2.min', array('jquery', 'ksm_scripts')),
        array('jquery.mCustomScrollbar.concat.min', array('jquery', 'ksm_scripts')),
        array('custom', array('jquery', 'angular',  'ksm_scripts')),
        array('store', array('jquery', 'ksm_scripts','components-common' , 'angular' ,'jquery.selectBoxIt', 'justifiedGallery')),
    );

    public $styles = array('jquery.selectBoxIt', 'justifiedGallery.min', 'selectbox/jquery.selectbox');
    
    protected $default_text = "<div class='empty_msg'>Hmm... We currently don't have a 3D model matching that description. Our community is growing fast so check back soon for that model!</div>";


    public function breadcrumbs($search_id,$taxonomy){
        $parent  = get_term_by( 'id', $search_id, $taxonomy);
        $arr = array();
        $i=0;
        $first_name = $parent->name;
        $arr_id[$i] = $parent->term_id;
        $arr[$i] =$parent->name;
        $i += 1;

        while ((int)$parent->parent != 0){
            $id = $parent->parent;
            $parent  = get_term_by( 'id', $id, $taxonomy);
            $arr_id[$i] = $parent->term_id;
            $parent->name = str_replace('&amp;', '&', $parent->name);
            $arr[$i] =$parent->name;
            $i += 1;
        }

        $arr_id[$i] = '';
        $arr[$i] ='';

        if($taxonomy == 'ksm_tax_style'){
            $res = "'no','no','no','{$first_name}'";
        }else {
            $ids = base64_encode(json_encode(array_reverse($arr_id)));
            $names = base64_encode(json_encode(array_reverse($arr)));
            $res = "'{$search_id}','{$ids}','{$names}'";
        }
        return $res;
    }


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
            $containers['content'] = $this->default_text;
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
            $containers['content'] = $this->default_text;
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
            $containers['content'] = $this->default_text;
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
            $containers['content'] = $this->default_text;
        }
        
        $containers['found'] = $found;
        
        echo json_encode($containers);
    }
    
    //Filter posts
    public function ksm_ajax_filter_posts() {

        $list_taxonomies = array(
            'price',
            'style',
            'culture',
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
            'renderer',
            'model_angular'
            );

        if(sizeof($_POST['style']) > 0) {
            $tmp_is_all = 0;
            for ($i = 0; $i < sizeof($_POST['style']); $i++) {
                if ($_POST['style'][$i] == 'all') {
                    $tmp_is_all = 1;
                }
            }
            if ($tmp_is_all == 1) {
                $arr_tax_styles = KSM_Taxonomy::custom_list(array('tax' => 'style'));
                $tmp_i = 0;
                $_POST['style'] = array();
                foreach ($arr_tax_styles as $key => $tax_style) {
                    $_POST['style'][] = $tax_style;
                    $tmp_i++;
                }
            }
        }
        if(sizeof($_POST['culture']) > 0) {
            $tmp_is_all = 0;
            for ($i = 0; $i < sizeof($_POST['culture']); $i++) {
                if ($_POST['culture'][$i] == 'none/general' || $_POST['culture'][$i] == 'all') {
                    $tmp_is_all = 1;
                }
            }
            if ($tmp_is_all == 1) {
                $arr_tax_cultures = KSM_Taxonomy::custom_list(array('tax' => 'culture'));
                $tmp_i = 0;
                $_POST['culture'] = array();
                foreach ($arr_tax_cultures as $key => $tax_culture) {
                    $_POST['culture'][] = $tax_culture;
                    $tmp_i++;
                }
            }
        }
        if(sizeof($_POST['file_format']) > 0) {
            $tmp_is_all = 0;
            for ($i = 0; $i < sizeof($_POST['culture']); $i++) {
                if ($_POST['file_format'][$i] == 'all') {
                    $tmp_is_all = 1;
                }
            }
            if ($tmp_is_all == 1) {
                $arr_tax_cultures = KSM_Taxonomy::custom_list(array('tax' => 'file_format'));
                $tmp_i = 0;
                $_POST['file_format'] = array();
                foreach ($arr_tax_cultures as $key => $tax_culture) {
                    $_POST['file_format'][] = $tax_culture;
                    $tmp_i++;
                }
            }
        }
        if(sizeof($_POST['game_ready']) > 0) {
            $tmp_is_all = 0;
            for ($i = 0; $i < sizeof($_POST['game_ready']); $i++) {
                if ($_POST['game_ready'][$i] == 'all') {
                    $tmp_is_all = 1;
                }
            }
            if ($tmp_is_all == 1) {
                $_POST['game_ready'] = array();
                $_POST['print_ready'] = array('yes');
                $options = KSM_DataStore::Terms('game_ready', null, null);
                foreach ($options as $key => $value) {
                    if(isset($value['filterable']) && $value['filterable'] == false){
                        continue;
                    }else {
                        if($value['filter_label'] == 'GAME READY (MOBILE DEV)' ||
                            $value['filter_label'] == 'GAME READY (MID GEN)' ||
                            $value['filter_label'] == 'GAME READY (NEXT GEN)'){
                            $_POST['game_ready'][] = $key;
                        }
                    }
                }
            }
        }
        if(sizeof($_POST['model_angular']) > 0) {
            $tmp_is_all = 0;
            for ($i = 0; $i < sizeof($_POST['model_angular']); $i++) {
                if ($_POST['model_angular'][$i] == 'all') {
                    $tmp_is_all = 1;
                }
            }
            if ($tmp_is_all == 1) {
                $_POST['model_angular'] = array();
                $options = KSM_DataStore::Terms('model_angular', null, null);
                foreach ($options as $key => $value) {
                    if(isset($value['filterable']) && $value['filterable'] == false){
                        continue;
                    }else {
                        if($value['filter_label'] == 'All Triangulated' ||
                            $value['filter_label'] == 'ALL QUADS' ||
                            $value['filter_label'] == 'OVER 90% QUADS'){
                            $_POST['model_angular'][] = $key;
                        }
                    }
                }
            }
        }
        if(sizeof($_POST['model_scale']) > 0) {
            $tmp_is_all = 0;
            $tmp_is_no = 0;
            for ($i = 0; $i < sizeof($_POST['model_scale']); $i++) {
                if ($_POST['model_scale'][$i] == 'yes') {
                    $tmp_is_all = 1;
                }
                if ($_POST['model_scale'][$i] == 'no') {
                    $tmp_is_no = 1;
                }
            }
            if ($tmp_is_all == 1) {
                $_POST['world_scale'] = array('yes');
            }
            else if ($tmp_is_no == 1) {
                $_POST['world_scale'] = array('no');
                }
        }

/*
All --> all textured + none
None --> not related to any of presented in code 4 categories: Hand-painted; Photographs; Procedural; Hybrid.
Textured --> all of Hand-painted; Photographs; Procedural; Hybrid.
Textured(hand-painted) --> that have hand painted option
textured (photographs) --> that have photographs option
*/
$tmp_is_all = 0;
$tmp_is_none = 0;
        if(sizeof($_POST['texturing_status']) > 0) {
            $tmp_is_textured = 0;
            $tmp_is_all = 0;
            $tmp_is_none = 0;
            for ($i = 0; $i < sizeof($_POST['texturing_status']); $i++) {
                if ($_POST['texturing_status'][$i] == 'textured') {
                    $tmp_is_textured = 1;
                }
                if ($_POST['texturing_status'][$i] == 'all') {
                    $tmp_is_all = 1;
                }
                if ($_POST['texturing_status'][$i] == 'none') {
                    $tmp_is_none = 1;
                }
            }
            if ($tmp_is_textured == 1) {
                $_POST['texturing_method'] = array();
                $options = KSM_DataStore::Terms('texturing_method', null, null);
                foreach ($options as $key => $value) {
                    $_POST['texturing_method'][] = $key;
                }
            }else if ($tmp_is_all == 1) {
                $_POST['texturing_method'] = array();
                $options = KSM_DataStore::Terms('texturing_method', null, null);
                foreach ($options as $key => $value) {
                    $_POST['texturing_method'][] = $key;
                }
            }else if ($tmp_is_none == 1) {
                $_POST['texturing_method'] = array();
                $options = KSM_DataStore::Terms('texturing_method', null, null);
                foreach ($options as $key => $value) {
                    $_POST['texturing_method'][] = $key;
                }
            }else{
                $_POST['texturing_method'] = $_POST['texturing_status'];
            }
            unset($_POST['texturing_status']);
        }


        if(sizeof($_POST['mapping']) > 0) {
            $tmp_is_none = 0;
            for ($i = 0; $i < sizeof($_POST['mapping']); $i++) {
                if ($_POST['mapping'][$i] == 'none') {
                    $tmp_is_none = 1;
                }
            }
            if ($tmp_is_none == 1) {
                unset($_POST['mapping']);
            }
        }
        if(sizeof($_POST['lighting']) > 0) {
            $tmp_is_none = 0;
            for ($i = 0; $i < sizeof($_POST['lighting']); $i++) {
                if ($_POST['lighting'][$i] == 'none') {
                    $tmp_is_none = 1;
                }
            }
            if ($tmp_is_none == 1) {
                unset($_POST['lighting']);
            }
        }


        if(isset($_POST['environment'])){
            if($_POST['environment'] == 'show both'){
                $_POST['environment'] = array('yes','no');
            }
            if($_POST['environment'] == 'full environment'){
                $_POST['environment'] = array('yes');
            }
            if($_POST['environment'] == 'single object'){
                $_POST['environment'] = array('no');
            }
        }

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
                if($k == 'ksm_tax_texturing_method' && $tmp_is_all == 1){
                    $tax_query[] = array(
                            'taxonomy' => $k,
                            'field' => 'slug',
                            'operator' => 'EXISTS',
                    );
                }
                else if($k == 'ksm_tax_texturing_method' && $tmp_is_none == 1){
                    $tax_query[] = array(
                        array(
                            'taxonomy' => $k,
                            'field' => 'slug',
                            'operator' => 'EXISTS',
                        ),
                        array(
                            'taxonomy' => $k,
                            'field' => 'slug',
                            'terms' => $v,
                            'operator' => 'NOT IN',
                        ),
                        'relation' => 'AND'
                    );
                }else{
                    $tax_query[] = array(
                        'taxonomy' => $k,
                        'field' => 'slug',
                        'terms' => $v
                    );
                }


            }
        }

        if($cat == 'all'){
            $arr_cats_primary = KSM_Taxonomy::custom_list(array('orderby' => 'term_id', 'order' => 'ASC'));

            $tmp_arr_tx = [];
            foreach($arr_cats_primary as $k => $v) {
                $tmp_arr_tx[] = $k;
            }

            $tax_query[] = array(
                'taxonomy' => 'category',
                'field' => 'id',
                'terms' => $tmp_arr_tx
            );
        }else {
            if ($cat) {
                $tax_query[] = array(
                    'taxonomy' => 'category',
                    'field' => 'id',
                    'terms' => $cat);
            }
        }

        $page = $_POST['page'];
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        $args = array(
            'posts_per_page' => COMMUNITY_POSTS_PER_PAGE,
            'paged' => $page,
            'post_type' => $this->Model->post_type,
            'post_status' => 'publish'
        );

        if($_POST['price_min'] == "NaN"){
            $price_min = 0;
        }else{
            $price_min = $_POST['price_min'];
        }
        if($_POST['price_max'] == "NaN"){
            $price_max = 999999;
        }else{
            $price_max = $_POST['price_max'];
        }
        
            $args['meta_query'] = array(
                'relation' => 'AND',
            
                array(
                'key' => 'edd_price',
                'value' => array($price_min, $price_max),
                'type' => 'numeric',
                'compare' => 'BETWEEN',
            ),
        ); 

        if(isset($_POST['pr_rating'])){
            $args['meta_query'][] = array(
                    'key' => 'rating_coefficient',
                    'value' => $_POST['pr_rating'],
                    'compare' => '>=',
            );
        }
//        print_r($args);exit;

//        If action is SEARCH. For example, keywords are car sports red big v8 auto
        if( !empty($_POST['q']) ) {
//            $args['s'] = $_POST['q'];
            $search_terms = preg_split("/[^\w]*([\s]+[^\w]*|$)/", $_POST['q'], -1, PREG_SPLIT_NO_EMPTY);   
            
            global $wpdb;
            
            $sql = "SELECT SQL_CALC_FOUND_ROWS  $wpdb->posts.ID FROM $wpdb->posts";
            $where = "WHERE 1=1 AND ($wpdb->posts.post_password = '')  AND $wpdb->posts.post_type = '{$this->Model->post_type}' AND (($wpdb->posts.post_status = 'publish'))";
            $join = '';
            $like = '';
            $group_by = " GROUP BY $wpdb->posts.ID";
            $order_by = " ORDER BY $wpdb->posts.post_date DESC";
            $limit = " LIMIT 0, ". COMMUNITY_POSTS_PER_PAGE;
            
            // For tax_query                
            $tax_query[] = array(
                    'taxonomy' => 'ksm_tax_keyword',
                    'field' => 'slug',
                    'terms' => $search_terms
            );

            $new_tax_query = new WP_Tax_Query( $tax_query );
            $clauses = $new_tax_query->get_sql( $wpdb->posts, 'ID' );
            $join .= $clauses['join'];
            $where .= $clauses['where'];
            
            // Add meta data query
            $join .= " INNER JOIN mqucz_postmeta AS mt1 ON ( $wpdb->posts.ID = mt1.post_id ) ";
            
            // For meta_query
            if(isset($_POST['pr_rating'])){
                    $join .= " INNER JOIN $wpdb->postmeta ON ( $wpdb->posts.ID = $wpdb->postmeta.post_id ) \n ";
                    $where .= " AND ( $wpdb->postmeta.meta_key = 'rating_coefficient' AND CAST($wpdb->postmeta.meta_value AS CHAR) >= '{$_POST['pr_rating']}' ) \n ";
            }      
            // For post's title and content
            if( !empty($search_terms) ){
//                    $like = " AND ( $wpdb->posts.post_title LIKE '%{$search_terms[0]}%' OR $wpdb->posts.post_content LIKE '%{$search_terms[0]}%' \n";
                    
                    if( count($search_terms) > 1 ){
                            for($i=1; $i < count($search_terms); $i++){
//                                $like .= " OR $wpdb->posts.post_title LIKE '%{$search_terms[$i]}%' OR $wpdb->posts.post_content LIKE '%{$search_terms[$i]}%' \n";
                            }
                    }
//                    $like .= ')';
            }

            $where .= " AND ( mt1.meta_key = 'edd_price' AND CAST(mt1.meta_value AS SIGNED) BETWEEN {$price_min} AND {$price_max} ) ";

            $sql.= $join.$where.$like.$group_by.$order_by.$limit;
//echo $sql;exit;
            $arr_posts = (array)$wpdb->get_results($sql);
            $post_count = count($arr_posts);
            
        // OR other actions
        }else{
            if(!empty($tax_query)){
                $args['tax_query'] = $tax_query;
            }
            $args = array_merge($args , $sort_args);
            $args['tax_query']['relation'] = 'AND';
            $query = new WP_Query( $args );
            $arr_posts = $query->posts;
            
            if(isset($query->post_count)) {
                $post_count = $query->post_count;
            }else{
                $post_count = 0;
            }
        }
                
        $containers = array();

        $posts = '';
        for($i=0; $i < $post_count; ++$i){
            $thumbnail_id = get_post_thumbnail_id($arr_posts[$i]->ID);
            if( $thumbnail_id != false){
                $grid_img = get_image_src($thumbnail_id, 'gallery_grid');
                $permalink = ksm_get_permalink("store/download/{$arr_posts[$i]->ID}");
                $imagesize = getimagesize($grid_img);

                $posts .= "<a class='item' data-w='{$imagesize[0]}' data-h='{$imagesize[1]}' href='{$permalink}/'><img src='{$grid_img}'></a>";
            }
        }
        
        $containers['posts'] = $posts;

        $containers['pagination'] = 
                $this->Model->paginate_links(array('prev_text' => '', 'next_text' => ''), $query);

        
        wp_reset_postdata();
        
        
        if($post_count == 0) {
            $containers['posts'] = $this->default_text;
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
    
    //Selected downloads
    public function ksm_ajax_get_selected_downloads(){
        $data = array('result' => false, 'html' => '');
//        
//        $def_count = 10;
//        $ksm_store_settings = get_option('ksm_store_settings') ? get_option('ksm_store_settings') : array();
//        $download_count = !empty($ksm_store_settings['download']['count']) ? $ksm_store_settings['download']['count'] : $def_count;
//        $download_list = !empty($ksm_store_settings['download']['list']) ? $ksm_store_settings['download']['list'] : $def_count;
//
//        if( count($download_list) > $download_count ){ 
//            array_splice($download_list, $download_count);            
//        }
//        
//        if( !empty($download_list) ){
//                $html = '';
//                foreach ($download_list as $key => $post_id) {
//
//                        $thumbnail_attributes = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' ); //url, width, height
//                        if($thumbnail_attributes){
//                            $width = $thumbnail_attributes[1] > $thumbnail_attributes[2] ? '400' : '267';
//                            $height = $thumbnail_attributes[1] > $thumbnail_attributes[2] ? '267' : '400';
//                            $html .= '<a href="'. get_permalink( $post_id ) .'"> <img src="'. $thumbnail_attributes[0] .'" width="'. $width .'" height="'. $height .'"/></a>';
//                        }
//                }
//                $data = array('result' => true, 'html' => $html);
//        }    

        $args = array(
            'posts_per_page'=> 10,
            'post_type'     => $this->Model->post_type,
            'orderby'       => 'date', 
            'order'         => 'DESC',
            'post_status'   => 'publish'
        );
        $arr_posts = get_posts($args);
        if( !empty($arr_posts) ){
            foreach ($arr_posts as $key => $obj_post) {
                $grid_img_attributes = wp_get_attachment_image_src( get_post_thumbnail_id($obj_post->ID), 'gallery_grid' );
                if($grid_img_attributes){
                        $width = $grid_img_attributes[1] > $grid_img_attributes[2] ? '400' : '267';
                        $height = $grid_img_attributes[1] > $grid_img_attributes[2] ? '267' : '400';
                        $html .= '<a href="'. ksm_get_permalink("store/download/{$obj_post->ID}") .'/" class="item" data-w="'. $width .'" data-h="'. $height .'"><img src="'. $grid_img_attributes[0] .'" alt=""/></a>';
                }
            }
            $data = array('result' => true, 'html' => $html);
        }else{
            $data['html'] = $this->default_text;
        }
        
        exit(json_encode($data));
        
    }
    
    //FEATURED CATEGORIES
    public function ksm_ajax_get_cats_featured() {
            $data = array('result' => false, 'html' => '');
            
            $def_count = 10;
            $ksm_store_settings = get_option('ksm_store_settings') ? get_option('ksm_store_settings') : array();
            $feat_cats_count = !empty($ksm_store_settings['feat_cats']['count']) ? $ksm_store_settings['feat_cats']['count'] : $def_count;
            $feat_cats_list = !empty($ksm_store_settings['feat_cats']['list']) ? $ksm_store_settings['feat_cats']['list'] : array();

            if( count($feat_cats_list) > $feat_cats_count ){ 
                array_splice($feat_cats_list, $feat_cats_count);            
            }

            $html = '';
            if( !empty($feat_cats_list) ){
                
                    $terms = get_terms( 'category', array(
                                        'hide_empty' => false,
                                        'fields'     => 'id=>slug',
                                        'include'    => implode(",", $feat_cats_list)
                    ) );               
                    if( !empty($terms) ){
                            $def_img = ksm_get_default_term_image();

                            foreach ($terms as $key => $term) {

                                    $res = ksm_get_term_image($key);
                                    $res = ( $res != false ) ? $res : $def_img;
                                    $html .= '<a href="'. home_url('category/'.$term) .'" class="single-category"><img src="'. $res .'" alt="pict"></a>';                    
                            }
                            $data = array('result' => true, 'html' => $html);
                    }                    
            }
            
            exit(json_encode($data));        
    }
    
    //ART STYLES
    public function ksm_ajax_get_styles() {
            $data = array('result' => false, 'html' => '');
            
            $def_count = 10;
            $ksm_store_settings = get_option('ksm_store_settings') ? get_option('ksm_store_settings') : array();
            $art_styles_count = !empty($ksm_store_settings['art_styles']['count']) ? $ksm_store_settings['art_styles']['count'] : $def_count;
            $art_styles_list = !empty($ksm_store_settings['art_styles']['list']) ? $ksm_store_settings['art_styles']['list'] : array();

            if( count($art_styles_list) > $art_styles_count ){ 
                array_splice($art_styles_list, $art_styles_count);            
            } 

            $html = '';
            if( !empty($art_styles_list) ){
                
                    $terms = get_terms( 'ksm_tax_style', array(
                                        'hide_empty' => false,
                                        'fields'     => 'id=>slug',
                                        'include'    => implode(",", $art_styles_list)
                    ) );
                    if( !empty($terms) ){
                            $def_img = ksm_get_default_term_image();
                    
                            foreach ($terms as $key => $term) {

                                    $res = ksm_get_term_image($key);
                                    $res = ( $res != false ) ? $res : $def_img;
                                    $html .= '<a href="'. home_url('ksm_tax_style/'.$term) .'" class="single-category"><img src="'. $res .'" alt="pict"></a>';                    
                            }
                            $data = array('result' => true, 'html' => $html);
                    }
            }
            
            exit(json_encode($data));        
    }
    
}
?>