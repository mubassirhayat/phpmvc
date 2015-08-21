<?php

use \RequestHandler\RequestHandler;
/**
*
*/
class App
{
	public function __construct()
	{
		$url = $_GET['url'];

		$request = new RequestHandler();
		$request->setUrl($url);

		$request->getControllerFromURL();
		$request->loadController();


		$request->getActionFromURL();
		$request->loadAction();
	}
}
