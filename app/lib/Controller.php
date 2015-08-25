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

	public function doAction($action, $paramerters)
	{
		$this->$action($paramerters);
	}
}
