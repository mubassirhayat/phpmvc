<?php

namespace ORM;

use \Config;
use \ORM\OracleDB;
use \ORM\PostgreDB;
use \ORM\SqliteDB;
use \ORM\MSSqlDB;
use \ORM\MySqlDB;

class DBManager
{
	/**
	* @var Object $_dataObject Current object of a particular database
	*/
	public $_dataObject;


	/**
	* Initialize the current object of a particular database
	*
	* @param none
	* @return Object $this->_dataObject Current object of database
	*/
	public function __construct()
	{
		switch(Config::$DB['DRIVER'])
		{
			case 'ORACLE':
				$this->_dataObject = OracleDB::_getInstance();
			break;

			case 'PGSQL':
				$this->_dataObject = PostgreDB::_getInstance();
			break;

			case 'SQLITE':
				$this->_dataObject = SqliteDB::_getInstance();
			break;

			case 'MSSQL':
				$this->_dataObject = MSSqlDB::_getInstance();
			break;

			case 'MYSQL':
			default:
				$this->_dataObject = MySqlDB::_getInstance();
			break;
		}
	}
}
?>
