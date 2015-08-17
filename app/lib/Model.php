<?php
use \ORM\DbConnection;
/**
* Main Model class
*/
class Model
{
	protected $db;

	public function __construct()
	{
		$this->db = DbConnection::getInstance();
		// $this->db = $this->dbConnection->getDb();
	}
}
