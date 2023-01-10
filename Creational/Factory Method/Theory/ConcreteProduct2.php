<?php

namespace paterni\Creational\FactoryMethod\Theory;

class ConcreteProduct2 implements Product
{
    public function operation(): string
    {
        return "{Result of the ConcreteProduct2}";
    }
}
