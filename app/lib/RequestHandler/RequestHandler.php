<?php

namespace RequestHandler;

class RequestHandler {

    protected $controller = '';

	protected $action = '';

    protected $defaultController = 'home';

    protected $defaultAction = 'index';

	protected $parameters = [];

    public function getControllerFromURL($url)
    {
        $urlVars = $this->parseUrl($url);
        if (isset($url[0])) {
			if (file_exists('../app/controllers/' . $url[0] . '.php'))
			{
				$this->controller = $url[0];
				// unset($url[0]);
			} else {
				# code...
				$this->controller = 'error';
				// unset($url[0]);
			}
		}
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
