<?php


$post = get_post();

if($post->post_type == 'attachment') {
    $img = get_image_src($post->ID, 'favorite_large');
} elseif($post->post_type == 'download') {
    $img = get_image_src($post->_thumbnail_id, 'favorite_large');
}


if($img) {
    echo '<div><div class="image"><img src="'.$img.'"/></div></div>';
}


?>