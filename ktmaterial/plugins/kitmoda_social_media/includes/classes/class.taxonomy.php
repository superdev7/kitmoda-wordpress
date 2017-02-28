<?php



class KSM_D_Taxonomy extends KSM_Taxonomy {
    
}

class KSM_Taxonomy {
    
    
    public $taxonomy,
            $params,
            $name,
            $hierarchical,
            $slug,
            $key,
            $objects,
            $get_terms_method,
            $tax,
            $value_type
            ;
    
    
    public function __construct($tax = 'category') {
        
        
        $taxonomies = (Array) KSM_DataStore::Options('taxonomy');
        
        if($taxonomies[$tax]) {
            $this->taxonomy = $tax;
            $this->params = $taxonomies[$tax];
            $this->tax = $tax;
            $this->name = $this->params['name'];
            $this->hierarchical = $this->params['hierarchical'];
            $this->slug = $this->params['slug'];
            $this->objects = $this->params['objects'];
            
            $this->value_type = isset($this->params['value_type']) ? $this->params['value_type'] : 'simple';
            
            $this->get_terms_method = isset($this->params['get_terms_method']) ? $this->params['get_terms_method'] : '';
            
            $this->key = $this->params['prefix'] . $this->taxonomy;
        }
    }
    
    
    
    static function tax_name($tax) {
        
        $_tax = (Array) KSM_DataStore::Option('taxonomy', $tax);
        
        if($_tax) {
            $tax = $_tax['prefix'] . $tax;
        }
        
        return $tax;
    }
    
    
    public function get_terms($args = array() , $label = '') {
        
        
        $_args = array(
            'orderby'       => $args['orderby'] ? $args['orderby'] : 'id', 
            'order'         => $args['order'] ? $args['order'] : 'ASC',
            'hide_empty'    => false, 
            'parent'        => $args['parent'] ? $args['parent'] : 0,
            'fields'        => 'all'
        );
        
        
            
        $terms = get_terms($this->key, $_args);
            
        if($terms instanceof WP_Error) {
            return array();
        }
        
        $final_terms = array();
            
        if($label) {
            $lables = KSM_DataStore::Terms($this->slug);
            foreach($terms as $t) {
                $lbl = $lables[$t->name][$label] ? $lables[$t->name][$label] : $lables[$t->name]['label'];
                $t->label = $lbl;
                $final_terms[] = $t;
            }
        } else {
            $final_terms = $terms;
        }
            
        
        return $final_terms;
        
    }
    
    public function add_term($term) {
        
        $_term = wp_insert_term($term, $this->key);
    }
    
    
    public function update_term($term, $name) {
        wp_update_term($term->ID, $this->key, array(
                'name' => $name
            ));
    }
    
    public function term_exists($term, $by='name') {
        
        if($by == 'name') {
            if(term_exists($term, $this->key)) {
                return true;
            }
        } elseif($by == 'id') {
            if($this->get_term_by_id($term)) {
                return true;
            }
        }
        
        return false;
        
        
    }
    
    
    
    public function get_term($term) {
        return get_term_by('name', $term, $this->key);
    }
    
    public function get_term_by_id($term) {
        return get_term_by('id', $term, $this->key);
    }
    
    public function get_term_id($term) {
        
        $_term = $this->get_term($term);
        if($_term) {
            return $_term->term_id;
        }
        return '';
    }


    public function get_children($term) {
        return get_term_children($term, $this->key);
    }
    
    
    public function get_post_terms($post_id, $args = array()) {
        
        $terms = wp_get_post_terms($post_id, $this->key, $args);
        
        return $terms;
    }
    
    public function set_terms($post_id, $terms, $append = false) {
        wp_set_post_terms($post_id, $terms, $this->key, $append);
    }


    public function delete_term($term) {
        
        wp_delete_term( $term, $this->key );
        
    }
    
    /**
     * 
     * @param int $post_id
     * @param mixed $term
     */
    
    public function set_term($post_id, $term) {
        wp_set_post_terms($post_id, $term, $this->key);
    }
    
    
    
    
    
    public function range_to_term($number) {
        $terms = $this->get_terms();
        
        
        
        $_term = null;
        
        foreach($terms as $term) {
            list($min, $max) = explode('-', $term->name);
            
            $min = ksm_format_to_number($min);
            $max = ksm_format_to_number($max);
            
            if($max == 'more') {
                if($number > $min) {
                    $_term = $term;
                    continue;
                }
            } else {
                if($number >= $min && $number <= $max) {
                    $_term = $term;
                    continue;
                }
            }
        }
        
        return $_term;
    }
    
    
    
    
    function __call($method, $args){
        
        if($method == 'value_to_term') {
            $term = new stdClass();
            if($this->value_type == 'range') {
                $term = call_user_func_array(array($this, 'range_to_term'), $args);
            } else {
                $term = call_user_func_array(array($this, 'get_term'), $args);
            }
            return $term;
        }
        
    }
    
    
    
    static function dropdown($args = array(), $terms_label = '') {
        $parent = !$args['parent'] || $args['parent'] < 0 || !is_numeric($args['parent']) ? 0 : $args['parent'] ;
        
        $tax = $args['tax'] ? $args['tax'] : 'category';
        
        
        
        
        $self = new KSM_Taxonomy($tax);
        $args['parent'] = $parent;
        $args['tax'] = $tax;
        return $self->get_dropdown($args, $terms_label);
    }
    
    
    public function get_dropdown($args = array(), $terms_label = '') {
        extract($args);
        
        $none_text = "Select a {$this->params['name']}";
        
        if (preg_match("/([Aa][[:space:]])+[aeiouAEIOU]/",$none_text)) {
            $none_text = ucfirst(preg_replace("/[Aa][[:space:]]/", "an ", $none_text));
        }
        
        $none_text = $args['none'] ? $args['none'] : $none_text;
        
        $label = $label ? $label : '';
        
        
        
        
        $name = $args['name'] ? $args['name'] : strtolower($this->params['name']);
        $id = '__'.$name;
        
        if($this->params['hierarchical']) {
            $name .= "[]";
            $id .= "_" . $args['parent'];
        }
        
        
        
        $class = $args['class'] ? $args['class'] : '';
        
        $terms = $this->get_terms($args, $terms_label);
        
        
        ob_start();
        echo '<div class="field">';
        if($label) {
            echo '<label for="'.$id.'">'.$label.'</label>';
        }
        
        echo '<select name="'.$name.'" id="'.$id.'" class="'.$class.'">
                <option value="">'.$none_text.'</option>';
        
        foreach($terms as $t) :
            $lbl = $t->label ? $t->label : $t->name;
            $vlu = $args['value'] ? $t->{$args['value']} : $t->term_id;
			if $lbl != 'Uncategorized':
				echo '<option class="level-0" value="'.$vlu.'">'.$lbl.'</option>';
			endif;
        endforeach;
        
        echo '</select><div class="clr"></div></div>';
        
        $select = ob_get_clean();
        
        return $select;
    }
    
    
    
}