<?php

$data = array(
        
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
    
        
    );