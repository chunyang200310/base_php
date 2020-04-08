<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

// Throwing an Exception
function inverse($x)
{
	if (!$x) {
		throw new Exception('Division by zero.');
	}
	return 1/$x;
}

try {
	echo inverse(5) . '<br />';
	echo inverse(0) . '<br />';
} catch (Exception $e) {
	echo 'Caught exception: ', $e->getMessage(), '<br />';
}

// Continue execute
echo 'Hello world. <br />';

// Exception handling with a finally block
function inverse2($x)
{
	if (!$x) {
		throw new Exception('Division by zero');
	}
	return 1 / $x;
}

try {
	echo inverse2(5) . '<br />';
} catch (Exception $e) {
	echo 'Caught exception: ', $e->getMessage(), '<br />';
} finally {
	echo 'First finally. <br />';
}

try {
	echo inverse2(0) . '<br />';
} catch (Exception $e) {
	echo 'Caught exception: ', $e->getMessage(), '<br />';
} finally {
	echo 'Second finally. <br />';
}

// Continue execution
echo 'Hallo die Welt. <br />';

// Interaction between the finally block and return
function test()
{
	try {
		throw new Exception('foo');
	} catch (Exception $e) {
		return 'catch';
	} finally {
		return 'finally';
	}
}

echo test() . '<br />';

// Nested Exception
class MyException extends Exception {}
class Test
{
	public function testing()
	{
		try {
			try {
				throw new MyException('foo!');
			} catch (MyException $e) {
				// rethrow it
				throw $e;
			}
		} catch (Exception $e) {
			var_dump($e->getMessage());
		}
	}
}

$foo = new Test();
$foo->testing();
echo '<br />';

// Multi catch exception handling
class MyException1 extends Exception {}

class MyOtherException extends Exception {}

class Test1
{
	public function testing()
	{
		try {
			throw new MyException();
		} catch (MyException | MyOtherExctption $e) {
			var_dump(get_class($e));
		}
	}
}

$foo = new test1();
$foo->testing();
