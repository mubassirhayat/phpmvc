<?php

use \RequestHandler\RequestHandler;
use \ControllerFactory;
/**
*
*/
class App
{
	protected $url = '';

	public $request = NULL;
	public function __construct()
	{
		$this->url = $_GET['url'];

		$this->request = new RequestHandler($this->url);

		$controller = ControllerFactory::create($this->request->controller);

		$controller->doAction($this->request->action, $this->request->parameters);
	}
}
