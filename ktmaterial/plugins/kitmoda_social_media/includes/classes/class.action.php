<?php

class KSM_Action {
    
    static function get($id) {
        return (Array) json_decode(Ksm_Hash::decrypt($id));
    }
    
    static function follow_toggle($to, $from) {
        
        $followed = KSM_Follow::getStatus($to, $from);
        
        if($followed) {
            return self::unfollow($to);
        }
        return self::follow($to);
    }
    
    
    static function follow($id) {
        
        return array(
            'action' => Ksm_Hash::encrypt(json_encode(array('action' => 'follow', '_id' => $id))),
            'class' => 'follow',
            'removeClass' => 'unfollow',
            'text' => 'Follow'
        );
    }
    
    
    static function unfollow($id) {
        
        return array(
            'action' => Ksm_Hash::encrypt(json_encode(array('action' => 'unfollow', '_id' => $id))),
            'class' => 'unfollow',
            'removeClass' => 'follow',
            'text' => 'Remove'
        );
    }
    
    
    static function compose($id) {
        
        return Ksm_Hash::encrypt(json_encode(array('action' => 'compose', '_id' => $id)));
    }
    
    
    static function publisher($name, $id = '') {
        
        $data = array('name' => $name);
        if($id) {
            $data['_id'] = $id;
        }
        
        return Ksm_Hash::encrypt(json_encode($data));
    }
    
    
    static function form($name, $id = '') {
        
        $data = array('name' => $name);
        if($id) {
            $data['_id'] = $id;
        }
        
        return Ksm_Hash::encrypt(json_encode($data));
    }
    
    
    
    
    
    static function favorite_toggle($post) {
        
        $user_id = get_current_user_id();
        
        if($user_id && $post) {
        
            $favorite = KSM_Favorite::getStatus($post->ID, $user_id);

            if($favorite) {
                return self::unfavorite($post);
            }
            return self::favorite($post);
        } else {
            return array('action' => '', 'class' => 'disabled');
        }
    }
    
    
    static function favorite($post) {
        
        return array(
            'action' => Ksm_Hash::encrypt(json_encode(array('action' => 'favorite', '_id' => $post->ID))),
            'class' => 'favorite',
            'removeClass' => 'unfavorite'
        );
    }
    
    
    static function unfavorite($post) {
        
        return array(
            'action' => Ksm_Hash::encrypt(json_encode(array('action' => 'unfavorite', '_id' => $post->ID))),
            'class' => 'unfavorite',
            'removeClass' => 'favorite'
        );
    }
    
    
    
    
    
    static function post_like_toggle($post) {
        
        $user_id = get_current_user_id();
        
        if($user_id && $post) {
        
            $liked = KSM_Like::user_liked($post, $user_id);

            if($liked) {
                return self::post_unlike($post);
            }
            return self::post_like($post);
        } else {
            return array('action' => '', 'class' => 'disabled');
        }
    }
    
    
    static function post_like($post) {
        
        return array(
            'action' => Ksm_Hash::encrypt(json_encode(array('action' => 'post_like', '_id' => $post->ID))),
            'class' => 'post_like',
            'removeClass' => 'post_unlike'
        );
    }
    
    
    static function post_unlike($post) {
        
        return array(
            'action' => Ksm_Hash::encrypt(json_encode(array('action' => 'post_unlike', '_id' => $post->ID))),
            'class' => 'post_unlike',
            'removeClass' => 'post_like'
        );
    }
    
    
    
    
    static function comment_like_toggle($comment) {
        
        $user_id = get_current_user_id();
        
        if($user_id && $comment) {
        
            $liked = KSM_Like::user_liked_comment($comment, $user_id);

            if($liked) {
                return self::comment_unlike($comment);
            }
            return self::comment_like($comment);
        } else {
            return array('action' => '', 'class' => 'disabled');
        }
    }
    
    
    static function comment_like($comment) {
        
        return array(
            'action' => Ksm_Hash::encrypt(json_encode(array('action' => 'comment_like', '_id' => $comment->comment_ID))),
            'class' => 'comment_like',
            'removeClass' => 'comment_unlike'
        );
    }
    
    
    static function comment_unlike($comment) {
        
        return array(
            'action' => Ksm_Hash::encrypt(json_encode(array('action' => 'comment_unlike', '_id' => $comment->comment_ID))),
            'class' => 'comment_unlike',
            'removeClass' => 'comment_like'
        );
    }
    
    
    static function StudioID($user = null) {
        
        if(!$user) {
            $user_id = get_current_user_id();
            $user = get_user_by('id', $user_id);
        }
        
        if($user) {
            $key = time() . rand(11111, 99999);

            $ar = array('user' => $user->user_login, 'key' => $key);
            return Ksm_Hash::encrypt(json_encode($ar));
        }
    }
    
    
    
    static function AuthID($user = null) {
        
        if(!$user) {
            $user_id = get_current_user_id();
            
            if($user_id) {
                $user = get_user_by('id', $user_id);
            }
        }
        
        
        if($user) {
            return self::StudioID($user);
        } else {
            $key = time() . rand(11111, 99999);
            $ar = array('key' => $key);
            return Ksm_Hash::encrypt(json_encode($ar));
        }
    }
    
    
    
    
    
    static function return_model($id) {
        $ar = array('id' => $id, 'action' => 'return_model');
        return Ksm_Hash::encrypt(json_encode($ar));
    }
    
    static function ksmPostID($post_id) {
        
        $post = get_post($post_id);
        
        $ar = array('id' => $post_id, 'author' => $post->post_author, 'type' => 'ksm_post');
        return Ksm_Hash::encrypt(json_encode($ar));
        
    }
    
    
}

