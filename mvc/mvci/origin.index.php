<?php
/* index.php
 * 入口文件,用来接收用户参数,根据用户参数找到需要的模块,控制器,并调用指定的方法
 */

declare(strict_types = 1);

error_reporting(E_ALL);

// 注册自动加载机制
spl_autoload_register("autoloader");

function autoloader($className)
{
	echo 'We need: <font color="green">' . $className . '</font><br />';

	// 第三方的类做特殊处理
	if ('Smarty' == $className) {
		require_once './framework/vendor/smarty/Smarty.class.php';
		return;
	}

	// 1, 先将带有命名空间的类,根据命名空间的分隔符 \ ,分隔开
	$arr = explode('\\', $className);
	// var_dump($arr);

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
	var_dump($class_file);

	// 5, 加载类
	// 如果不是按照我们自己的命名空间规则定义的,说明不是我们需要加载的类,这样的类不用加载
	if (file_exists($class_file)) {
		require_once $class_file;
	}
}

// 要去前台还是后台
//$m = isset($_GET['m']) ? $_GET['m'] : 'home';
$m = $_GET['m'] ?? 'home';

// 访问哪个功能模块,(控制器)
$c = $_GET['c'] ?? 'Index';
$c = ucfirst($c);

// 调用哪个方法
$a = $_GET['a'] ?? 'indexAction';

// combine controller name
// $controller_name = $c . 'Controller';
//var_dump($m, $c, $a);
//return;

// 带上需要加载类的命名空间
$controller_name = $m . '\\controller\\' . $c . 'Controller';

// 加载控制器类,并实例化对象
//$class_file = './application/' . $m . '/controller/' . $controller_name .
//'.class.php';

// require_once $class_file;

$controller = new $controller_name;

// call controller's method
$controller->$a();
