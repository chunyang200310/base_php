# Final Keyword

PHP 5 introduces the final keyword, which prevents child classes from overriding a method by prefixing the definition with final. If the class itself is being defined final then it cannot be extended.

```php
<?php
// Final methods example
class BaseClass
{
    public function test()
    {   
        echo 'BaseClass::test() called. <br />';
    }   

    final public function moreTesting()
    {   
        echo 'BaseClass::moreTesting() called. <br />';
    }   
}

class ChildClass extends BaseClass
{
    public function test()
    {   
        echo 'ChildClass::test() called. <br />';
    }   

    // Cannot override final method
    /*  
    public function moreTesting()
    {
        echo 'ChildClass::moreTesting() called. <br />';
    }
     */
}

$cc = new ChildClass();
$cc->test();

// Final class example
final class Dog
{
    public function test()
    {
        echo 'Dog::test() called. <br />';
    }
    
    // Here it doesn't matter if you specify the function as final or not
    final public function test2()
    {
        echo 'Dog::test2() called. <br />';
    }
}   

// Fatal error: Class Pig may not inherit from final class (Dog)
// class Pig extends Dog {}
```

