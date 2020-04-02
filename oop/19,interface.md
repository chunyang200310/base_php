# Interface

Object interfaces allow you to create code which specifies which methods a class must implement, without having to define how these methods are implemented. 

Interfaces are defined in the same way as a class, but with the **interface** keyword replacing the **class** keyword and without any of the methods having their contents defined. 

All methods declared in an interface must be **public**; this is the nature of an interface.

```php
<?php
// Interface example
interface iTemplate
{
    public function setVariable($name, $var);
    public function getHtml($template);
}

// implement the interface: iTemplate
class Template implements iTemplate
{
    private $vars = [];

    public function setVariable($name, $var)
    {   
        $this->vars[$name] = $var;
    }   

    public function getHtml($template)
    {   
        foreach ($this->vars as $name => $value) {
            $template = str_replace('{' . $name . '}', $value, $template);
        }   

        return $template;
    }   
}
```



Note that it is possible to declare a constructor in an interface, which can be useful in some contexts, e.g. for use by factories. 

**implement**: To implement an interface, the implements operator is used. All methods in the interface must be implemented within a class; failure to do so will result in a fatal error. Classes may implement more than one interface if desired by separating each interface with a comma. 

Interfaces can be extended like classes using the extends operator. 

**Constants**: It's possible for interfaces to have constants. Interface constants work exactly like class constants except they cannot be overridden by a class/interface that inherits them. 

```php
<?php
interface a
{
    const b = 'Interface constant';
}
// Prints: Interface constant
echo a::b;
// This will however not work because it's not allowed to 
// override constants.
class b implements a
{
    const b = 'Class constant';
}
```



