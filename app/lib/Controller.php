<?php

/**
*
*/
class Controller
{
	public function __construct()
	{

	}
	protected function model($model)
	{
		require_once '../app/models/' . $model . '.php';

		return new $model();
	}

	protected function view($view, $data = [])
	{
		require_once '../app/views/' . $view . '.php';
	}

	public function doAction()
	{
		// Do all the actions here
	}

	// public function error404()
	// {
	// 	$errorModel = self::model('ErrorModel');
	//
	// 	$error = $errorModel->error404();
	//
	// 	self::view('template/header');
	// 	self::view('template/nav');
	// 	self::view('error/error404', ['error' => $error]);
	// 	self::view('template/footer');
	// }
}
