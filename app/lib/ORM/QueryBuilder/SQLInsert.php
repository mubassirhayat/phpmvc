<?php
namespace ORM\QueryBuilder;

class SQLInsert
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
		$this->s[0] = "INSERT INTO $tablename SET ";
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

	function sql()
	{
		$sql = '';

		foreach($this->s as $str)
			$sql .= $str;

		return $sql;
	}
}
?>
