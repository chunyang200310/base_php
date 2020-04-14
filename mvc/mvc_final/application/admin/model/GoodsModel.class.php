<?php
/* GoodsModel.class.php
 * 商品模型类, 用来操作商品表(CRUD)
 */
declare(strict_types = 1);

namespace admin\model;

use framework\core\Model;

error_reporting(E_ALL);

class GoodsModel extends Model
{
	protected $logic_table = 'goods';

	public function goods_add()
	{
		$sql = "insert into goods values(7, 'wangwu', 'adminww')";
		$res = $this->dao->exec($sql);
		$id = $this->dao->lastInsertId();
		
		var_dump($res, $id);
	}
	
	public function Goods_delete() {}

	public function goods_update() {}

	public function goods_select()
	{
		$sql = 'select * from goods';
		$res = $this->dao->fetchAll($sql);

		return $res;
	}
}
