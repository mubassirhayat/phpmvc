<?php
namespace ORM\QueryBuilder;

class SQLSelect
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
		$this->s[0] = "SELECT ";
		$this->s[1] = "*";
		$this->s[2] = " FROM $tablename ";
	}

	function cols($str)
	{
		if(empty($str))
			$this->s[1] = "*";
		else
			$this->s[1] = $str;
	}

	function where($str)
	{
		if(empty($str)) return false;

		$this->s[4] = " WHERE ".$str." ";
	}

	function limit($val)
	{
		if(empty($val))	return false;

		$this->s[5] = " LIMIT ".$val." \r\n";
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
