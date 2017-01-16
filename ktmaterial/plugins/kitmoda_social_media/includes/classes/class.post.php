<?php



class KSM_Post {
    
    public $Post,
           $match_type;
    
    
    function __construct($id = 0, $match_type = true) {
        $this->match_type = $match_type;
        $this->Post = $this->init($id);
    }
    
    
    static function get($id, $match_type=true) {
        
        $cls = get_called_class();
        
        //$key = "{$cls}_{$id}";
        //$_obj = wp_cache_get($key, 'ksm_posts');
        
        
        //if(!$_obj) {
            $_obj = new $cls($id, $match_type);
        
            if($_obj->ID) {
                return $_obj;
                //wp_cache_set($key, $this, 'ksm_posts');
            }
        //}
        
        
        return null;
    }
    
    
    public function Insert($args = array(), $as_data = array()) {
        
        if(!$args['post_status']) $args['post_status'] = 'publish';
        if(!$args['post_author']) $args['post_author'] = get_current_user_id();
        
        
        $args['post_type'] = $this->_post_type;
        $meta = array();
        
        if(isset($args['meta'])) {
            $meta = $args['meta'];
            unset($args['meta']);
        }
        
        $post_id = wp_insert_post($args);
        
        if($post_id) {
            $this->Post = get_post($post_id);
            
            if(!empty($as_data)) {
                
                foreach($this->as_data as $fun_name => $fun_args) {
                    foreach($fun_args as $_fun_args) {
                        if(in_array('post_id', $_fun_args)) {
                            $post_id_key = array_search('post_id', $_fun_args);
                            $_fun_args[$post_id_key] = $post_id;
                        }
                        call_user_func_array($fun_name, $_fun_args);
                    }
                }
                
            }
            
            
            foreach($meta as $k => $v) {
                $this->update_meta($k, $v);
            }
            
            $this->emit('Insert');
            return $post_id;
        }
        
        return false;
    }
    
    public function delete() {
        
    }
    
    
    
    public function init($id) {
        
        $post = null;
        if($id) {
            $post = get_post($id);
            if(!$post || ($this->match_type && $post->post_type != $this->_post_type)) {
                $post = null;
            }
        }
        
        if(!$this->__isValid()) {
            $post = null;
        }
        
        return $post;
    }
    
    
    
    public function __isValid() {
        return true;
    }
    
    
    public function __get($name) {
        
        
        if($name == 'Author' && !isset($this->Author)) {
            $this->Author = new KSM_User($this->post_author);
        }
        
        
        if(property_exists($this, $name)) {
            return $this->{$name};
        } elseif(is_object($this->Post) && (property_exists($this->Post, $name) || isset($this->Post->{$name}))) {
            return $this->Post->{$name};
        }
    }
    
    
    public function the_title() {
        
	$title = isset( $this->Post->post_title ) ? $this->Post->post_title : '';

	return apply_filters( 'the_title', $title, $this->Post->ID );
        
    }
    
    public function the_content() {
        
    }
    
    
    public function isOwner($user_id = 0) {
        
        $user_id = $user_id ? $user_id : get_current_user_id();
        
        
        
        if($this->Post && $this->post_author == $user_id) {
            return true;
        }
        return false;
    }
    
    
    public function update_meta($key, $value) {
        update_post_meta($this->ID, $key, $value);
        $this->{$key} = $value;
    }
    
    public function delete_meta($key) {
        delete_post_meta($this->ID, $key);
        $this->{$key} = '';
    }
    
    
    
    
    public function Error($error) {
        return array('error' => true, 'msg' => $error);
    }
    
    public function Errors($errors) {
        return array('error' => true, array('errors' => $errors));
    }
    
    
    public function Success($msg='', $data = array()) {
        return array_merge($data , array('success' => true, 'msg' => $msg));
    }
    
    
    
    
    public function thumb($size = 'avatar_small_2') {
        
        $thumb_id = get_post_thumbnail_id($this->ID);
        
        $thumb = "";
        if($thumb_id) {
            $thumb = get_image_src($thumb_id, $size);
        }
        
        return $thumb;
    }
    
    
    public function the_thumb($size = 'avatar_small_2') {
        $src = $this->thumb($size);
        $thumb = '';
        if($src) {
            $thumb = "<img src=\"$src\" />";
        }
        return $thumb;
    }
    
    
    function EventData() {
        return array('id' => $this->ID);
    }
    
    public function get_tax_label($tax, $ds_label = true) {
        
        $_tax = new KSM_Taxonomy($tax);
        $terms = wp_get_post_terms($this->ID, $_tax->key, array('fields' => 'names'));
        
        
        if($ds_label) {
            $all_labels = KSM_DataStore::Terms($tax, 'view');
            $labels = array();
            foreach($terms as $t) {
                $labels[] = $all_labels[$t];
            }
        } else {
            $labels = $terms;
        }
        return implode(', ', $labels);
    }
    
    
    
    public function get_tags_admin_links($tax, $ds_label = true) {
        
        
        $terms = $this->get_terms($tax, $ds_label);
        
        $tax_name = KSM_Taxonomy::tax_name($tax);
        
        
        $tags = array();
        foreach ( $terms as $term ) {
            $tag_link = esc_url( add_query_arg( array( 'post_type' => $this->post_type, $tax_name => $term->slug ), 'edit.php' ) );
            $tag_name = esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, $tax_name, 'display' ) );
            
            $tags[] = sprintf( '<a href="%s">%s</a>', $tag_link, $tag_name);
        }
        
        return join( ', ', $tags );
    }
    
    
    
    
    public function get_terms($tax, $ds_label = true) {
        $_tax = new KSM_Taxonomy($tax);
        $_terms = wp_get_post_terms($this->ID, $_tax->key);
        
        $terms = array();
        
        if($ds_label) {
            $all_labels = KSM_DataStore::Terms($tax, 'view');
            foreach($_terms as $t) {
                
                if($all_labels[$t->name]) {
                    $t->name = $all_labels[$t->name];
                }
                
                $terms[] = $t;
            }
        } 
        
        return $terms;
    }
    
    
    
    public function get_term_id($taxonomy = 'category') {
        $taxonomy = KSM_Taxonomy::tax_name($taxonomy);
        return wp_get_post_terms($this->ID, $taxonomy, array('fields' => 'ids'));
    }
    
    
    
    public function has_term($term, $taxonomy) {
        $taxonomy = KSM_Taxonomy::tax_name($taxonomy);
        return has_term( $term, $taxonomy, $this->ID );
    }
    
    public function breadcrumb() {
        
        $term_id = (Array) $this->get_term_id();
        $term_id = $term_id[0];
        if($term_id) {
            return store_search_breadcrumb($term_id);
        }
    }
    
    
    public function image_attachments($args = array(), $including_thumb = true) {
        return post_attacments($this->ID, $args, $including_thumb);
    }
    
    
    
    public function images($args = array(), $including_thumb = true, $size = '') {
        
        $attachments = $this->image_attachments($args , $including_thumb);
        
        $images = array();
        
        foreach($attachments as $att) {
            $src = get_image_src($att->ID, $size);
            if(!$src) continue;
            //if($count_view) { KSM_postView::add($att);}
            
            $images[$att->ID] = array('id' => $att->ID, 'src' => $src);
        }
        
        return $images;
    }
    
    
    
    function is_reported_by($user_id) {
        
        global $wpdb;
        
        
        
        if($user_id) {
            $q = "SELECT * FROM {$wpdb->prefix}ksm_post_reports WHERE post_id = %d AND reported_by = %d";

            $report = $wpdb->get_row($wpdb->prepare($q, $this->Post->ID, $user_id));
            if($report) {
                return true;
            }
        }
        
        return false;
    }
    
    function should_auto_block() {
        global $wpdb;
        
        
        $time = time();
        
        $threshold = strtotime('+'.POST_BLOCK_REPORTS_THRESHOLD) - $time;
        $posts_limit = POST_BLOCK_REPORTS_COUNT;
        
        
        $start_time = $time - $threshold;
        $end_time = $time;
        
        $count = $this->count_reports(array('start' => $start_time, 'end' => $end_time));
        
        if($count >= $posts_limit) {
            return true;
        }
        
        return false;
    }
    
    
    public function count_reports($period = array()) {
        global $wpdb;
        
        $table = $wpdb->prefix."ksm_post_reports";
        $q = "SELECT count(*) FROM {$table} WHERE post_id = %d";
        
        $args = array();
        
        $args['query'] = $q;
        $args[] = $this->Post->ID;
        if(!empty($period)) {
            $args['query'] .= ' AND `time` BETWEEN %d AND %d';
            $args[] = $period['start'];
            $args[] = $period['end'];
        }
        
        $query = call_user_func_array(array($wpdb, 'prepare'), $args);
        
        $count = $wpdb->get_var($query);
        
        return $count;
    }
    
    
    
    function addReport($reasons, $user_id = 0) {
        global $wpdb;
        
        
        if(!$user_id)  {
            $user_id = get_current_user_id();
        }
        
        $table = $wpdb->prefix."ksm_post_reports";
        $data = array(
            'post_id' => $this->Post->ID,
            'reported_by' => $user_id,
            'reasons' => maybe_serialize($reasons),
            'time' => time()
        );
        
        
        if($wpdb->insert( $table, $data, array('%d', '%d', '%s', '%d') )) {
            $count = $this->count_reports();
            $this->update_meta('reports_count', $count);
            return true;
        }
        
        return false;
    }
    
    
    
    
    function reports() {
        global $wpdb;
        
        
        $q = "SELECT * FROM {$wpdb->prefix}ksm_post_reports WHERE post_id = %d";
        
        
        
        $reports = $wpdb->results($wpdb->prepare($q, $this->Post->ID));
        return $reports;
    }
    
    
    function block($type = 'auto') {
        $this->update_meta('blocked', 'yes');
        $this->update_meta('block_type', $type);
    }
    
    function unblock() {
        $this->update_meta('blocked', 'no');
        $this->delete_meta('block_type');
    }
    
    
    function is_blocked() {
        
        if($this->blocked == 'yes') {
            return true;
        }
        return false;
    }
    
    public function gallery($settings = array()) {
        
        
        
        
        $thumb_size = $settings['thumb_size'];
        $full_size  = $settings['full_size'];
    
        
        //$count_view = $settings['count_view'] ? $settings['count_view'] : false;
    
        $gallery = array();
    
    
        $gallery['name'] = $settings['name'];
        
        $gallery['buttons'] = $settings['buttons'];
    
        
        $with_featured = $settings['with_featured'] ? true : false;
        $gallery['images'] = $this->images(array(), $with_featured, $full_size);
        $gallery['thumbs'] = $this->images(array(), $with_featured, $thumb_size);
        
            
        
        
        return $gallery;
        
        
            
            
        
    }
    
    
    
    public function image_attachment_ids($args = array(), $including_thumb = true) {
        return post_attacment_ids($this->ID, $args, $including_thumb);
    }
    
    
    public function comments($args = array()) {
        $comments = array();
        
        if($this->ID) {
            $_args = array('post_id' => $this->ID, 'status'  => 1);
            $args = array_merge($_args, $args);
            
            $args['post_id'] = $this->ID;
            
            
            
            $comments = get_comments($args);
        }
        
        return $comments;
    }
    
    
    public function emit($event, $args = array()) {
        
        
        $cb = "on{$event}";
        
        if(method_exists($this, $cb)) {
            $this->{$cb}();
        }
        
        
        $cls = get_called_class();
        
        if(strtolower(substr($cls, 0, 4)) == 'ksm_') {
            $cls = substr($cls, 4);
        }
        
        
        
        
        
        $event_name = 'KSM_Event_'.$cls . '__' .$event;
        
        
        
        $args['id'] = $this->ID;

        $cls = get_called_class();
        if(strtolower(substr($cls, 0, 4)) == 'ksm_') {
            $cls = substr($cls, 4);
        }
            
        $event_data = KSM_DataStore::Option('Event', $event);
        
        if(!empty($event_data)) {
            if($event_data['email']) {
                $email = KSM_Email::get($event_data['email'], $args);
                $email->send();
            } elseif($event_data['notification']) {
                
                echo "asdasd";
                $notification = KSM_Notification::get($event_data['notification'], $args);
                
                
                
                $notification->send();
            }
        }
        
        
        
    }
    
    static function get_post($id) {
        
        $post = new KSM_Post($id, false);
        
        
        return $post;
    }
    
    
    
    
    
    
    
    
}