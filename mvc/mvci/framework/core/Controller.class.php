<?php
/* Controller.class.php
 * 基础控制器类,封装控制器类公共方法
 */
declare(strict_types = 1);

namespace framework\core;

error_reporting(E_ALL);

class Controller
{
	protected \Smarty $smarty;

	public function __construct()
	{
		// require_once './smarty/Smarty.class.php';
		// require_once './framework/vendor/smarty/Smarty.class.php';

		$this->smarty = new \Smarty();
		$this->smarty->left_delimiter = '<{';
		$this->smarty->right_delimiter = '}>';
		// $this->smarty->setTemplateDir('./view/tpl');
        // $this->smarty->setCompileDir('./view/tpl_c');
		$this->smarty->setTemplateDir('./application/' . MODULE . '/view/tpl');
		$this->smarty->setCompileDir('./application/' . MODULE . '/view/tpl_c');
	}
}
