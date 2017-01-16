<?php

class KSM_RestController extends KSM_BaseController {
    
    
    
    
    public function ksm_posts() {
        
        
        $actions = array('query', 'get', 'update', 'delete');
        
        
        
        
        
        
        if($this->params['id']) {
            getOne($this->params['id']);
        } else {
            
        }
        
        
        pr(KSM_Action::get($_SERVER['HTTP_KSM-Access-ID']));
        
        pr($_SERVER['HTTP_X_KSM_ID']);
        
        exit;
    }
    
    
    
    
    public function ksm_comments() {
        
        
        $actions = array('query', 'get', 'update', 'delete');
        
        
        
        $action = $_POST['action'];
        
        pr($_POST);
        pr($_SERVER);
        
        
        $data = file_get_contents("php://input");
        $data = json_decode($data, TRUE);
        
        
        pr($data);
        exit;
        
        if(!in_array($action, $actions)) {
            return;
        }
        
        
        
        
        //if(!$this->params['id']) {
        //    $action = 'query';
        //}
        
        $result = array();
        
        switch($action) {
            case "query":
                break;
            
            case "get" :
                
                $ksm_post = new KSM_Post($post_id);
                if($ksm_post->ID) {
                    $data = KSM_REST_Comments::get($id);
                }

                
                break;
                
                
            case "update" :
                
                if($this->params['id']) {
                    $comment = new KSM_Post_Comment($this->params['id']);
                    
                    if($comment->isOwner()) {
                        $result = $comment->update();
                    }
                    
                }
                
                pr($_POST);
                pr($this->params);
                break;
            
            case "delete" :
                if($this->params['id']) {
                    $comment = new KSM_Post_Comment($this->params['id']);
                    $result = $comment->delete();
                }
                
                break;
            
        }
        
        
        
        
        return $result;
        
        
    }
    
    
}
