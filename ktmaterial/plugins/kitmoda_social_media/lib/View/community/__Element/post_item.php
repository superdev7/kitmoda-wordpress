<?php


//$post = get_post();

if($post) :

    $likes = $post->likes ? (Array) $post->likes : array();
    $like_action = KSM_Action::post_like_toggle($post);
    $attachments = post_attacments($post->ID);
    
    
    
    $thumb = get_image_src($attachments[0]->ID, 'community_thumb');
    $post_comments = get_comments(array('post_id' => $post->ID, 'orderby' => 'comment_date', 'order' => 'DESC'));
    $show_more = strlen($post->post_content) > 360 ? true : false;
    $pauthor = new KSM_User($post->post_author);
    
    
    KSM_postView::add($post);
    
    
    
    ?>



<div class="post_content_container_highlight_community">
<div class="post minimized with_no_image>" id="wp_<?=$post->ID?>">
        
    
    <div class="post_content_container">
	<div class="post_content_overlay">
        <div class="post_content">
        
            <div class="post_header">
                
                <div class="author">
                    <div class="avatar">
                        <?=$pauthor->avatar_link('avatar_tiny')?>
                    </div>
                    
                    <?=$pauthor->display_name_link()?>
                    <div class="clr"></div>
                </div>
                
                
                
                <ul class="post_stats">
                    <li class="views">
                        <span class="button"></span>
                        <span class="count"><?=get_number($post->views_count) ?></span>
                    </li>
                    <li class="likes">
                        <span type="plike" class="button <?=$like_action['class']?>" rel="<?=$like_action['action']?>"></span>
                        <span class="count"><?=get_number($post->likes_count) ?></span>
                    </li>
                    <li class="share">
                        <span class="button" data-item="<?=$post->ID ?>"></span>
                        <span class="count"><?=$post->shares_count ?></span>
                    </li>
                    <li class="clr"></li>
                </ul>
                <div class="title"><?=$post->post_title?></div>
                
                <?php if($post->post_author == get_current_user_id()) : ?>
                    
                    <ul class="post_actions">
                        <li class="edit_post"><a class="colorbox" href="<?=ksm_get_permalink("community/edit_post/$post->ID")?>">EDIT POST</a></li>
                        <li class="delete_post"><a class="colorbox" href="<?=ksm_get_permalink("community/delete_post/$post->ID")?>">DELETE</a></li>
                        <li class="clr"></li>
                    </ul>
                    
                    <?php endif; ?>
            </div>
            
            
               <div class="box-shg">
            <div class="post_inner">
                <p class="mainp minimized">
                    <?=($show_more ? substr($post->post_content, 0, 360).'...' : $post->post_content)?>
                </p>
                <p class="mainp maximized"><?=$post->post_content;?></p>
                <?php if($thumb) :?>
                    <div class="thumb"><img src="<?=$thumb?>" /></div>
                    
                    
                    <?php
                slick_attachment_gallery($post->ID, array(
                    'full_size'=> 'wall_full', 
                    'thumb_size'=>'avatar_small_2' , 
                    'name'=>"comm_sgallery_{$post->ID}",
                    'button' => '<span class="gallery_back_btn">Back</span>',
                    'count_view' => true
                    ));
                    ?>
                    
                    
                <?php endif; ?>
            
            
            
            <fieldset class="post_min_max minimized">
                <?php if($show_more) : ?>
                <legend align="center">
                    <span class="legend" style="font-size: 11px;">SHOW MORE</span>
                </legend>
                <?php endif; ?>
            </fieldset>
            
            
            </div>
			<?php $this->render_element('add_comment', array('post' => $post));?>
			<?php $classes = 'post_comments_container minimized'; $classes .= (($post->comment_count == 0) ? ' no_comments' : '');?> 
			<fieldset class="<?=$classes?>">
				<div class="comment_toggle">
				<div class="community_sidebar_linebreak"></div>
					<legend>
						<span class="legend" style="width: auto; padding-right: 15px; margin-right: 8px;">Comments</span>
						<span class="comments_count"><?=$post->comment_count?></span>
					</legend>
            </div>
				<div class="post_comments"> 
					<div class="comments">
					<?php foreach ((Array) $post_comments as $comment) : $this->render_element('comment_item', array('comment'=> $comment)); endforeach;?>
					</div>
				</div>
            </fieldset>
            </div>
            
            </div>
			</div>
            
            
            
            
            
            
            
            
            
                    
                
        </div><div class="clr"></div>

        
    </div>	</div>
    
    <?php
    
    

endif;

?>