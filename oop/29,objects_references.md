# Objects and references

One of the key-points of PHP 5 OOP that is often mentioned is that "objects are passed by references by default". This is not completely true. This section rectifies that general thought using some examples. 

A PHP reference is an alias, which allows two different variables to write to the same value. As of PHP 5, an object variable doesn't contain the object itself as value anymore. It only contains an object identifier which allows object accessors to find the actual object. When an object is sent by argument, returned or assigned to another variable, the different variables are not aliases: they hold a copy of the identifier, which points to the same object. 

```php
<?php
// references and objects
class A
{
    public $foo = 1;
}

$a = new A();
$b = $a;
xdebug_debug_zval('a', 'b');
var_dump($a, $b);   // ($a) = ($b) = <id>

$b->foo = 2;
echo $a->foo . '<br />';
echo $b->foo . '<br />';
$a = 'a';
var_dump($b);
unset($a);
var_dump($b);


$c = new A();
$d = &$c;       // ($c, $d) = <id>
xdebug_debug_zval('c', 'd');
var_dump($c, $d);
$d->foo = 2;
echo $c->foo . '<br />';
echo $d->foo . '<br />';
$c = 'a';
var_dump($d);
unset($c);
var_dump($d);

$e = new A();

function foo($obj)
{
    // ($obj) = ($e) = <id>
    $obj->foo = 2;
}

foo($e);
echo $e->foo . '<br />';
```

![reference](/opt/lampp/htdocs/studieren/base_php/oop/reference.png)