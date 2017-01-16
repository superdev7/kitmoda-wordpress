<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$data = array(
    
    
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
            
            
        
    );