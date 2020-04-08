# Reference Explained

### What References Are

References in PHP are a means to access the same variable content by different names. They are not like C pointers; for instance, you cannot perform pointer arithmetic using them, they are not actual memory addresses, and so on. See What References Are Not for more information. Instead, they are symbol table aliases. Note that in PHP, variable name and variable content are different, so the same content can have different names. The closest analogy is with Unix filenames and files - variable names are directory entries, while variable content is the file itself. References can be likened to hardlinking in Unix filesystem. 

### What References Do

There are three basic operations performed using references: `assigning by reference`, `passing by reference`, and `returning by reference`. This section will give an introduction to these operations, with links for further reading. 

**1, Assign By Reference**

In the first of these, PHP references allow you to make two variables refer to the same content. Meaning, when you do: `$a = &$b;`, it means that $a and $b point to the same content. 

$a and $b are completely equal here. $a is not pointing to $b or vice versa. $a and $b are pointing to the same place. 

If you assign, pass, or return an undefined variable by reference, it will get created. 

```php
<?php
    // Assign by Reference
    $a =& $b;
    var_dump($a, $b);   // null, null

    // Using references with undefined variable
    function foo(&$var) {}

    foo($c);
    var_dump($c);       // null

    $d = []; 
    foo($d['b']);
    var_dump(array_key_exists('b', $d));    // boolean true

    $e = new stdClass();
    foo($e->d);
    var_dump(property_exists($e, 'd'));     // boolean true

	// The same syntax can be used with functions that return references: 
	$foo =& find_var($bar);
```

If you assign a reference to a variable declared global inside a function, the reference will be visible only inside the function. You can avoid this by using the $GLOBALS array. 

```php
<?php
    // Referencing global variables inside functions
    $var1 = 'Example variable';
    $var2 = '';

    function global_references($use_globals)
    {
        global $var1, $var2;

        if (!$use_globals) {
            $var2 =& $var1;     // visible only inside the function
        } else {
            $GLOBALS['var2'] =& $var1;  // visible also in global context
        }
    }

    global_references(false);
    echo 'Var2 is set to ' . $var2 . '<br />';
    global_references(true);
    echo 'Var2 is set to ' . $var2 . '<br />';
```

Think about global $var; as a shortcut to $var =& $GLOBALS['var'];. Thus assigning another reference to $var only changes the local variable's reference. 

If you assign a value to a variable with references in a foreach statement, the references are modified too.

```php
<?php
$ref = 0;
$row =& $ref;

foreach ([1, 2, 3] as $row) {
    // do something
}

echo '$ref = ' . $ref . '<br />';	// 3
```

While not being strictly an assignment by reference, expressions created with the language construct array() can also behave as such by prefixing & to the array element to add. Example: 

```php
<?php
$a1 = 1;
var_dump($a1);
$b1 = [2, 3];
var_dump($a1, $b1);
$arr = [&$a1, &$b1[0], &$b1[1]];
var_dump($a1, $b1, $arr);

$arr[0]++; $arr[1]++; $arr[2]++;
var_dump($a1, $b1, $arr);
```

Note, however, that references inside arrays are potentially dangerous. Doing a normal (not by reference) assignment with a reference on the right side does not turn the left side into a reference, but references inside arrays are preserved in these normal assignments. This also applies to function calls where the array is passed by value. Example: 

```php
<?php
/* Assignment of scalar variables */
$a = 1;
$b =& $a;
$c = $b;
$c = 7; //$c is not a reference; no change to $a or $b

/* Assignment of array variables */
$arr = array(1);
$a =& $arr[0]; //$a and $arr[0] are in the same reference set
$arr2 = $arr; //not an assignment-by-reference!
$arr2[0]++;
/* $a == 2, $arr == array(2) */
/* The contents of $arr are changed even though it's not a reference! */
```

In other words, the reference behavior of arrays is defined in an element-by-element basis; the reference behavior of individual elements is dissociated from the reference status of the array container. 

**Pass By Reference**

The second thing references do is to pass variables by reference. This is done by making a local variable in a function and a variable in the calling scope referencing the same content. Example: 

```php
<?php
    /*** Pass by Reference  ***/
    function pass_by_ref(&$var)
    {   
        $var++;
    }

    $pa = 5;
    pass_by_ref($pa);
    echo $pa . '<br />';	// 6
```

will make $a to be 6. This happens because in the function foo the variable $var refers to the same content as $a. For more information on this, read the passing by reference section. 

**Return by Reference**

The third thing references can do is *return by reference*. 

### What References Are Not

As said before, references are not pointers. That means, the following construct won't do what you expect: 

```php
<?php
function foo(&$var)
{
    $var =& $GLOBALS['baz'];
}

foo($bar);
```

What happens is that $var in foo will be bound with $bar in the caller, but then re-bound with $GLOBALS["baz"]. There's no way to bind $bar in the calling scope to something else using the reference mechanism, since $bar is not available in the function foo (it is represented by $var, but $var has only variable contents and not name-to-value binding in the calling symbol table). You can use returning references to reference variables selected by the function. 

### Passing by Reference

You can pass a variable by reference to a function so the function can modify the variable. The syntax is as follows:

```php
<?php
function foo(&$var)
{
    $var++;
}
$a=5;
foo($a);
// $a is 6 here
```

There is no reference sign on a function call - only on function definitions. Function definitions alone are enough to correctly pass the argument by reference. As of PHP 5.3.0, you will get a warning saying that "call-time pass-by-reference" is deprecated when you use & in foo(&$a);. And as of PHP 5.4.0, call-time pass-by-reference was removed, so using it will raise a fatal error. 

```php
<?php
    <?php
function foo(&$var)
{
    $var++;
}
function &bar()
{
    $a = 5;
    return $a;
}
foo(bar());
```

No other expressions should be passed by reference, as the result is undefined. For example, the following examples of passing by reference are invalid: 

```php
<?php
function foo(&$var)
{
    $var++;
}

function bar() // Note the missing &
{
    $a = 5;
    return $a;
}

foo(bar()); // Produces fatal error as of PHP 5.0.5, strict standards notice
            // as of PHP 5.1.1, and notice as of PHP 7.0.0

foo($a = 5); // Expression, not variable
foo(5); // Produces fatal error

class Foobar
{
}

foo(new Foobar()) // Produces a notice as of PHP 7.0.7
                  // Notice: Only variables should be passed by reference
```

### Returning References

Returning by reference is useful when you want to use a function to find to which variable a reference should be bound. Do not use return-by-reference to increase performance. The engine will automatically optimize this on its own. Only return references when you have a valid technical reason to do so. To return references, use this syntax: 

```php
<?php
class Foo
{
    public $value = 42;

    public function &getValue()
    {
        return $this->value;
    }
}   

$obj = new Foo();
$myValue = &$obj->getValue();   // $myValue is a reference to $obj->value, which is 42.
$obj->value = 2;
echo 'MyValue: ' . $myValue . '<br />';		// 2
```

In this example, the property of the object returned by the getValue function would be set, not the copy, as it would be without using reference syntax. 

Unlike parameter passing, here you have to use & in both places - to indicate that you want to return by reference, not a copy, and to indicate that reference binding, rather than usual assignment, should be done for $myValue. 

If you try to return a reference from a function with the syntax: return ($this->value); this will not work as you are attempting to return the result of an expression, and not a variable, by reference. You can only return variables by reference from a function - nothing else. Since PHP 5.1.0, an E_NOTICE error is issued if the code tries to return a dynamic expression or a result of the new operator. 

To use the returned reference, you must use reference assignment: 

```php
<?php
function &collector() {
  static $collection = [];
  return $collection;
}

$collection = &collector();
$collection[] = 'foo';
```

To pass the returned reference to another function expecting a reference you can use this syntax:

```php
<?php
function &collector() {
  static $collection = array();
  return $collection;
}
array_push(collector(), 'foo');
```

Note that array_push(&collector(), 'foo'); will not work, it results in a fatal error. 

### Unsetting References

When you unset the reference, you just break the binding between variable name and variable content. This does not mean that variable content will be destroyed. For example: 

```php
<?php
$a = 1;
$b =& $a;
unset($a);	// won't unset $b, just $a. 
```

Again, it might be useful to think about this as analogous to the Unix *unlink* call. 

### Spotting References

Many syntax constructs in PHP are implemented via referencing mechanisms, so everything mentioned herein about reference binding also applies to these constructs. Some constructs, like passing and returning by reference, are mentioned above. Other constructs that use references are: 

**global References**

When you declare a variable as global $var you are in fact creating reference to a global variable. That means, this is the same as: 

`$var =& $GLOBALS['var'];`

This also means that unsetting $var won't unset the global variable. 

**$this**

In an object method, $this is always a reference to the called object. 