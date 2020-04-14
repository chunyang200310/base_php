<?php
/* Controller.class.php
 * 基础控制器类,封装控制器类公共方法
 */
declare(strict_types = 1);

namespace framework\core;

use framework\core\Factory;

error_reporting(E_ALL);

class Controller
{
	protected \Smarty $smarty;
	protected $model;

	public function __construct()
	{
		$this->smarty = new \Smarty();
		$this->smarty->left_delimiter = '<{';
		$this->smarty->right_delimiter = '}>';

		/*
		$this->smarty->setTemplateDir('./application/' . MODULE . '/view/tpl');
		$this->smarty->setCompileDir('./application/' . MODULE . '/view/tpl_c');
		 */
		$this->smarty->setTemplateDir(APP_PATH . MODULE . '/view/tpl');
		$this->smarty->setCompileDir(APP_PATH . MODULE . '/view/tpl_c');

		$this->initModelObj();
	}

	private function initModelObj()
	{
		// $this->model = Factory::M(CONTROLLER . 'Model');

		// 如果没有Model,则Factory类会自动加上Model.
		$this->model = Factory::M(CONTROLLER);
	}
}
