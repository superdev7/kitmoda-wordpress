<div></div>

<?php


$type = $_GET['type'];

if(!$type) {
    include KSM_BASE_PATH .'templates/publisher/options.php';
} elseif($type == 'textured') {
    //include ksm_plugin_dir .'templates/publisher/textured.php';
    //include ksm_plugin_dir .'templates/publisher/category.php';
    include KSM_BASE_PATH .'templates/publisher/texture/techinfo.php';
}

elseif($type == 'collab_concept') {
    $pub = new KSMCollaborationConceptPublisher();
    $pub->add_form();
} elseif($type == 'collab_untextured') {
    $pub = new KSMCollaborationUntexturedModelPublisher();
    $pub->add_form();
}

?>