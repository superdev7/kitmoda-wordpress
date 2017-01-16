<?php


$data = array(
    
    
    
    
    // Rendering Information
    'renderer' => array(
        'type' => 'ds_term_name',
        'rules' => array('required' => "Please Select : What renderer was used for the featured image"),
        'save_as' => array('post_term')
        ),
    
    'lighting' => array(
        'type' => 'ds_term_name',
        'rules' => array('required' => "Please Select : Is the lighting setup included within the main file"),
        'save_as' => array('post_term')
        ),
    
    
    
    'hdr_lighting' => array(
        'type' => 'ds_term_name',
        'rules' => array('required' => 'Please Select : Is HDR lighting used'),
        'save_as' => array('post_term')
        ),
    'indirect_illuminate' => array(
        'type' => 'ds_term_name',
        'rules' => array('required' => 'Please Select : Is GI or Indirect Illumination used'),
        'save_as' => array('post_term')
        ),
    
    
    'mapping' => array(
        'type' => 'ds_term_name',
        'rules' => array('not_empty' => "Please Select : Which map types were used to render details"),
        'save_as' => array('post_term')
        ),
    
    'ambient_occlusion_baked' => array(
        'type' => 'ds_term_name',
        'rules' => array('required' => 'Please Select : Is ambient occlusion baked into this model'),
        'save_as' => array('post_term')
    ),
    
    
    
    
    // Texture Information
    'texturing_method' => array(
        'type' => 'ds_term_name',
        'rules' => array('required' => 'Please Select : How were the textures created'),
        'save_as' => array('post_term')
        ),
    
    
    'map_type'=> array(
        'type' => 'ds_term_names',
        'prepare' => 'ds_term_names_array',
        'save_as' => array('post_terms')
        ),
    
    'procedural_texture' => array(
        'type' => 'ds_term_name',
        'rules' => array('required' => "Please Select : Are procedural textures used within the primary file"),
        'save_as' => array('post_term')
        ),
    
    'unwrap_overlap' => array(
        'type' => 'ds_term_name',
        'rules' => array('required' => 'Please Select : Unwrap Overlap'),
        'save_as' => array('post_term')
    )
    
    
    
    
    
    
    
    
    
    );

?>