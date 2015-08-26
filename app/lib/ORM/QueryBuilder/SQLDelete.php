<?php
namespace ORM\QueryBuilder;

class SQLDelete
{
	var $table;
	var $s;

	function __construct()
	{
	}

	function reset()
	{
		$this->sets = '';
		$this->s = '';
		$this->table = '';
	}

	function table($tablename)
	{
		$this->reset();
		$this->table = $tablename;
		$this->s[0] = "DELETE FROM $tablename ";
	}

	function where($str)
	{
		if(empty($str)) return false;

		$this->s[2] = "WHERE ".$str." ";
	}


	function sql()
	{
		$sql = '';

		foreach($this->s as $str)
			$sql .= $str;

		return $sql;
	}
}
?>
