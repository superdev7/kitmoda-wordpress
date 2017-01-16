<?php

class KSM_MvcLoader {

    
    public $plugin_app_paths = array(),
           $public_controller_names = array(
               'community',
               'store',
               'studio',
               'collaboration'
               
           ),
            
            
            $mvc_query_vars = array(
                'controller',
                'action',
                'id'
            ),
            
            
           $query_vars = array();
    
    protected $core_path = '';
    public $dispatcher = null;
    
    
    function __construct() {
        $this->dispatcher = KSM_MvcDispatcher::get_instance();
    }
    
    
    
    public function parse_query($query) {
        
        
        if(!$this->dispatcher->controller) {
            $routing_params = $this->get_routing_params();
            if($routing_params['controller']) {
                $this->dispatcher->init($routing_params);
            }
        }
        
        
        return $query;
    }
    
    static function &get_instance() {
        static $instance = array();
        if (!$instance) {
            //$instance[0] = new KSM_MvcLoader();
			$instance[0] =& new KSM_MvcLoader();
        }
        return $instance[0];
    }
    
    
    
    function flush_rewrite_rules() {
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
    }
    
    
    static function register_rest_routes() {
        
        $routes = KSM_DataStore::Option('route', 'rest');
        
        
        
        
        
        //pr($routes);
        //exit;
        
        foreach($routes as $n => $_r) {
            
            
            
            $controller_name = 'KSM_Rest_Controller_'.ucfirst($n);
            
            $rest_controller = new $controller_name;
            
            
            foreach($_r as $k) {
                $route = "/" . $k[0];
                $args = array();
                foreach($k[1] as $v) {
                    $__route = array();
                    $__route['methods']  = $v['methods'];
                    $type = $v['type'];
                    //$rest_controller = 'KSM_Rest_Controller_'.ucfirst($n);
                    $callback = $v['callback'] ? $v['callback'] : $type;
                    $p_callback = $v['permission_callback'] ? $v['permission_callback'] : "{$type}_permission";

                    $__route['callback']  = array($rest_controller, $callback);
                    $__route['permission_callback']  = array($rest_controller, $p_callback);


                    $args[] = $__route;
                }
                
                //echo $namespace . "|" . $route;
                //pr($args);

                register_rest_route(KSM_REST_NAMESPACE, $route, $args);
            }
            
            
        }
        
        
        
        
        
        
    }
    
    
    function add_rewrite_rules($rules) {
        
        $new_rules = array();
        $routes = KSM_DataStore::Option('route', 'front');
        
        
        
        $extra_routes = array();
        $extra_routes = apply_filters('ksm_front_routes', $extra_routes);
        
        
        if(!empty($extra_routes)) {
            $routes = array_merge($routes, $extra_routes);
        }
        
        
        
        
        //pr($rules);
        //exit;
        
        
	foreach ($routes as $route) {
            
            $route_path = $route[0];
            //$route_defaults = isset($route[1]) ? $route[1] : '';
			$route_defaults = $route[1];
            //echo $route_path . "<br>";
            if (strpos($route_path, '{:controller}') !== false) {
                foreach ($this->public_controller_names as $controller) {
                    $route_rules = $this->get_rewrite_rules($route_path, $route_defaults, $controller);
                    $new_rules = array_merge($route_rules, $new_rules);
		}
            } else if (!empty($route_defaults['controller'])) {
                $route_rules = $this->get_rewrite_rules($route_path, $route_defaults, $route_defaults['controller'], 1);
		$new_rules = array_merge($route_rules, $new_rules);
            }
	}
        
        
        
		
	$rules = array_merge($new_rules, $rules);
        
	return $rules;
    }
    
    
    
    
    
    protected function get_routing_params() {
        //echo "get_routing_params <br>";
        global $wp_query;
        
        
	//$controller = $this->query_vars['mvc_controller'];
        
        $controller = $wp_query->get('mvc_controller');
        
        
	if ($controller) {
            $query_params = $wp_query->query;
            $params = array();
            foreach ($query_params as $key => $value) {
                $key = preg_replace('/^(mvc_)/', '', $key);
		$params[$key] = $value;
            }
            return $params;
	}
		
	return false;
    }
    
    
    /*
    public function filter_post_link($permalink, $post) {
        
        //echo "filter_post_link <br>";
        
        //pr($this->get_routing_params());
        if (substr($post->post_type, 0, 4) == 'mvc_') {
            $model_name = substr($post->post_type, 4);
            $controller = MvcInflector::tableize($model_name);
            $model_name = MvcInflector::camelize($model_name);
            $model = MvcModelRegistry::get_model($model_name);
            $object = $model->find_one(array('post_id' => $post->ID));
            if ($object) {
                $url = MvcRouter::public_url(array('object' => $object));
                if ($url) {
                    return $url;
                }
            }
        }
	return $permalink;
    }
    
    */
    
    
    protected function get_rewrite_rules($route_path, $route_defaults, $controller, $first_query_var_match_index=0) {
        //echo "get_rewrite_rules <br>";
        add_rewrite_tag('%'.$controller.'%', '(.+)');
		
		$rewrite_path = $route_path;
		$query_vars = array();
		$query_var_counter = $first_query_var_match_index;
		$query_var_match_string = '';
		
		// Add any route params from the route path (e.g. '{:controller}/{:id:[\d]+}') to $query_vars
		// and append them to the match string for use in a WP rewrite rule
		preg_match_all('/{:(.+?)(:.*?)?}/', $rewrite_path, $matches);
		foreach ($matches[1] as $query_var) {
			//$query_var = 'mvc_'.$query_var;
                        
                        
                        $query_var = in_array($query_var, $this->mvc_query_vars) ? 'mvc_'.$query_var : $query_var;
                        
			if ($query_var != 'mvc_controller') {
				$query_var_match_string .= '&'.$query_var.'=$matches['.$query_var_counter.']';
			}
			$query_vars[] = $query_var;
			$query_var_counter++;
		}
		
		// Do the same as above for route params that are defined as route defaults (e.g. array('action' => 'show'))
		if (!empty($route_defaults)) {
			foreach ($route_defaults as $query_var => $value) {
				//$query_var = 'mvc_'.$query_var;
                                $query_var = in_array($query_var, $this->mvc_query_vars) ? 'mvc_'.$query_var : $query_var;
				if ($query_var != 'mvc_controller') {
					$query_var_match_string .= '&'.$query_var.'='.$value;
					$query_vars[] = $query_var;
				}
			}
		}
		
		$this->query_vars = array_unique(array_merge($this->query_vars, $query_vars));
		$rewrite_path = str_replace('{:controller}', $controller, $route_path);
		
		// Replace any route params (e.g. {:param_name}) in the route path with the default pattern ([^/]+)
		$rewrite_path = preg_replace('/({:[\w_-]+})/', '([^/]+)', $rewrite_path);
		// Replace any route params with defined patterns (e.g. {:param_name:[\d]+}) in the route path with
		// their pattern (e.g. ([\d]+))
		$rewrite_path = preg_replace('/({:[\w_-]+:)(.*?)}/', '(\2)', $rewrite_path);
		$rewrite_path = '^'.$rewrite_path.'/?$';
		
		$controller_value = empty($route_defaults['controller']) ? $controller : $route_defaults['controller'];
		$controller_rules = array();
		$controller_rules[$rewrite_path] = 'index.php?mvc_controller='.$controller_value.$query_var_match_string;
		
                
		return $controller_rules;
	}
        
        
        
    
    
    
    public function add_query_vars($vars) {
        $vars = array_merge($vars, $this->query_vars);
        
        
	return $vars;
    }
    
    
    function template_redirect() {
        
        
        
        
        if(!$this->dispatcher->controller && !is_admin() && !is_404() && is_front_page()) {
            $routing_params = array('controller' => 'community');
            $this->dispatcher->init($routing_params);
        }
        
        
        
        $this->dispatcher->dispatch();
    }
    
    
    public function add_ajax_routes() {
        
        $routes = KSM_DataStore::Option('route', 'ajax');
        
        $extra_routes = array();
        $extra_routes = apply_filters('ksm_ajax_routes', $extra_routes);
        
        
        if(!empty($extra_routes)) {
            $routes = array_merge($routes, $extra_routes);
        }
        
        
        
        if (!empty($routes)) {
            foreach ($routes as $route) {
                
                $actions = array();
                
                $wp_action = $route['controller'] .'_'.$route['action'];
                //&& $route['no_private']
                if(isset($route['no_private']) ) {
                    $actions[] = array('tag' => "wp_ajax_nopriv_{$wp_action}", 'fun' => "public_ajax_{$wp_action}");
                }
                
                $actions[] = array('tag' => "wp_ajax_{$wp_action}", 'fun' => "admin_ajax_{$wp_action}");
                
                foreach($actions as $action) {
                    $tag = $action['tag'];
                    $method = $action['fun'];
                    
                    $routing_params = 
                    "array(
                        'controller' => {$route['controller']}, 
                        'action' => {$route['action']}, 
                        'is_ajax' => true
                        )";
                    
                      //Old Code  
                    $this->dispatcher->{$method} = create_function('', 'KSM_MvcDispatcher::dispatch_ajax('.$routing_params.');die();');
					
					//New Code
					//$this->dispatcher->{$method} = function() {KSM_MvcDispatcher::dispatch_ajax($routing_params);
					//die();};
					
                    add_action($tag, array($this->dispatcher, $method));
                }
            }
	}
    }
    
    
    
}