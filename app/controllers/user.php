<?php

/**
* User or Index controller
*/
class User extends Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index($user = null)
	{
		$userModel = $this->model('UserModel');

		if ($user)
		{
			$user = $userModel->get($user);
		}
		// echo "<pre>";
		// var_dump($user[0]['name']);
		// echo "</pre>";
		$this->view('template/header');
		$this->view('template/nav');
		$this->view('user/index', ['user' => $user[0]]);
		$this->view('template/footer');
	}
}
