<?php

namespace paterni\Creational\FactoryMethod\Theory;

class ConcreteCreator2 extends Creator
{
    public function factoryMethod(): Product
    {
        return new ConcreteProduct2();
    }
}
