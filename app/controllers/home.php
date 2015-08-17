<?php

/**
* Home or Index controller
*/
class Home extends Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function index($user = null)
	{
		$homeModel = $this->model('HomeModel');

		$home = $homeModel->index();

		$this->view('template/header');
		$this->view('template/nav');
		$this->view('home/index', ['home' => $home]);
		$this->view('template/footer');
	}
} 