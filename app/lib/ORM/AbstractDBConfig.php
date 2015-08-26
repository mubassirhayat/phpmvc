<?php
namespace ORM;

use \Config;

abstract class AbstractDBConfig
{
	/**
	* @var $_sqlHost Database host
	* @access protected
	*/
	protected $_sqlHost;

	/**
	* @var $_sqlUser Database user
	* @access protected
	*/
	protected $_sqlUser;

	/**
	* @var $_sqlPass Database password
	* @access protected
	*/
	protected $_sqlPass;

	/**
	* @var $_sqlDB Database name
	* @access protected
	*/
	protected $_sqlDB;


	/**
	* Set the configuration values for Database Connectivity
	*
	* @param none
	* @return none
	*/
	protected function _initializeConfiguration()
	{
		$this->_sqlHost = Config::$DB['HOST'];
		$this->_sqlUser = Config::$DB['USER'];
		$this->_sqlPass = Config::$DB['PASS'];
		$this->_sqlDB = Config::$DB['DB'];
	}
}
?>
