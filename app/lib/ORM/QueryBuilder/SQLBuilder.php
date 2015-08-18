<?php
namespace ORM\QueryBuilder;

use \ORM\QueryBuilder\SQLUpdate;
use \ORM\QueryBuilder\SQLInsert;
use \ORM\QueryBuilder\SQLDelete;
use \ORM\QueryBuilder\SQLSelect;

class SQLBuilder
{
	var $update;
	var $insert;
	var $delete;
	var $select;

	function __construct()
	{
		$this->update = new SQLUpdate();
		$this->insert = new SQLInsert();
		$this->delete = new SQLDelete();
		$this->select = new SQLSelect();
	}
}

?>
