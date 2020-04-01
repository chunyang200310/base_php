# Class Constants

It is possible to define constant values on a per-class basis remaining the same and unchangeable. Constants differ from normal variables in that you don't use the $ symbol to declare or use them. The default visibility of class constants is public. 

The value must be a constant expression, not (for example) a variable, a property, or a function call.

It's also possible for interfaces to have constants. 

As of PHP 5.3.0, it's possible to reference the class using a variable. The variable's value can not be a keyword (e.g. self, parent and static). 

Note that class constants are allocated once per class, and not for each class instance. 

```php
<?php
class MyClass
{
    const KONSTANT = 'constant value';
    const FOO = <<<'EOT'
foo
EOT;
    const BAR = <<<EOT
bar
EOT;

    // constant expression example
    const TWO = ONE * 2;
    const THREE = ONE + SELF::TWO;
    const SENTENCE = 'The value of THREE is: ' . self::THREE;

    // class constant visibility modifiers
    public const AAA = 'aaa';
    private const BBB = 'bbb';

    public function showConstant(): string
    {   
        return self::KONSTANT . '<br />';
    }   
}

echo MyClass::KONSTANT . '<br />';
echo MyClass::FOO . '<br />';
echo MyClass::BAR . '<br />';

$cls = 'MyClass';
echo $cls::KONSTANT . '<br />';

$obj = new MyClass();
echo $obj->showConstant();
echo $obj::KONSTANT . '<br />';

// ::class
echo 'class name: ' . MyClass::class . '<br />';

// constant expression
echo $cls::TWO . '<br />';
echo $cls::THREE . '<br />';
echo $cls::SENTENCE . '<br />';

// visibility modifiers
echo $cls::AAA . '<br />';
// echo $cls::BBB . '<br />';   // Fatal error: Cannot access private const
```

