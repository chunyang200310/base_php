<?php
/* CategoryModel.class.php
 * 分类模型类, 用来操作分类表(CRUD)
 */
declare(strict_types = 1);

namespace admin\model;

use framework\core\Model;

error_reporting(E_ALL);

// require_once './Model.class.php';
// require_once './framework/core/Model.class.php';

class CategoryModel extends Model
{
	public function cat_add()
	{
		$sql = "insert into category values(7, 'wangwu', 'adminww')";
		$res = $this->dao->exec($sql);
		$id = $this->dao->lastInsertId();
		
		var_dump($res, $id);
	}
	
	public function cat_delete() {}

	public function cat_update() {}

	public function cat_select()
	{
		$sql = 'select * from goods';
		$res = $this->dao->fetchAll($sql);

		return $res;
	}
}

/*
$um = new UserModel();
$um->user_add();
 */
