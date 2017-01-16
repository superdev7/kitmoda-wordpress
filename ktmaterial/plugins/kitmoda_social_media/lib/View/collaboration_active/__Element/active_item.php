<?php

//pr($this);


$steps = KSM_DataStore::Option('CollaborationActiveStep', $post->active_type);


if($post->active_type == 'model') {
    $type =  'Model';
} elseif($post->active_type == 'texture') {
    $type =  'Texture';
} elseif($post->active_type == 'model_texture') {
    $type =  'Texture and Model';
}
?>


<div class="step_header">
    <div class="title"><?=$post->post_title?></div>
    <div class="type"><?=$type?></div>
</div>

<?php
foreach($steps as $s_name => $s_args) {
    $this->render_element('step_item', array('post' => $post, 's_name' => $s_name, 's_args' => $s_args));
}

?>