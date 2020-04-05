<?php
declare(strict_types = 1);

/*
namespace my;

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

class MyClass {}
function myFunction() {}
const MYCONST = 1;

$a = new MyClass;
$c = new \my\Myclass;
var_dump($a, $c);

$a = strlen('hi');
var_dump($a);

$d = namespace\MYCONST;
var_dump($d);

$e = __NAMESPACE__ . '\MYCONST';
var_dump($e);
echo constant($e);
 */

/***  __NAMESPACE__ ***/
//echo '"', __NAMESPACE__, '"';	// ""
namespace MyProject;

echo '"', __NAMESPACE__, '"';

class MyClass {}

function get($className)
{
	$a = __NAMESPACE__ . '\\' . $className;
	return new $a;
}

$obj = get('MyClass');
var_dump($obj);
