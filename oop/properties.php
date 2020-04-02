<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

define('myConstant', 'hello world');
$myVar = 'hello world';

// property declarations
class DeclPro
{
	// valid property declarations
	public $var1 = 'hello ' . 'world';
	public $var2 = <<<EOD
hello world
EOD;
	public $var3 = 1 + 1;
	public $var4 = myConstant;
	public $var5 = [true, false];
	public $var6 = <<<'NEWSTR'
hello world
NEWSTR;

	// invalid property declarations
	//public $var7 = self::myVar7();
	//public $var8 = $myVar;


	public static function myVar7()
	{
		return 'hello world';
	}
}

$dp = new DeclPro();
echo 'var1: ' . $dp->var1 . '<br />';
echo 'var2: ' . $dp->var2 . '<br />';
echo 'var3: ' . $dp->var3 . '<br />';
echo 'var4: ' . $dp->var4 . '<br />';
echo 'var6: ' . $dp->var6 . '<br />';
var_dump($dp->var5);

// As of PHP 7.4.0, property definitions can include a type declaration, with the exception of the callable type.
class User
{
	//public int $id;
	//public string $name;

	public function __construct(int $id, string $name)
	{
		$this->id = $id;
		$this->name = $name;
	}
}

$user = new User(1, 'lisi');
echo 'ID: ' . $user->id . '<br />';
echo 'Name: ' . $user->name . '<br />';
