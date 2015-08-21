<?php

use \RequestHandler\RequestHandler;
/**
*
*/
class App
{
	protected $url = '';
	public function __construct()
	{
		$this->url = $_GET['url'];

		$request = new RequestHandler($this->url);
		// echo "<pre align='left'>";
		// var_dump($request);
		// echo "</pre><br><br><br><br><br><br>";
	}
}
