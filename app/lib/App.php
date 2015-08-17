<?php

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
		$url = $this->parseUrl();
		if (file_exists('../app/controllers/' . $url[0] . '.php')) 
		{
			$this->controller = $url[0];
			unset($url[0]);
		}

		require_once '../app/controllers/' . $this->controller . '.php';

		$this->controller = new $this->controller();

		if (isset($url[1])) 
		{
			if (method_exists($this->controller, $url[1])) 
			{
				$this->action = $url[1];
				unset($url[1]);
			}
		}

		$this->parameters = $url ? array_values($url) : [];

		call_user_func_array([$this->controller, $this->action], $this->parameters);
	}

	protected function parseUrl() 
	{
		if (isset($_GET['url'])) 
		{
			return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
		}
	}
}