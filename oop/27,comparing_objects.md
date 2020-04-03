# Comparing Object

When using the comparison operator (==), object variables are compared in a simple manner, namely: Two object instances are equal if they have the same attributes and values (values are compared with ==), and are instances of the same class. 

When using the identity operator (===), object variables are identical if and only if they refer to the same instance of the same class. 

```php
<?php
// object comparison
function bool2str($bool)
{
    if ($bool === false) {
        return 'FALSE';
    } else {
        return 'TRUE';
    }
}

function compareObjects(&$o1, &$o2)
{
    echo 'o1 == o2 : ' . bool2str($o1 == $o2) . '<br />';
    echo 'o1 != o2 : ' . bool2str($o1 != $o2) . '<br />';
    echo 'o1 === o2 : ' . bool2str($o1 === $o2) . '<br />';
    echo 'o1 !== o2 : ' . bool2str($o1 !== $o2) . '<br />';
}

class Flag
{
    public $flag;

    public function __construct($flag = true)
    {
        $this->flag = $flag;
    }
}

class OtherFlag
{
    public $flag;

    public function __construct($flag = true)
    {
        $this->flag = $flag;
    }
}

$o = new Flag();
$p = new Flag();
$q = $o;
$r = new OtherFlag();

echo 'Two instances of the same class. <br />';
compareObjects($o, $p);

echo '<br /> Two references to the same instance. <br />';
compareObjects($o, $q);

echo '<br /> Instances of twor different classes. <br />';
compareObjects($o, $r);
```

Extensions can define own rules for their objects comparison (==). 