# PHP base

### About PHP

- PHP is an acronym[^ 1 ] for "PHP: Hypertext Preprocessor"
- A PHP script can be placed anywhere in the document
- The default file extension for PHP files is "`.php`",  e,g: `base.php`.

[^ 1 ]:akrəˌnim  首字母缩写

### Basic Syntax

```php
<?php		//php script starts with: <?php
    echo 'Hello world!';	//php statements end with a semicolon(;)
	ECho 'Good morning.'	// Keywords are case-insensitive
    // However, all variable names are case-sensitive
    $var = 'a';
	$Var = 'a';
?>			// php script ends with: ?>. Can be ommited if no following contents
```

### Comments in PHP

PHP supports several ways of commenting:

```php
<?php
    // this is a single-line comment
    # this is also a single-line comment
    /*
    This is a multiple-lines comment block
    that spans over multiple
    lines
    */
    $foo = 'bar';	// followed contents in this line are comments
	$bar = 5 /* + 15 (leave out parts of the code)*/ + 5;
?>
```

### PHP Variables

##### 1, Creating (Declaring) PHP variable

In PHP, a variable starts with the `$` sign, followed by the name of variable: `$a  = 1`

When you assign a text value to a variable, put quotes around the value: `$b = 'a'`

use xdebug see detail of variable: `xdebug_debug_zval('a');`

Rules for PHP variables:

- A variable starts with the `$` sign, followed by the name of the variable
- A variable name must start with a letter or the underscore character
- A variable name cannot start with a number
- A variable name can only contain alpha-numeric characters and underscores (A-z, 0-9, and _ )
- Variable names are case-sensitive (`$age` and   `$AGE` are two different variables)

##### 2, PHP Variables Scope

 In PHP, variables can be declared anywhere in the script. 

 The scope of a variable is the part of the script where the variable can be referenced/used. 

 PHP has three different variable scopes:  local, global, static.

**Global Scope** :  A variable declared **outside** a function has a GLOBAL SCOPE and can only  be accessed outside a function.

**Local Scope**:  A variable declared **within** a function has a LOCAL SCOPE and can only  be accessed within that function: 

```php
<?php
    $x = 5;	// global scope
	function myTest() {
        $y = 10;	// local scope
    echo 'Variable in function is: ' . $y;
        
        // using x inside this function will generate an error
        echo 'Variable x inside function is: ' . $x;
    }
	myTest();
	
	echo 'Variable x outside function is: ' . $x;

	// using y outside the function will generate an error
	echo 'Variable y outside function is: ' . $y;
?>
```



**PHP The global Keyword**:  The `global` keyword is used to access a global variable from within a function. 

 To do this, use the `global` keyword before the variables (inside the  function): 

```php
<?php
    $x = 5;
	$y = 10;
	
	function myTest() {
        global $x, $y;
        $y = $x + $y;
    }
	
	myTest();
	echo $y;	// outpust 15

	/* PHP also stores all global variables in an array called $GLOBALS[index]. 
	The index holds the name of the variable.This array is also accessible from 
	within functions and can be used to update global variables directly.
	*/
	function myTest2() {
        $GLOBALS['y'] = $GLOBALS['x'] + $GLOBALS['y'];
    }

	myTest2();
	echo $y;	// outputs 20
?>
```

**PHP The static Keyword**:  Normally, when a function is completed/executed, all of its variables are deleted.  However, sometimes we want a local variable NOT to be deleted. We need it for a  further job. 

 To do this, use the `static` keyword when you first declare the  variable: 

```php
<?php
    function myTest() {
    	static $x = 0;
    	echo $x;
    	$x++;
	}
	
	myTest();
	myTest();
	myTest();

	// The variable is still local to the function.
?>
```

