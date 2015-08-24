<?php

use \RequestHandler\RequestHandler;
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

		require_once '../app/controllers/' . $this->request->controller . '.php';
		$controller = new $this->request->controller();

		var_dump($controller);
		// echo "<pre align='left'>";
		// var_dump($request);
		call_user_func_array([$controller, $this->request->action], $this->request->parameters);

		// var_dump($request);
		// echo "</pre><br><br><br><br><br><br>";
	}
}
