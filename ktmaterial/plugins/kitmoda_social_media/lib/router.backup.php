<?php

class KSM_MvcRouter {
	
	public $routes = array();
        
        
        

	static public function url($options=array()) {
            
            $defaults = array(
                'action' => 'index',
                'controller' => null
            );
            
            $options = array_merge($defaults, $options);
            $routes = self::get_public_routes();
            $controller = $options['controller'];
            $action = $options['action'];
            $matched_route = null;
            
            
            foreach ($routes as $route) {
                $route_path = $route[0];
		$route_defaults = $route[1];
		if (!empty($route_defaults['controller']) && $route_defaults['controller'] == $controller) {
                    if (!empty($route_defaults['action']) && $route_defaults['action'] == $action) {
			$matched_route = $route;
                    }
		}
            }
            
            $url = site_url('/');
            if ($matched_route) {
                $path_pattern = $matched_route[0];
                preg_match_all('/{:([\w]+).*?}/', $path_pattern, $matches, PREG_SET_ORDER);
                $path = $path_pattern;
                foreach ($matches as $match) {
                    $pattern = $match[0];
                    $option_key = $match[1];
                    if (isset($options[$option_key])) {
                        $value = $options[$option_key];
                        $path = preg_replace('/'.preg_quote($pattern).'/', $value, $path, 1);
                    }
                }
                $path = rtrim($path, '/').'/';
                $url .= $path;
            } else {
                $url .= $controller.'/';
                if (!empty($action) && !in_array($action, array('show', 'index'))) {
                    $url .= $action.'/';
                }
                if (!empty($options['id'])) {
                    $url .= $options['id'].'/';
                }
            }
            return $url;
	}
        
        
}

?>