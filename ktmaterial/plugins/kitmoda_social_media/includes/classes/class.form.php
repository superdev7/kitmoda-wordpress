<?php




class KSM_Form extends KSM_Object {
    
    
    
    public $name, // Form name
           $config, // Form raw datastore configration
           $prepare_data, // 
           $as_data,
           $fields,
           $sections;
    
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
        
        $this->prepare_fields();
        
    }
    
    
    public function prepare_fields() {
        
        
        
        $form_object = get_called_class().'_Object';
        
        foreach((Array) $this->config as $fn => $f) {
            
            $field_args = $f;
            $field_args['name'] = $fn;
            if($this->prepare_data['data']) {
                $field_args['raw_input'] = $this->prepare_data['data'][$fn];
            }
            
            $f = KSM_Form_Field::get($field_args);
            unset($field_args);
            
            $f->form = $form_object;
            
            if($f && $f->is_field_visible()) {
                $this->fields[$fn] = $f;
            } else {
                unset($f);
            }
            
        }
        
    }
    
    
    /*
    public function prepare_fields() {
        
        foreach($this->config as $section_name => $section) {
            foreach((Array) $section['fields'] as $fn => $f) {
                
                
                $field_args = $f;
                $field_args['name'] = $fn;
                if($this->prepare_data['data']) {
                    $field_args['raw_input'] = $this->prepare_data['data'][$fn];
                }
                
                $f = KSM_Form_Field::get($field_args);
                
                if(!$f) {
                    continue;
                }
                
                unset($field_args);
                
                $f->form = &$this;
                
                if($f && $f->is_field_visible()) {
                    if(!$this->sections[$section_name]['title']) {
                        $this->sections[$section_name]['title'] = $section['title'];
                    }
                    
                    
                    $this->sections[$section_name]['fields'][] = $fn;
                    $this->fields[$fn] = $f;
                } else {
                    unset($f);
                }
                
            }
            
        }
        
    }
    */
    
    
    public function get_field($f) {
        return $this->fields[$f];
    }
    
    
    
    public function get_action_id() {
        return KSM_Action::form($this->name);
    }
    
    
    public function validate($return_data = false) {
        
        
        $v = new KSM_Form_Validate($this->fields);
        $result = array();
        
        
        if($v->validate_form()) {
            
            $result = array('success' => true);
            if($return_data) {
                $result['data'] = $this->data();
            }
            
        } else {
            $errors = $v->single_errors();
            $result =  array('error' => true, 'errors' => $errors);
        }
        
        return $result;
    }
    
    
    function data() {
        $data = array();
        foreach($this->fields as $k => $f) {
            $data[$k] = $f->value;
        }
        
        return $data;
    }
    
    public function auto_save($post_id) {
        
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
    
    
    public function prepare_auto_save() {
        
        
        $term_ids = array();
        
        
        
        //foreach($this->steps as $sname => $step) {
            
            //$sdata = $step['data'];
            
            foreach ((Array) $this->fields as $fname => $f) {
                
                if(!$f->save_as) {
                    continue;
                }
                
                
                
                foreach ($f->save_as as $sa) {
                    if($sa == 'post_term' || $sa == 'post_terms') {
                        
                        $multi = $sa == 'post_terms' ? true : false;
                        $tax_name = $f->tax ? $f->tax : $fname;
                        
                        
                        if($f->type == 'term_id' || $f->type == 'term_ids') {
                            
                            if($multi) {
                                foreach((Array) $f->value as $m) {
                                    $term_ids[$tax_name][] = (int) $m;
                                }
                            } else {
                                $term_ids[$tax_name][] = (int) $f->value;
                            }
                            
                        } elseif($f->type == 'list') {
                            foreach((Array) explode(',', $f->value) as $tn) {
                                $term_ids[$tax_name][] = $tn;
                            }
                        } else {
                            $tax = new KSM_Taxonomy($tax_name);
                            
                            if($multi) {
                                foreach((Array) $f->value as $m) {
                                    $term = $tax->value_to_term($m);
                                    if($term) {
                                        $term_ids[$tax_name][] = (int) $term->term_id;
                                    }
                                }
                            } else {
                                $term = $tax->value_to_term($f->value);
                                if($term) {
                                    $term_ids[$tax_name][] = (int) $term->term_id;
                                }
                            }
                            
                            
                        }
                    }
                    
                    elseif($sa == 'post_meta') {
                        $this->as_data['update_post_meta'][] = array('post_id', $fname, $f->value);
                    }
                }
                
                
            }
        //}
        
        
        
        
        foreach($term_ids as $tax_name => $_ids) {
            $tax = new KSM_Taxonomy($tax_name);
            $this->as_data['wp_set_post_terms'][] = array('post_id', $_ids, $tax->key);
        }
        
    }
    
    
    
    
    
    
    
    
    static function get_form($name = '', $prepare_data = array()) {
        
        if($name) {
            $config = self::get_fields($name);
            
            //pr($fields);
            
            if(!empty($config)) {
                $form_name = "Form_{$name}";
                $cls_name = "KSM_{$form_name}";
                
                $args = array(
                    'name' => $name,
                    'config' => $config,
                    'prepare_data' => $prepare_data
                    );
                
                // $form_name, $fields, $_data
                
                return new $cls_name($args);
            }
        }
        return null;
    }
    
    
    static function get_fields($name) {
        $name = "Form/{$name}";
        return KSM_DataStore::Options($name);
    }
    
    
    
    
    
    
    
    static function radio($data, $settings) {
        
        $name = $settings ['name'];
        $current = $settings['value'];
        
        $options = "";
        
        foreach((Array) $data as $k => $v) {
            $id = $name.'_'.$k;
            $isSelected = $k == $current ? true : false;
            $options .= '
            <div class="field">
                <input type="radio" name="'.$name.'" id="'.$id.'" value="'.$k.'"'.($isSelected ? 'checked="checked"' : '').' />
                <label for="'.$id.'">'.$v.'</label>
            </div>';
        }
        
        $options .= "<div class=\"clr\"></div>";
        return $options;
    }
    
    static function dropdown($data, $settings) {
        
        $name = $settings['name'];
        $current = $settings['value'];
        
        $id = isset($settings['id']) ? $settings['id'] : $name;
        $id = str_replace(array('[', ']'), '_', $id);
        
        
        $class = $settings['class'] ? $settings['class'] : '';
        
        $select = "";
        $select = '<select name="'.$name.'"'.($id ? " id=\"{$id}\"" : "").' class="'.$class.'">';
        
        if($settings['none_text']) {
            $select .= '<option value="">'.$settings['none_text'].'</option>';
        }
        
        
        foreach((Array) $data as $k => $v) {
            $isSelected = ($k == $current) ? true : false;
            
            $select .= "<option".($isSelected ? ' selected="selected"' : '')." value=\"{$k}\">{$v}</option>";
        }
        
        $select .= "</select>";
        
        //$options .= "<div class=\"clr\"></div>";
        return $select;
    }
    
    
    
    static function options_radio($name, $settings = array()) {
        
        $label = $settings['label'] ? $settings['label'] : 'form_label';
        $settings['name'] = $settings['name'] ? $settings['name'] : $name;
        
        
        $options = KSM_DataStore::Options($name, $label);
        return self::radio($options, $settings);
    }
    
    
    static function options_checkbox($name, $settings = array()) {
        
        $label = $settings['label'] ? $settings['label'] : 'form_label';
        $settings['name'] = $settings['name'] ? $settings['name'] : $name;
        
        
        $options = KSM_DataStore::Options($name, $label);
        return self::checkbox($options, $settings);
    }
    
    
    
    
    static function terms_radio($name, $settings = array()) {
        
        $label = $settings['label'] ? $settings['label'] : 'form_label';
        $settings['name'] = $settings['name'] ? $settings['name'] : $name;
        
        $section = $settings['section'] ? $settings['section'] : '';
        
        $options = KSM_DataStore::Terms($name, $label, $section);
        
        if($settings['prepend']) {
            $options = array_merge($settings['prepend'], $options);
        }
        
        return self::radio($options, $settings);
    }
    
    
    static function terms_dropdown($name, $settings = array()) {
        
        $label = $settings['label'] ? $settings['label'] : 'form_label';
        $settings['name'] = $settings['name'] ? $settings['name'] : $name;
        
        $section = $settings['section'] ? $settings['section'] : '';
        
        $options = KSM_DataStore::Terms($name, $label, $section);
        return self::dropdown($options, $settings);
    }
    
    
    static function terms_checkbox($name, $settings = array()) {
        
        $label = $settings['label'] ? $settings['label'] : 'form_label';
        $settings['name'] = $settings['name'] ? $settings['name'] : $name;
        
        
        
        $section = $settings['section'] ? $settings['section'] : '';
        
        $options = KSM_DataStore::Terms($name, $label, $section);
        return self::checkbox($options, $settings);
    }
    
    
    
    
    
    static function store_facet_field($taxonomies, $label, $visible = 0) {
        
        
        $taxonomies = is_array($taxonomies) ? $taxonomies : array($taxonomies);
        
        $fields = array();
        $options = "";
        
        foreach($taxonomies as $tax) {
            
            $name = $tax;
            $terms = (Array) KSM_DataStore::Terms($tax);
            foreach($terms as $k => $v) {
                if($v['filterable'] === false) {
                    continue;
                }
                $lbl = $v[$label] ? $v[$label] : $v['label'];
                $id = 'ff_'.$name.'_'.$k;
                $fields[] = '
                <div class="field">
                    <input type="checkbox" class="opt_filter" name="'.$name.'[]" id="'.$id.'" value="'.$k.'"'.($isSelected ? 'checked="checked"' : '').' />
                    <label for="'.$id.'">'.$lbl.'</label>
                </div>';
            }
        }
        
        
        if($visible) {
            $options = implode('', array_slice($fields, 0, $visible));
                
            $options .= '<div class="more_options">
                                <div class="more_options_list">'.
                                implode('', array_slice($fields, $visible)).
                                '</div>
                                <div class="more">Show More</div>
                                <div class="less">Less</div>
                            </div>';
        } else {
            $options = implode('', $fields);
        }
            
        return $options;
            
        
    }
    
    
    static function checkbox($data, $settings) {
        
        $name = $settings ['name'] . '[]';
        $current = $settings['value'];
        
        
        $options = "";
        
        foreach((Array) $data as $k => $v) {
            $id = str_replace('[]', '_i', $name.'_'.$k);
            $isSelected = $k == $current ? true : false;
            $options .= '
            <div class="field">
                <input type="checkbox" name="'.$name.'" id="'.$id.'" value="'.$k.'"'.($isSelected ? 'checked="checked"' : '').' />
                <label for="'.$id.'">'.$v.'</label>
            </div>';
        }
        
        $options .= "<div class=\"clr\"></div>";
        return $options;
    }
    
	/**********************************************************************************/
	//Staging 2 version of images_upload_placeholder
	/**********************************************************************************/
	 static function images_upload_placeholder($args, $data = array()) {
        
        
        $name = $args['name'];
        $n = "{$name}[]";
        
        $sections = $args['sections'];
        
        $classes = array();
        $classes[] = 'items';
        if($sections['featured']) {
            $classes[] =  'with_featured';
        }
        
        
        
        $classes = implode(' ', $classes);
        
        ob_start();
        echo '<div class="section_headers">';
        foreach($sections as $k => $sec) :?>
            <div class="section_header <?=$k?>">
                <div class="ui_placeholder_wrapper">
                <div class="field_name"><?=$sec['title']?><span class="note"><?=$sec['note']?></span></div>
                </div>
            </div>
            
        <?php 
        
        endforeach;
        echo '</div>';
        
        $ph = ob_get_clean();
        
        
        
        
        $ph .= "<ul class=\"{$classes}\">";
        
        
        
        $total_c = 1;
        
        foreach($sections as $sec_name => $sec) {
            
            
            $sec_items = $sec['items'];
            for ($i=1; $i <=$sec_items; $i++) {
                
                
            
                if($data[$total_c]) {
                    
                    $ph .=
                    '<li class="item'.(($data[$total_c]->poslock) ? ' poslock' : '').'">
                            <div class="b2">
                                <div class="b3">
                                    <img src="'.get_image_src($data[$total_c]->ID, 'pub_feature').'" width="100%" height="100%" />
									
                                </div>
								
                            </div>
		
                            <input type="hidden" class="uid" name="'.$n.'" value="'.$data[$total_c]->ID.'">
                        	
                    </li>';
                    
                } else {
                    $ph .='<li class="item empty"><div class="b2"><div class="b3"></div></div>
					
                    <input type="hidden" class="uid" name="'.$n.'" value="" />
                       <div class="progress"><div class="bar"></div></div> 
                    </li>';
                }
                
                $total_c++;
            }
            //if($sec['secsep']) {
                $secsep_class = "poslock secsep secsep_{$sec_name}";
                $ph .= "<li class=\"{$secsep_class}\"></li>";
            //}
        }
        
        
        
        
        
        $ph .= '<li class="clr"></li></ul>';
        
        return $ph;
        
    }
	//End of images_upload_placeholder method - Staging 2 version (working but needs to be updated)
	/**********************************************************************************/
	
	/**********************************************************************************/
    //The following method needs to be re-written, replacing with staging 2 code - Above
	/**********************************************************************************/
    /*static function images_upload_placeholder($args, $data = array()) {
        
        
        $name = $args['name'] . '[]';
        
        
        $sections = $args['sections'];
        
        $classes = array();
        $classes[] = 'items';
        if($sections['featured']) {
            $classes[] =  'with_featured';
        }
        
        
        
        $classes = implode(' ', $classes);
        
        ob_start();
        
        foreach($sections as $k => $sec) :?>

            
            <div class="section section_<?=$k?>">
                
                <div class="section_inner">
                
                    <div class="section_header">
                        <div class="field_name"><?=$sec['title']?><span class="note"><?=$sec['note']?></span></div>
                        
                    </div>

                    <div class="list">
                        <ul class="<?=$classes?>">
                        <?php for ($i=1; $i <=$sec['items']; $i++) : ?>
                            <li class="item empty">
                                
                                    <div class="b2">
                                        <div class="b3"></div>
                                    </div>
                                    
                                    
                                    
                                    <div class="inner">
                                        <div class="img"></div>
                                        <input type="hidden" class="uid" name="<?=$name?>" value="" />
                                        <div class="progress"><div class="bar"></div></div>
                                    </div>
                                    
                                
                            </li>
                        <?php endfor; ?>
                        </ul>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                    
                </div>
            </div>
            <?php endforeach; ?>
            
        
        
        
        <?php
        
        $ph = ob_get_clean();
        
        
        return $ph;
        
        
    }*/
	// End of images_upload_placeholder method - Staging 1 version (buggy)
    /**********************************************************************************/
    
    static function getCetegorySelect() {
        $id = $_POST['id'];
        $select = "";
        if($id) {
            $childs = get_term_children( $id, 'category' );
            if(empty($childs)) {
                $select = "";
            } else {
                $select = KSM_Taxonomy::dropdown(array('label'=>'Sub Category', 'parent' => $id));
            }
        }
        
        echo $select;
        die();
    }
    
    
    
    static function star_rating_input($name, $rating = 0) {
        
        $id = 'rateit_'.rand(11111111, 999999999);
        $rating = $rating ? $rating : '0';
        ob_start();
        
        ?>
    
        <div class="rateit" data-rateit-step="1" id="<?=$id?>" value="<?=$rating?>" data-rateit-resetable="false"></div>
        <input type="hidden" name="<?=$name?>" id="input_<?=$id?>" value="<?=$rating?>" />
    
        <script type="text/javascript">
            jQuery(function() {
                jQuery('#<?=$id?>').bind('rated reset', function (e) {
                    var ri = jQuery(this);
                    var value = ri.rateit('value');
                    jQuery('#input_<?=$id?>').val(value);
                });
                jQuery('#<?=$id?>').rateit('value', '<?=$rating?>');
            })
        </script><?php
      
        $html = ob_get_clean();
        return $html;
    }
    
    
    
    
    
    
    
    
    function prepare_form_save_as_s3_download_attach($field) {
        
        $value = $field['value'];
        $_data['KSM_S3::download_attach'][] = array(array($value), 'post_id', $field['field_name']);
        
    }
    
    
    
    
}




class KSM_Form_Rate extends KSM_Form {
    
    
    public $purchase_download;
    
    
    //public function is_visible() {
        
    //}
    
    
    //public function visible_fields() {
        
    //    foreach((Array) $this->fields as $f) {
    //        $f->is_visible();
    //    }
    //}
    
    
    
    /*
    public function prepare_fields() {
        
        foreach($this->config as $section_name => $section) {
            foreach((Array) $section['fields'] as $fn => $f) {
                
                
                $field_args = $f;
                $field_args['name'] = $fn;
                if($this->prepare_data['data']) {
                    $field_args['raw_input'] = $this->prepare_data['data'][$fn];
                }
                
                $f = KSM_Form_Field::get($field_args);
                unset($field_args);
                
                $f->form = &$this;
                
                
                if($f && $f->is_field_visible()) {
                    if(!$this->sections[$section_name]['title']) {
                        $this->sections[$section_name]['title'] = $section['title'];
                    }
                    
                    
                    $this->sections[$section_name]['fields'][] = $fn;
                    $this->fields[$fn] = $f;
                } else {
                    unset($f);
                }
                
            }
            
        }
        
    }
    */
    
    
    
    public function getAssignmentRules() {
        
        $roles = array();
        
        
        
        
        $user_roles = $this->prepare_data['download']->getUserRoles();
        
        
        foreach($this->fields as $n => $f) {
            $f_rules = $f->getAssignmentRules();
            foreach($f_rules as $sname => $su_roles) {
                foreach($su_roles as $sru) {
                    $suser = $sru;
                    if($sru == '6' && !$user_roles[6] && $user_roles[5]) {
                        $suser = 5;
                    } elseif($sru == '4' && !$user_roles[4] && $user_roles[2]) {
                        $suser = 2;
                    }
                    $roles[$sname][$suser][] = $n;
                }
            }
        }
        
        
        return array('roles' => $roles, 'users' => $user_roles);
    }
    
    
    
    public function get_action_id() {
        return KSM_Action::form($this->name, $this->purchase_download->ID);
    }
    
    
    
    
    public function submit() {
        
        
        
        
        
        $v_result = $this->validate(true);
        if($v_result['error']) {
            KSM_Js::setPopupError($v_result['msg']);
            exit;
        }
            
        
        
        $this->prepare_auto_save();
        
        
        $user_id = get_current_user_id();
        
        
        
        
        $post_args = array(
            'post_type' => "ksm_p_download_rate",
            'post_status' => "publish",
            'post_author' => $user_id,
            'post_title' => "Download Rate",
            'post_content' => "",
            'post_parent' => $this->prepare_data['download']->ID
        );
        
        
        $_post_id = wp_insert_post($post_args);
        
        
        
        $success_msg = "Thanks for rating.";
        
	
        if($_post_id) {
            
            $this->auto_save($_post_id);
            
            //update_post_meta($_post_id, 'model_type', 'textured');
            
            
            
            
            
            
            $meta_fields = get_post_meta($_post_id);

            
            $fields  = array_keys($this->fields);
            
            $rating_data = array();
            $role_score_data = array();
            
            foreach ($meta_fields as $mfk => $mf) {
                if(in_array($mfk, $fields)) {
                    $rating_data[] = $mf[0];
                    
                    foreach((Array) $this->fields[$mfk]->score_groups as $sg) {
                        if($sg == 'role') {
                            $role_score_data[] = $mf[0];
                        }
                    }
                    
                }
            }
            
            
            
            
            $rating_average = array_average($rating_data);
            $contribution_rating_average = array_average($role_score_data);
            
            
            update_post_meta($_post_id, 'p_download_id', $this->purchase_download->ID);
            update_post_meta($this->purchase_download->ID, 'rate_id', $_post_id);
            
            update_post_meta($this->purchase_download->ID, 'rating_average', $rating_average);
            update_post_meta($this->purchase_download->ID, 'contribution_rating_average', $contribution_rating_average);
            
            
            return array('success' => true , 'msg' => $success_msg);
            
        }
        
        return array('error' => true , 'msg' => 'unable to post.');
    }
    
}



class KSM_Form_Field  extends KSM_Object {
    public $type,
           $rules,
           $sanitize,
           $save_as,
           $tooltip,
           $label,
           $class,
           $visibility,
           $assignment,
           $field_type,
           $value,
           $raw_input,
           $name,
           $score_groups,
           $prepare_data,
           $form;
    
    
    
    
    
    
    
    public function __construct($args = array()) {
        parent::__construct($args);
        
        
        $this->prepare_rules();
        
        //if($this->raw_input) {
            $this->sanitize();
        //}
            
            
            
            
            
        
    }
    
    
    
    
    public function prepare_rules() {
        
        
        
        $rules = array();
        
        
            
        foreach((Array) $this->rules as $k => $v) {
            
            
            $rule = array();
            
            $r_name = is_numeric($k) ? $v : $k;
            $message = is_numeric($k) ? KSM_Form_Validate::rule_message($r_name) : $v;
            $callback = 'validate_' . $r_name;
            
            
            
            if($r_name == 'required') {
                switch($this->type) {
                    case "term_id":
                        $callback = 'validate_term_id_' . $r_name;
                        break;
                    case "term_name":
                        $callback = 'validate_term_name_' . $r_name;
                        break;
                    case "no_child_term_id":
                        $callback = 'validate_no_child_term_id_' . $r_name;
                        break;
                }
            } elseif(preg_match("/(max|min)_(\d+)_items/", $r_name, $output_array)) {
                if($this->type == 'list') {
                    $callback = 'validate_'.$output_array[1].'_array_items';
                    
                    $rule["{$output_array[1]}"] = $output_array[2];
                }
            } elseif(preg_match("/(max|min)_(\d+)/", $r_name, $output_array)) {
                if($this->type == 'number') {
                    $callback = 'validate_'.$output_array[1];
                    $rule["{$output_array[1]}"] = $output_array[2];
                }
            } elseif(preg_match("/between_length_(\d+)-(\d+)/", $r_name, $output_array)) {
                $callback = 'validate_between_length';
                $rule['min'] = $output_array[1];
                $rule['max'] = $output_array[2];
                
            } elseif(preg_match("/(max|min)_length_(\d+)/", $r_name, $output_array)) {
                $callback = 'validate_'.$output_array[1].'_length';
                $rule['min'] = $output_array[2];
                $rule['max'] = $output_array[3];
                
            }
            
            $rule['message'] = $message;
            $rule['callback'] = $callback;
            
            $rules[$r_name] = $rule;
        }
        
        
        $this->rules = $rules;
                
    }
    
    
    static function get($f) {
        $type = $f['field_type'];
        $fclass = "KSM_Form_{$type}_Field";
        
        if(class_exists($fclass)) {
            return new $fclass($f);
        }
    }
    
    
    public function field_id() {
        $id = $this->id ? $this->id : "input_{$this->name}";
        return $id;
    }
    
    
    
    
    public function sanitize() {
        
        
        $value = $this->raw_input;
        
        foreach((Array) $this->sanitize as $cb) {
            if(function_exists($cb)) {
                $value = call_user_func($cb, $value);
            }
        }
        
        $this->value = $value;
    }
    
    
    public function match_field_rule($rule, $rule_value) {
        
        $vr_parts = explode('__', $rule);
            
        $obj_name = $vr_parts[0];
        $obj_var_name = $vr_parts[1];
            
            
        $is_tax_match = false;
            
        if(substr($obj_var_name, 0, 4) == 'tax_') {
            $is_tax_match = true;
            $obj_var_name = substr($obj_var_name, 4);
        }
        
        
        $match_type = $vr_parts[2] == 'not' ? 'not_match' : 'match';
        
        //echo "{$obj_name} | {$obj_var_name} | {$match_type} | $vrv <br>";
        
        //pr($this->form);
        
        if(is_object($this->form->prepare_data[$obj_name])) {
            if($is_tax_match) {
                if($match_type == 'not_match') {
                    if(!$this->form->prepare_data[$obj_name]->has_term($rule_value, $obj_var_name)) return true;
                } elseif($match_type == 'match') {
                    if($this->form->prepare_data[$obj_name]->has_term($rule_value, $obj_var_name)) return true;
                }
            } else {
                if(is_array($rule_value)) {
                    if($match_type == 'not_match') {
                        if(!in_array($this->form->prepare_data[$obj_name]->$obj_var_name, $rule_value)) return true;
                    } elseif($match_type == 'match') {
                        if(in_array($this->form->prepare_data[$obj_name]->$obj_var_name, $rule_value)) return true;
                    }
                } else {
                    if($match_type == 'not_match') {
                        if($this->form->prepare_data[$obj_name]->$obj_var_name != $rule_value) return true;
                    } elseif($match_type == 'match') {
                        if($this->form->prepare_data[$obj_name]->$obj_var_name == $rule_value) return true;
                    }
                }
            }
            
        }
    }
    
    
    
    
    
    
    public function is_field_visible() {
        
        
        if(!is_array($this->visibility) && ($this->visibility == '' || $this->visibility == '*')) {
            return true;
        }
        
        
        if($this->isRuleValid($this->visibility)) {
            return true;
        }
        
        
        return false;
    }
    
    
    
    
    public function isRuleValid($rules = array()) {
        
        //pr($rules);
        
        //$result = array();
        $result = $this->rules_matched($this->visibility);
        
        return $this->isMatched($result);
        
        //echo ($this->isMatched($result)) ? "Matched" : "Not Match";
    }
    
    
    function isMatched($result = array()) {
        
        $matched = false;
        
        if($result['op'] == 'OR') {
            if(array_sum($result['result']) > 0) {
                $matched = true;
            } 
        } elseif($result['op'] == 'AND') {
            if(array_sum($result['result']) == count($result['result'])) {
                $matched = true;
            }
        }
        
        //echo $this->name;
        //pr($result);
        //echo "Matched : " . ($matched ? "Yes" : "No") . "<br /> -----------------------------<br />";
        
        
        return $matched;
    }
    
    
    function rules_matched($rules_set = array()) {
        
        
        $result = array();
        
        $operator = 'AND';
        
        foreach ($rules_set as $k => $v) {
            
            $is_operator = ($v == 'AND' || $v == 'OR') ? true : false;
            
            if($is_operator) {
                $operator = $v;
            } else {
                
                if(is_numeric($k) && is_array($v)) {
                    $r = $this->rules_matched($v);
                    if($this->isMatched($r)) {
                        $result[] = 1;
                    } else {
                        $result[] = 0;
                    }
                    
                    
                } else {
                    //$fkid = "{$this->name}:{$k}";
                    $result[] = $this->match_field_rule($k, $v);
                }
                
            }
        }
        
        return array('op' => $operator, 'result' =>  $result);
    }
    
    
    public function getAssignmentRules() {
        
        if(!is_array($this->assignment) && ($this->assignment == '' || $this->assignment == '*')) {
            return;
        }
        
        
        //pr($this->assignment);
        //exit;
        
        $_rules = array();
        
        $bt = $this->form->prepare_data['build_type'];
        
        foreach ($this->assignment as $score_type => $rules) {
            
            
            $_bt_rules = $rules[$bt];
            
            if($_bt_rules) {
                
                foreach($_bt_rules as $_r) {
                    if(is_array($_r)) {
                        
                        //pr($_r[0]);
                        
                        reset($_r);
                        $first_key = key($_r);
                        
                        
                        if(is_numeric($first_key) && is_array($_r[$first_key])) {
                            $rules_set = $_r[0];
                            $ru = $_r[1];
                        } else {
                            $rules_set = array($first_key => $_r[$first_key]);
                            $ru = $_r[0];
                        }
                        
                        //echo "$this->name : $score_type : $ru  <br />--------------------<br />";
                        //pr($rules_set);
                        //pr($_r);
                        
                        if($this->isRuleValid($rules_set)) {
                            $_rules[$score_type][] = $ru;
                        }
                    } else {
                        $_rules[$score_type][] = $_r;
                    }
                }
                
                
                
            }
            
        }
        
        
        
        return $_rules;
    }
    
    
}



class KSM_Form_Input_Text_Field extends KSM_Form_Field {
    
    
    public function validation_attributes() {
        
        $rules = array();
        
        
        $default_validation_rules = array('required', 'min', 'max', 'minlength', 'maxlength');
        
        foreach($this->rules as $r => $rule) {
            
            $rule_name = 'k-' . str_replace('_', '-', $rule['callback']);
            $rule_args = $rule;
            
            unset($rule_args['callback']);
            unset($rule_args['message']);
            
            
            
            $rules[$rule_name] = !empty($rule_args) ?  htmlentities(json_encode($rule_args), ENT_QUOTES, 'UTF-8') : '';
        }
        
        
        
        
        $rule_attributes = array();
        
        
        foreach($rules as $k => $v) {
            $rule_attributes[] = $k . (($v) ? '="' . $v . '"' : '');
        }
        
        return $rule_attributes;
    }
    
    
    public function field() {
        
        $v_attributes = $this->validation_attributes();
        
        ob_start();
        ?>
        
        <div class="<?=$this->class?>"><input <?=implode(' ', $v_attributes)?> type="text" name="<?=$this->name?>" id="<?=$this->field_id()?>" value="" /></div>
        
        <?php
        $html = ob_get_clean();
        return $html;
    }
    
}

class KSM_Form_Input_Email_Field extends KSM_Form_Input_Text_Field {
    
}

class KSM_Form_Input_Password_Field extends KSM_Form_Field {
    public function field() {
        
        ob_start();
        ?>
        
        <div class="<?=$this->class?>"><input type="password" name="<?=$this->name?>" id="<?=$this->field_id()?>" value="" /></div>
        
        <?php
        $html = ob_get_clean();
        return $html;
    }
}




class KSM_Form_Rate_Field extends KSM_Form_Field {
    
    
    
    
    
    
    public function field($rating = 0) {
        $id = 'rateit_'.rand(11111111, 999999999);
        $rating = $rating ? $rating : '0';
        ob_start();
        ?>
    
        <div class="rateit" data-rateit-step="1" id="<?=$id?>" value="<?=$rating?>" data-rateit-resetable="false"></div>
        <input type="hidden" name="<?=$this->name?>" id="input_<?=$id?>" value="<?=$rating?>" />
    
        <script type="text/javascript">
            jQuery(function() {
                jQuery('#<?=$id?>').bind('rated reset', function (e) {
                    var ri = jQuery(this);
                    var value = ri.rateit('value');
                    jQuery('#input_<?=$id?>').val(value);
                });
                jQuery('#<?=$id?>').rateit('value', '<?=$rating?>');
            })
        </script><?php
      
        $html = ob_get_clean();
        return $html;
    }
    
}





class KSM_Form_Validate
{
    public $fields = array();
    protected $_errors = array();
    protected $_validations = array();
    protected $_labels = array();

    
    
    protected static $_rules = array();
    protected static $_ruleMessages = array();
    
    

    const ERROR_DEFAULT = 'Invalid';

    protected $validUrlPrefixes = array('http://', 'https://');

    public $data = array();
    
    
    
    public function __construct($fields)
    {
        

        //foreach($fields as $k => $v) {
            
            //$fields[$k]['field_name'] = $k;
            
            
            //$value = $this->sanitize($data[$k], $v['sanitize']);
            
            
            //$v->sanitize();
            
            //if($v->prepare) {
            //    $prepare_cb = 'prepare_'.$v->prepare;
            //    $value = call_user_func(array($this, $prepare_cb), $fields[$k] , $value);
            //}
            
            
            //$fields[$k]['value'] = $value;
            
            //$v->value = $value;
            
            //$this->data[$k] = $value;
        //}
        
        $this->fields = $fields;
        
        
        
        $langFile = KSM_BASE_PATH . 'lang'  . DIRECTORY_SEPARATOR . 'en.php';
        $langMessages = include $langFile;
        static::$_ruleMessages = array_merge(static::$_ruleMessages, $langMessages);
        
    }
    
    
    public function prepare_ds_term_names_array($field, $terms) {
        
        
        $tax = $field['tax'] ? $field['tax'] : $field['field_name'];
        
        
        $_terms = array();
        
        if(is_array($terms)) {
            foreach((Array) $terms as $t) {
                if($t && KSM_DataStore::Term_Exist($tax, $t)) {
                    $_terms[] = $t;
                }
            }
        }
        
        return $_terms;
    }


    public function data() {
        return $this->data;
    }
    
    
    public function sanitize($value, $cbs = array()) {
        
        foreach((Array) $cbs as $cb) {
            if(function_exists($cb)) {
                $value = call_user_func($cb, $value);
            }
            
        }
        return $value;
    }

    
    
    
    
    /*
    public function __call($name, $arguments) {
        
        $nparts = explode('_', $name);
        $arguments = $arguments[0];
        
        
        
        
        if($nparts[0] == 'validate') {
            if(preg_match("/(max|min)_(\d+)_items/", $name, $output_array)) {
                if($arguments['type'] == 'list') {
                    $callback = 'validate_'.$output_array[1].'_array_items';
                    $arguments["{$output_array[1]}"] = $output_array[2];
                    if(method_exists($this, $callback)) {
                        return call_user_func(array($this, $callback), $arguments);
                    }
                }
            } elseif(preg_match("/(max|min)_(\d+)/", $name, $output_array)) {
                if($arguments['type'] == 'number') {
                    $callback = 'validate_'.$output_array[1];
                    $arguments["{$output_array[1]}"] = $output_array[2];
                    if(method_exists($this, $callback)) {
                        return call_user_func(array($this, $callback), $arguments);
                    }
                }
            } elseif(preg_match("/(max|min|between)_length_(\d+)-(\d+)/", $name, $output_array)) {
                
                
                $callback = 'validate_'.$output_array[1].'_length';
                $arguments["{$output_array[1]}"] = array(
                    'min' => $output_array[2], 
                    'max' => $output_array[3]);
                
                if(method_exists($this, $callback)) {
                    return call_user_func(array($this, $callback), $arguments);
                }
                
            }
        }
        
    }
    */
    
    
    
    
    
    
    
    public function validate_form() {
        
        
        
        foreach($this->fields as $fname => $field) {
            
            
            
            foreach((Array) $field->rules as $rule_name => $rule) {
                
                
                //pr($rule);
                $callback = $rule['callback'];
                
                
                if(method_exists($this, $callback)) {
                    $res = call_user_func(array($this, $callback), $field, $rule);
                    if(!$res) {
                        
                        
                        $params = $rule;
                        
                        $params['field_name'] = $fname;
                        $params['rule_name'] = $rule_name;
                        
                        
                        unset($params['message']);
                        unset($params['callback']);
                        
                        $this->error($fname, $rule['message'], $params);
                    }
                }
            }
        }
        
        return count($this->errors()) === 0;
        
    }
    
    
    
    public function validate_google_recaptcha($field, $rule = array()) {
        
        
        $secret = RECAPTCHA_SECRET_KEY;
        $captcha = trim( $field->value );
        
        
        if($captcha) {
            $url = "https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$captcha}";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $response = curl_exec($ch);
            curl_close($ch);
            
            //pr($response);
            if($response) {
                $json = json_decode($response);
                return $json->success;
            }
        }
        return false;
    }
    
    
    public function validate_min_length($field, $rule = array()) {
        
        return strlen($field->value) >= $rule['min'];
    }
    public function validate_max_length($field, $rule = array()) {
        return strlen($field->value) <= $rule['max'];
    }
    public function validate_between_length($field, $rule = array()) {
        $length = strlen($field->value);
        return $length >= $rule['min'] && $length <= $rule['max'];
    }
    
    
    
    public function validate_min($field, $rule = array()) {
        $value = $field->value;
        return is_numeric($value) && $value >= $rule['min'];
    }
    public function validate_max($field, $rule = array()) {
        $value = $field->value;
        return is_numeric($value) && $value <= $rule['max'];
    }

    
    public function validate_in_array($field, $rule = array()) {
        $ar = (Array) $field['rules_data']['in_array'];
        return in_array($field->value, $ar);
    }
    
    
    public function validate_not_empty($field, $rule = array()) {
        $value = (Array) $field->value;
        return !empty($value);
    }
    
    public function validate_max_array_items($field = array(), $rule = array()) {
        $value = $field->value;
        
        if($field->type == 'list') {
            $value = explode(',', $value);
        }
        return count($value) <= $rule['max'];
    }
    
    
    public function validate_min_array_items($field = array(), $rule = array()) {
        $value = $field->value;
        
        if($field->type == 'list') {
            $value = explode(',', $value);
        } 
        return count($value) >= $rule['min'];
    }
    
    public function validate_s3_attachable($field, $rule = array()) {
        $value = $field->value;
        return $value && KSM_S3::can_user_attach($value);
    }
    
    
    public function validate_no_child_term_id_required($field, $rule = array()) {
        
        
        if($this->validate_required($field, $rule)) {
            $tax_name = $field->tax ? $field->tax : $field->field_name;
            if($tax_name) {
                $_tax = new KSM_Taxonomy($tax_name);
                if($_tax->term_exists($field->value, 'id') && !$_tax->get_children($field->value)) {
                    return true;
                }
            }
        }
        return false;
    }
    
    
    public function validate_term_id_required($field, $rule = array()) {
        
        if($this->validate_required($field, $rule)) {
            $tax_name = $field->tax ? $field->tax : $field->field_name;
            if($tax_name) {
                $_tax = new KSM_Taxonomy($tax_name);
                if($_tax->term_exists($field->value, 'id')) {
                    return true;
                }
            }
        }
        return false;
    }
    
    
    public function validate_term_name_required($field, $rule = array()) {
        
        if($this->validate_required($field, $rule)) {
            
            $tax_name = $field->tax ? $field->tax : $field->field_name;
            if($tax_name) {
                $_tax = new KSM_Taxonomy($tax_name);
                if($_tax->term_exists($field->value)) {
                    return true;
                }
            }
        }
        return false;
    }
    
    
    public function validate_required($field, $rule = array()) {
        $value = $field->value;
        return !is_null($value) && !(is_string($value) && trim($value) === '');
    }
    
    
    
    public function validate_email_domain_blacklist($field, $rule = array()) {
        
        $domain = preg_replace('/^.*@(.*)/', '$1', $field->value);
        $domains = KSM_DataStore::Options('Blacklist_Email_Domain');
        
        return $domain && !in_array($domain, $domains);
    }
    
    
    public function validate_email_available($field, $rule = array()) {
        return !KSM_User::email_exists($field->value);
    }
    
    
    public function validate_email($field, $rule = array()) {
        return $this->validateEmail($field, $field->value);
    }

    
    protected function validate_numeric($field, $rule = array()) {
        return is_numeric($field->value);
    }
    
    protected function validate_integer($field, $rule = array()) {
        return filter_var($field->value, FILTER_VALIDATE_INT) !== false;
    }
    
    protected function validate_float($field, $rule = array()) {
        return filter_var($field->value, FILTER_VALIDATE_FLOAT) !== false;
    }
    
    protected function validate_price($field, $rule = array()) {
        return ($this->validate_integer($field) || $this->validate_float($field)) && $field->value > 0;
    }
    
    
    public function validate_alpha_num_space($field, $rule = array()) {
        return preg_match('/^[a-z0-9 ]+$/i', $field->value);
    }
    
    public function validate_display_name_available($field, $rule = array()) {
        return KSM_display_name_available($field->value);
    }
    
    static function rule_message($rule) {
        $message = (isset(static::$_ruleMessages[$rule]) ? static::$_ruleMessages[$rule] : self::ERROR_DEFAULT);
        return "{field} $message";
    }
    
    
    
    
    
    
    
    
    
    protected function validateEquals($field, $value, array $params) {
        $field2 = $params[0];
        return isset($this->_fields[$field2]) && $value == $this->_fields[$field2];
    }

    
    protected function validateDifferent($field, $value, array $params)
    {
        $field2 = $params[0];
        return isset($this->_fields[$field2]) && $value != $this->_fields[$field2];
    }

    
    protected function validateAccepted($field, $value)
    {
        $acceptable = array('yes', 'on', 1, true);
        return in_array($value, $acceptable, true);
    }
    
    protected function validateLength($field, $value, $params)
    {
        $length = strlen($value);
        if(isset($params[1])) {
            return $length >= $params[0] && $length <= $params[1];
        }
        return $length == $params[0];
    }

    
    protected function validateLengthBetween($field, $value, $params) {
        $length = strlen($value);
        return $length >= $params[0] && $length <= $params[1];
    }

    
    protected function validateLengthMin($field, $value, $params) {
        return strlen($value) >= $params[0];
    }

    
    protected function validateLengthMax($field, $value, $params) {
        return strlen($value) <= $params[0];
    }

    
    

    
    protected function validateMin($field, $value, $params)
    {
        return !(bccomp($params[0], $value, 14) == 1);
    }

    
    protected function validateMax($field, $value, $params)
    {
        return !(bccomp($value, $params[0], 14) == 1);
    }

    
    protected function validateIn($field, $value, $params)
    {
        $isAssoc = array_values($params[0]) !== $params[0];
        if($isAssoc) {
            $params[0] = array_keys($params[0]);
        }
        return in_array($value, $params[0]);
    }

    
    protected function validateNotIn($field, $value, $params)
    {
        return !$this->validateIn($field, $value, $params);
    }

    
    protected function validateContains($field, $value, $params)
    {
        if(!isset($params[0])) {
            return false;
        }
        if (!is_string($params[0]) || !is_string($value)) {
            return false;
        }
        return (strpos($value, $params[0]) !== false);
    }

    
    protected function validateIp($field, $value)
    {
        return filter_var($value, FILTER_VALIDATE_IP) !== false;
    }

    
    protected function validateEmail($field, $value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    
    protected function validateUrl($field, $value)
    {
        foreach ($this->validUrlPrefixes as $prefix) {
            if(strpos($value, $prefix) !== false) {
                return filter_var($value, FILTER_VALIDATE_URL) !== false;
            }
        }
        return false;
    }

    
    protected function validateUrlActive($field, $value)
    {
        foreach ($this->validUrlPrefixes as $prefix) {
            if(strpos($value, $prefix) !== false) {
                $url = str_replace($prefix, '', strtolower($value));

                return checkdnsrr($url);
            }
        }
        return false;
    }

    
    protected function validateAlpha($field, $value)
    {
        return preg_match('/^([a-z])+$/i', $value);
    }

    
    protected function validateAlphaNum($field, $value)
    {
        return preg_match('/^([a-z0-9])+$/i', $value);
    }

    
    protected function validateSlug($field, $value)
    {
        return preg_match('/^([-a-z0-9_-])+$/i', $value);
    }

    
    protected function validateRegex($field, $value, $params)
    {
        return preg_match($params[0], $value);
    }

    
    protected function validateDate($field, $value)
    {
        return strtotime($value) !== false;
    }

    
    protected function validateDateFormat($field, $value, $params)
    {
        $parsed = date_parse_from_format($params[0], $value);

        return $parsed['error_count'] === 0;
    }

    
    protected function validateDateBefore($field, $value, $params)
    {
        $vtime = ($value instanceof \DateTime) ? $value->getTimestamp() : strtotime($value);
        $ptime = ($params[0] instanceof \DateTime) ? $params[0]->getTimestamp() : strtotime($params[0]);
        return $vtime < $ptime;
    }

    
    protected function validateDateAfter($field, $value, $params)
    {
        $vtime = ($value instanceof \DateTime) ? $value->getTimestamp() : strtotime($value);
        $ptime = ($params[0] instanceof \DateTime) ? $params[0]->getTimestamp() : strtotime($params[0]);
        return $vtime > $ptime;
    }

    
    protected function validateBoolean($field, $value)
    {
        return (is_bool($value)) ? true : false;
    }

    
    protected function validateCreditCard($field, $value, $params)
    {
        /**
         * I there has been an array of valid cards supplied, or the name of the users card
         * or the name and an array of valid cards
         */
        if (!empty($params)) {
            /**
             * array of valid cards
             */
            if (is_array($params[0])) {
                $cards = $params[0];
            } else if (is_string($params[0])){
                $cardType  = $params[0];
                if (isset($params[1]) && is_array($params[1])) {
                    $cards = $params[1];
                    if (!in_array($cardType, $cards)) {
                        return false;
                    }
                }
            }
        }
        /**
         * Luhn algorithm
         *
         * @return bool
         */
        $numberIsValid = function () use ($value) {
            $number = preg_replace('/[^0-9]+/', '', $value);
            $sum = 0;

            $strlen = strlen($number);
            if ($strlen < 13) {
                return false;
            }
            for ($i = 0; $i < $strlen; $i++) {
                $digit = (int) substr($number, $strlen - $i - 1, 1);
                if ($i % 2 == 1) {
                    $sub_total = $digit * 2;
                    if ($sub_total > 9) {
                        $sub_total = ($sub_total - 10) + 1;
                    }
                } else {
                    $sub_total = $digit;
                }
                $sum += $sub_total;
            }
            if ($sum > 0 && $sum % 10 == 0) {
                    return true;
            }
                return false;
        };

        if ($numberIsValid()) {
            if (!isset($cards)) {
                return true;
            } else {
                $cardRegex = array(
                    'visa'          => '#^4[0-9]{12}(?:[0-9]{3})?$#',
                    'mastercard'    => '#^5[1-5][0-9]{14}$#',
                    'amex'          => '#^3[47][0-9]{13}$#',
                    'dinersclub'    => '#^3(?:0[0-5]|[68][0-9])[0-9]{11}$#',
                    'discover'      => '#^6(?:011|5[0-9]{2})[0-9]{12}$#',
                );

                if (isset($cardType)) {
                    // if we don't have any valid cards specified and the card we've been given isn't in our regex array
                    if (!isset($cards) && !in_array($cardType, array_keys($cardRegex))) {
                        return false;
                    }

                    // we only need to test against one card type
                    return (preg_match($cardRegex[$cardType], $value) === 1);

                } else if (isset($cards)) {
                    // if we have cards, check our users card against only the ones we have
                    foreach($cards as $card) {
                        if (in_array($card, array_keys($cardRegex))) {
                            // if the card is valid, we want to stop looping
                            if (preg_match($cardRegex[$card], $value) === 1) {
                                return true;
                            }
                        }
                    }
                } else {
                    // loop through every card
                    foreach($cardRegex as $regex) {
                        // until we find a valid one
                        if (preg_match($regex, $value) === 1) {
                            return true;
                        }
                    }
                }
            }
        }

        // if we've got this far, the card has passed no validation so it's invalid!
        return false;
    }


    
    /*
    public function data()
    {
        return $this->_fields;
    }
    */

    
    public function errors($field = null)
    {
        if($field !== null) {
            return isset($this->_errors[$field]) ? $this->_errors[$field] : false;
        }
        return $this->_errors;
    }
    
    
    public function single_errors() {
        
        $errors = array();
        
        foreach($this->_errors as $name => $error) {
            $errors[$name] = $error[0];
        }
        
        return $errors;
    }
    

    
    public function error($field, $msg, array $params = array())
    {
        $msg = $this->checkAndSetLabel($field, $msg, $params);

        $values = array();
        // Printed values need to be in string format
        foreach($params as $param) {
            if(is_array($param)) {
                $param = "['" . implode("', '", $param) . "']";
            }
            if($param instanceof \DateTime) {
                $param = $param->format('Y-m-d');
            }
            // Use custom label instead of field name if set
            if(isset($this->_labels[$param])) {
                $param = $this->_labels[$param];
            }
            $values[] = $param;
        }
        
        
        $this->_errors[$field][] = array(
            'field' => $field,
            'rule' => ksm_camelcase($params['rule_name']),
            'msg' => vsprintf($msg, $values)
        );
        

        //$this->_errors[$field][] = vsprintf($msg, $values);
    }

    
    public function message($msg)
    {
        $this->_validations[count($this->_validations)-1]['message'] = $msg;
        return $this;
    }
    
    
    public function reset()
    {
        $this->_fields = array();
        $this->_errors = array();
        $this->_validations = array();
        $this->_labels = array();
    }

    public function validate()
    {
        
        foreach($this->_validations as $v) {
            foreach($v['fields'] as $field) {
                $value = isset($this->_fields[$field]) ? $this->_fields[$field] : null;

                // Don't validate if the field is not required and the value is empty
                if ($v['rule'] !== 'required' && !$this->hasRule('required', $field) && $value == '') {
                    continue;
                }

                // Callback is user-specified or assumed method on class
                if(isset(static::$_rules[$v['rule']])) {
                    $callback = static::$_rules[$v['rule']];
                } else {
                    $callback = array($this, 'validate' . ucfirst($v['rule']));
                }

                $result = call_user_func($callback, $field, $value, $v['params']);
                if(!$result) {
                    $this->error($field, $v['message'], $v['params']);
                }
            }
        }

        return count($this->errors()) === 0;
    }

    
    protected function hasRule($name, $field)
    {
        foreach($this->_validations as $validation) {
            if ($validation['rule'] == $name) {
                if (in_array($field, $validation['fields'])) {
                    return true;
                }
            }
        }
        return false;
    }

    
    public static function addRule($name, $callback, $message = self::ERROR_DEFAULT)
    {
        if(!is_callable($callback)) {
            throw new \InvalidArgumentException("Second argument must be a valid callback. Given argument was not callable.");
        }

        static::$_rules[$name] = $callback;
        static::$_ruleMessages[$name] = $message;
    }

    
    public function rule($rule, $fields)
    {
        if(!isset(static::$_rules[$rule])) {
            $ruleMethod = 'validate' . ucfirst($rule);
            if(!method_exists($this, $ruleMethod)) {
                throw new \InvalidArgumentException("Rule '" . $rule . "' has not been registered with " . __CLASS__ . "::addRule().");
            }
        }

        // Ensure rule has an accompanying message
        $message = isset(static::$_ruleMessages[$rule]) ? static::$_ruleMessages[$rule] : self::ERROR_DEFAULT;

        // Get any other arguments passed to function
        $params = array_slice(func_get_args(), 2);

        $this->_validations[] = array(
            'rule' => $rule,
            'fields' => (array) $fields,
            'params' => (array) $params,
            'message' => '{field} ' . $message
        );
        return $this;
    }

    
    public function label($value)
    {
        $lastRules = $this->_validations[count($this->_validations)-1]['fields'];
        $this->labels(array($lastRules[0] => $value));

        return $this;
    }

    
    public function labels($labels = array())
    {
        $this->_labels = array_merge($this->_labels, $labels);
        return $this;
    }

    
    private function checkAndSetLabel($field, $msg, $params)
    {
        if (isset($this->_labels[$field])) {
            $msg = str_replace('{field}', $this->_labels[$field], $msg);
        } else {
            $msg = str_replace('{field}', ucwords(str_replace('_', ' ', $field)), $msg);
        }
        
        if (is_array($params)) {
            foreach ($params as $k => $v) {
                if(is_array($v)) {
                    continue;
                }
                $tag = '{'. $k .'}';
                $msg = str_replace($tag, $v, $msg);
            }
        }
        
        
        return $msg;
    }

    
    public function rules($rules)
    {
        foreach ($rules as $ruleType => $params) {
            if (is_array($params)) {
                foreach ($params as $innerParams) {
                    array_unshift($innerParams, $ruleType);
                    call_user_func_array(array($this, "rule"), $innerParams);
                }
            } else {
                $this->rule($ruleType, $params);
            }
        }
    }
}


class KSM_Form_Registration extends KSM_Form {
    
    
    
    
    public function submit() {
        
        $v_result = $this->validate(true);
        if($v_result['error']) {
            return $v_result;
        }
        
        
        
        if(KSM_User::Register($v_result['data'])) {
            return array('success' => true);
        }
        
        
        
        
	//wp_set_auth_cookie( $user_id, true );
	//wp_set_current_user( $user_id, $userdata[ 'user_login'] );
	//do_action( 'wp_login', $userdata[ 'user_login'] );
        
        
    }
    
}