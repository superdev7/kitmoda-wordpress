<?php

$data = array(
    
    
    

    

//array(download__concept_created => 'yes' , 4),
//array(download__concept_created => 'no' , 2)


//array(download__concept_created => 'yes' , 6),
//array(download__concept_created => 'no' , 5)
    
    
    
    'files_scene' => array(
        'title' => 'FILES AND SCENE',
        'fields' => array(
            
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
            
        )
    ),
    
    
    
    
    'concept_art' => array(
        'title' => 'Concept Art',
        'fields' => array(
            
            'creativity' => array(
                'type' => 'number',
                'rules' => array('required', 'min_1', 'max_5'),
                'sanitize' => array('wp_kses_no_tag'),
                'save_as' => array('post_meta'),
                'label' => 'Creativity (Originality of design)',
                'visibility' => array('download__concept_created' => "yes"),
                'score_groups' => array('concept'),
                'assignment' => array(
                    'solo' => array(
                        '1' => array(4),
                        '2' => array(6),
                    ),
                    'role' => array(
                        
                        '3' => array(1),
                        '4' => array(1),
                        '5' => array(4),
                        '5.1' => array(4),
                        '6' => array(1),
                    ),
                    'maintenance' => array(),
                    'team' => array(
                        '3' => array(1,5),
                        '4' => array(1,2,3),
                        '5' => array(4),
                        '5.1' => array(3,4),
                        '6' => array(1,2),
                    ),
                    'concept' => array(
                        '1' => array(1),
                        '2' => array(1),
                        '3' => array(1),
                        '4' => array(1),
                        '5' => array(1),
                        '5.1' => array(1),
                        '6' => array(1),
                    )
                    
                ),
                'field_type' => 'rate'
                ),

        'style' => array(
            'type' => 'number',
            'rules' => array('required', 'min_1', 'max_5'),
            'sanitize' => array('wp_kses_no_tag'),
            'save_as' => array('post_meta'),
            'label' => 'Style (Appeal of the design style)',
            'visibility' => array('download__concept_created' => "yes"),
            'score_groups' => array('concept'),
            'assignment' => array(
                    'solo' => array(
                        '1' => array(4),
                        '2' => array(6)
                    ),
                    'role' => array(
                        '3' => array(1),
                        '4' => array(1),
                        '5' => array(4),
                        '5.1' => array(4),
                        '6' => array(1),
                    ),
                    'maintenance' => array(),
                    'team' => array(
                        '3' => array(1,5),
                        '4' => array(1,2,3),
                        '5' => array(4),
                        '5.1' => array(3,4),
                        '6' => array(1,2),
                    ),
                    'concept' => array(
                        '1' => array(1),
                        '2' => array(1),
                        '3' => array(1),
                        '4' => array(1),
                        '5' => array(1),
                        '5.1' => array(1),
                        '6' => array(1),
                    )
                ),
            
            'field_type' => 'rate'
            ),

        'concept' => array(
            'type' => 'number',
            'rules' => array('required', 'min_1', 'max_5'),
            'sanitize' => array('wp_kses_no_tag'),
            'save_as' => array('post_meta'),
            'label' => 'Overall Concept (Overall concept)',
            'visibility' => array('download__concept_created' => "yes"),
            'score_groups' => array('concept'),
            'assignment' => array(
                    'solo' => array(
                        '1' => array(4),
                        '2' => array(6)
                    ),
                    'role' => array(
                        '3' => array(1),
                        '4' => array(1),
                        '5' => array(4),
                        '5.1' => array(4),
                        '6' => array(1),
                    ),
                    'maintenance' => array(),
                    'team' => array(
                        '3' => array(1,5),
                        '4' => array(1,2,3),
                        '5' => array(4),
                        '5.1' => array(3,4),
                        '6' => array(1,2),
                    ),
                    'concept' => array(
                        '1' => array(1),
                        '2' => array(1),
                        '3' => array(1),
                        '4' => array(1),
                        '5' => array(1),
                        '5.1' => array(1),
                        '6' => array(1),
                    )
                ),
            'field_type' => 'rate'
            )
        )
    ),
    
    
    
    
    'model' => array(
        'title' => 'Model',
        'fields' => array(
            'artistic_quality' => array(
            'type' => 'number',
            'rules' => array('required', 'min_1', 'max_5'),
            'sanitize' => array('wp_kses_no_tag'),
            'save_as' => array('post_meta'),
            'label' => 'Overall artistic quality',
            'visibility' => '*',
            'score_groups' => array('model'),
                'assignment' => array(
                    'solo' => array(
                        '1' => array(4),
                        '2' => array(6),
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
                    ),
                    'model' => array(
                        '1' => array(2),
                        '2' => array(2),
                        '3' => array(2),
                        //'4' => array(2),
                        '5' => array(2),
                        '5.1' => array(2),
                        '6' => array(2),
                    )
                ),
            'field_type' => 'rate'
            ),

        'scale' => array(
            'type' => 'number',
            'rules' => array('required', 'min_1', 'max_5'),
            'sanitize' => array('wp_kses_no_tag'),
            'save_as' => array('post_meta'),
            'label' => 'Scale (approximates real world units)',
            'visibility' => '*',
            'score_groups' => array('model'),
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
                    ),
                    'model' => array(
                        '1' => array(2),
                        '2' => array(2),
                        '3' => array(2),
                        //'4' => array(2),
                        '5' => array(2),
                        '5.1' => array(2),
                        '6' => array(2),
                    )
                ),
            'field_type' => 'rate'
            ),

        'polygon_count' => array(
            'type' => 'number',
            'rules' => array('required', 'min_1', 'max_5'),
            'sanitize' => array('wp_kses_no_tag'),
            'save_as' => array('post_meta'),
            'label' => 'Polygon Count is Accurate',
            'visibility' => '*',
            'score_groups' => array('model'),
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
                    ),
                    'model' => array(
                        '1' => array(2),
                        '2' => array(2),
                        '3' => array(2),
                        //'4' => array(2),
                        '5' => array(2),
                        '5.1' => array(2),
                        '6' => array(2),
                    )
                ),
            'field_type' => 'rate'
            ),

        'polygon_structure' => array(
            'type' => 'number',
            'rules' => array('required', 'min_1', 'max_5'),
            'sanitize' => array('wp_kses_no_tag'),
            'save_as' => array('post_meta'),
            'label' => 'Polygon Structure (Clean flow lines and/or efficient poly use)',
            'visibility' => '*',
            'score_groups' => array('model'),
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
                        '5.1' => array(3)
                    ),
                    'team' => array(
                        '3' => array(1,5),
                        '4' => array(1,2,3),
                        '5' => array(4),
                        '5.1' => array(3,4),
                        '6' => array(1,2),
                    ),
                    'model' => array(
                        '1' => array(2),
                        '2' => array(2),
                        '3' => array(2),
                        //'4' => array(2),
                        '5' => array(2),
                        '5.1' => array(2),
                        '6' => array(2),
                    )
                ),
            'field_type' => 'rate'
            ),

        'polygonal_errors' => array(
            'type' => 'number',
            'rules' => array('required', 'min_1', 'max_5'),
            'sanitize' => array('wp_kses_no_tag'),
            'save_as' => array('post_meta'),
            'label' => 'No Polygonal Errors (See Poly Errors for Info)',
            'visibility' => '*',
            'score_groups' => array('model'),
            'assignment' => array(
                    'solo' => array(
                        '1' => array(4),
                        '2' => array(6),
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
                    ),
                    'model' => array(
                        '1' => array(2),
                        '2' => array(2),
                        '3' => array(2),
                        //'4' => array(2),
                        '5' => array(2),
                        '5.1' => array(2),
                        '6' => array(2),
                    )
                ),
            'field_type' => 'rate'
            ),

        'model_detail' => array(
            'type' => 'number',
            'rules' => array('required', 'min_1', 'max_5'),
            'sanitize' => array('wp_kses_no_tag'),
            'save_as' => array('post_meta'),
            'label' => 'Model Detail (Contains adequate details and beveling)',
            'visibility' => '*',
            'score_groups' => array('model'),
            'assignment' => array(
                    'solo' => array(
                        '1' => array(4),
                        '2' => array(6),
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
                    ),
                    'model' => array(
                        '1' => array(2),
                        '2' => array(2),
                        '3' => array(2),
                        //'4' => array(2),
                        '5' => array(2),
                        '5.1' => array(2),
                        '6' => array(2),
                    )
                ),
            'field_type' => 'rate'
            ),

        '3d_print_viability' => array(
            'type' => 'number',
            'rules' => array('required', 'min_1', 'max_5'),
            'sanitize' => array('wp_kses_no_tag'),
            'save_as' => array('post_meta'),
            'label' => '3D print viability',
            'visibility' => array('download__tax_print_ready' => 'yes'),
            'score_groups' => array('model'),
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
                    ),
                    'model' => array(
                        '1' => array(2),
                        '2' => array(2),
                        '3' => array(2),
                        //'4' => array(2),
                        '5' => array(2),
                        '5.1' => array(2),
                        '6' => array(2),
                    )
                ),
            'field_type' => 'rate'
            ),




        'realtime_game_viability' => array(
            'type' => 'number',
            'rules' => array('required', 'min_1', 'max_5'),
            'sanitize' => array('wp_kses_no_tag'),
            'save_as' => array('post_meta'),
            'label' => 'Realtime/game viability (Model is built correctly for realtime rendering)',
            'visibility' => array('download__tax_game_ready__not' => 'no'),
            'score_groups' => array('model'),
            'assignment' => array(
                    'solo' => array(
                        '1' => array(4),
                        '2' => array(6),
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
                    ),
                    'model' => array(
                        '1' => array(2),
                        '2' => array(2),
                        '3' => array(2),
                        //'4' => array(2),
                        '5' => array(2),
                        '5.1' => array(2),
                        '6' => array(2),
                    )
                ),
            'field_type' => 'rate'
            )
        )
    ),
    
    
    
    
    'UV Unwrap' => array(
        'title' => 'UV Unwrap',
        'fields' => array(
            
            'unwrapped' => array(
                'type' => 'number',
                'rules' => array('required', 'min_1', 'max_5'),
                'sanitize' => array('wp_kses_no_tag'),
                'save_as' => array('post_meta'),
                'label' => 'All objects are unwrapped (No missing UVS)',
                'visibility' => array('download__tax_unwrapped__not' => 'no'),
                'score_groups' => array('uv_unwrap'),
                'assignment' => array(
                    'solo' => array(
                        '1' => array(4),
                        '2' => array(6)
                    ),
                    'role' => array(
                        '3' => array(5),
                        '4' => array(
                            array('untextured_download__tax_unwrapped' => 'no', 3),
                            array('untextured_download__tax_unwrapped' => 'yes', 2),
                        ),
                        '5' => array(
                            array('untextured_download__tax_unwrapped' => 'yes', 4),
                        ),
                        '5.1' => array(
                            array('untextured_download__tax_unwrapped' => 'no', 3),
                            array('untextured_download__tax_unwrapped' => 'yes', 4),
                        ),
                        '6' => array(
                            array('untextured_download__tax_unwrapped' => 'yes', 2),
                        ),
                    ),
                    'maintenance' => array(
                        '4' => array(
                            array('untextured_download__tax_unwrapped' => 'yes', 3)
                        ),
                        '5.1' => array(
                            array('untextured_download__tax_unwrapped' => 'yes', 3)
                        ),
                    ),
                    'team' => array(
                        '3' => array(1,5),
                        '4' => array(
                            array('untextured_download__tax_unwrapped' => 'yes', 1),
                            array('untextured_download__tax_unwrapped' => 'yes', 2),
                            array('untextured_download__tax_unwrapped' => 'yes', 3)
                        ),
                        '5' => array(4),
                        '5.1' => array(3,4),
                        '6' => array(1,2),
                    )
                ),
                'field_type' => 'rate'
                ),





            'uv_stretching' => array(
                'type' => 'number',
                'rules' => array('required', 'min_1', 'max_5'),
                'sanitize' => array('wp_kses_no_tag'),
                'save_as' => array('post_meta'),
                'label' => 'Minimal UV Stretching - (UV stretching is not excessive)',
                'visibility' => array(
                    'download__tax_unwrapped__not' => 'no',
                    'download__tax_unwrap_stretching' => array('less-stretching','balanced')
                    ),
                'score_groups' => array('uv_unwrap'),
                'assignment' => array(
                    
                    'solo' => array(
                        '1' => array(4),
                        '2' => array(6)
                    ),
                    'role' => array(
                        '3' => array(5),
                        '4' => array(
                            array('untextured_download__tax_unwrapped' => 'no', 3),
                            array('untextured_download__tax_unwrapped' => 'yes', 2),
                        ),
                        '5' => array(
                            array('untextured_download__tax_unwrapped' => 'yes', 4),
                        ),
                        '5.1' => array(
                            array('untextured_download__tax_unwrapped' => 'no', 3),
                            array('untextured_download__tax_unwrapped' => 'yes', 4),
                        ),
                        '6' => array(
                            array('untextured_download__tax_unwrapped' => 'yes', 2),
                        ),
                    ),
                    'maintenance' => array(
                        '4' => array(
                            array('untextured_download__tax_unwrapped' => 'yes', 3)
                        ),
                        '5.1' => array(
                            array('untextured_download__tax_unwrapped' => 'yes', 3)
                        ),
                    ),
                    'team' => array(
                        '3' => array(1,5),
                        '4' => array(
                            array('untextured_download__tax_unwrapped' => 'yes', 1),
                            array('untextured_download__tax_unwrapped' => 'yes', 2),
                            array('untextured_download__tax_unwrapped' => 'yes', 3)
                        ),
                        '5' => array(4),
                        '5.1' => array(3,4),
                        '6' => array(1,2),
                    )
                    
                ),
                'field_type' => 'rate'
                ),

            'uv_seams' => array(
                'type' => 'number',
                'rules' => array('required', 'min_1', 'max_5'),
                'sanitize' => array('wp_kses_no_tag'),
                'save_as' => array('post_meta'),
                'label' => 'Minimal UV Seams – (Not an unnecessary amount of UV Shells)',
                'visibility' => array(
                    'download__tax_unwrapped__not' => 'no',
                    'download__tax_unwrap_stretching' => array('less-seam','balanced')
                    ),
                'score_groups' => array('uv_unwrap'),
                'assignment' => array(
                    
                    'solo' => array(
                        '1' => array(4),
                        '2' => array(6)
                    ),
                    'role' => array(
                        '3' => array(5),
                        '4' => array(
                            array('untextured_download__tax_unwrapped' => 'no', 3),
                            array('untextured_download__tax_unwrapped' => 'yes', 2),
                        ),
                        '5' => array(
                            array('untextured_download__tax_unwrapped' => 'yes', 4),
                        ),
                        '5.1' => array(
                            array('untextured_download__tax_unwrapped' => 'no', 3),
                            array('untextured_download__tax_unwrapped' => 'yes', 4),
                        ),
                        '6' => array(
                            array('untextured_download__tax_unwrapped' => 'yes', 2),
                        ),
                    ),
                    'maintenance' => array(
                        '4' => array(
                            array('untextured_download__tax_unwrapped' => 'yes', 3)
                        ),
                        '5.1' => array(
                            array('untextured_download__tax_unwrapped' => 'yes', 3)
                        ),
                    ),
                    'team' => array(
                        '3' => array(1,5),
                        '4' => array(
                            array('untextured_download__tax_unwrapped' => 'yes', 1),
                            array('untextured_download__tax_unwrapped' => 'yes', 2),
                            array('untextured_download__tax_unwrapped' => 'yes', 3)
                        ),
                        '5' => array(3,4),
                        '5.1' => array(3,4),
                        '6' => array(1,2),
                    )
                ),
                'field_type' => 'rate'
                ),

            'unwrap_overlap' => array(
                'type' => 'number',
                'rules' => array('required', 'min_1', 'max_5'),
                'sanitize' => array('wp_kses_no_tag'),
                'save_as' => array('post_meta'),
                'label' => 'Unwrap Overlap – (No unintentional overlap)',
                'visibility' => array(
                    'download__tax_unwrapped__not' => 'no',
                    'download__tax_unwrap_overlap' => 'no'
                    ),
                'score_groups' => array('uv_unwrap'),
                'assignment' => array(
                    'solo' => array(
                        '1' => array(4),
                        '2' => array(6)
                    ),
                    'role' => array(
                        '3' => array(5),
                        '4' => array(
                            array('untextured_download__tax_unwrapped' => 'no', 3),
                            array('untextured_download__tax_unwrapped' => 'yes', 2),
                        ),
                        '5' => array(
                            array('download__tax_unwrapped' => 'yes', 4),
                        ),
                        '5.1' => array(
                            array('untextured_download__tax_unwrapped' => 'no', 3),
                            array('untextured_download__tax_unwrapped' => 'yes', 4),
                        ),
                        '6' => array(
                            array('download__tax_unwrapped' => 'yes', 2),
                        ),
                    ),
                    'maintenance' => array(
                        '4' => array(
                            array('untextured_download__tax_unwrapped' => 'yes', 3)
                        ),
                        '5.1' => array(
                            array('untextured_download__tax_unwrapped' => 'yes', 3)
                        ),
                    ),
                    'team' => array(
                        '3' => array(1,5),
                        '4' => array(
                            array('untextured_download__tax_unwrapped' => 'yes', 1),
                            array('untextured_download__tax_unwrapped' => 'yes', 2),
                            array('untextured_download__tax_unwrapped' => 'yes', 3)
                        ),
                        '5' => array(3,4),
                        '5.1' => array(3,4),
                        '6' => array(1,2),
                    )
                ),
                'field_type' => 'rate'
                )
            
        )
    ),
    
    
    
    
    
    
    
    
    
    'image_maps' => array(
        'title' => 'Image Maps',
        'fields' => array(
            
            'texture_quality' => array(
                'type' => 'number',
                'rules' => array('required', 'min_1', 'max_5'),
                'sanitize' => array('wp_kses_no_tag'),
                'save_as' => array('post_meta'),
                'label' => 'Overall Texture Quality',
                'visibility' => array('download__model_type' => 'textured'),
                'score_groups' => array('texture'),
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
                    ),
                    'texture' => array(
                        '2' => array(3),
                        '3' => array(3),
                        '4' => array(3),
                        '5.1' => array(3),
                    ),
                    
                ),
                'field_type' => 'rate'
                ),

            'texture_detail' => array(
                'type' => 'number',
                'rules' => array('required', 'min_1', 'max_5'),
                'sanitize' => array('wp_kses_no_tag'),
                'save_as' => array('post_meta'),
                'label' => 'Texture detail (Maps are adequately detailed for item)',
                'visibility' => array('download__model_type' => 'textured'),
                'score_groups' => array('texture'),
                'assignment' => array(
                    'solo' => array(
                        '2' => array(6)
                    ),
                    'role' => array(
                        '3' => array(5),
                        '4' => array(3),
                        '5.1' => array(3)
                    ),
                    'maintenance' => array(),
                    'team' => array(
                        '3' => array(1,5),
                        '4' => array(1,2,3),
                        '5' => array(3,4),
                        '5.1' => array(3,4),
                        '6' => array(1,2),
                    ),
                    'texture' => array(
                        '2' => array(3),
                        '3' => array(3),
                        '4' => array(3),
                        '5.1' => array(3),
                    ),
                ),
                'field_type' => 'rate'
                ),

            'normal_displacements' => array(
                'type' => 'number',
                'rules' => array('required', 'min_1', 'max_5'),
                'sanitize' => array('wp_kses_no_tag'),
                'save_as' => array('post_meta'),
                'label' => 'Normal Maps and Displacements',
                'visibility' => array(
                    'download__tax_mapping' => array('normal', 'displacement', 'both')
                    ),
                'score_groups' => array('texture'),
                'assignment' => array(
                    'solo' => array(
                        '1' => array(4),
                        '2' => array(6)
                    ),
                    'role' => array(
                        '3' => array(
                            array('download__tax_mapping' => array('normal', 'displacement', 'both'), 5),
                        ),
                        '4' => array(
                            
                            array(
                                array(
                                    'untextured_download__tax_mapping__not' => array('normal', 'displacement', 'both'),
                                    'textured_download__tax_mapping' => array('normal', 'displacement', 'both')
                                ),
                                3
                            )
                            
                            
                        ),
                        '5' => array(
                            array('download__tax_mapping' => array('normal', 'displacement', 'both'), 4),
                        ),
                        '5.1' => array(
                            
                            array(
                                array(
                                    array('untextured_download__tax_mapping__not' => array('normal', 'displacement', 'both')),
                                    array('textured_download__tax_mapping' => array('normal', 'displacement', 'both'))
                                ),
                                3
                            )
                        ),
                        '6' => array(
                            array('untextured_download__tax_mapping' => array('normal', 'displacement', 'both'), 2),
                        ),
                    ),
                    'maintenance' => array(
                        '4' => array(
                            array('untextured_download__tax_mapping' => array('normal', 'displacement', 'both')
                                , 3)
                        ),
                        '5.1' => array(
                            array('untextured_download__tax_mapping' => array('normal', 'displacement', 'both'), 3)
                        )
                    ),
                    'team' => array(
                        '3' => array(1,5),
                        '4' => array(1,2,3),
                        '5' => array(3,4),
                        '5.1' => array(3,4),
                        '6' => array(1,2),
                    ),
                    'texture' => array(
                        '2' => array(3),
                        '3' => array(3),
                        '4' => array(3),
                        '5.1' => array(3),
                    ),
                ),
                'field_type' => 'rate'
                ),
            
            
            
            
            'diffuse' => array(
                'type' => 'number',
                'rules' => array('required', 'min_1', 'max_5'),
                'sanitize' => array('wp_kses_no_tag'),
                'save_as' => array('post_meta'),
                'label' => 'Diffuse (Color)',
                'visibility' => array(
                    'textured_download__tax_map_type' => 'diffuse'
                    ),
                'score_groups' => array('texture'),
                'assignment' => array(
                    'solo' => array(
                        '2' => array(6)
                    ),
                    'role' => array(
                        '3' => array(5),
                        '4' => array(3),
                        '5.1' => array(3)
                    ),
                    'maintenance' => array(),
                    'team' => array(
                        '3' => array(1,5),
                        '4' => array(1,2,3),
                        '5' => array(3,4),
                        '5.1' => array(3,4),
                        '6' => array(1,2),
                    ),
                    'texture' => array(
                        '2' => array(3),
                        '3' => array(3),
                        '4' => array(3),
                        '5.1' => array(3),
                    ),
                ),
                'field_type' => 'rate'
                ),
            
            
            'opacity' => array(
                'type' => 'number',
                'rules' => array('required', 'min_1', 'max_5'),
                'sanitize' => array('wp_kses_no_tag'),
                'save_as' => array('post_meta'),
                'label' => 'Opacity / Transparency',
                'visibility' => array(
                    'textured_download__tax_map_type' => 'opacity'
                    ),
                'score_groups' => array('texture'),
                'assignment' => array(
                    'solo' => array(
                        '2' => array(6)
                    ),
                    'role' => array(
                        '3' => array(5),
                        '4' => array(3),
                        '5.1' => array(3)
                    ),
                    'maintenance' => array(),
                    'team' => array(
                        '3' => array(1,5),
                        '4' => array(1,2,3),
                        '5' => array(3,4),
                        '5.1' => array(3,4),
                        '6' => array(1,2),
                    ),
                    'texture' => array(
                        '2' => array(3),
                        '3' => array(3),
                        '4' => array(3),
                        '5.1' => array(3),
                    ),
                ),
                'field_type' => 'rate'
                ),
            
            
            'specular_glossiness' => array(
                'type' => 'number',
                'rules' => array('required', 'min_1', 'max_5'),
                'sanitize' => array('wp_kses_no_tag'),
                'save_as' => array('post_meta'),
                'label' => 'Specular Glossiness / Shinyness',
                'visibility' => array(
                    'textured_download__tax_map_type' => 'specular-level'
                    ),
                'score_groups' => array('texture'),
                'assignment' => array(
                    'solo' => array(
                        '2' => array(6)
                    ),
                    'role' => array(
                        '3' => array(5),
                        '4' => array(3),
                        '5.1' => array(3)
                    ),
                    'maintenance' => array(),
                    'team' => array(
                        '3' => array(1,5),
                        '4' => array(1,2,3),
                        '5' => array(3,4),
                        '5.1' => array(3,4),
                        '6' => array(1,2),
                    ),
                    'texture' => array(
                        '2' => array(3),
                        '3' => array(3),
                        '4' => array(3),
                        '5.1' => array(3),
                    ),
                ),
                'field_type' => 'rate'
                ),
            
            
            
            
            'self_ambient' => array(
                'type' => 'number',
                'rules' => array('required', 'min_1', 'max_5'),
                'sanitize' => array('wp_kses_no_tag'),
                'save_as' => array('post_meta'),
                'label' => 'Self Illumination/Ambient',
                'visibility' => array(
                    'textured_download__tax_map_type' => 'specular-level'
                    ),
                'score_groups' => array('texture'),
                'assignment' => array(
                    'solo' => array(
                        '2' => array(6)
                    ),
                    'role' => array(
                        '3' => array(5),
                        '4' => array(3),
                        '5.1' => array(3)
                    ),
                    'maintenance' => array(),
                    'team' => array(
                        '3' => array(1,5),
                        '4' => array(1,2,3),
                        '5' => array(3,4),
                        '5.1' => array(3,4),
                        '6' => array(1,2),
                    ),
                    'texture' => array(
                        '2' => array(3),
                        '3' => array(3),
                        '4' => array(3),
                        '5.1' => array(3),
                    ),
                ),
                'field_type' => 'rate'
                ),
            
            
            
            
            
            'roughness_glossiness' => array(
                'type' => 'number',
                'rules' => array('required', 'min_1', 'max_5'),
                'sanitize' => array('wp_kses_no_tag'),
                'save_as' => array('post_meta'),
                'label' => 'Roughness / Glossiness',
                'visibility' => array(
                    'textured_download__tax_map_type' => 'roughness'
                    ),
                'score_groups' => array('texture'),
                'assignment' => array(
                    'solo' => array(
                        '2' => array(6)
                    ),
                    'role' => array(
                        '3' => array(5),
                        '4' => array(3),
                        '5.1' => array(3)
                    ),
                    'maintenance' => array(),
                    'team' => array(
                        '3' => array(1,5),
                        '4' => array(1,2,3),
                        '5' => array(3,4),
                        '5.1' => array(3,4),
                        '6' => array(1,2),
                    ),
                    'texture' => array(
                        '2' => array(3),
                        '3' => array(3),
                        '4' => array(3),
                        '5.1' => array(3),
                    ),
                ),
                'field_type' => 'rate'
                ),
            
            
            
            
            
            'specular_reflectivity' => array(
                'type' => 'number',
                'rules' => array('required', 'min_1', 'max_5'),
                'sanitize' => array('wp_kses_no_tag'),
                'save_as' => array('post_meta'),
                'label' => 'Specular / Reflectivity',
                'visibility' => array(
                    'textured_download__tax_map_type' => 'specular-reflectivity'
                    ),
                'score_groups' => array('texture'),
                'assignment' => array(
                    'solo' => array(
                        '2' => array(6)
                    ),
                    'role' => array(
                        '3' => array(5),
                        '4' => array(3),
                        '5.1' => array(3)
                    ),
                    'maintenance' => array(),
                    'team' => array(
                        '3' => array(1,5),
                        '4' => array(1,2,3),
                        '5' => array(3,4),
                        '5.1' => array(3,4),
                        '6' => array(1,2),
                    ),
                    'texture' => array(
                        '2' => array(3),
                        '3' => array(3),
                        '4' => array(3),
                        '5.1' => array(3),
                    ),
                ),
                'field_type' => 'rate'
                )
            
            
        )
    ),
    
    
    
    
    'lighting' => array(
        'title' => 'Lighting and rendering',
        'fields' => array(
            'lighting_visibility' => array(
                'type' => 'number',
                'rules' => array('required', 'min_1', 'max_5'),
                'sanitize' => array('wp_kses_no_tag'),
                'save_as' => array('post_meta'),
                'label' => 'Lighting Visibility (Clearly illuminates objects)',
                'visibility' => array('download__tax_lighting' => 'yes'),
                'score_groups' => array('lighting'),
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
                                    'untextured_download__tax_lighting' => 'no', 
                                    'textured_download__tax_lighting' => 'yes'
                                    ),3)
                        ),
                        '5' => array(
                            array('download__tax_lighting' => 'yes', 4)
                        ),
                        '5.1' => array(
                            array(
                                array(
                                    'untextured_download__tax_lighting' => 'no', 
                                    'textured_download__tax_lighting' => 'yes'
                                    ),3)
                        ),
                        '6' => array(
                            array('untextured_download__tax_lighting' => 'yes', 2)
                        ),
                    ),
                    'maintenance' => array(
                        '4' => array(
                            array('untextured_download__tax_lighting' => 'yes', 3)
                        ),
                        '5.1' => array(
                            array('untextured_download__tax_lighting' => 'yes', 3)
                        )
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

            'lighting_appeal' => array(
                'type' => 'number',
                'rules' => array('required', 'min_1', 'max_5'),
                'sanitize' => array('wp_kses_no_tag'),
                'save_as' => array('post_meta'),
                'label' => 'Lighting Appeal',
                'visibility' => array('download__tax_lighting' => 'yes'),
                'score_groups' => array('lighting'),
                'assignment' => array(
                    'solo' => array(
                        '1' => array(4),
                        '2' => array(6),
                    ),
                    'role' => array(
                        '3' => array(3),
                        
                        '4' => array(
                            array(
                                array(
                                    'untextured_download__tax_lighting' => 'no', 
                                    'textured_download__tax_lighting' => 'yes'
                                    ),3)
                        ),
                        '5' => array(
                            array('untextured_download__tax_lighting' => 'yes', 4)
                        ),
                        '5.1' => array(
                            array(
                                array(
                                    'untextured_download__tax_lighting' => 'no', 
                                    'textured_download__tax_lighting' => 'yes'
                                    ),3)
                        ),
                        '6' => array(
                            array('untextured_download__tax_lighting' => 'yes', 2)
                        ),
                    ),
                    'maintenance' => array(
                        '4' => array(
                            array('untextured_download__tax_lighting' => 'yes', 3)
                        ),
                        '5.1' => array(
                            array('untextured_download__tax_lighting' => 'yes', 3)
                        )
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
            
            
            'hdr_lighting' => array(
                'type' => 'number',
                'rules' => array('required', 'min_1', 'max_5'),
                'sanitize' => array('wp_kses_no_tag'),
                'save_as' => array('post_meta'),
                'label' => 'HDRI Lighting is Rendering and High Quality (Within primary file)',
                'visibility' => array('download__tax_hdr_lighting' => 'yes'),
                'score_groups' => array('lighting'),
                'assignment' => array(
                    'solo' => array(
                        '1' => array(4),
                        '2' => array(6),
                    ),
                    'role' => array(
                        '3' => array(
                            array('textured_download__tax_hdr_lighting' => 'yes', 5)
                        ),
                        
                        '4' => array(
                            array(
                                array(
                                    'untextured_download__tax_hdr_lighting' => 'no', 
                                    'textured_download__tax_hdr_lighting' => 'yes'),
                                3)
                        ),
                        '5' => array(
                            array('untextured_download__tax_hdr_lighting' => 'yes', 4)
                        ),
                        '5.1' => array(
                            array(
                                array(
                                    'untextured_download__tax_hdr_lighting' => 'no', 
                                    'textured_download__tax_hdr_lighting' => 'yes'),
                                3)
                        ),
                        '6' => array(
                            array('untextured_download__tax_hdr_lighting' => 'yes', 2)
                        ),
                    ),
                    'maintenance' => array(
                        '4' => array(
                            array('untextured_download__tax_hdr_lighting' => 'yes', 3)
                        ),
                        '5.1' => array(
                            array('untextured_download__tax_hdr_lighting' => 'yes', 3)
                        )
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
            
            'indirect_illuminate' => array(
                'type' => 'number',
                'rules' => array('required', 'min_1', 'max_5'),
                'sanitize' => array('wp_kses_no_tag'),
                'save_as' => array('post_meta'),
                'label' => 'GI or indirect illumination (Within primary file)',
                'visibility' => array('download__tax_indirect_illuminate' => 'yes'),
                'score_groups' => array('lighting'),
                'assignment' => array(
                    'solo' => array(
                        '1' => array(4),
                        '2' => array(6),
                    ),
                    'role' => array(
                        '3' => array(
                            array('textured_download__tax_indirect_illuminate' => 'yes', 5)
                        ),
                        
                        '4' => array(
                            array(
                                array(
                                    'untextured_download__tax_indirect_illuminate' => 'no', 
                                    'textured_download__tax_indirect_illuminate' => 'yes'),
                                3)
                        ),
                        '5' => array(
                            array('untextured_download__tax_indirect_illuminate' => 'yes', 4)
                        ),
                        '5.1' => array(
                            array(
                                array(
                                    'untextured_download__tax_indirect_illuminate' => 'no', 
                                    'textured_download__tax_indirect_illuminate' => 'yes'),
                                3)
                        ),
                        '6' => array(
                            array('untextured_download__tax_indirect_illuminate' => 'yes', 2)
                        ),
                    ),
                    'maintenance' => array(
                        '4' => array(
                            array('untextured_download__tax_indirect_illuminate' => 'yes', 3)
                        ),
                        '5.1' => array(
                            array('untextured_download__tax_indirect_illuminate' => 'yes', 3)
                        )
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
                )
            
        )
    )
    
);

?>