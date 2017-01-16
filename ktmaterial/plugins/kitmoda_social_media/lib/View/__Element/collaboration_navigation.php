<?php


$kuser = KUser::get_instance();


$count_requests = 0;
$count_active_collaborations = 0;


$user_id = get_current_user_id();

if($user_id) {
    $count_requests = $kuser->Auth->count_collaboration_active_requests;
    
    $count_active_collaborations = $kuser->Auth->count_active_collaborations;
    
}


//atrqt="community_add_post"
$collaboration_menu = 
array(
    'join' => array(
        'title' => 'Join'
    ),
    'launch' => array(
        'title' => 'Launch',
        'auth' => true
    ),
    'active' => array(
        'title' => 'Active',
        'count' => $count_active_collaborations,
        'auth' => true
    ),
    'requests' => array(
        'title' => 'Incoming Requests',
        'count' => $count_requests,
        'auth' => true
    ),
    'partner_projects' => array(
        'title' => 'PARTNER\'S PROJECTS',
        'count' => '',
        'auth' => true
    )
    
    );

?>

<div class="nav-contaner">
<div class="nav">
    <ul>
        
        <?php foreach ($collaboration_menu as $k => $v) : 
            $class = ($k == $collaboration_tab) ? 'active' : '';
            $auth = ($v['auth'] && !$user_id) ? ' atrqt="collaboration_'.$k.'"' : '';
            
            
        
            ?>			
            <li class="nav_<?=$v['title']?>">
                <a<?=$auth?> class="<?=$class?>" href="<?=ksm_get_permalink("collaboration/{$k}")?>">
                <?=$v['title']?>
                    <?php if($v['count'] > 0) : ?>
                        <span class="count"><?=$v['count']?></span>
                    <?php endif; ?>
                </a>
            
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</div>