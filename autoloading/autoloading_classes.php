<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

// 1, use REQUIRE load Class Files
require_once './sub/Cat.class.php';
require_once './sub/Dog.class.php';
require_once './sub/Pig.class.php';

$cat = new Cat();
$cat = new Dog();
$cat = new Pig();

// 2, use __autoload function
function __autoload($className)
{
	echo 'We need class named: ' . $className . '. <br />';
	require_once './sub/' . $className . '.class.php';
}

$cat = new Cat();
$cat = new Dog();
$cat = new Pig();

// 3, use config file loading class file
require_once './common.php';
function __autoload($className)
{
	echo 'We need class named: ' . $className . '. <br />';
	global $classMap;
	require_once $classMap[$className];
}

$cat = new Cat();
$cat = new Dog();
$cat = new Pig();

// 4, spl_autoload_register
require_once './common.php';

spl_autoload_register('class_autoload');

function class_autoload($className)
{
	echo 'We need class named: ' . $className . '. <br />';
	global $classMap;
	require_once $classMap[$className];
}

$cat = new Cat();
$cat = new Dog();
$cat = new Pig();
