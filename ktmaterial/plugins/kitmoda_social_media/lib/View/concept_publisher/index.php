<div class="window_inner">
<?php



if(!$this->KUser->Auth) {
    return;
}


$name = 'pub_'. $pub_options['type'];


foreach((Array) $pub_options['uploaders'] as $upl_name) {
    $upl = KSM_Uploader::get_uploader($upl_name);
    $upl->build();
}

?>



<iframe name="pub_frame" class="formframe"></iframe>
<form class="<?=$name?> pub_form" method="post" target="pub_frame" action="<?=admin_url( 'admin-ajax.php' )?>">

<input type="hidden" id="pub_type" value="<?=$pub_options['type']?>" />
<input type="hidden" name="action" value="<?=$pub_options['type']?>_submit" />
<?php
foreach((Array) $pub_options['steps'] as $step_index => $step) {
    
    echo '<div class="step publisher_step_'.$step['name'].'" swidth="'.$step['width'].'" sheight="'.$step['height'].'" sindex="'.$step_index.'" rel="'.$step['name'].'">';
        $this->render_element($step['name'], array('step' => $step));
    echo '</div>';
}
        


?>

</form>
</div>