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

		$this->view('template/header');
		$this->view('template/nav');
		$this->view('user/index', ['user' => $user]);
		$this->view('template/footer');
	}
} 