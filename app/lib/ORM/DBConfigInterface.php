<?php
namespace ORM;

interface DBConfigInterface
{
	public static function _getInstance();
	public function _makeConnection();
	public function _executeSql($_query);
	public function _beginTransaction();
	public function _commitTransaction();
	public function _rollbackTransaction();
	public function _fetchAssoc();
	public function _fetchArray();
	public function _fetchObject();
	public function _affectedRows();
	public function _lastID();
    public function _multipleID($_size);
	public function _freeResult();
}
?>
