<?php

    
class KSM_Patch {
    
    
    
    
    
    
    static function add_terms() {
        
        require_once(ABSPATH . 'magento-help/includes/taxonomy.php');
        
        foreach((Array) KSM_DataStore::Options('taxonomy') as $k => $t) {
            $terms = (Array) @KSM_DataStore::Terms($k);
            $tax  = new KSM_Taxonomy($k);
            foreach($terms as $t_name=> $t_args) {
                if(!$tax->term_exists($t_name)) {
                    $tax->add_term($t_name);
                }
            }
        }
        exit;
    }
    
    static function update_user_sale_stats() {
        
        $users = get_users(array(
            //'number' => -1
        ));
        //pr($users);
        foreach($users as $u) {
            KSM_Count::update_user_sale_stats($u->ID);
        }
        
    }
    
    
    
    static function update_download_authors() {
        
        $posts = get_posts(array(
            'post_type' => 'download',
            'posts_per_page' => -1,
            'post_status' => 'any'
        ));
        
        
        foreach($posts as $p) {
            $download = new KSM_Download($p->ID);
            $authors = $download->authors();
            foreach ($authors as $a) {
                if(!$download->author_exists_in_d_authors($a)) {
                    $download->add_author_in_d_authors($a);
                }
            }
        }
        
        exit;
        
    }
    
    
    
    
    function ksm_download_post_updated() {
        
         $posts = get_posts(array(
            'post_type' => 'download',
            'posts_per_page' => -1,
            'post_status' => 'any'
        ));
        
        $authors_list = array();
        
        foreach($posts as $p) {
            $download = new KSM_Download($p->ID);
            $authors = $download->authors();
            foreach ($authors as $a) {
                if(!in_array($a, $authors_list)) {
                    $authors_list[] = $a;
                }
            }
        }
        
        
        
        foreach ($authors_list as $author) {
            ksm_update_author_model_stats($author);
        }
        
        exit;
    }
    
    
    
    function ksm_download_author_models_rating() {
        
         $posts = get_posts(array(
            'post_type' => 'download',
            'posts_per_page' => -1,
            'post_status' => 'any'
        ));
        
        $authors_list = array();
        
        foreach($posts as $p) {
            $download = new KSM_Download($p->ID);
            $authors = $download->authors();
            foreach ($authors as $a) {
                if(!in_array($a, $authors_list)) {
                    $authors_list[] = $a;
                }
            }
        }
        
        
        
        foreach ($authors_list as $author) {
            ksm_update_author_model_ratings($author);
        }
        
        exit;
    }
    
    
    static function update_download_check_stats() {
        $posts = get_posts(array(
            'post_type' => 'download',
            'posts_per_page' => -1,
            'post_status' => 'any'
        ));
        
        
        foreach($posts as $p) {
            $download = new KSM_Download($p->ID);
            $isTextured = $download->isTextured() ? 'yes' : 'no';
            $isUntextured = $download->isUntextured() ? 'yes' : 'no';
            $isSolo = $download->isSolo() ? 'yes' : 'no';
            $isCollaboration = $download->isCollaboration() ? 'yes' : 'no';
            $isCollaborationTextured = $download->isCollaborationTextured() ? 'yes' : 'no';
            $isCollaborationUntextured = $download->isCollaborationUntextured() ? 'yes' : 'no';
            $isSoloTextured = $download->isSoloTextured() ? 'yes' : 'no';
            $isSoloUntextured = $download->isSoloUntextured() ? 'yes' : 'no';
            
            
            
            $download->update_meta('is_textured', $isTextured);
            $download->update_meta('is_untextured', $isUntextured);
            $download->update_meta('is_solo', $isSolo);
            $download->update_meta('is_collaboration', $isCollaboration);
            $download->update_meta('is_collaboration_textured', $isCollaborationTextured);
            $download->update_meta('is_collaboration_untextured', $isCollaborationUntextured);
            $download->update_meta('is_solo_textured', $isSoloTextured);
            $download->update_meta('is_solo_untextured', $isSoloUntextured);
        }
        
        exit;
    }
    
    static function add_categories() {
        
        ini_set('memory_limit','512M');
        
        
        require_once(ABSPATH . 'magento-help/includes/taxonomy.php');
        
        $source = KSM_BASE_PATH . 'cache/Kitmoda_categories.xml';
        $categories = array();
        $child_categories = array();
        
        $xml = @simplexml_load_file($source);
        if(!$xml) {
            echo "XML file not found";
            return;
        }
        foreach($xml->children() as $cat) {
            
            
            $item = array();
            $item = array('id' =>(String) $cat['id'], 'name'=> (String) $cat['text'], 'parent' => (String) $cat['parent']);
            
            if($item['parent'] == '-1') {
                continue;
            }
            
            $parent = $item['parent'];
            $id = $item['id'];
            
            
            $categories[$id] = $item;
            $child_categories[$parent][] = $item;
        }
        
        $relation = array(0=>0);
        
        
        //pr($child_categories);
        //exit;
        
        foreach($child_categories as $_pid => $childs) {
            
            
            
            //$data_parent = $cat['parent'];
            
            
            
            $parent = $relation[$_pid];
            
            
            foreach($childs as $c) {
                
                $cid = $c['id'];
                
                $cat_args = array(
                    //'name' => $c['name'],
                    'parent'=> $parent
                );
                $exists = term_exists($c['name'], 'category', $parent);
                if(!$exists) {
                    $term_result = wp_insert_term($c['name'], 'category', $cat_args);
                    
                    if($term_result instanceof WP_Error) {
                        //pr($term_result);
                        //pr($cat);
                    } else {
                        $real_id = $term_result['term_id'];
                        if($real_id) {
                            $relation[$cid] = $real_id;
                        }
                    }
                } else {
                    
                    $real_id = $exists['term_id'];
                    if($real_id && !$relation[$cid]) {
                        $relation[$cid] = $real_id;
                    }
                }
            
            
                
            }
            
            
            //if($data_parent) {
            //    if($categories[$data_parent] && $categories[$data_parent]['real_id']) {
            //        $parent = $categories[$data_parent]['real_id'];
            //    }
            //}
            
            //$categories[$cid]['real_parent_id'] = $parent;
            
            
            
            
            
        }
        
        pr($relation);
        
        //pr($child_categories);
        //exit;
        
        /*
        
         foreach($categories as $cid => $cat) {
            
            $data_parent = $cat['parent'];
            
            $parent = 0;
            
            if($data_parent) {
                if($categories[$data_parent] && $categories[$data_parent]['real_id']) {
                    $parent = $categories[$data_parent]['real_id'];
                }
            }
            
            $categories[$cid]['real_parent_id'] = $parent;
            
            $cat_args = array(
                'name' => $cat['name'],
                'parent'=> $parent
            );
            
            
            //if(!term_exists($cat['name'], 'category')) {
                $term_result = wp_insert_term($cat['name'], 'category', $cat_args);
            //}
            
            if($term_result instanceof WP_Error) {
                //pr($term_result);
                //pr($cat);
            } else {
                $real_id = $term_result['term_id'];
                if($real_id) {
                    $categories[$cid]['real_id'] = $real_id;
                }
            }
            
            
            
        } 
          
        */
        
        exit;
    }
    
    
    static function delete_categories() {
        
        ini_set('memory_limit','512M');
        
        $terms = get_terms( 'category', array( 'fields' => 'ids', 'hide_empty' => false ) );
          foreach ( $terms as $value ) {
               wp_delete_term( $value, 'category' );
          }
        
        exit;
    }
    
    
    
    static function add_not_blocked() {
        $posts = get_posts(array(
            'post_type' => 'ksm_post',
            'posts_per_page' => -1,
            'post_status' => 'any'
        ));
        
        foreach($posts as $p) {
            update_post_meta($p->ID, 'blocked', 'no');
        }
        
    }
    
    
}

?>