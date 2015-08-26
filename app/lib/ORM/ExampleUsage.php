<?php
namespace ORM;

use \ORM\DBManager;

final class ExampleUsage extends DBManager
{
	/**
	* @var String $_sqlQuery Query variable
	*/
	private $_sqlQuery = NULL;

	/**
	* @var Array $_result Contains result from a database query as an array
	*/
	private $_result = NULL;


	public function _methodOne()
	{
		$this->_sqlQuery = "SELECT * FROM table_name";
		return $this->_dataObject->_executeSql($this->_sqlQuery)->_fetchAssoc();
	}

	public function _methodTwo()
	{
		$this->_sqlQuery = "DELETE FROM table_name WHERE id='xxxx'";
		return (FALSE !== $this->_dataObject->_executeSql($this->_sqlQuery)->_affectedRows() > 0);
	}
}
?>
