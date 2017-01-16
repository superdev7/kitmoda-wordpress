<?php


$data = array(
    
    // Model Information
    
    'modeling_method' => array(
        'type' => 'ds_term_names',
        'rules' => array('not_empty' => "Please Select : Modeling Method"),
        'prepare' => 'ds_term_names_array',
        'save_as' => array('post_terms')
        ),
    'environment' => array(
        'type' => 'ds_term_name',
        'rules' => array('required' => "Please Select : Entire Environment or Single Object"),
        'save_as' => array('post_term')
        ),
    'primary_file_format' => array(
        'type' => 'ds_term_name',
        'tax' => 'file_format',
        'rules' => array('required' => "Please Select : Primary File Format"),
        'save_as' => array('post_term', 'post_meta')
        ),
    'other_file_formats' => array(
        'type' => 'ds_term_names',
        'tax' => 'file_format',
        'prepare' => 'ds_term_names_array',
        'save_as' => array('post_terms')
        ),
    'poly_count' => array(
        'rules' => array('required' => 'Polygon count is required', 'min_1' => "Polygon count should be a number"),
        'type' => 'number',
        'save_as' => array('post_term', 'post_meta')
        ),
    'organization' => array(
        'type' => 'ds_term_name',
        'rules' => array('required' => "Please Select : Are the Objects Named and Organized"),
        'save_as' => array('post_term')
        ),
    'world_scale' => array(
        'type' => 'ds_term_name',
        'rules' => array('required' => "Plesae Select : Does the model match real world scale"),
        'save_as' => array('post_term')
        ),
    'print_ready' => array(
        'type' => 'ds_term_name',
        'rules' => array('required' => "Please Select : Is the Model 3D print ready"),
        'save_as' => array('post_term')
        ),
    'game_ready' => array(
        'type' => 'ds_term_name',
        'rules' => array('required' => "Please Select : Is the model Game and Realtime Rendering Ready"),
        'save_as' => array('post_term')
        ),
    'model_angular' => array(
        'type' => 'ds_term_name',
        'rules' => array('required' => "Please Select : Does the model contain quadrangular or triangulated polygons"),
        'save_as' => array('post_term')
        ),
    
    
    
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
    
    'ap_required' => array(
        'type' => 'string',
        'rules' => array('in_array' => "Please Select : Are additional plugins required to render within the native file"),
        'rules_data' => array('in_array' => array('yes', 'no')),
    ),
    
    'additional_plugins' => array(
        'type' => 'string',
        'sanitize' => array('wp_kses_no_tag'),
        'save_as' => array('post_meta')
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
    
    //
    
    
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
    
    
    // UV Unwrap
    'unwrapped' => array(
        'type' => 'ds_term_name',
        'rules' => array('required' => 'Please Select : Is the model Unwrapped'),
        'save_as' => array('post_term')
    ),
    'unwrap_overlap' => array(
        'type' => 'ds_term_name',
        'rules' => array('required' => 'Please Select : Unwrap Overlap'),
        'save_as' => array('post_term')
    ),
    'unwrap_stretching' => array(
        'type' => 'ds_term_name',
        'rules' => array('required' => 'Please Select : Unwrap Stretching VS seams'),
        'save_as' => array('post_term')
    )
    
    
    );

?>