<?php
namespace ORM;

use \ORM\AbstractDBConfig;
use \ORM\DBConfigInterface;

final class MySqlDB extends AbstractDBConfig implements DBConfigInterface
{
	private static $_singleInstance;
	private $_sqlLink;
	private $_sqlExec;
	private $_sqlArray = array();
	private $_sqlAffectedRows = array();
	private $_sqlRows = array();
	private $_lastID;


	/**
	 * Create the single instance of class
	 *
	 * @param none
	 * @return Object self::$_singleInstance Instance
	 */
	public static function _getInstance()
	{
		if(!self::$_singleInstance instanceof self)
		{
			self::$_singleInstance = new self;
		}
		return self::$_singleInstance;
	}

	/**
	* Constructor to create initial configuration of MySql
	*
	* @param none
	* @return none
	*/
	private function __construct()
	{
		$this->_initializeConfiguration();
		$this->_makeConnection()->_selectDB();
	}

	/**
	* Open a connection to MySQL server
	*
	* @param none
	* @return Object $this
	*/
	public function _makeConnection()
	{
		$this->_sqlLink = mysql_connect($this->_sqlHost, $this->_sqlUser, $this->_sqlPass);
		return $this;
	}

	/**
	* Select a MySQL database.
	*
	* @param none
	* @return Object $this
	*/
	public function _selectDB()
	{
		mysql_select_db($this->_sqlDB, $this->_sqlLink);
	}

	/**
	* Execute the SQL
	*
	* @param String $_query
	* @return Object $this
	*/
	public function _executeSql($_query)
	{
		$this->_sqlExec = mysql_query($_query);
		return $this;
	}

	/**
	 * Starts a transaction
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function _beginTransaction()
	{
		mysql_query("BEGIN");
		return $this;
	}

	/**
	 * Commit the changes
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function _commitTransaction()
	{
		mysql_query("COMMIT");
		return $this;
	}

	/**
	 * Rollback the changes
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function _rollbackTransaction()
	{
		mysql_query("ROLLBACK");
		return $this;
	}

	/**
	* Fetch a result row as an associative array
	*
	* @param none
	* @return Object $this
	*/
	public function _fetchAssoc()
	{
		$_sqlStoreValues = array();
		while($this->_sqlRows = mysql_fetch_assoc($this->_sqlExec))
		{
			$_sqlStoreValues[] = $this->_sqlRows;
		}
		$this->_freeResult();
		return $_sqlStoreValues;
	}

	/**
	* Fetch a result row as an associative array and as an enumerated array
	*
	* @param none
	* @return Array $this->_sqlStoreValues
	*/
	public function _fetchArray()
	{
		$_sqlStoreValues = array();
		while($this->_sqlArray = mysql_fetch_array($this->_sqlExec, MYSQL_BOTH))
		{
			$_sqlStoreValues[] = $this->_sqlArray;
		}
		$this->_freeResult();
		return $_sqlStoreValues;
	}

	/**
	* Fetch a result row as an object
	*
	* @param none
	* @return Array $this->_sqlStoreValues
	*/
	public function _fetchObject()
	{
		$_sqlStoreValues = array();
		while($this->_sqlRows = mysql_fetch_object($this->_sqlExec))
		{
			$_sqlStoreValues[] = $this->_sqlRows;
		}
		$this->_freeResult();
		return $_sqlStoreValues;
	}

	/**
	* Fetch number of affected rows in previous MySQL operation
	*
	* @param none
	* @return Object $this
	*/
	public function _affectedRows()
	{
		return $this->_sqlAffectedRows = mysql_affected_rows();
	}

	/**
	* Method to return the id of last affected row
	*
	* @param none
	* @return Int $this->_lastID Last id
	*/
	public function _lastID()
	{
		return mysql_insert_id();
	}

        /**
	 * Method to return id of last statements executed
	 *
	 * @param Int $_size Count of insert statements
	 * @return array
	 */
	public function _multipleID($_size)
	{
		for($i=mysql_insert_id();$i<(mysql_insert_id()+$_size);$i++)
		{
			$_lastIDs[] = $i;
		}
		return $_lastIDs;
	}

	/**
	* Method to free the results from memory
	*
	* @param none
	* @return none
	*/
	public function _freeResult()
	{
		mysql_free_result($this->_sqlExec);
	}

	/**
	* Method to stop the cloning of object
	*
	* @param none
	* @return none
	*/
	private function __clone()
	{
		throw new Exception("Cloning is disabled.");
	}

	/**
	* Destroy MySQL connection
	*
	* @param none
	* @return none
	*/
	public function __destruct()
	{
		mysql_close($this->_sqlLink);
	}
}
?>
