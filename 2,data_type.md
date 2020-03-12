# PHP Data Types

﻿ Variables can store data of different types, and different data types can do  different things. 

 PHP supports the following ten data types: 

- scalar:
  - String
  - Integer
  - Float
  - Boolean

- compound
  - Array
  - Object
  - Callable
  - Iterable

- special types
  - Resource
  - null

 You can check the type of a variable by using the `gettype()` function.  

```php
<?php
    $var;
	echo gettype($var);	// null
?>
```

### 1, PHP Strings

 A string is a sequence of characters,  can be any text inside quotes. You can use single or double quotes : `$x = 'hello'; $y = "word"`

**PHP String Functions**:

```php
<?php
    // 1, strlen() - Returns the length of a String
    echo strlen('Hello world!');		// 12

	// 2, str_word_count() - Count Words in a String
	echo str_word_count('How are you?');	// 3

	// 3, strrev() - Reverse a String
	echo strrev('Hello');	// olleH

	// 4, strpos() - Search For a Text Within a String, returns the character position of the first match if found or FALSE if no match is found.
	echo strpos('What is your name?', 'your');	// 	8
	//The first character position in a string is 0 (not 1).

	// 5, str_replace() - Replace Text Within a String
	echo str_replace('world', 'Dolly', 'Hello world!');	// Hello Dolly!
?>	
```

### 2, PHP Integer

 An integer is a number without any decimal part.  Integers can be specified in three formats: decimal (10-based),  hexadecimal (16-based - prefixed with 0x) or octal (8-based - prefixed  with 0) 

`$a = 1; $b = -1; $c = 0123; $d = 0X123;`

Check if the type of a variable is integer: `is_int(); is_integer(); is_long()`

### 3, PHP Floats

 A float is a number with a decimal point or a number in exponential form. 

`$f = 1.23; $f2= 2.4e3;`

**PHP Infinity**:  A numeric value that is larger than PHP_FLOAT_MAX is considered infinite. 

`echo PHP_FLOAT_MAX;	// 1.7976931348623E+308`

$x = 1.9e310

check if a numeric values is finite or infinite: `is_finite(); is_infinite`