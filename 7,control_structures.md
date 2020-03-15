# Control Structures

Any PHP script is built out of a series of statements. A statement can be an assignment, a function call, a loop, a conditional statement or even a statement that does nothing (an empty statement). 

Statements usually end with a semicolon. In addition, statements can be grouped into a statement-group by encapsulating a group of statements with curly braces. 

A statement-group is a statement by itself as well. The various statement types are described in this chapter. 

### if

The if construct is one of the most important features of many languages, PHP included.

`if (expr) statement`

As described in the section about expressions, expression is evaluated to its Boolean value. If expression evaluates to TRUE, PHP will execute statement, and if it evaluates to FALSE - it'll ignore it.

```php
<?php
    if ($a > $b) {
        echo 'a is bigger than b';
        $b = $a;
    }
```

### else

Often you'd want to execute a statement if a certain condition is met, and a different statement if the condition is not met. This is what else is for.else extends an if statement to execute a statement in case the expression in the if statement evaluates to FALSE.

```php
<?php
    if ($a > $b) {
        echo 'a is greater than b';
    } else {
        echo 'a is NOT greater than b';
    }
```

### elseif/ else if

elseif, as its name suggests, is a combination of if and else. Like else, it extends an if statement to execute a different statement in case the original if expression evaluates to FALSE.

```php
<?php
    if ($a > $b) {
        echo 'a is bigger than b';
    } elseif ($a == $b) {
        echo 'a is equal to b';
    } else {
        echo 'a is smaller than b';
    }
```

If you find yourself using a lot of "elseif"s, then you should look at using switch instead.

### Alternative syntax for control structures

PHP offers an alternative syntax for some of its control structures; 

```php
<?php if ($a == 5): ?>
    A is equal to 5
<?php endif; ?>
```

In the above example, the HTML block "A is equal to 5" is nested within an if statement written in the alternative syntax. The HTML block would be displayed only if $a is equal to 5. 

The alternative syntax applies to else and elseif as well. The following is an if structure with elseif and else in the alternative format: 

```php
<?php
if ($a == 5):
    echo "a equals 5";
    echo "...";
elseif ($a == 6):
    echo "a equals 6";
    echo "!!!";
else:
    echo "a is neither 5 nor 6";
endif;
?> 
```

### while

while loops are the simplest type of loop in PHP. `while (expr) statement`

```php
<?php
    $i = 1;
	while ($i <= 10) {
        echo $i++;
    }

	$i = 1;
	while ($i <= 10):
		echo $i;
		$i++;
	endwhile;
```

### do-while

do-while loops are very similar to while loops, except the truth expression is checked at the end of each iteration instead of in the beginning.

There is just one syntax for do-while loops: 

```php
<?php
    $i = 0;
	do {
        echo $i;
    } while ($i > 0);
?>
```

Advanced C users may be familiar with a different usage of the do-while loop, to allow stopping execution in the middle of code blocks, by encapsulating them with do-while (0), and using the break statement. 

```php
<?php
    do {
        if ($i < 5) {
            echo 'i is not big enough';
            break;
        }
        $i *= $factor;
        if ($i < $minium_limit) {
            break;
        }
        echo 'i is ok';
    } while (0);
?>
```

### for

For loops are the most **complex** loops in PHP, The behave like their counter parts. The syntax of

a for loop is: `for (expr1; expr2; expr3) statement`

The first expression (expr1) is evaluated (executed) once unconditionally at the beginning of the loop.

In the beginning of each iteration, expr2 is evaluated. If it evaluates to TRUE, the loop continues and the nested statement(s) are executed. If it evaluates to FALSE, the execution of the loop ends. 

At the end of each iteration, expr3 is evaluated (executed). 

Consider the following examples. All of them display the numbers 1 through 10: 

```php
<?php
    for ($i = 1; $i <= 10; $i++) {
        echo $i;
    }

	for ($i = 1; ; $i++) {
        if ($i > 10) {
            break;
        }
    	echo $i;
    }

	for (; ;) {
        if ($i > 10) {
            break;
        }
        echo $i;
        $i++;
    }

	for ($i = 1, $j = 0; $i <=10; $j += $i, print $i, $i++);
```

### foreach

The foreach construct provides an easy way to iterate over arrays. foreach works only on arrays and objects, and will issue an error when you try to use it on a variable with a different data type or an uninitialized variable. There are two syntaxes:

`foreach ($arr as $val) statment	foreach($arr as $key => $value)`
In order to be able to directly modify array elements within the loop precede $value with &. In that case the value will be assigned by reference. 

```php
<?php
    $arr = [1, 2, 3, 4];
	foreach ($arr as &$value) {
        $value = $value * 2;
    }
	
	unset($value);		// break the reference with the last element

	// while...list...each
	while (list($key, $value) = each($arr)) {
    	echo "key: $key; value: $value<br />";
    }

	//PHP 5.5 added the ability to iterate over an array of arrays and unpack the nested array into loop variables by providing a list() as the value.
	$arr = [
        [1, 2],
        [3, 4]
    ];
	
	foreach ($arr as list($a, $b)) {
        echo "A: $a; B:$b<br />";
    }

    foreach ($array as list($a)) {
        // Note that there is no $b here.
        echo "$a\n";
    }
?>
```

### Break

break ends execution of the current for, foreach, while, do-while or switch structure. 

break accepts an optional numeric argument which tells it how many nested enclosing structures are to be broken out of. The default value is 1, only the immediate enclosing structure is broken out of. 

```php
<?php
    $arr = ['one', 'two', 'three', 'four', 'stop', 'five'];
	while (list(, $val) = each($arr)) {
        if ($val == 'stop') {
            break;
        }
        echo "$val<br />";
    }

	// using the optional argument.
	$i = 0;
	while (++$i) {
        switch ($i) {
            case 5:
                echo "At 5<br />";
                break 1;	// exit only the switch
            case 10:
                echo "At 10; quittint<br />";
                break 2;	// exit the switch and the while
            default:
                break;
        }
    }
```

### continue

continue is used within looping structures to skip the rest of the current loop iteration and continue execution at the condition evaluation and then the beginning of the next iteration. 

```php
<?php
while (list($key, $value) = each($arr)) {
    if (!($key % 2)) { // skip even members
        continue;
    }
    do_something_odd($value);
}
$i = 0;
while ($i++ < 5) {
    echo "Outer<br />\n";
    while (1) {
        echo "Middle<br />\n";
        while (1) {
            echo "Inner<br />\n";
            continue 3;
        }
        echo "This never gets output.<br />\n";
    }
    echo "Neither does this.<br />\n";
}
?> 
```

### switch

The *switch* statement is similar to a series of  IF statements on the same expression.

```php
<?php
    $i = mt_rand(0, 2);
	
```

