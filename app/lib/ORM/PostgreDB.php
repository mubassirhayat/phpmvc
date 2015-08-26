<?php
namespace ORM;

use \ORM\AbstractDBConfig;
use \ORM\DBConfigInterface;

if(!defined('DIRECT_ACCESS'))
{
	die("Direct access is forbidden.");
}

final class PostgreDB extends AbstractDBConfig implements DBConfigInterface
{
	/**
	* Variables for database interaction
	*/
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
	* Constructor to create initial configuration of Oracle
	*
	* @param none
	* @return none
	*/
	private function __construct()
	{
		$this->_initializeConfiguration();
		$this->_makeConnection();
	}

	/**
	* Open a connection to Postgre server
	*
	* @param none
	* @return Object $this
	*/
	public function _makeConnection()
	{
		$this->_sqlLink = pg_connect('host = '.$this->_sqlHost.' port=5432 dbname = '.$this->_sqlDB.' user = '.$this->_sqlUser.' password = '.$this->_sqlPass);
		return $this;
	}

	/**
	* Select a Oracle database.
	*
	* @param none
	* @return Object $this
	*/
	public function _selectDB()
	{
		// Nothing to do here
	}

	/**
	* Execute the SQL
	*
	* @param String $_query
	* @return Object $this
	*/
	public function _executeSql($_query)
	{
		$this->_sqlExec = pg_execute($this->_sqlLink, $_query);
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
		pg_execute($this->_sqlLink, "BEGIN");
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
		pg_execute($this->_sqlLink, "COMMIT");
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
		pg_execute($this->_sqlLink, "ROLLBACK");
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
		while($this->_sqlRows = pg_fetch_assoc($this->_sqlExec))
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
		while($this->_sqlRows = pg_fetch_array($this->_sqlExec, OCI_BOTH))
		{
			$_sqlStoreValues[] = $this->_sqlRows;
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
		while($this->_sqlRows = pg_fetch_object($this->_sqlExec, OCI_BOTH))
		{
			$_sqlStoreValues[] = $this->_sqlRows;
		}
		$this->_freeResult();
		return $_sqlStoreValues;
	}

	/**
	* Fetch number of affected rows in previous Oracle operation
	*
	* @param none
	* @return Object $this
	*/
	public function _affectedRows()
	{
		return pg_affected_rows();
	}

	/**
	* Method to return the id of last affected row
	*
	* @param none
	* @return Int $this->_lastID Last id
	*/
	public function _lastID($_tableName = '', $_fieldName = '')
	{
		$_pgSql = "SELECT $_fieldName FROM $_tableName ORDER BY $_fieldName DESC LIMIT 1";

		$this->_executeSql($_pgSql);
		return $this->_sqlRows[$_fieldName];
	}

	/**
	 * Method to return id of last multiple insert statements executed
	 *
	 * @param Int $_size Count of statements
	 * @return array
	 */
	public function _multipleID($_size, $_tableName = '', $_fieldName = '')
	{
		$_lastID = $this->_lastID($_tableName, $_fieldName);

		for($i=$_lastID;$i<($_lastID+$_size);$i++)
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
		pg_free_result($this->_sqlExec);
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
	* Destroy Oracle connection
	*
	* @param none
	* @return none
	*/
	public function __destruct()
	{
		pg_close($this->_sqlLink);
	}
}
?>
