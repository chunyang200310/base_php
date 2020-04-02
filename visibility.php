<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

// Property Visibility
class MyClass
{
	public $public = 'Public';
	protected $protected = 'Protected';
	private $private = 'Private';

	public function printHello()
	{
		echo $this->public;
		echo $this->protected;
		echo $this->private;
	}
}

$mc = new MyClass();
var_dump($mc);
echo $mc->public . '<br />';

/* fatal error
 * $mc->protected;
 * $mc->private;
 */

$mc->printHello();

class SubClass extends MyClass
{
	// redeclare the publie and protected properties
	public $public = 'SubClass Public';
	protected $protected = 'SubClass Protected';
	private $private = 'SubClass Private';
	var $name;

	public function printHello()
	{
		echo $this->public;
		echo $this->protected;
		echo $this->private;
	}
}

$sc = new SubClass();
var_dump($sc);
$sc->printHello();

/******   Method Visibility   ******/
class MethodVisible
{
	// public methods
	function noVisible()
	{
		echo 'No visibility keyword are defined as public. <br />';
	}

	public function publicInfo()
	{
		echo 'Public informations. <br />';
	}

	// protected method
	protected function protectedInfo()
	{
		echo 'Protected informations. <br />';
	}

	// private method
	private function privateInfo()
	{
		echo 'Private informations. <br />';
	}

	public function showInfo()
	{
		$this->noVisible();
		$this->publicInfo();
		$this->protectedInfo();
		$this->privateInfo();
	}
}

$mv = new MethodVisible();
var_dump($mv);
$mv->publicInfo();

// fatal error
//$mv->protectedInfo();
//$mv->privateInfo();

$mv->showInfo();

/******   Constant Visibility   ******/
class ConstVisible
{
	// public constants
	const NO_KEYWORD = 'no keyword defined as publid';
	public const MY_PUBLIC = 'public';

	// protected
	protected const MY_PROTECTED = 'protected';

	// private
	private const MY_PRIVATE = 'private';

	public function showConst()
	{
		echo self::NO_KEYWORD;
		echo self::MY_PUBLIC;
		echo self::MY_PROTECTED;
		echo self::MY_PRIVATE;
	}
}

$cv = 'ConstVisible';
echo $cv::NO_KEYWORD . '<br />';
echo $cv::MY_PUBLIC . '<br />';

// fatal error
//echo $cv::MY_PROTECTED . '<br />';
//echo $cv::MY_PRIVATE . '<br />';

$cv1 = new ConstVisible();
$cv1->showConst();

class SubCv extends ConstVisible
{
	public function showParentConst()
	{
		echo self::MY_PUBLIC;
		echo self::MY_PROTECTED;
		//echo self::MY_PRIVATE;
	}
}

$scv = new SubCv();
echo '<br />subcv public: ' . SubCv::MY_PUBLIC;
$scv->showParentConst();

/******   Visibility from other objects   ******/
class VisibleFromOther
{
	private $foo;

	public function __construct($foo)
	{
		$this->foo = $foo;
	}

	private function bar()
	{
		echo 'Accessed the private method. <br />';
	}

	public function baz(VisibleFromOther $other)
	{
		// we cann change the private property
		$other->foo = 'hello';
		var_dump($other->foo);

		// call private method
		$other->bar();
	}
}

$vfo = new VisibleFromOther('test');
$vfo->baz(new VisibleFromOther('other'));
