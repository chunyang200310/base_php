<?php
namespace magicConstants;

//magic constants魔术常量。属于预定义常量的一部分。
//__LINE__: The current line number of the file.
echo __LINE__;
echo '<br />';
//require 'testMagicConstants.php';	//显示的是被引入文件的行号。

//__FILE__:The full path and filename of the file
echo __FILE__;
echo '<br />';
//require_once 'testMagicConstants.php';	//返回的引入文件的文件路径和名字

echo __DIR__;
echo '<hr />';

trait tfun
{
    function tfunc()
    {
	echo __TRAIT__;	//namespace and trait name.
	echo '<br />';
    }
}

class Test
{
    use tfun;

    public function tcl()
    {
	echo __FUNCTION__ . '<br />';	//不带命名空间
	echo __CLASS__ . '<br />';		//namespace and classname
	echo __TRAIT__ . '<br />';		//null
	echo __METHOD__ . '<br />';		//namespace, classname and function name
	echo __NAMESPACE__ . '<br />';
    }
}

$t = new Test();
$t->tcl();
$t->tfunc();
echo Test::class;	//namespace and classname相当与__CLASS__.
