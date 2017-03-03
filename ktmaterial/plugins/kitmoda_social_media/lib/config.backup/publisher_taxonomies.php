<?php

$filter_optios = array(
        'price' => array(
            '5-10',
            '10-25',
            '25-50',
            '50-75',
            '75-100',
            '100-150',
            '150-200',
            '200-300',
            '300-more',
        ) , 
        
        
        'style' => array(
            'realism',
            'steam-punk', 
            'gothic',
            'dragons-lore',
            'whimsical-fairytale',
            'horror',
            'sci-fi',
            'decay-dystopia',
            'anime',
            'classic-toon',
            'art-deco',
            'ornate',
            'tribal',
            'film-noir',
            'romantic',
            'surreal',
            'expressive',
            'folksy-rural',
            'stylish-hip',
            'educational',
            'comedy'           
        ),
        
        'era' => array(
            'prehistoric',
            'ancient',
            'historic',
            'retro',
            'present',
            'future'
        ),

        
        'file_format' => array(
            'max',
            'mb',
            'ma',
            'mud', 
            'blend',
            'lwo', 
            'xsi', 
            'c4d', 
            'ztl', 
            'obj', 
            'stl'
        ),
        
        'model_type' => array(
            'next-gen',
            'mobile-dev',
            '3d-print-ready',
            'full-environment'
        ) , 
        
        
        'model_specs' => array(
            'all-quads',
            'over-90-quads',
            'real-worls-scale'
        ),
        
        'poly_count' => array(
            '10-500',
            '500-2k',
            '2k-10k',
            '10k-25k',
            '25k-100k',
            '100k-500k',
            '500k-1m',
            '1m-5m',
            '5m-10m',
            '10m-15m',
            '15m-more'
        ),
        
        
        'texturing' => array(
            'untextured',
            'hand-painted-textures',
            'photographs',
            'procedural',
            'hybrid',
        ),
        
        'mapping' => array(
            'normal',
            'displacement',
            'grayscale-bump'
        ),
        
        'lighting' => array(
            'yes',
            'no'
        ),
            
        'renderer' => array(
            'vray',
            'mental-ray',
            'studio-max',
            'maya',
            'turtle',
            'zbrush',
            'mudbox',
            'iray',
            'indigo',
            'c4d',
            'blender',
            'lightwave'
        )
        
        
    );







$term_labels = array(
    'price' => array(
        '5-10' => array('filter_label' =>     '$5 - $10'),
        '10-25' => array('filter_label' =>    '$10 - $25'),
        '25-50' => array('filter_label' =>    '$25 - $50'),
        '50-75' => array('filter_label' =>    '$50 - $75'),
        '75-100' => array('filter_label' =>   '$75 - $100'),
        '100-150' => array('filter_label' =>  '$100 - $150'),
        '150-200' => array('filter_label' =>  '$150 - $200'),
        '200-300' => array('filter_label' =>  '$200 - $300'),
        '300-more' => array('filter_label' => '> $300'),
        ),
    
    'style' => array(
        'steam-punk' => array('filter_label' => 'Steam Punk'),
        'vampire' => array('filter_label' => 'Vampire'),
        'dragons-lore' => array('filter_label' => 'Dragons and Lore'),
        'whimsical-fairytale' => array('filter_label' => 'Whimsical Fairytale'),
        'horror' => array('filter_label' => 'Horror'),
        'anime-toon' => array('filter_label' => 'Anime Toon'),
        'classic-toon' => array('filter_label' => 'Classic Toon'),
        'simple-toon' => array('filter_label' => 'Simple Toon'),
        'comedy' => array('filter_label' => 'Comedy'),
        'educational' => array('filter_label' => 'Educational/Diagram'),
        'art-deco' => array('filter_label' => 'Art Deco'),
        'ornate' => array('filter_label' => 'Ornate'),
        'tribal' => array('filter_label' => 'Tribal'),
        'film-noir' => array('filter_label' => 'Film Noir'),
        'gothic' => array('filter_label' => 'Gothic'),
        'romantic' => array('filter_label' => 'Romantic'),
        'realism' => array('filter_label' => 'Realism'),
        'surreal' => array('filter_label' => 'Surreal'),
        'tech-robotic' => array('filter_label' => 'Tech Robotic'),
        'retro' => array('filter_label' => 'Retro'),
        'country-rural' => array('filter_label' => 'Country/Rural'),
        'urban' => array('filter_label' => 'Urban')
        ),
        
        'era' => array(
            'prehistoric' => array('filter_label' => 'PREHISTORIC - Before 12000 BC'),
            'ancient' => array('filter_label' => 'ANCIENT - 12000 BC to 1 AD'),
            'historic' => array('filter_label' => "HISTORIC - 1 AD to 1950's"),
            'retro' => array('filter_label' => 'RETRO - 1950 to Present'),
            'present' => array('filter_label' => 'PRESENT'),
            'future' => array('filter_label' => 'FUTURE')
            
        ),
        
        'file_format' => array(
            'max' => array('filter_label' => 'MAX'),
            'mb' => array('filter_label' => 'MB'),
            'ma' => array('filter_label' => 'MA'),
            'mud' => array('filter_label' => 'MUD'),
            'blend' => array('filter_label' => 'BLEND'),
            'lwo' => array('filter_label' => 'LWO'),
            'xsi' => array('filter_label' => 'XSI'),
            'c4d' => array('filter_label' => 'C4D'),
            'ztl' => array('filter_label' => 'ZTL'),
            'obj' => array('filter_label' => 'OBJ'),
            'stl' => array('filter_label' => 'STL')
        ),
        
        'model_type' => array(
           'next-gen' => array('filter_label' => 'GAME READY (NEXT GEN)'),
           'mobile-dev' => array('filter_label' => 'GAME READY (MOBILE DEV)'),
           '3d-print-ready' => array('filter_label' => '3D PRINT READY'),
           'full-environment' => array('filter_label' => 'FULL ENVIRONMENT')
        ) , 
        
        
        'model_specs' => array(
            'all-quads' => array('filter_label' => 'ALL QUADS'),
            'over-90-quads' => array('filter_label' => 'OVER 90% QUADS'),
            'real-worls-scale' => array('filter_label' => 'REAL WORLD SCALE')
        ),
        
        'poly_count' => array(
           '10-500' => array('filter_label' => '10 - 500'),
           '500-2k' => array('filter_label' => '500 - 2000'),
           '2k-10k' => array('filter_label' => '2000 - 10,000'),
           '10k-25k' => array('filter_label' => '10,000 - 25,000'),
           '25k-100k' => array('filter_label' => '25,000 - 100,000'),
           '100k-500k' => array('filter_label' => '100,000 - 500,000'),
           '500k-1m' => array('filter_label' => '500,000 - 1 MILLION'),
           '1m-5m' => array('filter_label' => '1 - 5 MILLION'),
           '5m-10m' => array('filter_label' => '5 MILLION - 10 MILLION'),
           '10m-15m' => array('filter_label' => '10 MILLION - 15 MILLION'),
           '15m-more' => array('filter_label' => '> 15 MILLION')
        ),
    
    
   
    
        'texturing' => array(
            'untextured' => array('filter_label' => 'UNTEXTURED'),
            'hand-painted-textures' => array('filter_label' => 'HAND PAINTED TEXTURES'),
            'photographs' => array('filter_label' => 'PHOTOGRAPHS'),
            'procedural' => array('filter_label' => 'PROCEDURAL'),
            'hybrid' => array('filter_label' => 'HYBRID')
        ),
        'mapping' => array(
            'normal' => array('filter_label' => 'NORMALS MAP'),
            'displacement' => array('filter_label' => 'DISPLACEMENT MAP'),
            'grayscale-bump' => array('filter_label' => 'GRAYSCALE BUMP MAP'),
        ),
        
        'lighting' => array(
            'yes' => array('filter_label' => 'INCLUDED WITHIN FILE'),
            'no' => array('filter_label' => 'NOT INCLUDED')
        ),
        'renderer' => array(
            'vray' => array('filter_label' => 'VRAY'),
            'mental-ray' => array('filter_label' => 'MENTAL RAY'),
            'studio-max' => array('filter_label' => 'STUDIO MAX'),
            'maya' => array('filter_label' => 'MAYA'),
            'turtle' => array('filter_label' => 'TURTLE'),
            'zbrush' => array('filter_label' => 'ZBRUSH'),
            'mudbox' => array('filter_label' => 'MUDBOX'),
            'iray' => array('filter_label' => 'IRAY'),
            'indigo' => array('filter_label' => 'INDIGO'),
            'c4d' => array('filter_label' => 'C4D'),
            'blender' => array('filter_label' => 'BLENDER'),
            'lightwave' => array('filter_label' => 'LIGHTWAVE')
        )
        
        
    );




?>