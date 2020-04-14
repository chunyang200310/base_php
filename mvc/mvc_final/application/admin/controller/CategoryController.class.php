<?php
/*
 * 分类控制器,负责分类管理这个功能模块
 */
declare(strict_types = 1);

namespace admin\controller;

use framework\core\{Controller, Factory};

error_reporting(E_ALL);

class CategoryController extends Controller
{
	public function indexAction()
	{
		/* 命令模型查询数据 */
		$cat_model = Factory::M('CategoryModel');
		$cat_list = $cat_model->cat_Select();

		/* 命令视图显示数据 */
		// 分配数据过去
		$this->smarty->assign('cat_list', $cat_list);

		// 显示数据
		$this->smarty->display('./application/admin/view/tpl/cat_list.html');
	}

	public function deleteAction() {}

	public function editAction() {}

	public function addAction()
	{
		$model = Factory::M('CategoryModel');
		$data = [];
		$model->insert($data);
	}
}
