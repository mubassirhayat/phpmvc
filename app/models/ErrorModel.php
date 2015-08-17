<?php

/**
* Error class
*/
class ErrorModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function error404()
	{
		return '<h1>File Not Found</h1>';
	}
}