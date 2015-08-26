<?php
namespace ORM;

use \ORM\AbstractDBConfig;
use \ORM\DBConfigInterface;

final class SqliteDB extends AbstractDBConfig implements DBConfigInterface 
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
	* Constructor to create initial configuration of MySql
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
	* Open a connection to MySQL server
	*
	* @param none
	* @return Object $this
	*/
	public function _makeConnection()
	{
		$this->_sqlLink = sqlite_open($this->_sqlDB, 0666, $_sqliteError);
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
		$this->_sqlExec = sqlite_query($this->_sqlLink, $_query);
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
		throw new Exception('Transaction is not supported in Sqlite. Hence, transaction initialization quitted.');
	}

	/**
	 * Commit the changes
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function _commitTransaction()
	{
		throw new Exception('Transaction is not supported in Sqlite. Hence, transaction commit quitted.');
	}

	/**
	 * Rollback the changes
	 *
	 * @param none
	 * @return Object $this Current object
	 */
	public function _rollbackTransaction()
	{
		throw new Exception('Transaction is not supported in Sqlite. Hence, transaction rollback quitted.');
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
		while($this->_sqlRows = sqlite_fetch_array($this->_sqlExec, SQLITE_ASSOC))
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
		while($this->_sqlArray = sqlite_fetch_array($this->_sqlExec, SQLITE_BOTH))
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
		while($this->_sqlRows = sqlite_fetch_object($this->_sqlExec))
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
		return sqlite_num_rows($this->_sqlExec);
	}

	/**
	* Method to return the id of last affected row
	*
	* @param none
	* @return Int $this->_lastID Last id
	*/
	public function _lastID()
	{
		return sqlite_last_insert_rowid($this->_sqlExec);
	}

	/**
	 * Method to return id of last multiple insert statements executed
	 *
	 * @param Int $_size Count of statements
	 * @return array
	 */
	public function _multipleID($_size)
	{
		for($i=sqlite_last_insert_rowid();$i<(sqlite_last_insert_rowid()+$_size);$i++)
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
		unset($this->_sqlExec);
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
		sqlite_close($this->_sqlLink);
	}
}
?>
