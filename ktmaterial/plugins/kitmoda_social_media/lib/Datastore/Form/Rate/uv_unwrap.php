<?php

$data = array(
        
            
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
        
    );