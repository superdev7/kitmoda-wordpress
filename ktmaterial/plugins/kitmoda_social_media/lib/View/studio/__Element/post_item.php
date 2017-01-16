<?php


if($post) :
    

$likes = $post->likes ? (Array) $post->likes : array();
$like_action = KSM_Action::post_like_toggle($post);



$attachments = post_attacments($post->ID, array(
    'order'     => 'ASC',
    'meta_key' => 'image_sort',
    'orderby'   => 'meta_value_num',
));

$author =  new KSM_User($post->post_author);
KSM_postView::add($post);



            
//$classes = 'post_comments_container minimized';
//$classes .= (($post->comment_count == 0) ? ' no_comments' : '');
                    



?>


<div class="post" id="wp_<?=$post->ID?>">
    <div class="post_content_container_highlight">
        <div class="post_content_container">
            <div class="post_content">
                
                <div class="text_content_area_wrap_shadow">
                    <div class="text_content_area_new_top_border">
                        <div class="text_content_area_new_top"></div>
                   </div>
                    <div class="text_content_area_new_border">
                        <div class="text_content_area_new">
                            <div class="text_content_area_new_overlay">

                    <div class="post_text_header">
                        <div class="avatar">
                            <?=$post->Author->avatar_link('avatar_tiny');?>
                        </div>
                        <div class="post_content_headerinfo">
                            <li class="post_content_title"><?=$post->post_title?></li>
                        </div>

                        <ul style="margin:0; float:right; margin-right: 10px;">

                            <li class="post_content_username">
                                <?=$post->Author->display_name_link();?>
                            </li>
                            <li class="post_content_age"><?=time_ago($post->post_date)?></li>
                            <li class="clr"></li>
                        </ul>
                        <div class="clr"></div>
                    </div>
                    <div class="text_holder_box">
                                <div class="post_content_divide_gradient_line_dark"></div>
                                <div class="post_content_divide_gradient_line_dark"></div>
                                <div class="post_content_divide_gradient_line"></div>



                                <div class="pst-ih"><?=$post->post_content?></div>

                        </div>
                    </div>
                </div>
                    </div>
                    <div class="text_content_area_new_bottom_border">
                        <div class="text_content_area_new_bottom"></div>
                    </div>
                </div>
                
                
                <?php if ($attachments) : ?>
                <div class="post_content_image_background">

                    <ul class="wp_images" style="text-align: center;">

                    <?php
                    foreach ($attachments as $att) :
                        KSM_postView::add($att);
                        $fav_action = KSM_Action::favorite_toggle($att);
                    ?>

                        <li style="display: inline-block;">

                            <div class="img_header">
                                <div class="bg"></div>
                                <div class="bar">
                                    <div class="title"><?=$att->post_title?></div>
                                    <ul class="image_stats">
                                        <li class="favorites">
                                            <span type="favorite" class="button <?= $fav_action['class'] ?>" rel="<?= $fav_action['action'] ?>"></span>
                                            <span class="count"><?= ($att->favorites_count ? $att->favorites_count : '0') ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <img class="studiowall_image" src="<?=get_image_src($att->ID, 'wall_full') ?>" />
                        </li>
                    <?php endforeach; ?>
                        <li class="clr"></li>
                    </ul>
                </div>
                <?php endif; ?>

            </div>
            <?php 
            if(!$is_edit) :
            $this->render_element('add_wall_post_comment', array('wp' => $post));
            ?>
            <div class="footer_backdrop_highlight">
                <div class="footer">
                    <div class="footer_studio_post_overlay">
                    <ul class="post_stats">
                        <li class="views">
                            <span class="button"></span>
                            <span class="count"><?=get_number($post->views_count) ?></span>
                        </li>

                        <li class="comments">

                            <span class="button"></span>

                            <span class="count"><?=get_number($post->comment_count) ?></span>

                        </li>

                        <li class="likes">
                            <span type="plike" class="button <?=$like_action['class']?>" rel="<?=$like_action['action']?>"></span>
                            <span class="count"><?=get_number($post->likes_count) ?></span>
                        </li>
                        <li class="share">
                            <span class="button" data-item="<?=$post->ID?>"></span>
                        </li>

                        <li class="clr"></li>
                    </ul>
                    
                    
                    <?php if($post->Author->ID == get_current_user_id()) : ?>
                    
                    <ul class="post_actions">
                        <li class="edit_post"><a class="colorbox" href="<?=ksm_get_permalink("studio/edit_post/$post->ID")?>">EDIT POST</a></li>
                        <li class="delete_post"><a class="colorbox" href="<?=ksm_get_permalink("studio/delete_post/$post->ID")?>">DELETE</a></li>
                        <li class="clr"></li>
                    </ul>
                    
                    <?php endif; ?>
                    <div class="clr"></div>
                </div>
            </div>
            <?php endif; ?>
        </div>
		
        </div>
    </div><div class="clr"></div>
    
    <?php if(!$is_edit) ?>
    <div class="post_comments">
        <div class="comments_header <?=(($post->comment_count == 0) ? 'no_comments' : '')?>">
                <ul class="comments_stats">
                    <li class="stat_comments">
                        <span class="button"></span>
                        <span class="count"><?=get_number($post->comment_count) ?></span>
                    </li>
                </ul>
                
                
                
                <div class="comments_toggle hide" rel="hide">SHOW COMMENTS</div>
                <div class="clr"></div>
            </div>
        
    <div class="comments">
            
            
            
            
        <?php
        $wall_post_comments = get_comments(array('post_id' => $post->ID, 'orderby' => 'comment_date', 'order' => 'ASC'));
        foreach ((Array) $wall_post_comments as $wpc) :
            $this->render_element('wall_comment_item', array('wpc' => $wpc));
        endforeach;
        ?>
        </div>
    </div>
    
    <?php enfif; ?>
</div>


<?php 



endif;
?>