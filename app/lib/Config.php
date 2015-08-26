<?php

/**
* Configurations class
*/
class Config
{

	public static $DB = array(
		// DRIVER can be MYSQL, MSSQL, ORACLE, PGSQL, SQLITE
		'DRIVER'	=>	'MYSQL',
		'HOST'		=>	'localhost',
		'USER'		=>	'root',
		'PASS'		=>	'123',
		'DB'		=>	'university',
	);

	private function __construct()
	{

	}
}
