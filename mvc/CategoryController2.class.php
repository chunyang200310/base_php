<?php
/*
 * 分类控制器,负责分类管理这个功能模块
 */

declare(strict_types = 1);

error_reporting(E_ALL);

class CategoryController
{
	public function indexAction()
	{
		/* 命令模型查询数据 */
		// 先用工厂类实例化模型对象
		require_once './Factory.class.php';

		$cat_model = Factory::M('CategoryModel');
		$cat_list = $cat_model->cat_Select();

		/* 命令视图显示数据 */
		// 借助smarty显示数据,这里引入smarty并做一些基础配置
		require_once './smarty/Smarty.class.php';

		$smarty = new Smarty();
		$smarty->left_delimiter = '<{';
		$smarty->right_delimiter = '}>';
		$smarty->setTemplateDir('./view/tpl');
		$smarty->setCompileDir('./view/tpl_c');

		// 分配数据过去
		$smarty->assign('cat_list', $cat_list);

		// 显示数据
		$smarty->display('view/cat_list.html');
	}

	public function deleteAction() {}

	public function editAction() {}

	public function addAction() {}
}

$cm = new CategoryController();
$cm->indexAction();
