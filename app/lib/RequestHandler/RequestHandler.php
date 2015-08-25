<?php

namespace RequestHandler;

class RequestHandler {

    public $controller = '';

	public $action = '';

    protected $url = '';

	public $parameters = [];

    public function __construct($url)
    {
        $this->url = $url;
		$this->getControllerFromURL();


		$this->getActionFromURL();
    }
    public function getControllerFromURL()
    {
        $this->url = $this->parseUrl($this->url);
        if (isset($this->url[0])) {
			if (file_exists('../app/controllers/' . $this->url[0] . '.php'))
			{
				$this->controller = $this->url[0];
				unset($this->url[0]);
			} else {
				# code...
				$this->controller = 'error';
				unset($this->url[0]);
			}
		} else {
            $this->controller = 'home';
        }
        return $this->controller;
    }

    public function getActionFromURL()
    {
        if (isset($this->url[1]))
		{
            $this->action = $this->url[1];
			unset($this->url[1]);
		} else {
            $this->action = 'index';
        }
        return $this->action;
    }

    public function getParametersFromURL()
    {
        $this->parameters = $this->url ? array_values($this->url) : [];
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
