<?php





$sub_tabs = array(

    'messages' => 'MESSAGES',

    'purchase_library' => 'PURCHASE LIBRARY',

    'sales' => 'SALES',

    'products' => 'PRODUCTS'

);









?>







<div class="top_tabs">

    <div class="nav">

        <ul>

            <?php foreach ($sub_tabs as $tk => $tn) : ?>

            <li class="nav_<?=$tn?>"><a<?=(($sub_tab == $tk) ? ' class="active"' : '')?> href="<?=ksm_get_permalink("account/{$tk}")?>" ><?=$tn?><span></span></a></li>

            <?php endforeach; ?>

        </ul>

    </div>

</div><div class="clr"></div>