<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */






?>


<div class="step" rel="<?=$s_name?>">
    
    <div class="link top"></div>
    
    <div class="inner">
        <div class="title"><?=$s_args['title']?></div>

        <div class="box_border">
            <div class="box"></div>

        </div>
    </div>
    
    <div class="side_buttons">
        <?php foreach ((Array)$s_args['side_buttons'] as $bk => $b) : ?>
        <a href="" class="btn btn_blue <?=$bk?>"><?=$b['label']?></a>
        <?php endforeach;; ?>
    </div>
    <div class="clr"></div>
    <div class="link bottom">
        
        <div class="dot"></div>
    </div>
    
</div>