<?php
/* UserModel.class.php
 * 用户模型类, 用来操作用户表(CRUD)
 */
declare(strict_types = 1);

error_reporting(E_ALL);

require_once './Model.class.php';

class UserModel extends Model
{
	public function user_add()
	{
		$sql = "insert into user values(7, 'wangwu', 'adminww')";
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
