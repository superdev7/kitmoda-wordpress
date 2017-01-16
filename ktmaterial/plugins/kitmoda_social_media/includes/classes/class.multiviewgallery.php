<?php
/*
define('KSM_GALLERY_RESULTS_PER_PAGE', 20);

class KSM_MultiViewGallery {
    
    public $rpp,
           $user,
           $name,
           $results,
           $total_results;
    
    public function __construct($args = array()) {
        
        if($args['user_id']) {
            $this->user = get_user_by('id', $args['user_id']);
        }
        
        $this->name = $args['name'];
        $this->rpp = KSM_GALLERY_RESULTS_PER_PAGE;
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
    
    
    
    
    
    public function load($page = 1) {
        
        $this->results = $this->Results($page);
        $this->total_pages = ceil($this->total_results / $this->rpp);
        $this->hash_location = "{$this->hash_name}_{$this->current_page}";
        
        
        
        include KSM_BASE_PATH . 'templates/__elements/kmvg/kmvg.php';
        
        
    }
    
    
    public function ajaxLoad($page) {
        $this->results = $this->Results($page);
        $this->hash_location = "{$this->hash_name}_{$this->current_page}";
        
        $full_slides = array();
        $full_nav_slides = array();
        $grid_items = array();
        
        $results = array();
        
        $c = ($this->rpp * $this->current_page) - $this->rpp;
        
        foreach($this->results as $p) {
            $full_slides[] = 
                    "<div data-item=\"$p->ID\" id=\"{$this->hash_location}_{$p->ID}\">
                        <img src=\"".$this->getFullImage($p)."\" />
                    </div>";
                    
             $full_nav_slides[] = 
                     "<div>
                         <div class=\"outer_border\">
                            <img src=\"".$this->getTinyImage($p)."\" />
                         </div>
                     </div>";
             
             
             
             $grid_img = $this->getGridImage($p);
             ob_start();
             
             include KSM_BASE_PATH.'templates/__elements/kmvg/grid_item.php';
             $grid_items[] = ob_get_clean();
             $c++;
        }
                
        return
        array(
            'full' => $full_slides,
            'full_nav' => $full_nav_slides,
            'grid' => $grid_items,
            'page' => $page,
            'name' => $this->name
        );
        
        
        
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





class KSM_MultiViewGallery_Products extends KSM_MultiViewGallery {
    
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
        
        $this->total_results = $this->user->products_count;
        $this->name = 'products';
        $this->hash_name = 'dl';
        
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
            'author' => $this->user->ID,
            'paged' => $page,
            'post_type' => 'download',
            'post_status' => 'publish',
            'meta_query' => array(
                array('key' => '_thumbnail_id', 'value' => '0', 'compare' => '>', 'type' => 'numeric')
            )
        );
        
        $products = get_posts($args);
        
        return $products;
    }
    
    
    static function load_items() {
        $user_id = $_POST['u'];
        $page = $_POST['p'];
        
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












class KSM_MultiViewGallery_Wips extends KSM_MultiViewGallery {
    
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
        
        $this->total_results = $this->user->wip_count;
        $this->name = 'wips';
        $this->hash_name = 'wip';
        
    }
    
    
    public function Results($page=1) {
        
        $page = $page ? $page : 1;
        $page = (!is_numeric($page) || $page < 1) ? 1 : $page;
        
        $this->current_page = $page;
        
        
        $args = array(
            'posts_per_page' => $this->rpp ,
            'author' => $this->user->ID,
            'paged' => $page,
            'post_type' => 'ksm_wip',
            'post_status' => 'publish',
            'meta_query' => array(
                array('key' => 'image', 'value' => '0', 'compare' => '>', 'type' => 'numeric')
            )
        );
        
        $products = get_posts($args);
        
        return $products;
    }
    
    
    
    static function load_items() {
        $user_id = $_POST['u'];
        $page = $_POST['p'];
        
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
 
 */


?>