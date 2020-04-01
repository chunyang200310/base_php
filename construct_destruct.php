<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

// old-style constructor function, by the name of the class. 
class OldStyleConstruct
{
	public $name;

	public function oldStyleConstruct($name)
	{
		$this->name = $name;
	}
}

$oc = new OldStyleConstruct('lisi');
echo $oc->name . '<br />';

// new unified constructors: __construct();
class BaseClass
{
	public function __construct()
	{
		echo 'In BaseClass constructor. <br />';
	}
}

class SubClass extends BaseClass
{
	public function __construct()
	{
		echo 'In SubClass constructor. <br />';
	}
}

class OtherSubClass extends BaseClass
{
	// no __constructor, inherits BaseClass's constructor
}

$bc = new BaseClass();
$sc = new SubClass();
$osc = new OtherSubClass();

// explicitly destroy object
$obj1 = new stdClass();
$obj2 = new stdClass();
$obj3 = new stdClass();
var_dump($obj1, $obj2, $obj3);

// destroy 
unset($obj1);
$obj2 = null;
$obj3 = 'Tom';
var_dump($obj1, $obj2, $obj3);

// destructor
Class Destructor
{
	public function __construct()
	{
		echo 'In construct <br />';
	}

	public function __destruct()
	{
		echo 'Destroying ' . __CLASS__ . '<br />';
	}
}

$des = new Destructor();
