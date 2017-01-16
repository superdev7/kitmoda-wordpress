<?php

$data = array(
    
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
    
    );

