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

### 3, Returning values

Values are returned by using the optional return statement. Any type may be returned, including arrays and objects. This causes the function to end its execution immediately and pass control back to the line from which it was called. 

If the return is omitted the value NULL will be returned.

```php
<?php
    // use of return
    function square($num)
    {
        return $num * $num;
    }
    echo square(4);	// 16
```

A function can not return multiple values, but similar results can be obtained by returning an array. 

```php
<?php
    // Returning an array to get multiple values
    function small_numbers()
	{
    	return [0, 1, 2];
	}
	list ($zero, $one, $two) = small_numbers();
```

To return a reference from a function, use the reference operator & in both the function declaration and when assigning the returned value to a variable:

```php
function &returns_reference()
{
    return $someref;
}
$newref =& returns_reference();
```

**Return type declarations**:

PHP 7 adds support for return type declarations. Similarly to argument type declarations, return type declarations specify the type of the value that will be returned from a function. The same types are available for return type declarations as are available for argument type declaration

Strict typing also has an effect on return type declarations. In the default weak mode, returned values will be coerced to the correct type if they are not already of that type. In strong mode, the returned value must be of the correct type, otherwise a TypeError will be thrown. 

As of PHP 7.1.0, return values can be marked as nullable by prefixing the type name with a question mark (?). This signifies that the function returns either the specified type or NULL

When overriding a parent method, the child's method must match any return type declaration on the parent. If the parent doesn't define a return type, then the child method may do so.

```php
<?php
    // Basic return type declaration
    function sum($a, $b): float
    {
        return $a + $b;
    }
	var_dump(sum(1 + 2)); // return float, even two int given

	// strict mode in action
    declare(strict_types=1);
    function sum($a, $b): int {
        return $a + $b;
    }
    var_dump(sum(1, 2));
    var_dump(sum(1, 2.5)); // Fatal error: Uncaught TypeError: Return value of sum() must be of the type integer, float returned in

	// Returning an object
    class C {}
    function getC(): C {
        return new C;
    }
    var_dump(getC());
```

### 4, Variable functions

PHP supports the concept of variable functions. This means that if a variable name has parentheses appended to it, PHP will look for a function with the same name as whatever the variable evaluates to, and will attempt to execute it. Among other things, this can be used to implement callbacks, function tables, and so forth. 

```php
<?php
// variable function example
function var_func()
{
    echo 'call function: var_func <br />';
}

$str = 'var_func';
$str();

// call Object method with the variable functions
class CallVar
{
    public function variable()
    {
        $name = 'bar';
        //$name = 'Bar';    // method name case insensitive
        $this->$name(); // call the bar() method
    }

    public function bar()
    {
        echo 'This is bar <br />';
    }
}

$cv = new CallVar();
$funcName = 'variable';
$cv->$funcName();

// When calling static methods, the function call is stronger 
// than the static property operator
class FooStatic
{
    public static $variable = 'static property';

    public static function variable()
    {
        echo 'Method variable called. <br />';
    }
}

echo FooStatic::$variable . '<br />';
FooStatic::variable() . '<br />';
$variable = 'variable';
FooStatic::$variable();

// Complex callables
class ComplexCall
{
    public static function bar()
    {
        echo 'bar <br />';
    }

    public function baz()
    {
        echo 'baz <br />';
    }
}

$func = ['ComplexCall', 'bar'];
$func();
$func = [new ComplexCall, 'baz'];
$func();
$func = 'ComplexCall::bar';
$func();
```

### 5, Internal (built-in) functions

PHP comes standard with many functions and constructs. There are also functions that require specific PHP extensions compiled in, otherwise fatal "undefined function" errors will appear. 

It's important to realize what a function returns or if a function works directly on a passed in value.

### 6, Anonymous functions

Anonymous functions, also known as closures, allow the creation of functions which have no specified name. They are most useful as the value of callback parameters, but they have many other uses. 

```php
<?php
    // anonymous function example
    echo preg_replace_callback('~-([a-z])~', function ($match) {
        return strtoupper($match[1]);
    }, 'hello-world');
	// outputs helloWorld
```

Closures can also be used as the values of variables; PHP automatically converts such expressions into instances of the Closure internal class. Assigning a closure to a variable uses the same syntax as any other assignment, including the trailing semicolon: 

```php
<?php
	//Anonymous function variable assignment example
    $greet = function ($name)
    {
        echo '<br /> Hello ' . $name . '<br />';
    };  // semicolon cannot be omited!
    $greet('World');
    $greet('PHP');

```

Closures may also inherit variables from the parent scope. Any such variables must be passed to the use language construct. From PHP 7.1, these variables must not include superglobals, $this, or variables with the same name as a parameter. 

```php
<?php
// Inheriting variables from the parent scope 
$message = 'hello';

$example = function ()
{
    var_dump($message);
};
$example();     // null

$example = function () use ($message)
{
    var_dump($message);
};
$example();

$message = 'world';
var_dump($message);
$example();

// reset message
$message = 'hello';

$example = function () use (&$message)
{
    var_dump($message);
};
$example();

$message = 'world';
$example();

// Closures can also accept regular arguments
$example = function ($arg) use ($message) {
    var_dump($arg . ' ' . $message);
};
$example('hello');
```

Inheriting variables from the parent scope is not the same as using global variables. Global variables exist in the global scope, which is the same no matter what function is executing. The parent scope of a closure is the function in which the closure was declared (not necessarily the function it was called from). 

Automatic binding of $this:

```php
<?php
class Test
{
    public function testing()
    {
        return function() {
            var_dump($this);
        };
    }
}   

$obj = new Test;
$function = $obj->testing();
$function();
```

**Static anonymous functions**

As of PHP 5.4, anonymous functions may be declared statically. This prevents them from having the current class automatically bound to them. Objects may also not be bound to them at runtime. 

```php
<?php
// Attempting to use $this inside a Static anonymous functions
// Attempting to use $this inside a Static anonymous functions
class UseThis
{
    function __construct()
    {
        $func = static function() {
            // var_dump($this);
            // Fatal error: Uncaught Error: Using $this when not in object context
        };  
        $func();
    }   
}
new UseThis();

// Attempting to bind an object to a static anonymous function
$func = static function() {
    // function body
};
$func = $func->bindTo(new StdClass); // Warning: Cannot bind an instance to a static closure
$func();    // Fatal error: Uncaught Error: Function name must be a string
```

