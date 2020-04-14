<?php
/* UserModel.class.php
 * 用户模型类, 用来操作用户表(CRUD)
 */
declare(strict_types = 1);

error_reporting(E_ALL);

class UserModel
{
	private $dao;

	public function __construct()
	{
		require_once './DAOPDO.class.php';

		$option = [
			'host'		=>	'localhost',
			'user'		=>	'root',
			'pass'		=>	'vxvd828q',
			'dbname'	=>	'php_7',
			'port'		=>	3306,
			'charset'	=>	'utf8'
		];

		$this->dao = DAOPDO::getsingleton($option);
	}

	public function user_add()
	{
		/*
		require_once './DAOPDO.class.php';

		$option = [
			'host'		=>	'localhost',
			'user'		=>	'root',
			'pass'		=>	'vxvd828q',
			'dbname'	=>	'php_7',
			'port'		=>	3306,
			'charset'	=>	'utf8'
		];

		$dao = DAOPDO::getsingleton($option);
		// var_dump($dao);
		 */

		$sql = "insert into user values(6, 'wangwu', 'adminww')";
		//$res = $dao->exec($sql);
		//$id = $dao->lastInsertId();
		$res = $this->dao->exec($sql);
		$id = $this->dao->lastInsertId();
		
		var_dump($res, $id);
	}
	
	public function user_delete() {}

	public function user_update() {}

	public function user_select() {}
}

/*
$um = new UserModel();
$um->user_add();
 */
