<?php
/*
 * 商品控制器,负责商品管理这个功能模块
 */
declare(strict_types = 1);

namespace admin\controller;

use framework\core\{Controller, Factory};

error_reporting(E_ALL);

class GoodsController extends Controller
{
	public function indexAction()
	{
		$data = ['goods_id', 'goods_name', 'shop_price'];
		$where = ['goods_id'=>508];
		$res = $this->model->find($data, $where);
		var_dump($res);
	}

	public function deleteAction()
	{
		$model = Factory::M('GoodsModel');
		$model->delete(504);
		echo 'will delete';
	}

	public function updateAction()
	{
		$data = ['goods_name'=>'mate50', 'shop_price'=>'19999'];
		$where = ['goods_id'=>'508'];
		$res = $this->model->update($data, $where);
		echo 'Affected rows: ' . $res . '<br />';

		echo 'Hello';
	}

	public function editAction() {}

	public function addAction()
	{
		$model = Factory::M('GoodsModel');
		$data = ['goods_name'=>'Handy', 'shop_price'=>'999'];
		echo 'Last insert id: ' . $model->insert($data);
	}
}
