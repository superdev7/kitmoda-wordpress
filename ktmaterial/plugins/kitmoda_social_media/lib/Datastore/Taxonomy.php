<?php


$data = array(
    'topic' => array(
        'name' => 'Topic',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Topics',
        'slug' => 'topic',
        'get_terms_method' => 'KSM_DataStore::Terms',
        'objects' => array('ksm_post', 'attachment')
        ),
    
    
    'post_at' => array(
        'name' => 'Post At',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Post At',
        'slug' => 'post_at',
        'get_terms_method' => 'KSM_DataStore::Terms',
        'objects' => array('ksm_post', 'attachment')
        ),
    
    
    'category' => array(
        'name' => 'Category',
        'prefix' => '',
        'hierarchical' => true,
        'menu_name' => 'Categories',
        'slug' => 'category',
        'objects' => array('download', 'ksm_collaboration')
        ),
    
    'keyword' => array(
        'name' => 'Keyword',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Keywords',
        'slug' => 'keyword',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration', 'ksm_p_download')
        ),
    
    
    
    'price' => array(
        'name' => 'Price',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Price',
        'slug' => 'price',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms',
        'value_type' => 'range'
        ),
    
    'style' => array(
        'name' => 'Style',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Styles',
        'slug' => 'style',
//        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    'era' => array(
        'name' => 'Era',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Eras',
        'slug' => 'era',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    'culture' => array(
        'name' => 'Culture',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Cultures',
        'slug' => 'culture',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
        
    
    'file_format' => array(
        'name' => 'File Format',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'File Format',
        'slug' => 'file_format',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
    ),
    /*
    'model_type' => array(
        'name' => 'Model Type',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Model Type',
        'slug' => 'model_type',
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    'model_specs' => array(
        'name' => 'Model Specs',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Model Specs',
        'slug' => 'model_specs',
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
      
     'texturing' => array(
        'name' => 'Texturing',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Texturing',
        'slug' => 'texturing',
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    */
    'poly_count' => array(
        'name' => 'Poly Count',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Poly Count',
        'slug' => 'poly_count',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms',
        'value_type' => 'range'
        ),
    
    'mapping' => array(
        'name' => 'Mapping',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Mapping',
        'slug' => 'mapping',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    'modeling_method' => array(
        'name' => 'Modeling Method',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Modeling Method',
        'slug' => 'modeling_method',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    'organization' => array(
        'name' => 'Organization',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Organization',
        'slug' => 'organization',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    'lighting' => array(
        'name' => 'Lighting',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Lighting',
        'slug' => 'lighting',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    'bake_lighting' => array(
        'name' => 'Bake Lighting',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Bake Lighting',
        'slug' => 'bake_lighting',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    'renderer' => array(
        'name' => 'Renderer',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Renderer',
        'slug' => 'renderer',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    'world_scale' => array(
        'name' => 'World Scale',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'World Scale',
        'slug' => 'world_scale',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ) ,
    
    'unwrap' => array(
        'name' => 'Unwrap',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Unwrap',
        'slug' => 'unwrap',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ) ,
    
    'texturing_method' => array(
        'name' => 'Texturing Method',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Texturing Method',
        'slug' => 'texturing_method',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ) ,
    
    'print_ready' => array(
        'name' => 'Print Ready',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Print Ready',
        'slug' => 'print_ready',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    'model_quads' => array(
        'name' => 'Model Quads',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Model Quads',
        'slug' => 'model_quads',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    'model_angular' => array(
        'name' => 'Model Angular',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Model Angular',
        'slug' => 'model_angular',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    'game_ready' => array(
        'name' => 'Game Ready',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Game Ready',
        'slug' => 'game_ready',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    'environment' => array(
        'name' => 'Environment',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Environment',
        'slug' => 'environment',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    
    
    
    'model_angular' => array(
        'name' => 'Model Angular',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Model Angular',
        'slug' => 'model_angular',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    'ambient_occlusion_baked' => array(
        'name' => 'Ambient Occlusion Baked',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Ambient Occlusion Baked',
        'slug' => 'ambient_occlusion_baked',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    'unwrapped' => array(
        'name' => 'Unwrapped',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Unwrapped',
        'slug' => 'unwrapped',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    'unwrap_overlap' => array(
        'name' => 'Unwrap Overlap',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Unwrap Overlap',
        'slug' => 'unwrap_overlap',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    'unwrap_stretching' => array(
        'name' => 'Unwrap Stretching',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Unwrap Stretching',
        'slug' => 'unwrap_stretching',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    
    'map_type' => array(
        'name' => 'Additional Map Types',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Additional Map Types',
        'slug' => 'map_type',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    
    'hdr_lighting' => array(
        'name' => 'HDR Image Lighting',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'HDR Image Lighting',
        'slug' => 'hdr_lighting',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    'indirect_illuminate' => array(
        'name' => 'Indirect Illuminate',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Indirect Illuminate',
        'slug' => 'indirect_illuminate',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        ),
    
    
    'procedural_texture' => array(
        'name' => 'Procedural Texture',
        'prefix' => 'ksm_tax_',
        'hierarchical' => false,
        'menu_name' => 'Procedural Texture',
        'slug' => 'procedural_texture',
        'show_in_menu' => false,
        'objects' => array('download', 'ksm_collaboration'),
        'get_terms_method' => 'KSM_DataStore::Terms'
        )
    
    
);