<?php

$obj = new Artists_List();
$obj->prepare_items();
?>


<div class="wrap">
	<!-- Changed path to point to kimoda site-->
    <h1>Message <a href="http://kitmoda.com/magento-help/post-new.php?post_type=ksm_message" class="page-title-action">New Message</a></h1>
    <form method="post">
        <?php $obj->display();?>
    </form>	
</div>