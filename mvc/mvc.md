# MVC

### 基本概念

M: Model, Model is a data and business logic.

V: View, View is a User Interface.

C: Controller, Controller is a request handler.

### 按照OOP思想封装模型层

框架中最小的单元就是类. 把数据库中的每张表当成一个类, 对表的操作(CRUD)看做类的方法.

比如新建一个*用户类*模型:UserModel.class.php

```php
<?php
/* UserModel.class.php
 * 用户模型类, 用来操作用户表(CRUD)
 */
declare(strict_types = 1); 

error_reporting(E_ALL);

class UserModel
{
    public function user_add() {}
            
    public function user_delete() {}

    public function user_update() {}

    public function user_select() {}
}
```

在模型里操作数据库,直接使用之前封装过的DAOPDO类, 首先引入约束数据库操作的接口:I_DAO.interface.php

```php
<?php
/* I_DAO.interface.php
 * 数据库操作接口
 */
declare(strict_types = 1);

error_reporting(E_ALL);

interface I_DAO
{   
    public function fetchRow($sql);
    
    public function FetchAll($sql);
    
    public function fetchColumn($sql);
    
    public function exec($sql);
    
    public function quote($str);
    
    public function lastInsertId();
} 
```

引入DAOPDO类:

```php
<?php
/* DAOPDO.class.php
 * 操作数据库的具体方法
 */

require_once './I_DAO.interface.php';

class DAOPDO implements I_DAO
{
    private static $instance;
    private $pdo;

    private function __construct(array $option)
    {
        $host ??= $option['host'];
        $user ??= $option['user'];
        $pass ??= $option['pass'];
        $dbname ??= $option['dbname'];
        $port ??= $option['port'];
        $charset ??= $option['charset'];

        if (!$host || !$user || !$pass || !$dbname || !$port || !$charset) {
            die('Arguments error. <br />');
        }

        $dsn = "mysql:host=$host;dbname=$dbname;port=$port;charset=$charset";

        try {
            $this->pdo = new PDO($dsn, $user, $pass);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    private function __clone() { }
    
	public static function getSingleton(array $option): DAOPDO
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self($option);
        }
        return self::$instance;
    }

    public function fetchRow($sql)
    {
        $pdo_statement = $this->pdo->query($sql);

        if (false === $pdo_statement) {
            echo 'sql error: <font color="red">' . $this->pdo->errorInfo()[2] .
                '</font>. <br />';
            return false;
        }
        $result = $pdo_statement->fetch(PDO::FETCH_ASSOC);
        $pdo_statement->closeCursor();
        return $result;
    }

    public function fetchAll($sql)
    {
        $pdo_statement = $this->pdo->query($sql);

        if (false === $pdo_statement) {
            echo 'sql error: <font color="red">' . $this->pdo->errorInfo()[2] .
                '</font>. <br />';
            return false;
        }
        $result = $pdo_statement->fetchAll(PDO::FETCH_ASSOC);
        $pdo_statement->closeCursor();
        return $result;
    }
    
	public function fetchColumn($sql)
    {
        $pdo_statement = $this->pdo->query($sql);

        if (false === $pdo_statement) {
            echo 'sql error: <font color="red">' . $this->pdo->errorInfo()[2] .
                '</font>. <br />';
            return false;
        }
        $result = $pdo_statement->fetchColumn();
        $pdo_statement->closeCursor();
        return $result;
    }

    public function exec($sql)
    {
        $result = $this->pdo->exec($sql);

        if (false === $result) {
            echo 'Sql error: <font color="red">' . $this->pdo->errorInfo()[2].
                '</font>. <br />';
            return false;
        }
        return $result;
    }

    public function quote($str)
    {
        return $this->pdo->quote($str);
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
```

在用户模型中实例化DAOPDO类:

```php
<?php
/* UserModel.class.php
 * 用户模型类, 用来操作用户表(CRUD)
 */
declare(strict_types = 1);

error_reporting(E_ALL);

class UserModel
{
    public function user_add()
    {
        require_once './DAOPDO.class.php';

        $option = [
            'host'      =>  'localhost',
            'user'      =>  'root',
            'pass'      =>  'vxvd828q',
            'dbname'    =>  'php_7',
            'port'      =>  3306,
            'charset'   =>  'utf8'
        ];

        $dao = DAOPDO::getsingleton($option);
        // var_dump($dao);

        $sql = "insert into user values(5, 'wangwu', 'adminww')";
        $res = $dao->exec($sql);
        $id = $dao->lastInsertId();
        var_dump($res, $id);
    }

    public function user_delete() {}

    public function user_update() {}

    public function user_select() {}
}

/*
$um = new UserModel();
$um->user_add();
*/
```

这个类中其他的方法,如查询,修改,删除方法都要用到DAOPDO这个类,为了避免重复代码,把这个类放到构造函数中实例化:

```php
<?php
/* UserModel.class.php
 * 用户模型类, 用来操作用户表(CRUD)
 */
declare(strict_types = 1); 

error_reporting(E_ALL);

class UserModel
{
    private $dao;

    public function __construct()
    {   
        require_once './DAOPDO.class.php';

        $option = [ 
            'host'      =>  'localhost',
            'user'      =>  'root',
            'pass'      =>  'vxvd828q',
            'dbname'    =>  'php_7',
            'port'      =>  3306,
            'charset'   =>  'utf8'
        ];

        $this->dao = DAOPDO::getsingleton($option);
    }   

    public function user_add()
    {   
        $sql = "insert into user values(6, 'wangwu', 'adminww')";        
        $res = $this->dao->exec($sql);
        $id = $this->dao->lastInsertId();

        var_dump($res, $id);
    }

    public function user_delete() {}

    public function user_update() {}

    public function user_select() {}
}

/*
$um = new UserModel();
$um->user_add();
 */
```

**基础模型类**

以后项目还有很多的模型类,每个模型类都要使用DAOPDO类操作数据库,所以将公共代码提取到一个基础类中,其他类直接继承这个基础类:

```php
<?php
/* Model.class.php
 * 基础模型类, 每个模型类都会用到的公共代码
 */

declare(strict_types = 1);

error_reporting(E_ALL);

class Model
{
    protected $dao;
    
    public function __construct()
    {   
        require_once './DAOPDO.class.php';;

        $option = [
            'host'      =>  'localhost',
            'user'      =>  'root',
            'pass'      =>  'vxvd828q',
            'dbname'    =>  'php_7',
            'port'      =>  3306,
            'charset'   =>  'utf8'
        ];

        $this->dao = DAOPDO::getsingleton($option);
    }
}
```

其他模型类直接继承基础模型类:

```php
<?php
/* UserModel.class.php
 * 用户模型类, 用来操作用户表(CRUD)
 */
declare(strict_types = 1);

error_reporting(E_ALL);

require_once './Model.class.php';

class UserModel extends Model
{   
    public function user_add()
    {
        $sql = "insert into user values(7, 'wangwu', 'adminww')";
        $res = $this->dao->exec($sql);
        $id = $this->dao->lastInsertId();

        var_dump($res, $id);
    }

    public function user_delete() {}

    public function user_update() {}

    public function user_select() {}
}
    
/*
$um = new UserModel();
$um->user_add();
 */
```

**工厂类实例化单例对象**

工厂模式在我们这里指的就是，传递模型类名称进来，生产模型对象出去.

```php
<?php
/* Factory.class.php
 * 工厂类,根据模型类的名字, 实例化模型对象并返回
 */
declare(strict_types = 1);

error_reporting(E_ALL);

class Factory
{   
    public static function M($modelName)
    {   
        static $model_list = [];
        
        if (!isset($model_list[$modelName])) {
            $model_list[$modelName] = new $modelName;
        }   
        return $model_list[$modelName];
    }   
} 
```

### 控制器层的封装

控制器层按照**功能模块**来划分,便于分工协作开发,每人负责一个功能,一个功能对应一个控制器类,所以每人负责一个控制器即可.项目的功能模块是在项目分析阶段就决定的.按照功能模块封装控制器,则把每个功能模块里的操作(CRUD)封装成控制器的方法.

例如分类控制器:

```php
<?php
/*
 * 分类控制器,负责分类管理这个功能模块
 */

declare(strict_types = 1);

error_reporting(E_ALL);

class CategoryController
{
    // 控制器方法名最后加Action,用来避免和模型的方法名混淆
    public function indexAction() {}

    public function deleteAction() {}

    public function editAction() {}

    public function addAction() {}
}
```

在控制器中发布命令,命令模型处理数据,命令视图显示数据:

```php
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

        // 显示数据.(linux系统要给tpl_c文件夹 o+w 的权限)
        $smarty->display('view/cat_list.html');
    }   

    public function deleteAction() {}

    public function editAction() {}

    public function addAction() {}
}

$cm = new CategoryController();
$cm->indexAction();
```

因为控制器中的其他方法也会用到smarty,避免代码重复可以把smarty的引入和设置放在构造函数中:

```php
<?php
/*
 * 分类控制器,负责分类管理这个功能模块
 */

declare(strict_types = 1); 

error_reporting(E_ALL);

class CategoryController
{
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

    public function indexAction()
    {   
        /* 命令模型查询数据 */
        // 先用工厂类实例化模型对象
        require_once './Factory.class.php';

        $cat_model = Factory::M('CategoryModel');
        $cat_list = $cat_model->cat_Select();

        /* 命令视图显示数据 */
        // 分配数据过去
        $this->smarty->assign('cat_list', $cat_list);

        // 显示数据
        $this->smarty->display('view/cat_list.html');
    }   

    public function deleteAction() {}

    public function editAction() {}

    public function addAction() {}
}

$cm = new CategoryController();
$cm->indexAction();
```

**基础控制器类**

每个项目都会有很多的控制器类,每个控制器类中都需要用smarty,所以将smarty的引入和初始化再次封装到一个基础的控制器中,让其他的控制器类继承这个基础控制器类.

```php
<?php
/* Controller.class.php
 * 基础控制器类,封装控制器类公共方法
 */
declare(strict_types = 1);
    
error_reporting(E_ALL);

class Controller
{
    protected Smarty $smarty;

    public function __construct()
    {
        require_once './smarty/Smarty.class.php';

        $this->smarty = new Smarty();
        $this->smarty->left_delimiter = '<{';
        $this->smarty->right_delimiter = '}>';
        $this->smarty->setTemplateDir('./view/tpl');
        $this->smarty->setCompileDir('./view/tpl_c');
    }
}
```

分类控制器,继承基础控制器:

```php
<?php
/*
 * 分类控制器,负责分类管理这个功能模块
 */

declare(strict_types = 1);

error_reporting(E_ALL);

require_once './Controller.class.php';

class CategoryController extends Controller
{
    public function indexAction()
    {
        /* 命令模型查询数据 */
        // 先用工厂类实例化模型对象
        require_once './Factory.class.php';

        $cat_model = Factory::M('CategoryModel');
        $cat_list = $cat_model->cat_Select();

        /* 命令视图显示数据 */
        // 分配数据过去
        $this->smarty->assign('cat_list', $cat_list);

        // 显示数据
        $this->smarty->display('view/cat_list.html');
    }

    public function deleteAction() {}
```

至此,一个最简单的mvc框架就算完成了.可以用来做一些内容很小,功能简单的个人网站了.但不能做大一点的项目.继续完善这个框架.

### MVC目录结构

上面的所有代码都放在一个文件夹里太混乱不好管理,所有要对mvc的代码分目录保存.

和具体项目业务相关的代码,放在项目目录里,通常取名application. 还有一些代码是公共的,不管做什么项目都会用到,放在框架目录里,取名framework.

随着框架的不断完善,会出现很多有用的工具类,为了高效管理,也分目录存放: 1, 像smarty这样别人提供的类库,放在verdor目录,表示是第三方提供的.2, 像Captcha, Page等自己写的一些工具类放在tools目录. 3, 像DAOPDO这些与数据库相关的类,接口都保存到dao目录. 4, 基础的类如Model.class.php,放到core目录.

应用程序application里一般又包括前台和后台,也用mvc思想进行目录划分.最终的目录如下:

![mvc_directory](/opt/lampp/htdocs/studieren/mvc/mvc_directory.png)

### 入口文件

入口文件又称分发控制器,根据用户需求,引导到对应的文件,展示用户想要的内容.通常为:index.php

这个文件直接放在项目的根目录就可以了.所有需要require的类,都是相对于该文件的路径出发.

入口文件需要的参数:1,去前台还是后台? home/admin?

2, 需要哪个功能,即哪个控制器? controller?

3,访问控制器的哪个方法? action?

```php
<?php
/* index.php
 * 入口文件,用来接收用户参数,根据用户参数找到需要的模块,控制器,并调用指定的方法
 */

declare(strict_types = 1); 

error_reporting(E_ALL);

// 要去前台还是后台
//$m = isset($_GET['m']) ? $_GET['m'] : 'home';
$m = $_GET['m'] ?? 'home';

// 访问哪个功能模块,(控制器)
$c = $_GET['c'] ?? 'Index';

// 调用哪个方法
$a = $_GET['a'] ?? 'indexAction';

// combine controller name
$controller_name = $c . 'Controller';
//var_dump($m, $c, $a);
//return;

// 加载控制器类,并实例化对象
$class_file = './application/' . $m . '/controller/' . $controller_name .
    '.class.php';

require_once $class_file;

$controller = new $controller_name;

// call controller's method
$controller->$a();
```

测试一下: http://mypage.com/index.php?m=admin&c=Category&a=indexAction

因为所有的类文件都是相对于index.php这个入口文件出发来加载,所以会有一系列找不到类文件的错误,逐一修改加载的路径:

1, require_once(./Controller.class.php) in CategoryController.class.php on line *10*

`require_once './framework/core/Controller.class.php';`

2, require_once(./smarty/Smarty.class.php) in Controller.class.php on line *15*

`require_once './framework/vendor/smarty/Smarty.class.php';`

3, require_once(./Factory.class.php) in CategoryController.class.php on line *35*

`require_once './framework/core/Factory.class.php';`

4, require_once(CategoryModel.class.php) in Factory.class.php on line *16*

工厂类实例化模型对象的时候,具体是前台的模型还是后台的模型与$m的值有关,这里暂时用一下全局变量的$m,后期用常量代替:

`global $m;`

`require_once './application/' . $m . '/model/' . $modelName . '.class.php';`

5, require_once(./Model.class.php) in CategoryModel.class.php on line *9*

`require_once './framework/core/Model.class.php';`

6, require_once(./DAOPDO.class.php) in Model.class.php on line *16*

`require_once './framework/dao/DAOPDO.class.php';`

7, require_once(./I_DAO.interface.php) in DAOPDO.class.php on line *6*

`require_once './framework/dao/I_DAO.interface.php';`

8, Uncaught  --> Smarty: Unable to load template.

这里要修改的是framework/core/Controller.class.php这个文件中关于smarty的配置,这里的配置也和$m的值相关,这里也暂时用下全局变量$m,后期用常量代替.

`global $m;`

`$this->smarty->setTemplateDir('./application/' . $m . '/view/tpl');`

`$this->smarty->setCompileDir('./application/' . $m . '/view/tpl_c');`

(linux中tpl_c要有o+w的权限)

同时也要修改CategoryController.class.php文件中模板的路径:

`$this->smarty->display('./application/admin/view/tpl/cat_list.html');`

至此,一切正常!

### 自动加载机制

当使用一个类,而当前文件中并不存在这个类时,就会触发自动加载,自动加载机制提供了最后一次机会,可以把类加载过来.

触发自动加载的四种情况:

1, new Class;	Class not in this file.

2, Class::staticMethod;	Class not in this file.

3, Class extends ParentClass; ParentClass not in this file

4, Class implement Interface; Interface not in this file.

使用自动加载机制的话,之前所有的require_once都不需要了,统统删除.

涉及到的文件:

index.php

application/admin/controller/CategoryController.class.php

framework/dao/DAOPDO.class.php

framework/core/Controller.class.php

framework/core/Factory.class.php

application/admin/model/CategoryModel.class.php

framework/core/Model.class.php

删除所有的require_once后会报: Class 'CategoryController' not found 的错误,

仅仅通过类名是无法把类加载进来的,因为不知道去哪个目录找,可能admin,home里都有这个类.

解决这个问题的方法是给每个类增加命名空间,并且命名空间和该类所在的位置有一定关联.

1, 入口文件是用来加载其他类的,不需要加命名空间.

2, 每个类的命名空间包含当前类所在的路径.框架目录里的类,命名空间为: framework\core; 项目里的类,命名空间就不要加application了,因为application是项目名,不同的项目名称不同, 所以项目的命名空间直接从application的子目录开始: admin\controller; home\controller;

3, 第三方的类,不用加命名空间,做特殊的处理:手动加载(require)

添加了命名空间后,在入口文件中注册自动加载机制,在要实例化对象的时候就带上该类的命名空间,系统就会提示需要加载的带有命名空间的类:

```php
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
    echo 'We need: ' . $className . '<br />';
}

// 要去前台还是后台
$m = $_GET['m'] ?? 'home';
    
// 访问哪个功能模块,(控制器)
$c = $_GET['c'] ?? 'Index';
$c = ucfirst($c);
    
// 调用哪个方法
$a = $_GET['a'] ?? 'indexAction';

// 带上需要加载类的命名空间
$controller_name = $m . '\\controller\\' . $c . 'Controller';

$controller = new $controller_name;

// call controller's method
$controller->$a();
```

再测试: index.php?m=admin&c=category&a=indexAction就会提示:

We need: admin\controller\CategoryController

这样我们就可以获得类所在位置了.

**完成自动加载**

根据系统提示的需要的类名,解析出类所在的路径并加载.

```php
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

// 带上需要加载类的命名空间
$controller_name = $m . '\\controller\\' . $c . 'Controller';

$controller = new $controller_name;

// call controller's method
$controller->$a();
```

### 封装入口文件

因为我们采用的OOP（面向对象的思想）封装的框架，框架里面的代码都应该是类，然而现在的入口文件index.php是完全面向过程的写法，所以我们要将其封装到类中. 封装在framework/core/Framework.class.php

```php
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
        $this->autoload();
        $this->initMCA();
        $this->dispatch();
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

    // 确定m c a
    public function initMCA()
    {
        // 去哪个模块? 前台/后台?
        $m = $_GET['m'] ?? 'home';
        define('MODULE', $m);

        // 访问哪个功能模块? (哪个控制器)
        $c = $_GET['c'] ?? 'index';
        define('CONTROLLER', $c);

        // 调用哪个方法
        $a = $_GET['a'] ?? 'indexAction';
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
}
```

封装好入口文件后,原来的index.php只需要引入这个类,并实例化对象即可:

```php
<?php
declare(strict_types = 1); 

error_reporting(E_ALL);

require_once './framework/core/Framework.class.php';

new framework\core\Framework();
```

### 配置系统

配置文件就是用来保存一些有固定格式,多文件之间的公共数据. 比如js, css, images等的路径, 如果将来图片的路径变了,只需要修改配置文件即可,不用去每个文件查找修改,提升了维护效率.

需要加配置文件的地方:

1. 框架应该有自己的配置文件, 如框架版本等.
2. 应用程序有自己的配置文件,如数据库信息.
3. 为了灵活起见,给前台和后台也要有自己的配置文件.

三中配置文件的优先级应该是: framework confi < application config < module config

使用array_merge()来合并这三种配置,不相同配置项会合并, 相同的配置项,后边数组的元素会覆盖前面数组的元素,这样把优先级低的放在前面, 就能实现我们需要的优先级.

在Framework.class.php中增加三个方法,加载配置文件:

```php
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
```

在构造方法中调用这三个方法,并合并按照优先级合并数组:

```php
class Framework
{     
    public function __construct()   
    {
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
    ......
}

```

在初始化mca的方法中使用配置文件:

```php
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
```

在framework/core/Model.class.php文件中使用配置文件:

```php
class Model
{
    protected $dao;

    public function __construct()
    {
        /*
        $option = [ 
            'host'      =>  'localhost',
            'user'      =>  'root',
            'pass'      =>  'vxvd828q',
            'dbname'    =>  'php_7',
            'port'      =>  3306,
            'charset'   =>  'utf8'
        ];
         */
        $option = $GLOBALS['config'];

        $this->dao = DAOPDO::getsingleton($option);
    }
}
```

测试一下, 完全OK.

### 路径常量

框架中一些设计到路径的地方,如项目根目录,application目录,框架目录,css,js,image等资源目录.用常量保存,便于项目的维护.

在Framework.class.php中增加一个初始化常量的方法并在构造函数中调用它.

```php
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
    ......
}
```

在framework/core/Controller.class.php文件中使用路径常量

```php
class Controller
{   
    protected \Smarty $smarty;
        
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

    }   
}
```

### 自动化处理

我们要将模型中经常使用到的sql语句公共部分再起提取出来，封装到一个方法中,简化数据库的操作.

##### 自动插入

原生sql:

`INSERT INTO goods ('goods_name') VALUES ('phone');`

简化为:

`$data = ['goods_name'=>'iphone'];`

`$this->insert($data);`

为了方便所有的模型都可以使用简化的方法,把这个方法封装在framework/core/Model.class.php

```php
	//automatic insert
    public function insert($data)
    {   
        // origin sql: INSERT INTO `goods` (`goods_name`) values ('Handys');
        $sql = "INSERT INTO $this->true_table";
        
        // combine fields list
        $fields = array_keys($data);
        $fields_list = array_map(function ($v) {
            return '`' . $v . '`';
        }, $fields);
        $fields_list = '(' . implode(',', $fields_list) . ')';
        $sql .= $fields_list;

        // combine Values
        $values = array_values($data);
        $values = array_map([$this->dao,'quote'], $values);
        $values = ' VALUES(' . implode(',', $values) . ')';
        $sql .= $values;
        
        // execute sql and return Primary key
        $this->dao->exec($sql);
        return $this->dao->lastInsertId();
    }
```

##### 自动删除

$model->delete($id)

首先要获取表中的primary key, 根据pk来删除记录.

在Model.class.php中定义一个主键字段属性$pk, 定义一个方法initField()获取它.

```php
class Model
{
    // primary key
    protected $pk;
    ......
        
    private function initField()
        {
            $sql = "DESC $this->true_table";
            $result = $this->dao->fetchAll($sql);

            foreach ($result as $k=>$v) {
                if ('PRI' == $v['Key']) {
                    $this->pk = $v['Field'];
                    break;
                }
            }
        }
}
```

 获取到primary key之后就可以根据pk删除数据了:

```php
	public function delete($id)
    {
        $sql = "DELETE FROM $this->true_table WHERE $this->pk=$id";
        // die($sql);
        return $this->dao->exec($sql);
    }
```

##### 自动更新

必须有where条件才能更新! 没有where条件直接返回false.

```php
    // automatic update
    public function update(array $data, array $where = null)
    {
        if (!$where) {
            echo 'Where condition is necessary. <br />';
            return false;
        } else {
            foreach ($where as $k=>$v) {
                $where_str = " WHERE `$k`='$v'";
            }
        }
        $sql = "UPDATE $this->true_table SET ";
        $fields = array_keys($data);
        $fields = array_map(function ($v) {
            return '`' . $v . '`';
        }, $fields);

        $field_values = array_values($data);
        $field_values = array_map([$this->dao, 'quote'], $field_values);

        $str = '';

        foreach ($fields as $k=>$v) {
            $str .= $v . '=' . $field_values[$k] . ',';
        }

        // delete the last comma
        $str = substr($str, 0, -1);

        // combine sql statement
        $sql .= $str . $where_str;
        //var_dump($sql);

        // excute SQL and return affected rows
        return $this->dao->exec($sql);
    }
```

##### 自动查询

如果传了where条件,返回一条数据,否则返回所有数据.

```php
    // automatic find
    public function find($data = [], $where = []) 
    {   
        // 如果没有指定字段,则表示所有字段
        if (!$data) {
            $fields = '*';
        } else {
            // combine fields
            $fields = array_map(function ($v) {
                return '`' . $v . '`';
            }, $data);
            $fields = implode(',', $fields);
        }
        if (!$where) {
            $sql = "SELECT $fields FROM $this->true_table";
        } else {
            foreach ($where as $k=>$v) {
                $where_str = '`' . $k . '`=' . "'$v'";
            }
            $sql = "SELECT $fields FROM $this->true_table WHERE $where_str";
        }
        // die($sql);
        return $this->dao->fetchRow($sql);
    } 
```

