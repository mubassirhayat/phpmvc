<?php

/**
* Home class
*/
class HomeModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		// Bussiness Logic here
		return "Some business logic";
	}
}