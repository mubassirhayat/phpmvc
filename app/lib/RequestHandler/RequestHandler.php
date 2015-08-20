<?php

namespace RequestHandler;

class RequestHandler {
	public $controller_name;
	public $action_name;
	public $valid = false;
	public $params = array();
	public $referer;
	public $uri;
	public $method;
	public $routes;

	public function __construct($routes, $app_root = ROOT ) {
		$this->routes = $routes;
		$route = $this->get_route($routes, $app_root);
		if(is_array($route)) {
			if(isset($route['redirect'])){
				if(!isset($route[0])) $route[0] = null;
				self::redirect($route['redirect'],$route[0]);
			}

			$this->controller_name = $route[0];
			$this->action_name = $route[1] ? $route[1] : 'index';
			$this->params = array_merge($this->params, $_GET, $_POST);
			if(isset($_SERVER['HTTP_REFERER'])) $this->referer = $_SERVER['HTTP_REFERER'];
			$this->uri = $_SERVER['REQUEST_URI'];
			$this->valid = true;
		}
	}

	public function set_action_name($name) {
		$this->action_name = $name;
	}

	public function set_controller_name($name) {
		$this->controller_name = $name;
	}

	public function get_route($route, $app_root) {

		$this->method = (isset($_REQUEST['_method']) && strtolower($_SERVER['REQUEST_METHOD']) == 'post') ? strtolower($_REQUEST['_method']) : strtolower($_SERVER['REQUEST_METHOD']);

		$subfolder = str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\','/',$app_root));
		$uri = str_replace($subfolder,'', $_SERVER['REQUEST_URI']);
		$uri = explode('?',$uri);
		$uri[0] = $this->strip_slash($uri[0]);

		if($uri[0] === '' || $uri[0] === '/index.php') {
			if(isset($route[$this->method]['/'])) return $route[$this->method]['/'];
			if(isset($route['*']['/'])) return $route['*']['/'];
		}else{

			$route_list = array();
			if(isset($route['*'])) $route_list = $route['*'];

			if(isset($route[$this->method])) {
				$route_list = array_merge($route_list, $route[$this->method]);
			}

            if(empty($route_list)) return false;

			if(isset($route_list[$uri[0]])) {
				return $route_list[$uri[0]];
			}else if(isset($route_list[$uri[0].'/'])) {
				return $route_list[$uri[0].'/'];
			}

			$uri[0] = substr($uri[0],1);
			$uri_parts = explode('/', $uri[0]);

			foreach ($route_list as $route => $values) {
				$route = $this->strip_slash(substr($route,1));
				$route_parts = explode('/', $this->strip_slash($route));

				if(!$route) continue;

				if(sizeof($uri_parts) !== sizeof($route_parts) ) continue;

				$static = explode(':',$route);
				if(substr($uri[0],0,strlen($static[0]))!==$static[0]) continue;

				preg_match_all('@:([\w]+)@', $route, $params_name, PREG_PATTERN_ORDER);

				$params_name = $params_name[0];

				if(!count($params_name)) continue;

				$route_regex = $route;
				$route_regex = str_replace('/','\/',$route_regex);

				foreach ($params_name as $name) {
					$regex = '[.a-zA-Z0-9_\+\-%]';
					if (isset($values[$name])) $regex = $values[$name];

					$route_regex = preg_replace('/'.$name.'/','('.$regex.'+)',$route_regex,1);
				}

				if(preg_match('/'.$route_regex.'/' , $uri[0], $matches) === 1){
					array_shift($matches);
					foreach ($params_name as $key => $value) {
						$this->params[substr($value,1)] = $matches[$key];
					}
					return $values;
				}
			}
			return false;
		}
	}


	public function __call($name, $arguments) {
		$named_route = str_replace('_path','',$name);

		if(substr($name,-5,strlen($name)-1) === '_path') {
			return $this->url_for($named_route,$arguments);
		}else{
			trigger_error('Method '.$name.' not exist');
		}
	}


	public function url_for($named_route,$params = array()) {

		$route_list = array();
		if(isset($this->routes['*'])) $route_list = $this->routes['*'];

		if(isset($this->routes[$this->method])) {
			$route_list = array_merge($route_list, $this->routes[$this->method]);
		}
		$path = false;
		foreach ($route_list as $url => $route) {
			if(isset($route['as']) && $route['as'] == $named_route ) {

				preg_match_all('@:([\w]+)@', $url, $params_name, PREG_PATTERN_ORDER);

				$params_name = $params_name[0];

				if(count($params_name)){
					if (count($params) != count($params_name)) { die('Named route for '.$named_route.' expects '.count($params_name).' params not '.count($params).'.'); }
					$route_regex = $url;
					$route_regex = str_replace('/','\/',$route_regex);

					$i = 0;
					foreach ($params_name as $name) {
						$route_regex = preg_replace('/'.$name.'/',$params[$i],$route_regex,1);
						$i++;
					}
					$path = $route_regex;
				}else{
					$path = $url;
				}
			}
		}

		if(!$path) die('Named route for '.$named_route.' doenst exist.');

		return str_replace('\/','/',$path); ;
	}

	public static function redirect($location, $code=302, $exit=true, $headerBefore=NULL, $headerAfter=NULL){
		if($headerBefore!=NULL){
			for($i=0;$i<sizeof($headerBefore);$i++){
				header($headerBefore[$i]);
			}
		}
		header("Location: $location", true, $code);
		if($headerAfter!=NULL){
			for($i=0;$i<sizeof($headerBefore);$i++){
				header($headerBefore[$i]);
			}
		}
		if($exit) die;
	}

	protected function strip_slash($str) {
		if($str[strlen($str)-1]==='/'){
			$str = substr($str,0,-1);
		}
		return $str;
	}
}
?>
