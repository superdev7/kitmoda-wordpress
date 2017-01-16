<?php

define('KSM_GALLERY_RESULTS_PER_PAGE', 20);

class KSM_mvgHelper {
    
    public $galleries = array();
    
    public function __construct($args = array()) {
        
        $galleries = $args['galleries'];
        
        
        
        foreach($galleries as $g => $params) {
            $g_class = 'KSM_MultiViewGallery_'.ucfirst($g);
            if(class_exists($g_class)) {
                $gallery = new $g_class($params);
                //$gallery->init();
                //if($gallery->total_results > 0) {
                    $this->galleries[$g] = $gallery;
                //}
            }
        }
        
    }
    
    
    public function design() {
        
        foreach($this->galleries as $g) {
            $g->design();
        }
        
    }
    
    
    public function render() {
        echo '<div class="multi_view_galleries">
            <div class="loading">
            <div class="goverlay"></div>';
        include KSM_VIEWS_PATH.'__Element/loading.php';
        echo '</div>';
        
        foreach($this->galleries as $g) {
            $g->load();
        }
        
        echo '</div>';
    }
    
    
    
    public function ajaxLoad($page, $type) {
        
        $result = array();
        foreach($this->galleries as $g) {
            $result[$g->name] = $g->ajaxLoad($page, $type);
        }
        
        return $result;
    }
    
    
}





class KSM_MultiViewGallery {
    
    public $rpp,
           $user_id,
           $name,
           $results,
           $total_results,
            
           $share_post = 'parent',
            
           $count_mini_grid_view = true,
           $count_grid_view = true,
           $count_full_view = true,
            
           $path = ''
            ;
    
    public function __construct($args = array()) {
        
        //if($args['user_id']) {
        //    $this->user = get_user_by('id', $args['user_id']);
        //}
        
        $this->user_id = $args['user_id'];
        
        $this->name = $args['name'];
        $this->rpp = KSM_GALLERY_RESULTS_PER_PAGE;
        
        $this->path = 'kmvg' . DIRECTORY_SEPARATOR;
        
    }
    
    
    public function design() {
        ?>
        <div class="ksm_gallery_multi_views gallery <?=$this->name?>_gallery" data-name="<?=$this->name?>" data-item="<?=$this->user->ID?>" data-pages="<?=$this->total_pages?>">
        <?php
            include $this->path.'empty_message.php';
            include $this->path.'mini_grid.php';
            include $this->path.'grid.php';
            include $this->path.'full.php';
        ?>
        </div>
      <?php  
    }
    
    
    public function getGridImage($post) {
        return get_image_src($post->image, 'gallery_grid');
    }
    
    public function getFullImage($post) {
        return get_image_src($post->image, 'full');
    }
    
    public function getTinyImage($post) {
        return get_image_src($post->image, 'avatar_small_2');
    }
    
    
    public function init($page = 1) {
        $this->results = $this->Results($page);
        $this->total_pages = ceil($this->total_results / $this->rpp);
        $this->hash_location = "{$this->hash_name}_{$this->current_page}";
    }
    
    
    
    public function load() {
        ?>
        <div class="ksm_gallery_multi_views gallery <?=$this->name?>_gallery" data-name="<?=$this->name?>" data-item="<?=$this->user->ID?>" data-pages="<?=$this->total_pages?>">
        <?php
            include $this->path.'empty_message.php';
            include $this->path.'mini_grid.php';
            include $this->path.'grid.php';
            include $this->path.'full.php';
        ?>
        </div>
      <?php  
    }
    
    
    
    
    public function renderGridItem($p, $item_index = 0) {
        ob_start();
        include $this->path.'grid_item.php';
        return ob_get_clean();
    }
    
    public function renderFullItem($p) {
        ob_start();
        include $this->path.'full_item.php';
        return ob_get_clean();
    }
    
    
    public function renderFullThumbItem($p) {
        ob_start();
        include $this->path.'full_thumb_item.php';
        return ob_get_clean();
    }
    
    
    public function ajaxLoad($page = 1) {
        
        $this->results = $this->Results($page);
        $this->hash_location = "{$this->hash_name}_{$this->current_page}";
        
        $full_slides = array();
        $full_nav_slides = array();
        $grid_items = array();
        
        $results = array();
        
        $item_index = ($this->rpp * $this->current_page) - $this->rpp;
        
        $found = false;
        $total = 0;
        foreach($this->results as $p) {
            $total++;
        }
        
        foreach($this->results as $p) {
            $found = true;
            if($this->count_grid_view) KSM_postView::add($p);
            $p->total_img=$total;
            $p->user_name = get_user_by('id', $p->post_author);
            $p->user_name = $p->user_name->data->display_name;
            $full_slides[] = $this->renderFullItem($p);
            $full_nav_slides[] = $this->renderFullThumbItem($p);
            $grid_items[] = $this->renderGridItem($p, $item_index);
            
            
            
            $item_index++;
        }
        
        
        $data = array(
                'full' => array(
                    'slides' => $full_slides,
                    'nav' => $full_nav_slides
                    ),
                'grid' => array(
                    'slides' => $grid_items,
                    'pagination' => ''
                    ),
                'mini' => array(
                    'slides' => $grid_items
                    ),
                'found' => $found
                );
        
        if($page == 1) {
            $data['mini'] = array(
                'slides' => $grid_items
            );
        }
        
        return $data;
    }
    
    
    
    
    function paginate_links() {
	

	$total        = ceil($this->total_results / $this->rpp);
	$current      = $this->current_page;
        

	$defaults = array(
		'total' => $total,
		'current' => $current,
		'show_all' => false,
		'prev_next' => true,
		'end_size' => 1,
		'mid_size' => 2,
	);

	
        $args = wp_parse_args( $args, $defaults );
	
	
	if ( $total < 2 ) {
		return;
	}
	
	$end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
	if ( $end_size < 1 ) {
		$end_size = 1;
	}
	$mid_size = (int) $args['mid_size'];
	if ( $mid_size < 0 ) {
		$mid_size = 2;
	}
	
	$r = '';
	$page_links = array();
	$dots = false;

	if ( $args['prev_next'] && $current && 1 < $current ) :
            $link = $current - 1;
            $page_links[] = '<a class="prev page-numbers" href="#" rel="'.$link.'"></a>';
	endif;
	for ( $n = 1; $n <= $total; $n++ ) :
		if ( $n == $current ) :
			$page_links[] = "<span class='page-numbers current'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . "</span>";
			$dots = true;
		else :
			if ( $args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
				$page_links[] = "<a class='page-numbers' href=\"#\" rel=\"$n\">" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . "</a>";
				$dots = true;
			elseif ( $dots && ! $args['show_all'] ) :
				$page_links[] = '<span class="page-numbers dots">' . __( '&hellip;' ) . '</span>';
				$dots = false;
			endif;
		endif;
	endfor;
	if ( $args['prev_next'] && $current && ( $current < $total || -1 == $total ) ) :
		$link = $current + 1;
		$page_links[] = '<a class="next page-numbers" href="#" rel="'.$link.'"></a>';
	endif;
	
	$r = join("\n", $page_links);
	
	return $r;
    }
    
    
    
    
    
    
    
    
}





class KSM_MultiViewGallery_Product_Studio extends KSM_MultiViewGallery {
    
    
    public $share_post = 'post';
    
    public function __construct($args = array()) {
        parent::__construct($args);
        
        //$this->total_results = $this->user->products_count;
        $this->name = 'products';
        $this->hash_name = 'dl';
        $this->tab_name = 'Products';
        
    }
    
    public function getGridImage($post) {
        return get_image_src($post->_thumbnail_id, 'gallery_grid');
    }
    
    public function getFullImage($post) {
        return get_image_src($post->_thumbnail_id, 'full');
    }
    
    public function getTinyImage($post) {
        return get_image_src($post->_thumbnail_id, 'avatar_small_2');
    }
    
    
    
    public function Results($page=1) {
        
        $page = $page ? $page : 1;
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        $this->current_page = $page;
        
        
        $args = array(
            'posts_per_page' => $this->rpp ,
            'author' => $this->user_id,
            'paged' => $page,
            'post_type' => 'download',
            'post_status' => 'publish',
            'meta_query' => array(
                array('key' => '_thumbnail_id', 'value' => '0', 'compare' => '>', 'type' => 'numeric')
            )
        );
        
        
        $query = new WP_Query( $args );
        $this->total_results = $query->found_posts;
        
        $posts = $query->posts;
        wp_reset_query();
        wp_reset_postdata();
        
        return $posts;
    }
    
    
    static function load_items() {
        $user_id = sanitize_text_field($_POST['u']);
        $page = sanitize_text_field($_POST['p']);
        
        if($user_id) {
            $user = get_user_by('id', $user_id);
        }
        $results = array();
        if($user && $user instanceof WP_User) {
            $gallery = new KSM_MultiViewGallery_Products(array('user_id'=>$user->ID));
            
            $results = $gallery->ajaxLoad($page);
            
        }
        
        
        echo json_encode($results);
        
        die();
    }
    
    
}












class KSM_MultiViewGallery_Wip_Studio extends KSM_MultiViewGallery {
    
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
        
        //$this->total_results = $this->user->wip_count;
        $this->name = 'wip';
        $this->hash_name = 'wip';
        $this->tab_name = 'WIP';
        
    }
    
    
    public function getGridImage($post) {
        return get_image_src($post->ID, 'gallery_grid');
    }
    
    public function getFullImage($post) {
        return get_image_src($post->ID, 'full');
    }
    
    public function getTinyImage($post) {
        return get_image_src($post->ID, 'avatar_small_2');
    }
    
    public function Results($page=1) {
        
        $page = $page ? $page : 1;
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        $this->current_page = $page;
        
        
        
        
        $args = array(
            'posts_per_page' => $this->rpp ,
            'paged' => $page,
            'post_type' => 'attachment',
            'post_status' => 'any',
            'author' => $this->user_id,
            
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'ksm_tax_topic',
                    'field' => 'name',
                    'terms' => 'wip'
                ),
                array(
                    'taxonomy' => 'ksm_tax_post_at',
                    'field' => 'name',
                    'terms' => 'studio'
                )
            )
            
            
        );
        
        
        
        $query = new WP_Query( $args );
        
        
        $this->total_results = $query->found_posts;
        
        $posts = $query->posts;
        wp_reset_query();
        wp_reset_postdata();
        
        return $posts;
    }
    
    
    
    static function load_items() {
        $user_id = sanitize_text_field($_POST['u']);
        $page = sanitize_text_field($_POST['p']);
        
        if($user_id) {
            $user = get_user_by('id', $user_id);
        }
        $results = array();
        if($user && $user instanceof WP_User) {
            $gallery = new KSM_MultiViewGallery_Wips(array('user_id'=>$user->ID));
            $results = $gallery->ajaxLoad($page);
            
        }
        
        
        echo json_encode($results);
        
        die();
    }
    
    
}





class KSM_MultiViewGallery_Finished_Studio extends KSM_MultiViewGallery {
    
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
        
        //$this->total_results = $this->user->wip_count;
        $this->name = 'finished';
        $this->hash_name = 'finished';
        $this->tab_name = 'Finished Artwork';
        
    }
    
    
    public function getGridImage($post) {
        return get_image_src($post->ID, 'gallery_grid');
    }
    
    public function getFullImage($post) {
        return get_image_src($post->ID, 'full');
    }
    
    public function getTinyImage($post) {
        return get_image_src($post->ID, 'avatar_small_2');
    }
    
    public function Results($page=1) {
        
        $page = $page ? $page : 1;
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        $this->current_page = $page;
        
        
        
        
        $args = array(
            'posts_per_page' => $this->rpp ,
            'paged' => $page,
            'post_type' => 'attachment',
            'post_status' => 'any',
            'author' => $this->user_id,
            
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'ksm_tax_topic',
                    'field' => 'name',
                    'terms' => 'finished'
                ),
                array(
                    'taxonomy' => 'ksm_tax_post_at',
                    'field' => 'name',
                    'terms' => 'studio'
                )
            )
            
            
        );
        
        
        
        
        $query = new WP_Query( $args );
        
        
        
        
        $this->total_results = $query->found_posts;
        
        $posts = $query->posts;
        wp_reset_query();
        wp_reset_postdata();
        
        return $posts;
    }
    
    
    
    static function load_items() {
        $user_id = sanitize_text_field($_POST['u']);
        $page = sanitize_text_field($_POST['p']);
        
        if($user_id) {
            $user = get_user_by('id', $user_id);
        }
        $results = array();
        if($user && $user instanceof WP_User) {
            $gallery = new KSM_MultiViewGallery_Wips(array('user_id'=>$user->ID));
            $results = $gallery->ajaxLoad($page);
            
        }
        
        
        echo json_encode($results);
        
        die();
    }
    
    
}




class KSM_MultiViewGallery_Trending_Community extends KSM_MultiViewGallery {
    
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
        
        //$this->total_results = $this->user->wip_count;
        $this->name = 'trending_community';
        $this->hash_name = 'trending_community';
        $this->tab_name = 'Trending';
    }
    
    public function getGridImage($post) {
        return get_image_src($post->ID, 'gallery_grid');
    }
    
    public function getFullImage($post) {
        return get_image_src($post->ID, 'full');
    }
    
    public function getTinyImage($post) {
        return get_image_src($post->ID, 'avatar_small_2');
    }
    
    public function Results($page=1) {
        
        $page = $page ? $page : 1;
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        $this->current_page = $page;
        
        $sort_args = array('meta_key' => 'trending','orderby' => 'meta_value_num', 'order' => 'DESC');
        
        
        
        
        
        
        
        
        
        
        $args = array(
            'posts_per_page' => $this->rpp ,
            'paged' => $page,
            'post_type' => 'attachment',
            'post_status' => 'any',
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'ksm_tax_post_at',
                    'field' => 'name',
                    'terms' => 'community'
                )
            ),
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'trending',
                    'value' => '0',
                    'compare' => '>',
                )
            )
        );
        
        
        $args = array_merge($args , $sort_args);
        $query = new WP_Query( $args );
        
        
        $this->total_results = $query->found_posts;
        
        $posts = $query->posts;
        wp_reset_query();
        wp_reset_postdata();
        
        return $posts;
    }
    
    
    
    static function load_items() {
        $user_id = sanitize_text_field($_POST['u']);
        $page = sanitize_text_field($_POST['p']);
        
        if($user_id) {
            $user = get_user_by('id', $user_id);
        }
        $results = array();
        if($user && $user instanceof WP_User) {
            $gallery = new KSM_MultiViewGallery_Wips(array('user_id'=>$user->ID));
            $results = $gallery->ajaxLoad($page);
            
        }
        
        
        echo json_encode($results);
        
        die();
    }
    
    
}



class KSM_MultiViewGallery_New_Community extends KSM_MultiViewGallery {
    
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
        
        //$this->total_results = $this->user->wip_count;
        $this->name = 'new_community';
        $this->hash_name = 'new_community';
        $this->tab_name = 'New';
    }
    
    public function getGridImage($post) {
        return get_image_src($post->ID, 'gallery_grid');
    }
    
    public function getFullImage($post) {
        return get_image_src($post->ID, 'full');
    }
    
    public function getTinyImage($post) {
        return get_image_src($post->ID, 'avatar_small_2');
    }
    
    
    
    
    public function Results($page=1) {
        
        
        
        $page = $page ? $page : 1;
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        $this->current_page = $page;
        
        
        
        
        
        
        $args = array(
            'posts_per_page' => $this->rpp ,
            'paged' => $page,
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            
            
            
            'tax_query' => array(
                'relation' => 'AND',
                //array(
                    //'taxonomy' => 'ksm_tax_topic',
                    //'field' => 'name',
                    //'terms' => 'wip'
                //),
                array(
                    'taxonomy' => 'ksm_tax_post_at',
                    'field' => 'name',
                    'terms' => 'community'
                )
            )
        );
        
        
        
        $query = new WP_Query( $args );
        
        
        $this->total_results = $query->found_posts;
        $posts = $query->posts;
        wp_reset_query();
        wp_reset_postdata();
        
        return $posts;
    }
    
    
    
    static function load_items() {
        $user_id = sanitize_text_field($_POST['u']);
        $page = sanitize_text_field($_POST['p']);
        
        if($user_id) {
            $user = get_user_by('id', $user_id);
        }
        $results = array();
        if($user && $user instanceof WP_User) {
            $gallery = new KSM_MultiViewGallery_Wips(array('user_id'=>$user->ID));
            $results = $gallery->ajaxLoad($page);
            
        }
        
        
        echo json_encode($results);
        
        die();
    }
    
    
}




class KSM_MultiViewGallery_Top_Rated_Community extends KSM_MultiViewGallery {
    
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
        
        //$this->total_results = $this->user->wip_count;
        $this->name = 'top_community';
        $this->hash_name = 'top_community';
        $this->tab_name = 'Top Rated';
    }
    
    
    public function getGridImage($post) {
        return get_image_src($post->ID, 'gallery_grid');
    }
    
    public function getFullImage($post) {
        return get_image_src($post->ID, 'full');
    }
    
    public function getTinyImage($post) {
        return get_image_src($post->ID, 'avatar_small_2');
    }
    
    public function Results($page=1) {
        
        $page = $page ? $page : 1;
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        $this->current_page = $page;
        
        $sort_args = array('meta_key' => 'rating_coefficient','orderby' => 'meta_value_num', 'order' => 'DESC');
        
        $args = array(
            'posts_per_page' => $this->rpp ,
            'paged' => $page,
            'post_type' => 'attachment',
            'post_status' => 'any',
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'ksm_tax_post_at',
                    'field' => 'name',
                    'terms' => 'community'
                )
            ),
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'rating_coefficient',
                    'value' => '0',
                    'compare' => '>',
                )
            )
        );
        
        
        $args = array_merge($args , $sort_args);
        $query = new WP_Query( $args );
        
        
        $this->total_results = $query->found_posts;
        $posts = $query->posts;
        wp_reset_query();
        wp_reset_postdata();
        
        return $posts;
    }
    
    
    
    static function load_items() {
        $user_id = sanitize_text_field($_POST['u']);
        $page = sanitize_text_field($_POST['p']);
		
        if($user_id) {
            $user = get_user_by('id', $user_id);
        }
        $results = array();
        if($user && $user instanceof WP_User) {
            $gallery = new KSM_MultiViewGallery_Wips(array('user_id'=>$user->ID));
            $results = $gallery->ajaxLoad($page);
            
        }
        
        
        echo json_encode($results);
        
        die();
    }
    
    
}



class KSM_MultiViewGallery_Challenge_Community extends KSM_MultiViewGallery {
    
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
        
        //$this->total_results = $this->user->wip_count;
        $this->name = 'challenge_community';
        $this->hash_name = 'challenge_community';
        $this->tab_name = 'Challenge';
    }
    
    
    public function getGridImage($post) {
        return get_image_src($post->ID, 'gallery_grid');
    }
    
    public function getFullImage($post) {
        return get_image_src($post->ID, 'full');
    }
    
    public function getTinyImage($post) {
        return get_image_src($post->ID, 'avatar_small_2');
    }
    
    public function Results($page=1) {
        
        $page = $page ? $page : 1;
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        $this->current_page = $page;
        
        
        
        $args = array(
            'posts_per_page' => $this->rpp ,
            'paged' => $page,
            'post_type' => 'attachment',
            'post_status' => 'any',
            
            
            
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'ksm_tax_topic',
                    'field' => 'name',
                    'terms' => 'challenge'
                ),
                array(
                    'taxonomy' => 'ksm_tax_post_at',
                    'field' => 'name',
                    'terms' => 'community'
                )
            )
        );
        
        
        
        $query = new WP_Query( $args );
        
        
        $this->total_results = $query->found_posts;
        $posts = $query->posts;
        wp_reset_query();
        wp_reset_postdata();
        
        return $posts;
    }
    
    
    
    static function load_items() {
        $user_id = sanitize_text_field($_POST['u']);
        $page = sanitize_text_field($_POST['p']);
        
        if($user_id) {
            $user = get_user_by('id', $user_id);
        }
        $results = array();
        if($user && $user instanceof WP_User) {
            $gallery = new KSM_MultiViewGallery_Wips(array('user_id'=>$user->ID));
            $results = $gallery->ajaxLoad($page);
            
        }
        
        
        echo json_encode($results);
        
        die();
    }
    
    
}



class KSM_MultiViewGallery_Wip_Community extends KSM_MultiViewGallery {
    
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
        
        //$this->total_results = $this->user->wip_count;
        $this->name = 'wip_community';
        $this->hash_name = 'wip_community';
        $this->tab_name = 'Wip';
    }
    
    
    public function getGridImage($post) {
        return get_image_src($post->ID, 'gallery_grid');
    }
    
    public function getFullImage($post) {
        return get_image_src($post->ID, 'full');
    }
    
    public function getTinyImage($post) {
        return get_image_src($post->ID, 'avatar_small_2');
    }
    
    public function Results($page=1) {
        
        $page = $page ? $page : 1;
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        $this->current_page = $page;
        
        
        
        $args = array(
            'posts_per_page' => $this->rpp ,
            'paged' => $page,
            'post_type' => 'attachment',
            'post_status' => 'any',
            
            
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'ksm_tax_topic',
                    'field' => 'name',
                    'terms' => 'wip'
                ),
                array(
                    'taxonomy' => 'ksm_tax_post_at',
                    'field' => 'name',
                    'terms' => 'community'
                )
            )
        );
        
        
        
        $query = new WP_Query( $args );
        
        
        $this->total_results = $query->found_posts;
        $posts = $query->posts;
        wp_reset_query();
        wp_reset_postdata();
        
        return $posts;
    }
    
    
    
    static function load_items() {
        $user_id = sanitize_text_field($_POST['u']);
        $page = sanitize_text_field($_POST['p']);
        
        if($user_id) {
            $user = get_user_by('id', $user_id);
        }
        $results = array();
        if($user && $user instanceof WP_User) {
            $gallery = new KSM_MultiViewGallery_Wips(array('user_id'=>$user->ID));
            $results = $gallery->ajaxLoad($page);
            
        }
        
        
        echo json_encode($results);
        
        die();
    }
    
    
}