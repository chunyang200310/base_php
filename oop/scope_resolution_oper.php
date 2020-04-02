<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

/****** Scope Resolution Operator (::)  ******/
// :: from outside the class definition
class MyClass
{
	public const CONST_VALUE = 'A constant value';

	public function myFunc()
	{
		echo 'MyClass::myFunc() <br />';
	}
}

$mc = 'MyClass';
echo $mc::CONST_VALUE . '<br />';
echo MyClass::CONST_VALUE . '<br />';

// :: from inside the class definition
class OtherClass extends MyClass
{
	public static $my_static = 'static variable';

	public static function doubleColon()
	{
		echo parent::CONST_VALUE . '<br />';
		echo self::$my_static . '<br />';
	}

	// Override parent's definition
	public function myFunc()
	{
		echo 'OtherClass::myFunc() <br />';

		// But still call the parent function
		parent::myFunc();
	}
}

$oc = 'OtherClass';
$oc::doubleColon();
OtherClass::doubleColon();

// calling a parent's method
$oc1 = new OtherClass();
$oc1->myFunc();
