<?php
use \ORM\DBManager;
/**
* Main Model class
*/
class Model extends DBManager
{
	protected $db;

	public function __construct()
	{
		parent::__construct();
		// $this->db = $this->dbConnection->getDb();
	}
}
