<?php



class KSM_View {
    
    
    private $template,
            $vars = array(),
            $controller
            
            ;

    public function __construct($controller) {
        $this->controller = $controller;
        //$this->model = $model;
    }

    
    public function __set($index, $value) {
        $this->vars[$index] = $value;
    }

 
    public function __get($index) {
        return $this->vars[$index];
    }
    
    public function setTemplate($temp) {
        $this->template = $temp;
    }
    
    function avatar($user_id = 0, $size='avatar_small') {
        
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
    
    public function include_element($name) {
        $file = KSM_VIEWS_PATH . strtolower($this->controller->name) .  DIRECTORY_SEPARATOR . '__Element' . DIRECTORY_SEPARATOR . $name . '.php';
        
        if($file) {
            include $file;
        }
    }

    
    
    public function render() { 
        
        $this->enqueue();
        
        extract($this->vars);
        ob_start();
	require($this->template);
	echo ob_get_clean();
    }
    
}

?>