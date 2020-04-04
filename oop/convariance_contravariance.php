<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

// covariance
abstract class Animal
{
    protected string $name;

    public function __construct(string $name)
    {   
        $this->name = $name;
    }   

    abstract public function speak();

    // Contravariance
    public function eat(AnimalFood $food)
    {   
        echo $this->name . ' eats ' . get_class($food);
    }   
}

class Dog extends Animal
{
    public function speak()
    {   
        echo $this->name . ' barks';
    }   

    // contravariance
    // overridden eat()
    public function eat(Food $food)
    {   
        echo $this->name . ' eats ' . get_class($food);
    }   
}

class Cat extends Animal
{
    public function speak()
    {   
        echo $this->name . ' meows';
    }   
}

// A few factories will be added which return a new object of class type Animal, Cat, or Dog.
interface AnimalShelter
{
    public function adopt(string $name): Animal;
}

class CatShelter implements AnimalShelter
{
    // instead of returning class type Animal, it can return class type Cat
    public function adopt(string $name): Cat
    {
        return new Cat($name);
    }
}

class DogShelter implements AnimalShelter
{
    // instead of returning class type Animal, it can return class type Dog
    public function adopt(string $name): Dog
    {
        return new Dog($name);
    }
}

$kitty = (new CatShelter)->adopt('Ricky');
$kitty->speak();
echo "\n";

$doggy = (new DogShelter)->adopt("Mavrick");
$doggy->speak();
echo "\n";

// contravariance
class Food {}

class AnimalFood extends Food {}

$kitty = (new CatShelter)->adopt('Ricky');
$catFood = new AnimalFood();
$kitty->eat($catFood);
echo "\n";

$doggy = (new DogShelter)->adopt('Mavrick');
$banana = new Food();
$doggy->eat($banana);
echo "\n";

// But what happens if $kitty tries to eat the $banana? 
$kitty->eat($banana);
