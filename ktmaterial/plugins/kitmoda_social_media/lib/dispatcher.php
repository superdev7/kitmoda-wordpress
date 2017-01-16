<?php

//echo get_current_user_id();
//exit;





class KUser {
    
    public  $Auth,
            $Access,
            $Type,
            $isPublic,
            $isPrivate;
    
    
    
    static function &get_instance($args = array()) {
        static $instance = array();
        if (!$instance) {
            $instance[0] = new KUser($args);
        }
        return $instance[0];
    }
            

    function __construct($args = array()) {
        
        $authUserID = get_current_user_id();
        
        
        
        $this->Auth = new KSM_User($authUserID);// wp_get_current_user();
        
        
        
        $access_username = $args['user'] ? $args['user'] : get_query_var('username');
        
        if(!$access_username) {
            $this->Type = 'private';
        } else {
            if($authUserID && $access_username == $this->Auth->user_login) {
                $this->Type = 'private';
            } else {
                $this->Type = 'public';
            }
        }
        
        if(!$authUserID) {
            $this->Auth = array();
        }
        
        if($this->Type == 'public') {
            $access_user = get_user_by('login', $access_username);
            
            if($access_user) {
                $this->Access = new KSM_User($access_user->ID);
            }
            
        } elseif($this->Type == 'private') {
            $this->Access = $this->Auth;
        }
        
        
        
        
        
        
        $this->isPublic = ($this->Type == 'public') ? true : false;
        $this->isPrivate = ($this->Type == 'private') ? true : false;
    }
    
    

}

class KSM_MvcDispatcher {
    
    public $controller;
    
    
    
    static function &get_instance() {
        static $instance = array();
        if (!$instance) {
            $instance[0] = new KSM_MvcDispatcher();
        }
        return $instance[0];
    }
    
    
    public function __construct() {
        
        
    }
    
    
    
    public function init($options=array()) {
        
        
        $controller_name = $options['controller'];
        
        
        
        if($controller_name) {
            $params = $options;
            $controller_class = KSM_MVC_getControllerClassName($controller_name);
            
            if(class_exists($controller_class)) {
                $this->controller = new $controller_class($params);
                if(!isset($options['is_ajax']) || !$options['is_ajax']) {
                    $this->controller->KUser = KUser::get_instance();
                }
            }
        }
    }
    
    
    function dispatch_ajax($options=array()) {
        
        
        
        
        $dispatcher = self::get_instance();
        $dispatcher->init($options);
        $dispatcher->dispatch();
    }
    
    function dispatch() {
        
        //echo $this->is_home();
        //pr($this);
        //echo "asdasd";
        
        //exit;
        
        
        if(!$this->controller) {
            return;
        }
        
	
        
        
        if(!$this->controller->action_exists()) {
            exit;
        }
	
        $this->controller->__before();
        $result = call_user_func(array($this->controller, $this->controller->action_method));
        
        
        
        if($this->controller->params['controller'] == 'rest') {
            echo json_encode($result);
            die();
        } else {
            $this->controller->enqueue();
            $this->controller->__after();
            $this->controller->render_layout();
        }
    }
	
	private function escape_params($params) {
		if (is_array($params)) {
			foreach ($params as $key => $value) {
				if (is_string($value)) {
					$params[$key] = stripslashes($value);
				} else if (is_array($value)) {
					$params[$key] = self::escape_params($value);
				}
			}
		}
		return $params;
	}

	public function __call($method, $args) {
		if (isset($this->$method) === true) {
			$function = $this->$method;
			$function();
		}
	}

}

?>