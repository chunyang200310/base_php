<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

include './classa.php';

$a = new A();
$s = serialize($a);
var_dump($s);	// string 'O:1:"A":1:{s:3:"one";i:1;}'
if (file_put_contents('obj_store.txt', $s)) {
	echo 'Wrote successful.';
} else {
	echo 'Wrote failed';
}
