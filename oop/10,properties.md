# Properties

Class member variables are called "properties". You may also see them referred to using other terms such as "attributes" or "fields", but for the purposes of this reference we will use "properties". They are defined by using one of the keywords public, protected, or private, optionally followed by a type declaration, followed by a normal variable declaration. This declaration may include an initialization, but this initialization must be a constant value--that is, it must be able to be evaluated at compile time and must not depend on run-time information in order to be evaluated. 

Within class methods non-static properties may be accessed by using -> (Object Operator): $this->property (where property is the name of the property). Static properties are accessed by using the :: (Double Colon): self::$property. 

The pseudo-variable $this is available inside any class method when that method is called from within an object context. $this is a reference to the calling object.

```php
<?php
// property declarations
class DeclPro
{
    // valid property declarations
    public $var1 = 'hello ' . 'world';
    public $var2 = <<<EOD
hello world
EOD;
    public $var3 = 1 + 1;
    public $var4 = myConstant;
    public $var5 = [true, false];
    public $var6 = <<<'NEWSTR'
hello world
NEWSTR;

    // invalid property declarations
    //public $var7 = self::myVar7();
    //public $var8 = $myVar;


    public static function myVar7()
    {
        return 'hello world';
    }
}

$dp = new DeclPro();
echo 'var1: ' . $dp->var1 . '<br />';
echo 'var2: ' . $dp->var2 . '<br />';
echo 'var3: ' . $dp->var3 . '<br />';
echo 'var4: ' . $dp->var4 . '<br />';
echo 'var6: ' . $dp->var6 . '<br />';
var_dump($dp->var5);
```

As of PHP 7.4.0, property definitions can include a type declaration, with the exception of the callable type. 

```php
<?php
class User
{
    public int $id;
    public string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}

$user = new User(1, 'lisi');
echo 'ID: ' . $user->id . '<br />';
echo 'Name: ' . $user->name . '<br />';
```

