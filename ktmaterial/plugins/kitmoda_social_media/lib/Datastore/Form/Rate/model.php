<?php

$data = array (
        
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
        
    );