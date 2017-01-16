<?php

$data = array(
    
    'model' => array(
        
        'model' => array(
            'title' => 'Model',
            'side_buttons' => array(
                'info'=> array(
                    'label' => 'Collaboration Info',
                    'uri' => 'mi'
                    ) , 
                'files'=> array(
                    'label' => 'Original Files',
                    'uri' => 'mfiles'
                    )
                ),
            ),
        
        'model_midpoint_feedback' => array(
            'title' => 'Midpoint Feedback',
            'side_buttons' => array(
                'notes'=> array(
                    'label' => 'Feedback',
                    'uri' => 'mmn'
                    ) , 
                'info'=> array(
                    'label' => 'Submitted WIP',
                    'uri' => 'mmi'
                    )
                ),
            
            
            'states' => array(
                'model_mid_wip' =>  array(
                    'label' => 'Submit WIP',
                    'duration' => 'active',
                    'partner_project_label' => 'FIRST WIP MIDPOINT SUMMISSION'
                    ),
                'fb_wait_model_mid_wip' => array(
                    'label' => 'Awating Feedback',
                    'duration' => 'model_mid_wip',
                    'partner_project_label' => 'FIRST WIP MIDPOINT - FEEDBACK'
                    )
                )
            ),
        
        'model_final_feedback' => array(
            'title' => 'Final Feedback',
            'side_buttons' => array(
                'notes'=> array(
                    'label' => 'Feedback',
                    'uri' => 'mfn'
                    ) , 
                'info'=> array(
                    'label' => 'Submitted WIP',
                    'uri' => 'mfi'
                    )
                ),
            'states' => array(
                'model_final_wip' => array(
                    'label' => 'Submit Final WIP',
                    'duration' => 'fb_wait_model_mid_wip',
                    'partner_project_label' => 'FINAL WIP SUMMISSION'
                    ),
                'fb_wait_model_final_wip' => array(
                    'label' => 'Awating Feedback',
                    'duration' => 'model_final_wip',
                    'partner_project_label' => 'FINAL WIP - FEEDBACK'
                    )
                )
            ),
        
        'model_publish' => array(
            'title' => 'Publish',
            //'side_buttons' => array('info'),
            'states' => array(
                'sell_model' => array(
                    'label' => 'Sell Model',
                    'duration' => 'fb_wait_model_final_wip'
                    )
                )
            ),
        
        'model_rate' => array(
            'title' => 'Rate',
            'last' => true,
            'states' => array(
                'rate_model' => array(
                    'label' => 'Rate Artist',
                    'duration' => 'sell_model'
                    )
                )
            )
        ),
    
    
    
    
    
    
    'texture' => array(
        
        'texture' => array(
            'title' => 'Texture',
            'side_buttons' => array(
                'info'=> array(
                    'label' => 'Collaboration Info',
                    'uri' => 'ti'
                    ) , 
                'files'=> array(
                    'label' => 'Original Files',
                    'uri' => 'tfiles'
                    )
                )
            ),
        'texture_midpoint_feedback' => array(
            'title' => 'Midpoint Feedback',
            'side_buttons' => array(
                'notes'=> array(
                    'label' => 'Feedback',
                    'uri' => 'tmn'
                    ) , 
                'info'=> array(
                    'label' => 'Submitted WIP',
                    'uri' => 'tmi'
                    )
                ),
            'states' => array(
                'texture_mid_wip' =>  array(
                    'label' => 'Submit WIP',
                    'duration' => 'active',
                    'partner_project_label' => 'FIRST WIP MIDPOINT SUMMISSION'
                    ),
                'fb_wait_texture_mid_wip' => array(
                    'label' => 'Awating Feedback',
                    'duration' => 'texture_mid_wip',
                    'partner_project_label' => 'FIRST WIP MIDPOINT - FEEDBACK'
                    )
                )
            ),
        
        
        'texture_final_feedback' => array(
            'title' => 'Final Feedback',
            'side_buttons' => array(
                'notes'=> array(
                    'label' => 'Feedback',
                    'uri' => 'tfn'
                    ) , 
                'info'=> array(
                    'label' => 'Submitted WIP',
                    'uri' => 'tfi'
                    )
                ),
            'states' => array(
                'texture_final_wip' => array(
                    'label' => 'Submit Final WIP',
                    'duration' => 'fb_wait_texture_mid_wip',
                    'partner_project_label' => 'FINAL WIP SUMMISSION'
                    ),
                'fb_wait_texture_final_wip' => array(
                    'label' => 'Awating Feedback',
                    'duration' => 'texture_final_wip',
                    'partner_project_label' => 'FINAL WIP MIDPOINT - FEEDBACK'
                    )
                )
            ),
        
        
        'texture_publish' => array(
            'title' => 'Publish',
            //'side_buttons' => array('info'),
            'states' => array(
                'sell_texture' => array(
                    'label' => 'Sell Model',
                    'duration' => 'fb_wait_texture_final_wip'
                    )
                )
            
            
            ),
        'texture_rate' => array(
            'title' => 'Rate',
            'last' => true,
            'states' => array(
                'rate_texture' => array(
                    'label' => 'Rate Artist',
                    'duration' => 'sell_texture'
                    )
                )
            )
        ),
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    'model_texture' => array(
        'model' => array(
            'title' => 'Model',
            
            'side_buttons' => array(
                'info'=> array(
                    'label' => 'Collaboration Info',
                    'uri' => 'mi'
                    ) , 
                'files'=> array(
                    'label' => 'Original Files',
                    'uri' => 'mfiles'
                    )
                ),
            ),
        'model_midpoint_feedback' => array(
            'title' => 'Midpoint Feedback',
            
            
            'side_buttons' => array(
                'notes'=> array(
                    'label' => 'Feedback',
                    'uri' => 'mmn'
                    ) , 
                'info'=> array(
                    'label' => 'Submitted WIP',
                    'uri' => 'mmi'
                    )
                ),
            
            'states' => array(
                'model_mid_wip' =>  array(
                    'label' => 'Submit WIP',
                    'duration' => 'active',
                    'partner_project_label' => 'FIRST WIP MIDPOINT SUMMISSION'  
                    ),
                'fb_wait_model_mid_wip' => array(
                    'label' => 'Awating Feedback',
                    'duration' => 'model_mid_wip',
                    'partner_project_label' => 'FIRST WIP MIDPOINT - FEEDBACK'
                    )
                )
            ),
        'model_final_feedback' => array(
            'title' => 'Final Feedback',
            'side_buttons' => array(
                'notes'=> array(
                    'label' => 'Feedback',
                    'uri' => 'mfn'
                    ) , 
                'info'=> array(
                    'label' => 'Submitted WIP',
                    'uri' => 'mfi'
                    )
                ),
            'states' => array(
                'model_final_wip' => array(
                    'label' => 'Submit Final WIP',
                    'duration' => 'fb_wait_model_mid_wip',
                    'partner_project_label' => 'FINAL WIP SUMMISSION'
                    ),
                'fb_wait_model_final_wip' => array(
                    'label' => 'Awating Feedback',
                    'duration' => 'model_final_wip',
                    'partner_project_label' => 'FINAL WIP - FEEDBACK'
                    )
                )
            ),
        
        'model_publish' => array(
            'title' => 'Publish',
            //'side_buttons' => array('info'),
            'states' => array(
                'sell_model' => array(
                    'label' => 'Sell Model',
                    'duration' => 'fb_wait_model_final_wip'
                    )
                )
            ),
        
        'texture' => array(
            'title' => 'Texture',
            //'side_buttons' => array('info')
            ),
        'texture_midpoint_feedback' => array(
            'title' => 'Midpoint Feedback',
            
            'side_buttons' => array(
                'notes'=> array(
                    'label' => 'Feedback',
                    'uri' => 'tmn'
                    ) , 
                'info'=> array(
                    'label' => 'Submitted WIP',
                    'uri' => 'tmi'
                    )
                ),
            
            'states' => array(
                'texture_mid_wip' =>  array(
                    'label' => 'Submit WIP',
                    'duration' => 'sell_model',
                    'partner_project_label' => 'FIRST WIP TEXTURE MIDPOINT SUMMISSION'
                    ),
                'fb_wait_texture_mid_wip' => array(
                    'label' => 'Awating Feedback',
                    'duration' => 'texture_mid_wip',
                    'partner_project_label' => 'FIRST WIP TEXTURE MIDPOINT - FEEDBACK'
                    )
                )
            ),
        'texture_final_feedback' => array(
            'title' => 'Final Feedback',
            
            'side_buttons' => array(
                'notes'=> array(
                    'label' => 'Feedback',
                    'uri' => 'tfn'
                    ) , 
                'info'=> array(
                    'label' => 'Submitted WIP',
                    'uri' => 'tfi'
                    )
                ),
            'states' => array(
                'texture_final_wip' => array(
                    'label' => 'Submit Final WIP',
                    'duration' => 'fb_wait_texture_mid_wip',
                    'partner_project_label' => 'FINAL WIP TEXTURE SUMMISSION'
                    ),
                'fb_wait_texture_final_wip' => array(
                    'label' => 'Awating Feedback',
                    'duration' => 'texture_final_wip',
                    'partner_project_label' => 'FINAL WIP TEXTURE - FEEDBACK'
                    )
                )
            
            ),
        'texture_publish' => array(
            'title' => 'Publish',
            //'side_buttons' => array('info'),
            'states' => array(
                'sell_texture' => array(
                    'label' => 'Sell Model',
                    'duration' => 'fb_wait_texture_final_wip'
                    )
                )
            ),
        'model_texture_rate' => array(
            'last' => true,
            'title' => 'Rate',
            'states' => array(
                'rate_model_texture' => array(
                    'label' => 'Rate Artist',
                    'duration' => 'sell_texture'
                    )
                )
            )
        )
    
    );
    
            
?>