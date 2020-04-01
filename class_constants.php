<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

const ONE = 1;

class MyClass
{
	const KONSTANT = 'constant value';
	const FOO = <<<'EOT'
foo
EOT;
	const BAR = <<<EOT
bar
EOT;

	// constant expression example
	const TWO = ONE * 2;
	const THREE = ONE + SELF::TWO;
	const SENTENCE = 'The value of THREE is: ' . self::THREE;

	// class constant visibility modifiers
	public const AAA = 'aaa';
	private const BBB = 'bbb';

	public function showConstant(): string
	{
		return self::KONSTANT . '<br />';
	}
}

echo MyClass::KONSTANT . '<br />';
echo MyClass::FOO . '<br />';
echo MyClass::BAR . '<br />';

$cls = 'MyClass';
echo $cls::KONSTANT . '<br />';

$obj = new MyClass();
echo $obj->showConstant();
echo $obj::KONSTANT . '<br />';

// ::class
echo 'class name: ' . MyClass::class . '<br />';

// constant expression
echo $cls::TWO . '<br />';
echo $cls::THREE . '<br />';
echo $cls::SENTENCE . '<br />';

// visibility modifiers
echo $cls::AAA . '<br />';
// echo $cls::BBB . '<br />';	// Fatal error: Cannot access private const

// use class constants in function
function getConstant()
{
	global $obj;
	return $obj->showConstant();
	return MyClass::KONSTANT . '<br />';
}

echo getConstant();
