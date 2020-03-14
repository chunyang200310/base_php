# PHP Variable

Variables in PHP are represented by a dollar sign followed by the name of the variable.

The variable name is case-sensitive.

A valid variable name starts with a letter or underscore, followed by any number of letters, numbers, or underscores.

**define** a variable and assign values to variable: `$var = 'Bob'`

**variable variables**: `$v = 'hello'; $$v = 'world';`

**destroy the specified variable:** `unset($v);`

**value pass between variables**: 

- pass by value: `$a = 'zhangsan'; $b = $a;`相当与把a内存空间的内容复制了一份给b空间。复制是在其中任何一个发生改变的时候发生的(COW机制)。两个不同的内存空间，任何的改变不会影响另一个。
- pass by reference: `$a = 1; $b = &$a;`a, b两个变量指向同一个内存地址，通过任何一个变量名都可以修改内存空间的值。`unset($a)`: 不会影响别的变量。

**Variable scope**: local, global, static.

**Functions about variable:** 

```php
<?php
//1,isset:determine if a variable is set and is not null.
//isset(mixed $var [, mixed $...]) : bool
echo '<br />test isset(): <br />';
var_dump(isset($a));
var_dump(isset($b));
$b = null;
var_dump(isset($b));
$b = 0;
var_dump(isset($b));

//2,unset:destroys the specified variables.
//unset(mixed $var [, mixed $...]) : void
echo '<br />test unset(): <br />';
unset($b);

//3,empty:Determine whether a variable is empty. A variable is considered empty if it does not exist or if its value equals FALSE. 
//empty(mixed $var) : bool 
//The following values are considered to be empty: 

"" (an empty string) 

0 (0 as an integer) 

0.0 (0 as a float) 

"0" (0 as a string) 

NULL 

FALSE 

array() (an empty array) 
?>
```

**Variable scope**: The scope of a variable is the context within which it is defined.For the most part all PHP variables only have a single scope. This single scope spans included and required files as well. 