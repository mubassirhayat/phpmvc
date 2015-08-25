<?php

use \ORM\QueryBuilder\SQLBuilder;
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

	public function get($user)
	{
		$id = (int)$user[0];

		$this->_sqlQuery = new SQLBuilder();
		$this->_sqlQuery->select->table('students');
		$this->_sqlQuery->select->cols('*');
		$this->_sqlQuery->select->where('id=' . $id);
		$this->_sqlQuery->select->limit(1);

		return $this->_dataObject->_executeSql($this->_sqlQuery->select->sql())->_fetchAssoc();
	}
}
