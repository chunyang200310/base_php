# Class Abstract

PHP 5 introduces abstract classes and methods. Classes defined as abstract cannot be instantiated, and any class that contains at least one abstract method must also be abstract. Methods defined as abstract simply declare the method's signature - they cannot define the implementation. 

When inheriting from an abstract class, all methods marked abstract in the parent's class declaration must be defined by the child; additionally, these methods must be defined with the same (or a less restricted) visibility. For example, if the abstract method is defined as protected, the function implementation must be defined as either protected or public, but not private. Furthermore the signatures of the methods must match, i.e. the type hints and the number of required arguments must be the same. For example, if the child class defines an optional argument, where the abstract method's signature does not, there is no conflict in the signature. This also applies to constructors as of PHP 5.4. Before 5.4 constructor signatures could differ. 

```php
<?php
// Abstract class
abstract class AbstractClass
{
    // force extending class to define this method
    abstract protected function getValue();
    abstract protected function prefixValue($prefix);

    // common method
    public function printOut()
    {
        echo $this->getValue() . '<br />';
    }
}

class ConcreteClass1 extends AbstractClass
{
    protected function getValue()
    {
        return 'ConcreteClass1';
    }

    public function prefixValue($prefix)
    {
        return "{$prefix}ConcreteClass1";
    }
}

class ConcreteClass2 extends AbstractClass
{
    protected function getValue()
    {
        return 'ConcreteClass2';
    }

    public function prefixValue($prefix)
    {
        return "{$prefix}ConcreteClass2";
    }
}

$conc1 = new ConcreteClass1();
$conc1->printOut();
echo $conc1->prefixValue('FOO_') . '<br />';

$conc2 = new ConcreteClass2();
$conc2->printOut();
echo $conc2->prefixValue('FOO_') . '<br />';

abstract class PrefixProcess
{
    // abstract method only needs to define the required arguments
    abstract protected function prefixName($name);
}

class DoProcess extends PrefixProcess
{
    // child class may define optinal arguments not in parent's signature
    public function prefixName($name, $separator = '.')
    {
        if ($name == 'Pacman') {
            $prefix = 'Mr';
        } elseif ($name == 'Pacwoman') {
            $prefix = 'Mrs';
        } else {
            $prefix = '';
        }
        return "{$prefix}{$separator} {$name}";
    }
}

$dp = new DoProcess();
echo $dp->prefixName('Pacman') . '<br />';
echo $dp->prefixName('Pacwoman') . '<br />';
```

