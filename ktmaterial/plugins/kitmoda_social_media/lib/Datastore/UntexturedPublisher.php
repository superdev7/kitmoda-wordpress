<?php


$data = array(
    'type' => 'UntexturedPublisher',
    'steps' => array(
        1 => array(
            'width' => '726',
            'height' => '956',
            'title' => 'Publish Untextured Model to Store',
            'name' => 'images'
            ) , 
        array(
            'width' => '726',
            'height' => '1294',
            'title' => 'Publish Untextured Model to Store',
            'name' => 'description'
        ),
            
        array(
            'width' => '726',
            'height' => '2394',
            'title' => 'Publish Untextured Model to Store',
            'name' => 'tech'
        ),
        array(
            'width' => '726',
            'height' => '2394',
            'title' => 'Publish Untextured Model to Store',
            'name' => 'upload'
        )
    ) ,
    
    'uploaders' => array('utpi'),
    
    'tech_taxonomy_fields' => array(
        'environment',
        'primary_file_format' => array('tax' => 'file_format'),
        'other_file_formats' => array('tax' => 'file_format','multi' => true),
        'poly_count',
        'organization',
        'world_scale',
        'print_ready',
        'game_ready',
        'model_quads',
        'renderer',
        'lighting',
        'bake_lighting',
        'texturing_method',
        'unwrap',
        'modeling_method' => array('multi' => true),
        'mapping' => array('multi' => true)
    )
    
    
);


