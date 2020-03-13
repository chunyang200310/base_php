# PHP Constant

 Constants are like variables except that once they are defined  they cannot be changed or undefined. 

 A constant is an identifier (name) for a simple value. The value cannot be  changed during the script. 

 Constant names are recommended to be all uppercase and separated by underline.

 Constants are automatically global across  the entire script. 

**Create a PHP Constant**: use `define(key, value)` or `const key = value`

```php
<?php
    define('PI', 3.14);			//Variable names must be quoted
	define('NAME', 'lisi');
	define('TRUTH', true);
	define('HERO', ['name'=>'xiangyu', 'age'=>18, 'sex'=>'male']);
	var_dump(PI, NAME, TRUTH, HERO);
	
	const PI2 = 3.14;			//Variable names without quotes
	const NAME2 = 'zhangsan';
	const LIES = false;
	const MEINV = ['diaochan', 'xishi', 'zhaojun', 'guifei'];
	var_dump(PI2, NAME2, LIES, MEINV);

	// use constants in function directly
	function getValue()
    {
        echo PI * 2;
        echo NAME;
        echo MEINV[0];
        return PI * 2;
    }
?>
```

constant often used in configure file, e.g.: web root path.

