<?php








function ksm_register_taxonomies() {
    


    foreach((Array) KSM_DataStore::Options('taxonomy') as $t => $args) {
        
        $tax = new KSM_Taxonomy($t);
        
        if(taxonomy_exists($tax->key)) {
            continue;
        }
        
        register_taxonomy($tax->key, $tax->objects,
                array(
                    'labels' => array(
                        'name'          => $tax->name,
                        'new_item_name' => "New {$tax->name}",
                        'add_new_item'  => "Add New {$tax->name}",
                        //'menu_name'     =>  "{$args['menu_name']}",
                        'ksm_lable'     => 'Text'
                        ),
                        'public'        => true,
                        'show_ui'       => true,
                        'show_tagcloud' => true,
                        'hierarchical'  => $tax->hierarchical,
                        'query_var'     => true,
                        'rewrite'       => array( 'slug' => $tax->slug ),
                        'show_in_nav_menus' => false,
                                'show_admin_column' => false
                    )
        );
    }
    
    
    
    
    
    
    
}




?>