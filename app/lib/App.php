<?php

use \RequestHandler\RequestHandler;
/**
*
*/
class App
{
	protected $controller = 'home';

	protected $action = 'index';

	protected $parameters = [];

	public function __construct()
	{
		$request = new RequestHandler();
		$url = $_GET['url'];
		var_dump($_GET['controller']);
		$this->controller = $request->getControllerFromURL($url);
		die();
		// $this->action = ;

		require_once '../app/controllers/' . $this->controller . '.php';
		$this->controller = new $this->controller();

		if (isset($url[1]))
		{
			if (method_exists($this->controller, $url[1]))
			{
				$this->action = $url[1];
				// unset($url[1]);
			} else {
				$this->action = 'error404';
				// var_dump($this->action);
				// unset($url[1]);
			}
		}

		$this->parameters = $url ? array_values($url) : [];
		call_user_func_array([$this->controller, $this->action], $this->parameters);
	}
}
