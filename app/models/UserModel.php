<?php

/**
* User class
*/
class UserModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get($id)
	{
		$id = (int)$id;

		$user = $this->db->query("SELECT * FROM students WHERE id = {$id}");

		return $user->fetch(PDO::FETCH_OBJ);
	}
}
