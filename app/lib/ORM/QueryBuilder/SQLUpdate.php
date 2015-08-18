<?php
namespace ORM\QueryBuilder;

class SQLUpdate
{
	var $table;
	var $sets;
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
		$this->s[0] = "UPDATE $tablename SET ";
	}

	function set($key, $value)
	{
		$this->sets[$key] = $value;

		// update sql //
		$count = 0;
		$this->s[1] = '';

		$num_sets = count($this->sets);

		foreach($this->sets as $key => $value)
		{
			$this->s[1] .= $key."=".$value;

			if($count < $num_sets - 1)
				$this->s[1] .= ', ';
			else
				$this->s[1] .= ' ';
			$count++;
		}
	}

	function where($str)
	{
		if(empty($str)) return false;

		$this->s[2] = "WHERE ".$str." ";
	}

	function limit($val)
	{
		if(empty($val))	return false;

		$this->s[3] = " LIMIT ".$val." \r\n";
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
