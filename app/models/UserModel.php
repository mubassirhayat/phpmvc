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

	public function get($id)
	{
		$id = (int)$id;
		$this->_sqlQuery = new SQLBuilder();
		$this->_sqlQuery->select->table('students');
		$this->_sqlQuery->select->cols('*');
		$this->_sqlQuery->select->where('id=' . $id);
		$this->_sqlQuery->select->limit(1);
		// echo "<pre>";
		// var_dump($this->_sqlQuery->select->sql());
		// echo "</pre>";
		return $this->_dataObject->_executeSql($this->_sqlQuery->select->sql())->_fetchAssoc();

	}
}
