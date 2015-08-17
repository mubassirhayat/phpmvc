<?php

/**
* User class
*/
class UserModel extends Model
{
	private $_sqlQuery = NULL;

	private $_result = NULL;

	public function __construct()
	{
		parent::__construct();
	}

	public function get($id)
	{
		$id = (int)$id;
		$this->_sqlQuery = "SELECT * FROM students WHERE id = {$id}";

		return $this->_dataObject->_executeSql($this->_sqlQuery)->_fetchAssoc();

	}
}
