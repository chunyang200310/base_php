<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

// $GLOBALS
function test()
{
	$foo = 'local variable';

	echo '$foo in global scope: ' . $GLOBALS['foo'] . '<br />';
	echo '$foo in current scope: ' . $foo . '<br />';
}

$foo = 'Example content';
test();

// $_SERVER
var_dump($_SERVER);

// $_GET
// http://localhost/studieren/base_php/predefined_variables.php?name=lisi
echo 'Hello ' . $_GET['name'] . '<br />';

// $http_response_header
function get_contents()
{
	file_get_contents('http://www.baidu.com');
	var_dump($http_response_header);
}

get_contents();
var_dump($http_response_header);

// $argc
var_dump($argc);	// run this file in command line

// $argv
var_dump($argv);	// run this file in command line
