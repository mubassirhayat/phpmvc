<?php

/**
* Home or Index controller
*/
class Error extends Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function index($user = null)
	{

	}

	public function error404()
	{
		$errorModel = $this->model('ErrorModel');

		$error = $errorModel->error404();

		$this->view('template/header');
		$this->view('template/nav');
		$this->view('error/error404', ['error' => $error]);
		$this->view('template/footer');
	}
} 