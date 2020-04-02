<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

// static method example
class Foo
{
	public function normalFunc()
	{
		echo 'Normal function. <br />';
	}

	public static function aStaticMethod()
	{
		echo 'I am a static method. <br />';
	}
}

Foo::aStaticMethod();
// Foo::normalFunc(); 	// Deprecated: Non-static method Foo::normalFunc() should not be called statically
$sm = 'Foo';
$sm::aStaticMethod();

// static property example
class StaticPro
{
	public static $my_static = 'foo';

	public function staticValue()
	{
		return self::$my_static;
	}
}

class SubStatic extends StaticPro
{
	public function parentStatic()
	{
		return parent::$my_static;
	}
}

echo StaticPro::$my_static . '<br />';
$sp = new StaticPro();
echo $sp->staticValue() . '<br />';
echo $sp->my_static . '<br />';	// Undefined property: StaticPro::$my_static

echo $sp::$my_static . '<br />';

$cls = 'StaticPro';
echo $cls::$my_static . '<br />';

echo SubStatic::$my_static . '<br />';
$ss = new SubStatic();
echo $ss->parentStatic();
