# PHP Operators

﻿Operators are used to perform operations on variables and values. 

PHP divides the operators in the following groups:

- Arithmetic operators
- Assignment operators
- Comparison operators
- Increment/Decrement operators
- Logical operators
- String operators
- Array operators
- Conditional assignment operators

### 1, PHP Arithmetic Operators

 The PHP arithmetic operators are used with numeric values to perform common arithmetical operations.

`+	-	*	/	%	**`

### 2, PHP Assignment Operators

 The PHP assignment operators are used with numeric values to write a value to a variable. 

`=	+=	-=	*=	/=	%=`

### 3, PHP Comparison Operators

 The PHP comparison operators are used to compare two values (number or string): 

`==(equal)	===(identical)	!=(not equal)	<>(not equal)`

`!==(not identical)	>(greater than)	<(less than)	>=(greater than or equal)`

`<=(less than or equal)	<=>(spaceship)`

```php
<?php
    $res = $a <=> $b; 

	if ($a > $b) {
        $res = 1;
    } elseif ($a == $b) {
        $res = 0;
    } else {
    	$res = -1;
    }
?>
```

### 4, PHP Increment / Decrement Operators

 The PHP increment operators are used to increment a variable's value.

 The PHP decrement operators are used to decrement a variable's value. 

`++$x`: Pre-increment

`$x++`: Post-increment

`--$x`: Pre-decrement

`$x--`: Post-decrement

 ++, --- does not affect Boolean values.  `++null = 1`

### 5, PHP Logical Operators

 The PHP logical operators are used to combine conditional statements. 

`and	or	xor	&&	|| 	!` 

### 6, PHP String Operators

 PHP has two operators that are specially designed for strings: `.	.=`

### 7, PHP Array Operators

 The PHP array operators are used to compare arrays. 

`+	==	===	!=	<>	!==`

### 8, PHP Conditional Assignment Operators

 The PHP conditional assignment operators are used to set a value depending on conditions.

Ternary: `?:`	`$x = exp1 ? exp2 : exp3;`

Null coalescing: `??`:	`$x = exp1 ?? exp2';`