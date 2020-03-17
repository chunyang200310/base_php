# Functions

### 1, User-defined functions

A function may be defined using syntax such as the following:

```php
<?php
function foo($arg_1, $arg_2, /* ..., */ $arg_n)
{
    echo "Example function.\n";
    return $retval;
}
```

Any valid PHP code may appear inside a function, even other functions and class definitions. 

Function names follow the same rules as other labels in PHP.

Functions need not be defined before they are referenced, except when a function is conditionally defined as shown in the two examples below. 

```php
<?php
    // Conditional functions
    $makefoo = true;
    /* We can't call foo() from here 
       since it doesn't exist yet,
       but we can call bar() */
    bar();
    if ($makefoo) {
      function foo()
      {
        echo "I don't exist until program execution reaches me.\n";
      }
    }
    /* Now we can safely call foo()
       since $makefoo evaluated to true */
    if ($makefoo) foo();

    function bar() 
    {
      echo "I exist immediately upon program start.\n";
    }

	// Functions within functions
    function foo() 
    {
      function bar() 
      {
        echo "I don't exist until foo() is called.\n";
      }
    }
    /* We can't call bar() yet
       since it doesn't exist. */
    foo();
    /* Now we can call bar(),
       foo()'s processing has
       made it accessible. */
    bar();
```

All functions and classes in PHP have the global scope - they can be called outside a function even if they were defined inside and vice versa. 

It is possible to call recursive functions in PHP. 

```php
<?php
function recursion($a)
{
    if ($a < 20) {
        echo "$a\n";
        recursion($a + 1);
    }
}
```

### 2, Function arguments

Information may be passed to functions via the argument list, which is a comma-delimited list of expressions. The arguments are evaluated from left to right. 

PHP supports passing arguments by **value** (the default), passing by **reference**, and default argument values. Variable-length argument lists are also supported. 

**Passing arguments by value**:

By default, function arguments are passed by value (so that if the value of the argument within the function is changed, it does not get changed outside of the function). 

```php
<?php
    // Passing arrays to functions
	$input = [1, 2];
    function takesArray($input)
    {
        echo "$input[0] + $input[1] = " . $input[0] + $input[1];
    }
	
	takesArray($input);
```

**Passing arguments by reference**: 

To allow a function to modify its arguments, they must be passed by reference. 

To have an argument to a function always passed by reference, prepend an ampersand **(&)** to the argument name in the function definition: 

```php
<?php
    function add_some_extra(&$string)
    {
        $string .= 'and something extra.';
    }
	$str = 'This is the content, ';
	add_some_extra($str);
	echo $str;	//This is a string, and something extra.
```

**Default argument values**:

A function may define C++-style default values for scalar arguments as follows: 

```php
<?php
function get_age($name = 'Tom', $age = 16) 
{
    return $name . ' is ' . ($age + 2) . ' years old. <br />';
}

echo get_age();		// Tom is 18 years old. 

// non-scalar types as default values
function make_coffee($type = ['cappuccino'], $maker = null)
{
    $device = $maker ?? 'hands';
    return 'Making a cup of ' . join(',', $type) . ' with ' . $device . '. <br />';
}
echo make_coffee();
echo make_coffee(['cappuccino', 'lavazza'], 'teapot');

```

The default value must be a constant expression, not (for example) a variable, a class member or a function call. 

Note that when using default arguments, any defaults should be on the right side of any non-default arguments; otherwise, things will not work as expected. 

```php
<?php
function makeyogurt($flavour, $type = "acidophilus")
{
	return "Making a bowl of $type $flavour. <br />";
}
 
echo makeyogurt("raspberry");
```

**Type declarations**

Type declarations allow functions to require that parameters are of a certain type at call time. If the given value is of the incorrect type, then an error is generated: in PHP 5, this will be a recoverable fatal error, while PHP 7 will throw a TypeError exception.

To specify a type declaration, the type name should be added before the parameter name. The declaration can be made to accept NULL values if the default value of the parameter is set to NULL. 

valid types: Class/interface name, self, array, callable, bool, float, int, string, iterable, object.

Aliases for the above scalar types are not supported. Instead, they are treated as class or interface names. For example, using boolean as a parameter or return type will require an argument or return value that is an instanceof the class or interface boolean, rather than of type bool: 

```php
function test_alias(boolean $param) { }
test_alias(true); // Fatal error: Uncaught TypeError: Argument 1 passed to test_alias() must be an instance of boolean, bool given

function test_type(bool $param) {
    return $param;
}
echo test_type(true) . '<br />';

// Basic class type declaration
class C {}
class D extends C {}
class E {}

function f(C $c)
{
    echo 'Class name: ' . get_class($c) . '<br />';
}
f(new C); 
f(new D); 
// f(new E);    // Fatal error: Uncaught TypeError: Argument 1 passed to f() must be an instance of C, instance of E given

// Basic interface type declaration
interface I { public function f(); }
class Ii implements I {public function f() {} }
class J {}
function test_interface(I $i)
{
    echo 'Class name: ' . get_class($i) . '<br />';
}
test_interface(new Ii);
test_interface(new J);   // Argument 1 passed to test_interface() must implement interface I, instance of J given
```

**Typed pass-by-reference Parameters**

Declared types of reference parameters are checked on function entry, but not when the function returns, so after the function had returned, the argument's type may have changed. 

```php
// Typed pass-by-reference Parameters
function array_baz(array &$param)
{
    $param = 1;
}
$arr = [];
array_baz($arr);
var_dump($arr);
// array_baz($arr); // Argument 1 passed to array_baz() must be of the type array, int given

// Nullable type declaration
class Foo {}
function test_null(Foo $foo = null)
{
    var_dump($foo);
}
test_null(new Foo);		// object(Foo)[1]
test_null(null);		// null
```

**strict typing**

By default, PHP will coerce values of the wrong type into the expected scalar type if possible. 

It is possible to enable strict mode on a per-file basis. In strict mode, only a variable of exact type of the type declaration will be accepted, or a TypeError will be thrown. The only exception to this rule is that an integer may be given to a function expecting a float. Function calls from within internal functions will not be affected by the strict_types declaration. 

To enable strict mode, the declare statement is used with the strict_types declaration: 

```php
<?php
declare(strict_types=1);
function sum(int $a, int $b)
{
    return $a + $b;
}
var_dump(sum(1, 2));
var_dump(sum(1.5, 2.5));
```

**Variable-length argument lists**

PHP has support for variable-length argument lists in user-defined functions. This is implemented using the ... token in PHP 5.6 and later, and using the func_num_args(), func_get_arg(), and func_get_args() functions in PHP 5.5 and earlier. 

The arguments will be passed into the given variable as an array.

```php
<?php
    // Using ... to access variable arguments
    function get_sum(...$numbers)
    {
        $acc = 0;
        foreach ($numbers as $n) {
            $acc += $n;
        }   
        return $acc;
    }

    echo 'The sum = ' . get_sum(1, 2, 3, 4) . '<br />';

    // use ... to provide arguments
    function add($a, $b)
    {
        return $a + $b;
    }
    echo add(...[1, 2]) . '<br />';
    $a = [1, 2];
    echo add(...$a) . '<br />';

    // Type hinted variable arguments
    function total_intervals($unit, DateInterval ...$intervals) {
        $time = 0;
        foreach ($intervals as $interval) {
            $time += $interval->$unit;
        }
        return $time;
    }
    $a = new DateInterval('P1D');
    $b = new DateInterval('P2D');
    echo total_intervals('d', $a, $b).' days';
    // This will fail, since null isn't a DateInterval object.
    // Fatal error: Uncaught TypeError: Argument 2 passed to total_intervals() must be an instance of DateInterval, null given
    echo total_intervals('d', null);

	// Accessing variable arguments in PHP 5.5 and earlier 
	function sum_early() {
        $acc = 0;
        foreach (func_get_args() as $n) {
            $acc += $n;
        }
        return $acc;
    }
    echo sum_early(1, 2, 3, 4);
```

**Functions as arguments**:

```php
<?php
function func_as_arg($a, $b, $c)
{   
    return $c($a, $b);
}

$sum = func_as_arg(1, 2, function ($a, $b) {
    return $a + $b;
});
echo 'Sum is: ' . $sum . '<br />';
```

