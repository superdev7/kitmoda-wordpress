<?php

$data = array(
    
    'file_error' => array(
        'type' => 'number',
        'rules' => array('required', 'min_1', 'max_5'),
        'sanitize' => array('wp_kses_no_tag'),
        'save_as' => array('post_meta'),
        'tooltip' => 'No 3D File Errors (Files open without error)',
        'label' => 'No 3D File Errors (Files open without error)',
        'visibility' => '*',
        'score_groups' => array('file_error'),
        'assignment' => array(
            'solo' => array(
                '1' => array(4),
                '2' => array(6)
            ),
            'role' => array(
                '3' => array(5),
                '5' => array(4),
                '6' => array(2),
            ),
            'maintenance' => array(
                '4' => array(3),
                '5.1' => array(3),
            ),
            'team' => array(
                '3' => array(1,5),
                '4' => array(1,2,3),
                '5' => array(3,4),
                '5.1' => array(3,4),
                '6' => array(1,2),
            )
        ),
        'field_type' => 'rate'
        ),
    
    '3d_package_content' => array(
        'type' => 'number',
        'rules' => array('required', 'min_1', 'max_5'),
        'sanitize' => array('wp_kses_no_tag'),
        'save_as' => array('post_meta'),
        'tooltip' => '3D Package contents (The downloaded product is not missing any expected files)',
        'label' => '3D Package contents (The downloaded product is not missing any expected files)',
        'visibility' => '*',
        'score_groups' => array('file_error'),
        'assignment' => array(
            'solo' => array(
                '1' => array(4),
                '2' => array(6)
            ),
            'role' => array(
                '3' => array(5),
                //'4' => array('product'),
                '5' => array(4),
                //'5.1' => array('product'),
                '6' => array(2),
            ),
            'maintenance' => array(
                '4' => array(3),
                '5.1' => array(3),
            ),
            'team' => array(
                '3' => array(1,5),
                '4' => array(1,2,3),
                '5' => array(3,4),
                '5.1' => array(3,4),
                '6' => array(1,2)
                )
            ),
        'field_type' => 'rate'
        ),
    
    'texture_map_content' => array(
        'type' => 'number',
        'rules' => array('required', 'min_1', 'max_5'),
        'sanitize' => array('wp_kses_no_tag'),
        'save_as' => array('post_meta'),
        'label' => 'Texture Map Package contents (The downloaded product is not missing any expected files)',
        'visibility' => array('download__model_type' => 'textured'),
        'assignment' => array(
            'solo' => array(
                '2' => array(6),
            ),
            'role' => array(
                '3' => array(5),
                '4' => array(3),
                '5.1' => array(3),
            ),
            'maintenance' => array(),
            'team' => array(
                '3' => array(1,5),
                '4' => array(1,2,3),
                '5' => array(3,4),
                '5.1' => array(3,4),
                '6' => array(1,2),
            )
        ),
        'field_type' => 'rate'
        ),
    
    'image_map_package_content' => array(
        'type' => 'number',
        'rules' => array('required', 'min_1', 'max_5'),
        'sanitize' => array('wp_kses_no_tag'),
        'save_as' => array('post_meta'),
        'label' => 'Image Map Package Contents',
        'visibility' => array(
            
            array('download__model_type' => 'textured'),
            'OR',
            array(
                array('download__model_type' => 'untextured'),
                'AND',
                array(
                    'download__tax_ambient_occlusion_baked__not' => 'no', 'OR',
                    'download__tax_mapping__not' => 'no',
                    'download__tax_hdr_lighting__not' => 'no'
                )
            )
        ),
        
        'assignment' => array(
            'solo' => array(
                '1' => array(4),
                '2' => array(6),
            ),
            'role' => array(
                '3' => array(5),
                '4' => array(
                    array(
                        array(
                            'untextured_download__tax_ambient_occlusion_baked' => 'no',
                            'untextured_download__tax_mapping' => 'no',
                            'untextured_download__tax_hdr_lighting' => 'no'
                        ), 3) 
                ),
                
                '5' => array(4),
                
                '5.1' => array(
                    
                    array(
                        array(
                            'untextured_download__tax_ambient_occlusion_baked' => 'no',
                            'untextured_download__tax_mapping' => 'no',
                            'untextured_download__tax_hdr_lighting' => 'no'
                        ), 3) ,
                    
                ),
                '6' => array(2)
            ),
            'maintenance' => array(
                '4' => array(
                    
                    
                    array(
                        array(
                            'untextured_download__tax_ambient_occlusion_baked__not' => 'no', 'OR',
                            'untextured_download__tax_mapping__not' => 'no',
                            'untextured_download__tax_hdr_lighting__not' => 'no'
                        ), 3)
                    ),
            
                    '5' => array(
                        array(
                        array(
                            'untextured_download__tax_ambient_occlusion_baked__not' => 'no', 'OR',
                            'untextured_download__tax_mapping__not' => 'no',
                            'untextured_download__tax_hdr_lighting__not' => 'no'
                        ), 3)
                    ),
        
                    '5.1' => array(
                        array(
                        array(
                            'untextured_download__tax_ambient_occlusion_baked__not' => 'no', 'OR',
                            'untextured_download__tax_mapping__not' => 'no',
                            'untextured_download__tax_hdr_lighting__not' => 'no'
                        ), 3)
                    )
                
            ),
            'team' => array(
                '3' => array(1,5),
                '4' => array(1,2,3),
                '5' => array(4),
                '5.1' => array(3,4),
                '6' => array(1,2),
            )
        ),
        'field_type' => 'rate'
        ),
    
    '3d_object_naming' => array(
        'type' => 'number',
        'rules' => array('required', 'min_1', 'max_5'),
        'sanitize' => array('wp_kses_no_tag'),
        'save_as' => array('post_meta'),
        'label' => 'Object Naming (objects are named in an organized fashion)',
        'visibility' => '*',
        'score_groups' => array('scene_org'),
        'assignment' => array(
            'solo' => array(
                '1' => array(4),
                '2' => array(6)
            ),
            'role' => array(
                
                '3' => array(5),
                '5' => array(4),
                '6' => array(2),
            ),
            'maintenance' => array(
                '4' => array(3),
                '5.1' => array(3),
            ),
            'team' => array(
                '3' => array(1,5),
                '4' => array(1,2,3),
                '5' => array(4),
                '5.1' => array(3,4),
                '6' => array(1,2),
            )
        ),
        'field_type' => 'rate'
        ),
    
    'grouping' => array(
        'type' => 'number',
        'rules' => array('required', 'min_1', 'max_5'),
        'sanitize' => array('wp_kses_no_tag'),
        'save_as' => array('post_meta'),
        'label' => 'Groups, parenting, and layers (Organized scene heirarchy where applicable)',
        'visibility' => '*',
        'score_groups' => array('scene_org'),
        'assignment' => array(
            'solo' => array(
                '1' => array(4),
                '2' => array(6)
            ),
            'role' => array(
                '3' => array(5),
                '5' => array(4),
                '6' => array(2),
            ),
            'maintenance' => array(
                '4' => array(3),
                '5.1' => array(3),
            ),
            'team' => array(
                '3' => array(1,5),
                '4' => array(1,2,3),
                '5' => array(4),
                '5.1' => array(3,4),
                '6' => array(1,2),
            )
        ),
        'field_type' => 'rate'
        )
    );