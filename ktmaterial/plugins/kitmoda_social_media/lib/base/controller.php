<?php

abstract class KSM_BaseController {
    
    public   $Model,
                
                $action,
                $data,
                $useModel = true,
                $viewVars  = array(),
                $layout = null,
                $GET,
                $params,
                $use = array(),
                $viewName = null,
                $defaultAction = 'index',
                $subAction,
                $required_login = array(),
                $auth_user,
                $access_user,
                $access_type,
                $is_public_view,
                $is_private_view,
                $name,
                $is_ajax = false,
                $action_method,
                $KUser = null;
    
	
    
	function __construct($params = array()) {
            
            $this->params = $params;
            
            $this->name = KSM_MVC_getName(get_called_class());
            $this->action = isset($params['action']) && $params['action'] ? $params['action'] : 'index';
            
            $this->is_ajax = isset($params['is_ajax']) && $params['is_ajax'] ? true : false;
            
            $this->action_method = $this->is_ajax ? 'ksm_ajax_'.$this->action : 'ksm_'.$this->action;
            
            
            
            
            $this->main_tab = isset($params['main_tab']) && $params['main_tab'] ? $params['main_tab'] : strtolower($this->name);
            
            $this->init();
            
            
            
            
            $this->setView($this->action);
            
            
	}
        
        
        
        function init() {
            $this->initModel();
            //$this->dispatch_controller();
            //$this->view->setTemplate($this->view_path());
        }
        
        
        public function action_exists() {
            return method_exists($this, $this->action_method);
        }
        
	
        public function url($args) {
            //$args['controller'] = strtolower($this->name);
            //$args['action'] = $args['a'];
            //unset($args['a']);
            
            //return KSM_MvcRouter::url($args);
        }
        
        
        
        
        
        
        
        public function __before() {
            if($this->required_auth() && !$this->KUser->Auth) {
                echo "Login is required";
                exit;
            }
        }
        
        function __after() {
            
            $this->setup_helpers();
            
            if($this->is_ajax) {
                die();
            }
        }
        
        function required_auth() {

            if($this->required_login) {
                if($this->required_login[0] == '*' || in_array($this->action, $this->required_login)) {
                    return true;
                }
            }
            
        }
        
        
	
	private function initModel() {
            if($this->useModel) {
                $model_class = 'KSM_'.$this->name . "Model";
                
                if(class_exists($model_class)) {
                    $model_instance = new $model_class();
                    $this->{$this->name} = $model_instance;
                    $this->Model = $model_instance;
                }
            }
	}
        
        
        
        
        
	
	function setView($view) {
            $this->viewName = $view;
	}
	
        
        function controller_id() {
            
            return strtolower(KSM_MVC_getFileName(get_called_class()));
        }
        
        
        function view_dir() {
            
            return KSM_VIEWS_PATH . $this->controller_id() .  DIRECTORY_SEPARATOR;
        }
	
        function view_path() {
            return $this->view_dir() . $this->viewName . '.php';
        }
        
        
        public function enqueue() {
            //$name = 'kms_'.$this->controller_id();
            
            $this->styles[] = $this->controller_id();
            
            if($this->scripts) {
                foreach((Array) $this->scripts as $script) {
                    wp_enqueue_script($script[0], trailingslashit(KSM_BASE_URL)."js/{$script[0]}.js", $script[1]);
                }
            }
            
            
            if($this->styles) {
                foreach((Array) $this->styles as $style) {
                    ksm_enqueue_style($style, trailingslashit(KSM_BASE_URL)."css/{$style}.css");
                }
            }
            //ksm_enqueue_style($name, trailingslashit(KSM_BASE_URL).'css/'.$this->controller_id().'.css');
        }
	
        function render_layout() {
            
            // exaptional just for publisher
            extract($this->viewVars);
            
            $layout = $this->layout ? $this->layout : 'default';
            $layout_path = KSM_VIEWS_PATH . "__layouts/{$layout}.php";
            if(is_file($layout_path)) {
                include $layout_path;
            }
            die();
        }
        
        
        function render_view() {
            $path = $this->view_path();
            
            extract($this->viewVars);
            
            if(is_file($path)) {
                include $path;
            }
        }
        
        
        function elementExists($ele) {
            
            $file = $this->view_dir() . '__Element' . DIRECTORY_SEPARATOR . $ele . '.php';
            if(!is_file($file)) {
                $file = KSM_VIEWS_PATH . '__Element' . DIRECTORY_SEPARATOR . $ele . '.php';
            }
            
            
            if(is_file($file)) {
                return true;
            }
        }
        
        
        
        function render_element($ele, $params = array(), $absolute_path = false) {
            
            extract($this->viewVars);
            extract($params);
            
            if($absolute_path) {
                $file = $ele;
            } else {
                $file = $this->view_dir() . '__Element' . DIRECTORY_SEPARATOR . $ele . '.php';
                if(!is_file($file)) {
                    $file = KSM_VIEWS_PATH . '__Element' . DIRECTORY_SEPARATOR . $ele . '.php';
                }
            }
            
            
            
            
            
            //if(is_file($file)) {
                include $file;
            //}
        }
        
        
        function setup_helpers() {
            
            foreach((Array) $this->Helpers as $h_name => $h_options) {
                $helper_class = '';
                $helper_class = "ksm_{$h_name}Helper";
                $this->$h_name = new $helper_class($h_options);
            }
        }
        
	function dispatch_controller() {
            
            //pr($this->Helpers);
            $method = $this->action;
            if(method_exists($this, $method)) {
                $this->$method();
                
                
                
                
                if(method_exists($this, '__after_action')) {
                    $this->__after_action();
                }
            }
	}
        
        //function set($name, $value) {
            //$this->$name = $value;
        //}
        
        
        
        public function set($name, $value) {
            $this->viewVars[$name] = $value;
	}
        
        
        public function avatar($user_id = 0, $size='avatar_small') {
            
            if($user_id) {
                $user = get_user_by('id', $user_id);
            }
            
            if($user instanceof WP_User) {
                if($user->$size) {
                    $avatar = $user->$size;
                } elseif($user->avatar) {
                    $avatar = get_image_src($user->avatar, $size);
                }
            }
            
            if($avatar) return $avatar;
            return get_default_avatar($size);
        }
        
	
}

?>