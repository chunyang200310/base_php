<?php
/* Framework.class.php
 * 入口文件类, 根据用户请求额参数, 向用户展示指定的内容
 */
declare(strict_types = 1);

namespace framework\core;

error_reporting(E_ALL);

class Framework
{
	public function __construct()
	{
		// path constants
		$this->initConst();

		$this->autoload();

		// load config file
		$framework_config = $this->loadFrameworkConfig();
		$common_config = $this->loadCommonConfig();
		$GLOBALS['config'] = array_merge($framework_config, $common_config);

		$this->initMCA();

		// load MODULE config
		$module_config = $this->loadModuleConfig();
		$GLOBALS['config'] = array_merge($GLOBALS['config'], $module_config);

		$this->dispatch();
	}

	public function initConst()
	{
		define('ROOT_PATH', str_replace('\\', '/', getcwd() . '/'));
		define('APP_PATH', ROOT_PATH . 'application/');
		define('FRAMEWORK_PATH', ROOT_PATH . 'framework/');
	}

	// 注册自动加载
	public function autoload()
	{
		// 如果函数的参数是回调函数, 直接写函数的名字
		// 如果函数的参数是一个对象的方法, 需要传数组进去. 元素1: 对象; 元素2: 对象方法
		spl_autoload_register([$this, 'autoloader']);
	}

	// 自动加载执行的函数
	public function autoloader($className)
	{
		echo 'We need: <font color="green">' . $className . '</font><br />';

		// 第三方的类做特殊处理
		if ('Smarty' == $className) {
			require_once './framework/vendor/smarty/Smarty.class.php';
			return;
		}

		// 1, 先将带有命名空间的类,根据命名空间的分隔符 \ ,分隔开
		$arr = explode('\\', $className);

		// 2, 根据第一个元素确定加载的根目录是application还是framework
		if ('framework' == $arr[0]) {
			$basic_path = './';
		} else {
			$basic_path = './application/';
		}

		// 3, 确定application,framework里的子目录
		$sub_path = str_replace('\\', '/', $className);

		// 4, 确定文件名
		// 确定后缀,类文件的后缀: .class.php, 接口文件的后缀: interface.php
		// framework\dao\I_DAO, 判断最后元素是否I_开头
		if ('I_' == substr($arr[count($arr) - 1], 0, 2)) {
			// 说明是接口文件
			$fix = '.interface.php';
		} else {
			$fix = '.class.php';
		}
		$class_file = $basic_path . $sub_path . $fix;
		// var_dump($class_file);

		// 5, 加载类
		// 如果不是按照我们自己的命名空间规则定义的,说明不是我们需要加载的类,这样的类不用加载
		if (file_exists($class_file)) {
			require_once $class_file;
		}
	}

	// 确定m c a
	public function initMCA()
	{
		// 去哪个模块? 前台/后台?
		// $m = $_GET['m'] ?? 'home';
		$m = $_GET['m'] ?? $GLOBALS['config']['default_module'];
		define('MODULE', $m);

		// 访问哪个功能模块? (哪个控制器)
		// $c = $_GET['c'] ?? 'index';
		$c = $_GET['c'] ?? $GLOBALS['config']['default_controller'];
		define('CONTROLLER', ucfirst($c));

		// 调用哪个方法
		// $a = $_GET['a'] ?? 'indexAction';
		$a = $_GET['a'] ?? $GLOBALS['config']['default_action'];
		define('ACTION', $a);
	}

	// 实例化对象, 调用方法
	public function dispatch()
	{
		$controller_name = MODULE . '\controller\\' . CONTROLLER . 'Controller';
		$controller = new $controller_name;

		$a = ACTION;
		$controller->$a();
	}

	// load framework config
	public function loadFrameworkConfig()
	{
		$config_file = './framework/config/config.php';

		if (file_exists($config_file)) {
			return require_once $config_file;
		} else {
			return [];
		}
	}

	// load application common config
	public function loadCommonConfig()
	{
		$config_file = './application/common/config/config.php';

		if (file_exists($config_file)) {
			return require_once $config_file;
		} else {
			return [];
		}
	}

	// load MODULE(admin/home) config
	public function loadModuleConfig()
	{
		$config_file = './application/' . MODULE . '/config/config.php';

		if (file_exists($config_file)) {
			return require_once $config_file;
		} else {
			return [];
		}
	}
}
