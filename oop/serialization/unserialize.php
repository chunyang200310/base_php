<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

// the definition of class A must here, or: __PHP_Incomplete_Class 
include './classa.php';

$s = file_get_contents('./obj_store.txt');
// var_dump($s);
$a = unserialize($s);
var_dump($a);
$a->showOne();
