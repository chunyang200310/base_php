<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

// cloning an object
class SubObject
{
	static $instances = 0;
	public $instance;

	public function __construct()
	{
		$this->instance = ++self::$instances;
	}
}

class MyCloneable
{
	public $object1;
	public $object2;

	function __clone()
	{
		// Force a copy of this->object, otherwise it will point to same object
		$this->object1 = clone $this->object1;
	}
}

$obj = new MyCloneable();

$obj->object1 = new SubObject();
$obj->object2 = new SubObject();

$obj2 = clone $obj;

echo 'Original object: <br />';
print_r($obj);
echo '<br />';

echo 'Cloned object: <br />';
print_r($obj2);
echo '<br />';

// Access member of freshly cloned object
$dateTime = new DateTime();
echo (clone $dateTime)->format('Y');
