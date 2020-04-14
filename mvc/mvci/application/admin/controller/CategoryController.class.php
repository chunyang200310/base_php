<?php
/*
 * 分类控制器,负责分类管理这个功能模块
 */

declare(strict_types = 1);

namespace admin\controller;

use framework\core\{Controller, Factory};

error_reporting(E_ALL);

// require_once './Controller.class.php';
// require_once './framework/core/Controller.class.php';

class CategoryController extends Controller
{
	/*
	private Smarty $smarty;

	public function __construct()
	{
		// 借助smarty显示数据,这里引入smarty并做一些基础配置
		require_once './smarty/Smarty.class.php';

		$this->smarty = new Smarty();
		$this->smarty->left_delimiter = '<{';
		$this->smarty->right_delimiter = '}>';
		$this->smarty->setTemplateDir('./view/tpl');
		$this->smarty->setCompileDir('./view/tpl_c');
	}
	 */

	public function indexAction()
	{
		/* 命令模型查询数据 */
		// 先用工厂类实例化模型对象
		// require_once './Factory.class.php';
		// require_once './framework/core/Factory.class.php';

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

	public function addAction() {}
}

/*
$cm = new CategoryController();
$cm->indexAction();
 */
