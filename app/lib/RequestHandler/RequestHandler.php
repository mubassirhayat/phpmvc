<?php

namespace RequestHandler;

class RequestHandler {

    protected $controller = '';

	protected $action = '';

    protected $url = '';

	protected $parameters = [];

    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getControllerFromURL()
    {
        $this->url = $this->parseUrl($this->url);
        if (isset($this->url[0])) {
			if (file_exists('../app/controllers/' . $this->url[0] . '.php'))
			{
				$this->controller = $this->url[0];
				unset($url[0]);
			} else {
				# code...
				$this->controller = 'error';
				unset($url[0]);
			}
		} else {
            $this->controller = 'home';
        }
        return $this->controller;
    }

    public function loadController()
    {
        require_once '../app/controllers/' . $this->controller . '.php';
		$this->controller = new $this->controller();
    }

    public function getActionFromURL()
    {
        if (isset($this->url[1]))
		{
			if (method_exists($this->controller, $this->url[1]))
			{
				$this->action = $this->url[1];
				unset($url[1]);
			} else {
				$this->action = 'error404';
				// var_dump($this->action);
				unset($url[1]);
			}
		} else {
            $this->action = 'index';
        }
        return $this->action;
    }

    public function loadAction()
    {
        $this->parameters = $this->url ? array_values($this->url) : [];
		call_user_func_array([$this->controller, $this->action], $this->parameters);
    }

    private function parseUrl($url)
	{
		if (isset($url))
		{
			// detrmine controller and action here
			return explode('/', filter_var(rtrim($url, '/'), FILTER_SANITIZE_URL));
		}
	}
}
